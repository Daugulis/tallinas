<style>
<?php if ($parser['pdf']['ID']!='') {?> 	
.fl-p-menu a { width: 25%;  }
 <?php } ?> 
</style>

<div class="flat-page">
	<div class="fl-p-menu">
		<a href="/<?php echo (cLANG); ?>/<?php echo (OBJ); ?>/"><div class="t"><div class="v"><img src="/img/back-arrow.png" alt=""/><?php echo (voc('План этажа')); ?></div></div></a>
		<a href="javascript:showPlan();" class="color selected"><div class="t"><div class="v"><?php echo (voc('Планировка')); ?></div></div></a>
		<a href="javascript:showText();"><div class="t"><div class="v"><?php echo (voc('Качество')); ?></div></div></a>
		<?php if ($parser['pdf']['ID']!='') {?> 	
		<a href="/<?php echo (cLANG); ?>/<?php echo (OBJ); ?>/<?php echo (TASK); ?>/getpdf/"><div class="t"><div class="v"><?php echo (voc('План квартиры')); ?></div></div></a>
		 <?php } ?> 
	</div>
	<div class="a-p-container" id="splan">
	<div class="fl-p-info">
		<div class="f-p-i-block">
			<div class="f-p-i-b-left"><?php echo (voc('Адрес:')); ?></div> 
			<div class="f-p-i-b-right"><?php echo (voc('Tallinas 86')); ?></div>
		</div>
		<div class="f-p-i-block">
			<div class="f-p-i-b-left"><?php echo (voc('Этаж:')); ?></div> 
			<div class="f-p-i-b-right"><?php echo ($parser['room']['FLOOR']); ?></div>
		</div>
		<div class="f-p-i-block">
			<div class="f-p-i-b-left"><?php echo (voc('№ квартиры:')); ?></div> 
			<div class="f-p-i-b-right"><?php echo ($parser['room']['NUMBER']); ?></div>
		</div>
		<div class="f-p-i-block">
			<div class="f-p-i-b-left"><?php echo (voc('Площадь:')); ?></div> 
			<div class="f-p-i-b-right"><?php echo ($parser['room']['AREA']); ?> m2</div>
		</div>
		<?php if ($parser['room']['STATUS']!='0') {?> 	
		<div class="f-p-i-block">
			<div class="f-p-i-b-left"><?php echo (voc('Цена:')); ?></div> 
			<div class="f-p-i-b-right"><?php echo ($parser['room']['PRICE']); ?> &euro;</div>
		</div>
		 <?php } ?> 
		<?php if ($parser['room']['STATUS']=='0') {?> 	
		<div class="f-p-i-block">
			<div class="f-p-i-b-left"><?php echo (voc('Статус:')); ?></div> 
			<div class="f-p-i-b-right">
			<?php if ($parser['room']['STATUS']=='1') {?> 	<?php echo (voc('Свободна')); ?> <?php } ?> 
			<?php if ($parser['room']['STATUS']=='0') {?> 	<?php echo (voc('Продана')); ?> <?php } ?> 
			<?php if ($parser['room']['STATUS']=='2') {?> 	<?php echo (voc('Резервация')); ?> <?php } ?> 
			</div>
		</div>
		 <?php } ?> 
	</div>
	<div class="flat-plan" style="opacity: 0;">
		<div class="t">
			<div class="v">
				<div id="planid">
				<div class="pls color">123m</div><div class="plsl color"></div><div class="plsh color"><h2>N12, 2-комнатная</h2><div class="plsd"><span>Площадь:</span> 123 &nbsp; &nbsp; &nbsp;<span>Статус:</span> свободна</div></div>
					<img id="plani" src="/img/<?php echo $parser["img"]; ?>.png" data-w="<?php echo ($parser['imm']['0']); ?>" data-h="<?php echo ($parser['imm']['1']); ?>" border="0" usemap="#planim" alt="" />
					<map name="planim" id="planim">
						<?php foreach($parser["areas"] as $_key_1=>$_var_1)
{
 ?>
						<area  data-mapid="<?php echo $parser["areas"][$_key_1]["NUM"]; ?>" data-num="<?php echo $parser["areas"][$_key_1]["NUM"]; ?>" id="fs<?php echo $parser["areas"][$_key_1]["NUM"]; ?>" data-maphilight="" alt="" title="" href="" shape="poly" data-t="24" data-x="550" data-y="260" coords="<?php echo $parser["areas"][$_key_1]["CORDS"]; ?>" style="outline:none;" target="_self"     />
						<?php 
}
 ?>
					</map>
				</div>
			</div>
		</div>
	</div>
	</div>
	<?php foreach($parser["stree"] as $_key_2=>$_var_2)
{
 ?>
	<div class="a-p-container apall" id="stxt" style="display: none;">
		<?php echo (getTextBlocksSite(''.$parser["stree"][$_key_2]["ID"].'', 'tree')); ?>
		<?php if (count($parser['cblocks'])>0) {?> 	
			<?php foreach($parser["cblocks"] as $_key_3=>$_var_3)
{
 ?>
				<?php if (''.$parser["cblocks"][$_key_3]["TYPE"].''=='1') {?> 	
				<?php echo (getTextBlockSite('tree', ''.$parser["cblocks"][$_key_3]["ID"].'')); ?>
				<?php if ($parser['cblock']['NAME']!='') {?> 	
				<b><?php echo ($parser['cblock']['NAME']); ?></b>
				 <?php } ?> 
				<?php if ($parser['cblock']['TEXT']!='') {?> 	
				<?php echo ($parser['cblock']['TEXT']); ?>
				 <?php } ?> 
				 <?php } ?> 
				<?php if (''.$parser["cblocks"][$_key_3]["TYPE"].''=='2') {?> 	
				<?php echo (getImagesBlockSite('tree', ''.$parser["cblocks"][$_key_3]["ID"].'')); ?>
				<?php if (count($parser['bimages'])>1) {?> 	
				<div class="a-p-gallery">
					<?php foreach($parser["bimages"] as $_key_4=>$_var_4)
{
 ?>
                    <a href="javascript:openGallery('<?php echo $parser["cblocks"][$_key_3]["ID"]; ?>', '<?php echo $parser["bimages"][$_key_4]["ID"]; ?>')" style="background:url(<?php echo (getImageSrc('1'.getImageTypeByExt(''.$parser["bimages"][$_key_4]["EXT"].'').'5'.$parser["bimages"][$_key_4]["ID"].'', getImageTypeByExt(''.$parser["bimages"][$_key_4]["EXT"].''))); ?>);"></a>
					<?php 
}
 ?>
                </div>
				 <?php } ?> 
				<?php if (count($parser['bimages'])==1) {?> 	
				<?php foreach($parser["bimages"] as $_key_5=>$_var_5)
{
 ?>
				<p class="signature"><img src="/loads/tree/<?php echo $parser["bimages"][$_key_5]["ID"]; ?>.<?php echo $parser["bimages"][$_key_5]["EXT"]; ?>" alt="" /></p>
				<?php 
}
 ?>
				 <?php } ?> 
				 <?php } ?> 
			<?php 
}
 ?>
		 <?php } ?> 
		<?php if (''.$parser["stree"][$_key_2]["TYPE"].''=='5') {?> 	
		<div id="smap" style="height: 100%; width: 100%;"></div>
		 <?php } ?> 
	</div>
	<?php 
}
 ?>
