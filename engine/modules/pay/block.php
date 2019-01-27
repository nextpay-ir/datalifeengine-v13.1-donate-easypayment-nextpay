<?php
/*
=====================================================
 DLEFA Pay  Ver 1.0
-----------------------------------------------------
 Persian support site: https://dlefa.ir
-----------------------------------------------------
 FileName :  block.php
-----------------------------------------------------
 Copyright (c) 2018, All rights reserved.
=====================================================
*/

defined("DATALIFEENGINE") || exit();

$module_title = $pay_config['module_title'];

$tpl->load_template('pay/block.tpl');

$JS = <<<HTML
<script>
function Pay(){
	ShowLoading('در حال برقراری ارتباط با درگاه بانک...');
	var amount = $("input[name=pay_amount]").val();
	if($("input[name=name]").val().length < 1){
	    HideLoading();
		DLEalert( 'نام و نام خانوادگی خود را وارد نمایید.', 'خطا' );
		return;
	}
	var name = $("input[name=name]").val();
	if($("input[name=mobile]").val().length < 1){
	    HideLoading();
		DLEalert( 'لطفا تلفن همراه خود را وارد نمایید.', 'خطا' );
		return;
	}
    var phone = /^[0][9][0-9]{9,9}$/;
    if($("input[name=mobile]").val().match(phone)) {
    	var mobile = $("input[name=mobile]").val();
    } else {
	    HideLoading();
        DLEalert( 'لطفا تلفن همراه خود را به صورت صحیح وارد نمایید.', 'خطای ورودی تلفن همراه' );
        return;
    }
    var message = $("#message").val();
	var bankid = $("select[name=pay_bankid]").val();
	$.post( dle_root+'engine/ajax/controller.php?mod=pay',{
		action: "pay",
		amount: amount,
		name: name,
		mobile: mobile,
		message: message,
		bankid: bankid
	}, function(result){
		if( result.status ){
			if( bankid == "mellat" ){
				var form = document.createElement("form");
				form.setAttribute("method", "POST");
				form.setAttribute("action", result.url);
				form.setAttribute("target", "_self");
				var hiddenField = document.createElement("input");
				hiddenField.setAttribute("name", "RefId");
				hiddenField.setAttribute("value", result.ref);
				form.appendChild(hiddenField);
				document.body.appendChild(form);
				form.submit();
				document.body.removeChild(form);
			}else if( bankid == "nextpay" ){
				setTimeout(function(){
					window.location.replace(result.url);
					window.location.href=result.url;
				},3000);
			}
		}else{
			HideLoading();
			DLEalert( result.msg, 'خطا' );
		}
	},"JSON");
	return false;
}
</script>
HTML;
$tpl->copy_template = "<!--Nextpay Pay Plugin-->" . $JS . $tpl->copy_template . "<!--Nextpay Pay Plugin-->";
$tpl->set('{onclick}', 'onclick="Pay(); return false;"');
$tpl->set('{pay}', "<input type=\"submit\" name=\"pay\" class=\"btn btn-big\" value=\"پرداخت\" onclick=\"Pay(); return false;\">");
if ($is_logged){
	$tpl->set('{input-name}', "<input type=\"text\" class=\"form-control width-200 ltr\" name=\"name\" id=\"name\" value=\"{$member_id['name']}\" readonly>");
    $xfs = xfieldsdataload( $member_id['xfields'] );
    $tpl->set('{input-mob}', "<input type=\"text\" class=\"form-control width-200 ltr\" name=\"mobile\" id=\"mobile\" value=\"{$xfs['mob']}\">");
}else{
	$tpl->set('{input-name}', "<input type=\"text\" class=\"form-control width-200\" name=\"name\" id=\"name\">");
    $tpl->set('{input-mob}', "<input type=\"text\" class=\"form-control width-200 ltr\" name=\"mobile\" id=\"mobile\">");
}
$tpl->set('{input-amount}', "<input type=\"text\" class=\"form-control width-200 ltr\" name=\"pay_amount\" id=\"pay_amount\">");

if ($pay_config['mellat_on'] && $pay_config['nextpay_on']){
	$tpl->set('{bank-list}', "<select class=\"uniform\" name=\"pay_bankid\" id=\"pay_bankid\"><option value=\"nextpay\">درگاه نکست پی</option><option value=\"mellat\">درگاه ملت</option></select>");
}else{
	if ($pay_config['mellat_on']){
		$tpl->set('{bank-list}', "<select class=\"uniform\" name=\"pay_bankid\" id=\"pay_bankid\"><option value=\"mellat\">درگاه ملت</option></select>");
	}elseif ($pay_config['nextpay_on']){
		$tpl->set('{bank-list}', "<select class=\"uniform\" name=\"pay_bankid\" id=\"pay_bankid\"><option value=\"nextpay\">درگاه نکست پی</option></select>");
	}else{
		$tpl->set('{bank-list}', "درگاهی توسط مدیر سایت تعریف نشده است!");
	}
}
$tpl->set('{input-desc}', "<textarea name=\"message\" id=\"message\" rows=\"8\" class=\"wide\"></textarea>");
$tpl->compile('content');
$tpl->clear();
echo $tpl->result['pay'];
?>
