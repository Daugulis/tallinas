<?php foreach($parser["vocs"] as $_key_1=>$_var_1)
{
 ?><div id="item<?php echo $parser["vocs"][$_key_1]["ID"]; ?>" class="transalte-item <?php if (ceil(intval(''.$parser["vocs"][$_key_1]["num"].'')/2)!=intval(''.$parser["vocs"][$_key_1]["num"].'')/2) {?> 	grey <?php } ?>  <?php if (''.$parser["vocs"][$_key_1]["num"].''=='1') {?> 	border <?php } ?> ">
	<div class="cell-1" style="width: 50%;"><a href="javascript:translate('<?php echo $parser["vocs"][$_key_1]["ID"]; ?>')" class="translate-item-title">
		<?php if (''.$parser["vocs"][$_key_1]["svalue"].''=='1') {?> 	
		<?php echo $parser["vocs"][$_key_1]["lvalue"]; ?>
		 <?php } ?> 
		<?php if (''.$parser["vocs"][$_key_1]["svalue"].''!='1') {?> 	
		<?php echo $parser["vocs"][$_key_1]["TRANS"]; ?>
		 <?php } ?> 
	</a></div>
	<div class="cell-2" style="width: 20%;">
		<?php foreach($parser["langs"] as $_key_2=>$_var_2)
{
 ?>				
		<img src="/loads/languages/<?php echo $parser["langs"][$_key_2]["IMID"]; ?>.<?php echo $parser["langs"][$_key_2]["IMEXT"]; ?>" border="0" alt="" <?php if (checkTranslate(''.$parser["vocs"][$_key_1]["num"].'', ''.$parser["langs"][$_key_2]["ID"].'')==false) {?> 	class="no-translate" <?php } ?>  />
		<?php 
}
 ?>		
	</div>
	<div class="cell-2" style="width: 20%; text-align: left;">
		<a href="javascript:deleteVocs('<?php echo $parser["vocs"][$_key_1]["ID"]; ?>');" style="margin-bottom:0px;"><img src="/admin/img/icon-red-delete.png" border="0" alt="" /></a>
	</div>
</div><?php 
}
 ?>