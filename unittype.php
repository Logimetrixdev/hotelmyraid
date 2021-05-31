<?php
extract($_REQUEST);
require_once('class/config.inc.php');
require_once('class/class.unittype.php');
$auth=new Authentication();
$auth->CheckAdminlogin();
$layout_obj = new DesignLayout();
$notice_obj = new Notification();
$controller = 'InventorySettings';
$action = 'UnitType';
$UnitType_obj = new MasterUnitType();
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("UnitType_obj")); 
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
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->
  <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
  <link rel="stylesheet" type="text/css" href="js/jquery.easypiechart/jquery.easy-pie-chart.css" />
	<link rel="stylesheet" type="text/css" href="js/bootstrap.switch/bootstrap-switch.css" />
	<link rel="stylesheet" type="text/css" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css" />
	<link rel="stylesheet" type="text/css" href="js/jquery.select2/select2.css" />
	<link rel="stylesheet" type="text/css" href="js/bootstrap.slider/css/slider.css" />
	<link rel="stylesheet" type="text/css" href="js/jquery.datatables/bootstrap-adapter/css/datatables.css" />
  <link href="css/style.css" rel="stylesheet" />
 
  
  
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

         <div class="row">
		  
	 <?php 
	 $notice_obj->notify();
   switch($index)
	{
		case 'add':
		if($submit=='Save Info')
		$UnitType_obj->New_UnitType('server');	
		else
		$UnitType_obj->New_UnitType('local');
		break;
		case 'edit':
		if($submited=='Edit Info')
		$UnitType_obj->Edit_UnitType('server',$utid);	
		else
		$UnitType_obj->Edit_UnitType('local',$utid);
	 break;
	default :
		echo $UnitType_obj->UnitTypeManagement($utid);

		
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

	 <script src="js/jquery.js"></script>
      <script src="js/jquery.parsley/dist/parsley.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
	<script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
	<script type="text/javascript" src="js/jquery.easypiechart/jquery.easy-pie-chart.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
	<script type="text/javascript" src="js/behaviour/general.js"></script>
  <script src="js/jquery.ui/jquery-ui.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.nestable/jquery.nestable.js"></script>
	<script type="text/javascript" src="js/bootstrap.switch/bootstrap-switch.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
  <script src="js/jquery.select2/select2.min.js" type="text/javascript"></script>
  <script src="js/bootstrap.slider/js/bootstrap-slider.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
	<script type="text/javascript" src="js/jquery.datatables/jquery.datatables.min.js"></script>
	<script type="text/javascript" src="js/jquery.datatables/bootstrap-adapter/js/datatables.js"></script>


    <script type="text/javascript">
      
      $(document).ready(function(){
        //initialize the javascript
        App.init();
		 $('form').parsley();
        App.dataTables();
      $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
      $('.dataTables_length select').addClass('form-control');    

        //Horizontal Icons dataTable
        $('#datatable-icons').dataTable();
      });
    </script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
      <script src="js/behaviour/voice-commands.js"></script>
  <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>

</html>
