<?php
/*
=====================================================
 DLEFA Pay Ver 1.0
-----------------------------------------------------
 Persian support site: https://dlefa.ir
-----------------------------------------------------
 FileName :  pay.php
-----------------------------------------------------
 Copyright (c) 2018, All rights reserved.
=====================================================
*/

defined("DATALIFEENGINE") || exit();

@include ENGINE_DIR .'/modules/pay/data/data.php';

if( $action == "settings" ){
	function makeCheckBox($name, $selected) {

		$selected = $selected ? "checked" : "";
		
		return "<input class=\"switch\" type=\"checkbox\" name=\"{$name}\" value=\"1\" {$selected}>";

	}
	function showRow($title = "", $field = "") {
			
	echo "<tr>
			<td><h6>{$title}</h6></td>
			<td>{$field}</td>
		</tr>";
	}
	echoheader( "<i class=\"fa fa fa-credit-card-alt position-left\"></i><span class=\"text-semibold\">تنظیمات پلاگین پرداخت آنلاین همیار دیتالایف</span>", "تنظیمات پلاگین و درگاه ها");
	echo <<<HTML
<script>
<!--
    function ChangeOption(obj, selectedOption) {

        $("#navbar-filter li").removeClass('active');
        $(obj).parent().addClass('active');
        document.getElementById('general').style.display = "none";
        document.getElementById('mellat').style.display = "none";
        document.getElementById('nextpay').style.display = "none";
        document.getElementById('sms').style.display = "none";
		document.getElementById(selectedOption).style.display = "";

        return false;

    }
//-->
</script>
<form action="" method="post">
<div class="navbar navbar-default navbar-component navbar-xs systemsettings">
    <ul class="nav navbar-nav visible-xs-block">
        <li class="full-width text-center"><a data-toggle="collapse" data-target="#navbar-filter" class="legitRipple"><i class="fa fa-bars"></i></a></li>
    </ul>
    <div class="navbar-collapse collapse" id="navbar-filter">
        <ul class="nav navbar-nav">
            <li class="active"><a onclick="ChangeOption(this, 'general');" class="tip legitRipple" title="" data-original-title="تنظیمات پلاگین"><i class="fa fa-cog"></i> تنظیمات پلاگین</a></li>
            <li><a onclick="ChangeOption(this,'mellat');" class="tip legitRipple" title="" data-original-title="تنظیمات درگاه بانک ملت"><i class="fa fa-shield"></i> تنظیمات درگاه بانک ملت</a></li>
            <li><a onclick="ChangeOption(this, 'nextpay');" class="tip legitRipple" title="" data-original-title="تنظیمات درگاه نکست پی"><i class="fa fa-file-text-o"></i> تنظیمات درگاه نکست پی</a></li>
            <li><a onclick="ChangeOption(this, 'sms');" class="tip legitRipple" title="" data-original-title="تنظیمات درگاه پیامک"><i class="fa fa-commenting-o"></i> تنظیمات درگاه پیامک</a></li>
        </ul>
    </div>
</div>

<div id="general" class="panel panel-flat">
	<div class="panel-body">
	تنظیمات پلاگین
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-normal">
			<tbody>
				<tr>
					<td class="bg-primary" colspan="2" align="center">
						<h6><i class="fa fa-cog fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>این پلاگین توسط تیم نکست پی منتشر شده است. جهت سفارشی سازی از طریق لینک <a class="text-warning" href="https://nextpay.ir/support/" target="_blank"><b>تماس با ما</b></a> اقدام فرمایید.</h6>
					</td>
				</tr>
				<tr>
					<td class="col-xs-5 col-sm-5 col-md-5"><h6>Title پلاگین سمت سایت</h6></td>
					<td class="col-xs-7 col-sm-7 col-md-7 settingstd"><input type="text" class="form-control width-300" name="save_con[module_title]" value="{$pay_config['module_title']}"></td>
				</tr>
				<tr>
					<td class="col-xs-5 col-sm-5 col-md-5"><h6>تعداد فیش ها در پنل مدیریت</h6></td>
					<td class="col-xs-7 col-sm-7 col-md-7 settingstd"><input type="text" class="form-control text-center width-300" name="save_con[fish_order]" value="{$pay_config['fish_order']}"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div id="mellat" class="panel panel-flat" style="display:none">
	<div class="panel-body">
    تنظیمات درگاه بانک ملت
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-normal">
			<tbody>
				<tr>
					<td class="bg-primary" colspan="2" align="center">
						<h6><i class="fa fa-cog fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>برای دریافت درگاه بانک ملت بایستی پس از دریافت نماد اعتماد الکترونیکی به سایت <a href="http://behpardakht.com/" class="text-warning" target="_blank"><b>به پرداخت بانک ملت</b></a> مراجعه نمایید.</h6>
					</td>
				</tr>
HTML;
					showRow( "فعال بودن درگاه بانک ملت", makeCheckBox( "save_con[mellat_on]", "{$pay_config['mellat_on']}" ) );
					echo <<<HTML
				<tr>
					<td class="col-xs-5 col-sm-5 col-md-5"><h6>ترمینال</h6></td>
					<td class="col-xs-7 col-sm-7 col-md-7 settingstd"><input type="text" class="form-control ltr width-300" name="save_con[mellat_terminalid]" value="{$pay_config['mellat_terminalid']}"></td>
				</tr>
				<tr>
					<td class="col-xs-5 col-sm-5 col-md-5"><h6>نام کاربری</h6></td>
					<td class="col-xs-7 col-sm-7 col-md-7 settingstd"><input type="text" class="form-control ltr width-300" name="save_con[mellat_username]" value="{$pay_config['mellat_username']}"></td>
				</tr>
				<tr>
					<td class="col-xs-5 col-sm-5 col-md-5"><h6>کلمه عبور</h6></td>
					<td class="col-xs-7 col-sm-7 col-md-7 settingstd"><input type="text" class="form-control ltr width-300" name="save_con[mellat_password]" value="{$pay_config['mellat_password']}"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div id="nextpay" class="panel panel-flat" style="display:none">
	<div class="panel-body">
    تنظیمات درگاه نکست پی
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-normal">
			<tbody>
				<tr>
					<td class="bg-primary" colspan="2" align="center">
						<h6><i class="fa fa-cog fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>برای دریافت درگاه و اطلاعات بیشتر به سایت <a class="text-warning" href="https://api.nextpay.org/account/signup/" target="_blank"><b>نکست پی</b></a> مراجعه نمایید.</h6>
					</td>
				</tr>
HTML;
					showRow( "فعال بودن درگاه نکست پی", makeCheckBox( "save_con[nextpay_on]", "{$pay_config['nextpay_on']}" ) );
					echo <<<HTML
				<tr>
					<td class="col-xs-5 col-sm-5 col-md-5"><h6>کلید مجوزدهی</h6><span class="note large">XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX</span></td>
					<td class="col-xs-7 col-sm-7 col-md-7 settingstd"><input type="text" class="form-control ltr width-300" name="save_con[nextpay_apikey]" value="{$pay_config['nextpay_apikey']}"></td>
				</tr>
HTML;
					echo <<<HTML
			</tbody>
		</table>
	</div>
</div>
<div id="sms" class="panel panel-flat" style="display:none">
	<div class="panel-body">
    تنظیمات درگاه پیامک
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-normal">
			<tbody>
				<tr>
					<td class="bg-primary" colspan="2" align="center">
						<h6><i class="fa fa-cog fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>برای دریافت پنل پیامک به سایت <a class="text-warning" href="http://sms.dlesms.ir/register.jspd" target="_blank"><b>DLESMS.ir</b></a> مراجعه نمایید.</h6>
					</td>
				</tr>
HTML;
					showRow( "فعال بودن ارسال پیامک", makeCheckBox( "save_con[sms_on]", "{$pay_config['sms_on']}" ) );
					echo <<<HTML
				<tr>
					<td class="col-xs-5 col-sm-5 col-md-5"><h6>نام کاربری</h6></td>
					<td class="col-xs-7 col-sm-7 col-md-7 settingstd"><input type="text" class="form-control ltr width-300" name="save_con[sms_uname]" value="{$pay_config['sms_uname']}"></td>
				</tr>
				<tr>
					<td class="col-xs-5 col-sm-5 col-md-5"><h6>کلمه عبور</h6></td>
					<td class="col-xs-7 col-sm-7 col-md-7 settingstd"><input type="password" class="form-control ltr width-300" name="save_con[sms_pass]" value="{$pay_config['sms_pass']}"></td>
				</tr>
				<tr>
					<td class="col-xs-5 col-sm-5 col-md-5"><h6>شماره اختصاصی پیامک</h6></td>
					<td class="col-xs-7 col-sm-7 col-md-7 settingstd"><input type="text" class="form-control ltr width-300" name="save_con[sms_from]" value="{$pay_config['sms_from']}"></td>
				</tr>
				<tr>
					<td class="col-xs-5 col-sm-5 col-md-5"><h6>متن پیامک کاربران</h6></td>
					<td class="col-xs-7 col-sm-7 col-md-7 settingstd">
					<textarea name="save_con[sms_text]" class="classic" style="width:100%;height:100px;">{$pay_config['sms_text']}</textarea></td>
				</tr>
HTML;
					showRow( "فعال بودن ارسال پیامک به مدیر", makeCheckBox( "save_con[sms_admin_on]", "{$pay_config['sms_admin_on']}" ) );
					echo <<<HTML
				<tr>
				<tr>
					<td class="col-xs-5 col-sm-5 col-md-5"><h6>تلفن همراه مدیر</h6></td>
					<td class="col-xs-7 col-sm-7 col-md-7 settingstd"><input type="text" class="form-control ltr width-300" name="save_con[sms_admin]" value="{$pay_config['sms_admin']}"></td>
				</tr>
					<td class="col-xs-5 col-sm-5 col-md-5"><h6>متن پیامک مدیریت</h6></td>
					<td class="col-xs-7 col-sm-7 col-md-7 settingstd">
					<textarea name="save_con[admin_text]" class="classic" style="width:100%;height:100px;">{$pay_config['admin_text']}</textarea></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div style="margin-bottom:30px;">
	<input type="hidden" name="mod" value="pay">
	<input type="hidden" name="action" value="save">
	<input type="hidden" name="doaction" value="save">
	<button type="submit" class="btn bg-teal btn-raised position-left legitRipple"><i class="fa fa-floppy-o position-left"></i>ذخیره</button>
</div>
</form>
HTML;
	echofooter();
} elseif( $action == "save" AND isset( $_POST['doaction'] ) ){
	$data = $_POST['save_con'];
	$save = fopen(ENGINE_DIR . '/modules/pay/data/data.php', "w");
    fwrite($save, "<?PHP\r\n// Nextpay Pay Gateways Configurations\r\n\$pay_config = array (\r\n");
    foreach ($data as $name => $value) {
        $value = str_replace("$", "&#036;", $value);
        $value = str_replace("{", "&#123;", $value);
        $value = str_replace("}", "&#125;", $value);
        $value = str_replace(chr(0), "", $value);
        $value = str_replace(chr(92), "", $value);
        $value = str_ireplace("base64_decode", "base64_dec&#111;de", $value);
        $name  = str_replace("$", "&#036;", $name);
        $name  = str_replace("{", "&#123;", $name);
        $name  = str_replace("}", "&#125;", $name);
        $name  = str_replace(chr(0), "", $name);
        $name  = str_replace(chr(92), "", $name);
        $name  = str_replace('(', "", $name);
        $name  = str_replace(')', "", $name);
        $name  = str_ireplace("base64_decode", "base64_dec&#111;de", $name);
        fwrite($save, "'{$name}' => '{$value}',\r\n");
    }
    fwrite($save, ");\r\n?>");
    fclose($save);
	clear_all_caches();
    msg("info", "ذخیره تغییرات درگاه های پرداختی", "تغییرات با موفقیت ذخیره شدند.", "?mod=pay");
} elseif( $action == "remove" AND $_GET['id'] != "" ){
	$chk = $db->super_query("SELECT id FROM " . PREFIX . "_pay_invoices WHERE id='{$_GET['id']}'");
	if( $chk ){
		$db->query("DELETE FROM " . PREFIX . "_pay_invoices WHERE id='{$chk['id']}'");
		msg('info', 'پیام', 'سند پرداختی مورد نظر با موفقیت از سیستم حذف گردید.', "?mod=pay");
	}else
		msg('info', 'پیام', 'سند پرداختی مورد نظر در سیستم یافت نشد.', "?mod=pay");
} else {

$limit = $pay_config['fish_order'];
$start = intval( $_GET['page'] )*limit;

$List = $db->query("SELECT * FROM " . PREFIX . "_pay_invoices ORDER BY id DESC LIMIT $start,$limit");

if( $db->num_rows($List) > 0 ){
	
	$item = '';
	$i = 0;
	while( $row = $db->get_row($List) ){
		$i++;
		if( $row['userid'] ){
			$user = $db->super_query("SELECT name, fullname FROM " . PREFIX . "_users WHERE user_id='{$row['userid']}'");
			$name = ( $user['fullname'] != "" ) ? $user['fullname'] : $user['name'];
		}else
			$name = $row['name'];
		
		$row['amount'] = number_format($row['amount']);
		$row['date'] = jdate('Y/m/d', $row['date']);
		if( $row['statusmsg'] == "" ) $row['statusmsg'] = "عملیات ناموفق";
		if( $row['statusmsg'] == "Complete Transaction" ) $row['statusmsg'] = "عملیات موفق";
		$item .= <<<HTML
	<tr>
		<td class="text-center">{$i}</td>
		<td class="text-center">{$name}</td>
		<td class="text-center">{$row['mobile']}</td>
		<td class="text-center">{$row['amount']} تومان</td>
		<td class="text-center">{$row['bank']}</td>
		<td class="text-center">{$row['refid']}</td>
		<td class="text-center">{$row['statusmsg']}</td>
		<td class="text-center">{$row['message']}</td>
		<td class="text-center">{$row['date']}</td>
		<td class="text-center">
			<a href="?mod=pay&action=remove&id={$row['id']}" onclick="javascript:Premove('{$row['id']}'); return(false);"><i class="fa fa-remove fa-2x tip" style="color:red" data-original-title="حذف"></i></a>
		</td>
	</tr>
HTML;
		
	}
	
	$content = <<<HTML
  <div class="table-responsive">
    <table class="table table-striped table-xs">
      <thead>
      <tr>
        <th class="text-center">ردیف</th>
        <th class="text-center">نام و نام خانوادگی</th>
		<th class="text-center">موبایل</th>
		<th class="text-center">مبلغ پرداختی</th>
        <th class="text-center">بانک</td>
		<th class="text-center">شماره پیگیری</td>
		<th class="text-center">وضعیت پرداخت</td>
		<th class="text-center">پیام</td>
		<th class="text-center">تاریخ</th>
		<th class="text-center">عملیات</td>
      </tr>
      </thead>
	  <tbody>
		{$item}
	  </tbody>
	</table>
  </div>
HTML;
}else
	$content = "<div class=\"panel-body\"><table width=\"100%\">
		    <tr>
		        <td height=\"100\" class=\"text-center\">--هیچ سندی ثبت نشده است.--</td>
		    </tr>
		</table></div>";
		
echoheader( "<i class=\"fa fa-money position-left\"></i><span class=\"text-semibold\">پرداخت آنلاین همیار دیتالایف</span>", "مدیریت پرداخت آنلاین همیار دیتالایف");
echo <<<HTML
<script>
function Premove(id){
	DLEconfirm( 'آیا شما از حذف این فیش مطمئن هستید؟', 'پیام', function () {
			document.location='?mod=pay&action=remove&id=' + id;
	});	
}
</script>
	<div class="panel panel-default">
	  <div class="panel-heading">
		لیست فیش های بانکی
		<div class="heading-elements">
			<ul class="icons-list">
				<li><a href="?mod=pay&action=settings"><i class="fa fa-cogs position-left"></i>تنظیمات</a></li>
			</ul>
		</div>
	  </div>
		
	  {$content}
	  <div class="panel-footer text-right">{$pages}</div>
	</div>
HTML;
echofooter();
}

?>
