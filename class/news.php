<?php 

class news extends textsdata
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "news";
		$this->datatable = "tb_news";
		$this->folder = "news";
		$this->images = "1";
		$this->langsdata = Array("NAME", "URL", "STEXT", "TEXT", "TITLE", "KW", "DESC");
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
		$sql = "delete from `tb_news` where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "delete from `tb_news_data` where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_news_blocks` set `CID`='0' where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_news_images` set `CID`='0' where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
	}

	function _addimage()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_news_images", "news", "CID", $id, 0, 0, 0, 1);
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
		$params['sort'] = Array("field"=>"DTIME", "type"=>"desc");
		$this->parser['items'] = $this->getLangData($params);
		$out = getTemplate("admin_" . $this->name . "_ajax_list");
		echo $out;
		exit();
	}

	function _addajax()
	{
		$data = Array("STATUS"=>$_POST['status'], "ACTUAL"=>$_POST['actual'], "FIRST"=>$_POST['first'], "DTIME"=>date("Y-m-d H:i:s", strtotime($_POST['dtime'])));
		$id = $this->getAddAjax($data, $_POST);
		$this->saveImages($_POST['itemimg'], $id);
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
		$data = Array("STATUS"=>$_POST['status'], "ACTUAL"=>$_POST['actual'], "FIRST"=>$_POST['first'], "DTIME"=>date("Y-m-d H:i:s", strtotime($_POST['dtime'])));
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
		$this->parser['blocks'] = $this->getBlocks($id);
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_edit");
	}

	function getDates()
	{
		$sql = "select distinct(year(`DTIME`)) as `year` from `tb_news` where `STATUS` = '1'";
		$res = $this->_parent->DB->getRowsBySQL($sql);
		return $res;
	}

	

}