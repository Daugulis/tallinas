<style>
.m-p-img2 { 
	position:absolute; 
	left:0px; 
	top:0px; 
	width:100%; 
	height:100%; 
	overflow: hidden; 
}
.m-p-img2 img.sd {
	position: absolute;
	opacity: 0;
}
.f-p-menu a {
	cursor: pointer;
}
.f-circle {
	position: absolute;
	width: 20px;
	height: 20px;
	border-radius: 10px;
}
.pls {
	position: absolute;
	text-align: center;
	padding: 8px 0px;
	background: blue;
	border: solid 1px #ffffff;
	font-size: 12px;
	color: #ffffff;
	width: 60px;
	z-index: 999999;
	display: none;
	cursor: pointer;
}
.plsh {
	z-index: 99999;
	position: absolute;
	font-size: 12px;
	text-align: left;
	padding: 15px;
	margin-top: -90px;
	margin-left: 50px;
	display: none;
}
.plsh h2 {
	font-size: 16px;
	margin: 0px 0px 10px;
	padding: 0px;
	font-weight: normal;
}
.plsh span {
	color: #eeeeee;
}
.plsl {
	position: absolute;
	width: 2px;
	z-index: 99998;
	height: 100px;
	margin-left: 150px;
	margin-top: -50px;
	-ms-transform: rotate(20deg); /* IE 9 */
    -webkit-transform: rotate(20deg); /* Chrome, Safari, Opera */
    transform: rotate(20deg);
	display: none;
}
.plsl2 {
	position: absolute;
	width: 2px;
	z-index: 99998;
	height: 100px;
	margin-left: -50px;
	margin-top: -50px;
	-ms-transform: rotate(-20deg); /* IE 9 */
    -webkit-transform: rotate(-20deg); /* Chrome, Safari, Opera */
    transform: rotate(-20deg);
	display: none;
}
</style>

<div class="f-circle"></div>

<div class="floor-page">
	<div class="f-p-menu">
		<a href="javascript:setFloor('2');" class="fp2 <?php if (OBJ=='2') {?> 	color selected <?php } ?> " onmouseover="showlevel('2')" onmouseout="hidelevel('2')" data-level="2"><div class="t"><div class="v"><?php echo (voc('2 этаж')); ?></div></div></a>
		<a href="javascript:setFloor('3');" class="fp3 <?php if (OBJ=='3') {?> 	color selected <?php } ?> " onmouseover="showlevel('3')" onmouseout="hidelevel('3')" data-level="3"><div class="t"><div class="v"><?php echo (voc('3 этаж')); ?></div></div></a>
		<a href="javascript:setFloor('4');" class="fp4 <?php if (OBJ=='4') {?> 	color selected <?php } ?> " onmouseover="showlevel('4')" onmouseout="hidelevel('4')" data-level="4"><div class="t"><div class="v"><?php echo (voc('4 этаж')); ?></div></div></a>
		<a href="javascript:setFloor('5');" class="fp5 <?php if (OBJ=='5') {?> 	color selected <?php } ?> " onmouseover="showlevel('5')" onmouseout="hidelevel('5')" data-level="5"><div class="t"><div class="v"><?php echo (voc('5 этаж')); ?></div></div></a>
	</div>
	<div class="floor-plan" style="width: 85%;">
		<div class="t">
			<div class="v">
                <div class="compass"><img src="/img/compass.png" alt="" /></div>
				<div id="planid">
				</div>
			</div>
		</div>
	</div>

	

</div>
<div class="f-p-m-img">
    <div class="banks"><div class="t"><div class="v">
        <a href="https://www.swedbank.lv" target="_blank"><img src="/img/Swedbank-logo.gif" alt="" /></a>
        <a href="http://www.seb.lv" target="_blank"><img src="/img/seb-logo.gif" alt="" /></a>
        <a href="https://www.citadele.lv" target="_blank"><img src="/img/citadele-logo.jpg" alt="" /></a>
        <a href="https://www.dnb.lv" target="_blank"><img src="/img/dnb-logo.png" alt="" /></a>
    </div></div></div>
	<div class="m-p-img" id="m-p-img" style="z-index: 997; background:url(/loads/main/<?php echo ($parser['mainbg']['IMID']); ?>.<?php echo ($parser['mainbg']['IMEXT']); ?>) center; background-size:cover; background-repeat:no-repeat;"></div>
	<div class="m-p-img2" style="z-index: 998;"></div>
</div>

<script>

var floor = '<?php echo (OBJ); ?>';
var chrome = false;

var ov = '<div class="pls color">123m</div><div class="plsl color"></div><div class="plsh color"><h2>N12, 2-комнатная</h2><div class="plsd"><span>Площадь:</span> 123 &nbsp; &nbsp; &nbsp;<span>Статус:</span> свободна</div></div>';

