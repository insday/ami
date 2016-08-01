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
<body topmargin="0" leftmargin="0" onLoad="document.entering.login.focus();"<?if (is_file($_SERVER["DOCUMENT_ROOT"]."/admin/images/bg.jpg")) {?> style="background: url('/admin/images/bg.jpg'); background-size: cover;"<?}?>>
<form name="entering" method="POST" action="xp_main_check.php" onSubmit="if (document.entering.login.value == '' || document.entering.passwrd.value == '') {alert('Введите логин и пароль!'); document.entering.login.focus();} else {this.submit();}; return false;">
<div class="top">WEBSTELLAR 1.0</div>
<div class="login">
	<?
	if ($_SESSION["index_msg"] != "")
		print "<div class=\"login_error\">".$_SESSION["index_msg"]."</div>";
	$_SESSION["index_msg"] = "";
	?>
	<h1>Вход в CMS</h1>
	<div class="group">
		<div class="login_ttl">Логин / Login:</div>
		<div class="login_fld"><input type="text" name="login" size="20" /></div>
	</div>
	<div class="group">
		<div class="login_ttl">Пароль / Password:</div>
		<div class="login_fld"><input type="password" name="passwrd" size="20" /></div>
	</div>
	<div class="login_forgot"><a href="help.php">забыл пароль / forgote the password</div>
	<div class="login_enter"><button name="submitit">войти / enter</button></div>
</div>
</form>
</body>
</html>
