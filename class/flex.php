<?php

class flex
{
	
	var $manager = false;
	var $langs = Array();
	var $langs_id = Array();
	var $langs_name = Array();

	function flex()
	{
		global $DB;
		$this->DB = $DB;
		$this->dPost();
		$this->getLangs();
		$this->parseURI();
	}

	function dPost()
	{
		if (count($_POST)>0)
		{
			foreach ($_POST as $k=>$v)
			{
				if (!is_array($v))
				{
					$_POST[$k] = stripslashes($v);
				}
			}
		}
	}

	function getStr($str, $part1, $part2, $inc1, $inc2, $start = 0)
	{
		$ra = array();
		while ($start < strlen($str))
		{
			$pos1 = strpos($str, $part1, $start);
			if ($pos1 === false)
			{
				$start = strlen($str);
			}
			else
			{	
				$sss = $pos1 + strlen($part1);
				$pos2 = strpos($str, $part2, $sss);
				$len = $pos2-$pos1;
				if ($inc1)
				{
					$spos = $pos1;
				}
				else
				{
					$spos = $pos1 + strlen($part1);
					$len -= strlen($part1);
				}
				if ($inc2)
				{
					$len += strlen($part2);
				}
				array_push($ra, substr($str, $spos, $len));
				$start = ($pos2 > $start)?($pos2):(strlen($str));
			}
		}	
		return $ra;
	}

	function parseURI()
	{
		global $parser;
		$arr = explode("/", $_SERVER['REQUEST_URI']);
		$this->lang['short'] = $arr['1'];
		if ($arr['2']=='manager')
		{
			define("ADMIN", true);
			define("VOC_TYPE", "2");
			$this->manager = true;
			$this->obj = '';
			$this->task = '';
			$this->id = '';
			$this->id2 = '';
			if (isset($arr['3']))
			{
				$this->obj = $arr['3'];
			}
			if (isset($arr['4']))
			{
				$this->task = (trim($arr['4'])!="") ? trim($arr['4']) : "list";
			}
			if (isset($arr['5']))
			{
				$this->id = (trim($arr['5'])!="") ? trim($arr['5']) : "0";
			}
			if (isset($arr['6']))
			{
				$this->id2 = (trim($arr['6'])!="") ? trim($arr['6']) : "";
			}
			define("OBJ", $this->obj);
			define("TASK", $this->task);
			define("ID", $this->id);
			define("ID2", $this->id2);
			
			if (substr(OBJ, -4)=='.css')
			{
				header("Content-Type: text/css;");
				$cnt = file_get_contents("css/" . OBJ);
				exit($cnt);
			}

			if (OBJ=="logout")
			{
				unset( $_SESSION['login']);
				unset( $_SESSION['password']);
				header("Location: /" . $this->lang['short'] . "/manager/");
				exit();
			}

			$this->getManager();
		}
		else
		{
	
			$this->obj = "";
			$this->task = "";
			$this->id = "";
			$this->id2 = "";
			$this->id3 = "";
			$this->id4 = "";

			define("ADMIN", false);
			if (!in_array($this->lang['short'], $this->langs_name))
			{
				header("Location: /".DEF_LANG."/");
				exit();
			}
			define("LANG", $this->langs_id[$this->lang['short']]);
			define("cLANG", strtolower($this->langs_name[LANG]));
			define("VOC_TYPE", "1");
			
			
			getSysVoc();
			if (isset($arr["2"]))
			{
				$this->obj = $arr["2"];
			}
			if (isset($arr["3"]))
			{
				$this->task = (trim($arr['3'])!="") ? trim($arr['3']) : "";
			}
			if (isset($arr["4"]))
			{
				$this->id = (trim($arr['4'])!="") ? trim($arr['4']) : "";
			}
			if (isset($arr["5"]))
			{
				$this->id2 = (trim($arr['5'])!="") ? trim($arr['5']) : "";
			}
			if (isset($arr["6"]))
			{
				$this->id3 = (trim($arr['6'])!="") ? trim($arr['6']) : "";
			}
			if (isset($arr["7"]))
			{
				$this->id4 = (trim($arr['7'])!="") ? trim($arr['7']) : "";
			}
			define("OBJ", $this->obj);
			define("TASK", $this->task);
			define("ID", $this->id);
			define("ID2", $this->id2);
			define("ID3", $this->id3);
			define("ID4", $this->id4);
			$this->getSite();
		}
	}

	function getManager()
	{
		include_once "class/admin.php";
		$manager = new Admin();
		$manager->init($this);
	}

	function getSite()
	{
		include_once "class/site.php";
		$site = new Site();
		$site->init($this);
	}

	function getLangs()
	{
		global $parser;
		$SQL = "
			SELECT 
				l.* ,
				(SELECT `ID` from `tb_languages_images` where `CID`=`l`.`ID`) as `IMID` ,
				(SELECT `EXT` from `tb_languages_images` where `CID`=`l`.`ID`) as `IMEXT` 
			FROM `tb_languages` as	`l`
			where 
			l.`STATUS`='1' 
			order by l.`LEFT`";
		$this->langs = Array();
		$this->langs_id = Array();
		$i = 0;
		if ($res=$this->DB->Query($SQL))
		{
			while ($row=$this->DB->Fetch($res))
			{
				$i++;
				$row['num'] = $i;
				$row['SITENAME'] = $row['SNAME'];
				$row['SHORTNAME'] = $row['URL'];
				$row['SHORTNAME'] = strtolower($row['SHORTNAME']);
				$this->langs[] = $row;
				$this->langs_id[$row['SHORTNAME']] = $row['ID'];
				$this->langs_name[$row['ID']] = $row['SHORTNAME'];
				if ($row['DEF']=="1")
				{
					$parser['clangdata'] = $row;
					define("DEF_LANG_ID", $row['ID']);
					define("DEF_LANG", $row['SHORTNAME']);
				}
			}
		}
		$parser['langs'] = $this->langs;
		$parser['langsbyid'] = $this->langs_name;
	}

}

?>