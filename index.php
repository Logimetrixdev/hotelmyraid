<?php
extract($_REQUEST);
require_once('class/config.inc.php');
$auth=new Authentication();
$auth->IfAlreadyLogin();
$layout_obj = new DesignLayout();
$user_obj = new User();
$notice_obj = new Notification();
?>
<html> 
<head> 
<title><?php echo WEB_TITLE;?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1 " />
	<script src="js_login/jquery-1.8.3.min.js"></script>
	<!-- site style -->
	<link href="css_login/style.css" rel="stylesheet" type="text/css" media="screen" />
 <!--[if lt IE 10]> <link href="css/styleIE.css" rel="stylesheet" type="text/css" media="screen" /> <![endif]--> 
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <style>
.bott
{
box-sizing: border-box;
overflow: visible;
-moz-user-select: none;
    background-color: #FFFFFF;
    background-image: linear-gradient(to bottom, #FFFFFF 60%, #F9F9F9 100%);
    border-color: #CCCCCC;
    color: #333333;
    border-radius: 0;
    box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.12), 1px 1px 0 rgba(255, 255, 255, 0.2) inset;
    font-size: 13px;
    margin-bottom: 5px !important;
    margin-left: 4px;
    outline: medium none;
    padding: 7px 11px;
}
</style>
 </head> 
 <body> 
 <img src="img/gear.png" id="OptionColor" /> 
 <img src="img/picture.png" id="OptionBack" /> 
 <div class="LoginBox"> 
     <div><?php $notice_obj->Notify();?> </div>
 <img src="img/avatar.png" style="box-shadow:5px 5px 5px #787878; border-radius:5px; height:160px; width:160px;" /> 
 <h2 class="loginMessage"></h2> 
 <div class="fields"> 
	<?php
	if($submit=='Log In')
	{
	$user_obj->AdminLogin('server');	
	}
	else
	{
	$user_obj->AdminLogin('local');
	}
	?>
 </div> 
 </div> 

	<!-- javascript for login -->
	<script src="js_login/MetroLogin.js"></script>
</body> 
</html>