</div>
<div class="r-s-img-container">
    <div class="banks"><div class="t"><div class="v">
        <a href="https://www.swedbank.lv" target="_blank"><img src="/img/Swedbank-logo.gif" alt="" /></a>
        <a href="http://www.seb.lv" target="_blank"><img src="/img/seb-logo.gif" alt="" /></a>
        <a href="https://www.citadele.lv" target="_blank"><img src="/img/citadele-logo.jpg" alt="" /></a>
        <a href="https://www.dnb.lv" target="_blank"><img src="/img/dnb-logo.png" alt="" /></a>
    </div></div></div>
	<div class="r-s-img" style="background:url(/loads/main/<?php echo ($parser['mainbg']['IMID']); ?>.<?php echo ($parser['mainbg']['IMEXT']); ?>);"></div>
</div>

<script>
function showPlan()
{
	$('.fl-p-menu a').removeClass('color');
	$('.fl-p-menu a').removeClass('selected');
	$('.fl-p-menu a').eq(1).addClass('color');
	$('.fl-p-menu a').eq(1).addClass('selected');

	$('#stxt').hide();
	$('#splan').fadeIn();
}
function showText()
{
	$('.fl-p-menu a').removeClass('color');
	$('.fl-p-menu a').removeClass('selected');
	$('.fl-p-menu a').eq(2).addClass('color');
	$('.fl-p-menu a').eq(2).addClass('selected');

	$('#splan').hide();
	$('#stxt').fadeIn();
}
</script>

