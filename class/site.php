<?php

class site 
{
	function init(&$flex)
	{
		global $DB, $parser;
		$this->flex = &$flex;
		$this->parser = &$parser;
		$this->DB = $DB;
		$this->buildPage();
	}

	function buildPage()
	{
		global $parser, $DB;

		$this->parser['title'] = "";


		$this->flex->html = "";	

		$this->getUrlData();

		$parser['title'] = voc('def_title');
		$parser['kw'] = voc('def_kw');
		$parser['desc'] = voc('def_desc');

        $this->getObjData();	


		//print_r($parser['aprices']);

		//$parser['menu'] = $this->getMenu("0");
		//$parser['menus'] = $this->getMenu("2");
		
		if (($_SESSION['swpopup'] < time() - 12300) || $_GET['popup']=='1')
		{
			$_SESSION['swpopup'] = time();
			$parser['swpopup'] = '1';
		}
		else
		{
			$parser['swpopup'] = '0';
		}

		include_once "class/services.php";
		$services = new Services();
		$services->init($this);
		$services->images = "1";

		include_once "class/main.php";
		$main = new main();
		$main->init($this);

		include_once "class/tree.php";
		$tree = new tree();
		$tree->init($this);

		include_once "class/texts.php";
		$texts = new texts();
		$texts->init($this);

		include_once "class/categories.php";
		$categories = new categories();
		$categories->init($this);

		include_once "class/markers.php";
		$markers = new markers();
		$markers->init($this);

		include_once "class/contacts.php";
		$contacts = new contacts();
		$contacts->init($this);

		$params = Array();
		$params['sort'] = Array("field"=>"LEFT", "type"=>"asc");
		$params['sq'] = " `STATUS`='1' and `SUB_ID` = '0'";
		$this->parser['tree'] = $tree->getLangData($params);

		$params = Array();
		$params['sort'] = Array("field"=>"LEFT", "type"=>"asc");
		$params['sq'] = " `STATUS`='1'";
		$this->parser['markers'] = $markers->getLangData($params);

		foreach ($this->parser['markers'] as $k=>$v)
		{
			$this->parser['markers'][$k]['LANG_NAME'] = htmlspecialchars(str_replace("'", "\'", $this->parser['markers'][$k]['LANG_NAME']));
			$this->parser['markers'][$k]['LANG_TEXT'] = str_replace("\r\n", "<br />", str_replace("'", "\'", $this->parser['markers'][$k]['LANG_TEXT']));
		}

		$params = Array();
		$params['sort'] = Array("field"=>"LEFT", "type"=>"asc");
		$params['sq'] = " `STATUS`='1'";
		$this->parser['contacts'] = $contacts->getLangData($params);

		//print_r($this->parser['contacts']);

		$params = Array();
		$params['sort'] = Array("field"=>"LEFT", "type"=>"asc");
		$params['sq'] = " `STATUS`='1'";
		$this->parser['main'] = $main->getLangData($params);

		$params = Array();
		$params['sort'] = Array("field"=>"LEFT", "type"=>"asc");
		$params['sq'] = " `STATUS`='1' and `SUB_ID` = '0' and `TYPE` = '4'";
		$this->parser['ctree'] = $tree->getLangData($params);

		if (OBJ=='sendmsg')
		{
			$stext = 'Name: ' . $_POST['name'] . "\r\n<br />";
			$stext .= 'Phone: ' . $_POST['phone'] . "\r\n<br />";
			$stext .= 'E-mail: ' . $_POST['email'] . "\r\n<br />";
			$stext .= 'Text: ' . $_POST['text'] . "\r\n<br />";
			socketmail('info@tallinas86.lv', 'info@tallinas86.lv', 'New message Tallinas86.lv', $stext, 'Tallinas 86');
			socketmail('jurijs.daugulis@gmail.com', 'info@tallinas86.lv', 'New message Tallinas86.lv', $stext, 'Tallinas 86');
			exit();
		}

		switch (U_TYPE)
		{
			case '4':
				$parser['scnc'] = '1';
				$parser['content'] = getTemplate('site_contacts');
				break;
			case '2':
				//$parser['content'] = getTemplate('site_faq');
				$sql = "select * from `tb_tree` where `SUB_ID` = '".U_ID."' and `STATUS` = '1' order by `LEFT` LIMIT 1";
				$rw = $DB->getRowBySQL($sql);
				if ($rw['ID']>0)
				{
					$sql = "select * from `tb_tree_data` where `CID` = '".$rw['ID']."' and `LANGID` = '".LANG."'";
					$rw = $DB->getRowBySQL($sql);
					header('Location: /'.cLANG.'/'.OBJ.'/' . $rw['URL'] . '/');
					exit();
				}
				break;
			case '3':
				$sql = "select * from `tb_tree_images` where `CID` = '".U_ID."' order by `LEFT`";
				$parser['images'] = $DB->getRowsBySQL($sql);
				foreach ($parser['images'] as $k=>$v)
				{
					list($w, $h, $type, $attr) = getimagesize("loads/tree/".$v['ID'].".".$v['EXT']);
					$parser['images'][$k]['w'] = $w;
					$parser['images'][$k]['h'] = $h;
				}
				$parser['content'] = getTemplate('site_gallery');
				break;
			case '1':
				$parser['ob'] = $tree->getDataByID(U_ID);
				//print_R($parser['ob']);

				$params = Array();
				$params['sort'] = Array("field"=>"LEFT", "type"=>"asc");
				$params['sq'] = " `STATUS`='1' and `SUB_ID` = '".U_ID."'";
				$this->parser['stree'] = $tree->getLangData($params);

				$parser['content'] = getTemplate('site_about');
				break;
			default:
				if (OBJ=='showpopup')
				{
					$parser['ob'] = $tree->getDataByID(TASK);
					echo getTemplate('site_popup');
					exit();
				}
				if (TASK=='' && (intval(OBJ)>1 && intval(OBJ)<6))
				{
					if (!isset($_SESSION['mainnum']))
					{
						$_SESSION['mainnum'] = 0;
					}
					else
					{
						$_SESSION['mainnum'] = $_SESSION['mainnum'] + 1;
					}
					if ($_SESSION['mainnum']+1 > count($parser['main']))
					{
						$_SESSION['mainnum'] = 0;
					}
					$parser['mainbg'] = $parser['main'][$_SESSION['mainnum']];
					$sql = 'select * from `tb_catalog` order by `NUMBER`';
					$parser['rooms'] = $DB->getRowsBySQL($sql);

					$parser['content'] = getTemplate('site_floor');
					break;
				}
				if (intval(TASK)>0 && (intval(OBJ)>1 && intval(OBJ)<6))
				{

					$params = Array();
					$params['sort'] = Array("field"=>"LEFT", "type"=>"asc");
					$params['sq'] = " `STATUS`='1' and `tb`.`ID` = '6'";
					$this->parser['stree'] = $tree->getLangData($params);

					if (!isset($_SESSION['mainnum']))
					{
						$_SESSION['mainnum'] = 0;
					}
					else
					{
						$_SESSION['mainnum'] = $_SESSION['mainnum'] + 1;
					}
					if ($_SESSION['mainnum']+1 > count($parser['main']))
					{
						$_SESSION['mainnum'] = 0;
					}
					$parser['mainbg'] = $parser['main'][$_SESSION['mainnum']];
					$sql = 'select * from `tb_catalog` where `NUMBER` = ' . intval(TASK);
					$parser['room'] = $DB->getRowBySQL($sql);
					$parser['img'] = $parser['room']['NUMBER'] - ( ( $parser['room']['FLOOR'] - 2 ) * 12 ) ;
					if (OBJ=='5' && TASK=='48')
					{
						$parser['img'] = '12-1';
					}
					$parser['imm'] = getimagesize("img/".$parser['img'].".png");
					$sql = 'select * from `tb_catalog` where `NUMBER` = ' . intval(TASK);
					$rw = $DB->getRowBySQL($sql);

					$larr = Array('lv'=>'0', 'ru'=>'1', 'en'=>'2');

					$sql = "select * from `tb_catalog_images` where `CID` = '".$parser['room']['ID']."' order by `LEFT` limit ".$larr[cLANG].",1";
					$parser['pdf'] = $DB->getRowBySQL($sql);
					if ($parser['pdf']['ID']!='')
					{
						//
					}
					else
					{
						$sql = "select * from `tb_catalog_images` where `CID` = '".$parser['room']['ID']."' order by `LEFT` limit 1";
						$parser['pdf'] = $DB->getRowBySQL($sql);
					}

					if (ID=='getpdf' && $parser['pdf']['ID']>0)
					{						
						$file_url = 'loads/catalog/' . $parser['pdf']['ID'] . '.' . $parser['pdf']['EXT'];
						header('Content-Type: application/octet-stream');
						header("Content-Transfer-Encoding: Binary"); 
						header("Content-disposition: attachment; filename=\"" . $parser['pdf']['NAME'] . "\""); 
						readfile($file_url);
						exit();
					}


					$sql = '
						select 
							a.* ,
							c.`NUMBER` as `INAME`,
							`t`.`NAME` as `TNAME`
						from `tb_areas` as `a`
						inner join `tb_atypes_data` as `t`
						on `a`.`TID` = `t`.`CID` and '.LANG.' = `t`.`LANGID`
						inner join `tb_catalog` as `c`
						on `a`.`CID` = `c`.`ID`
						where
							`a`.`CID` = ' . $rw['ID'].'
							and `a`.`STATUS` = 1
						';
					$parser['areas'] = $DB->getRowsBySQL($sql);


					$parser['content'] = getTemplate('site_flat');
					break;
				}
				$parser['content'] = getTemplate('site_first');
				break;
		}

		header("Content-Type: text/html; charset=utf-8");

		if ($_GET['test'])
		{
			$_SESSION['test'] = $_GET['test'];
		}
			
		//if ($_SESSION['test']=='on')
		//{
			$this->flex->html .= getTemplate("site_header");
			$this->flex->html .= getTemplate("site_body");
		//}
		//else
		//{
		//	$this->flex->html = file_get_contents("index_b.html");
		//}

		//print_r($_SERVER);
		if ($_SERVER['REMOTE_ADDR']!='89.201.1.220')
		{
			//$this->flex->html = getTemplate('index');
		}
	}

