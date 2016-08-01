<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();

ini_set("display_errors","1");
ini_set("error_reporting", E_ALL);

require_once "../includes/messages.php";
require_once "../includes/main_func.php";
switch (@$_GET["ref"])
	{
	case "nosql":
		require_once "../includes/db.php";
		$meta = explode("|", $str);
?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?=show_mess("TTLInstallation");?></title>
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Pragma" content="no-cache"> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" media="screen" type="text/css" href="/admin/webstellar.css">
</head>
<body>
	<table class="table" cellpadding="0" cellspacing="0" border="0" width="100%" id="main_table">
		<tr>
		<td align="center">
		<p />
		<?=show_mess("MsgCheckDBParams");?>
		<p />
		<form name="chkDBParams" method="POST" action="?ref=upd">
		<table cellpadding="3" cellspacing="0" border="0">
			<tr>
				<td align="right"><?=show_mess("TTLDBPrefix");?>:</td>
				<td align="left"><input size="30" name="dbprefix" value="<?=$meta[4];?>"></td>
			</tr>
			<tr>
				<td align="right"><?=show_mess("TTLDBServer");?>:</td>
				<td align="left"><input size="30" name="dbserver" value="<?=$meta[0];?>"></td>
			</tr>
			<tr>
				<td align="right"><?=show_mess("TTLDBName");?>:</td>
				<td align="left"><input size="30" name="dbname" value="<?=$meta[3];?>"></td>
			</tr>
			<tr>
				<td align="right"><?=show_mess("TTLDBUser");?>:</td>
				<td align="left"><input size="30" name="dbuser" value="<?=$meta[1];?>"></td>
			</tr>
			<tr>
				<td align="right"><?=show_mess("TTLDBPassword");?>:</td>
				<td align="left"><input type="password" size="30" name="dbpassword" value="<?=$meta[2];?>"></td>
			</tr>
			<tr>
				<td align="center" colspan="2"><input type="submit" name="submit" value="<?=show_mess("ButDBParamsSave");?>"></td>
			</tr>
		</table>
		</form>
		<p />
		</td>
	</tr>
</table>
</body>
</html>
		<?=show_mess("MsgDescrDBParams");?>
		<?
	break;
	case "upd":
		$h = $_POST["dbserver"];
		$u = $_POST["dbuser"];
		$p = $_POST["dbpassword"];
		$d = $_POST["dbname"];
		$prefix = $_POST["dbprefix"];

		if (@$file = fopen("db.php","w+"))
			{
			$char = "|";
				
			fputs($file, "<? ");
			fputs($file, "\$str = \"");
			fputs($file, $h);
			fputs($file, $char);
			fputs($file, $u);
			fputs($file, $char);
			fputs($file, $p);
			fputs($file, $char);
			fputs($file, $d);
			fputs($file, "\";");
			fputs($file, "?>");
			
			fclose($file);
		
			header("Location: ?ref=notables");
		}
		else
			{
			?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?=show_mess("TTLInstallation");?></title>
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Pragma" content="no-cache"> 
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<link rel="stylesheet" media="screen" type="text/css" href="/admin/webstellar.css">
	<script src="/admin/js/jquery-last.min.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
	<table cellpadding="0" cellspacing="0" border="0" width="100%" id="main_table">
		<tr>
		<td align="center">
		<p />
		<?=show_mess("MsgCheckDBParams");?>
			<p />
			<span class="redbold"><b><?=show_mess("MsgSaveFail");?></b></span>
			<p />
			<form name="chkDBParams" method="POST" action="xp_save_db.php">
			<table cellpadding="3" cellspacing="0" border="0">
				<tr>
					<td align="right"><?=show_mess("TTLDBPrefix");?>:</td>
					<td align="left"><input size="30" name="dbprefix" value="<?=$prefix;?>"></td>
				</tr>
				<tr>
					<td align="right"><?=show_mess("TTLDBServer");?>:</td>
					<td align="left"><input size="30" name="dbserver" value="<?=$h;?>"></td>
				</tr>
				<tr>
					<td align="right"><?=show_mess("TTLDBName");?>:</td>
					<td align="left"><input size="30" name="dbname" value="<?=$d;?>"></td>
				</tr>
				<tr>
					<td align="right"><?=show_mess("TTLDBUser");?>:</td>
					<td align="left"><input size="30" name="dbuser" value="<?=$u;?>"></td>
				</tr>
				<tr>
					<td align="right"><?=show_mess("TTLDBPassword");?>:</td>
					<td align="left"><input size="30" name="dbpassword" value="<?=$p;?>"></td>
				</tr>
				<tr>
					<td align="center" colspan="2"><input type="submit" name="savetofile" value="<?=show_mess("ButDBSaveToFile");?>"></td>
				</tr>
				<tr>
					<td align="center" colspan="2"><input type="button" name="tryagain" value="<?=show_mess("ButTryAgain");?>"  onClick="this.form.action='?ref=upd'; this.form.submit();"></td>
				</tr>
				<tr>
					<td align="center" colspan="2"><input type="button" name="try" value="<?=show_mess("ButFileWritten");?>"  onClick="this.form.action='?ref=notables'; this.form.submit();"></td>
				</tr>
			</table>
			</form>
			<p />
			<?=show_mess("MsgDescrDBParams");?>
		</td>
	</tr>
</table>
</body>
</html>
			<?
		}
	break;
	case "notables":
		require_once "../includes/connection.php";
		$tablesxml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
		<roachcms ver=\"1.5\">
			<tables>
				<table>
					<tablename>langs</tablename>
					<fields>
						<field>
							<fieldname>lang_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>1</ai>
							<notnull>0</notnull>,
							<key>primary</key>,
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>lang_order</fieldname>,
							<fieldtype>int(11)</fieldtype>,
							<ai>0</ai>,
							<notnull>0</notnull>,
							<defaultvalue>1</defaultvalue>,
						</field>
						<field>
							<fieldname>lang_short</fieldname>,
							<fieldtype>varchar(255)</fieldtype>,
							<ai>0</ai>,
							<notnull>0</notnull>,
							<defaultvalue></defaultvalue>,
						</field>
					</fields>
					<inserts>
						<insert>
							<lang_id>1</lang_id>
							<lang_order>1</lang_order>
							<lang_short>RU</lang_short>
						</insert>
					</inserts>
				</table>
				<table>
					<tablename>lang_names</tablename>
					<fields>
						<field>
							<fieldname>lang_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>lang_name</fieldname>,
							<fieldtype>varchar(100)</fieldtype>,
							<ai>0</ai>,
							<notnull>0</notnull>,
							<defaultvalue></defaultvalue>,
						</field>
						<field>
							<fieldname>name_lang_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue></defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>name_lang_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>lang_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>lang_id</fieldname>
								<fieldname>name_lang_id</fieldname>
							</fieldnames>
							<indextype>UNIQUE</indextype>
						</index>
					</indexes>
					<inserts>
						<insert>
							<lang_id>1</lang_id>
							<lang_name>Русский</lang_name>
							<name_lang_id>1</name_lang_id>
						</insert>
						<insert>
							<lang_id>1</lang_id>
							<lang_name>Russian</lang_name>
							<name_lang_id>2</name_lang_id>
						</insert>
					</inserts>
				</table>
				<table>
					<tablename>websites</tablename>
					<fields>
						<field>
							<fieldname>website_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>1</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>website_name</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>NEW WEBSITE</defaultvalue>
						</field>
						<field>
							<fieldname>website_url</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>insday.ru</defaultvalue>
						</field>
						<field>
							<fieldname>website_style</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>default</defaultvalue>
						</field>
						<field>
							<fieldname>client_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>website_order</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>website_on</fieldname>
							<fieldtype>tinyint(1)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue></defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>client_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
					</indexes>
					<inserts>
						<insert>
							<website_id>1</website_id>
							<website_name>New website</website_name>
							<website_url>insday.ru</website_url>
							<client_id>NULL</client_id>
							<website_order>1</website_order>
							<website_on>0</website_on>
						</insert>
					</inserts>
				</table>
				<table>
					<tablename>pages</tablename>
					<fields>
						<field>
							<fieldname>page_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>1</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>parent_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>website_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>page_order</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>page_on</fieldname>
							<fieldtype>tinyint(1)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue></defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>website_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
					</indexes>
					<inserts>
						<insert>
							<page_id>1</page_id>
							<website_id>1</website_id>
							<page_order>1</page_order>
							<page_on>0</page_on>
						</insert>
					</inserts>
				</table>
				<table>
					<tablename>pages_data</tablename>
					<fields>
						<field>
							<fieldname>page_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>1</defaultvalue>
						</field>
						<field>
							<fieldname>lang_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>1</defaultvalue>
						</field>
						<field>
							<fieldname>page_title</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>NEW PAGE</defaultvalue>
						</field>
						<field>
							<fieldname>page_url</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>new</defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>page_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>lang_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>page_id</fieldname>
								<fieldname>lang_id</fieldname>
							</fieldnames>
							<indextype>UNIQUE</indextype>
						</index>
					</indexes>
					<inserts>
						<insert>
							<page_id>1</page_id>
							<lang_id>1</lang_id>
							<page_title>Главная</page_title>
							<page_url>/</page_url>
						</insert>
						<insert>
							<page_id>1</page_id>
							<lang_id>2</lang_id>
							<page_title>Main</page_title>
							<page_url>/</page_url>
						</insert>
					</inserts>
				</table>
				<table>
					<tablename>blocks</tablename>
					<fields>
						<field>
							<fieldname>block_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>1</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>page_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>parent_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>module_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>block_order</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>
							<defaultvalue></defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>page_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>parent_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>module_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
					</indexes>
				</table>
				<table>
					<tablename>blocks_data</tablename>
					<fields>
						<field>
							<fieldname>block_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>block_title</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>NEW BLOCK</defaultvalue>
						</field>
						<field>
							<fieldname>lang_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>1</defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>block_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>lang_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>block_id</fieldname>
								<fieldname>lang_id</fieldname>
							</fieldnames>
							<indextype>UNIQUE</indextype>
						</index>
					</indexes>
				</table>
				<table>
					<tablename>blocks_properties</tablename>
					<fields>
						<field>
							<fieldname>b_property_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>1</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>block_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull></notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>b_property_name</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull></notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>b_property_value</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull></notnull>
							<defaultvalue></defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>block_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>block_id</fieldname>
								<fieldname>b_property_name</fieldname>
							</fieldnames>
							<indextype>UNIQUE</indextype>
						</index>
					</indexes>
				</table>
				<table>
					<tablename>element_types</tablename>
					<fields>
						<field>
							<fieldname>e_type_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>1</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>e_type_name</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
					</fields>
					<inserts>
						<insert>
							<e_type_id>1</e_type_id>
							<e_type_name>header</e_type_name>
						</insert>
						<insert>
							<e_type_id>2</e_type_id>
							<e_type_name>text</e_type_name>
						</insert>
						<insert>
							<e_type_id>3</e_type_id>
							<e_type_name>picture</e_type_name>
						</insert>
					</inserts>
				</table>
				<table>
					<tablename>elements</tablename>
					<fields>
						<field>
							<fieldname>element_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>1</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>block_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>element_symbolic</fieldname>
							<fieldtype>varchar(50)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>element_type</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>element_format</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>element_properties</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>element_order</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>
							<defaultvalue></defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>block_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
					</indexes>
				</table>
				<table>
					<tablename>elements_data</tablename>
					<fields>
						<field>
							<fieldname>element_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>element_title</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>NEW BLOCK</defaultvalue>
						</field>
						<field>
							<fieldname>lang_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>1</defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>element_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>lang_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>element_id</fieldname>
								<fieldname>lang_id</fieldname>
							</fieldnames>
							<indextype>UNIQUE</indextype>
						</index>
					</indexes>
				</table>
				<table>
					<tablename>secure</tablename>
					<fields>
						<field>
							<fieldname>ip</fieldname>
							<fieldtype>char(30)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>dt</fieldname>
							<fieldtype>datetime</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>0000-00-00</defaultvalue>
						</field>
					</fields>
				</table>
				<table>
					<tablename>real_data</tablename>
					<fields>
						<field>
							<fieldname>element_id</fieldname>
							<fieldtype>int</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>block_id</fieldname>
							<fieldtype>int</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>page_id</fieldname>
							<fieldtype>int</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>element_data</fieldname>
							<fieldtype>text</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>element_row</fieldname>
							<fieldtype>int</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>element_order</fieldname>
							<fieldtype>int</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>lang_id</fieldname>
							<fieldtype>int</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>1</defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>element_id</fieldname>
								<fieldname>element_row</fieldname>
								<fieldname>lang_id</fieldname>
							</fieldnames>
							<indextype>UNIQUE</indextype>
						</index>
					</indexes>
				</table>
				<table>
					<tablename>workflow</tablename>
					<fields>
						<field>
							<fieldname>user_id</fieldname>
							<fieldtype>int</fieldtype>
							<ai>1</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>user_name</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue>NULL</defaultvalue>
						</field>
						<field>
							<fieldname>user_login</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue>NULL</defaultvalue>
						</field>
						<field>
							<fieldname>user_pass</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue>NULL</defaultvalue>
						</field>
						<field>
							<fieldname>user_enabled</fieldname>
							<fieldtype>tinyint(1)</fieldtype>
							<ai>0</ai>
							<notnull>0</notnull>,
							<defaultvalue>NULL</defaultvalue>
						</field>
					</fields>
				</table>
				<table>
					<tablename>wf_rights</tablename>
					<fields>
						<field>
							<fieldname>user_id</fieldname>
							<fieldtype>int</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>dept_id</fieldname>
							<fieldtype>int</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
					</fields>
				</table>
				<table>
					<tablename>words</tablename>
					<fields>
						<field>
							<fieldname>word_id</fieldname>
							<fieldtype>int</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>lang_id</fieldname>
							<fieldtype>int</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>word</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>lang_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>word_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
					</indexes>
				</table>
				<table>
					<tablename>meta_words</tablename>
					<fields>
						<field>
							<fieldname>meta_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>1</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>page_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>lang_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>meta_title</fieldname>
							<fieldtype>text</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>meta_description</fieldname>
							<fieldtype>text</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>meta_keywords</fieldname>
							<fieldtype>text</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>meta_vip</fieldname>
							<fieldtype>tinyint(1)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>1</defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>page_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>lang_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>meta_title</fieldname>
							</fieldnames>
							<indextype>FULLTEXT</indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>meta_description</fieldname>
							</fieldnames>
							<indextype>FULLTEXT</indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>meta_keywords</fieldname>
							</fieldnames>
							<indextype>FULLTEXT</indextype>
						</index>
					</indexes>
				</table>
				<table>
					<tablename>variables</tablename>
					<fields>
						<field>
							<fieldname>var_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>1</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>var_name</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>var_value</fieldname>
							<fieldtype>text</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>var_descr</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>var_type</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>0</defaultvalue>
						</field>
						<field>
							<fieldname>dtype_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>1</defaultvalue>
						</field>
						<field>
							<fieldname>ronly</fieldname>
							<fieldtype>tinyint(1)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>1</defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>dtype_id</fieldname>
							</fieldnames>
							<indextype></indextype>
						</index>
						<index>
							<fieldnames>
								<fieldname>var_name</fieldname>
							</fieldnames>
							<indextype>UNIQUE</indextype>
						</index>
					</indexes>
					<inserts>
						<insert>
							<var_id>1</var_id>
							<var_name>lang</var_name>
							<var_value>RU</var_value>
							<var_descr>VarInterfaceLang</var_descr>
							<var_type>0</var_type>
							<dtype_id>1</dtype_id>
							<ronly>0</ronly>
						</insert>
						<insert>
							<var_id>2</var_id>
							<var_name>CMSVersion</var_name>
							<var_value>2.0</var_value>
							<var_descr>VarCMSVersion</var_descr>
							<var_type>0</var_type>
							<dtype_id>1</dtype_id>
							<ronly>1</ronly>
						</insert>
						<insert>
							<var_id>3</var_id>
							<var_name>CMSWebsiteName</var_name>
							<var_value>Наименование веб-сайта</var_value>
							<var_descr>VarCMSWebsiteName</var_descr>
							<var_type>0</var_type>
							<dtype_id>1</dtype_id>
							<ronly>0</ronly>
						</insert>
						<insert>
							<var_id>4</var_id>
							<var_name>CMSMainEmail</var_name>
							<var_value>hello@insday.ru</var_value>
							<var_descr>VarCMSMainEmail</var_descr>
							<var_type>0</var_type>
							<dtype_id>1</dtype_id>
							<ronly>0</ronly>
						</insert>
						<insert>
							<var_id>5</var_id>
							<var_name>CMSMainPhone</var_name>
							<var_value>+7 812 980 04 48</var_value>
							<var_descr>VarCMSMainPhone</var_descr>
							<var_type>0</var_type>
							<dtype_id>1</dtype_id>
							<ronly>0</ronly>
						</insert>
						<insert>
							<var_id>6</var_id>
							<var_name>CMSVKLink</var_name>
							<var_value>https://vk.com</var_value>
							<var_descr>VarCMSVKLink</var_descr>
							<var_type>0</var_type>
							<dtype_id>1</dtype_id>
							<ronly>0</ronly>
						</insert>
						<insert>
							<var_id>7</var_id>
							<var_name>CMSFBLink</var_name>
							<var_value>https://www.facebook.com</var_value>
							<var_descr>VarCMSFBLink</var_descr>
							<var_type>0</var_type>
							<dtype_id>1</dtype_id>
							<ronly>0</ronly>
						</insert>
						<insert>
							<var_id>8</var_id>
							<var_name>CMSTWLink</var_name>
							<var_value>https://twitter.com</var_value>
							<var_descr>VarCMSTWLink</var_descr>
							<var_type>0</var_type>
							<dtype_id>1</dtype_id>
							<ronly>0</ronly>
						</insert>
					</inserts>
				</table>
				<table>
					<tablename>messages</tablename>
					<fields>
						<field>
							<fieldname>message_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>1</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>message_name</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>message_value</fieldname>
							<fieldtype>varchar(255)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue></defaultvalue>
						</field>
						<field>
							<fieldname>lang_id</fieldname>
							<fieldtype>int(11)</fieldtype>
							<ai>0</ai>
							<notnull>1</notnull>
							<defaultvalue>1</defaultvalue>
						</field>
					</fields>
					<indexes>
						<index>
							<fieldnames>
								<fieldname>message_name</fieldname>
							</fieldnames>
							<indextype>UNIQUE</indextype>
						</index>
					</indexes>
				</table>
			</tables>	
		</roachcms>
		";
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($tablesxml);
		//print_r($xml);
		if ($xml)
			{
			foreach ($xml->tables->children() as $table)
				{
				$query = "
CREATE TABLE IF NOT EXISTS `".$prefix."_".$table->tablename."` (";
				$first = 1;
				foreach ($table->fields->children() as $field)
					{
					if ($first == 0)
						$query .= ", ";
					$first = 0;
					$query .= "`".$field->fieldname."` ".$field->fieldtype;
					if ($field->notnull == 1)
						$query .= " NOT NULL";
					if ($field->ai == 1)
						$query .= " AUTO_INCREMENT PRIMARY KEY";
				}
				$query .= ") DEFAULT CHARSET=UTF8";
				mysql_query($query) or die(mysql_error());
				//echo "<br>".$query;
				if ($table->indexes)
					{
					$query = "SHOW INDEX FROM ".$prefix."_".$table->tablename;
					$icount = mysql_query($query) or die(mysql_error());
					if (mysql_num_rows($icount) == 0)
						{
						foreach ($table->indexes->children() as $index)
							{
							$inames = array();
							$fnames = array();
							foreach ($index->fieldnames->children() as $fname)
								{
								$inames[] = $fname;
								$fnames[] = "`".$fname."`";
							}
							$query = "CREATE ".$index->indextype." INDEX `".implode("_", $inames)."` ON `".$prefix."_".$table->tablename."` (".implode(", ", $fnames).")";
							mysql_query($query) or die(mysql_error());
							//echo "<br>".$query;
						}
					}
				}
				if ($table->inserts)
					{
					foreach ($table->inserts->children() as $insert)
						{
						$fields = array();
						$values = array();
						foreach ($insert->children() as $ifield)
							{
							$fields[] = "`".$ifield->getName()."`";
							$values[] = "'".$ifield."'";
						}
						$query = "INSERT IGNORE INTO ".$prefix."_".$table->tablename." (".implode(", ", $fields).") VALUES (".implode(", ", $values).")";
						mysql_query($query) or die(mysql_error());
						//echo "<br>".$query;
					}
				}
			}
		}
		else
			{
			echo "Failed loading XML\n";
			foreach (libxml_get_errors() as $error)
				{
				echo "\n", $error->message, " in line ", $error->line;
			}
		}
		header("Location: ../index.php");
	break;
	default:
		$_SESSION["index_msg"] = $MSG["RU"]["MsgSystemReady"];
		header("Location: ../index.php");
	break;
}
?>
