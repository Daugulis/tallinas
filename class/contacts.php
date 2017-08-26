<?php 

class contacts extends textsdata
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "contactsnew";
		$this->datatable = "tb_contactsnew";
		$this->folder = "contactsnew";
		//$this->images = "1";
		$this->langsdata = Array("NAME", "ADDRESS", "EMAIL", "EMAIL2", "EMAIL3", "PHONE", "PHONE2", "PHONE3", "SKYPE", "SKYPE2", "SKYPE3");
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
		$sql = "delete from `tb_contactsnew` where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "delete from `tb_contactsnew_data` where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);		
	}

	function _addimage()
	{
		$id = intval(ID);
		$arr = explode('.', strtolower($_FILES['file']['name']));
		$ext = $arr[count($arr)-1];
		$id = saveImage($_FILES['file'], "tb_contactsnew_images", "contactsnew", "CID", $id, 0, 0, 0, 1);
		$result = Array("id"=>$id, "typeid"=>getImageType($_FILES['file']['type']), "ext"=>$ext, "name"=>$_FILES['file']['name']);
		echo json_encode($result);
		exit();
	}

	function _list()
	{
		$sql = "
			select
				a.* 
			from `tb_admin_users` as `a`
			order by a.`NAME` 
		";
		$this->parser['users'] = $this->_parent->DB->getRowsBySQL($sql);
		//$this->parser['items'] = $this->getData();
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_list");
	}

	function _listajax()
	{
		$params = Array();
		$params['sort'] = Array("field"=>"LEFT", "type"=>"asc");
		$params['sq'] = " `UID`='".$_POST['utype']."' ";
		$this->parser['items'] = $this->getLangData($params);
		$out = getTemplate("admin_" . $this->name . "_ajax_list");
		echo $out;
		exit();
	}

	function _addajax()
	{
		$left = $this->getLeft() + 1;
		$data = Array("STATUS"=>$_POST['status'], "EMAIL"=>$_POST['email'], "REGNR"=>$_POST['regnr'], "PHONE1"=>$_POST['phone1'], "PHONE2"=>$_POST['phone2'], "UID" => UID, "LAT"=>$_POST['lat'], "LNG"=>$_POST['lng'], "ADDRESS"=>$_POST['formatted_address'], "DTIME"=>date("Y-m-d H:i:s", strtotime($_POST['dtime'])));
		$id = $this->getAddAjax($data, $_POST);
		$out = getTemplate("admin_" . $this->name . "_add_ajax");
		echo $out;
		exit();
	}

	function _add()
	{
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_add");
	}

	function _editajax($id)
	{
		$data = Array("STATUS"=>$_POST['status'], "EMAIL"=>$_POST['email'], "REGNR"=>$_POST['regnr'], "PHONE1"=>$_POST['phone1'], "PHONE2"=>$_POST['phone2'], "LAT"=>$_POST['lat'], "LNG"=>$_POST['lng'], "ADDRESS"=>$_POST['formatted_address'], "DTIME"=>date("Y-m-d H:i:s", strtotime($_POST['dtime'])));
		$this->getEditAjaxSave($id, $data, $_POST);
		$out = getTemplate("admin_" . $this->name . "_edit_ajax");
		echo $out;
		exit();
	}

	function _edit($id)
	{
		$this->getEditAjax($id);
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_edit");
	}

	function getData($url)
	{
		return $this->getDataByURL($url);
	}

}