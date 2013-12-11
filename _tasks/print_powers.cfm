<Cfsetting requesttimeout="86400" />

<Cfparam name="url.report_id" type="string" default="0" />
<Cfparam name="url.trans_id" type="string" default="0" />
<Cfparam name="url.prefix_id" type="string" default="0" />
<Cfparam name="url.hide" type="string" default="0" />
<cfparam name="url.mek"	 type="string" default="" />
<Cfparam name="url.batch" type="boolean" default="false" />
<cfparam name="variables.loc" type="struct" default="#{}#" />
<Cfparam name="variables.execute" type="boolean" default="false" />
<Cfif url.report_id eq 0>
	<Cflocation url="/index.php" addtoken="yes" />
</Cfif>

<cfoutput>


	<cfquery name="loc.power" datasource="prod_instantpowers_v2">		
		SELECT DISTINCT
		p.power_id, p.pek, p.prefix_id, ps.status, ps.key,
		def.first_name, def.last_name, pp.prefix, pp.amount, pd.bond_amount, pd.county, p.exp_date,
		pd.court, pd.case_number, pd.charge, pd.executing_agent, DATE_FORMAT(pd.court_date, "%m/%d/%Y") as court_date
		
		
		FROM power AS p
		INNER JOIN transmission AS t
			ON t.transmission_id = p.transmission_id
		INNER JOIN bail_agent AS ba 			
			ON	ba.mek = t.bail_agent_id
		INNER JOIN bail_agency_agent_join AS baaj
			ON	baaj.bail_agent_id = ba.mek
		INNER JOIN bail_agency AS bay
			ON bay.bail_agency_id = baaj.bail_agency_id	
		INNER JOIN member AS m
			ON m.mek = ba.mek
			
		INNER JOIN power_prefix AS pp
			ON pp.prefix_id = p.prefix_id	
		
		INNER JOIN power_status AS ps
			ON ps.power_status_id = p.status_id
		
		INNER JOIN power_details as pd
			ON pd.pek = p.pek AND pd.prefix_id = p.prefix_id	
		INNER JOIN power_details_defendant as def
			ON def.pek = p.pek AND def.prefix_id = p.prefix_id	
		
		WHERE p.power_id in (
        	SELECT power_id 
            FROM master_agent_report_data 
            WHERE report_id =         <cfqueryparam value="#url.report_id#" cfsqltype="cf_sql_integer" />            
          )
		
		ORDER BY p.pek
	
	</cfquery>
</cfoutput>

<cfquery name="agent" datasource="prod_instantpowers_v2">
		SELECT m.full_name, bay.agency_name, bay.address, bay.city, bay.state, bay.zip, ba.license_number, m.company
		from member as m
		INNER JOIN bail_agent AS ba 			
			ON	m.mek = ba.mek
		INNER JOIN bail_agency_agent_join AS baaj
			ON	baaj.bail_agent_id = ba.mek
		INNER JOIN bail_agency AS bay
			ON bay.bail_agency_id = baaj.bail_agency_id	
		WHERE m.mek = <cfqueryparam value="#url.mek#" cfsqltype="cf_sql_varchar" />
</cfquery>


<cfoutput>

<Cfset loc.power_pdf = 'power_' & createUUID() />
<cfdocument format="pdf" filename="#loc.power_pdf#.pdf" overwrite="yes">
<style type="text/css">
@import url(http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700);

*{
	font-family:"Open Sans", Arial, Helvetica, sans-serif;
	color:##000;	
	line-height:20px;
}
div.power{
	margin-bottom:32px;
	padding:10px;
	width:800px;
	font-size:12px;
	color:##111;
	text-align:justify;
	text-justify:inter-word;
	float:left;
	border: 1px solid ##0071ac;
	background: url(/_assets/power_assets/images/pattern_003.png);
	clear:both;	
	height:500px;
}

div.executed{
	background: url(/_assets/power_assets/images/pattern_003.png) !important;
}

