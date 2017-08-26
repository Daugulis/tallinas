<style>
.mtext { float: left; width: 99%; }
</style>
<div class="sub-menu">
	<div class="sub-menu-container">
    	<a href="/<?php echo (cLANG); ?>/manager/tree/"><?php echo (voc('Tree')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/tree/add/" class="selected"><?php echo (voc('Add new tree')); ?></a>
    </div>
</div>
<div class="main">
	<div class="sort">

	</div> 
	<div class="add-table">
		<div class="table-header">
			<div class="cell-1" style="width: 100%;"><?php echo (voc('Add new tree')); ?></div>
		</div>
		<div class="add-item">
			<form id="pform">
			<input type="hidden" name="data" value="1"/>
			<div class="cell-1" style="width: 100%;">
				<h2><?php echo (voc('Information')); ?></h2>
				<div class="add-item-line">
					<?php foreach($parser["langs"] as $_key_1=>$_var_1)
{
 ?>
					<div class="half-block" style="width: 33%">
						<h1><?php echo (voc('Title')); ?> (<?php echo $parser["langs"][$_key_1]["SHORTNAME"]; ?>):</h1>
						<input type="text" class="prev" id="name_<?php echo $parser["langs"][$_key_1]["ID"]; ?>" name="name_<?php echo $parser["langs"][$_key_1]["ID"]; ?>" value="" />
					</div>         
					<?php 
}
 ?>
					<?php foreach($parser["langs"] as $_key_2=>$_var_2)
{
 ?>
					<div class="half-block" style="width: 33%">
						<h1><?php echo (voc('URL')); ?> (<?php echo $parser["langs"][$_key_2]["SHORTNAME"]; ?>):</h1>
						<input type="text" class="prev" id="url_<?php echo $parser["langs"][$_key_2]["ID"]; ?>" name="url_<?php echo $parser["langs"][$_key_2]["ID"]; ?>" value="" />
					</div>         
					<?php 
}
 ?>
					<div class="half-block" style="width: 33%">
						<h1><?php echo (voc('Parent:')); ?></h1>
						<select name="pid">
							<option value="0">-</option>
							<?php foreach($parser["tr"] as $_key_3=>$_var_3)
{
 ?>
							<option value="<?php echo $parser["tr"][$_key_3]["ID"]; ?>"><?php echo $parser["tr"][$_key_3]["NAME"]; ?></option>
							<?php 
}
 ?>
						</select>
					</div>
					<div class="half-block" style="width: 33%">
						<h1><?php echo (voc('Type:')); ?></h1>
						<select name="type">
							<option value="1"><?php echo (voc('text')); ?></option>
							<option value="2"><?php echo (voc('catalogue')); ?></option>
							<option value="3"><?php echo (voc('galley')); ?></option>
							<option value="4"><?php echo (voc('contacts')); ?></option>
							<option value="5"><?php echo (voc('map')); ?></option>
							<option value="7"><?php echo (voc('popup')); ?></option>
						</select>
					</div>
					
					<div class="half-block" style="width: 33%">
						<h1><?php echo (voc('Status:')); ?></h1>
						<select name="status">
							<option value="1"><?php echo (voc('enable')); ?></option>
							<option value="0"><?php echo (voc('disable')); ?></option>
						</select>
					</div>		
				</div>

				<h2><?php echo (voc('SEO')); ?></h2>
				<div class="add-item-line">
					<?php foreach($parser["langs"] as $_key_4=>$_var_4)
{
 ?>
					<div class="half-block" style="width: 33%">
						<h1><?php echo (voc('SEO Title')); ?> (<?php echo $parser["langs"][$_key_4]["SHORTNAME"]; ?>):</h1>
						<input type="text" class="prev" id="title_<?php echo $parser["langs"][$_key_4]["ID"]; ?>" name="title_<?php echo $parser["langs"][$_key_4]["ID"]; ?>" value="" />
					</div>         
					<?php 
}
 ?>
					<?php foreach($parser["langs"] as $_key_5=>$_var_5)
{
 ?>
					<div class="half-block" style="width: 33%">
						<h1><?php echo (voc('SEO Keywords')); ?> (<?php echo $parser["langs"][$_key_5]["SHORTNAME"]; ?>):</h1>
						<input type="text" class="prev" id="kw_<?php echo $parser["langs"][$_key_5]["ID"]; ?>" name="kw_<?php echo $parser["langs"][$_key_5]["ID"]; ?>" value="" />
					</div>         
					<?php 
}
 ?>
					<?php foreach($parser["langs"] as $_key_6=>$_var_6)
{
 ?>
					<div class="half-block" style="width: 33%">
						<h1><?php echo (voc('SEO Description')); ?> (<?php echo $parser["langs"][$_key_6]["SHORTNAME"]; ?>):</h1>
						<input type="text" class="prev" id="desc_<?php echo $parser["langs"][$_key_6]["ID"]; ?>" name="desc_<?php echo $parser["langs"][$_key_6]["ID"]; ?>" value="" />
					</div>         
					<?php 
}
 ?>			
				</div>    

				<div style="clear: both;"></div>
				<div>
				<div style="position: relative; clear: both;">
				<div class="mtexts" id="mtexts">
					
						
					
				</div>
				</div>
				</div>
				<div style="clear: both;"></div>

				<h2><?php echo (voc('Добавить блок')); ?>:</h2>
				<div class="add-item-line">
					<a href="javascript:addBlock('text');" class="add-category" style="clear:left; margin-top:8px;"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /><?php echo (voc('Добавить текстовой блок')); ?></a>
					<a href="javascript:addBlock('foto');" class="add-category" style="clear:left; margin-top:8px;"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /><?php echo (voc('Добавить фото блок')); ?></a>
				</div>

				<div style="clear: both;"></div>
				<h2><?php echo (voc('Images')); ?>:</h2>
				<div class="add-item-line">
					<div class="add-item-img-container" id="itemimg">
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

<div id="upimgs" style="display: none;"><div>
<div id="upimgs2" style="display: none;"><div>
<div id="upimgs3" style="display: none;"><div>

<script>

var tnm = 0;

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

		var tt = '';
		<?php foreach($parser["langs"] as $_key_7=>$_var_7)
{
 ?>
		tt = tt + '<div class="full-block" style="width: 33%;"><h1 style="padding: 10px;"><?php echo (voc('Title')); ?> (<?php echo $parser["langs"][$_key_7]["SHORTNAME"]; ?>)</h1><input  style="text-transform: none;" name="bname['+tnm+'][<?php echo $parser["langs"][$_key_7]["ID"]; ?>]" /></div>';
		<?php 
}
 ?>

		var t = '<div class="mtext" id="mtext'+tnm+'"><h2><?php echo (voc('Text')); ?><a style="cursor: pointer; margin-right: 20px;"><img class="move" src="/admin/img/icon-move-small.png" border="0" alt="" /></a><a href="javascript:deleteBlock(\''+tnm+'\')" style="cursor: pointer;"><img  src="/admin/img/icon-close-small.png" border="0" alt="" /></a></h2><div class="add-item-line">'+tt+'</div><div class="add-item-line"><input type="hidden" name="block[]" value="'+tnm+'" />';
		<?php foreach($parser["langs"] as $_key_8=>$_var_8)
{
 ?>
		t = t + '<div class="full-block" style="width: 33%;"><h1 style="padding: 10px;"><?php echo (voc('Text')); ?> (<?php echo $parser["langs"][$_key_8]["SHORTNAME"]; ?>)</h1><textarea class="prev"  style="height: 160px; text-transform: none;" name="text['+tnm+'][<?php echo $parser["langs"][$_key_8]["ID"]; ?>]" id="text_'+tnm+'_<?php echo $parser["langs"][$_key_8]["ID"]; ?>"></textarea></div>';
		<?php 
}
 ?>
		t = t + '</div></div>';
		$('.mtexts').append(t);
		
		<?php foreach($parser["langs"] as $_key_9=>$_var_9)
{
 ?>
		CKEDITOR.replace( 'text_'+tnm+'_<?php echo $parser["langs"][$_key_9]["ID"]; ?>' , {
			toolbar: [ 
				{ name: 'document', items: [ 'Source', '-', 'NewPage' ] }, [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ], { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
				{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
				{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
				{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
				{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
			]
		});
		<?php 
}
 ?>

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
		var t = '<div class="mtext" id="mtext'+tnm+'"><input type="hidden" name="block[]" value="'+tnm+'" /><h2><?php echo (voc('Images')); ?>: <a style="cursor: pointer; margin-right: 20px;"><img class="move" src="/admin/img/icon-move-small.png" border="0" alt="" /></a><a href="javascript:deleteBlock(\''+tnm+'\')" style="cursor: pointer;"><img  src="/admin/img/icon-close-small.png" border="0" alt="" /></a></h2><div class="add-item-line"><div class="add-item-img-container" id="itemimg_'+tnm+'"><p id="addpbut_'+tnm+'"><a id="addimagebutt_'+tnm+'" style="margin-left: 8px;margin-top: 8px;"><img src="/admin/img/icon-green-add-big.png" width="48" height="48" border="0" /></a></p></div></div></div><div id="upimgs_'+tnm+'" style="display: none;"></div>';
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
			$('#up_'+tm+'_'+file.id+' img').attr('src', '/getimage.php?id=1'+obj.typeid+'1'+obj.id);
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
		url: '/<?php echo (cLANG); ?>/manager/tree/addajax/',
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
	var h = '<p class="itemimg itembimg" data-type="" id="up'+file.id+'" data-img=""><a class="del" href="javascript:delImage(\''+file.id+'\', \'\');"></a><input type="hidden" name="itemimg[]" value="" id="itemimg'+file.id+'" /><img src="" style="display:none;" /><a class="upproc" style="margin-left: 11px; margin-top: 20px;">0%</a></p>';
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
	$('#up'+file.id+' img').attr('src', '/getimage.php?id=1'+obj.typeid+'1'+obj.id);
	$('#up'+file.id).data('img', obj.id);
	$('#up'+file.id).data('type', obj.typeid);
	$('#itemimg'+file.id).val(obj.id);
}

DJS.progressUpImages =  function(up, file) {
	$('#up'+file.id+' a.upproc').html(file.percent+'%');
}

DJS.addUpImages3 =  function(up, file) {
	var h = '<p class="itemimg itembimg" data-type="" id="upf'+file.id+'" data-img=""><a class="del" href="javascript:delFiles(\''+file.id+'\', \'\');"></a><input type="hidden" name="itemfiles[]" value="" id="itemfile'+file.id+'" /><img src="" style="display:none;" /><a class="upproc" style="margin-left: 11px; margin-top: 20px;">0%</a></p>';
	$('#addpbut3').before(h);
	$( "#itemfile" ).sortable({
		containment: "parent",
		items: "p.itemimg",
		stop: function( event, ui ) {
			//$('#thpr').html('');
			//pImages();
		}
	});
	$('#itemfile .itemimg').click(function() {
		$('#itemfile .itemimg').removeClass('selb');
		$(this).addClass('selb');
	});
}


DJS.uploadUpImages3 =  function(up, file, resp) {
	var obj = $.parseJSON(resp['response']);
	$('#upf'+file.id+' a.upproc').css('display', 'none');
	$('#upf'+file.id+' a.del').fadeIn();
	$('#upf'+file.id+' img').load(function() {
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
	$('#upf'+file.id+' img').attr('src', '/getimage.php?id=f'+obj.typeid+'1'+obj.id);
	$('#upf'+file.id).data('img', obj.id);
	$('#upf'+file.id).data('type', obj.typeid);
	$('#itemfile'+file.id).val(obj.id);
}

DJS.progressUpImages3 =  function(up, file) {
	$('#upf'+file.id+' a.upproc').html(file.percent+'%');
}

DJS.addUpImages2 =  function(up, file) {
	var h = '<p class="itemimg itembimg" data-type="" id="up'+file.id+'" data-img=""><a class="del" href="javascript:delImage(\''+file.id+'\', \'\');"></a><input type="hidden" name="itemicons[]" value="" id="itemicon'+file.id+'" /><img src="" style="display:none;" /><a class="upproc" style="margin-left: 11px; margin-top: 20px;">0%</a></p>';
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
	$('#up'+file.id+' img').attr('src', '/loads/treeicons/'+obj.id+'.svg');
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

function delFiles(id, p)
{
	$('#upf'+id).remove();	
}

function delIcons(id, p)
{
	$('#upi'+id).remove();	
}

$(document).ready(function() {

	$('.dtime').datetimepicker({
							firstDay : 1,
							dateFormat: 'dd.mm.yy',
							timeFormat: 'HH:mm',
							showButtonPanel: true  });
	
	<?php foreach($parser["langs"] as $_key_10=>$_var_10)
{
 ?>
	/*
	CKEDITOR.replace( 'stext_<?php echo $parser["langs"][$_key_10]["ID"]; ?>' , {
		toolbar: [ 
			{ name: 'document', items: [ 'Source', '-', 'NewPage' ] }, [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ], { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
			{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
			{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
			{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
			{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		]
	});
	CKEDITOR.replace( 'text_<?php echo $parser["langs"][$_key_10]["ID"]; ?>' , {
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

	//addUploader(new Array('item3', 'addfilebutt', 'upimgs3', 'addUpImages3', 'uploadUpImages3', 'progressUpImages3', '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/addfile/'));

});

</script>