<?php 

class prices extends textsdata
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "prices";
		$this->datatable = "tb_prices";
		$this->folder = "prices";
		$this->images = "1";
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
		$sql = "delete from `tb_prices` where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "delete from `tb_prices_data` where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_prices_images` set `CID`='0' where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);		
	}

	function _addimage()
	{
		$id = intval(ID);
		$arr = explode('.', strtolower($_FILES['file']['name']));
		$ext = $arr[count($arr)-1];
		$id = saveImage($_FILES['file'], "tb_prices_images", "prices", "CID", $id, 0, 0, 0, 1);
		$result = Array("id"=>$id, "typeid"=>getImageType($_FILES['file']['type']), "ext"=>$ext, "name"=>$_FILES['file']['name']);
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
		$params['sort'] = Array("field"=>"LEFT", "type"=>"asc");
		$this->parser['items'] = $this->getLangData($params);
		$out = getTemplate("admin_" . $this->name . "_ajax_list");
		echo $out;
		exit();
	}

	function _addajax()
	{
		$left = $this->getLeft() + 1;
		$data = Array("STATUS"=>$_POST['status'], "PID"=>$_POST['pid'], "NACENKA"=>$_POST['nacenka'], "PRICE"=>$_POST['price'], "MPRICE"=>$_POST['mprice'], "LEFT"=>$left, "DTIME"=>date("Y-m-d H:i:s", strtotime($_POST['dtime'])));
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
		$data = Array("STATUS"=>$_POST['status'], "PID"=>$_POST['pid'], "NACENKA"=>$_POST['nacenka'], "PRICE"=>$_POST['price'], "MPRICE"=>$_POST['mprice'], "DTIME"=>date("Y-m-d H:i:s", strtotime($_POST['dtime'])));
		$this->getEditAjaxSave($id, $data, $_POST);
		$this->unsetImages($id);
		$this->saveImages($_POST['itemimg'], $id);
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
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_edit");
	}

	function getData($url)
	{
		return $this->getDataByURL($url);
	}

}