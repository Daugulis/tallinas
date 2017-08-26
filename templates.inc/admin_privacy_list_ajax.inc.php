<?php foreach($parser["users"] as $_key_1=>$_var_1)
{
 ?>
<div class="user-items-item" id="admin<?php echo $parser["users"][$_key_1]["ID"]; ?>">
	<div class="cell-1"><div class="vertical vmiddle"><div class="tr"><div class="td"><a href=""><?php echo $parser["users"][$_key_1]["NAME"]; ?> <?php echo $parser["users"][$_key_1]["SURNAME"]; ?></a></div></div></div></div>
	<div class="cell-2"><div class="vertical vmiddle"><div class="tr"><div class="td"><a href=""><?php echo $parser["users"][$_key_1]["EMAIL"]; ?></a></div></div></div></div>
	<div class="cell-3"><div class="vertical vmiddle"><div class="tr"><div class="td">
		<?php if (''.$parser["users"][$_key_1]["GROUP"].''=='0') {?> 	<?php echo (voc('КЛИЕНТ')); ?> <?php } ?> 
		<?php if (''.$parser["users"][$_key_1]["GROUP"].''=='10') {?> 	<?php echo (voc('МЕНЕДЖЕР')); ?> <?php } ?> 
		<?php if (''.$parser["users"][$_key_1]["GROUP"].''=='100') {?> 	<?php echo (voc('АДМИНИСТРАТОР')); ?> <?php } ?> 
	</div></div></div></div>
	<div class="cell-4"><div class="vertical vmiddle"><div class="tr"><div class="td"><?php echo $parser["users"][$_key_1]["CDATE"]; ?></div></div></div></div>
	<div class="cell-5"><div class="vertical vmiddle"><div class="tr"><div class="td"><?php if (''.$parser["users"][$_key_1]["ENABLED"].''=='1') {?> 	<?php echo (voc('активный')); ?> <?php } ?> <?php if (''.$parser["users"][$_key_1]["ENABLED"].''!='1') {?> 	<?php echo (voc('неактивный')); ?> <?php } ?> </div></div></div></div>
	<div class="cell-6">
		<a href="javascript:editAdmin('<?php echo $parser["users"][$_key_1]["ID"]; ?>');"><img src="/admin/img/icon-orange-edit.png" border="0" alt="" /></a>
		<a href="javascript:deleteAdmin('<?php echo $parser["users"][$_key_1]["ID"]; ?>');"><img src="/admin/img/icon-red-delete.png" border="0" alt="" /></a>
	</div>
</div>
<?php 
}
 ?>