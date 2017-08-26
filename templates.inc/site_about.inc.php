<div style="z-index: 999999; display: none; " class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
	<div class="pswp__scroll-wrap">
	    <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
	    <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
            <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="<?php echo (voc('trans_close_esc')); ?>"></button>
                <button class="pswp__button pswp__button--share" title="<?php echo (voc('trans_share')); ?>"></button>
                <button class="pswp__button pswp__button--fs" title="<?php echo (voc('trans_fullscreen')); ?>"></button>
                <button class="pswp__button pswp__button--zoom" title="<?php echo (voc('trans_zoom')); ?>"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div> 
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="<?php echo (voc('trans_previous')); ?>">
            </button>
            <button class="pswp__button pswp__button--arrow--right" title="<?php echo (voc('trans_next')); ?>">
            </button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
<div class="about-page">
	<div class="a-p-menu">
		<?php foreach($parser["stree"] as $_key_1=>$_var_1)
{
 ?>
		<a id="a-<?php echo $parser["stree"][$_key_1]["LANG_URL"]; ?>" href="javascript:show('<?php echo $parser["stree"][$_key_1]["LANG_URL"]; ?>', '<?php echo $parser["stree"][$_key_1]["TYPE"]; ?>')" <?php if (''.$parser["stree"][$_key_1]["num"].''=='1') {?> 	class="color selected" <?php } ?> ><?php echo $parser["stree"][$_key_1]["LANG_NAME"]; ?></a>
		<?php 
}
 ?>
	</div>
	<?php foreach($parser["stree"] as $_key_2=>$_var_2)
{
 ?>
	<div class="a-p-container apall" id="<?php echo $parser["stree"][$_key_2]["LANG_URL"]; ?>" <?php if (''.$parser["stree"][$_key_2]["num"].''!='1') {?> 	style="display: none;" <?php } ?> >
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
                    <a href="javascript:openGallery('<?php echo $parser["cblocks"][$_key_3]["ID"]; ?>', '<?php echo $parser["bimages"][$_key_4]["ID"]; ?>')" style="background:url(<?php echo (getImageSrc('1'.getImageTypeByExt(''.$parser["bimages"][$_key_4]["EXT"].'').'5'.$parser["bimages"][$_key_4]["ID"].'', getImageTypeByExt(''.$parser["bimages"][$_key_4]["EXT"].''))); ?>); <?php if (count($parser['bimages'])=='2') {?> 	width: 50%; height: 270px; <?php } ?> "></a>
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
		<div id="smap" style="height: 100%; width: 100%; display:inline-block; margin-top:30px;"></div>
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
	<div class="r-s-img" style="background:url(/loads/tree/<?php echo ($parser['ob']['images']['0']['ID']); ?>.<?php echo ($parser['ob']['images']['0']['EXT']); ?>);"></div>
</div>

<script>
var markers = [];
var currtp = '0';
var currnm = '0';
var map = '';
var imid = 0;
var infoBubble = new Array();
var popup = new Array();
var currpopup = 0;

function clMPopup(id)
{
	infoBubble[id].close();
}

function reshow()
{
	show(currnm, currtp);
}


function show(nm, tp)
{
	currtp = tp;
	currnm = nm;
	$('.a-p-menu a').removeClass('color');
	$('.a-p-menu a').removeClass('selected');
	$('.a-p-menu #a-'+nm).addClass('color');
	$('.a-p-menu #a-'+nm).addClass('selected');
	$('.apall').hide();
	$('#'+nm).fadeIn('fast', function() {
		if (currtp=='5')
		{
			var mapCanvas = document.getElementById('smap');
			var mapOptions = {
				center: new google.maps.LatLng(56.956659, 24.147919),
				zoom: 15,
				scrollwheel: false,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}		
			map = new google.maps.Map(mapCanvas, mapOptions)
			var companyPos = new google.maps.LatLng(56.956659, 24.147919);
			var companyMarker = new google.maps.Marker({
				position: companyPos,
				map: map,
				title:"",
				icon: new google.maps.MarkerImage('/img/map-marker.png'),
				zIndex: 3000
			});

			/*
			var request = {
				location: companyPos,
				radius: '800',
				types: ['store', 'restaurant', 'parking', 'school', 'hair_care', 'cafe', 'bus_station']
			};

			service = new google.maps.places.PlacesService(map);
			service.nearbySearch(request, callback);
			*/

			markers = [];
			<?php foreach($parser["markers"] as $_key_6=>$_var_6)
{
 ?>
			var companyPos = new google.maps.LatLng(<?php echo $parser["markers"][$_key_6]["LAT"]; ?>, <?php echo $parser["markers"][$_key_6]["LNG"]; ?>);
			markers[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = new google.maps.Marker({
				position: companyPos,
				map: map,
				icon: new google.maps.MarkerImage('/loads/markers/<?php echo $parser["markers"][$_key_6]["IMIDSVG"]; ?>.<?php echo $parser["markers"][$_key_6]["IMEXTSVG"]; ?>'),
				title:"<?php echo $parser["markers"][$_key_6]["LANG_NAME"]; ?>",
				zIndex: 3
			});
			popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = '';
			popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] + '<div class="phoneymap-popup">';
			popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] + '<div class="phoneym-p-header color" style="text-align: center;"><div class="t"><div class="v"><?php echo $parser["markers"][$_key_6]["LANG_NAME"]; ?><a href="javascript:clMPopup(\'<?php echo $parser["markers"][$_key_6]["num"]; ?>\');" class="phoneym-p-close" style="text-align: center;"><img src="/img/close.png" border="0" style="margin-left: 5px; width: 20px; height: 20px;" alt="" /></a></div></div></div>';
			popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] + '<div class="phoneym-p-contacts" style="background: url(\'<?php echo (getImageSrc('8'.getImageTypeByExt(''.$parser["markers"][$_key_6]["IMEXT"].'').'5'.$parser["markers"][$_key_6]["IMID"].'', ''.$parser["markers"][$_key_6]["IMEXT"].'')); ?>\') center; background-size:cover; background-repeat:no-repeat; height: 150px;">';
			popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] + '</div>';
			popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] + '<div class="phoneym-p-work-time">';
			popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] + '<div class="phoneywork-time-table" style="padding: 10px; text-align: center;"><?php echo $parser["markers"][$_key_6]["LANG_TEXT"]; ?>';
			popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] + '</div>';
			popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] + '</div>';
			popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] + '<div class="phoneym-p-footer color" style="text-align: center;"><?php echo $parser["markers"][$_key_6]["ADDRESS"]; ?></div>';
			popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>] + '</div>';
			infoBubble[<?php echo $parser["markers"][$_key_6]["num"]; ?>] = new InfoBubble({
			  map: map,
			  content: popup[<?php echo $parser["markers"][$_key_6]["num"]; ?>],
			  position: new google.maps.LatLng(-100, -100),
			  shadowStyle: 0,
			  padding: 0,
			  backgroundColor: 'none',
			  borderRadius: 0,
			  arrowSize: 0,
			  borderWidth: 0,
			  borderColor: 'none',
			  disableAutoPan: true,
			  hideCloseButton: true,
			  arrowPosition: 50,
			  backgroundClassName: 'phoney',
			  arrowStyle: 2
			});


			google.maps.event.addListener(markers[<?php echo $parser["markers"][$_key_6]["num"]; ?>], 'click', function() {
				if (!infoBubble[<?php echo $parser["markers"][$_key_6]["num"]; ?>].isOpen()) 
				{
					var latLng = this.getPosition(); // returns LatLng object
					map.setCenter(latLng); // setCenter takes a LatLng object
					map_recenter(latLng, 0, 100);
					if (currpopup!=0)
					{
						infoBubble[currpopup].close();
					}
					infoBubble[<?php echo $parser["markers"][$_key_6]["num"]; ?>].open(map, this);
					currpopup = <?php echo $parser["markers"][$_key_6]["num"]; ?>;
					var rendererOptions = {
						map: map,
						preserveViewport: true
					}
				}
				else
				{
					infoBubble[<?php echo $parser["markers"][$_key_6]["num"]; ?>].close();
				}
			  });

			<?php 
}
 ?>
		}
	});
}

