 <?php

/* 
 * This class is responcible for the reports
 * Author: Abhishek Kumar Mishra
 * Created Date: 22/09/2014
 */

class HotelReports
{
	
	function __construct()
	{	
					$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
					$this->validity = new ClsJSFormValidation();
					$this->Form = new ValidateForm();
					$this->auth=new Authentication();
					$this->noti=new Notification();
					$this->Helper=new HotelReportHelper();
					
	}
	
	
	
	
	function RoomStatus()
	{
		

	 ?>
        <div class="audit_left">
            <div class="audit_total_room_main">
              <div class="audit_total_room_left">Total Rooms<br />
                <span class="span8">Total Room in the hotel</span></div>
              <div class="audit_total_room_right"><?php echo $this->Helper->GetTotalRoomCount();?> Rooms</div>
            </div>
            <div class="audit_today_tomorrows_main">
              <div class="audit_total_room_left">
                <div class="audit_arrival_left"><span class="span9">Rooms</span> <br />
                  Arrivals</div>
                <div class="audit_arrival_right"><?php echo '0'.$this->Helper->getTodaysArrival();?> <br />
                  <span class="span10"><a href="#">See Details</a></span></div>
              </div>
              <div class="audit_total_room_right">
                <div class="audit_arrival_left_again"><span class="span9">Arrival </span> <br />
                  Tomorrow</div>
                <div class="audit_arrival_right_again"><?php echo '0'.$this->Helper->getTomorrowArrival();?> <br />
                  <span class="span10"><a href="#">See Details</a></span></div>
              </div>
            </div>
            <div class="audit_today_tomorrows_main">
              <div class="audit_total_room_left">
                <div class="audit_arrival_left"><span class="span9">Rooms</span> <br />
                  Departure</div>
                <div class="audit_arrival_right"><?php echo '0'.$this->Helper->getTodaysDeparture();?> </div>
              </div>
              <div class="audit_total_room_right">
                <div class="audit_arrival_left_again"><span class="span9">Departure </span> <br />
                  Tomorrow</div>
                <div class="audit_arrival_right_again"><?php echo '0'.$this->Helper->getTomorrowDeparture();?></div>
              </div>
            </div>
          </div>
        <?php 
	}
	
	
	
	function RoomAvalbilityStatus()
	{
		?>
        <div class="audit_right">
        
        
            <div class="audit_ricktangle_main">
              <div class="audit_ricktangle_room_left"><span class="span9">Rooms</span><br />
                Available<br />
                <span class="span8">Room Available in hotel</span></div>
              <div class="audit_ricktangle_room_right">
                <div class="audit_rectackt_one">
                  <div class="audit_rectackt_top">Superior</div>
                  <div class="audit_rectackt_bottom">041</div>
                </div>
                <div class="audit_rectackt_two">
                  <div class="audit_rectackt_top">Superior</div>
                  <div class="audit_rectackt_bottom">041</div>
                </div>
                <div class="audit_rectackt_three">
                  <div class="audit_rectackt_top">Superior</div>
                  <div class="audit_rectackt_bottom">041</div>
                </div>
              </div>
            </div>
            
            
          </div>
        <?php 
	}
	
	function RoomSearch($report_date)
	{
		?>
        <div class="col-lg-12">
					<div class="block-flat" style="min-height:225px !important;">
                      <div class="header">							
							<h4>Room Availability</h4>
						</div>
						<div class="content">
<form method="get" action="availibility.php?index=res" enctype="multipart/form-data" id="" name="searchUser" >
<div class="col-lg-1">
   </div>
    <div class="col-lg-1">
   </div>  
  
    
    
    <div class="col-lg-1">
   </div>
    <div class="col-lg-3">
    <div class="form-group">
             <div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
            <input class="form-control"  name="report_date" size="16" type="text" value="<?php echo $_REQUEST['report_date']?>" readonly >
            <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
            </div>
        </div>
    </div>
    
     <div class="col-lg-4">
         <div class="form-group"> 
        <button class="btn btn-primary" type="submit" value="View Report" name="submit">View</button>
        </div>
        </div>              
            </form>
						</div>
					</div>				
				</div>
        <?php
	}
	
	function getroom_type($id)
	{
		$sql="select * from ".HMS_ROOM_TYPE." where id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['name'];
	}
	
