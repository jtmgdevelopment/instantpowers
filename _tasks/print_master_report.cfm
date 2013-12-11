<cfparam name="url.var1" type="string" default="" />
<cfparam name="url.var2" type="string" default="" />
<cfparam name="url.var3" type="string" default="0" />
<cfparam name="url.var4" type="string" default="" />
<cfparam name="url.var5" type="string" default="" />
<cfparam name="variables.loc" type="struct" default="#{}#" />

<cfparam  name="variables.domain" type="string" default="" />
<cfparam  name="variables.subdomain" type="string" default="" />
<cfparam  name="variables.dsn" type="string" default="" />

<cfset variables.domain = cgi.server_name>
<cfset variables.subDomain = "">
<Cfset variables.isdomain = "instantpowers.com" />

<cfif ListFirst( variables.domain, ".") neq "foo" and ListFirst( variables.domain, ".") neq "www">
    <cfset variables.subDomain = ListFirst( variables.domain, ".")>
	<Cfset variables.isdomain =  variables.subDomain & '.' & variables.isdomain />
</cfif>
<cfset variables.dsn = 'prod_instantpowers_v2' />

<cfif variables.subdomain eq 'stage'>
	<cfset variables.dsn = 'stage' />
</cfif>

<Cfif ! len( url.var1 ) || ! len( url.var2 )>
	<cflocation url="/master_agent/reports" addtoken="no" />
</Cfif>

<Cfset loc = {
		dsn 		= 'is',
		ins_id 		= url.var1,
		mek			= url.var2,
		report_id 	= url.var3
} />

<cfquery name="loc.getInsuranceInfo" datasource="#variables.dsn#">

	<cfif url.var5 eq "ins">
	SELECT m.full_name, ia.agency_name, ia.insurance_agency_id
	FROM member AS m
	INNER JOIN insurance_agency_agent_join AS iaaj
		ON iaaj.insurance_agent_id = m.mek
	INNER JOIN insurance_agency AS ia
		ON ia.insurance_agency_id = iaaj.insurance_agency_id	
	WHERE 1 = 1		
	AND iaaj.insurance_agent_id = <cfqueryparam value="#loc.ins_id#" cfsqltype="cf_sql_varchar" />
	
	<cfelseif url.var5 eq "mgauser">
	

		select 
			m.first_name, m.last_name, m.full_name, m.email, m.address, m.city, m.state, m.zip, m.phone,m.mek,
			case m.active
				when 1 then "Active"
				when 0 then "Not Active"
				else "Not Active"
			end as active,				
			s.username, r.label,
			DATE_FORMAT(m.created, "%m/%d/%Y") as date_created,
			j.company_name as agency_name,
			concat( m.full_name, " - ", j.company_name ) as namde_company
		from member m
		
		inner join security s on s.mek = m.mek
		inner join security_role_join srj on srj.security_id = s.mek
		inner join roles r on srj.role_id = r.role_id
		inner join mgas j on j.mek = m.mek
		where 1 = 1
		and m.mek = <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" />	

	<cfelse>

	SELECT m.full_name, ia.agency_name, ia.insurance_agency_id
	FROM member AS m
	INNER JOIN insurance_agency_agent_join AS iaaj
		ON iaaj.insurance_agent_id = m.mek
	INNER JOIN insurance_agency AS ia
		ON ia.insurance_agency_id = iaaj.insurance_agency_id	
	WHERE 1 = 1		
	AND iaaj.insurance_agent_id = <cfqueryparam value="#loc.ins_id#" cfsqltype="cf_sql_varchar" />
	
	</cfif>
	
</cfquery>


