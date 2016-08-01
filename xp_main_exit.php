<?
@session_start();
unset($s_login);
unset($s_password);
session_destroy();

header("Location: index.php");
?>