	function getroom($report_date)
	{
		$this->room_id=array();
		$sql_room="select * from ".HMS_GUEST_RESERVATION." where  check_in_status='1' ";
		if($report_date!='')
		{
			 $sql_room .= " and '".$report_date."' between arrival and departure";
		}
		$result_room = $this->db->query($sql_room,__FILE__,__LINE__);
		while($row_room = $this->db->fetch_array($result_room))
		{
			array_push($this->room_id,$row_room['room_id']);
		}
		return $this->room_id;
	}
	
	function RoomAvailReport($report_date='')
	{
		
		//print_r($this->getroom($report_date));
		
		$sql="select * from ".HMS_ROOM." where deleted!='1' and assigned=0 ";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		
		
			$sql .= " order by id";
		
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$cnt =$this->db->num_rows($result);
		//echo $sql;;
		//$row = mysql_fetch_assoc($result);
		// print_r($row);
		 //exit();
		?>
      
        <div class="col-md-12">
        <div class="block-flat">
        <div class="header">
        <h4>Rooms List</h4>
        </div>
        <div class="content">
        <div class="table-responsive">
        <table class="table table-bordered" id="datatable" >
        <thead>
        <tr>
        <th>S.No.</th>
        <th>Room No.</th>
        <th>Room Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($cnt>0)
        {
        $i=1;
        while($row = mysql_fetch_assoc($result))
        {
				
			if(!in_array($row['id'],$this->getroom($report_date)))
			{
        ?>
        <tr>
        <td><?php echo $i;?></td>
        <td><?php echo 'Room '.$row['room_no'];?></td>
        <td><?php echo $this->getroom_type($row['room_type_id']);?></td>
        </tr>
        <?php
			}
        $i++;
        }
        
        }
        else
        {
        ?>
        <tr>
        <td style="color:#C00; font-size:18px" colspan="3">Sorry! No Record Matching By Your Filter Criteria...</td>
       
        
        </tr>
        <?php
        }
        ?>
        </tbody>
        </table>
        </div>
        </div>
        </div>				
		</div>
			
        <?php   
	}
	
	
	function getBanquet($report_date,$start_time,$end_time)
	{
		$this->banquet_id=array();
		$sql_room="select * from ".HMS_BANQUETS." where  status='1' ";
		if($report_date!='')
		{
			 $sql_room .= " and event_date_start='".$report_date."'";
		}
		
		if($start_time!='' && $end_time!='')
		{
			 $sql_room .= " and '".$start_time."' between start_time  and end_time and '".$end_time."' between start_time  and end_time";
		}
		
		//echo $sql_room;
		$result_room = $this->db->query($sql_room,__FILE__,__LINE__);
		while($row_room = $this->db->fetch_array($result_room))
		{
			array_push($this->banquet_id,$row_room['banquet_id']);
		}
		return $this->banquet_id;
	}
	