<Cfif loc.report_id eq 0>
	
	
	<cfquery name="loc.getReportPowers" datasource="#variables.dsn#">

		<cfif url.var5 eq "ins">

		SELECT DISTINCT  p.pek, pp.prefix, pp.amount, pd.case_number, pd.charge, pd.county, pd.bond_amount, pdd.first_name, pdd.last_name, DATE_FORMAT( pd.execution_date,'%m/%d/%Y' ) as execution_date, ps.key, pd.case_number, pd.charge, pd.county
		FROM power AS p
		LEFT JOIN power_details AS pd
			ON pd.power_id = p.power_id			
			
		LEFT JOIN power_details_defendant AS pdd
			ON pdd.power_id = p.power_id	
		INNER JOIN power_prefix AS pp
			ON pp.prefix_id = p.prefix_id	
		INNER JOIN power_status AS ps
			ON ps.power_status_id = p.status_id				
			
		INNER JOIN transmission AS t
			ON t.transmission_id = p.transmission_id
		INNER JOIN insurance_agency_agent_join AS iaaj
			ON t.insurance_agent_id = iaaj.insurance_agent_id
		WHERE 1 = 1	
		AND p.is_reported = 0	
		AND iaaj.insurance_agency_id = <cfqueryparam value="#loc.getInsuranceInfo.insurance_agency_id#" cfsqltype="cf_sql_integer" />
		AND t.bail_agent_id = <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" />

		Order by pp.prefix, pp.amount, p.pek
		
		
		<cfelseif url.var5 eq 'mgauser'> 

			SELECT DISTINCT  p.pek, pp.prefix, pp.amount, pd.bond_amount, pdd.first_name, pdd.last_name, DATE_FORMAT( pd.execution_date,'%m/%d/%Y' ) as execution_date, ps.key, pd.case_number, pd.charge, pd.county
			FROM power AS p
			LEFT JOIN power_details AS pd
				ON pd.power_id = p.power_id			
				
			LEFT JOIN power_details_defendant AS pdd
				ON pdd.power_id = p.power_id	
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id	
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id				
				
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id
			INNER JOIN master_agent_report_data as mard
				ON mard.power_id = p.power_id 
			WHERE 1 = 1	
			
			AND t.mga_id = <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" />
	        AND mard.mga_id = <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" />
	        AND mard.mga_reported = 0
			Order by pp.prefix, pp.amount, p.pek
		
		
		<cfelse>


		SELECT DISTINCT  p.pek, pp.prefix, pp.amount, pd.case_number, pd.charge, pd.county, pd.bond_amount, pdd.first_name, pdd.last_name, DATE_FORMAT( pd.execution_date,'%m/%d/%Y' ) as execution_date, ps.key, pd.case_number, pd.charge, pd.county
		FROM power AS p
		INNER JOIN power_details AS pd
			ON pd.power_id = p.power_id			
			
		LEFT JOIN power_details_defendant AS pdd
			ON pdd.power_id = p.power_id	
		INNER JOIN power_prefix AS pp
			ON pp.prefix_id = p.prefix_id	
		INNER JOIN power_status AS ps
			ON ps.power_status_id = p.status_id				
			
		INNER JOIN transmission AS t
			ON t.transmission_id = p.transmission_id
		INNER JOIN insurance_agency_agent_join AS iaaj
			ON t.insurance_agent_id = iaaj.insurance_agent_id
		WHERE 1 = 1	
		AND p.is_reported = 0	
		AND iaaj.insurance_agency_id = <cfqueryparam value="#loc.getInsuranceInfo.insurance_agency_id#" cfsqltype="cf_sql_integer" />
		AND t.bail_agent_id = <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" />

		Order by pp.prefix, pp.amount, p.pek
		
		
		
		</cfif>
	
	</cfquery>
	
	<cfquery name="loc.getPowerGroups" datasource="#variables.dsn#">

		<cfif url.var5 eq "ins">

			SELECT distinct  pp.prefix_id, pd.case_number, pd.charge, pp.prefix, pp.amount, count( * ) as grouping
			FROM power AS p
			LEFT JOIN power_details AS pd
			ON pd.power_id = p.power_id			
			INNER JOIN power_prefix AS pp
			ON pp.prefix_id = p.prefix_id	
			INNER JOIN transmissiON AS t
			ON t.transmission_id = p.transmission_id
			INNER JOIN insurance_agency_agent_join AS iaaj
			ON t.insurance_agent_id = iaaj.insurance_agent_id
			INNER JOIN bail_agency_agent_join AS baaj
			ON baaj.bail_agent_id = t.bail_agent_id
			INNER JOIN bail_agency AS ba
			ON ba.bail_agency_id = baaj.bail_agency_id
			WHERE 1 = 1	

			AND p.is_reported = 0
		
			AND iaaj.insurance_agency_id =  <cfqueryparam value="#loc.getInsuranceInfo.insurance_agency_id#" cfsqltype="cf_sql_integer" />
			AND t.bail_agent_id = <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" />
	
			GROUP BY pp.prefix_id, pp.prefix, pp.amount ORDER BY grouping desc
		
		<cfelseif url.var5 eq "mgauser">
		
		

			SELECT distinct  pp.prefix_id, pd.case_number, pd.charge, pp.prefix, pp.amount, count( distinct mard.power_id ) as grouping
			FROM power AS p
			LEFT JOIN power_details AS pd
				ON pd.power_id = p.power_id			
				
			LEFT JOIN power_details_defendant AS pdd
				ON pdd.power_id = p.power_id	
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id	
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id				
				
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id
			INNER JOIN master_agent_report_data as mard
				ON mard.power_id = p.power_id 
			WHERE 1 = 1	
			
			AND t.mga_id = <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" />
	        AND mard.mga_id = <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" />
	        AND mard.mga_reported = 0
			GROUP BY pp.prefix_id, pp.prefix, pp.amount ORDER BY grouping desc

		
		<cfelse>
			
			SELECT distinct  pp.prefix_id, pd.case_number, pd.charge, pp.prefix, pp.amount, count( * ) as grouping
			FROM power AS p
			LEFT JOIN power_details AS pd
			ON pd.power_id = p.power_id			
			INNER JOIN power_prefix AS pp
			ON pp.prefix_id = p.prefix_id	
			INNER JOIN transmissiON AS t
			ON t.transmission_id = p.transmission_id
			INNER JOIN insurance_agency_agent_join AS iaaj
			ON t.insurance_agent_id = iaaj.insurance_agent_id
			INNER JOIN bail_agency_agent_join AS baaj
			ON baaj.bail_agent_id = t.bail_agent_id
			INNER JOIN bail_agency AS ba
			ON ba.bail_agency_id = baaj.bail_agency_id
			WHERE 1 = 1	

			AND p.is_reported = 0
		
			AND iaaj.insurance_agency_id =  <cfqueryparam value="#loc.getInsuranceInfo.insurance_agency_id#" cfsqltype="cf_sql_integer" />
			AND t.bail_agent_id = <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" />
	
			GROUP BY pp.prefix_id, pp.prefix, pp.amount ORDER BY grouping desc
		
		
		
		
		</cfif>	
	</cfquery>
	
	
	
