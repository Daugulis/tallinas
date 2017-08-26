<?php 

class main extends textsdata
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "main";
		$this->datatable = "tb_main";
		$this->folder = "main";
		$this->images = "1";
		$this->langsdata = Array("NAME", "TEXT", "URL");
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
		$sql = "delete from `tb_main` where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "delete from `tb_main_data` where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "delete from `tb_main_images` where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
	}

	function _addimage()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_main_images", "main", "CID", $id, 0, 0, 0, 1);
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
		$params = Array();
		$params['sort'] = Array("field"=>"LEFT", "type"=>"asc");
		$this->parser['items'] = $this->getLangData($params);
		$out = getTemplate("admin_" . $this->name . "_ajax_list");
		echo $out;
		exit();
	}

	function _addajax()
	{
		$left = $this->getLeft() + 1;
		$data = Array("STATUS"=>$_POST['status'], "LEFT"=>$left);
		$id = $this->getAddAjax($data, $_POST);
		$this->saveImages($_POST['itemimg'], $id);
		$out = getTemplate("admin_" . $this->name . "_add_ajax");
		echo $out;
		exit();
	}

	function _add()
	{
		$out = getTemplate("admin_" . $this->name . "_add");
		echo $out;
		exit();
	}

	function _settings()
	{
		if ($_POST['data']=='1')
		{
			$arr = Array(
				"TIMEOUT" => $_POST['timeout'],
				"ETIMEOUT" => $_POST['etimeout'],
				"HEIGHT" => $_POST['height'],
				"TYPE" => $_POST['type'],
				"EIMGIN" => $_POST['eimgin'],
				"EIMGOUT" => $_POST['eimgout'],
				"EIMGIND" => $_POST['eimgind'],
				"EIMGOUTD" => $_POST['eimgoutd'],
				"ETEXTIN" => $_POST['etextin'],
				"ETEXTOUT" => $_POST['etextout'],
				"ETEXTIND" => $_POST['etextind'],
				"ETEXTOUTD" => $_POST['etextoutd']
			);
			$this->_parent->DB->update($arr, 'tb_main_settings', ' `ID` = 1');
			exit();
		}
		$sql = "select * from `tb_main_settings`";
		$rw = $this->_parent->DB->getRowBySQL($sql);
		arrToParser($rw, 'd');
		$out = getTemplate("admin_" . $this->name . "_settings");
		echo $out;
		exit();
	}

	function _editajax($id)
	{
		$data = Array("STATUS"=>$_POST['status'], "CID"=>$_POST['cid']);
		$this->getEditAjaxSave($id, $data, $_POST);
		$out = getTemplate("admin_" . $this->name . "_edit_ajax");
		$this->unsetImages($id);
		$this->saveImages($_POST['itemimg'], $id);
		echo $out;
		exit();
	}

	function _edit($id)
	{
		$this->getEditAjax($id);
		$this->parser['images'] = $this->getImages($id);
		$out = getTemplate("admin_" . $this->name . "_edit");
		echo $out;
		exit();
	}

}