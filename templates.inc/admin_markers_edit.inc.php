<style>
.mtext { float: left; width: 99%; }
</style>
<div class="sub-menu">
	<div class="sub-menu-container">
    	<a href="/<?php echo (cLANG); ?>/manager/catalogue/"><?php echo (voc('Catalogue')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/areas/"><?php echo (voc('Areas')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/atypes/"><?php echo (voc('Areas types')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/markers/" class="selected"><?php echo (voc('Markers')); ?></a>
    </div>
</div>
<div class="main">
	<div class="sort">

	</div> 
	<div class="add-table">
		<div class="table-header">
			<div class="cell-1" style="width: 100%;"><?php echo (voc('Edit marker')); ?> - <?php echo (htmlspecialchars($parser['d_ADDRESS'])); ?></div>
		</div>
		<div class="add-item">
			<form id="pform">
			<input name="lat" type="hidden" value="<?php echo $parser["d_LAT"]; ?>">
			<input name="lng" type="hidden" value="<?php echo $parser["d_LNG"]; ?>">
			<input name="formatted_address" type="hidden" value="<?php echo $parser["d_ADDRESS"]; ?>">
			<input type="hidden" name="data" value="1"/>
			<div class="cell-1" style="width: 100%;">
				<h2><?php echo (voc('Information')); ?></h2>
				<div class="add-item-line">
					<?php foreach($parser["langs"] as $_key_1=>$_var_1)
{
 ?>
					<div class="half-block">
						<h1><?php echo (voc('Name')); ?> (<?php echo $parser["langs"][$_key_1]["SHORTNAME"]; ?>):</h1>
						<input type="text" class="prev" name="name_<?php echo $parser["langs"][$_key_1]["ID"]; ?>" value="<?php echo (htmlspecialchars(getVFValue('d_name', ''.$parser["langs"][$_key_1]["ID"].''))); ?>" />
					</div>
					<?php 
}
 ?>
					<div class="half-block">
						<h1><?php echo (voc('Status:')); ?></h1>
						<select name="status">
							<option value="1" <?php if ($parser['d_STATUS']=='1') {?> 	selected <?php } ?> >Активный</option>
							<option value="0" <?php if ($parser['d_STATUS']=='0') {?> 	selected <?php } ?> >Неактивный</option>
						</select>
					</div>	
						
				</div>   

				<h2><?php echo (voc('Short text')); ?></h2>
				<div class="add-item-line">
					<?php foreach($parser["langs"] as $_key_2=>$_var_2)
{
 ?>
					<div class="full-block" style="width: 33%;"> 
						<h1 style="padding: 10px;"><?php echo (voc('Short text')); ?> (<?php echo $parser["langs"][$_key_2]["SHORTNAME"]; ?>)</h1>
						<textarea class="prev" id="text_<?php echo $parser["langs"][$_key_2]["ID"]; ?>" name="text_<?php echo $parser["langs"][$_key_2]["ID"]; ?>"><?php echo (getVFValue('d_text', ''.$parser["langs"][$_key_2]["ID"].'')); ?></textarea>
					</div>
					<?php 
}
 ?>
				</div>
				<div style="clear: both;"></div>

				
				
				<h2><?php echo (voc('Map')); ?></h2>
				<div class="add-item-line">
					<div class="full-block">
						<h1><?php echo (voc('Map address:')); ?></h1>
						<input type="text" class="prev" name="mapaddress" id="mapinput" value="<?php echo (htmlspecialchars($parser['d_ADDRESS'])); ?>" />
					</div>	
					<div class="full-block">
						<div id="map" style="width: 100%; height: 400px;"></div>
					</div>	
				</div>  

				<div style="clear: both;"></div>
				<h2><?php echo (voc('Images')); ?>:</h2>
				<div class="add-item-line">
					<div class="add-item-img-container" id="itemimg">
						<?php foreach($parser["images"] as $_key_3=>$_var_3)
{
 ?>
						<p class="itemimg" data-type="<?php echo (getImageType(''.$parser["images"][$_key_3]["TYPE"].'')); ?>" id="up<?php echo $parser["images"][$_key_3]["ID"]; ?>" data-img="<?php echo $parser["images"][$_key_3]["ID"]; ?>"><a style="display: block;" class="del" href="javascript:delImage('<?php echo $parser["images"][$_key_3]["ID"]; ?>', '');"></a><input type="hidden" name="itemimg[]" value="<?php echo $parser["images"][$_key_3]["ID"]; ?>" id="itemimg<?php echo $parser["images"][$_key_3]["ID"]; ?>" /><img <?php if (''.$parser["images"][$_key_3]["EXT"].''!='svg') {?> 	src="/getimage.php?id=8<?php echo (getImageType(''.$parser["images"][$_key_3]["TYPE"].'')); ?>1<?php echo $parser["images"][$_key_3]["ID"]; ?>" <?php } ?> <?php if (''.$parser["images"][$_key_3]["EXT"].''=='svg') {?> 	src="/loads/markers/<?php echo $parser["images"][$_key_3]["ID"]; ?>.svg" <?php } ?>  /><a class="upproc" style="display: none; margin-left: 11px; margin-top: 20px;">0%</a></p>
						<?php 
}
 ?>
						<p id="addpbut"><a id="addimagebutt" style="margin-left: 8px;margin-top: 8px;"><img src="/admin/img/icon-green-add-big.png" width="48" height="48" border="0" /></a></p>
					</div>
				</div>
				
				
				<div style="clear: both;"></div>
				
				<h2><?php echo (voc('Save data')); ?></h2>
				<a href="javascript:saveText();" class="add-photo"><?php echo (voc('Save data')); ?></a>
			</div>
			</form>
			
		</div>
	   
	</div>

</div>

<style>
.selb {
	border: solid 1px #ff6600 !important;
}
</style>

<div id="upimgs"><div>
<div id="upimgs2"><div>

<script>

var tnm = <?php echo (count($parser['blocks'])); ?>;

function deleteBlock(nm)
{
	$('#mtext'+nm).slideUp(function() { $(this).remove(); });
}

function addBlock(p)
{
	tnm = tnm + 1;
	switch (p)
	{
	case 'text':
		var t = '<div class="mtext"><h2><?php echo (voc('Text')); ?><a style="cursor: pointer; margin-right: 20px;"><img class="move" src="/admin/img/icon-move-small.png" border="0" alt="" /></a><a href="javascript:deleteBlock(\''+tnm+'\')" style="cursor: pointer;"><img  src="/admin/img/icon-close-small.png" border="0" alt="" /></a></h2><div class="add-item-line"><input type="hidden" name="block[]" value="'+tnm+'" />';
		<?php foreach($parser["langs"] as $_key_4=>$_var_4)
{
 ?>
		t = t + '<div class="full-block" style="width: 33%;"><h1 style="padding: 10px;"><?php echo (voc('Text')); ?> (<?php echo $parser["langs"][$_key_4]["SHORTNAME"]; ?>)</h1><textarea class="prev"  style="height: 160px; text-transform: none;" name="text['+tnm+'][<?php echo $parser["langs"][$_key_4]["ID"]; ?>]"></textarea></div>';
		<?php 
}
 ?>
		t = t + '</div></div>';
		$('.mtexts').append(t);

		$( "#mtexts").sortable({
			
			items: "div.mtext",
			handle: ".move",
			stop: function( event, ui ) {
				//$('#thpr').html('');
				//pImages();
			}
		});
		break;
	case 'foto':
		var t = '<div class="mtext"><input type="hidden" name="block[]" value="'+tnm+'" /><h2><?php echo (voc('Images')); ?>: <a style="cursor: pointer; margin-right: 20px;"><img class="move" src="/admin/img/icon-move-small.png" border="0" alt="" /></a><a href="javascript:deleteBlock(\''+tnm+'\')" style="cursor: pointer;"><img  src="/admin/img/icon-close-small.png" border="0" alt="" /></a></h2><div class="add-item-line"><div class="add-item-img-container" id="itemimg_'+tnm+'"><p id="addpbut_'+tnm+'"><a id="addimagebutt_'+tnm+'" style="margin-left: 8px;margin-top: 8px;"><img src="/admin/img/icon-green-add-big.png" width="48" height="48" border="0" /></a></p></div></div></div><div id="upimgs_'+tnm+'" style="display: none;"></div>';
		$('#mtexts').append(t);

		$( "#mtexts").sortable({
			
			items: "div.mtext",
			handle: ".move",
			stop: function( event, ui ) {
				//$('#thpr').html('');
				//pImages();
			}
		});

		DJS['addUpImages_'+tnm] =  function(up, file) {
			var h = '<p class="itemimg data-type="" id="up_'+up+'_'+file.id+'" data-img=""><a class="del" href="javascript:delImageT(\''+up+'\', \''+file.id+'\', \'\');"></a><input type="hidden" name="itemimg['+up+'][]" value="" id="itemimg_'+up+'_'+file.id+'" /><img src="" style="display:none;" /><a class="upproc" style="margin-left: 11px; margin-top: 20px;">0%</a></p>';
			$('#addpbut_'+up).before(h);
			$( "#itemimg_" + up ).sortable({
				containment: "parent",
				items: "p.itemimg",
				stop: function( event, ui ) {
					//$('#thpr').html('');
					//pImages();
				}
			});
		}


		DJS['uploadUpImages_'+tnm] =  function(up, file, resp, tm) {
			var obj = $.parseJSON(resp['response']);
			$('#up_'+tm+'_'+file.id+' a.upproc').css('display', 'none');
			$('#up_'+tm+'_'+file.id+' a.del').fadeIn();
			$('#up_'+tm+'_'+file.id+' img').load(function() {
				$(this).fadeIn();
				var hh = $(this).height();
				if (hh<90)
				{
					hh = ( 90 - hh ) / 2;
					$(this).css('margin-top', hh.toFixed(0)+'px');
				}
				var ww = $(this).width();
				if (ww<90)
				{
					ww = ( 90 - ww ) / 2;
					$(this).css('margin-left', ww.toFixed(0)+'px');
				}
			});
			$('#up_'+tm+'_'+file.id+' img').attr('src', '/getimage.php?id=8'+obj.typeid+'1'+obj.id);
			$('#up_'+tm+'_'+file.id).data('img', obj.id);
			$('#up_'+tm+'_'+file.id).data('type', obj.typeid);
			$('#itemimg_'+tm+'_'+file.id).val(obj.id);
		}

		DJS['progressUpImages_'+tnm] =  function(up, file, tm) {
			$('#up_'+tm+'_'+file.id+' a.upproc').html(file.percent+'%');
		}

		addUploader(new Array(tnm, 'addimagebutt_'+tnm, 'upimgs_'+tnm, 'addUpImages_'+tnm, 'uploadUpImages_'+tnm, 'progressUpImages_'+tnm, '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/addimage/'));
		break;
	}
}

function saveText()
{
	if (CKEDITOR)
	{
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances[instance].updateElement();
		}
	}
	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/manager/markers/editajax/<?php echo (ID); ?>/',
		data: $('#pform').serialize()
	}).done(function(data) {
		$('#pcontent').html(data);
		$('#overley').fadeIn();
		$('#popup').fadeIn();		
	});
}

