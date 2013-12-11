<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if( ENVIRONMENT == 'development' || ENVIRONMENT == 'devlocal' )
{
	// Authorize.net Account Info
	$config['api_login_id'] = '5c84tEwVn';
	$config['api_transaction_key'] = '83q9HMn7698T2Hr4';
	$config['api_url'] = 'https://test.authorize.net/gateway/transact.dll'; // TEST URL
}
else if( ENVIRONMENT == 'testing' )
{
	// Authorize.net Account Info
	$config['api_login_id'] = '5c84tEwVn';
	$config['api_transaction_key'] = '83q9HMn7698T2Hr4';
	$config['api_url'] = 'https://test.authorize.net/gateway/transact.dll'; // TEST URL
}
else if( ENVIRONMENT == 'production' )
{
	// Authorize.net Account Info
	$config['api_login_id'] = '8SfB6u9R';
	$config['api_transaction_key'] = '69S5Z8sTFAw6fp7B';
	$config['api_url'] = 'https://secure.authorize.net/gateway/transact.dll'; // TEST URL
}





//$config['api_url'] = 'https://secure.authorize.net/gateway/transact.dll'; // PRODUCTION URL

/* EOF */