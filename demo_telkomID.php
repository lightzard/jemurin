<?php
require_once("AppPRIME.class.php");     // include class AppPRIME
$config = array(                        // setting config via array
	'partner_key' => 'YOUR_PARTNER_KEY',
	'secret_key' => 'YOUR_SECRET_KEY'
);

/** 
 * Selain memasukkan partner_key dan secret_key di atas,
 * Cara lain adalah:
 * $AppPRIME->setPartnerKey('YOUR_PARTNER_KEY');
 * $AppPRIME->setSecretKey('YOUR_SECRET_KEY');
 */
 
$AppPRIME = new AppPRIME($config);

$AppPRIME->debugResponseFormat="JSON";  // debug response : JSON / ARRAY
$AppPRIME->setEnv("runtime");           // Environment : sandbox / runtime
$AppPRIME->setDebug(true);              // debug : true / false

$param = array(                         // array parameter authentication Telkom ID
	'telkomid' => 'demotelkom',           // - Telkom ID
	'password' => 'telkom'                // - Password
); 

$AppPRIME->setParam($param);
$response=$AppPRIME->authTelkomID();    // authentication Telkom ID
if (!$response)
	print_r($AppPRIME->showError());
else 
	echo "Login Berhasil";
?>