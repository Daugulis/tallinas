<?php

class admin 
{
	function init(&$flex)
	{
		global $DB;
		$this->flex = &$flex;
		$this->DB = $DB;
		$this->auth();
		if (defined("UID"))
		{
			if ((int)UID>0)
			{
				$this->getMenu();
				$this->buildPage();
			}
		}
	}

	function auth()
	{
		global $parser;
		if (isset($_POST['a_login'])) $_SESSION['login'] = str_replace("'", "", $_POST['a_login']);
		if (isset($_POST['a_pass'])) $_SESSION['password'] = str_replace("'", "", $_POST['a_pass']);
		$l = (isset($_SESSION['login'])) ? $_SESSION['login'] : "";
		$p = (isset($_SESSION['password'])) ? $_SESSION['password'] : "";

		$sql = "SELECT COUNT(*) as cnt FROM `tb_admin_users` WHERE (`LOGIN` = '$l') AND (`PASS` = '$p')";
		$row = $this->DB->Fetch($this->DB->Query($sql));
		if ($row['cnt']<1)
		{
			$this->getLoginPage();
		}
		else
		{
			$sql = "SELECT * FROM `tb_admin_users` WHERE (`LOGIN` = '$l') AND (`PASS` = '$p')";
			$row = $this->DB->Fetch($this->DB->Query($sql));
			
			if (isset($_POST['data']))
			{
				if ($_POST['data']=='chlang')
				{
					if ($_POST['langid']!=$row['LANG'])
					{
						$row['LANG'] = $_POST['langid'];
						$sql = "update `tb_admin_users` set `LANG`='".$_POST['langid']."' where `ID`='".$row['ID']."'";
						$this->DB->Query($sql);
					}
					header("Location: " . $_SERVER['REQUEST_URI']);
					exit();
				}
			}

			if (isset($_POST['data']))
			{
				if ($_POST['data']=='chcss')
				{
					if ($_POST['css']!=$row['CSS'])
					{
						$row['CSS'] = $_POST['css'];
						$sql = "update `tb_admin_users` set `CSS`='".$_POST['css']."' where `ID`='".$row['ID']."'";
						$this->DB->Query($sql);
					}
					header("Location: " . $_SERVER['REQUEST_URI']);
					exit();
				}
			}

			$sql = "select * from `tb_admin_access` where `UID`='".$row['ID']."'";
			if ($res3 = $this->DB->Query($sql))
			{
				while ($row3 = $this->DB->Fetch($res3))
				{
					$parser['apriv'][$row3['COLL']] = $row3['LEVEL'];
				}
			}

			//print_r($parser['apriv']);
			$user = array();
			$user = $row;
			$parser['login_user'] = $row['NAME']." ".$row['SURNAME']."!";
			$parser['login_user_data'] = $user;

			define("CSS", $user['CSS']);
			$_SESSION['ADMIN'] = true;
			define("UID", $user['ID']);
			define("LANG", $user['LANG']);
			define("sLANG", strtoupper($user['LANG']));
			define("cLANG", strtolower($this->flex->langs_name[LANG]));
			getSysVoc();
			$sql = "UPDATE `tb_admin_users` SET `LU_DATE` = NOW() , `LU_IP` = '".$_SERVER['REMOTE_ADDR']."' WHERE `ID` = '".$user['ID']."'";
			$this->DB->Query($sql);

			if (isset($_POST['a_login']))
			{
				header("Location: /" . $this->flex->langs_name[LANG] . "/manager/");
				exit();
			}
		}
	}

	function getLoginPage()
	{
		global $flex;
		$this->flex->html = getTemplate("admin_login");
	}

	function buildPage()
	{
		global $parser, $DB;
		$this->flex->html = "";

		if ($this->flex->obj=="file")
		{
			include_once "class/files.php";
			$proc = new files();
			$proc->init($this);
			exit();
		}
		
		$this->flex->html .= getTemplate("admin_header");

		$sql = "select * from `tb_admin_objects` where `NAME`='".$this->flex->obj."'";
		$rw = $this->DB->getRowBySQL($sql);
		$parser['objname'] = $rw['NAME'];

		
		switch ($this->flex->obj)
		{
			case 'ajax':
				$this->flex->html = "";
				include_once "class/ajax.php";
				$proc = new ajax();
				$proc->init($this);
				exit();
				break;
			default:
				if (file_exists("class/" . $this->flex->obj . ".php"))
				{
					include_once "class/" . $this->flex->obj . ".php";
					$fl = $this->flex->obj;
					$proc = new $fl();
					$proc->init($this);
					break;
				}
				$parser['cnt'] = getTemplate("admin_first");
				break;
		}

		$this->flex->html .= getTemplate("admin_body");
	}

	function getMenu()
	{
		global $parser;
		$sql = "select * from `tb_admin_objects` where `PARENTID`='0' and `ENABLED`='1' order by `LEFT`";
		$parser['menu'] = $this->DB->getRowsBySQL($sql);
	}
}

?>