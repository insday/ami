<?
session_start();
require "includes/connection.php";
require "includes/main_init.php";
require "includes/messages.php";

mysql_query("select * from ".$prefix."_secure") or header("Location: install/index.php?table=secure&ref=notables");

mysql_query("delete from ".$prefix."_secure where date_add(dt, interval 1 hour) < NOW()") or die("CHECK SECURE TABLE!");

if ($_SESSION['attempts'] > 2)
	mysql_query("insert into ".$prefix."_secure (ip, dt) values('".$_SERVER["REMOTE_ADDR"]."', NOW())");

$hacker = mysql_query("select * from ".$prefix."_secure where ip = '".$_SERVER["REMOTE_ADDR"]."'");
if (mysql_num_rows($hacker) > 0)
	{
	$_SESSION['index_msg'] = $MSG[$lang]["MsgAccessBlocked"];
	$_SESSION['attempts'] = 0;
	header("Location: index.php");
}
else
	{
	if (mysql_query("select * from workflow"))
		{
		$user_select = mysql_query("select * from ".$prefix."_workflow where user_login = '".$_POST["login"]."' and user_pass = '".md5($_POST["passwrd"])."'") or die(mysql_error());
		$good_entry = mysql_num_rows($user_select);
	}
	if (($log != $_POST["login"] || $pass != $_POST["passwrd"]) && $good_entry == 0)
		{
		$_SESSION['attempts']++;
		$_SESSION['index_msg'] = $MSG[$lang]["MsgNoAccess"];
		$_SESSION['s_login'] = "";
		$_SESSION['s_password'] = "";
		$_SESSION["w_login_user_id"] = "";
		$_SESSION["w_login"] = "";
		$_SESSION["w_password"] = "";
		header("Location: index.php");
	}
	else
		{
		if ($good_entry != 0)
			{
			$arr_user = mysql_fetch_array($user_select);
			$_SESSION['s_login'] = "";
			$_SESSION['s_password'] = "";
			$_SESSION['w_login'] = $arr_user["user_login"];
			$_SESSION['w_password'] = $arr_user["user_pass"];
			$_SESSION['w_login_user_id'] = $arr_user["user_id"];
			$_SESSION['attempts'] = "";
		}
		else
			{
			$_SESSION['s_login'] = $log;
			$_SESSION['s_password'] = $pass;
			$_SESSION['w_login'] = "";
			$_SESSION['w_password'] = "";
			$_SESSION['w_login_user_id'] = "";
			$_SESSION['attempts'] = "";
		}
		header("Location: main.php");
	}
}
?>
