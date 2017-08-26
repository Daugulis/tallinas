<?php

function sub_str($string, $value, $delim = "<!---")
{
	$pos = strpos( $string, $delim . "$value:"); 
	if ($pos === false)
	{
		return false;
	}
	$pos += strlen($delim . "$value:");
	$pos2 = $pos + 1;
	while (	
	((ord($string[$pos2]) >= ord('A')) && (ord($string[$pos2]) <= ord('Z'))) || 
	((ord($string[$pos2]) >= ord('a')) && (ord($string[$pos2]) <= ord('z'))) || 
	((ord($string[$pos2]) >= ord('0')) && (ord($string[$pos2]) <= ord('9'))) || 
	($string[$pos2] == "_"))
	{
		++$pos2;
	}
	return substr($string, $pos, $pos2 - $pos);
}

function loopTemplate($string, $valuename, $arr)
{
	global $parser;
	$res = "";
	$r_array = array();
	$ostring = $string;
	$maxiter = 10000;
	$iter = 0;
	
	while(($val = sub_str($string, $valuename, "{")) && ($iter < $maxiter))
	{
		array_push($r_array, $val);
		$string = str_replace("{" . $valuename. ":" . $val . "}", "", $string);
		++$iter;
	}
	
	if ($iter == $maxiter)
	{
		echo "loopTemplate error";
	}
	$old_valuename = $valuename;
	$valuename = str_replace("<?php echo ", "\".", $valuename);
	$valuename = str_replace("; ?>", ".\"", $valuename);
	if (!isset($parser['ck_parser']))
	{
		$parser['ck_parser'] = 0;
	}
	$parser['ck_parser'] ++;
	$res = "<?php foreach(\$parser[\"$valuename\"] as \$_key_".$parser['ck_parser']."=>\$_var_".$parser['ck_parser'].")\r\n{\r\n ?>";
	foreach ($r_array as $var)
	{
		$ovar = $var;
		//echo "{" . $old_valuename . ":" . $ovar ."}"."<br>";
		$ss = str_replace("{" . $old_valuename . ":" . $ovar ."}", "<?php echo \$parser[\"$valuename\"][\$_key_".$parser['ck_parser']."][\"$ovar\"]; ?>", $ostring);
		$ostring = $ss;
	}
	$res .= $ss;
	$res .= "<?php \r\n}\r\n ?>";
	return $res;
}

function parseSTR($string)
{
	global $parser;
  $pos = 0;
  $start = 0;
  $iter = 0;
  $maxiter = 5000;
  while (( ($pos = strpos( $string, '<!---', $start )) !== FALSE ) && ($iter < $maxiter))
  {
	++$iter;
  	if(($string[$pos + 5] == "%") || ($string[$pos + 5] == "?"))
	{
   		$evn = strpos($string, "--->", $pos + 6);
  		$vn = substr($string, $pos + 6, $evn - $pos - 6);
  		$pos2 = strpos($string, "<!---/$vn--->", $pos + 10);
  		$lvar = substr($string, $evn + 4, $pos2 - $evn - 4);
  		$pos2 += strlen("<!---/$vn--->");
  		$pos2 -=4;
  		if ($string[$pos + 5] == "%")
		{
  			$value = loopTemplate($lvar, $vn, $parser[$vn]);	
  		}
		elseif ($string[$pos + 5] == "?")
		{
$vn = str_replace("<?php echo ", "'.", $vn);
$vn = str_replace("; ?>", ".'", $vn);
$value = "<?php if ($vn) {?> ";
$value .= "	".$lvar." ";
$value .= "<?php } ?> ";
  		}	
  		if (strlen($value) > 0)
		{
 				$start = $pos;
  		}	
  	}
	else
	{
  		$pos2 = strpos($string, "--->", $pos + 5);
		if ($string[$pos + 5] == "#")
		{
	   		$evn = strpos($string, "--->", $pos + 6);
    		$vn = substr($string, $pos + 6, $evn - $pos - 6);
			$old_vn = $vn;
			$vn = str_replace("<?php echo ", "\".", $vn);
			$vn = str_replace("; ?>", ".\"", $vn);
			$value = "<?php echo \$parser[\"$vn\"]; ?>";
		} 
		else
		{
		  	$command = substr( $string, $pos + 5, $pos2 - $pos - 5);
			$command = str_replace("<?php echo ", "'.", $command);
			$command = str_replace("; ?>", ".'", $command);
		    $value = "<?php echo ($command); ?>";
		} 
		$start = $pos;
		if (strpos($value, "<!---") === false)
		{
			$start += strlen($value); 
		}
  	}
    $string = substr($string, 0, $pos) . $value . substr($string, $pos2 + 4);
  }
	if ($iter == $maxiter) {
		return "PARSER LOOP ERROR!:";
	}
	return $string;
}

function getTemplate($name)
{
	global $parser;
	$file_name = getcwd()."/templates/$name.htm";
	$file_name2 = getcwd()."/templates.inc/$name.inc.php";
	if (file_exists($file_name) || file_exists($file_name2)) 
	{
		if (file_exists($file_name2))
		{
			$cashe = true;
		}
		else
		{
			$cashe = false;
		}
		if ($cashe)
		{
			//
		}
		else
		{
			$template_variable = null;                        
			$fd = fopen ($file_name, 'r');
			$string = fread ($fd, filesize($file_name));
			if (defined("LG"))
			{
				$string = str_replace("_lg", "_".LG."", $string);
			}
			$string = parseSTR($string);
			
			if ($f=fopen($file_name2, 'w'))
			{
				fwrite($f, $string);
				fclose($f);
				chmod($file_name2, 0660);
			}
		}

		ob_start();
		include $file_name2;
		$out = ob_get_clean();
		return $out;
	}
	else
	{
		return "Unable open template: $name";
	}
}

?>