	function BanquetSearch($report_date,$start_time,$end_time)
	{
		
		
		?>
        <div class="col-lg-12">
					<div class="block-flat" style="min-height:225px !important;">
                      <div class="header">							
							<h4>Banquet Availability</h4>
						</div>
						<div class="content">
<form method="get" action="banquet_availibility.php" enctype="multipart/form-data" id="" name="searchUser" >

        <div class="col-lg-3">
        <div class="form-group">
        <div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
        <input class="form-control"  name="report_date" size="16" type="text" value="<?php echo $_REQUEST['report_date']?>" readonly >
        <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
        </div>
        </div>
        </div>
        
        <div class="col-lg-3">
        <div class="form-group">
        <input id="start"  required name="start_time" value="<?php 
		if($_REQUEST['start_time']!='')
		echo $_REQUEST['start_time'];
		else
		 echo '12:00 PM'; 
		 ?>"/>
        </div>
        </div>
        
        
        <div class="col-lg-3">
        <div class="form-group">
          <input id="end"  required name="end_time" value="<?php 
		if($_REQUEST['end_time']!='')
		echo $_REQUEST['end_time'];
		else
		 echo '12:30 PM'; 
		 ?>"/>
        </div>
        </div>

    
     <div class="col-lg-3">
         <div class="form-group"> 
        <button class="btn btn-primary" type="submit" value="View Report" name="submit">View</button>
        </div>
        </div>              
            </form>
						</div>
					</div>				
				</div>
        <?php
	}
	
	
	
	
	function BanquetAvailReport($report_date='',$start_time='',$end_time='')
	{
		//print_r($this->getBanquet($report_date,$start_time,$end_time));
		$sql="select * from ".HMS_BANQUET_TYPE." where  status='1' and deleted='1' ";
		
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$cnt =$this->db->num_rows($result);
		?>
      
        <div class="col-md-12">
        <div class="block-flat">
        <div class="header">
        <h4>Banquet List</h4>
        </div>
        <div class="content">
        <div class="table-responsive">
        <table class="table table-bordered" id="datatable" >
        <thead>
        <tr>
        <th>S.No.</th>
        <th>Banquet Name</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($cnt>0)
        {
        $i=1;
        while($row = mysql_fetch_assoc($result))
        {
		
			if(!in_array($row['id'],$this->getBanquet($report_date,$start_time,$end_time)))
			{	
				
			
        ?>
        <tr>
        <td><?php echo $i;?></td>
        <td><?php echo $row['banquet'];?></td>
        </tr>
        <?php
			}
        $i++;
        }
        
        }
        else
        {
        ?>
        <tr>
        <td style="color:#C00; font-size:18px" colspan="3">Sorry! No Record Matching By Your Filter Criteria...</td>
       
        
        </tr>
        <?php
        }
        ?>
        </tbody>
        </table>
        </div>
        </div>
        </div>				
		</div>
			
        <?php   
	}
	
	
	
	
	function SalesSearch($room_type,$room_no_id,$report_date)
	{
		?>
        <div class="col-lg-12">
					<div class="block-flat" style="min-height:225px !important;">
                      <div class="header">							
							<h4>Sales Reporting </h4>
						</div>
						<div class="content">
<form method="get" action="sales_reporting.php" enctype="multipart/form-data" id="" name="searchUser" >

    <div class="col-lg-3">
    <div class="form-group"> 
    <select name="room_type" class="form-control"  onchange="report_obj.GetAllRooms(this.value,{target:'refroomlisting',preloader:'pr'})">
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
    </div>  
    
    <div class="col-lg-1">
    <img id="pr" src="img/status.gif" style="visibility:hidden; height:25px;">
    </div>
    <div class="col-lg-3">
    <div class="form-group" id="refroomlisting"> 
    <select name="room_no_id" class="form-control">
    <option value="">--Room No.--</option>
			
    </select>
    
    </div>
    </div>
    
    <div class="col-lg-1">
   </div>
    <div class="col-lg-3">
    <div class="form-group">
             <div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
            <input class="form-control"  name="report_date" size="16" type="text" value="" readonly >
            <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
            </div>
        </div>
    </div>
    
     <div class="col-lg-4">
         <div class="form-group"> 
        <button class="btn btn-primary" type="submit" value="View Report" name="submit">View Report</button>
        </div>
        </div>              
            </form>
						</div>
					</div>				
				</div>
        <?php
	}
	
	
	
	
	function GetAllRooms($id)
	{
	ob_start();
	?>
						<select class="form-control" name="room_no_id" >
						<option value="">-- Select Room --</option>
							<?php
							$sql="select * from ".HMS_ROOM." where room_type_id='".$id."' and deleted='0'";
                            $result = $this->db->query($sql,__FILE__,__LINE__);
							while($row = $this->db->fetch_array($result))
							{
							?>
							<option value="<?php echo $row['id'];?>"><?php echo $row['room_no'];?></option>
							<?php
							}
							?>
						</select>
	<?php
	
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
	}
	
