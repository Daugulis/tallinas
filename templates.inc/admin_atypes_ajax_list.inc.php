<form id="iform">
<input type="hidden" id="lefturl" value="/<?php echo (cLANG); ?>/manager/atypes/setleft/">
<?php foreach($parser["items"] as $_key_1=>$_var_1)
{
 ?>
<div class="user-items-item <?php if (ceil(intval(''.$parser["items"][$_key_1]["num"].'')/2)!=intval(''.$parser["items"][$_key_1]["num"].'')/2) {?> 	grey <?php } ?> " id="item<?php echo $parser["items"][$_key_1]["ID"]; ?>">
	<input type="hidden" name="items[]" value="<?php echo $parser["items"][$_key_1]["ID"]; ?>" />
	<div class="cell-1" style="width: 70%;"><div class="vertical vmiddle"><div class="tr"><div class="td"><?php echo $parser["items"][$_key_1]["LANG_NAME"]; ?></div></div></div></div>					
	<div class="cell-6" style="width: 20%; text-align: left;">
	<a href="javascript:editRow('<?php echo $parser["items"][$_key_1]["ID"]; ?>', '/<?php echo (cLANG); ?>/manager/atypes/edit/')" style="margin-bottom:0px;"><img src="/admin/img/icon-orange-edit.png" border="0" alt="" /></a> 
	<a href="javascript:chStatus('<?php echo $parser["items"][$_key_1]["ID"]; ?>', '/<?php echo (cLANG); ?>/manager/atypes/setstatus/');" style="margin-bottom:0px;"><img <?php if (''.$parser["items"][$_key_1]["STATUS"].''=='1') {?> 	src="/admin/img/icon-green-done.png" <?php } ?> <?php if (''.$parser["items"][$_key_1]["STATUS"].''=='0') {?> 	src="/admin/img/icon-grey-done.png" <?php } ?>  id="status<?php echo $parser["items"][$_key_1]["ID"]; ?>" border="0" alt="" /></a>
	<a style="margin-bottom:0px; cursor: pointer;"><img class="move" src="/admin/img/icon-orange-move.png" border="0" alt="" /></a>
	<a href="javascript:deleteRow('<?php echo $parser["items"][$_key_1]["ID"]; ?>', '/<?php echo (cLANG); ?>/manager/atypes/delete/');" style="margin-bottom:0px;"><img src="/admin/img/icon-red-delete.png" border="0" alt="" /></a>
	</div>
</div>
<?php 
}
 ?>
</form>