<style>
#itemimg p { float: left; clear: none; }
#itemfiles p { float: left; clear: none; }
</style>
<form id="addform">
<input type="hidden" name="data" value="1" />
<div class="popup-header">
	<a href="javascript:void();"><?php echo (voc('language_edit')); ?> - <?php echo (htmlspecialchars($parser['d_NAME'])); ?></a>
</div>
<div class="popup-main">
	<div class="popup-main-block">
		<p><?php echo (voc('language_name')); ?>:</p>
		<input name="name" type="text" value="<?php echo (htmlspecialchars($parser['d_NAME'])); ?>" />
	</div>
	<div class="popup-main-block">
		<p><?php echo (voc('language_site_name')); ?>:</p>
		<input name="sname" type="text" value="<?php echo (htmlspecialchars($parser['d_SNAME'])); ?>" />
	</div>
	<div class="popup-main-block">
		<p><?php echo (voc('language_url')); ?>:</p>
		<input name="url" type="text" value="<?php echo (htmlspecialchars($parser['d_URL'])); ?>" />
	</div>
	<div class="popup-main-block">
		<p><?php echo (voc('use_as_default')); ?></p>
		<select name="def">			
			<option value="1" <?php if ($parser['d_DEF']=='1') {?> 	selected <?php } ?> ><?php echo (voc('yes')); ?></option>
			<option value="0" <?php if ($parser['d_DEF']=='0') {?> 	selected <?php } ?> ><?php echo (voc('no')); ?></option>						
		</select>
	</div>
	<div class="popup-main-block">
		<p><?php echo (voc('status')); ?></p>
		<select name="status">			
			<option value="1" <?php if ($parser['d_STATUS']=='1') {?> 	selected <?php } ?> ><?php echo (voc('enabled')); ?></option>
			<option value="0" <?php if ($parser['d_STATUS']=='0') {?> 	selected <?php } ?> ><?php echo (voc('disabled')); ?></option>						
		</select>
	</div>
	<div style="clear: both;"></div>
	<div class="popup-main-block" style="width: 600px !important;">
		<p><?php echo (voc('Images')); ?>:</p>
		<div class="add-item-img-container" id="itemimg">
			<?php foreach($parser["images"] as $_key_1=>$_var_1)
{
 ?>	
			<p class="itemimg" data-type="<?php echo (getImageType(''.$parser["images"][$_key_1]["TYPE"].'')); ?>" id="up<?php echo $parser["images"][$_key_1]["ID"]; ?>" data-img="<?php echo $parser["images"][$_key_1]["ID"]; ?>"><a style="display: block;" class="del" href="javascript:delImage('<?php echo $parser["images"][$_key_1]["ID"]; ?>', '');"></a><input type="hidden" name="itemimg[]" value="<?php echo $parser["images"][$_key_1]["ID"]; ?>" id="itemimg<?php echo $parser["images"][$_key_1]["ID"]; ?>" /><img src="/loads/languages/<?php echo $parser["images"][$_key_1]["ID"]; ?>.<?php echo $parser["images"][$_key_1]["EXT"]; ?>" /><a class="upproc" style="display: none; margin-left: 11px; margin-top: 20px;">0%</a></p>
			<?php 
}
 ?>
			<p id="addpbut"><a id="addimagebutt" style="margin-left: 8px;margin-top: 8px;"><img src="/admin/img/icon-green-add-big.png" width="48" height="48" border="0" /></a></p>
		</div>
	</div>
	<a class="pp" href="javascript:saveRow('/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/editajax/<?php echo (ID); ?>/', 'addform', '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/listajax/', '');">&nbsp; &nbsp; <?php echo (voc('Save data')); ?> &nbsp; &nbsp;</a>
</div>
</form>

<div id="upimgs" style="display: none;"><div>
<div id="upimgs2" style="display: none;"><div>

<script>
DJS.addUpImages =  function(up, file) {
	var h = '<p class="itemimg" data-type="" id="up'+file.id+'" data-img=""><a class="del" href="javascript:delImage(\''+file.id+'\', \'\');"></a><input type="hidden" name="itemimg[]" value="" id="itemimg'+file.id+'" /><img src="" style="display:none;" /><a class="upproc" style="margin-left: 11px; margin-top: 20px;">0%</a></p>';
	$('#addpbut').before(h);
	$( "#itemimg" ).sortable({
		containment: "parent",
		items: "p.itemimg"
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
	$('#up'+file.id+' img').attr('src', '/getimage.php?id=d'+obj.typeid+'1'+obj.id);
	$('#up'+file.id).data('img', obj.id);
	$('#up'+file.id).data('type', obj.typeid);
	$('#itemimg'+file.id).val(obj.id);
}

DJS.progressUpImages =  function(up, file) {
	$('#up'+file.id+' a.upproc').html(file.percent+'%');
}

function delImage(id, p)
{
	$('#up'+id).remove();	
}
function delFile(id, p)
{
	$('#file'+id).remove();	
}
addUploader(new Array('item', 'addimagebutt', 'upimgs', 'addUpImages', 'uploadUpImages', 'progressUpImages', '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/addimage/'));


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
	items: "p.itemimg"
});

$( "#itemfiles" ).sortable({
	containment: "parent",
	items: "p.itemimg"
});
</script>