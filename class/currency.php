<?php 

class currency extends textsdata
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "currency";
		$this->datatable = "tb_currency";
		$this->folder = "currency";
		$this->images = "1";
		$this->langsdata = Array("NAME");
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
		$sql = "delete from `tb_currency` where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "delete from `tb_currency_data` where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
	}

	function _addimage()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_currency_images", "currency", "CID", $id, 0, 0, 0, 1);
		$result = Array("id"=>$id, "typeid"=>getImageType($_FILES['file']['type']));
		echo json_encode($result);
		exit();
	}

	function _addicon()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_tree_icons", "servicesicons", "CID", $id, 0, 0, 0, 1);
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
		$data = Array("STATUS"=>$_POST['status'], "CODE"=>$_POST['code'], "COEF"=>$_POST['coef'], "LEFT"=>$left);
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

	function _editajax($id)
	{
		$data = Array("STATUS"=>$_POST['status'], "CODE"=>$_POST['code'], "COEF"=>$_POST['coef'],);
		$this->getEditAjaxSave($id, $data, $_POST);
		$this->unsetImages($id);
		$this->saveImages($_POST['itemimg'], $id);
		$out = getTemplate("admin_" . $this->name . "_edit_ajax");
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