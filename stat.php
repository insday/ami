<?
include "includes/connection.php";
include "includes/main_init.php";
include "includes/main_func.php";
include "includes/messages.php";
include "secure.php";

$admin_title = show_mess("TTLStat");

include "includes/header.php";
include "includes/top.php";
include "includes/sidebar.php";
include "includes/depts.php";

?>
<div id="content" class="content">
<h2><?=$admin_title;?></h2>
<table class="stat">
	<tr>
		<th>Дата/Время</th>
		<th>Отправлено на</th>
		<th>Сообщение</th>
	</tr>
<?
$slct = mysql_query("select * from ".$prefix."_orders order by date desc") or die("NO ORDERS TABLE");
while ($arr = mysql_fetch_array($slct))
	{
	?>
	<tr>
		<td style="width: 90px;"><b><?=$arr["date"];?></b></td>
		<td><?=$arr["email"];?></td>
		<td><?=nl2br($arr["message"]);?></td>
	</tr>
	<?
}
?>
</table>
<?
mysql_close();
include "includes/footer.php";
?>
