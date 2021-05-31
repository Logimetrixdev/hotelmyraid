<?php
require_once('class/config.inc.php');
$user_obj = new User();
$notice_obj = new Notification();
$auth=new Authentication();
extract($_REQUEST);
$user_obj->logOut();
?>

