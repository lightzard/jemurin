<?php
require_once("AppPRIME.class.php");															// include class AppPRIME
$config = array(																								// setting config via array
	'partner_key' => 'hardhack_0003',
	'secret_key' => 'ATMDH'
);

/** 
 * Selain memasukkan partner_key dan secret_key di atas,
 * Cara lain adalah:
 * $AppPRIME->setPartnerKey('YOUR_PARTNER_KEY');
 * $AppPRIME->setSecretKey('YOUR_SECRET_KEY');
 */
 
$AppPRIME = new AppPRIME($config);

$AppPRIME->debugResponseFormat="JSON";	// debug response : JSON / ARRAY
$AppPRIME->setEnv("runtime");						// Environment : sandbox / runtime
$AppPRIME->setDebug(true);							// debug : true / false

$param=array(														// array parameter send sms
		"address" => "02717099323",           // - nomor flexi tujuan
		"charginginformation" => array(
			"description" => "testing sms",   // - deskripsi
			"currency" => "IDR",              // - mata uang : IDR
			"amount" => "1",                  // - rupiah yang dideduct, berlaku jika code != SDPCHG000
			"code" => "SDPCHG000"             // - charge code
		),
		"message" => "test sms"             // - isi pesan sms
	);
/*$param = array( // array parameter authentication Telkom ID
    'telkomid' => 'demotelkom', // - Telkom ID
    'password' => 'telkom' // - Password
);*/
$AppPRIME->setParam($param);

//$AppPRIME->authTelkomID();
//echo "aa";//$response"";
$response=$AppPRIME->sendSMS();					// send sms
if (!$response)
	print_r($AppPRIME->showError());
else 
	echo "Send SMS Berhasil";
?>