<?
header('Content-Type: text/html; charset=UTF-8');

// ini_set("display_errors", "1");
// ini_set("display_startup_errors", "1");
// ini_set("error_reporting", E_ALL);
?>
<html>
<head><title>^^ Webstellar 1.0 | <?=$admin_title;?> ^^</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="robots" content="noindex, nofollow">
	<link rel="stylesheet" type="text/css" href="/admin/webstellar.css">
	<script src="/admin/js/jquery-last.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/admin/js/jquery.tablednd_0_5.js" type="text/javascript" charset="utf-8"></script>
	<script src="/admin/js/jquery-ui.js" type="text/javascript" charset="utf-8"></script>
	<script src="/admin/js/jquery.nicescroll.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/admin/js/jquery.selection.js" type="text/javascript" charset="utf-8"></script>
	<script src="/admin/js/bootstrap-colorpicker.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/admin/js/ajaxupload.3.5.js" type="text/javascript" charset="utf-8"></script>
	<script>
		$(document).ready(function() { 
			$(".depts").niceScroll({cursorcolor:"#9A9A9A", cursoropacitymin: "0.6", cursorwidth: 6, cursorborder: "none", cursorborderradius: 0});
		});
		MSG = new Array();
		var lng = "<?=strtoupper($lang_short);?>";
	<?
	foreach ($MSG as $GNAL => $MASS)
		{
		?>
		MSG['<?=$GNAL;?>'] = new Array();
		<?
		foreach ($MASS as $KEY => $VAL)
			{
			?>
			MSG['<?=$GNAL;?>']['<?=$KEY;?>'] = '<?=$VAL;?>';
			<?
		}
	}
	?>
	</script>
	<script src="/admin/js/js.js" type="text/javascript" charset="utf-8"></script>
</head>
<body topMargin="0" leftMargin="0"<?if ($admin_focus != "") {?> onLoad="<?=$admin_focus;?>"<?}?>>
