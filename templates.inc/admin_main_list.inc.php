<div class="sub-menu">
	<div class="sub-menu-container">
    	<a href="/<?php echo (cLANG); ?>/manager/main/" class="selected"><?php echo (voc('Sliders')); ?></a>
		<a href="javascript:addRow('/<?php echo (cLANG); ?>/manager/main/add/')"><?php echo (voc('Add new slide')); ?></a>
    </div>
</div>
<div class="main">
	<div class="sort">
		
    </div> 

		<div class="user-items-table">
        	<div class="table-header">
            	<div class="cell-1" style="width: 70%;"><?php echo (voc('Sliders')); ?></div>
                <div class="cell-6" style="width: 20%;"><?php echo (voc('Actions')); ?></div>
            </div>
			<div class="add-line">
            	<div class="cell-1">
					<a href="javascript:addRow('/<?php echo (cLANG); ?>/manager/main/add/')" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /><?php echo (voc('Add new slide')); ?></a>
                </div>
            </div>
            <div class="user-items border" id="items">
            </div>
            <div class="add-line">
            	<div class="cell-1">
					<a href="javascript:addRow('/<?php echo (cLANG); ?>/manager/main/add/')" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /><?php echo (voc('Add new slide')); ?></a>
                </div>
            </div>
           
        </div>		

    	
    
</div>


<script>

function saveSettings(form)
{
	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/manager/main/settings/',
		data: $('#'+form).serialize()
	}).done(function(data) {
		$('#overley').fadeOut();
		$('#popup').fadeOut();
	});
}



function showProducts()
{
	showRows('/<?php echo (cLANG); ?>/manager/main/listajax/', '');
}


$(document).ready(function() {
	showProducts();
});
</script>