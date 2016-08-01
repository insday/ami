<?
session_start();
require_once "includes/connection.php";

if (mysql_query("select * from ".$prefix."_workflow"))
	{
	$user_select = mysql_query("select * from ".$prefix."_workflow where user_id = '".$_SESSION["w_login_user_id"]."' and user_login = '".$_SESSION["w_login"]."' and user_pass = '".$_SESSION["w_password"]."' and user_enabled = 1") or header("Location: install/index.php?ref=notables&t=1");
	$good_entry = mysql_num_rows($user_select);
}
if (($_SESSION["s_login"] != $log || $_SESSION["s_password"] != $pass) && $good_entry == 0)
	{
	$_SESSION["index_msg"] = $MSG[$lang]["MsgSessionFailed"];
	header("Location: /admin/index.php");
}
else
	{
	if ($good_entry != 0)
		{
		if ($_REQUEST["dept_id"] != "")
			$entry_dept_id = $_REQUEST["dept_id"];
		else
			{
			$module_query = mysql_query("select * from ".$prefix."_depts d left join ".$prefix."_dept_types dt on dt.dtype_id = d.dtype_id where dept_type = '".str_replace("/admin/","",str_replace(".php","",$_SERVER["PHP_SELF"]))."'") or header("Location: /admin/install/index.php?ref=notables&t=2");
			if ($arr_module_id = mysql_fetch_array($module_query))
				$entry_dept_id = $arr_module_id["dept_id"];
			else
				{
				$module_query = mysql_query("select * from ".$prefix."_depts d left join ".$prefix."_dept_types dt on dt.dtype_id = d.dtype_id where dept_type = '".$w_dept_type."'") or die("Hands up! No enter!");
				if ($arr_module_id = mysql_fetch_array($module_query))
					$entry_dept_id = $arr_module_id["dept_id"];
				else
					$entry_dept_id = 1;
			}
		}
		$entry_select = mysql_query("select * from ".$prefix."_wf_rights where user_id = '".$_SESSION["w_login_user_id"]."' and (dept_id in (select parent_id from ".$prefix."_depts where dept_id = ".$entry_dept_id.") or dept_id = ".$entry_dept_id.")") or header("Location: /admin/install/index.php?ref=notables&t=3");
		if (mysql_num_rows($entry_select) == 0)
			{
			$entry_select = mysql_query("select wf.*, dt.file_inc from ".$prefix."_wf_rights wf left join ".$prefix."_depts d on d.dept_id = wf.dept_id left join ".$prefix."_dept_types dt on dt.dtype_id = d.dtype_id where user_id = '".$_SESSION["w_login_user_id"]."'") or header("Location: /admin/install/index.php?ref=notables&t=4");
			if ($arr_entry = mysql_fetch_array($entry_select))
				{
				$_SESSION["sys_msg"] = $MSG[$lang]["MsgNoMDeptRights"];
				if ($arr_entry["file_inc"] != "")
					header("Location: ".$arr_entry["file_inc"]);
				else
					header("Location: /admin/main.php?dept_id=".$arr_entry["dept_id"]);
			}
			else
				{
				$_SESSION["index_msg"] = $MSG[$lang]["MsgNoDeptRights"];
				header("Location: /admin/index.php");
			}
			break;
		}
		else
			{
			$user_id = $_SESSION["w_login_user_id"];
			$_SESSION['IsAuthorized'] = true;
		}
	}
}
?>
