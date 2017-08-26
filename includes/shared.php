<?php

	function getsttnm($id)
	{
		global $parser;
		return $parser['sttnm'][$id];
	}
	
	function tnl($num)
	{
		if ($num!='')
		{
			if ($num<10)
			{
				return '0' . $num;
			}
			else
			{
				return $num;
			}
		}
	}

	function getRating($nid, $crid, $jid, $aid, $nl=false)
	{
		global $DB, $parser;
		$n = $parser['rating'][$nid][$crid][$jid][$aid];
		if ($n=='0' && $nl==false)
		{
			return '';
		}
		else
		{
			return intval($n);
		}
	}

	function getCriterionsByNomination($id)
	{
		global $DB, $parser;
		$sql = "
			select
				`cr`.`ID`,
				`crd`.`NAME` as `HINT`,
				`crd`.`TITLE` as `NAME`,
				`cc`.`PID`
			from `tb_competitions_nominations_criterions` as `cc`
			inner join `tb_competitions_nominations` as `c`
			on `cc`.`CID` = `c`.`ID`
			inner join `tb_criterions` as `cr`
			on `cc`.`PID` = `cr`.`ID`
			inner join `tb_criterions_data` as `crd`
			on `cr`.`ID` = `crd`.`CID` and '".LANG."' = `crd`.`LANGID`
			where `c`.`NID` = '".$id."' and `cr`.`STATUS` = '1'
			order by `cr`.`LEFT`
		";
		$res = $DB->getRowsBySQL($sql);
		$parser['criterions'] = $res;
	}

	function getJuryByCompetitions($id)
	{
		global $DB, $parser;
		$sql = "
			select
				s.* ,
				`sd`.`NAME` as `TNAME`
			from `tb_jury` as `s`
			inner join `tb_jury_data` as `sd`
			on `s`.`ID` = `sd`.`CID` and '".LANG."' = `sd`.`LANGID`
			inner join `tb_competitions_nominations_jury` as `cnj`
			on `s`.`ID` = `cnj`.`PID` and '".$id."' = `cnj`.`NID`
			where `s`.`STATUS` = '1'
			order by `s`.`LEFT`
		";
		$res = $DB->getRowsBySQL($sql);
		$parser['jury'] = $res;
	}

	function getArtistsByJury($id)
	{
		global $DB, $parser;
		$sql = "
			select 
				`a`.`ID`,
				`ad`.`NAME`,
				`an`.`COMMENT`
			from `tb_competitors` as `a`
			inner join `tb_competitors_data` as `ad`
			on `a`.`ID` = `ad`.`CID` and '".LANG."' = `ad`.`LANGID`
			inner join `tb_competitors_nominations` as `an`
			on `a`.`ID` = `an`.`CID` and '".$id."' = `an`.`LID` and `an`.`STATUS` = '1'
			left join `tb_nominations_order` as `sr`
			on `a`.`ID` = `sr`.`AID` and `an`.`LID` = `sr`.`LID`
			where `a`.`STATUS` = '1'
			order by `sr`.`LEFT` 
		";
		$res = $DB->getRowsBySQL($sql);
		$parser['artists'] = $res;
	}

	function getTOrdersItems($id)
	{
		global $DB;
		$out = '';
		$sql = "select * from `tb_torders_items` where `CID` = '".$id."' order by `ID`";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				$out .= '<div style="float: left; width: 43%; margin: 0px 10px 10px 0px;">';
				$out .= '<p>Товар: '.$row['TNAME'].'</p>';
				$out .= '<p>Кол-во: '.$row['TCOUNT'].'</p>';
				$out .= '<p>Страна: '.$row['TSTRANA'].'</p>';
				$out .= '<p>Вес брутто: '.$row['TVES'].'</p>';
				$out .= '<p>Материал / состав: '.$row['TSOSTAV'].'</p>';
				$out .= '<p>Артикул: '.$row['TMODEL'].'</p>';
				$out .= '<p>Торговая марка: '.$row['TMARKA'].'</p>';
				$out .= '<p>Цена: '.$row['TPRICE'].'</p>';
				$out .= '</div>';
			}
		}
		return $out;
	}

	function getOrderItemData($num, $dt='', $frombase='0')
	{
		global $DB, $parser;
		$out = '';
		$data = unserialize($parser['items'][$num-1]['DATA']);
		if (is_array($dt))
		{
			$data = $dt;
		}
		if ($data['ctype']=='1')
		{
			if ($frombase=='0')
			{
				$out .= '<p>Competitions</p>';
				$out .= '<p>'.$parser['items'][$num-1]['CNAME'].'</p>';
				$out .= '<p>'.$parser['items'][$num-1]['NNAME'].'</p>';
			}
			else
			{
				$sql = "select * from `tb_nominations_data` where `CID` = '".$data['nid']."' and `LANGID` = '".LANG."'";
				$rw = $DB->getRowBySQL($sql);
				$out .= '<p>Competitions</p>';
				$out .= '<p>'.$rw['NAME'].'</p>';
			}
		}
		//else
		//{
			$out .= '<p>Masterclasses</p>';
			foreach ($data['msdata'] as $v)
			{
				$out .= '<p style="padding-bottom: 10px;">'.$v['lang']['TNAME'].' '.$v['lang']['SUBNAME'].' ' . $v['lang']['NAME'] .'</p>';
			}
		//}
		return $out;
	}

	function getOrderUserData($num, $dt='')
	{
		global $DB, $parser;
		$out = '';
		$data = unserialize($parser['items'][$num-1]['DATA']);
		if (is_array($dt))
		{
			$data = $dt;
		}
		//print_R($data);
		if ($data['ctype']=='1')
		{
			if ($data['ftype']=='fsolo')
			{
				$out .= '<p>SOLO</p>';
				$out .= '<p>Имя, Фамилия: '.$data['name'].'</p>';
				$out .= '<p>Эл. почта: '.$data['email'].'</p>';
				$out .= '<p>Телефон: '.$data['phone'].'</p>';
				$out .= '<p>Сценический псевдоним: '.$data['nick'].'</p>';
				$out .= '<p>Дата рождения: '.$data['bdate'].'</p>';
			}
			else
			{
				$out .= '<p>GROUP</p>';
				$out .= '<p>Имя, Фамилия художественного руководителя: '.$data['cname'].'</p>';
				$out .= '<p>Эл. почта: '.$data['email'].'</p>';
				$out .= '<p>Телефон: '.$data['phone'].'</p>';
				$out .= '<p>Название группы: '.$data['group'].'</p>';
				$out .= '<p>Количество человек: '.$data['cnt'].'</p>';
				$out .= '<p>Возраст участников: '.$data['ages'].'</p>';
			}
			$out .= '<p>Страна: '.$data['country'].'</p>';
			$out .= '<p>Город: '.$data['city'].'</p>';
			$out .= '<p>Название музыки: '.$data['music'].'</p>';
			$out .= '<p>Автор хореографии: '.$data['autor'].'</p>';
			$out .= '<p>Ваш педагог: '.$data['teacher'].'</p>';
			$out .= '<p>Студия: '.$data['studio'].'</p>';
		}
		else
		{
			$out .= '<p>Имя, Фамилия: '.$data['name'].'</p>';
			$out .= '<p>Эл. почта: '.$data['email'].'</p>';
			$out .= '<p>Телефон: '.$data['phone'].'</p>';
			$out .= '<p>Студия: '.$data['studio'].'</p>';
		}
		return $out;
	}

	function getTreeNominations($id)
	{
		global $parser, $DB;
		$sql = "select GROUP_CONCAT(`NID` SEPARATOR ',') as `NID` from `tb_competitions_nominations` where `CID` = '".$id."' and `STATUS` = '1'";
		$rw = $DB->getRowBySQL($sql);
		$narr = explode(',', $rw['NID']);
		$parser['nominations2'] = Array();
		$n = 0;
		foreach ($parser['nominations'] as $v)
		{
			if (in_array($v['ID'], $narr))
			{
				$n++;
				$v['num'] = $n;
				$v['even'] = ($n/2==ceil($n/2)) ? "1" : "0";
				$parser['nominations2'][] = $v;
			}
		}
	}

	function getAPrice($id, $price)
	{
		global $parser;
		if (isset($parser['aprices'][$id]))
		{
			return $parser['aprices'][$id] + $price;
		}
		else
		{
			return $price;
		}
	}

	function getOCats($id)
	{
		global $DB;
		$r = '';
		$sql = "select * from `tb_catalog_ct` where `CID` = '".$id."'";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				$r .= ' cat'.$row['PID'];
			}
		}
		return $r;
	}

	function getImageSrc($num, $ext, $f="temp")
	{
		if (file_exists($f."/".$num.".".$ext))
		{
			return "/".$f."/".$num.".".$ext;
		}
		else
		{
			if ($f=="temp")
			{
				return "/getimage.php?id=".$num;
			}
			else
			{
				return "/getimage_crop.php?id=".$num;
			}
		}
		return $num;
	}

	function getJury($cid, $nid)
	{
		global $DB, $parser;
		$sql = "
			select
				c.*,
				(select `ID` from `tb_jury_images` where `CID` = `c`.`ID` and `STATUS`='0' order by `LEFT`  LIMIT 1) as `IMID` ,
				(select `EXT` from `tb_jury_images` where `CID` = `c`.`ID` and `STATUS`='0' order by `LEFT`  LIMIT 1) as `IMEXT` ,
				`cd`.`NAME`,
				`cd`.`URL`,
				`cd`.`TEXT`
			from `tb_jury` as `c`
			inner join `tb_jury_data` as `cd`
			on `c`.`ID`=`cd`.`CID` and '".LANG."'=`cd`.`LANGID`			
			inner join `tb_competitions_nominations_jury` as `cp`
			on `c`.`ID` = `cp`.`PID` and '".$nid."' = `cp`.`NID` and '".$cid."' = `cp`.`COMPID`
			where 1=1 and `c`.`STATUS` = '1' 
			order by `c`.`LEFT`
		";
		//echo $cid . ' ' . $nid . ' ';
		//echo $sql;
		$parser['citems'] = $DB->getRowsBySQL($sql);
	}

	function geSSMenu($id)
	{
		global $DB, $parser;
		$sql = "
			select
				c.*,
				`cd`.`NAME` as `LANG_NAME`,
				`cd`.`URL` as `LANG_URL`
			from `tb_tree` as `c`
			inner join `tb_tree_data` as `cd`
			on `c`.`ID`=`cd`.`CID` and '".LANG."'=`cd`.`LANGID`			
			where 1=1 and `c`.`STATUS` = '1' and `c`.`SUB_ID` = '".$id."' 
			order by `c`.`LEFT`
		";
		$parser['items'] = $DB->getRowsBySQL($sql);		
	}

	function getImageIco($ext)
	{
		$e = strtolower($ext);
		$ex = Array("xls", "xlam", "xlsb", "xltm", "xlsm", "xlsx");
		$doc = Array("doc", "docx");
		$pdf = Array("pdf");
		if (in_array($e, $ex)) return "/img/exel.jpg";
		if (in_array($e, $doc)) return "/img/word.jpg";
		if (in_array($e, $pdf)) return "/img/pdf.jpg";
		//return "/img/pdf.jpg";
	}

	function getDocIcoID($ext)
	{
		$e = strtolower($ext);
		$ex = Array("xls", "xlam", "xlsb", "xltm", "xlsm", "xlsx");
		$doc = Array("doc", "docx");
		$pdf = Array("pdf");
		if (in_array($e, $ex)) return "3";
		if (in_array($e, $doc)) return "4";
		if (in_array($e, $pdf)) return "2";
		return "1";
	}

	function ttext($text, $n)
	{
		$c = 0;
		$r = '';
		$a = explode(" ", $text);
		if (count($a)>0)
		{
			foreach ($a as $t)
			{
				if (mb_strlen(trim($r . ' ' . $t), "utf-8")<=$n)
				{
					$r = trim($r . ' ' . $t);
				}
				else
				{
					break;
				}
			}
		}
		if (trim($r)!=trim($text))
		{
			return $r . '...';
		}
		else
		{
			return $r;
		}
	}

	function getFMenuLinks($id, $obj)
	{
		global $parser, $DB;
		$out = '';
		$sql = "
			select
				s.* ,
				`sd`.`NAME`,
				`sd`.`URL`
			from `tb_texts` as `s`
			inner join `tb_texts_data` as `sd`
			on `s`.`ID` = `sd`.`CID` and '".LANG."' = `sd`.`LANGID`
			where `s`.`PID` = '".$id."' and `s`.`FOOTER` = '1'
			order by `s`.`LEFT` 
		";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				$out .= '<a href="/'.LANG.'/'.$obj.'/'.$row['URL'].'/">'.ttext($row['NAME'], 30).'</a>';
			}
		}
		return $out;
	}

	function getTextBlocksSite($id, $name, $limit)
	{
		global $DB, $parser;
		$lim = ($limit!='') ? ' LIMIT ' . $limit : '';
		$sql = "select * from `tb_".$name."_blocks` where `CID` = '".$id."' order by `LEFT` " . $lim;
		$parser['cblocks'] = $DB->getRowsBySQL($sql);
	}

	function getTextBlockSite($name, $bid, $nm, $tg='p')
	{
		global $DB, $parser;
		$sql = "select * from `tb_".$name."_blocks_data` where `CID` = '".$bid."' and `LANGID`='".LANG."'";
		$rw = $DB->getRowBySQL($sql);
		$parser['cblock'] = $rw;
		return;
		$res = '';
		if ($nm=="TEXT")
		{
			$arr = explode("\r\n", $rw['TEXT']);
			foreach ($arr as $v)
			{
				if ($tg=='p')
				{
					$res .= '<p>'.$v.'</p>';
				}
				else
				{
					$res .= $v.'<br />';
				}
			}
			$res = $rw['TEXT'];
		}
		else
		{
			$res = $rw[$nm];
		}
		return $res;
	}

	function getTextBlock($name, $id, $bid, $left)
	{
		global $DB, $parser;
		
		$tt = '';
		foreach ($parser['langs'] as $lang)
		{
			$sql = "select * from `tb_".$name."_blocks_data` where `CID` = '".$bid."' and `LANGID`='".$lang['ID']."'";
			$rw = $DB->getRowBySQL($sql);
			$tt = $tt . '<div class="full-block" style="width: 33%;"><h1 style="padding: 10px;">'.voc('Title').' ('.$lang['SHORTNAME'].')</h1><input class="prev"  style="text-transform: none;" name="bname['.$left.']['.$lang['ID'].']" value="'.htmlspecialchars($rw['NAME']).'"></div>';
		}
		
		$t = '<div class="mtext" id="mtext'.$left.'"><h2>'.voc('Text').'<a style="cursor: pointer; margin-right: 20px;"><img class="move" src="/admin/img/icon-move-small.png" border="0" alt="" /></a><a href="javascript:deleteBlock(\''.$left.'\')" style="cursor: pointer;"><img  src="/admin/img/icon-close-small.png" border="0" alt="" /></a></h2><div class="add-item-line">'.$tt.'</div><div class="add-item-line"><input type="hidden" name="block[]" value="'.$left.'" />';
		foreach ($parser['langs'] as $lang)
		{
			$sql = "select * from `tb_".$name."_blocks_data` where `CID` = '".$bid."' and `LANGID`='".$lang['ID']."'";
			$rw = $DB->getRowBySQL($sql);
			$t = $t . '<div class="full-block" style="width: 33%;"><h1 style="padding: 10px;">'.voc('Text').' ('.$lang['SHORTNAME'].')</h1><textarea class="prev"  style="height: 160px; text-transform: none;" name="text['.$left.']['.$lang['ID'].']" id="text_'.$left.'_'.$lang['ID'].'">'.$rw['TEXT'].'</textarea></div>';
		}
		$t = $t . '</div></div>';
		return $t;
	}
	function getCnBlock($name, $id, $bid, $left)
	{
		global $DB, $parser;
		
		$tt = '';
		foreach ($parser['langs'] as $lang)
		{
			$sql = "select * from `tb_".$name."_contacts_data` where `CID` = '".$bid."' and `LANGID`='".$lang['ID']."'";
			$rw = $DB->getRowBySQL($sql);
			$tt = $tt . '<div class="half-block"><h1>'.voc('Name').' ('.$lang['SHORTNAME'].')</h1><input class="prev"  style="text-transform: none;" name="cname['.$left.']['.$lang['ID'].']" value="'.htmlspecialchars($rw['NAME']).'"></div>';
		}

		foreach ($parser['langs'] as $lang)
		{
			$sql = "select * from `tb_".$name."_contacts_data` where `CID` = '".$bid."' and `LANGID`='".$lang['ID']."'";
			$rw = $DB->getRowBySQL($sql);
			$tt = $tt . '<div class="half-block"><h1>'.voc('Address').' ('.$lang['SHORTNAME'].')</h1><input class="prev"  style="text-transform: none;" name="caddress['.$left.']['.$lang['ID'].']" value="'.htmlspecialchars($rw['ADDRESS']).'"></div>';
		}

		foreach ($parser['langs'] as $lang)
		{
			$sql = "select * from `tb_".$name."_contacts_data` where `CID` = '".$bid."' and `LANGID`='".$lang['ID']."'";
			$rw = $DB->getRowBySQL($sql);
			$tt = $tt . '<div class="half-block"><h1>'.voc('E-mail').' ('.$lang['SHORTNAME'].')</h1><input class="prev"  style="text-transform: none;" name="cemail['.$left.']['.$lang['ID'].']" value="'.htmlspecialchars($rw['EMAIL']).'"></div>';
		}

		foreach ($parser['langs'] as $lang)
		{
			$sql = "select * from `tb_".$name."_contacts_data` where `CID` = '".$bid."' and `LANGID`='".$lang['ID']."'";
			$rw = $DB->getRowBySQL($sql);
			$tt = $tt . '<div class="half-block"><h1>'.voc('Phone').' ('.$lang['SHORTNAME'].')</h1><input class="prev"  style="text-transform: none;" name="cphone['.$left.']['.$lang['ID'].']" value="'.htmlspecialchars($rw['PHONE']).'"></div>';
		}

		$tc = '<input type="hidden" name="lat['.$left.']" id="lat_'.$left.'" value="'.$parser['cn'][$left-1]['LAT'].'">';
		$tc = $tc . '<input type="hidden" name="lng['.$left.']" id="lng_'.$left.'" value="'.$parser['cn'][$left-1]['LNG'].'">';
		$tc = $tc . '<input type="hidden" name="formatted_address['.$left.']" id="formatted_address_'.$left.'" value="'.$parser['cn'][$left-1]['ADDRESS'].'">';

		$tt = $tt . $tc . '<div class="full-block"><h1>'.voc('Map address:').'</h1><input type="text" class="prev" data-t="'.$left.'" name="mapaddress['.$left.']" id="mapinput_'.$left.'" value="'.htmlspecialchars($parser['cn'][$left-1]['ADDRESS']).'" /></div><div class="full-block"><div id="map_'.$left.'" style="width: 100%; height: 220px;"></div></div>';
		
		$t = '<div class="mtext" id="mtext'.$left.'"><h2>'.voc('Contact').'<a style="cursor: pointer; margin-right: 20px;"><img class="move" src="/admin/img/icon-move-small.png" border="0" alt="" /></a><a href="javascript:deleteBlock(\''.$left.'\')" style="cursor: pointer;"><img  src="/admin/img/icon-close-small.png" border="0" alt="" /></a></h2><div class="add-item-line">'.$tt.'</div>';
		$t = $t . '</div>';
		return $t;
	}
	function getImageBlock($name, $id, $bid, $left, $im="8")
	{
		global $DB, $parser;
		$images = '<div class="mtext" id="mtext'.$left.'"><input type="hidden" name="block[]" value="'.$left.'" /><h2>'.voc('Images').': <a style="cursor: pointer; margin-right: 20px;"><img class="move" src="/admin/img/icon-move-small.png" border="0" alt="" /></a><a href="javascript:deleteBlock(\''.$left.'\')" style="cursor: pointer;"><img  src="/admin/img/icon-close-small.png" border="0" alt="" /></a></h2><div class="add-item-line"><div class="add-item-img-container" id="itemimg_'.$left.'">';
		$sql = "select * from `tb_".$name."_images` where `CID`='".$id."' and `ST` = '".$bid."' order by `LEFT`";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				$images .= '
					<p class="itemimg" data-type="'.getImageType($row['TYPE']).'" id="up_'.$left.'_'.$row['ID'].'" data-img="'.$row['ID'].'"><a style="display: block;" class="del" href="javascript:delImageT(\''.$left.'\', \''.$row['ID'].'\', \'\');"></a><input type="hidden" name="itemimg['.$left.'][]" value="'.$row['ID'].'" id="itemimg_'.$left.'_'.$row['ID'].'" /><img src="/getimage.php?id='.$im.getImageType($row['TYPE']).'1'.$row['ID'].'" /><a class="upproc" style="display: none; margin-left: 11px; margin-top: 20px;">0%</a></p>
				';
			}
		}
		$images .= '
			<p id="addpbut_'.$left.'"><a id="addimagebutt_'.$left.'" style="margin-left: 8px;margin-top: 8px;"><img src="/admin/img/icon-green-add-big.png" width="48" height="48" border="0" /></a></p></div></div></div><div id="upimgs_'.$left.'" style="display: none;"></div>
		';
		return $images;
	}

	function getImagesBlockSite($name, $bid)
	{
		global $DB, $parser;
		$sql = "select * from `tb_".$name."_images` where `ST` = '".$bid."' order by `LEFT`";
		$res = $DB->getRowsBySQL($sql);
		if (count($res)>0)
		{
			foreach ($res as $k=>$v)
			{
				list($w, $h, $type, $attr) = getimagesize("loads/".$name."/".$v['ID'].".".$v['EXT']);
				$res[$k]['w'] = $w;
				$res[$k]['h'] = $h;
			}
		}
		$parser['bw'] = '';
		$parser['bimages'] = $res;
		if (count($parser['bimages'])==2)
		{
			$parser['bw'] = '50%;';
			$parser['bh'] = '370px;';
		}
		if (count($parser['bimages'])==3)
		{
			$parser['bw'] = '33%;';
			$parser['bh'] = '200px;';
		}
		if (count($parser['bimages'])==4)
		{
			$parser['bw'] = '50%;';
			$parser['bh'] = '370px;';
		}
		if (count($parser['bimages'])==5)
		{
			$parser['bw'] = '20%;';
			$parser['bh'] = '170px;';
		}
		if (count($parser['bimages'])==6)
		{
			$parser['bw'] = '33%;';
			$parser['bh'] = '170px;';
		}
		if (count($parser['bimages'])==8)
		{
			$parser['bw'] = '25%;';
			$parser['bh'] = '170px;';
		}
	}

	function getSubMenuSite($id)
	{
		global $DB, $parser;
		$sql = "
			select 
				t.* ,
				(SELECT `ID` FROM `".TABLE_TREE_IMAGES."` where `CID`=t.ID order by `LEFT` LIMIT 1) as `IMID` ,
				(SELECT `EXT` FROM `".TABLE_TREE_IMAGES."` where `CID`=t.ID order by `LEFT` LIMIT 1) as `IMEXT`,
				tl.`NAME` as `NAME` ,
				tl.`TEXT` as `TEXT` ,
				tl.`URL` as `URL`
			from `".TABLE_TREE."` as t
			inner join `".TABLE_TREE_DATA."` as tl
			on t.ID=tl.CID and '".LANG."'=tl.LANGID
			where 
				t.STATUS = '1' 
				and t.SUB_ID='".$id."'
			order by
				t.LEFT
		";
		$parser['submenu'] = $DB->getRowsBySQL($sql);
		//print_r($parser['submenu']);
		//return getTemplate("site_texts_submenu");
	}

	function getSubTextTexts($id)
	{
		global $DB, $parser;
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
				and t.SUB_ID='".$id."'
			order by
				t.LEFT
		";
		$parser['smenu2'] = $DB->getRowsBySQL($sql);
		//print_r($parser['smenu2']);
		return getTemplate("site_texts_subtext");
	}

	function getPDFCompanies($id)
	{
		global $DB, $parser;
		$sql = "
		select
			t1.*,
			(select `NAME` from `tb_jurisdictions_data` where `LANGID`='".LANG."' and `CID`=`t1`.`PID`) as `JNAME`,
			IF(t2.`NAME`<> '', t2.`NAME`, 'без названия') as `CNAME`
		from `tb_companies` t1
		inner join `tb_companies_data` t2
		on t1.ID = t2.`CID` and `t2`.`LANGID`='".LANG."'
		where `t1`.`PID`='".$id."' and `t1`.`STATUS` IN (1,3)
		order by `t1`.`RDATE` desc
		";
		$parser['cmp'] = $DB->getRowsBySQL($sql);
		if (count($parser['cmp'])>0)
		{
			$out = getTemplate("site_pdf_companies");
			return $out;
		}
	}

	function getOrderServices($id)
	{
		global $DB, $parser;
		$sql = "
			select 
				*
			from `tb_orders_services` as `os`
			where `os`.`OID`='".$id."'
		";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				echo "<p>".$row['SERVICE']."</p>";
			}
		}
	}

	function getServicesMy($id)
	{
		global $DB, $parser;
		$sql = "
			select 
				os.* ,
				UNIX_TIMESTAMP(`os`.`RDTIME`) as `URDTIME`,
				(select `NAME` from `tb_jurisdictions_sr_data` where `CID`=`os`.`SID` and `LANGID`='".LANG."') as `SRNAME`
			from `tb_orders_services2` as `os`
			where `os`.`CID`='".$id."' and `UID`='".$parser['user']['ID']."'
			order by `SRNAME`
		";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				$cl = ($row['PSTATUS']=='1') ? " style=\"color: green;\"" : ""; 
				echo "<b ".$cl.">".$row['SRNAME'] ."</b>";
			}
		}
	}

	function getOrderServices2($cid, $uid)
	{
		global $DB, $parser;
		$sql = "
			select 
				os.* ,
				UNIX_TIMESTAMP(`os`.`RDTIME`) as `URDTIME`,
				(select `NAME` from `tb_jurisdictions_sr_data` where `CID`=`os`.`SID` and `LANGID`='".LANG."') as `SRNAME`
			from `tb_orders_services2` as `os`
			where `os`.`CID`='".$cid."' and `UID`='".$uid."'
			order by `os`.`RDTIME`
		";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				$cl = ($row['PSTATUS']=='0') ? "red" : "#1b8eca"; 
				echo "<p><a href=\"javascript:editCompanyService('".$row['ID']."')\" style=\"color: ".$cl.";\">".$row['SRNAME'] . " " . date("d.m.y", $row['URDTIME']) ."</a></p>";
			}
		}
	}

	function getUsersNumbers($id)
	{
		global $DB, $parser;
		$out = "";
		$sql = "select * from `tb_numbers` where `UID`='".$id."'";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				$out .= $row['NUMBER'] . " (".$row['SUMM']." &euro;), ";
			}
		}
		$out = trim($out, ", ");
		return $out;
	}


	function getMenuType($type)
	{
		$arr = Array(
			"Главная страница", 
			"Текстовая страница", 
			"Вопросы и ответы",
			"Отзывы",
			"Форма",
			"Контакты",
			"Основная страница",
			"Партнёры",
			"Документы"
		);
		$arr = Array(
				"Главная страница",				
				"Текстовая страница",
				"Услуги",
				"Продажа компаний",
				"Регистрация компаний",
				"Контакты",
				"Основная страница"
			);
		return $arr[$type-1];
	}

	function getMenuPos2($top, $bottom)
	{
		if ($top=="0" && $bottom="0")
		{
			return "Независимые страницы";
		}
		else
		{
			if ($top=="1" && $bottom=="1")
			{
				return "Верхнее меню/Нижнее меню";
			}
			else
			{
				if ($top=="1")
				{
					return "Верхнее меню";
				}
				else
				{
					return "Нижнее меню";
				}
			}
		}
	}

	function num2str($num) {
		$nul='nule';
		$ten=array(
			array('','viens','divi','tris','cetri','pieci','sesi','septini', 'astoni','devini'),
			array('','viens','divi','tris','cetri','pieci','sesi','septini', 'astoni','devini'),
		);
		$a20=array('desmit','vienpadsmit','divpadsmit','trispadsmit','cetrpadsmit' ,'piecpadsmit','sespadsmit','septinpadsmit','astonpadsmit','devinpadsmit');
		$tens=array(2=>'divdesmit','trisdesmit','cetrdesmit','piecdesmit','sesdesmit','septindesmit' ,'astondesmit','devindesmit');
		$hundred=array('','vins simts','divi simti','tris simti','cetri simti','pieci simti','sesi simti', 'septini simti','astoni simti','devini simti');
		$unit=array( // Units
			array('centi' ,'centi' ,'centi',	 1),
			array('euro'   ,'euro'   ,'euro'    ,0),
			array('tukstoss'  ,'tukstosi'  ,'tukstosi'     ,1),
			array('millions' ,'millioni','millioni' ,0),
			array('milliardi','milliardi','milliardi',0),
		);
		//
		list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
		$out = array();
		if (intval($rub)>0) {
			foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
				if (!intval($v)) continue;
				$uk = sizeof($unit)-$uk-1; // unit key
				$gender = $unit[$uk][3];
				list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
				// mega-logic
				$out[] = $hundred[$i1]; # 1xx-9xx
				if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
				else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
				// units without rub & kop
				if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
			} //foreach
		}
		else $out[] = $nul;
		$out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
		$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
		return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
	}

	/**
	 * Склоняем словоформу
	 * @ author runcore
	 */
	function morph($n, $f1, $f2, $f5) {
		$n = abs(intval($n)) % 100;
		if ($n>10 && $n<20) return $f5;
		$n = $n % 10;
		if ($n>1 && $n<5) return $f2;
		if ($n==1) return $f1;
		return $f5;
	}

	function getRekNum($num)
	{
		$a = explode("-", $num);
		$y = substr($a['0'], 0, 4);
		$m = substr($a['0'], 4, 2);
		$d = substr($a['0'], 6, 2);
		echo "KU-" . $d . "/" . $m . "/" . $y . "-" . $a['1'];
	}

	function checkTranslate($nm, $lang)
	{
		global $DB, $parser;
		if ($parser['vocs'][$nm-1]['svalue_'.$lang]=='1')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function getOrdersItems($id)
	{
		global $DB, $parser;
		$sql = "
			select
				c.*,
				`oi`.`OID`,
				`oi`.`PRICE` as `OPRICE`,
				`oi`.`CNT`,
				(select `ID` from `".TABLE_CATALOG_IMAGES."` where `CID` = `c`.`ID` and `STATUS`='0' order by `LEFT`  LIMIT 1) as `IMID` ,
				(select `TYPE` from `".TABLE_CATALOG_IMAGES."` where `CID` = `c`.`ID` and `STATUS`='0' order by `LEFT`  LIMIT 1) as `IMTYPE` ,
				IF(td.`URL`<>'', td.`URL`, `c`.`CID`) as `CATURL`,
				IF(cd.`NAME`<>'', cd.`NAME`, 'без названия') as `CNAME`,
				IF(cd.`URL`<>'', cd.`URL`, `c`.`ID`) as `CURL`
			from `".TABLE_CATALOG."` as `c`
			".$sqj."
			inner join `".TABLE_CATALOG_DATA."` as `cd`
			on `c`.`ID`=`cd`.`CID` and '".LANG."'=`cd`.`LANGID`
			inner join `tb_orders_items` as `oi`
			on `c`.`ID`=`oi`.`CID` and '".$id."'=`oi`.`OID`
			inner join `".TABLE_CAT_DATA."` as `td`
			on `c`.`CID`=`td`.`CID` and '".LANG."'=`td`.`LANGID`
			where 1=1 and `c`.`CID`>0 
		";
		$parser['items'] = $DB->getRowsBySQL($sql);
		return getTemplate('admin_offers_items');
	}

	function getItemParameters($id, $cid, $limit, $pr)
	{
		global $parser, $DB;

		if ($pr!="")
		{
			$ppr = $pr;
		}
		else
		{
			$ppr = "0";
		}
		$sql = "
			select 
				t.* ,
				IF(td.`NAME`<>'', td.`NAME`, 'без названия') as `CNAME`,
				GROUP_CONCAT(IF(td2.`NAME`<>'', td2.`NAME`, 'без названия') SEPARATOR ',') as `PNAME`,
				GROUP_CONCAT(CONCAT('pfi' , td2.`CID`) SEPARATOR ' ') as `PIDS`
			from `".TABLE_PR."` as `t`
			inner join `".TABLE_PR_DATA."` as `td`
			on `t`.`ID`=`td`.`CID` and '".LANG."'=`td`.`LANGID`
			inner join `".TABLE_PR."` as `pf`
			on `t`.`ID`=`pf`.`PID` and `pf`.`ID` IN ($ppr)
			inner join `".TABLE_PR_DATA."` as `td2`
			on `pf`.`ID`=`td2`.`CID` and '".LANG."'=`td2`.`LANGID`
			where `t`.`PID`='0'
			GROUP by `t`.`ID` order by t.`LEFT` LIMIT 5
		";
		$parser['pfs'] = $DB->getRowsBySQL($sql);
		return getTemplate('site_catalog_pfs');
	}

	function getBlockCnt($item, $id, $type)
	{
		global $parser, $DB;
		switch ($type)
		{
			case 'media':
				$sql = "select * from `".TABLE_CATALOG_BLOCKS_DATA."` where `BID`='".$id."'";
				$rw = $DB->getRowBySQL($sql);
				return $rw['VALUE'];
				break;
			case 'text':
				$sql = "select * from `".TABLE_CATALOG_BLOCKS_DATA."` where `BID`='".$id."' and `LANGID`='".LANG."'";
				$rw = $DB->getRowBySQL($sql);
				return $rw['VALUE'];
				break;
			case 'images':
				$sql = "select * from `".TABLE_CATALOG_IMAGES."` where `CID`='".$item."' and `STATUS`='".$id."' order by `LEFT`";
				$parser['bimages'] = $DB->getRowsBySQL($sql);
				return getTemplate('site_blocks_images');
				break;
		}
	}

	function getBlockContent($num, $id, $type)
	{
		global $parser, $DB;
		$parser['bnum'] = $num;
		$parser['bid'] = $id;
		switch ($type)
		{
			case 'media':
				$sql = "select * from `".TABLE_CATALOG_BLOCKS_DATA."` where `BID`='".$id."'";
				$rw = $DB->getRowBySQL($sql);
				return '<textarea name="video'.$num.'" id="video'.$num.'">'.$rw['VALUE'].'</textarea>';
				break;
			case 'text':
				$sql = "select * from `".TABLE_CATALOG_BLOCKS_DATA."` where `BID`='".$id."'";
				if ($res=$DB->Query($sql))
				{
					while ($row=$DB->Fetch($res))
					{
						$parser['b_text_'.$row['LANGID']] = $row['VALUE'];
					}
				}
				return getTemplate('admin_blocks_text');
				break;
			case 'images':
				$sql = "select * from `".TABLE_CATALOG_IMAGES."` where `CID`='".ID."' and `STATUS`='".$id."' order by `LEFT`";
				$parser['bimages'] = $DB->getRowsBySQL($sql);
				return getTemplate('admin_blocks_images');
				break;
		}
	}

	function getParametersValues($id, $template="admin_parameters_values", $cc="")
	{
		global $parser, $DB;

		$sq = "";
		if ($cc=="1")
		{
			$sq .= " and (select count(*) from `tb_catalog_pr` where `PID`=`t`.`ID`) > 0 ";
		}

		$sql = "
			select 
				t.* ,
				IF(td.`NAME`<>'', td.`NAME`, 'без названия') as `CNAME`
			from `".TABLE_PR."` as `t`
			inner join `".TABLE_PR_DATA."` as `td`
			on `t`.`ID`=`td`.`CID` and '".LANG."'=`td`.`LANGID`
			where `PID`='".$id."' $sq order by `LEFT`
		";
		$parser['pf'] = $DB->getRowsBySQL($sql);
		if (count($parser['pf'])>0)
		{
			return getTemplate($template);
		}
		else
		{
			return '';
		}
	}

	function getMenuSubCategories($id, $l="0", $status="")
	{
		global $parser, $DB;
		$sq = "";
		if ($status!="")
		{
			$sq .= " and `t`.`STATUS`='".$status."' ";
		}
		$sql = "
			select 
				t.* ,
				(select count(*) as `cnt` from `tb_catalog` where `CAT1`=`t`.`ID` OR `CAT2`=`t`.`ID` OR `CAT3`=`t`.`ID` ) as `cnt`,
				IF(td.`URL`<>'', td.`URL`, `t`.`ID`) as `URL`,
				IF(td.`NAME`<>'', td.`NAME`, 'без названия') as `CNAME`
			from `".TABLE_CAT."` as `t`
			inner join `".TABLE_CAT_DATA."` as `td`
			on `t`.`ID`=`td`.`CID` and '".LANG."'=`td`.`LANGID`
			where `PID`='".$id."' ".$sq." order by `LEFT`
		";

		$result = "";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				if ($l=="0")
				{
					$result .= '<div class="sub-category-block"><h1>'.$row['CNAME'].'</h1>'.getMenuSubCategories($row['ID'], "1", $status).'</div>';
				}
				if ($l=="1")
				{
					if ($row['cnt']>0)
					{
						$result .= '<a href="/'.cLANG.'/'.$row['URL'].'/">'.$row['CNAME'].'  <b>('.$row['cnt'].')</b></a>';
					}
				}
			}
		}
		return $result;
	}

	function getMenuSubCategoriesMob($id, $l="0", $status="")
	{
		global $parser, $DB;
		$sq = "";
		if ($status!="")
		{
			$sq .= " and `t`.`STATUS`='".$status."' ";
		}
		$sql = "
			select 
				t.* ,
				(select count(*) as `cnt` from `tb_catalog` where `CAT1`=`t`.`ID` OR `CAT2`=`t`.`ID` OR `CAT3`=`t`.`ID` ) as `cnt`,
				IF(td.`URL`<>'', td.`URL`, `t`.`ID`) as `URL`,
				IF(td.`NAME`<>'', td.`NAME`, 'без названия') as `CNAME`
			from `".TABLE_CAT."` as `t`
			inner join `".TABLE_CAT_DATA."` as `td`
			on `t`.`ID`=`td`.`CID` and '".LANG."'=`td`.`LANGID`
			where `PID`='".$id."' ".$sq." order by `LEFT`
		";

		$result = "";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				if ($l=="0")
				{
					$result .= '<b>'.$row['CNAME'].'</b>'.getMenuSubCategoriesMob($row['ID'], "1", $status);
				}
				if ($l=="1")
				{
					if ($row['cnt']>0)
					{
						$result .= '<a href="/'.cLANG.'/'.$row['URL'].'/">'.$row['CNAME'].'  ('.$row['cnt'].')</a>';
					}
				}
			}
		}
		return $result;
	}
	
	function getCategories($id)
	{
		global $parser, $DB;
		$parser['cid'] = $id;
		$sql = "
			select 
				t.* ,
				(select count(*) as `cnt` from `tb_catalog` where `CAT1`=`t`.`ID` OR `CAT2`=`t`.`ID` OR `CAT3`=`t`.`ID` ) as `cnt`,
				IF(td.`NAME`<>'', td.`NAME`, 'без названия') as `CNAME`
			from `".TABLE_CAT."` as `t`
			inner join `".TABLE_CAT_DATA."` as `td`
			on `t`.`ID`=`td`.`CID` and '".LANG."'=`td`.`LANGID`
			where `PID`='".$id."' order by `LEFT`
		";
		$parser['cats'] = $DB->getRowsBySQL($sql);
		if (count($parser['cats'])>0)
		{
			return getTemplate("admin_categories_sub");
		}
		else
		{
			return getTemplate("admin_categories_sub_empty");
		}
	}

	function getCategories2($id)
	{
		global $parser, $DB;
		$parser['cid2'] = $id;
		$sql = "
			select 
				t.* ,
				(SELECT COUNT(*) as `cnt` from `".TABLE_CATALOG."` where `CID`=`t`.`ID`) as `cnt`,
				IF(td.`NAME`<>'', td.`NAME`, 'без названия') as `CNAME`
			from `".TABLE_CAT."` as `t`
			inner join `".TABLE_CAT_DATA."` as `td`
			on `t`.`ID`=`td`.`CID` and '".LANG."'=`td`.`LANGID`
			where `PID`='".$id."' order by `LEFT`
		";
		$parser['cats2'] = $DB->getRowsBySQL($sql);
		if (count($parser['cats2'])>0)
		{
			return getTemplate("admin_categories_sub2");
		}
		else
		{
			return "";
		}
	}

	function getUserPrice($price)
	{
		$s = (int)$_SESSION['userdata']['SKIDKA'];
		$k = $price / 100 * $s;
		return number_format($price - $k, 2, '.', '');
	}

	function getCrCNT($pid, $cid, $sid)
	{
		return $_SESSION['cart'][$pid."_".$cid."_".$sid];
	}

	function getParserVar($key1, $key2, $key3)
	{
		global $parser;
		return $parser[$key1][$key2][$key3];
	}

	function getCLImages($pid, $cid)
	{
		global $parser, $DB;
		$parser['cid'] = $cid;
		$sql = "select * from `tb_catalog_images` where `CID`='".$pid."' and `ST`='".$cid."' order by `LEFT`";
		$parser['pimages'] = $DB->getRowsBySQL($sql);
		echo getTemplate('site_catalog_images');
	}

	function getListSizes($ids)
	{
		global $parser;
		$arr = explode(",", $ids);
		if (count($parser['sizes'])>0)
		{
			foreach ($parser['sizes'] as $v)
			{
				if (in_array($v['ID'], $arr))
				{
					echo $v['CODE']. " ";
				}
			}
		}
	}

	function getCatUrl2($url, $t="")
	{
		$c = "";
		if ($t=="")
		{
			$c = implode($_SESSION['curls'], "/");
			if (!in_array($url, $_SESSION['curls']))
			{
				$c .= "/" . $url;
			}
		}
		else
		{
			if (count($_SESSION['curls'])>0)
			{
				foreach ($_SESSION['curls'] as $v)
				{
					if ($v!=$url)
					{
						$c .= $v."/";
					}
				}
			}
			$c = trim($c, "/");
		}
		$c = trim($c, "/");
		if ($c=="") $c = "all";
		echo $c;
	}

	function getCatUrl3($url, $t="")
	{
		$c = "";
		if ($t=="")
		{
			$c = implode($_SESSION['curls'], "/");
			if (!in_array($url, $_SESSION['curls']))
			{
				$c .= "/" . $url;
			}
		}
		else
		{
			if (count($_SESSION['curls'])>0)
			{
				foreach ($_SESSION['curls'] as $v)
				{
					if ($v!=$url)
					{
						$c .= $v."/";
					}
				}
			}
			$c = trim($c, "/");
		}
		if (OBJ=="all") $c = "all";
		echo $c;
	}

	function getFrames($id)
	{
		global $DB, $parser;
		$result = "";
		$sql = "select * from `".TABLE_HTU_IMAGES2."` where `CID`='".$id."' order by `ST`";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				$result .= ", '".$row['ID'].".".$row['EXT']."'";
			}
		}
		return $result;
	}

	function getCatalogImages2($id, $clid, $fl="catalog", $tb="tb_catalog_images", $field="CID")
	{
		global $DB, $parser;
		$sql = "select * from `".$tb."` where `".$field."`='".$id."' and `ST`='".$clid."' order by `LEFT`";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				list($w, $h, $type, $attr) = getimagesize("loads/".$fl."/".$row['ID'].".".$row['EXT']);
				$margintop = "0";
				$marginleft = "0";
				$neww = 0;
				$newh = 0;
				if ($w>$h)
				{
					$nhp = ( 170 - $h ) / 2 ;
					$parser['margintop'] = ceil($nhp);
					if ($w>170)
					{
						$cf = 170/$w;
						$nh = $h * $cf;
						$nhp = ( 170 - $nh ) / 2 ;
						$neww = "170";
						$newh = $nh;
						$margintop = $nhp;
					}
				}
				else
				{
					if ($w!=$h)
					{
						if ($h>170)
						{
							$cf = 170/$h;
							$nw = $w * $cf;
							$nwp = ( 170 - $nw ) / 2 ;
							$newh = "170";
							$neww = $nw;
							$marginleft = $nwp;
						}
						else
						{
							$nwp = ( 170 - $w ) / 2 ;
							$nwh = ( 170 - $h ) / 2 ;
							$newh = $h;
							$neww = $w;
							$marginleft = $nwp;
							$margintop = $nhp;
						}
					}
				}

				$dv = '';
				foreach ($parser['langs'] as $lng)
				{
					$sql = "select * from `tb_projects_images_data` where `CID`='".$row['ID']."' and `LANGID`='".$lng['ID']."'";
					$rww = $DB->getRowBySQL($sql);
					$dv .= '<input type="hidden" name="imgtext_'.$row['ID'].'_'.$lng['ID'].'" id="imgtext_'.$row['ID'].'_'.$lng['ID'].'" value="'.htmlspecialchars($rww['TEXT']).'" />';
				}

				echo '<div class="climg" id="item-img'.$row['ID'].'">'.$dv.'<input type="hidden" name="imgtext"><input type="hidden" name="img_'.$clid.'[]" value="'.$row['ID'].'" id="dtimg'.$row['ID'].'" /><input type="hidden" name="imgold_'.$clid.'[]" value="'.$row['ID'].'" /><a href="javascript:deleteimg(\''.$row['ID'].'\')">'.voc('Удалить').'</a><a class="imgta" href="javascript:textimg(\''.$row['ID'].'\')">'.voc('Текст').'</a><img src="/loads/'.$fl.'/'.$row['ID'].'.'.$row['EXT'].'" width="'.$neww.'" style="margin-left: '.$marginleft.'px; margin-top: '.$margintop.'px; " height="'.$newh.'" id="img'.$row['ID'].'" /></div>';
			}
		}
	}


	function getDialogImages2($id, $clid, $fl="dialog", $tb="tb_interview_dimages", $field="CID")
	{
		global $DB;
		$sql = "select * from `".$tb."` where `".$field."`='".$id."' and `ST`='".$clid."' order by `LEFT`";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				list($w, $h, $type, $attr) = getimagesize("loads/".$fl."/".$row['ID'].".".$row['EXT']);
				$margintop = "0";
				$marginleft = "0";
				$neww = 0;
				$newh = 0;
				if ($w>$h)
				{
					$nhp = ( 100 - $h ) / 2 ;
					$parser['margintop'] = ceil($nhp);
					if ($w>170)
					{
						$cf = 100/$w;
						$nh = $h * $cf;
						$nhp = ( 100 - $nh ) / 2 ;
						$neww = "100";
						$newh = $nh;
						$margintop = $nhp;
					}
				}
				else
				{
					if ($w!=$h)
					{
						if ($h>100)
						{
							$cf = 100/$h;
							$nw = $w * $cf;
							$nwp = ( 100 - $nw ) / 2 ;
							$newh = "100";
							$neww = $nw;
							$marginleft = $nwp;
						}
						else
						{
							$nwp = ( 100 - $w ) / 2 ;
							$nwh = ( 100 - $h ) / 2 ;
							$newh = $h;
							$neww = $w;
							$marginleft = $nwp;
							$margintop = $nhp;
						}
					}
				}
				echo '<div class="climg2" id="item-dimg'.$row['ID'].'"><input type="hidden" name="dimg_'.$clid.'[]" value="'.$row['ID'].'" id="dtdimg'.$row['ID'].'" /><a href="javascript:deleteimgd(\''.$row['ID'].'\')">'.voc('Удалить').'</a><img src="/loads/'.$fl.'/'.$row['ID'].'.'.$row['EXT'].'" width="'.$neww.'" style="margin-left: '.$marginleft.'px; margin-top: '.$margintop.'px; " height="'.$newh.'" id="dimg'.$row['ID'].'" /></div>';
			}
		}
	}

	function getFramesID($id)
	{
		global $DB, $parser;
		$result = "";
		$sql = "select * from `".TABLE_HTU_IMAGES2."` where `CID`='".$id."' order by `ST`";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				$result .= ", '".$row['ID']."'";
			}
		}
		return $result;
	}

	function getSCategories($id, $url)
	{
		global $DB, $parser;
		$sql = "
			select 
				`c`.* ,
				`cn`.`VALUE` as `NAME` ,
				`cu`.`VALUE` as `URL` 
			from `".TABLE_SCAT."` as `c`
			inner join `".TABLE_SCAT_NAME."` as `cn`
			on `c`.ID=`cn`.CID and '".LANG."'=`cn`.`LANGID`
			inner join `".TABLE_SCAT_URL."` as `cu`
			on `c`.ID=`cu`.CID and '".LANG."'=`cu`.`LANGID`
			inner join `".TABLE_SCAT_STATUS."` as `cs`
			on `c`.ID=`cs`.CID and '".LANG."'=`cs`.`LANGID`
			where `c`.`TID`='".$id."' and `c`.`STATUS`='1' and `c`.`CNT`>0 order by `LEFT`
		";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				if (ID2==$row['URL'])
				{
					$s = "id=\"selected\"";
				}
				else
				{
					$s = "";
				}
				echo '<a href="/'.cLANG.'/'.OBJ.'/'.TASK.'/'.ID.'/'.$url.'/'.$row['URL'].'/" '.$s.' class="margin"><i></i>'.$row['NAME'].'</a>';
			}
		}
	}

	function getSCategories2($id, $url, $url2)
	{
		global $DB, $parser;
		$sql = "
			select 
				`c`.* ,
				`cn`.`VALUE` as `NAME` ,
				`cu`.`VALUE` as `URL` 
			from `".TABLE_SCAT."` as `c`
			inner join `".TABLE_SCAT_NAME."` as `cn`
			on `c`.ID=`cn`.CID and '".LANG."'=`cn`.`LANGID`
			inner join `".TABLE_SCAT_URL."` as `cu`
			on `c`.ID=`cu`.CID and '".LANG."'=`cu`.`LANGID`
			inner join `".TABLE_SCAT_STATUS."` as `cs`
			on `c`.ID=`cs`.CID and '".LANG."'=`cs`.`LANGID`
			where `c`.`TID`='".$id."' and `c`.`STATUS`='1' and `c`.`CNT`>0 order by `LEFT`
		";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				if (ID2==$row['URL'])
				{
					$s = "id=\"selected\"";
				}
				else
				{
					$s = "";
				}
				echo '<a href="/'.cLANG.'/'.OBJ.'/'.TASK.'/'.$url2.'/'.$url.'/'.$row['URL'].'/" '.$s.' ><i></i>'.$row['NAME'].'</a>';
			}
		}
	}

	function getStatC($id)
	{
		global $parser, $DB;
		if (count($parser['cstat'.$id])>0)
		{
			foreach ($parser['cstat'.$id] as $k=>$v)
			{
				echo '{country: "'.$parser['countries'][$k]['NAME'].'", value: '.$v.'},';
			}
		}
	}

	function getStatS($id)
	{
		global $parser, $DB;
		if (count($parser['sstat'.$id])>0)
		{
			foreach ($parser['sstat'.$id] as $k=>$v)
			{
				$sex = ($k=="1") ? "Male" : "Female";
				echo '{country: "'.$sex.'", value: '.$v.'},';
			}
		}
	}

	function getStatA($id)
	{
		global $parser, $DB;
		if (count($parser['astat'.$id])>0)
		{
			foreach ($parser['astat'.$id] as $k=>$v)
			{
				switch ($k)
				{
					case '0':
						$age = "0-18";
						break;
					case '18':
						$age = "19-30";
						break;
					case '30':
						$age = "31-45";
						break;
					case '45':
						$age = "46-60";
						break;
					case '60':
						$age = "60<";
						break;
				}
				echo '{country: "'.$age.'", value: '.$v.'},';
			}
		}
	}

	function domain_exists($email, $record = 'MX')
	{
		list($user, $domain) = split('@', $email);
		if ($domain=="")
		{
			return false;
		}
		else
		{
			return checkdnsrr($domain, $record);
		}
	}

	function getOtveti($id, $vleft, $lang, $ln)
	{
		global $DB, $parser;
		$out = "";
		for ($i=1; $i<=4; $i++)
		{
			$sql = "select * from `tb_otveti` where `VID` = '".$id."' and `LEFT`='".$i."' order by `LEFT`";
			$rw = $DB->getRowBySQL($sql);
			if ((int)$rw['ID']>0)
			{
				$sql = "select * from `tb_otveti_name` where `LANGID` = '".$lang."' and `CID`='".$rw['ID']."'";
				$rw2 = $DB->getRowBySQL($sql);
				$out .= '<tr><th>Ответ '.$row['LEFT'].' ('.$ln.'): </th><td><input type="text" name="a_'.$vleft.'_'.$lang.'['.$rw['LEFT'].']" value="'.htmlspecialchars($rw2['VALUE']).'" style="width: 400px;" /></td></tr>';
			}
		}
		return $out;
	}

	function getAnswersSite($id, $u="1")
	{
		global $DB, $parser;
		$out = "";
		$sql = "
			select 
			 `a`.* ,
			 `an`.`VALUE` as `NAME`
			from `tb_otveti` as `a` 
			inner join `tb_otveti_name` as `an`
			on `a`.ID = `an`.CID and '".LANG."' = `an`.`LANGID`
			where `a`.`VID` = '".$id."' order by `LEFT`
		";
		if ($res = $DB->Query($sql))
		{
			$nm = 0;
			while ($row = $DB->Fetch($res))
			{
				if (trim($row['NAME'])!="")
				{
					$nm++;
					$cb = ($nm=="100") ? "checked" : "";
					$d = (in_array($parser['item']['ID'], $parser['userlots'])) ? "disabled" : "";
					$sql = "select * from `tb_users_otveti` where `VID`='".$id."' and `UID`='".$_SESSION['userdata']['ID']."'";
					$rr = $DB->getRowBySQL($sql);
					if ($rr['OID']==$row['ID']) 
					{
						$ch = "checked";
					}
					else
					{
						$ch = "";
					}
					if ($u=="0") $ch = "";
					$out .= '<label><input name="a'.$id.'" '.$d.' '.$ch.' value="'.$row['ID'].'" type="radio" /><i>'.$row['NAME'].'</i></label>';
				}
			}
		}
		return $out;
	}

	function getCCnt($id)
	{
		global $DB, $parser;
		$sql = "select COUNT(*) as `cnt` from `tb_catalog` where `TID`='".$id."'";
		$rw = $DB->getRowBySQL($sql);
		return "количество товаров: " . $rw['cnt'];
	}

	function getCURL($id)
	{
		global $DB, $parser;
		$sql = "select `VALUE` from `tb_categories_url` where `CID`='".$id."' and `LANGID`='".LANG."'";
		$rw = $DB->getRowBySQL($sql);
		return $rw['VALUE'];
	}


	function getEqs($id)
	{
		global $DB, $parser;
		$resl = "";
		$sql = "select * from `tb_catalog_eq` where `CID` = '".$id."' and `LANGID`='".LANG."' order by `ID`";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				switch($row['CN'])
				{
					case '1':
						$cn = 'л.';
						break;
					case '2':
						$cn = 'мл.';
						break;
					case '3':
						$cn = 'гр.';
						break;
					case '4':
						$cn = 'кг.';
						break;
					case '5':
						$cn = 'шт.';
						break;
				}
				if (trim($row['VALUE'])!="")
				{
					$resl .= "<b>/</b><a>".$row['VALUE'] . " " . $cn ."</a>";
				}
			}
		}
		return $resl;
	}

	function getMenuIcon($id)
	{
		//
	}

	function socketmail($to, $from, $subject, $message, $textfrom)
	{

		if (mail($to, $subject, $message, "From: $from\r\n"."Reply-To: ".$from."\r\n"."Content-Type: text/html; charset=utf-8\r\n"))
		{
			return true;
			
		}
		else
		{
			return false;
		}
	}

	function getOrdersStat($id)
	{
		global $parser, $DB;
		$sql = "
			select 
				SUM(`oi`.CNT) as `cnt`
			from `tb_orders_items` as `oi`
			inner join `tb_orders` as `o`
			on `oi`.OID=`o`.ID and '3'=`o`.STATUS and '".date("Y-m-d", $_SESSION['stat_dt1'])."'<=`o`.DATE and '".date("Y-m-d", $_SESSION['stat_dt2'])."'>=`o`.DATE
			where `oi`.CID='".$id."'
		";
		$row = $DB->getRowBySQL($sql);
		return (int)$row['cnt'];
	}

	function getPrice($price)
	{
		if ($_SESSION['val']=="rur")
		{
			return number_format($price, "2", ".", ",");
		}
		if ($_SESSION['val']=="eur")
		{
			return number_format($price/KOEF, "2", ".", ",");
		}
	}

	function getCFields($id)
	{
		global $parser, $DB;
		$parser['cfields'] = $parser['cfields_'.$id];
		return getTemplate('site_cfields');
	}


	function getBC($id)
	{
		global $parser;
		$parser['bc'] = $parser['rg_'.$id];
		return getTemplate('site_first_bc');
	}

	function getCatalogLink($id)
	{
		global $DB;
		$res = "";
		$sql = "
			select 
				r.* ,
				ru.VALUE as `URL`
			from `tb_tree` as r
			inner join `tb_tree_url` as ru
			on r.ID=ru.TID and '".LANG."'=ru.LANGID
			where r.ID='".$id."' and r.STATUS='1'
		";
		$row = $DB->getRowBySQL($sql);
		if ((int)$row['SUB_ID'])
		{
			$res = getCatalogLink($row['SUB_ID']);
		}
		IF ($row['URL']!="")
		{
			$res .= $row['URL'] . "/";
		}
		return $res;
	}

	function getCatalogTitle($id)
	{
		global $DB;
		$res = "";
		$sql = "
			select 
				r.* ,
				ru.VALUE as `TITLE`
			from `tb_tree` as r
			inner join `tb_tree_title` as ru
			on r.ID=ru.TID and '".LANG."'=ru.LANGID
			where r.ID='".$id."' and r.STATUS='1'
		";
		$row = $DB->getRowBySQL($sql);
		if ((int)$row['SUB_ID'])
		{
			$res = getCatalogTitle($row['SUB_ID']);
		}
		IF ($row['TITLE']!="")
		{
			$res .= " &mdash; " . $row['TITLE'];
		}
		return $res;
	}

	function getCatalogTitle2($id)
	{
		global $DB;
		$res = "";
		$sql = "
			select 
				r.* ,
				rl.VALUE as `URL` ,
				ru.VALUE as `TITLE`
			from `tb_tree` as r
			inner join `tb_tree_langs` as ru
			on r.ID=ru.TID and '".LANG."'=ru.LANGID
			inner join `tb_tree_url` as rl
			on r.ID=rl.TID and '".LANG."'=rl.LANGID
			where r.ID='".$id."' and r.STATUS='1'
		";
		$row = $DB->getRowBySQL($sql);
		if ((int)$row['SUB_ID'])
		{
			$res = getCatalogTitle2($row['SUB_ID']);
		}
		IF ($row['TITLE']!="")
		{
			if ($row['ID']!=U_ID)
			{
				$res .= "<a href=\"/".cLANG."/".$row['URL']."/\">".$row['TITLE']."</a><i>::</i>";
			}
		}
		return $res;
	}

	function getSubMenu($id)
	{
		global $DB, $parser;
		$sql = "select * from `tb_admin_objects` where `PARENTID`='".$id."' order by `LEFT`";
		$parser['smenu'] = $DB->getRowsBySQL($sql);
		return getTemplate("admin_submenu");
	}

	function gh($text)
	{
		return htmlspecialchars($text);
	}

	function chNm($num, $dg="2")
	{
		$a = $num % $dg;
		return ((int)$a==0) ? true : false;
	}

	function arrToParser($arr, $prefix="")
	{
		global $parser;
		if (count($arr)>0)
		{
			foreach ($arr as $k=>$v)
			{
				if ($prefix!="")
				{
					$parser[$prefix.'_'.$k] = $v;
				}
				else
				{
					$parser[$k] = $v;
				}
			}
		}
	}

	function array2str($arr, $type=0) 
	{
		switch ($type) 
		{
			case 1:
				$result = "'0'";
				if (count($arr)>0)
				{
					foreach ($arr as $v)
					{
						$result .= ",'".$v."'";
					}
				}
				break;
			default:
				$result = "0";
				if (count($arr)>0)
				{
					foreach ($arr as $v)
					{
						$result .= ",".$v;
					}
				}	
				break;
		}
		return $result;
	}

	function getSeriesByCat($id)
	{
		global $DB, $parser;
		$sql = "
			select
				* ,
				`sn`.VALUE as `NAME`
			from `tb_series` as `s`
			inner join `tb_series_name` as `sn`
			on `s`.ID=`sn`.CID and '".LANG."'=`sn`.LANGID
			where `s`.TID='".$id."'
		";
		$parser['sr'] = $DB->getRowsBySQL($sql);
		$parser['srid'] = $id;
		return getTemplate("admin_catalog_series");
	}

	function checkLangFormValues($arr, $field)
	{
		global $parser;
		foreach ($parser['langs'] as $lang)
		{
			if (trim($arr[$field . "_" . $lang['ID']])=="")
			{
				return false;
			}
		}
		return true;
	}

	function getLValue($key, $akey, $lid, $field, $def="-")
	{
		global $parser;
		if (trim($parser[$key][$akey][$field . "_" . $lid])!="")
		{
			return trim($parser[$key][$akey][$field . "_" . $lid]);
		}
		else
		{
			return $def;
		}
	}

	function getVFValue($name, $lid)
	{
		global $parser;
		return $parser[$name . "_" . $lid];
	}


	function getSysVoc()
	{
		global $DB, $parser;

		$SQL = "
			SELECT 
				*
			FROM `".TABLE_VOC."`
		";
		if ($res=$DB->Query($SQL))
		{
			while ($row=$DB->Fetch($res))
			{
				$SQL = "SELECT `VALUE` FROM `".TABLE_VOC_LANGS."` WHERE `LANGID`='".LANG."' AND `VOCID`='".$row['ID']."'";
				$rw = $DB->getRowBySQL($SQL);
				if (!isset($parser['sys_voc_' . $row['TYPE']]))
				{
					$parser['sys_voc_' . $row['TYPE']] = array();
				}
				if (!$rw['VALUE']) $rw['VALUE'] = "";
				$parser['sys_voc_' . $row['TYPE']][$row['TRANS']] = $rw['VALUE'];
			}
		}
	}

	function voc($var, $type="admin") {
		global $parser, $DB;
		$tp = VOC_TYPE;
		if ($parser['sys_voc_'.$tp][$var]!="")
		{
			return $parser['sys_voc_'.$tp][$var];
		}
		else
		{
			if (!isset($parser['sys_voc_'.$tp][$var]))
			{
				//exit('not isset ' . $var);
				$parser['sys_voc_' . $tp][$var] = $var;
				$SQL = "INSERT INTO `".TABLE_VOC."` ( `TRANS` , `TYPE` ) values ( '".mysql_escape_string($var)."' , '".$tp."' )";
				$DB->Query($SQL);
				$vocid = $DB->getInsertId();
				foreach ($parser['langs'] as $v)
				{
					if ($v['DEF']=='1')
					{
						$SQL = "INSERT INTO `".TABLE_VOC_LANGS."` ( `VOCID` , `LANGID` , `VALUE` ) values ( '".$vocid."' , '".$v['ID']."' , '".mysql_escape_string($var)."' ) ";
						$DB->Query($SQL);
					}
					else
					{
						$SQL = "INSERT INTO `".TABLE_VOC_LANGS."` ( `VOCID` , `LANGID` ) values ( '".$vocid."' , '".$v['ID']."' ) ";
						$DB->Query($SQL);
					}
				}
			}
			$SQL = "SELECT `ID` FROM `".TABLE_VOC."` WHERE `TRANS`='".mysql_escape_string($var)."' AND `TYPE`='".$tp."'";
			$rw = $DB->getRowBySQL($SQL);
			$vocid = $rw['ID'];
			foreach ($parser['langs'] as $v)
			{
				$SQL = "SELECT `ID` FROM `".TABLE_VOC_LANGS."` WHERE `VOCID`='".$vocid."' AND `LANGID`='".$v['ID']."'";
				$rw2 = $DB->getRowBySQL($SQL);
				if ((int)$rw2['ID']>0)
				{
					//
				}
				else
				{
					if ($v['DEF']=='1')
					{
						$SQL = "INSERT INTO `".TABLE_VOC_LANGS."` ( `VOCID` , `LANGID` , `VALUE` ) values ( '".$vocid."' , '".$v['ID']."' , '".mysql_escape_string($var)."' ) ";
						$DB->Query($SQL);
					}
					else
					{
						$SQL = "INSERT INTO `".TABLE_VOC_LANGS."` ( `VOCID` , `LANGID` ) values ( '".$vocid."' , '".$v['ID']."' ) ";
						$DB->Query($SQL);
					}
				}

			}
			return $var;
		}
	}

	function getStatus($st)
	{
		switch ($st)
		{
			case '1':
				return voc(TRANS_ENABLED);
				break;
			case '0':
				return voc(TRANS_DISABLED);
				break;
		}
	}

	function getYN($st)
	{
		switch ($st)
		{
			case '1':
				return voc(TRANS_YES);
				break;
			case '0':
				return voc(TRANS_NO);
				break;
		}
	}

	function getTreeType($tp)
	{
		switch ($tp)
		{
			case '1':
				return voc(TRANS_FIRST_PAGE);
				break;
			case '2':
				return voc(TRANS_TREE_GROUP);
				break;
			case '3':
				return voc(TRANS_TEXT_PAGE);
				break;
			case '5':
				return voc(TRANS_CONTACTS);
				break;
			case '6':
				return voc(TRANS_BUY_PLACES);
				break;
			case '61':
				return voc('Services');
				break;
			case '62':
				return voc('Projects');
				break;
			case '63':
				return voc('Interview');
				break;
			case '64':
				return voc('Partners');
				break;
			case '7':
				return voc(TRANS_HOW_TO_USE);
				break;
			case '71':
				return voc('FAQ');
				break;
			case '72':
				return voc('Sitemap');
				break;
			case '77':
				return voc('Menu block');
				break;
			case '99':
				return voc(TRANS_REDIRECT);
				break;
		}
	}

	function getAnswers($nm)
	{
		global $parser;
		$parser['qnum'] = $nm;
		$parser['answers'] = $parser['quesions_'.$nm];
		return getTemplate('site_answers');
	}

	function getNumW($num)
	{
		switch ($num)
		{
			case "1": return "one";
			case "2": return "two";
			case "3": return "three";
			case "4": return "four";
		}
	}

	function getValuta($id)
	{
		switch ($id)
		{
			case '1':
				return "&euro;";
				break;
			case '2':
				return "Ls";
				break;
		}
	}


	function getRegionType($tp)
	{
		switch ($tp)
		{
			case '1':
				return voc('gorod');
				break;
			case '2':
				return voc('rajon');
				break;
			case '3':
				return voc('posjolok');
				break;
			case '4':
				return voc('volosj');
				break;
		}
	}

	function getCatalogImages($id)
	{
		global $parser;
		if (count($parser['images'.$id])>0)
		{
			foreach ($parser['images'.$id] as $v)
			{
				echo "<a href=\"/loads/cataloggl/".$v['ID'].".".$v['EXT']."\" rel=\"cl$id\" style=\"display: none;\"></a>";
			}
		}
	}

	function getTextFields($field_name, $field_value, $field_width, $field_height, $toolbar_set="standard")
	{
		global $parser;
		$parser[$field_name] = new SpawEditor($field_name, $parser[$field_value]);
		$parser[$field_name]->setConfigItem('default_toolbarset', $toolbar_set, SPAW_CFG_TRANSFER_SECURE);
		$parser[$field_name]->setConfigItem('default_lang', 'ru', SPAW_CFG_TRANSFER_SECURE);
		$parser[$field_name]->setConfigItem('default_width', $field_width.'px', SPAW_CFG_TRANSFER_SECURE);
		$parser[$field_name]->setConfigItem('default_height', $field_height.'px', SPAW_CFG_TRANSFER_SECURE);
	}

	function saveImage($file, $table, $folder, $field, $id, $st="0", $left="0", $def="0", $in="0")
	{
		global $DB;
		if ($file['size']>0)
		{
			$arr = explode(".", $file['name']);
			$ext = strtolower($arr[count($arr)-1]);
			$sq = ($left!="0") ? " and `LEFT`='".$left."' " : "";
			$SQL = "SELECT * FROM `".$table."` WHERE `".$field."`='".$id."' and `ST`='".$st."' " . $sq;
			$row = $DB->getRowBySQL($SQL);
			if ((int)$row['ID']==0 || $in=="1")
			{
				$SQL = "INSERT INTO 
					`".$table."` 
					( 
						`".$field."` ,
						`EXT` ,
						`NAME` ,
						`TYPE` ,
						`SIZE` ,
						`DATE` ,
						`STATUS` ,
						`ST` ,
						`LEFT` ,
						`DEF`
					)
					values
					(
						'".$id."' ,
						'".mysql_real_escape_string($ext)."' ,
						'".mysql_real_escape_string($file['name'])."' ,
						'".mysql_real_escape_string($file['type'])."' ,
						'".mysql_real_escape_string($file['size'])."' ,
						'".date("Y-m-d H:i:s")."' ,
						'1' ,
						'".$st."' ,
						'".$left."' ,
						'".$def."'
					)
				";
			}
			else
			{
				$SQL = "UPDATE 
					`".$table."` 
					SET 
						`EXT` = '".mysql_real_escape_string($ext)."' ,
						`NAME` = '".mysql_real_escape_string($file['name'])."' ,
						`TYPE` = '".mysql_real_escape_string($file['type'])."' ,
						`SIZE` = '".mysql_real_escape_string($file['size'])."' ,
						`DATE` = '".date("Y-m-d H:i:s")."' ,
						`STATUS` = '1'
					WHERE `ID`='".$row['ID']."'
				";
				
			}
			if ($DB->Query($SQL))
			{
				$imid = ($row['ID']>0 && $in=="0") ? $row['ID'] : $DB->getInsertId();
				if (copy($file['tmp_name'], "loads/".$folder."/" . $imid . "." . $ext))
				{
					chmod("loads/".$folder."/" . $imid . "." . $ext, 0664);
				}
				return $imid;
			}
		}
	}

	function updateValueField($arr)
	{
		global $DB;
		$SQL = "SELECT `ID` FROM `".$arr['table']."` WHERE `".$arr['field']."`='".$arr['id']."' AND `LANGID`='".$arr['langid']."'";
		$rw = $DB->getRowBySQL($SQL);
		if ((int)$rw['ID']>0)
		{
			$SQL = "UPDATE `".$arr['table']."` SET `VALUE` = '".mysql_escape_string($_POST[$arr['prefix'].'_'.$arr['langid']])."' WHERE `".$arr['field']."`='".$arr['id']."' AND `LANGID`='".$arr['langid']."'";
		}
		else
		{
			$SQL = "
				INSERT INTO `".$arr['table']."`
				(
					`VALUE` , 
					`".$arr['field']."` ,
					`LANGID` 
				)
				values
				(
					'".mysql_escape_string($_POST[$arr['prefix'].'_'.$arr['langid']])."' ,
					'".$arr['id']."' ,
					'".$arr['langid']."' 
				)
			";
		}
		if ($DB->Query($SQL))
		{
			return true;
		}
	}

	function getLangLink($l)
	{
		global $DB;
		
		$sql = "select * from `tb_languages` where `URL`='".$l."'";
		$row = $DB->getRowBySQL($sql);
		$langid = $row['ID'];
		
		$rs = "/" . $l . "/";
		$arr = explode("/", $_SERVER['REQUEST_URI']);
		if (count($arr)>0)
		{
			foreach ($arr as $v)
			{
				if ($v!='' && strlen($v)>2)
				{					
					$sql = "select * from `tb_tree_data` where `URL`='".mysql_escape_string($v)."' and `LANGID`='".LANG."'";
					$rw = $DB->getRowBySQL($sql);
					if ((int)$rw['CID']>0)
					{
						$sql = "select * from `tb_tree_data` where `CID`='".$rw['CID']."' and `LANGID`='".$langid."'";
						$rw = $DB->getRowBySQL($sql);
						$rs .= $rw['URL'] . "/";
					}
					else
					{
						$sql = "select * from `tb_nominations_data` where `URL`='".mysql_escape_string($v)."' and `LANGID`='".LANG."'";
						$rw = $DB->getRowBySQL($sql);
						if ((int)$rw['CID']>0)
						{
							$sql = "select * from `tb_nominations_data` where `CID`='".$rw['CID']."' and `LANGID`='".$langid."'";
							$rw = $DB->getRowBySQL($sql);
							$rs .= $rw['URL'] . "/";
						}
						else
						{
							$sql = "select * from `tb_masterclasses_data` where `URL`='".mysql_escape_string($v)."' and `LANGID`='".LANG."'";
							$rw = $DB->getRowBySQL($sql);
							if ((int)$rw['CID']>0)
							{
								$sql = "select * from `tb_masterclasses_data` where `CID`='".$rw['CID']."' and `LANGID`='".$langid."'";
								$rw = $DB->getRowBySQL($sql);
								$rs .= $rw['URL'] . "/";
							}
							else
							{
								$rs .= $v . "/";																				
							}																				
						}																				
					}																	
				}
			}
		}
		//$rs = "/" . $rs;
		return $rs;
	}

	function getITP($ext)
	{
		$extarr = Array("jpeg"=>"1", "gif"=>"2", "jpg"=>"1");
		return $extarr[$ext];
	}

	function getLink()
	{
		$res = "";
		if (OBJ!="")
		{
			$res .= OBJ . "/";
		}

		if (TASK!="" && defined("TASK"))
		{
			$res .= TASK . "/";
		}

		if (ID!=""  && defined("ID"))
		{
			$res .= ID . "/";
		}
		return $res;
	}

	function updateLeftPos($l, $id, $top="0", $table="struktura", $cm="top", $SQ="", $field="LEFT")
	{
		global $parser, $DB;
		$SQL = "SELECT `ID` , `".$field."` FROM `".$table."` WHERE `".$cm."` = '$top' ".$SQ." ORDER by `".$field."`";
		$result = $DB->Query($SQL);
		$arr = Array("0");
		$i=0;
		if ($result)
		{
			while ($row=$DB->Fetch($result))
			{
				if ($row['ID']!=$id)
				{
					$i++;
					$arr[$i] = $row['ID'];
				}
				if ($row[$field]==$l)
				{
					$l_id = $row['ID'];
				}
			}
		}
		$a = array_flip($arr); $pos = ($a[$l_id])?($a[$l_id]):(0); array_splice($arr, $pos+1, 0, $id);
		return array_flip($arr);
	}

	function getImageType($type)
	{
		switch ($type)
		{
			case 'image/jpeg':
				return "1";
				break;
			case 'image/pjpeg':
				return "1";
				break;
			case 'image/gif':
				return "2";
				break;
			case 'image/png':
				return "3";
				break;
			case 'image/svg+xml':
				return "9";
				break;
		}
	}

	function getImageTypeByExt($type)
	{
		switch ($type)
		{
			case 'jpg':
				return "1";
				break;
			case 'gif':
				return "2";
				break;
			case 'png':
				return "3";
				break;
			case 'svg':
				return "9";
				break;
		}
	}

	function getBlocksLinks($id)
	{
		global $DB, $parser;
		$sql = "
			select 
				t.* ,
				tl.`NAME` ,
				tl.`URL` 
			from `".TABLE_TREE."` as t
			inner join `".TABLE_TREE_DATA."` as tl
			on `t`.`ID`=`tl`.`TID` and '".LANG."'=`tl`.`LANGID`
			where 
				t.STATUS = '1' 
				and t.SUB_ID='".$id."'
			order by
				t.LEFT
		";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res) )
			{
				if ($row['TYPE_ID']=='99')
				{
					echo '<a href="'.$row['URL'].'" target="_blank">'.$row['NAME'].'</a>';
				}
				else
				{
					echo '<a href="'.$row['URL'].'">'.$row['NAME'].'</a>';
				}
			}
		}
	}

	function getFirstSubMenu($id)
	{
		global $DB, $parser;
		$sql = "
			select 
				t.* ,
				tl.VALUE as `NAME` ,
				tu.VALUE as `URL`
			from `".TABLE_TREE."` as t
			inner join `".TABLE_TREE_LANGS."` as tl
			on t.ID=tl.TID and '".LANG."'=tl.LANGID
			inner join `".TABLE_TREE_URL."` as tu
			on t.ID=tu.TID and '".LANG."'=tu.LANGID
			inner join `".TABLE_TREE_URL."` as tu2
			on t.SUB_ID=tu2.TID and '".LANG."'=tu2.LANGID
			where 
				t.STATUS = '1' 
				and t.SUB_ID='".$id."'
			order by
				t.LEFT
		";
		$parser['smenu'] = $DB->getRowsBySQL($sql);
		if (count($parser['smenu'])>0)
		{
			return getTemplate("site_submenu");
		}
	}

	function cmp_asc($a, $b)
	{
		global $parser;
		if ($a == $b) {
			return 0;
		}
		return ($a[$parser['usortkey']] < $b[$parser['usortkey']]) ? -1 : 1;
	}

	function cmp_desc($a, $b, $key)
	{
		global $parser;
		if ($a == $b) {
			return 0;
		}
		return ($a[$parser['usortkey']] > $b[$parser['usortkey']]) ? -1 : 1;
	}

	function getMenu($parent, $type="")
	{
		global $parser, $DB;
		$sql = "
			select 
				t.* ,
				(SELECT `ID` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID LIMIT 1) as `IMID` ,
				(SELECT `EXT` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID LIMIT 1) as `IMEXT` ,
				tl.VALUE as `NAME` ,
				tu.VALUE as `URL`
			from `".TABLE_TREE."` as t
			inner join `".TABLE_TREE_LANGS."` as tl
			on t.ID=tl.TID and '".LANG."'=tl.LANGID
			inner join `".TABLE_TREE_URL."` as tu
			on t.ID=tu.TID and '".LANG."'=tu.LANGID
			where 
				t.STATUS = '1' 
				and t.SUB_ID='".$parent."'
			order by
				t.LEFT
		";
		$out = "";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				$out .= "<li>";
				if (getSP($row['ID']))
				{
					$out .= "<a href=\"javascript:void(0);\" class=\"menulink\">".$row['NAME']."</a>";
					$out .= getMenu($row['ID']);
				}
				else
				{
					$out .= "<a href=\"/".cLANG."/".$row['URL']."/\" class=\"menulink\">".$row['NAME']."</a>";
				}
				$out .= "</li>";
			}
		}

		if ($out!="")
		{
			return "<ul>" . $out . "</ul>";
		}
		
	}

	function getLeftMenu()
	{
		global $DB, $parser;
		

		$sql = "
			select 
				t.* ,
				(SELECT `ID` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID LIMIT 1) as `IMID` ,
				(SELECT `EXT` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID LIMIT 1) as `IMEXT` ,
				tl.VALUE as `NAME` ,
				tu.VALUE as `URL`
			from `".TABLE_TREE."` as t
			inner join `".TABLE_TREE_LANGS."` as tl
			on t.ID=tl.TID and '".LANG."'=tl.LANGID
			inner join `".TABLE_TREE_URL."` as tu
			on t.ID=tu.TID and '".LANG."'=tu.LANGID
			where 
				t.STATUS = '1' 
				and t.SUB_ID='".$parser['topmenuid']."'
			order by
				t.LEFT
		";
		$parser['lmenu'] = $DB->getRowsBySQL($sql);
		
		return getTemplate('site_left_menu');
	}

	function getLSMenu($id)
	{
		global $DB, $parser;

		$sql = "
			select 
				t.* ,
				(SELECT `ID` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID LIMIT 1) as `IMID` ,
				(SELECT `EXT` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID LIMIT 1) as `IMEXT` ,
				tl.VALUE as `NAME` ,
				tu.VALUE as `URL`
			from `".TABLE_TREE."` as t
			inner join `".TABLE_TREE_LANGS."` as tl
			on t.ID=tl.TID and '".LANG."'=tl.LANGID
			inner join `".TABLE_TREE_URL."` as tu
			on t.ID=tu.TID and '".LANG."'=tu.LANGID
			where 
				t.STATUS = '1' 
				and t.SUB_ID='".$id."'
			order by
				t.LEFT
		";
		$out = "";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				
				$sql = "
					select 
						t.* ,
						(SELECT `ID` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID LIMIT 1) as `IMID` ,
						(SELECT `EXT` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID LIMIT 1) as `IMEXT` ,
						tl.VALUE as `NAME` ,
						tu.VALUE as `URL`
					from `".TABLE_TREE."` as t
					inner join `".TABLE_TREE_LANGS."` as tl
					on t.ID=tl.TID and '".LANG."'=tl.LANGID
					inner join `".TABLE_TREE_URL."` as tu
					on t.ID=tu.TID and '".LANG."'=tu.LANGID
					where 
						t.STATUS = '1' 
						and t.SUB_ID='".$row['ID']."'
					order by
						t.LEFT
				";
				$rows = $DB->getRowsBySQL($sql);
				if ($rows['0']['ID']!="")
				{
					$sl = (U_ID==$row['ID']) ? " class=\"selected\" " : "";
					$out .= "<li>";
					$out .= "<a href=\"javascript:void(0);\" ".$sl.">".$row['NAME']."</a>";
					foreach ($rows as $s)
					{
						$sl = (U_ID==$s['ID']) ? " class=\"selected\" " : "";
						$out .= "<a href=\"/".cLANG."/".$s['URL']."/\" ".$sl."> &nbsp; &nbsp; - ".$s['NAME']."</a>";;
					}
					$out .= "</li>";
				}
				else
				{
					$sl = (U_ID==$row['ID']) ? " class=\"selected\" " : "";
					$out .= "<li>";
					$out .= "<a href=\"/".cLANG."/".$row['URL']."/\" ".$sl.">".$row['NAME']."</a>";
					$out .= "</li>";
				}
			}
		}

		if ($out!="")
		{
			echo "<ul class=\"categoryitems\">" . $out . "</ul>";
		}
	}

	function getAllByMenu($id)
	{
		global $DB;
		$dd = ($id == 0) ? U_ID : $id;
		$sql = "
					select 
						t.* ,
						(SELECT `ID` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID LIMIT 1) as `IMID` ,
						(SELECT `EXT` FROM `".TABLE_TREE_IMAGES."` where `TID`=t.ID LIMIT 1) as `IMEXT` ,
						tl.VALUE as `NAME` ,
						tu.VALUE as `URL`
					from `".TABLE_TREE."` as t
					inner join `".TABLE_TREE_LANGS."` as tl
					on t.ID=tl.TID and '".LANG."'=tl.LANGID
					inner join `".TABLE_TREE_URL."` as tu
					on t.ID=tu.TID and '".LANG."'=tu.LANGID
					where 
						t.STATUS = '1' 
						and t.ID='".$dd."'


				";

		$row = $DB->getRowBySQL($sql);

		return $row;
	}

	function getTopMenu($id)
	{
		global $DB;
		$sql = "select * from `tb_tree` where `ID`='".$id."'";
		$rw = $DB->getRowBySQL($sql);

		if ($rw['SUB_ID']>0)
		{
			$sql = "select * from `tb_tree` where `ID`='".$rw['SUB_ID']."'";
			$rw2 = $DB->getRowBySQL($sql);
			if ($rw2['SUB_ID']>0)
			{
				return getTopMenu($rw2['ID']);
			}
			else
			{
				return $rw2['ID'];
			}
		}
		else
		{
			return 0;
		}
	}

	function getSP($id)
	{
		global $DB;
		$sql = "select * from `tb_tree` where `SUB_ID`='".$id."' and `STATUS`='1'";
		$rw = $DB->getRowsBySQL($sql);
		if ($rw['0']['ID']>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function getMenuTree($parent, $nm=0, &$num="0")
	{
		global $DB, $parser;
		$result = Array();
		$sql = "
			select 
				t.* ,
				tu2.VALUE as `URL2` ,
				tu.VALUE as `URL` ,
				tl.VALUE as `NAME`
			from `".TABLE_TREE."` as t
			inner join `".TABLE_TREE_LANGS."` as tl
			ON t.ID=tl.TID and '".LANG."'=tl.LANGID
			inner join `".TABLE_TREE_URL."` as tu
			ON t.ID=tu.TID and '".LANG."'=tu.LANGID
			left join `".TABLE_TREE_URL."` as tu2
			ON t.SUB_ID=tu2.TID and '".LANG."'=tu2.LANGID
			where t.SUB_ID='".$parent."'
			order by t.LEFT
		";
		if ($res = $DB->Query($sql))
		{
			while ($row = $DB->Fetch($res))
			{
				$num++;
				$row['nm'] = $nm;
				$row['num'] = $num;
				$sep = "";
				for ($i=1; $i<=$nm*5; $i++)
				{
					$sep .= "&nbsp;";
				}
				$row['sep'] = $sep;
				if ($row['URL2']!="")
				{
					$row['LINK'] = $row['URL2'] . "/" . $row['URL'] . "./";
				}
				else
				{
					$row['LINK'] = $row['URL'] . "./";
				}
				$result[] = $row;
				$arr2 = getMenuTree($row['ID'], $nm+1, $num);
				$result = array_merge($result, $arr2);
			}
		}
		return $result;
	}

	function getNSize($w, $h, $mx, $my)
	{

		$maxw = $mx;
		$maxh = $my;

		if($maxw or $maxh)
		{
			$sam1=$w/$maxw;
			$sam2=$h/$maxh;
			$sam=max($sam1,$sam2);
			if($sam <1 ) $sam=1;
		}
		elseif($w)
		{
			$sam=$w($img)/$w;
		}
		elseif($h)
		{
			$sam=$h($img)/$h;
		} else
		{
			$sam=1;
		}

		$w=$w/$sam;
		$h=$h/$sam;
		return array($w, $h);
	}

	function getStr($str, $part1, $part2, $inc1, $inc2, $start = 0) {
		$ra = array();
		while ($start < strlen($str)) {
			$pos1 = strpos($str, $part1, $start);
			if ($pos1 === false) {
				$start = strlen($str);
			} else {	
				$sss = $pos1 + strlen($part1);
				$pos2 = strpos($str, $part2, $sss);
				$len = $pos2-$pos1;
				if ($inc1) {
					$spos = $pos1;
				} else {
					$spos = $pos1 + strlen($part1);
					$len -= strlen($part1);
				}
				if ($inc2) {
					$len += strlen($part2);
				}
				array_push($ra, substr($str, $spos, $len));
				$start = ($pos2 > $start)?($pos2):(strlen($str));
			}
		}	
		return $ra;
	}



?>