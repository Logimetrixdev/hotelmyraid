<?php

/* 
 * This class is responcible for the user Reservation of HMS
 * Author: Abhishek Kumar Mishra
 * Created Date: 31/3/2014
 */

class Reservation
{
	
	function __construct()
	{
					$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
					$this->validity = new ClsJSFormValidation();
					$this->Form = new ValidateForm();
					$this->auth=new Authentication();
					$this->Master=new MasterClass();
					$this->objMail=new PHPMailer();
					$this->kt=new KOT();
	}
	
	
	
	function New_Reservation($runat)
	{
		switch($runat)
		{
		
			case 'local':
			$FormName = "form_add";
							$ControlNames=array("name"			=>array('name',"''","Kindly enter name","span_name"),
												"contact"			=>array('contact',"Mobile","Kindly enter contact","span_contact"),
												"username"			=>array('username',"''","Kindly enter user name","span_username"),
												"email"			=>array('email',"EMail","Kindly enter Email","span_email"),
												"password"			=>array('password',"''","Kindly enter contact password","span_password"),
												"user_type"			=>array('user_type',"''","Kindly enter user type","span_user_type")
												);
	
							$ValidationFunctionName="CheckAddValidity";
						
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
			?>
	

		
		
      <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="<?php echo $FormName ?>">
      <div class="col-md-6">
       <div class="block-flat">
          <div class="header">							
            <h3>Reservations</h3>
          </div>
          <div class="content" style="padding-top:0px;">
            
			  <h4 style="font-weight:600">Guest Information:-</h4>
			  <div class="form-group">
			  <div class="col-sm-2" style="padding-right: 6px;padding-left: 1px;">
              <label>Title</label> 
				<select class="form-control" name="title" required>
				<option value="Mr." <?php if($_REQUEST['title']=='Mr.') { echo 'selected="selected"';}?> >Mr.</option>
				<option value="Mrs." <?php if($_REQUEST['title']=='Mrs.') { echo 'selected="selected"';}?> >Mrs.</option>
                <option value="Miss." <?php if($_REQUEST['title']=='Miss.') { echo 'selected="selected"';}?> >Miss.</option>
				</select>
	         </div>
			  <div class="col-sm-5" style="padding-right: 6px;padding-left: 1px;">
              <label>First Name</label> 
			   <input type="text" name="first_name" value="<?php echo $_REQUEST['first_name']?>" class="form-control" required placeholder="Type something" />
			  </div>
			  <div class="col-sm-5" style="padding-right: 6px;padding-left: 1px;">
              <label>Last Name</label> 
			   <input type="text" name="last_name" class="form-control" value="<?php echo $_REQUEST['last_name']?>" required placeholder="Type something" />
			  </div>
			  </div>
			  
			 
			  <div class="form-group">
			 
			  <div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
              <label>Email</label> 
			  <input type="email" class="form-control" value="<?php echo $_REQUEST['email']?>" name="email"  placeholder="Type something" />
			  </div>
			  <div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
              <label>Phone</label> 
			     <input data-parsley-type="digits" type="text" value="<?php echo $_REQUEST['phone']?>" name="phone" class="form-control" required placeholder="Type something" />
			  </div>
			  </div>
			  
			  
			   <h4 style="font-weight:600">Booking Type:-</h4>
			 <div class="form-group">
			  <div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
              <label>Booking Type</label> 
				 	<select class="form-control" name="booking_type">
				<option value="">--Booking Type --</option>
				<option value="confirm" selected="selected">Confirm List</option>
				</select>
	         </div>
			 
			 <div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
              <label>Booking Source</label> 
				 	<select class="form-control" name="booking_source_id">
				<option value="">--Booking Type --</option>
				<option value="1" selected="selected">Front Desk</option>
				</select>
	         </div>
			 
			</div>
			
			   <h4 style="font-weight:600">Business Source:-</h4>
			  <div class="form-group">
			  <div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
              <label>Market Place</label> 
				 	<select class="form-control" name="market_place_id" onchange="reservation_obj.ChangeSourceInfo(this.value,{target:'refsourcelisting',preloader:'pr7'})">
				<option value="">-- Market Place --</option>
				 <?php
				$sql="select * from ".HMS_MARKET_PLACE." where deleted='0'";
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
			  <div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
              <label>Source Info</label> <img id="pr7" src="img/status.gif" style="visibility:hidden; height:25px;"> 
					<div id="refsourcelisting">
					<select class="form-control" name="source_info_id">
					<option value="">-- Source Info --</option>
					</select>
					</div>
			  </div>
			</div>
			
			
			  
		  </div>
        </div>
        
      </div>
	  
	  <div class="col-md-6">
       <div class="block-flat">
          <div class="content" style="padding-top:0px;">
             <h4 style="font-weight:600">Stay Information:-</h4>
			  <div class="form-group">
			
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>Arrival</label> 
				<div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
                    <input class="form-control"  name="arrival" size="16" type="text" value="" readonly onkeyup="reservation_obj.DaysCalculate(this.value,this.form.departure.value,{target:'refdays'})" onchange="reservation_obj.DaysCalculate(this.value,this.form.departure.value,{target:'refdays'})">
                    <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
                  </div>
	         </div>
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>Departure</label> 
			 <div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
                    <input class="form-control" name="departure" size="16" type="text" value="" readonly onkeyup="reservation_obj.DaysCalculate(this.form.arrival.value,this.value,{target:'refdays',preloader:'pr5'})" onchange="reservation_obj.DaysCalculate(this.form.arrival.value,this.value,{target:'refdays',preloader:'pr5'})">
                    <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
                  </div>
			  </div>
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>No. of nights</label> <img id="pr5" src="img/status.gif" style="visibility:hidden; height:25px;"> 
				  <div id="refdays"> 
				  <input type="text" value="" required class="form-control" name="no_of_nights" readonly="readonly">
				  </div>
			  </div>
              <!--<div style="padding:3px;">
              <a class="fancybox fancybox.iframe" href="room_bookings.php">Check Room Availbility</a>
              </div>-->
			  </div>
			  <div class="form-group">
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>Room Type</label> 
				 <select class="form-control" name="room_type_id" required>
				<option value="">--Room Type--</option>
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
             <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>Occupancy</label> 
				<select class="form-control" name="occupancy" required 
         onchange="reservation_obj.checkoccupany(this.value,this.form.no_of_room.value,this.form.adult_count.value,this.form.child_count.value,this.form.child_age.value,this.form.extra_bed.value,{target:'checkoccupanyref'})" >
				<option value="">-- Select --</option>
				<option value="1">Single</option>
				<option value="2">Double</option>
				
				</select>
	         </div>
			 <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>Total Room</label> 
				<select class="form-control" name="no_of_room" required onchange="reservation_obj.checkoccupany(this.form.occupancy.value,this.value,this.form.adult_count.value,this.form.child_count.value,this.form.child_age.value,this.form.extra_bed.value,{target:'checkoccupanyref'})" >
				<option value="">Room</option>
				<?php
				for($i=1; $i<=10; $i++)
				{
				?>
				<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php
				}
				?>
				</select>
	         </div>
			  <div class="col-sm-3" style="padding-right: 6px;padding-left: 1px;">
              <label>Adult</label> 
			   <select class="form-control" name="adult_count" required onchange="reservation_obj.checkoccupany(this.form.occupancy.value,this.form.no_of_room.value,this.value,this.form.child_count.value,this.form.child_age.value,this.form.extra_bed.value,{target:'checkoccupanyref'})"  >
				<option value="">-- Adult --</option>
				<?php
				for($j=1; $j<=10; $j++)
				{
				?>
				<option value="<?php echo $j;?>"><?php echo $j;?></option>
				<?php
				}
				?>
				</select>
			  </div>
			  <div class="col-sm-3" style="padding-right: 6px;padding-left: 1px;">
              <label>Children</label> 
	<select class="form-control" name="child_count" required onchange=" reservation_obj.checkoccupany(this.form.occupancy.value,this.form.no_of_room.value,this.form.adult_count.value,this.value,this.form.child_age.value,this.form.extra_bed.value,{target:'checkoccupanyref'})" >
				<option value="">-- Children --</option>
                <option value="0">None</option>
				<?php
				for($k=1; $k<=10; $k++)
				{
				?>
				<option value="<?php echo $k;?>"><?php echo $k;?></option>
				<?php
				}
				?>
				</select>
			  </div>
              <div class="col-sm-3" style="padding-right: 6px;padding-left: 1px;">
                    <label>Age</label>
            <select class="form-control" name="child_age" onchange="reservation_obj.checkoccupany(this.form.occupancy.value,this.form.no_of_room.value,this.form.adult_count.value,this.form.child_count.value,this.value,this.form.extra_bed.value,{target:'checkoccupanyref'})" >
				<option value="">-- Age --</option>
                
				<?php
				for($ca=1; $ca<=17; $ca++)
				{
				?>
				<option value="<?php echo $ca;?>"><?php echo $ca.' Years';?></option>
				<?php
				}
				?>
				</select>
			  </div>
              <div class="col-sm-3" style="padding-right: 6px;padding-left: 1px;">
                    <label>Extra Bed</label>
            <select class="form-control" name="extra_bed" onchange="reservation_obj.checkoccupany(this.form.occupancy.value,this.form.no_of_room.value,this.form.adult_count.value,this.form.child_count.value,this.form.child_age.value,this.value,{target:'checkoccupanyref'})" >
				<option value="">-- Bed --</option>
                
				<?php
				for($eb=1; $eb<=2; $eb++)
				{
				?>
				<option value="<?php echo $eb;?>"><?php echo $eb;?></option>
				<?php
				}
				?>
				</select>
			  </div>
              <div id="checkoccupanyref"></div>
			  </div>
			  
			  
			  <?php /*?><div class="form-group">
			  <div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
              <label>Product Menu</label> 
			  <br />
			  <select id="example14" style="width:320px;" name="product[]" multiple="multiple" class="form-control">
                <?php
				$sql="select * from ".HMS_PRODUCT." where status=1 and deleted=1";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				while($row = $this->db->fetch_array($result))
				{
				?>
				<option value="<?php echo $row['id'];?>"><?php echo $row['title'];?></option>
				<?php
				}
				?>
               </select>
					
	         </div>
			  
			 </div><?php */?>
			 
			
			 
			  
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
			
			
			
			 $this->title = $title;
			 $this->first_name = $first_name;
			 $this->last_name = $last_name;
			 $this->email = $email;
			 $this->phone = $phone;
		
			 $this->arrival = $arrival;
			 $this->departure = $departure;
			 $this->no_of_nights = $no_of_nights;
			 $this->room_type_id = $room_type_id;
		     $this->no_of_room = $no_of_room;
			 $this->adult_count = $adult_count;
			 $this->child_count = $child_count;
			 $this->child_age = $child_age;
			 $this->extra_bed = $extra_bed;
			 $this->occupancy = $occupancy;
			 $this->market_place_id = $market_place_id;
			 $this->source_info_id = $source_info_id;
			 $this->booking_source_id = $booking_source_id;
			/* $this->product = $product;*/
			 $this->booking_type = $booking_type;
			//$total_no_of_person =  $this->adult_count + $this->child_count;
			
			
			
			
			
			$chekvaloccupany='y';
			
			if($chekvaloccupany == 'y')
			{ 
			$chekvaloccupany = $this->ValidCheckOccupany($occupancy,$no_of_room,$adult_count,$child_count,$child_age,$extra_bed); 
			}
			
			
			if($chekvaloccupany != 'y')
			{
				echo $chekvaloccupany;
				$this->New_Reservation('local');
			}
			else
			{
			
			$return = true;
		if($this->Form->ValidField($first_name,'empty','Please enter first name')==false)
		    $return =false;
		if($this->Form->ValidField($last_name,'empty','Please enter last name')==false)
			$return =false;
		/*if($this->Form->ValidField($address,'empty','Please enter address')==false)
		    $return =false;
		if($this->Form->ValidField($identification_number,'empty','Please enter identification number')==false)
			$return =false;*/
	    if($this->Form->ValidField($arrival,'empty','Please enter arrival date')==false)
			$return =false;
		if($this->Form->ValidField($departure,'empty','Please enter departure date')==false)
			$return =false;
		if($this->Form->ValidField($booking_type,'empty','Please Select Booking Type')==false)
			$return =false;
		
		
		$sql_check="select * from ".HMS_HOLD_GUEST_RESERVATION." where arrival ='".$arrival."' and departure='".$departure."' and cancelled='0'";
		$result_check = $this->db->query($sql_check,__FILE__,__LINE__);
		$Cnt = $this->db->num_rows($result_check);
		if($Cnt>0)
		{
			$_SESSION['error_msg'] = 'Hold reservation exits between this date kindly cancel that then proceed.';
			?>
			<script>
			window.location='add_reservation.php';
			</script>
			<?php
			exit();
		}
			
		if($return){
							$insert_sql_array = array();
							$insert_sql_array['title'] = $this->title;
							$insert_sql_array['first_name'] = $this->first_name;
							$insert_sql_array['last_name'] = $this->last_name;
						
							$insert_sql_array['email'] = $this->email;
							$insert_sql_array['phone'] =$this->phone;
							$this->db->insert(HMS_GUEST,$insert_sql_array);
						    $guest_id = $this->db->last_insert_id();
							
							
							$insert_sql_array2['guest_id'] = $guest_id;
							$insert_sql_array2['arrival'] = $this->arrival;
							$insert_sql_array2['departure'] = $this->departure;
							$insert_sql_array2['no_of_nights'] = $this->no_of_nights;
							$insert_sql_array2['room_type_id'] = $this->room_type_id;
							$insert_sql_array2['occupancy'] =  $this->occupancy;
							$insert_sql_array2['no_of_rooms'] = $this->no_of_room;
							$insert_sql_array2['adult_count'] = $this->adult_count;
							$insert_sql_array2['child_count'] = $this->child_count;
							$insert_sql_array2['child_age'] = $this->child_age;
							$insert_sql_array2['extra_bed'] = $this->extra_bed;
							if($extra_bed!='')
							{
							$insert_sql_array2['extra_bed_cost'] = $this->Master->extra_bed_cost($this->extra_bed,$this->room_type_id);
							}
							$insert_sql_array2['market_place_id'] = $this->market_place_id;
							$insert_sql_array2['source_info_id'] = $this->source_info_id;
							$insert_sql_array2['booking_source_id'] = $this->booking_source_id;
							$insert_sql_array2['booking_type'] = $this->booking_type;
							$insert_sql_array2['total_room_cost'] = $this->Master->TotalRoomCost($this->no_of_room,$this->room_type_id,$this->no_of_nights,$this->occupancy);
							$this->db->insert(HMS_GUEST_RESERVATION,$insert_sql_array2);
							$reservation_id = $this->db->last_insert_id();
							
							?>
							<script type="text/javascript">
						window.location = 'add_reservation.php?index=payment&guestid=<?php echo $guest_id;?>&reservationid=<?php echo $reservation_id;?>';
							</script>
							<?php
							exit();
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->New_Reservation('local');
							}
			}
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
	
	function ValidCheckOccupany($occupancy,$No_Of_Rooms,$Adult_Count,$Child_Count='',$Age='',$extraBed='')
	{
		if($Age!='' and $Age>5)
		 {
			 $occupany = $Adult_Count+$Child_Count;
			 $maxoccupany = $No_Of_Rooms*$occupancy;
			  $maxoccupany = $maxoccupany+$extraBed;
			 if($occupany>$maxoccupany)
			 {
				 $reply='<div class="col-md-12">
       <div class="block-flat">
          <div class="header"><div style="color:#FA5050">Error: Occupancy problem occured! kindly check values.</div></div></div></div>';
			 }
			 else
			 {
				 $reply='y';
			 }
		 }
		 elseif($Age!='' and $Age<5)
		 {
			 $occupany = $Adult_Count;
			  $maxoccupany = $No_Of_Rooms*$occupancy;
			   $maxoccupany = $maxoccupany+$extraBed;
			  if($occupany>$maxoccupany)
			 {
				 $reply='<div class="col-md-12">
       <div class="block-flat">
          <div class="header"><div style="color:#FA5050">Error: Occupancy problem occured! kindly check values.</div></div></div></div>';
			 }
			 else
			 {
				 $reply='y';
			 }
			 
		 }
		 else
		 {
			  $occupany = $Adult_Count;
			   $maxoccupany = $No_Of_Rooms*$occupancy;
			    $maxoccupany = $maxoccupany+$extraBed;
			  if($occupany>$maxoccupany)
			 {
				 $reply='<div class="col-md-12">
       <div class="block-flat">
          <div class="header"><div style="color:#FA5050">Error: Occupancy problem occured! kindly check values.</div></div></div></div>';
			 }
			 else
			 {
				 $reply='y';
			 }
		 }
		return $reply;
	}
	
	function checkoccupany($occupancy='',$No_Of_Rooms,$Adult_Count,$Child_Count='',$Age='',$extraBed='')
	{
		ob_start();
		
		 if($Age!='' and $Age>5)
		 {
			 $occupany = $Adult_Count+$Child_Count;
			 $maxoccupany = $No_Of_Rooms*$occupancy;
			 $maxoccupany = $maxoccupany+$extraBed;
			 if($occupany>$maxoccupany)
			 {
				 echo '<p style="color:#FA5050">Occupancy problem occured! kindly check values.</p>';
			 }
		 }
		 elseif($Age!='' and $Age<5)
		 {
			 $occupany = $Adult_Count;
			  $maxoccupany = $No_Of_Rooms*$occupancy;
			   $maxoccupany = $maxoccupany+$extraBed;
			 if($occupany>$maxoccupany)
			 {
				  echo '<p style="color:#FA5050">Occupancy problem occured! kindly check values.</p>';
			 }
		 }
		 else
		 {
			  $occupany = $Adult_Count;
			   $maxoccupany = $No_Of_Rooms*$occupancy;
			    $maxoccupany = $maxoccupany+$extraBed;
			 if($occupany>$maxoccupany)
			 {
				 echo '<p style="color:#FA5050">Occupancy problem occured! kindly check values.</p>';
			 }
		 }
						
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	
	
	function ChangeState($id,$state_id='')
	{
	ob_start();
	?>
		<select class="form-control" name="state_id" required onchange="reservation_obj.ChangeCity(this.value,{target:'refcitylisting',preloader:'pr4'})">
						<option value="">-- Select State --</option>
							<?php
							$sql="select * from ".HMS_STATE." where country_id ='".$id."'";
							$result = $this->db->query($sql,__FILE__,__LINE__);
							while($row = $this->db->fetch_array($result))
							{
							?>
							<option value="<?php echo $row['id'];?>" <?php if($row['id']==$state_id) { echo 'selected="selected"';}?> ><?php echo $row['name'];?></option>
							<?php
							}
							?>
						</select>
	<?php
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
	}
	
	
	function ChangeCity($id,$cityId='')
	{
	ob_start();
	?>
						<select class="form-control" name="city_id" required>
						<option value="">-- Select City --</option>
							<?php
							$sql="select * from ".HMS_CITY." where state_id ='".$id."'";
							$result = $this->db->query($sql,__FILE__,__LINE__);
							while($row = $this->db->fetch_array($result))
							{
							?>
							<option value="<?php echo $row['id'];?>" <?php if($row['id']==$cityId) { echo 'selected="selected"';}?>><?php echo $row['name'];?></option>
							<?php
							}
							?>
						</select>
	<?php
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
	}
	
	
	function ChangeIdentificationState($id,$ID_state_Id='')
	{
	ob_start();
	?>
		<select class="form-control" name="identify_state_id" required onchange="reservation_obj.ChangeIdentificationCity(this.value,{target:'refIdentifycitylisting',preloader:'pr2'})">
						<option value="">-- Select State --</option>
							<?php
							$sql="select * from ".HMS_STATE." where country_id ='".$id."'";
							$result = $this->db->query($sql,__FILE__,__LINE__);
							while($row = $this->db->fetch_array($result))
							{
							?>
							<option value="<?php echo $row['id'];?>" <?php if($row['id']==$ID_state_Id) { echo 'selected="selected"';}?>><?php echo $row['name'];?></option>
							<?php
							}
							?>
						</select>
	<?php
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
	}
	
	
	function ChangeIdentificationCity($id,$user_id_city_Id='')
	{
	ob_start();
	?>
						<select class="form-control" name="identify_city_id" required>
						<option value="">-- Select City --</option>
							<?php
							$sql="select * from ".HMS_CITY." where state_id ='".$id."'";
							$result = $this->db->query($sql,__FILE__,__LINE__);
							while($row = $this->db->fetch_array($result))
							{
							?>
							<option value="<?php echo $row['id'];?>" <?php if($row['id']==$user_id_city_Id) { echo 'selected="selected"';}?>><?php echo $row['name'];?></option>
							<?php
							}
							?>
						</select>
	<?php
	
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
	}
	
	function ChangeSourceInfo($id)
	{
	ob_start();
	?>
						<select class="form-control" name="source_info_id" required>
						<option value="">-- Select Souce Info --</option>
							<?php
							$sql="select * from ".HMS_SOURCE_INFO." where market_place_id ='".$id."' and deleted='0'";
							$result = $this->db->query($sql,__FILE__,__LINE__);
							while($row = $this->db->fetch_array($result))
							{
							?>
							<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
							<?php
							}
							?>
						</select>
	<?php
	
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
	}
	
	
	function DaysCalculate($date1, $date2)
	{
	ob_start();
	if($date1!='' && $date2!='')
	{
	$sql="select * from ".HMS_HOLD_GUEST_RESERVATION." where arrival ='".$date1."' and departure='".$date2."' and cancelled='0'";
	$result = $this->db->query($sql,__FILE__,__LINE__);
	$Cnt = $this->db->num_rows($result);
		if($Cnt<=0)
		{
				if($date1<=$date2)
				{
					if($date1==$date2)
					{
				?>
				<input type="text" value="<?php echo 1;?>" name="no_of_nights" required class="form-control" readonly="readonly">
				<?php
					}
					else
					{
				 $dayscount  =  round(abs(strtotime($date1)-strtotime($date2))/86400);
				?>
				<input type="text" value="<?php echo $dayscount;?>" name="no_of_nights" required class="form-control" readonly="readonly">
				<?php
					}
				}
				else
				{
				?>
					<input type="text" value="" required class="form-control" name="no_of_nights" readonly="readonly">
					<span style="color:#FF0000;">Wroung Date Selection</span>
				<?php
				}
		}
		else
		{
		
		?>
		<input type="text" value="" required class="form-control" name="no_of_nights" readonly="readonly">
		<span style="color:#FF0000;">Hold Reservation Occured B/W this date</span>
		<?php
		}
	}
	else
	{
	?>
	<input type="text" value="" required class="form-control" name="no_of_nights" readonly="readonly">
	<?php
	}
	 	$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	
	
	  
			
			
	
	function EditSection($caseFinder,$res_id)
	{ 
		/* Guest Basic Information fetching start */
		
		$this->GuestId = $this->Master->GetGusetIdByReservationID($res_id);
		$sql="select * from ".HMS_GUEST." where id ='".$this->GuestId."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		/* End */
		
		/* Id card Information fetching start  */
			  	$sql_get_id_type="select * from ".HMS_GUEST_IDENTIFICATION." where reservation_id='".$res_id."'";
				$result_get_id_type = $this->db->query($sql_get_id_type,__FILE__,__LINE__);
				$row_get_id_type = $this->db->fetch_array($result_get_id_type);
				$user_id_number = $row_get_id_type['identification_number']; 
				$user_id_exp_date = $row_get_id_type['identity_exp_date']; 
				$user_id_country_Id = $row_get_id_type['identify_country_id']; 
				$user_id_state_Id = $row_get_id_type['identify_state_id']; 
				$user_id_city_Id = $row_get_id_type['identify_city_id']; 
				
		/* Id card Information fetching start for user */
				
			  
				
		switch($caseFinder)
		{
			case 'local':
			$FormName = 'EditSection'; 
			?>
            <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="<?php echo $FormName ?>">
      <div class="col-md-8">
       <div class="block-flat">
          <div class="header">							
            <h4>Edit Reservation Details</h4>
          </div>
          <div class="content" style="padding-top:0px;">
            
			  <h4 style="font-weight:600">Guest Information:-</h4>
			  <div class="form-group">
			  <div class="col-sm-2" style="padding-right: 6px;padding-left: 1px;">
              <label>Title</label> 
				<select class="form-control" name="title" required>
				<option <?php if($row['title']=='Mr.') { echo 'selected="selected"';}?>  value="Mr.">Mr.</option>
				<option  <?php if($row['title']=='Mrs.') { echo 'selected="selected"';}?>  value="Mrs.">Mrs.</option>
                <option  <?php if($row['title']=='Miss.') { echo 'selected="selected"';}?>  value="Mrs.">Miss.</option>
				</select>
	         </div>
			  <div class="col-sm-5" style="padding-right: 6px;padding-left: 1px;">
              <label>First Name</label> 
			   <input type="text" name="first_name" class="form-control" value="<?php echo $row['first_name'];?>" required placeholder="Type something" />
			  </div>
			  <div class="col-sm-5" style="padding-right: 6px;padding-left: 1px;">
              <label>Last Name</label> 
			   <input type="text" name="last_name" class="form-control" value="<?php echo $row['last_name'];?>" required placeholder="Type something" />
			  </div>
			  </div>
			  
			  <div class="form-group">
			  <div class="col-sm-12" style="padding-right: 6px;padding-left: 1px;">
              <label>Address</label> 
				<textarea class="form-control" name="address" placeholder="Type something"><?php echo $row['address'];?></textarea>
	         </div>
			</div>
			
			<div class="form-group">
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>Country</label> 
<select class="form-control" name="country_id" required onchange="reservation_obj.ChangeState(this.value,{target:'refstatelisting',preloader:'pr3'})">
				<option value="">-- Select Country --</option>
				<?php
				$sql_1="select * from ".HMS_COUNTRY;
				$result_1 = $this->db->query($sql_1,__FILE__,__LINE__);
				while($row_1 = $this->db->fetch_array($result_1))
				{
				?>
				<option value="<?php echo $row_1['id'];?>" <?php if($row_1['id']==$row['country_id']) { echo 'selected="selected"';}?>><?php echo $row_1['name'];?></option>
				<?php
				}
				?>
				</select>
	         </div>
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
			 
				 	 <label>State</label> <img id="pr3" src="img/status.gif" style="visibility:hidden; height:25px;"> 
					  <div id="refstatelisting">
				 	   <?php echo $this->ChangeState($row['country_id'],$row['state_id']);?>
					</div>
			  </div>
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>City</label> <img id="pr4" src="img/status.gif" style="visibility:hidden; height:25px;"> 
			  <div id="refcitylisting">
				 	    <?php echo $this->ChangeCity($row['state_id'],$row['city_id']);?>
					</div>
			  </div>
			  </div>
			  <div class="form-group">
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>Zip Code</label> 
				 <input  type="text" name="zipcode" class="form-control" value="<?php echo $row['zipcode'];?>"  placeholder="Type something" />
	         </div>
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>Email</label> 
			  <input type="email" class="form-control" name="email" value="<?php echo $row['email'];?>"  placeholder="Type something" />
			  </div>
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>Phone</label> 
			     <input data-parsley-type="digits" type="text" name="phone" value="<?php echo $row['phone'];?>" class="form-control" required placeholder="Type something" />
			  </div>
			  </div>
			    <h4 style="font-weight:600">Identity Information:-</h4>
			  <div class="form-group">
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>ID Type</label> 
				 	<?php $this->Master->Identfication_Type($res_id);?>
	         </div>
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>ID Number</label>
              <input data-parsley-type="alphanum" name="identification_number" value="<?php echo $user_id_number;?>" type="text" class="form-control" required placeholder="Type something" />
			  </div>
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>Expiry Date</label> 
			 <div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
                    <input class="form-control" size="16" name="identity_exp_date" type="text" value="<?php echo $user_id_exp_date;?>" readonly>
                    <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
                  </div>
			  </div>
			  </div>
			  <div class="form-group" style="padding-bottom:25px;">
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>Country</label> 
				<select class="form-control" name="identify_country_id" required onchange="reservation_obj.ChangeIdentificationState(this.value,{target:'refidentystatelisting',preloader:'pr'})">
				<option value="">-- Select Country --</option>
				<?php
				$sql_2="select * from ".HMS_COUNTRY;
				$result_2 = $this->db->query($sql_2,__FILE__,__LINE__);
				while($row_2 = $this->db->fetch_array($result_2))
				{
				?>
				<option value="<?php echo $row_2['id'];?>" <?php if($row_2['id']==$user_id_country_Id) { echo 'selected="selected"';}?>><?php echo $row_2['name'];?></option>
				<?php
				}
				?>
				</select>
	         </div>
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>State</label> <img id="pr" src="img/status.gif" style="visibility:hidden; height:25px;">  
			 	 <div id="refidentystatelisting">
				 <?php echo $this->ChangeIdentificationState($user_id_country_Id,$user_id_state_Id);?>
				</div>
			  </div>
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>City</label> <img id="pr2" src="img/status.gif" style="visibility:hidden; height:25px;"> 
			  <div id="refIdentifycitylisting">
			  <?php echo $this->ChangeIdentificationCity($user_id_state_Id,$user_id_city_Id);?>
				</div>
			  </div>
              
              
              
			  </div>
              <div class="form-group" style=" margin-top: 45px;
    padding-bottom: 26px;">
                <div class="col-sm-offset-2 col-sm-10">
                 <button class="btn btn-default">Cancel</button>
				  <button type="submit" class="btn btn-primary" name="submited" value="Edit Info">Edit Info</button>
                </div>
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
			
			 $this->title = $title;
			 $this->first_name = $first_name;
			 $this->last_name = $last_name;
			 $this->address = $address;
			 $this->country_id = $country_id;
			 $this->state_id = $state_id;
			 $this->city_id = $city_id;
			 $this->zipcode = $zipcode;
			 $this->email = $email;
			 $this->phone = $phone;
			 $this->identification_id = $identification_id;
			 $this->identification_number = $identification_number;
			 $this->identity_exp_date = $identity_exp_date;
			 $this->identify_country_id = $identify_country_id;
			 $this->identify_state_id = $identify_state_id;
			 $this->identify_city_id = $identify_city_id;
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($first_name,'empty','Please Enter First Name')==false)
							$return =false;
						if($this->Form->ValidField($last_name,'empty','Please Enter Last Name')==false)
							$return =false;
						if($this->Form->ValidField($country_id,'empty','Please Select Country')==false)
							$return =false;
						if($this->Form->ValidField($state_id,'empty','Please Select State')==false)
							$return =false;
						if($this->Form->ValidField($city_id,'empty','Please Select City')==false)
							$return =false;
							if($this->Form->ValidField($phone,'empty','Please Enter phone no')==false)
							$return =false;
							/* End Validation  */
							
						if($return){
							
							$update_sql_array = array();
							$update_sql_array['title'] = $this->title;
							$update_sql_array['first_name'] = $this->first_name;
							$update_sql_array['last_name'] = $this->last_name;
							$update_sql_array['address'] = $this->address;
							$update_sql_array['country_id'] = $this->country_id;
							$update_sql_array['state_id'] = $this->state_id;
							$update_sql_array['city_id'] = $this->city_id;
							$update_sql_array['zipcode'] = $this->zipcode;
							$update_sql_array['email'] = $this->email;
							$update_sql_array['phone'] = $this->phone;
							$this->db->update(HMS_GUEST,$update_sql_array,'id',$this->GuestId);
							
							$update_sql_array1['identification_id'] = $this->identification_id;
							$update_sql_array1['identification_number'] =  $this->identification_number;
							$update_sql_array1['identity_exp_date'] =  $this->identity_exp_date;
							$update_sql_array1['identify_country_id'] =  $this->identify_country_id;
							$update_sql_array1['identify_state_id'] =  $this->identify_state_id;
							$update_sql_array1['identify_city_id'] =  $this->identify_city_id;
			 
			 				$this->db->update(HMS_GUEST_IDENTIFICATION,$update_sql_array1,'reservation_id',$res_id);
			 
							
							
							$_SESSION['msg'] = 'Guest Details has been Successfully Updated.';
							
							?>
							<script type="text/javascript">
								window.location = "reservation_lising.php"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->EditSection('local',$res_id);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	
	function PaymentSection($runat,$guestid,$reservationid)
	{
		switch($runat)
		{
		
			case 'local':
			$FormName = "form_payment";
			
			?>
       <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="<?php echo $FormName ?>">
      
	<div class="col-md-12">
					<div class="block-flat">
						<div class="header">							
							<h4>Payment Details</h4>
						</div>
						<div class="content">
							<div class="table-responsive">
							<table class="table no-border hover">
								<thead class="no-border">
									<tr>
										
										<th style="width:14%;"><strong>Date</strong></th>
										<th style="width:28%;" class="text-left"><strong>Description</strong></th>
										<th  style="width:28%;" class="text-center"><strong>Referance</strong></th>
										<th style="width:15%;" class="text-center"><strong>Debit INR</strong></th>
										<th style="width:15%;" class="text-center"><strong>Credit INR</strong></th>
									</tr>
								</thead>
								<tbody class="no-border-y">
									<tr>
										<td><?php echo date('d/m/Y');?></td>
										<td class="text-left">Rooms (<?php echo $this->Master->TotalBookedRoomsByReservationId($reservationid);?> <?php echo $this->Master->RoomTypeByReservationId($reservationid);?>)</td>
										<td class="text-center">[ NA Room ]</td>
										<td class="text-center"><?php echo $this->Master->getRoomTotalAmount($reservationid);?></td>
										<td class="text-center"></td>
									</tr>
									<?php
								   if($this->Master->ExtraBedAllowed($reservationid)!=0)
								   {
								    ?>
                                   <tr>
										<td class="text-left"><?php echo date('d/m/Y');?></td>
										<td class="text-left">Bed Booked (<?php echo $this->Master->ExtraBedAllowed($reservationid);?>)</td>
										<td class="text-center">[ NA Room ]</td>
				<td class="text-center"><?php echo $this->Master->ExtraBedPriceOnReservation($reservationid);?></td>
										<td class="text-center"></td>
									</tr>
                                    <?php
								   }
								   ?>
									<tr><td colspan="3"><strong>Total Product Cost:-</strong></td>
									 <td class="text-center" ><?php echo $this->Master->TotalProductCost($reservationid);?></td>
									<input type="hidden" readonly="readonly" class="form-control" style="width:120px;" required  value="<?php echo $this->Master->TotalProductCost($reservationid);?>" name="main_cost" />
                                    </tr>
                                      
                                    <tr>
									<td></td>
								    <td></td>
									<td class="text-center"><strong>Any Discount:-</strong></td>
									 <td class="text-center" colspan="2">
									 <input type="text" name="discount"  onchange="reservation_obj.getpayableamount(this.form.main_cost.value,this.value,{})" placeholder="0.00" onkeyup="reservation_obj.getpayableamount(this.form.main_cost.value,this.value,{})" data-parsley-type="number" value="0" class="form-control" style="width:120px;" required/></td>
								</tr>
                                <tr>
									<td></td>
								    <td></td>
									<td class="text-center"><strong>Prduct Cost:-</strong></td>
									 <td class="text-center" colspan="2">
									<input type="text" readonly="readonly" class="form-control" style="width:120px;" required  value="<?php echo $this->Master->TotalProductCost($reservationid);?>" id="totalProCost" name="procost" /></td>
								</tr>
        						
        
                                 <tr>
									<td class="text-left" colspan="5"><strong>Applied Taxes:-</strong></td>
								   </tr> 
                                   <script>
								   function check_lux(total)
									{
									var toatlamt=0;
									var stotal=0;
									var sercharge=0;
									var serCharge=0 ;
									var gn, elem;
									for(var i=1; i<=2;i++){
									gn = 'tax'+i;
									elem = document.getElementById(gn);
									
									if (elem.checked == true) {
										 stotal += Number(total*elem.value/100);
										 if (elem.checked == true && i==1) 
										 
										 document.getElementById('lux_tax').value= total*elem.value/100;
										 }
										 if(elem.checked == true && i==2)
										 {
											 document.getElementById('ser_tax').value= total*elem.value/100;
										 }
									}
									
									var toatlamt = parseFloat(stotal) + parseFloat(total);
									//sercharge = document.getElementById('tax3');
									//if (sercharge.checked == true) { serCharge = Number(sercharge.value) * toatlamt/100; }
									//toatlamt = parseFloat(serCharge) + parseFloat(toatlamt);
									document.getElementById('totalamtwithTax').value= toatlamt;
									//document.getElementById('service_charge').value= serCharge;
									}
								   </script>
                                    <tr>
										<td class="text-left" colspan="5">
                                        <?php
										$x=1;
				$sql_tax="select * from ".HMS_TAXS." where id!='3' and id!='4' and id!='10' and used_for='f'";
				$result_tax = $this->db->query($sql_tax,__FILE__,__LINE__);
				while($row_tax = $this->db->fetch_array($result_tax))
				{
				?>
                                        <p>
                                        <input type="checkbox" value="<?php echo $row_tax['percent_value'];?>" id="tax<?php echo $x; ?>" name="tax<?php echo $x;?>" onchange="javascript:check_lux(this.form.procost.value);"/> <?php echo $row_tax['tax_name'];?> 
                                        [<?php echo $row_tax['percent_value'].'%';?> ]</p>
                                        <?php $x++;}?>
               
                                        </td>
							       </tr>
                                 	 
                                  
                     			   <tr>
									<td><input type="hidden" id="lux_tax" name="lux_tax" value="" />
                                    </td>
								    <td><input type="hidden" id="ser_tax" name="ser_tax" value="" /></td>
									<td class="text-center"><strong>Total Amount:-</strong></td>
									 <td class="text-center" colspan="2">
									 <input type="text" id="totalamtwithTax" value="<?php echo $this->Master->TotalPayAableAmount($this->Master->TotalProductCost($reservationid));?>" class="form-control" name="total_amount" readonly="readonly" style="width:120px;" placeholder="0.00"> 
									 </td>
								</tr>
								<tr>
									<td><strong>Payment Method:-</strong></td>
								    <td><select class="form-control" style="width:195px;" name="payment_mode">
					<option value="">-- Choose Payment Type --</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Cash">Cash</option>
                    <option value="Credit/Debit Card">Credit/Debit Card</option>
                    </select></td>
									<td class="text-center"><strong>Paid Amount:-</strong></td>
									 <td class="text-center" colspan="2">
									 <input type="text"  onchange="reservation_obj.calculatetotal(this.form.total_amount.value,this.value,{})" placeholder="0.00" onkeyup="reservation_obj.calculatetotal(this.form.total_amount.value,this.value,{})" name="paid_amount" value="" data-parsley-type="number" class="form-control" style="width:120px;" required/></td>
								</tr>
                                
								<tr>
								
									<td>Receipt No.</td>
								    <td><input type="text" required  value="" class="form-control" name="receipt_no" data-parsley-type="digits"  style="width:194px;"></td>
									
									<td class="text-center"><strong>Balance Amount:-</strong></td>
									 <td class="text-center" colspan="2">
									 <input type="text"   id="amount_left" name="remain_amount"  placeholder="0.00" class="form-control" readonly="readonly" value="" style="width:120px;"/></td>
								</tr>	
								</tbody>
							</table>		
							</div>
							<div class="form-group" style=" margin-top: 45px;padding-bottom: 26px;">
                <div class="col-sm-offset-2 col-sm-10">
				<div  style="float:right;">
                 <button class="btn btn-default">Cancel</button>
				  <button type="submit" class="btn btn-primary" name="submitPayment" value="Pay Now">Pay Now</button>
				  </div>
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
			
			
				$this->lux_tax = $lux_tax;
				$this->ser_tax = $ser_tax;
				$this->total_amount = $total_amount;
				$this->paid_amount = $paid_amount;
				$this->remain_amount = $remain_amount;
				$this->payment_mode = $payment_mode;
				$this->discount = $discount;
				$this->tax1 = $tax1;
				$this->tax2 = $tax2;
				$this->procost = $procost;
				$this->receipt_no = $receipt_no;
			
			$return = true;
			
		if($this->Form->ValidField($total_amount,'empty','Please enter total amont')==false)
			$return =false;
		if($this->Form->ValidField($paid_amount,'empty','Please enter amount paid')==false)
		    $return =false;
		if($this->Form->ValidField($payment_mode,'empty','Please select any payment mode')==false)
		    $return =false;
			
			
			    $sql = "select * from ".HMS_RESERVATION_PAYMENTS." where reservation_id='".$reservationid."'";
				$record = $this->db->query($sql,__FILE__,__LINE__);
				$cnt = $this->db->num_rows($record);
				if($cnt>0)
				{
					$_SESSION['error_msg'] = 'Invalid Entry! Payment Already done';
					?>
                    <script type="text/javascript">
							window.location = 'add_reservation.php';
							</script>
                    <?php
					exit();
				}
			
			
			
			if($return){
							$insert_sql_array = array();
							$insert_sql_array['base_price'] = $this->Master->getRoomTotalAmount($reservationid);
						    $insert_sql_array['extra_bed'] = $this->Master->getExtraBedCost($reservationid);
							if($this->tax1!='')
							{
							$insert_sql_array['tax1'] = $this->lux_tax;
							}
							if($this->tax2!='')
							{
							$insert_sql_array['tax2'] =  $this->ser_tax;
							}
							$insert_sql_array['total_amount'] = $this->total_amount;
							$insert_sql_array['advance_amount'] = $this->paid_amount;
							$insert_sql_array['total_paid_amount'] = $this->paid_amount;
							$insert_sql_array['payment_mode'] = $this->payment_mode;
							$insert_sql_array['remain_amount'] = $this->remain_amount;
							$insert_sql_array['discount'] = $this->discount;
							$insert_sql_array['payment_date'] = date('Y-m-d h:i:s A');
							$insert_sql_array['guest_id'] = $guestid;
							$insert_sql_array['reservation_id'] = $reservationid;
							$insert_sql_array['receipt_no'] = $this->receipt_no;
							$insert_sql_array['user_id'] = $_SESSION['user_id'];
							
							$this->db->insert(HMS_RESERVATION_PAYMENTS,$insert_sql_array);
							$pay_id = $this->db->last_insert_id();
						    $_SESSION['msg'] = 'Guest payment done successfully.';	
							
								$this->objMail->IsHTML(true);
								$this->objMail->From = "info@myriadhotel.co.in";
								$this->objMail->FromName = "Hotel Myriad";
								$this->objMail->Sender = 'info@myriadhotel.co.in';
								$this->objMail->AddAddress(EMAIL_ADDRESS);
								$this->objMail->Subject = 'New Reservation';							
															
								$this->objMail->Body = '<br/>Hi Admin, This is new reservation details<br/><br/><br/>';
								$this->objMail->Body .= '<div style="width:600px; height:842px; padding-left:15px; background:#2494F2; color:#000;"><br/>';
								$this->objMail->Body .= '<br/><div style="width:595px; height:842px; padding-left:15px; background:#2494F2; color:#000;"><br/>';
								$this->objMail->Body .= '<div style="height:125px;"><img src="'.$_SERVER['HTTP_HOST'].'/images/header.jpg" style="height:135px;" width="584" /></div>';
								$this->objMail->Body .= '<div style="width:570px; float:left; margin:12px;"';
								$this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#FFF;"><strong>'.$this->Master->FindGuestNameByGuestId($guestid).'</strong></p>';
								$this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#FFF;"><strong>'.$this->Master->FindGuestCityByGuestId($guestid).' '.$this->Master->FindGuestStateByGuestId($guestid).'</strong></p>';
								$this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#FFF;"><strong>'.$this->Master->FindGuestCountryByGuestId($guestid).', '.$this->Master->FindGuestZipcodeByGuestId($guestid).'</strong></p>';
							   $this->objMail->Body .= '</div>';
							   $this->objMail->Body .= '<div style="clear:both"></div>';
							   
							   $this->objMail->Body .= '<div style="width:570px;  margin:12px;">';
							   
							   $this->objMail->Body .= '<div style="width:59%; float:left;">';
							   $this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#fff;"><strong style="color:#000;">Arrival:</strong> '.$this->Master->ArrivalDateByReservationId($reservationid).'</p>';
							   $this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#fff;"><strong style="color:#000;">Departure:</strong> '.$this->Master->DeparturelDateByReservationId($reservationid).'</p>';
							   $this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#fff;"><strong style="color:#000;">Room Type:</strong> '.$this->Master->RoomTypeByReservationId($reservationid).'</p>';
							   
							   if($this->Master->getreservationOccpany($reservationid)==1)
							   {
							   $this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#fff;"><strong style="color:#000;">Rate:</strong> '.$this->Master->GetRoomPriceByReservationIdforSingleOccupany($reservationid).'</p>';
							   }
							   else
							   {
								$this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#fff;"><strong style="color:#000;">Rate:</strong> '.$this->Master->GetRoomPriceByReservationIdforDoubleOccupany($reservationid).'</p>';  
							   }
							   
							   $this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#fff;"><strong style="color:#000;">Time:</strong> '.date('l jS \of F Y h:i:s A').'</p>';
							   $this->objMail->Body .= '</div>';
							   
										$x=1001;
                                        $sql_1 = "select * from ".HMS_RESERVATION_PAYMENTS	;
										$result_1= $this->db->query($sql_1,__FILE__,__LINE__);
										while($row_1= $this->db->fetch_array($result_1))
										{
										$x++;
										}
										$invoice = $x-1;
										
							    $this->objMail->Body .= '<div style="width:39%; float:left;">';
							    $this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#fff;"><strong style="color:#000;">Invoice No.</strong> '.$invoice.'</p>';
								$this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#fff;"><strong style="color:#000;">Receipt No.</strong> '.$this->receipt_no.'</p>';
							   $this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#fff;"><strong style="color:#000;">Adults/Children:</strong> '.$this->Master->TotalAdultReservationId($reservationid).'/'.$this->Master->TotalChildReservationId($reservationid).'</p>';
							   $this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#fff;"><strong style="color:#000;">No. Of Days:</strong> '.$this->Master->TotalNightsByReservationId($reservationid).'</p>';
							   $this->objMail->Body .= '<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px; color:#fff;"><strong style="color:#000;">Cashier: </strong>'.ucwords($_SESSION['user_name']).' ['.$this->Master->GetUserLevelByUserTypeId($_SESSION['user_type']).']</p>';
							   $this->objMail->Body .= '</div>';
							   $this->objMail->Body .= '</div>';
							   
							   $this->objMail->Body .= '<div style="clear:both"></div>';
							   
							   $this->objMail->Body .= '<br/><div style="width:570px; margin:12px;">';
							   $this->objMail->Body .= '<div style="clear:both"></div>';
							   
								$this->objMail->Body .= '<div style="width:560px; border:1px solid #000; border-bottom:2px solid #666; height:34px; background:#EBEBEB; border-left:none; border-right:none;">';
								$sql_2 = "select * from ".HMS_RESERVATION_PAYMENTS." where id='".$pay_id."'";
							$result_2= $this->db->query($sql_2,__FILE__,__LINE__);
							$row_2= $this->db->fetch_array($result_2);
							
								$this->objMail->Body .= '<table width="100%"  border="0" cellspacing="5" cellpadding="5">';
								$this->objMail->Body .= '<tr>
								<th scope="col" width="15%">Date</th>
								<th scope="col" width="27%">Description</th>
								<th scope="col" width="28%">Reference</th>
								<th scope="col" width="15%">Debit</th>
								<th scope="col" width="15%">Credit</th>
								</tr>';
								$this->objMail->Body .= '<tr>
								<td>'.date('d-m-Y', strtotime($row_2['payment_date'])).'</td>
								<td>Room ['.$this->Master->TotalBookedRoomsByReservationId($reservationid).'] ['.$this->Master->RoomTypeByReservationId($reservationid).']</td>
								<td>[ NA Room ]</td>
								<td>'.$this->Master->getRoomTotalAmount($reservationid).'</td>
								<td>&nbsp;</td>
								</tr>';
							if($this->Master->ExtraBedAllowed($reservationid)!=0)
							{
								$this->objMail->Body .= ' <tr>
								<td>'.date('d-m-Y', strtotime($row_2['payment_date'])).'</td>
								<td>Bed Booked ['.$this->Master->ExtraBedAllowed($reservationid).']</td>
								<td>[ NA Room ]</td>
								<td>'.$this->Master->ExtraBedPriceOnReservation($reservationid).'</td>
								<td>&nbsp;</td>
								</tr>';
							}
							
							
							
							if($row_2['tax1']!=0)
							{
								$this->objMail->Body .= '<tr>
								<td>'.date('d-m-Y', strtotime($row_2['payment_date'])).'</td>
								<td>Luxury Tax</td>
								<td>'.$this->Master->GetTaxValue(1).'% (On Room)</td>
								<td>'.$row_2['tax1'].'</td>
								<td>&nbsp;</td>
								</tr>';
							}
							if($row_2['tax2']!=0)
							{
								$this->objMail->Body .= '<tr>
								<td>'.date('d-m-Y', strtotime($row_2['payment_date'])).'</td>
								<td>Service Tax</td>
								<td>'.$this->Master->GetTaxValue(2).'% (On Room)</td>
								<td>'.$row_2['tax2'].'</td>
								<td>&nbsp;</td>
								</tr>';
							}
							
								$this->objMail->Body .= '</table>';
								$this->objMail->Body .= '<hr/><table width="100%"  border="0" cellspacing="5" cellpadding="5">';
								$this->objMail->Body .= '<tr>
								<th scope="col" width="36%"></th>
								<th scope="col" width="25%">Total Amount</th>
								<th scope="col" width="25%">'.$row_2['total_amount']+$row_2['discount'].' INR</th>
								<th scope="col" width="25%"></th>
								</tr>';
								
								$this->objMail->Body .= '<tr>
								<th scope="col" width="36%">Payment Mode: '.$this->payment_mode.'</th>
								<th scope="col" width="25%">Paid Amount</th>
								<th scope="col" width="25%"></th>
								<th scope="col" width="25%">'.$row_2['advance_amount'].' INR</th>
								</tr>';
								$this->objMail->Body .= '<tr>
								<th scope="col" width="36%"></th>
								<th scope="col" width="25%">Discount</th>
								<th scope="col" width="25%"></th>
								<th scope="col" width="25%">'.$row_2['discount'].' INR</th>
								</tr>';
								
								$this->objMail->Body .= '<tr>
								<th scope="col" width="36%"></th>
								<th scope="col" width="25%">Payment Due</th>
								<th scope="col" width="25%"></th>
								<th scope="col" width="25%">'.$row_2['remain_amount'].' INR</th>
								</tr>';
								$this->objMail->Body .= '</table>';
								$this->objMail->Body .= '</div>';
								$this->objMail->Body .= '</div>';
							    $this->objMail->Body .= '</div><br/><br/>';
								$this->objMail->Body .= 'Regards,<br/>';
								$this->objMail->Body .= '<hr>Hotel Myriad<br/>';
								$this->objMail->WordWrap = 50;
								$this->objMail->Send();
								
							?> 
							<script type="text/javascript">
							
							window.location = 'invoice.php?index=advancepayment&paymentId=<?php echo $pay_id;?>';
							</script>
							<?php
							exit();
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->PaymentSection('local',$guestid,$reservationid);
							}
							
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
	
/*	function addtaxes($tax_id1,$tax_id2,$tax_id3,$product_total)
	{
		ob_start();
		
		$toatlamt = 0;
		$luxTax = 0;
		$serTax = 0;
		$sercharge = 0;
		?>
        <script type="text/javascript">
		alert('<?php echo $tax_id1.'dfghjkl'.$tax_id2.'gjvhjk'.$tax_id3.'fgvhjk'.$product_total;  ?>');
		</script>
        <?php
		if($tax_id1==1)
		{
			$luxTax = $this->Master->GetTaxValueOnProduct($product_total,$this->Master->GetTaxValue($tax_id1));
			
			$toatlamt  = $product_total+$luxTax;
		}
		if($tax_id2==2)
		{
			$serTax = $this->Master->GetTaxValueOnProduct($product_total,$this->Master->GetTaxValue($tax_id2));
			$toatlamt = $serTax+$product_total+$luxTax;
		}
		if($tax_id3==4)
		{
			$serTax = $this->Master->GetTaxValueOnProduct($toatlamt,$this->Master->GetTaxValue($tax_id3));
			$toatlamt = $toatlamt+$serTax;
		}
		?>
		<script>
		document.getElementById('totalamtwithTax').value=<?php echo  $toatlamt; ?>;
		</script>
		
		<?php 
		
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
		
	}*/
	
		function InvoiceSection($payId)
		{
		$sql="select * from ".HMS_RESERVATION_PAYMENTS." where id ='".$payId."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		?>
		
	  
		<div class="col-md-12" id="abc">
       <div class="block-flat" style="height:1250px;">
          <div class="header" style="border:none;">							
            <h3><img src="img/invoice_header.jpg" style="width:950px; height:150px;" /></h3>
          </div>
          <div class="content">
		  <div class="col-md-12">
						<h4><strong> <?php echo $this->Master->FindGuestNameByGuestId($row['guest_id'])?></strong></h4>
							<p style="margin-bottom:1px;"><strong><?php echo $this->Master->FindGuestAddressByGuestId($row['guest_id'])?></strong></p>
							<p style="margin-bottom:1px;"><strong><?php echo $this->Master->FindGuestCityByGuestId($row['guest_id'])?> <?php echo $this->Master->FindGuestStateByGuestId($row['guest_id'])?></strong></p>
							<p style="margin-bottom:1px;"><strong><?php echo $this->Master->FindGuestCountryByGuestId($row['guest_id'])?>, <?php echo $this->Master->FindGuestZipcodeByGuestId($row['guest_id'])?></strong></p>
		</div>
			<div class="col-md-12" style="margin-top:25px;">
						<div style="width:49%;  float:left;">
						<p><strong>Arrival    :  </strong>  <?php echo $this->Master->ArrivalDateByReservationId($row['reservation_id'])?></p>
						<p><strong>Departure  :  </strong>  <?php echo $this->Master->DeparturelDateByReservationId($row['reservation_id'])?></p>
						<p><strong>Room Type  :  </strong>  <?php echo $this->Master->RoomTypeByReservationId($row['reservation_id'])?></p>
                        <?php
						//echo $this->Master->getreservationOccpany($row['reservation_id']);
                               if($this->Master->getreservationOccpany($row['reservation_id'])==1)
							   {
								   ?>
                           <p><strong>Rate:  </strong> <?php echo $this->Master->GetRoomPriceByReservationIdforSingleOccupany($row['reservation_id'])?></p>
                                   <?php
							   }
							   else
							   {
								?>
                           <p><strong>Rate:  </strong> <?php echo $this->Master->GetRoomPriceByReservationIdforDoubleOccupany($row['reservation_id'])?></p>
                                   <?php  
							   }
                               ?>
						<p><?php echo date('l jS \of F Y h:i:s A');?></p>
						</div>
						<div style="width:49%; float:right;">
						
						                <?php
										$x=1001;
                                        $sql_1 = "select * from ".HMS_RESERVATION_PAYMENTS	;
										$result_1= $this->db->query($sql_1,__FILE__,__LINE__);
										while($row_1= $this->db->fetch_array($result_1))
										$x++;
										?>
						<p><strong>Invoice No.:  </strong> <?php echo $x;?></p>
                        <p><strong>Receipt No:  </strong> <?php echo $row['receipt_no'];?></p>
						<p><strong>Adults/Children    :  </strong>   <?php echo $this->Master->TotalAdultReservationId($row['reservation_id'])?>/<?php echo $this->Master->TotalChildReservationId($row['reservation_id'])?></p>
						
						<p><strong>No. Of Days  :  </strong>  <?php echo $this->Master->TotalNightsByReservationId($row['reservation_id'])?></p>
						<p><strong>Cashier  :  </strong>  </p>
						</div>
						</div>
		
		 
		
		  <div class="col-md-12">
		  <div class="table-responsive">
							<table class="table no-border hover">
								<thead class="no-border">
									<tr style="border-top:1px solid #999999; background:#EBEBEB;">
										<th style="width:14%;"><strong>Date</strong></th>
										<th style="width:28%;" class="text-left"><strong>Description</strong></th>
										<th  style="width:28%;" class="text-center"><strong>Referance</strong></th>
										<th style="width:15%;" class="text-center"><strong>Debit INR</strong></th>
										<th style="width:15%;" class="text-center"><strong>Credit INR</strong></th>
									</tr>
								</thead>
								<tbody class="no-border-y">
									<tr>
										<td><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left">Rooms (<?php echo $this->Master->TotalBookedRoomsByReservationId($row['reservation_id']);?> <?php echo $this->Master->RoomTypeByReservationId($row['reservation_id']);?>)</td>
										<td class="text-center">[ NA Room ]</td>
										<td class="text-center"><?php echo $this->Master->getRoomTotalAmount($row['reservation_id']);?></td>
										<td class="text-center"></td>
									</tr>
									
				            <?php
								   if($this->Master->ExtraBedAllowed($row['reservation_id'])!=0)
								   {
								    ?>
                                   <tr>
										<td class="text-left"><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left">Bed Booked (<?php echo $this->Master->ExtraBedAllowed($row['reservation_id']);?>)</td>
										<td class="text-center">[ NA Room ]</td>
				<td class="text-center"><?php echo $this->Master->ExtraBedPriceOnReservation($row['reservation_id']);?></td>
										<td class="text-center"></td>
									</tr>
                                    <?php
								   }
								   ?>      
									
							<?php
							if($row['tax1']>0)
							{
								?>
								<tr>
										<td><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left"><?php echo $this->Master->GetTaxType(1)?> </td>
										<td class="text-center"><?php echo $this->Master->GetTaxValue(1)?>% [Added On Room]</td>
										<td class="text-center"><?php echo $row['tax1'];?></td>
										<td class="text-center"></td>
								</tr>
                              <?php
							}
							?>
                            <?php
							if($row['tax2']>0)
							{
								?>
								<tr>
										<td><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left"><?php echo $this->Master->GetTaxType(2)?> </td>
										<td class="text-center"><?php echo $this->Master->GetTaxValue(2)?>% [Added On Room]</td>
										<td class="text-center"><?php echo $row['tax2'];?></td>
										<td class="text-center"></td>
								</tr>
                              <?php
							}
							?>
                             <?php
							/*if($row['service_charge']!=0)
							{
								?>
								<tr>
										<td><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left"> Service Charge</td>
										<td class="text-center"><?php echo $this->Master->GetTaxValue(4);?>%</td>
										<td class="text-center"><?php echo round($row['service_charge']);?></td>
										<td class="text-center"></td>
								</tr>
                              <?php
							}*/
							?>
								<tr>
									<td><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
								    <td><?php echo $row['payment_mode']?></td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									 <td class="text-center"><?php echo $row['advance_amount']?></td>
							   </tr>
							   
							</tbody>
							</table>		
							</div>
							<hr style="background:#000000; height:2px;"/>
							<div class="table-responsive">
							<table class="table no-border hover">
								<thead class="no-border">
									<tr>
										<th style="width:14%;"></th>
										<th style="width:28%;" class="text-left"></th>
										<th  style="width:28%;" class="text-center"><strong>Total</strong></th>
										<th style="width:15%;" class="text-center"><strong><?php echo $row['total_amount']+$row['discount'];?> INR</strong></th>
										<th style="width:15%;" class="text-center"><strong><?php echo $row['total_paid_amount']?> INR</strong></th>
									</tr>
                                    <tr>
										<th style="width:14%;"></th>
										<th style="width:28%;" class="text-left"></th>
										<th  style="width:28%;" class="text-center"><strong>Discount</strong></th>
										<th style="width:15%;" class="text-center"></th>
										<th style="width:15%;" class="text-center"><strong><?php echo $row['discount']?> INR</strong></th>
									</tr>
                                    <tr>
										<th style="width:14%;"></th>
										<th style="width:28%;" class="text-left"></th>
										<th  style="width:28%;" class="text-center"><strong>Total Balance Due</strong></th>
										<th style="width:15%;" class="text-center"></th>
										<th style="width:15%;" class="text-center"><strong><?php echo $row['remain_amount']?> INR</strong></th>
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
	
	
		function calculatetotal($total_payable_amout='',$paid_amount='')
	{
	    ob_start();
		
		$amount_left=0;
		
		$amount_left = $total_payable_amout-$paid_amount;
		?>
		<script>
		document.getElementById('amount_left').value=<?php echo  $amount_left; ?>;
		
		</script>
		
		<?php 
		
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
		function getpayableamount($total,$discount)
	{
			ob_start();
			
			if($discount < $total)
			{
			$totalamontpayment = $total-$discount;
			?>
			<script>
			document.getElementById('totalamtwithTax').value= <?php echo  $totalamontpayment; ?>;
			document.getElementById('totalProCost').value= <?php echo  $totalamontpayment; ?>;
			</script>
			<?php 
			}
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	
	
	
	function ReservationListing($first_name='',$last_name='',$phone='',$arrival='',$departure='',$room_type_id='')
	{
	
			$sql="select * from ".HMS_GUEST_RESERVATION." where deleted='0'";
			
			 $sql .= " order by arrival desc";
			
			
			
			$result = $this->db->query($sql,__FILE__,__LINE__);
			$cnt = $this->db->num_rows($result);
			?>
            <div class="col-sm-10 col-md-10">
						<div class="block">
						<div class="header">
						<h4>Reservation List</h4>
						</div>
						<div class="content" style="max-height:600px; overflow:auto;">
                        <?php
			if($cnt>0)
			{
				while($row = $this->db->fetch_array($result))
				{
					?>
			<div class="block-flat profile-info" style="padding-top:5px; margin-bottom:10px;">
			<div class="row">
			<div class="col-sm-10">
			<div class="personal" style="padding-bottom:2px;">
				<h4><strong style="color:#2494F2;"> <?php echo $this->Master->FindGuestNameByGuestId($row['guest_id'])?></strong></h4>
		
			<div class="col-md-4 col-sm-5"><strong>Arrival: </strong><?php echo $row['arrival'];?></div>
			<div class="col-md-4 col-sm-5"><strong>Departure: </strong><?php echo $row['departure'];?></div>
			<div class="col-md-4 col-sm-5"><strong>Contact: </strong><?php echo $this->Master->FindGuestPhoneByGuestId($row['guest_id'])?> </div>
			<div class="col-md-4 col-sm-5"><strong>Adult/Child: </strong>  <?php echo $row['adult_count']?>/<?php echo $row['child_count']?></div>
			<div class="col-md-4 col-sm-5"><strong>Email: </strong><?php echo $this->Master->FindGuestEmailByGuestId($row['guest_id'])?></div>
			<div class="col-md-4 col-sm-5"><strong>Room Type: </strong> <?php echo $this->Master->RoomTypeByReservationId($row['id'])?></div>
			</div>
			</div>
			<div class="col-sm-2">
			<div class="btn-group" style="margin-top:30px;">
			<button type="button" class="btn btn-default">Settings</button>
			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
			</button>
			<ul class="dropdown-menu" role="menu">
			<!--<li><a href="#">View Profile</a></li>-->
            <?php
            if($row['check_in_status']==0)
			{?>
            <li><a href="reservation_lising.php?index=checkIn&res_id=<?php echo $row['id'];?>">Check-In</a></li>
            
            <?php } elseif($row['check_in_status']==1) { ?>
            <li><a href="reservation_lising.php?index=checkOut&res_id=<?php echo $row['id'];?>">Check-Out</a></li>
            <li><a href="add_reservation.php?index=EditInfo&res_id=<?php echo $row['id'];?>">Edit Info</a></li>
            <?php } else {?>
            <li>
            <li><a href="invoice.php?index=billinfo&res_id=<?php echo $row['id'];?>">Billing Info</a></li>
            </li>
            <?php } 
			if($_SESSION['user_type']==1 or $_SESSION['user_type']==2)
			{
			?>
			<li class="divider"></li>
			<li> <a  href="javascript: void(0);" title="Remove" onclick="javascript: if(confirm('Do u want to delete this Guset Reservation Info?')) { reservation_obj.deleteguest('<?php echo $row['id'];?>',{}) };">Remove Guest</a></li>
            <?php
			}
			?>
			</ul>
			</div>
			</div>
			</div>
			</div>
				<?php
			}
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
						</div>
						</div>
						</div>	
                        <?php
	}
	
	function deleteguest($res_id)
	{
		ob_start();
			
			/*Start deleting only this reservation by making delete status = 1*/
			$update_array = array();
			$update_array['deleted'] = 1 ;
		
			$this->db->update(HMS_GUEST_RESERVATION,$update_array,'id',$res_id);
			
			
			$_SESSION['msg']='Guest Reservation has been Deleted successfully';
			
			?>
			<script type="text/javascript">
				location.reload(true);
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
	
	
	function GuestCheckIn($reservationId)
	{
		$sql="select * from ".HMS_GUEST_RESERVATION." where id='".$reservationId."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$cnt = $this->db->num_rows($result);
		
		?>
            <div class="col-sm-8 col-md-8">
            <div class="block">
            <div class="header">
            <h4>Reservation Details</h4>
            </div>
            <div class="content" style="max-height:600px; overflow:auto;">
            <?php
			if($cnt>0)
			{
				$row = $this->db->fetch_array($result);
				?>
            <div class="block-flat profile-info" style="padding-top:5px; margin-bottom:10px;">
			<div class="row">
			<div class="col-sm-12">
			<div class="personal" style="padding-bottom:2px;">
			<h4><strong style="color:#2494F2;"> <?php echo $this->Master->FindGuestNameByGuestId($row['guest_id'])?></strong></h4>
			<?php
		    if($this->Master->FindGuestAddressByGuestId($row['guest_id'])!='')
			{
			?>
            <p class="description"><strong>Address: </strong> <?php echo $this->Master->FindGuestAddressByGuestId($row['guest_id'])?> <?php echo $this->Master->FindGuestCityByGuestId($row['guest_id'])?>, <?php echo $this->Master->FindGuestStateByGuestId($row['guest_id'])?> <br /> <?php echo $this->Master->FindGuestCountryByGuestId($row['guest_id'])?>, <?php echo $this->Master->FindGuestZipcodeByGuestId($row['guest_id'])?></p>
			<?php
			}
			else
			{
			?>
			 <strong style="color:#2494F2;">Address Information Is Not Available</strong>
			<?php
			}
			?>
			
			
            <p class="description"><strong>Contact: </strong><?php echo $this->Master->FindGuestPhoneByGuestId($row['guest_id'])?><br />
               <strong>Email: </strong><?php echo $this->Master->FindGuestEmailByGuestId($row['guest_id'])?></p>
            
           <?php
		    if($this->Master->FindGuestIdentificationTypeByReservationId($reservationId)!='')
			{
			?>
            <h4><strong style="color:#2494F2;">Identification Information</strong></h4>
            <div class="col-md-6 col-sm-5"><strong>Id Type: </strong> <?php echo $this->Master->FindGuestIdentificationTypeByReservationId($reservationId)?></div>
			<div class="col-md-6 col-sm-5"><strong>Id Number: </strong> <?php echo $this->Master->FindGuestIdentificationNumberByReservationId($reservationId)?></div>
            <div class="col-md-6 col-sm-5"><strong>Expiry Date: </strong> <?php echo $this->Master->FindGuestIdentificationExpByReservationId($reservationId)?></div>
            <div class="col-md-6 col-sm-5"><strong>Id Address: </strong> <?php echo $this->Master->FindIdentityCityByReservationId($reservationId)?>,  <?php echo $this->Master->FindIdentityStateByReservationId($reservationId)?>  <?php echo $this->Master->FindIdentityCountryByReservationId($reservationId)?></div>
			<br  />
			<?php
			}
			else
			{
			?>
			 <strong style="color:#2494F2;">Identification Information Is Not Available</strong>
			<?php
			}
			?>
          
             <h4 style="margin-top:40px;"><strong style="color:#2494F2;">Stay Information</strong></h4>
             <div class="col-md-6 col-sm-5"><strong>Arrival: </strong><?php echo $row['arrival'];?></div>
			<div class="col-md-6 col-sm-5"><strong>Departure: </strong><?php echo $row['departure'];?></div>
			<div class="col-md-6 col-sm-5"><strong>Adult/Child: </strong>  <?php echo $row['adult_count']?>/<?php echo $row['child_count']?></div>
			<div class="col-md-6 col-sm-5"><strong>Room Type: </strong> <?php echo $this->Master->RoomTypeByReservationId($row['id'])?></div>
            <?php
			if($row['check_in_status']==0)
			{
				extract($_REQUEST);
				if($checkedIn == 'Check In')
				$this->CheckInForm('server',$reservationId,$row['room_type_id']);
				else
				$this->CheckInForm('local',$reservationId,$row['room_type_id']);
			}
			elseif($row['check_in_status']==1)
			{
				//echo $row['check_in_status'];
				?>
                 
                 <div class="col-md-6 col-sm-5">
                 <h6 style="color:#060; font-weight:600; margin-top:15px;">Guest is checked In</h6>
                 <strong>Alloted Room No.: <?php echo $this->Master->GetRoomNumberById($row['room_id']);?></strong>
                 </div>
                <?php
			}
			else
			{
				?>
                 
                 <div class="col-md-6 col-sm-5">
                 <h6 style="color:#060; font-weight:600; margin-top:15px;">Guest is billed out</h6>
                
                 </div>
                <?php
				
			}
			?>
            
            
                </div>
                </div>
                </div>
                </div>
            <?php
			}
			else
			{
				?>
            <div class="block-flat profile-info" style="padding-top:5px; margin-bottom:10px;">
			<div class="row">
			<div class="col-sm-12">
			<div class="personal" style="padding-bottom:2px;">
			<h4 style="color:#990000;">Invalid Entry! Please try again</h4>
			</div>
			</div>
			</div>
			</div>
                <?php
			}
			?>
            
            <div class="clear"></div>
            </div>
            </div>
            </div>	
		 <?php
	}
	
	
	
	
	function CheckInForm($caseFinder,$res_id,$room_type_id)
	{ 
			
		switch($caseFinder)
		{
			case 'local':
			$FormName = "frm_check_in";
			/*			$ControlNames=array("room_no"        =>array('room_no',"","Required field.","span_room_no"),
						"address"        =>array('address',"","Required field.","span_address"),
						"country_id"        =>array('country_id',"","Required field.","span_country_id"),
						"state_id"        =>array('state_id',"","Required field.","span_state_id"),
						"city_id"        =>array('city_id',"","Required field.","span_city_id"),
						"zipcode"        =>array('zipcode',"","Required field.","span_zipcode"),
						"identification_id"        =>array('identification_id',"","Required field.","span_identification_id"),
						"identification_number"        =>array('identification_number',"","Required field.","span_identification_number"),
						"identity_exp_date"        =>array('identity_exp_date',"","Required field.","span_identity_exp_date"),
						"filess"        =>array('filess',"","Required field.","span_filess")
						
					);
                            $ValidationFunctionName="CheckroomValidity";
					
						$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
						echo $JsCodeForFormValidation;*/
?>
			<div class="col-md-12 col-sm-5" style="margin-top:20px;">
                <form action="" method="post"  name="<?php echo $FormName;?>" enctype="multipart/form-data">
					<?php
					// Now fetch the rooms that is avaliable of selected room type 
                    $sql_room="select * from ".HMS_ROOM." where room_type_id='".$room_type_id."' and assigned='0' and deleted='0'";
                    $result_room = $this->db->query($sql_room,__FILE__,__LINE__);
                    $cnt_availbilty = $this->db->num_rows($result_room);
                    if($cnt_availbilty>0)
                    {
                    ?>
						<h4 style="font-weight:600; border-bottom:2px solid #2494F2;">Personal Information</h4>
						<div class="form-group">
						<div class="col-sm-12" style="padding-right: 6px;padding-left: 1px;">
						<label>Address</label> 
						<textarea class="form-control" name="address" value="<?php echo $_REQUEST['address']?>"  placeholder="Type something"  required></textarea>
						
						</div>
						</div>
						
						
						<div class="form-group">
						<div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
						<label>Country</label>
						<select class="form-control" name="country_id" required onChange="reservation_obj.ChangeState(this.value,{target:'refstatelisting',preloader:'pr3'})">
						<option value="">-- Select Country --</option>
						<?php
						$sql="select * from ".HMS_COUNTRY;
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
						<div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
						
						<label>State</label>   <img id="pr3" src="img/status.gif" style="visibility:hidden; height:25px;"> 
						<div id="refstatelisting">
						<select class="form-control" name="state_id" required>
						<option value="">-- Select State --</option>
						</select>
						</div>
						</div>
						
						</div>
						
							<div style="clear:both;"></div>	
			 
						<div class="form-group">
						<div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
						<label>City</label> <img id="pr4" src="img/status.gif" style="visibility:hidden; height:25px;"> 
						<div id="refcitylisting">
						<select class="form-control" name="city_id" required>
						<option value="">-- Select City --</option>
						</select>
						</div>
						</div>
						
						<div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
<label>Zip Code</label> <span style="color:#F00; font-weight:600;" id="span_zipcode"></span>
<input  type="text" name="zipcode" value="<?php echo $_REQUEST['zipcode']?>" class="form-control"   placeholder="Type something" required />
</div>

</div>

	<div style="clear:both;"></div>	

<div class="form-group">
<div class="col-sm-12" style="padding-right: 6px;padding-left: 1px;">
						<label>Check-In Room</label> 
						<select name="room_no" class="form-control" required>
						<option value="">- Select Room -</option>
						<?php
						while($row_room = $this->db->fetch_array($result_room))
						{
						?>
						<option value="<?php echo $row_room['id']?>"><?php echo $row_room['room_no']?></option>
						<?php
						}
						?>
						</select>
</div>
</div>
				
				
				
				<div style="clear:both;"></div>		
				
					<h4 style="font-weight:600; border-bottom:2px solid #2494F2;">Identity Information</h4>
                    
					
					  <div class="form-group">
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>ID Type</label>  
				 	<select class="form-control" name="identification_id" required>
				<option value="">-- Select ID Type --</option>
				<?php
				$sql="select * from ".HMS_IDENTY." where deleted='0'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				while($row = $this->db->fetch_array($result))
				{
				?>
				<option value="<?php echo $row['id'];?>" <?php if($row['id']==$user_id_type) { echo 'selected="selected"';}?> ><?php echo $row['name'];?></option>
				<?php
				}
				?>
				</select>
	         </div>
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>ID Number</label> 
			  <input data-parsley-type="alphanum"  name="identification_number" value="<?php echo $_REQUEST['identification_number']?>" type="text" class="form-control"  placeholder="Type something" required/>
			  </div>
			  
			  <div class="col-sm-4" style="padding-right: 6px;padding-left: 1px;">
              <label>Country</label> 
				<select class="form-control" name="identify_country_id" required onChange="reservation_obj.ChangeIdentificationState(this.value,{target:'refidentystatelisting',preloader:'pr'})">
				<option value="">-- Select Country --</option>
				<?php
				$sql="select * from ".HMS_COUNTRY;
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
			  
			  <div class="form-group" style="padding-bottom:25px;">
			  
			  <div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
              <label>State</label> <img id="pr" src="img/status.gif" style="visibility:hidden; height:25px;">  
			 	 <div id="refidentystatelisting">
				 <select class="form-control" name="identify_state_id" required>
				<option value="">-- Select State --</option>
				</select>
				</div>
			  </div>
			  <div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
              <label>City</label> <img id="pr2" src="img/status.gif" style="visibility:hidden; height:25px;"> 
			  <div id="refIdentifycitylisting">
			  <select class="form-control" name="identify_city_id" required>
				<option value="">-- Select City --</option>
				
				</select>
				</div>
			  </div>
			  </div>
              
			   <div class="form-group">
              
			   <div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
			 <label>Expiry Date</label> 
			 <div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
                    <input class="form-control" size="16" name="identity_exp_date" value="<?php echo $_REQUEST['identity_exp_date']?>" type="text"  readonly required>
                    <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
                  </div>
			  </div>
			  
			  
              <div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
              <label>Upload Id:</label>
			  <input type="file" name="filess" value="" required/>
			  </div>
			  
		</div>
		
		
		   <div class="form-group" style="padding-bottom:25px;">
		  <div class="col-sm-12" style="padding-right: 6px;padding-left: 1px;">
                    <input type="submit" name="checkedIn" style="margin-top:22px;" class="btn btn-primary" value="Check In"/>
			    </div>
				</div>
				
				
					 </form>
                    <?php
                    }
                    else
                    {
                        ?>
                        <h6 style="color:#900; font-weight:600;">Sorry! No Room Available of Selected Room Type</h6>
                        <?php
                    }
                    ?>
                 
      		  </div>
			  
            <?php
			break;
			case 'server':
			extract($_POST);
			
			
			 $tmx=time();
			 				
							//$path=$_FILES["filess"]["name"];
							//move_uploaded_file($_FILES["filess"][tmp_name],"proof/".$path); 
							if ($_FILES["filess"]["error"] > 0)
							{
							//echo "Error: " . $_FILES["filess"]["error"] . "<br />";
							echo 'Invalid file';
							}
							else
							{
							  "Upload: " . $_FILES["file"]["name"] . "<br />";
							 "Type: " . $_FILES["file"]["type"] . "<br />";
							 "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
							 "Stored in: " . $_FILES["file"]["tmp_name"];
							 $tmpname=$_FILES["filess"]["name"];
							
							$name= explode('.',$tmpname);
							$tmp=$_FILES["filess"]["type"];
							$type= explode('/',$tmp);
							if($type[1]=='jpeg'||$type[1]=='JPEG'||$type[1]=='jpg'||$type[1]=='JPG'||$type[1]=='png'||$type[1]=='PNG'||$type[1]=='gif'||$type[1]=='GIF')
								{						
								
						    $path= 'userimage'.$tmx.".".$type[1];
							move_uploaded_file($_FILES["filess"][tmp_name],"proof/".$path);
							}
								else
								{
									echo 'Invalid file';
								}
							}
							
			
			
			 
			 $this->address = $address;
			 $this->country_id = $country_id;
			 $this->state_id = $state_id;
			 $this->city_id = $city_id;
			 $this->zipcode = $zipcode;
			 
			  $this->room_no = $room_no;
			 
			 
			
			 $this->identification_id = $identification_id;
			 $this->identification_number = $identification_number;
			 $this->identity_exp_date = $identity_exp_date;
			 $this->identify_country_id = $identify_country_id;
			 $this->identify_state_id = $identify_state_id;
			 $this->identify_city_id = $identify_city_id;
			 $this->image_path = $path;
			
		
			 
			 
			 
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
							$return =true;
						if($this->Form->ValidField($address,'empty','kindly enter address please..')==false)
							$return =false;
						if($this->Form->ValidField($country_id,'empty','kindly select country please..')==false)
							$return =false;
						if($this->Form->ValidField($state_id,'empty','kindly select state please..')==false)
							$return =false;
						if($this->Form->ValidField($city_id,'empty','kindly select city please..')==false)
							$return =false;
						if($this->Form->ValidField($zipcode,'empty','Please Select City')==false)
							$return =false;
						if($this->Form->ValidField($room_no,'empty','Please Enter phone no')==false)
							$return =false;
							
						if($this->Form->ValidField($identification_id,'empty','Please Select Country')==false)
							$return =false;
						if($this->Form->ValidField($identification_number,'empty','Please Select State')==false)
							$return =false;
						if($this->Form->ValidField($identity_exp_date,'empty','Please Select City')==false)
							$return =false;
						
							/* End Validation  */
							
						if($return){
						
							$insert_sql_array = array();
							$insert_sql_array['guest_id'] = $this->Master->GetGuestIDByReseravtionId($res_id);
							$insert_sql_array['reservation_id'] = $res_id;
							$insert_sql_array['identification_id'] = $this->identification_id;
							$insert_sql_array['identification_number'] = $this->identification_number;
							$insert_sql_array['identity_exp_date'] = $this->identity_exp_date;
							$insert_sql_array['identify_country_id'] = $this->identify_country_id;
							$insert_sql_array['identify_state_id'] = $this->identify_state_id;
							$insert_sql_array['identify_city_id'] = $this->identify_city_id;
							$insert_sql_array['image_path'] = $this->image_path;
							
							//print_r($insert_sql_array);
							
						    $this->db->insert(HMS_GUEST_IDENTIFICATION,$insert_sql_array);
							
							
							$update_sql_array = array();
							$update_sql_array['address'] = $this->address;
							$update_sql_array['country_id'] = $this->country_id;
							$update_sql_array['state_id'] = $this->state_id;
							$update_sql_array['city_id'] = $this->city_id;
							$update_sql_array['zipcode'] = $this->zipcode;
							
							//print_r($update_sql_array);
							$this->db->update(HMS_GUEST,$update_sql_array,'id',$this->Master->GetGuestIDByReseravtionId($res_id));
							
							$update_sql_array2 = array();
							$update_sql_array2['assigned'] = 1;
							$update_sql_array2['guest_flag'] = 1;
							
							//print_r($update_sql_array2);
							$this->db->update(HMS_ROOM,$update_sql_array2,'id',$this->room_no);
							
							$update_sql_array3 = array();
							$update_sql_array3['room_id'] = $this->room_no;
							$update_sql_array3['check_in_status'] = 1;
							
							//print_r($update_sql_array3);
							$this->db->update(HMS_GUEST_RESERVATION,$update_sql_array3,'id',$res_id);
						
							$_SESSION['msg'] = 'Guest is Successfully checked In in Room No. '.$this->Master->GetRoomNumberById($this->room_no);
							?>
							<script type="text/javascript">
								window.location = "reservation_lising.php"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->CheckInForm('local',$res_id,$room_type_id);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	
	
	     function guestCheck_in_update($room_no_id,$reservation_Id)
			{
				
			ob_start();
			
			
			if($room_no_id!='' and $reservation_Id!='')
			{
			$update_sql_array = array();
			$update_sql_array['assigned'] = 1;
			
			$this->db->update(HMS_ROOM,$update_sql_array,'id',$room_no_id);
			
			$update_sql_array2 = array();
			$update_sql_array2['room_id'] = $room_no_id;
			$update_sql_array2['check_in_status'] = 1;
			$this->db->update(HMS_GUEST_RESERVATION,$update_sql_array2,'id',$reservation_Id);
							
			$_SESSION['msg'] = 'Guest is Successfully checked In in Room No. '.$this->Master->GetRoomNumberById($room_no_id);
			
			?>
            <script>
			window.location='reservation_lising.php?index=checkIn&res_id=<?php echo $reservation_Id;?>'
			</script>
            <?php
							
			}
			else
			{
			$_SESSION['error_msg'] = 'Something went wroung !';
			?>
            <script>
			window.location='reservation_lising.php?index=checkIn&res_id=<?php echo $reservation_Id;?>'
			</script>
            <?php
			}
			
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}
			
		function GuestcheckOut($runat, $reservationid)
		{
            
    	switch($runat)
		{
		
			case 'local':
			$FormName = "form_checkOut";
							$ControlNames=array("name"			=>array('name',"''","Kindly enter name","span_name"),
												"contact"			=>array('contact',"Mobile","Kindly enter contact","span_contact"),
												"username"			=>array('username',"''","Kindly enter user name","span_username"),
												"email"			=>array('email',"EMail","Kindly enter Email","span_email"),
												"password"			=>array('password',"''","Kindly enter contact password","span_password"),
												"user_type"			=>array('user_type',"''","Kindly enter user type","span_user_type")
												);
	
							$ValidationFunctionName="CheckCheckoutValidity";
						
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
				$sql="select * from ".HMS_RESERVATION_PAYMENTS." where reservation_id ='".$reservationid."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
			
			?>
            <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="<?php echo $FormName ?>">
      
	<div class="col-md-12">
					<div class="block-flat">
						<div class="header">							
							<h4>Billing Details</h4>
						</div>
						<div class="content">
							<div class="table-responsive">
							<table class="table no-border hover">
								<thead class="no-border">
									<tr>
										
										<th style="width:14%;"><strong>Date</strong></th>
										<th style="width:28%;" class="text-left"><strong>Description</strong></th>
										<th  style="width:28%;" class="text-center"><strong>Referance</strong></th>
										<th style="width:15%;" class="text-center"><strong>Debit INR</strong></th>
										<th style="width:15%;" class="text-center"><strong>Credit INR</strong></th>
									</tr>
								</thead>
								<tbody class="no-border-y">
									<tr>
										<td><?php echo date('d-m-Y', strtotime($row['payment_date']));?>
										</td>
										<td class="text-left">Rooms (<?php echo $this->Master->TotalBookedRoomsByReservationId($reservationid);?> <?php echo $this->Master->RoomTypeByReservationId($reservationid);?>)</td>
										<td class="text-center">[ NA Room ]</td>
										<td class="text-center"><?php echo $row['base_price'];?></td>
										<td class="text-center"></td>
									</tr>
									<?php
								   if($this->Master->ExtraBedAllowed($reservationid)!=0)
								   {
								    ?>
                                   <tr>
										<td class="text-left"><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left">Bed Booked (<?php echo $this->Master->ExtraBedAllowed($reservationid);?>)</td>
										<td class="text-center">[ NA Room ]</td>
				<td class="text-center"><?php echo $this->Master->ExtraBedPriceOnReservation($reservationid);?></td>
										<td class="text-center"></td>
									</tr>
                                    <?php
								   }
								   ?>
								  <?php
								   if($row['tax1']!=0)
								   {
								    ?>
                                   <tr>
										<td class="text-left"><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left"><?php echo $this->Master->GetTaxType(1)?> </td>
										<td class="text-center"><?php echo $this->Master->GetTaxValue(1)?>% [Added On Room]</td>
										<td class="text-center"><?php echo $row['tax1'];?></td>
										<td class="text-center"></td>
									</tr>
                                    <?php
								   }
								   ?>
                                   <?php
								   if($row['tax2']!=0)
								   {
								    ?>
                                   <tr>
										<td class="text-left"><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left">Service Tax [Add On Room]</td>
										<td class="text-center"><?php echo $this->Master->GetTaxValue(2)?>% [Added On Room]</td>
										<td class="text-center"><?php echo $row['tax2'];?></td>
										<td class="text-center"></td>
									</tr>
                                    <?php
								   }
								   ?>
                                   <?php
								   if($row['service_charge']!=0)
								   {
								    ?>
                                   <tr>
										<td class="text-left"><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left">Service Charge</td>
										<td class="text-center"><?php echo $this->Master->GetTaxValue(4)?>%</td>
										<td class="text-center"><?php echo round($row['service_charge']);?></td>
										<td class="text-center"></td>
									</tr>
                                    <?php
								   }
								   ?>
                                    <?php
								   if($row['advance_amount']!=0)
								   {
								    ?>
                                   <tr>
										<td class="text-left"><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left">Advance payment (<?php echo $row['payment_mode'];?>)</td>
										<td class="text-center">[N/A]</td>
										<td class="text-center"></td>
										<td class="text-center"><?php echo $row['advance_amount'];?></td>
									</tr>
                                    <?php
								   }
								   ?>
                                    <?php
								   if($row['discount']!=0)
								   {
								    ?>
                                   <tr>
										<td class="text-left"><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left">Discount Amount</td>
										<td class="text-center">[N/A]</td>
										<td class="text-center"></td>
										<td class="text-center"><?php echo $row['discount'];?></td>
									</tr>
                                    <?php
								   }
								   ?>
						
								<tr>
									<td></td>
								    <td></td>
									<td class="text-center"><strong>Remaining Balance:-</strong></td>
									 <td class="text-center" colspan="2">
									 <input type="text"  class="form-control" name="rem_amt" readonly="readonly" id="rem_amt" data-parsley-type="number" style="width:120px;" required placeholder="0.00" value="<?php echo $row['remain_amount'];?>" /> 
									 </td>
								</tr>
                                <tr>
									<td></td>
								    <td></td>
									<td class="text-center"><strong>F & B Amount(Included Tax):-</strong></td>
									 <td class="text-center" colspan="2">
									 <input type="text"  class="form-control" name="fb_amount" id="fb_amount" data-parsley-type="number" style="width:120px;" required placeholder="0.00" value="<?php echo $this->calulateFBamountWithTaxes($reservationid);?>" readonly="readonly" /> 
									 </td>
								</tr>
                                
                                
                                  <tr>
									<td></td>
								    <td> <?php
				
				$sql_tax="select * from ".HMS_TAXS." where  id='4'";
				$result_tax = $this->db->query($sql_tax,__FILE__,__LINE__);
				$row_tax = $this->db->fetch_array($result_tax);
				
				$applicable_amt = $row['base_price']+$row['extra_bed']-$row['discount'];
				 $plan_fb_charges = $this->getOnlyChargesFB($reservationid);
				
				?></td>
									<td class="text-center"><strong><?php echo $row_tax['tax_name'];?> 
                                        [<?php echo $row_tax['percent_value'].'%';?> ] :-</strong> <input type="checkbox"  value="<?php echo $row_tax['percent_value'];?>" id="service_charge" name="service_charge" onchange="javascript:get_serviceTax('<?php echo $applicable_amt;?>','<?php echo $plan_fb_charges;?>')" /> </td>
									 <td class="text-center" colspan="2">
                                <input type="text" name="service_chg"  class="form-control" style="width:120px;" readonly="readonly" id="srg" value="0"/>
                                         
                                     </td>
								</tr>
                                
                                
                            <tr>
									<td></td>
								    <td></td>
									<td class="text-center"><strong>Payable Amount(Round off):-</strong></td>
									 <td class="text-center" colspan="2">
                                    <input type="text" value="<?php echo round($row['remain_amount']+$this->calulateFBamountWithTaxes($reservationid));?>" class="form-control" id="due_amount" name="due_amount" readonly="readonly" style="width:120px;" placeholder="0.00"> 
                                     </td>
								</tr>
                                
                                
                                
								<tr>
									<td><strong>Payment Method:-</strong></td>
								    <td><select class="form-control" style="width:195px;" name="payment_mode" required>
					<option value="">-- Choose Payment Type --</option>
                    <option value="Check">Check</option>
                    <option value="Cash">Cash</option>
                    <option value="Credit/Debit Card">Credit/Debit Card</option>
                    </select></td>
									<td class="text-center"><strong>Paid Amount:-</strong></td>
									 <td class="text-center" colspan="2">
									 <input type="text" 
                                     onchange="reservation_obj.calculatebilling(this.form.due_amount.value,this.value,{})" placeholder="0.00" onkeyup="reservation_obj.calculatebilling(this.form.due_amount.value,this.value,{})" onclick="reservation_obj.calculatebilling(this.form.due_amount.value,this.value,{})"  name="paid_amount" value="" data-parsley-type="number" class="form-control" style="width:120px;"  required/
                                      ></td>
								</tr>
                                <script>
								   function get_serviceTax(total,fb_amt)
									{
									var toatlamt=0;
									var stotal=0;
									var sercharge=0;
									var serCharge=0 ;
									
									toatlamt = parseFloat(total) + parseFloat(fb_amt);
									
									sercharge = document.getElementById('service_charge');
									
									if(service_charge.checked == true)
									{
									serCharge = Number(sercharge.value) * toatlamt/100; 
									//alert(serCharge);
									var dueAmount = document.getElementById('due_amount').value;
									var finalAmount = parseFloat(dueAmount)+parseFloat(serCharge);
									document.getElementById('due_amount').value = Math.round(finalAmount);
									document.getElementById('srg').value = parseFloat(serCharge);
									}
									else
									{
									serCharge = Number(sercharge.value) * toatlamt/100; 
									var dueAmount = document.getElementById('due_amount').value;
									var finalAmount = parseFloat(dueAmount)-parseFloat(serCharge);
									document.getElementById('due_amount').value = finalAmount;
									document.getElementById('srg').value = 0;
									}
									
									}
								   </script>
								<tr>
									<td>
               
              					 </td>
								    <td></td>
									<td class="text-center"><strong>Balance Amount:-</strong></td>
									 <td class="text-center" colspan="2">
									 <input type="text" value="" placeholder="0.00"  id="amount_remain" name="remain_amount" data-parsley-type="number" class="form-control" readonly="readonly" style="width:120px;"/></td>
								</tr>	
								</tbody>
							</table>		
							</div>
							<div class="form-group" style=" margin-top: 45px;padding-bottom: 26px;">
                <div class="col-sm-offset-2 col-sm-10">
				<div  style="float:right;">
                 <button class="btn btn-default">Cancel</button>
				  <button type="submit"  class="btn btn-primary" name="submitPayment" value="Generate Bill">Generate Bill</button>
				  </div>
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
			
				$this->service_charge = $service_charge;
				
				
				//$this->fandb_price = $this->calulateFBamountWithTaxes($reservationid);
				$this->fandb_price = $fb_amount;
				$this->fb_price_plain = $this->getOnlyChargesFB($reservationid);
				$this->vat_fb = $this->calculateVatOnAmount($this->getOnlyChargesFB($reservationid));
				$this->sat_fb = $this->calculateSatOnAmount($this->getOnlyChargesFB($reservationid));
				
				$this->service_chg = $service_chg;
				$this->payment_mode = $payment_mode;
				$this->paid_amount = $paid_amount;
				
			   /*Start Server Side Validation from here it works when javascript validation is failed*/
    		$return =true;
						if($this->Form->ValidField($paid_amount,'empty','Please Enter Paid Amount')==false)
							$return =false;
						
					
		    /* End Validation  */
			
			$sql="select * from ".HMS_RESERVATION_PAYMENTS." where reservation_id ='".$reservationid."'";
			$result = $this->db->query($sql,__FILE__,__LINE__);
			$row = $this->db->fetch_array($result);
			if($this->service_charge>0 and isset($this->service_charge)){
				$oldTotal = $row['total_amount'];
				$oldPaid = $row['total_paid_amount'];
				$newTotal = $oldTotal+$this->fandb_price+round($this->service_chg);
				$newTotalPaidAmount = $oldPaid+$this->paid_amount;
				$OutstandingAmount = $newTotal-$newTotalPaidAmount;
			}else{
				$oldTotal = $row['total_amount'];
				$oldPaid = $row['total_paid_amount'];
				$newTotal = $oldTotal+$this->fandb_price;
				$newTotalPaidAmount = $oldPaid+$this->paid_amount;
				$OutstandingAmount = $newTotal-$newTotalPaidAmount;
			}
            
			/*echo round($OutstandingAmount);
			exit();*/
			
				/*if($OutstandingAmount>=0){
					*/
					if($return){
							$update_sql_array = array();
							$update_sql_array['fandb_price'] = $this->fandb_price;
							$update_sql_array['fb_price_plain'] = $this->getOnlyChargesFB($reservationid);
							$update_sql_array['vat_fb'] = $this->vat_fb;
							$update_sql_array['sat_fb'] = $this->sat_fb;
							$update_sql_array['service_charge'] = $this->service_chg;
							$update_sql_array['total_amount'] = $newTotal;
							$update_sql_array['total_paid_amount'] = $newTotalPaidAmount;
							$update_sql_array['remain_amount'] = $OutstandingAmount;
							$update_sql_array['final_amount'] = $this->paid_amount;
							$update_sql_array['fullpayment_date'] = date('Y-m-d h:i:s A');
							$update_sql_array['fullpayment_mode'] = $this->payment_mode;
							$this->db->update(HMS_RESERVATION_PAYMENTS,$update_sql_array,'reservation_id',$reservationid);
							$get_room_id = $this->Master->RoomIDByReservationId($reservationid);
							$update_sql_array2 = array();
							$update_sql_array2['assigned'] = 0;
							$update_sql_array2['guest_flag'] = 0;
							$this->db->update(HMS_ROOM,$update_sql_array2,'id',$get_room_id);
							$update_sql_array3 = array();
							$update_sql_array3['check_in_status'] = 2;
							$this->db->update(HMS_GUEST_RESERVATION,$update_sql_array3,'id',$reservationid);
							$_SESSION['msg'] = 'Billing details has been successfully saved.';
							
							$update_sql_array4 = array();
							
							$sql_kt="select id,guest_id,reservation_id,paid_status from ".HMS_KOT." where reservation_id ='".$reservationid."' and paid_status='unpaid'";
							$result_kt = $this->db->query($sql_kt,__FILE__,__LINE__);
							while($row_kt = $this->db->fetch_array($result_kt)){
							$update_sql_array4['paid_status'] = 'paid';
							$this->db->update(HMS_KOT,$update_sql_array4,'reservation_id',$reservationid);
							}
							
							
							?>
							<script type="text/javascript">
							window.location='invoice.php?index=billinfo&paymentId=<?php echo $row['id'];?>';
							</script>
							<?php
							exit();} 
							else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->GuestcheckOut('local',$reservationid);
							}/*}else{
								$_SESSION['error_msg'] = 'Invalid Amount!! Kindly enter correct amount';
									?>
									<script type="text/javascript">
									window.location='reservation_lising.php?index=checkOut&res_id=<?php echo $reservationid;?>';
									</script>
									<?php
									exit();	
					}*/
			
			  break;
			   default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
	    	}
		}
	
	
	
	
	function calulateFBamountWithTaxes($reservation_id)
	{
			$kot_amount = 0;
		    $sql="select * from ".HMS_KOT." where reservation_id='".$reservation_id."' and paid_status='unpaid'";
		    $result = $this->db->query($sql,__FILE__,__LINE__);
			while($row = $this->db->fetch_array($result))
			{
				$kot_amount = $kot_amount+$row['kot_amount'];
			}
			    $totalVat = $this->calculateVatOnAmount($kot_amount);
				$totalSat = $this->calculateSatOnAmount($kot_amount);
				$totalfbBill = $kot_amount+$totalVat+$totalSat;
			return $totalfbBill;
	}
	
	function getOnlyChargesFB($reservation_id)
	{
		   $kot_amount = 0;
		    $sql="select * from ".HMS_KOT." where reservation_id='".$reservation_id."' and paid_status='unpaid'";
		    $result = $this->db->query($sql,__FILE__,__LINE__);
			while($row = $this->db->fetch_array($result))
			{
				$kot_amount = $kot_amount+$row['kot_amount'];
			}
			return $kot_amount;
	}
	
	
	function calculateVatOnAmount($amount)
	{
		        $sql="select id,percent_value from ".HMS_TAXS." where id = 3";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				$vatamount = $amount*$row['percent_value']/100;
				return $vatamount;
	}
	
	function calculateSatOnAmount($amount)
	{
		        $sql="select id,percent_value from ".HMS_TAXS." where id = 10";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				$satamount = $amount*$row['percent_value']/100;
				return $satamount;
	}
	
	
	
	function calculatebilling($total_amount,$paid_amount)
	{
		ob_start();
		
		$amount_left=0;
		
		$amount_left = $total_amount-$paid_amount;
		?>
		<script>
		
		document.getElementById('amount_remain').value=<?php echo  $amount_left; ?>;
		</script>
		
		<?php 
		
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function calculatetotalwithFB($total_amount, $fb_amount)
	{
		ob_start();
		echo $total_amount;
		
		
		$amount_pay=0;
		
		 $amount_pay = $total_amount+$fb_amount;
		 ?>
		 <input type="text" value="<?php echo $amount_pay;?>" class="form-control" name="total_amount" readonly="readonly" style="width:120px;" placeholder="0.00"> 
        <?php
		
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}		
	
	
	function BillingDetails($payId,$reservationId='')
	{
		if($reservationId!='')
		{
				 $sql="select * from ".HMS_RESERVATION_PAYMENTS." where reservation_id ='".$reservationId."'";
		}
		else
		{
			$sql="select * from ".HMS_RESERVATION_PAYMENTS." where id ='".$payId."'";
		}
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		?>
       
		<div class="col-md-12">
       <div class="block-flat" style="height:1250px;">
       <a class="fancybox fancybox.iframe btn btn-primary btn-lg" href="main_invoice.php?paymentId=<?php echo $row['id'];?>">Generate Invoice</a>
          <div class="header" style="border:none;">							
            <h3><img src="img/invoice_header.jpg" style="width:950px; height:150px;" /></h3>
          </div>
          <div class="content">
		  <div class="col-md-12">
						<h4><strong> <?php echo $this->Master->FindGuestNameByGuestId($row['guest_id'])?></strong></h4>
							<p style="margin-bottom:1px;"><strong><?php echo $this->Master->FindGuestAddressByGuestId($row['guest_id'])?></strong></p>
							<p style="margin-bottom:1px;"><strong><?php echo $this->Master->FindGuestCityByGuestId($row['guest_id'])?> <?php echo $this->Master->FindGuestStateByGuestId($row['guest_id'])?></strong></p>
							<p style="margin-bottom:1px;"><strong><?php echo $this->Master->FindGuestCountryByGuestId($row['guest_id'])?>, <?php echo $this->Master->FindGuestZipcodeByGuestId($row['guest_id'])?></strong></p>
		</div>
			<div class="col-md-12" style="margin-top:25px;">
						<div style="width:49%;  float:left;">
						<p><strong>Arrival    :  </strong>  <?php echo $this->Master->ArrivalDateByReservationId($row['reservation_id'])?></p>
						<p><strong>Departure  :  </strong>  <?php echo $this->Master->DeparturelDateByReservationId($row['reservation_id'])?></p>
						<p><strong>Room Type  :  </strong>  <?php echo $this->Master->RoomTypeByReservationId($row['reservation_id'])?></p>
						   <?php
                               if($this->Master->getreservationOccpany($row['reservation_id'])==1)
							   {
								   ?>
                           <p><strong>Rate:  </strong> <?php echo $this->Master->GetRoomPriceByReservationIdforSingleOccupany($row['reservation_id'])?></p>
                                   <?php
							   }
							   else
							   {
								?>
                           <p><strong>Rate:  </strong> <?php echo $this->Master->GetRoomPriceByReservationIdforDoubleOccupany($row['reservation_id'])?></p>
                                   <?php  
							   }
                               ?>
						<p><?php echo date('l jS \of F Y h:i:s A', strtotime($row['fullpayment_date']));?></p>
						</div>
						<div style="width:49%; float:right;">
						
						                <?php
										$x=1001;
                                        $sql_1 = "select * from ".HMS_RESERVATION_PAYMENTS	;
										$result_1= $this->db->query($sql_1,__FILE__,__LINE__);
										while($row_1= $this->db->fetch_array($result_1))
										$x++;
										?>
						<p><strong>Invoice No.:  </strong> <?php echo $x;?></p>
						<p><strong>Adults/Children    :  </strong>   <?php echo $this->Master->TotalAdultReservationId($row['reservation_id'])?>/<?php echo $this->Master->TotalChildReservationId($row['reservation_id'])?></p>
						
						<p><strong>No. Of Days  :  </strong>  <?php echo $this->Master->TotalNightsByReservationId($row['reservation_id'])?></p>
						<p><strong>Cashier  :  </strong>  </p>
						</div>
						</div>
		
		 
		
		  <div class="col-md-12">
		  <div class="table-responsive">
							<table class="table no-border hover">
								<thead class="no-border">
									<tr style="border-top:1px solid #999999; background:#EBEBEB;">
										<th style="width:14%;"><strong>Date</strong></th>
										<th style="width:28%;" class="text-left"><strong>Description</strong></th>
										<th  style="width:28%;" class="text-center"><strong>Referance</strong></th>
										<th style="width:15%;" class="text-center"><strong>Debit INR</strong></th>
										<th style="width:15%;" class="text-center"><strong>Credit INR</strong></th>
									</tr>
								</thead>
								<tbody class="no-border-y">
									<tr>
										<td><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left">Rooms (<?php echo $this->Master->TotalBookedRoomsByReservationId($row['reservation_id']);?> <?php echo $this->Master->RoomTypeByReservationId($row['reservation_id']);?>)</td>
										<td class="text-center">[ NA Room ]</td>
										<td class="text-center"><?php echo number_format($row['base_price'],2);?></td>
										<td class="text-center"></td>
									</tr>
									
				            <?php
								   if($this->Master->ExtraBedAllowed($row['reservation_id'])!=0)
								   {
								    ?>
                                   <tr>
										<td class="text-left"><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left">Bed Booked (<?php echo $this->Master->ExtraBedAllowed($row['reservation_id']);?>)</td>
										<td class="text-center">[ NA Room ]</td>
				<td class="text-center"><?php echo number_format($row['extra_bed'],2);?></td>
										<td class="text-center"></td>
									</tr>
                                    <?php
								   }
								   ?>      
								
							<?php
							if($row['tax1']!=0)
							{
								?>
								<tr>
										<td><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left">Luxury Tax</td>
										<td class="text-center"><?php echo $this->Master->GetTaxValue(1)?>% [Add On Room]</td>
										<td class="text-center"><?php echo number_format($row['tax1'],2);?></td>
										<td class="text-center"></td>
								</tr>
                              <?php
							}
							?>
                            <?php
							if($row['tax2']!=0)
							{
								?>
								<tr>
										<td><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
										<td class="text-left">Service Tax</td>
										<td class="text-center"><?php echo $this->Master->GetTaxValue(2)?>% [Add On Room]</td>
										<td class="text-center"><?php echo number_format($row['tax2'],2);?></td>
										<td class="text-center"></td>
								</tr>
                              <?php
							}
							if($row['advance_amount']>0)
							{
							?>
                               <tr>
									<td><?php echo date('d-m-Y', strtotime($row['payment_date']));?></td>
								    <td>Advance Amount (<?php echo $row['payment_mode'] ?>)</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									 <td class="text-center"><?php echo number_format($row['advance_amount'],2)?></td>
							   </tr>
                            <?php
							}
							?>
                            <?php
							if($row['fb_price_plain']>0)
							{
								?>
								<tr>
										<td><?php echo date('d-m-Y', strtotime($row['fullpayment_date']));?></td>
										<td class="text-left">Food and Beverage</td>
										<td class="text-center">--</td>
										<td class="text-center"><?php echo number_format($row['fb_price_plain'],2);;?></td>
										<td class="text-center"></td>
								</tr>
                              <?php
							}
							?>
                             <?php
							if($row['vat_fb']>0)
							{
								?>
								<tr>
										<td><?php echo date('d-m-Y', strtotime($row['fullpayment_date']));?></td>
										<td class="text-left">VAT</td>
										<td class="text-center"><?php echo $this->kt->GetVat();?> % On F & B</td>
										<td class="text-center"><?php echo number_format($row['vat_fb'],2);?></td>
										<td class="text-center"></td>
								</tr>
                              <?php
							}
							?>
                            <?php
							if($row['sat_fb']>0)
							{
								?>
								<tr>
										<td><?php echo date('d-m-Y', strtotime($row['fullpayment_date']));?></td>
										<td class="text-left">SAT</td>
										<td class="text-center"><?php echo $this->kt->GetSat();?> % On F & B</td>
										<td class="text-center"><?php echo number_format($row['sat_fb'],2);?></td>
										<td class="text-center"></td>
								</tr>
                              <?php
							}
							?>
                             <?php
							if($row['service_charge']!=0)
							{
								?>
								<tr>
										<td><?php echo date('d-m-Y', strtotime($row['fullpayment_date']));?></td>
										<td class="text-left">Service Charge</td>
										<td class="text-center"><?php echo $this->Master->GetTaxValue(4)?>% On Bill</td>
										<td class="text-center"><?php echo number_format($row['service_charge'],2);?></td>
										<td class="text-center"></td>
								</tr>
                              <?php
							}
							?>
								
                               <tr>
									<td><?php echo date('d-m-Y', strtotime($row['fullpayment_date']));?></td> 
								    <td>Final Payment (<?php echo $row['fullpayment_mode'];?>)</td>
									<td class="text-center"></td>
									<td class="text-center"></td>
									 <td class="text-center"><?php echo number_format($row['final_amount'],2);?></td>
							   </tr>
							   
							</tbody>
							</table>		
							</div>
							<hr style="background:#000000; height:2px;"/>
							<div class="table-responsive">
							<table class="table no-border hover">
								<thead class="no-border">
                                	<tr>
										<th style="width:14%;"></th>
										<th style="width:28%;" class="text-left"></th>
										<th  style="width:28%;" class="text-center"><strong>Total</strong></th>
										<th style="width:15%;" class="text-center"><strong><?php echo number_format($this->total_amt_to_be_paid($row['base_price'],$row['extra_bed'],$row['tax1'],$row['tax2'],$row['fb_price_plain'],$row['vat_fb'],$row['sat_fb'],$row['service_charge']),2);?> INR</strong></th>
										<th style="width:15%;" class="text-center"></strong></th>
									</tr>
                                    
									<tr>
										<th style="width:14%;"></th>
										<th style="width:28%;" class="text-left"></th>
										<th  style="width:28%;" class="text-center"><strong>Round Off</strong></th>
										<th style="width:15%;" class="text-center"><strong><?php echo number_format(round($row['total_amount']+$row['discount']),2);;?> INR</strong></th>
										<th style="width:15%;" class="text-center"><strong><?php echo number_format($row['total_paid_amount'],2);?> INR</strong></th>
									</tr>
                                    <tr>
										<th style="width:14%;"></th>
										<th style="width:28%;" class="text-left"></th>
										<th  style="width:28%;" class="text-center"><strong>Discount</strong></th>
										<th style="width:15%;" class="text-center"></th>
										<th style="width:15%;" class="text-center"><strong><?php echo number_format($row['discount'],2);?> INR</strong></th>
									</tr>
                                    <tr>
										<th style="width:14%;"></th>
										<th style="width:28%;" class="text-left"></th>
										<th  style="width:28%;" class="text-center"><strong>Total Balance Due</strong></th>
										<th style="width:15%;" class="text-center"><strong><?php echo number_format(round($row['remain_amount']),2);?> INR</strong></th>
										<th style="width:15%;" class="text-center"></th>
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
	
	function total_amt_to_be_paid($room_cost,$bed_cost,$lux_tax,$ser_tax,$fb,$fb_vat,$fb_sat,$service_charge)
	{
		$total_amt = $room_cost+$bed_cost+$lux_tax+$ser_tax+$fb+$fb_vat+$fb_sat+$service_charge;
		return $total_amt;
	}
	
	function GenerateInvoice($payment_id)
	{
		$sql="select * from ".HMS_RESERVATION_PAYMENTS." where id ='".$payment_id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		?>
        <a href="javascript: void(0);" onClick="printpage('print');"><button class="btn btn-gebo" style="width:90px; font-family:verdana;font-size:13px;" value="Submit" type="submit" name="submit" id="submit">Print</button></a>
        
<div style="width:650px; height:842px; padding-left:70px;" id="print">
<div style="height:125px;"></div>
<div style="width:625px; float:left; margin:12px;">
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong><?php echo ucwords($this->Master->FindGuestNameByGuestId($row['guest_id']));?></strong></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><?php echo $this->Master->FindGuestAddressByGuestId($row['guest_id'])?></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><?php echo $this->Master->FindGuestCityByGuestId($row['guest_id'])?> <?php echo $this->Master->FindGuestStateByGuestId($row['guest_id'])?></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><?php echo $this->Master->FindGuestCountryByGuestId($row['guest_id'])?>, <?php echo $this->Master->FindGuestZipcodeByGuestId($row['guest_id'])?></p>
</div>

<div style="clear:both"></div>

<div style="width:625px;  margin:12px;">
<div style="width:57%; float:left">
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Arrival:</strong> <?php echo $this->Master->ArrivalDateByReservationId($row['reservation_id'])?></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Departure:</strong> <?php echo $this->Master->DeparturelDateByReservationId($row['reservation_id'])?></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Room Type:</strong> <?php echo $this->Master->RoomTypeByReservationId($row['reservation_id'])?></p>
   <?php
                               if($this->Master->getreservationOccpany($row['reservation_id'])==1)
							   {
								   ?>
                                    <p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Rate:</strong>  <?php echo $this->Master->GetRoomPriceByReservationIdforSingleOccupany($row['reservation_id'])?></p>
                         
                                   <?php
							   }
							   else
							   {
								?>
                                <p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Rate:</strong>  <?php echo $this->Master->GetRoomPriceByReservationIdforDoubleOccupany($row['reservation_id'])?></p>
                             <?php  
							   }
                               ?>
</div>
<div style="width:40%; float:left">
 <?php
										$x=1001;
                                        $sql_1 = "select * from ".HMS_RESERVATION_PAYMENTS	;
										$result_1= $this->db->query($sql_1,__FILE__,__LINE__);
										while($row_1= $this->db->fetch_array($result_1))
										$x++;
										?>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Invoice No:</strong> <?php echo $x;?></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>Adults/Children:</strong> <?php echo $this->Master->TotalAdultReservationId($row['reservation_id'])?>/<?php echo $this->Master->TotalChildReservationId($row['reservation_id'])?></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong>No. Of Days:</strong> <?php echo $this->Master->TotalNightsByReservationId($row['reservation_id'])?></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><strong></strong></p>
</div>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding: 2px;"><?php echo date('l jS \of F Y h:i:s A', strtotime($row['fullpayment_date']));?></p>
</div>

<div style="clear:both"></div>

<div style="width:625px; margin:12px;">
<div style="clear:both"></div>

<!-- header code -->
<div style="width:610px; border:1px solid #000; border-bottom:2px solid #000; height:34px; background-color:#EBF3EE; border-left:none; border-right:none;">
<div style="width:90px; height:35px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 16px; margin: 0; padding:6px 6px 6px 26px;">Date</p></div>
<div style="width:190px; height:35px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 16px; margin: 0; padding:6px 6px 6px 40px;">Description</p></div>
<div style="width:140px; height:35px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 16px; margin: 0; padding:6px 6px 6px 22px;">Reference</p></div>
<div style="width:90px; height:35px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 16px; margin: 0; padding:6px 6px 6px 22px;">Debit</p></div>
<div style="width:90px; height:35px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 16px; margin: 0; padding:6px 6px 6px 22px;">Credit</p></div> 
</div>

<!-- header code End -->

<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:35px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo date('d-m-Y', strtotime($row['payment_date']));?></p></div>
<div style="width:190px; height:35px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> Room</p></div>
<div style="width:140px; height:35px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo $this->Master->TotalBookedRoomsByReservationId($row['reservation_id']);?> Room - <?php echo $this->Master->RoomTypeByReservationId($row['reservation_id']);?></p></div>
<div style="width:90px; height:35px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"><?php echo number_format($row['base_price'],2);?></p></div>
<div style="width:90px; height:35px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> </p></div> 
</div>

 <?php
if($row['extra_bed']>0)
{
?>
<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo date('d-m-Y', strtotime($row['payment_date']));?></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> Extra Bed </p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo $this->Master->ExtraBedAllowed($row['reservation_id']);?> Bed</p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"><?php echo number_format($row['extra_bed'],2);?></p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> </p></div> 
</div>
 <?php
}
?>


 <?php
if($row['tax1']>0)
{
?>
<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo date('d-m-Y', strtotime($row['payment_date']));?></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center">Luxury Tax</p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"><?php echo $this->Master->GetTaxValue(1)?>% - On Room</p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"><?php echo number_format($row['tax1'],2);?></p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> </p></div> 
</div>
 <?php
}
?>


 <?php
if($row['tax2']>0)
{
?>
<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo date('d-m-Y', strtotime($row['payment_date']));?></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center">Service Tax</p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo $this->Master->GetTaxValue(2)?>% [On Room]</p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"><?php echo number_format($row['tax2'],2);?></p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> </p></div> 
</div>
 <?php
}
?>


 <?php
if($row['advance_amount']>0)
{
?>
<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo date('d-m-Y', strtotime($row['payment_date']));?></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> Advance Payment</p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 12px; margin: 0;  color:#000;" align="center"><?php echo $row['payment_mode']?><br /><span style="font-size:12px;"><b>Receipt No: </b><?php echo $row['receipt_no']?><span></p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"></p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo number_format($row['advance_amount'])?></p></div> 
</div>
 <?php
}
?>
 
 <?php
if($row['fandb_price']>0)
{
?>
<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo date('d-m-Y', strtotime($row['fullpayment_date']));?></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center">Food and Beverage</p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center">--</p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"><?php echo number_format($row['fb_price_plain'],2);?></p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> </p></div> 
</div>
 <?php
}
?> 

 <?php
if($row['vat_fb']>0)
{
?>
<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo date('d-m-Y', strtotime($row['fullpayment_date']));?></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center">VAT</p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"><?php echo $this->kt->GetVat();?> % On F & B</p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"><?php echo number_format($row['vat_fb'],2);?></p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> </p></div> 
</div>
 <?php
}
?> 


 <?php
if($row['sat_fb']>0)
{
?>
<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo date('d-m-Y', strtotime($row['fullpayment_date']));?></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center">VAT</p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"><?php echo $this->kt->GetSat();?> % On F & B</p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"><?php echo number_format($row['sat_fb'],2);?></p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> </p></div> 
</div>
 <?php
}
?> 

 <?php
if($row['service_charge']>0)
{
?>
<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo date('d-m-Y', strtotime($row['fullpayment_date']));?></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center">Service Charge</p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo $this->Master->GetTaxValue(4)?>% - On Bill</p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"><?php echo number_format($row['service_charge'],2);?></p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> </p></div> 
</div>
 <?php
}
?>






<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"><?php echo date('d-m-Y', strtotime($row['fullpayment_date']));?></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center">Final Payment (<?php echo $row['fullpayment_mode'];?>)</p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center">--</p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"></p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo number_format($row['final_amount'],2);?></p></div> 
</div>



<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none; margin-top:10px;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"></p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"><b>Total</b></p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"><?php echo number_format($this->total_amt_to_be_paid($row['base_price'],$row['extra_bed'],$row['tax1'],$row['tax2'],$row['fb_price_plain'],$row['vat_fb'],$row['sat_fb'],$row['service_charge']),2);?> INR</p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"></p></div> 
</div>

<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none; margin-top:10px;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"></p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"><b>Round Off:</b></p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"><?php echo number_format(round($row['total_amount']+$row['discount']),2)?> INR</p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo number_format($row['total_paid_amount'],2)?> INR</p></div> 
</div>

<div style="width:610px; border:1.3px solid #666666; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"></p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"><b>Discount</b></p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"></p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> <?php echo number_format($row['discount'],2)?> INR</p></div> 
</div>
<div style="width:610px; border:2px solid #000000; height:30px; border-left:none; border-right:none; border-top:none;">
<div style="width:90px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"></p></div>
<div style="width:190px; height:30px;float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"></p></div>
<div style="width:140px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"><b>Balance Due</b></p></div>
<div style="width:90px; height:30px; float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 0px; color:#000;" align="center"> <?php echo number_format(round($row['remain_amount']),2)?> INR</p></div>
<div style="width:90px; height:30px;  float:left;"><p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin: 0; padding:6px 6px 6px 6px; color:#000;" align="center"> </p></div> 
</div>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; width:48%; margin-top: 145px; padding:6px 6px 6px 0px; color:#000; float:left;"><b>[Front office Signature]</b></p>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; width:48%; margin-top: 145px; padding:6px 6px 6px 0px; color:#000; float:right; text-align:right;"><b>[Guest Signature]</b></p>

<div style="clear:both"></div>
<p style="font-family:Arial, Helvetica, sans-serif;font-size: 13px; margin-top: 40px; padding:6px 6px 6px 0px; color:#000;" align="right">Visit Again, Thank You</p>


</div>
</div>
        <?php
	}
	
	
	
	
	function CheckRoomAvailbilityCalendar()
	{
		$sql="select * from ".HMS_GUEST_RESERVATION." where check_in_status='0'";
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
				   $arr = explode('-',$row['arrival']);
				   $dept = explode('-',$row['departure']);
				   ?>
                    {
                            title: '<?php ?>',
                            start: new Date(<?php echo $arr[0]?>, <?php echo $arr[1]-1?>, <?php echo $arr[2]?>),
							end: new Date(<?php echo $dept[0]?>, <?php echo $dept[1]-1?>, <?php echo $dept[2]?>),
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
	

}