<?php
extract($_REQUEST);
require_once('class/config.inc.php');
$auth=new Authentication();
$auth->CheckAdminlogin();
$layout_obj = new DesignLayout();
$notice_obj = new Notification();
$controller = 'banquet';
$action = 'listing';
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
	<link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />

	<link rel="stylesheet" href="fonts/font-awesome-4/css/font-awesome.min.css">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="../../assets/js/html5shiv.js"></script>
	  <script src="../../assets/js/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
	<link rel="stylesheet" type="text/css" href="js/jquery.easypiechart/jquery.easy-pie-chart.css" />
	<link rel="stylesheet" type="text/css" href="js/bootstrap.switch/bootstrap-switch.css" />
	<link rel="stylesheet" type="text/css" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css" />
	<link rel="stylesheet" type="text/css" href="js/jquery.select2/select2.css" />
	<link rel="stylesheet" type="text/css" href="js/bootstrap.slider/css/slider.css" />
  <link rel="stylesheet" type="text/css" href="js/jquery.timeline/css/component.css" />
	<!-- Custom styles for this template -->
	<link href="css/style.css" rel="stylesheet" />	
 <?php $ajax->Run('liveX/phplivex.js');?>
<script src="js/print.js"></script>
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
		  <?php $notice_obj->Notify();?> 
			<div class="row dash-cols">
            	
						<?php 
						switch($index)
						{
							case 'banquetMenuSelection':
							if($submit=='Proceed')
							$banquet_reser_obj->BanquetMenu('server',$bookingId);	
							else
							$banquet_reser_obj->BanquetMenu('local',$bookingId);
							break;
							case 'payment':
							if($submited=='paynow')
							$banquet_reser_obj->BanquetTotalCost('server',$bookingId);	
							else
							$banquet_reser_obj->BanquetTotalCost('local',$bookingId);
							break;
							case 'print':
							$banquet_reser_obj->BanquetBillAdvancePayment($pid);
							break;
							case 'finalpayment':
							if($submited=='pay')
							$banquet_reser_obj->MainInvoice('server',$bqId);	
							else
							$banquet_reser_obj->MainInvoice('local',$bqId);
							break;
							case 'FinalInvoicePrint':
							$banquet_reser_obj->FinalInvoiceDetails($pid);
							break;
		   					default:
							?>
							<div id="popupdiv">
							<?php 
							echo $banquet_reser_obj->banquetBookingListing($pg='1',$recordcount='5',$first_name,$last_name,$phone,$arrival,$departure,$room_type_id,$name);
							?>
							</div>
							<?php
							break;
						}
						?>
						
				
						<div class="col-lg-12 pull-left">
						<div class="block-flat">
						<div class="content">
						<p align="center"> Hotel Management Appliaction Powered by <a target="_blank" href="http://logimetrix.in/"><strong style="font-size:12px; font-family:Verdana, Geneva, sans-serif;">Logimetrix Tech Solutions</strong></a> &copy; 2014 All Rights Reserved.</p>
						</div>
						</div>				
						</div>
				</div>
		 </div>
		</div> 
		
	</div>

	<script src="js/jquery.js"></script>
    
      <script type="text/javascript" src="popup/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="popup/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
	$('.fancybox').fancybox();
});
</script>

	  <script src="js/jquery.parsley/dist/parsley.min.js" type="text/javascript"></script>
  <script src="js/jquery.parsley/src/extra/dateiso.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
	<script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
	<script type="text/javascript" src="js/jquery.easypiechart/jquery.easy-pie-chart.js"></script>
  <script src="js/jquery.ui/jquery-ui.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.nestable/jquery.nestable.js"></script>
	<script type="text/javascript" src="js/bootstrap.switch/bootstrap-switch.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	<script src="js/jquery.select2/select2.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.slider/js/bootstrap-slider.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
  <script type="text/javascript" src="js/bootstrap.multiselect/js/bootstrap-multiselect.js"></script>
  <script type="text/javascript" src="js/jquery.multiselect/js/jquery.multi-select.js"></script>
  <script type="text/javascript" src="js/jquery.quicksearch/jquery.quicksearch.js"></script>
	<script type="text/javascript" src="js/behaviour/general.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
    
         $('form').parsley();
    
        $('#example14').multiselect({
            buttonWidth: '466px',
            buttonText: function(options) {
                if (options.length === 0) {
                    return 'None selected <b class="caret"></b>';
                }
                else {
                    var selected = '';
                    options.each(function() {
                        selected += $(this).text() + ', ';
                    });
                    return selected.substr(0, selected.length -2) + ' <b class="caret"></b>';
                }
            }
        });
     });
    </script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
  <script src="js/behaviour/voice-commands.js"></script>
  <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/jquery.flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="js/jquery.flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="js/jquery.flot/jquery.flot.labels.js"></script>

  </body>

</html>
