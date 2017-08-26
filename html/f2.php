<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tallinas 86</title>
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script> 
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script src="/jquery.rwdImageMaps.js?<?php echo time(); ?>" type="text/javascript"></script> 
<script src="/jquery.maphilight.js?<?php echo time(); ?>" type="text/javascript"></script>
<!-- <script src="/jquery.map-trifecta.js?<?php echo time(); ?>" type="text/javascript"></script> -->
</head>
<body>
<div class="left-side">
	<div class="l-s-header">
    	<a href="index.html" class="logo">Tallinas <b class="color">86</b></a>
        <div class="languages">
        	<a href="">Lat</a>
            <a href="" class="selected">Rus</a>
            <a href="">Eng</a>
        </div>
    </div>
    <div class="l-s-main">
    	<div class="l-s-m-menu">
        	<a href="index.html">Выбор квартиры</a> 
			<a href="about.html">О проекте</a> 
			<a href="gallery.html">Галерея </a> 
			<a href="contacts.html" class="selected color">Контакты</a> 
        </div>
        <div class="l-s-m-share">
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style addthis_32x32_style" >
                <a class="addthis_button_facebook"></a>
                <a class="addthis_button_draugiem"></a>
                <a class="addthis_button_twitter"></a>
                <a class="addthis_button_google_plusone_share"></a>
                <a class="addthis_button_email"></a>
            </div>
            <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
            <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50e808b26b4f2c23"></script>
            <!-- AddThis Button END -->
        </div>
    </div>
    <div class="l-s-footer">
    	<a href="contacts.html" class="button color">Задать вопрос</a>
    </div>
</div>
<div class="main">
	<div class="m-container">
		<div class="floor-page">
			<div class="f-p-menu">
            	<a href="">2 этаж</a>
                <a href="">3 этаж</a>
                <a href="" class="color selected">4 этаж</a>
                <a href="">5 этаж</a>
            </div>
            <div class="floor-plan">
            	<div class="t">
                	<div class="v">
                    	<img src="/img/plan-1.png" alt="" width="700" id="plani" usemap="#planim"/>
						<map name="planim" id="planim">
							<area  id="fs1" alt="fs1" title="fs1" href="/<!---cLANG--->/<!---OBJ--->/12/" shape="poly" data-t="24" data-x="262" data-y="130" coords="41,41,1041,42,1041,491,42,491" style="outline:none;" target="_self"     />
							<area  id="fs2" alt="fs2" title="fs2" href="" shape="poly" data-t="24" data-x="262" data-y="130" coords="1704,340,1745,340,1744,40,2170,40,2169,531,1746,530,1746,401,1705,401" style="outline:none;" target="_self"     />
							<area  id="fs3" alt="fs3" title="fs3" href="" shape="poly" data-t="24" data-x="262" data-y="130" coords="1602,532,1709,533,1709,626,1746,626,1745,542,2170,542,2169,787,2197,787,2197,1099,1747,1099,1746,686,1708,686,1709,729,1603,729" style="outline:none;" target="_self"     />
							<area  id="fs4" alt="fs4" title="fs4" href="" shape="poly" data-t="24" data-x="262" data-y="130" coords="1593,282,1283,283,1284,995,1705,995,1705,740,1592,740" style="outline:none;" target="_self"     />
							<area  id="fs5" alt="fs5" title="fs5" href="" shape="poly" data-t="24" data-x="262" data-y="130" coords="1283,1007,1705,1006,1704,1525,1629,1526,1629,1505,1284,1505" style="outline:none;" target="_self"     />
						</map>
                    </div>
            	</div>
            </div>
        </div>
        <div class="f-p-m-img">
        	<div class="m-p-img"></div>
        </div>
    </div>
</div>

<script>

function setCImageSize()
{
	//$('#plani').rwdImageMaps();
	$('#plani').maphilight();
	
}

$(document).ready(function() {
	setCImageSize();
});
</script>

</body>
</html>
