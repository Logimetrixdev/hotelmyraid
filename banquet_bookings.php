<?php
extract($_REQUEST);
require_once('class/config.inc.php');
$auth=new Authentication();
$auth->CheckAdminlogin();
$layout_obj = new DesignLayout();
$notice_obj = new Notification();
$controller = 'banquet';
$action = 'banquet_reservation';
$banquet_reser_obj = new BanquetReservation();
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("banquet_reser_obj"));  
?>
<link rel="stylesheet" type="text/css" href="event_calendar/fullcalendar.css" />
<link rel="stylesheet" type="text/css" href="event_calendar/fullcalendar.print.css" />
<script src="event_calendar/jquery.min.js"></script>

<script src="event_calendar/fullcalendar.min.js"></script>


<?php $banquet_reser_obj->CheckbanquetAvailbilityCalendar();?>
<style>
    #calendar{text-align:center;font-size:14px;font-family:"Lucida Grande",Helvetica,Arial,Verdana,sans-serif;background:#FFC26A;margin:0 auto;}
    th{background:#ccc;}
    table{background:#2494F2;}
    .forgot_password_popup{padding:5px;}
	.fc-event {
	background: #B2525F; !important;
	color: #fff!important;
	}
</style>
<div class="forgot_password_popup">
    <div id='calendar'></div>
</div>