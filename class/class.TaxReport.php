 <?php

/* 
 * This class is responcible for the reports
 * Author: Abhishek Kumar Mishra
 * Created Date: 22/09/2014
 */

class TaxReports
{
	
	function __construct()
	{	
					$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
					$this->validity = new ClsJSFormValidation();
					$this->Form = new ValidateForm();
					$this->auth=new Authentication();
					$this->noti=new Notification();
					$this->Helper=new HotelReportHelper();
					$this->Master=new MasterClass();
					$this->objMail=new PHPMailer();
					
	}
	
	
	function Search($start_date='',$end_date='')
	{
		?>
        <div class="col-lg-12">
					<div class="block-flat" style="min-height:225px !important;">
                      <div class="header">							
							<h4>Reporting </h4>
						</div>
						<div class="content">
<form method="get" action="tax_report.php" enctype="multipart/form-data" id="" name="searchUser" >

    <div class="col-lg-4">
    <div class="form-group">
             <div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
            <input class="form-control"  name="start_date" value="<?php echo $_REQUEST['start_date']?>" size="16" type="text"  readonly >
            <span class="input-group-addon btn btn-primary"><span class="glyphicon glyphicon-th"></span></span>
            </div>
        </div>
    </div>  
    
    <div class="col-lg-4">
    <div class="form-group">
             <div class="input-group date datetime" data-min-view="2" data-date-format="yyyy-mm-dd">
            <input class="form-control"  name="end_date" size="16" type="text" value="<?php echo $_REQUEST['end_date']?>" readonly >
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
	function getroom_type($type,$id)
        {
            $sql_room="SELECT *  from ".HMS_ROOM_TYPE." where id='".$type."'";
            $result_room = $this->db->query($sql_room,__FILE__,__LINE__);
            $row_room = mysql_fetch_assoc($result_room);
            return $row_room['base_price'];
           
        }
        
        function getbill_no($id)
        {
            $sql_room="SELECT *  from ".HMS_RESERVATION_PAYMENTS." where reservation_id='".$id."'";
            $result_room = $this->db->query($sql_room,__FILE__,__LINE__);
            $row_room = mysql_fetch_assoc($result_room);
            return $row_room['id'];
           
        }
        
       
        
        function getper_persontax($id,$person)
        {
            $sql_room="SELECT *  from ".HMS_RESERVATION_PAYMENTS." where reservation_id='".$id."'";
            $result_room = $this->db->query($sql_room,__FILE__,__LINE__);
            $row_room = mysql_fetch_assoc($result_room);
            $tax=$row_room['tax1']/$person;
            return $tax;
           
        }
         function getpersontax($id)
        {
            $sql_room="SELECT *  from ".HMS_RESERVATION_PAYMENTS." where reservation_id='".$id."'";
            $result_room = $this->db->query($sql_room,__FILE__,__LINE__);
            $row_room = mysql_fetch_assoc($result_room);
            
            return $row_room['tax1'];
           
        }
	function Report($start_date='',$end_date='')
	{
	
		$sd=01;
		$ed=31;
		 $arrival_date=date('Y-m-0'.$sd);
		 $departure_date=date('Y-m-'.$ed);
		$sql = "SELECT *  from ".HMS_GUEST_RESERVATION." where 1";
		if($start_date!='' && $end_date!='')
		{
			$sql .= " and arrival>='".$start_date."' and departure<='".$end_date."' and check_in_status=1 OR arrival>='".$start_date."' and departure<='".$end_date."' and check_in_status=2";
		}
		  else
		  {
			  	$sql .= " and arrival>='".$arrival_date."' and departure<='".$departure_date."' and check_in_status=1 OR arrival>='".$arrival_date."' and departure<='".$departure_date."' and check_in_status=2 ";
		  }
                         // $sql .= " and check_in_status=1 OR check_in_status=2";
			  $sql .= " order by id desc";
			  
			   $result = $this->db->query($sql,__FILE__,__LINE__);
				//$cnt =$this->db->num_rows($result);
		//echo $sql;;
		///$row = mysql_fetch_assoc($result);
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
                    <th>Name of Person</th>
                    <th>Age</th>
                    <th>Nationality</th>
                    <th>Room No.</th>
                    <th>Room Rate <br />per day per person</th> 
                    <th>Arrival<br />Date / Time</th>
                    <th>Depataure<br />Date / Time</th>
                    <th>Period of<br /> stay in days</th>
                    <th>Total Room Charges</th>
                    <th>Charges paid <br />in Foreign/Indian Currency</th>
                    <th>No. of Person</th>
                    <th>Bill/Cash Memo<br />No. / Date</th>
                    <th>L.T. Colected<br /> from Each Person</th> 
                    <th>Totally Collected</th>
                    
                    </tr>
				</thead>
             <tbody>
         <?php
		
				$i=1;
				while($row = mysql_fetch_assoc($result))
				{
					$sql_guest="SELECT title,first_name,last_name,TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age, nationality  from ".HMS_GUEST." where id=".$row['guest_id'];
					$result_guest = $this->db->query($sql_guest,__FILE__,__LINE__);
					$row_guest = mysql_fetch_assoc($result_guest); 
					
					$sql_room="SELECT *  from ".HMS_ROOM." where id=".$row['room_id'];
					$result_room = $this->db->query($sql_room,__FILE__,__LINE__);
					$row_room = mysql_fetch_assoc($result_room);
					
					$total_person=$row['adult_count']+$row['child_count'];
					?>
					<tr style="color:#000 !important;">
					<td><?php echo $i;?></td>
					 <td><?php echo $row_guest['title'].' '.$row_guest['first_name'].' '.$row_guest['last_name'];?></td>
					<td><?php echo $row_guest['age'].' years ';?></td>
                                        <td><?php echo ucfirst($row_guest['nationality']);?></td>
					<td><?php echo 'Room '.$row_room['room_no'];?></td>
					<td><?php echo $this->getroom_type($row['room_type_id'],$row['occupancy']);?></td>
					<td><?php echo $row['arrival'];?></td>
					<td><?php echo $row['departure'];?></td>
					<td><?php echo $row['no_of_nights'];?></td>
					<td><?php echo $this->Master->getRoomTotalAmount($row['guest_id']);?></td>
					<td>INR</td>
					<td><?php echo $total_person;?></td>
					<td><?php echo $this->getbill_no($row['id']);?></td>
					<td><?php echo @number_format($this->getper_persontax($row['id'],$total_person),2);?></td>
					<td><?php echo @number_format($this->getpersontax($row['id']),2);?></td>
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
