<div class="breadcrumbs" style="background-color: <?=$properties["back_color"];?>; color: <?=$properties["text_color"];?>;">
<?
$pid = $page_id;
if ($fields["self_include"] == 1)
	$pth = $fields["delimiter"].$allpages[$pid];
while ($allparents[$pid] > 1)
	{
	$pth = $fields["delimiter"]."<a style=\"color: ".$properties["text_color"].";\" href=\"/".$allurls[$allparents[$pid]]."\">".$allpages[$allparents[$pid]]."</a>".$pth;
	$pid = $allparents[$pid];
}
$pth = "<a style=\"color: ".$properties["text_color"].";\" href=\"/\">Главная</a>".$pth;
print $pth;
?>
</div>
