<?php
extract($_REQUEST);
require_once('class/config.inc.php');
require_once('class/class.StockTransfer.php');
$auth = new Authentication();
$auth->CheckAdminlogin();
$layout_obj = new DesignLayout();
$notice_obj = new Notification();
$controller = 'Inventory';
$action = 'addstock';
$stock_obj = new StockTransfer();
$ajax = new PHPLiveX();
$ajax->AjaxifyObjects(array("stock_obj")); 
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

    
    <link rel='stylesheet' type='text/css' href='css_inv/style.css' />
	<link rel='stylesheet' type='text/css' href='css_inv/print.css' media="print" />
    
    
   
	<script type='text/javascript' src='js_inv/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='js_inv/example1.js'></script> 
    <script type='text/javascript' src='js/print.js'></script>    
 
  
 <?php $ajax->Run('liveX/phplivex.js');?>

</head>

<body>

		  <?php 
		  switch($index)
		  {
			  case 'printreceipt':
			  $stock_obj->PrintIssuedTicketToBanquetStock($issuedId);
			  break;
			  case 'transfer_banquet':
			        if($transferdata=='Transfer Item')
									$stock_obj->newTransfer('server','BT');
					else			
									$stock_obj->newTransfer('local','BT');
			  break;
			  case 'transfer_kitchen':
			        if($transferdata=='Transfer Item')
									$stock_obj->newTransfer('server','KT');
					else			
									$stock_obj->newTransfer('local','KT');
			  break;
			  default:
					echo 'Invalid Argument';
			  break;
		  }
		?>	
 
  </body>

</html>
