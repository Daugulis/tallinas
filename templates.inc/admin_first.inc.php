<div class="main">
    <div class="main-page-items">
		<?php foreach($parser["menu"] as $_key_1=>$_var_1)
{
 ?>
		<?php if ($parser['apriv'][''.$parser["menu"][$_key_1]["NAME"].'']=='1') {?> 	
        <a href="/<?php echo (cLANG); ?>/manager/<?php echo $parser["menu"][$_key_1]["NAME"]; ?>/"><img src="/admin/img/menu-icon-big-<?php echo $parser["menu"][$_key_1]["ICON"]; ?>.png" border="0" alt="" /><h1><?php echo (voc(''.$parser["menu"][$_key_1]["CAPTION"].'')); ?></h1></a>
		 <?php } ?> 
		<?php 
}
 ?>
    </div>
</div>