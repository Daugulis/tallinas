<?php 

class tree extends textsdata
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "tree";
		$this->datatable = "tb_tree";
		$this->folder = "tree";
		$this->images = "1";
		$this->icons = "1";
		$this->files = "1";
		$this->langsdata = Array("NAME", "URL", "TEXT", "TITLE", "KW", "DESC", "SUBURL", "SUBNAME", "STEXT", "TNAME");
		if (ADMIN && $import=="0")
		{
			$this->buildPage();
		}
	}

	function buildPage()
	{
		$method = "_".$this->_parent->flex->task;
		if (method_exists($this, $method))
		{
			$this->$method(ID);
		}
	}

	function _setleft()
	{
		if (isset($_POST['items']))
		{
			$this->setLeft($_POST['items']);
		}
	}

	function _setstatus($id)
	{
		$out = $this->setStatus($id);
		echo $out;
		exit();
	}

	function _delete($ids)
	{
		$sql = "delete from `tb_tree` where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "delete from `tb_tree_data` where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_tree_images` set `CID` = '0' where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_tree_blocks` set `CID` = '0' where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
	}

	function _addimage()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_tree_images", "tree", "CID", $id, 0, 0, 0, 1);
		$result = Array("id"=>$id, "typeid"=>getImageType($_FILES['file']['type']));
		echo json_encode($result);
		exit();
	}

	function _addfile()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_tree_files", "tfiles", "CID", $id, 0, 0, 0, 1);
		$result = Array("id"=>$id, "typeid"=>getImageType($_FILES['file']['type']));
		echo json_encode($result);
		exit();
	}

	function _addicon()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_tree_icons", "treeicons", "CID", $id, 0, 0, 0, 1);
		$result = Array("id"=>$id, "typeid"=>getImageType($_FILES['file']['type']));
		echo json_encode($result);
		exit();
	}

	function _list()
	{
		$this->parser['items'] = $this->getData();
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_list");
	}

	function _listajax()
	{
		$sql = "
			select
				t.* ,
				`td`.`NAME`
			from `tb_tree` as `t`
			inner join `tb_tree_data` as `td`
			on `t`.`ID`=`td`.`CID` and '".LANG."' = `td`.`LANGID`
			order by `td`.`NAME`
		";
		$ptr = Array();
		$this->parser['tr'] = $this->_parent->DB->getRowsBySQL($sql);
		foreach ($this->parser['tr'] as $k=>$v)
		{
			$ptr[$v['ID']] = $v['NAME'];
		}
		$params = Array();
		$params['sort'] = Array("field"=>"LEFT", "type"=>"asc");
		$this->parser['items'] = $this->getLangData($params);
		foreach ($this->parser['items'] as $k=>$v)
		{
			$this->parser['items'][$k]['CNAME'] = $ptr[$v['SUB_ID']];
		}
		$out = getTemplate("admin_" . $this->name . "_ajax_list");
		echo $out;
		exit();
	}

	function _addajax()
	{
		$left = $this->getLeft() + 1;
		$data = Array("STATUS"=>$_POST['status'], "TFORM"=>$_POST['tform'], "NOMINATIONS"=>$_POST['nominations'], "JURY"=>$_POST['jury'], "MC"=>$_POST['mc'], "TIMERID"=>$_POST['timer'], "MENU"=>$_POST['menu'], "PERIOD"=>$_POST['period'], "SUB_ID"=>$_POST['pid'], "FIRST"=>$_POST['first'], "TYPE"=>$_POST['type'], "FOOTER"=>$_POST['footer'], "LEFT"=>$left, "TDTIME"=>date("Y-m-d H:i:s", strtotime($_POST['tdtime'])));
		$id = $this->getAddAjax($data, $_POST);
		$this->saveImages($_POST['itemimg'], $id);
		$this->saveIcons($_POST['itemicons'], $id);
		$this->saveFiles($_POST['itemfiles'], $id);
		$this->saveBlocksTextsData($_POST['text'], $id, true);
		$this->saveBlocksImagesData($_POST['itemimg'], $id);
		$this->saveBlocksData($_POST['block'], $id);
		$out = getTemplate("admin_" . $this->name . "_add_ajax");
		echo $out;
		exit();
	}

	function _add()
	{
		$sql = "
			select
				t.* ,
				`td`.`NAME`
			from `tb_tree` as `t`
			inner join `tb_tree_data` as `td`
			on `t`.`ID`=`td`.`CID` and '".LANG."' = `td`.`LANGID`
			where `t`.`SUB_ID` = '0'
			order by `t`.`LEFT`
		";
		$ptr = Array();
		$this->parser['tr'] = $this->_parent->DB->getRowsBySQL($sql);

		$sql = "
			select
				t.* ,
				`td`.`NAME`
			from `tb_competitions` as `t`
			inner join `tb_competitions_data` as `td`
			on `t`.`ID`=`td`.`CID` and '".LANG."' = `td`.`LANGID`
			order by `td`.`NAME`
		";
		$ptr = Array();
		$this->parser['cm'] = $this->_parent->DB->getRowsBySQL($sql);

		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_add");
	}

	function _editajax($id)
	{
		$data = Array("STATUS"=>$_POST['status'], "TFORM"=>$_POST['tform'], "NOMINATIONS"=>$_POST['nominations'], "JURY"=>$_POST['jury'], "MC"=>$_POST['mc'], "TIMERID"=>$_POST['timer'], "MENU"=>$_POST['menu'], "PERIOD"=>$_POST['period'], "SUB_ID"=>$_POST['pid'], "FIRST"=>$_POST['first'], "TYPE"=>$_POST['type'], "FOOTER"=>$_POST['footer'], "TDTIME"=>date("Y-m-d H:i:s", strtotime($_POST['tdtime'])));
		$this->getEditAjaxSave($id, $data, $_POST);
		$this->unsetImages($id);
		$this->saveImages($_POST['itemimg'], $id);
		$this->unsetIcons($id);
		$this->saveIcons($_POST['itemicons'], $id);
		$this->unsetFiles($id);
		$this->saveFiles($_POST['itemfiles'], $id);
		$this->unsetBlocksData($id);
		$this->saveBlocksTextsData($_POST['text'], $id, true);
		$this->saveBlocksImagesData($_POST['itemimg'], $id);
		$this->saveBlocksData($_POST['block'], $id);
		$out = getTemplate("admin_" . $this->name . "_edit_ajax");
		echo $out;
		exit();
	}

	function _edit($id)
	{
		$sql = "
			select
				t.* ,
				`td`.`NAME`
			from `tb_competitions` as `t`
			inner join `tb_competitions_data` as `td`
			on `t`.`ID`=`td`.`CID` and '".LANG."' = `td`.`LANGID`
			order by `td`.`NAME`
		";
		$ptr = Array();
		$this->parser['cm'] = $this->_parent->DB->getRowsBySQL($sql);
		$sql = "
			select
				t.* ,
				`td`.`NAME`
			from `tb_tree` as `t`
			inner join `tb_tree_data` as `td`
			on `t`.`ID`=`td`.`CID` and '".LANG."' = `td`.`LANGID`
			where `t`.`ID`<>'".$id."' and `t`.`SUB_ID` = '0'
			order by `t`.`LEFT`
		";
		$ptr = Array();
		$this->parser['tr'] = $this->_parent->DB->getRowsBySQL($sql);
		$this->getEditAjax($id);
		$this->parser['images'] = $this->getImages($id);
		$this->parser['icons'] = $this->getIcons($id);
		$this->parser['files'] = $this->getFiles($id);
		$this->parser['blocks'] = $this->getBlocks($id);
		if (strtotime($this->parser['d_TDTIME'])==0)
		{
			$this->parser['d_TDTIME'] = '';
		}
		else
		{
			$this->parser['d_TDTIME'] = date("d.m.Y H:i", strtotime($this->parser['d_TDTIME']));
		}
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_edit");
	}

}