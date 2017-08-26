<?php 

class documents extends textsdata
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "documents";
		$this->datatable = "tb_documents";
		$this->folder = "documents";
		$this->langsdata = Array("NAME", "URL", "STEXT", "TITLE", "KW", "DESC");
		$this->files = "1";
		//include_once "class/categories.php";
		//$this->categoies = new categories();
		//$this->categoies->init($_parent);
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
		$sql = "delete from `tb_documents` where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "delete from `tb_documents_data` where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_documents_files` set `CID`='0' where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
	}

	function _addimage()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_services_images", "services", "CID", $id, 0, 0, 0, 1);
		$arr = explode(".", $_FILES['file']['name']);
		$ext = strtolower($arr[count($arr)-1]);
		$docico = getDocIcoID($ext);
		$result = Array("id"=>$id, "typeid"=>getImageType($_FILES['file']['type']), "ico"=>$docico);
		echo json_encode($result);
		exit();
	}

	function _addicon()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_services_icons", "servicesicons", "CID", $id, 0, 0, 0, 1);
		$arr = explode(".", $_FILES['file']['name']);
		$ext = strtolower($arr[count($arr)-1]);
		$docico = getDocIcoID($ext);
		$result = Array("id"=>$id, "typeid"=>getImageType($_FILES['file']['type']), "ico"=>$docico);
		echo json_encode($result);
		exit();
	}

	function _addfile()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_documents_files", "documents", "CID", $id, 0, 0, 0, 1);
		$arr = explode(".", $_FILES['file']['name']);
		//print_r($arr);
		$ext = strtolower($arr[count($arr)-1]);
		$docico = getDocIcoID($ext);
		$result = Array("id"=>$id, "name"=>$_FILES['file']['name'], "typeid"=>getImageType($_FILES['file']['type']), "ico"=>$docico);
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
		//print_r($_POST);
		//exit();
		$left = $this->getLeft() + 1;
		$data = Array("STATUS"=>$_POST['status'], "LEFT"=>$left, "PID"=>$_POST['pid']);
		$id = $this->getAddAjax($data, $_POST);
		$this->saveFiles($_POST['itemfiles'], $id);
		$out = getTemplate("admin_" . $this->name . "_add_ajax");
		echo $out;
		exit();
	}

	function _add()
	{
		
		$sql = "
			select 
				c.* ,
				`cd`.`NAME` as `LANG_NAME`
			from `tb_categories` as `c`
			inner join `tb_categories_data` as `cd`
			on `c`.`ID`=`cd`.`CID` and '".LANG."' = `cd`.`LANGID`
			order by `c`.`LEFT`
		";
		$this->parser['categories'] = $this->_parent->DB->getRowsBySQL($sql);

		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_add");
	}

	function _editajax($id)
	{
		$data = Array("STATUS"=>$_POST['status'], "PID"=>$_POST['pid'], "DTIME"=>date("Y-m-d H:i:s", strtotime($_POST['dtime'])));
		$this->getEditAjaxSave($id, $data, $_POST);
		$this->unsetFiles($id);
		$this->saveFiles($_POST['itemfiles'], $id);
		$out = getTemplate("admin_" . $this->name . "_edit_ajax");
		echo $out;
		exit();
	}

	function _edit($id)
	{

		$sql = "
			select 
				c.* ,
				`cd`.`NAME` as `LANG_NAME`
			from `tb_categories` as `c`
			inner join `tb_categories_data` as `cd`
			on `c`.`ID`=`cd`.`CID` and '".LANG."' = `cd`.`LANGID`
			order by `c`.`LEFT`
		";
		$this->parser['categories'] = $this->_parent->DB->getRowsBySQL($sql);

		$this->getEditAjax($id);
		$this->parser['files'] = $this->getFiles($id);
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_edit");
	}

	function getData($url)
	{
		return $this->getDataByURL($url);
	}

}