function map_recenter(latlng,offsetx,offsety) {
    var point1 = map.getProjection().fromLatLngToPoint(
        (latlng instanceof google.maps.LatLng) ? latlng : map.getCenter()
    );
	console.log(point1);
    var point2 = new google.maps.Point(
        ( (typeof(offsetx) == 'number' ? offsetx : 0) / Math.pow(2, map.getZoom()) ) || 0,
        ( (typeof(offsety) == 'number' ? (point1.y - 200) : 0) / Math.pow(2, map.getZoom()) ) || 0
    );  
    map.setCenter(map.getProjection().fromPointToLatLng(new google.maps.Point(
        point1.x,
        point1.y + point2.y
    )));
}

function callback(results, status) 
{
	console.log(status);
	if (status == google.maps.places.PlacesServiceStatus.OK)
	{
		for (var i = 0; i < results.length; i++) 
		{
			var place = results[i];
			console.log(place);
			var image = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(20, 20)
			};
			var companyMarker = new google.maps.Marker({
				map: map,
				icon: image,
				zIndex: i+100,
				title: place.name,
	            position: place.geometry.location
			});
		}
	}
}

function openGallery(id, imid) {
	$('.pswp').eq(0).show();
	var pswpElement = document.querySelectorAll('.pswp')[0];
	
	var items = [];
	var obj = {};
	var ind = 0;
	var imind = 0;
	<?php foreach($parser["stree"] as $_key_7=>$_var_7)
{
 ?>
		<?php echo (getTextBlocksSite(''.$parser["stree"][$_key_7]["ID"].'', 'tree')); ?>
		<?php if (count($parser['cblocks'])>0) {?> 	
		<?php foreach($parser["cblocks"] as $_key_8=>$_var_8)
{
 ?>
		<?php if (''.$parser["cblocks"][$_key_8]["TYPE"].''=='2') {?> 	
		<?php echo (getImagesBlockSite('tree', ''.$parser["cblocks"][$_key_8]["ID"].'')); ?>
			<?php foreach($parser["bimages"] as $_key_9=>$_var_9)
{
 ?>
			obj = {
				src: '/loads/tree/<?php echo $parser["bimages"][$_key_9]["ID"]; ?>.<?php echo $parser["bimages"][$_key_9]["EXT"]; ?>',
				w: <?php echo $parser["bimages"][$_key_9]["w"]; ?>,
				h: <?php echo $parser["bimages"][$_key_9]["h"]; ?>,
				title: ''
			};
			if (id=='<?php echo $parser["bimages"][$_key_9]["ST"]; ?>')
			{
				obj.pid = 'image-' + ind;
				items.push(obj);
				if (imid=='<?php echo $parser["bimages"][$_key_9]["ID"]; ?>')
				{
					imind = ind;
				}
				ind++;
			}
			<?php 
}
 ?>
		 <?php } ?> 
		<?php 
}
 ?>
		 <?php } ?> 
	<?php 
}
 ?>
	var options = {
		index: imind
	};
	var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
	gallery.init();
}

</script>