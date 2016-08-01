<?
function show_mess($message)
	{
	global $MSG, $lang;
	if ($lang == "")
		$lang = "RU";

	if ($MSG[$lang][$message] != "")
		return $MSG[$lang][$message];
	else
		return "-- no entry on this language (".$lang."), add message for '".$message."' --";
}
setlocale(LC_ALL, 'en_US.UTF8');
function Translit($string) {
	$replace=array(
		"'"=>"",
		"`"=>"",
		"а"=>"a","А"=>"a",
		"б"=>"b","Б"=>"b",
		"в"=>"v","В"=>"v",
		"г"=>"g","Г"=>"g",
		"д"=>"d","Д"=>"d",
		"е"=>"e","Е"=>"e",
		"ж"=>"zh","Ж"=>"zh",
		"з"=>"z","З"=>"z",
		"и"=>"i","И"=>"i",
		"й"=>"y","Й"=>"y",
		"к"=>"k","К"=>"k",
		"л"=>"l","Л"=>"l",
		"м"=>"m","М"=>"m",
		"н"=>"n","Н"=>"n",
		"о"=>"o","О"=>"o",
		"п"=>"p","П"=>"p",
		"р"=>"r","Р"=>"r",
		"с"=>"s","С"=>"s",
		"т"=>"t","Т"=>"t",
		"у"=>"u","У"=>"u",
		"ф"=>"f","Ф"=>"f",
		"х"=>"h","Х"=>"h",
		"ц"=>"c","Ц"=>"c",
		"ч"=>"ch","Ч"=>"ch",
		"ш"=>"sh","Ш"=>"sh",
		"щ"=>"sch","Щ"=>"sch",
		"ъ"=>"","Ъ"=>"",
		"ы"=>"y","Ы"=>"y",
		"ь"=>"","Ь"=>"",
		"э"=>"e","Э"=>"e",
		"ю"=>"yu","Ю"=>"yu",
		"я"=>"ya","Я"=>"ya",
		"і"=>"i","І"=>"i",
		"ї"=>"yi","Ї"=>"yi",
		"є"=>"e","Є"=>"e"
	);
	return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}
function dateconv($lang_id, $date_given, $format_id)
	{
  $month=array("-","января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
  $month1=array("-","январь","февраль","март","апрель","май","июнь","июль","август","сентябрь","октябрь","ноябрь","декабрь");
  if ($txt_format == 1)
		{
		echo substr($date_given,8,2)." ".$month[intval(substr($date_given,5,2))]." ".substr($date_given,0,4)." г.";
	}
  else
  	{
  	if (substr($date_given,0,4) == "0000")
	    {
    	echo " ";
  	}
  	else
	    {
    	if (substr($date_given,5,2) == "00")
	      {
      	echo substr($date_given,0,4);
    	}
    	else
	      {
      	if (substr($date_given,8,2) == "00")
	        {
        	echo $month1[intval(substr($date_given,5,2))]." ".substr($date_given,0,4);
      	}
      	else
	        {
      	echo substr($date_given,8,2).".".substr($date_given,5,2).".".substr($date_given,0,4);
      	}
    	}
  	}
	}
}
?>
