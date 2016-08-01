<?php
include "includes/connection.php";
include "includes/main_init.php";
include "includes/main_func.php";
include "includes/messages.php";
include "secure.php";

$id = (int)$_POST["id"];
$row = (int)$_POST["row"];
if ($row != "")
	$rowdel = "element_row = ".$row." and ";
if ($id != 0)
	{
	$query = "delete from ".$prefix."_real_data where ".$rowdel."element_id = ".$id;
	mysql_query($query) or die(mysql_error());
	echo 1;
}
?>