<?php

class textsdata 
{
	
	var $name = "table";
	var $datatable = "tb_table";
	var $folder = "folder";
	var $langsdata = Array("NAME", "TEXT", "TITLE", "KW", "DESC");
	var $icons = 0;
	var $images = 0;
	var $files = 0;

	function setLeft($data)
	{
		if (count($data)>0)
		{
			foreach ($data as $k=>$v)
			{
				$left = $k+1;
				$sql = "update `".$this->datatable."` set `LEFT` = ".intval($left)." where `ID`=".intval($v)."";
				$this->_parent->DB->Query($sql);
			}
		}
	}

	function getLeft()
	{
		$sql = "select * from `".$this->datatable."` order by `LEFT` desc LIMIT 1";
		$rw = $this->_parent->DB->getRowBySQL($sql);
		if (isset($rw['LEFT']))
		{
			return intval($rw['LEFT']);
		}
		else
		{
			return 0;
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

	function unsetBlocksData($id)
	{
		$sql = "update `".$this->datatable . "_blocks` set `CID` = '0' where `CID` = '".$id."' ";
		$this->_parent->DB->Query($sql);
	}

	function saveBlocksData($arr, $id)
	{
		if (count($arr)>0)
		{
			foreach ($arr as $k=>$v)
			{
				$l = $k+1;
				$sql = "update `".$this->datatable . "_blocks` set `LEFT` = '".$l."' where `CID` = '".$id."' and `SORT` = '".$v."'";
				$this->_parent->DB->Query($sql);
			}
		}
	}
		
	function saveBlocksTextsData($arr, $id, $title=false)
	{
		if (count($arr)>0)
		{
			foreach ($arr as $k=>$v)
			{
				$a = Array("SORT"=>$k, "CID"=>$id, "TYPE"=>"1");
				$this->_parent->DB->insert($a, $this->datatable . "_blocks", $bid);
				if ((int)$bid>0)
				{
					foreach ($this->parser['langs'] as $lang)
					{

						$a = Array(
							"CID"=>$bid, 
							"LANGID"=>$lang['ID'],
							"TEXT"=>$v[$lang['ID']]
						);
						if ($title==true)
						{
							$a['NAME'] = $_POST['bname'][$k][$lang['ID']];
						}
						//print_r($a);
						$this->_parent->DB->insert($a, $this->datatable."_blocks_data", $vid);
					}
				}
			}
		}
	}

	function saveBlocksImagesData($arr, $id)
	{
		if (count($arr)>0)
		{
			foreach ($arr as $k=>$v)
			{
				if (is_array($v))
				{
					$a = Array("SORT"=>$k, "CID"=>$id, "TYPE"=>"2");
					$this->_parent->DB->insert($a, $this->datatable . "_blocks", $bid);
					if ((int)$bid>0)
					{
						foreach ($v as $a=>$b)
						{
							$l = $a + 1;
							$sql = "update `".$this->datatable . "_images` set `CID` = '".$id."' , `ST`='".$bid."' , `LEFT` = '".$l."' where `ID` = '".$b."'";
							$this->_parent->DB->Query($sql);
						}
					}
				}
			}
		}
	}

	function getBlocks($id)
	{
		$sql = "select * from `".$this->datatable."_blocks` where `CID` = '".$id."' order by `LEFT`";
		$res = $this->_parent->DB->getRowsBySQL($sql);
		return $res;
	}

	function getAddAjax($data, $langdata)
    {
		$arr = $data;
		$arr['CDTIME'] = date("Y-m-d H:i:s");
		$arr['EDTIME'] = date("Y-m-d H:i:s");
		if ($this->_parent->DB->insert($arr, $this->datatable, $id))
		{
			foreach ($this->parser['langs'] as $lang)
			{

				$arr = Array(
					"CID"=>$id, 
					"LANGID"=>$lang['ID']
				);
				foreach ($this->langsdata as $field)
				{
					$arr[$field] = $langdata[strtolower($field).'_'.$lang['ID']];
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

	function getDataByURL($url)
	{
		$res = Array();
		$sql = "select * from `".$this->datatable."_data` where `URL` = '".mysql_real_escape_string($url)."' and `LANGID` = '".LANG."'";
		$row = $this->_parent->DB->getRowBySQL($sql);
		$res['lang'] = $row;
		$sql = "select * from `".$this->datatable."` where `ID` = '".$row['CID']."'";
		$row = $this->_parent->DB->getRowBySQL($sql);
		$res['data'] = $row;
		return $res;
	}

	function getDataByID($id)
	{
		$res = Array();
		$sql = "select * from `".$this->datatable."_data` where `CID` = '".mysql_real_escape_string($id)."' and `LANGID` = '".LANG."'";
		$row = $this->_parent->DB->getRowBySQL($sql);
		$res['lang'] = $row;
		$sql = "select * from `".$this->datatable."` where `ID` = '".$row['CID']."'";
		$row = $this->_parent->DB->getRowBySQL($sql);
		$res['data'] = $row;
		if ($this->images=="1")
		{
			$sql = "select * from `".$this->datatable."_images` where `CID` = '".$id."' order by `LEFT`";
			$rows = $this->_parent->DB->getRowsBySQL($sql);
			$res['images'] = $rows;
		}
		return $res;
	}


	function getEditAjax($id)
    {

		$sql = "SELECT * FROM `".$this->datatable."_data` WHERE `CID`=".intval($id);
		if ($res = $this->_parent->DB->Query($sql))
		{
			while ($row=$this->_parent->DB->Fetch($res))
			{
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
		$arr = $data;
		$arr['EDTIME'] = date("Y-m-d H:i:s");
		$data['EDTIME'] = date("Y-m-d H:i:s");
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
						$arr[$field] = $langdata[strtolower($field).'_'.$lang['ID']];
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
						$arr[$field] = $langdata[strtolower($field).'_'.$lang['ID']];
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
		$where = "";
		$order = "";
		if (is_array($params['sort']))
		{
			$order = " order by `".$params['sort']['field']."` " . $params['sort']['type'];
		}
		if (isset($params['sq']))
		{
			$where .= "and " . $params['sq'];
		}
		

		$lgf = (is_array($langsfields)) ? $langsfields : $this->langsdata;
		$l = "";
		foreach ($lgf as $f)
		{
			$l .= ", `tbd`.`".$f."` as `LANG_".$f."`";
		}

		$sl = "";
		if ($this->images == "1")
		{
			$sl .= "
				,(select `ID` from `".$this->datatable."_images` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1) as `IMID`
				,(select `EXT` from `".$this->datatable."_images` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1) as `IMEXT`
			";
		}
		if ($this->dimages == "1")
		{
			$sl .= "
				,(select `ID` from `".$this->datatable."_images` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1,1) as `IMID2`
				,(select `EXT` from `".$this->datatable."_images` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1,1) as `IMEXT2`
			";
		}
		if ($this->size == "1")
		{
			$sl .= "
				,(select `WIDTH` from `".$this->datatable."_images` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1) as `IMWIDTH`
				,(select `HEIGHT` from `".$this->datatable."_images` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1) as `IMHEIGHT`
			";
		}
		if ($this->svg == "1")
		{
			$sl .= "
				,(select `ID` from `".$this->datatable."_images` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1,1) as `IMIDSVG`
				,(select `EXT` from `".$this->datatable."_images` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1,1) as `IMEXTSVG`
			";
		}
		if ($this->icons == "1")
		{
			$sl .= "
				,(select `ID` from `".$this->datatable."_icons` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1) as `ICOID`
				,(select `EXT` from `".$this->datatable."_icons` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1) as `ICOEXT`
			";
		}
		if ($this->files == "1")
		{
			$sl .= "
				,(select `NAME` from `".$this->datatable."_files` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1) as `FILENAME`
				,(select `ID` from `".$this->datatable."_files` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1) as `FILEID`
				,(select `EXT` from `".$this->datatable."_files` where `CID` = `tb`.`ID` order by `LEFT` LIMIT 1) as `FILEEXT`
			";
		}
		if ($params['cnt']!='')
		{
			$sl .= "
				,(select COUNT(*) as cnt from `".$this->datatable."` where `".$params['cnt']."` = `tb`.`ID` ) as `cnt`
			";
		}

        $sql = "
			select
				`tb`.*
				".$sl."
				".$l."
			from `".$this->datatable."` `tb`
			left join `".$this->datatable."_data` as `tbd`
			on `tb`.`ID` = `tbd`.`CID` and '".LANG."'=`tbd`.`LANGID`
			where 1=1 ".$where."
			".$order."
		";

        return $this->_parent->DB->getRowsBySQL($sql);
    
	}

	function delImage($id, $ext)
	{
		if (file_exists("loads/".$this->folder."/" . $id . "." . $ext))
		{
			@unlink("loads/".$this->folder."/" . $id . "." . $ext);
		}
		$sql = "delete from `".$this->datatable."_images` where `ID`='".$id."'";
		$this->_parent->DB->Query($sql);
	}

	function deleteImages($id)
	{
		$sql = "select * from `".$this->datatable."_images` where `CID` = '".$id."'";
		if ($res = $this->_parent->DB->Query($sql))
		{
			while ($row = $this->_parent->DB->Fetch($res))
			{
				$this->delImage($row['ID'], $row['EXT']);
			}
		}
	}

	function unsetImages($id)
	{
		$sql = "update `".$this->datatable."_images` set `CID` = '0' where `CID` = '".$id."'";
		$this->_parent->DB->Query($sql);
	}

	function unsetIcons($id)
	{
		$sql = "update `".$this->datatable."_icons` set `CID` = '0' where `CID` = '".$id."'";
		$this->_parent->DB->Query($sql);
	}

	function unsetFiles($id)
	{
		$sql = "update `".$this->datatable."_files` set `CID` = '0' where `CID` = '".$id."'";
		$this->_parent->DB->Query($sql);
	}

	function setIcons2x($id, $folder)
	{
		$sql = "select * from `".$this->datatable."_icons` where `CID` = '".$id."' order by `LEFT`";
		$rows = $this->_parent->DB->getRowsBySQL($sql);
		if (count($rows)>1)
		{
			//echo getcwd();
			//echo "<pre>";
			//print_r($rows);
			//echo "11" . "/loads/".$folder."/".$rows['1']['ID'].".".$rows['1']['EXT'];
			if (copy("loads/".$folder."/".$rows['1']['ID'].".".$rows['1']['EXT'], "loads/".$folder."/".$rows['0']['ID']."@2x.".$rows['1']['EXT']))
			{
				//echo "ok";
			}
			else
			{
				//echo "bad";
			}
			//echo "22";
		}
	}

	function saveImages($arr, $id)
	{
		if (is_array($arr))
		{
			if (count($arr)>0)
			{
				$nm = 0;
				foreach ($arr as $img)
				{
					if (!is_array($img))
					{
						$nm++;
						$sql = "update `".$this->datatable."_images` set `CID`='".$id."' , `LEFT`='".$nm."' , `STATUS`='0' where `ID`='".$img."'";
						$this->_parent->DB->Query($sql);
					}
				}
			}
		}
	}

	function saveIcons($arr, $id)
	{
		if (is_array($arr))
		{
			if (count($arr)>0)
			{
				$nm = 0;
				foreach ($arr as $img)
				{
					$nm++;
					$sql = "update `".$this->datatable."_icons` set `CID`='".$id."' , `LEFT`='".$nm."' , `STATUS`='0' where `ID`='".$img."'";
					$this->_parent->DB->Query($sql);
				}
			}
		}
	}

	function saveFiles($arr, $id)
	{
		if (is_array($arr))
		{
			if (count($arr)>0)
			{
				$nm = 0;
				foreach ($arr as $img)
				{
					$nm++;
					$sql = "update `".$this->datatable."_files` set `CID`='".$id."' , `LEFT`='".$nm."' , `STATUS`='0' where `ID`='".$img."'";
					$this->_parent->DB->Query($sql);
				}
			}
		}
	}

	function getImages($id)
	{
		$sql = "select * from `".$this->datatable."_images` where `CID` = ".intval($id)." and `ST`='0' order by `LEFT`";
		$res = $this->_parent->DB->getRowsBySQL($sql);
		return $res;
	}

	function getFiles($id)
	{
		$sql = "select * from `".$this->datatable."_files` where `CID` = ".intval($id)." order by `LEFT`";
		$res = $this->_parent->DB->getRowsBySQL($sql);
		return $res;
	}

	function getIcons($id)
	{
		$sql = "select * from `".$this->datatable."_icons` where `CID` = ".intval($id)." order by `LEFT`";
		$res = $this->_parent->DB->getRowsBySQL($sql);
		return $res;
	}

}

?>