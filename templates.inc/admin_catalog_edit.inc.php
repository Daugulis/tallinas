<style>
.mtext { float: left; width: 99%; }
</style>
<div class="sub-menu">
	<div class="sub-menu-container">
    	<a href="/<?php echo (cLANG); ?>/manager/catalogue/" class="selected"><?php echo (voc('Catalogue')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/areas/"><?php echo (voc('Areas')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/atypes/"><?php echo (voc('Areas types')); ?></a>
    </div>
</div>
<div class="main">
	<div class="sort">

	</div> 
	<div class="add-table">
		<div class="table-header">
			<div class="cell-1" style="width: 100%;"><?php echo (voc('Edit object')); ?> - N<?php echo $parser["d_NUMBER"]; ?></div>
		</div>
		<div class="add-item">
			<form id="pform">
			<input type="hidden" name="data" value="1"/>
			<div class="cell-1" style="width: 100%;">
				<h2><?php echo (voc('Information')); ?></h2>
				<div class="add-item-line">
					
					<div class="half-block">
						<h1>Floor:</h1>
						<input type="text" class="prev" name="floor" value="<?php echo $parser["d_FLOOR"]; ?>" />
					</div>
					
					<div class="half-block">
						<h1>Number:</h1>
						<input type="text" class="prev" name="number" value="<?php echo $parser["d_NUMBER"]; ?>" />
					</div>         
					
					<div class="half-block">
						<h1>Rooms:</h1>
						<input type="text" class="prev" name="rooms" value="<?php echo $parser["d_ROOMS"]; ?>" />
					</div>         

					<div class="half-block">
						<h1>Area:</h1>
						<input type="text" class="prev" name="area" value="<?php echo $parser["d_AREA"]; ?>" />
					</div>         

					<div class="half-block">
						<h1>Price:</h1>
						<input type="text" class="prev" name="price" value="<?php echo $parser["d_PRICE"]; ?>" />
					</div>         
					
					<div class="half-block">
						<h1><?php echo (voc('Status:')); ?></h1>
						<select name="status">
							<option value="1" <?php if ($parser['d_STATUS']=='1') {?> 	selected <?php } ?> >Свободна</option>
							<option value="0" <?php if ($parser['d_STATUS']=='0') {?> 	selected <?php } ?> >Продана</option>
							<option value="2" <?php if ($parser['d_STATUS']=='2') {?> 	selected <?php } ?> >Резервация</option>
						</select>
					</div>	
						
				</div>  

				<div style="clear: both;"></div>
				<h2><?php echo (voc('Images')); ?> (1-lv; 2-ru; 3-en):</h2>
				<div class="add-item-line">
					<div class="add-item-img-container" id="itemimg">
						<?php foreach($parser["images"] as $_key_1=>$_var_1)
{
 ?>	
						<p class="itemimg itembimg" data-type="<?php echo (getImageType(''.$parser["images"][$_key_1]["TYPE"].'')); ?>" id="up<?php echo $parser["images"][$_key_1]["ID"]; ?>" data-img="<?php echo $parser["images"][$_key_1]["ID"]; ?>"><a style="display: block;" class="del" href="javascript:delImage('<?php echo $parser["images"][$_key_1]["ID"]; ?>', '');"></a><input type="hidden" name="itemimg[]" value="<?php echo $parser["images"][$_key_1]["ID"]; ?>" id="itemimg<?php echo $parser["images"][$_key_1]["ID"]; ?>" /><img src="/48px/pdf.png" alt="<?php echo $parser["images"][$_key_1]["NAME"]; ?>" title="<?php echo $parser["images"][$_key_1]["NAME"]; ?>" /><a class="upproc" style="display: none; margin-left: 11px; margin-top: 20px;">0%</a></p>
						<?php 
}
 ?>
						<p id="addpbut"><a id="addimagebutt" style="margin-left: 8px;margin-top: 8px;"><img src="/admin/img/icon-green-add-big.png" width="48" height="48" border="0" /></a></p>
					</div>
				</div>
				

				
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
		url: '/<?php echo (cLANG); ?>/manager/catalogue/editajax/<?php echo (ID); ?>/',
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
	$('#up'+file.id+' img').attr('src', '/48px/pdf.png');
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
	if (obj.typeid!='9')
	{
		$('#upi'+file.id+' img').attr('src', '/48px/pdf.png');
	}
	else
	{
		$('#upi'+file.id+' img').attr('src', '/48px/pdf.png');
	}
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
function delIcons(id, p)
{
	$('#upi'+id).remove();	
}

$(document).ready(function() {


	addUploader(new Array('item', 'addimagebutt', 'upimgs', 'addUpImages', 'uploadUpImages', 'progressUpImages', '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/addimage/'));

	//addUploader(new Array('item2', 'addiconbutt', 'upimgs2', 'addUpImages2', 'uploadUpImages2', 'progressUpImages2', '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/addicon/'));

	$('.itemimg').each(function() {
		
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


});

</script>