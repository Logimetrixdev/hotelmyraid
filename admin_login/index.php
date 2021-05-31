<?php
extract($_REQUEST);
require_once('../class/configAdmin.inc.php');
$auth=new Authentication();
$auth->IfAlreadyLogin();
$user_obj = new User();
$notice_obj = new Notification();
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from condorthemes.com/cleanzone/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 30 Mar 2014 17:47:28 GMT -->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="images/favicon.png">

	<title><?php echo WEB_TITLE;?> - ADMIN</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>

	<!-- Bootstrap core CSS -->
	<link href="../js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">

	<link rel="stylesheet" href="../fonts/font-awesome-4/css/font-awesome.min.css">

	<!-- Custom styles for this template -->
	<link href="../css/style.css" rel="stylesheet" />	

</head>

<body class="texture">

		<div id="cl-wrapper" class="login-container">
		<div class="middle-login">
        <?php $notice_obj->Notify();?>
		<?php
        if($submit=='Log In')
        {
        $user_obj->AdminMainLogin('server');	
        }
        else
        {
        $user_obj->AdminMainLogin('local');
        }
        ?>
     <div class="text-center out-links" style="color:#97D4F6;">&copy; <?php echo date("Y")?> Powered By<a href="http://www.logimetrix.co.in" target="_blank"> Logimetrix tech Solutions</a></div>
	</div> 
	
</div>

<script src="../js/jquery.js"></script>
 
	<script type="text/javascript" src="../js/behaviour/general.js"></script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
  <script src="../js/behaviour/voice-commands.js"></script>
  <script src="../js/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/jquery.flot/jquery.flot.js"></script>
<script type="text/javascript" src="../js/jquery.flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="../js/jquery.flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="../js/jquery.flot/jquery.flot.labels.js"></script>

</body>

<!-- Mirrored from condorthemes.com/cleanzone/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 30 Mar 2014 17:47:28 GMT -->
</html>
