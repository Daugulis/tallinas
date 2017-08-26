<div class="sub-menu">
	<div class="sub-menu-container">
    	<a href="/<?php echo (cLANG); ?>/manager/catalogue/" class="selected"><?php echo (voc('Catalogue')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/areas/"><?php echo (voc('Areas')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/atypes/"><?php echo (voc('Areas types')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/markers/"><?php echo (voc('Markers')); ?></a>
    </div>
</div>
<div class="main">
	<div class="sort">
		
    </div> 

		<div class="user-items-table">
        	<div class="table-header">
            	<div class="cell-1" style="width: 70%;"><?php echo (voc('Objects')); ?></div>
                <div class="cell-6" style="width: 20%;">ДЕЙСТВИЯ</div>
            </div>
			<div class="add-line">
            	<div class="cell-1">
					<a href="/<?php echo (cLANG); ?>/manager/catalogue/add/" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /><?php echo (voc('Add new object')); ?></a>
                </div>
            </div>
            <div class="user-items border" id="items">
            </div>
            <div class="add-line">
            	<div class="cell-1">
					<a href="/<?php echo (cLANG); ?>/manager/catalogue/add/" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /><?php echo (voc('Add new object')); ?></a>
                </div>
            </div>
           
        </div>		

    	
    
</div>


<script>

$('#popup').css('width', '900px');
$('#popup').css('margin-left', '-450px');

function deleteMenu(id)
{
	if (confirm('Удалить запись?'))
	{
		$.ajax({
			type: 'POST',
			url: '/<?php echo (cLANG); ?>/manager/companies/deleteajax/'+id,
			data: ''
		}).done(function(data) {
			$('#item'+id).slideUp(function() { $(this).remove(); 
				$('#items').find('.table-item').each(function(index) {
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


function showServices()
{
	showRows('/<?php echo (cLANG); ?>/manager/catalogue/listajax/', '');
}

function editCompany(id)
{
	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/manager/companies/editajax/'+id,
		data: ''
	}).done(function(data) {
		$('#pcontent').html(data);
		$( ".rdate" ).datepicker({ dateFormat: "dd.mm.yy" });
		$('#overley').fadeIn();
		$('#popup').fadeIn();		
	});
}

function saveCompany(url, form)
{
	$('#popup').fadeOut('normal', function() {
		var p = $('#'+form).serialize();
		$.ajax({
			type: 'POST',
			url: url,
			data: p
		}).done(function(data) {
			closePopup();
			showContacts();
		});
	});
}

function addCompany()
{
	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/manager/companies/addajax/',
		data: ''
	}).done(function(data) {
		$('#pcontent').html(data);
		$( ".rdate" ).datepicker({ dateFormat: "dd.mm.yy" });
		$('#overley').fadeIn();
		$('#popup').fadeIn();		
	});
}

$(document).ready(function() {
	showServices();
});
</script>