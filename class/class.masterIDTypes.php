<?php

/* 
 * This class is responcible for the master values of ID Types.
 * Author: Abhishek Kumar Mishra
 * Created Date: 26/5/2014
 */
 

class MasterIDTypeClass
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
	
	function New_IDtype($case_finder)
	{
		switch($case_finder)
		{
			case 'local':
			?>
            <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="addNew_IDtype">
      <div class="col-md-8">
       <div class="block-flat">
          <div class="header">							
            <h4>Add A New Room</h4>
          </div>
          <div class="content">
           	 <div class="form-group" style="padding:10px 0 10px;">
			                <div class="col-sm-8">
                            <label>ID Type</label> 
                           <input type="text" name="name" class="form-control"   required placeholder="Type something"  />
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
							$this->name = $name;
						
							
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($name,'empty','Please enter Id Type')==false)
							$return =false;
						
						
							/* End Validation  */
							
				$sql = "select * from ".HMS_IDENTY." where name='".$this->name."'";
				$record = $this->db->query($sql,__FILE__,__LINE__);
				$cnt = $this->db->num_rows($record);
				if($cnt>0)
				{
					$_SESSION['error_msg'] = 'ID type already exists';
					?>
                    <script type="text/javascript">
							window.location = 'manageIdType.php?index=new_type';
							</script>
                    <?php
					exit();
				}
				
						if($return){
							
							$insert_sql_array = array();
							$insert_sql_array['name'] = ucwords($this->name);
							 $this->db->insert(HMS_IDENTY,$insert_sql_array);
							
							$_SESSION['msg'] = 'ID Type has been Successfully Added';
							
							?>
							<script type="text/javascript">
								window.location = "manageIdType.php"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->New_IDtype('local');
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	
	
	
	
	function IDTypeValuesManagement()
	{
		
		?>
                <div class="row">
				<div class="col-md-12">
					<div class="block-flat">
                    <a href="manageIdType.php?index=new_type" class="btn btn-primary btn-flat" style="float:right;">Add New ID Type</a>
						<div class="header">
                        							
							<h4>ID Type Details</h4>
                          
						</div>
						<div class="content">
							<div class="table-responsive">
								<table class="table table-bordered" id="datatable" >
									<thead>
										<tr>
											<th>S. No.</th>
											<th>ID Type</th>
											
                                           <th>Operations</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
				$sql="select * from ".HMS_IDENTY." where deleted='0'";
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
											
											<td><?php echo $row['name'];?></td>
											
                                            
											<td class="center"><div class="btn-group"><button class="btn btn-default btn-xs" type="button">Actions</button><button data-toggle="dropdown" class="btn btn-xs btn-primary dropdown-toggle" type="button"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul role="menu" class="dropdown-menu pull-right"><li><a href="manageIdType.php?index=edit_IdType&idTypeID=<?php echo $row['id'];?>" title="Edit">Edit</a></li>
                                       
                                            <li class="divider"></li><li> <a  href="javascript: void(0);" title="Remove" onclick="javascript: if(confirm('Do u want to delete this ID Type?')) { IDType_obj.deleteIDtype('<?php echo $row['id'];?>',{}) };">Remove</a></li></ul></div></td>
										</tr>
										<?php 
							$x++;
							}
				}
				else
				{
					?>
                   					 <tr class="odd gradeX">
											<td colspan="5"><h4>Sorry! No ID Type  Available</h4></td>
											
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
	
	
	function deleteIDtype($id)
	{
			ob_start();
			
			$update_array = array();
			$update_array['deleted'] = 1 ;
		
			$this->db->update(HMS_IDENTY,$update_array,'id',$id);
		
			$_SESSION['msg']='ID Type has been successfully deleted';
			
			?>
			<script type="text/javascript">
				location.reload(true);
			</script>
			<?php
			
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	
	
	
	
	
		
	
	
	
	function Edit_IDType($case_finder,$IdTyepId)
	{
				$sql="select * from ".HMS_IDENTY." where id ='".$IdTyepId."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
		switch($case_finder)
		{
			
			case 'local':
			?>
            <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="editIDType">
            <div class="col-md-8">
       <div class="block-flat">
          <div class="header">							
            <h4>Edit ID Type</h4>
          </div>
          <div class="content">
           	<div class="form-group" style="padding:10px 0 10px;">
			                <div class="col-sm-8">
                            <label>ID Type</label> 
                           <input type="text" name="name" class="form-control"  value="<?php echo $row['name']?>"  required placeholder="Type something"  />
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
							
							
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($name,'empty','Please enter ID Type')==false)
							$return =false;
						
					
							/* End Validation  */
						if($return){
							
							$update_sql_array = array();
							$update_sql_array['name'] = ucwords($this->name);
							
							
						    $this->db->update(HMS_IDENTY,$update_sql_array,'id',$IdTyepId);
							$_SESSION['msg'] = 'Id Type has been Successfully Updated.';
							
							?>
							<script type="text/javascript">
								window.location = "manageIdType.php"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->Edit_IDType('local',$IdTyepId);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	

}