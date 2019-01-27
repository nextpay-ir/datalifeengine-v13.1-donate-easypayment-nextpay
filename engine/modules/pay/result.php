<?php
/*
=====================================================
 DLEFA Pay  Ver 1.0
-----------------------------------------------------
 Persian support site: https://dlefa.ir
-----------------------------------------------------
 FileName :  result.php
-----------------------------------------------------
 Copyright (c) 2018, All rights reserved.
=====================================================
*/

defined("DATALIFEENGINE") || exit();

$module_title = $pay_config['module_title'];

require_once ENGINE_DIR . '/modules/pay/data/data.php';

$bankid = $db->safesql( $_GET['bankid'] );

$result = array('status'=> false);

switch( $bankid ){
		
	case "mellat":
		require_once ENGINE_DIR . '/modules/pay/gateway/mellat.php';
		$orderid = $db->safesql( $_GET['orderid'] );
		if (empty($orderid)){
			header("HTTP/1.0 301 Moved Permanently");
			header("Location: {$config['http_home_url']}pay");
			die("Redirect");
		}else{
			$invoice = $db->super_query("SELECT id, amount, mobile FROM " . PREFIX . "_pay_invoices WHERE refid='{$orderid}'");
			if( $invoice ){
				$result = Verify($pay_config['mellat_terminalid'] , $pay_config['mellat_username'], $pay_config['mellat_password'], $orderid);
				if( $result['status'] ){
					$db->query("UPDATE " . PREFIX . "_pay_invoices SET `status`='{$result['statuscode']}', `statusmsg`='{$result['msg']}',`refid`='{$result['ref']}' WHERE id='{$invoice['id']}'");
					$refid = $result['ref'];
					$msg   = $result['msg'];
				}else{
					$db->query("UPDATE " . PREFIX . "_pay_invoices SET `status`='{$result['statuscode']}', `statusmsg`='{$result['msg']}',`refid`='{$result['ref']}' WHERE id='{$invoice['id']}'");
					$refid = $result['ref'];
					$msg   = $result['msg'];
				}
			}else
				$msg = "فیش پرداختی در سیستم یافت نشد.";
				$tpl->set_block( "'\\[success\\](.*?)\\[/success\\]'si", "" );
		}
		break;
	case "nextpay":
		require_once ENGINE_DIR . '/modules/pay/gateway/nextpay.php';
		$trans_id = $db->safesql( $_POST['trans_id'] );
		$order_id = $db->safesql( $_POST['order_id'] );		
        $invoice = $db->super_query("SELECT id, amount, mobile FROM " . PREFIX . "_pay_invoices WHERE refid='{$trans_id}'");
        if( $invoice ){
            $result = Verify($pay_config['nextpay_apikey'], $trans_id, $order_id, $invoice['amount']);
            if( $result['status']){
                $db->query("UPDATE " . PREFIX . "_pay_invoices SET `status`='{$result['statuscode']}', `statusmsg`='{$result['msg']}' WHERE id='{$invoice['id']}'");
                $refid = $trans_id;
                $msg   = $result['msg'];
                $tpl->set('[success]', "");
                $tpl->set('[/success]', "");
            }else{
                $db->query("UPDATE " . PREFIX . "_pay_invoices SET `status`='{$result['statuscode']}', `statusmsg`='{$result['msg']}' WHERE id='{$invoice['id']}'");
                $refid = $trans_id;
                $msg   = $result['msg'];
            }
        }else
            $msg = "فیش پرداختی در سیستم یافت نشد.";
		$bank = "نکست پی";
		break;
	
	default:
		header("HTTP/1.0 301 Moved Permanently");
		header("Location: {$config['http_home_url']}pay");
		die("Redirect");
}



if ( $result['status']) {
	
	if ($pay_config['sms_on']){
		$sms_text = str_replace('%pay_code%', $refid, $pay_config['sms_text']);
		send_sms ($sms_text, $invoice['mobile']);
		if ($pay_config['sms_admin_on']){
			send_sms ($pay_config['admin_text'], $pay_config['sms_admin']);
		}
	}
	
	$tpl->load_template('pay/result.tpl');
} else {
	$tpl->load_template('pay/error.tpl');
}
$tpl->set('{bank}', $bank);
$tpl->set('{amount}', intval( $invoice['amount'] ));
$tpl->set('{msg}', $msg);
$tpl->set('{pcode}', $refid);
$tpl->compile('content');
$tpl->clear();
?>
