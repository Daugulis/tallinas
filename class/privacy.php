<?php 

class privacy
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "privacy";
		if (ADMIN && $import=="0")
		{
			$this->buildPage();
		}
	}
	
	function buildPage()
	{
		switch ($this->_parent->flex->task)
		{
			case 'list':
				$this->getList();
				break;
			case 'listajax':
				$this->getListAjax();
				break;
			case 'deleteajax':
				$this->getDelete(ID);
				exit();
				break;
			case 'delete':
				$this->getDelete(ID);
				header("Location: /" . cLANG . "/manager/" . OBJ . "/");
				exit();
				break;
			case 'add':
				$this->getAdd();
				break;
			case 'addajax':
				$this->getAddAjax();
				break;
			case 'edit':
				$this->getEdit();
				break;
			case 'editajax':
				$this->getEditAjax();
				break;
		}
	}

	function getDelete($ids)
	{

		$sql = "delete from `tb_admin_users` where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);

		$sql = "delete from `tb_admin_access` where `UID` in (".$ids.")";
		$this->_parent->DB->Query($sql);

	}


	function getList()
	{
		$sql = "
			select
				a.* 
			from `tb_admin_users` as `a`
			order by a.`NAME` 
		";
		$this->parser['users'] = $this->_parent->DB->getRowsBySQL($sql);
		$this->parser['cnt'] = getTemplate("admin_".$this->name."_list");
	}

	function getListAjax()
	{
		if ($_POST['level']!="all")
		{
			$sq = " and `GROUP` = '".$_POST['level']."'";
		}
		$sql = "
			select
				a.* 
			from `tb_admin_users` as `a`
			where 1=1 $sq
			order by a.`NAME` 
		";
		$this->parser['users'] = $this->_parent->DB->getRowsBySQL($sql);
		$out = getTemplate("admin_".$this->name."_list_ajax");
		echo $out;
		exit();
	}

	function getAdd()
	{
		$this->parser['cnt'] = getTemplate("admin_".$this->name."_add");
	}

	function getAddAjax()
	{
		if ($_POST['data']=='1')
		{
			extract($_POST);
			$arr = Array(
					"NAME"=>$name,
					"SURNAME"=>$surname,
					"LOGIN"=>$login,
					"PASS"=>$pass,
					"EMAIL"=>$email,
					"LANG"=>11,
					"ENABLED"=>$status,
					"GROUP"=>$group,
					"CDATE"=>date("Y-m-d")
				);
			if ($this->_parent->DB->insert($arr, "tb_admin_users", $id))
			{
				if (count($_POST['perm'])>0)
				{
					foreach ($_POST['perm'] as $k=>$v)
					{
						$arr = Array(
							"UID"=>$id,
							"COLL"=>$k,
							"LEVEL"=>$v
						);
						if ($this->_parent->DB->insert($arr, "tb_admin_access", $aid))
						{
							//
						}
					}
				}
			}
			exit();
		}
		$out = getTemplate("admin_".$this->name."_add_ajax");
		echo $out;
		exit();
	}

	function getEdit()
	{
		$this->parser['cnt'] = getTemplate("admin_".$this->name."_edit");
	}

	function getEditAjax()
	{

		if ($_POST['data']=='1')
		{
			extract($_POST);
			$arr = Array(
					"NAME"=>$name,
					"SURNAME"=>$surname,
					"LOGIN"=>$login,
					"PASS"=>$pass,
					"EMAIL"=>$email,
					"LANG"=>11,
					"ENABLED"=>$status,
					"GROUP"=>$group,
					"CDATE"=>date("Y-m-d")
				);
			if ($this->_parent->DB->Update($arr, "tb_admin_users", " `ID` = '".ID."' "))
			{
				$sql = "delete from `tb_admin_access` where `UID`='".ID."'";
				$this->_parent->DB->Query($sql);
				if (count($_POST['perm'])>0)
				{
					foreach ($_POST['perm'] as $k=>$v)
					{
						$arr = Array(
							"UID"=>ID,
							"COLL"=>$k,
							"LEVEL"=>$v
						);
						if ($this->_parent->DB->insert($arr, "tb_admin_access", $aid))
						{
							//
						}
					}
				}
			}
			exit();
		}

		$SQL = "SELECT n.* FROM `tb_admin_users` as n WHERE `ID`='".ID."'";
		$row = $this->_parent->DB->getRowBySQL($SQL);
		arrToParser($row, "d");

		$sql = "select * from `tb_admin_access` where `UID`='".ID."'";
		if ($res = $this->_parent->DB->Query($sql))
		{
			while ($row = $this->_parent->DB->Fetch($res))
			{
				$this->parser['priv'][$row['COLL']] = $row['LEVEL'];
			}
		}

		$out = getTemplate("admin_".$this->name."_edit_ajax");
		echo $out;
		exit();
	}

}

?>