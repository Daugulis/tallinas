<?php 

class offers extends textsdata
{

	function init(&$_parent, $import="0")
	{
		global $parser;
		$this->parser = &$parser;
		$this->_parent = &$_parent;
		$this->name = "orders";
		$this->datatable = "tb_orders";
		$this->images = "0";
		$this->langsdata = Array();
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

	function _savecomment()
	{
		$sql = "update `tb_orders` set `INFO`='".$_POST['cm']."' where `ID`='".$_POST['id']."'";
		$this->_parent->DB->Query($sql);
		exit();
	}

	function _deletepr()
	{
		$sql = "update `tb_orders` set `PRTYPE` = '0' where `ID` = '".$_POST['id']."'";
		$this->_parent->DB->Query($sql);
		exit();
	}

	function _setpr()
	{
		$sql = "update `tb_orders` set `PRTYPE` = '1' where `ID` = '".$_POST['id']."'";
		$this->_parent->DB->Query($sql);
		exit();
	}

	function _deleterating()
	{
		$sql = "select * from `tb_tenders` where `ID` = '".$_POST['id']."'";
		$rw = $this->_parent->DB->getRowBySql($sql);
		$sql = "update `tb_tenders_companies` set `RATING` = '0' where `TID` = '".$_POST['id']."' and `CID` = '".$rw['BEST']."'";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_tenders` set `DTYPE` = '0' where `ID` = '".$_POST['id']."'";
		$this->_parent->DB->Query($sql);
		updateCompaniesRating($rw['BEST']);
		$sql = "select * from `tb_companies` where `ID` = '".$rw['BEST']."'";
		$rw = $this->_parent->DB->getRowBySql($sql);
		
		echo $rw['RATING'];
		exit();
	}

	function _setrating()
	{
		$sql = "select * from `tb_tenders` where `ID` = '".$_POST['id']."'";
		$rw = $this->_parent->DB->getRowBySql($sql);
		$sql = "update `tb_tenders_companies` set `RATING` = '".$_POST['rating']."' where `TID` = '".$_POST['id']."' and `CID` = '".$rw['BEST']."'";
		$this->_parent->DB->Query($sql);
		$sql = "update `tb_tenders` set `DTYPE` = '1' where `ID` = '".$_POST['id']."'";
		$this->_parent->DB->Query($sql);
		updateCompaniesRating($rw['BEST']);
		$sql = "select * from `tb_companies` where `ID` = '".$rw['BEST']."'";
		$rw = $this->_parent->DB->getRowBySql($sql);
		echo $rw['RATING'];
		exit();
	}

	function _openclosed()
	{
		$sql = "select * from `tb_tenders` where `ID` = '".$_POST['id']."'";
		$rw = $this->_parent->DB->getRowBySql($sql);
		//print_r($rw);
		echo getTemplate('admin_tender_closed');
		exit();
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
		$sql = "update `tb_orders` set `DELETED` = '1' where `ID` in (".$ids.")";
		$this->_parent->DB->Query($sql);
	}

	function _list()
	{
		$sql = "
			select
				`t`.`ID`,
				`td`.`NAME`,
				(select count(*) from `tb_tenders` where `CID` = `t`.`ID`) as `cnt`
			from `tb_tree` as `t`
			inner join `tb_tree_data` as `td`
			on `t`.`ID` = `td`.`CID` and '".LANG."' = `td`.`LANGID`
			where `t`.`TYPE` = '1'
			order by `td`.`NAME`
		";
		$this->parser['tr'] = $this->_parent->DB->getRowsBySQL($sql);

		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_list");
	}

	function _tlist()
	{
		$sql = "
			select
				`t`.`ID`,
				`td`.`NAME`,
				(select count(*) from `tb_tenders` where `CID` = `t`.`ID`) as `cnt`
			from `tb_tree` as `t`
			inner join `tb_tree_data` as `td`
			on `t`.`ID` = `td`.`CID` and '".LANG."' = `td`.`LANGID`
			where `t`.`TYPE` = '1'
			order by `td`.`NAME`
		";
		$this->parser['tr'] = $this->_parent->DB->getRowsBySQL($sql);

		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_tlist");
	}

	function _listajax()
	{
		$sq = '';
		if ($_POST['prtype']!='all')
		{
			$sq .= " and `t`.`PRTYPE` = '".$_POST['prtype']."'";
		}
		$sql = "
			select
				`t`.* ,
				( select `NAME` from `tb_competitions_data` where `CID` = `t`.`CID` and `LANGID` = '".LANG."' ) as `CNAME`,
				( select `NAME` from `tb_nominations_data` where `CID` = `t`.`NID` and `LANGID` = '".LANG."' ) as `NNAME`
			from `tb_orders` as `t`
			where `t`.`DELETED` = '0' ".$sq."
			order by `t`.`DTIME` desc
		";
		$this->parser['items'] = $this->_parent->DB->getRowsBySQL($sql);
		$out = getTemplate("admin_" . $this->name . "_ajax_list");
		echo $out;
		exit();
	}

	function _tlistajax()
	{
		$sq = '';
		if ($_POST['vtype']>0)
		{
			$sq .= " and `t`.`CID` = '".$_POST['vtype']."'";
		}
		if ($_POST['dtype']=='1')
		{
			$sq .= " and `t`.`EDTIME` > NOW()";
		}
		if ($_POST['dtype']=='2')
		{
			$sq .= " and `t`.`EDTIME` <= NOW()";
		}
		$sql = "
			select
				`t`.* ,
				(select count(*) from `tb_tenders_companies` where `STATUS` = '1' and `TID` = `t`.`ID`) as `cnt`
			from `tb_tenders` as `t`
			where `t`.`DELETED` = '0' ".$sq."
			order by `t`.`DTIME` desc
		";
		$this->parser['items'] = $this->_parent->DB->getRowsBySQL($sql);
		$out = getTemplate("admin_" . $this->name . "_ajax_tlist");
		echo $out;
		exit();
	}

	function _editajax($id)
	{
		$data = Array(
				"STATUS"=>$_POST['status'], 
				"TYPE" => $_POST['type'],
				"OTYPE" => $_POST['otype'],
				"VTYPE" => $_POST['vtype'],
				"PTYPE" => $_POST['ptype'],
				"NAME" => $_POST['name'],
				"PHONE" => $_POST['phone'],
				"EMAIL" => $_POST['email'],
				"CNAME" => $_POST['cname'],
				"VES" => $_POST['ves'],
				"OBJOM" => $_POST['objom'],
				"PRICE" => $_POST['price'],
				"FROM" => $_POST['from'],
				"TO" => $_POST['to'],
				"DATE" => date("Y-m-d", strtotime($_POST['dtime'])),
				"DTIME" => date("Y-m-d H:i:s", strtotime($_POST['dtime'])),
				"EDATE" => date("Y-m-d", strtotime($_POST['edtime'])),
				"EDTIME" => date("Y-m-d H:i:s", strtotime($_POST['edtime']))
		);
		$this->_parent->DB->update($data, 'tb_tenders', " `ID` = '".$id."' ");

		if (count($_POST['tprice'])>0)
		{
			foreach ($_POST['tprice'] as $k=>$v)
			{
				$arr = Array(
					"PRICE" => $_POST['tprice'][$k],
					"SROK" => $_POST['tsrok'][$k],
					"DATE" => date("Y-m-d", strtotime($_POST['tdtime'][$k])),
					"DTIME" => date("Y-m-d H:i:s", strtotime($_POST['tdtime'][$k])),
				);
				$this->_parent->DB->update($arr, 'tb_tenders_companies', " `ID` = '".$k."' ");
			}
		}

		$out = getTemplate("admin_" . $this->name . "_edit_ajax");
		echo $out;
		exit();
	}

	function _edit($id)
	{
		$sql = "select * from `tb_tenders` where `ID` = '".$id."'";
		$row = $this->_parent->DB->getRowBySQL($sql);
		arrToParser($row, "d");

		$sql = "
			select 
				`tc`.* ,
				(select `ID` from `tb_companies_images` where `CID` = `tc`.`CID` order by `LEFT` limit 1) as `IMID`,
				(select `EXT` from `tb_companies_images` where `CID` = `tc`.`CID` order by `LEFT` limit 1) as `IMEXT`,
				(select `NAME` from `tb_companies_data` where `CID` = `tc`.`CID` and `LANGID` = '".LANG."') as `CNAME`
			from `tb_tenders_companies` as `tc`
			where `tc`.`TID` = '".$id."' and `tc`.`STATUS` = '1'
			order by `tc`.`DTIME` desc
		";
		$this->parser['companies'] = $this->_parent->DB->getRowsBySQL($sql);
		//print_r($this->parser['companies']);

		$this->parser['cnt'] = getTemplate("admin_" . $this->name . "_edit");
	}

	function getData($url)
	{
		return $this->getDataByURL($url);
	}

}