<div class="sub-menu">
	<div class="sub-menu-container">
    	<a href="/<?php echo (cLANG); ?>/manager/catalogue/"><?php echo (voc('Catalogue')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/areas/"><?php echo (voc('Areas')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/atypes/" class="selected"><?php echo (voc('Areas types')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/markers/"><?php echo (voc('Markers')); ?></a>
    </div>
</div>
<div class="main">
	<div class="sort">
		
    </div> 

		<div class="user-items-table">
        	<div class="table-header">
            	<div class="cell-1" style="width: 70%;"><?php echo (voc('Title')); ?></div>
                <div class="cell-6" style="width: 20%;"><?php echo (voc('Actions')); ?></div>
            </div>
			<div class="add-line">
            	<div class="cell-1">
					<a href="javascript:addRow('/<?php echo (cLANG); ?>/manager/atypes/add/')" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /><?php echo (voc('Add new')); ?></a>
                </div>
            </div>
            <div class="user-items border" id="items">
            </div>
            <div class="add-line">
            	<div class="cell-1">
					<a href="javascript:addRow('/<?php echo (cLANG); ?>/manager/atypes/add/')" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /><?php echo (voc('Add new')); ?></a>
                </div>
            </div>
           
        </div>		

    	
    
</div>


<script>

$('#popup').css('width', '900px');
$('#popup').css('margin-left', '-450px');


function showCategories()
{
	showRows('/<?php echo (cLANG); ?>/manager/atypes/listajax/', '');
}


$(document).ready(function() {
	showCategories();
});
</script>