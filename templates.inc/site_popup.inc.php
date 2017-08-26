<div class="popup-content">
	<?php if (count($parser['ob']['images'])>0) {?> 	
	<div class="popup-image"><div class="t"><div class="v"><img src="<?php echo (getImageSrc('1'.getImageTypeByExt($parser['ob']['images']['0']['EXT']).'9'.$parser['ob']['images']['0']['ID'], getImageTypeByExt($parser['ob']['images']['0']['EXT']))); ?>" /></div></div></div>
	 <?php } ?> 
	<?php echo (getTextBlocksSite($parser['ob']['data']['ID'], 'tree')); ?>
	<?php if (count($parser['cblocks'])>0) {?> 	
		<div class="popup-text">
		<?php foreach($parser["cblocks"] as $_key_1=>$_var_1)
{
 ?>
			<?php if (''.$parser["cblocks"][$_key_1]["TYPE"].''=='1') {?> 	
				<?php echo (getTextBlockSite('tree', ''.$parser["cblocks"][$_key_1]["ID"].'')); ?>
				<?php if ($parser['cblock']['NAME']!='') {?> 	
					<h3><?php echo ($parser['cblock']['NAME']); ?></h3>
				 <?php } ?> 
				<?php if ($parser['cblock']['TEXT']!='') {?> 	
					<?php echo ($parser['cblock']['TEXT']); ?>
				 <?php } ?> 
			 <?php } ?> 
		<?php 
}
 ?>
		</div>
	 <?php } ?> 
</div>