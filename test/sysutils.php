<?php
function textutf8($value)
{
	// return iconv("TIS-620", "UTF-8", $value);
	return iconv('TIS-620', 'UTF-8//TRANSLIT//IGNORE', $value);
}

function texttis620($value)
{
	return iconv("UTF-8", "TIS-620//TRANSLIT//IGNORE", $value);
}

function decodemonthyear($value, &$amonth, &$ayear)
{
	$amonth = 0;
	$ayear = 0;
	$value = trim($value);
	if ($value <> 0)
	{
		$i = strpos($value, '-');
		if ($i > 0)
		{
			$amonth = substr($value, 0, $i);
			$ayear = substr($value, $i + 1, strlen($value) - ($i + 1));
		}
	}
}

function dateengtotha($value)
{
	date("Y", strtotime($value));
	date("d", strtotime($value)). ' ';
	monthstr(date("m", strtotime($value))).' ';
}

function monthstr($monthno)
{
	switch ($monthno)
	{
		case 0 : return ""; break;	
		case 1 : return "มกราคม"; break;	
		case 2 : return "กุมภาพันธ์"; break;	
		case 3 : return "มีนาคม"; break;	
		case 4 : return "เมษายน"; break;	
		case 5 : return "พฤษภาคม"; break;	
		case 6 : return "มิถุนายน"; break;	
		case 7 : return "กรกฎาคม"; break;	
		case 8 : return "สิงหาคม"; break;	
		case 9 : return "กันยายน"; break;	
		case 10 : return "ตุลาคม"; break;	
		case 11 : return "พฤศจิกายน"; break;	
		case 12 : return "ธันวาคม"; break;	
	}
}
?>