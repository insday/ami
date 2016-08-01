<?
@session_start();
$vars_query = "select * from ".$prefix."_variables";
$vars = mysql_query($vars_query) or header("Location: /admin/install/index.php?ref=notables");

while ($arr_vars = mysql_fetch_array($vars))
	{
	$var_name = $arr_vars["var_name"];
	$$var_name = $arr_vars["var_value"];
}
if (@$lang == "")
	$lang = "RU";

if (@$lang_id == "" && @$_GET["lang_id"] != "")
	$lang_id = $_GET["lang_id"];

if (@$lang_id == "")
	{
	if (@$_SESSION["cms_lang_id"] != "") 
		$lang_id = $_SESSION["cms_lang_id"];
	else
		{
		$lang_id = 1;
		$_SESSION["cms_lang_id"] = 1;
	}
}
else
	$_SESSION["cms_lang_id"] = $lang_id;

$langs_q = "select * from ".$prefix."_langs";
$langs = mysql_query($langs_q) or die("NO LANGS TABLE");
while ($arr_langs = mysql_fetch_array($langs))
	$alllangs[$arr_langs["lang_id"]] = $arr_langs["lang_short"];

$langs_q = "select * from ".$prefix."_langs where lang_id = ".$lang_id;
$langs = mysql_query($langs_q) or die("NO LANGS TABLE");
if ($arr_langs = mysql_fetch_array($langs))
	$lang_short = $arr_langs["lang_short"];

/*
$alldepts_query = "select dt.dept_type, d.dept_id, dn.dept_name, dn.dept_ename from ".$prefix."_dept_types dt
										left join ".$prefix."_depts d on d.dtype_id = dt.dtype_id
										left join ".$prefix."_dept_names dn on dn.dept_id = d.dept_id where lang_id = ".$lang_id;
$alldepts = mysql_query($alldepts_query) or header("Location: /admin/install/index.php?ref=notables");
while ($arr_alldepts = mysql_fetch_array($alldepts))
	{
	if ($arr_alldepts["dept_id"] == 1)
		$main_dept_name = $arr_alldepts["dept_name"];
	$d_name = $arr_alldepts["dept_type"]."_dept";
	$d1_name = $arr_alldepts["dept_type"]."_dept_id";
	$d2_name = $arr_alldepts["dept_type"]."_edept";
	$$d_name = $arr_alldepts["dept_name"];
	$$d1_name = $arr_alldepts["dept_id"];
	$$d2_name = $arr_alldepts["dept_ename"];
}

$words = array();
$tw = mysql_query("select * from ".$prefix."_words where lang_id = ".$lang_id) or header("Location: /admin/install/index.php?ref=notables");
while ($row = mysql_fetch_array($tw))
	{
	$words[$row["word_id"]] = $row["word"];
}
*/
function t_word($word_id)
	{
	global $words;

	if ($words[$word_id] != "")	
		return $words[$word_id];
	else
		return "-- no entry --";
}
function error_show($big_error_text, $error_text, $after_text)
	{
  global $CMSShowMySQLErrors;
  
  $header = "From:sergey.taran@allspb.ru\nX-Mailer: PHP Auto-Mailer\nContent-Type: text/plain"; 
	$message = "Error ".$big_error_text."
	Error text - ".$error_text."
	After text - ".$after_text."
	File - ".$_SERVER["PHP_SELF"]."
	URI - ".$_SERVER["REQUEST_URI"]."
	User - ".$_SERVER["REMOTE_ADDR"]."
	Agent - ".$_SERVER["HTTP_USER_AGENT"]."
	FILE - ".__FILE__."
	LINE - ".__LINE__."
	POST VARIABLES:
	";
	foreach ($_POST as $key => $var)
		{
		$message .= $key." => ".$var."
		";
	}
	//mail("sergey.taran@allspb.ru", "ERRROR!!!", $message, $header) or die("Mailing failed");
	if ($CMSShowMySQLErrors == 1)
		die("<html><body><p style=\"font-family: Arial; font-size: 12px;\"><b>".$big_error_text.":</b> \"".$error_text." (".$after_text.")\"</body></html>");
	else
		die("<html><body><p style=\"font-family: Arial; font-size: 12px;\"><b>".$big_error_text."</b></p></body></html>");
}
function mail_it($id, $from, $to)
	{
	global $user_login, $user_password, $user_email, $user_name, $date1, $date1, $any_text;
	$query = "select * from messages where message_type_id = ".$id;
	$mi = mysql_query($query) or header("Location: /admin/install/index.php?ref=notables");
	if (@$row = mysql_fetch_array($mi))	
		{
		$subject = $row["subject"];
		//$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($subj, "w","k")).'?=';
		$message = $row["message"];
		//$message = "<html><body><font face=\"Arial, Verdana, Tahoma, Serif\">".$message."</font></body></html>";
		$message = str_replace("%user_login%",$user_login,$message);
		$message = str_replace("%user_password%",$user_password,$message);
		$message = str_replace("%user_email%",$user_email,$message);
		$message = str_replace("%user_name%",$user_name,$message);
		$message = str_replace("%date1%",$date1,$message);
		$message = str_replace("%date2%",$date2,$message);
		$message = str_replace("%any_text%",$any_text,$message);
		$message = str_replace("\r\n","<br>",htmlspecialchars($message));
		
		include("Mail.php");

		if ($from == "")
			$from = "sergey.taran@allspb.ru";

		$headers = array(
    'From'    => $from,
    'Subject' => $subject,
		);

		mail($to, $subject, $message, $headers) or die("Mailing failed");
		//mail("taran@itstar.ru", "Mailing Report", "Subj =  ".$subject.", mess = ".$message, $headers) or die("Mailing failed");
	}
	else
		return "-- no entry --";
}
function send_message ($subj, $message, $email) 
	{ 
	//формируем заголовок письма 
	if ($email == NULL||$email == "")
		{
		$email = "serguei.taran@allspb.ru";
		$message .= "\n\nПроверить работоспособность!!!";
	}
	$header= "From:report@stpark.ru\nX-Mailer: PHP Auto-Mailer\nContent-Type: text/plain;\n charset=koi8-r"; 

	// перекодируем данные в koi-8  из кодировки win-1251 

	$subj    = convert_cyr_string($subj,"w","k"); 
	$message = convert_cyr_string($message,"w","k"); 
	$header  = convert_cyr_string($header ,"w","k"); 

	// отправляем почту стандартной функцией 
	mail("$email", "$subj", "$message", "$header"); 
} 
?>
