<?php
$h = $_POST["dbserver"];
$u = $_POST["dbuser"];
$p = $_POST["dbpassword"];
$d = $_POST["dbname"];
$prefix = $_POST["dbprefix"];

$char = "|";
header('Content-Type: text/x-delimtext; name="db.php"'); 
header('Content-disposition: attachment; filename=db.php'); 
echo "<? \$str = \"".$h.$char.$u.$char.$p.$char.$d.$char.$prefix."\";?>"; 
?>