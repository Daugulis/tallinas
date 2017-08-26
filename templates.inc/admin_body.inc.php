<body>

<style>
#mpopup {
	z-index: 900;
	position: fixed;
	width: 100%;
	height: 100%;
	background-color: rgba(255, 255, 255, 0.5);
	display: none;

}
#mpopupbg {
	position: fixed;
	z-index: 910;
	width: 100%;
	height: 100%;
	background-color: rgba(255, 255, 255, 0.5);
}
#mpopupContent {
	margin: 100px 0px;
	padding: 10px;
	border: solid 1px #0C71A5;
	position: fixed;
	background: #ffffff;
}
</style>

<script>
function setPpos()
{
	var w1 = $(window).width();
	var w2 = $('#mpopupContent').width();
	var p = ( w1 - w2 ) / 2;
	$('#mpopupContent').css('margin-left', p.toFixed(2)+'px');
}
</script>

<div id="mpopup">
	<div id="mpopupContent">content</div>
	<div id="mpopupbg"></div>
</div>

<script>
	var w1 = $(window).width();
	var w2 = 600;
	var p = ( w1 - w2 ) / 2;
	$('#mpopupContent').css('margin-left', p.toFixed(2)+'px');
</script>

<div class="overlay" id="overley" style="display: none;"></div>
<div class="popup" id="popup" style="display: none;"><a href="javascript:closePopup()" class="close-popup">X</a>
	<div id="pcontent">
		<div class="popup-header">
			<a href=""><?php echo (voc('Название категории')); ?></a>
		</div>
        <div class="popup-main">
        	<div class="popup-main-block">
                <p><?php echo (voc('Название категории')); ?> (RU):</p>
                <input type="text" />
            </div>
            <div class="popup-main-block">
                <p><?php echo (voc('Название категории')); ?> (LV):</p>
                <input type="password" />
            </div>
            <div class="popup-main-block">
                <p><?php echo (voc('URL АДРЕС')); ?> (RU):</p>
                <input type="text" />
            </div>
            <div class="popup-main-block">
                <p><?php echo (voc('URL АДРЕС')); ?> (LV):</p>
                <input type="password" />
            </div>
            <div class="popup-main-block">
                <p><?php echo (voc('Статус')); ?>:</p>
                <select>
                	<option><?php echo (voc('Активный')); ?></option>
                </select>
            </div>
            <a href="javascript:void();"><?php echo (voc('Сохранить')); ?></a>
        </div>
	</div>
</div>

<div class="header">
	<a href="/<?php echo (cLANG); ?>/manager/" class="logo"></a>
		<div class="user-info"><h1><?php echo ($parser['login_user_data']['NAME']); ?> <?php echo ($parser['login_user_data']['SURNAME']); ?></h1><h2><?php echo (voc('ПОСЛЕДНИЙ ВИЗИТ')); ?>: <i><?php echo (date("d.m.Y H:i:s")); ?></i></h2></div><a href="/<?php echo (cLANG); ?>/manager/logout/" class="exit-button"><?php echo (voc('ВЫХОД')); ?></a>
            <div class="header-menu">
                <a href="/<?php echo (cLANG); ?>/manager/" <?php if (OBJ=='') {?> 	class="selected" <?php } ?> ><img src="/admin/img/menu-icon-small-home.png" border="0" alt="" /></a>
				<?php foreach($parser["menu"] as $_key_2=>$_var_2)
{
 ?>
				<?php if ($parser['apriv'][''.$parser["menu"][$_key_2]["NAME"].'']=='1') {?> 	
                <a href="/<?php echo (cLANG); ?>/manager/<?php echo $parser["menu"][$_key_2]["NAME"]; ?>/" title="<?php echo (voc(''.$parser["menu"][$_key_2]["CAPTION"].'')); ?>" <?php if (OBJ==''.$parser["menu"][$_key_2]["NAME"].'') {?> 	class="selected" <?php } ?> ><img src="/admin/img/menu-icon-small-<?php echo $parser["menu"][$_key_2]["ICON"]; ?>.png" border="0" alt="" /></a>
				 <?php } ?> 
				<?php 
}
 ?>                
            </div>
</div>
<?php if (isset($parser['cnt'])) {?> 	
<?php echo $parser["cnt"]; ?>
 <?php } ?> 
<div class="footer">
	<div class="footer-left">
        <p>SKYPE SUPPORT: <a href="skype:designio.support">DESIGNIO.SUPPORT</a></p>
        <p>E-MAIL: <a href="mailto:SUPPORT@DESIGNIO.LV">SUPPORT@DESIGNIO.LV</a></p>
	</div>
    <div class="footer-right">
		<p>CMS SYSTEM DEVELOPED BY <a href="">DESIGNIO</a></p>
		<p><i>VERSION:</i> 040050014</p>
	</div>
</div>
</body>
</html>