var mp = '<map name="planm" id="planm"><area  data-mapid="12" data-num="12" id="fs12" data-maphilight="" alt="" title="" href="" shape="poly" data-t="24" data-x="550" data-y="260" coords="53,46,1045,46,1045,491,53,491" style="outline:none;" target="_self"     /><area  data-mapid="11" data-num="11" id="fs11" alt="" title="" href="" shape="poly" data-t="24"  data-x="1960" data-y="260" coords="1747,42,2168,42,2168,530,1747,530" style="outline:none;" target="_self"     /><area  data-mapid="10" data-num="10" id="fs10" alt="" title="" href="" shape="poly" data-t="24" data-x="1960" data-y="800" coords="1602,532,1709,533,1709,626,1746,626,1745,542,2170,542,2169,787,2197,787,2197,1099,1747,1099,1746,686,1708,686,1709,729,1603,729" style="outline:none;" target="_self"     /><area  data-mapid="9" data-num="9" id="fs9" alt="" title="" href="" shape="poly" data-t="24" data-x="1500" data-y="596" coords="1593,282,1283,283,1284,995,1705,995,1705,740,1592,740" style="outline:none;" target="_self"     /><area  data-mapid="8" data-num="8" id="fs8" alt="" title="" href="" shape="poly" data-t="24" data-x="1490" data-y="1240" coords="1283,1007,1705,1006,1704,1525,1629,1526,1629,1505,1284,1505" style="outline:none;" target="_self"     /><area  data-mapid="7" data-num="7" id="fs7" alt="" title="" href="" shape="poly" data-t="24" data-x="1970" data-y="1380" coords="1734,1587,1747,1587,1746,1110,2197,1111,2196,1570,2181,1570,2180,1667,1766,1668,1766,1663,1735,1663" style="outline:none;" data-maphilight="" target="_self"     /><area  data-mapid="6" data-num="6" id="fs6" alt="" title="" href="" shape="poly" data-t="24" data-x="1872" data-y="2060" coords="1634,1752,1634,1774,1580,1775,1580,2117,1725,2117,1725,1907,1766,1907,1767,2575,2181,2575,2181,1680,1765,1679,1766,1827,1724,1827,1725,1774,1716,1774,1717,1753" style="outline:none;" target="_self"     /><area  data-mapid="5" data-num="5" id="fs5" alt="" title="" href="" shape="poly" data-t="24" data-x="1350" data-y="2100" coords="1061,2038,1085,2038,1084,1853,1253,1853,1264,1853,1343,1774,1569,1775,1569,2117,1465,2117,1465,2157,1485,2157,1485,2162,1553,2162,1553,2157,1725,2157,1725,2575,1231,2575,1231,2157,1390,2157,1390,2116,1061,2117" style="outline:none;" target="_self"     /><area  data-mapid="4" data-num="4" id="fs4" alt="" title="" href="" shape="poly" data-t="24" data-x="1000" data-y="2380" coords="898,2137,898,2157,787,2157,787,2593,1206,2592,1206,2575,1220,2575,1220,2156,978,2157,978,2137" style="outline:none;" target="_self"     /><area  data-mapid="3" id="fs3" data-num="3" alt="" title="" href="" shape="poly" data-t="24" data-x="540" data-y="2380" coords="770,2143,770,2157,776,2157,775,2592,579,2593,579,2574,301,2575,301,2157,698,2157,698,2142" style="outline:none;" target="_self"     /><area  data-mapid="2" data-num="2" id="fs2" alt="" title="" href="" shape="poly" data-t="24" data-x="340" data-y="2080" coords="43,1690,290,1689,290,1951,534,1951,534,2116,162,2117,162,2157,290,2157,289,2574,42,2574,43,2157,89,2156,89,2136,89,2116,43,2117" style="outline:none;" target="_self"     /><area  data-mapid="1" id="fs1" data-num="1" alt="" title="" href="" shape="poly" data-x="565" data-y="1820" coords="599,2003,599,1991,544,1991,544,1940,301,1940,301,1689,831,1689,832,1991,674,1991,674,2002" style="outline:none;" target="_self"     /></map>';

var rooms = [];
<?php foreach($parser["rooms"] as $_key_1=>$_var_1)
{
 ?>
rooms[<?php echo $parser["rooms"][$_key_1]["NUMBER"]; ?>] = { area: '<?php echo $parser["rooms"][$_key_1]["AREA"]; ?>', floor: '<?php echo $parser["rooms"][$_key_1]["FLOOR"]; ?>', price: '<?php echo $parser["rooms"][$_key_1]["PRICE"]; ?>', status: '<?php echo $parser["rooms"][$_key_1]["STATUS"]; ?>', number: '<?php echo $parser["rooms"][$_key_1]["NUMBER"]; ?>', count: '<?php echo $parser["rooms"][$_key_1]["ROOMS"]; ?>' };
<?php 
}
 ?>

