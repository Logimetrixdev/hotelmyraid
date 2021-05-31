<?php
extract($_REQUEST);
require_once('class/config.inc.php');
$auth=new Authentication();
$auth->CheckAdminlogin();
$ajax = new PHPLiveX();
$layout_obj = new DesignLayout();
$notice_obj = new Notification();
$controller = 'Report';
$action = 'SaleBanquetReport';
$report_obj = new HotelReports();

$ajax->AjaxifyObjects(array("report_obj"));  
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
	<link href='http://fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
  

    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet" />
	<link rel="stylesheet" href="fonts/font-awesome-4/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->
	    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />

  <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
  <link rel="stylesheet" type="text/css" href="js/jquery.easypiechart/jquery.easy-pie-chart.css" />
	<link rel="stylesheet" type="text/css" href="js/bootstrap.switch/bootstrap-switch.css" />
	<link rel="stylesheet" type="text/css" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css" />
	<link rel="stylesheet" type="text/css" href="js/jquery.select2/select2.css" />
	<link rel="stylesheet" type="text/css" href="js/bootstrap.slider/css/slider.css" />
	<link rel="stylesheet" type="text/css" href="js/intro.js/introjs.css" />
  <link rel="stylesheet" href="js/jquery.vectormaps/jquery-jvectormap-1.2.2.css" type="text/css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="js/jquery.magnific-popup/dist/magnific-popup.css" />
  <link rel="stylesheet" type="text/css" href="js/jquery.niftymodals/css/component.css" />
  <link rel="stylesheet" type="text/css" href="js/bootstrap.summernote/dist/summernote.css" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  
  
    <link rel="stylesheet" type="text/css" href="media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="resources/syntax/shCore.css">
   <style type="text/css" class="init">

	th, td { white-space: nowrap; }
	div.dataTables_wrapper {
		width: 1028px;
		margin: 0 auto;
	}

	</style>
	<script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="resources/demo.js"></script>
	<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
	$('#example').dataTable( {
		"scrollX": true
	} );
} );

	</script>
    
 <?php $ajax->Run('liveX/phplivex.js');?>

</head>
<body class="dt-example">

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
    <div class="row">
    <?php
	switch($index)
	{
	case 'sales' :
    $report_obj->SalesBanquetSearch($banquet_type,$report_date);
	break;
	
	default:
	$report_obj->SalesBanquetSearch($banquet_type,$report_date);
	$report_obj->SalesBanquetReport($banquet_type,$report_date);
	break;
	}
	
    ?>
    </div>
    </div>
    </div>

  <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>

  <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
	<script type="text/javascript" src="js/behaviour/general.js"></script>
  <script src="js/jquery.ui/jquery-ui.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
	<script type="text/javascript" src="js/jquery.easypiechart/jquery.easy-pie-chart.js"></script>
	<script type="text/javascript" src="js/jquery.nestable/jquery.nestable.js"></script>
	<script type="text/javascript" src="js/bootstrap.switch/bootstrap-switch.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
  <script src="js/jquery.select2/select2.min.js" type="text/javascript"></script>
  <script src="js/skycons/skycons.js" type="text/javascript"></script>
  <script src="js/bootstrap.slider/js/bootstrap-slider.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/jquery.niftymodals/js/jquery.modalEffects.js"></script>   
    <script type="text/javascript" src="js/bootstrap.summernote/dist/summernote.min.js"></script>

  <script src="js/jquery.vectormaps/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="js/jquery.vectormaps/maps/jquery-jvectormap-us-merc-en.js"></script>
    <script src="js/jquery.vectormaps/maps/jquery-jvectormap-world-mill-en.js"></script>
    <script src="js/jquery.vectormaps/maps/jquery-jvectormap-fr-merc-en.js"></script>
    <script src="js/jquery.vectormaps/maps/jquery-jvectormap-uk-mill-en.js"></script>
    <script src="js/jquery.vectormaps/maps/jquery-jvectormap-us-il-chicago-mill-en.js"></script>
    <script src="js/jquery.vectormaps/maps/jquery-jvectormap-au-mill-en.js"></script>
    <script src="js/jquery.vectormaps/maps/jquery-jvectormap-in-mill-en.js"></script>
    <script src="js/jquery.vectormaps/maps/jquery-jvectormap-map.js"></script>
    <script src="js/jquery.vectormaps/maps/jquery-jvectormap-ca-lcc-en.js"></script>

  <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        //App.dashBoard();        
        /*Sparklines*/
       
      

      });
    </script>
    	<script type="text/javascript" src="js/jquery.magnific-popup/dist/jquery.magnific-popup.min.js"></script>
   
 

    <script src="js/behaviour/voice-commands.js"></script>
  <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.flot/jquery.flot.js"></script>
	<script type="text/javascript" src="js/jquery.flot/jquery.flot.pie.js"></script>
	<script type="text/javascript" src="js/jquery.flot/jquery.flot.resize.js"></script>
	<script type="text/javascript" src="js/jquery.flot/jquery.flot.labels.js"></script>
  </body>

</html>
