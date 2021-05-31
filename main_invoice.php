<?php
extract($_REQUEST);
require_once('class/config.inc.php');
$auth=new Authentication();
$auth->CheckAdminlogin();
$layout_obj = new DesignLayout();
$notice_obj = new Notification();
$banquet_reser_obj = new BanquetReservation();
$reservation_obj = new Reservation();
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("reservation_obj","banquet_reser_obj")); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEB_TITLE;?></title>

<script type="text/javascript" src="js/print.js"></script>
</head>

<body style="background:#FFF;">
<?php
switch($index)
{
	case 'banquetInvoice':
	if($paymentId!='')
	$banquet_reser_obj->GenerateInvoice($paymentId);
	else
	echo 'Invalid Entry';
	break;
	
	default:
	if($paymentId!='')
	$reservation_obj->GenerateInvoice($paymentId);
	else
	echo 'Invalid Entry';
	break;
}
?>
</body>
</html>