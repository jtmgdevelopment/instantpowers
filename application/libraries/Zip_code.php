<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('_UNIT_MILES', 'm');
define('_UNIT_KILOMETERS', 'k');
// constants for passing $sort to get_zips_in_range()
define('_ZIPS_SORT_BY_DISTANCE_ASC', 1);
define('_ZIPS_SORT_BY_DISTANCE_DESC', 2);
define('_ZIPS_SORT_BY_ZIP_ASC', 3);
define('_ZIPS_SORT_BY_ZIP_DESC', 4);
// constant for miles to kilometers conversion
define('_M2KM_FACTOR', 1.609344);
 
class Zip_code {

	var $CI;
	var $last_error = "";            // last error message set by this class
	var $last_time = 0;              // last function execution time (debug info)
	var $units = _UNIT_MILES;        // miles or kilometers
	var $decimals = 2;               // decimal places for returned distance

	public function __construct()
	{
		// Copy an instance of CI so we can use the entire framework.
		$this->CI =& get_instance();
		$this->CI->load->library('upload');
		$this->CI->load->database();
		$this->CI->config->load('upload');
	}

	public function get_distance($zip1, $zip2) 
	{
		// returns the distance between to zip codes.  If there is an error, the 
		// function will return false and set the $last_error variable.
		
		$this->chronometer();         // start the clock
		
		if ($zip1 == $zip2) return 0; // same zip code means 0 miles between. :)
		
		
		// get details from database about each zip and exit if there is an error
		
		$details1 = $this->get_zip_point($zip1);
		$details2 = $this->get_zip_point($zip2);
		if ($details1 == false) 
		{
		 $this->last_error = "No details found for zip code: $zip1";
		 return false;
		}
		if ($details2 == false) 
		{
		 $this->last_error = "No details found for zip code: $zip2";
		 return false;
		}     
		
		
		// calculate the distance between the two points based on the lattitude
		// and longitude pulled out of the database.
		
		$miles = $this->calculate_mileage($details1[0], $details2[0], $details1[1], $details2[1]);
		
		$this->last_time = $this->chronometer();
		
		if ($this->units == _UNIT_KILOMETERS) return round($miles * _M2KM_FACTOR, $this->decimals);
		else return round($miles, $this->decimals);       // must be miles
	  
	}   

	public function get_zip_details($zip) 
	{
	
		// This function pulls the details from the database for a 
		// given zip code.
		
		$sql = "
			SELECT lat AS lattitude, lon AS longitude, city, county, state_prefix, 
			state_name, area_code, time_zone
			FROM zip_code 
			WHERE zip_code='$zip'
			";
		
		$query = $this->CI->db->query($sql, array($zip));
		if (!$query)
		{
			return false;
		} 
		else
		{
			return $query->row_array();
		}
	}


	public function get_zip_point($zip)
	{
	
		// This function pulls just the lattitude and longitude from the
		// database for a given zip code.
		
		$sql = "SELECT lat, lon from zip_code WHERE zip_code=?";
		
		$query = $this->CI->db->query($sql, array($zip));
		
		if (!$query) 
		{
			return false;
		} 
		else
		{
			return $query->row_array();
		}
	}


   private function calculate_mileage($lat1, $lat2, $lon1, $lon2) 
   {
 
      // Convert lattitude/longitude (degrees) to radians for calculations
      $lat1 = deg2rad($lat1);
      $lon1 = deg2rad($lon1);
      $lat2 = deg2rad($lat2);
      $lon2 = deg2rad($lon2);
      
      // Find the deltas
      $delta_lat = $lat2 - $lat1;
      $delta_lon = $lon2 - $lon1;
	
      // Find the Great Circle distance 
      $temp = pow(sin($delta_lat/2.0),2) + cos($lat1) * cos($lat2) * pow(sin($delta_lon/2.0),2);
      $distance = 3956 * 2 * atan2(sqrt($temp),sqrt(1-$temp));

      return $distance;
   }

   public function get_zips_in_range($zip, $range, $sort = 1, $include_base = 0) 
   {
       
		// returns an array of the zip codes within $range of $zip. Returns
		// an array with keys as zip codes and values as the distance from 
		// the zipcode defined in $zip.
		
		$this->chronometer();                     // start the clock
		
		$details = $this->get_zip_point($zip);  // base zip details
		
		if ($details == false) return false;
		
		// Find Max - Min Lat / Long for Radius and zero point and query
		// only zips in that range.
		$lat_range = $range/69.172;
		$lon_range = abs($range/(cos($details['lat']) * 69.172));
		$min_lat = number_format($details['lat'] - $lat_range, "4", ".", "");
		$max_lat = number_format($details['lat'] + $lat_range, "4", ".", "");
		$min_lon = number_format($details['lon'] - $lon_range, "4", ".", "");
		$max_lon = number_format($details['lon'] + $lon_range, "4", ".", "");
		
		$return = array();    // declared here for scope
		
		$sql = "SELECT zip_code, lat, lon FROM zip_code ";
		$sql .= "WHERE "; 
		$sql .= "lat BETWEEN ? AND ? 
		AND lon BETWEEN ? AND ?";
		
		$query = $this->CI->db->query($sql, array($min_lat, $max_lat, $min_lon, $max_lon));
		
		$ret = $query->result_array();
		
		if (!$query) 
		{
			return false;
		} 
		else 
		{
			foreach($ret as $row)
			{
				$dist = $this->calculate_mileage($details['lat'],$row['lat'],$details['lon'],$row['lon']);
				if ($this->units == _UNIT_KILOMETERS) $dist = $dist * _M2KM_FACTOR;
				if ($dist <= $range) 
				{
					$return[str_pad($row['zip_code'], 5, "0", STR_PAD_LEFT)] = round($dist, $this->decimals);
				}
			
			}
		}
		
		// sort array
		switch($sort)
		{
			case _ZIPS_SORT_BY_DISTANCE_ASC:
				asort($return);
			break;
		
			case _ZIPS_SORT_BY_DISTANCE_DESC:
				arsort($return);
			break;
		
			case _ZIPS_SORT_BY_ZIP_ASC:
				ksort($return);
			break;
		
			case _ZIPS_SORT_BY_ZIP_DESC:
				krsort($return);
			break; 
		}
		
		$this->last_time = $this->chronometer();
		
		if (empty($return)) return false;
		
		return array_keys($return);
	}

   private function chronometer()  
   {
 
	   $now = microtime(TRUE);  // float, in _seconds_
	   $now = $now + time();
	   $malt = 1;
	   $round = 7;
  
	   if($this->last_time > 0) 
	   {
		   /* Stop the chronometer : return the amount of time since it was started,
		   in ms with a precision of 3 decimal places, and reset the start time.
		   We could factor the multiplication by 1000 (which converts seconds
		   into milliseconds) to save memory, but considering that floats can
		   reach e+308 but only carry 14 decimals, this is certainly more precise */
		  
		   $retElapsed = round($now * $malt - $this->last_time * $malt, $round);
		  
		   $this->last_time = $now;
		  
		   return $retElapsed;
	   } 
	   else 
	   {
		   // Start the chronometer : save the starting time
		
		   $this->last_time = $now;
		  
		   return 0;
	   }

   }

}