	function SalesReport($room_type='',$room_no_id='',$report_date='')
	{
$sql = "SELECT res.id,res.guest_id,res.arrival,res.departure,res.no_of_nights,res.occupancy,res.adult_count,res.child_count,res.room_type_id,res.room_id,res.created,res.check_in_status,res_pay.guest_id,res_pay.reservation_id,res_pay.receipt_no,res_pay.base_price,res_pay.extra_bed,res_pay.fandb_price,res_pay.fb_price_plain,res_pay.tax1,res_pay.tax2,res_pay.vat_fb,res_pay.sat_fb,res_pay.service_charge,res_pay.discount,res_pay.advance_amount,res_pay.total_amount,res_pay.total_paid_amount,res_pay.final_amount,res_pay.remain_amount,res_pay.payment_mode as advmode,res_pay.fullpayment_mode as fpmode,rm.id AS roomId,rm.room_no,rmt.name,rmt.id AS roomtypeID
		FROM tbl_guest_reservation AS res 
		INNER JOIN tbl_reservation_payments AS res_pay on (res.id = res_pay.reservation_id)
		INNER JOIN tbl_rooms AS rm on (res.room_id = rm.id)
		INNER JOIN tbl_room_types AS rmt on (res.room_type_id = rmt.id) where 1 ";
		  if($report_date)
		  {
				$sql .= " and '".$report_date."' between res.arrival and res.departure";
		  }
		  if($room_type)
		  {
			  $sql .= " and res.room_type_id  ='".$room_type."'";
		  }
		   if($room_no_id)
		  {
			  $sql .= " and res.room_id  ='".$room_no_id."'";
		  }
			  $sql .= " order by res.created desc";
			  
			   $result = $this->db->query($sql,__FILE__,__LINE__);
				$cnt =$this->db->num_rows($result);
		//echo $sql;;
		//$row = mysql_fetch_assoc($result);
		// print_r($row);
		 //exit();
		?>
      
        <div class="col-md-12">
					<div class="block-flat">
                    
						<div class="header">
                        <h4>Report List</h4>
                      </div>
						<div class="content">
                        
                        <table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>S.No.</th>
            <th>Room Type</th>
            <th>Room No.</th>
            <th>Room Rate</th>
            <th>No. of Person<br/>
            (Adult+Child)</th>
            <th>Occupacy</th>
            <th>Day</th> 
            <th>Room Charge</th>
            <th>Discount</th>
             <th>Extra Bed Cost</th>
            <th>Lux. Tax</th>
            <th>Ser. Tax</th>
            <th>F & B Charges</th>
            <th>VAT</th>
            <th>SAT</th> 
            <th>Service Charge</th>
            <th>Net Amount</th>
            <th>Advance Amount ( Receipt No)</th>
             <th>Advance Amount ( Payment Mode)</th>
            <th>Final Amount</th>
            <th>Final Amount ( Payment Mode)</th>
            <th>Amount Total Paid</th>
            <th>Outstanding</th> 
					</tr>
				</thead>
             <tbody>
         <?php
		if($cnt>0)
		{
				$i=1;
				while($row = mysql_fetch_assoc($result))
				{
					?>
                 <tr style="color:#000 !important;">
					<td><?php echo $i;?></td>
					 <td><?php echo $row['name'];?></td>
					<td><?php echo 'Room '.$row['room_no'];?></td>
					<td><?php echo number_format($row['base_price'],2).' INR';?></td>
					<td><?php echo $row['adult_count'].' Adults ';
					if($row['child_count']>0)
					{ echo $row['child_count'].'+ Children' ;} ?></td>
					<td><?php if($row['occupancy']==1) { echo 'Single';} else { echo 'Double';}?></td>
					<td><?php echo number_format($row['no_of_nights'],2).' Day';?></td>
					<td><?php echo number_format($row['base_price']-$row['discount'],2).' INR';?></td>
					<td><?php echo number_format($row['discount'],2).' INR';?></td>
					<td><?php echo number_format($row['extra_bed'],2).' INR';?></td>
					<td><?php echo number_format($row['tax1'],2).' INR';?></td>
					<td><?php echo number_format($row['tax2'],2).' INR';?></td>
					<td><?php echo number_format($row['fb_price_plain'],2).' INR';?></td>
					<td><?php echo number_format($row['vat_fb'],2).' INR';?></td>
					<td><?php echo number_format($row['sat_fb'],2).' INR';?></td>
					<td><?php echo number_format($row['service_charge'],2).' INR';?></td>
					<td><?php echo number_format($row['total_amount'],2).' INR';?></td>
					<td><?php echo number_format($row['advance_amount'],2).' INR ('.$row['receipt_no'].')';?></td>
                                        <td><?php echo $row['advmode'];?></td>
					<td><?php echo number_format($row['final_amount'],2).' INR';?></td>
                                        <td><?php echo $row['fpmode'];?></td>
					<td><?php echo number_format($row['total_paid_amount'],2).' INR';?></td>
					<td><?php echo number_format($row['remain_amount'],2).' INR';?></td>
					</tr>
					<?php
					$i++;
				}
				
		}
		else
		{
			?>
            <tr>
					<td style="color:#C00; font-size:18px">Sorry! No Record Matching By Your Filter Criteria...</td>
                   <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
            </tr>
            <?php
		}
		?>
	</tbody>
			</table>
          </div>
					</div>				
				</div>
			
        <?php   
	}
	
	
	function SalesBanquetSearch($banquet_type,$report_date)
	{
		?>
        <div class="col-lg-12">
					<div class="block-flat" style="min-height:225px !important;">
                      <div class="header">							
							<h4>Sales Banquet Hall Only Reporting </h4>
						</div>
						<div class="content">
<form method="get" action="sales_banquet_reporting.php" enctype="multipart/form-data" id="" name="searchUser" >

    <div class="col-lg-3">
    <div class="form-group"> 
    <select name="banquet_type" class="form-control" >
    <option value="">--Banquet Type--</option>
				<?php
				$sql="select * from ".HMS_BANQUET_TYPE." where status=1 and deleted=1";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				while($row = $this->db->fetch_array($result))
				{
				?>
				<option value="<?php echo $row['id'];?>"><?php echo $row['banquet'];?></option>
				<?php
				}
				?>
    </select>
    
    </div>
    </div>  
    
    <div class="col-lg-1">
    </div>
    <!--<div class="col-lg-3">
    <div class="form-group" id="refroomlisting"> 
    <select name="pakageType" class="form-control">
    <option value="without_package">With Out Package</option>
    <option value="with_package">With Package</option>
	</select>
    
    </div>
    </div>-->
    
    <div class="col-lg-3">
    <div class="form-group">
             <div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
            <input class="form-control"  name="report_date" size="16" type="text" value="" readonly >
            <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
            </div>
        </div>
    </div>
    
     <div class="col-lg-4">
         <div class="form-group"> 
        <button class="btn btn-primary" type="submit" value="View Report" name="submit">View Report</button>
        </div>
        </div>              
            </form>
						</div>
					</div>				
				</div>
        <?php
	}
	
	
		function SalesBanquetReport($banquet_type='',$report_date='')
	{
		  if($report_date)
		  {
				$cond = " and bq.event_date_start='".$report_date."'";
		  }
		  if($banquet_type)
		  {
			  $cond .= " and bq.banquet_id ='".$banquet_type."'";
		  }
		  /* if($pkg_type)
		  {
			  $cond .= " and bqp.bq_booking_type ='".$pkg_type."'";
		  }*/
		      $cond .= " and bqp.bq_booking_type ='without_package'";
			  $cond .= " order by bqp.created desc";
			  
			$sql = "select bq.id,bq.person_name,bq.organization,
			bq.event_date_start As BookingDate,bq.start_time,bq.end_time,
			bq.banquet_id,bqp.*,bqt.banquet from tbl_banquets AS bq
			INNER JOIN tbl_banquet_payment AS bqp on (bq.id = bqp.banquet_id)
			INNER JOIN tbl_banquet_types AS bqt on (bq.banquet_id = bqt.id) where 1 $cond";
		  
			  
			   $result = $this->db->query($sql,__FILE__,__LINE__);
		
		?>
      
        <div class="col-md-12">
					<div class="block-flat">
                    
						<div class="header">
                        <h4>Report List</h4>
                      </div>
						<div class="content">
                        
                        <table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
                            <th>S.No.</th>
                            <th>Person Name</th>
                            <th>Organization</th>
                            <th>Booking Date</th>
                            <th>Booking Time</th>
                            <th>Banquet Name</th>
                            <th>Hall Cost</th> 
                            <th>Audio Charges</th> 
                            <th>Projector charges</th>
                            <th>No of Pax</th>
                            <th>Extra Hrs Charges</th>
                            <th>Service Tax On Extra Hrs</th>
                            <th>Total Cost</th>
                            <th>Service tax</th> 
                            <th>Final Amount</th>
                            <th>Discount</th> 
                            <th>Advance Amount (Mode)</th>
                            <th>Final amonut (Mode)</th>
                            <th>Total Amount Paid</th>
                            <th>Outstanding</th> 
					</tr>
				</thead>
             <tbody>
         <?php
			$i=1;
				while($row = mysql_fetch_assoc($result))
				{
					//print_r($row);
					
					?>
					<tr>
					<td><?php echo $i;?></td>
					 <td><?php echo $row['person_name'];?></td>
					<td><?php echo $row['organization'];?></td>
					<td><?php echo $row['BookingDate'];?></td>
					<td><?php echo $row['start_time'].'--'.$row['end_time'];?></td>
					<td><?php echo $row['banquet'];?></td>
					<td><?php echo number_format($row['hall_cost'],2).' INR';?></td>
					<td><?php echo number_format($row['audio_charges'],2).' INR';?></td>
					<td><?php echo number_format($row['projector_charges'],2).' INR';?></td>
					<td><?php echo $row['no_of_pax'];?></td>
					<td><?php echo number_format($row['extra_hr_charges_plain'],2).' INR'; ?></td>
					<td><?php  echo number_format($row['extra_hr_charges_sat'],2).' INR'; ?></td>
                    
					<td><?php echo number_format($row['total_cost']+$row['audio_charges']+$row['projector_charges'],2).' INR'; ?></td>
					<td><?php  echo number_format($row['servicetax'],2).' INR';?></td>
                  <td><?php echo number_format($row['finalcost']+round($row['extra_hr_charges']),2).' INR';?></td>
					<td><?php echo number_format($row['disount_given'],2).' INR';?></td>
					<td><?php echo number_format($row['advance_paid'],2).' INR ('.$row['receipt_no'].')';?> (<?php echo $row['advance_mode'];?>)</td>
					<td><?php echo number_format($row['full_amount_paid'],2).' INR';?>(<?php echo $row['full_amount_mode'];?>)</td>
					<td><?php echo number_format($row['advance_paid']+$row['full_amount_paid'],2).' INR';?></td>
					<td><?php echo number_format($row['remaining_amt'],2).' INR';?></td>
					</tr>
					<?php
					$i++;
				}
				
		
		
		?>
	</tbody>
			</table>
          </div>
					</div>				
				</div>
			
        <?php    
	}
	
	
	function SalesBanquetPaxWithHallSearch($banquet_type,$report_date)
	{
		?>
        <div class="col-lg-12">
					<div class="block-flat" style="min-height:225px !important;">
                      <div class="header">							
							<h4>Sales Banquet Hall With Pax Reporting </h4>
						</div>
						<div class="content">
<form method="get" action="sales_banquet_reporting_pax.php" enctype="multipart/form-data" id="" name="searchUser" >

    <div class="col-lg-3">
    <div class="form-group"> 
    <select name="banquet_type" class="form-control" >
    <option value="">--Banquet Type--</option>
				<?php
				$sql="select * from ".HMS_BANQUET_TYPE." where status=1 and deleted=1";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				while($row = $this->db->fetch_array($result))
				{
				?>
				<option value="<?php echo $row['id'];?>"><?php echo $row['banquet'];?></option>
				<?php
				}
				?>
    </select>
    
    </div>
    </div>  
    
    <div class="col-lg-1">
    </div>
  
    <div class="col-lg-3">
    <div class="form-group">
             <div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
            <input class="form-control"  name="report_date" size="16" type="text" value="" readonly >
            <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
            </div>
        </div>
    </div>
    
     <div class="col-lg-4">
         <div class="form-group"> 
        <button class="btn btn-primary" type="submit" value="View Report" name="submit">View Report</button>
        </div>
        </div>              
            </form>
						</div>
					</div>				
				</div>
        <?php
	}
	
	
	
