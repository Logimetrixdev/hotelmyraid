<?php

/* 
 * This class is responcible for the banquet Menus.
 * Author: Abhishek Kumar Mishra
 * Created Date: 24/08/2014
 */
 

class BanquetMenus
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
			<form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="addNewMenuHeader">
				<div class="col-md-10">
               <div class="block-flat">
                <a href="banquet_menus.php" class="btn btn-primary btn-flat" style="float:right;">View Banquet Menu</a>
            
						<div class="header">							
						<h4>Add A New Banquet Menu Header</h4>
						</div>
					<div class="content">
							<div class="form-group">
							<div class="col-sm-8">
							<label>Menu Header</label> 
							<input type="text" name="header_name" class="form-control"  required placeholder="Type something"  />
							</div>
							</div>
							
							<div class="form-group">
							<div class="col-sm-8">
							<label>Max Allowed Items</label> 
                            <select data-parsley-type="number" name="max_allowed" class="form-control"  required>
                            <option value=""> ----- No Of Item Allowed ---- </option>
                            <?php
							for($i=1;$i<=15;$i++)
							{
								?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php
							}
							?>
                            </select>
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
							$this->header_name = $header_name;
							$this->max_allowed = $max_allowed;
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($header_name,'empty','Please Enter A Menu Header')==false)
							$return =false;
						if($this->Form->ValidField($max_allowed,'empty','Please Select Max Allowed Quantity')==false)
							$return =false;
						/* End Validation  */
			
				
						if($return){
							
							$insert_sql_array = array();
							$insert_sql_array['header_name'] = ucwords($this->header_name);
							$insert_sql_array['max_allowed'] = $this->max_allowed;
							 $this->db->insert(HMS_BANQUETS_MENU_HEADER,$insert_sql_array);
							
							$_SESSION['msg'] = 'Menu header has been Successfully Added';
							
							?>
							<script type="text/javascript">
								window.location = "banquet_menus.php?index=new_item"
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
	
	
	function New_Item_In_Category($case_finder)
	{
		switch($case_finder)
		{
			case 'local':
			?>
			<form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="addNewRoom">
				<div class="col-md-10">
              <div class="block-flat">
                 <a href="banquet_menus.php" class="btn btn-primary btn-flat" style="float:right;">View Banquet Menu</a>
				 	<div class="header">							
						<h4>Add A New Item</h4>
						</div>
					<div class="content">
							<div class="form-group">
							<div class="col-sm-8">
							<label>Menu Header</label> 
							<select name="header_id" class="form-control" required>
							<option value="">--- Select Menu Header ---</option>
							<?php
							$sql_header="select * from ".HMS_BANQUETS_MENU_HEADER." where deleted='1' and status='1'";
							$result_header = $this->db->query($sql_header,__FILE__,__LINE__);
							while($row_header = $this->db->fetch_array($result_header))
							{
							?>
							<option value="<?php echo $row_header['id'];?>"><?php echo $row_header['header_name'];?></option>
							<?php
							}
							?>
							</select>
							</div>
							</div>
							
                            
                            <div class="form-group">
							<div class="col-sm-8">
							<label>Item Name</label> 
                            <input  type="text" name="item" class="form-control"  required/>
                           </div>
							</div>
                            
							
						<div class="form-group" style=" margin-top:25px; padding-bottom: 20px;">
						<div class="col-sm-offset-2 col-sm-10">
						<button class="btn btn-default">Cancel</button>
						<button type="submit" class="btn btn-primary" name="submited" value="Save Info">Save Info</button>
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
							$this->header_id = $header_id;
							$this->item = $item;
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($header_id,'empty','Please Pick Any Header Type')==false)
							$return =false;
						if($this->Form->ValidField($item,'empty','Please Enter Item Name')==false)
							$return =false;
						/* End Validation  */
			
				
						if($return){
							
							$insert_sql_array = array();
							$insert_sql_array['header_id'] = $this->header_id;
							$insert_sql_array['item'] = ucwords($this->item);
							$this->db->insert(HMS_BANQUET_MENU,$insert_sql_array);
							$_SESSION['msg'] = 'Menu item is added in menu header successfully';
							?>
							<script type="text/javascript">
								window.location = "banquet_menus.php"
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->New_Item_In_Category('local');
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	
	
	
	
	
	
    function EditItems($case_finder,$item_id)
	{
		switch($case_finder)
		{
			case 'local':
			     $sql_item = "select * from ".HMS_BANQUET_MENU." where id='".$item_id."'";
							$result_item = $this->db->query($sql_item,__FILE__,__LINE__);
							$row_item = $this->db->fetch_array($result_item);
			?>
			<form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="edititem">
				<div class="col-md-10">
              <div class="block-flat">
                 <a href="banquet_menus.php" class="btn btn-primary btn-flat" style="float:right;">View Banquet Menu</a>
				 	<div class="header">							
						<h4>Edit Item</h4>
						</div>
					<div class="content">
							<div class="form-group">
							<div class="col-sm-8">
							<label>Menu Header</label> 
							<select name="header_id" class="form-control" required>
							<option value="">--- Select Menu Header ---</option>
							<?php
							$sql_header="select * from ".HMS_BANQUETS_MENU_HEADER." where deleted='1' and status='1'";
							$result_header = $this->db->query($sql_header,__FILE__,__LINE__);
							while($row_header = $this->db->fetch_array($result_header))
							{
							?>
							<option value="<?php echo $row_header['id'];?>" <?php if($row_item['header_id']==$row_header['id']) { echo 'selected';} ?>><?php echo $row_header['header_name'];?></option>
							<?php
							}
							?>
							</select>
							</div>
							</div>
							
                            
                            <div class="form-group">
							<div class="col-sm-8">
							<label>Item Name</label> 
                            <input  type="text" name="item" class="form-control" value="<?php echo $row_item['item'];?>"  required/>
                           </div>
							</div>
                            
							
						<div class="form-group" style=" margin-top:25px; padding-bottom: 20px;">
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
							$this->header_id = $header_id;
							$this->item = $item;
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($header_id,'empty','Please Pick Any Header Type')==false)
							$return =false;
						if($this->Form->ValidField($item,'empty','Please Enter Item Name')==false)
							$return =false;
						/* End Validation  */
			
				
						if($return){
							
							$update_sql_array = array();
							$update_sql_array['header_id'] = $this->header_id;
							$update_sql_array['item'] = ucwords($this->item);
						$this->db->update(HMS_BANQUET_MENU,$update_sql_array,'id',$item_id);
							$_SESSION['msg'] = 'Menu item is updated in menu header successfully';
							?>
							<script type="text/javascript">
								window.location = "banquet_menus.php?index=editItem&itemId=<?php echo $item_id?>";
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->EditItems('local',$item_id);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	
	
	
	
	
	function EditHeader($case_finder,$MenuHeaderId)
	{
		switch($case_finder)
		{
			case 'local':
				            $sql_item = "select * from ".HMS_BANQUETS_MENU_HEADER." where id='".$MenuHeaderId."'";
							$result_item = $this->db->query($sql_item,__FILE__,__LINE__);
							$row_item = $this->db->fetch_array($result_item);
			
			?>
			<form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="editNewMenuHeader">
				<div class="col-md-10">
               <div class="block-flat">
                <a href="banquet_menus.php" class="btn btn-primary btn-flat" style="float:right;">View Banquet Menu</a>
            
						<div class="header">							
						<h4>Edit Banquet Menu Header</h4>
						</div>
					<div class="content">
							<div class="form-group">
							<div class="col-sm-8">
							<label>Menu Header</label> 
							<input type="text" name="header_name" class="form-control"  required placeholder="Type something"  value="<?php echo $row_item['header_name']?>" />
							</div>
							</div>
							
							<div class="form-group">
							<div class="col-sm-8">
							<label>Max Allowed Items</label> 
                            <select data-parsley-type="number"  name="max_allowed" class="form-control"  required>
                            <option value=""> ----- No Of Item Allowed ---- </option>
                            <?php
							for($i=1;$i<=15;$i++)
							{
								?>
                                <option value="<?php echo $i;?>" <?php if($row_item['max_allowed']==$i) { echo 'selected';} ?>><?php echo $i;?></option>
                                <?php
							}
							?>
                            </select>
                         	</div>
							</div>
						<div class="form-group" style=" margin-top:25px; padding-bottom: 20px;">
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
							$this->header_name = $header_name;
							$this->max_allowed = $max_allowed;
							
						/*Start Server Side Validation from here it works when javascript validation is failed*/
								$return =true;
						if($this->Form->ValidField($header_name,'empty','Please Enter A Menu Header')==false)
							$return =false;
						if($this->Form->ValidField($max_allowed,'empty','Please Select Max Allowed Quantity')==false)
							$return =false;
						/* End Validation  */
			
				
						if($return){
							
							$update_sql_array = array();
							$update_sql_array['header_name'] = ucwords($this->header_name);
							$update_sql_array['max_allowed'] = $this->max_allowed;
							$this->db->update(HMS_BANQUETS_MENU_HEADER,$update_sql_array,'id',$MenuHeaderId);
							
							$_SESSION['msg'] = 'Menu header has been Successfully updated';
							
							?>
							<script type="text/javascript">
								window.location = "banquet_menus.php?index=editMenuHeader&headerId=<?php echo $MenuHeaderId?>";
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->EditHeader('local',$MenuHeaderId);
							}	
			
			break;
			default:
			  echo "Sorry! Wroung Argumnet is passed.";
			  break;
		}
	}
	
	
	
	function AllBanquetMenuList()
	{
		
		?>
                <div class="row">
				<div class="col-md-12">
					<div class="block-flat">
                      <a href="banquet_menus.php?index=new_header" class="btn btn-primary btn-flat" style="float:right;">Add New Menu Header</a>
                    <a href="banquet_menus.php?index=new_item" class="btn btn-primary btn-flat" style="float:right;">Add New Item In Menu</a>
						<div class="header">
                        	<h4>Banquet Menu</h4>
                       </div>
						<div class="content">
							<div class="table-responsive">
								<table class="table table-bordered" id="datatable" >
									<thead>
										<tr>
											<th width="10%"><b>S. No.</b></th>
											<th width="25%"><b>Menu Headers(Allowed for Selection)</b></th>
											<th width="35%"><b>Items</b></th>
										    <th width="15%"><b>Operations</b></th>
										</tr>
									</thead>
									<tbody>
                                    <?php
				$sql="select * from ".HMS_BANQUETS_MENU_HEADER." where status='1' and deleted='1' order by id";
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
											<td><?php echo $row['header_name'];?> <b>(Any <?php echo $row['max_allowed'];?>)</b></td>
											<td class="center">
                                           <?php
											$sql_bitem="select * from ".HMS_BANQUET_MENU." where header_id='".$row['id']."'";
											$result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
											$cntval = $this->db->num_rows($result_bitem);
											if($cntval>0)
											{
												?>
                                                <p>
                                                <?php
												while($row_bitem = $this->db->fetch_array($result_bitem))
												{
													?>
                                                    <a href="banquet_menus.php?index=editItem&itemId=<?php echo $row_bitem['id'];?>" class="fancybox fancybox.iframe">
                                                    <img src="images/edit.png" style="height:20px; margin-right:5px; cursor:pointer;" title="Edit This Item"></a>
                                                    <img src="images/trash.png" style="height:20px; margin-right:10px; cursor:pointer;" title="Remove This Item" onclick="javascript: if(confirm('Do u want to delete this item from this header?')) { banquet_obj.deleteitem('<?php echo $row_bitem['id'];?>',{}) };">
                                                    <?php
													echo '<b>'.$row_bitem['item'].'</b>';
													echo '<br />';
												}
												?>
                                                </p>
                                                <?php
											}
											else
											{
												
												?>
                                                <p> No Item found in this header</p>
                                                <?php
											}
											
											?>
											
											
                                            
                                            </td>
                                             <td class="center"><div class="btn-group"><button class="btn btn-default btn-xs" type="button">Actions</button>
												<button data-toggle="dropdown" class="btn btn-xs btn-primary dropdown-toggle" type="button"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul role="menu" class="dropdown-menu pull-right">
						<li><a href="banquet_menus.php?index=editMenuHeader&headerId=<?php echo $row['id'];?>" class="fancybox fancybox.iframe" title="Edit">Edit</a></li>
                        <li class="divider"></li><li> <a  href="javascript: void(0);" title="Remove Header" onclick="javascript: if(confirm('If you remove this header it will remove all items as well?')) { banquet_obj.deleteheader('<?php echo $row['id'];?>',{}) };" >Remove</a></li></ul></div></td>
										</tr>
										<?php 
							$x++;
							}
				}
				else
				{
					?>
                   					 <tr class="odd gradeX">
											<td colspan="5"><h4>No Menu Headers is found!!!</h4></td>
											
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
	
	function deleteitem($id)
	{
			ob_start();
			
			/*Start deleting  related items related with  Id*/
			$update_array = array();
			$update_array['deleted'] = 0 ;
		
			$this->db->update(HMS_BANQUET_MENU,$update_array,'id',$id);
			/*End deleting  related items related with  Id*/
			$_SESSION['msg']='Item  has been Deleted successfully';
			
			?>
			<script type="text/javascript">
				location.reload(true);
			</script>
			<?php
			
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	
	function deleteheader($id)
	{
			ob_start();
			
			/*Start deleting  related header related with  Id*/
			$update_array = array();
			$update_array['deleted'] = 0 ;
			$this->db->update(HMS_BANQUETS_MENU_HEADER,$update_array,'id',$id);
			
			$sql_bitem="select * from ".HMS_BANQUET_MENU." where header_id='".$id."'";
			$result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
			while($row_bitem = $this->db->fetch_array($result_bitem))
			{
				$update_array = array();
				$update_array['deleted'] = 0 ;
				$this->db->update(HMS_BANQUET_MENU,$update_array,'id',$row_bitem['id']);
			}
			
			/*End deleting  related items related with  Id*/
			$_SESSION['msg']='Menu Header and Items  has been Deleted successfully';
			
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