<body>
<div class="overlay"></div>
<div class="popup"></div>
<div class="open-close open-close-h color" onclick="swmenu();"><i></i></div>
<div class="left-side">
	<div class="l-s-header">
    	<a href="/<?php echo (cLANG); ?>/" class="logo"><img src="/img/tallinas.png" class="tallinas" alt=""/> <b class="color"><img src="/img/86.png" alt=""></b></a>
        <div class="languages">
			<?php foreach($parser["langs"] as $_key_1=>$_var_1)
{
 ?>
        	<a href="<?php echo (getLangLink(''.$parser["langs"][$_key_1]["SHORTNAME"].'')); ?>" <?php if (''.$parser["langs"][$_key_1]["ID"].''==LANG) {?> 	class="selected" <?php } ?> ><?php echo $parser["langs"][$_key_1]["SITENAME"]; ?></a>
			<?php 
}
 ?>
        </div>
    </div>
    <div class="l-s-main">
    	<div class="l-s-m-menu">
			<a href="/<?php echo (cLANG); ?>/" <?php if (in_array(OBJ, Array('', '2', '3', '4', '5'))) {?> 	class="selected color" <?php } ?> ><?php echo (voc('Выбор квартиры')); ?></a> 
			<?php foreach($parser["tree"] as $_key_2=>$_var_2)
{
 ?>
			<?php if (''.$parser["tree"][$_key_2]["TYPE"].''!='7') {?> 	
        	<a href="/<?php echo (cLANG); ?>/<?php echo $parser["tree"][$_key_2]["LANG_URL"]; ?>/" <?php if (OBJ==''.$parser["tree"][$_key_2]["LANG_URL"].'') {?> 	class="selected color" <?php } ?> ><?php echo $parser["tree"][$_key_2]["LANG_NAME"]; ?></a>
			 <?php } ?> 
			<?php if (''.$parser["tree"][$_key_2]["TYPE"].''=='7') {?> 	
        	<a href="javascript:showPopup('<?php echo $parser["tree"][$_key_2]["ID"]; ?>')" data-id="<?php echo $parser["tree"][$_key_2]["ID"]; ?>" class="colored <?php if (OBJ==''.$parser["tree"][$_key_2]["LANG_URL"].'') {?> 	selected color <?php } ?>  popuplink"><?php echo $parser["tree"][$_key_2]["LANG_NAME"]; ?></a>
			 <?php } ?> 
			<?php 
}
 ?>
        </div>
		<style>.l-s-m-share{margin-left:30px;margin-right:30px;}.l-s-m-share a{display:inline-block;margin-top:10px;}.l-s-m-share img{display:inline-block;width:100%;}</style>
        <div class="l-s-m-share">
            <a href="https://www.facebook.com/Tallinas-86-Apartments-1039088446172460/?ref=ts&fref=ts" target="_blank">
			<img src="/img/facebook.png" alt=""/>
			</a>
        </div>
    </div>
    <div class="l-s-footer">
		<?php if (OBJ!=$parser['ctree']['0']['LANG_URL']) {?> 	
    	<a href="/<?php echo (cLANG); ?>/<?php echo ($parser['ctree']['0']['LANG_URL']); ?>/" class="button color"><?php echo (voc('Задать вопрос')); ?></a>
		 <?php } ?> 
	</div>
</div>
<div class="main">
	<div class="m-container">
    	<?php echo $parser["content"]; ?>
    </div>
</div>
<script>
function showPopup(id)
{

	$('.overlay').click(function() {
		$('.overlay').fadeOut();
		$('.popup').fadeOut();
	});

	$('.popup').click(function() {
		$('.overlay').fadeOut();
		$('.popup').fadeOut();
	});

	$.ajax({
		type: 'POST',
		url: '/<?php echo (cLANG); ?>/showpopup/'+id+'/',
		data: ''
	}).done(function(data) {
		$('.popup').html(data);
		$('.overlay').fadeIn();
		$('.popup').fadeIn();		
	});
}

function swmenu()
{
	var mm = parseInt($('.left-side').css('margin-left'));
	var mw = parseInt($('.left-side').width());
	if (mm == 0)
	{
		$('.left-side').css({'margin-left': '-'+mw+'px', transition: '0.3s'});
		$('.main').css({'margin-left': '0px', transition: '0.3s'});
		$('.open-close').removeClass('open-close-h');;
		$('.open-close').css({'left': '0px', transition: '0.3s'});
	}
	else
	{
		$('.open-close').addClass('open-close-h');;
		$('.left-side').css('margin-left', '0px');
		$('.main').css('margin-left', mw+'px');
		$('.open-close').css({'left': mw+'px', transition: '0.3s'});
	}
	setTimeout(function() {
		if (typeof window['setFloor'] === 'function')
		{
			phh = $('.floor-plan').height();
			pww = $('.floor-plan').width();
			executeFunctionByName('setFloor', floor, '');
			executeFunctionByName('reshow', '', '');
		}
		if (typeof window['reshow'] === 'function')
		{
			executeFunctionByName('reshow', '', '');
		}
	}, 400);
	if (typeof window['swiper'] !== 'undefined')
	{
		setTimeout(function() {
			swiper.update(true);
		}, 300);
	}
}

function redraw()
{
	return;
	var mm = parseInt($('.left-side').css('margin-left'));
	var mw = parseInt($('.left-side').width());
	if (mm==0)
	{
		var mmm = mw - mm;
	}
	else
	{
		var mmm = 0;
	}
	$('.open-close').css('left', mmm+'px');
}

$(window).resize(redraw);

executeFunctionByName = function(functionName)
{ 
	var args = Array.prototype.slice.call(arguments).slice(1);
	var namespaces = functionName.split(".");
	var func = namespaces.pop();
	var ns = namespaces.join('.');
	if(ns === undefined || ns === '')
	{
		ns = 'window';
	}
	ns = eval(ns);
	return ns[func].apply(ns, args);
};

<?php if ($parser['swpopup']=='1') {?> 	
if ($('.popuplink').eq(0).length>0)
{
	showPopup($('.popuplink').eq(0).attr('data-id'));
}
 <?php } ?> 

$(document).ready(function() {
	if ($(window).width()<900)
	{
		var mm = parseInt($('.left-side').css('margin-left'));
		var mw = parseInt($('.left-side').width());
		$('.open-close').css('left', mw+'px');
	}
	else
	{
		$('.open-close').hide();
	}
});

</script>
</body>
</html>