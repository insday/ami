<?
// $emailto = "support@insday.ru";
$emailto = "taran1972@gmail.com";
$email = "support@insday.ru";
$message = "������������!

� ����� ".$_SERVER["SERVER_NAME"]." ��������� ������ �� ������:
----------------------------------------
��������� EMail: ".$_POST["email"]."
���������:
".$_POST["message"]." 

";
$header = "From:".$email."\nX-Mailer: PHP Auto-Mailer\nContent-Type: text/plain; charset=utf-8";
$subj = "WEBSTELLAR HELP";

$_SESSION["index_msg"] = $MSG[$lang]["MsgHelpMailingSuccess"];

mail($emailto, $subj, $message, $header, "-f".$email) or $_SESSION["index_msg"] = $MSG[$lang]["MsgHelpMailingFailed"];

header("Location: index.php");
?>