<?php

/* 
 * This class is responcible for the user tentative Reservation of HMS
 * Author: Abhishek Kumar Mishra
 * Created Date: 06/08/2014
 */

class TentativeReservation
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
            <h3>Tentative Reservations</h3>
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
				<option value="wait" selected="selected">Wait List</option>
				</select>
	         </div>
			 
			 <div class="col-sm-6" style="padding-right: 6px;padding-left: 1px;">
              <label>Booking Source</label> 
				 	<select class="form-control" name="booking_source_id">
				<option value="">--Booking Type --</option>
				<option value="on_call" selected="selected">On Call Booking</option>
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
		 if($this->Form->ValidField($arrival,'empty','Please enter arrival date')==false)
			$return =false;
		if($this->Form->ValidField($departure,'empty','Please enter departure date')==false)
			$return =false;
		if($this->Form->ValidField($booking_type,'empty','Please Select Booking Type')==false)
			$return =false;
			
		if($return){
							$insert_sql_array = array();
							$insert_sql_array['title'] = $this->title;
							$insert_sql_array['first_name'] = $this->first_name;
							$insert_sql_array['last_name'] = $this->last_name;
						    $insert_sql_array['email'] = $this->email;
							$insert_sql_array['phone'] =$this->phone;
							$insert_sql_array['arrival'] = $this->arrival;
							$insert_sql_array['departure'] = $this->departure;
							$insert_sql_array['no_of_nights'] = $this->no_of_nights;
							$insert_sql_array['room_type_id'] = $this->room_type_id;
							$insert_sql_array['occupancy'] =  $this->occupancy;
							$insert_sql_array['no_of_rooms'] = $this->no_of_room;
							$insert_sql_array['adult_count'] = $this->adult_count;
							$insert_sql_array['child_count'] = $this->child_count;
							$insert_sql_array['child_age'] = $this->child_age;
							$insert_sql_array['extra_bed'] = $this->extra_bed;
							$insert_sql_array['market_place_id'] = $this->market_place_id;
							$insert_sql_array['source_info_id'] = $this->source_info_id;
							$insert_sql_array['booking_source_id'] = $this->booking_source_id;
							$insert_sql_array['booking_type'] = $this->booking_type;
							$this->db->insert(HMS_HOLD_GUEST_RESERVATION,$insert_sql_array);
							
							$_SESSION['msg'] = 'Hold Reservation has been Successfully Done.';
							?>
							<script type="text/javascript">
							window.location = 'add_tentative.php';
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
		<?php
		 }
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	

	
	
	
	function ReservationListing($pg='',$recordcount='',$first_name='',$last_name='',$phone='',$arrival='',$departure='',$room_type_id='')
	{
		ob_start();
			$sql="select * from ".HMS_HOLD_GUEST_RESERVATION." where cancelled!=1";
			$sql .= " order by arrival asc";
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
						<h4>Tentative Reservation List</h4>
						</div>
						<div class="content" <?php /*?>style="max-height:600px; overflow:auto;"<?php */?>>
                        <?php
			if($cnt>0)
			{
				while($row = $this->db->fetch_array($result))
				{
					?>
			<div class="block-flat profile-info" style="padding-top:5px; margin-bottom:10px;">
			<div class="row">
			<div class="col-sm-8">
			<div class="personal" style="padding-bottom:2px;">
			<h4><strong style="color:#2494F2;"> <?php echo $row['title'].' '.$row['first_name'].' '.$row['last_name'];?></strong></h4>
		    <div class="col-md-6 col-sm-5"><strong>Arrival: </strong><?php echo $row['arrival'];?></div>
			<div class="col-md-6 col-sm-5"><strong>Departure: </strong><?php echo $row['departure'];?></div>
			<div class="col-md-6 col-sm-5"><strong>Contact: </strong><?php echo $row['phone']?> </div>
			<div class="col-md-6 col-sm-5"><strong>Adult/Child: </strong>  <?php echo $row['adult_count']?>/<?php echo $row['child_count']?></div>
			<div class="col-md-12 col-sm-5"><strong>Email: </strong><?php echo $row['email'];?></div>
			<div class="col-md-12 col-sm-5"><strong>Room Type: </strong> <?php echo $this->Master->RoomTypeByRoomTypeId($row['room_type_id']);?></div>
			</div>
			</div>
			<div class="col-sm-4">
			<?php
			if($_SESSION['user_type']==1 or $_SESSION['user_type']==2)
			{
			?>
			<div class="btn-group" style="margin-top:30px;">
			<button type="button" class="btn btn-default">Guest Settings</button>
			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
			</button>
			<ul class="dropdown-menu" role="menu">
		    <li class="divider"></li>
			<li> <a  href="javascript: void(0);" title="Cancel Booking" onclick="javascript: if(confirm('Do u want to cancel this hold Reservation Info?')) { reservation_obj.deleteguest('<?php echo $row['id'];?>',{}) };">Cancel Booking</a></li>
             </ul>
			</div>
			 <?php
			}
			?>
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
		<li><a  onclick="reservation_obj.ReservationListing('1',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,{target:'popupdiv'})" href="javascript:void(0)">First</a></li>
						<li><a  onclick="reservation_obj.ReservationListing('<?php echo $pgr-1;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,{target:'popupdiv'})" href="javascript:void(0)">Previous</a></li>
		<?php }?>
		
		<?php if($pgr == $lastpage && ($pgr-4) >= 1 ) { ?>
						<li><a onclick="reservation_obj.ReservationListing('<?php echo $pgr-4;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,{target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr-4; ?></a>
						</li>
						<?php } ?>
						
						<?php if($pgr == $lastpage || $pgr == $lastpage-1) { 
						if(($pgr-3) >= 1){?>
						<li><a  onclick="reservation_obj.ReservationListing('<?php echo $pgr-3;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,  {target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr-3; ?></a>
						</li>
						<?php } } ?>
						
						<?php $temp0=$pgr-2; if($temp0 >= 1) { ?>
						<li><a  onclick="reservation_obj.ReservationListing('<?php echo $pgr-3;?>',   '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,{target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr-2; ?></a>
						</li>
						<?php } ?>

						
						<?php $temp1=$pgr-1; if($temp1 >= 1) {?>
						<li><a  onclick="reservation_obj.ReservationListing('<?php echo $pgr-1;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' , {target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr-1; ?></a>
						</li>
						<?php } ?>
						
						<li class="active"><a class="paginate_active" tabindex="0"><?php echo $pgr;?></a></li>
						
						<?php $temp2=$pgr+1; if($temp2 <= $lastpage) { ?>
						<li><a  onclick="reservation_obj.ReservationListing('<?php echo $pgr+1;?>',   '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,{target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr+1; ?></a>
						</li>
						<?php } ?>
						
						<?php $temp3=$pgr+2; if($temp3 <= $lastpage) { ?>
						<li><a onclick="reservation_obj.ReservationListing('<?php echo $pgr+2;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' , {target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr+2; ?></a>
						</li>
						<?php } ?>
						
						<?php if($pgr == 1 || $pgr == 2) { if(($pgr+3) <= $lastpage) { ?>
						<li><a  onclick="reservation_obj.ReservationListing('<?php echo $pgr+3;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,  {target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr+3; ?></a>
						</li>
						<?php } }?>
						
						<?php if($pgr == 1 && ($pgr+4) <= $lastpage) { ?>
						<li><a onclick="reservation_obj.ReservationListing('<?php echo $pgr+4;?>',  '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' , {target:'popupdiv'})" href="javascript:void(0)"><?php echo $pgr+4; ?></a>
						</li>
						<?php } ?>
		
						<?php if($lastpage!='0' && $lastpage!=$pgr) {
						
						?>
						<li><a  onclick="reservation_obj.ReservationListing('<?php echo $pgr+1;?>', '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' ,{target:'popupdiv'})" href="javascript:void(0)">Next&nbsp;<span class="fa fa-angle-right"></span></a>
						</li>
						
						<li><a onclick="reservation_obj.ReservationListing('<?php echo $lastpage;?>', '<?php echo $recordcount;?>','<?php echo $first_name?>','<?php echo $last_name?>','<?php echo $phone?>','<?php echo $arrival?>','<?php echo $departure?>','<?php echo $room_type_id?>' , {target:'popupdiv'})" href="javascript:void(0)">Last&nbsp;<span class="fa fa-angle-right"></span></a>
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
	
	function deleteguest($hold_id)
	{
		ob_start();
			
			/*Start deleting only this reservation by making delete status = 1*/
			$update_array = array();
			$update_array['cancelled'] = 1 ;
		    $this->db->update(HMS_HOLD_GUEST_RESERVATION,$update_array,'id',$hold_id);
			$_SESSION['msg']='Hold Reservation has been  successfully cancelled.';
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
	

	
	
	

}