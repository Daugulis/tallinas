<?php 

class services extends textsdata
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "services";
		$this->datatable = "tb_services";
		$this->folder = "services";
		$this->images = "1";
		$this->icons = "1";
		$this->size = "1";
		$this->langsdata = Array("NAME", "URL", "STEXT", "TITLE", "KW", "DESC");
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
		$sql = "delete from `tb_services` where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "delete from `tb_services_data` where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_services_blocks` set `CID`='0' where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_services_images` set `CID`='0' where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_services_icons` set `CID`='0' where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
	}

	function _addimage()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_services_images", "services", "CID", $id, 0, 0, 0, 1);
		list($width, $height, $type, $attr) = getimagesize($_FILES['file']['tmp_name']);
		$sql = "update `tb_services_images` set `WIDTH` = '".$width."' , `HEIGHT` = '".$height."' where `ID` = '".$id."'";
		$this->_parent->DB->Query($sql);
		$result = Array("id"=>$id, "typeid"=>getImageType($_FILES['file']['type']));
		echo json_encode($result);
		exit();
	}

	function _addicon()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_services_icons", "servicesicons", "CID", $id, 0, 0, 0, 1);
		if (getImageType($_FILES['file']['type'])!='9')
		{
			list($width, $height, $type, $attr) = getimagesize($_FILES['file']['tmp_name']);
			$sql = "update `tb_services_icons` set `WIDTH` = '".$width."' , `HEIGHT` = '".$height."' where `ID` = '".$id."'";
			$this->_parent->DB->Query($sql);
		}
		$result = Array("id"=>$id, "typeid"=>getImageType($_FILES['file']['type']));
		echo json_encode($result);
		exit();
	}

	function _list()
	{
		//$this->parser['items'] = $this->getData();
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
			$this->parser['items'][$k]['CNAME'] = $ptr[$v['PID']];
		}
		$out = getTemplate("admin_" . $this->name . "_ajax_list");
		echo $out;
		exit();
	}

	function _addajax()
	{
		//print_r($_POST);
		//exit();
		$left = $this->getLeft() + 1;
		$data = Array("STATUS"=>$_POST['status'], "PID"=>$_POST['pid'], "LEFT"=>$left, "TYPE"=>$type, "DTIME"=>date("Y-m-d H:i:s", strtotime($_POST['dtime'])));
		$id = $this->getAddAjax($data, $_POST);
		$this->saveImages($_POST['itemimg'], $id);
		$this->saveIcons($_POST['itemicons'], $id);
		$this->saveBlocksTextsData($_POST['text'], $id);
		$this->saveBlocksImagesData($_POST['itemimg'], $id);
		$this->saveBlocksData($_POST['block'], $id);
		//$this->setIcons2x($id, "servicesicons");
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
			order by `td`.`NAME`
		";
		$this->parser['tr'] = $this->_parent->DB->getRowsBySQL($sql);
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_add");
	}

	function _editajax($id)
	{
		$data = Array("STATUS"=>$_POST['status'], "PID"=>$_POST['pid'], "TYPE"=>$type, "DTIME"=>date("Y-m-d H:i:s", strtotime($_POST['dtime'])));
		$this->getEditAjaxSave($id, $data, $_POST);
		$this->unsetImages($id);
		$this->saveImages($_POST['itemimg'], $id);
		$this->unsetIcons($id);
		$this->saveIcons($_POST['itemicons'], $id);
		$this->unsetBlocksData($id);
		$this->saveBlocksTextsData($_POST['text'], $id);
		$this->saveBlocksImagesData($_POST['itemimg'], $id);
		$this->saveBlocksData($_POST['block'], $id);
		//$this->setIcons2x($id, "servicesicons");
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
			from `tb_tree` as `t`
			inner join `tb_tree_data` as `td`
			on `t`.`ID`=`td`.`CID` and '".LANG."' = `td`.`LANGID`
			order by `td`.`NAME`
		";
		$this->parser['tr'] = $this->_parent->DB->getRowsBySQL($sql);
		$this->getEditAjax($id);
		$this->parser['images'] = $this->getImages($id);
		$this->parser['simages'] = $this->getIcons($id);
		$this->parser['blocks'] = $this->getBlocks($id);
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_edit");
	}

	function getData($url)
	{
		return $this->getDataByURL($url);
	}

}