<script>

var floor = '2';
var chrome = false;

var ov = '<div class="pls color">123m</div><div class="plsl color"></div><div class="plsh color"><h2>N12, 2-комнатная</h2><div class="plsd"><span>Площадь:</span> 123 &nbsp; &nbsp; &nbsp;<span>Статус:</span> свободна</div></div>';

var rooms = [];
<?php foreach($parser["areas"] as $_key_6=>$_var_6)
{
 ?>
rooms[<?php echo $parser["areas"][$_key_6]["NUM"]; ?>] = { area: '<?php echo $parser["areas"][$_key_6]["AREA"]; ?>', floor: '111', status: '1', name: '<?php echo $parser["areas"][$_key_6]["TNAME"]; ?>', number: '333', count: '12' };
<?php 
}
 ?>

function setCImageSize()
{
	$('img[usemap]').mapTrifecta();	

	$('area').mouseover(function() {
		$('area').attr('data-curr', '0');
		$(this).attr('data-curr', '1');
		var cr = $(this);
		$(this).trigger('curr.maphilight');
		$('area').attr('data-pls', '0');
		$(this).attr('data-pls', '1');
		var plw = $('.pls').width();
		var plh = $('.pls').height();
		var ax = $(this).attr('data-x');
		var ay = $(this).attr('data-y');
		var at = $(this).attr('data-t');
		var pw = $('#plani').width();
		var ph = $('#plani').height();
		var ow = $('#plani').attr('data-w');
		var oh = $('#plani').attr('data-h');
		var kw = pw/ow;
		var kh = ph/oh;
		var ox = ( ax * kw ) - ( plw / 2 );
		var oy = ( ay * kh ) - ( plh / 2 ) - 8;
		console.log(oy);
		//$('.pls').css('margin-left', ox+'px');
		//$('.pls').css('margin-top', oy+'px');
		var oxx = ox + 30;
		var oyy = oy - 90;
		var oxh = ox - 50;
		var oyh = oy - 130;
		console.log('---'+ox + ' ' + pw);
		if (ox>pw/2)
		{
			oxh = oxh - 80;
			$('.plsl').addClass('plsl2');
		}
		else
		{
			$('.plsl').removeClass('plsl2');
		}
		console.log($('.plsl').position());
		//$('.plsl').css('margin-left', oxx+'px');
		var scx = $('#plani').attr('center-x')-100;
		var scy = $('#plani').attr('center-y') - 140;
		console.log(scx+' '+scy);
		$('.plsh').css('margin-left', scx+'px');
		$('.plsh').css('margin-top', scy+'px');

		var nm = parseInt($(this).attr('data-num'));
		nm = ( parseInt(floor) - 1 ) * nm;
		$('.pls').html(rooms[nm].area+'m');
		$('.plsh h2').html(rooms[nm].name);
		$('.plsd').html('<span><?php echo (voc('Площадь:')); ?></span> '+rooms[nm].area+' &nbsp; &nbsp; &nbsp;<span>');
		$('.plsl').fadeIn('fast');
		$('.plsh').fadeIn('fast');
	});

	$('area').mouseleave(function(e) {
		if ($('.pls').is(':hover'))
		{
			if ($(this).attr('data-pls')=='1')
			{
				$(this).data('maphilight', {'alwaysOn': true, 'fillColor': '0a83e0'}).trigger('alwaysOn.maphilight');
			}
			else
			{
				$('.pls').hide();
				$('.plsl').hide();
				$('.plsh').hide();
				if ($(this).attr('data-st')=='0')
				{ 
					$(this).data('maphilight', {'alwaysOn': true, 'fillColor': '6b6b6b'}).trigger('alwaysOn.maphilight');
				}
				else
				{
					if ($(this).attr('data-st')=='2')
					{ 
						$(this).data('maphilight', {'alwaysOn': true, 'fillColor': 'ff9900'}).trigger('alwaysOn.maphilight');
					}
					else
					{
						$(this).data('maphilight', {'alwaysOn': false, 'fillColor': '0a83e0'}).trigger('alwaysOn.maphilight');
					}
				}
			}
		}
		else
		{
			$('.pls').hide();
			$('.plsl').hide();
			$('.plsh').hide();
			$(this).attr('data-pls', '0');
			if ($(this).attr('data-st')=='0')
			{ 
				$(this).data('maphilight', {'alwaysOn': true, 'fillColor': '6b6b6b'}).trigger('alwaysOn.maphilight');
			}
			else
			{
				if ($(this).attr('data-st')=='2')
				{ 
					$(this).data('maphilight', {'alwaysOn': true, 'fillColor': 'ff9900'}).trigger('alwaysOn.maphilight');
				}
			}
		}
	});
}