function prevText()
{
	var h = CKEDITOR.instances['ctext_<?php echo (LANG); ?>'].getData();
	$('#prevtext').html(h);
}

DJS.addUpImages =  function(up, file) {
	var h = '<p class="itemimg" data-type="" id="up'+file.id+'" data-img=""><a class="del" href="javascript:delImage(\''+file.id+'\', \'\');"></a><input type="hidden" name="itemimg[]" value="" id="itemimg'+file.id+'" /><img src="" style="display:none;" /><a class="upproc" style="margin-left: 11px; margin-top: 20px;">0%</a></p>';
	$('#addpbut').before(h);
	$( "#itemimg" ).sortable({
		containment: "parent",
		items: "p.itemimg",
		stop: function( event, ui ) {
			//$('#thpr').html('');
			//pImages();
		}
	});
	$('#itemimg .itemimg').click(function() {
		$('#itemimg .itemimg').removeClass('selb');
		$(this).addClass('selb');
	});
}


DJS.uploadUpImages =  function(up, file, resp) {
	var obj = $.parseJSON(resp['response']);
	$('#up'+file.id+' a.upproc').css('display', 'none');
	$('#up'+file.id+' a.del').fadeIn();
	$('#up'+file.id+' img').load(function() {
		$(this).fadeIn();
		var hh = $(this).height();
		if (hh<90)
		{
			hh = ( 90 - hh ) / 2;
			$(this).css('margin-top', hh.toFixed(0)+'px');
		}
		var ww = $(this).width();
		if (ww<90)
		{
			ww = ( 90 - ww ) / 2;
			$(this).css('margin-left', ww.toFixed(0)+'px');
		}
	});
	if (obj.ext!='svg')
	{
		$('#up'+file.id+' img').attr('src', '/getimage.php?id=8'+obj.typeid+'1'+obj.id);
	}
	else
	{
		$('#up'+file.id+' img').attr('src', '/loads/markers/'+obj.id+'.svg');
	}
	$('#up'+file.id).data('img', obj.id);
	$('#up'+file.id).data('type', obj.typeid);
	$('#itemimg'+file.id).val(obj.id);
}

