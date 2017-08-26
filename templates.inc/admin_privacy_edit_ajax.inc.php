<form id="addform">
<input type="hidden" name="data" value="1" />
<div class="popup-header">
	<a href="javascript:showTab('1');"><?php echo (voc('Основная информация')); ?></a>
	<a href="javascript:showTab('2');;"><?php echo (voc('Права')); ?></a>
</div>
<div class="popup-main">
	<div id="pinfo" class="ptab ptab1">
		<div class="popup-main-block">
			<p><?php echo (voc('Имя:')); ?></p>
			<input name="name" value="<?php echo $parser["d_NAME"]; ?>" type="text" />
		</div>
		<div class="popup-main-block">
			<p><?php echo (voc('Фамилия:')); ?></p>
			<input name="surname" value="<?php echo $parser["d_SURNAME"]; ?>" type="text" />
		</div>
		<div class="popup-main-block">
			<p><?php echo (voc('Login:')); ?></p>
			<input name="login" value="<?php echo $parser["d_LOGIN"]; ?>" type="text" />
		</div>
		<div class="popup-main-block">
			<p><?php echo (voc('E-mail:')); ?></p>
			<input name="email" value="<?php echo $parser["d_EMAIL"]; ?>" type="text" />
		</div>
		<div class="popup-main-block">
			<p><?php echo (voc('Passord:')); ?></p>
			<input name="pass" value="<?php echo $parser["d_PASS"]; ?>" type="password" />
		</div>
		<div class="popup-main-block">
			<p><?php echo (voc('Password (reply):')); ?></p>
			<input name="pass2" type="password" value="<?php echo $parser["d_PASS"]; ?>" />
		</div>
		<div class="popup-main-block">
			<p><?php echo (voc('Группа:')); ?></p>
			<select name="group">
				<option value="1" <?php if ($parser['d_GROUP']=='0') {?> 	selected <?php } ?> ><?php echo (voc('Клиенты')); ?></option>
				<option value="10" <?php if ($parser['d_GROUP']=='10') {?> 	selected <?php } ?> ><?php echo (voc('Менеджеры')); ?></option>
				<option value="100" <?php if ($parser['d_GROUP']=='100') {?> 	selected <?php } ?> ><?php echo (voc('Админы')); ?></option>
			</select>
		</div>
		<div class="popup-main-block">
			<p><?php echo (voc('Статус:')); ?></p>
			<select name="status">
				<option value="1" <?php if ($parser['d_ENABLED']=='1') {?> 	selected <?php } ?> ><?php echo (voc('Активный')); ?></option>
				<option value="0" <?php if ($parser['d_ENABLED']=='0') {?> 	selected <?php } ?> ><?php echo (voc('Неактивный')); ?></option>
			</select>
		</div>
	</div>
	<div id="ppermissions" class="ptab ptab2" style="display:none;">		
		<div class="popup-main-block">
			<p><?php echo (voc('Main:')); ?></p>
			<select name="perm[main]">
				<option value="1" <?php if ($parser['priv']['main']=='1') {?> 	selected <?php } ?> ><?php echo (voc('Активный')); ?></option>
				<option value="0" <?php if ($parser['priv']['main']=='0') {?> 	selected <?php } ?> ><?php echo (voc('Неактивный')); ?></option>
			</select>
		</div>
		<div class="popup-main-block">
			<p><?php echo (voc('Tree:')); ?></p>
			<select name="perm[tree]">
				<option value="1" <?php if ($parser['priv']['tree']=='1') {?> 	selected <?php } ?> ><?php echo (voc('Активный')); ?></option>
				<option value="0" <?php if ($parser['priv']['tree']=='0') {?> 	selected <?php } ?> ><?php echo (voc('Неактивный')); ?></option>
			</select>
		</div>
		<div class="popup-main-block">
			<p><?php echo (voc('Catalogue:')); ?></p>
			<select name="perm[catalogue]">
				<option value="1" <?php if ($parser['priv']['catalogue']=='1') {?> 	selected <?php } ?> ><?php echo (voc('Активный')); ?></option>
				<option value="0" <?php if ($parser['priv']['catalogue']=='0') {?> 	selected <?php } ?> ><?php echo (voc('Неактивный')); ?></option>
			</select>
		</div>
		
		<div class="popup-main-block">
			<p><?php echo (voc('Contacts:')); ?></p>
			<select name="perm[contacts]">
				<option value="1" <?php if ($parser['priv']['contacts']=='1') {?> 	selected <?php } ?> ><?php echo (voc('Активный')); ?></option>
				<option value="0" <?php if ($parser['priv']['contacts']=='0') {?> 	selected <?php } ?> ><?php echo (voc('Неактивный')); ?></option>
			</select>
		</div>
		<div class="popup-main-block">
			<p><?php echo (voc('Translate:')); ?></p>
			<select name="perm[translate]">
				<option value="1" <?php if ($parser['priv']['translate']=='1') {?> 	selected <?php } ?> ><?php echo (voc('Активный')); ?></option>
				<option value="0" <?php if ($parser['priv']['translate']=='0') {?> 	selected <?php } ?> ><?php echo (voc('Неактивный')); ?></option>
			</select>
		</div>
		<div class="popup-main-block">
			<p><?php echo (voc('Privacy:')); ?></p>
			<select name="perm[privacy]">
				<option value="1" <?php if ($parser['priv']['privacy']=='1') {?> 	selected <?php } ?> ><?php echo (voc('Активный')); ?></option>
				<option value="0" <?php if ($parser['priv']['privacy']=='0') {?> 	selected <?php } ?> ><?php echo (voc('Неактивный')); ?></option>
			</select>
		</div>

	</div>
	<a class="pp" href="javascript:saveAdmin('/<?php echo (cLANG); ?>/manager/<?php echo (OBJ); ?>/<?php echo (TASK); ?>/<?php echo (ID); ?>/', 'addform');">&nbsp; <?php echo (voc('Сохранить')); ?>&nbsp; </a>
</div>
</form>