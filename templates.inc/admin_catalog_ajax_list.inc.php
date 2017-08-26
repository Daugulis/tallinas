<form id="iform">
<input type="hidden" id="lefturl" value="/<?php echo (cLANG); ?>/manager/catalogue/setleft/">
<?php foreach($parser["items"] as $_key_1=>$_var_1)
{
 ?>
<div class="user-items-item <?php if (ceil(intval(''.$parser["items"][$_key_1]["num"].'')/2)!=intval(''.$parser["items"][$_key_1]["num"].'')/2) {?> 	grey <?php } ?> " id="item<?php echo $parser["items"][$_key_1]["ID"]; ?>">
	<input type="hidden" name="items[]" value="<?php echo $parser["items"][$_key_1]["ID"]; ?>" />
	<div class="cell-1" style="width: 20%;"><div class="vertical vmiddle"><div class="tr"><div class="td">Floor: <?php echo $parser["items"][$_key_1]["FLOOR"]; ?></div></div></div></div>					
	<div class="cell-1" style="width: 20%;"><div class="vertical vmiddle"><div class="tr"><div class="td">Number: <?php echo $parser["items"][$_key_1]["NUMBER"]; ?></div></div></div></div>
	<div class="cell-1" style="width: 20%;"><div class="vertical vmiddle"><div class="tr"><div class="td">Area: <?php echo $parser["items"][$_key_1]["AREA"]; ?></div></div></div></div>					
	<div class="cell-1" style="width: 20%;"><div class="vertical vmiddle"><div class="tr"><div class="td">
	<?php if (''.$parser["items"][$_key_1]["STATUS"].''=='1') {?> 	<font color="green">Свободна</font> <?php } ?> 
	<?php if (''.$parser["items"][$_key_1]["STATUS"].''=='0') {?> 	<font color="grey">Продана</font> <?php } ?> 
	<?php if (''.$parser["items"][$_key_1]["STATUS"].''=='2') {?> 	<font color="orange">Резервация</font> <?php } ?> 
	</div></div></div></div>					
	<div class="cell-6" style="width: 10%; text-align: left;">
	<a href="/<?php echo (cLANG); ?>/manager/catalogue/edit/<?php echo $parser["items"][$_key_1]["ID"]; ?>/" style="margin-bottom:0px;"><img src="/admin/img/icon-orange-edit.png" border="0" alt="" /></a> 
	<a href="javascript:deleteRow('<?php echo $parser["items"][$_key_1]["ID"]; ?>', '/<?php echo (cLANG); ?>/manager/catalogue/delete/');" style="margin-bottom:0px;"><img src="/admin/img/icon-red-delete.png" border="0" alt="" /></a>
	</div>
</div>
<?php 
}
 ?>
</form>