DJS.progressUpImages =  function(up, file) {
	$('#up'+file.id+' a.upproc').html(file.percent+'%');
}

DJS.addUpImages2 =  function(up, file) {
	var h = '<p class="itemimg" data-type="" id="upi'+file.id+'" data-img=""><a class="del" href="javascript:delIcons(\''+file.id+'\', \'\');"></a><input type="hidden" name="itemicons[]" value="" id="itemicon'+file.id+'" /><img src="" style="display:none;" /><a class="upproc" style="margin-left: 11px; margin-top: 20px;">0%</a></p>';
	$('#addpbut2').before(h);
	$( "#itemicon" ).sortable({
		containment: "parent",
		items: "p.itemimg",
		stop: function( event, ui ) {
			//$('#thpr').html('');
			//pImages();
		}
	});
	$('#itemicon .itemimg').click(function() {
		$('#itemicon .itemimg').removeClass('selb');
		$(this).addClass('selb');
	});
}


DJS.uploadUpImages2 =  function(up, file, resp) {
	var obj = $.parseJSON(resp['response']);
	$('#upi'+file.id+' a.upproc').css('display', 'none');
	$('#upi'+file.id+' a.del').fadeIn();
	$('#upi'+file.id+' img').load(function() {
		$(this).fadeIn();
		var hh = $(this).height();
		if (hh<90)
		{
			hh = ( 90 - hh ) / 2;
			$(this).css('margin-top', hh.toFixed(0)+'px');
		}
		var ww = $(this).width();
		if (ww<90)
		{
			ww = ( 90 - ww ) / 2;
			$(this).css('margin-left', ww.toFixed(0)+'px');
		}
	});
	$('#upi'+file.id+' img').attr('src', '/loads/servicesicons/'+obj.id+'.svg');
	$('#upi'+file.id).data('img', obj.id);
	$('#upi'+file.id).data('type', obj.typeid);
	$('#itemicon'+file.id).val(obj.id);
}

