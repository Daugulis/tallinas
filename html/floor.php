<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tallinas 86</title>
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
<link href="/tr/css/bootstrap-3.3.1.min.css" rel="stylesheet" />
<link rel="stylesheet" href="/map-trifecta.css"> 
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script> -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script src="/jquery.map-trifecta.js?<?php echo time(); ?>" type="text/javascript"></script> 
</head>
<body>

<style>
#plani {
	width: 50%;
}
</style>

<div>
	<img src="/img/plan-1.png" alt="" id="plani" usemap="#planim"/>
	<map name="planim">
		<area  data-mapid="1" alt="fs1" title="fs1" href="/<!---cLANG--->/<!---OBJ--->/12/" shape="poly" data-t="24" data-x="262" data-y="130" coords="41,41,1041,42,1041,491,42,491" style="outline:none;" target="_self"     />
		<area  data-mapid="2" alt="fs2" title="fs2" href="" shape="poly" data-t="24" data-x="262" data-y="130" coords="1704,340,1745,340,1744,40,2170,40,2169,531,1746,530,1746,401,1705,401" style="outline:none;" target="_self"     />
		<area  data-mapid="3" alt="fs3" title="fs3" href="" shape="poly" data-t="24" data-x="262" data-y="130" coords="1602,532,1709,533,1709,626,1746,626,1745,542,2170,542,2169,787,2197,787,2197,1099,1747,1099,1746,686,1708,686,1709,729,1603,729" style="outline:none;" target="_self"     />
		<area  data-mapid="4" alt="fs4" title="fs4" href="" shape="poly" data-t="24" data-x="262" data-y="130" coords="1593,282,1283,283,1284,995,1705,995,1705,740,1592,740" style="outline:none;" target="_self"     />
		<area  data-mapid="5" alt="fs5" title="fs5" href="" shape="poly" data-t="24" data-x="262" data-y="130" coords="1283,1007,1705,1006,1704,1525,1629,1526,1629,1505,1284,1505" style="outline:none;" target="_self"     />
	</map>
</div>

<script>

function setCImageSize()
{
	$('img[usemap]').mapTrifecta();
}

$(document).ready(function() {
	//$(window).resize(setCImageSize);
	setCImageSize();
});
</script>

</body>
</html>
