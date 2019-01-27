<?php
/*
=====================================================
 DLEFA Pay  Ver 1.0
-----------------------------------------------------
 Persian support site: https://dlefa.ir
-----------------------------------------------------
 FileName :  main.php
-----------------------------------------------------
 Copyright (c) 2018, All rights reserved.
=====================================================
*/

defined("DATALIFEENGINE") || exit();

@include ENGINE_DIR .'/modules/pay/data/data.php';

function send_sms ($text, $to){
	global $pay_config;

	$param = array('uname'=>$pay_config['sms_uname'],'pass'=>$pay_config['sms_pass'],'from'=>$pay_config['sms_from'],'message'=>$text,'to'=>json_encode(array($to)),'op'=>'send');
	
	$handler = curl_init('http://37.130.202.188/services.jspd');             
	curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($handler, CURLOPT_POSTFIELDS, $param);                       
	curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
	$response2 = curl_exec($handler);
}

$action = ( $_REQUEST['action'] ) ? $_REQUEST['action'] : 'send';

if( $action == "verify" )
	include ENGINE_DIR . '/modules/pay/result.php';
else
	include ENGINE_DIR . '/modules/pay/block.php';

?>