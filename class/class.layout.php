<?php

/* 
 * This class is responcible for the layout design of HMS
 * Author: Abhishek Kumar Mishra
 * Created Date: 30/3/2014
 */

class DesignLayout
{
	
	function __construct()
	{
					$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
					$this->validity = new ClsJSFormValidation();
					$this->Form = new ValidateForm();
					$this->auth=new Authentication();
					$this->noti=new Notification();
					$this->Master=new MasterClass();
	}
	

    function TopMenuBar($controller='',$action='')
    {
        ?>
                <div id="head-nav" class="navbar navbar-default navbar-fixed-top">
                    <div class="container-fluid">
                      <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                          <span class="fa fa-gear"></span>
                        </button>
                        <a class="navbar-brand" href="dashboard.php"><span>Hotel App</span></a>
                      </div>
                      <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                          <li  <?php if($controller=='dashboard') { echo 'class="active"';}?>><a href="dashboard.php">Dashboard</a></li>
						    <li class="dropdown <?php if($controller=='reservation') { echo 'active';}?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Front Desk <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <li><a href="add_reservation.php">New Confirm Reservation</a></li>
                        <li><a href="reservation_lising.php">Confirm  List</a></li>
						<li><a href="add_tentative.php">New Tentative Reservation</a></li>
                        <li><a href="tentative_lising.php">Tentative List</a></li>
                        <li><a href="availibility.php?index=res">Check Availability</a></li>
  
                      	</ul>
                        </li>
                         <li class="dropdown <?php if($controller=='banquet') { echo 'active';}?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Banquet <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <li><a href="banquet_reservation.php">New Booking</a></li>
                        <li><a href="banquet_listing.php">Booking List</a></li>
                        <li><a href="banquet_availibility.php?index=banquet">Check Availability</a></li>
                      	</ul>
                        </li>
                        <li class="dropdown <?php if($controller=='Kot') { echo 'active';}?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">KOT <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <li><a href="addkot.php">Generate KOT</a></li>
                      <!--  <li><a href="viewkots.php">View KOT's</a></li>-->
                      	</ul>
                        </li>
                        
                         <li><a href="managehousekeeping.php">HouseKeeping</a></li>
                         <?php
                         if($_SESSION['user_type']==1 or $_SESSION['user_type']==2)
						{
							?>
                          <li><a href="viewAllusers.php">All Settings</a></li>
                          <?php
						}
						?>
                          <!--<li><a href="#">KOT</a></li>-->
                       
                          <!--<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Large menu <b class="caret"></b></a>
                      <ul class="dropdown-menu col-menu-2">
                        <li class="col-sm-6 no-padding">
                          <ul>
                          <li class="dropdown-header"><i class="fa fa-group"></i>Users</li>
                          <li><a href="#">Action</a></li>
                          <li><a href="#">Another action</a></li>
                          <li><a href="#">Something else here</a></li>
                          <li class="dropdown-header"><i class="fa fa-gear"></i>Config</li>
                          <li><a href="#">Action</a></li>
                          <li><a href="#">Another action</a></li>
                          <li><a href="#">Something else here</a></li> 
                          </ul>
                        </li>
                        <li  class="col-sm-6 no-padding">
                          <ul>
                          <li class="dropdown-header"><i class="fa fa-legal"></i>Sales</li>
                          <li><a href="#">New sale</a></li>
                          <li><a href="#">Register a product</a></li>
                          <li><a href="#">Register a client</a></li> 
                          <li><a href="#">Month sales</a></li>
                          <li><a href="#">Delivered orders</a></li>
                          </ul>
                        </li>
                      </ul>
                          </li>-->
                        </ul>
                        <?php
						   $sql_folder="select * from ".HMS_USER_PIC." where user_id='".$_SESSION['user_id']."'";
							$records_folder = $this->db->query($sql_folder,__FILE__,__LINE__);
							$row_folder = $this->db->fetch_array($records_folder);
						?>
                    <ul class="nav navbar-nav navbar-right user-nav">
                      <li class="dropdown profile_menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <?php
			  if($row_folder['user_pic']!='')
			  {
				?>
                 <img  style="border-radius: 30px;
    height: 35px;
    width: 35px;" src="user_pic/<?php echo $row_folder['user_pic'];?>">
               
                <?php
			  }
			  else
			  {
				  ?>
                  <img  style="border-radius: 30px;
    height: 35px;
    width: 35px;" src="images/avatar2.jpg">
                  <?php
			  }
			  ?>
             <?php echo ucwords($_SESSION['user_name']);?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        	<li><a href="#" style="font-weight:600;"><?php echo $this->Master->GetUserLevelByUserTypeId($_SESSION['user_type']);?></a></li>
                          
                          <li><a href="profile_view.php?user_id=<?php echo $_SESSION['user_id'];?>">Profile</a></li>
                          <li><a href="profile_view.php?index=profile_edit&user_id=<?php echo $_SESSION['user_id'];?>">Edit Profile</a></li>
                           <li><a href="profile_view.php?index=change_pass">Change Password</a></li>
                          <li class="divider"></li>
                          <li><a href="logout.php">Sign Out</a></li>
                        </ul>
                      </li>
                    </ul>			
                    <!--<ul class="nav navbar-nav navbar-right not-nav" >
                      <li class="button dropdown">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class=" fa fa-comments"></i></a>
                        <ul class="dropdown-menu messages">
                          <li>
                            <div class="nano nscroller">
                              <div class="content">
                                <ul>
                                  <li>
                                    <a href="#">
                                      <img src="images/avatar2.jpg" alt="avatar" /><span class="date pull-right">13 Sept.</span> <span class="name">Daniel</span> I'm following you, and I want your money! 
                                    </a>
                                  </li>
                                  <li>
                                    <a href="#">
                                      <img src="images/avatar_50.jpg" alt="avatar" /><span class="date pull-right">20 Oct.</span><span class="name">Adam</span> is now following you 
                                    </a>
                                  </li>
                                  <li>
                                    <a href="#">
                                      <img src="images/avatar4_50.jpg" alt="avatar" /><span class="date pull-right">2 Nov.</span><span class="name">Michael</span> is now following you 
                                    </a>
                                  </li>
                                  <li>
                                    <a href="#">
                                      <img src="images/avatar3_50.jpg" alt="avatar" /><span class="date pull-right">2 Nov.</span><span class="name">Lucy</span> is now following you 
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                            <ul class="foot"><li><a href="#">View all messages </a></li></ul>           
                          </li>
                        </ul>
                      </li>
                      <li class="button dropdown">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-globe"></i><span class="bubble">2</span></a>
                        <ul class="dropdown-menu">
                          <li>
                            <div class="nano nscroller">
                              <div class="content">
                                <ul>
                                  <li><a href="#"><i class="fa fa-cloud-upload info"></i><b>Daniel</b> is now following you <span class="date">2 minutes ago.</span></a></li>
                                  <li><a href="#"><i class="fa fa-male success"></i> <b>Michael</b> is now following you <span class="date">15 minutes ago.</span></a></li>
                                  <li><a href="#"><i class="fa fa-bug warning"></i> <b>Mia</b> commented on post <span class="date">30 minutes ago.</span></a></li>
                                  <li><a href="#"><i class="fa fa-credit-card danger"></i> <b>Andrew</b> killed someone <span class="date">1 hour ago.</span></a></li>
                                </ul>
                              </div>
                            </div>
                            <ul class="foot"><li><a href="#">View all activity </a></li></ul>           
                          </li>
                        </ul>
                      </li>
                      <li class="button"><a href="javascript:;" class="speech-button"><i class="fa fa-microphone"></i></a></li>				
                    </ul>-->

                      </div><!--/.nav-collapse animate-collapse -->
                    </div>
                  </div>
        <?php
    }

	
	