<cfelse>
	
	
	<cfquery name="loc.getReportPowers" datasource="#variables.dsn#">
	
		SELECT DISTINCT  p.pek, pp.prefix, pd.case_number, 	pp.amount, pd.county, pd.case_number, pd.charge, pd.bond_amount, pdd.first_name, pdd.last_name, DATE_FORMAT( pd.execution_date,'%m/%d/%Y' ) as execution_date, ps.key
		FROM power AS p
		INNER JOIN master_agent_report_data as mard
		on mard.power_id = p.power_id
		LEFT JOIN power_details AS pd
			ON pd.power_id = p.power_id
		LEFT JOIN power_details_defendant AS pdd
			ON pdd.power_id = p.power_id	
		INNER JOIN power_prefix AS pp
			ON pp.prefix_id = p.prefix_id	
		INNER JOIN power_status AS ps
			ON ps.power_status_id = p.status_id				
			
		INNER JOIN transmissiON AS t
			ON t.transmission_id = p.transmission_id
		
		<cfif url.var5 eq "ins">

			INNER JOIN insurance_agency_agent_join AS iaaj
			ON t.insurance_agent_id = iaaj.insurance_agent_id
		
		
		<cfelse>
			
		</cfif>
		WHERE 1 = 1	
		AND mard.report_id = <cfqueryparam value="#loc.report_id#" cfsqltype="cf_sql_integer" />
	
	</cfquery>


	<cfquery name="loc.getPowerGroups" datasource="#variables.dsn#">
	
				SELECT distinct mard.power_id, pp.prefix_id, pp.prefix, pp.amount, count( * ) as grouping
				FROM power AS p
				INNER JOIN master_agent_report_data as mard
				on mard.power_id = p.power_id
				LEFT JOIN power_details AS pd
					ON pd.power_id = p.power_id			
				INNER JOIN power_prefix AS pp
					ON pp.prefix_id = p.prefix_id	
				INNER JOIN transmissiON AS t
					ON t.transmission_id = p.transmission_id
				<cfif url.var5 eq "ins">

					INNER JOIN insurance_agency_agent_join AS iaaj
						ON t.insurance_agent_id = iaaj.insurance_agent_id
				</cfif>
				WHERE 1 = 1	
			AND mard.report_id = <cfqueryparam value="#loc.report_id#" cfsqltype="cf_sql_integer" />
	
			GROUP BY pp.prefix_id, pp.prefix, pp.amount ORDER BY grouping desc	
	
	
	</cfquery>

</Cfif>

