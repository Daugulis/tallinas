<div class="sub-menu">
	<div class="sub-menu-container">
    	<a href="/<?php echo (cLANG); ?>/manager/translate"><?php echo (voc('Переводы')); ?></a>
		<a href="/<?php echo (cLANG); ?>/manager/languages/" class="selected"><?php echo (voc('languages')); ?></a>
    </div>
</div>
<div class="main">
	<div class="sort">
    </div> 
	<div class="user-items-table">
		<div class="table-header">
			<div class="cell-1" style="width: 20%;"><?php echo (voc('language_name')); ?></div>
			<div class="cell-1" style="width: 20%;"><?php echo (voc('language_site_name')); ?></div>
			<div class="cell-1" style="width: 20%;"><?php echo (voc('language_url')); ?></div>
			<div class="cell-1" style="width: 10%;"><?php echo (voc('language_icon')); ?></div>
			<div class="cell-6" style="width: 20%;"><?php echo (voc('actions')); ?></div>
		</div>
		<div class="add-line">
			<div class="cell-1">
				<a href="javascript:addRow('/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/add/')" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /><?php echo (voc('add_new_language')); ?></a>
			</div>
		</div>
		<div class="user-items border" id="items">
		</div>
		<div class="add-line">
			<div class="cell-1">
				<a href="javascript:addRow('/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/add/')" class="add-category"><img src="/admin/img/icon-add-small.png" width="16" height="16" border="0" alt="" /><?php echo (voc('add_new_language')); ?></a>
			</div>
		</div>
	</div>		
</div>


<script>


function showProducts()
{
	showRows('/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/listajax/', '');
}


$(document).ready(function() {
	showProducts();
});
</script>