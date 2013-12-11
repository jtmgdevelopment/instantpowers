<cfsetting showdebugoutput="no" />
<Cfparam name="variables.loc" type="struct" default="#{}#" />
<cfparam name="url.username" type="string" default="" />
<cfparam  name="variables.domain" type="string" default="" />
<cfparam  name="variables.subdomain" type="string" default="" />

<cfset variables.domain = cgi.server_name>
<cfset variables.subDomain = "">
<Cfset variables.isdomain = "instantpowers.com" />

<cfif ListFirst( variables.domain, ".") neq "foo" and ListFirst( variables.domain, ".") neq "www">
    <cfset variables.subDomain = ListFirst( variables.domain, ".")>
	<Cfset variables.isdomain =  variables.subDomain & '.' & variables.isdomain />
</cfif>


<Cfset loc = {
	dsn 		= 'prod_instantpowers_v2',
	adminEmail 	= 'jgonzalez@jtmgdevelopment.com',
	taskURL		= 'http://' & variables.isdomain &  '/_task/expire_transmissions.cfm'
} />

<cfif variables.subdomain eq 'stage'>
	<cfset loc.dsn = 'stage' />
</cfif>



<Cfquery name="loc.getVoidedID" datasource="#loc.dsn#">
	SELECT power_status_id
	FROM power_status
	WHERE `key` = <cfqueryparam value="voided" cfsqltype="cf_sql_varchar" />
</Cfquery>




<Cfquery name="loc.getInventoryID" datasource="#loc.dsn#">
	SELECT power_status_id
	FROM power_status
	WHERE `key` = <cfqueryparam value="inventory" cfsqltype="cf_sql_varchar" />
</Cfquery>


<cfquery name="loc.expiredpowers" dataSource="#loc.dsn#">
	select * from power  	
	WHERE 
	exp_date < <cfqueryparam value="#now()#" cfsqltype="cf_sql_date" /> 
	AND  status_id = <cfqueryparam value="#loc.getInventoryID.power_status_id#" cfsqltype="cf_sql_integer" />
</cfquery>


<cfquery name="loc.updatePowers" datasource="#loc.dsn#">
	UPDATE power
	SET status_id = <cfqueryparam value="#loc.getVoidedID.power_status_id#" cfsqltype="cf_sql_integer" />
	WHERE exp_date < <cfqueryparam value="#now()#" cfsqltype="cf_sql_date" /> 
	AND  status_id = <cfqueryparam value="#loc.getInventoryID.power_status_id#" cfsqltype="cf_sql_integer" />
</cfquery>


<cfquery name="loc.updateTransmission" datasource="#loc.dsn#">
	UPDATE transmission
	SET active = <cfqueryparam value="0" cfsqltype="cf_sql_bit" />
	WHERE exp_date < <cfqueryparam value="#now()#" cfsqltype="cf_sql_date" /> 
</cfquery>



<cfmail to="#loc.adminEmail#" from="noreply@instantpowers.com" subject="Expired Transmissions" type="html">
	<h2>Agent Login</h2>
	<p>#url.username# just logged in at #now()#</p>
	<cfdump var="#loc#" />
</cfmail>






