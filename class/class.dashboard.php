<?php

/*****************************************************************************************************************
Class Discription : This class will handle all the dashboard activity ;

*****************************************************************************************************************/
class Dashboard
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
	
	
	function RoomStatsDisplay()
	{
		?>
        <div class="col-sm-4 col-md-4">
					<div class="block" style="min-height:450px;">
						<div class="header">
							<h4>Today's Room Status</h4>
						</div>
                        <div style="clear:both;"></div>
                        <?php
					$sql_room="select * from ".HMS_ROOM." where deleted='0' order by room_no";
					$result_room = $this->db->query($sql_room,__FILE__,__LINE__);
					$cnt = $this->db->num_rows($result_room);
					if($cnt>0)
					{
						while($row_room = $this->db->fetch_array($result_room))
						{
							
						?>
                        <a href="currentroom_details.php?room_id=<?php echo $row_room['id'];?>" class="fancybox fancybox.iframe"><div <?php if($row_room['assigned']==0) { echo 'class="room_avl"';} elseif($row_room['assigned']==1) { echo 'class="room_occu"';} else { echo 'class="room_main"';}?>  > <p class="room_inner"><?php echo 'Room '.$row_room['room_no']?> (<?php echo $this->Master->RoomTypeByRoomTypeId($row_room['room_type_id']);?>)</p></div></a>
						<?php
						
						}
					}
					else
					{
						?>
                        <div class="hint_room">
                        <p class="hint_room_inner"> Sorry No Room Available</p> 
                        </div>
                        <?php
					}
					
					?>
                         <div style="clear:both;"></div>
    					<div class="hint_room"> 
                         <p class="hint_room_inner" <?php if($_SESSION['user_type']==1 or $_SESSION['user_type']==2) { echo 'style="width: 140px;"';}?>><img src="images/Maintenance_icons.jpg" style="padding:2px;"/>Under Houskeeping</p>
                          <p class="hint_room_inner"  <?php if($_SESSION['user_type']==1 or $_SESSION['user_type']==2) { echo 'style="width: 97px;"';}?>><img src="images/Occupied_icons.jpg" style="padding:2px;"/>Occupied</p>  
                        <p class="hint_room_inner"  <?php if($_SESSION['user_type']==1 or $_SESSION['user_type']==2) { echo 'style="width: 97px;"';}?>><img src="images/Available_icons.jpg" style="padding:2px;"/>Available</p> 
                       
                       
                        </div>
					</div>
				</div>
        <?php
	}
	
	function RoomCurrentInfo($room_id)
	{
		$sql_room="select * from ".HMS_ROOM." where id='".$room_id."'";
		$result_room = $this->db->query($sql_room,__FILE__,__LINE__);
		$row_room = $this->db->fetch_array($result_room);
		?>
         <div class="col-md-8">
       <div class="block-flat profile-info">
          <div class="header">							
            <h4>Current Status of Room No. <?php echo $row_room['room_no'];?></h4>
          </div>
          <div class="content">
          <?php
		if($row_room['assigned']==0)
		{
			?>
            <div class="col-sm-8">
			<div style="padding-bottom:2px;" class="personal">
            <h4><strong style="color:#2494F2;">
            <?php
			echo 'Room Available';
			?>
            </strong></h4>
            </div>
			</div>
            <?php
		}
		elseif($row_room['assigned']==1)
		{
			$reservation_Id = $this->getReservationIdByCurrentBookedRoom($room_id);
			$guest_Id = $this->getGuestIdByCurrentBookedRoom($room_id);
			?>
            
			<div class="col-sm-8">
			<div   style="padding-bottom:2px; text-align:left!important;">
			<h4><strong style="color:#2494F2;"> <?php echo ucwords($this->Master->FindGuestNameByGuestId($guest_Id)); ?></strong></h4>
			<p class="description"><strong>Address: </strong>  <?php echo $this->Master->FindGuestAddressByGuestId($guest_Id)?> <?php echo $this->Master->FindGuestCityByGuestId($guest_Id)?>, <?php echo $this->Master->FindGuestStateByGuestId($guest_Id)?> <br /> <?php echo $this->Master->FindGuestCountryByGuestId($guest_Id)?>, <?php echo $this->Master->FindGuestZipcodeByGuestId($guest_Id)?></p>
            <h4><strong>Basic Info:</strong></h4>
			<div style="float:left; width:49%;"><strong>Arrival: </strong><?php echo $this->Master->ArrivalDateByReservationId($reservation_Id)?></div>
			<div style="float:left; width:49%;"><strong>Departure: </strong><?php echo $this->Master->DeparturelDateByReservationId($reservation_Id)?></div>
			<div style="float:left; width:49%;"><strong>Contact: </strong><?php echo $this->Master->FindGuestPhoneByGuestId($guest_Id)?> </div>
			<div style="float:left; width:49%;"><strong>Adult/Child: </strong>  <?php echo $this->Master->TotalAdultReservationId($reservation_Id)?>/ <?php echo $this->Master->TotalChildReservationId($reservation_Id)?></div>
			<div style="float:left; width:49%;"><strong>Email: </strong><?php if($this->Master->FindGuestEmailByGuestId($guest_Id)) { echo $this->Master->FindGuestEmailByGuestId($guest_Id); } else { echo 'Not Available';}?></div>
			<div style="float:left; width:49%;"><strong>Room Type: </strong> <?php echo $this->Master->RoomTypeByReservationId($reservation_Id)?></div>
            <div style="clear:both;"></div>
            <h4><strong>Payment Info:</strong></h4>
           <div style="float:left; width:49%;"><strong>Booking Amount: </strong><?php echo $this->Master->GetBookingTotalAmount($reservation_Id)?> INR</div>
			<div style="float:left; width:49%;"><strong>Advance Amount: </strong> <?php echo $this->Master->GetAdvanceAmount($reservation_Id)?> INR</div>
             <div style="float:left; width:49%;"><strong>Disount Amount: </strong><?php echo $this->Master->GetDiscountAmount($reservation_Id)?> INR</div>
			<div style="float:left; width:49%;"><strong>Remain Amount: </strong> <?php echo $this->Master->GetRemainingAmount($reservation_Id)?> INR</div>   <div style="clear:both;"></div>
			</div>
			</div>
			
			
            <?php
			
		}
		else
		{
			?>
            <div class="col-sm-8">
			<div style="padding-bottom:2px;" class="personal">
              <h4><strong style="color:#2494F2;">
            <?php
			echo 'Room is in Maintenance';
			?>
            </strong></h4>
           
            </div>
			</div>
            <?php
		}
		?>
        </div>
        </div>
        </div>
        <?php
	}
	
	
	function getReservationIdByCurrentBookedRoom($room_id)
	{
				$sql="select * from ".HMS_GUEST_RESERVATION." where room_id ='".$room_id."' and check_in_status='1'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['id'];
	}
	
	function getGuestIdByCurrentBookedRoom($room_id)
	{
				$sql="select * from ".HMS_GUEST_RESERVATION." where room_id ='".$room_id."' and check_in_status='1'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['guest_id'];
	}
	
	function SechduledCheckInToday()
	{
		?>
        <div class="col-sm-4 col-md-4">
					<div class="block">
						<div class="header">							
							<h4>Today's Scheduled Check In</h4>
						</div>
						<div class="content" style="height:400px; overflow:auto;">
                    <?php
					$current_date = date("Y-m-d");
					$sql="select * from ".HMS_GUEST_RESERVATION." where arrival ='".$current_date."' and deleted='0' and check_in_status='0' order by created limit 0,10 ";
					$result = $this->db->query($sql,__FILE__,__LINE__);
					$cnt = $this->db->num_rows($result);
					if($cnt>0)
					{
						while($row = $this->db->fetch_array($result))
						{
							?>
                            <div class="col-sm-12 col-md-12" style="box-shadow:2px 2px 2px #2494F2; margin-bottom:10px;">
                                    <div class="col-sm-3" style="color:#2494F2; font-weight:600;">
                                    Guest:
                                    </div>
                                    <div class="col-sm-6">
                                    <?php echo $this->Master->FindGuestNameByGuestId($row['guest_id'])?>
                                    </div>
                                    <div class="col-sm-3" style="color:#2494F2; font-weight:600;">
                                    Arrival:
                                    </div>
                                    <div class="col-sm-3" style="color:#2494F2; font-weight:600;">
                                    Phone:
                                    </div>
                                    <div class="col-sm-6">
                                   <?php echo $this->Master->FindGuestPhoneByGuestId($row['guest_id'])?>
                                    </div>
                                    <div class="col-sm-3">
                                    <?php echo $row['arrival'];?>
                                    </div>
                                     <div class="col-sm-3" style="color:#2494F2; font-weight:600;">
                                    Email:
                                    </div>
                                    <div class="col-sm-6">
                                  <?php echo $this->Master->FindGuestEmailByGuestId($row['guest_id'])?>
                                    </div>
                                    <div class="col-sm-3" style="color:#2494F2; font-weight:600;">
                                    Departure:
                                   </div>
                                     <div class="col-sm-3" style="color:#2494F2; font-weight:600;">
                                    Type:
                                    </div>
                                    <div class="col-sm-6">
                                    <?php echo $this->Master->RoomTypeByReservationId($row['id'])?>
                                    </div>
                                    <div class="col-sm-3">
                                    <?php echo $row['departure'];?>
                                   </div>
                              </div>
                       <?php
						}
					}
					else
					{
						?>
                         <div class="col-sm-12 col-md-12" style="box-shadow:2px 2px 2px #2494F2; margin-bottom:10px;">
                         <div class="col-sm-12">
                             <h5>Sorry! There are no scheduled Check-In is found for today.</h5>
                         </div>
                          </div>
                        <?php
					}
					?>
                              
						</div>
					</div>
				</div>
        <?php
	}
	
	
	function SechduledCheckOutToday()
	{
		?>
        <div class="col-sm-4 col-md-4">
					<div class="block">
						<div class="header">							
							<h4>Today's Scheduled Check Out</h4>
						</div>
						<div class="content" style="height:400px; overflow:auto;">
                                  <?php
					$current_date = date("Y-m-d");
					$sql="select * from ".HMS_GUEST_RESERVATION." where departure ='".$current_date."' and deleted='0' and check_in_status='1' order by created limit 0,10 ";
					$result = $this->db->query($sql,__FILE__,__LINE__);
					$cnt = $this->db->num_rows($result);
					if($cnt>0)
					{
						while($row = $this->db->fetch_array($result))
						{
							?>
                            <div class="col-sm-12 col-md-12" style="box-shadow:2px 2px 2px #2494F2; margin-bottom:10px;">
                                    <div class="col-sm-3" style="color:#2494F2; font-weight:600;">
                                    Guest:
                                    </div>
                                    <div class="col-sm-6">
                                    <?php echo $this->Master->FindGuestNameByGuestId($row['guest_id'])?>
                                    </div>
                                    <div class="col-sm-3" style="color:#2494F2; font-weight:600;">
                                    Arrival:
                                    </div>
                                    <div class="col-sm-3" style="color:#2494F2; font-weight:600;">
                                    Phone:
                                    </div>
                                    <div class="col-sm-6">
                                   <?php echo $this->Master->FindGuestPhoneByGuestId($row['guest_id'])?>
                                    </div>
                                    <div class="col-sm-3">
                                    <?php echo $row['arrival'];?>
                                    </div>
                                     <div class="col-sm-3" style="color:#2494F2; font-weight:600;">
                                    Email:
                                    </div>
                                    <div class="col-sm-6">
                                  <?php echo $this->Master->FindGuestEmailByGuestId($row['guest_id'])?>
                                    </div>
                                    <div class="col-sm-3" style="color:#2494F2; font-weight:600;">
                                    Departure:
                                   </div>
                                     <div class="col-sm-3" style="color:#2494F2; font-weight:600;">
                                    Type:
                                    </div>
                                    <div class="col-sm-6">
                                    <?php echo $this->Master->RoomTypeByReservationId($row['id'])?>
                                    </div>
                                    <div class="col-sm-3">
                                    <?php echo $row['departure'];?>
                                   </div>
                              </div>
                       <?php
						}
					}
					else
					{
						?>
                         <div class="col-sm-12 col-md-12" style="box-shadow:2px 2px 2px #2494F2; margin-bottom:10px;">
                         <div class="col-sm-12">
                             <h5>Sorry! There are no scheduled Check-Out is found for today.</h5>
                         </div>
                          </div>
                        <?php
					}
					?>
                              
                              
						</div>
					</div>
				</div>
        <?php
	}
}
?>