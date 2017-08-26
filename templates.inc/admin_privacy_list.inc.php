<div class="sub-menu">
	<div class="sub-menu-container">
    	<a href="javascript:void();" class="selected"><?php echo (voc('ПОЛЬЗОВАТЕЛИ')); ?></a>
        <a href="javascript:addAdmin();"><?php echo (voc('ДОБАВИТЬ ПОЛЬЗОВАТЕЛЯ')); ?></a>
    </div>
</div>
<div class="main">
	<div class="sort">
    	<select name="level" id="level" onchange="getAdmins()">
        	<option value="all"><?php echo (voc('Все пользователи')); ?></option>
            <option value="0"><?php echo (voc('Клиенты')); ?></option>
            <option value="10"><?php echo (voc('Менеджеры')); ?></option>
            <option value="100"><?php echo (voc('Админы')); ?></option>
        </select>
    </div> 
    	<div class="user-items-table">
        	<div class="table-header">
            	<div class="cell-1"><?php echo (voc('ИМЯ ПОЛЬЗОВАТЕЛЯ')); ?></div>
                <div class="cell-2"><?php echo (voc('ЭЛ. почта')); ?></div>
                <div class="cell-3"><?php echo (voc('ТИП')); ?></div>
                <div class="cell-4"><?php echo (voc('ДАТА СОЗДАНИЯ')); ?></div>
                <div class="cell-5"><?php echo (voc('СТАТУС')); ?></div>
                <div class="cell-6"><?php echo (voc('ДЕЙСТВИЯ')); ?></div>
            </div>
			<div class="add-line">
            	<div class="cell-1">
					<a href="javascript:addAdmin();" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /> <?php echo (voc('ДОБАВИТЬ ПОЛЬЗОВАТЕЛЯ')); ?></a>
                </div>
            </div>
            <div class="user-items border" id="admins">
				
            </div>
            <div class="add-line">
            	<div class="cell-1">
					<a href="javascript:addAdmin();" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /> <?php echo (voc('ДОБАВИТЬ ПОЛЬЗОВАТЕЛЯ')); ?></a>
                </div>
            </div>
           
        </div>
    
</div>

<script>

function showTab(id)
{
	$('.ptab').hide();
	$('.ptab'+id).fadeIn();
}

function editAdmin(id)
{
	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/manager/privacy/editajax/'+id,
		data: ''
	}).done(function(data) {
		$('#pcontent').html(data);
		$('#overley').fadeIn();
		$('#popup').fadeIn();		
	});
}

function addAdmin()
{
	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/manager/privacy/addajax/',
		data: ''
	}).done(function(data) {
		$('#pcontent').html(data);
		$('#overley').fadeIn();
		$('#popup').fadeIn();		
	});
}

function deleteAdmin(id)
{
	if (confirm('Удалить запись?'))
	{
		$.ajax({
			type: 'POST',
			url: '/<?php echo (cLANG); ?>/manager/privacy/deleteajax/'+id,
			data: ''
		}).done(function(data) {
			$('#admin'+id).slideUp(function() { $(this).remove(); });
		});
	}
}

function saveAdmin(url, form)
{
	$('#popup').fadeOut('normal', function() {
		var p = $('#'+form).serialize();
		$.ajax({
			type: 'POST',
			url: url,
			data: p
		}).done(function(data) {
			closePopup();
			getAdmins();
		});
	});
}

function postAdmin(url, form)
{
	$('#popup').fadeOut('normal', function() {
		var p = $('#'+form).serialize();
		$.ajax({
			type: 'POST',
			url: url,
			data: p
		}).done(function(data) {
			closePopup();
			getAdmins();
		});
	});
}

function getAdmins()
{
	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/manager/privacy/listajax/',
		data: 'level='+$('#level').val()
	}).done(function(data) {
		$('#admins').html(data);
	});
}

$(document).ready(function() {
	getAdmins();
	
});

</script>