<?php 

class questions extends textsdata
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "questions";
		$this->datatable = "tb_questions";
		$this->langsdata = Array("NAME", "URL");
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
		$sql = "delete from `tb_questions` where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
	}

	function _list()
	{
		$sql = "select * from `tb_questions` order by `CDTIME` desc";
		$this->parser['items'] = $this->_parent->DB->getRowsBySQL($sql);
		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_list");
	}

	function _listajax()
	{
		$sql = "select * from `tb_questions` order by `CDTIME` desc";
		$this->parser['items'] = $this->_parent->DB->getRowsBySQL($sql);
		$out = getTemplate("admin_" . $this->name . "_ajax_list");
		echo $out;
		exit();
	}

	function _addajax()
	{
		$left = $this->getLeft() + 1;
		$data = Array("STATUS"=>$_POST['status'], "BG"=>$_POST['bg'], "COLOR"=>$_POST['color'], "LEFT"=>$left);
		$id = $this->getAddAjax($data, $_POST);
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
		$data = Array("STATUS"=>$_POST['status'], "BG"=>$_POST['bg'], "COLOR"=>$_POST['color']);
		$this->getEditAjaxSave($id, $data, $_POST);
		$out = getTemplate("admin_" . $this->name . "_edit_ajax");
		echo $out;
		exit();
	}

	function _edit($id)
	{
		$this->getEditAjax($id);
		$out = getTemplate("admin_" . $this->name . "_edit");
		echo $out;
		exit();
	}

}