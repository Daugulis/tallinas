<?php

	session_start();

	error_reporting(0);
	ini_set("display_errors", "1");

	date_default_timezone_set("Europe/Riga");
	
	//print_r($_SERVER);

	//echo "test";

	include_once "includes/config.php";
	include_once "includes/parser.php";
	include_once "includes/shared.php";
	include_once "class/db.php";
	include_once "class/admin.php";
	include_once "class/simpledata.php";
	include_once "class/textsdata.php";
	include_once "class/flex.php";
	include_once "class/Mail.php";
	include_once "Mail_Mime/mime.php";

	//require_once 'mailt/PHPMailerAutoload.php';

	define("MYSQL_ERROR_LOG", "mysql_error.log");
	$DB = new DB();
	$DB->host = $db['host'];
	$DB->user = $db['user'];
	$DB->password = $db['password'];
	$DB->dbase = $db['db'];
	$DB->init();

	$DB->Query('SET NAMES UTF8');
	$DB->Query('SET COLLATION_CONNECTION=UTF8_GENERAL_CI');
	$DB->Query("SET time_zone = '+3:00'");

	if ($_GET['dup']=='1')
	{
		$sql = 'select * from `tb_catalog` where `FLOOR` = 1 ';
		if ($res = $DB->Query($sql))
		{
			while($row = $DB->Fetch($res))
			{
				print_r($row);
				$n = $row['NUMBER'] + 36;
				$f = $row['FLOOR'] + 3;
				$arr = Array(
					'NUMBER' => $n,
					'FLOOR' => $f,
					'STATUS' => '1',
					'ROOMS' => $row['ROOMS'],
					'AREA' => $row['AREA']
				);
				$DB->insert($arr, 'tb_catalog', $idd);
				$arr = Array('CID' => $idd, 'LANGID' => '11');
				$DB->insert($arr, 'tb_catalog_data', $idds);
				$arr = Array('CID' => $idd, 'LANGID' => '13');
				$DB->insert($arr, 'tb_catalog_data', $idds);
				$arr = Array('CID' => $idd, 'LANGID' => '8');
				$DB->insert($arr, 'tb_catalog_data', $idds);
			}
		}
		exit();
	}

	$flex = new Flex();

	header("Content-Type: text/html; charset=utf-8");
	exit($flex->html);

?>