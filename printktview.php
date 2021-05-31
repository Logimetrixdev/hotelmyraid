<?php
extract($_REQUEST);
require_once('class/config.inc.php');
require_once('class/class.Kot.php');
$auth = new Authentication();
$auth->CheckAdminlogin();
$layout_obj = new DesignLayout();
$notice_obj = new Notification();
$controller = 'Kot';
$action = 'addkot';
$kot_obj = new KOT();
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("kot_obj")); 
?>
<script src="js/print.js"></script>
(Best View on Firefox)
<?php $kot_obj->GenerateKOT($kt_id,$type);?>			