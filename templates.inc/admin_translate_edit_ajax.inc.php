<form id="addform">
<input type="hidden" name="data" value="1" />
<div class="popup-header">
	<a href="javascript:showTab('1');">Основная информация</a>
</div>
<div class="popup-main">
	<div id="pinfo" class="ptab ptab1">
		<div class="popup-main-block" style="width: 600px;">
			<p><?php echo (voc('Текстовая метка')); ?>:</p>
			<p style="color: #757575;"><?php echo $parser["d_TRANS"]; ?></p>
		</div>
		<?php foreach($parser["langs"] as $_key_1=>$_var_1)
{
 ?>
		<div class="popup-main-block" style="width: 600px;">
			<p><?php echo (voc('Перевод')); ?> (<?php echo $parser["langs"][$_key_1]["SHORTNAME"]; ?>):</p>
			<textarea name="name_<?php echo $parser["langs"][$_key_1]["ID"]; ?>"><?php echo (getVFValue('d_name', ''.$parser["langs"][$_key_1]["ID"].'')); ?></textarea>
		</div>
		<?php 
}
 ?>		
	</div>
	<a class="pp" href="javascript:saveVoc('/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/<?php echo (TASK); ?>/<?php echo (ID); ?>/', 'addform');">Сохранить</a>
</div>
</form>