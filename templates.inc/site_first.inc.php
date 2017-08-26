<style>
.m-p-img2 { 
	position:absolute; 
	left:0px; 
	top:0px; 
	width:100%; 
	height:100%; 
	overflow: hidden; 
}
.m-p-img2 img {
	width: 100%;
	opacity: 0;
}
.m-p-img2 .imgc {
	position: absolute;
}

</style>
<div class="choose-floor-window" style="z-index: 999;"><a href="" class="close-window"><i></i></a>
	<b><?php echo (voc('ВЫБЕРИТЕ ЭТАЖ')); ?></b>
	<div class="c-f-w-menu">
		<a href="/<?php echo (cLANG); ?>/5/" onmouseover="showlevel('5')" onmouseout="hidelevel('5')" data-level="5"><?php echo (voc('5 этаж')); ?></a>
		<a href="/<?php echo (cLANG); ?>/4/" onmouseover="showlevel('4')" onmouseout="hidelevel('4')" data-level="4"><?php echo (voc('4 этаж')); ?></a>
		<a href="/<?php echo (cLANG); ?>/3/" onmouseover="showlevel('3')" onmouseout="hidelevel('3')" data-level="3"><?php echo (voc('3 этаж')); ?></a>
		<a href="/<?php echo (cLANG); ?>/2/" onmouseover="showlevel('2')" onmouseout="hidelevel('2')" data-level="2"><?php echo (voc('2 этаж')); ?></a>
	</div>
</div>
<div class="m-p-img" id="m-p-img" style="z-index: 997;"></div>
<div class="m-p-img2" style="z-index: 998;"><div class="imgc"><img src="/img/tallinas86.jpg" id="planim" usemap="#map1" /><map name="map1" data-mapid="2" id="map1"><area id="s2" data-mapid="2" alt="" title="" href="/<?php echo (cLANG); ?>/2/" shape="poly" coords="229,559,604,424,1155,552,1165,620,609,548,219,626" style="outline:none;" target="_self"     /><area data-mapid="3" id="s3" alt="" title="" href="/<?php echo (cLANG); ?>/3/" shape="poly" coords="234,498,606,317,1148,490,1154,541,606,403,228,546" style="outline:none;" target="_self"     /><area data-mapid="4"  id="s4" alt="" title="" href="/<?php echo (cLANG); ?>/4/" shape="poly" coords="243,431,607,212,1134,427,1143,484,608,316,237,492" style="outline:none;" target="_self"     /><area data-mapid="5" id="s5" alt="" title="" href="/<?php echo (cLANG); ?>/5/" shape="poly" coords="248,367,606,101,1128,367,1134,418,607,207,247,428,244,427" style="outline:none;" target="_self" /></map></div></div>

<div class="pls"></div>
<div class="plsl"></div>
<div class="plsh"></div>

<script>

wrz = true;
var backgroundImage = '';
var backgroundImageLoaded = false;

var ht = '';


function showlevel(num)
{
	$('#s'+num).mouseover();
}
function hidelevel(num)
{
	$('#s'+num).mouseout();
}

var mp = '';

$(document).ready(function() {
	$(window).resize(function() {
		//mp = null;
		//setCImageSize();
		console.log('r1');
	});
	//setCImageSize();
	$('img[usemap]').mapTrifecta();
	$('area').each(function() {
		$(this).mouseover(function() {
			var nm = $(this).attr('data-mapid');
			$('.c-f-w-menu a').removeClass('hover');
			console.log(nm);
			$('.c-f-w-menu a[data-level="'+nm+'"]').addClass('hover');
		});
		$(this).mouseleave(function() {
			var nm = $(this).attr('data-mapid');
			$('.c-f-w-menu a').removeClass('hover');
		});
		$(this).click(function() {
			var nm = $(this).attr('data-mapid');
			document.location = '/<?php echo (cLANG); ?>/'+nm+'/';
		});
	});
});

</script>