div.transfer{
	background:url(/_assets/power_assets/images/watermark-pattern-transfer.png) !important;	
}
div.void{
	background:url(/_assets/power_assets/images/watermark-pattern-void.png) !important;	
}
div.rewrite{
	background:url(/_assets/power_assets/images/watermark-pattern-rewrite.png) !important;	
}
div.discharged{
	background:url(/_assets/power_assets/images/watermark-pattern-discharged.png) !important;	
}
div.judgement{
	background:url(/_assets/power_assets/images/watermark-pattern-judgement.png) !important;	
}
div.expired{
	background:url(/_assets/power_assets/images/watermark-pattern-expired.png) !important;	
}
div.forfeited{
	background:url(/_assets/power_assets/images/watermark-pattern-forfeited.png) !important;	
}

table{
	border:none;
	border-collapse:collapse;	
}
##power-amount{
	font-size: 15px;
	font-weight: bold;
	color: ##0071AC;
	text-transform:uppercase;
}
##power-number{
	font-size: 15px;
	font-weight: bold;
	color: ##0071AC;

}
##large{
	font-size:20px;	
}

.content{
	font-size:12px;	
}
p{
	line-height:18px;	
}
p.blue{
	color:##0071AC;	
}
.stats{
	font-size:12px;	
}
</style>



<Cfloop query="loc.power">

<p align="right">
	<em><u>Power Document - #loc.power.prefix# #loc.power.pek#</u></em>
</p>
<div style="margin:10px; width:800px;">
	<div class="power #loc.power.key#">
		<table width="100%">
			<tr>
				<td id="power-amount" align="center" width="140" nowrap> POWER AMOUNT<br />
					#dollarformat( replace( loc.power.amount, '$', '', 'all' ) )# </td>
				<td id="insurance-company" align="center"><span id="mid" style="font-size:13px;">POWER OF ATTORNEY</span><br>
					<span style="font-size:16px;"><strong>PALMETTO SURETY CORPORATION</strong></span><br>
					<span class="small" style=" padding:5px; font-size:11px;">126 Seven Farms Drive, Suite 170, Charleston, SC 29492</span></td>
				<td  id="power-number" align="right">#listfirst( loc.power.prefix, '.' )# <span style="color:red; font-size:15px;">#loc.power.pek#</span></td>
			</tr>
		</table>
		<div class="content">
			<p>
				KNOW ALL MEN BY THESE PRESENTS: that PALMETTO SURETY CORPORATION, a corporation duly authorized and existing under the laws of the State of South Carolina does constitute and appoint the below named agent its true and lawful Attorney-In-Fact for it and in its name, place and stead, to execute, and deliver for and on its behalf, as surety, a bail bond only.
			</p>
			<p class="blue">
				Authority of such Attorney-In-Fact is limited to appearance bonds. No authority is provided herein for the execution of surety immigration bonds or to gurantee alimony payments, fines, wage law claims or other payments of any kind on behalf of below named defendant. The named agent is appointed only to execute the bond consistent with the terms of this power of attorney. The agents is not authorized to act as agent for receipt of service of process in any criminal or civil action. This power is void if altered or erased or used in any combination with other powers of attorney of this company or any other company to obtain the release of the defendant named below or to satisfy any bond requirement in excess of the stated face amount of this power. This power can only be used once. The obligation of the company shall not exceed the sum of
			</p>
			<p class="blue" style="text-align:center; font-size:13px; font-weight:bold">
				#NumberAsString(rereplace( listfirst( loc.power.amount, '.' ), '[^0-9]', '', 'ALL' ))# (#dollarformat(rereplace( listfirst( loc.power.amount, '.' ), '[^0-9]', '', 'ALL' ))#) DOLLARS
			</p>
			<p>
				and provided this Power-Of-Attorney is filed with the bond and retained as a part of the court records. The said Attorney-In-Fact is hereby authorized to insert in this Power-Of-Attorney the name of the person on whose behalf this bond was given.
			</p>
			<p>
				IN WITNESS WHEREOF, PALMETTO SURETY CORPORATION has caused these presents to be signed by it's duly authorized officer, proper for the purpose and its corporate seal to be hereunto affixed this #dateLetters(now())# day of #dateformat(now(), 'mmmm')#.
			</p>
		</div>
	</div>
	<div style="height:30px; width:100%"></div>
	<div style="width:800px; height:500px;">
		<div style="width:400px; float:left; ">
			<table class="stats" cellpadding="3">
				<tr>
					<td><strong>Bond Amount</strong>:</td>
					<td>#dollarformat(loc.power.bond_amount)#</td>
				</tr>
				<tr>
					<td><strong>Defendant</strong>:</td>
					<td>#loc.power.first_name# #loc.power.last_name#</td>
				</tr>
				<tr>
					<td><strong>Court</strong>:</td>
					<td>#loc.power.court#</td>
				</tr>
				<tr>
					<td><strong>Case ##</strong>:</td>
					<td>#loc.power.case_number#</td>
				</tr>
				<tr>
					<td><strong>County</strong>:</td>
					<td>#loc.power.county#</td>
				</tr>
				<tr>
					<td><strong>Offense</strong>:</td>
					<td>#loc.power.charge#</td>
				</tr>
				<tr>
					<td><strong>Executing Agent</strong>:</td>
					<td>#loc.power.executing_agent#</td>
				</tr>
			</table>
		</div>
		<div style="width:350px; float:left; text-align:right;">
			<h1 style="color:red; font-weight:normal; font-size:20px; "> Expires #dateFormat( loc.power.exp_date, 'mm/dd/yyyy' )# </h1>
			<div style="margin-top:20px;"> <img src="/_assets/power_assets/images/seal-signature.png" width="330" height="140" border="0"> </div>
		</div>
	</div>
	
	
