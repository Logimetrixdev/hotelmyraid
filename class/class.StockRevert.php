<?php

/* 
 * This class is responcible for the master values of Source Info
 * Author: Abhishek Kumar Mishra
 * Created Date: 15/09/2014
 */

class StockRevert
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
	
	
	
	function newRevert($runat,$transferTo)
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
       <div id="page-wrap" style="min-height:550px;">
         <h2 style="margin:0px; padding:0px; font-family:Arial, Helvetica, sans-serif;">Stock Revert From <?php if($transferTo=='BT') { echo 'Banquet'; } else { echo 'Kitchen';}?></h2>
		
		<div style="clear:both"></div>
		
		
		
		<table id="items" style="width:70% !important;">
		
		  <tr>
		      <th>Item</th>
		      <th>Product Type</th>
		      <th>Quantity</th>
		  </tr>
		  
          
		  <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr">
              <select name="product_headers[]" class="form-control" required onchange="stock_obj.getProductDetail(this.value,'<?php echo 1; ?>',{target:'product<?php echo 1; ?>'});">
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
		      <td class="description"><div  id="product<?php echo 1;?>"><select name="product_type[]" style="width:200px;" class="form-control"><option value="">-- Product Type --</option></select></div></td>
		       <td><input type="text" name="qty[]" class="form-control" /></td>
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
		      <td class="description"><div  id="product<?php echo $x;  ?>"><select name="product_type[]" style="width:200px;" class="form-control"><option value="">-- Product Type --</option></select></div></td>
		    
		      <td><input type="text" name="qty[]" class="form-control" /></div></td>
		   
           <tr   id="trbutton<?php echo $x; ?>" <?php if($x!=1){ ?> style="display:none" <?php } ?>><td colspan="5">
       <a   href="javascript:void(0);"  onclick="document.getElementById('show<?php echo $x+1; ?>').style.display=''; 
       document.getElementById('trbutton<?php echo $x; ?>').style.display='none';  document.getElementById('trbutton<?php echo $x+1; ?>').style.display='';"><img src="images/newline.png" /></a></td></tr>
          <?php 
		  
		  }
		  ?>
          
         <tr>
         <td colspan="2"></td>
    <td style="float:right; border:none;">
    <input type="submit" name="transferdata" class="btn" value="Revert Item" /></td>
  </tr> 
		</table>
		

		
	
	</div>
         </form>                          
                            <?php
							break;
							case 'server':
									extract($_POST);
						
                        // purchase ready to transfer...
						        $this->product_headers = array_values(array_filter($product_headers)); 
								$this->product_type = array_values(array_filter($product_type)); 
								$this->qty = array_values(array_filter($qty));
						// purchase product info...		
						/*echo '<pre>';
						 echo 'Headers Array:';
						 print_r($this->product_headers);
						  echo '<br />';
						 echo 'product Array:'; 
						 print_r($this->product_type);
						  echo '<br />';
						
						 echo 'product qty:'; 
						 print_r($this->qty);
													
						exit();*/
							
							//server side validation
							$return =true;
							if($return){
								if($transferTo=='BT')
								{
												$insert_sql_array = array();
												$insert_sql_array['revert_date'] = date('Y-m-d h:i:s A');
												$insert_sql_array['revert_area'] = 'banquet';
												$insert_sql_array['user_id'] = $_SESSION['user_id'];
												$insert_sql_array['last_updated'] = date('Y-m-d h:i:s A');
												$this->db->insert(HMS_REVERT_STOCK,$insert_sql_array);
												$revert_Id = $this->db->last_insert_id();
												$val=0;
												foreach($this->product_headers as $k)
												{
													$insert_sql_array1['revert_id'] = $revert_Id;
													$insert_sql_array1['header_id'] = $k;
													$insert_sql_array1['product_id'] = $this->product_type[$val];
													$insert_sql_array1['qty'] = $this->qty[$val];
													$insert_sql_array1['user_id'] = $_SESSION['user_id'];
													$insert_sql_array1['last_updated'] = date('Y-m-d h:i:s A');
													$this->db->insert(HMS_REVERT_STOCK_LIST,$insert_sql_array1);
													$this->RevertProductFromBanquet($k,$this->product_type[$val],$this->qty[$val],$issued_Id);
													$val++;
												}
												$_SESSION['msg'] = 'All product is revert to main stock';
								}
								else
								{
												$insert_sql_array = array();
												$insert_sql_array['revert_date'] = date('Y-m-d h:i:s A');
												$insert_sql_array['revert_area'] = 'kitchen';
												$insert_sql_array['user_id'] = $_SESSION['user_id'];
												$insert_sql_array['last_updated'] = date('Y-m-d h:i:s A');
												$this->db->insert(HMS_REVERT_STOCK,$insert_sql_array);
												$revert_Id = $this->db->last_insert_id();
												$val=0;
												foreach($this->product_headers as $k)
												{
													$insert_sql_array1['revert_id'] = $revert_Id;
													$insert_sql_array1['header_id'] = $k;
													$insert_sql_array1['product_id'] = $this->product_type[$val];
													$insert_sql_array1['qty'] = $this->qty[$val];
													$insert_sql_array1['user_id'] = $_SESSION['user_id'];
													$insert_sql_array1['last_updated'] = date('Y-m-d h:i:s A');
													$this->db->insert(HMS_REVERT_STOCK_LIST,$insert_sql_array1);
													$this->RevertProductFromKitchen($k,$this->product_type[$val],$this->qty[$val],$issued_Id);
													$val++;
												}
												$_SESSION['msg'] = 'All product is revert to main stock';
								}
												
												?>
												<script type="text/javascript">
												window.location='revertitems.php?index=printreceipt&revertId=<?php echo $revert_Id;?>';
												</script> 
												<?php
												exit();
								} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->newRevert('local',$transferTo);
							}
							break;
			default 	: 
							echo "Wrong Parameter passed";
							
		}
	
	}
	
	
	// RevertProductFromKitchen    Update main stock by reverting item
	function RevertProductFromKitchen($header_id,$product_id,$qty,$issued_Id)
	{
		if($product_id>0){
				
				 		$total_stock = $this->GetQtyOfaProductfromStock($product_id);
						$new_qty = $total_stock+$qty;
				        $update_sql_array = array();
						$update_sql_array['qty'] = $new_qty;
						$update_sql_array['user_id'] = $_SESSION['user_id'];
						$this->db->update(HMS_STOCK,$update_sql_array,'product_id',$product_id);
		}
				 
	}
	
	
	// RevertProductFromBanquet    Update main stock by reverting item
	function RevertProductFromBanquet($header_id,$product_id,$qty,$issued_Id)
	{
		if($product_id>0){
		             	$total_stock = $this->GetQtyOfaProductfromStock($product_id);
						$new_qty = $total_stock+$qty;
				        $update_sql_array = array();
						$update_sql_array['qty'] = $new_qty;
						$update_sql_array['user_id'] = $_SESSION['user_id'];
						$this->db->update(HMS_STOCK,$update_sql_array,'product_id',$product_id);
		}
	}
	
	
	function GetQtyOfaProductfromStock($product_id)
	{
		 $sql="select id,product_id,qty from ".HMS_STOCK." where  product_id = '".$product_id."'";
         $result= $this->db->query($sql,__FILE__,__LINE__);
		 $row = $this->db->fetch_array($result);
		 return $row['qty'];
	}
	
    function getProductDetail($header_id,$x)
	{
		ob_start();
		?>
        
            <select name="product_type[]" class="form-control" style="width:200px;"  >
	     <option value="">--  Product Type --</option>
			<?php 
            $sql="select * from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where purchase_header_id='".$header_id."' and status = 1 and delete_status=1";
            $result= $this->db->query($sql,__FILE__,__LINE__);
            while($row= $this->db->fetch_array($result))
            {
            ?>
            <option value="<?php echo $row['id']?>"><?php echo $row['product_name']?> (<?php echo $this->getUnitNameByProductId($row['id']);?>)</option>
            <?php
            }
            ?>
       </select> 
       
        <?php 
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function  getProductQty($header_id,$product_id)
	{
		ob_start();
		    $sql="select * from ".HMS_STOCK." where header_id='".$header_id."' and product_id = '".$product_id."'";
            $result= $this->db->query($sql,__FILE__,__LINE__);
			if($this->db->num_rows($result)){
            $row= $this->db->fetch_array($result);
			if($row['qty']>=1){
				 ?>
                  <select name="qty[]" class="form-control" >
                  <option value="">-- QTY --</option>
                  <?php for($i=1;$i<=$row['qty'];$i++) { ?>
                  <option value="<?php echo $i;?>"><?php echo $i;?> (<?php echo $this->getUnitNameByProductId($product_id);?>)</option>
                  <?php } ?>
                  </select>
                <?php
			}
			else{
				?><select name="qty[]" class="form-control"><option value="">-- No Qty Aval --</option></select><?php
			}}
			else
			{
				?>
                <select name="qty[]" class="form-control"><option value="">No Stock Available</option></select>
                <?php
			 }
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	
	function getUnitNameByProductId($product_id)
	{
		        $sql="select id,unit_id from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where id ='".$product_id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				$unit_name = $this->GetUnitById($row['unit_id']);
				return $unit_name;
	}
	
	
	function GetUnitById($Id)
	{
				$sql="select * from ".HMS_PURCHASE_UNITS." where id ='".$Id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['unit_type'];
	}
	
	
	function PrintRevertTicketToBanquetStock($revert_id)
	{
		?>
        <div id="print">
        <table width="100%" border="0">
        <tr>
       <td style="text-transform:capitalize;" colspan="2"><b>Revert From:</b> <?php echo $this->GetStockRevertArea($revert_id);?></td>
        </tr>
        <tr>
        <td colspan="2"><b>Date:</b> <?php echo date('l jS \of F Y h:i:s A', strtotime($this->GetStockRevertDateTime($revert_id)));?></td>
        </tr>
        </table>

        <table border="1" style="width:100% !important;"   id="items">
        <tr>
        <th>S. No.</th>
        <th>Product</th>
        <th>Quantity</th>
        </tr>
        <?php
        $sql="select * from ".HMS_REVERT_STOCK_LIST." where revert_id ='".$revert_id."'";
        $result = $this->db->query($sql,__FILE__,__LINE__);
        $i=1;
        while($row = $this->db->fetch_array($result))
        {?>
        <tr>
        <td align="center"><?php echo $i;?></td>
        <td align="center"><?php echo $this->getProductNameByProductId($row['product_id']);?></td>
        <td align="center"><?php echo $row['qty'];?> <?php echo $this->getUnitNameByProductId($row['product_id']);?></td>
        </tr>
        <?php $i++; 
		} 
		?>
        </table>
        </div>
   <?php  
}
	
	
	function GetStockRevertArea($revert_id)
	{  
		        $sql="select id,revert_area from ".HMS_REVERT_STOCK." where id ='".$revert_id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['revert_area'];
	}
	
	function GetStockRevertDateTime($revert_id)
	{
		        $sql="select id,revert_date from ".HMS_REVERT_STOCK." where id ='".$revert_id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['revert_date'];
	}
	
	function getProductNameByProductId($product_id)
	{
		        $sql="select id,product_name from ".HMS_INVENTORY_HEARDERS_CATEGORIES." where id ='".$product_id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['product_name'];
	}
	
	

}