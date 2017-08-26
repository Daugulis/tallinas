<style>
.reqerr { border: solid 1px red !important; }
</style>

<div class="contacts-page">
	<div class="c-p-container">
		<b><?php echo ($parser['contacts']['0']['LANG_NAME']); ?></b>
			<?php if ($parser['contacts']['0']['REGNR']!='') {?> 	
			<div class="c-p-line">
				<div class="c-p-l-left"><?php echo (voc('Рег. номер:')); ?></div>
				<div class="c-p-l-right">
					<a><?php echo ($parser['contacts']['0']['REGNR']); ?></a>
				</div>
			</div>
			 <?php } ?> 
			<?php if ($parser['contacts']['0']['LANG_ADDRESS']!='') {?> 	
			<div class="c-p-line">
				<div class="c-p-l-left"><?php echo (voc('Адрес.:')); ?></div>
				<div class="c-p-l-right">
					<a><?php echo ($parser['contacts']['0']['LANG_ADDRESS']); ?></a>
				</div>
			</div>
			 <?php } ?> 
			<?php if ($parser['contacts']['0']['PHONE']!='') {?> 	
			<div class="c-p-line">
				<div class="c-p-l-left"><?php echo (voc('Тел.:')); ?></div>
				<div class="c-p-l-right">
					<a><?php echo ($parser['contacts']['0']['PHONE1']); ?></a>
				</div>
			</div>
			 <?php } ?> 
			<?php if ($parser['contacts']['0']['PHONE2']!='') {?> 	
			<div class="c-p-line">
				<div class="c-p-l-left"><?php echo (voc('Моб.:')); ?></div>
				<div class="c-p-l-right">
					<a><?php echo ($parser['contacts']['0']['PHONE2']); ?></a>
				</div>
			</div>
			 <?php } ?> 
			<?php if ($parser['contacts']['0']['EMAIL']!='') {?> 	
			<div class="c-p-line">
				<div class="c-p-l-left"><?php echo (voc('Эл почта.:')); ?></div>
				<div class="c-p-l-right">
					<a class="mailto:<?php echo ($parser['contacts']['0']['EMAIL']); ?>" id="mail"><?php echo ($parser['contacts']['0']['EMAIL']); ?></a>
				</div>
			</div>
<style>
.c-person        { float:left; position:relative; margin-top:30px; padding-top:30px; padding-bottom:32px; width:100%; border-top:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; font-size:20px }
.c-person:before { content:''; position:absolute; left:0px; top:0px; width:100%; height:1px; background:#fff; }
.c-person:after  { content:''; position:absolute; left:0px; bottom:-2px; width:100%; height:1px; background:#fff; }
.c-person b      { float:left; clear:left; margin:0px; padding:0px; font-size:15px; }
.c-person i      { float:left; clear:left; margin:0px; margin-top:5px; padding:0px; color:#7d7d7d; font-size:13px; font-style:normal; }
</style>
            <div class="c-person">
                <?php echo voc('<b>Tamāra Raine</b><i>Nekustamo īpašumu pārdošanas nodaļas direktore</i>'); ?>
            </div>
			 <?php } ?> 
				<div class="c-b-item work-time" style="display: none;">
					<div class="c-b-i-right">
						<div class="work-time-table">
							<div class="w-t-block">
								<p class="w-t-head color"><?php echo (voc('Пн.')); ?></p>
								<p>10-18</p>
							</div>
							<div class="w-t-block">
								<p class="w-t-head color"><?php echo (voc('Вт.')); ?></p>
								<p>10-18</p>
							</div>
							<div class="w-t-block">
								<p class="w-t-head color"><?php echo (voc('Ср.')); ?></p>
								<p>10-18</p>
							</div>
							<div class="w-t-block">
								<p class="w-t-head color"><?php echo (voc('Чт.')); ?></p>
								<p>10-18</p>
							</div>
							<div class="w-t-block">
								<p class="w-t-head color"><?php echo (voc('Пт.')); ?></p>
								<p>10-18</p>
							</div>
							<div class="w-t-block">
								<p class="w-t-head free-day"><?php echo (voc('Сб.')); ?></p>
								<p>-</p>
							</div>
							<div class="w-t-block">
								<p class="w-t-head free-day"><?php echo (voc('Вс.')); ?></p>
								<p>-</p>
							</div>
						</div>
					</div>
				</div>
			<form id="sform">
				<div id="frep" style="display: none;" style="padding: 0px 0px 10px; font-size: 14px;"><?php echo (voc('Сообщение отправлено')); ?><br /><br /></div>
				<input name="name" type="text" class="req" placeholder="<?php echo (voc('Ваше Имя')); ?>"/>
				<input name="phone" type="text" class="req" placeholder="<?php echo (voc('Телефон')); ?>"/>
				<input name="email" type="text" class="req" placeholder="<?php echo (voc('Эл. почта')); ?>"/>
				<textarea name="text" class="req" placeholder="<?php echo (voc('Текст сообщения')); ?>"></textarea>
				<a href="javascript:sendf();" class="button color"><?php echo (voc('Отправить')); ?></a>
			</form>
	</div>
</div>
<div id="map"></div>

<script>

function sendf()
{
	var s = 1;
	$('#sform .req').each(function() {
		if ($(this).val()=='' || $(this).val()==$(this).attr('placeholder'))
		{
			s = 0;
			$(this).addClass('reqerr');
		}
		else
		{
			$(this).removeClass('reqerr');
		}
	});
	if (s==1)
	{
		$('#frep').slideDown(function() {
			setTimeout(function() {
				$('#frep').slideUp();
			}, 3000);
		});
		$.ajax({
			type: 'POST',
			url: '/<?php echo (cLANG); ?>/sendmsg/',
			data: $('#sform').serialize()
		}).done(function(data) {
			$('#sform .req').val('');
		});
	}
}

      function initialize() {
        var mapCanvas = document.getElementById('map');
        var mapOptions = {
          center: new google.maps.LatLng(<?php echo ($parser['contacts']['0']['LAT']); ?>, <?php echo ($parser['contacts']['0']['LNG']); ?>),
          zoom: 16,
		  scrollwheel: false,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }		
        var map = new google.maps.Map(mapCanvas, mapOptions)
		var companyPos = new google.maps.LatLng(<?php echo ($parser['contacts']['0']['LAT']); ?>, <?php echo ($parser['contacts']['0']['LNG']); ?>);
		var companyMarker = new google.maps.Marker({
		  position: companyPos,
		  map: map,
		  title:"",
		  icon: new google.maps.MarkerImage('/img/map-marker.png'),
		  zIndex: 3});
      }
      google.maps.event.addDomListener(window, 'load', initialize);	  
</script>