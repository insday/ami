<?
include "includes/connection.php";
include "includes/main_init.php";
include "includes/main_func.php";
include "includes/messages.php";
include "secure.php";

$admin_title = show_mess("TTLConfig");

include "includes/header.php";
include "includes/top.php";
include "includes/sidebar.php";
include "includes/depts.php";

?>
<div id="content" class="content">
<h2><?=$admin_title;?></h2>

<h3>Работа с языками</h3>
<?
$langs_q = "select l.*, ln.lang_name from ".$prefix."_langs l left join ".$prefix."_lang_names ln on ln.lang_id = l.lang_id and name_lang_id = ".$lang_id." order by l.lang_id";
$langs = mysql_query($langs_q) or die("NO LANGS TABLE");

while ($arr_langs = mysql_fetch_array($langs))
	{
	?>
	<div id="lang<?=$arr_langs["lang_id"];?>" class="group">
		<div class="ttl"><?=$arr_langs["lang_name"];?></div>
		<div class="ttl"><?=$arr_langs["lang_short"];?></div>
		<div class="fld">
			<img onClick="edit_lang(<?=$arr_langs["lang_id"];?>);" src="images/edit.svg" width="25" height="25" border="0" alt="<?=show_mess("TTLEditLang");?>" />
		</div>
		<div class="fld">
			<img onClick="if (<?=$arr_langs["lang_id"];?> == 1) {alert('<?=show_mess("MsgNoRusLangDelete");?>')} else {if (confirm('<?=show_mess("ConfDelLang");?>')) {del_lang(<?=$arr_langs["lang_id"];?>)}};" src="images/delete.svg" width="24" height="24" border="0" alt="<?=show_mess("TTLDeleteLang");?>" />
		</div>
	</div>
	<?
}
?>
<div id="addlang" class="group">
	<div class="ttl"><input name="lang_name" id="lang_name" /></div>
	<div class="ttl"><input name="lang_short" id="lang_short" /></div>
	<div class="fld" align="center"><button onClick="add_lang($('#lang_name').val(), $('#lang_short').val());">+</button></div>
</div>
<?
mysql_close();
include "includes/footer.php";
?>
