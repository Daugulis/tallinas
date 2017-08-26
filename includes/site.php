<?php

class site 
{
	function init(&$flex)
	{
		global $DB, $parser;
		$this->flex = &$flex;
		$this->parser = &$parser;
		$this->DB = $DB;
		$this->buildPage();
	}

	function buildPage()
	{
		global $parser, $DB;

		$this->parser['title'] = "";


		$this->flex->html = "";

		if (OBJ=="ajax")
		{
			
			$this->flex->html = "";
			include_once "class/ajax.php";
			$proc = new ajax();
			$proc->init($this);
			exit();
		}

		if ($_SESSION['lemail']!="" && $_SESSION['lpass']!="")
		{
			$sql = "select * from `tb_users` where `STATUS`='1' and `EMAIL`='".mysql_escape_string($_SESSION['lemail'])."' and	`PASS`='".mysql_escape_string($_SESSION['lpass'])."'";
			$rw = $DB->getRowBySQL($sql);
			if ($rw['ID']>0)
			{
				$parser['user'] = $rw;

				$sql = "
				select
					t1.*,
					(select `NAME` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JNAME`,
					(select `ID` from `tb_users_favorits` where `UID`='".$parser['user']['ID']."' and `CID`=`t1`.`ID`) as `FID`,
					IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
				from `tb_companies` t1
				inner join `tb_companies_data` t2
				on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
				where `t1`.`STATUS` IN (4) and `t1`.`UID`='".$parser['user']['ID']."'
				order by `t1`.`RDATE` desc
				";
				$parser['ucmp'] = $DB->getRowsBySQL($sql);	
				//print_r($parser['ucmp']);

				$sql = "select * from `tb_orders` where `UID`='".$parser['user']['ID']."' and `CID`>0";
				$parser['mycmpr'] = Array();
				if ($res = $DB->Query($sql))
				{
					while($row = $DB->Fetch($res))
					{
						$parser['mycmpr'][] = $row['CID'];
					}
				}
				//print_r($parser['mycmpr']);
			}
		}


		include_once "class/categories.php";
		$cat = new Categories();
		$cat->init($this);

		include_once "class/catalogue.php";
		$catalog = new Catalogue();
		$catalog->init($this);

		include_once "class/parameters.php";
		$parameters = new Parameters();
		$parameters->init($this);

		include_once "class/contacts.php";
		$contacts = new Contacts();
		$contacts->init($this);		

		$this->getUrlData();
        $this->getObjData();	

		$parser['menu'] = $this->getMenu("0");
		$parser['menus'] = $this->getMenu("2");

		$sql = "select * from `tb_tree` where `TYPE`='5' and `STATUS`='1' LIMIT 1";
		$rw = $DB->getRowBySQL($sql);
		if ($rw['ID']>0)
		{
			$sql = "select * from `tb_tree_data` where `TID`='".$rw['ID']."' and `LANGID`='".LANG."' LIMIT 1";
			$rw2 = $DB->getRowBySQL($sql);
			
			$sql = "select * from `tb_tree` where `ID`='".$rw['SUB_ID']."' and `STATUS`='1' LIMIT 1";
			$rw3 = $DB->getRowBySQL($sql);			

			$sql = "select * from `tb_tree_data` where `TID`='".$rw3['ID']."' and `LANGID`='".LANG."' LIMIT 1";
			$rw4 = $DB->getRowBySQL($sql);
			
			$parser['regurl'] = "/".cLANG."/".$rw4['URL']."/".$rw2['URL']."/";
		}

		$sql = "select * from `tb_tree` where `TYPE`='4' and `STATUS`='1' LIMIT 1";
		$rw = $DB->getRowBySQL($sql);
		if ($rw['ID']>0)
		{
			$sql = "select * from `tb_tree_data` where `TID`='".$rw['ID']."' and `LANGID`='".LANG."' LIMIT 1";
			$rw2 = $DB->getRowBySQL($sql);
			
			$sql = "select * from `tb_tree` where `ID`='".$rw['SUB_ID']."' and `STATUS`='1' LIMIT 1";
			$rw3 = $DB->getRowBySQL($sql);			

			$sql = "select * from `tb_tree_data` where `TID`='".$rw3['ID']."' and `LANGID`='".LANG."' LIMIT 1";
			$rw4 = $DB->getRowBySQL($sql);
			
			$parser['produrl'] = "/".cLANG."/".$rw4['URL']."/".$rw2['URL']."/";
		}

		$sql = "
			select
				`m`.* ,
				`md`.`NAME`,
				`md`.`TEXT`
			from `tb_main` as `m`
			inner join `tb_main_data` as `md`
			on `m`.`ID`=`md`.`CID` and '".LANG."'=`md`.`LANGID`
			where `m`.`STATUS`='1' 
			order by `m`.`LEFT`
		";
		$parser['otzivi'] = $DB->getRowsBySQL($sql);

		$sql = "select * from `tb_tree` where `TYPE`='1'";
		$rw = $DB->getRowBySQL($sql);
		$sql = "select * from `tb_tree_images` where `TID`='".$rw['ID']."'";
		$rw = $DB->getRowBySQL($sql);
		arrToParser($rw, "fi");

		switch (U_TYPE)
		{		
			case '2':
				$sql = "
					select 
						td.*
					from `tb_tree` as `t`
					inner join `tb_tree_data` as `td`
					on `t`.`ID`=`td`.`TID` and '" . LANG . "'=`td`.`LANGID`
					where `t`.`STATUS`='1' and t.`ID`='".U_ID."' 
				";
				$rw = $DB->getRowBySQL($sql);
				arrToParser($rw, "t");
                $parser['content'] = getTemplate('site_text');
                break;
			case '6':

                $parser['contacts'] = $contacts->getContacts();
				//print_R($parser['contacts']);
				$parser['cn'] = '1';
				$parser['content'] = getTemplate('site_contacts');
                break;
			case '7': 
				$parser['menu2'] = $this->getMenu(U_ID);
				$parser['content'] = getTemplate('site_texts');
                break;
			case '4': 


				if (ID!="")
				{
					$sql = "select * from `tb_jurisdictions_data` where `URL`='".mysql_escape_string(ID)."' and `LANGID`='".LANG."'";
					$item = $DB->getRowBySQL($sql);
					if ($item['ID']>0)
					{
						arrToParser($item, "d");

						$sql = "select * from `tb_jurisdictions` where `ID`='".$item['CID']."'";
						$j = $DB->getRowBySQL($sql);
						arrToParser($j, "j");

						$sql = "select * from `tb_jurisdictions_images` where `CID`='".$item['CID']."' order by `LEFT` LIMIT 1";
						$im = $DB->getRowBySQL($sql);						
						arrToParser($im, "i");

						$sql = "
						select
							t1.*,
							(select `NAME` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JNAME`,
							(select `ID` from `tb_users_favorits` where `UID`='".$parser['user']['ID']."' and `CID`=`t1`.`ID`) as `FID`,
							IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
						from `tb_companies` t1
						inner join `tb_companies_data` t2
						on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
						where `t1`.`PID`='".$j['ID']."' and `t1`.`STATUS` IN (1,3)
						order by `t1`.`RDATE` desc
						";
						$parser['cmp'] = $DB->getRowsBySQL($sql);												

						if (ID2=='show')
						{
							$parser['content'] = getTemplate('site_sale_sdet');
							break;
						}

						$u = substr(ID2, 0, strlen(ID2)-3);
						//echo $u;
						$sql = "select * from `tb_tree_data` where `URL`='".mysql_escape_string($u)."' and `LANGID`='".LANG."'";
						$t = $DB->getRowBySQL($sql);

						if ($_GET['getpdf']=='1')
						{

							$sql = "
							select
									t1.*,
									(SELECT `ID` FROM `tb_jurisdictions_images` where `CID`=t1.ID order by `LEFT` LIMIT 1) as `IMID` ,
									(SELECT `EXT` FROM `tb_jurisdictions_images` where `CID`=t1.ID order by `LEFT` LIMIT 1) as `IMEXT` ,
									t2.`URL`,
									IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
								from `tb_jurisdictions` t1
								inner join `tb_jurisdictions_data` t2
								on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
								where `t1`.`STATUS`='1' and `t1`.`ID`='".$item['CID']."'
								order by `t1`.`LEFT`
							";
							$parser['jd'] = $DB->getRowsBySQL($sql);

							$out = getTemplate("site_pdf");
							require_once("dompdf/dompdf_config.inc.php");
							//$t = getTemplate("pdf_bill");

							$dompdf = new DOMPDF();
							$dompdf->load_html($out, 'UTF-8');
							$dompdf->render();
							$dompdf->stream("companies.pdf");
							exit();
						}

						if (ID2!="")
						{

							$sql = "
								select
									t1.*,
									(SELECT `ID` FROM `tb_jurisdictions_images` where `CID`=t1.ID order by `LEFT` LIMIT 1) as `IMID` ,
									(SELECT `EXT` FROM `tb_jurisdictions_images` where `CID`=t1.ID order by `LEFT` LIMIT 1) as `IMEXT` ,
									t2.`URL`,
									IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
								from `tb_jurisdictions` t1
								inner join `tb_jurisdictions_data` t2
								on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
								where `t1`.`STATUS`='1'
								order by `t1`.`LEFT`
							";
							$parser['jd'] = $DB->getRowsBySQL($sql);

							$sql = "
								select
									t1.*,									
									t2.`PERIOD`,
									IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
								from `tb_jurisdictions_sr` t1
								inner join `tb_jurisdictions_sr_data` t2
								on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
								order by `t1`.`LEFT`
							";
							$parser['sr'] = $DB->getRowsBySQL($sql);

							$parser['content'] = getTemplate('site_sale_services');
							break;
						}

						$sql = "
							select 
								t.* ,
								(SELECT `ID` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID order by `LEFT` LIMIT 1) as `IMID` ,
								(SELECT `EXT` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID order by `LEFT` LIMIT 1) as `IMEXT`,
								tl.`NAME` as `NAME` ,
								tl.`TEXT` as `TEXT` ,
								tl.`URL` as `URL`
							from `".TABLE_TREE."` as t
							inner join `".TABLE_TREE_DATA."` as tl
							on t.ID=tl.TID and '".LANG."'=tl.LANGID
							where 
								t.STATUS = '1' 
								and (select count(*) from `tb_jurisdictions_sr` where `PID`='".$item['CID']."' and `CATID`=`t`.`ID`)>0
							order by
								t.LEFT
						";
						$parser['menu2'] = $this->DB->getRowsBySQL($sql);						

						$parser['content'] = getTemplate('site_sale_det');
						break;
					}
				}

				$sql = "
					select
						t1.*,
						(select COUNT(*) from `tb_companies` where `PID`=`t1`.`ID` and `STATUS` in (1,3) ) as `cnt`,
						(SELECT `ID` FROM `tb_jurisdictions_images` where `CID`=t1.ID order by `LEFT` LIMIT 1) as `IMID` ,
						(SELECT `EXT` FROM `tb_jurisdictions_images` where `CID`=t1.ID order by `LEFT` LIMIT 1) as `IMEXT` ,
						t2.`URL`,
						IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
					from `tb_jurisdictions` t1
					inner join `tb_jurisdictions_data` t2
					on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
					where `t1`.`STATUS`='1'
					order by `t1`.`LEFT`
				";
				$parser['jd'] = $DB->getRowsBySQL($sql);				

				$parser['menu2'] = $this->getMenu(U_ID);
				$parser['content'] = getTemplate('site_sale');
                break;
			case '5': 

				$sql = "
				select
						t1.*,
						(SELECT `ID` FROM `tb_jurisdictions_images` where `CID`=t1.ID order by `LEFT` LIMIT 1) as `IMID` ,
						(SELECT `EXT` FROM `tb_jurisdictions_images` where `CID`=t1.ID order by `LEFT` LIMIT 1) as `IMEXT` ,
						t2.`URL`,
						IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
					from `tb_jurisdictions` t1
					inner join `tb_jurisdictions_data` t2
					on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
					where `t1`.`STATUS`='1'
					order by `t1`.`LEFT`
				";
				$parser['jd'] = $DB->getRowsBySQL($sql);

				$sql = "
					select
						t1.*,
						(select `NAME` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JNAME`,						
						IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
					from `tb_companies` t1
					inner join `tb_companies_data` t2
					on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
					where `t1`.`STATUS` IN (1,3)
					order by `t1`.`LEFT`
				";
				$parser['cmp'] = $DB->getRowsBySQL($sql);

				if (ID!="")
				{
					$sql = "select * from `tb_companies` where `ID`='".ID."'";
					$rw = $DB->getRowBySQL($sql);
					arrToParser($rw, "c");
				}

				$parser['menu2'] = $this->getMenu(U_ID);
				$parser['content'] = getTemplate('site_register');
                break;
			case '3':        
				$parser['menu2'] = $this->getMenu(U_ID);
				$parser['content'] = getTemplate('site_services');
                break;
			default:	
				if (OBJ=='getpdf')
				{
					$sql = "
					select
							t1.*,
							(SELECT `ID` FROM `tb_jurisdictions_images` where `CID`=t1.ID order by `LEFT` LIMIT 1) as `IMID` ,
							(SELECT `EXT` FROM `tb_jurisdictions_images` where `CID`=t1.ID order by `LEFT` LIMIT 1) as `IMEXT` ,
							t2.`URL`,
							IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
						from `tb_jurisdictions` t1
						inner join `tb_jurisdictions_data` t2
						on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
						where `t1`.`STATUS`='1'
						order by `t1`.`LEFT`
					";
					$parser['jd'] = $DB->getRowsBySQL($sql);

					$out = getTemplate("site_pdf");
					require_once("dompdf/dompdf_config.inc.php");
					//$t = getTemplate("pdf_bill");

					$dompdf = new DOMPDF();
					$dompdf->load_html($out, 'UTF-8');
					$dompdf->render();
					$dompdf->stream("companies.pdf");
					exit();
				}
				if (OBJ=='cregister')
				{
					if ($_POST)
					{
						$sql = "select count(*) as cnt from `tb_orders` where `DATE` = '".date("Y-m-d")."'";
						$rw = $DB->getRowBySQL($sql);
						$num = (int)$rw['cnt']+1;
						$num = date("Ymd") . "-" . $num;
						$arr = Array(
							"TYPE"=>$_POST['type'],
							"DATE"=>date("Y-m-d"),
							"DTIME"=>date("Y-m-d H:i:s"),
							"PDTIME"=>date("Y-m-d H:i:s"),
							"INFO"=>$_POST['text'],
							"CID"=>"0",
							"NAMES"=>"",
							"LANG"=>LANG,
							"IP"=>$_SERVER['REMOTE_ADDR'],
							"NUM"=>$num,
							"STATUS"=>"1"
						);
						if ($_POST['type']=='1')
						{							
							foreach ($_POST['cname'] as $v)
							{
								if ($v!="Желаемое название")
								{
									$arr['NAMES'] .= $v . ", ";
								}
							}
						}
						else
						{
							$arr['CID'] = $_POST['cid'];
						}
						$arr['NAMES'] = trim($arr['NAMES'], ", ");
						if ($parser['user']['ID']>0)
						{
							$arr['UID'] = $parser['user']['ID'];
						}
						else
						{
							$arr['NAME'] = $_POST['rname'];
							$arr['PHONE'] = $_POST['rphone'];
							$arr['EMAIL'] = $_POST['remail'];
						}						
						if ($DB->insert($arr, "tb_orders", $id))
						{
							if (count($_POST['sr'])>0)
							{
								foreach ($_POST['sr'] as $v)
								{
									$arr2 = Array("OID"=>$id, "SERVICE"=>$v);
									$DB->insert($arr2, "tb_orders_services", $id2);
								}
							}	
							/*
							if ($arr['CID']>0)
							{
								if ($arr['UID']>0)
								{
									$uarr['UID'] = $arr['UID'];
									$DB->update($uarr, "tb_companies", " `ID`='".$arr['CID']."' ");
								}
							}
							*/
						}
					}
					exit();
				}
				if (OBJ=='getcmp')
				{					
					$sq = ($_POST['jd']!='0') ? " and `t1`.`PID`='".intval($_POST['jd'])."'" : "";
					$sql = "
						select
							t1.*,
							(select `NAME` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JNAME`,						
							IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
						from `tb_companies` t1
						inner join `tb_companies_data` t2
						on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
						where `t1`.`STATUS` IN (1,3) ".$sq."
						order by `t1`.`LEFT`
					";
					$parser['cmp'] = $DB->getRowsBySQL($sql);
					$out = getTemplate("site_companies_sel");
					echo $out;
					exit();
				}
				if (OBJ=='profile')
				{
					if ($parser['user']['ID']>0)
					{
						switch(strtolower(TASK))
						{
							case 'orderservice':
								//print_r($_POST);
								$sql = "select * from `tb_orders` where `UID`='".$parser['user']['ID']."' and `CID`='".$_POST['cid']."'";
								$rw = $DB->getRowBySQL($sql);
								
								$sql = "select * from `tb_orders_services2` where `UID`='".$parser['user']['ID']."' and `SID`='".$_POST['sid']."' and `CID`='".$_POST['cid']."'";
								$arr = Array("UID"=>$parser['user']['ID'], "CID"=>$_POST['cid'], "SID"=>$_POST['sid'], "RDTIME"=>date("Y-m-d H:i:s"));
								$DB->insert($arr, "tb_orders_services2", $idd);

								$sql = "update `tb_orders` set `PDTIME`=NOW() where `CID`='".intval($_POST['cid'])."' and `UID`='".$parser['user']['ID']."'";
								$DB->Query($sql);
								
								exit();
								break;
							case 'setregister':								
								$sql = "select count(*) as cnt from `tb_orders` where `DATE` = '".date("Y-m-d")."'";
								$rw = $DB->getRowBySQL($sql);
								$num = (int)$rw['cnt']+1;
								$num = date("Ymd") . "-" . $num;
								$arr = Array(
									"TYPE"=>"2",
									"DATE"=>date("Y-m-d"),
									"DTIME"=>date("Y-m-d H:i:s"),
									"INFO"=>"",
									"CID"=>$_POST['cmp'],
									"NAMES"=>"",
									"LANG"=>LANG,
									"IP"=>$_SERVER['REMOTE_ADDR'],
									"NUM"=>$num,
									"STATUS"=>"1"
								);					
								$arr['UID'] = $parser['user']['ID'];
														
								if ($DB->insert($arr, "tb_orders", $id))
								{						
									$arr2 = Array("OID"=>$id, "SERVICE"=>"Номинальный сервис");
									$DB->insert($arr2, "tb_orders_services", $id2);						
									$arr2 = Array("OID"=>$id, "SERVICE"=>"Открытые расчетного счета");
									$DB->insert($arr2, "tb_orders_services", $id2);						
								}

								$sql = "update `tb_companies` set `STATUS`='2' where `ID`='".$_POST['cmp']."'";
								$DB->Query($sql);

								exit();
								break;
							case 'setfavorite':
								$sql = "select * from `tb_users_favorits` where `UID`='".$parser['user']['ID']."' and `CID`='".$_POST['cmp']."'";
								$rw = $DB->getRowBySQL($sql);
								if ($rw['ID']>0)
								{
									//
								}
								else
								{
									$arr = Array("UID"=>$parser['user']['ID'], "CID"=>$_POST['cmp']);
									$DB->insert($arr, "tb_users_favorits", $id);
								}
								exit();
								break;
							case 'delfavorite':
								$sql = "delete from `tb_users_favorits` where `UID`='".$parser['user']['ID']."' and `CID`='".$_POST['cmp']."'";
								$DB->Query($sql);
								exit();
								break;
							case 'all':
								$sql = "
								select
									t1.*,
									(select `NAME` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JNAME`,
									(select `STATUS` from `tb_orders` where `CID`=`t1`.`ID` and `OTYPE`='1' and `STATUS`<>'0' and `UID`='".$parser['user']['ID']."') as `OSTATUS`,
									(select `ID` from `tb_users_favorits` where `UID`='".$parser['user']['ID']."' and `CID`=`t1`.`ID` LIMIT 1) as `FID`,		
									IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
								from `tb_companies` t1
								inner join `tb_companies_data` t2
								on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
								where ( `t1`.`STATUS` IN (1,2,3) ) OR ( `t1`.`STATUS` IN (4) and `t1`.`UID`='".$parser['user']['ID']."' )
								order by `t1`.`RDATE` desc
								";
								$parser['cmp'] = $DB->getRowsBySQL($sql);	
								$parser['content'] = getTemplate('site_profile_all');
								break;
							case 'delcmp':
								$sql = "update `tb_companies` set `DDTIME`=NOW() , `DSTATUS`='1' where `ID`='".intval($_POST['cmp'])."'";
								$DB->Query($sql);
								break;
							case 'prodcmp':
								$sql = "update `tb_companies` set `PRDTIME`=NOW() , `PRSTATUS`='1' where `ID`='".intval($_POST['cmp'])."'";
								$DB->Query($sql);
								break;
							case 'showcompanies':
								$parser['cmp'] = Array();
								switch (ID)
								{
									case 'all':
										$sql = "
											select
												t1.*,
												(select `NAME` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JNAME`,
												(select `URL` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JURL`,
												(select `ID` from `tb_users_favorits` where `UID`='".$parser['user']['ID']."' and `CID`=`t1`.`ID`) as `FID`,		
												IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
											from `tb_companies` t1
											inner join `tb_companies_data` t2
											on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
											where ( `t1`.`STATUS` IN (3,4) and `t1`.`UID`='".$parser['user']['ID']."' )  OR (select `ID` from `tb_users_favorits` where `UID`='".$parser['user']['ID']."' and `CID`=`t1`.`ID`)>0
											order by `t1`.`EDATE`
										";
										$parser['cmp'] = $DB->getRowsBySQL($sql);
										break;
									case 'register':
										$sql = "
											select
												t1.*,
												(select `NAME` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JNAME`,
												(select `URL` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JURL`,
												(select `ID` from `tb_users_favorits` where `UID`='".$parser['user']['ID']."' and `CID`=`t1`.`ID`) as `FID`,		
												IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
											from `tb_companies` t1
											inner join `tb_companies_data` t2
											on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
											where ( `t1`.`STATUS` IN (3,4) and `t1`.`UID`='".$parser['user']['ID']."' )
											order by `t1`.`EDATE`
										";
										$parser['cmp'] = $DB->getRowsBySQL($sql);
										break;
									case 'favorite':
										$sql = "
											select
												t1.*,
												(select `NAME` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JNAME`,
												(select `URL` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JURL`,
												(select `ID` from `tb_users_favorits` where `UID`='".$parser['user']['ID']."' and `CID`=`t1`.`ID`) as `FID`,		
												IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
											from `tb_companies` t1
											inner join `tb_companies_data` t2
											on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
											where (select `ID` from `tb_users_favorits` where `UID`='".$parser['user']['ID']."' and `CID`=`t1`.`ID`)>0
											order by `t1`.`EDATE`
										";
										$parser['cmp'] = $DB->getRowsBySQL($sql);
										break;
								}
								$out = getTemplate("site_profile_my_companies");
								echo $out;
								exit();
								break;
							case 'my':
								$sql = "
								select
									t1.*,
									(select `NAME` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JNAME`,
									(select `URL` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JURL`,
									(select `ID` from `tb_users_favorits` where `UID`='".$parser['user']['ID']."' and `CID`=`t1`.`ID`) as `FID`,		
									IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
								from `tb_companies` t1
								inner join `tb_companies_data` t2
								on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
								where ( `t1`.`STATUS` IN (3,4) and `t1`.`UID`='".$parser['user']['ID']."' )  OR (select `ID` from `tb_users_favorits` where `UID`='".$parser['user']['ID']."' and `CID`=`t1`.`ID`)>0
								order by `t1`.`EDATE`
								";
								$parser['cmp'] = $DB->getRowsBySQL($sql);	

								$parser['content'] = getTemplate('site_profile_my');
								break;
							case 'data':
								$parser['content'] = getTemplate('site_profile_data');
								break;
						}
					}
					else
					{
						header("Location: /<!---cLANG--->/");
						exit();
					}
					break;
				}

				if (OBJ=='logout')
				{
					unset($_SESSION['lemail']);
					unset($_SESSION['lpass']);
					header("Location: /<!---cLANG--->/");
					exit();
				}
				
				if (OBJ=='login')
				{
					if ($_POST)
					{
						extract($_POST);
						$sql = "select * from `tb_users` where `EMAIL`='".$lemail."' and `PASS`='".$lpass."'";
						$rw = $DB->getRowBySQL($sql);
						if ($rw['ID']>0)
						{
							$_SESSION['lemail'] = $lemail;
							$_SESSION['lpass'] = $lpass;
							echo "1";
						}
						else
						{
							echo "0";
						}
					}
					exit();
				}

				$sql = "
					select
						t1.*,
						(select `NAME` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JNAME`,
						IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
					from `tb_companies` t1
					inner join `tb_companies_data` t2
					on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
					where `t1`.`STATUS` IN (1,3)
					order by RAND() LIMIT 3
					";
					$parser['cmp'] = $DB->getRowsBySQL($sql);
				$sql = "
					select
						t1.*,
						(select `NAME` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JNAME`,
						t2.ADDRESS,
						IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
					from `tb_companies` t1
					inner join `tb_companies_data` t2
					on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
					where `t1`.`STATUS` IN (4)
					order by `t1`.`STDTIME` desc LIMIT 3
					";
					$parser['cmp2'] = $DB->getRowsBySQL($sql);

				
				$parser['content'] = getTemplate('site_main');
				break;
				

				$parser['content'] = getTemplate("site_body");
				break;
		}

		header("Content-Type: text/html; charset=utf-8");
			
		$this->flex->html .= getTemplate("site_header");
		$this->flex->html .= getTemplate("site_body");

	}

	function getObjData()
	{
		global $DB, $parser;
		$sql = "select * from `tb_tree_data` where `URL`='".mysql_escape_string(OBJ)."' and `LANGID`='".LANG."'";
		$data = $DB->getRowBySQL($sql);
		$sql = "select * from `tb_tree` where `ID`='".$data['TID']."'";
		$row = $DB->getRowBySQL($sql);
		$row['URL'] = OBJ;
		$row['NAME'] = $data['NAME'];
		$parser['u_title'] = $parser['title'] = $data['TITLE'];
		$parser['u_desc'] = $data['DESC'];
		$parser['u_kw'] = $data['KW'];		
		$parser['objdata'] = $row;
	}

	function getTaskData()
	{
		global $DB, $parser;
		$parser['taskdata'] = $row;
	}

	function getIDData()
	{
		global $DB, $parser;
		$parser['iddata'] = $row;
	}

	function getUrlData()
	{
		$arr = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
		$arr = array_reverse($arr);
		$type = 0;
		$id = 0;

		$_SESSION['curls'] = Array();
		$_SESSION['cids'] = Array();
		
		if (count($arr)>0)
		{
			$nm = 0;
			foreach ($arr as $a)
			{
				$nm++;
		
				$sql = "select * from `".TABLE_TREE_DATA."` where `LANGID`='".LANG."' and `URL`='".mysql_escape_string($a)."'";
				$row = $this->DB->getRowBySQL($sql);
				if ((int)$row['ID']>0 && $id==0)
				{
					$num = $nm;
					$id = $row['TID'];
					$sql = "select * from `".TABLE_TREE."` where `ID`='".$id."'";
					$rw = $this->DB->getRowBySQL($sql);
					$type = $rw['TYPE'];
					$next = $rw['NEXT'];
					$name = $row['NAME'];
					$kw = $row['KW'];
					$desc = $row['DESC'];
					$title = $row['TITLE'];
				}
				else
				{
					$sql = "select * from `".TABLE_CAT_DATA."` where `LANGID`='".LANG."' and `URL`='".mysql_escape_string($a)."'";

					$row = $this->DB->getRowBySQL($sql);
					if ((int)$row['ID']>0)
					{
						if (!in_array($row['ID'], $_SESSION['cids']))
						{
							$_SESSION['cids'][] = $row['CID'];
							
						}
						if (!in_array($a, $_SESSION['curls']))
						{
							$_SESSION['curls'][] = $a;	
						}
					}
					else
					{
						$sql = "select * from `tb_catalog_data` where `LANGID`='".LANG."' and `URL`='".mysql_escape_string($a)."'";
						$row = $this->DB->getRowBySQL($sql);
						if ((int)$row['ID']>0)
						{
							$this->parser['prod'] = $row;
						}
					}
				}
			}
		}
		if ($num==1)
		{
			if ($next=="1")
			{
				$sql = "select * from `".TABLE_TREE."` where `SUB_ID`='".$id."' and `STATUS`='1' order by `LEFT`";
				$row = $this->DB->getRowBySQL($sql);
				if ((int)$row['ID']>0)
				{
					$sql = "select * from `".TABLE_TREE_DATA."` where `TID`='".$row['ID']."' and `LANGID`='".LANG."'";
					$row = $this->DB->getRowBySQL($sql);
					if ($row['URL']!="")
					{	
						header("Location: /" . trim($_SERVER['REQUEST_URI'], "/") . "/" . $row['URL'] . "/");
						exit();
					}
				}
			}
		}

		define("U_TYPE", $type);
		define("U_ID", $id);
		define("U_NAME", $name);
		$this->parser['title'] = $title;
		$this->parser['kw'] = $kw;
		$this->parser['desc'] = $desc;
	}

	function getMenu($parent, $type="")
	{
		$sql = "
			select 
				t.* ,
				(SELECT `ID` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID order by `LEFT` LIMIT 1) as `IMID` ,
				(SELECT `EXT` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID order by `LEFT` LIMIT 1) as `IMEXT`,
				tl.`NAME` as `NAME` ,
				tl.`TEXT` as `TEXT` ,
				tl.`URL` as `URL`,
				t2.`URL` as `URL2`
			from `".TABLE_TREE."` as t
			inner join `".TABLE_TREE_DATA."` as tl
			on t.ID=tl.TID and '".LANG."'=tl.LANGID
			left join `".TABLE_TREE_DATA."` as t2
			on t.`SUB_ID`=t2.`TID` and '".LANG."'=t2.LANGID
			where 
				t.STATUS = '1' 
				and t.SUB_ID='".$parent."'
				and t.`TYPE`<>'1'
			order by
				t.LEFT
		";
		$res = $this->DB->getRowsBySQL($sql);
		return $res;
	}

	function getMenuGl($p)
	{
		$sql = "
			select 
				t.* ,
				(SELECT `ID` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID LIMIT 1) as `IMID` ,
				(SELECT `EXT` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID LIMIT 1) as `IMEXT` ,
				(SELECT `TEXT` FROM `".TABLE_TEXTS."` where `TID`=t.ID and `LANGID`='".LANG."' ) as `TEXT` ,
				tl.`NAME` as `NAME` ,
				tl.`URL` as `URL`
			from `".TABLE_TREE."` as t
			inner join `".TABLE_TREE_DATA."` as tl
			on t.ID=tl.TID and '".LANG."'=tl.LANGID
			where 
				t.STATUS = '1' 
				and t.TYPE_ID IN ($p)
			order by
				t.LEFT
		";
		$res = $this->DB->getRowsBySQL($sql);
		return $res;
	}
}


?>