function setCImageSize()
{
	$('img[usemap]').mapTrifecta();	
	
	setTimeout(function() {
		for (var i in rooms)
		{
			if (rooms[i].status=='0' && floor==rooms[i].floor)
			{ 
				var idd = parseInt(rooms[i].number) - ( ( parseInt(rooms[i].floor) - 2 ) * 12 );
				$('#fs'+idd).attr('data-st', '0');
				$('#fs'+idd).data('maphilight', {'alwaysOn': true, 'fillColor': '6b6b6b'}).trigger('alwaysOn.maphilight');
			}
			if (rooms[i].status=='2' && floor==rooms[i].floor)
			{ 
				var idd = parseInt(rooms[i].number) - ( ( parseInt(rooms[i].floor) - 2 ) * 12 );
				$('#fs'+idd).attr('data-st', '2');
				$('#fs'+idd).data('maphilight', {'alwaysOn': true, 'fillColor': 'ff9900'}).trigger('alwaysOn.maphilight');
			}
		}
	}, 100);

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
		$('.pls').css('margin-left', ox+'px');
		$('.pls').css('margin-top', oy+'px');
		var oxx = ox + 30;
		var oyy = oy - 90;
		var oxh = ox - 50;
		var oyh = oy - 130;
		if (ox>pw/2)
		{
			oxh = oxh - 80;
			$('.plsl').addClass('plsl2');
		}
		else
		{
			$('.plsl').removeClass('plsl2');
		}
		$('.plsl').css('margin-left', oxx+'px');
		$('.plsh').css('margin-left', oxh+'px');
		$('.plsh').css('margin-top', oyh+'px');

		var nm = parseInt($(this).attr('data-num'));
		nm = ( ( parseInt(floor) - 2 ) * 12 ) + nm;
		console.log(floor);
		console.log(nm);
		console.log(rooms[nm]);
		$('.pls').html(rooms[nm].area+'m');
		$('.plsh h2').html('<?php echo (voc('Nr.')); ?>' + rooms[nm].number + ' &nbsp; &nbsp; ' + rooms[nm].count + '-<?php echo (voc('комнатная')); ?>');
		var st = '<?php echo (voc('свободная')); ?>';
		if (rooms[nm].status=='2')
		{
			st = '<?php echo (voc('резервация')); ?>';
		}
		if (rooms[nm].status=='0')
		{
			st = '<?php echo (voc('продана')); ?>';
		}
		if (rooms[nm].status!='0')
		{
			$('.plsd').html('<span><?php echo (voc('Площадь:')); ?></span> '+rooms[nm].area+' &nbsp; &nbsp; &nbsp;<span><?php echo (voc('Цена:')); ?></span> ' + rooms[nm].price + ' &euro;');
		}
		else
		{
			$('.plsd').html('<span><?php echo (voc('Площадь:')); ?></span> '+rooms[nm].area+' &nbsp; &nbsp; &nbsp;<span><?php echo (voc('Статус:')); ?></span> ' + st);
		}
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
	$('#planid').css('opacity', '0');
	$('.maphilighted').remove();
	$('#planid img').remove();
	$('#planid').html('');
	$('#planid').append(ov);
	$('#planid').append(mp);
	$('area').removeAttr('href');
	$('#planid').append('<img style="width: 100%" id="plani" data-w="2245" data-h="2641" src="" alt="" usemap="#planm" />');
	if (nm=='5')
	{
		$('#plani').attr('src', '/img/plan-2.png');
	}
	else
	{
		$('#plani').attr('src', '/img/plan-1.png');
	}
	$('.fp'+floor).removeClass('color');
	$('.fp'+floor).removeClass('selected');
	floor = nm;
	$('.fp'+floor).addClass('color');
	$('.fp'+floor).addClass('selected');
	$('#planid area').each(function() {
		var nm = ( ( floor - 2 ) * 12 ) +  parseInt($(this).attr('data-num')); 
		$(this).attr('href', '/<?php echo (cLANG); ?>/'+floor+'/'+rooms[nm].number+'/');
		$(this).click(function() {
			document.location = $(this).attr('href');
		});
	});


	var ww = $('#plani').attr('data-w');
	var hh = $('#plani').attr('data-h');
	
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
	$('#planid').css('opacity', '1');
	$('#planid').hide();
	$('#planid').fadeIn(function() {
		setCImageSize();	
	});
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