 function MenuBar($controller='',$action='')
	{
		
	?>
    
	<div class="cl-sidebar" data-position="right">
			<div class="cl-toggle"><i class="fa fa-bars"></i></div>
			<div class="cl-navblock">
        <div class="menu-space">
          <div class="content">
            <div class="side-user">
            </div>
	<ul class="cl-vnavigation">
	         <li <?php if($controller=='dashboard') { echo 'class="active"';}?>><a href="dashboard.php"><i class="fa fa-home"></i><span>Dashboard</span></a></li>
             <li <?php if($controller=='UserSettings') { echo 'class="active"';}?>><a href="#"><i class="fa fa-gears"></i><span>Users Settings</span></a>
                <ul class="sub-menu">
                <li <?php if($controller=='UserSettings' && $action=='CreateUser') { echo 'class="active"';}?>><a href="addusers.php">Create User</a></li>
                 <li <?php if($controller=='UserSettings' && $action=='AllUser') { echo 'class="active"';}?>><a href="viewAllusers.php">All Users</a></li>
                </ul>
              </li>
              
			  <li <?php if($controller=='RoomSettings') { echo 'class="active"';}?>><a href="#"><i class="fa fa-gears"></i><span>Room Settings</span></a>
                <ul class="sub-menu">
                <li <?php if($controller=='RoomSettings' && $action=='RoomType') { echo 'class="active"';}?>><a href="manageroom_types.php">Room Types</a></li>
                 <li <?php if($controller=='RoomSettings' && $action=='Rooms') { echo 'class="active"';}?>><a href="managerooms.php">Rooms</a></li>
                </ul>
              </li>
              <li <?php if($controller=='OtherSettings') { echo 'class="active"';}?>><a href="#"><i class="fa fa-gears"></i><span>Other Settings</span></a>
                <ul class="sub-menu">
                <li <?php if($controller=='OtherSettings' && $action=='BanquetMenu') { echo 'class="active"';}?>><a href="banquet_menus.php">Banquet Menu</a></li>
                <li <?php if($controller=='OtherSettings' && $action=='KotMenu') { echo 'class="active"';}?>><a href="kot_menus.php">F&B Menu</a></li>
                <li <?php if($controller=='OtherSettings' && $action=='TaxManagement') { echo 'class="active"';}?>><a href="managetaxes.php">Tax Management</a></li>
                <li <?php if($controller=='OtherSettings' && $action=='IDType') { echo 'class="active"';}?>><a href="manageIdType.php">ID Type Management</a></li>
                <li <?php if($controller=='OtherSettings' && $action=='MarketPlace') { echo 'class="active"';}?>><a href="marketplace.php">Market Place Management</a></li>
                 <li <?php if($controller=='OtherSettings' && $action=='SourceInfo') { echo 'class="active"';}?>><a href="sourceinfo.php">Source Info Management</a></li>
				 
				  <li <?php if($controller=='OtherSettings' && $action=='EventType') { echo 'class="active"';}?>><a href="eventtype.php">Event Type</a></li>
				  
				  <li <?php if($controller=='OtherSettings' && $action=='Banquet') { echo 'class="active"';}?>><a href="banquet.php">Banquet</a></li>
				  
				  <li <?php if($controller=='OtherSettings' && $action=='Distributor') { echo 'class="active"';}?>><a href="distributor.php">Distributor</a></li>
                 
                </ul>
              </li>


    <li <?php if($controller=='InventorySettings') { echo 'class="active"';}?>><a href="#"><i class="fa fa-gears"></i><span>Inventory Settings</span></a>
    <ul class="sub-menu">
    <li <?php if($controller=='InventorySettings' && $action=='PurchaseHeaders') { echo 'class="active"';}?>><a href="purchase_headers.php">Purchase Headers Category</a></li>
     <li <?php if($controller=='InventorySettings' && $action=='PurchaseHeadersProduct') { echo 'class="active"';}?>><a href="purchase_headers_category.php">Purchase Headers Sub-Category</a></li>
      <li <?php if($controller=='InventorySettings' && $action=='UnitType') { echo 'class="active"';}?>><a href="unittype.php">Purchase Unit Type</a></li>
    </ul>
    </li>
        <li <?php if($controller=='Inventory') { echo 'class="active"';}?>><a href="#"><i class="fa fa-gears"></i><span>Manage Stock</span></a>
    <ul class="sub-menu">
    <li <?php if($controller=='Inventory' && $action=='addstock') { echo 'class="active"';}?>><a href="addstock.php">Add Stock</a></li>
  	<li <?php if($controller=='Inventory' && $action=='viewstock') { echo 'class="active"';}?>><a href="viewallstock.php">View All Stock</a></li>
    </ul>
    </li>
	  
      <li <?php if($controller=='Report') { echo 'class="active"';}?>><a href="#"><i class="fa fa-gears"></i><span>Reporting</span></a>
    <ul class="sub-menu">
    <li  <?php if($controller=='Report' && $action=='RoomReport') { echo 'class="active"';}?>><a href="room_reporting.php">Room Status Reporting</a></li>
    <li  <?php if($controller=='Report' && $action=='SaleReport') { echo 'class="active"';}?>><a href="sales_reporting.php?index=sales">Sales Reporting</a></li>
  	
     <li  <?php if($controller=='Report' && $action=='SaleBanquetReport') { echo 'class="active"';}?>><a href="sales_banquet_reporting.php?index=sales">Banquet Hall Only  Reporting</a></li>
      <li  <?php if($controller=='Report' && $action=='SaleBanquetPaxReport') { echo 'class="active"';}?>><a href="sales_banquet_reporting_pax.php?index=sales">Banquet Reporting With Pax</a></li>
    <li  <?php if($controller=='Report' && $action=='Kt') { echo 'class="active"';}?>><a href="kt_reporting.php?index=sales">KOT Reporting</a></li>
    <li  <?php if($controller=='Report' && $action=='TaxReport') { echo 'class="active"';}?>><a href="tax_report.php">Tax Reporting</a></li>
	
	
	 
     
    </ul>
    </li>        




			  
			  
             <!-- <li><a href="#"><i class="fa fa-smile-o"></i><span>UI Elements</span></a>
                <ul class="sub-menu">
                  <li><a href="ui-elements.html">General</a></li>
                  <li><a href="ui-buttons.html">Buttons</a></li>
                  <li><a href="ui-modals.html"><span class="label label-primary pull-right">New</span> Modals</a></li>
                  <li><a href="ui-notifications.html"><span class="label label-primary pull-right">New</span> Notifications</a></li>
                  <li><a href="ui-icons.html">Icons</a></li>
                  <li><a href="ui-grid.html">Grid</a></li>
                  <li><a href="ui-tabs-accordions.html">Tabs & Acordions</a></li>
                  <li><a href="ui-nestable-lists.html">Nestable Lists</a></li>
                  <li><a href="ui-treeview.html">Tree View</a></li>
                </ul>
              </li>
              <li><a href="#"><i class="fa fa-list-alt"></i><span>Forms</span></a>
                <ul class="sub-menu">
                  <li><a href="form-elements.html">Components</a></li>
                  <li><a href="form-validation.html">Validation</a></li>
                  <li><a href="form-wizard.html">Wizard</a></li>
                  <li><a href="form-masks.html">Input Masks</a></li>
                  <li><a href="form-multiselect.html"><span class="label label-primary pull-right">New</span>Multi Select</a></li>
                  <li><a href="form-wysiwyg.html"><span class="label label-primary pull-right">New</span>WYSIWYG Editor</a></li>
                  <li><a href="form-upload.html"><span class="label label-primary pull-right">New</span>Multi Upload</a></li>
                </ul>
              </li>
              <li><a href="#"><i class="fa fa-table"></i><span>Tables</span></a>
                <ul class="sub-menu">
                  <li><a href="tables-general.html">General</a></li>
                  <li><a href="tables-datatables.html"><span class="label label-primary pull-right">New</span>Data Tables</a></li>
                </ul>
              </li>              
              <li><a href="#"><i class="fa fa-map-marker nav-icon"></i><span>Maps</span></a>
                <ul class="sub-menu">
                  <li><a href="maps.html">Google Maps</a></li>
                  <li><a href="vector-maps.html"><span class="label label-primary pull-right">New</span>Vector Maps</a></li>
                </ul>
              </li>             
              <li><a href="#"><i class="fa fa-envelope nav-icon"></i><span>Email</span></a>
                <ul class="sub-menu">
                  <li><a href="email-inbox.html">Inbox</a></li>
                  <li><a href="email-read.html">Email Detail</a></li>
                  <li><a href="email-compose.html"><span class="label label-primary pull-right">New</span>Email Compose</a></li>
                </ul>
              </li>
              <li><a href="typography.html"><i class="fa fa-text-height"></i><span>Typography</span></a></li>
              <li><a href="charts.html"><i class="fa fa-bar-chart-o"></i><span>Charts</span></a></li>
              <li><a href="#"><i class="fa fa-file"></i><span>Pages</span></a>
                <ul class="sub-menu">
                  <li><a href="pages-blank.html">Blank Page</a></li>
                  <li><a href="pages-blank-header.html">Blank Page Header</a></li>
                  <li><a href="pages-blank-aside.html">Blank Page Aside</a></li>
                  <li><a href="pages-login.html">Login</a></li>
                  <li><a href="pages-404.html">404 Page</a></li>
                  <li><a href="pages-500.html">500 Page</a></li>
                  <li><a href="pages-sign-up.html"><span class="label label-primary pull-right">New</span>Sign Up</a></li>
                  <li><a href="pages-forgot-password.html"><span class="label label-primary pull-right">New</span>Forgot Password</a></li>
                  <li><a href="pages-profile.html"><span class="label label-primary pull-right">New</span>Profile</a></li>
                  <li><a href="pages-search.html"><span class="label label-primary pull-right">New</span>Search</a></li>
                  <li><a href="pages-calendar.html"><span class="label label-primary pull-right">New</span>Calendar</a></li>
                  <li><a href="pages-code-editor.html"><span class="label label-primary pull-right">New</span>Code Editor</a></li>
                  <li><a href="pages-gallery.html">Gallery</a></li>
                  <li><a href="pages-timeline.html">Timeline</a></li>
                </ul>
              </li>-->
            </ul>
				
			 </div>
        </div>
        <div class="text-right collapse-button" style="padding:7px 9px;">
          <input type="text" class="form-control search" placeholder="Search..." />
          <button id="sidebar-collapse" class="btn btn-default" style=""><i style="color:#fff;" class="fa fa-angle-left"></i></button>
        </div>
			</div>
		</div> 
	
		<?php
	}
}