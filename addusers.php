<?php
extract($_REQUEST);
require_once('class/config.inc.php');
$auth = new Authentication();
$auth->CheckAdminlogin();
$layout_obj = new DesignLayout();
$notice_obj = new Notification();
$controller = 'UserSettings';
$action = 'CreateUser';
$user_obj = new User();
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("user_obj")); 
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
        case 'new':
        if($submit=='Add User')
        $user_obj->Add_User('server');	
        else
        $user_obj->Add_User('local');
        break;
        
        case 'listings':
        echo 'View Coming Soon';
        break;
        default :
        if($submit=='Add User')
        $user_obj->Add_User('server');	
        else
        $user_obj->Add_User('local');
        break;
        }
        ?>
            
            <?php 
            $user_obj->Advance_Search($first_name,$last_name,$phone,$arrival,$departure,$room_type_id);
            ?>
           
            
	</div>
     </div>
        
      </div>
    </div>
    
    </div>
		</div> 
		
	</div>

	<script src="js/jquery.js"></script>

	
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
