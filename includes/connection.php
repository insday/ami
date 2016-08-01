<?
require_once "db.php";

$meta = explode("|", $str);

$log = "admin";
$pass = "wsadmintellar15";

mysql_connect($meta[0], $meta[1], $meta[2]) or header("Location: /admin/install/index.php?ref=nosql");
mysql_select_db($meta[3]) or header("Location: /admin/install/index.php?ref=nosql");

$prefix = $meta[4];
$_ROOT_ = "/";

mysql_query("set character_set_client ='utf8'");
mysql_query("set character_set_results ='utf8'");
mysql_query("set collation_connection ='utf8_general_ci'");
?>
