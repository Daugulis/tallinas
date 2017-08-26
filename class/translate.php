<?php 

class translate
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "translate";
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
				$this->getList(ID);
				break;
			case 'listajax':
				$this->getListAjax(ID);
				break;
			case 'deleteajax':
				$this->getDelete(ID);
				break;
			case 'delete':
				$this->getDelete(ID);
				header("Location: /" . cLANG . "/manager/" . OBJ . "/");
				exit();
				break;
			case 'add':
				$this->getAdd();
				break;
			case 'settings':
				$this->getSettings();
				break;
			case 'edit':
				$this->getEdit();
				break;
			case 'editajax':
				$this->getEditAjax();
				break;
		}
	}

	function getDelete($id)
	{
		$sql = "delete from `".TABLE_VOC_LANGS."` where `VOCID`='".$id."'";
		$this->_parent->DB->Query($sql);
		$sql = "delete from `".TABLE_VOC."` where `ID`='".$id."'";
		$this->_parent->DB->Query($sql);
	}

	function getList($type="1")
	{
		$sq = $sq2 = "";
		foreach ($this->parser['langs'] as $lang)
		{
			$sq .= " , ( select `VALUE` from `".TABLE_VOC_LANGS."` where `VOCID`=v.ID and `LANGID`='".$lang['ID']."' ) as `value_".$lang['ID']."` ";
		}

		$sqnn = "";
		if ($_POST['srname']!="")
		{
			$sqnn = " and ( `v`.`TRANS` LIKE '%".$_POST['srname']."%' OR ( select `VALUE` from `".TABLE_VOC_LANGS."` where `VOCID`=v.ID and `LANGID`='1' ) LIKE '%".$_POST['srname']."%' )";
		}

		$sql = "
			select 
				v.* $sq
			from `".TABLE_VOC."` as `v`
			where 
				`TYPE`='".$type."' $sqnn
			order by `TRANS`";
		$this->parser['vocs'] = $this->_parent->DB->getRowsBySQL($sql);
		$this->parser['cnt'] = getTemplate("admin_".$this->name."_list");
	}

	function getListAjax($type="1")
	{
		$sq = $sq2 = "";
		foreach ($this->parser['langs'] as $lang)
		{
			$sq .= " , ( select `VALUE` from `".TABLE_VOC_LANGS."` where `VOCID`=v.ID and `LANGID`='".$lang['ID']."' ) as `value_".$lang['ID']."` ";
			$sq .= " , ( select IF(`VALUE`<>'', 1, 0) from `".TABLE_VOC_LANGS."` where `VOCID`=v.ID and `LANGID`='".$lang['ID']."' ) as `svalue_".$lang['ID']."` ";
			if ($lang['ID']==LANG)
			{
				$sq .= " , ( select `VALUE` from `".TABLE_VOC_LANGS."` where `VOCID`=v.ID and `LANGID`='".$lang['ID']."' ) as `lvalue` ";
				$sq .= " , ( select IF(`VALUE`<>'', 1, 0) from `".TABLE_VOC_LANGS."` where `VOCID`=v.ID and `LANGID`='".$lang['ID']."' ) as `svalue` ";
			}

		}

		$sqnn = "";
		if ($_POST['srname']!="")
		{
			$sqnn = " and ( `v`.`TRANS` LIKE '%".$_POST['srname']."%' OR ( select `VALUE` from `".TABLE_VOC_LANGS."` where `VOCID`=v.ID and `LANGID`='1' ) LIKE '%".$_POST['srname']."%' )";
		}

		$sql = "
			select 
				v.* $sq
			from `".TABLE_VOC."` as `v`
			where 
				`TYPE`='".$type."' $sqnn
			order by `TRANS`";
		$this->parser['vocs'] = $this->_parent->DB->getRowsBySQL($sql);
		//print_R($this->parser['vocs']);
		$out = getTemplate("admin_".$this->name."_list_ajax");
		echo $out;
		exit();
	}

	function getAdd()
	{
		$this->parser['cnt'] = getTemplate("admin_".$this->name."_add");
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
			foreach ($this->parser['langs'] as $lang)
			{
				$arr = Array(
					"VALUE"=>$_POST['name_'.$lang['ID']]
				);
				$this->_parent->DB->Update($arr, TABLE_VOC_LANGS, " `VOCID` = '".ID."' and `LANGID`='".$lang['ID']."'");
			}
			exit();
		}

		$sql = "SELECT * FROM `".TABLE_VOC_LANGS."` WHERE `VOCID`='".ID."'";
		if ($res=$this->_parent->DB->Query($sql))
		{
			while ($row=$this->_parent->DB->Fetch($res))
			{
				$this->parser['d_name_'.$row['LANGID']] = $row['VALUE'];
			}
		}

		$SQL = "SELECT n.* FROM `".TABLE_VOC."` as n WHERE `ID`='".ID."'";
		$row = $this->_parent->DB->getRowBySQL($SQL);
		arrToParser($row, "d");

		$out = getTemplate("admin_".$this->name."_edit_ajax");
		echo $out;
		exit();
	}

	function getSettings()
	{		

		$sql = "select * from `tb_langs` order by `NAME`";
		$this->parser['langs2'] = $this->_parent->DB->getRowsBySQL($sql);

		$out = getTemplate("admin_".$this->name."_settings_ajax");
		echo $out;
		exit();
	}

}

?>