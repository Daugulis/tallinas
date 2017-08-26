<div class="sub-menu">
	<div class="sub-menu-container">
    	<a href="/<?php echo (cLANG); ?>/manager/contacts/" class="selected"><?php echo (voc('Contacts')); ?></a>
    </div>
</div>
<div class="main">
	<div class="sort">
		
		<input type="hidden" name="utype" id="utype" value="<?php echo (UID); ?>">
		
    </div> 

		<div class="user-items-table">
        	<div class="table-header">
            	<div class="cell-1" style="width: 70%;"><?php echo (voc('Contacts')); ?></div>
                <div class="cell-6" style="width: 20%;">ДЕЙСТВИЯ</div>
            </div>
			<div class="add-line">
            	<div class="cell-1">
					<a href="/<?php echo (cLANG); ?>/manager/contacts/add/" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /><?php echo (voc('Add new')); ?></a>
                </div>
            </div>
            <div class="user-items border" id="items">
            </div>
            <div class="add-line">
            	<div class="cell-1">
					<a href="/<?php echo (cLANG); ?>/manager/contacts/add/" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /><?php echo (voc('Add new')); ?></a>
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
			url: '/<?php echo (cLANG); ?>/manager/contacts/deleteajax/'+id,
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
	showRows('/<?php echo (cLANG); ?>/manager/contacts/listajax/', 'utype='+$('#utype').val());
}

function editCompany(id)
{
	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/manager/contacts/editajax/'+id,
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
		url: '/<?php echo (cLANG); ?>/manager/contacts/addajax/',
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