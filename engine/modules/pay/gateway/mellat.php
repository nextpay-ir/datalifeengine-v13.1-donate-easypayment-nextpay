<?php
/*
=====================================================
 DLEFA Pay  Ver 1.0
-----------------------------------------------------
 Persian support site: https://dlefa.ir
-----------------------------------------------------
 FileName :  mellat.php
-----------------------------------------------------
 Copyright (c) 2018, All rights reserved.
=====================================================
*/

$error = array(
	11 => "شماره کارت نامعتبر است",
	12 => "موجودی کافی نیست",
	13 => "رمز نادرست است",
	14 => "تعداد وارد کردن رمز بیش از حد مجاز است",
	15 => "کارت نامعتبر است",
	16 => "دفعات برداشت وجه بیش از حد مجاز است",
	17 => "کاربر از انجام تراکنش منصرف شده است",
	18 => "تاریخ انقضای کارت گذشته است",
	19 => "مبلغ برداشت وجه بیش از اندازه مجاز است",
	111 => "صادر کننده کارت نامعتبر است",
	112 => "خطای سوئیت صادر کننده کارت",
	113 => "پاسخی از صادر کننده کارت دریافت نشد",
	114 => "دارنده کارت مجاز به انجام این تراکنش نیست",
	21 => "پذیرنده کارت نامعتبر است",
	23 => "خطای امنیتی روی داده است",
	24 => "اطلاعات کاربری پذیرنده نامعتبر است",
	25 => "مبلغ نامعتبر است",
	31 => "پاسخ نامعتبر است",
	32 => "قرمت اطلاعات وارد شده صحیح نمی باشد",
	33 => "حساب نامعتبر است",
	34 => "خطای سیستمی",
	35 => "تاریخ نا معتبر است",
	41 => "شماره درخواست تکراری است",
	42 => "تراکنش یافت نشد",
	43 => "قبلا درخواست تائیدیه ارسال شده است",
	44 => "درخواست تائید یافت نشد",
	45 => "تراکنش منحل شده است",
	46 => "تراکنش منحل نشده است",
	47 => "منحل سازی تراکنش یافت نشد",
	48 => "تراکنش ریورس شده است",
	49 => "تراکنش ریفاند یافت نشد",
	412 => "شناسه قبض نادرست است",
	413 => "شناسه پرداخت نادرست است",
	414 => "سازمان صادر کننده قبض نامعتبر است",
	415 => "زمان جلسه کاری پایان یافته است",
	416 => "خطا در ثبت اطلاعات",
	417 => "شناسه پرداخت کننده نامعتبر است",
	418 => "اشکال در تعریف اطلاعات مشتری",
	419 => "تعداد دفعات ورود اطلاعات بیش از حد مجاز است",
	421 => "IP نامعتبر است",
	51 => "تراکنش تکراری است",
	54 => "تراکنش مرجع یافت نشد",
	55 => "تراکنش نامعتبر است",
	61 => "خطا در واریز"
);

function Request($terminalId, $userName, $userPassword, $amount, $orderid, $callback){
	global $error;
	$gate = new SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
	$result = $gate->bpPayRequest(array(
		'terminalId' => $terminalId,
		'userName' => $userName,
		'userPassword' => $userPassword,
		'orderId' => $orderid,
		'amount' => $amount,
		'localDate' => date('ymj'),
		'localTime' => date('His'),
		'additionalData' => '',
		'callBackUrl' => $callback,
		'payerId' => 0,
	), "http://interfaces.core.sw.bps.com/");
	$result->return = explode(",", $result->return);
	if (intval($result->return[0]) === 0) {
		return array(
			'status' => true,
			'ref'    => $result->return[1],
			'url'	 => "https://bpm.shaparak.ir/pgwchannel/startpay.mellat"
		);
    } else {
		return array(
			'status' => false,
			'msg'    => $error[$result->return[0]]
		);
	}
}

function Verify($terminalId, $userName, $userPassword, $orderid){
	global $error;
	if( isset($_POST['RefId']) ){
		$gate = new SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
		$result = $gate->bpVerifyRequest(array(
			'terminalId' => $terminalId,
			'userName' => $userName,
			'userPassword' => $userPassword,
			'orderId' => $orderid,
			'saleOrderId' => $_POST['SaleOrderId'],
			'saleReferenceId' => $_POST['SaleReferenceId'],
		), "http://interfaces.core.sw.bps.com/");

		$result->return = explode(",", $result->return);

		if( intval( $result->return[0] ) === 0 ){
			$result = $gate->bpSettleRequest(array(
				'terminalId' => $terminalId,
				'userName' => $userName,
				'userPassword' => $userPassword,
				'orderId' => $orderid,
				'saleOrderId' => $_POST['SaleOrderId'],
				'saleReferenceId' => $_POST['SaleReferenceId'],
			), "http://interfaces.core.sw.bps.com/");

			return array(
				'status' => true,
				'statuscode' => $result->return[0],
				'ref'	 => $_POST['SaleReferenceId'],
				'msg'	 => "پرداخت با موفقیت انجام شد."
			);
		}else {
			$result = $gate->bpReversalRequest(array(
				'terminalId' => $terminalId,
				'userName' => $userName,
				'userPassword' => $userPassword,
				'orderId' => $orderid,
				'saleOrderId' => $_POST['SaleOrderId'],
				'saleReferenceId' => $_POST['SaleReferenceId'],
			), "http://interfaces.core.sw.bps.com/");
			return array(
				'status' => false,
				'statuscode' => $result->return[0],
				'msg'	 => $error[ $_POST['ResCode'] ]
			);
		}
	}else{
		return array(
			'status' => false,
			'msg'	 => $error[ $_POST['ResCode'] ]
		);
	}
}
?>
