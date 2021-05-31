<?php

/* 
 * This class is responcible for the master values of room type included in all hotel activity
 * Author: Abhishek Kumar Mishra
 * Created Date: 16/5/2014
 */

class MasterRoomTypeClass
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
	
	function New_Room_Type($case_finder)
	{
		switch($case_finder)
		{
			case 'local':
			?>
            <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="addNewRoomType">
      <div class="col-md-8">
       <div class="block-flat">
          <div class="header">							
            <h4>Add A New Room Type</h4>
          </div>
          <div class="content">
           					<div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Room Type</label> 
                            <input type="text" name="name" class="form-control" required placeholder="Type something" />
                            </div>
                             </div>
			  
			  <div class="form-group" style="padding:10px 0 10px;">
			                <div class="col-sm-8">
                            <label>Single Occupany Price</label> 
                            <input type="text" name="base_price" class="form-control" data-parsley-type="number"  required placeholder="Type something" />
                            </div>
                            
			</div>
			
			<div class="form-group" style="padding:10px 0 10px;">
			  <div class="col-sm-8">
                            <label>Double Occupany Price</label> 
                            <input type="text" name="higher_price" class="form-control" data-parsley-type="number"  required placeholder="Type something" />
                            </div>
			  </div>
              
              <div class="form-group" style="padding:10px 0 10px;">
			  <div class="col-sm-8">
                            <label>Extra Bed Room Price</label> 
                            <input type="text" name="extra_bed_price"  data-parsley-type="number" class="form-control" required placeholder="Type something" />
                            </div>
			  </div>
              
              <div class="form-group" style=" margin-top:25px;
    padding-bottom: 20px;">
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
							$this->name = $name;
							$this->base_price = $base_price;
							$this->higher_price = $higher_price;
							$this->extra_bed_price = $extra_bed_price;
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($name,'empty','Please Enter Room Type')==false)
							$return =false;
						if($this->Form->ValidField($base_price,'empty','Please Enter Single Occupancy Price')==false)
							$return =false;
						if($this->Form->ValidField($higher_price,'empty','Please Enter Double Occupancy Price')==false)
							$return =false;
						if($this->Form->ValidField($extra_bed_price,'empty','Please Enter Extra Bed Price')==false)
							$return =false;
							/* End Validation  */
						if($return){
							
							$insert_sql_array = array();
							$insert_sql_array['name'] = ucwords($this->name);
							$insert_sql_array['base_price'] = $this->base_price;
							$insert_sql_array['higher_price'] = $this->higher_price;
							$insert_sql_array['extra_bed_price'] = $this->extra_bed_price;
						    $this->db->insert(HMS_ROOM_TYPE,$insert_sql_array);
							
							$_SESSION['msg'] = 'Room Type Details has been Successfully Added';
							
							?>
							<script type="text/javascript">
								window.location = "manageroom_types.php?index=new_type"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->New_Room_Type('local');
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	
	
	
	
	function RoomTypeValuesManagement()
	{
		
		?>
                <div class="row">
				<div class="col-md-12">
					<div class="block-flat">
                    <a href="manageroom_types.php?index=new_type" class="btn btn-primary btn-flat" style="float:right;">Add New Room Type</a>
						<div class="header">
                        							
							<h4>Room Type Details</h4>
                          
						</div>
						<div class="content">
							<div class="table-responsive">
								<table class="table table-bordered" id="datatable" >
									<thead>
										<tr>
											<th>S. No.</th>
											<th>Room Type [Total Room]</th>
											<th>Single Occupancy Price</th>
											<th>Double Occupancy Price</th>
                                            <th>Extra Bed Price</th>
											<th>Operations</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
				$sql="select * from ".HMS_ROOM_TYPE." where deleted='1'";
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
											<td><strong><?php echo $row['name'];?></strong> [<?php echo $this->Master->gettotalRoomCountofRoomType($row['id']).' Rooms';?>]</td>
											<td><?php echo $row['base_price'];?></td>
											<td class="center">	<?php echo $row['higher_price'];?></td>
                                            <td class="center">	<?php echo $row['extra_bed_price'];?></td>
											<td class="center"><div class="btn-group"><button class="btn btn-default btn-xs" type="button">Actions</button><button data-toggle="dropdown" class="btn btn-xs btn-primary dropdown-toggle" type="button"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul role="menu" class="dropdown-menu pull-right"><li><a href="manageroom_types.php?index=edit_room_Type&roomTypeId=<?php echo $row['id'];?>" title="Edit">Edit</a></li>
                                       
                                            <li class="divider"></li><li> <a  href="javascript: void(0);" title="Remove" onclick="javascript: if(confirm('Do u want to delete this room type with all rooms?')) { RoomType_obj.deleteroomType('<?php echo $row['id'];?>',{}) };">Remove</a></li></ul></div></td>
										</tr>
										<?php 
							$x++;
							}
				}
				else
				{
					?>
                   					 <tr class="odd gradeX">
											<td colspan="6"><h4>Sorry! No Room Type Available</h4></td>
											
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
	
	
	function deleteroomType($id)
	{
			ob_start();
			
			/*Start deleting all related rooms related with room type Id*/
			$update_array1 = array();
			$update_array1['deleted'] = 1 ;
		    $this->db->update(HMS_ROOM,$update_array1,'room_type_id',$id);
			
			/*End deleting all related rooms related with room type Id*/
			
			/*Finallym start deleting room type with related room type Id*/
			$update_array = array();
			$update_array['deleted'] = 0 ;
		    $this->db->update(HMS_ROOM_TYPE,$update_array,'id',$id);
			/*End deleting all room type with related room type Id*/
			
			
			$_SESSION['msg']='Room Type With all related rooms has been Deleted successfully';
			
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
	
	
	
		function Edit_Room_Type($case_finder,$roomTypeId)
	{
				$sql="select * from ".HMS_ROOM_TYPE." where id ='".$roomTypeId."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
		switch($case_finder)
		{
			
			case 'local':
			?>
            <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="editRoomType">
      <div class="col-md-8">
       <div class="block-flat">
          <div class="header">							
            <h4>Edit Room Type</h4>
          </div>
          <div class="content">
           					<div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Room Type</label> 
                            <input type="text" name="name" class="form-control" value="<?php echo $row['name'];?>" required placeholder="Type something" />
                            </div>
                             </div>
			  
			  <div class="form-group" style="padding:10px 0 10px;">
			                <div class="col-sm-8">
                            <label>Single Occupany Price</label> 
                            <input type="text" name="base_price" class="form-control" value="<?php echo $row['base_price'];?>" data-parsley-type="number"  required placeholder="Type something" />
                            </div>
                            
			</div>
			
			<div class="form-group" style="padding:10px 0 10px;">
			  <div class="col-sm-8">
                            <label>Double Occupany Price</label> 
                            <input type="text" name="higher_price" class="form-control" value="<?php echo $row['higher_price'];?>" data-parsley-type="number"  required placeholder="Type something" />
                            </div>
			  </div>
              
              <div class="form-group" style="padding:10px 0 10px;">
			  <div class="col-sm-8">
                            <label>Extra Bed Room Price</label> 
                            <input type="text" name="extra_bed_price" value="<?php echo $row['extra_bed_price'];?>" data-parsley-type="number" class="form-control" required placeholder="Type something" />
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
							$this->name = $name;
							$this->base_price = $base_price;
							$this->higher_price = $higher_price;
							$this->extra_bed_price = $extra_bed_price;
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($name,'empty','Please Enter Room Type')==false)
							$return =false;
						if($this->Form->ValidField($base_price,'empty','Please Enter Single Occupancy Price')==false)
							$return =false;
						if($this->Form->ValidField($higher_price,'empty','Please Enter Double Occupancy Price')==false)
							$return =false;
						if($this->Form->ValidField($extra_bed_price,'empty','Please Enter Extra Bed Price')==false)
							$return =false;
							/* End Validation  */
						if($return){
							
							$update_sql_array = array();
							$update_sql_array['name'] = ucwords($this->name);
							$update_sql_array['base_price'] = $this->base_price;
							$update_sql_array['higher_price'] = $this->higher_price;
							$update_sql_array['extra_bed_price'] = $this->extra_bed_price;
						    $this->db->update(HMS_ROOM_TYPE,$update_sql_array,'id',$roomTypeId);
							$_SESSION['msg'] = 'Room Type Details has been Successfully Updated.';
							
							?>
							<script type="text/javascript">
								window.location = "manageroom_types.php"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->Edit_Room_Type('local',$roomTypeId);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	

}