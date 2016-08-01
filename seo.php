<?
include "includes/connection.php";
include "includes/main_init.php";
include "includes/main_func.php";
include "includes/messages.php";
include "secure.php";

$admin_title = show_mess("TTLSEO");

include "includes/header.php";
include "includes/top.php";
include "includes/sidebar.php";
include "includes/depts.php";

?>
<div id="content" class="content">
<h2><?=$admin_title;?></h2>
<?
$q = mysql_query("select * from ".$prefix."_redirects");
while ($arr_q = mysql_fetch_array($q))
	{
	?>
	<input name="pattern" /> <input name="url" /><br />
	<?
}
mysql_close();
include "includes/footer.php";
?>
