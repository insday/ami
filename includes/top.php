<?
if ($_SESSION["s_login"] != "")
	$user = $_SESSION["s_login"];
else
	$user = $_SESSION["w_login"];
?>
<div class="darkgrey top group">
	<div class="left span_1_of_2 leftalign group">
		<div class="left sitename"><?=$_SERVER["HTTP_HOST"];?></div>
		<div class="left lang" onClick="$('.alllangs').fadeIn(300);">
			<div class="curlang"><?=$lang_short;?></div>
			<div class="alllangs">
				<?
				$langs_q = "select * from ".$prefix."_langs order by lang_id";
				$langs = mysql_query($langs_q) or die("NO LANGS TABLE");
				while ($arr_langs = mysql_fetch_array($langs))
					{
					?>
					<div class="onelang" onClick="document.location = '<?=$_SERVER["REQUEST_URI"];?><?=(strpos($_SERVER["REQUEST_URI"], "?") !== false?"&":"?");?>lang_id=<?=$arr_langs["lang_id"];?>'"><?=$arr_langs["lang_short"];?></div>
					<?
				}
				?>
				<div class="onelang morelangs" onClick="document.location = 'config.php'">Еще</div>
			</div>
		</div>
	</div>
	<div class="left span_1_of_2 rightalign">
		<div class="userdata"><?=$user;?> <button onClick="alert('Профиль');">Администратор</button><img src="images/close_w.png" onClick="document.location='xp_main_exit.php'" /></div>
	</div>
</div>