</div>
<!--end:fullwidth--> 
<br clear="all">
</div>
</Cfloop>
</cfdocument>
</cfoutput> <cfoutput>
	<cfheader name="Content-Disposition" value="attachment;filename=#loc.power_pdf#.pdf">
	<cfcontent type="application/octet-stream" file="#expandPath('.')#\#loc.power_pdf#.pdf" deletefile="Yes">
</cfoutput>
<cfscript>
/**
 * Returns a number converted into a string (i.e. 1 becomes &quot;One&quot;).
 * Added catch for number=0. Thanks to Lucas for finding it.
 * 
 * @param number      The number to translate. (Required)
 * @return Returns a string. 
 * @author Ben Forta (ben@forta.com) 
 * @version 2, August 20, 2002 
 */
function NumberAsString(number)
{
   VAR Result="";          // Generated result
   VAR Str1="";            // Temp string
   VAR Str2="";            // Temp string
   VAR n=number;           // Working copy
   VAR Billions=0;
   VAR Millions=0;
   VAR Thousands=0;
   VAR Hundreds=0;
   VAR Tens=0;
   VAR Ones=0;
   VAR Point=0;
   VAR HaveValue=0;        // Flag needed to know if to process "0"

   // Initialize strings
   // Strings are "externalized" to simplify
   // changing text or translating
   if (NOT IsDefined("REQUEST.Strs"))
   {
      REQUEST.Strs=StructNew();
      REQUEST.Strs.space=" ";
      REQUEST.Strs.and="AND";
      REQUEST.Strs.point="POINT";
      REQUEST.Strs.n0="ZERO";
      REQUEST.Strs.n1="ONE";
      REQUEST.Strs.n2="TWO";
      REQUEST.Strs.n3="THREE";
      REQUEST.Strs.n4="FOUR";
      REQUEST.Strs.n5="FIVE";
      REQUEST.Strs.n6="SIX";
      REQUEST.Strs.n7="SEVEN";
      REQUEST.Strs.n8="EIGHT";
      REQUEST.Strs.n9="NINE";
      REQUEST.Strs.n10="TEN";
      REQUEST.Strs.n11="ELEVEN";
      REQUEST.Strs.n12="TWELVE";
      REQUEST.Strs.n13="THIRTEEN";
      REQUEST.Strs.n14="FOURTEEN";
      REQUEST.Strs.n15="FIFTEEN";
      REQUEST.Strs.n16="SIXTEEN";
      REQUEST.Strs.n17="SEVENTEEN";
      REQUEST.Strs.n18="EIGHTEEN";
      REQUEST.Strs.n19="NINETEEN";
      REQUEST.Strs.n20="TWENTY";
      REQUEST.Strs.n30="THIRTY";
      REQUEST.Strs.n40="FORTY";
      REQUEST.Strs.n50="FIFTY";
      REQUEST.Strs.n60="SIXTY";
      REQUEST.Strs.n70="SEVENTY";
      REQUEST.Strs.n80="EIGHTY";
      REQUEST.Strs.n90="NINETY";
      REQUEST.Strs.n100="HUNDRED";
      REQUEST.Strs.nK="THOUSAND";
      REQUEST.Strs.nM="MILLION";
      REQUEST.Strs.nB="BILLION";
   }
   
   // Save strings to an array once to improve performance
   if (NOT IsDefined("REQUEST.StrsA"))
   {
      // Arrays start at 1, to 1 contains 0
      // 2 contains 1, and so on
      REQUEST.StrsA=ArrayNew(1);
      ArrayResize(REQUEST.StrsA, 91);
      REQUEST.StrsA[1]=REQUEST.Strs.n0;
      REQUEST.StrsA[2]=REQUEST.Strs.n1;
      REQUEST.StrsA[3]=REQUEST.Strs.n2;
      REQUEST.StrsA[4]=REQUEST.Strs.n3;
      REQUEST.StrsA[5]=REQUEST.Strs.n4;
      REQUEST.StrsA[6]=REQUEST.Strs.n5;
      REQUEST.StrsA[7]=REQUEST.Strs.n6;
      REQUEST.StrsA[8]=REQUEST.Strs.n7;
      REQUEST.StrsA[9]=REQUEST.Strs.n8;
      REQUEST.StrsA[10]=REQUEST.Strs.n9;
      REQUEST.StrsA[11]=REQUEST.Strs.n10;
      REQUEST.StrsA[12]=REQUEST.Strs.n11;
      REQUEST.StrsA[13]=REQUEST.Strs.n12;
      REQUEST.StrsA[14]=REQUEST.Strs.n13;
      REQUEST.StrsA[15]=REQUEST.Strs.n14;
      REQUEST.StrsA[16]=REQUEST.Strs.n15;
      REQUEST.StrsA[17]=REQUEST.Strs.n16;
      REQUEST.StrsA[18]=REQUEST.Strs.n17;
      REQUEST.StrsA[19]=REQUEST.Strs.n18;
      REQUEST.StrsA[20]=REQUEST.Strs.n19;
      REQUEST.StrsA[21]=REQUEST.Strs.n20;
      REQUEST.StrsA[31]=REQUEST.Strs.n30;
      REQUEST.StrsA[41]=REQUEST.Strs.n40;
      REQUEST.StrsA[51]=REQUEST.Strs.n50;
      REQUEST.StrsA[61]=REQUEST.Strs.n60;
      REQUEST.StrsA[71]=REQUEST.Strs.n70;
      REQUEST.StrsA[81]=REQUEST.Strs.n80;
      REQUEST.StrsA[91]=REQUEST.Strs.n90;
   }

   //zero shortcut
   if(number is 0) return "Zero";

   // How many billions?
   // Note: This is US billion (10^9) and not
   // UK billion (10^12), the latter is greater
   // than the maximum value of a CF integer and
   // cannot be supported.
   Billions=n\1000000000;
   if (Billions)
   {
      n=n-(1000000000*Billions);
      Str1=NumberAsString(Billions)&REQUEST.Strs.space&REQUEST.Strs.nB;
      if (Len(Result))
         Result=Result&REQUEST.Strs.space;
      Result=Result&Str1;
      Str1="";
      HaveValue=1;
   }

   // How many millions?
   Millions=n\1000000;
   if (Millions)
   {
      n=n-(1000000*Millions);
      Str1=NumberAsString(Millions)&REQUEST.Strs.space&REQUEST.Strs.nM;
      if (Len(Result))
         Result=Result&REQUEST.Strs.space;
      Result=Result&Str1;
      Str1="";
      HaveValue=1;
   }

   // How many thousands?
   Thousands=n\1000;
   if (Thousands)
   {
      n=n-(1000*Thousands);
      Str1=NumberAsString(Thousands)&REQUEST.Strs.space&REQUEST.Strs.nK;
      if (Len(Result))
         Result=Result&REQUEST.Strs.space;
      Result=Result&Str1;
      Str1="";
      HaveValue=1;
   }

   // How many hundreds?
   Hundreds=n\100;
   if (Hundreds)
   {
      n=n-(100*Hundreds);
      Str1=NumberAsString(Hundreds)&REQUEST.Strs.space&REQUEST.Strs.n100;
      if (Len(Result))
         Result=Result&REQUEST.Strs.space;
      Result=Result&Str1;
      Str1="";
      HaveValue=1;
   }   

   // How many tens?
   Tens=n\10;
   if (Tens)
      n=n-(10*Tens);
    
   // How many ones?
   Ones=n\1;
   if (Ones)
      n=n-(Ones);
   
   // Anything after the decimal point?
   if (Find(".", number))
      Point=Val(ListLast(number, "."));
   
   // If 1-9
   Str1="";
   if (Tens IS 0)
   {
      if (Ones IS 0)
      {
         if (NOT HaveValue)
            Str1=REQUEST.StrsA[0];
      }
      else
         // 1 is in 2, 2 is in 3, etc
         Str1=REQUEST.StrsA[Ones+1];
   }
   else if (Tens IS 1)
   // If 10-19
   {
      // 10 is in 11, 11 is in 12, etc
      Str1=REQUEST.StrsA[Ones+11];
   }
   else
   {
      // 20 is in 21, 30 is in 31, etc
      Str1=REQUEST.StrsA[(Tens*10)+1];
      
      // Get "ones" portion
      if (Ones)
         Str2=NumberAsString(Ones);
      Str1=Str1&REQUEST.Strs.space&Str2;
   }
   
   // Build result   
   if (Len(Str1))
   {
      if (Len(Result))
         Result=Result&REQUEST.Strs.space&REQUEST.Strs.and&REQUEST.Strs.space;
      Result=Result&Str1;
   }

   // Is there a decimal point to get?
   if (Point)
   {
      Str2=NumberAsString(Point);
      Result=Result&REQUEST.Strs.space&REQUEST.Strs.point&REQUEST.Strs.space&Str2;
   }
    
   return Result;
}