<cfquery name="loc.getPremiums" datasource="#variables.dsn#">
	<cfif url.var5 eq "ins">
	
		SELECT p.premium_id, p.mek, i.insurance_agency_id, premium, buf, active, agency_name
		FROM premiums AS p
		
		INNER JOIN insurance_agency_agent_join AS iaaj
		ON p.transmitter_id = iaaj.insurance_agent_id
		INNER JOIN insurance_agency as i on i.insurance_agency_id = iaaj.insurance_agency_id
		WHERE 1 = 1	
		
		
		AND p.transmitter_id = <cfqueryparam value="#loc.ins_id#" cfsqltype="cf_sql_varchar" />
		
	
		and p.mek = <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" />
	
	<cfelseif url.var5 eq "mgauser">
	

			SELECT P.Premium_id, P.Mek, P.Transmitter_id, Premium, Buf, P.Active, Agency_name, 
            Case  
            When Mga.Mek Is NULL Then "NOT MGA"
            Else "MGA"
            End As Is_mga
            FROM Premiums AS P

        
            INNER JOIN Insurance_agency_agent_join As Iaaj ON Iaaj.Insurance_agent_id = P.Transmitter_id
            INNER JOIN Insurance_agency AS I ON I.Insurance_agency_id = Iaaj.Insurance_agency_id
            LEFT JOIN Mgas As Mga On Mga.Mek = P.Transmitter_id
            WHERE 1 = 1    
         AND P.Transmitter_id = <cfqueryparam value="#loc.ins_id#" cfsqltype="cf_sql_varchar" /> AND P.Mek = <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" />        
            UNION
            
            SELECT P.Premium_id, P.Mek, P.Transmitter_id, Premium, Buf, P.Active, Mga.Company_name As Agency_name, "MGA" As Is_mga
            FROM Premiums AS P

            INNER JOIN Mgas As Mga ON Mga.Mek = P.Transmitter_id
            
            WHERE 1 = 1
         AND P.Transmitter_id = <cfqueryparam value="#loc.ins_id#" cfsqltype="cf_sql_varchar" /> AND <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" /> 
		
	
	<cfelse>
		SELECT p.premium_id, p.mek, i.insurance_agency_id, premium, buf, active, agency_name
		FROM premiums AS p
		
		INNER JOIN insurance_agency_agent_join AS iaaj
		ON p.transmitter_id = iaaj.insurance_agent_id
		INNER JOIN insurance_agency as i on i.insurance_agency_id = iaaj.insurance_agency_id
		WHERE 1 = 1	
		
		
		AND p.transmitter_id = <cfqueryparam value="#loc.ins_id#" cfsqltype="cf_sql_varchar" />
		
	
		and p.mek = <cfqueryparam value="#loc.mek#" cfsqltype="cf_sql_varchar" />
	
	
	</cfif>


</cfquery>


<cfoutput>
	
<cfset loc.report = [] />
<cfset loc.totals = {
		bondAmount 	= 0,
		premium		= 0,
		company 	= 0,
		buf 		= 0,
		powers		= loc.getReportPowers.recordcount
	} />

<Cfloop query="loc.getReportPowers">
	<cfset loc.amount = loc.getReportPowers.bond_amount />
	
	<Cfif loc.amount lte 1000>
		<Cfset loc.premium = 100.00 />
	<cfelse>
		<cfset loc.premium = loc.amount * 0.10 />
	</Cfif>

	<Cfset loc.company = loc.premium * ( loc.getPremiums.premium/100 ) />
	<Cfset loc.buf = loc.premium * ( loc.getPremiums.buf/100 ) />
	
	<Cfset loc.temp = {
		power 		= loc.getReportPowers.prefix & loc.getReportPowers.amount & '-' & loc.getReportPowers.pek,
		amount 		= loc.amount,
		premium 	= loc.premium,
		company 	= loc.company,
		buf 		= loc.buf,
		case_number	= loc.getReportPowers.case_number,
		charge		= loc.getReportPowers.charge,
		defendant 	= loc.getReportPowers.first_name & ' ' & loc.getReportPowers.last_name,
		execDate	= loc.getReportPowers.execution_date,
		key			= loc.getReportPowers.key,
		county		= loc.getReportPowers.county
	} />
	
	<Cfset arrayAppend( loc.report, loc.temp ) />
	<Cfset loc.totals.bondAmount 	+= val( loc.amount ) />	
	<Cfif loc.getReportPowers.key neq 'executed'>
	
		<cfset loc.totals.premium 		+= val( 0.00 ) />
		<cfset loc.totals.company 		+= val( 0.00 ) />
		<Cfset loc.totals.buf			+= val( 0.00 ) />
	
	<cfelse>
		<cfset loc.totals.premium 		+= val( loc.premium ) />
		<cfset loc.totals.company 		+= val( loc.company ) />
		<Cfset loc.totals.buf			+= val( loc.buf ) />
	</Cfif>
</Cfloop>
<cfset loc.reportName = 'Master_Agent_Report_#createuuid()#.pdf' />

