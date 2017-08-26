<style>
.mtext { float: left; width: 99%; }
</style>
<div class="sub-menu">
	<div class="sub-menu-container">
    	<a href="/<?php echo (cLANG); ?>/manager/catalogue/"><?php echo (voc('Catalogue')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/areas/"><?php echo (voc('Areas')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/atypes/"><?php echo (voc('Areas types')); ?></a>
    </div>
</div>
<div class="main">
	<div class="sort">

	</div> 
	<div class="add-table">
		<div class="table-header">
			<div class="cell-1" style="width: 100%;"><?php echo (voc('Add new object')); ?></div>
		</div>
		<div class="add-item">
			<form id="pform">
			<input type="hidden" name="data" value="1"/>
			<div class="cell-1" style="width: 100%;">
				<h2><?php echo (voc('Information')); ?></h2>
				<div class="add-item-line">
					<div class="half-block">
						<h1>Floor:</h1>
						<input type="text" class="prev" name="floor" value="" />
					</div>
					
					<div class="half-block">
						<h1>Number:</h1>
						<input type="text" class="prev" name="number" value="" />
					</div>         
					
					<div class="half-block">
						<h1>Rooms:</h1>
						<input type="text" class="prev" name="rooms" value="" />
					</div>         

					<div class="half-block">
						<h1>Area:</h1>
						<input type="text" class="prev" name="area" value="" />
					</div>         

					<div class="half-block">
						<h1>Price:</h1>
						<input type="text" class="prev" name="price" value="" />
					</div>         
					
					<div class="half-block">
						<h1><?php echo (voc('Status:')); ?></h1>
						<select name="status">
							<option value="1">Свободна</option>
							<option value="0">Продана</option>
							<option value="2">Резервация</option>
						</select>
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

<div id="upimgs" style="display: none;"><div>
<div id="upimgs2" style="display: none;"><div>

<script>

var tnm = 0;

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
		url: '/<?php echo (cLANG); ?>/manager/catalogue/addajax/',
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
	$('#up'+file.id+' img').attr('src', '/getimage.php?id=2'+obj.typeid+'1'+obj.id);
	$('#up'+file.id).data('img', obj.id);
	$('#up'+file.id).data('type', obj.typeid);
	$('#itemimg'+file.id).val(obj.id);
}

DJS.progressUpImages =  function(up, file) {
	$('#up'+file.id+' a.upproc').html(file.percent+'%');
}

DJS.addUpImages2 =  function(up, file) {
	var h = '<p class="itemimg" data-type="" id="up'+file.id+'" data-img=""><a class="del" href="javascript:delImage(\''+file.id+'\', \'\');"></a><input type="hidden" name="itemicons[]" value="" id="itemicon'+file.id+'" /><img src="" style="display:none;" /><a class="upproc" style="margin-left: 11px; margin-top: 20px;">0%</a></p>';
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
	if (obj.typeid!='9')
	{
		$('#up'+file.id+' img').attr('src', '/getimage.php?id=9'+obj.typeid+'1'+obj.id);
	}
	else
	{
		$('#up'+file.id+' img').attr('src', '/loads/servicesicons/'+obj.id+'.svg');
	}
	$('#up'+file.id).data('img', obj.id);
	$('#up'+file.id).data('type', obj.typeid);
	$('#itemicon'+file.id).val(obj.id);
}

DJS.progressUpImages2 =  function(up, file) {
	$('#up'+file.id+' a.upproc').html(file.percent+'%');
}

function delImage(id, p)
{
	$('#up'+id).remove();	
}
function delImageT(t, id, p)
{
	$('#up_'+t+'_'+id).remove();	
}

$(document).ready(function() {

	$('.dtime').datetimepicker({
							firstDay : 1,
							dateFormat: 'dd.mm.yy',
							timeFormat: 'HH:mm',
							showButtonPanel: true  });

	//addUploader(new Array('item', 'addimagebutt', 'upimgs', 'addUpImages', 'uploadUpImages', 'progressUpImages', '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/addimage/'));

	//addUploader(new Array('item2', 'addiconbutt', 'upimgs2', 'addUpImages2', 'uploadUpImages2', 'progressUpImages2', '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/addicon/'));

});

</script>