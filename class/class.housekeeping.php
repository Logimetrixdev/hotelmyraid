<?php

/* 
 * This class is responcible for the Housekeeping.
 * Author: Abhishek Kumar Mishra
 * Created Date: 1/6/2014
 */
 

class HousekeepingClass
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
	

	function ManageHousekeeping()
	{
		
		?>
               
				<div class="col-md-12">
					<div class="block-flat">
                  
						<div class="header">
                        							
							<h4>Housekeeping Details</h4>
                          
						</div>
						<div class="content">
							<div class="table-responsive">
								<table class="table table-bordered" id="datatable" >
									<thead>
										<tr>
											<th>S. No.</th>
											<th>Room Type</th>
											<th>Room No.</th>
											<th>Current Status</th>
                                           <th>Operations</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
				$sql="select * from ".HMS_ROOM." where deleted='0'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$cnt = $this->db->num_rows($result);
				if($cnt>0)
				{
							$x=1;
							while($row = $this->db->fetch_array($result))
							{
							?>
                                    
										<tr class="odd gradeX">
											<td><?php echo $x;?></td>
											<td><?php echo $this->Master->RoomTypeByRoomTypeId($row['room_type_id']);?></td>
											<td><?php echo 'Room '.$row['room_no'];?></td>
											<td class="center"> <?php echo $this->Master->GetRoomStatusbyAssignedValue($row['assigned']);?></td>
                                            
											<td class="center"><div class="btn-group"><button class="btn btn-default btn-xs" type="button">Actions</button><button data-toggle="dropdown" class="btn btn-xs btn-primary dropdown-toggle" type="button"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul role="menu" class="dropdown-menu pull-right">
                                           <!-- <li><a href="#" title="">Room Available with Clean Status</a></li>
                                            <li><a href="#" title="">Room Booked</a></li>
                                           --> 
                                           <?php if($row['assigned']==1 or $row['assigned']==0) { ?>
                                           <li><a href="assignhousekeeping.php?index=assign&room_id=<?php echo $row['id'];?>" class="fancybox fancybox.iframe"  title="">
                                           Assign Houskeeping</a></li>
                                           <?php } elseif($row['assigned']==2) { ?>
                                            <li><a href="assignhousekeeping.php?index=release&room_id=<?php echo $row['id'];?>&hk_id=<?php echo $row['current_hk_id'];?>" class="fancybox fancybox.iframe" title="">Room Clear</a></li>
                                            <?php }?>
                                           <!-- <li><a href="#" title="">Guest - Check Out Room Dirty</a></li>-->
                                         </ul></div></td>
										</tr>
										<?php 
							$x++;
							}
				}
				else
				{
					?>
                   					 <tr class="odd gradeX">
											<td colspan="5"><h4>Sorry! No Room  Available</h4></td>
											
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
	
	
	function AssignUserForHouskeeping($runat,$room_id)
	{
		switch($runat)
		{
		
			case 'local':
			$FormName = "form_adduser";
			?>
            <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="addNew">
      <div class="col-md-8">
       <div class="block-flat">
          <div class="header">							
            <h3>Assign User For HouseKeeping</h3>
          </div>
          <div class="content">
           	 <div class="form-group">
			                <div class="col-sm-8">
                            <h4>User List</h4>
                            <select name="user_id" class="form-control" required>
                            <option value="">-- Select User --</option>
                            <?php
							$sql="select * from ".HMS_USER." where user_type_id='3' and status=1 ORDER BY username";
							$result = $this->db->query($sql,__FILE__,__LINE__);
							while($row = $this->db->fetch_array($result))
							{
								?>
                                 <option value="<?php echo $row['id']?>"><?php echo ucwords($row['username']);?></option>
                                <?php
							}
							?>
                            </select> 
                            </div>
          </div>
                        <div class="form-group">
                        <h4>Check List</h4>
                        <div class="col-sm-12" style="width:100%; float:left; height:92px; overflow:auto;">
                        
                        <?php
                        $sql_checkList="select * from ".HMS_CHECKLIST." where status='0' ORDER BY room_checklist_name";
                        $result_checkList = $this->db->query($sql_checkList,__FILE__,__LINE__);
                        while($row_checkList = $this->db->fetch_array($result_checkList))
                        {
                        ?>
                        <div class="radio" style="width:49%; float:left;"> 
                        <label for="ck1"> <input type="checkbox"  value="<?php echo $row_checkList['id']?>"  name="checkList[]" > <?php echo ucwords($row_checkList['room_checklist_name']);?></label> 	
                        </div>
                        <?php
                        }
                        ?>					
                        </div>
                       </div>
                       
                         <div class="form-group">
                        <h4>Any Remark</h4>
                        <div class="col-sm-12" style="width:100%; float:left; height:92px; overflow:auto;">
                        
                       <textarea name="remark" class="form-control"></textarea>				
                        </div>
                       </div>
			  <div class="form-group" style=" margin-top:25px; padding-bottom: 20px;">
                <div class="col-sm-offset-2 col-sm-10">
                 <button class="btn btn-default">Cancel</button>
				  <button type="submit" class="btn btn-primary" name="submit" value="Assign Work">Assign Work</button>
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
			
			
			
			
			$this->user_id = $user_id;
			$this->checkList = $checkList;
			$this->remark = $remark;
			
			
			
			$return = true;
			
		if($this->Form->ValidField($user_id,'empty','Please enter housekeeping name')==false)
		    $return =false;
		
		
			
			
			if($return){
							
							$insert_sql_array = array();
							$insert_sql_array['assigned_user_id'] = $this->user_id;
							$insert_sql_array['assigned_date_time'] = date('Y-m-d h:i:s');
							$insert_sql_array['room_no'] = $room_id;
							$insert_sql_array['remark'] = $this->remark;
							$this->db->insert(HMS_HKEEPING,$insert_sql_array);
							$hk_id = $this->db->last_insert_id();
							
							$update_sql_array2 = array();
							$update_sql_array2['assigned'] = 2;
							$update_sql_array2['current_hk_id'] = $hk_id;
							$this->db->update(HMS_ROOM,$update_sql_array2,'id',$room_id);
							
							
							$val=0;
							foreach($this->checkList as $k){
							$insert_sql_array1 = array();
							$insert_sql_array1['hk_id'] = $hk_id;
							$insert_sql_array1['checklist_id'] = $k;
							$this->db->insert(HMS_HKEEPING_CK_LIST,$insert_sql_array1);
							$val=0;
							}
							
						    $_SESSION['msg'] = 'Housekeeping Details has been Successfully Added';	
							?>
							<script type="text/javascript">
							window.location = 'assignhousekeeping.php?index=msg';
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->AssignUserForHouskeeping('local',$room_id);
							}
							
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
	
	
	function GetUSERNAMEbyUSerID($userId){ 
		$sql="select * from ".HMS_USER." where id='".$userId."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['username'];
	}
	
	function GetchecklistnamebyId($chkId){ 
		$sql="select * from ".HMS_CHECKLIST." where id='".$chkId."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['room_checklist_name'];
	}
	
	function ReleaseRoom($runat,$room_id,$hk_id)
	{
		switch($runat)
		{
		
			case 'local':
			$FormName = "form_release";
			            $sql="select * from ".HMS_HKEEPING." where id='".$hk_id."'";
                        $result = $this->db->query($sql,__FILE__,__LINE__);
						$row = $this->db->fetch_array($result);
			?>
            <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="addNewreal">
      <div class="col-md-8">
       <div class="block-flat">
          <div class="header">							
            <h3>Assiged Work</h3>
          </div>
          <div class="content">
           	 <div class="form-group">
			                <div class="col-sm-8">
                            <p><strong>Work Assign To: </strong><?php echo $this->GetUSERNAMEbyUSerID($row['assigned_user_id']); ?> </p>
                            <p><strong>Work Assigned Time: </strong><?php echo $row['assigned_date_time'];?></p>
                           
                            </div>
          </div>
                        <div class="form-group">
                        <h4>Check List</h4>
                        <div class="col-sm-12" style="width:100%; float:left; height:92px; overflow:auto;">
                        
                        <?php
                        $sql_checkList="select * from ".HMS_HKEEPING_CK_LIST." where hk_id='".$hk_id."'";
                        $result_checkList = $this->db->query($sql_checkList,__FILE__,__LINE__);
                        while($row_checkList = $this->db->fetch_array($result_checkList))
                        {
                        ?>
                        <div class="radio" style="width:49%; float:left;"> 
                         	<p><?php echo $this->GetchecklistnamebyId($row_checkList['checklist_id']);?></p>
                        </div>
                        <?php
                        }
                        ?>					
                        </div>
                       </div>
                       
                         
			  <div class="form-group" style=" margin-top:25px; padding-bottom: 20px;">
                <div class="col-sm-offset-2 col-sm-10">
                 <button class="btn btn-default">Cancel</button>
				  <button type="submit" class="btn btn-primary" name="submit" value="Clear Work">Clear Work</button>
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
			
			
			$return = true;
		
		
			
			
			if($return){
							
							$update_sql_array = array();
							$update_sql_array['completed_date_time'] = date('Y-m-d h:i:s');
							$update_sql_array['status'] = 'clear';
							$this->db->update(HMS_HKEEPING,$update_sql_array,'id',$hk_id);
							
							
							
							$sql="select * from ".HMS_ROOM." where id='".$room_id."'";
							$result = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($result);
				            if($row['guest_flag']==1){
							$update_sql_array2 = array();
							$update_sql_array2['assigned'] = 1;
							$update_sql_array2['current_hk_id'] = 0;
							$this->db->update(HMS_ROOM,$update_sql_array2,'id',$room_id);
							}
							else{
							$update_sql_array2 = array();
							$update_sql_array2['assigned'] = 0;
							$update_sql_array2['current_hk_id'] = 0;
							$this->db->update(HMS_ROOM,$update_sql_array2,'id',$room_id);
							}
							
							
							
							
							
						    $_SESSION['msg'] = 'Room is clean ready to use...';	
							?>
							<script type="text/javascript">
							window.location = 'assignhousekeeping.php?index=msg';
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->ReleaseRoom('local',$room_id,$hk_id);
							}
							
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
	
		
	
	
	
	
	

}