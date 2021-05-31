<?php

/* 
 * This class is responcible for the master values of Source Info
 * Author: Abhishek Kumar Mishra
 * Created Date: 30/08/2014
 */

class Stock
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
	
	function StockList()
	{
		
		?>
                <div class="row">
				<div class="col-md-12">
					<div class="block-flat">
                    <a href="addstock.php" class="btn btn-primary btn-flat" style="float:right;">Add New Purchase List</a>
                 	<div class="header" style="padding-bottom:55px;">
                        	<h4>Updated Stock</h4>
                            <div class="btn-group" style="float:right;">
                            <strong>Transfer Stock To:</strong><br />
                            <button class="btn btn-default btn-xs" type="button">-- Stock Transfer --</button><button data-toggle="dropdown" class="btn btn-xs btn-primary dropdown-toggle" type="button"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul role="menu" class="dropdown-menu pull-right">
                         <li><a href="issueitems.php?index=transfer_banquet" class="fancybox fancybox.iframe" title="Issued To Banquet">Issued To Banquet</a></li>
                           <li><a href="issueitems.php?index=transfer_kitchen" class="fancybox fancybox.iframe" title="Issued To Kitchen">Issued To Kitchen</a></li>
                         <li><a href="revertitems.php?index=revert_banquet" class="fancybox fancybox.iframe" title="Revert From Banquet">Revert From Banquet</a></li>
                       
                         <li><a href="revertitems.php?index=revert_kitchen" class="fancybox fancybox.iframe" title="Revert From Kitchen">Revert From Kitchen</a></li>
                         </ul>
                                         </div>
                      </div>
						<div class="content">
							<div class="table-responsive">
								<table class="table table-bordered" id="datatable" >
									<thead>
										<tr>
											<th><strong>S. No.</strong></th>
											<th><strong>Product Header</strong></th>
											<th><strong>Product Name</strong></th>
											<th><strong>Quantity Available</strong></th>
                                            <th><strong>Min Stock Level</strong></th>
                                       </tr>
									</thead>
									<tbody>
                                    <?php
				$sql="select * from ".HMS_STOCK." order by last_updated";
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
											<td><?php echo $this->getheaderNameByHeaderId($row['header_id']);?></td>
											<td><?php echo $this->getProductNameByProductId($row['product_id']);?></td>
                                            <td><?php echo $row['qty'].' '.$this->getUnitNameByProductId($row['product_id']);?></td>
                                            <td>
                                            <?php 
											if($row['qty'] > $this->getProductMinimumLevel($row['product_id'])){?>
                                            <img src="img/sucess.png"  style="height:23px; cursor:pointer" title="<?php echo  'Minimum Stock: '.$this->getProductMinimumLevel($row['product_id']).' '.$this->getUnitNameByProductId($row['product_id']);?>"/> [<?php echo  'Minimum Stock: '.$this->getProductMinimumLevel($row['product_id']).' '.$this->getUnitNameByProductId($row['product_id']);?>]
                                            <?php } 
                                            elseif($row['qty'] < $this->getProductMinimumLevel($row['product_id'])) { ?>
                                            <img src="img/danger.png" style="height:23px; cursor:pointer" title="<?php echo  'Minimum Stock: '.$this->getProductMinimumLevel($row['product_id']).' '.$this->getUnitNameByProductId($row['product_id']);?>"/> [<?php echo  'Minimum Stock: '.$this->getProductMinimumLevel($row['product_id']).' '.$this->getUnitNameByProductId($row['product_id']);?>]
                                            <?php } else { ?>
                                            <img src="img/warning.png" style="height:23px; cursor:pointer" title="<?php echo  'Minimum Stock: '.$this->getProductMinimumLevel($row['product_id']).' '.$this->getUnitNameByProductId($row['product_id']);?>"/> [<?php echo  'Minimum Stock: '.$this->getProductMinimumLevel($row['product_id']).' '.$this->getUnitNameByProductId($row['product_id']);?>]
                                            <?php } ?>
                                            </td>
											
										</tr>
										<?php 
							$x++;
							}
				}
				else
				{
					?>
                   					 <tr class="odd gradeX">
											<td colspan="5"><h4>Sorry! No Stock  Available</h4></td>
											
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
	
	
	function getheaderNameByHeaderId($header_id)
	{
		        $sql="select id,purchase_header from ".HMS_INVENTORY_HEARDERS." where id ='".$header_id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['purchase_header'];
	}
	
	function getProductNameByProductId($product_id)
	{
		        $sql="select id,product_name from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where id ='".$product_id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['product_name'];
	}
	
	function getUnitNameByProductId($product_id)
	{
		        $sql="select id,unit_id from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where id ='".$product_id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				$unit_name = $this->GetUnitById($row['unit_id']);
				return $unit_name;
	}
	
	function getProductMinimumLevel($product_id)
	{
		        $sql="select id,low_level from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where id ='".$product_id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['low_level'];
	}
	
	
	
	
	
	function newPurchase($runat)
	{
		switch($runat)
		{
			case 'local':
			$FormName = "frm_banners";
						$ControlNames=array("client_id"=>array('client_id',"''","Kindly select a client..","span_client_id"),
											"amount_paid"=>array('amount_paid',"''","Kindly enter an amount..","span_amount_paid")
											
						 );

						$ValidationFunctionName="CheckbannersValidity";
					
						$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
						echo $JsCodeForFormValidation;
		?>
        
        <form name="<?php echo $FormName; ?>" enctype="multipart/form-data" action=""  method="post">
       <div id="page-wrap">
         <div id="identity" >
		 <select name="dealers" class="form-control" style="width:29%;" onchange="stock_obj.getDistributorDeatils(this.value,{target:'distributor_details'});" required>
         <option value="">-- Select Distributor --</option>
          <?php
			  $sql_dis="select * from ".HMS_DISTRIBUTORS." where 1";
			  $result_dis = $this->db->query($sql_dis,__FILE__,__LINE__);
			  while($row_dis = $this->db->fetch_array($result_dis))
			  {
				  ?>
         <option value="<?php echo $row_dis['id'];?>"><?php echo $row_dis['distributors'];?></option>
         <?php
			  }
		  ?>
         </select>
         </div>
		
		<div style="clear:both"></div>
		
		<div id="customer" style="margin-top:25px !important;">
             <div id="distributor_details" style="width:240px; float:left;">
            <textarea  style="border:1px solid #666; height:75px; width:230px" name="clientaddress" ></textarea>
            </div>

            <table id="meta" >
                <tr>
                    <td class="meta-head">Date</td>
                    <td style="border-right:1px solid black;"><textarea id="date">December 15, 2009</textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td style="border-right:1px solid black;"><div class="due">Rs 0.00</div></td>
                </tr>

            </table>
		
		</div>
		
		<table id="items">
		
		  <tr>
		      <th style="color:#FFF;">Item</th>
		      <th style="color:#FFF;">Product Type</th>
		      <th width="17%" style="color:#FFF;">Unit Cost</th>
		      <th style="color:#FFF;">Quantity</th>
		      <th style="color:#FFF;">Price</th>
		  </tr>
		  
          
		  <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr">
              <select name="product_headers[]" class="form-control" required onchange="stock_obj.getProductDetail(this.value,'<?php echo 0; ?>',{target:'product<?php echo 0; ?>'});">
              <option value=""> -- Headers --</option>
              <?php
			 $sql="select * from ".HMS_INVENTORY_HEARDERS." where delete_status='1' and status='1'";
			  $result = $this->db->query($sql,__FILE__,__LINE__);
			  while($row = $this->db->fetch_array($result))
			  {
				  ?>
                   <option value="<?php echo $row['id']?>"><?php echo $row['purchase_header']?></option>
                  <?php
			  }
			  ?>
              </select>
              <a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><div  id="product<?php echo 0;?>"><select name="product_type[]" class="form-control"><option value="">-- Product Type --</option></select></div></td>
		      <td><div id="rate<?php echo 0;?>" ><input type="text" name="cost[]" placeholder="0.00" class="cost form-control" /></div></td>
		      <td><input type="text" name="qty[]" class="qty form-control" /></td>
		      <td><span class="price">Rs 0.00</span><span class="price_cost"></span></td>
		  </tr>
		  
		  
		
		   <?php for($x=1;$x<=50;$x++) 
		  {
			  
			  ?>
      
       
           <tr class="item-row" style="display:none;" id="show<?php echo $x; ?>">
		     <td class="item-name"><div class="delete-wpr">
              <select name="product_headers[]" class="form-control" onchange="stock_obj.getProductDetail(this.value,<?php echo $x;?>,{target:'product<?php echo $x; ?>'});">
              <option value=""> -- Headers --</option>
              <?php
			  $sql="select * from ".HMS_INVENTORY_HEARDERS." where delete_status='1' and status='1'";
			  $result = $this->db->query($sql,__FILE__,__LINE__);
			  while($row = $this->db->fetch_array($result))
			  {
				  ?>
                   <option value="<?php echo $row['id']?>"><?php echo $row['purchase_header']?></option>
                  <?php
			  }
			  ?>
              </select>
              <a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><div  id="product<?php echo $x;  ?>"><select name="product_type[]" class="form-control"><option value="">-- Product Type --</option></select></div></td>
		      <td><div id="rate<?php echo $x;  ?>" ><input type="text" name="cost[]" placeholder="0.00" class="cost form-control" /></div></td>
		      <td><input type="text" name="qty[]" class="qty form-control" /></td>
		      <td ><span class="price">Rs 0.00</span><span class="price_cost"></span></td></tr>
         
           <tr   id="trbutton<?php echo $x; ?>" <?php if($x!=1){ ?> style="display:none" <?php } ?>><td colspan="5" style="border-right:1px solid black;">
       <a   href="javascript:void(0);"  onclick="document.getElementById('show<?php echo $x+1; ?>').style.display=''; 
       document.getElementById('trbutton<?php echo $x; ?>').style.display='none';  document.getElementById('trbutton<?php echo $x+1; ?>').style.display='';"><img src="images/newline.png" /></a></td></tr>
          <?php 
		  
		  }
		  ?>
          
          
		  <!--<tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal">Rs 0.00</div></td>
		  </tr>-->
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value" style="border-right:1px solid black;"><div id="total">Rs 0.00</div> <input type="hidden" id="overallamount" name="overallamount" value="0"/></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line" >Amount Paid</td>

		      <td class="total-value" style="border-right:1px solid black;"><input type="text" id="paid" class="form-control" name="paidamount"  /></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line balance" style="color:#FFF;">Balance Due</td>
		      <td class="total-value balance" style="color:#FFF;border-right:1px solid black;"><div class="due">Rs 0.00</div> <input type="hidden" id="dueamount" name="dueamount" value="0"/></td>
		  </tr>
		
		</table>
		
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;">
  <tr>
    <td colspan="2" style="float:right; border:none; color:#FFF;"><input type="reset" name="purchasereset" class="btn" value="Reset" />
    <input type="submit" name="purchasedata" class="btn" value="Save Item" /></td>
  </tr>
</table>

		
	
	</div>
         </form>                          
                            <?php
							break;
							case 'server':
									extract($_POST);
									
						// Client Details on server side code value //
								$this->dealers=$dealers;
								$this->clientaddress=$clientaddress;
						// Client Details on server side code value //
                        // purchase product info...
						        $this->product_headers = @array_values(@array_filter($product_headers)); 
								$this->product_type = @array_values(@array_filter($product_type)); 
								$this->cost = @array_values(@array_filter($cost));
								$this->qty = @array_values(@array_filter($qty));
								$this->priceval = @array_values(@array_filter($priceval));
						        $this->overallamount = $overallamount;
								$this->paidamount = $paidamount;
								$this->dueamount = $dueamount;
						// purchase product info...		
						/*echo '<pre>';
						 echo 'Headers Array:';
						 print_r($this->product_headers);
						  echo '<br />';
						 echo 'product Array:'; 
						 print_r($this->product_type);
						  echo '<br />';
						 echo 'product Cost:'; 
						 print_r($this->cost);
						  echo '<br />';
						 echo 'product qty:'; 
						 print_r($this->qty);
						 echo 'product Amt:'; 
						 print_r($this->priceval);
						 echo '</pre>';
							echo 'overallamount:'; 
							echo $this->overallamount;
							echo '<br />';
							echo 'Paid Amount:'; 
							echo $this->paidamount;
							echo '<br />';
							echo ' Amount Due:'; 
							echo $this->dueamount;
							echo '<br />';
							
						exit();*/
							
							//server side validation
							$return =true;
								if($this->Form->ValidField($dealers,'empty','Please Select Dealer name')==false)
								$return =false;
								if($this->Form->ValidField($paidamount,'empty','Please enter amount paid')==false)
								$return =false;
							  	
								
								
								
								
							if($return){
								
												$insert_sql_array = array();
												$insert_sql_array['distributor_id'] = $this->dealers;
												$insert_sql_array['total_amount'] = $this->overallamount;
												$insert_sql_array['paid_amount'] = $this->paidamount;
												$insert_sql_array['due_amount'] = $this->dueamount;
												$insert_sql_array['puchase_date'] = date("Y-m-d");
												$insert_sql_array['user_id'] = $_SESSION['user_id'];
												$this->db->insert(HMS_PURCHSES,$insert_sql_array);
												$purchase_Id = $this->db->last_insert_id();
												$val=0;
												foreach($this->product_headers as $k)
												{
													$insert_sql_array1['puchase_id'] = $purchase_Id;
													$insert_sql_array1['header_id'] = $k;
													$insert_sql_array1['product_id'] = $this->product_type[$val];
													$insert_sql_array1['cost'] = $this->cost[$val];
													$insert_sql_array1['qty'] = $this->qty[$val];
													$insert_sql_array1['amount'] = $this->priceval[$val];
													$insert_sql_array1['puchase_date'] = date("Y-m-d");
													$insert_sql_array1['user_id'] = $_SESSION['user_id'];
													$this->db->insert(HMS_PURCHSE_LIST,$insert_sql_array1);
													$this->UpdateProductCostOnPurchase($k,$this->product_type[$val],$this->cost[$val]);
													$this->UpdateProductStockByQuantity($k,$this->product_type[$val],$this->qty[$val]);
													$val++;
												}
												
												$_SESSION['msg'] = 'New Purchase Item is updated in your stock';
												?>
												<script type="text/javascript">
													alert('New Purchase List Is updated in Stock Successfully')
													<?php /*?>location.reload(true);<?php */?>
													window.location.href="addstock.php";
												</script> 
												<?php
												exit();
								} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->newPurchase('local');
							}
							break;
			default 	: 
							echo "Wrong Parameter passed";
							
		}
	
	}
	
	function UpdateProductStockByQuantity($header_id,$product_id,$qty)
	{
		    $sql="select id,header_id,product_id,qty from ".HMS_STOCK." where header_id='".$header_id."' and product_id = '".$product_id."'";
            $result= $this->db->query($sql,__FILE__,__LINE__);
			if($this->db->num_rows($result)>0){
						$row = $this->db->fetch_array($result);
						$new_qty = $row['qty']+$qty;
						$update_sql_array = array();
						$update_sql_array['qty'] = $new_qty;
						$update_sql_array['user_id'] = $_SESSION['user_id'];
						$update_sql_array['last_updated'] = date('Y-m-d h:i:s A');
						$this->db->update(HMS_STOCK,$update_sql_array,'product_id',$product_id);
			}
			else{
												$insert_sql_array = array();
												$insert_sql_array['header_id'] = $header_id;
												$insert_sql_array['product_id'] = $product_id;
												$insert_sql_array['qty'] = $qty;
												$insert_sql_array['user_id'] = $_SESSION['user_id'];
												$insert_sql_array['last_updated'] = date('Y-m-d h:i:s A');
												$this->db->insert(HMS_STOCK,$insert_sql_array);
			}
	}
	function UpdateProductCostOnPurchase($header_id,$product_id,$product_cost)
	{
			$sql="select id,purchase_header_id,cost from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where purchase_header_id='".$header_id."' and id = '".$product_id."'";
            $result= $this->db->query($sql,__FILE__,__LINE__);
            $row= $this->db->fetch_array($result);
			if($row['cost']!=$product_cost){
				$update_sql_array = array();
				$update_sql_array['cost'] = $product_cost;
				$this->db->update(HMS_INVENTORY_HEARDERS_CATEGORIES,$update_sql_array,'id',$product_id);
			}
	}
	
    function getProductDetail($header_id,$x)
	{
		ob_start();
		
		?>
        
            <select name="product_type[]" class="form-control" onchange="stock_obj.getProductCost('<?php echo $header_id ?>',this.value,{target:'rate<?php echo $x; ?>'});">
	     <option value="">-- Select Product --</option>
			<?php 
            $sql="select * from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where purchase_header_id='".$header_id."' and status = 1 and delete_status=1";
            $result= $this->db->query($sql,__FILE__,__LINE__);
            while($row= $this->db->fetch_array($result))
            {
            ?>
            <option value="<?php echo $row['id']?>"><?php echo $row['product_name']?></option>
            <?php
            }
            ?>
       </select>
       
        <?php 
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	function  getProductCost($header_id,$product_id)
	{
		ob_start();
		    $sql="select id,purchase_header_id,cost,unit_id from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where purchase_header_id='".$header_id."' and id = '".$product_id."'";
            $result= $this->db->query($sql,__FILE__,__LINE__);
            $row= $this->db->fetch_array($result);
			
			?>
            <input type="text" name="cost[]" class="cost form-control" value="<?php echo $row['cost'];?>" style="width:67px; float:left;" /> - <?php echo $this->GetUnitById($row['unit_id']);
          
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	
	function GetUnitById($Id)
	{
				$sql="select * from ".HMS_PURCHASE_UNITS." where id ='".$Id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['unit_type'];
	}
	
	function getDistributorDeatils($dist_id)
	{
		$sql="select * from ".HMS_DISTRIBUTORS." where id ='".$dist_id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		ob_start();
		if($dist_id>0 and isset($dist_id)){
		?>
		<textarea    style="border:1px solid #666; height:75px; width:230px" name="clientaddress"><?php echo $row['distributor_address'];?></textarea>
		<?php } else{ ?>
			<textarea  style="border:1px solid #666; height:75px; width:230px" name="clientaddress"></textarea>
		<?php  }
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	

}