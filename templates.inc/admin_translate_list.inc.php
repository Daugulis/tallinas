<style>
.popup-main       { float:left; width:100%; padding-top:5px; padding-bottom:15px; }
.popup-main-block { float:left; width:46%; padding-left:4%; }
.popup-main p     { float:left; margin:0px; padding:0px; width:100%; text-align:left; font-size:15px; margin-top:10px; clear:left; }
.popup-main input { float:left; font-family:'MyriadProCondensed'; text-align:left; padding:10px; padding-left:2%; padding-right:2%; font-size:15px; border:1px solid #d5d5d5; width:88%; position:relative; margin-top:10px; clear:left;
					text-transform:uppercase; outline:none; }
.popup-main select{ float:left; font-family:'MyriadProCondensed'; margin:0px; padding:0px; text-align:left; padding:10px; padding-bottom:9px; padding-top:9px; padding-left:2%; padding-right:2%; font-size:15px; border:1px solid #d5d5d5; width:92.8%;
					position:relative; margin-top:10px; clear:left; text-transform:uppercase; outline:none; }
.popup-main a     { float:left; width:100px; height:29px; padding-top:9px; border:1px solid #dbdbdb; border-radius:4px; clear:left; text-align:center; text-decoration:none; color:#000; position:relative; left:50%; margin-left:-51px; margin-top:15px;
				    background:#ffffff; background:-moz-linear-gradient(top,  #ffffff 0%, #e9e9e9 100%); 
			  		background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#e9e9e9)); background:-webkit-linear-gradient(top,  #ffffff 0%,#e9e9e9 100%); 
			  		background:-o-linear-gradient(top,  #ffffff 0%,#e9e9e9 100%); background:-ms-linear-gradient(top,  #ffffff 0%,#e9e9e9 100%); 
			 	 	background:linear-gradient(to bottom,  #ffffff 0%,#e9e9e9 100%); filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e9e9e9',GradientType=0 ); }
.popup-tr-line            { float:left; width:100%; }
.popup-tr-line div.popup-main-block { float:left; width:180px;}
.popup-main-block img     { float:left; margin-top:17px; margin-right:10px; }
.short-input              { width:70% !important; float:left; clear:none !important; padding-left:6% !important; }
.popup-action-block       { float:left; width:100px; padding:0px; margin:0px; text-align:left; margin-left:20px; }
.popup-action-block a     { background:none !important; margin:0px; padding:0px !important; border:none !important; width:32px !important; height:auto; float:left !important; clear:none !important; text-align:left; left:0%; margin-top:12px; }
.popup-action-block label { position:relative; float:left; width:32px; cursor:pointer; margin-right:10px; }
.popup-action-block input { width:13px; height:13px; margin:0px; padding:0px; position:absolute; left:10px; top:22px; cursor:pointer; }

</style>

<div class="sub-menu">
	<div class="sub-menu-container">
    	<a href="" class="selected"><?php echo (voc('Переводы')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/languages/"><?php echo (voc('languages')); ?></a>
    </div>
</div>
<div class="main">

	<div class="sort">
    	<select id="vtype" onchange="getVocs(this.value)">
        	<option value="1"><?php echo (voc('Перевод слов на сайте')); ?></option>
            <option value="2"><?php echo (voc('Перевод слов админ панели')); ?></option>
        </select>
        <label><input type="text" /><a href="" class="search-icon"></a></label>
    </div>
    	<div class="transalte-items-table">
        	<div class="table-header">
            	<div class="cell-1" style="width: 50%;"><?php echo (voc('Слова / фразы')); ?></div>
                <div class="cell-2" style="width: 20%;"><?php echo (voc('ПЕреведенные слова')); ?></div>
				<div class="cell-2" style="width: 20%;"><?php echo (voc('Действия')); ?></div>
            </div>
            <div class="add-line">
            	<div class="cell-1">
					<a href="javascript:addLang();" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /> <?php echo (voc('ДОБАВИТЬ Язык')); ?></a>
					<a href="javascript:openLangs()" class="edit-category"><img src="/admin/img/icon-edit-small.png" width="16" height="16" border="0" alt="" /> <?php echo (voc('Настройки языков')); ?></a>
                </div>
            </div>
            <div id="vocs">
			</div>
			<div class="add-line">
            	<div class="cell-1">
					<a href="javascript:addLang();" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /> <?php echo (voc('ДОБАВИТЬ Язык')); ?></a>
					<a href="javascript:openLangs()" class="edit-category"><img src="/admin/img/icon-edit-small.png" width="16" height="16" border="0" alt="" /> <?php echo (voc('Настройки языков')); ?></a>
                </div>
            </div>          
        </div>    
</div>

<script>

function showAdd()
{
	$('#lsettings').hide();
	$('#ladd').fadeIn();
	$('.popup-header a').removeClass('current');
	$('.popup-header a').eq(0).addClass('current');
}

function showSets()
{
	$('#lsettings').fadeIn();
	$('#ladd').hide();
	$('.popup-header a').removeClass('current');
	$('.popup-header a').eq(1).addClass('current');
}

function translate(id)
{
	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/manager/translate/editajax/'+id,
		data: ''
	}).done(function(data) {
		$('#pcontent').html(data);
		$('#overley').fadeIn();
		$('#popup').fadeIn();		
	});
}

function openLangs()
{
	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/manager/translate/settings/',
		data: 'active=2'
	}).done(function(data) {
		$('#pcontent').html(data);
		$('#overley').fadeIn();
		$('#popup').fadeIn();		
	});
}

function addLang()
{
	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/manager/translate/settings/',
		data: 'active=1'
	}).done(function(data) {
		$('#pcontent').html(data);
		$('#overley').fadeIn();
		$('#popup').fadeIn();		
	});
}


function getVocs(id)
{
	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/manager/translate/listajax/'+id+'/',
		data: ''
	}).done(function(data) {
		$('#vocs').html(data);
	});
}

function saveLangData(url, form)
{
	$('#popup').fadeOut('normal', function() {
		
			closePopup();
		
	});
}

function saveVoc(url, form)
{
	$('#popup').fadeOut('normal', function() {
		var p = $('#'+form).serialize();
		$.ajax({
			type: 'POST',
			url: url,
			data: p
		}).done(function(data) {
			closePopup();
			getVocs($('#vtype').val());
		});
	});
}

function deleteVocs(id)
{
	if (confirm('Удалить запись?'))
	{
		$.ajax({
			type: 'POST',
			url: '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/deleteajax/'+id,
			data: ''
		}).done(function(data) {
			$('#item'+id).slideUp(function() { $(this).remove(); 
				$('#vocs').find('.transalte-item').each(function(index) {
					if (index/2==Math.ceil(index/2))
					{
						$(this).addClass('grey');
					}
					else
					{
						$(this).removeClass('grey');
					}
				});
			});
		});
	}
}

$(document).ready(function() {
	getVocs('1');
});
</script>