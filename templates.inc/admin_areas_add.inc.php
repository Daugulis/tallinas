<form id="addform">
<input type="hidden" name="data" value="1" />
<div class="popup-header">
	<a href="javascript:void();"><?php echo (voc('Add new')); ?></a>
</div>
<div class="popup-main">
	<div class="popup-main-block">
		<p><?php echo (voc('Number:')); ?></p>
		<select name="cid">			
			<?php foreach($parser["numbers"] as $_key_1=>$_var_1)
{
 ?>
			<option value="<?php echo $parser["numbers"][$_key_1]["ID"]; ?>"><?php echo $parser["numbers"][$_key_1]["NUMBER"]; ?></option>
			<?php 
}
 ?>
		</select>
	</div>
	<div class="popup-main-block">
		<p><?php echo (voc('Type:')); ?></p>
		<select name="tid">			
			<?php foreach($parser["atypes"] as $_key_2=>$_var_2)
{
 ?>
			<option value="<?php echo $parser["atypes"][$_key_2]["ID"]; ?>"><?php echo $parser["atypes"][$_key_2]["NAME"]; ?></option>
			<?php 
}
 ?>
		</select>
	</div>
	<div class="popup-main-block">
		<p><?php echo (voc('Room')); ?>:</p>
		<input name="num" type="text" />
	</div>
	<div class="popup-main-block">
		<p><?php echo (voc('Area')); ?>:</p>
		<input name="area" type="text" />
	</div>
	<div class="popup-main-block">
		<p><?php echo (voc('Status:')); ?></p>
		<select name="status">			
			<option value="1"><?php echo (voc('Enable')); ?></option>
			<option value="0"><?php echo (voc('Disable')); ?></option>						
		</select>
	</div>
	<div class="popup-main-block" style="width: 100%;">
		<p><?php echo (voc('Poly')); ?>:</p>
		<input name="cords" type="text" />
	</div>
	<a class="pp" href="javascript:saveRow('/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/addajax/', 'addform', '/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/listajax/', '');">&nbsp; &nbsp; <?php echo (voc('Save data')); ?> &nbsp; &nbsp;</a>
</div>
</form>