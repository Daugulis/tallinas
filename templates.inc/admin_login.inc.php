<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DESIGNIO CMS SYSTEM</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<link href="/admin/fonts/stylesheet.css" rel="stylesheet" type="text/css" />
<link href="/admin/css/style.css" rel="stylesheet" type="text/css" />
<script src="/admin/js/jquery-1.10.2.js"></script>
</head>
<body>
<div class="bg">
    <div class="login-window">
        <div class="login-window-header"><span style="color: #ffffff; font-size: 24px;">TALLINAS 86</span></div>
        <div class="login-window-main">
			<form id="lform" method="post">
            <p>ЛОГИН:</p>
            <input name="a_login" id="a_login" type="text" />
            <p>ПАРОЛЬ:</p>
            <input name="a_pass" id="a_pass" type="password" />
			
            <a href="javascript:login();">ВОЙТИ</a>
			</form>
        </div>
        <div class="developer">
            <p>CMS SYSTEM DEVELOPED BY <a href="">DESIGNIO</a></p>
            <p><i>VERSION:</i> 040050014</p>
        </div>
    </div>
</div>

<script>
$('#a_login').keyup(function(e) {
    var enterKey = 13;
    if (e.which == enterKey){
        login();
     }
 });
$('#a_pass').keyup(function(e) {
	var enterKey = 13;
	if (e.which == enterKey){
		login();
	 }
});
function login()
{
	document.getElementById('lform').submit();
}
</script>

</body>
</html>