<?php 

class texts extends textsdata
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "texts";
		$this->datatable = "tb_texts";
		$this->folder = "texts";
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
		$sql = "delete from `tb_texts` where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "delete from `tb_texts_data` where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_texts_images` set `CID`='0' where `CID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
	}

	function _addimage()
	{
		$id = intval(ID);
		$id = saveImage($_FILES['file'], "tb_texts_images", "texts", "CID", $id, 0, 0, 0, 1);
		$result = Array("id"=>$id, "typeid"=>getImageType($_FILES['file']['type']));
		echo json_encode($result);
		exit();
	}

	function _list()
	{
		$sql = "
			select
				s.* ,
				`sd`.`NAME`
			from `tb_tree` as `s`
			inner join `tb_tree_data` as `sd`
			on `s`.`ID` = `sd`.`CID` and '".LANG."' = `sd`.`LANGID`
			order by `s`.`LEFT`
		";
		$this->parser['tree'] = $this->_parent->DB->getRowsBySQL($sql);

		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_list");
	}

	function _listajax()
	{
		$params = Array();
		$params['sort'] = Array("field"=>"LEFT", "type"=>"asc");
		if ($_POST['utype']!='all')
		{
			$params['sq'] = " `PID`='".intval($_POST['utype'])."' ";
		}
		$this->parser['items'] = $this->getLangData($params);
		if (count($this->parser['items'])>0)
		{
			foreach ($this->parser['items'] as $k=>$v)
			{
				$sql = "select `NAME` from `tb_tree_data` where `CID` = '".$v['PID']."' and `LANGID` = '".LANG."'";
				$rw = $this->_parent->DB->getRowBySQL($sql);
				$this->parser['items'][$k]['TNAME'] = $rw['NAME'];
			}
		}
		$out = getTemplate("admin_" . $this->name . "_ajax_list");
		echo $out;
		exit();
	}

	function _addajax()
	{
		$left = $this->getLeft() + 1;
		$data = Array("STATUS"=>$_POST['status'], "LEFT"=>$left, "FOOTER"=>$_POST['footer'], "PID"=>$_POST['pid']);
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
			from `tb_tree` as `s`
			inner join `tb_tree_data` as `sd`
			on `s`.`ID` = `sd`.`CID` and '".LANG."' = `sd`.`LANGID`
			order by `s`.`LEFT`
		";
		$this->parser['tree'] = $this->_parent->DB->getRowsBySQL($sql);

		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_add");
	}

	function _editajax($id)
	{
		$data = Array("STATUS"=>$_POST['status'], "FOOTER"=>$_POST['footer'], "PID"=>$_POST['pid']);
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
				s.* ,
				`sd`.`NAME`
			from `tb_tree` as `s`
			inner join `tb_tree_data` as `sd`
			on `s`.`ID` = `sd`.`CID` and '".LANG."' = `sd`.`LANGID`
			order by `s`.`LEFT`
		";
		$this->parser['tree'] = $this->_parent->DB->getRowsBySQL($sql);
		$this->getEditAjax($id);
		$this->parser['images'] = $this->getImages($id);
		$this->parser['blocks'] = $this->getBlocks($id);
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_edit");
	}

	function getDates()
	{
		$sql = "select distinct(year(`DTIME`)) as `year` from `tb_texts` where `STATUS` = '1'";
		$res = $this->_parent->DB->getRowsBySQL($sql);
		return $res;
	}

	

}