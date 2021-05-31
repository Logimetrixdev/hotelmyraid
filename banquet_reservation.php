<?php
extract($_REQUEST);
require_once('class/config.inc.php');
$auth = new Authentication();
$auth->CheckAdminlogin();
$layout_obj = new DesignLayout();
$notice_obj = new Notification();
$controller = 'banquet';
$action = 'banquet_reservation';
$banquet_reser_obj = new BanquetReservation();
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("banquet_reser_obj")); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.png">

    <title><?php echo WEB_TITLE;?></title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
	<link rel="stylesheet" type="text/css" href="js/bootstrap.switch/bootstrap-switch.min.css" />
	<link rel="stylesheet" type="text/css" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css" />

	<!-- Select2 -->
	<link rel="stylesheet" type="text/css" href="js/jquery.select2/select2.css" />
	<link rel="stylesheet" type="text/css" href="js/bootstrap.slider/css/slider.css" />
  <link rel="stylesheet" type="text/css" href="js/jquery.niftymodals/css/component.css" />
  
  <!-- DateRange -->
	<link rel="stylesheet" type="text/css" href="js/bootstrap.daterangepicker/daterangepicker-bs3.css" />
  <link href="css/style.css" rel="stylesheet" />
   <link rel="stylesheet" href="fonts/font-awesome-4/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/pygments.css">
  <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
  <link href="js/jquery.icheck/skins/square/blue.css" rel="stylesheet">
 
	 <link href="css_timepicker/kendo.common.min.css" rel="stylesheet">
    <link href="css_timepicker/kendo.rtl.min.css" rel="stylesheet">
    <link href="css_timepicker/kendo.default.min.css" rel="stylesheet">

    <script src="js_timepicker/jquery.min.js"></script>
    <script src="js_timepicker/kendo.web.min.js"></script>
    <script src="js_timepicker/console.js"></script>

  
  
 <?php $ajax->Run('liveX/phplivex.js');?>

</head>

<body>

  <!-- Fixed navbar -->
<?php
$layout_obj->TopMenuBar($controller,$action);
?>
<div id="cl-wrapper" class="fixed-menu">
<?php
if($_SESSION['user_type']==1 or $_SESSION['user_type']==2)
{
$layout_obj->MenuBar($controller,$action);
}
?>
<div class="container-fluid" id="pcont">
	<div class="cl-mcont">
	<?php $notice_obj->notify();?>
         <div class="row">
		  
	 <?php 
   switch($index)
	{
	
	case 'listings':
		echo 'View Coming Soon';
	break;
	default :
	    if($submit=='Proceed')
		$banquet_reser_obj->New_BanquetReservation('server');	
		else
		$banquet_reser_obj->New_BanquetReservation('local');
		break;
	}
	?>
	</div>
     </div>
        
      </div>
    </div>
    </div>
		</div> 
	</div>

	      <script>
                $(document).ready(function() {
                    function startChange() {
                        var startTime = start.value();

                        if (startTime) {
                            startTime = new Date(startTime);

                            end.max(startTime);

                            startTime.setMinutes(startTime.getMinutes() + this.options.interval);

                            end.min(startTime);
                            end.value(startTime);
                        }
                    }

                    //init start timepicker
                    var start = $("#start").kendoTimePicker({
                        change: startChange
                    }).data("kendoTimePicker");

                    //init end timepicker
                    var end = $("#end").kendoTimePicker().data("kendoTimePicker");

                    //define min/max range
                    start.min("8:00 AM");
                    start.max("8:00 PM");

                    //define min/max range
                    end.min("8:00 AM");
                    end.max("8:00 AM");
                });
            </script>

<script type="text/javascript" src="popup/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="popup/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
	$('.fancybox').fancybox();
});
</script>
<script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
  <script src="js/jquery.select2/select2.min.js" type="text/javascript"></script>
  
  <script src="js/bootstrap.slider/js/bootstrap-slider.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
	<script type="text/javascript" src="js/jquery.nestable/jquery.nestable.js"></script>
	<script type="text/javascript" src="js/behaviour/general.js"></script>
  <script src="js/jquery.ui/jquery-ui.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/bootstrap.switch/bootstrap-switch.js"></script>
	<script type="text/javascript" src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="js/jquery.icheck/icheck.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.daterangepicker/moment.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.daterangepicker/daterangepicker.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      //initialize the javascript
      App.init();
       $('form').parsley();
    
      $('#reservation').daterangepicker();
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        format: 'YYYY-MM-DD h:mm A'
      });
      var cb = function(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + "]");
      }

      var optionSet1 = {
        startDate: moment().subtract('days', 29),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2014',
        dateLimit: { days: 60 },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
           'Last 7 Days': [moment().subtract('days', 6), moment()],
           'Last 30 Days': [moment().subtract('days', 29), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',

        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
      };

      var optionSet2 = {
        startDate: moment().subtract('days', 7),
        endDate: moment(),
        opens: 'left',
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
           'Last 7 Days': [moment().subtract('days', 6), moment()],
           'Last 30 Days': [moment().subtract('days', 29), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        }
      };

      $('#reportrange span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

      $('#reportrange').daterangepicker(optionSet1, cb);

    });
  </script>
  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/behaviour/voice-commands.js"></script>
  <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>

</html>
