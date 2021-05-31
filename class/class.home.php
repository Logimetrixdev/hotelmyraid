<?php 
class Home
{
		function __construct()
	{
					$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
					$this->validity = new ClsJSFormValidation();
					$this->Form = new ValidateForm();
					$this->auth=new Authentication();
					$this->noti=new Notification();
	}
	
	function Header()
	{
		
		?>
         <header>
                <div class="navbar navbar-fixed-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">
                            <a class="brand" href="home.php"><i class="icon-home icon-white"></i> <?php echo WEB_TITLE;?> </a>
                            <ul class="nav user_menu pull-right">
                                
                                
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-transform:capitalize;"><img src="img/user_avatar.png" alt="" class="user_avatar" /> <?php echo $_SESSION['user_name']; ?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="logout.php">Log Out</a></li>
                                         <li><a href="changepassword.php">Change Password</a></li>
                                    </ul>
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                </div>
                
                
            </header> 
          
        
        <?php
		
		
		}
		
		
		function Sidebar()
		{
							$sql="select * from ".INFINITE_USER_AUTH." where user_id = '".$_SESSION['user_id']."'";
							$result= $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($result);
			?>
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
                
                <div class="antiScroll">
                    <div class="antiscroll-inner">
                        <div class="antiscroll-content">
                    
                            <div class="sidebar_inner">
                                <form action="#" class="input-append" method="post" >
                                   
                                </form>
                                <div id="side_accordion" class="accordion">
                                <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a href="#collapseseven" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                                <img width="25" height="25" style="padding-right:10px;" src="img/gCons/computer.png"> Dashboard
                                            </a>
                                        </div>
                                        <div class="accordion-body collapse" id="collapseseven">
                                            <div class="accordion-inner">
                                                <ul class="nav nav-list">
                                                    <li><a href="home.php">Dashboard</a></li>
                                                   
                                                    
                                                </ul>
                                                
                                            </div>
                                        </div>
                                    </div>
                                <?php if($row['supplier'] == 'yes'){ ?>
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a href="#collapseThree" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                                <img width="25" height="25" style="padding-right:10px;" src="./img/gCons/male-user.png"> Manage Supplier
                                            </a>
                                        </div>
                                        <div class="accordion-body collapse" id="collapseThree">
                                            <div class="accordion-inner">
                                                <ul class="nav nav-list">
                                                    <li><a href="add_supplier.php">Add Supplier</a></li>
                                                    <li><a href="all_supplier.php">View & Edit</a></li>
                                                    
                                                </ul>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if($row['client'] == 'yes'){ ?>
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a href="#collapseOne" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                                <img width="25" height="25" style="padding-right:10px;" src="./img/gCons/male-user.png"> Manage Clients
                                            </a>
                                        </div>
                                        <div class="accordion-body collapse" id="collapseOne">
                                            <div class="accordion-inner">
                                                <ul class="nav nav-list">
                                                    <li><a href="add_client.php">Add Client</a></li>
                                                    <li><a href="all_client.php">View & Edit</a></li>
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } if($row['user'] == 'yes'){ ?>
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a href="#collapseTwo" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                                <img width="25" height="25" style="padding-right:10px;" src="./img/gCons/male-user.png"> Manage User
                                            </a>
                                        </div>
                                        <div class="accordion-body collapse" id="collapseTwo">
                                            <div class="accordion-inner">
                                                <ul class="nav nav-list">
                                                    <li><a href="add_user.php">Add User</a></li>
                                                    <li><a href="all_user.php">View & Edit</a></li>
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php }  ?>
                                    
                                    <?php  if($row['inventory'] == 'yes'){ ?>
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a href="#collapsefive" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                                <img width="25" height="25" style="padding-right:10px;" src="img/gCons/van.png"/> Manage Stock
                                            </a>
                                        </div>
                                        <div class="accordion-body collapse" id="collapsefive">
                                            <div class="accordion-inner">
                                                <ul class="nav nav-list">
                                                 <li><a href="show_all_product.php">All Product</a></li>
                                                    <li><a href="add_product_detail.php">Add Stock</a></li>
                                                    <li><a href="all_product_detail.php">View & Edit</a></li>
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <?php } if($row['billing'] == 'yes'){ ?>
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a href="#collapsesix" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                                <img width="25" height="25" style="padding-right:10px;" src="img/gCons/fancy-globe.png"/>Billing
                                            </a>
                                        </div>
                                        <div class="accordion-body collapse" id="collapsesix">
                                            <div class="accordion-inner">
                                                <ul class="nav nav-list">
                                                    <li><a href="create_invoice.php">Billing</a></li>
                                                     <li><a href="show_allinvoice.php">Show All Invoices</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <?php } if($row['expendeture'] == 'yes'){ ?>
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a href="#collapsefour" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                                <img width="25" height="25" style="padding-right:10px;" src="img/gCons/push-pin.png"/>Expendeture
                                            </a>
                                        </div>
                                        <div class="accordion-body collapse" id="collapsefour">
                                            <div class="accordion-inner">
                                                <ul class="nav nav-list">
                                                 	<li><a href="expences.php">View Expenses</a></li>	
                                                    <li><a href="expandeture.php">View profit</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <?php } ?>
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a href="#collapse7" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                               <i class="icon-th"></i> Calculator
                                            </a>
                                        </div>
                                        <div class="accordion-body collapse in" id="collapse7">
                                            <div class="accordion-inner">
                                                <form name="Calc" id="calc">
                                                    <div class="formSep control-group input-append">
                                                        <input type="text" style="width:130px" name="Input" /><button type="button" class="btn" name="clear" value="c" onClick="Calc.Input.value = ''"><i class="icon-remove"></i></button>
                                                    </div>
                                                    <div class="control-group">
                                                        <input type="button" class="btn btn-large" name="seven" value="7" onClick="Calc.Input.value += '7'" />
                                                        <input type="button" class="btn btn-large" name="eight" value="8" onClick="Calc.Input.value += '8'" />
                                                        <input type="button" class="btn btn-large" name="nine" value="9" onClick="Calc.Input.value += '9'" />
                                                        <input type="button" class="btn btn-large" name="div" value="/" onClick="Calc.Input.value += ' / '">
                                                    </div>
                                                    <div class="control-group">
                                                        <input type="button" class="btn btn-large" name="four" value="4" onClick="Calc.Input.value += '4'" />
                                                        <input type="button" class="btn btn-large" name="five" value="5" onClick="Calc.Input.value += '5'" />
                                                        <input type="button" class="btn btn-large" name="six" value="6" onClick="Calc.Input.value += '6'" />
                                                        <input type="button" class="btn btn-large" name="times" value="x" onClick="Calc.Input.value += ' * '" />
                                                    </div>
                                                    <div class="control-group">
                                                        <input type="button" class="btn btn-large" name="one" value="1" onClick="Calc.Input.value += '1'" />
                                                        <input type="button" class="btn btn-large" name="two" value="2" onClick="Calc.Input.value += '2'" />
                                                        <input type="button" class="btn btn-large" name="three" value="3" onClick="Calc.Input.value += '3'" />
                                                        <input type="button" class="btn btn-large" name="minus" value="-" onClick="Calc.Input.value += ' - '" />
                                                    </div>
                                                    <div class="formSep control-group">
                                                        <input type="button" class="btn btn-large" name="dot" value="." onClick="Calc.Input.value += '.'" />
                                                        <input type="button" class="btn btn-large" name="zero" value="0" onClick="Calc.Input.value += '0'" />
                                                        <input type="button" class="btn btn-large" name="DoIt" value="=" onClick="Calc.Input.value = Math.round( eval(Calc.Input.value) * 1000)/1000" />
                                                        <input type="button" class="btn btn-large" name="plus" value="+" onClick="Calc.Input.value += ' + '" />
                                                    </div>
                                                   
                                                </form>
                                            </div>
                                         </div>
                                    </div>
                                </div>
                                
                                
                            </div>
                               
                             
                        
                        </div>
                    </div>
                </div>
            
            </div>
            <?php
		}
		
		function All_Css()
		{
			?>
            
        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
            <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css" />
        <!-- breadcrumbs-->
            <link rel="stylesheet" href="lib/jBreadcrumbs/css/BreadCrumb.css" />
        <!-- tooltips-->
            <link rel="stylesheet" href="lib/qtip2/jquery.qtip.min.css" />
        <!-- colorbox -->
            <link rel="stylesheet" href="lib/colorbox/colorbox.css" />    
        <!-- code prettify -->
            <link rel="stylesheet" href="lib/google-code-prettify/prettify.css" />    
        <!-- notifications -->
            <link rel="stylesheet" href="lib/sticky/sticky.css" />    
        <!-- splashy icons -->
            <link rel="stylesheet" href="img/splashy/splashy.css" />
        <!-- flags -->
            <link rel="stylesheet" href="img/flags/flags.css" />    
        <!-- calendar -->
            <link rel="stylesheet" href="lib/fullcalendar/fullcalendar_gebo.css" />
            
        <!-- gebo color theme-->
            <link id="link_theme" rel="stylesheet" href="css/tamarillo.css">
        <!-- main styles -->
            <link rel="stylesheet" href="css/style.css" />
            
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans" />
    
        <!-- Favicon -->
            
        
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/ie.css" />
            <script src="js/ie/html5.js"></script>
            <script src="js/ie/respond.min.js"></script>
            <script src="lib/flot/excanvas.min.js"></script>
        <![endif]-->
        
        <script>
            //* hide all elements & show preloader
            document.documentElement.className += 'js';
        </script>
            <?php
		}
	
	
		function All_Javascript()
		{
			?>
              <script src="js/jquery.min.js"></script>
            <script src="js/jquery-migrate.min.js"></script>
            <!-- smart resize event -->
            <script src="js/jquery.debouncedresize.min.js"></script>
            <!-- hidden elements width/height -->
            <script src="js/jquery.actual.min.js"></script>
            <!-- js cookie plugin -->
            <script src="js/jquery_cookie.min.js"></script>
            <!-- main bootstrap js -->
            <script src="bootstrap/js/bootstrap.min.js"></script>
            <!-- bootstrap plugins -->
            <script src="js/bootstrap.plugins.min.js"></script>
            <!-- tooltips -->
            <script src="lib/qtip2/jquery.qtip.min.js"></script>
            <!-- jBreadcrumbs -->
            <script src="lib/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min.js"></script>
            <!-- lightbox -->
            <script src="lib/colorbox/jquery.colorbox.min.js"></script>
            <!-- fix for ios orientation change -->
            <script src="js/ios-orientationchange-fix.js"></script>
            <!-- scrollbar -->
            <script src="lib/antiscroll/antiscroll.js"></script>
            <script src="lib/antiscroll/jquery-mousewheel.js"></script>
            <!-- to top -->
            <script src="lib/UItoTop/jquery.ui.totop.min.js"></script>
            <!-- mobile nav -->
            <script src="js/selectNav.js"></script>
            <!-- common functions -->
            <script src="js/gebo_common.js"></script>
            
            <script src="lib/jquery-ui/jquery-ui-1.10.0.custom.min.js"></script>
            <!-- touch events for jquery ui-->
            <script src="js/forms/jquery.ui.touch-punch.min.js"></script>
            <!-- multi-column layout -->
            <script src="js/jquery.imagesloaded.min.js"></script>
            <script src="js/jquery.wookmark.js"></script>
            <!-- responsive table -->
            <script src="js/jquery.mediaTable.min.js"></script>
            <!-- small charts -->
            <script src="js/jquery.peity.min.js"></script>
            <!-- charts -->
            <script src="lib/flot/jquery.flot.min.js"></script>
            <script src="lib/flot/jquery.flot.resize.min.js"></script>
            <script src="lib/flot/jquery.flot.pie.min.js"></script>
            <!-- calendar -->
            <script src="lib/fullcalendar/fullcalendar.min.js"></script>
            <!-- sortable/filterable list -->
            <script src="lib/list_js/list.min.js"></script>
            <script src="lib/list_js/plugins/paging/list.paging.js"></script>
            <!-- dashboard functions -->
            <script src="js/gebo_dashboard.js"></script>
    
            <script>
                $(document).ready(function() {
                    //* show all elements & remove preloader
                    setTimeout('$("html").removeClass("js")',1000);
                });
            </script>
            <?php
		}
		
		
		
		
		
		
		
		function bodyclass()
		{
			echo 'class="menu_hover"';
		}
		
		
	
}
?>