DJS.progressUpImages2 =  function(up, file) {
	$('#upi'+file.id+' a.upproc').html(file.percent+'%');
}

function delImage(id, p)
{
	$('#up'+id).remove();	
}
function delImageT(t, id, p)
{
	$('#up_'+t+'_'+id).remove();	
}
function delIcon(id, p)
{
	$('#upi'+id).remove();	
}

$(document).ready(function() {
	
	$('.dtime').datetimepicker({
							firstDay : 1,
							dateFormat: 'dd.mm.yy',
							timeFormat: 'HH:mm',
							showButtonPanel: true  });

	<?php foreach($parser["langs"] as $_key_5=>$_var_5)
{
 ?>
	/*
	CKEDITOR.replace( 'stext_<?php echo $parser["langs"][$_key_5]["ID"]; ?>' , {
		toolbar: [ 
			{ name: 'document', items: [ 'Source', '-', 'NewPage' ] }, [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ], { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
			{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
			{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
			{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
			{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		]
	});
	CKEDITOR.replace( 'text_<?php echo $parser["langs"][$_key_5]["ID"]; ?>' , {
		toolbar: [ 
			{ name: 'document', items: [ 'Source', '-', 'NewPage' ] }, [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ], { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
			{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
			{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
			{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
			{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		]
	});
	*/
	<?php 
}
 ?>

	addUploader(new Array('item', 'addimagebutt', 'upimgs', 'addUpImages', 'uploadUpImages', 'progressUpImages', '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/addimage/'));

	//addUploader(new Array('item2', 'addiconbutt', 'upimgs2', 'addUpImages2', 'uploadUpImages2', 'progressUpImages2', '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/addicon/'));

	$('.itemimg').each(function() {
		$(this).find('img').eq(0).each(function() {
			$(this).fadeIn();
			var hh = $(this).height();
			if (hh<90)
			{
				hh = ( 90 - hh ) / 2;
				$(this).css('margin-top', hh.toFixed(0)+'px');
			}
			var ww = $(this).width();
			if (ww<90)
			{
				ww = ( 90 - ww ) / 2;
				$(this).css('margin-left', ww.toFixed(0)+'px');
			}
		});
		$(this).find('img').eq(0).load(function() {
			$(this).fadeIn();
			var hh = $(this).height();
			if (hh<90)
			{
				hh = ( 90 - hh ) / 2;
				$(this).css('margin-top', hh.toFixed(0)+'px');
			}
			var ww = $(this).width();
			if (ww<90)
			{
				ww = ( 90 - ww ) / 2;
				$(this).css('margin-left', ww.toFixed(0)+'px');
			}
		});
	});

	$( "#itemimg" ).sortable({
		containment: "parent",
		items: "p.itemimg",
		stop: function( event, ui ) {
			//$('#thpr').html('');
			//pImages();
		}
	});

	$( "#mtexts").sortable({
			
		items: "div.mtext",
		handle: ".move",
		stop: function( event, ui ) {
			//$('#thpr').html('');
			//pImages();
		}
	});

	$("#mapinput").geocomplete({
		map: "#map",
		location: '<?php echo $parser["d_ADDRESS"]; ?>',
		mapOptions: {
			zoom: 10
		},

		markerOptions: {
			draggable: true
		},

		details: "#pform"
	});

	$("#mapinput").bind("geocode:dragged", function(event, latLng){          
		$("input[name=lat]").val(latLng.lat());
		$("input[name=lng]").val(latLng.lng());
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'latLng': latLng }, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) 
			{
				console.log(results);
				if (results[0])
				{
					var faddr = results[0].formatted_address;
					$("#mapinput").val(faddr);
					$("input[name=formatted_address]").val(faddr); 
				}
			}
		});
	});

	$("#mapinput").bind("geocode:result", function(event, result){          
		$("input[name=lat]").val(result.geometry.location.lat());
		$("input[name=lng]").val(result.geometry.location.lng()); 
		$("input[name=formatted_address]").val(result.formatted_address); 
	});


});

</script>