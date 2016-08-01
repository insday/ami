<?
include "includes/connection.php";
include "includes/main_init.php";
include "includes/main_func.php";
include "includes/messages.php";
include "secure.php";

// print_r($_POST);
$i = 1;
foreach ($_POST['item'] as $value) {
	$query = "UPDATE ".$prefix."_pages SET page_order = ".$i." WHERE page_id = ".(int)str_replace("page", "", $value);
	mysql_query($query) or die(mysql_error());
    $i++;
}
?>