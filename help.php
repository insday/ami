<?
session_start();
header('Content-Type: text/html; charset=UTF-8');

// ini_set("display_errors", "1");
// ini_set("display_startup_errors", "1");
// ini_set("error_reporting", E_ALL);
?>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="robots" content="noindex, nofollow">
	<link rel="stylesheet" type="text/css" href="webstellar.css">
<head><title>^^ WEBSTELLAR ^^</title>
</head>
<body topmargin="0" leftmargin="0" onLoad="document.entering.email.focus();"<?if (is_file($_SERVER["DOCUMENT_ROOT"]."/admin/images/bg.jpg")) {?> style="background: url('/admin/images/bg.jpg'); background-size: cover;"<?}?>>
<form name="entering" method="POST" action="xp_send_help.php" onSubmit="if (document.entering.message.value == '' || document.entering.email.value == '') {alert('Введите email и сообщение!'); document.entering.message.focus();} else {this.submit();}; return false;">
<div class="top">WEBSTELLAR 1.0</div>
<div class="login">
	<?
	if ($_SESSION["index_msg"] != "")
		print "<div class=\"login_error\">".$_SESSION["index_msg"]."</div>";
	$_SESSION["index_msg"] = "";
	?>
	<h1>Помощь</h1>
	<div class="group">
		<div class="login_ttl">Ваш EMail:</div>
		<div class="login_fld"><input type="text" name="email" size="20" /></div>
	</div>
	<div class="login_ttlw">Ваше сообщение / Your message:</div>
	<div class="login_fldw"><textarea name="message"></textarea></div>
	<div class="login_enter"><button name="submitit">отправить / send</button></div>
</div>
</form>
</body>
</html>
