<?php

class sampledata 
{
	
	var $name = "table";
	var $datatable = "tb_table";
	var $langsdata = Array("NAME", "TEXT", "TITLE", "KW", "DESC");

	function setLeft()
	{
		if (count($_POST['items'])>0)
		{
			foreach ($_POST['items'] as $k=>$v)
			{
				$left = $k+1;
				$sql = "update `".$this->datatable."` set `LEFT` = ".intval($left)." where `ID`=".intval($v)."";
				$this->_parent->DB->Query($sql);
			}
		}
	}

	function setStatus($id)
	{
		$sql = "select * from `".$this->datatable."` where `ID`=".intval($id)."";
		$rw = $this->_parent->DB->getRowBySQL($sql);
		$status = ($rw['STATUS']=="1") ? "0" : "1";
		$sql = "update `".$this->datatable."` set `STATUS`=".intval($status)." where `ID`=".intval($id);
		$this->_parent->DB->Query($sql);
		$arr = Array("id"=>intval($id), "status"=>$status);
		return json_encode($arr);
	}

	function getAddAjax($data, $langdata)
    {
		if ($this->_parent->DB->insert($data, $this->datatable, $id))
		{
			foreach ($this->parser['langs'] as $lang)
			{

				$arr = Array(
					"CID"=>$id, 
					"LANGID"=>$lang['ID'],
					"NAME"=>$_POST['name_'.$lang['ID']]
				);
				foreach ($this->langsdata as $field)
				{
					$arr[$field] = $langdata[$field.'_'.$lang['ID']];
				}
				$this->_parent->DB->insert($arr, $this->datatable."_data", $vid);
			}
			return $id;
		}
		else
		{
			return false;
		}
    }

	function getEditAjax($id)
    {

		$sql = "SELECT * FROM `".$this->datatable."_data` WHERE `CID`=".intval($id);
		if ($res = $this->_parent->DB->Query($sql))
		{
			while ($row=$this->_parent->DB->Fetch($res))
			{
				$this->parser['d_name_'.$row['LANGID']] = $row['NAME'];
				foreach ($this->langsdata as $field)
				{
					$this->parser['d_'.strtolower($field).'_'.$row['LANGID']] = $row[$field];
				}
			}
		}
        
		$SQL = "SELECT n.* FROM `".$this->datatable."` as n WHERE `ID`=".intval($id);
		$row = $this->_parent->DB->getRowBySQL($SQL);
		arrToParser($row, "d");		

    }

	function getEditAjaxSave($id, $data, $langdata)
    {
		if ($this->_parent->DB->Update($data, $this->datatable, " `ID` = ".intval($id)))
		{
			foreach ($this->parser['langs'] as $lang)
			{
				$sql = "select * from `".$this->datatable."_data` where `CID`=".intval($id)." and `LANGID`=".intval($lang['ID']);
				$rww = $this->_parent->DB->getRowBySQL($sql);
				if ($rww['ID']>0)
				{
					$arr = Array();
					foreach ($this->langsdata as $field)
					{
						$arr[$field] = $langdata[$field.'_'.$lang['ID']];
					}
					$this->_parent->DB->update($arr, $this->datatable."_data", " `CID` = ".intval($id)." and `LANGID`=".intval($lang['ID']));
				}
				else
				{

					$arr = Array(
						"CID"=>$id, 
						"LANGID"=>$lang['ID']
					);
					foreach ($this->langsdata as $field)
					{
						$arr[$field] = $langdata[$field.'_'.$lang['ID']];
					}
					$this->_parent->DB->insert($arr, $this->datatable."_data", $vid);
				}
			}											
		}

    }

	function getData($params = 0, $fields = 0)
    {

		$order = "";
		if (is_array($params['sort']))
		{
			$order = " order by `".$params['sort']['field']."` " . $params['sort']['type'];
		}

        $sql = "
			select
				`tb`.*
			from `".$this->datatable."` `tb`
			".$order."
		";

        return $this->_parent->DB->getRowsBySQL($sql);
    
	}

	function getLangData($params = 0, $fields = 0, $langsfields = 0)
    {

		$order = "";
		if (is_array($params['sort']))
		{
			$order = " order by `".$params['sort']['field']."` " . $params['sort']['type'];
		}

		$lgf = (is_array($langsfields)) ? $langsfields : $this->langsdata;
		$l = "";
		foreach ($lgf as $l)
		{
			$l .= ", `tbd`.`".$l."` as `LANG_".$l."`";
		}

        $sql = "
			select
				`tb`.*
				".$l."
			from `".$this->datatable."` `tb`
			inner join `".$this->datatable."_data` as `tbd`
			on `tb`.`ID` = `tbd`.`CID` and '".LANG."'=`tbd`.`LANGID`
			".$order."
		";

        return $this->_parent->DB->getRowsBySQL($sql);
    
	}

}

?>