	function SalesBanquetWithPaxReport($banquet_type='',$report_date='')
	{
		  if($report_date)
		  {
				$cond = " and bq.event_date_start='".$report_date."'";
		  }
		  if($banquet_type)
		  {
			  $cond .= " and bq.banquet_id ='".$banquet_type."'";
		  }
		  /* if($pkg_type)
		  {
			  $cond .= " and bqp.bq_booking_type ='".$pkg_type."'";
		  }*/
		      $cond .= " and bqp.bq_booking_type ='with_package'";
			  $cond .= " order by bqp.created desc";
			  
		     $sql = "select bq.id,bq.person_name,bq.organization,
			bq.event_date_start As BookingDate,bq.start_time,bq.end_time,
			bq.banquet_id,bqp.*,bqt.banquet from tbl_banquets AS bq
			INNER JOIN tbl_banquet_payment AS bqp on (bq.id = bqp.banquet_id)
			INNER JOIN tbl_banquet_types AS bqt on (bq.banquet_id = bqt.id) where 1 $cond";
			
			
		  
			  
			   $result = $this->db->query($sql,__FILE__,__LINE__);
		
		?>
      
        <div class="col-md-12">
					<div class="block-flat">
                    
						<div class="header">
                        <h4>Report List</h4>
                      </div>
						<div class="content">
                        
                        <table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
                                <th>S.No.</th>
                                <th>Person Name</th>
                                <th>Organization</th>
                                <th>Booking Date</th>
                                <th>Booking Time</th>
                                <th>Banquet Name</th>
                                <th>Pax Cost</th> 
                                <th>Audio Charges</th> 
                                <th>Projector charges</th>
                                <th>No of Pax</th>
                                <th>Extra Pax Charges(Plain)</th>
                                <th>Extra Pax Vat</th>
                                <th>Extra Pax Sat</th>
                                <th>Extra Pax Service Tax</th>
                                <th>Total Cost</th>
                                <th>VAT</th> 
                                <th>SAT</th>
                                <th>Service Tax</th>
                                <th>Service Charge</th>
                                <th>Final Amount</th>
                                <th>Discount</th> 
                                <th>Advance Amount (Mode)</th>
                                <th>Final amonut (Mode)</th>
                                <th>Total Amount Paid</th>
                                <th>Outstanding</th> 
					</tr>
				</thead>
             <tbody>
         <?php
			$i=1;
				while($row = mysql_fetch_assoc($result))
				{
					//print_r($row);
					
					?>
					<tr>
					<td><?php echo $i;?></td>
					 <td><?php echo $row['person_name'];?></td>
					<td><?php echo $row['organization'];?></td>
					<td><?php echo $row['BookingDate'];?></td>
					<td><?php echo $row['start_time'].'--'.$row['end_time'];?></td>
					<td><?php echo $row['banquet'];?></td>
					<td><?php echo number_format($row['per_pax_cost'],2).' INR';?></td>
					<td><?php echo number_format($row['audio_charges'],2).' INR';?></td>
					<td><?php echo number_format($row['projector_charges'],2).' INR';?></td>
					<td><?php echo $row['no_of_pax'];?></td>
					<td><?php echo number_format($row['extra_pax_plain_cost'],2).' INR'; ?></td>
					<td><?php  echo number_format($row['extra_pax_vat'],2).' INR'; ?></td>
                    <td><?php  echo number_format($row['extra_pax_sat'],2).' INR'; ?></td>
                    <td><?php  echo number_format($row['extra_pax_ser_tax'],2).' INR'; ?></td>
                    
					<td><?php echo number_format($row['total_cost'],2).' INR'; ?></td>
                    
                    <td><?php echo number_format($row['vat'],2).' INR'; ?></td>
                    <td><?php echo number_format($row['sat'],2).' INR'; ?></td>
                    <td><?php echo number_format($row['servicetax'],2).' INR'; ?></td>
                    <td><?php echo number_format($row['service_charge'],2).' INR'; ?></td>
                
                  <td><?php echo number_format($row['finalcost']+round($row['extra_pax_cost']),2).' INR';?></td>
					<td><?php echo number_format($row['disount_given'],2).' INR';?></td>
					<td><?php echo number_format($row['advance_paid'],2).' INR ('.$row['receipt_no'].')';?> (<?php echo $row['advance_mode'];?>)</td>
					<td><?php echo number_format($row['full_amount_paid'],2).' INR';?>(<?php echo $row['full_amount_mode'];?>)</td>
					<td><?php echo number_format($row['advance_paid']+$row['full_amount_paid'],2).' INR';?></td>
					<td><?php echo number_format($row['remaining_amt'],2).' INR';?></td>
					</tr>
					<?php
					$i++;
				}
				
		
		
		?>
	</tbody>
			</table>
          </div>
					</div>				
				</div>
			
        <?php    
	}
	
	
	
	

}