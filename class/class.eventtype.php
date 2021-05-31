<?php

/* 
 * This class is responcible for the master values of Source Info
 * Author: Abhishek Kumar Mishra
 * Created Date: 27/5/2014
 */

class MasterEventTypeClass
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
	
	function New_Type($case_finder)
	{
		switch($case_finder)
		{
			case 'local':
			?>
            <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="addNewRoomType">
      <div class="col-md-8">
       <div class="block-flat">
          <div class="header">							
            <h4>Add A New Event Type</h4>
          </div>
          <div class="content">
          					
                             
           					<div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Event Type</label> 
                            <input type="text" name="event" class="form-control" required placeholder="Type something" />
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
							$this->event = $event;
							
							
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($event,'empty','Please Enter Event Type')==false)
							$return =false;
						
							/* End Validation  */
						if($return){
							
							$insert_sql_array = array();
							$insert_sql_array['event'] = $this->event;
							$insert_sql_array['status'] = '1';
							$insert_sql_array['deleted'] = '1';
							
						    $this->db->insert(HMS_EVENT_TYPE,$insert_sql_array);
							
							$_SESSION['msg'] = 'Event Type has been Successfully Added';
							
							?>
							<script type="text/javascript">
								window.location = "eventtype.php"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->New_Type('local');
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	
	
	
	
	function EventValuesManagement()
	{
		
		?>
                <div class="row">
				<div class="col-md-12">
					<div class="block-flat">
                    <a href="eventtype.php?index=new_type" class="btn btn-primary btn-flat" style="float:right;">Add New</a>
						<div class="header">
                        							
							<h4>Event Type</h4>
                          
						</div>
						<div class="content">
							<div class="table-responsive">
								<table class="table table-bordered" id="datatable" >
									<thead>
										<tr>
											<th>S. No.</th>
											<th>Event Type</th>
											
										</tr>
									</thead>
									<tbody>
                                    <?php
				$sql="select * from ".HMS_EVENT_TYPE." where deleted=1";
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
											<td><?php echo $row['event'];?></td>
											
											<td class="center"><div class="btn-group"><button class="btn btn-default btn-xs" type="button">Actions</button><button data-toggle="dropdown" class="btn btn-xs btn-primary dropdown-toggle" type="button"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul role="menu" class="dropdown-menu pull-right"><li><a href="eventtype.php?index=edit_source_Type&sourceId=<?php echo $row['id'];?>" title="Edit">Edit</a></li>
                                       
                                            <li class="divider"></li><li> <a  href="javascript: void(0);" title="Remove" onClick="javascript: if(confirm('Do u want to delete this Event?')) { Event_obj.deleteevent('<?php echo $row['id'];?>',{}) };">Remove</a></li></ul></div></td>
										</tr>
										<?php 
							$x++;
							}
				}
				else
				{
					?>
                   					 <tr class="odd gradeX">
											<td colspan="5"><h4>Sorry! No Event Type  Available</h4></td>
											
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
	
	
	function MarketPlaceByMarketPlaceId($id)
	{
		        $sql_room_type = "select * from ".HMS_MARKET_PLACE." where id='".$id."'";
				$result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
				$row_room_type = $this->db->fetch_array($result_room_type);
				return $row_room_type['name'];
				
	}
	
	function deleteevent($id)
	{
			ob_start();
			
			/*Start deleting all related rooms related with room type Id*/
			$update_array1 = array();
			$update_array1['deleted'] = 0 ;
		    $this->db->update(HMS_EVENT_TYPE,$update_array1,'id',$id);
			
			/*End deleting all related rooms related with room type Id*/
			
			
			
			$_SESSION['msg']='Event Type has been Deleted successfully';
			
			?>
			<script type="text/javascript">
				location.reload(true);
			</script>
			<?php
			
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	
	
	
	
	
		function Edit_Type($case_finder,$sourceId)
	{
				$sql="select * from ".HMS_EVENT_TYPE." where id ='".$sourceId."'";
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
            <h4>Edit Event Type</h4>
          </div>
          <div class="content">
           					
                             
           					<div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Event Type</label> 
                            <input type="text" name="event" value="<?php echo $row['event']?>" class="form-control" required placeholder="Type something" />
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
							$this->event = $event;
							
						
							
						
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($event,'empty','Please Enter Event Type')==false)
							$return =false;
						
						
							/* End Validation  */
						if($return){
							
							$update_sql_array = array();
							$update_sql_array['event'] = $this->event;
							 $this->db->update(HMS_EVENT_TYPE,$update_sql_array,'id',$sourceId);
							$_SESSION['msg'] = 'Event Type has been Successfully Updated.';
							
							?>
							<script type="text/javascript">
								window.location = "eventtype.php"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->Edit_Type('local',$sourceId);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	

}