<?php

/* 
 * This class is responcible for the master values of Source Info
 * Author: Abhishek Kumar Mishra
 * Created Date: 27/5/2014
 */

class DistributorClass
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
            <h4>Add A New Distributor</h4>
          </div>
          <div class="content">
          					
                             
           					<div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Distributor</label> 
                            <input type="text" name="distributors" class="form-control" required placeholder="Type something" />
                            </div>
                             </div>
							 <div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Email Id</label> 
                            <input type="text" name="email_id" class="form-control" required placeholder="Type something" />
                            </div>
                             </div>
							 <div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Contact No</label> 
                            <input type="text" name="contact_no" class="form-control" required placeholder="Type something" />
                            </div>
                             </div>
							 <div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Address</label> 
                            <input type="text" name="distributor_address" class="form-control" required placeholder="Type something" />
                            </div>
                             </div>
							 <div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Credit Limit</label> 
                            <input type="text" name="credit_limit" class="form-control" required placeholder="Type something" />
                            </div>
                             </div>
							 <div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Credit Limit Days</label> 
                            <input type="text" name="credit_limit_days" class="form-control" required placeholder="Type something" />
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

							$this->distributors = $distributors;
							$this->email_id = $email_id;
							$this->contact_no = $contact_no;
							$this->distributor_address = $distributor_address;
							$this->credit_limit = $credit_limit;
							$this->credit_limit_days = $credit_limit_days;
							
							
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
							if($this->Form->ValidField($distributors,'empty','Please Enter Distributors')==false)
							$return =false;
							
						
							/* End Validation  */
						if($return){
							
							$insert_sql_array = array();
							$insert_sql_array['distributors'] = $this->distributors;
							$insert_sql_array['email_id'] = $this->email_id;
							$insert_sql_array['contact_no'] = $this->contact_no;
							$insert_sql_array['distributor_address'] = $this->distributor_address;
							$insert_sql_array['credit_limit'] = $this->credit_limit;
							$insert_sql_array['credit_limit_days'] = $this->credit_limit_days;
							
							$insert_sql_array['status'] = '1';
							$insert_sql_array['deleted'] = '1';
							
						    $this->db->insert(HMS_DISTRIBUTORS,$insert_sql_array);
							
							$_SESSION['msg'] = 'Distributor Type has been Successfully Added';
							
							?>
							<script type="text/javascript">
								window.location = "distributor.php"
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
	
	
	
	
	function DistributorManagement()
	{
		
		?>
                <div class="row">
				<div class="col-md-12">
					<div class="block-flat">
                    <a href="distributor.php?index=new_type" class="btn btn-primary btn-flat" style="float:right;">Add New</a>
						<div class="header">
                        							
							<h4>Distributor List</h4>
                          
						</div>
						<div class="content">
							<div class="table-responsive">
								<table class="table table-bordered" id="datatable" >
									<thead>
										<tr>
											<th>S. No.</th>
											<th>Distributor's</th>
											<th>Address</th>
											<th>Email</th>
											<th>Contact No</th>
											<th>Credit Limit</th>
											<th>Credit Limit Days</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
				$sql="select * from ".HMS_DISTRIBUTORS." where deleted=1";
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
											<td><?php echo $row['distributors'];?></td>
											<td><div style="width:180px; height:80px; overflow:auto">
											<?php echo $row['distributor_address'];?></div></td>
											<td><?php echo $row['email_id'];?></td>
											<td><?php echo $row['contact_no'];?></td>
											<td><?php echo $row['credit_limit'];?></td>
											<td><?php echo $row['credit_limit_days'];?></td>
											<td class="center"><div class="btn-group"><button class="btn btn-default btn-xs" type="button">Actions</button><button data-toggle="dropdown" class="btn btn-xs btn-primary dropdown-toggle" type="button"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul role="menu" class="dropdown-menu pull-right"><li><a href="distributor.php?index=edit_source_Type&sourceId=<?php echo $row['id'];?>" title="Edit">Edit</a></li>
                                       
                                            <li class="divider"></li><li> <a  href="javascript: void(0);" title="Remove" onClick="javascript: if(confirm('Do u want to delete this Distributor?')) { distributor_obj.deletedistributor('<?php echo $row['id'];?>',{}) };">Remove</a></li></ul></div></td>
										</tr>
										<?php 
							$x++;
							}
				}
				else
				{
					?>
                   					 <tr class="odd gradeX">
											<td colspan="7"><h4>Sorry! No Event Type  Available</h4></td>
											
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
	
	
	
	
	function deletedistributor($id)
	{
			ob_start();
			
			/*Start deleting all related rooms related with room type Id*/
			$update_array1 = array();
			$update_array1['deleted'] = 0 ;
		    $this->db->update(HMS_DISTRIBUTORS,$update_array1,'id',$id);
			
			/*End deleting all related rooms related with room type Id*/
			
			
			
			$_SESSION['msg']='Distributor has been Deleted successfully';
			
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
				$sql="select * from ".HMS_DISTRIBUTORS." where id ='".$sourceId."'";
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
                            <label>Distributor</label> 
                            <input type="text" name="distributors" value="<?php echo $row['distributors'];?>" class="form-control" required placeholder="Type something" />
                            </div>
                             </div>
							 <div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Email Id</label> 
                            <input type="text" name="email_id" value="<?php echo $row['email_id'];?>" class="form-control" required placeholder="Type something" />
                            </div>
                             </div>
							 <div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Contact No</label> 
                            <input type="text" name="contact_no" value="<?php echo $row['contact_no'];?>" class="form-control" required placeholder="Type something" />
                            </div>
                             </div>
							 <div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Address</label> 
                            <input type="text" name="distributor_address" value="<?php echo $row['distributor_address'];?>" class="form-control" required placeholder="Type something" />
                            </div>
                             </div>
							 <div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Credit Limit</label> 
                            <input type="text" name="credit_limit" value="<?php echo $row['credit_limit'];?>" class="form-control" required placeholder="Type something" />
                            </div>
                             </div>
							 <div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Credit Limit Days</label> 
                            <input type="text" name="credit_limit_days" value="<?php echo $row['credit_limit_days'];?>" class="form-control" required placeholder="Type something" />
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
							$this->distributors = $distributors;
							$this->email_id = $email_id;
							$this->contact_no = $contact_no;
							$this->distributor_address = $distributor_address;
							$this->credit_limit = $credit_limit;
							$this->credit_limit_days = $credit_limit_days;
							
							
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
							if($this->Form->ValidField($distributors,'empty','Please Enter Distributors')==false)
							$return =false;
							
						
							/* End Validation  */
						if($return){
							
							$update_sql_array = array();
							$update_sql_array['distributors'] = $this->distributors;
							$update_sql_array['email_id'] = $this->email_id;
							$update_sql_array['contact_no'] = $this->contact_no;
							$update_sql_array['distributor_address'] = $this->distributor_address;
							$update_sql_array['credit_limit'] = $this->credit_limit;
							$update_sql_array['credit_limit_days'] = $this->credit_limit_days;
							
							
							 $this->db->update(HMS_DISTRIBUTORS,$update_sql_array,'id',$sourceId);
							$_SESSION['msg'] = 'Distributor Detail has been Successfully Updated.';
							
							?>
							<script type="text/javascript">
								window.location = "distributor.php"
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