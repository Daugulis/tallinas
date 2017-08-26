<form id="addform">
<input type="hidden" name="data" value="1" />
<div class="popup-header">
	<a href="javascript:void();"><?php echo (voc('Edit')); ?> - <?php echo (getVFValue('d_name', LANG)); ?></a>
</div>
<div class="popup-main">
	<?php foreach($parser["langs"] as $_key_1=>$_var_1)
{
 ?>
	<div class="popup-main-block">
		<p><?php echo (voc('Title')); ?> (<?php echo $parser["langs"][$_key_1]["SHORTNAME"]; ?>):</p>
		<input name="name_<?php echo $parser["langs"][$_key_1]["ID"]; ?>" type="text" value="<?php echo (htmlspecialchars(getVFValue('d_name', ''.$parser["langs"][$_key_1]["ID"].''))); ?>" />
	</div>
	<?php 
}
 ?>
	<div class="popup-main-block">
		<p><?php echo (voc('Status:')); ?></p>
		<select name="status">			
			<option value="1" <?php if ($parser['d_STATUS']=='1') {?> 	selected <?php } ?> ><?php echo (voc('Enable')); ?></option>
			<option value="0" <?php if ($parser['d_STATUS']=='0') {?> 	selected <?php } ?> ><?php echo (voc('Disable')); ?></option>						
		</select>
	</div>
	<a class="pp" href="javascript:saveRow('/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/editajax/<?php echo (ID); ?>/', 'addform', '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/listajax/', '');">&nbsp; &nbsp; <?php echo (voc('Save data')); ?> &nbsp; &nbsp;</a>
</div>
</form>