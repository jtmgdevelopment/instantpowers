<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(ENVIRONMENT == 'development' || ENVIRONMENT == 'devlocal')
{
	define('SITE_URL', 'http://is.bailcommerce.com');
	define('NOREPLY_EMAIL', 'noreply@instantpowers.com');
	define('SITE_NAME' , 'Development Instant Powers');
	define('ADMIN_EMAIL', 'jgonzalez@jtmgdevelopment.com');
	define( 'CREDITCARDNUMBER' , '4111111111111111' );			


	//default bond items
	define('BOND_AMOUNT', 500 );
	define('EXECUTION_DATE', date( 'm/d/Y' , strtotime("+1 week") ));
	define('COUNT_DATE', date( 'm/d/Y' , strtotime("+2 week") ) );
	define('COUNT_TIME', '09:30 pm'  );
	define('COURT','Leon County Courthouse' );
	define('COUNTY','Leon' );
	define('CASE_NUMBER','1AA23FDS232' );
	define('CHARGE','Drug Possession' );
	define('CITY','Tallahassee' );
	define('D_FNAME','John' );
	define('D_LNAME','Doe');
	define('AGENT','Barry Wise' );

}
else
{
	define('SITE_URL', 'http://instantpowers.com');
	define('NOREPLY_EMAIL', 'noreply@instantpowers.com');
	define('SITE_NAME' , 'Instant Powers');
	define('ADMIN_EMAIL', 'danzyd@gmail.com');
	define( 'CREDITCARDNUMBER' , '' );				

	//default bond items
	define('BOND_AMOUNT', '');
	define('EXECUTION_DATE','');
	define('COUNT_DATE','');
	define('COUNT_TIME','');
	define('COURT','');
	define('COUNTY','');
	define('CASE','');
	define('CHARGE','');
	define('CITY','');
	define('D_FNAME','');
	define('D_LNAME','');
	define('AGENT','');
	define('CASE_NUMBER','' );

}




define( 'DEVELOPER_EMAIL', 'jgonzalez@jtmgdevelopment.com,nolahshotwell@gmail.com');
define( 'CREDIT_AMOUNT' , '1.25' );			
define( 'CREDITS_DESC', 'Credits Purchase from Instant Powers' );
define( 'ANNUAL_FEE' , '119.00' );
define( 'ANNUAL_FEE_DESC', 'Annual Fee Purchase from Instant Powers' );
define( 'PAY_PREMIUM_DESC', 'Premium Payment From Agent' );

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */