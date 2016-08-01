<?
include "includes/connection.php";
include "includes/main_init.php";
include "includes/main_func.php";
include "includes/messages.php";
include "secure.php";

$pg_title = show_mess("TTLConfigPage");

include "includes/header.php";

$do_sql = $_POST["do_sql"];
?>
<blockquote>
<h4><tt>Здесь можно выполнить произвольную SQL-команду (будьте внимательны!!!)</tt></h4>
<!-- ***************************************************************************** -->
<form name="sql" action="do_sql.php" method="post">
Введите команду (таблицы начинаются с "<?=$prefix;?>_"):
<br />
<textarea name="do_sql" cols="100" rows="20"><?=stripslashes($do_sql);?></textarea>
<br />
<button>выполнить</button>
</form>
<!-- ***************************************************************************** -->
<?
if (@$do_sql != NULL && (substr(@$do_sql,0,6) == "select"||substr(@$do_sql,0,4) == "show"||substr(@$do_sql,0,6) == "update"||substr(@$do_sql,0,5) == "alter"||substr(@$do_sql,0,6) == "insert"||substr(@$do_sql,0,6) == "create"||substr(@$do_sql,0,6) == "delete"||substr(@$do_sql,0,4) == "drop"||substr(@$do_sql,0,4) == "desc"))
{
$do_do_sql = mysql_query(stripslashes(@$do_sql)) or die(mysql_error());
$m = mysql_num_rows($do_do_sql);
$n = mysql_num_fields($do_do_sql);
?>
<p>
Результат:
<table border="1" cellpadding="2" cellspacing="2" class="table">
<?
	print "<tr>";
  for($j=0;$j<$n; $j++)
  {
  print "<td><b>".mysql_field_name($do_do_sql,$j)."</b></td>";
  }
	print "</tr>";
  for($i=0; $i<$m; $i++)
  {
  $arr_sql = mysql_fetch_array($do_do_sql);
	print "<tr>";
    for($j=0;$j<$n; $j++)
    {
    if ($arr_sql[$j] != "")
      {
      print "<td>".$arr_sql[$j]."</td>";
	    }
	  else
	    {
      print "<td>&nbsp;</td>";
	  	}
	  }
	print "</tr>";
  }
}
?>
</table>
</blockquote>
</body>
</html>
