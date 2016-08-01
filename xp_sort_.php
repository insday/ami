<?
include "includes/connection.php";
include "includes/main_init.php";
include "includes/main_func.php";
include "includes/messages.php";
include "secure.php";

// print_r($_POST);
$i = 1;
foreach ($_POST['item'] as $value) {
	$query = "UPDATE ".$prefix."_blocks SET block_order = ".$i." WHERE block_id = ".(int)str_replace("block", "", $value);
	mysql_query($query) or die(mysql_error());
    $i++;
}
?>