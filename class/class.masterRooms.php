<?php

/* 
 * This class is responcible for the master values of rooms.
 * Author: Abhishek Kumar Mishra
 * Created Date: 22/5/2014
 */
 

class MasterRoomsClass
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
	
	function New_Room($case_finder)
	{
		switch($case_finder)
		{
			case 'local':
			?>
            <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="addNewRoom">
      <div class="col-md-8">
       <div class="block-flat">
          <div class="header">							
            <h4>Add A New Room</h4>
          </div>
          <div class="content">
           					<div class="form-group">
                            <div class="col-sm-8">
                            <label>Room Type</label> 
                            <select name="room_type_id" class="form-control" required>
                            <option value="">--- Select Room Type ---</option>
							<?php
                            $sql_room_type="select * from ".HMS_ROOM_TYPE." where deleted='1'";
                            $result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
                            while($row_room_type = $this->db->fetch_array($result_room_type))
                            {
                            ?>
                            <option value="<?php echo $row_room_type['id'];?>"><?php echo $row_room_type['name'];?></option>
                            <?php
                            }
                            ?>
                            </select>
                            
                            </div>
                             </div>
			  
			  <div class="form-group" style="padding:10px 0 10px;">
			                <div class="col-sm-8">
                            <label>Room No.</label> 
                            <b>(Only Room no.)</b> <input type="text" name="room_no" class="form-control" data-parsley-type="number"  required placeholder="Type something"  />
                            </div>
                            
			</div>
			
			
              
              
              
              <div class="form-group" style=" margin-top:25px; padding-bottom: 20px;">
                <div class="col-sm-offset-2 col-sm-10">
                 <button class="btn btn-default">Cancel</button>
				  <button type="submit" class="btn btn-primary" name="submit" value="Save Info">Save Info</button>
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
							$this->room_type_id = $room_type_id;
							$this->room_no = $room_no;
							
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($room_type_id,'empty','Please Select Room Type')==false)
							$return =false;
						if($this->Form->ValidField($room_no,'empty','Please Enter Room Number')==false)
							$return =false;
						
							/* End Validation  */
							
				$sql = "select * from ".HMS_ROOM." where room_no='".$this->room_no."'";
				$record = $this->db->query($sql,__FILE__,__LINE__);
				$cnt = $this->db->num_rows($record);
				if($cnt>0)
				{
					$_SESSION['error_msg'] = 'Room number already exists';
					?>
                    <script type="text/javascript">
							window.location = 'managerooms.php?index=new_type';
							</script>
                    <?php
					exit();
				}
				
						if($return){
							
							$insert_sql_array = array();
							$insert_sql_array['room_type_id'] = $this->room_type_id;
							$insert_sql_array['room_no'] = $this->room_no;
							
						    $this->db->insert(HMS_ROOM,$insert_sql_array);
							
							$_SESSION['msg'] = 'Room Details has been Successfully Added';
							
							?>
							<script type="text/javascript">
								window.location = "managerooms.php"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->New_Room('local');
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	
	
	
	
	function RoomsValuesManagement()
	{
		
		?>
                <div class="row">
				<div class="col-md-12">
					<div class="block-flat">
                    <a href="managerooms.php?index=new_type" class="btn btn-primary btn-flat" style="float:right;">Add New Room</a>
						<div class="header">
                        							
							<h4>Room Details</h4>
                          
						</div>
						<div class="content">
							<div class="table-responsive">
								<table class="table table-bordered" id="datatable" >
									<thead>
										<tr>
											<th>S. No.</th>
											<th>Room Type</th>
											<th>Room No.</th>
											<th>Status</th>
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
											<td class="center">	<?php if($row['status']==1) { echo 'Active';} else { echo 'Block';}?></td>
                                            
											<td class="center"><div class="btn-group"><button class="btn btn-default btn-xs" type="button">Actions</button><button data-toggle="dropdown" class="btn btn-xs btn-primary dropdown-toggle" type="button"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul role="menu" class="dropdown-menu pull-right"><li><a href="managerooms.php?index=edit_room&roomId=<?php echo $row['id'];?>" title="Edit">Edit</a></li>
                                       
                                            <li class="divider"></li><li> <a  href="javascript: void(0);" title="Remove" onclick="javascript: if(confirm('Do u want to delete this room?')) { Rooms_obj.deleteroom('<?php // echo $row['id'];?>',{}) };">Remove</a></li></ul></div></td>
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
			</div>
        <?php
	}
	
	
	function deleteroom($id)
	{
			ob_start();
			
			/*Start deleting all related rooms related with room type Id*/
			$update_array = array();
			$update_array['deleted'] = 1 ;
		
			$this->db->update(HMS_ROOM,$update_array,'id',$id);
			/*End deleting all related rooms related with room type Id*/
			
			
			
			$_SESSION['msg']='Room  has been Deleted successfully';
			
			?>
			<script type="text/javascript">
				location.reload(true);
			</script>
			<?php
			
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	
	
	
	function blockRoomType($id)
	{
		ob_start();
		
		$update_array = array();
		$update_array['status'] = 0 ;
		
		$this->db->update(HMS_ROOM_TYPE,$update_array,'id',$id);
		
		$_SESSION['msg']='This Room type has been Blocked successfully';
		
		?>
		<script type="text/javascript">
			window.location = "<?php $_SERVER['PHP_SELF'];?>"
		</script>
		<?php
		
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function unblockRoomType($id)
	{
		ob_start();
		
		$update_array = array();
		$update_array['status'] = 1;
		
		$this->db->update(HMS_ROOM_TYPE,$update_array,'id',$id);
		
		$_SESSION['msg']='This Room type has been Un-Blocked successfully';
		
		?>
		<script type="text/javascript">
			window.location = "<?php $_SERVER['PHP_SELF'];?>"
		</script>
		<?php
		
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	
		
	
	
	
	function Edit_Room($case_finder,$roomId)
	{
				$sql="select * from ".HMS_ROOM." where id ='".$roomId."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
		switch($case_finder)
		{
			
			case 'local':
			?>
            <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="editRoom">
            <div class="col-md-8">
       <div class="block-flat">
          <div class="header">							
            <h4>Edit Room Details</h4>
          </div>
          <div class="content">
           					<div class="form-group">
                            <div class="col-sm-8">
                            <label>Room Type</label> 
                            <select name="room_type_id" class="form-control" required>
                            <option value="">--- Select Room Type ---</option>
							<?php
                            $sql_room_type="select * from ".HMS_ROOM_TYPE." where 1";
                            $result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
                            while($row_room_type = $this->db->fetch_array($result_room_type))
                            {
                            ?>
                            <option value="<?php echo $row_room_type['id'];?>" <?php if($row_room_type['id']==$row['room_type_id']) { echo 'selected="selected"';}?>><?php echo $row_room_type['name'];?></option>
                            <?php
                            }
                            ?>
                            </select>
                            
                            </div>
                             </div>
			  
			  <div class="form-group" style="padding:10px 0 10px;">
			                <div class="col-sm-8">
                            <label>Room No.</label> 
                            <b>(Only Room no.)</b> <input type="text" name="room_no" value="<?php echo $row['room_no'];?>" class="form-control" data-parsley-type="number"  required placeholder="Type something"  />
                            </div>
                            
			</div>
			
			
              
              
              
              <div class="form-group" style=" margin-top:25px;
    padding-bottom: 20px;">
                <div class="col-sm-offset-2 col-sm-10">
                 <button class="btn btn-default">Cancel</button>
				  <button type="submit" class="btn btn-primary" name="submited" value="Edit Info">Edit Info</button>
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
							$this->room_type_id = $room_type_id;
							$this->room_no = $room_no;
							
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($room_type_id,'empty','Please Select Room Type')==false)
							$return =false;
						if($this->Form->ValidField($room_no,'empty','Please Enter Room Number')==false)
							$return =false;
					
							/* End Validation  */
						if($return){
							
							$update_sql_array = array();
							$update_sql_array['room_type_id'] = $this->room_type_id;
							$update_sql_array['room_no'] = $this->room_no;
							
						    $this->db->update(HMS_ROOM,$update_sql_array,'id',$roomId);
							$_SESSION['msg'] = 'Room  Details has been Successfully Updated.';
							
							?>
							<script type="text/javascript">
								window.location = "managerooms.php"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->Edit_Room('local',$roomId);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	

}