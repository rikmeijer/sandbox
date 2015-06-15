<?php
$ufurl = "https://rollsberekening.kooijmans.nl/rollswebservice/functies_3_0.asmx?wsdl";

$fp = fopen($ufurl, 'r', true, stream_context_create(array(
    'ssl' => array(
        'verify_peer'  => false,
        'allow_self_signed'  => true,
		'ciphers' => 'RC4-MD5'
    )
)));
$data = stream_get_contents($fp);
var_dump($data);
//
//$curl_handle = curl_init();
//curl_setopt($curl_handle, CURLOPT_URL, $ufurl);
//curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT,2);
//curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
//$data = curl_exec($curl_handle);
//curl_close($curl_handle);
//var_dump($data);


?>