	function getObjData()
	{
		global $DB, $parser;
		$sql = "select * from `tb_tree_data` where `URL`='".mysql_real_escape_string(OBJ)."' and `LANGID`='".LANG."'";
		$data = $DB->getRowBySQL($sql);
		$sql = "select * from `tb_tree` where `ID`='".$data['CID']."'";
		$row = $DB->getRowBySQL($sql);
		$row['URL'] = OBJ;
		$row['NAME'] = $data['NAME'];
		//print_r($data);
		$parser['u_title'] = $data['TITLE'];
		$parser['u_desc'] = $data['DESC'];
		$parser['u_kw'] = $data['KW'];
		$parser['title'] = ($data['TITLE']!='') ? $data['TITLE'] : $parser['title'];
		$parser['kw'] = ($data['KW']!='') ? $data['KW'] : $parser['kw'];
		$parser['desc'] = ($data['DESC']!='') ? $data['DESC'] : $parser['desc'];
		$parser['objdata'] = $row;
	}

	function getTaskData()
	{
		global $DB, $parser;
		$parser['taskdata'] = $row;
	}

	function getIDData()
	{
		global $DB, $parser;
		$parser['iddata'] = $row;
	}

	function getUrlData()
	{
		$arr = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
		$arr = array_reverse($arr);
		$type = 0;
		$id = 0;
		$num = 0;

		$name = "";
		$title = "";
		$kw = "";
		$desc = "";

		$_SESSION['curls'] = Array();
		$_SESSION['cids'] = Array();
		
		if (count($arr)>0)
		{
			$nm = 0;
			foreach ($arr as $a)
			{
				$nm++;
		
				$sql = "select * from `".TABLE_TREE_DATA."` where `LANGID`='".LANG."' and `URL`='".mysql_real_escape_string($a)."'";
				$row = $this->DB->getRowBySQL($sql);
				if ((int)$row['ID']>0 && $id==0)
				{
					$num = $nm;
					$id = $row['CID'];
					$sql = "select * from `".TABLE_TREE."` where `ID`='".$id."'";
					$rw = $this->DB->getRowBySQL($sql);
					$type = $rw['TYPE'];
					$next = $rw['NEXT'];
					$name = $row['NAME'];
					$kw = $row['KW'];
					$desc = $row['DESC'];
					$title = $row['TITLE'];
				}
				else
				{
					$sql = "select * from `".TABLE_CAT_DATA."` where `LANGID`='".LANG."' and `URL`='".mysql_real_escape_string($a)."'";

					$row = $this->DB->getRowBySQL($sql);
					if ((int)$row['ID']>0)
					{
						if (!in_array($row['ID'], $_SESSION['cids']))
						{
							$_SESSION['cids'][] = $row['CID'];
							
						}
						if (!in_array($a, $_SESSION['curls']))
						{
							$_SESSION['curls'][] = $a;	
						}
					}
					else
					{
						$sql = "select * from `tb_catalog_data` where `LANGID`='".LANG."' and `URL`='".mysql_real_escape_string($a)."'";
						$row = $this->DB->getRowBySQL($sql);
						if ((int)$row['ID']>0)
						{
							$this->parser['prod'] = $row;
						}
					}
				}
			}
		}
		if ($num==1)
		{
			if ($next=="1")
			{
				$sql = "select * from `".TABLE_TREE."` where `SUB_ID`='".$id."' and `STATUS`='1' order by `LEFT`";
				$row = $this->DB->getRowBySQL($sql);
				if ((int)$row['ID']>0)
				{
					$sql = "select * from `".TABLE_TREE_DATA."` where `TID`='".$row['ID']."' and `LANGID`='".LANG."'";
					$row = $this->DB->getRowBySQL($sql);
					if ($row['URL']!="")
					{	
						header("Location: /" . trim($_SERVER['REQUEST_URI'], "/") . "/" . $row['URL'] . "/");
						exit();
					}
				}
			}
		}

		define("U_TYPE", $type);
		define("U_ID", $id);
		define("U_NAME", $name);
		if ($title!="")
		{
			$this->parser['title'] = $title;
		}
		if ($kw!="")
		{
			$this->parser['kw'] = $kw;
		}
		if ($desc!="")
		{
			$this->parser['desc'] = $desc;
		}
	}

	function getMenu($parent, $type="")
	{
		$sql = "
			select 
				t.* ,
				tl.`NAME` as `NAME` ,
				tl.`TEXT` as `TEXT` ,
				tl.`URL` as `URL`
			from `".TABLE_TREE."` as t
			inner join `".TABLE_TREE_DATA."` as tl
			on t.ID=tl.CID and '".LANG."'=tl.LANGID
			where 
				t.STATUS = '1' 
				and `t`.`TYPE`<>'8'
			order by
				t.LEFT
		";
		$res = $this->DB->getRowsBySQL($sql);
		return $res;
	}

	function getMenuGl($p)
	{
		$sql = "
			select 
				t.* tl.`NAME` as `NAME` ,
				tl.`URL` as `URL`
			from `".TABLE_TREE."` as t
			inner join `".TABLE_TREE_DATA."` as tl
			on t.ID=tl.CID and '".LANG."'=tl.LANGID
			where 
				t.STATUS = '1' 
				and t.TYPE_ID IN ($p)
			order by
				t.LEFT
		";
		$res = $this->DB->getRowsBySQL($sql);
		return $res;
	}
}


?>