truncate table power;
truncate table transmission;
truncate table master_agent_report;
truncate table master_agent_report_data;
truncate table power_history;
truncate table power_sub_agent_history;
truncate table power_sub_agent_join;
truncate table jail_accepted_powers_data;
truncate table jail_accepted_powers_report;
truncate table power_details_collateral;
truncate table power_details_defendant;
truncate table power_details_indemnitor;
truncate table power_sub_agent_join;
truncate table saved_powers;
truncate table power_details;
truncate table bail_agency;
truncate table bail_agency_agent_join;
truncate table bail_agent;
truncate table bail_insurance_join;
truncate table bail_mga_join;
truncate table credits;
truncate table credits_history;
truncate table insurance_agency;
truncate table insurance_agency_agent_join;
truncate table insurance_agent;
truncate table jails;
truncate table master_sub_join;
truncate table member;
truncate table mga_insurance_join;
truncate table mgas;
truncate table offline_powers;
truncate table power_sub_agent_history;
truncate table power_sub_agent_join;
truncate table premiums;
truncate table recorded_emails;
truncate table saved_powers;
truncate table security;
truncate table security_role_join;
truncate table sub_agent_credit_use_history;
truncate table transactions;


INSERT INTO `member`
(`mek`,
`full_name`,
`first_name`,
`last_name`,
`email`)
VALUES
(
'adminkey1234',
'Admin Admin',
'Admin',
'Admin',
'admin@instantpowers.com'
);

INSERT INTO `security`
(
`username`,
`password`,
`active`,
`mek`)
VALUES
(
'admin',
'admin',
1,
'adminkey1234'
);

INSERT INTO `security_role_join`
(
`security_id`,
`role_id`)
VALUES
(
'adminkey1234',
10
);

