<?php

/* 
 * This class is responcible for the user Reservation of HMS
 * Author: Abhishek Kumar Mishra
 * Created Date: 31/3/2014
 */

class BanquetReservation
{
	
	function __construct()
	{
					$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
					$this->validity = new ClsJSFormValidation();
					$this->Form = new ValidateForm();
					$this->auth=new Authentication();
					$this->Master=new MasterClass();
					$this->objMail=new PHPMailer();
	}
	
	
	
	function New_BanquetReservation($runat)
	{
		switch($runat)
		{
		
			case 'local':
			$FormName = "form_add";
			?>
       <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="<?php echo $FormName ?>">
      <div class="col-md-9">
       <div class="block-flat">
          <div class="header">							
            <h4 style="font-weight:600" align="center">Banquet Booking Form & Menu</h4>
          </div>
          <div class="content">
             <div class="form-group">
			  <div class="col-sm-6" style="padding-bottom:10px;">
              <label>Name</label> 
				<input type="text" name="person_name" class="form-control" required placeholder="Type something" />
	         </div>
			  <div class="col-sm-6" style="padding-bottom:10px;">
              <label>Organization</label> 
			   <input type="text" name="organization" class="form-control"  placeholder="Type something" />
			  </div>
			  
			  </div>
			  
			  <div class="form-group">
			  <div class="col-sm-12" style="padding-bottom:10px;">
              <label>Address</label> 
				<textarea class="form-control" name="address" placeholder="Type something"  required></textarea>
	         </div>
			</div>
			
            <div class="form-group">
			  <div class="col-sm-6" style="padding-bottom:10px;">
              <label>Email</label> 
				<input type="text" data-parsley-type="email" name="email" class="form-control" required placeholder="Type something" />
	         </div>
			  <div class="col-sm-6" style="padding-bottom:10px;">
              <label>Phone</label> 
			   <input type="text" data-parsley-type="digits" name="phone" maxlength="10" class="form-control" required placeholder="Type something" />
			  </div>
			</div>
             <div class="form-group">
              	<div class="col-sm-3" style="padding-bottom:10px;">
              <label>Date Of Booking</label> 
				<div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
                    <input class="form-control"  name="event_date_start" size="16" type="text" value="<?php echo date("Y-m-d")?>" readonly />
                    <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
                  </div>
                  
                  <a href="banquet_bookings.php" class="btn btn-primary btn-xs fancybox fancybox.iframe" style="margin-top:8px;">Click To Check Banquet Availbility</a>
	         </div>
		      	<div class="col-sm-3" style="padding-bottom:10px;">
                  <?php /*?> <label>Data and Time of booking</label> 
                    <input type="text" style="width: 220px"  name="booking_date" id="reservationtime" class="form-control" value=""  required/><?php */?>
                    <label>Start Time</label> 
                    <input id="start"  required name="start_time" value="12:00 PM"/>
                </div>
                <div class="col-sm-3" style="padding-bottom:10px;">
                 <label>End Time</label> 
                   <input id="end"  required name="end_time" value="12:30 PM"/>
                </div>
			
			  <div class="col-sm-3" style="padding-bottom:10px;">
             <label>No. of Pax (guaranteed)</label> 
			  <input data-parsley-type="digits" name="no_of_person" type="text" class="form-control" required placeholder="Type something" />
	         </div>
			 
			 </div>
              
			
			  
             <div class="form-group">
               <div class="col-sm-4" style="padding-bottom:10px;">
              <label>Event Type</label> 
			  <?php echo $this->Master->Event_Type();?>
               
              </div>
			  <div class="col-sm-4" style="padding-bottom:10px;">
              <label>Banquet</label> 
			 <?php echo $this->Master->Banquet_Type();?>
             </div>
              
             <!-- <div class="col-sm-2" style="padding-bottom:10px; ">
              <label>Audio/Video</label> 
                <input type="checkbox"   name="audio" value="yes" class="icheck">  
              </div>-->
             <div class="col-sm-4" style="padding-bottom:10px;">
               <label>Rservation Type</label> 
                <select class="form-control" name="booking_type" required >
                <option value="">--Rservation Type --</option>
                <option value="1">Confirm List</option>
              </select>
               
              </div>	
			 </div>
             
             
             <div class="form-group">
              <div class="col-sm-4" style="padding-bottom:10px;">
              <label>Banquet Booking Type</label> 
                <select class="form-control" name="bq_booking_type" required onchange="banquet_reser_obj.GetValueOfBookingType(this.value,{target:'reflist',preloader:'pr'})">
                <option value="">-- Banquet Booking Type --</option>
                <option value="1"> With Package </option>
                <option value="2"> WithOut Package </option>
              </select>
               
              </div>
              
              
              <div class="col-sm-4" style="padding-bottom:10px;">
              <div  style="z-index:99999999;">
             <img id="pr" src="img/status.gif" style="visibility:hidden; height:25px;">
             </div>
              <div id="reflist">
              
              </div>
              </div>
              <div class="col-sm-4">
               </div>
              
             </div>
             
             
             
             <div class="form-group">
               <div class="col-sm-5" style="padding-bottom:10px; padding-top:15px;">
                <input type="checkbox"   name="term" value="yes" > <b>Agree Terms & Conditions</b>
               </div>
             </div>
             
              <div class="form-group">
               <div class="col-sm-12" style="padding-bottom:10px; padding-top:15px; height:100px; overflow:auto;">
                
                <p class="fa fa-thumbs-up"> The party will have to pay 50% Advance at the time of booking & balance minimum guaranteed amount shall be paid by the party 24 hrs. before the function</p>
                <br />
                <p class="fa fa-thumbs-up"> Party has to vacate the premises within the prescribed time, otherwise Rs. 2500/- per hour charged extra.</p>
                 <br />
                 <p class="fa fa-thumbs-up"> The party shall be made on basis of minimum guaranteed persons or actual whichever is higher.</p>
                  <br />
                   <p class="fa fa-thumbs-up"> Final bill will be settled immediately after the party is over.</p>
                  <br />
                   <p class="fa fa-thumbs-up"> Band and Dhols are strictly not allowed in the campus.</p>
                  <br />
                  <p class="fa fa-thumbs-up"> The Myriad shall not be held responcible for cancellation of function arising out of force majeure or any admin / judicial orders, all disputes subject to Lucknow Jurisdiction.</p>
                  <br />
                  <p class="fa fa-thumbs-up"> Consumption of all alcoholic drinks inside the hall is strictly prohibited without legal permit / temporary liquor license from excise department. Charges of which shall be extra & payable by customer.</p>
                  <br />
                  <p class="fa fa-thumbs-up"> Some other....</p>
                  <br />
              
               </div>
             </div>
             
             
           </div>
			   
              
              <div class="form-group" style=" margin-top: 45px;
    padding-bottom: 26px;">
                <div class="col-sm-offset-2 col-sm-10">
                 <button class="btn btn-default">Cancel</button>
				  <button type="submit" class="btn btn-primary" name="submit" value="Proceed">Proceed >></button>
                </div>
              </div>
              
              
		  </div>
        </div>
        
      </div>
	  
	    
            </form>
          
        <?php
			break;
			case 'server':
			extract($_POST);
			
							
			 $this->person_name = $person_name;
			 $this->organization = $organization;
			 $this->address = $address;
			 $this->email = $email;
			 $this->phone = $phone;
			 
			 $this->event_date_start = $event_date_start;
			 $this->start_time = $start_time;
			 $this->end_time = $end_time;
			 $this->no_of_person = $no_of_person;
			 $this->event_type_id = $event_type_id;
			 $this->banquet_id = $banquet_id;
			 //$this->audio = $audio;
			 
			 $this->booking_type = $booking_type;
			 
		     $this->cost = $cost;
			 $this->bq_booking_type = $bq_booking_type;
		
	
			 
			
			 
		 
			
			$chekbooking='y';
			
			if($chekbooking == 'y')
			{ 
			$chekbooking = $this->validbooking(); 
			}
			
			
			if($chekbooking != 'y')
			{
				echo $chekbooking;
				$this->New_BanquetReservation('local');
			}
			else
			{
			
			$return = true;
		if($this->Form->ValidField($person_name,'empty','Please enter person name')==false)
		    $return =false;
		if($this->Form->ValidField($organization,'empty','Please enter organization name')==false)
			$return =false;
		if($this->Form->ValidField($address,'empty','Please enter address')==false)
		    $return =false;
		if($this->Form->ValidField($event_date_start,'empty','Please select event date')==false)
		    $return =false;
		if($this->Form->ValidField($start_time,'empty','Please select start time')==false)
		    $return =false;
		if($this->Form->ValidField($end_time,'empty','Please select end time')==false)
		    $return =false;
	    if($this->Form->ValidField($bq_booking_type,'empty','Please select banquet booking type')==false)
		    $return =false;
	   if($this->Form->ValidField($cost,'empty','Please enter cost')==false)
		    $return =false;
			
		
			
		if($return){
							$insert_sql_array = array();
							$insert_sql_array['person_name'] = $this->person_name;
							$insert_sql_array['organization'] = $this->organization;
							$insert_sql_array['address'] = $this->address;
							$insert_sql_array['email'] = $this->email;
							$insert_sql_array['phone'] =$this->phone;
							
							$insert_sql_array['event_date_start'] = $this->event_date_start;
							$insert_sql_array['start_time'] =$this->start_time;
							$insert_sql_array['end_time'] =$this->end_time;
							
							$insert_sql_array['no_of_person'] =$this->no_of_person;
							$insert_sql_array['event_type_id'] =$this->event_type_id;
							
							$insert_sql_array['country_id'] = $this->country_id;
							$insert_sql_array['state_id'] = $this->state_id;
							$insert_sql_array['city_id'] =$this->city_id;
							
							$insert_sql_array['banquet_id'] = $this->banquet_id;
							//$insert_sql_array['audio'] = $this->audio;
							//$insert_sql_array['details'] =$this->details;
							$insert_sql_array['booking_type'] =$this->booking_type;
							$insert_sql_array['user_id'] =$_SESSION['user_id'];
							if($this->bq_booking_type!=1)
							{
							$insert_sql_array['bq_booking_type'] = 'without_package';
							$insert_sql_array['hall_cost'] = $this->cost;
							$insert_sql_array['total_cost'] = $this->cost;
							}
							else
							{
								$insert_sql_array['bq_booking_type'] = 'with_package';
								$insert_sql_array['per_pax_cost'] = $this->cost;
								$insert_sql_array['total_cost'] = $this->cost*$this->no_of_person;
							}
							
							//print_r($insert_sql_array);
						//	banquet_listing.php?index=payment&bookingId=
							$this->db->insert(HMS_BANQUETS,$insert_sql_array);
						    $booking_id = $this->db->last_insert_id();
							?>
							<script type="text/javascript">
							<?php
							if($this->bq_booking_type!=1){ ?>
							window.location = 'banquet_listing.php?index=payment&bookingId=<?php echo $booking_id;?>';
							<?php } else {?>
							window.location = 'banquet_listing.php?index=banquetMenuSelection&bookingId=<?php echo $booking_id;?>';
							<?php
							}
							?>
							</script>
							<?php
							exit();
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->New_BanquetReservation('local');
							}
			}
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
	
	function validbooking()
	{
		$reply='y';
		return $reply;
	}
	
	
	
	function GetValueOfBookingType($id)
	{
			ob_start();
			if($id!=1)
			{
				?>
              <input type="text" value="" placeholder="Banquet Hall Cost" class="form-control" name="cost" required/>
                <?php
			}
			else
			{
			  ?>
              <input type="text" value="" placeholder="Per Package Cost" class="form-control" name="cost" required/>
               <?php
			}
			
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	

	function banquetBookingListing($pg='',$recordcount='',$first_name='',$last_name='',$phone='',$arrival='',$departure='',$room_type_id='')
	{
		ob_start();
			$sql="select * from ".HMS_BANQUETS." where 1 ";
			
			 $sql .= " order by event_date_start";
			
			$resultpages= mysql_query($sql);
			if($pg>1)
			{
			$st= ($pg - 1) * $recordcount;
			$sql.=" limit ".$st.",".$recordcount." ";	
			$x=(($pg - 1)*$recordcount)+1;
			$pgr=$pg;
			}
			else
			{
			$sql.=" limit 0,".$recordcount." ";
			$x=1;
			$pgr=1;
			}
			$result_hold= mysql_query($sql);
			$recordStart=$x;
			//echo $sql;
			$numpages= mysql_num_rows($resultpages);
			
			$result = $this->db->query($sql,__FILE__,__LINE__);
			$cnt = $this->db->num_rows($result);
			?>
            <div class="col-sm-8 col-md-8">
						<div class="block">
						<div class="header">
						<h4>Banquet Booking List</h4>
						</div>
						
						<div class="content"<?php /*?> style="max-height:600px; overflow:auto;"<?php */?>>
                        <?php
			if($cnt>0)
			{
				while($row = $this->db->fetch_array($result))
				{
					?>
			<div class="block-flat profile-info" style="padding-top:5px;  margin-bottom:10px;">
			<div class="row">
			<div class="col-sm-8">
			<div class="personal" style="padding-bottom:2px;">
				<h4><strong style="color:#2494F2;"> <?php echo $this->Master->getBanquetbookingPersonName($row['id'])?></strong></h4>
			<p class="description"><strong>Address: </strong> <?php echo $this->Master->FindGuestAddress($row['id'])?> <?php echo $this->Master->FindBookingCity($row['id'])?> <br /> <?php echo $this->Master->FindBookingState($row['id'])?>, <?php echo $this->Master->FindBookingCountry($row['id'])?></p>
            <div class="col-md-10 col-sm-5"><strong>Organization: </strong><?php echo $row['organization'];?></div>
			<div class="col-md-8 col-sm-5"><strong>Event Date: </strong><?php echo $row['event_date_start'];?> </div>
            <div class="col-md-8 col-sm-5"><strong>Event Time: </strong><?php echo $row['start_time'];?> -- <?php echo $row['end_time'];?></div>
			<div class="col-md-8 col-sm-5"><strong>Email: </strong>  <?php echo $row['email']?></div>
            <div class="col-md-5 col-sm-5"><strong>Contact: </strong><?php echo $row['phone'];?></div>
            <div class="col-md-7 col-sm-5"><strong>Booking Type: </strong><?php if($row['booking_type']==1){ echo '<b style="color:#87C540">Confirm List</b>';} elseif($row['booking_type']==2) { echo '<b style="color:#27111E">Waiting List</b>';} else { echo '<b style="color:#B61528">Tentative List</b>';}?></div>
			
			</div>
			</div>
			<div class="col-sm-4">
			<div class="btn-group" style="margin-top:30px;">
			<button type="button" class="btn btn-default">Manage Settings</button>
			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
			</button>
			<ul class="dropdown-menu" role="menu">
			<li>
            <?php if($this->Master->getpaymentIdBybanquetBookingId($row['id'])>0)
			{
				if($row['status']==0)
				{
						?>
						<a href="#" onclick="javascript: if(confirm('Do You Want To Start Booking?')) { banquet_reser_obj.StartBooking('<?php echo $row['id'];?>',{}) };">Start Booking</a></li>
                        <li><a href="banquet_listing.php?index=print&pid=<?php echo $this->Master->getpaymentIdBybanquetBookingId($row['id']);?>">Booking Details</a></li>
						<?php
				}
				elseif($row['status']==1)
				{
					?>
                    <a href="#" onclick="javascript: if(confirm('Do You Want To End Booking?')) { banquet_reser_obj.EndBooking('<?php echo $row['id'];?>',{}) };">Party Running</a></li>
                    <li><a href="banquet_listing.php?index=print&pid=<?php echo $this->Master->getpaymentIdBybanquetBookingId($row['id']);?>">Booking Details</a></li>
                    <?php
				}
				else
				{
					?>
                     <li> <a href="#">Party Over</a></li>
                   <li> <a href="banquet_listing.php?index=FinalInvoicePrint&pid=<?php echo $this->Master->getpaymentIdBybanquetBookingId($row['id']);?>">Bill Info</a></li>
                    <?php
				}
				?>
            <?php
			}
			?>
            <li class="divider"></li>
			<li><a href="#">Delete Booking</a></li>
			</ul>
			</div>
			</div>
			</div>
			</div>
				<?php
			$x++;}
		}
		else
		{
			?>
			<div class="block-flat profile-info" style="padding-top:5px; margin-bottom:10px;">
			<div class="row">
			<div class="col-sm-12">
			<div class="personal" style="padding-bottom:2px;">
			<h4 style="color:#990000;">Sorry ! No Reservation Found</h4>
			</div>
			</div>
			</div>
			</div>
			<?php
		}
		?>
        <div class="clear"></div>
		
		<?php	
			$tmppage = $numpages/$recordcount;
			$remndr=$numpages%$recordcount;
			if($remndr >= 1)
			{
			$t1=explode('.',$tmppage);
			$lastpage = $t1[0]+1;
			}
			else
			{ $lastpage = $numpages/$recordcount; }	
		?>	
		
		<div class="row">
		<div class="col-sm-12">
		<div class="pull-left">
		<div class="dataTables_info" id="datatable_info"><?php echo $recordStart;?> to <?php echo $x-1; ?> of <?php echo $numpages; ?> entries</div></div>
		<div class="pull-right">
		<div class="dataTables_paginate paging_bs_normal">
		<ul class="pagination">
		  <?php if($pgr=='1') { ?>
		<li class="prev disabled"><a href="#"><span class="fa fa-angle-left"></span>&nbsp;First</a></li>
		<li class="prev disabled"><a href="#"><span class="fa fa-angle-left"></span>&nbsp;Previous</a></li>
		<?php } else {?>
		<li><a  onclick="banquet_reser_obj.banquetBookingListing('1',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,{target:'popupdiv'})" href="javascript:void(0)">First</a></li>
						<li><a  onclick="banquet_reser_obj.banquetBookingListing('<?php echo $pgr-1;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,{target:'popupdiv'})" href="javascript:void(0)">Previous</a></li>
		<?php }?>
		
		<?php if($pgr == $lastpage && ($pgr-4) >= 1 ) { ?>
						<li><a onclick="banquet_reser_obj.banquetBookingListing('<?php echo $pgr-4;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,{target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr-4; ?></a>
						</li>
						<?php } ?>
						
						<?php if($pgr == $lastpage || $pgr == $lastpage-1) { 
						if(($pgr-3) >= 1){?>
						<li><a  onclick="banquet_reser_obj.banquetBookingListing('<?php echo $pgr-3;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,  {target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr-3; ?></a>
						</li>
						<?php } } ?>
						
						<?php $temp0=$pgr-2; if($temp0 >= 1) { ?>
						<li><a  onclick="banquet_reser_obj.banquetBookingListing('<?php echo $pgr-3;?>',   '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,{target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr-2; ?></a>
						</li>
						<?php } ?>

						
						<?php $temp1=$pgr-1; if($temp1 >= 1) {?>
						<li><a  onclick="banquet_reser_obj.banquetBookingListing('<?php echo $pgr-1;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' , {target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr-1; ?></a>
						</li>
						<?php } ?>
						
						<li class="active"><a class="paginate_active" tabindex="0"><?php echo $pgr;?></a></li>
						
						<?php $temp2=$pgr+1; if($temp2 <= $lastpage) { ?>
						<li><a  onclick="banquet_reser_obj.banquetBookingListing('<?php echo $pgr+1;?>',   '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,{target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr+1; ?></a>
						</li>
						<?php } ?>
						
						<?php $temp3=$pgr+2; if($temp3 <= $lastpage) { ?>
						<li><a onclick="banquet_reser_obj.banquetBookingListing('<?php echo $pgr+2;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' , {target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr+2; ?></a>
						</li>
						<?php } ?>
						
						<?php if($pgr == 1 || $pgr == 2) { if(($pgr+3) <= $lastpage) { ?>
						<li><a  onclick="banquet_reser_obj.banquetBookingListing('<?php echo $pgr+3;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,  {target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr+3; ?></a>
						</li>
						<?php } }?>
						
						<?php if($pgr == 1 && ($pgr+4) <= $lastpage) { ?>
						<li><a onclick="banquet_reser_obj.banquetBookingListing('<?php echo $pgr+4;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' , {target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr+4; ?></a>
						</li>
						<?php } ?>
		
						<?php if($lastpage!='0' && $lastpage!=$pgr) {
						
						?>
						<li><a  onclick="banquet_reser_obj.banquetBookingListing('<?php echo $pgr+1;?>', '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,{target:'popupdiv'})" href="javascript:void(0)">Next&nbsp;<span class="fa fa-angle-right"></span></a>
						</li>
						
						<li><a onclick="banquet_reser_obj.banquetBookingListing('<?php echo $lastpage;?>', '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' , {target:'popupdiv'})" href="javascript:void(0)">Last&nbsp;<span class="fa fa-angle-right"></span></a>
						</li>
						<?php } ?>
		
		
		
		
		</ul>
		</div></div>
		<div class="clearfix"></div></div>
		</div>
		
						</div>
						</div>
						</div>	
                        <?php
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
	}
	
	
	
	
	function StartBooking($id)
	{
			ob_start();
			$update_array = array();
			$update_array['status'] = 1 ;
		
			$this->db->update(HMS_BANQUETS,$update_array,'id',$id);
			$_SESSION['msg']='Booking Status Start Now.';
			?>
            <script>
			window.location = "banquet_listing.php"
			</script>
			<?php
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	
	
	function EndBooking($id)
	{
			ob_start();
			$update_array = array();
			$update_array['status'] = 2 ;
		    $this->db->update(HMS_BANQUETS,$update_array,'id',$id);
			//$_SESSION['msg']='Booking Status End Now.';
			?>
            <script>
			window.location = "banquet_listing.php?index=finalpayment&bqId=<?php echo $id;?>"
			</script>
			<?php
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	
	
	
	
	function Advance_Search($first_name,$last_name,$phone,$arrival,$departure,$room_type_id)
	{
	?>
	   <div class="content">
            <form role="form" class="form-horizontal" method="get" action="reservation_lising.php">
              <div class="form-group">
              <label class="col-sm-4 control-label">First Name: </label>
              <div class="col-sm-8">
                <input type="text"  class="form-control" name="first_name">
              </div>
              </div>
              <div class="form-group">
              <label class="col-sm-4 control-label" >Last Name: </label>
              <div class="col-sm-8">
                <input type="text"  class="form-control" name="last_name">
              </div>
              </div>
              <div class="form-group">
              <label class="col-sm-4 control-label">Contact: </label>
              <div class="col-sm-8">
                <input type="text"  class="form-control" name="phone">
              </div>
              </div>
			  <div class="form-group">
              <label class="col-sm-4 control-label">Arrival: </label>
              <div class="col-sm-8">
                <div class="input-group date datetime" style="margin-bottom:0px;" data-min-view="2" data-date-format="yyyy-mm-dd">
                    <input class="form-control"  name="arrival" size="16" type="text" value="" readonly >
                    <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
                  </div>
              </div>
              </div>
			  <div class="form-group">
              <label class="col-sm-4 control-label">Departure: </label>
              <div class="col-sm-8">
                <div class="input-group date datetime" style="margin-bottom:0px;" data-min-view="2" data-date-format="yyyy-mm-dd">
                    <input class="form-control"  name="departure" size="16" type="text" value="" readonly >
                    <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
                  </div>
              </div>
              </div>
			  <div class="form-group">
              <label class="col-sm-4 control-label">Room Type: </label>
              <div class="col-sm-8">
              <select class="form-control" name="room_type_id">
							<option value=""> 	--Room Type --</option>
							<?php
							$sql="select * from ".HMS_ROOM_TYPE." where status=1 and deleted=1";
							$result = $this->db->query($sql,__FILE__,__LINE__);
							while($row = $this->db->fetch_array($result))
							{
							?>
							<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
							<?php
							}
							?>
						  </select>
              </div>
              </div>
              <div class="form-group">
              <div class="col-sm-offset-4 col-sm-8">
                <button class="btn btn-primary" type="submit">Search</button>
                <button class="btn btn-default">Cancel</button>
              </div>
              </div>
            </form>
          </div>
	<?php
	}
	
	
	
	
	
	
	
	
	
	function CheckbanquetAvailbilityCalendar()
	{
		$sql="select * from ".HMS_BANQUETS." where status='0'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$cnt = $this->db->num_rows($result);
			if($cnt>0)
			{
				?>
                 <script>
                $(document).ready(function() {
                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();
				
                $('#calendar').fullCalendar({
                editable: true,
                events: [
                <?php
				while($row = $this->db->fetch_array($result))
			   {
				   $arr = explode('-',$row['event_date_start']);
				   ?>
                    {
						
                            title: '<?php echo 	$row['person_name'];?> (<?php echo $this->Master->getBanquetName($row['banquet_id']);?>) [Time: <?php echo 	$row['start_time'].' - '.$row['end_time']?>]',
                            start: new Date(<?php echo $arr[0]?>, <?php echo $arr[1]-1?>, <?php echo $arr[2]?>),
							
							
                    },
                   <?php
			   }
			      ?>
			    ]
                });
                });
                
                </script>
                <?php
			}
		
	}
	
	
	
	function BanquetMenu($runat,$bookingid)
	{
		
		switch($runat)
		{
		
			case 'local':
			$FormName = "form_addbanquetMenu";
			?>
            
            

       <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="<?php echo $FormName ?>">
      <div class="col-md-12">
       <div class="block-flat">
          <div class="header">							
            <h4 style="font-weight:600" align="center">Banquet Menu Item List</h4>
          </div>
          <div class="content">
        	<div class="form-group">
            <?php
			    $sql="select * from ".HMS_BANQUETS_MENU_HEADER." where  status='1' and deleted='1' order by id";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$cnt = $this->db->num_rows($result);
				if($cnt>0)
				{
				      while($row = $this->db->fetch_array($result))
						{
							?>
							<div class="col-sm-4" style="padding-bottom:10px;">
							<label style="width:100% !important"><?php echo $row['header_name'];?> <b>(Any <?php echo $row['max_allowed'];?>)</b></label> 
                                            <?php
											$sql_bitem="select * from ".HMS_BANQUET_MENU." where header_id='".$row['id']."'";
											$result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
											$cntval = $this->db->num_rows($result_bitem);
											if($cntval>0)
											{
												
												while($row_bitem = $this->db->fetch_array($result_bitem))
												{
													//var_dump($this->Master->getValueMenuIdIsalredyAddedInBooking($bookingid,$row_bitem['id']));
												?>
												<input type="checkbox" name="item[]"  <?php if($this->Master->getValueMenuIdIsalredyAddedInBooking($bookingid,$row_bitem['id'])==true) { echo 'checked="checked"';}?>  value="<?php echo $row_bitem['id']; ?>" /> 
												<?php echo $row_bitem['item'].'<br/>';
												}
											}
											else
											{
												?>
                                                <p>No Item Found In This Header
                                                <?php
											}
											?>
							
							</div>
							<?php
						}
						
				}
				else
				{
					?>
                     <div class="col-sm-12" style="padding-bottom:10px;">
                     <h3>Sorry No Item Found!!</h3>
                     </div>
                    <?php
				}
					  ?>
       	 </div>

			
             
           </div>
			   
              
              <div class="form-group" style=" margin-top: 45px;
    padding-bottom: 26px;">
                <div class="col-sm-offset-2 col-sm-10">
                 <button class="btn btn-default">Cancel</button>
				  <button type="submit" class="btn btn-primary" name="submit" value="Proceed">Proceed >></button>
                </div>
              </div>
              
              
		  </div>
        </div>
        
      </div>
	  
	    
            </form>
          
              <?php
			break;
			case 'server':
			extract($_POST);
			
			           
			
						$this->item = $item;
						$ItemCountSelected = count($this->item);
						if($ItemCountSelected<=0){
							$_SESSION['error_msg'] = 'Kindly Select some menu item for banquet booking.';
							?>
                            <script type="text/javascript">
								window.location = "banquet_listing.php?index=payment&bookingId=<?php echo $bookingid;?>";
							</script>
							<?php 
							exit();
                        }
						
					   
					   	
						$return =true;	
							
							
			        	if($return){
							echo $sql="select id,no_of_person,bq_booking_type from ".HMS_BANQUETS." where id='".$bookingid."'";
							$result = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($result);
							
							//$item_totalcost=0;
							//foreach($this->item as $value){
							//	$item_totalcost = $item_totalcost+$this->Master->getItemPrice($value);
							//}
							//$totalbanquetCost = $item_totalcost*$row['no_of_person'];
							//$update_sql_array = array();
							//$update_sql_array['per_pax_cost'] = $item_totalcost;
							//$update_sql_array['total_cost'] = $totalbanquetCost;
							//$this->db->update(HMS_BANQUETS,$update_sql_array,'id',$bookingid);
							
							
							
							
							
							// this function is used at time when user back and regenerate memu list it delete all the previous item form banquet item table.
							//start
							$this->Master->DeletePreviousExistingItemsForBooking($bookingid);
							//End
							
											    $val=0;
												foreach($this->item as $k)
												{
													$insert_sql_array1['banquet_id'] = $bookingid;
													$insert_sql_array1['item_id'] = $k;
													//$insert_sql_array1['item_cost'] = $this->Master->getItemPrice($k); 
													$this->db->insert(HMS_BANQUETS_RESERVATION_ITEMS,$insert_sql_array1);
													$val++;
												}
											
							?>
							<script type="text/javascript">
								window.location = 'banquet_listing.php?index=payment&bookingId=<?php echo $bookingid;?>';
							</script>
							<?php  
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->BanquetMenu('local',$bookingid);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
    
	
	
	
		function BanquetTotalCost($runat,$bookingid)
	{
		
		switch($runat)
		{
	                    
							
			case 'local':
			 				$sql="select id,no_of_person,per_pax_cost,total_cost,bq_booking_type from ".HMS_BANQUETS." where id='".$bookingid."'";
							$result = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($result);
			$FormName = "form_finalBill";
			?>
            <style>
		table.tftable {font-size:12px;color:#333333;width:100%;border-width: 1px;border-color: #729ea5;border-collapse: collapse;}
table.tftable th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align:left;}
table.tftable tr {background-color:#ffffff;}
table.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}
		</style> 
            

       <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="<?php echo $FormName ?>">
       <?php
	   $sql_bitem="select * from ".HMS_BANQUETS_RESERVATION_ITEMS." where banquet_id='".$bookingid."'";
	   $result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
	   $count_variable = $this->db->num_rows($result_bitem);
	   if($row['bq_booking_type']=='with_package')
	   {
	   ?>
      <div class="col-md-6">
       <div class="block-flat">
       		<a href="banquet_listing.php?index=banquetMenuSelection&bookingId=<?php echo $bookingid;?>" class="btn btn-primary">Cancel this Menu and Select Again</a>
          <div class="header">							
            <h4 style="font-weight:600" align="center">Items List (Total Selected Item: <?php echo $count_variable;?>)</h4>
          </div>
          <div class="content" style="height:370px; overflow:auto;">
        	<table  border="0"  class="tftable">
                                <thead>
                                    <tr>
                                        <th width="10%"><b>S.No.</b></th>
                                        <th width="70%"><b>Item Name</b></th>
                                       
                                   </tr>
                                </thead>
                                      <tbody>
                                        <?php
							  				if($count_variable>0)
											{
										    $i=1;
											while($row_bitem = $this->db->fetch_array($result_bitem))
												{
												?>
                                                    <tr>
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $this->Master->getItemName($row_bitem['item_id']); ?></td>
                                                   
                                                    </tr>
                                                <?php
												 $i++;
												}
											}
											else
											{
												?>
                                               		<tr>
                                                    <td colspan="3"><?php echo 'No Menu Item has been selected';?></td>
                                                    
                                                    </tr>
                                                <?php
											}
												?>
                                 </tbody>
                            </table>
 </div>
 		
		<div style="border:2px solid #2494F2; height:40px; margin-top:10px">
        <div style="padding:3px;">
        <p style="width:31.5%; float:left;"><strong>Per Pack Total:</strong> <?php echo $row['per_pax_cost'];?></p>
         <p style="width:31.5%; float:left;"><strong>Total Packs:</strong> <?php echo $row['no_of_person'];?></p>
           <p style="width:31.5%; float:left;"><strong>Total Cost:</strong> <?php echo $row['total_cost'];?></p>
        </div>
        </div>
	  </div>
        </div>
       <?php
	   }
	   ?>
                                   <script>
								  /* function check_lux(total)
									{
									var toatlamt=0;
									var stotal=0;
									var sercharge=0;
									var serCharge=0 ;
									var gn, elem;
									for(var i=1; i<=3;i++){
									gn = 'tax'+i;
									elem = document.getElementById(gn);
									
									if (elem.checked == true) {
										 stotal += total*elem.value/100;
										 alert(stotal);
									
									}
									}
									var totalgrant = document.getElementById('grant_total').value
									var toatlamt = parseFloat(stotal) + parseFloat(totalgrant);
									document.getElementById('grant_total').value= toatlamt;
									
									}*/
								   </script>
        <div class="col-md-<?php if($row['bq_booking_type']=='with_package') { echo 6;} else { 12;}?>">
       <div class="block-flat">
          <div class="header">							
            <h4 style="font-weight:600" align="center">Payment Details</h4>
          </div>
          <div class="content" style="height:650px;">
        	<div class="form-group">
            	<div class="col-sm-8" style="padding-bottom:10px;">
							<label><b>Total Payment</b></label> 
                         <input type="text"   id="total_amount" name="total_amount" data-parsley-type="digits" placeholder="0.00" class="form-control" readonly="readonly" value="<?php echo $row['total_cost'];?>"/>                           
                </div>
               </div>
              
               
               <div class="form-group">
            	<div class="col-sm-4" style="padding-bottom:10px;">
							<label><b>Audio/Visual charges</b></label> 
                 <input type="text"   name="audio_charges" data-parsley-type="digits" placeholder="0.00" class="form-control"  value="" onchange="banquet_reser_obj.calculateBanquetTotal(this.value,this.form.projector_charges.value,'<?php echo $row['total_cost'];?>',this.form.advance_amt.value,this.form.disount_given.value,{target:'ref',preloader:'pr'})"/>    </div>
              
               <div class="col-sm-4" style="padding-bottom:10px;">
							<label><b>Projector charges : </b></label> 
                             <input type="text"   name="projector_charges" data-parsley-type="digits" placeholder="0.00" class="form-control"  value="" onchange="banquet_reser_obj.calculateBanquetTotal(this.form.audio_charges.value,this.value,'<?php echo $row['total_cost'];?>',this.form.advance_amt.value,this.form.disount_given.value,{target:'ref',preloader:'pr'})"/>    </div>
               </div>
               
               
               <div class="form-group">
                <div class="col-sm-4" style="padding-bottom:10px;">
							<label><b>Discount Given</b></label> 
                         <input type="text"   name="disount_given"  onchange="banquet_reser_obj.calculateBanquetTotal(this.form.audio_charges.value,this.form.projector_charges.value,'<?php echo $row['total_cost'];?>',this.form.advance_amt.value,this.value,{target:'ref',preloader:'pr'})"   data-parsley-type="digits" placeholder="0.00" class="form-control" required/>                           
                </div>
                <div class="col-sm-4" style="padding-bottom:10px;">
							<label><b>Receipt No.</b></label> 
                         <input type="text"   name="receipt_no" data-parsley-type="digits" placeholder="0.00" class="form-control" required/>                           
                </div>
                </div>
                <div class="form-group">
                <div class="col-sm-4" style="padding-bottom:10px;">
							<label><b>Advance Payment</b></label> 
                         <input type="text"  name="advance_amt" onkeyup="banquet_reser_obj.calculateBanquetTotal(this.form.audio_charges.value,this.form.projector_charges.value,'<?php echo $row['total_cost'];?>',this.value,this.form.disount_given.value,{target:'ref',preloader:'pr'})" onchange="banquet_reser_obj.calculateBanquetTotal(this.form.audio_charges.value,this.form.projector_charges.value,'<?php echo $row['total_cost'];?>',this.value,this.form.disount_given.value,{target:'ref',preloader:'pr'})"   data-parsley-type="digits" placeholder="0.00" class="form-control" value="" required/>                           
                </div>
                 <div class="col-sm-4" style="padding-bottom:10px;">
							<label><b>Payment Mode</b></label> 
                        <select class="form-control"  name="payment_mode" required>
					<option value="">-- Choose Mode --</option>
                    <option value="Check">Check</option>
                    <option value="Cash">Cash</option>
                    <option value="Credit/Debit Card">Credit/Debit Card</option>
                    </select>                          
                </div>
            </div>
                <div class="form-group"><img id="pr" src="img/status.gif" style="visibility:hidden; height:25px;">
            	<div class="col-sm-8" style="padding-bottom:10px;" id="ref">
							<label><b>Payment Due</b></label> 
                         <input type="text"   id="grant_total" name="final_amount"  placeholder="0.00" class="form-control" readonly="readonly" value="<?php echo $row['total_cost'];?>"/>                           
                </div>
           </div>
           
               <div class="form-group">
            	<div class="col-sm-8" style="padding-bottom:10px;">
							<label><b>Tax Applied : </b></label> 
                            <?php
							if($row['bq_booking_type']=='with_package')
							{?>
                              <br />
                              <input type="checkbox"  value="1"  name="vat"/> VAT
                              <br />
                              <input type="checkbox"  value="1"  name="sat"/> SAT
                              <br />
                               <input type="checkbox"  value="1" name="service_tax"/> Service Tax
                              <br />
                              <?php
							}else{
								?>
                              <br />
                              <input type="checkbox" value="2"  name="service_tax"/> Service Tax
                              <br />
                               <?php
							}
                            ?>  
                                                       
                </div>
               </div>
          
         
           
           <div class="form-group" style=" margin-top:15px;
    padding-bottom: 10px;">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary" name="submited" value="paynow">Pay Now</button>
            </div>
           </div>
          </div>
        </div>
      </div>
      
	  
	    
            </form>
          
              <?php
			break;
			case 'server':
			extract($_POST);
			
			           
			
						$this->total_amount = $total_amount;
						$this->disount_given = $disount_given;
						$this->advance_amt = $advance_amt;
						$this->payment_mode = $payment_mode;
						$this->final_amount = $final_amount;
						$this->receipt_no = $receipt_no;
						
						$this->audio_charges = $audio_charges;
						$this->projector_charges  = $projector_charges;
						$this->vat = $vat;
						$this->sat = $sat;
						$this->service_tax = $service_tax;
						
						
						//
						//updated date 1/11/2014 some error in testing found by me
						$amtTaXFor = $this->total_amount-$this->disount_given;
						//
						//
						//  Getting Tax values added on billing
						if($this->vat){
							 $vatValue=0;
							 $vatValue = $this->Master->GetVaTonTotal($amtTaXFor);}
						if($this->sat){
							 $satValue=0;
							 $satValue = $this->Master->GetSatonTotal($amtTaXFor);}
						if($this->service_tax){
							$serTaxValue=0;
							if($this->service_tax==1)
							{$serTaxValue = $this->Master->GetServiceTaxonTotalAmount($amtTaXFor);}
							else{$serTaxValue = $this->Master->GetServiceTaxonTotalAmountOnlyHall($amtTaXFor);}
							}
							
						//  Getting Tax values added on billing
							
						
							if($this->audio_charges=='')
							$this->audio_charges=0;
							if($this->projector_charges=='')
							$this->projector_charges=0;
						
						
						
						
						$return =true;	
								if($this->Form->ValidField($total_amount,'empty','Please enter total amount')==false)
								$return =false;
								if($this->Form->ValidField($disount_given,'empty','Please enter discount')==false)
								$return =false;
								if($this->Form->ValidField($advance_amt,'empty','Please enter advance payment')==false)
								$return =false;
								if($this->Form->ValidField($payment_mode,'empty','Please select payment mode')==false)
								$return =false;
								if($this->Form->ValidField($final_amount,'empty','Please enter final amouunt')==false)
								$return =false;
								if($this->Form->ValidField($receipt_no,'empty','Please enter receipt number')==false)
								$return =false;
							
						$remaining_payment = $this->total_amount+$this->audio_charges+$this->projector_charges+$vatValue+$satValue+$serTaxValue-$this->disount_given-$this->advance_amt;
						if($remaining_payment<0)
						{
							$_SESSION['error_msg'] = 'Final Amount can not be less than 0';
							?>
                            <script type="text/javascript">	
								window.location = "banquet_listing.php?index=payment&bookingId=<?php echo $bookingid;?>";
							</script>
							<?php 
							exit();
						}
						
						if($return){
							
							$sql="select id,no_of_person,per_pax_cost,total_cost,hall_cost,bq_booking_type from ".HMS_BANQUETS." where id='".$bookingid."'";
							$result = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($result);
							
							
							$insert_sql_array = array();
							$insert_sql_array['banquet_id'] = $bookingid;
							$insert_sql_array['receipt_no'] = $this->receipt_no;
							$insert_sql_array['bq_booking_type'] = $row['bq_booking_type'];
							$insert_sql_array['hall_cost'] = $row['hall_cost'];
							$insert_sql_array['per_pax_cost'] = $row['per_pax_cost'];
							$insert_sql_array['no_of_pax'] = $row['no_of_person'];
							$insert_sql_array['total_cost'] = $row['total_cost'];
							
							$insert_sql_array['audio_charges'] = $this->audio_charges;
							$insert_sql_array['projector_charges'] = $this->projector_charges;
							$insert_sql_array['vat'] = $vatValue;
							$insert_sql_array['sat'] = $satValue;
							$insert_sql_array['servicetax'] = $serTaxValue;
							$insert_sql_array['finalcost'] = $row['total_cost']+$this->audio_charges+$this->projector_charges+$vatValue+$satValue+$serTaxValue;
							
							$insert_sql_array['advance_paid'] = $this->advance_amt;
							$insert_sql_array['advance_date'] = date('Y-m-d h:i:s A');
							$insert_sql_array['advance_mode'] = $this->payment_mode;
							$insert_sql_array['remaining_amt'] = $remaining_payment;
							$insert_sql_array['disount_given'] = $this->disount_given;
							$insert_sql_array['user_id'] = $_SESSION['user_id'];
							
							$this->db->insert(HMS_BANQUETS_PAY,$insert_sql_array);
							$payment_id = $this->db->last_insert_id();
							
							?>
							<script type="text/javascript">
								window.location = 'banquet_listing.php?index=print&pid=<?php echo $payment_id;?>';
							</script>
							<?php 
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->BanquetTotalCost('local',$bookingid);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	
	
	
	
	function MainInvoice($runat,$bookingid)
	{
		
		switch($runat)
		{
		
			case 'local':
			                $sql="select * from ".HMS_BANQUETS_PAY." where banquet_id='".$bookingid."'";
							$result = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($result);
			$FormName = "form_finalBillsettalment";
			?>
            <style>
		table.tftable {font-size:12px;color:#333333;width:100%;border-width: 1px;border-color: #729ea5;border-collapse: collapse;}
table.tftable th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align:left;}
table.tftable tr {background-color:#ffffff;}
table.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}
		</style> 
            

       <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="<?php echo $FormName ?>">
       <?php
	   $sql_bitem="select * from ".HMS_BANQUETS_RESERVATION_ITEMS." where banquet_id='".$bookingid."'";
	   $result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
	   $count_variable = $this->db->num_rows($result_bitem);
	   if($row['bq_booking_type']=='with_package')
	   {
	   ?>
      <div class="col-md-6">
       <div class="block-flat">
       		
          <div class="header">							
            <h4 style="font-weight:600" align="center">Items List (Total Selected Item: <?php echo $count_variable;?>)</h4>
          </div>
          <div class="content" style="height:370px; overflow:auto;">
        	<table  border="0"  class="tftable">
                                <thead>
                                    <tr>
                                        <th width="10%"><b>S.No.</b></th>
                                        <th width="70%"><b>Item Name</b></th>
                                   </tr>
                                </thead>
                                      <tbody>
                                        <?php
							  				if($count_variable>0)
											{
										    $i=1;
											while($row_bitem = $this->db->fetch_array($result_bitem))
												{
												?>
                                                    <tr>
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $this->Master->getItemName($row_bitem['item_id']); ?></td>
                                                   </tr>
                                                <?php
												 $i++;
												}
											}
											else
											{
												?>
                                               		<tr>
                                                    <td colspan="2"><?php echo 'No Menu Item has been selected';?></td>
                                                    
                                                    </tr>
                                                <?php
											}
												?>
                                 </tbody>
                            </table>
 </div>
		<div style="border:2px solid #2494F2; height:40px; margin-top:10px">
        <div style="padding:3px;">
        <p style="width:31.5%; float:left;"><strong>Per Pack Total:</strong> <?php echo $row['per_pax_cost'];?></p>
         <p style="width:31.5%; float:left;"><strong>Total Packs:</strong> <?php echo $row['no_of_pax'];?></p>
           <p style="width:31.5%; float:left;"><strong>Total Cost:</strong> <?php echo $row['total_cost'];?></p>
        </div>
        </div>
	  </div>
        </div>
      <?php
	   }
	   ?>
        
        <div class="col-md-<?php if($row['bq_booking_type']=='with_package') { echo 6;} else { 12;}?>">
       <div class="block-flat">
          <div class="header">							
            <h4 style="font-weight:600" align="center">Payment Details</h4>
          </div>
          <div class="content" style="height:620px;">
        	<div class="form-group">
            	<div class="col-sm-8" style="padding-bottom:10px;">
							<label><b style="font-weight:900;">Total Payment : </b></label> 
                            <?php echo number_format($row['finalcost'],2);;?>                          
                </div>
             </div>
             <div class="form-group">
              <div class="col-sm-8" style="padding-bottom:10px;">
							<label><b style="font-weight:900;">Discount : </b></label> 
                            <?php echo number_format($row['disount_given'],2);?>                          
                </div>
               </div>
               
                <div class="form-group">
                <div class="col-sm-8" style="padding-bottom:10px;">
							<label><b style="font-weight:900;">Advance Amount : </b></label> 
                            <?php echo number_format($row['advance_paid'],2);?>   (By  <?php echo $row['advance_mode'];?>)                       
                </div>
               </div>
                
               <div class="form-group">
                <div class="col-sm-4" style="padding-bottom:10px;">
							<label><b>Remaining Amount</b></label> 
                 <input type="text"   name="remaining_amt" readonly="readonly"  class="form-control"  value="<?php echo $row['remaining_amt'];?>"/> 
                </div>
                <?php
				if($row['bq_booking_type']!='with_package') 
				{?>
                <div class="col-sm-4" style="padding-bottom:10px;">
							<label><b>Extra hours Charges (With Out Tax)</b></label> 
                         <input type="text"  name="extra_hr_charges" onkeyup="banquet_reser_obj.calculateExtraCharges('<?php echo $row['remaining_amt'];?>',this.value,'<?php echo 1;?>','',{target:'ref'})"   data-parsley-type="digits" placeholder="0.00" class="form-control" value="" required/>                           
                </div>
                <?php } else { ?>
                  <div class="col-sm-4" style="padding-bottom:10px;">
							<label><b>Extra Pax</b></label> 
                         <input type="text"  name="extra_pax" onkeyup="banquet_reser_obj.calculateExtraCharges('<?php echo $row['remaining_amt'];?>',this.value,'<?php echo 2;?>','<?php echo $row['per_pax_cost'];?>',{target:'ref'})"   data-parsley-type="digits" placeholder="0.00" class="form-control" value="" required/>  
                <?php }?>
                </div>
                <div class="form-group">
                <div class="col-sm-4" style="padding-bottom:20px;" id="ref">
							<label><b>Total Payment</b></label> 
                         <input type="text"  name="final_amount" id="final_amount"   placeholder="0.00" class="form-control" readonly="readonly" value="<?php echo $row['remaining_amt'];?>"/>                           
                </div>
                 
            </div>
      
            
           
          
           <div class="form-group">
            	 <div class="col-sm-4" style="padding-bottom:20px;">
							<label><b>Amount Paid</b></label> 
                         <input type="text"   id="amount_paid" name="amount_paid" onkeyup="banquet_reser_obj.calculateBanquetFinalTotal(this.form.final_amount.value,this.value,{target:'ref2'})" onchange="banquet_reser_obj.calculateBanquetFinalTotal(this.form.final_amount.value,this.value,{target:'ref2'})" placeholder="0.00" class="form-control" value=""/>                           
                </div>
                <div class="col-sm-4" style="padding-bottom:10px;">
							<label><b>Payment Mode</b></label> 
                        <select class="form-control"  name="payment_mode" required>
					<option value="">-- Choose Mode --</option>
                    <option value="Check">Check</option>
                    <option value="Cash">Cash</option>
                    <option value="Credit/Debit Card">Credit/Debit Card</option>
                    </select>                          
                </div>
               
           </div>
           <div class="form-group">
          
                
                
                  <div class="col-sm-4" style="padding-bottom:20px;" id="ref2">
							<label><b>Payment Due </b></label> 
                         <input type="text"   id="amount_due" name="amount_due" readonly="readonly"  placeholder="0.00" class="form-control" value=""/>                           
                </div>
           </div>
           
            <!--<div class="form-group">
            	<div class="col-sm-8" style="padding-bottom:10px;">
							<input type="checkbox" value="1" name="service_charge"/>  <b>Service Charge</b>
                </div>
           </div>-->
           
           
            <div class="form-group">
            <div class="col-sm-4" style="padding-bottom:20px;">
              
							<button type="submit" class="btn btn-primary"  style="margin-top:27px;" name="submited" value="pay">Pay Now</button>                          
                </div>
               </div>
           
           
          </div>
        </div>
      </div>
      
	  
	    
            </form>
          
              <?php
			break;
			case 'server':
			extract($_POST);
			
			           
						
						$this->extra_hr_charges = $extra_hr_charges;
						$this->extra_pax	= $extra_pax;
						$this->final_amount = $final_amount;
						$this->payment_mode = $payment_mode;
						$this->amount_paid = $amount_paid;
					
					
					
					$sql="select * from ".HMS_BANQUETS_PAY." where banquet_id='".$bookingid."'";
					$result = $this->db->query($sql,__FILE__,__LINE__);
					$row = $this->db->fetch_array($result);
							
						
					/*if($this->vat){
							 $serviceCharge=0;
							 $serviceCharge = $this->Master->GetServiceChargeValue($this->final_amount);}*/
					if($this->extra_pax>=0 and $this->extra_pax!='')
					{
						$extraPacks_cost = 0;
						$extraPacks_cost = $this->extra_pax*$row['per_pax_cost'];
						
						$vatTaxPercentage = $this->Master->GetVatforWithPackage();
						$SatTaxPercentage = $this->Master->GetSatforWithPackage();
						$SerTaxPercentage = $this->Master->GetServiceTaxforWithPackage();
						$VatOnExtraPacks  = $extraPacks_cost*$vatTaxPercentage/100;
						$SatOnExtraPacks  = $extraPacks_cost*$SatTaxPercentage/100;
						$SerTaxOnExtraPacks = $extraPacks_cost*$SerTaxPercentage/100;
		
						$taxOnExtraPacks = $VatOnExtraPacks+$SatOnExtraPacks+$SerTaxOnExtraPacks;
						
						$TotalCostonExtraPacks = $extraPacks_cost+$taxOnExtraPacks;
						$TatalAmountToBePaid = round($TotalCostonExtraPacks+$row['remaining_amt']);
					}
					
					if($this->extra_hr_charges>=0 and $this->extra_hr_charges!='')
					{
						$TaxOnExtraHours = $this->Master->CalculateServiceTaxOnExtraHours($this->extra_hr_charges);
						$TotalCostofExtraHours = $TaxOnExtraHours+$this->extra_hr_charges;
						$TatalAmountToBePaid = round($TotalCostofExtraHours+$row['remaining_amt']);
					}
					
					
					$remainingPaymentDue = $TatalAmountToBePaid-$this->amount_paid;
					if($remainingPaymentDue<0)
					{
						    $_SESSION['error_msg'] = 'Remaining payment values acn not be negative';
							?>
                            <script type="text/javascript">
								window.location = "banquet_listing.php?index=finalpayment&bqId=<?php echo $bookingid;?>";
							</script>
							<?php 
							exit();
					}
					
					
				/*	echo $TotalCostonExtraPacks;
					echo $TotalCostofExtraHours;
					echo '<br/>';
					echo $VatOnExtraPacks;
					echo '<br />';
					echo $SatOnExtraPacks;
					echo '<br />';
					echo $SerTaxOnExtraPacks;
					echo '<br />';
					echo $TatalAmountToBePaid;
					echo '<br />';
					echo $TaxOnExtraHours;
					echo '<br/>';
					echo $TatalAmountToBePaid;
					echo '<br />';
					echo $this->amount_paid;
					echo '<br/>';
					echo $remainingPaymentDue;
					
					
					exit();*/
						
						$return =true;	
								if($this->Form->ValidField($amount_paid,'empty','Please enter paid amount')==false)
								$return =false;
								if($this->Form->ValidField($payment_mode,'empty','Please select payment mode')==false)
								$return =false;
								if($this->Form->ValidField($final_amount,'empty','Please enter final amouunt')==false)
								$return =false;
								
						
						   
							
						/*$remaining_payment = $row['remaining_amt']+$this->other_charges-$this->amount_paid;
						if($remaining_payment<0)
						{
							$_SESSION['error_msg'] = 'Final Amount can not be less than 0';
							?>
                            <script type="text/javascript">
								window.location = "banquet_listing.php?index=finalpayment&bqId=<?php echo $bookingid;?>";
							</script>
							<?php 
							exit();
						}*/
						
						if($return){
							
							$update_sql_array = array();
						    if($this->extra_pax>=0 and $this->extra_pax!='')
							{
							$update_sql_array['extra_pax'] = $this->extra_pax;
							$update_sql_array['extra_pax_cost'] = $TotalCostonExtraPacks;
							
						    $update_sql_array['extra_pax_plain_cost'] = $extraPacks_cost;
							$update_sql_array['extra_pax_vat'] = $VatOnExtraPacks;
							$update_sql_array['extra_pax_sat'] = $SatOnExtraPacks;
							$update_sql_array['extra_pax_ser_tax'] = $SerTaxOnExtraPacks;
							}
							if($this->extra_hr_charges>=0 and $this->extra_hr_charges!='')
							{
							$update_sql_array['extra_hr_charges'] = $TotalCostofExtraHours;	
							
							$update_sql_array['extra_hr_charges_plain'] = $extra_hr_charges;
							$update_sql_array['extra_hr_charges_sat'] = $TaxOnExtraHours; 
							}
							//$update_sql_array['service_charge'] = $serviceCharge;
							$update_sql_array['full_amount_paid'] = $this->amount_paid;
							$update_sql_array['full_amount_date'] = date('Y-m-d h:i:s A');
							$update_sql_array['full_amount_mode'] = $this->payment_mode;
							$update_sql_array['remaining_amt'] = $remainingPaymentDue;
							$update_sql_array['user_id'] = $_SESSION['user_id'];
							
							// print_r($update_sql_array);
							//	exit();
							$this->db->update(HMS_BANQUETS_PAY,$update_sql_array,'banquet_id',$bookingid);
			                $_SESSION['msg']='Invoice has been generated successfully';
			                ?>
							<script type="text/javascript">
								window.location = 'banquet_listing.php?index=FinalInvoicePrint&pid=<?php echo $row['id'];?>';
							</script>
							<?php 
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->MainInvoice('local',$bookingid);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	
	
	
	
	
	function calculateBanquetTotal($audio='',$projector='',$total='',$advance='',$discount='')
	{
	    ob_start();
		
		if($advance=='')
		$advance=0;
		if($discount=='')
		$discount=0;
		if($audio=='')
		$audio=0;
		if($projector=='')
		$projector=0;
	    
		if($total>0 and $advance>=0 and $discount>=0 and $audio>=0 and $projector>=0)
		{
		$total_amount = $total+$audio+$projector;
		$amount_to_be_paid = $total_amount - $advance - $discount;
		}
		//echo $audio.'---'.$projector.'---'.$total.'--'.$advance.'--'.$discount;
	    //echo '<br />';
		//echo $amount_to_be_paid;
		//echo '<br />';
		//echo $total_amount;
		
	
	?> 
        <label><b>Payment Due</b></label> 
    <input type="text"  name="final_amount" id="grant_total"  placeholder="0.00" class="form-control" readonly="readonly" value="<?php echo $amount_to_be_paid;?>"/> 	<?php
	
            
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	function calculateExtraCharges($remainAmt='',$TextBoxValue='',$check='',$pax_cost='')
	{
		ob_start();
		
		if($check==1)
		{
			if($remainAmt>=0)
			{
				$TaxOnExtraHours = $this->Master->CalculateServiceTaxOnExtraHours($TextBoxValue);
				$totalValue = $TextBoxValue+$remainAmt+$TaxOnExtraHours;
				?>
                         <label><b>Total Payment</b></label> 
                         <input type="text" id="final_amount" name="final_amount"  placeholder="0.00" class="form-control" readonly="readonly" value="<?php echo round($totalValue);?>"/>  
                <?php
			}
		}
		else
		{
			if($remainAmt>=0)
			{
				$ExtraPaxCost = $TextBoxValue*$pax_cost;
				$TaxOnExtraPack = $this->Master->CalculteTaxOnExtraPacks($ExtraPaxCost);
				$totalValue = $remainAmt+$ExtraPaxCost+$TaxOnExtraPack;
				
				?>
                         <label><b>Total Payment</b></label> 
                         <input type="text" id="final_amount" name="final_amount"  placeholder="0.00" class="form-control" readonly="readonly" value="<?php echo round($totalValue);?>"/>  
                <?php
			}
		}
		
		
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
		function calculateBanquetFinalTotal($total='',$amt_paid='')
	{
	    ob_start();
		
		if($amt_paid=='')
		$amt_paid=0;
		/*?>
        <script>
		alert('<?php echo $total.'--'.$others.'--'.$amt_paid;?>');
		</script>
       
        <?php exit();*/
		if($total>0 and $amt_paid>=0)
		{
		$amount_to_be_paid = $total - $amt_paid;
		}
		
	if($amount_to_be_paid>=0)
	{
	?> 
        <label><b>Payment Due</b></label> 
    <input type="text"  name="amount_due"   id="amount_due" placeholder="0.00" class="form-control" readonly="readonly" value="<?php echo $amount_to_be_paid;?>"/> 	<?php
	}
	else{
		?>
    <label><b>Payment Due</b></label> 
    <input type="text"  name="amount_due" id="amount_due" placeholder="0.00" class="form-control" readonly="readonly" value="<?php echo $amount_to_be_paid;?>"/>
    <b style="color:#F00;">(Amt can't be negative)</b>
        <?php
	}
	
            
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	
	function BanquetBillAdvancePayment($billId)
	{
		$sql="select * from ".HMS_BANQUETS_PAY." where id ='".$billId."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		?>
        <div class="col-md-12" id="abc">
       <div class="block-flat" style="height:1450px;">
          <div class="header" style="border:none;">							
            <h3><img src="img/invoice_header.jpg" style="width:950px; height:150px;" /></h3>
          </div>
          <div class="content">
		  <div class="col-md-12">
						<h4><strong> <?php echo $this->Master->getBanquetbookingPersonName($row['banquet_id'])?></strong></h4>
							<p style="margin-bottom:1px;"><strong><?php echo $this->Master->FindGuestAddress($row['banquet_id'])?></strong></p>
							
		</div>
			<div class="col-md-12" style="margin-top:25px;">
						<div style="width:49%;  float:left;">
						<p><strong>Mobile No.    :  </strong>  <?php echo $this->Master->FindGuestMob($row['banquet_id'])?></p>
						<p><strong>Email Id  :  </strong>  <?php echo $this->Master->FindGuestEmail($row['banquet_id'])?></p>
						<p><strong>Banquet Type  :  </strong>  <?php echo $this->Master->getbanquetnamebybanquetId($row['banquet_id'])?></p>
                            
						<p><?php echo date('l jS \of F Y h:i:s A');?></p>
						</div>
						<div style="width:49%; float:right;">
						
						                <?php
										$x=0;
                                        $sql_1 = "select * from ".HMS_BANQUETS_PAY;
										$result_1= $this->db->query($sql_1,__FILE__,__LINE__);
										while($row_1= $this->db->fetch_array($result_1))
										$x++;
										?>
						<p><strong>Invoice No.:  </strong> <?php echo $x;?></p>
                        <p><strong>Receipt No:  </strong> <?php echo $row['receipt_no'];?></p>
						<p><strong>No. Of Pax :  </strong> <?php echo $row['no_of_pax'];?></p>
						<p><strong>Booking Date and Time :  </strong>  <?php echo date('d-m-Y', strtotime($this->Master->FindBanquetBookingDate($row['banquet_id'])));?>  <?php echo $this->Master->FindBanquetBookingStartTime($row['banquet_id'])?> - <?php echo $this->Master->FindBanquetBookingEndTime($row['banquet_id'])?></p>
						</div>
						</div>
		
		 
		
		  <div class="col-md-12">
		  <div class="table-responsive">
							<table class="table no-border hover">
								<thead class="no-border">
									<tr style="border-top:1px solid #999999; background:#EBEBEB;">
										<th style="width:15%;"><strong>Date</strong></th>
										<th style="width:25%;" class="text-left"><strong>Items</strong></th>
										<th  style="width:30%;" class="text-left"><strong>Referance</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong>Debit INR</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong>Credit INR</strong></th>
									</tr>
								</thead>
                                <tbody class="no-border-y">
                                <?php /*?><?php
										   $sql_bitem="select * from ".HMS_BANQUETS_RESERVATION_ITEMS." where banquet_id='".$row['banquet_id']."'";
										   $result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
										   $count_variable = $this->db->num_rows($result_bitem);
	 						  				if($count_variable>0)
											{
										  	while($row_bitem = $this->db->fetch_array($result_bitem))
														{
														?>
														
														<tr>
													<td><?php echo date('d-m-Y', strtotime($row_bitem['created']));?></td>
                                                    <td align="left"><?php echo $this->Master->getItemName($row_bitem['item_id']); ?></td>
                                                    <td align="left"><?php echo $row_bitem['item_cost'];?> INR Per Pax for <?php echo $row['no_of_pax'];?> Pax</td>
                                                     <td align="left"><?php echo number_format($row_bitem['item_cost'] * $row['no_of_pax'],2);?> INR</td>
                                                     <td align="left"></td>
														</tr>
														<?php
														$i++;
														}
											}
											else
											{
												?>
                                                <tr>
														<td colspan="3"><?php echo 'No Item Selected.';?></td>
														
														</tr>
                                                <?php
											}
											?><?php */?>
										<?php
										if($row['bq_booking_type']=='with_package')
										{
										?>
                                       <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>No. Of Pax :</b> <?php echo $row['no_of_pax'];?></td>
                                                   <td align="left"><b>Per Pax Cost. :</b> <?php echo $row['per_pax_cost'];?></td>
                                                     <td align="left"><?php echo number_format($row['total_cost'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
										else
										{
											?>
                                       <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>Banquet Hall Cost :</b> <?php echo $row['hall_cost'];?></td>
                                                   <td align="left"></td>
                                                     <td align="left"><?php echo number_format($row['total_cost'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php

										}
										?>
                                        
                                        <?php
										if($row['audio_charges']>0)
										{
										?>
                                       <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>Audio/Visual charges</b></td>
                                                   <td align="left"></td>
                                                     <td align="left"><?php echo number_format($row['audio_charges'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
                                        ?>
                                          <?php
										if($row['projector_charges']>0)
										{
										?>
                                       <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>Projector charges</b></td>
                                                   <td align="left"></td>
                                                     <td align="left"><?php echo number_format($row['projector_charges'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
                                        ?>
                                        <?php
										if($row['vat']>0)
										{
										?>
                                        <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>VAT Charges</b></td>
                                                   <td align="left"> VAT applicable 12.5% </td>
                                                     <td align="left"><?php echo number_format($row['vat'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
                                        ?>
                                          <?php
										if($row['sat']>0)
										{
										?>
                                        <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>SAT Charges</b></td>
                                                   <td align="left"> SAT applicable 1.5%</td>
                                                     <td align="left"><?php echo number_format($row['sat'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
                                        ?>
                                            <?php
										if($row['servicetax']>0)
										{
										?>
                                        <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>Service Tax</b></td>
                                                   <td align="left"> Service Tax applicable <?php if($row['bq_booking_type']=='with_package')
										{ echo '7.42%';} else{ echo '12.36%'; } ?> </td>
                                                     <td align="left"><?php echo number_format($row['servicetax'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
                                        ?>
                               
										<tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>Advance Amount</b> </td>
                                                   <td align="left"><b>Receipt No. :</b> <?php echo $row['receipt_no'];?><br/>
                                                     <b>Payment Mode :</b> <?php echo $row['advance_mode'];?></td>
                                                     <td align="left"></td>
                                                     <td align="left"><?php echo number_format($row['advance_paid'],2);?> INR</td>
							
                                        </tr>
							   
							</tbody>
							</table>		
							</div>
							<hr style="background:#000000; height:2px;"/>
							<div class="table-responsive">
							<table class="table no-border hover">
								<thead class="no-border">
								  	<tr>
								        <th style="width:15%;"><strong></strong></th>
										<th style="width:25%;" class="text-left"><strong></strong></th>
										<th  style="width:30%;" class="text-left"><strong>Total</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong><?php echo number_format($row['finalcost'],2);?> INR</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong><?php echo number_format($row['advance_paid'],2);?> INR</strong></th>
                                        </tr>
                                 
                                        
                                        
                                        
                                        	<tr>
								        <th style="width:15%;"><strong></strong></th>
										<th style="width:25%;" class="text-left"><strong></strong></th>
										<th  style="width:30%;" class="text-left"><strong>Any Discount</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong></strong></th>
                                        <th  style="width:15%;" class="text-left"><strong><?php echo number_format($row['disount_given'],2);?> INR</strong></th>
                                        </tr>
                                        
                                        	<tr>
								        <th style="width:15%;"><strong></strong></th>
										<th style="width:25%;" class="text-left"><strong></strong></th>
										<th  style="width:30%;" class="text-left"><strong>Payment Due</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong><?php echo $row['remaining_amt'];?> INR</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong></strong></th>
                                        </tr>
                                    
                                    
									
								</thead>
							</table>		
							</div>
		  </div>
		 </div>
		  
        </div>
      </div>
        <?php  
	}
	
	
	function FinalInvoiceDetails($billId)
	{
		$sql="select * from ".HMS_BANQUETS_PAY." where id ='".$billId."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		?>
         <a class="fancybox fancybox.iframe btn btn-primary btn-lg" href="main_invoice.php?index=banquetInvoice&paymentId=<?php echo $row['id'];?>">Generate Invoice</a>
         
        <div class="col-md-12" id="abc">
       <div class="block-flat" style="height:1450px;">
       
          <div class="header" style="border:none;">							
            <h3><img src="img/invoice_header.jpg" style="width:950px; height:150px;" /></h3>
          </div>
          
          <div class="content">
		  <div class="col-md-12">
						<h4><strong> <?php echo $this->Master->getBanquetbookingPersonName($row['banquet_id'])?></strong></h4>
							<p style="margin-bottom:1px;"><strong><?php echo $this->Master->FindGuestAddress($row['banquet_id'])?></strong></p>
							
		</div>
			<div class="col-md-12" style="margin-top:25px;">
						<div style="width:49%;  float:left;">
						<p><strong>Mobile No.    :  </strong>  <?php echo $this->Master->FindGuestMob($row['banquet_id'])?></p>
						<p><strong>Email Id  :  </strong>  <?php echo $this->Master->FindGuestEmail($row['banquet_id'])?></p>
						<p><strong>Banquet Type  :  </strong>  <?php echo $this->Master->getbanquetnamebybanquetId($row['banquet_id'])?></p>
                            
						<p>
                        <?php echo date('l jS \of F Y h:i:s A', strtotime($row['full_amount_date']));?></p>
						</div>
						<div style="width:49%; float:right;">
						
						                <?php
										$x=0;
                                        $sql_1 = "select * from ".HMS_BANQUETS_PAY;
										$result_1= $this->db->query($sql_1,__FILE__,__LINE__);
										while($row_1= $this->db->fetch_array($result_1))
										$x++;
										?>
						<p><strong>Invoice No.:  </strong> <?php echo $x;?></p>
                        <p><strong>Receipt No:  </strong> <?php echo $row['receipt_no'];?></p>
						<p><strong>No. Of Pax :  </strong> <?php echo $row['no_of_pax'];?></p>
						<p><strong>Booking Date and Time :  </strong>  <?php echo date('d-m-Y', strtotime($this->Master->FindBanquetBookingDate($row['banquet_id'])));?>  <?php echo $this->Master->FindBanquetBookingStartTime($row['banquet_id'])?> - <?php echo $this->Master->FindBanquetBookingEndTime($row['banquet_id'])?></p>
						</div>
						</div>
		
		 
		
		  <div class="col-md-12">
		  <div class="table-responsive">
							<table class="table no-border hover">
								<thead class="no-border">
									<tr style="border-top:1px solid #999999; background:#EBEBEB;">
										<th style="width:15%;"><strong>Date</strong></th>
										<th style="width:25%;" class="text-left"><strong>Items</strong></th>
										<th  style="width:30%;" class="text-left"><strong>Referance</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong>Debit INR</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong>Credit INR</strong></th>
									</tr>
								</thead>
                                <tbody class="no-border-y">
                             <?php /*?>   <?php
										   $sql_bitem="select * from ".HMS_BANQUETS_RESERVATION_ITEMS." where banquet_id='".$row['banquet_id']."'";
										   $result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
										   $count_variable = $this->db->num_rows($result_bitem);
	 						  				if($count_variable>0)
											{
										  	while($row_bitem = $this->db->fetch_array($result_bitem))
														{
														?>
														
														<tr>
													<td><?php echo date('d-m-Y', strtotime($row_bitem['created']));?></td>
                                                    <td align="left"><?php echo $this->Master->getItemName($row_bitem['item_id']); ?></td>
                                                    <td align="left"><?php echo $row_bitem['item_cost'];?> INR Per Pax for <?php echo $row['no_of_pax'];?> Pax</td>
                                                     <td align="left"><?php echo number_format($row_bitem['item_cost'] * $row['no_of_pax'],2);?> INR</td>
                                                     <td align="left"></td>
														</tr>
														<?php
														$i++;
														}
											}
											else
											{
												?>
                                                <tr>
														<td colspan="3"><?php echo 'No Item Selected.';?></td>
														
														</tr>
                                                <?php
											}
											?><?php */?>
                                        <?php
										if($row['bq_booking_type']=='with_package')
										{
										?>
                                       <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>No. Of Pax :</b> <?php echo $row['no_of_pax'];?></td>
                                                   <td align="left"><b>Per Pax Cost. :</b> <?php echo $row['per_pax_cost'];?></td>
                                                     <td align="left"><?php echo number_format($row['total_cost'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
										else
										{
											?>
                                       <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>Banquet Hall Cost :</b> <?php echo $row['hall_cost'];?></td>
                                                   <td align="left"></td>
                                                     <td align="left"><?php echo number_format($row['total_cost'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php

										}
										?>
										<?php
										if($row['audio_charges']>0)
										{
										?>
                                       <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>Audio/Visual charges</b></td>
                                                   <td align="left"></td>
                                                     <td align="left"><?php echo number_format($row['audio_charges'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
                                        ?>
                                          <?php
										if($row['projector_charges']>0)
										{
										?>
                                       <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>Projector charges</b></td>
                                                   <td align="left"></td>
                                                     <td align="left"><?php echo number_format($row['projector_charges'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
                                        ?>
                                        <?php
										if($row['vat']>0)
										{
										?>
                                        <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>VAT</b></td>
                                                   <td align="left"> VAT applicable 12.5% </td>
                                                     <td align="left"><?php echo number_format($row['vat'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
                                        ?>
                                          <?php
										if($row['sat']>0)
										{
										?>
                                        <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>SAT</b></td>
                                                   <td align="left"> SAT applicable 1.5%</td>
                                                     <td align="left"><?php echo number_format($row['sat'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
                                        ?>
                                            <?php
										if($row['servicetax']>0)
										{
										?>
                                        <tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>Service Tax</b></td>
                                                   <td align="left"> Service Tax applicable <?php if($row['bq_booking_type']=='with_package')
										{ echo '7.42%';} else{ echo '12.36%'; } ?> </td>
                                                     <td align="left"><?php echo number_format($row['servicetax'],2);?> INR</td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
                                        ?>
                               
										<tr>
													<td><?php echo date('d-m-Y', strtotime($row['advance_date']));?></td>
                                                    <td align="left"><b>Advance Amount</b> </td>
                                                   <td align="left"><b>Receipt No. :</b> <?php echo $row['receipt_no'];?><br/>
                                                     <b>Payment Mode :</b> <?php echo $row['advance_mode'];?></td>
                                                     <td align="left"></td>
                                                     <td align="left"><?php echo number_format($row['advance_paid'],2);?> INR</td>
							
                                        </tr>
                                          <?php
										if($row['extra_pax']>0)
										{
										?>
                                        <tr>
													<td><?php echo date('d-m-Y', strtotime($row['full_amount_date']));?></td>
                                                    <td align="left"><b style="font-weight:800;">Extra Pax : </b> <?php echo $row['extra_pax'];?> Packs</td>
                                                     <td align="left">
                                                     <b style="font-weight:800;">Extra Pax Cost :</b> <b><?php echo $row['extra_pax'].'*'.$row['per_pax_cost'];?></b><br/>
                                                    <b style="font-weight:800;">VAT Applied(12.5%)</b> <br/>
                                                    <b style="font-weight:800;">SAT Applied(1.5%) </b><br/>
                                                   <b style="font-weight:800;"> Service Tax Applied(7.42%)</b> </td>
                                                     <td align="left"><?php echo number_format($row['extra_pax_plain_cost'],2);?> INR<br/><b><?php echo number_format($row['extra_pax_vat'],2);?> INR</b><br /><b><?php echo number_format($row['extra_pax_sat'],2);?> INR</b><br /><b><?php echo number_format($row['extra_pax_ser_tax'],2);?> INR</b></td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
                                        ?>
                                       
                                        
                                        <?php
										if($row['extra_hr_charges']>0)
										{
										?>
                                        <tr>
													<td><?php echo date('d-m-Y', strtotime($row['full_amount_date']));?></td>
                                                    <td align="left"><b>Extra Hours Charges</b></td>
                                                     <td align="left"> <b style="font-weight:800;">Extra Hours Charges</b><br/>                          <b style="font-weight:800;">Service Tax Applied(12.36%)</b></td>
                                                     <td align="left"><b><?php echo number_format($row['extra_hr_charges_plain'],2);?> INR<br/> <b><?php echo number_format($row['extra_hr_charges_sat'],2);?> INR</b></td>
                                                     <td align="left"></td>
							
                                        </tr>
							   			<?php
										}
                                        ?>
                                        
                                        <tr>
													<td><?php echo date('d-m-Y', strtotime($row['full_amount_date']));?></td>
                                                    <td align="left"><b>Final Amount</b> </td>
                                                    <td align="left"><b>Payment Mode :</b> <?php echo $row['full_amount_mode'];?></td>
                                                     <td align="left"></td>
                                                     <td align="left"><?php echo number_format($row['full_amount_paid'],2);?> INR</td>
							
                                        </tr>
							   
							</tbody>
							</table>		
							</div>
							<hr style="background:#000000; height:2px;"/>
							<div class="table-responsive">
							<table class="table no-border hover">
								<thead class="no-border">
								  	<tr>
								        <th style="width:15%;"><strong></strong></th>
										<th style="width:25%;" class="text-left"><strong></strong></th>
										<th  style="width:30%;" class="text-left"><strong>Total</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong><?php echo number_format($row['finalcost']+$row['extra_hr_charges']+$row['extra_pax_cost'],2);?> INR</strong></th>
                                        <th  style="width:15%;" class="text-left"></th>
                                        </tr>
                                   <tr>
								        <th style="width:15%;"><strong></strong></th>
										<th style="width:25%;" class="text-left"><strong></strong></th>
										<th  style="width:30%;" class="text-left"><strong>Round Off</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong><?php echo number_format(round($row['finalcost']+$row['extra_hr_charges']+$row['extra_pax_cost']),2);?> INR</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong><?php echo number_format($row['advance_paid']+$row['full_amount_paid'],2);?> INR</strong></th>
                                        </tr>
                                        
                                        	<tr>
								        <th style="width:15%;"><strong></strong></th>
										<th style="width:25%;" class="text-left"><strong></strong></th>
										<th  style="width:30%;" class="text-left"><strong>Any Discount</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong></strong></th>
                                        <th  style="width:15%;" class="text-left"><strong><?php echo number_format($row['disount_given'],2);?> INR</strong></th>
                                        </tr>
                                        
                                        	<tr>
								        <th style="width:15%;"><strong></strong></th>
										<th style="width:25%;" class="text-left"><strong></strong></th>
										<th  style="width:30%;" class="text-left"><strong>Payment Due</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong><?php echo number_format($row['remaining_amt'],2);?> INR</strong></th>
                                        <th  style="width:15%;" class="text-left"><strong></strong></th>
                                        </tr>
                                    
                                    
									
								</thead>
							</table>		
							</div>
		  </div>
		 </div>
		  
        </div>
      </div>
        <?php
	}

	/*function getTotalbanquetItemCount()
	{ 
		        $sql="select id,status,deleted from ".HMS_BANQUETS_MENU_HEADER." where status='1' and deleted='1' order by id";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$x=1;
							while($row = $this->db->fetch_array($result))
							{
								            $sql_bitem="select id,header_id from ".HMS_BANQUET_MENU." where header_id='".$row['id']."'";
											$result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
											while($row_bitem = $this->db->fetch_array($result_bitem))
												{
													$x++;
												}
							}
							
							return $x;
							
	}*/
	
	
	function GenerateInvoice($payment_id)
    {
        $sql="select * from ".HMS_BANQUETS_PAY." where id ='".$payment_id."'";
        $result = $this->db->query($sql,__FILE__,__LINE__);
        $row = $this->db->fetch_array($result);
        ?>
        <a href="javascript: void(0);" onClick="printpage('print');"><button class="btn btn-gebo" style="width:90px; font-family:verdana;font-size:13px;" 
value="Submit" type="submit" name="submit" id="submit">Print</button></a>
        
<div style="width:950px; height:842px; padding-left:70px;" id="print">
<div style="height:110px;"> <h3><img src="img/invoice_header.jpg" style="width:950px; height:110px;" /></h3></div>

<div style="width:950px; float:left; margin:12px;">
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 18px; margin: 0; padding: 2px;"><strong>
<?php echo ucwords($this->Master->getBanquetbookingPersonName($row['banquet_id']));?></strong></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><?php echo $this->Master->FindGuestAddress($row['banquet_id'])?></p>
</div>

<div style="clear:both"></div>

<div style="width:950px;  margin:12px;">
<div style="width:57%; float:left">
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Mobile No.:</strong> <?php echo $this->Master->FindGuestMob($row
['banquet_id'])?></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Email Id:</strong> <?php echo $this->Master->FindGuestEmail($row
['banquet_id'])?></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Banquet Type:</strong>
 <?php echo $this->Master->getbanquetnamebybanquetId($row['banquet_id'])?></p>

                                    <p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><?php echo date('l jS \of F Y h:i:s 
A', strtotime($row['full_amount_date']));?></p></p>

</div>
<div style="width:40%; float:left">
                                        <?php
                                        $x=0;
                                        $sql_1 = "select * from ".HMS_BANQUETS_PAY;
                                        $result_1= $this->db->query($sql_1,__FILE__,__LINE__);
                                        while($row_1= $this->db->fetch_array($result_1))
                                        $x++;
                                        ?>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Invoice No:</strong> <?php echo $x;?></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Receipt No:</strong> <?php echo $row['receipt_no'];?></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>No. Of Pax :</strong> <?php echo $row['no_of_pax'];?></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Booking Date and Time :</strong> <?php echo date('d-m-Y', 
strtotime($this->Master->FindBanquetBookingDate($row['banquet_id'])));?>  <?php echo $this->Master->FindBanquetBookingStartTime($row['banquet_id'])?> - <?php echo 
$this->Master->FindBanquetBookingEndTime($row['banquet_id'])?></p>
</div>

</div>

<div style="clear:both"></div>

<div style="width:950px; margin:12px;">
<div style="clear:both"></div>

<!-- header code -->
<div style="width:950px; border:1px solid #000; border-bottom:2px solid #000; height:34px; background-color:#EBF3EE; border-left:none; border-right:none;">
<div style="width:10%; height:35px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 16px; margin: 0; padding:6px 6px 6px 5px; text-
align:left;">Date</p></div>
<div style="width:20%; height:35px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 16px; margin: 0; padding:6px 6px 6px 5px;text-
align:left;">Items</p></div>
<div style="width:30%; height:35px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 16px; margin: 0; padding:6px 6px 6px 5px;text-
align:left;">Reference</p></div>
<div style="width:20%; height:35px; float:right;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 16px; margin: 0; padding:6px 6px 6px 5px;text-
align:right;">Debit</p></div>
<div style="width:20%; height:35px;  float:right;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 16px; margin: 0; padding:6px 6px 6px 5px;text-
align:right;">Credit</p></div> 
</div>

<!-- header code End -->
<?php /*?>                <?php
               $sql_bitem="select * from ".HMS_BANQUETS_RESERVATION_ITEMS." where banquet_id='".$row['banquet_id']."'";
               $result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
               $count_variable = $this->db->num_rows($result_bitem);
                if($count_variable>0)
                {
                while($row_bitem = $this->db->fetch_array($result_bitem))
                            {
                            ?>
<div style="width:610px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 95px; color:#000;" 
> <?php echo date('d-m-Y', strtotime($row_bitem['created']));?></p></div>
<div style="width:190px; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 95px; color:#000;" 
> <?php echo $this->Master->getItemName($row_bitem['item_id']); ?></p></div>
<div style="width:140px; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 95px; 
color:#000;" > <?php echo $row_bitem['item_cost'];?> INR Per Pax for <?php echo $row['no_of_pax'];?> Pax</p></div>
<div style="width:90px; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 95px; color:#000;" 
><?php echo number_format($row_bitem['item_cost'] * $row['no_of_pax'],0);?> INR</p></div>
<div style="width:90px; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 95px; 
color:#000;" > </p></div> 
</div>

    <?php
                                                    
                                            }
                                            }
                                            else
                                            {
                                                ?>
                                              <div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<h2>No Item Found</h2>
</div>
                                                <?php
                                            }
                                            ?><?php */?>


 <?php if($row['bq_booking_type']=='with_package'){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['advance_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<b>No. Of Pax :</b> <?php echo $row['no_of_pax'];?></p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<b style="font-size:12px;">Per Pax Cost. :</b> <?php echo $row['per_pax_cost'];?>
                                                    </p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['total_cost'],0);?> INR</p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" > <?php //echo number_format($row['advance_paid'],0);?> </p></div> 
</div>
<?php } else { ?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['advance_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
Banquet Hall Cost</p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
</p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['total_cost'],2);?> INR</p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div>
</div> 
<?php } ?>
 <?php if($row['audio_charges']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['advance_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
Audio/Visual charges</p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
</p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['audio_charges'],2);?> INR</p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>
<?php } ?>

 <?php if($row['projector_charges']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['advance_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
Projector charges</p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
</p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['projector_charges'],2);?> INR</p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>
<?php } ?>

 <?php if($row['vat']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['advance_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
VAT     </p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo 'VAT applicable '.$this->Master->GetVatforWithPackage();?></p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['vat'],2);?> INR</p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>
<?php } ?>     
 <?php if($row['sat']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['advance_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
SAT     </p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo 'SAT applicable '.$this->Master->GetSatforWithPackage();?></p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['sat'],2);?> INR</p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>
<?php } ?>     


 <?php if($row['servicetax']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['advance_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
Service Tax</p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php 
if($row['bq_booking_type']=='without_package')
{
echo 'Service Tax applicable '.$this->Master->GetServiceTaxforWithOutPackage();
}
else
{
echo 'Service Tax applicable '.$this->Master->GetServiceTaxforWithPackage();    
}
?></p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['servicetax'],2);?> INR</p></div>
<div style="width:20px; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>
<?php } ?>     


 <?php if($row['advance_paid']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['advance_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
Advance Amount</p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<b style="font-size:12px;">Receipt No. :</b> <?php echo $row['receipt_no'];?> (<?php echo $row['advance_mode'];?>)</p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['advance_paid'],2);?> INR</p></div> 
</div>
<?php } ?> 



<?php if($row['extra_hr_charges_plain']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['full_amount_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
Extra Hours Charges</p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
</p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['extra_hr_charges_plain'],2);?> INR</p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>
<?php } ?> 
<?php if($row['extra_hr_charges_sat']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['full_amount_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
Extra Hours Charges</p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo 'Service Tax applicable '.$this->Master->GetServiceTaxforWithOutPackage();?></p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['extra_hr_charges_sat'],2);?> INR</p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>
<?php } ?> 



<?php if($row['extra_pax_plain_cost']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['full_amount_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
Extra Pax: <?php echo $row['extra_pax'];?></p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
Extra Pax Cost: <?php echo $row['extra_pax'].'*'.$row['per_pax_cost'];?></p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['extra_pax_plain_cost'],2);?> INR</p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>
<?php } ?> 
<?php if($row['extra_pax_vat']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['full_amount_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
>On Extra packs</p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
><?php echo 'VAT Applied '.$this->Master->GetVatforWithPackage();?></p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['extra_pax_vat'],2);?> INR</p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>
<?php } ?> 

<?php if($row['extra_pax_sat']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['full_amount_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
>On Extra Packs</p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
><?php echo 'SAT Applied '.$this->Master->GetSatforWithPackage();?></p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['extra_pax_sat'],2);?> INR</p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>
<?php } ?>

<?php if($row['extra_pax_ser_tax']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:45px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['full_amount_date']));?></p></div>
<div style="width:20%; height:40px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
>On Extra Packs</p></div>
<div style="width:30%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
><?php echo 'Service Tax Applied '.$this->Master->GetServiceTaxforWithPackage();?></p></div>
<div style="width:20%; height:40px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['extra_pax_ser_tax'],2);?> INR</p></div>
<div style="width:20%; height:40px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>
<?php } ?>

 
<?php if($row['full_amount_paid']>0){?>
<div style="width:950px; border:1.3px solid #666666; height:35px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" > 
<?php echo date('d-m-Y', strtotime($row['full_amount_date']));?></p></div>
<div style="width:20%; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
>Final Amount</p></div>
<div style="width:30%; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
>Payment Mode: <?php echo $row['full_amount_mode'];?></p></div>
<div style="width:20%; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div>
<div style="width:20%; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" > <?php echo number_format($row['full_amount_paid'],2);?> INR</p></div> 
</div>
<?php } ?> 

<div style="width:950px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none; margin-top:10px;">
<div style="width:10%; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
></p></div>
<div style="width:20%; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
></p></div>
<div style="width:30%; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
><b>Total</b></p></div>
<div style="width:20%; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['finalcost']+$row['extra_hr_charges']+$row['extra_pax_cost'],2);?> INR</p></div>
<div style="width:20%; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>



<div style="width:950px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none; margin-top:10px;">
<div style="width:10%; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
></p></div>
<div style="width:20%; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
></p></div>
<div style="width:30%; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
><b>Round Off</b></p></div>
<div style="width:20%; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format(round($row['finalcost']+$row['extra_hr_charges']+$row['extra_pax_cost']),2);?> INR</p></div>
<div style="width:20%; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['advance_paid']+$row['full_amount_paid'],2);?> INR</p></div> 
</div>



<div style="width:950px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
></p></div>
<div style="width:20%; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
></p></div>
<div style="width:30%; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
><b>Discount</b></p></div>
<div style="width:20%; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div>
<div style="width:20%; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" > <?php echo number_format($row['disount_given'],0);?> INR</p></div> 
</div>
<div style="width:950px; border:2px solid #000000; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:10%; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
></p></div>
<div style="width:20%; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
></p></div>
<div style="width:30%; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 2px; color:#000;" 
><b>Balance</b></p></div>
<div style="width:20%; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ><?php echo number_format($row['remaining_amt'],2);?> INR</p></div>
<div style="width:20%; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 5px;text-
align:right; color:#000;" ></p></div> 
</div>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; width:48%; margin-top: 145px; padding:6px 6px 6px 5px;text-align:right; color:#000; 
float:left;"><b>[Front office Signature]</b></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; width:48%; margin-top: 145px; padding:6px 6px 6px 5px;text-align:right; color:#000; float:right; 
text-align:right;"><b>[Guest Signature]</b></p>

<div style="clear:both"></div>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin-top: 40px; padding:6px 6px 6px 5px;text-align:right; color:#000;" align="right">Visit Again, 
Thank You</p>


</div>
</div>
        <?php   
    }
	
	
	
	

}