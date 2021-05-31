<?php
extract($_REQUEST);
require_once('class/config.inc.php');
$auth=new Authentication();
$auth->CheckAdminlogin();
$layout_obj = new DesignLayout();
$notice_obj = new Notification();
$controller = 'reservation';
$action = 'add_reservation';
$reservation_obj = new Reservation();
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("reservation_obj")); 
?>
<link rel="stylesheet" type="text/css" href="event_calendar/fullcalendar.css" />
<link rel="stylesheet" type="text/css" href="event_calendar/fullcalendar.print.css" />
<script src="event_calendar/jquery.min.js"></script>

<script src="event_calendar/fullcalendar.min.js"></script>


<?php $reservation_obj->CheckRoomAvailbilityCalendar();?>
<style>
    #calendar{text-align:center;font-size:14px;font-family:"Lucida Grande",Helvetica,Arial,Verdana,sans-serif;background:#FFC26A;margin:0 auto;}
    th{background:#ccc;}
    table{background:#e5f0e5;}
    .forgot_password_popup{padding:5px;}
</style>
<div class="forgot_password_popup" style="width: 590px;">
    <div id='calendar'></div>
</div>