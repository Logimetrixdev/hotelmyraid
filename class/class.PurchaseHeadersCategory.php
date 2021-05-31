<?php

/* 
 * This class is responcible for the master values of rooms.
 * Author: Abhishek Kumar Mishra
 * Created Date: 06/07/2014
 */
 

class PurchaseHeadersCategory
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
	
	function New_Header_Category($case_finder)
	{
		switch($case_finder)
		{
			case 'local':
			?>
			<form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="addNewRoom">
				<div class="col-md-10">
				<div class="block-flat">
						<div class="header">							
						<h4>Add A New Header Category</h4>
						</div>
					<div class="content">
							<div class="form-group">
							<div class="col-sm-8">
							<label>Header</label> 
							<select name="purchase_header_id" class="form-control" required>
							<option value="">--- Select Header Type ---</option>
							<?php
							$sql_header="select * from ".HMS_INVENTORY_HEARDERS." where delete_status='1' and status='1'";
							$result_header = $this->db->query($sql_header,__FILE__,__LINE__);
							while($row_header = $this->db->fetch_array($result_header))
							{
							?>
							<option value="<?php echo $row_header['id'];?>"><?php echo $row_header['purchase_header'];?></option>
							<?php
							}
							?>
							</select>
							</div>
							</div>
							<div class="form-group">
							<div class="col-sm-8">
							<label>Unit Type</label> 
							<select name="unit_id" class="form-control" required>
							<option value="">--- Select Unit Type ---</option>
							<?php
							$sql_unit="select * from ".HMS_PURCHASE_UNITS." where delete_status='1' and status='1'";
							$result_unit = $this->db->query($sql_unit,__FILE__,__LINE__);
							while($row_unit = $this->db->fetch_array($result_unit))
							{
							?>
							<option value="<?php echo $row_unit['id'];?>"><?php echo $row_unit['unit_type'];?></option>
							<?php
							}
							?>
							</select>
							</div>
							</div>
							<div class="form-group" style="padding:10px 0 10px;">
							<div class="col-sm-8">
							<label>Product Name</label> 
							<input type="text" name="product_name" class="form-control"  required placeholder="Type something"  />
							</div>
							</div>
                            <div class="form-group" style="padding:10px 0 10px;">
							<div class="col-sm-8">
							<label>Min Level Of Product</label> 
							<input type="text" name="low_level"  data-parsley-type="number" class="form-control"  required placeholder="Type something"  />
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
							$this->purchase_header_id = $purchase_header_id;
							$this->unit_id = $unit_id;
							$this->product_name = $product_name;
							$this->low_level = $low_level;
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($purchase_header_id,'empty','Please Select Product Header')==false)
							$return =false;
						if($this->Form->ValidField($unit_id,'empty','Please Select Unit Type')==false)
							$return =false;
						if($this->Form->ValidField($product_name,'empty','Please Enter Product Name')==false)
							$return =false;
						if($this->Form->ValidField($low_level,'empty','Please Enter Minimum Product Level')==false)
							$return =false;
						/* End Validation  */
				$sql = "select * from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where purchase_header_id='".$this->purchase_header_id."' and unit_id='".$this->unit_id."' and product_name='".$this->product_name."' ";
				$record = $this->db->query($sql,__FILE__,__LINE__);
				$cnt = $this->db->num_rows($record);
				if($cnt>0)
				{
					$_SESSION['error_msg'] = 'This Product is already exits in select header and unit type';
					?>
                    <script type="text/javascript">
							window.location = 'purchase_headers_category.php?index=new_header_category';
							</script>
                    <?php
					exit();
				}
				
						if($return){
							$insert_sql_array = array();
							$insert_sql_array['purchase_header_id'] = $this->purchase_header_id;
							$insert_sql_array['unit_id'] = $this->unit_id;
							$insert_sql_array['product_name'] = $this->product_name;
							$insert_sql_array['low_level'] = $this->low_level;
							
						    $this->db->insert(HMS_INVENTORY_HEARDERS_CATEGORIES,$insert_sql_array);
							
							$_SESSION['msg'] = 'Product Details has been Successfully Added';
							
							?>
							<script type="text/javascript">
								window.location = "purchase_headers_category.php?index=new_header_category"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->New_Header_Category('local');
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	
	
	
	
	function AllPurchaseHeaderCategory()
	{
		
		?>
                <div class="row">
				<div class="col-md-12">
					<div class="block-flat">
                    <a href="purchase_headers_category.php?index=new_header_category" class="btn btn-primary btn-flat" style="float:right;">Add New Category In Header</a>
						<div class="header">
                        							
							<h4>Header Category Details</h4>
                          
						</div>
						<div class="content">
							<div class="table-responsive">
								<table class="table table-bordered" id="datatable" >
									<thead>
										<tr>
											<th width="10%">S. No.</th>
											<th width="25%">Headers Category</th>
											<th width="35%">Product</th>
											<th width="15%">Unit Type</th>
                                            <th width="15%">Minium Level</th>
                                           <th width="15%">Operations</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
				$sql="select * from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where status='1' and delete_status='1'";
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
											<td><?php echo $this->GetHeaderById($row['purchase_header_id']);?></td>
											<td><?php echo $row['product_name'];?></td>
											<td class="center"><?php echo $this->GetUnitById($row['unit_id'])?></td>
                                            <td><?php echo $row['low_level'];?></td>
                                            
											<td class="center"><div class="btn-group"><button class="btn btn-default btn-xs" type="button">Actions</button>
												<button data-toggle="dropdown" class="btn btn-xs btn-primary dropdown-toggle" type="button"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul role="menu" class="dropdown-menu pull-right">
												<li><a href="purchase_headers_category.php?index=edit_header_category&categoryId=<?php echo $row['id'];?>" title="Edit">Edit</a></li>
                                       
                                            <li class="divider"></li><li> <a  href="javascript: void(0);" title="Remove" >Remove</a></li></ul></div></td>
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
	

	function GetUnitById($Id)
	{
				$sql="select * from ".HMS_PURCHASE_UNITS." where id ='".$Id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['unit_type'];
	}

	function GetHeaderById($Id)
	{
				$sql="select * from ".HMS_INVENTORY_HEARDERS." where id ='".$Id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['purchase_header'];
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
	
	
	
		
	
	
	
	function Edit_Header_Category($case_finder,$CatId)
	{
				$sql="select * from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where id ='".$CatId."'";
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
            <h4>Edit Header Product Details</h4>
          </div>
          <div class="content">
           					<div class="form-group">
							<div class="col-sm-8">
							<label>Edit Header</label> 
							<select name="purchase_header_id" class="form-control" required>
							<option value="">--- Select Header Type ---</option>
							<?php
							$sql_header="select * from ".HMS_INVENTORY_HEARDERS." where delete_status='1' and status='1'";
							$result_header = $this->db->query($sql_header,__FILE__,__LINE__);
							while($row_header = $this->db->fetch_array($result_header))
							{
							?>
							<option value="<?php echo $row_header['id'];?>" <?php if($row['purchase_header_id']==$row_header['id']) { echo 'selected';} ?>><?php echo $row_header['purchase_header'];?></option>
							<?php
							}
							?>
							</select>
							</div>
							</div>
							<div class="form-group">
							<div class="col-sm-8">
							<label>Edit Unit Type</label> 
							<select name="unit_id" class="form-control" required>
							<option value="">--- Select Unit Type ---</option>
							<?php
							$sql_unit="select * from ".HMS_PURCHASE_UNITS." where delete_status='1' and status='1'";
							$result_unit = $this->db->query($sql_unit,__FILE__,__LINE__);
							while($row_unit = $this->db->fetch_array($result_unit))
							{
								//echo $row['unit_id'].'matched'.$row_unit['id']
							?>
							<option value="<?php echo $row_unit['id'];?>" <?php if($row['unit_id']==$row_unit['id']) { echo 'selected';} ?>><?php echo $row_unit['unit_type'];?></option>
							<?php
							}
							?>
							</select>
							</div>
							</div>
							<div class="form-group" style="padding:10px 0 10px;">
							<div class="col-sm-8">
							<label>Edit Product Name</label> 
							<input type="text" name="product_name" class="form-control"  value="<?php echo $row['product_name']?>"  required placeholder="Type something"  />
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
						$this->purchase_header_id = $purchase_header_id;
							$this->unit_id = $unit_id;
							$this->product_name = $product_name;
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($purchase_header_id,'empty','Please Select Product Header')==false)
							$return =false;
						if($this->Form->ValidField($unit_id,'empty','Please Select Unit Type')==false)
							$return =false;
						if($this->Form->ValidField($product_name,'empty','Please Enter Product Name')==false)
							$return =false;
						/* End Validation  */
				$sql = "select * from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where purchase_header_id='".$this->purchase_header_id."' and unit_id='".$this->unit_id."' and product_name='".$this->product_name."' and id!='".$CatId."' ";
				$record = $this->db->query($sql,__FILE__,__LINE__);
				$cnt = $this->db->num_rows($record);
				if($cnt>0)
				{
					$_SESSION['error_msg'] = 'This Product is already exits in select header and unit type';
					?>
                    <script type="text/javascript">
							window.location = 'purchase_headers_category.php?index=edit_header_category&categoryId=<?php echo $CatId;?>';
							</script>
                    <?php
					exit();
				}
						if($return){
							
							$update_sql_array = array();
							$update_sql_array['purchase_header_id'] = $this->purchase_header_id;
							$update_sql_array['unit_id'] = $this->unit_id;
							$update_sql_array['product_name'] = $this->product_name;
							
						    $this->db->update(HMS_INVENTORY_HEARDERS_CATEGORIES,$update_sql_array,'id',$CatId);
							$_SESSION['msg'] = 'Product Details has been Successfully Updated.';
							
							?>
							<script type="text/javascript">
								window.location = "purchase_headers_category.php?index=edit_header_category&categoryId=<?php echo $CatId;?>"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->Edit_Header_Category('local',$CatId);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	

}