<?php
$message 	= 'This message was sent by an automatic mailer built with Instant Powers:= = = = = = = = = = = = = = = = = = = = = = = = = = = ';
$message 	.=  date('l jS \of F Y h:i:s A');
if(  mail('jgonzalez@jtmgdevelopment.com,nolahshotwell@yahoo.com', 'Email Test -> Instant Powers', $message ) ){
	
	echo 'Email Is Working ';
	echo date('l jS \of F Y h:i:s A');
	
}
else
{
	echo 'Email Is Not Working ';
	echo date('l jS \of F Y h:i:s A');
}

?>
