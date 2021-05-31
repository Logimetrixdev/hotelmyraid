<?php
extract($_REQUEST);
require_once('class/config.inc.php');
$auth=new Authentication();
$auth->CheckAdminlogin();
$layout_obj = new DesignLayout();
$notice_obj = new Notification();
$controller = 'Report';
$action = 'RoomReport';
$report_obj = new HotelReports();
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("report_obj"));  
?>
<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from condorthemes.com/cleanzone/dashboard2.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 30 Mar 2014 17:42:50 GMT -->
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
<style>

/*ROOM CODE START HERE*/
.audit_room{margin:5px; border:1px solid #CCC; overflow:hidden; background:#FFF;} 
.audit_main{margin:5px; padding:5px; border:1px solid #CCC; background:#FFF; overflow:hidden;}
.audit_left{width:500px; float:left; padding:5px;}
.audit_total_room_main{padding:5px; background:#f4f4f4; overflow:hidden; margin:13px 0px 30px;}
.audit_total_room_left{padding:5px; width:210px; float:left; font-size:22px;}
.audit_total_room_right{padding:5px; float:right; font-size:22px;}
.audit_today_tomorrows_main{padding:5px; overflow:hidden;}
.audit_arrival_left{width:100px; float:left; padding:30px 2px;}
.audit_arrival_left_again{width:130px; float:left; padding:30px 2px;}
.audit_arrival_right{float:right; background:url("images/pink_right.png") no-repeat 0px 0px; height:115px; padding:2px; width:98px; text-align:center; line-height:90px; color:#FFF;}
.audit_arrival_right_again{float:right; background:url("images/green_right.png") no-repeat 0px 0px; height:115px; padding:2px; width:98px; text-align:center; line-height:90px; color:#FFF;}

.audit_right{width:460px; float:right; padding:5px;}
.audit_ricktangle_main{padding:10px 0px; border-bottom:1px solid #CCC; overflow:hidden;}
.audit_ricktangle_room_left{padding:25px 3px 3px; width:155px; float:left; font-size:22px;}
.audit_ricktangle_room_right{padding:3px; width:285px; float:right;}
.audit_rectackt_one{width:80px; float:left; background:#7c3f13; margin-right:15px;}
.audit_rectackt_two{width:80px; float:left; background:#557778; margin-right:15px;}
.audit_rectackt_three{width:80px; float:left; background:#f32323; margin-right:9px;}
.audit_rectackt_top{color:#FFF; border-bottom:1px solid #fff; padding:10px 0px; text-align:center;}
.audit_rectackt_bottom{color:#FFF; padding:20px 0px; font-size:21px; text-align:center;}
.today_total_main{width:115px; float:right; margin:5px; overflow:hidden;}
.today_total_button a{width:50px; text-align:right; float:left; color:#000;font-weight:bold; font-family:Arial, Helvetica, sans-serif;}

/*ROOM CODE END HERE*/

/*SPAN CODE START HERE*/

.span1{font-size:15px;}
.span2{color:#a42a00;}
.span3{color:#996633;}
.span4{color:#666666;}
.span5{color:#900; text-align:center; padding:10px 0px;}
.span6{color:#333; text-align:center; font-weight:bold; padding:5px;}
.span7{color:#333; text-align:center; padding:10px 0px;}
.span9{font:normal 16px Arial, Helvetica, sans-serif; color:#666;}
.span8{font-size:12px; color:#666;}
.span10{color:#333; line-height:25px; font-size:13px; }
.span10 a{color:#0075a5;}
.span11{font-size:21px;}
.span12{font-weight:normal;}
.span13{font-size:21px; color:#e08600;}
.span14{font-size:15px; color:#F60;}
.span15_green{color:#090; font-weight:bold; font-family:Arial, Helvetica, sans-serif;}
.span15_red{color:#F00; font-weight:bold; font-family:Arial, Helvetica, sans-serif;}
.span15_orange{color:#FF6600; font-weight:bold; font-family:Arial, Helvetica, sans-serif;}
.span16{color:#900; font-size:15px;}
.span17{color:#666; font-size:16px;}
.span18{font-size:16px; color:#930;}
.span19{font:normal 18px Arial, Helvetica, sans-serif; color:#591900;}
.span20{color:#591900; font-size:14px;}
.span21{color:#5b1800; font-size:14px;}
.span22{visibility:hidden;}

p{font:normal 12px/17px Arial, Helvetica, sans-serif; color:#666; margin:5px 0px;}
hr{color:#CCC; margin:10px 0px;}

.news_red{margin:0px; padding:2px 5px 2px 30px; border-bottom:1px solid #CCC; color:#F00; background:#fff url("image/cross_icons.png") no-repeat 2px 5px;}
.news_green{margin:0px; padding:2px 5px 2px 30px; border-bottom:1px solid #CCC; color:#090; background:#fff url("image/right_icons.png") no-repeat 2px 5px;}
/*SPAN CODE START HERE*/

</style>
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
		 <div class="navigaion_new_right">
      <div class="audit_room">
        <div class="audit_main">
       
         <?php $report_obj->RoomStatus();?>
          <?php //$report_obj->RoomAvalbilityStatus();?>
         
          
        </div>
        <br />
        <br />
      </div>
    </div>
		
	</div>

  <script type="text/javascript" src="js/jquery.js"></script>
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
        $(".spk1").sparkline([2,4,3,6,7,5,8,9,4,2,6,8,8,9,10], { type: 'bar', width: '80px', barColor: '#4A8CF7'});
        $(".spk2").sparkline([4,6,7,7,4,3,2,1,4,4 ,5,6,5], { type: 'discrete', width: '80', lineColor: '#4A8CF7',thresholdValue: 4,thresholdColor: '#ff0000'});
        $(".spk4").sparkline([2,4,3,6,7,5,8,9,4,2,10,], { type: 'bar', width: '80px', height: '30px',barColor: '#EA6153'});
        $(".spk5").sparkline([5,3,5,6,5,7,4,8,6,9,8,], { type: 'bar', width: '80px', height: '30px',barColor: '#4AA3DF'});
      
        $(".spk3").sparkline([5,6,7,9,9,5,3,2,2,4,6,7], {
        type: 'line',
        lineColor: '#258FEC',
        fillColor: '#4A8CF7',
        spotColor: false,
        width: '80px',
        minSpotColor: false,
        maxSpotColor: false,  
        highlightSpotColor: '#1e7ac6',
        highlightLineColor: '#1e7ac6'});
     
        //Maps 
        $('#world-map').vectorMap({
          map: 'world_mill_en',
          backgroundColor: 'transparent',
          regionStyle: {
            initial: {
              fill: '#38c3c1',
            },
            hover: {
              "fill-opacity": 0.8
            }
          },
          markerStyle:{
              initial:{
                r: 10
              },
               hover: {
                r: 12,
                stroke: 'rgba(255,255,255,0.8)',
                "stroke-width": 4
              }
            },
            markers: [
                {latLng: [41.90, 12.45], name: '1.512 Visits', style: {fill: '#E44C34',stroke:'rgba(255,255,255,0.7)',"stroke-width": 3}},
                {latLng: [1.3, 103.8], name: '940 Visits', style: {fill: '#E44C34',stroke:'rgba(255,255,255,0.7)',"stroke-width": 3}},
                {latLng: [51.511214, -0.119824], name: '530 Visits', style: {fill: '#E44C34',stroke:'rgba(255,255,255,0.7)',"stroke-width": 3}},
                {latLng: [40.714353, -74.005973], name: '340 Visits', style: {fill: '#E44C34',stroke:'rgba(255,255,255,0.7)',"stroke-width": 3}},
                {latLng: [-22.913395, -43.200710], name: '1.800 Visits', style: {fill: '#E44C34',stroke:'rgba(255,255,255,0.7)',"stroke-width": 3}}
            ]
        });
        
        /*Pie Chart*/
        var data = [
        { label: "Google", data: 50},
        { label: "Dribbble", data: 15},
        { label: "Twitter", data: 12},
        { label: "Youtube", data: 14},
        { label: "Microsoft", data: 14}
        ]; 

        $.plot('#ticket-chart', data, {
          series: {
            pie: {
              show: true,
              innerRadius: 0.5,
              shadow:{
                top: 5,
                left: 15,
                alpha:0.3
              },
              stroke:{
                width:0
              },
              label: {
                show: false
              },
              highlight:{
                opacity: 0.08
              }
            }
          },
          grid: {
            hoverable: true,
            clickable: true
          },
          colors: ["#5793f3", "#19B698","#dd4444","#fd9c35","#fec42c","#d4df5a","#5578c2"],
          legend: {
            show: false
          }
        });
        
        $("table td .legend").each(function(){
          var el = $(this);
          var color = el.data("color");
          el.css("background",color);
        });

      });
    </script>
    	<script type="text/javascript" src="js/jquery.magnific-popup/dist/jquery.magnific-popup.min.js"></script>
   
  <script type="text/javascript">
    $(document).ready(function(){
    
      $('.image-zoom').magnificPopup({ 
        type: 'image',
        mainClass: 'mfp-with-zoom', // this class is for CSS animation below
        zoom: {
          enabled: true, // By default it's false, so don't forget to enable it
          duration: 300, // duration of the effect, in milliseconds
          easing: 'ease-in-out', // CSS transition easing function 
          opener: function(openerElement) {
            var parent = $(openerElement);
            return parent;
          }
        }
      });
      
      //Nifty Modals Init
      $('.md-trigger').modalEffects();
      
      //Summernote Editor
      $('#summernote').summernote({ 
        height: 100,
        toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']]
      ]});
    });
  </script>

    <script src="js/behaviour/voice-commands.js"></script>
  <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.flot/jquery.flot.js"></script>
	<script type="text/javascript" src="js/jquery.flot/jquery.flot.pie.js"></script>
	<script type="text/javascript" src="js/jquery.flot/jquery.flot.resize.js"></script>
	<script type="text/javascript" src="js/jquery.flot/jquery.flot.labels.js"></script>
  </body>

<!-- Mirrored from condorthemes.com/cleanzone/dashboard2.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 30 Mar 2014 17:44:40 GMT -->
</html>