function dateLetters(dateStr) {
    var letterList="st,nd,rd,th";
    var domStr=DateFormat(dateStr,"d");
    var domLetters='';
    var formatStr = "";

    if(arrayLen(arguments) gte 2) formatStr = dateFormat(dateStr,arguments[2]);

    switch (domStr) {
        case "1": case "21": case "31":  domLetters=ListGetAt(letterList,'1'); break;
        case "2": case "22": domLetters=ListGetAt(letterList,'2'); break;
        case "3": case "23": domLetters=ListGetAt(letterList,'3'); break;
        default: domLetters=ListGetAt(letterList,'4');
    }

    return domStr & domLetters & " " & formatStr;
}

function GetOrdinal(num) {
  // if the right 2 digits are 11, 12, or 13, set num to them.
  // Otherwise we just want the digit in the one's place.
  var two=Right(num,2);
  var ordinal="";
  switch(two) {
       case "11": 
       case "12": 
       case "13": { num = two; break; }
       default: { num = Right(num,1); break; }
  }

  // 1st, 2nd, 3rd, everything else is "th"
  switch(num) {
       case "1": { ordinal = "st"; break; }
       case "2": { ordinal = "nd"; break; }
       case "3": { ordinal = "rd"; break; }
       default: { ordinal = "th"; break; }
  }

  // return the text.
  return ordinal;
}
</cfscript>
