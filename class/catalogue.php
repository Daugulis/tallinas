<?php 

class catalogue extends textsdata
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "catalog";
		$this->datatable = "tb_catalog";
		$this->folder = "catalog";
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
		$sql = "delete from `tb_catalog` where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "delete from `tb_catalog_data` where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_catalog_images` set `CID`='0' where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
	}

	function _addimage()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_catalog_images", "catalog", "CID", $id, 0, 0, 0, 1);
		$result = Array("id"=>$id, "typeid"=>getImageType($_FILES['file']['type']));
		echo json_encode($result);
		exit();
	}

	function _addicon()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_services_images", "servicesicons", "CID", $id, 0, 0, 0, 1);
		if (getImageType($_FILES['file']['type'])!='9')
		{
			list($width, $height, $type, $attr) = getimagesize($_FILES['file']['tmp_name']);
			$sql = "update `tb_services_images` set `WIDTH` = '".$width."' , `HEIGHT` = '".$height."' where `ID` = '".$id."'";
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
		$params = Array();
		$params['sort'] = Array("field"=>"NUMBER", "type"=>"asc");
		$this->parser['items'] = $this->getLangData($params);
		$out = getTemplate("admin_" . $this->name . "_ajax_list");
		echo $out;
		exit();
	}

	function _addajax()
	{
		//print_r($_POST);
		//exit();
		$left = $this->getLeft() + 1;
		$data = Array("STATUS"=>$_POST['status'], "LEFT"=>$left, "NUMBER"=>$_POST['number'], "PRICE"=>$_POST['price'], "FLOOR"=>$_POST['floor'], "AREA"=>$_POST['area'], "ROOMS"=>$_POST['rooms']);
		$id = $this->getAddAjax($data, $_POST);
		$this->saveImages($_POST['itemimg'], $id);
		$out = getTemplate("admin_" . $this->name . "_add_ajax");
		echo $out;
		exit();
	}

	function _add()
	{

		$sql = "
			select
				s.* ,
				`sd`.`NAME`
			from `tb_categories` as `s`
			inner join `tb_categories_data` as `sd`
			on `s`.`ID` = `sd`.`CID` and '".LANG."' = `sd`.`LANGID`
			order by `s`.`LEFT`
		";
		$this->parser['services'] = $this->_parent->DB->getRowsBySQL($sql);

		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_add");
	}

	function _editajax($id)
	{
		$data = Array("STATUS"=>$_POST['status'], "NUMBER"=>$_POST['number'], "FLOOR"=>$_POST['floor'], "PRICE"=>$_POST['price'], "AREA"=>$_POST['area'], "ROOMS"=>$_POST['rooms']);
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
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_edit");
	}

	function getData($url)
	{
		return $this->getDataByURL($url);
	}

}