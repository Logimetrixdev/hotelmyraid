
<?php
 /***********************************************************************************

Class Discription : This class will handle the creation of invoice and show the invoices and printing layout of the invoice
************************************************************************************/

class Invoice{
	
	 var $user_id;
	 var $user;
	 var $type;
	 var $password;
	 var $db;
	 var $validity;
	 var $Form;
	 var $new_pass;
	 var $confirm_pass;
	 var $auth;
	 
	 
	function __construct(){
		$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
					$this->validity = new ClsJSFormValidation();
					$this->Form = new ValidateForm();
					$this->auth=new Authentication();
					$this->noti=new Notification();
	}
	

		function deleteinvoice($id)
	{
			ob_start();
		
		$sql="delete from ".TBL_BILLING_PRE." where id='".$id."'";
		$this->db->query($sql,__FILE__,__LINE__);
		
		$sql="delete from ".TBL_BILLING_MAIN." where billid='".$id."'";
		$this->db->query($sql,__FILE__,__LINE__);
		
		$_SESSION['msg']='Invoice has been Deleted successfully';
		
		?>
		<script type="text/javascript">
			window.location = "showinvoice.php"
		</script>
		<?php
		
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	//this function is returns the product price according to the sell Type and product name
		 function getProductRate($sell_type,$pid)
	 {	
	 
	 	ob_start();
		 $sql="select * from ".INFINITE_PRODUCT_DETAIL." where product_id='".$pid."'";
		$result= $this->db->query($sql,__FILE__,__LINE__);
		$row= $this->db->fetch_array($result);
		 ?>
         <input name="unit_price[]" readonly="readonly" style="width:100px" class="cost" value="<?php if($sell_type=='bundel' or $sell_type=='kg') echo $row['bundel_price']; else echo $row['pices_price'];  ?>" type="text">
         <?php 
		 $html = ob_get_contents();
		ob_end_clean();
		return $html;
	 }
	
	//This function is returns the products according to the selltype
	
	
	function getProductDetail($sell_type,$x='')
	{
		ob_start();
		$sell_typeforPrice = $sell_type;
		if($sell_type=='bundel' or $sell_type=='piece')
		{
		$sell_type='bundel';
		}
		
		
		?>
        
        <select   name="product[]"  onchange="invoice_obj.getProductRate('<?php echo $sell_typeforPrice ?>',this.value,{target:'rate<?php echo $x; ?>'});" class="" style="width:200px">
				<option selected="selected" value="">- Select a Product-</option>
    			<?php 
				$status = 'active';
		$sql="select * from ".INFINITE_PRODUCT_DETAIL." where sell_type='".$sell_type."' and status='".$status."'";
		$result= $this->db->query($sql,__FILE__,__LINE__);
		while($row= $this->db->fetch_array($result))
		{
				?>
       <option value="<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; if($sell_typeforPrice == 'bundel' or $sell_typeforPrice == 'kg') echo '('.$row['total_stock'].')'; else  echo '('.$row['total_no_of_pices'].')'; ?></option> 
      <?php } ?>
       </select>
        <?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	//This function is returns the Client Address In newInvoice(); 
	function address($client_id)
	{
		ob_start();
		 $sql = "select * from ".INFINITE_CLIENT." where id ='".$client_id."'";
		$result= $this->db->query($sql,__FILE__,__LINE__);
		$row= $this->db->fetch_array($result);
		?>
        <textarea  readonly="readonly" id="customer-title" style="overflow:auto; height:100px; width:250px;"><?php echo $row['client_address']; ?></textarea>
        <?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	

	//This is the function of generating Invoice PAGE NAME  --- create_invocie.php
	function newInvoice($runat)
	{
		switch($runat)
		{
			case 'local':
			 $FormName = "frm_invoice";
						$ControlNames=array("client_id" =>array('client_id',"''","Please Select a client.","span_client_id")
																
										
						);
                            $ValidationFunctionName="CheckuserValidity";
					
						$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
						echo $JsCodeForFormValidation;
		?>
        
        <form name="<?php echo $FormName; ?>" enctype="multipart/form-data" action=""  method="post">
       <div id="page-wrap">

		<textarea id="header">INVOICE</textarea>
		
		
		
		<div style="clear:both"></div>
        <select name="client_id" class="" style="width:200px" onchange="invoice_obj.address(this.value,{target:'address'});">
											<option>---Select Client---</option>
                                         <?php 
                                        $sql = "select * from ".INFINITE_CLIENT;
										$result= $this->db->query($sql,__FILE__,__LINE__);
										while($row= $this->db->fetch_array($result))
										{
										?>
												<option value="<?php echo $row['id']; ?>"><?php echo $row['client_name']; ?></option>
                                              
										<?php } ?>		
											</select>
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_client_id"></span>
		
		<div id="customer" style="height:115px;">
<div id="address">
            <textarea  readonly="readonly" id="customer-title"></textarea>
</div>
            <table id="meta">
                <tr>
                 <?php 					$x=1001;
                                        $sql = "select * from ".INFINITE_INVOICE_PRE;
										$result= $this->db->query($sql,__FILE__,__LINE__);
										while($row= $this->db->fetch_array($result))
										$x++;
										?>
                    <td class="meta-head">Invoice #</td>
                    <td><input type="hidden"  name="invoice_no" value="<?php echo $x; ?>"  /><?php echo $x; ?></td>
                </tr>	
                <tr>

                    <td class="meta-head">Date</td>
                    <td><?php echo date("d-m-Y") ?></td>
                </tr>
                

            </table>
		
		</div>
		
		<table id="items">
		
		  <tr>
		      <th>Sell Type</th>
		      <th>Product Name</th>
		      <th>Unit Cost</th>
		      <th>Quantity</th>
		      <th>Price</th>
		  </tr>
		  
		  <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><select name="sell_type[]" class="required" style="width:200px" onchange="invoice_obj.getProductDetail(this.value,{target:'product'});">
											<option>---Select Sell Type---</option>
                                         <?php 
                                       // $sql = "select * from ".TBL_DESCRIPTION;
										//$result= $this->db->query($sql,__FILE__,__LINE__);
										//while($row= $this->db->fetch_array($result))
										{
										?>
												<option value="bundel">In Bundel</option>
                                                <option value="kg">In Kg</option>
                                                <option value="piece">In Piece</option>
										<?php } ?>		
											</select><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><div  id="product"><select  name="product[]" style="width:200px" class="required">
											<option>- Select a Product-</option>
                                        </select>
                                            </div></td>
		      <td><!--<textarea class="cost"></textarea>--><div id="rate" ><input style="width:100px" type="text" class="cost"/></div></td>
		      <td><input name="quantity[]" style="width:100px" type="text" class="qty"/></td>
		      <td><span class="price"></span> <input type="hidden" name="price[]" class="price" /></td>
		  </tr>
		  
		   <?php for($x=1;$x<=50;$x++) 
		  {
			  
			  ?>
      
       
           <tr class="item-row" style="display:none;" id="show<?php echo $x; ?>">
		      <td class="description"><div class="delete-wpr">
							<select name="sell_type[]" class="required" style="width:200px" onchange="invoice_obj.getProductDetail(this.value,<?php echo $x; ?>,{target:'product<?php echo $x; ?>'});">
											<option>---Select Sell Type---</option>
                                         <?php 
                                       // $sql = "select * from ".TBL_DESCRIPTION;
										//$result= $this->db->query($sql,__FILE__,__LINE__);
										//while($row= $this->db->fetch_array($result))
										{
										?>
												<option value="bundel">In Bundel</option>
                                                <option value="kg">In Kg</option>
                                                <option value="piece">In Piece</option>
										<?php } ?>		
											</select>
											
						<a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td  class="item-name" >	<div  id="product<?php echo $x;  ?>"><select name="product[]" onchange="invoice_obj.getProductRate('<?php echo $sell_typeforPrice ?>',this.value,{target:'rate<?php echo $x; ?>'});" style="width:200px" class="required">
											<option>- Select a Product-</option>
                                        </select>
                                            </div>
										</td>
		      <td><!--<textarea class="cost"></textarea>--><div  id="rate<?php echo $x; ?>"><input readonly="readonly" style="width:100px" type="text" name="unit_price[]" class="cost"/></div></td>
		      <td><input type="text"  name="quantity[]"  style="width:100px;"  class="qty"></td>
		      <td><span class="price" > </span> <input type="hidden" name="price[]" class="price" /></td>
		  </tr >
         
           <tr   id="trbutton<?php echo $x; ?>" <?php if($x!=1){ ?> style="display:none" <?php } ?>><td colspan="5">
       <a   href="javascript:void(0);"  onclick="document.getElementById('show<?php echo $x+1; ?>').style.display=''; 
       document.getElementById('trbutton<?php echo $x; ?>').style.display='none';  document.getElementById('trbutton<?php echo $x+1; ?>').style.display='';"><img src="images/newline.png" /></a></td></tr>
          <?php 
		  
		  }
		  ?>
		  
		  
		  
		  
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Total&nbsp;&nbsp; &#8377;</td>
		      <td class="total-value"><div id="total">0 <input type="hidden" class="total-value" name="total_amount" /></div></td>
		  </tr>
          
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid&nbsp;&nbsp; &#8377;</td>

		      <td class="total-value"><textarea  name="amount_paid" id="paid">0</textarea></td>
               
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Balance Due &nbsp;&nbsp; &#8377;</td>
		      <td class="total-value balance"><div class="due">0<input type="hidden" name="balanace_due"  class="due" /></div></td>
		  </tr>
          <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Discount&nbsp;&nbsp; &#8377;</td>

		      <td class="total-value"><textarea  name="discount" id="discount">0</textarea></td>
               
		  </tr>
		
		</table>
		
		<div id="terms" style="float:right">
        <table width="200" border="0" style="margin-bottom:20px;">
						
  
	<button  onclick="return <?php echo $ValidationFunctionName?>();"  name="submit" type="submit" value="Submit" style="width:90px; font-family:verdana;font-size:13px;" class="btn btn-gebo">Submit</button><button style="width:90px; font-family:verdana;font-size:13px; margin-left:5px;" type="reset" class="btn btn-gebo">Cancel</button>
	
	
		 				
		</div>
	
	</div>
 </form>                          
                            <?php
							break;
							case 'server':
									extract($_POST);
									
								
								$this->sell_type=$sell_type;
                              	$this->product=$product; 
								$this->discount=$discount; 
								
								$this->unit_price = $unit_price;
								$this->quantity = $quantity;
								$this->price = $price;
								
								
								
								$this->client_id = $client_id;
								$this->invoice_no = $invoice_no;
								
								$this->amount_paid = $amount_paid;
								$this->balanace_due = $balanace_due;
								
							$j=0;
	foreach	($sell_type as $type) 
		{
			?>
           <?php /*?> <script>
			alert('<?php echo 'type='.$type.'  product='.$this->product[$j].'  unitprice='.$this->unit_price[$j].'  quantity='.$this->quantity[$j].'  clientid='.$this->client_id.'  amount='.$this->amount_paid.'    j'.$j; ?>');
			</script><?php */?>
            <?php 
			if($type !='' and $this->product[$j] !=''  and $this->unit_price[$j] !=''  and $this->quantity[$j] !='' and $this->client_id !='' )
			{
										$sql = "select * from ".INFINITE_PRODUCT_DETAIL." where product_id = '".$this->product[$j]."'";
										$result= $this->db->query($sql,__FILE__,__LINE__);
										$row= $this->db->fetch_array($result);
										if($type == 'bundel' or $type == 'kg')
										{
											if($row['total_stock']<$this->quantity[$j])
												{
													?>
													<script>
													window.location = 'create_invoice.php';
													</script>
													<?php 
													$_SESSION['error_msg'] = 'Please fill correct product quantity.';
													exit();
												}
										}
										if($type == 'piece')
										{
											if($row['total_no_of_pices']<$this->quantity[$j])
												{
													?>
													<script>
													window.location = 'create_invoice.php';
													</script>
													<?php 
													$_SESSION['error_msg'] = 'Please fill correct product quantity.';
													exit();
												}
										}
							
			}
				else
				{
				?>
                <script>
				window.location = 'create_invoice.php';
				</script>
                <?php 
				$_SESSION['error_msg'] = 'Please fill all the fields.';
				exit();
				}
				
		}
							
							//server side validation
							$return =true;
							/*	if($this->Form->ValidField($member_name,'empty','Member Field is Empty or Invalid')==false)
								$return =false;
								if($this->Form->ValidField($phone_no,'empty','Phone No. is Empty or Invalid')==false)
								$return =false;
							  	if($this->Form->ValidField($address,'empty','Address is Empty or Invalid')==false)
								$return =false;*/
								
								
								
							if($return){
								$k=0;
								$total_amount=0;
								$insert_sql_array = array();
								$insert_sql_array['client_id'] = $this->client_id;
								$insert_sql_array['invoice_id'] = $this->invoice_no;
								$insert_sql_array['invoice_date'] = date("d-m-Y");
								$insert_sql_array['amount_paid'] = $this->amount_paid;
								$insert_sql_array['discount'] = $this->discount;
								$insert_sql_array['user_id'] = $_SESSION['user_id'];
								
								$this->db->insert(INFINITE_INVOICE_PRE,$insert_sql_array);
								$lastid = $this->db->last_insert_id();
								$total_cost_price = 0;
								$total_supplier_price = 0;
								$total_client_price = 0;
								foreach($sell_type as $type)
								{
									$price=0;
									if($type !='' and $this->product[$k] !=''  and $this->unit_price[$k] !=''  and $this->quantity[$k] !='')
									{
										
										$insert_sql_array = array();
										$insert_sql_array['invoice_id'] = $lastid;
										$insert_sql_array['sell_type'] = $type;
										$insert_sql_array['product_id'] = $this->product[$k];
										$insert_sql_array['quantity'] = $this->quantity[$k];
										
										$sql = "select * from ".INFINITE_PRODUCT_DETAIL." where product_id = '".$this->product[$k]."'";
										$result= $this->db->query($sql,__FILE__,__LINE__);
										$row= $this->db->fetch_array($result);
										
										
										if($type=='bundel' or $type=='piece') 
										{
											if($type=='piece')
											{
												//this is upadte the total stock and remain stock if sell type is in Pieces;
												$remain_pices = $row['total_no_of_pices']-$this->quantity[$k];
												$update_sql_array = array();
												$update_sql_array['total_no_of_pices'] = $remain_pices;
												$bundel = $remain_pices/$row['no_of_pices'];
												$bundel = floor($bundel);
												$pcs = $remain_pices%$row['no_of_pices'];
												$update_sql_array['remain_stock'] = $bundel.' Bundel'.$pcs.' Pics';
												$update_sql_array['total_stock'] = $bundel;
												$this->db->update(INFINITE_PRODUCT_DETAIL,$update_sql_array,'product_id',$this->product[$k]);
											}
											else
											{
												//this is update the total stock and remain stock if sell type is in Bundel
												
												$update_sql_array = array();
												$update_sql_array['total_stock'] = $row['total_stock']-$this->quantity[$k];
												
												$sell_pices = $row['no_of_pices']*$this->quantity[$k];
												$remain_pices = $row['total_no_of_pices'] - $sell_pices;
												$bundel = $remain_pices/$row['no_of_pices'];
												$bundel = floor($bundel);
												$pcs = $remain_pices%$row['no_of_pices'];
												$update_sql_array['total_no_of_pices'] = $remain_pices;
												$update_sql_array['remain_stock'] = $bundel.' Bundel'.$pcs.' Pics';
												$this->db->update(INFINITE_PRODUCT_DETAIL,$update_sql_array,'product_id',$this->product[$k]);

											}
										}
										//this is update the total stock and remain stock if sell  type is in KG;
										else
										{
											$update_sql_array = array();
											$remain_stock = $row['total_stock']-$this->quantity[$k];
											$update_sql_array['total_stock'] = $remain_stock;
											$update_sql_array['remain_stock'] = $remain_stock.' Kg';
											$this->db->update(INFINITE_PRODUCT_DETAIL,$update_sql_array,'product_id',$this->product[$k]);
										}
										
										//calculation for client pricing details
										
										if($type=='bundel' or $type=='kg') 
										{
											$cli_price = $row['bundel_price']*$this->quantity[$k]; 
											$insert_sql_array['client_price']= $row['bundel_price']*$this->quantity[$k]; 
											$total_client_price = $total_client_price + $cli_price;
										}
										else 
										{
											$cli_price = $row['pices_price']*$this->quantity[$k];
											$insert_sql_array['client_price'] = $row['pices_price']*$this->quantity[$k];
											$total_client_price = $total_client_price + $cli_price;
										}
										
										//calculation for supplier pricing details
											
										if($type=='bundel' or $type=='kg') 
										{
											
											//calculation for supplier pricing details if sell type is in Bundel 
											if($type=='bundel')
											{
												$sup_unit_price = $row['bundel_supplier_price'] ;
												$sup_price=	$sup_unit_price*$this->quantity[$k]; 
												$insert_sql_array['supplier_price']= $sup_unit_price*$this->quantity[$k]; 
												$total_supplier_price = $total_supplier_price+$sup_price;
											}
											//calculation for supplier pricing details if sell type is in KG 
											else
											{
												$sup_unit_price = $row['bundel_supplier_price'] ;
												$sup_price=	$sup_unit_price*$this->quantity[$k]; 
												$insert_sql_array['supplier_price']= $sup_unit_price*$this->quantity[$k]; 
												$total_supplier_price = $total_supplier_price+$sup_price;
											}
										}
										//calculation for supplier pricing details if sell type is in Pieces 
										else 
										{
											$sup_price =$row['supplier_piece_price'];
											$sup_price = $sup_price*$this->quantity[$k];
											$insert_sql_array['supplier_price'] = $sup_price;	
											$total_supplier_price = $total_supplier_price+$sup_price;
										}
										
										
										
										$profit = $cli_price - $sup_price;
										$insert_sql_array['profit'] = $profit;
										$insert_sql_array['unit_price'] = $this->unit_price[$k];
										$insert_sql_array['product_name'] = $row['product_name'];
										
										$this->db->insert(INFINITE_INVOICE_DETAIL,$insert_sql_array);
								
									}
									
								$k++;
								}
								//this will  update the total details of current invoice in INVOICE_PRE table
								$update_sql_array_invoice = array();
								$update_sql_array_invoice['total_due'] = $total_client_price;
								$blnc_due = $total_client_price-$this->amount_paid+$this->$discount;
								$update_sql_array_invoice['balance_due'] = $blnc_due;
								$update_sql_array_invoice['total_supplier_price'] = $total_supplier_price;
								$update_sql_array_invoice['total_client_price'] = $total_client_price;
								$tf =  $total_client_price-$total_supplier_price+$this->$discount;
								$update_sql_array_invoice['total_profit'] = $tf;
								$this->db->update(INFINITE_INVOICE_PRE,$update_sql_array_invoice,'id',$lastid);
								
								//this will upadte the  LEFT Amount in CLIENT TABLE
								$update_sql_array_client= array();
								$update_sql_array_client['left_amount'] = $this->getLeftAmount($client_id,$total_client_price,$this->amount_paid,$this->$discount);
								$this->db->update(INFINITE_CLIENT,$update_sql_array_client,'id',$client_id);
								$_SESSION['msg'] = 'Your Invoice has been successfully created.';
						?>
                             <script type="text/javascript">
							 
							window.location = 'pre_invoice.php?invoiceId=<?php echo $lastid; ?>';
							</script>

							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->newInvoice('local');
							}
							break;
			default 	: 
							echo "Wrong Parameter passed";
							
		}
	
	}
	
	// this function iss returns the previous LEFT_AMOUNT of the client in time of creation invoice.
	function getLeftAmount($clientId, $ttl_clnt_prc, $amnt_pd, $discount)
	{
							$sql= "select * from ".INFINITE_CLIENT." where id='".$clientId."'";
							$record = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($record);
							$left_amount = $row['left_amount']+$ttl_clnt_prc-$amnt_pd-$discount;
							return $left_amount;
	}
	
	//This function is use to creation the layout of invoice and priting of INOVICE
	
	function generateInvoice($invoiceId)
	{
							$sql_invoice = "select * from ".INFINITE_INVOICE_PRE." where id='".$invoiceId."'";
							$record_invoice = $this->db->query($sql_invoice,__FILE__,__LINE__);
							$cnt = $this->db->num_rows($record_invoice);
							if($cnt>0)
							{
		
			?>
            
             <a href="javascript: void(0);" onClick="printpage('print');"><button class="btn btn-gebo" style="width:90px; font-family:verdana;font-size:13px;" value="Submit" type="submit" name="submit" id="submit">Print</button></a>
                <div id="print" style="height:auto; width:70%;">
                  <?php
				  
				  			$sql_invoice = "select * from ".INFINITE_INVOICE_PRE." where id='".$invoiceId."'";
							$record_invoice = $this->db->query($sql_invoice,__FILE__,__LINE__);
							$row_invoice = $this->db->fetch_array($record_invoice);
							
							$sql = "select * from ".INFINITE_CLIENT." where id='".$row_invoice['client_id']."'";
							$record = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($record);
							
//							$sql_company = "select * from ".TBL_COMPANY;
//							$record_company = $this->db->query($sql_company,__FILE__,__LINE__);
//							$row_company = $this->db->fetch_array($record_company);
							
						?>
                       <?php /*?>  <p style="margin:0; width:75%;  float:left" >Registration No. : <?php echo $row_company['reg_no']; ?></p>
                <p style="margin:0" >TIN No. : <?php echo $row_company['tin_no']; ?></p><?php */?>
                
                
                <h3  align="center" style="margin:0"><?php echo 'INVOICE'; //if($row_invoice['status']=='yes'){ echo 'INVOICE';}else { echo 'QUATATION'; } ?></h3>
                
                
                <h3 style="margin:0" align="center"><?php echo 'Shree Associates'; //echo $row_company['cmpny_name']; ?></h3>
                <p style="margin:0" align="center"><?php echo 'Lambhua'; //echo $row_company['address1']; ?></p>
                <p style="margin:0" align="center"><?php echo 'Sultanpur';//echo $row_company['address2']; ?></p>
                
              
                 <p style="margin:0; width:75%; float:left">&nbsp;</p>
                 <p style="margin:0">Date : <?php echo $row_invoice['invoice_date']; ?></p> 
                 
                <p style="margin:0; width:75%; float:left">Name : <?php echo $row['client_name']; ?></p>
                 <p style="margin:0"><?php echo 'Invoice No.'; ?> : <?php echo $row_invoice['invoice_id']; ?></p> 
                		
                <hr />
                <p style=" <?php if($row['e_mail'] != ''){ ?> float:left; <?php } ?>width:45%;margin:0" >Phone No. :   <?php echo $row['contact']; ?> </p> 
                
                <?php if($row['e_mail'] != ''){ ?>
                <p style="margin:0" >E-Mail. : <?php echo $row['e_mail']; ?></p>
                <?php } ?>
                <hr />
                <p style=" width:45%;margin:0" >Address. : <?php echo substr($row['client_address'], 0, 50); ?></p>
                <hr />
                <table width="100%" border="0" >
                <tr  style="border-bottom:#000 2px solid" >
                <td width="18%"><strong>S.No.</strong></td>
                <td width="18%"><strong>Sell Type</strong></td>
                <td width="18%"> <strong>Product Name</strong></td>
                <td width="18%"><strong>Unit Cost</strong></td>
                <td width="18%"><strong>Quantity</strong></td>
                <td width="10%"><strong>Price</strong></td>
                </tr>
                 <?php
							 $sql_invoice = "select * from ".INFINITE_INVOICE_PRE." where id='".$invoiceId."'";
							$record_invoice = $this->db->query($sql_invoice,__FILE__,__LINE__);
							$row_invoice = $this->db->fetch_array($record_invoice);
							$x=1;
							$sql_detail = "select * from ".INFINITE_INVOICE_DETAIL." where invoice_id='".$row_invoice['id']."'";
							$record_detail = $this->db->query($sql_detail,__FILE__,__LINE__);
							while($row_detail = $this->db->fetch_array($record_detail))
							{
						?>
                            
                            <tr>
                            <td><?php echo $x; ?></td>
                            <td><?php echo  $row_detail['sell_type']; ?></td>
                           

                            <td><?php echo $row_detail['product_name']; ?></td>
                            
                            
                            <td>&#8377;&nbsp;&nbsp; <?php echo number_format($row_detail['unit_price'],2); ?></td>
                            <td><?php echo $row_detail['quantity']; ?></td>
                            <td>&#8377;&nbsp;&nbsp; <?php echo  number_format($row_detail['client_price'],2); ?></td>
                            </tr>
                            <?php $x++; 
							} ?>
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td >&nbsp;</td>
                </tr>
                
                <tr style="border-top:solid #000 2px;">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><div style="border-top:#000 solid 1px;" >Total Amount </div></td>
                <td ><div style="border-top:#000 solid 1px;" >&#8377;&nbsp;&nbsp; <?php echo number_format($row_invoice['total_due'],2); ?></div></td>
                </tr>
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><div style="border-top:#000 solid 1px;" >Discount</div></td>
                <td ><div style="border-top:#000 solid 1px;" >&#8377;&nbsp;&nbsp; <?php echo $row_invoice['discount']; ?></div></td>
                </tr>
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><div style="border-top:#000 solid 1px;" >Amount Paid</div></td>
                <td ><div style="border-top:#000 solid 1px;" >&#8377;&nbsp;&nbsp; <?php echo $row_invoice['amount_paid']; ?></div></td>
                </tr>
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><div style="border-top:#000 solid 1px;" >Balance Due</div></td>
                <td ><div style="border-top:#000 solid 1px;" >&#8377;&nbsp;&nbsp; <?php echo  number_format($row_invoice['balance_due'],2); ?></div></td>
                </tr>
                
               
                </table>
                <hr />
                <br clear="all" />
               
               <p style="width:75%; float:left">Custmer Signature</p> <p >Retailer Signature</p>
                </div>
<?php
							}
							else
echo '<h3>You are not authorized to access this page.</h3>';
		
	}
	//This function is use to Show All Invoices(Pagename = show_allinvocie.php)
	function showAllInvoice()
	{
		
					$sql="select * from ".INFINITE_INVOICE_PRE."  order by timestamp";
					 $resultpages= $this->db->query($sql,__FILE__,__LINE__);
					if($_REQUEST['pg'])
					{
					$st= ($_REQUEST['pg'] - 1) * 10;
					$sql.=" limit ".$st.",10 ";	
					$x=(($_REQUEST['pg'] - 1)*10)+1;
					$pgr=$_REQUEST['pg'];
					}
					if($_REQUEST['pg'] == '')
					{
					$sql.=" limit 0,10 ";
					$x=1;
					$pgr=1;
					}			
		?>
        				<div class="row-fluid">
        				<div class="span12">
                        <a class="btn btn-danger" href="create_invoice.php" style="float:right;">Billing</a>
                        </div>
                        </div>
                        <div class="span10">
                         <h2> All Invoice Record</h2>
                       <hr />
                         <table class="table table-striped table-bordered dTableR" >
                                <thead>
                                    <tr>
                                        <th width="9%">S.No.</th>
                                        <th width="15%">Invoice No.</th>
                                         <th width="15%">Invoice Date</th>
                                        <th width="20%">Client Name</th>
                                        <th width="15%">Contact No. </th>
                                         <th width="20%">total Amount</th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
						$result= $this->db->query($sql,__FILE__,__LINE__);
						$cnt = $this->db->num_rows($result);
						if($cnt>0)
						{
						$x=1;
							while($row = $this->db->fetch_array($result))
							{
							$sql_client = "select * from ".INFINITE_CLIENT." where id='".$row['client_id']."'";
							$record_client = $this->db->query($sql_client,__FILE__,__LINE__);
							$row_client = $this->db->fetch_array($record_client);
								
							?>	
                                    <tr>
                                        <td><?php echo $x;?></td>
                                        <td><?php echo $row['invoice_id'];?></td>
                                        <td><?php echo $row['invoice_date'];?></td>
                                        <td><?php echo $row_client['client_name'];?></td>
                                         <td><?php echo $row_client['contact'];?></td>
                                          <td>&#8377;&nbsp;&nbsp; <?php echo $row['total_due'];?></td>
                                       <td>
            <a title="Print" href="invoice.php?invoiceId=<?php echo $row['id'];?>" target="_blank"><i class="splashy-document_letter_new"></i></a>
                                        </td>
                                    </tr>
                            <?php
							$i++;
								}
							
						}
						else
						{
							?>
							<tr style="height:55px;">
							<td align="center" style="font-family:'Comic Sans MS', cursive; font-size:16px; font-weight:600; color:#3B5998;" colspan="7">Sorry! No Record Found....</td>
							</tr>
							<?php
						}
							?>
                                </tbody>
                            </table>
                            <div align="center">
         <div class="btn-group">
			<?php
			$numpages= $this->db->num_rows($resultpages);
			//echo $numpages;
			$tmppage = $numpages/10;
			$remndr=$numpages%10;
			if($remndr >= 1)
			{
				$t1=explode('.',$tmppage);
				$lastpage = $t1[0]+1;
			}
			else
			{ $lastpage = $numpages/10; }
			 ?>
			
				<a href="show_allinvoice.php" class="btn btn-info">&laquo;&laquo;</a>
<a href="show_allinvoice.php<?php if($pgr >=2 ) {echo '?pg=';echo $pgr-1; } else { echo $pg; }?>" class="btn btn-info">&laquo;</a>
				
				<?php if($pgr == $lastpage && ($pgr-4) >= 1 ) { ?>
				<a href="show_allinvoice.php?pg=<?php echo $pgr-4;?>" class="btn btn-info"><?php echo $pgr-4; ?></a>
				<?php } ?>
				
				<?php if($pgr == $lastpage || $pgr == $lastpage-1) { 
				if(($pgr-3) >= 1){
				?>
				<a href="show_allinvoice.php?pg=<?php echo $pgr-3;?>" class="btn btn-info"><?php echo $pgr-3; ?></a>
				<?php } }?>
				
				<?php $temp0=$pgr-2;
					if($temp0 >= 1) {				
				?>
				<a href="show_allinvoice.php?pg=<?php echo $pgr-2;?>" class="btn btn-info"><?php echo $pgr-2;?></a>
				<?php } ?>
				
				<?php $temp1=$pgr-1;
					if($temp1 >= 1) {				
				?>
				<a href="show_allinvoice.php?pg=<?php echo $pgr-1;?>" class="btn btn-info"><?php echo $pgr-1;?></a>
				<?php } ?>
				
				<a href="show_allinvoice.php?pg=<?php if($pgr !='') {echo $pgr;} else { echo 1; }?>" class="btn btn-info active"><?php if($pgr !='') {echo $pgr;} else { echo 1; }?></a>
				
				<?php $temp2=$pgr+1;
					if($temp2 <= $lastpage) {				
				?>
				<a href="show_allinvoice.php?pg=<?php echo $pgr+1;?>" class="btn btn-info"><?php echo $pgr+1;?></a>
				<?php } ?>
				<?php $temp3=$pgr+2;
					if($temp3 <= $lastpage) {				
				?>
				<a href="show_allinvoice.php?pg=<?php echo $pgr+2;?>" class="btn btn-info"><?php echo $pgr+2;?></a>
				<?php } ?>
				
				<?php if($pgr == 1 || $pgr == 2) { 
				if(($pgr+3) <= $lastpage) {
				?>
				<a href="show_allinvoice.php?pg=<?php echo $pgr+3;?>" class="btn btn-info"><?php echo $pgr+3; ?></a>
				<?php } }?>
				
				<?php if($pgr == 1 && ($pgr+4) <= $lastpage) { ?>
				<a href="show_allinvoice.php?pg=<?php echo $pgr+4;?>" class="btn btn-info"><?php echo $pgr+4; ?></a>
				<?php } ?>
				
				<a href="show_allinvoice.php?pg=<?php echo $pgr+1;?>" class="btn btn-info">&raquo;</a>
				
				<a href="show_allinvoice.php?pg=<?php echo $lastpage;?>" class="btn btn-info">&raquo;&raquo;</a>
			</div>
            </div>
             <div align="right">Total Pages - <?php echo $lastpage;?></div>
			<div align="right">Total Records - <?php echo $numpages;?></div>
            
                        </div>
                    
        <?php
		
	
	}
	
	
	function getInvoiceForPreview($invoiceId)
	{
		
							$sql_invoice = "select * from ".INFINITE_INVOICE_PRE." where id='".$invoiceId."'";
							$record_invoice = $this->db->query($sql_invoice,__FILE__,__LINE__);
							$cnt = $this->db->num_rows($record_invoice);
							if($cnt>0)
							{
		
			?>
            
             <a href="invoice.php?invoiceId=<?php echo $invoiceId; ?>" target="_blank" ><button class="btn btn-gebo" style="width:90px; font-family:verdana;font-size:13px;" value="Submit" type="submit" name="submit" id="submit">Print</button></a>
                <div id="print" style="height:auto; width:70%;">
                  <?php
				  
				  			$sql_invoice = "select * from ".INFINITE_INVOICE_PRE." where id='".$invoiceId."'";
							$record_invoice = $this->db->query($sql_invoice,__FILE__,__LINE__);
							$row_invoice = $this->db->fetch_array($record_invoice);
							
							$sql = "select * from ".INFINITE_CLIENT." where id='".$row_invoice['client_id']."'";
							$record = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($record);
							
//							$sql_company = "select * from ".TBL_COMPANY;
//							$record_company = $this->db->query($sql_company,__FILE__,__LINE__);
//							$row_company = $this->db->fetch_array($record_company);
							
						?>
                       <?php /*?>  <p style="margin:0; width:75%;  float:left" >Registration No. : <?php echo $row_company['reg_no']; ?></p>
                <p style="margin:0" >TIN No. : <?php echo $row_company['tin_no']; ?></p><?php */?>
                
                
                <h3  align="center" style="margin:0"><?php echo 'INVOICE'; //if($row_invoice['status']=='yes'){ echo 'INVOICE';}else { echo 'QUATATION'; } ?></h3>
                
                
                <h3 style="margin:0" align="center"><?php echo 'Shree Associates'; //echo $row_company['cmpny_name']; ?></h3>
                <p style="margin:0" align="center"><?php echo 'Lambhua'; //echo $row_company['address1']; ?></p>
                <p style="margin:0" align="center"><?php echo 'Sultanpur';//echo $row_company['address2']; ?></p>
                
              
                 <p style="margin:0; width:75%; float:left">&nbsp;</p>
                 <p style="margin:0">Date : <?php echo $row_invoice['invoice_date']; ?></p> 
                 
                <p style="margin:0; width:75%; float:left">Name : <?php echo $row['client_name']; ?></p>
                 <p style="margin:0"><?php echo 'Invoice No.'; ?> : <?php echo $row_invoice['invoice_id']; ?></p> 
                		
                <hr />
                <p style=" <?php if($row['e_mail'] != ''){ ?> float:left; <?php } ?>width:45%;margin:0" >Phone No. :   <?php echo $row['contact']; ?> </p> 
                
                <?php if($row['e_mail'] != ''){ ?>
                <p style="margin:0" >E-Mail. : <?php echo $row['e_mail']; ?></p>
                <?php } ?>
                <hr />
                <p style=" width:45%;margin:0" >Address. : <?php echo substr($row['client_address'], 0, 50); ?></p>
                <hr />
                <table width="100%" border="0" >
                <tr  style="border-bottom:#000 2px solid" >
                <td width="18%"><strong>S.No.</strong></td>
                <td width="18%"><strong>Sell Type</strong></td>
                <td width="18%"> <strong>Product Name</strong></td>
                <td width="18%"><strong>Unit Cost</strong></td>
                <td width="18%"><strong>Quantity</strong></td>
                <td width="10%"><strong>Price</strong></td>
                </tr>
                 <?php
							 $sql_invoice = "select * from ".INFINITE_INVOICE_PRE." where id='".$invoiceId."'";
							$record_invoice = $this->db->query($sql_invoice,__FILE__,__LINE__);
							$row_invoice = $this->db->fetch_array($record_invoice);
							$x=1;
							$sql_detail = "select * from ".INFINITE_INVOICE_DETAIL." where invoice_id='".$row_invoice['id']."'";
							$record_detail = $this->db->query($sql_detail,__FILE__,__LINE__);
							while($row_detail = $this->db->fetch_array($record_detail))
							{
						?>
                            
                            <tr>
                            <td><?php echo $x; ?></td>
                            <td><?php echo  $row_detail['sell_type']; ?></td>
                           

                            <td><?php echo $row_detail['product_name']; ?></td>
                            
                            
                            <td>&#8377;&nbsp;&nbsp; <?php echo number_format($row_detail['unit_price'],2); ?></td>
                            <td><?php echo $row_detail['quantity']; ?></td>
                            <td>&#8377;&nbsp;&nbsp; <?php echo  number_format($row_detail['client_price'],2); ?></td>
                            </tr>
                            <?php $x++; 
							} ?>
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td >&nbsp;</td>
                </tr>
                
                <tr style="border-top:solid #000 2px;">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><div style="border-top:#000 solid 1px;" >Total Amount </div></td>
                <td ><div style="border-top:#000 solid 1px;" >&#8377;&nbsp;&nbsp; <?php echo number_format($row_invoice['total_due'],2); ?></div></td>
                </tr>
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><div style="border-top:#000 solid 1px;" >Discount</div></td>
                <td ><div style="border-top:#000 solid 1px;" >&#8377;&nbsp;&nbsp; <?php echo $row_invoice['discount']; ?></div></td>
                </tr>
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><div style="border-top:#000 solid 1px;" >Amount Paid</div></td>
                <td ><div style="border-top:#000 solid 1px;" >&#8377;&nbsp;&nbsp; <?php echo $row_invoice['amount_paid']; ?></div></td>
                </tr>
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><div style="border-top:#000 solid 1px;" >Balance Due</div></td>
                <td ><div style="border-top:#000 solid 1px;" >&#8377;&nbsp;&nbsp; <?php echo  number_format($row_invoice['balance_due'],2); ?></div></td>
                </tr>
                
               
                </table>
                <hr />
                <br clear="all" />
               
               <p style="width:75%; float:left">Custmer Signature</p> <p >Retailer Signature</p>
                </div>
<?php
							}
							else
echo '<h3>You are not authorized to access this page.</h3>';
		
	
	}
	
}


?>