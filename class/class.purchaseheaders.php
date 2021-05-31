<?php

/* 
 * This class is responcible for the master values of purchase headers included in all hotel activity
 * Author: Abhishek Kumar Mishra
 * Created Date: 05/7/2014
 */

class MasterPurchaseHeaderClass
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
	
	function New_Purchase_Header($case_finder)
	{
		switch($case_finder)
		{
			case 'local':
			?>
            <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="addNewRoomType">
      <div class="col-md-8">
       <div class="block-flat">
       	<a style="float:right;" class="btn btn-primary btn-flat" href="purchase_headers.php">View All Headers</a>
          <div class="header">							
            <h4>Add A New Purchase Header</h4>
          </div>
          <div class="content">
           					<div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Purchase Header</label> 
                            <input type="text" name="purchase_header" class="form-control" required placeholder="Type something" />
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
							$this->purchase_header = $purchase_header;
							
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($purchase_header,'empty','Please Enter Purchase Header')==false)
							$return =false;
					
							/* End Validation  */
						if($return){
							
							$insert_sql_array = array();
							$insert_sql_array['purchase_header'] = ucwords($this->purchase_header);
							$insert_sql_array['user_id'] = $_SESSION['user_id'];
							$this->db->insert(HMS_INVENTORY_HEARDERS,$insert_sql_array);
							
							$_SESSION['msg'] = 'Header Details has been Successfully Added';
							
							?>
							<script type="text/javascript">
								window.location = "purchase_headers.php?index=add"
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
	
	
	
	function Gettotalcount($headerId)
	{
				$sql="select * from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where purchase_header_id='".$headerId."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$cnt = $this->db->num_rows($result);
				return $cnt;
	}

	function PurchaseHeadersManagement()
	{
		
		?>
                <div class="row">
				<div class="col-md-12">
					<div class="block-flat">
                    <a href="purchase_headers.php?index=add" class="btn btn-primary btn-flat" style="float:right;">Add New Header</a>
						<div class="header">
                        							
							<h4>Header Details</h4>
                          
						</div>
						<div class="content">
							<div class="table-responsive">
								<table class="table table-bordered" id="datatable" >
									<thead>
										<tr>
											<th>S. No.</th>
											<th>Purchase Headers</th>
											<th>Total Product</th>
											<th>Operations</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
				$sql="select * from ".HMS_INVENTORY_HEARDERS." where delete_status='1' and status='1'";
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
											<td><?php echo $row['purchase_header'];?></td>
											<td> Total Product Count: <?php echo $this->Gettotalcount($row['id']);?></td>
											
											<td class="center"><div class="btn-group"><button class="btn btn-default btn-xs" type="button">Actions</button><button data-toggle="dropdown" class="btn btn-xs btn-primary dropdown-toggle" type="button"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul role="menu" class="dropdown-menu pull-right">
												<li><a href="purchase_headers.php?index=edit&headerid=<?php echo $row['id'];?>" title="Edit">Edit</a></li>
                                       
                                            <li class="divider"></li><li> <a  href="javascript: void(0);" title="Block">Block</a></li></ul></div></td>
										</tr>
										<?php 
							$x++;
							}
				}
				else
				{
					?>
                   					 <tr class="odd gradeX">
											<td colspan="6"><h4>Sorry! No Purchase Header Available</h4></td>
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
	
	
	
		function Edit_Purchase_Header($case_finder,$headerId)
	{
				$sql="select * from ".HMS_INVENTORY_HEARDERS." where id ='".$headerId."'";
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
            <h4>Edit Header</h4>
          </div>
          <div class="content">
           					<div class="form-group" style="padding:10px 0 10px;">
                            <div class="col-sm-8">
                            <label>Edit Purchase Header</label> 
                            <input type="text" name="purchase_header" class="form-control" value="<?php echo $row['purchase_header'];?>" required placeholder="Type something" />
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
							$this->purchase_header = $purchase_header;
							
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($purchase_header,'empty','Please Enter Purchase header')==false)
							$return =false;
						
							/* End Validation  */
						if($return){
							
							$update_sql_array = array();
							$update_sql_array['purchase_header'] = ucwords($this->purchase_header);
							$update_sql_array['user_id'] = $_SESSION['user_id'];
							
						    $this->db->update(HMS_INVENTORY_HEARDERS,$update_sql_array,'id',$headerId);
							$_SESSION['msg'] = 'Header Details has been Successfully Updated.';
							
							?>
							<script type="text/javascript">
								window.location = "purchase_headers.php"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->Edit_Purchase_Header('local',$headerId);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	

}