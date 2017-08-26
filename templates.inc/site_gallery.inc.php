<style>
.swiper-container {
	width: 100%;
	height: 100%;
}
.swiper-slide {
	text-align: center;
	font-size: 18px;
	background: #fff;

	/* Center slide text vertically */
	display: -webkit-box;
	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	-webkit-justify-content: center;
	justify-content: center;
	-webkit-box-align: center;
	-ms-flex-align: center;
	-webkit-align-items: center;
	align-items: center;
}
</style>

<div style="z-index: 999999; display: none; " class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
	<div class="pswp__scroll-wrap">
	    <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
	    <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
            <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="<?php echo (voc('trans_close_esc')); ?>"></button>
                <button class="pswp__button pswp__button--share" title="<?php echo (voc('trans_share')); ?>"></button>
                <button class="pswp__button pswp__button--fs" title="<?php echo (voc('trans_fullscreen')); ?>"></button>
                <button class="pswp__button pswp__button--zoom" title="<?php echo (voc('trans_zoom')); ?>"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div> 
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="<?php echo (voc('trans_previous')); ?>">
            </button>
            <button class="pswp__button pswp__button--arrow--right" title="<?php echo (voc('trans_next')); ?>">
            </button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
<div class="gallery-page swiper-container">
	<a class="left-arrow arrow" style="z-index: 999; cursor: pointer;"><i></i></a>
	<a class="right-arrow arrow" style="z-index: 999; cursor: pointer;"><i></i></a>
	<div class="slides swiper-wrapper">
		<?php foreach($parser["images"] as $_key_1=>$_var_1)
{
 ?>
		<div class="swiper-slide"><a href="javascript:openGallery('<?php echo $parser["images"][$_key_1]["ID"]; ?>')" style="background:url('/loads/tree/<?php echo $parser["images"][$_key_1]["ID"]; ?>.<?php echo $parser["images"][$_key_1]["EXT"]; ?>');"></a></div>
		<?php 
}
 ?>
	</div>
</div>

<script>
var imid = 0;
var swiper = new Swiper('.swiper-container', {
	loop: true,
	nextButton: '.right-arrow',
	prevButton: '.left-arrow',
});

function openGallery(id) {
	$('.pswp').eq(0).show();
	var pswpElement = document.querySelectorAll('.pswp')[0];
	
	var items = [];
	var obj = {};
	var ind = 0;
	var imind = 0;
	<?php foreach($parser["images"] as $_key_2=>$_var_2)
{
 ?>
	obj = {
		src: '/loads/tree/<?php echo $parser["images"][$_key_2]["ID"]; ?>.<?php echo $parser["images"][$_key_2]["EXT"]; ?>',
		w: <?php echo $parser["images"][$_key_2]["w"]; ?>,
		h: <?php echo $parser["images"][$_key_2]["h"]; ?>,
		title: ''
	};
	if (id=='<?php echo $parser["images"][$_key_2]["ID"]; ?>')
	{
		obj.pid = 'image-' + ind;
		items.push(obj);
		if (imid=='<?php echo $parser["images"][$_key_2]["ID"]; ?>')
		{
			imind = ind;
		}
		ind++;
	}
	<?php 
}
 ?>
		
	var options = {
		index: imind
	};
	var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
	gallery.init();
}
</script>