<cfdocument format="pdf" filename="#loc.reportName#" overwrite="yes">
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
	width:700px;
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
	font-size:10px;	
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
.tit{
	padding:20px;
	background:##eee;	
	font-family:"Open Sans", Arial, Helvetica, sans-serif;
}
table{
	border:none;
	border-collapse:collapse;
	font-size:11px;
	border:2px solid ##B2E1FF
}
table th{
	background-color: ##0085CC;
    border-right: 1px solid ##00A6FF;
    color: ##FFFFFF;	
	font-weight:bold;
	padding:5px;
} 
table td{
	border:1px solid ##B2E1FF;
	padding:5px;
	font-size: 8px;
}
table tbody tr:nth-child(2n) {
    background: none repeat scroll 0 0 ##EEEEEE;
}
p.small{ font-size:11px; padding-left:20px;}
ul{
	margin:5px 20px;	
}
li{
	font-size:11px;
	font-style:italic;
	list-style:none;	
}
</style>
<h3 class="tit">
	Master Agent Report Totals
</h3>
<ul>
	<li>Company Premium: #loc.getPremiums.premium#%</li>
	<li>BUF: #loc.getPremiums.buf#%</li>
</ul>	
	

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<thead>
		<th>Total Powers Executed</th>
		<th>Total Bond Amount</th>
		<th>Total Premium</th>
		<th>Total Company</th>
		<th>Total BUF</th>
	</thead>
	<tbody>		
		<tr>
			<td>#loc.totals.powers# executed powers</td>
			<td>#numberFormat( loc.totals.bondAmount, '$_,_.__' )#</td>
			<td>#numberFormat( loc.totals.premium, '$_,_.__' )#</td>
			<td>#numberFormat( loc.totals.company, '$_,_.__' )#</td>
			<td>#numberFormat( loc.totals.buf, '$_,_.__' )#</td>
		</tr>		
	</tbody>
</table>	

<h3 class="tit">
	Power Breakdown
</h3>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<thead>
		<th>Power Definition</th>
		<th>Amount Executed</th>
	</thead>
	<tbody>		
		<cfloop query="loc.getPowerGroups">
		<tr>
			<td>#loc.getPowerGroups.prefix##loc.getPowerGroups.amount#</td>
			<td>#loc.getPowerGroups.grouping#</td>
		</tr>		
		</cfloop>
	</tbody>
	
</table>	


<h3 class="tit">Master Agent Report Power Details</h3>
<p class="low small">Powers are ordered by power type/amount</p>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<thead>
		<th>Power ##</th>
		<th>Defendant</th>
		<th>County</th>
		<th>Case ##</th>
		<th>Offense</th>
		<th>Date</th>
		<th>Bond Amount</th>
		<th>Premium</th>
		<th>Company</th>
		<th>BUF</th>
	</thead>
	<tbody>		
		<Cfloop from="1" to="#arrayLen( loc.report )#" index="loc.i" step="1">
		<Cfif loc.i mod 2 >
			<tr style="background-color:##fff">
		<cfelse>
			<tr style="background-color:##eee">
		</Cfif>
		
			<td>#loc.report[ loc.i ].power#</td>
			<td>#loc.report[ loc.i ].defendant#</td>
			<td>#loc.report[ loc.i ].county#</td>
			<td>#loc.report[ loc.i ].case_number#</td>
			<td>#loc.report[ loc.i ].charge#</td>
			<Cfif loc.report[ loc.i ].key neq 'executed'>
				<td>#loc.report[ loc.i ].key#</td>
			<cfelse>
				<td>#loc.report[ loc.i ].execDate#</td>
			</Cfif>
			<Cfif loc.report[ loc.i ].key neq 'executed'>
				<td>#numberFormat( loc.report[ loc.i ].amount, '$_,_.__' )#</td>
				<td>0.00</td>
				<td>0.00</td>
				<td>0.00</td>			
			<cfelse>
				<td>#numberFormat( loc.report[ loc.i ].amount, '$_,_.__' )#</td>			
				<td>#numberFormat( loc.report[ loc.i ].premium, '$_,_.__' )#</td>
				<td>#numberFormat( loc.report[ loc.i ].company, '$_,_.__' )#</td>
				<td>#numberFormat( loc.report[ loc.i ].buf, '$_,_.__' )#</td>			
			</Cfif>
						
		</tr>		
		</Cfloop>
	</tbody>
</table>	

</cfdocument>
<cfheader name="Content-Disposition" value="attachment;filename=#loc.reportName#">
<cfcontent type="application/octet-stream" file="#expandPath('.')#/#loc.reportName#" deletefile="Yes">

</cfoutput>