var phh = $('.floor-plan').height();
var pww = $('.floor-plan').width();

function setFloor(nm)
{
	var ww = parseInt($('#plani').attr('data-w'));
	var hh = parseInt($('#plani').attr('data-h'));
	if (hh>ww)
	{
		var phhd = (phh/hh)*100;
		var fpp = ( ww / 100 ) * phhd;
		if (fpp<pww)
		{
			var phhdl = (pww - fpp) / 2;
		}
		else
		{
			var phhdl = 0;
		}
		var pw = 0;
		var pdelta = parseInt((ww/hh)*100);
		if ($(window).width() < 700)
		{
			//alert(pww);
			//return;
			fpp = pww - 50;
			if (fpp<pww)
			{
				var phhdl = (pww - fpp) / 2;
			}
			else
			{
				var phhdl = 0;
			}
		}
		$('#planid').css('width', fpp+'px');
		$('#planid').css('margin-left', phhdl+'px');
	}
	else
	{
		var phhd = (pww/ww)*100;
		var fpp = ( ww / 100 ) * phhd;
		if (fpp<pww)
		{
			var phhdl = (pww - fpp) / 2;
		}
		else
		{
			var phhdl = 0;
		}
		var pw = 0;
		var pdelta = parseInt((ww/hh)*100);
		if ($(window).width() < 700)
		{
			//alert(pww);
			//return;
			fpp = pww - 50;
			if (fpp<pww)
			{
				var phhdl = (pww - fpp) / 2;
			}
			else
			{
				var phhdl = 0;
			}
		}
		$('#planid').css('width', fpp+'px');
		$('#planid').css('margin-left', phhdl+'px');
	}
	$('.flat-plan').css('opacity', '1');
	setCImageSize();	
}

function showlevel(nm)
{
	//
}

function hidelevel(nm)
{
	//
}

$(document).ready(function() {
	phh = $('.floor-plan').height();
	pww = $('.floor-plan').width();
	setFloor(floor);
});
$(document).on('mousemove', function(e) {
	//
});

function getAreaCenter(shape, coords) {
	var coordsArray = coords,
		center = [];
	if (shape == 'circle') {
		// For circle areas the center is given by the first two values
		center = [coordsArray[0], coordsArray[1]];
	} else {
		// For rect and poly areas we need to loop through the coordinates
		var coord,
			minX = maxX = parseInt(coordsArray[0], 10),
			minY = maxY = parseInt(coordsArray[1], 10);
		for (var i = 0, l = coordsArray.length; i < l; i++) {
			coord = parseInt(coordsArray[i], 10);
			if (i%2 == 0) { // Even values are X coordinates
				if (coord < minX) {
					minX = coord;
				} else if (coord > maxX) {
					maxX = coord;
				}
			} else { // Odd values are Y coordinates
				if (coord < minY) {
					minY = coord;
				} else if (coord > maxY) {
					maxY = coord;
				}
			}
		}
		center = [parseInt((minX + maxX) / 2, 10), parseInt((minY + maxY) / 2, 10)];
	}
	return(center);
}

</script>