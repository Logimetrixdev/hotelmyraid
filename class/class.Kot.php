<?php

/* 
 * This class is responcible for the master values of Source Info
 * Author: Abhishek Kumar Mishra
 * Created Date: 30/08/2014
 */

class KOT
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
	

	
	
	
	
	function addkot($runat)
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
           <div>
               <input type="text" name="waiter" placeholder="Waiter Name Please.."  style="width:25%;"  class="form-control" required/>
       
           </div>
         <div id="identity">
                <select  class="form-control" name="kot_for" style="width:25%;" onchange="kot_obj.getdetails(this.value,{target:'room_no_div'});" required>
                <option value="">-- Select Kot For --</option>
                <option value="guest">Guest</option>
                <option value="staff">Staff</option>
                <option value="visitors">Visitors</option>
                </select>
         </div>
         <div id="room_no_div">
         </div>
         <div id="guest_div" style="margin-top:10px;">
         </div>
         
		
		<div style="clear:both"></div>
		
		
		
		<table id="items">
		
		  <tr>
		      <th>Item Code</th>
		      <th width="17%">Pax Cost</th>
		      <th>No. Of Plates</th>
		      <th>Price</th>
		  </tr>
		  
          
		  <tr class="item-row" style="padding-top:2px; padding-bottom:0px;" >
		      <td class="item-name" style="padding-top:2px; padding-bottom:0px;">
              <select name="product_headers[]" class="select2"  onchange="kot_obj.getProductCost(this.value,'<?php echo 1; ?>',{target:'rate<?php echo 1; ?>'});">
              <option value=""> -- Item Coode --</option>
              <?php
			  $sql="select * from ".HMS_KOT_MENU_HEADER." where status='1' and deleted='1' order by id";
			  $result = $this->db->query($sql,__FILE__,__LINE__);
			  while($row = $this->db->fetch_array($result))
			  {
				?>
				<optgroup label="<?php echo $row['header_name'];?>">
					<?php
                    $sql_bitem="select * from ".HMS_KOT_MENU." where header_id='".$row['id']."' and status='1' and deleted='1'";
                    $result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
                    while($row_bitem = $this->db->fetch_array($result_bitem))
                    {
                    ?>
                    <option value="<?php echo $row_bitem['id'];?>"><?php echo $row_bitem['item_code'];?></option>
                    <?php } ?>
                  </optgroup>
                  <?php
			  }
			  ?>
              </select>
              </td>
              <td><div id="rate<?php echo 1;?>" ><input type="text" name="cost[]" placeholder="0.00" class="cost form-control" /></div></td>
		      <td><input type="text" name="qty[]" class="qty form-control" /></td>
		      <td><span class="price">Rs 0.00</span><span class="price_cost"></span></td>
		  </tr>
		   <?php for($x=1;$x<=50;$x++) 
		  {
			  
			  ?>
             <tr class="item-row" style="display:none; padding-top:2px; padding-bottom:0px;" id="show<?php echo $x; ?>">
		     <td class="item-name" style="padding-top:2px; padding-bottom:0px;">
               <select name="product_headers[]" class="select2" onchange="kot_obj.getProductCost(this.value,'<?php echo $x; ?>',{target:'rate<?php echo $x; ?>'});">
              <option value=""> -- Item Coode --</option>
              <?php
			  $sql="select * from ".HMS_KOT_MENU_HEADER." where status='1' and deleted='1' order by id";
			  $result = $this->db->query($sql,__FILE__,__LINE__);
			  while($row = $this->db->fetch_array($result))
			  {
				?>
				<optgroup label="<?php echo $row['header_name'];?>">
					<?php
                    $sql_bitem="select * from ".HMS_KOT_MENU." where header_id='".$row['id']."' and status='1' and deleted='1'";
                    $result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
                    while($row_bitem = $this->db->fetch_array($result_bitem))
                    {
                    ?>
                    <option value="<?php echo $row_bitem['id'];?>"><?php echo $row_bitem['item_code'];?></option>
                    <?php } ?>
                  </optgroup>
                  <?php
			  }
			  ?>
              </select>
             </td>
             <td><div id="rate<?php echo $x;  ?>" ><input type="text" name="cost[]" placeholder="0.00" class="cost form-control" /></div></td>
		      <td><input type="text" name="qty[]" class="qty form-control" /></td>
		      <td><span class="price">Rs 0.00</span><span class="price_cost"></span></td></tr>
         
           <tr   id="trbutton<?php echo $x; ?>" <?php if($x!=1){ ?> style="display:none" <?php } ?>><td colspan="4">
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
              <td colspan="3" class="total-line">Total</td>
		      <td class="total-value"><div id="total">Rs 0.00</div> <input type="hidden" id="overallamount" name="overallamount" value="0"/></td>
		  </tr>
		  <tr>
		      <td colspan="3" class="total-line">KOT Type</td>

		      <td class="total-value">
              <input type="hidden" id="paid" class="form-control" name="paidamount"  />
                <select  class="form-control" name="kot_type" style="width:80%;" onchange="kot_obj.TotalValutionOnKtType(this.value,this.form.overallamount.value,{target:'depentonkt_type'});" required>
                <option value="">-- KOT Type --</option>
                <option value="non_cmtry" selected="selected">Non-Complementary</option>
                <option value="cmtry">Complementary</option>
               </select>
              </td>
		  </tr>
		  <tr>
		      <td colspan="3" class="total-line balance">Total Amount To Be Paid: </td>
		      <td class="total-value balance"><div class="due" style="display:none;">Rs 0.00</div> <div id="depentonkt_type">
              <input type="text" readonly="readonly" id="dueamount" name="dueamount" value="" class="form-control"/>
              </div></td>
		  </tr>
		
		</table>
		
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;">
  <tr>
    <td colspan="2" style="float:right; border:none;">
    <input type="submit" name="submited" class="btn" value="ADD KOT" /></td>
  </tr>
</table>

		
	
	</div>
         </form>                          
                            <?php
							break;
							case 'server':
									extract($_POST);
						
                        // KOT ITEM INFO...
						        $this->product_headers = array_values(array_filter($product_headers)); 
								$this->cost = array_values(array_filter($cost));
								$this->qty = array_values(array_filter($qty));
								$this->priceval = array_values(array_filter($priceval));
						        $this->dueamount = $dueamount;
							
								$this->kot_for = $kot_for;
								$this->room_id = $room_id;
								$this->kot_type = $kot_type;
                                                                $this->waiter = $waiter;
								
								if($this->kot_for=='guest'){
									$sql="select id,guest_id,room_id,check_in_status from ".HMS_GUEST_RESERVATION." where deleted='0' and check_in_status='1' and room_id='".$this->room_id."'";
									$result = $this->db->query($sql,__FILE__,__LINE__);
									$row = $this->db->fetch_array($result);
								$this->guest_id = $row['guest_id'];
								$this->reservation_id = $row['id'];
								}
								
								   
						// KOT ITEM INFO...		
					/*	echo '<pre>';
						 echo 'Headers Array:';
						 print_r($this->product_headers);
						  echo '<br />';
						
						 echo 'product Cost:'; 
						 print_r($this->cost);
						  echo '<br />';
						 echo 'product qty:'; 
						 print_r($this->qty);
						 echo 'product Amt:'; 
						 print_r($this->priceval);
						 echo '</pre>';
							
							echo ' Amount Due:'; 
							echo $this->dueamount;
							echo '<br />';
							
						exit();*/
							
							//server side validation
							$return =true;
								if($this->Form->ValidField($kot_for,'empty','Kindly Select KOT for....')==false)
								$return =false;
								if($this->Form->ValidField($kot_type,'empty','Kindly select KOT type....')==false)
								$return =false;
                                                                if($this->Form->ValidField($waiter,'empty','Kindly enter waiter name....')==false)
								$return =false;
							 if($return){
								
												$insert_sql_array = array();
												if($this->kot_for!='guest'){
												$insert_sql_array['kot_for'] = $this->kot_for; 
												}else {
												$insert_sql_array['kot_for'] = $this->kot_for;
												$insert_sql_array['guest_id'] = $this->guest_id;
												$insert_sql_array['reservation_id'] = $this->reservation_id;
												$insert_sql_array['room_id'] = $this->room_id;
												}
												$insert_sql_array['kot_type'] = $this->kot_type;
												$insert_sql_array['kot_amount'] = $this->dueamount;
												$insert_sql_array['kot_vat'] = $this->calculateVatOnAmount($this->dueamount);
												$insert_sql_array['kot_sat'] = $this->calculateSatOnAmount($this->dueamount);
												$insert_sql_array['kot_total'] = $this->dueamount+$this->calculateVatOnAmount($this->dueamount)+$this->calculateSatOnAmount($this->dueamount);
												if($this->kot_type=='cmtry')
												{
													$insert_sql_array['paid_status'] = 'free';
												}
												$insert_sql_array['waiter'] = $this->waiter;
												$insert_sql_array['order_datetime'] = date('Y-m-d h:i:s A');
												$insert_sql_array['user_id'] = $_SESSION['user_id'];
												$this->db->insert(HMS_KOT,$insert_sql_array);
												$kt_Id = $this->db->last_insert_id();
												$val=0;
												foreach($this->product_headers as $k)
												{
													$insert_sql_array1['kt_id'] = $kt_Id;
													$insert_sql_array1['item_id'] = $k;
													$insert_sql_array1['cost'] = $this->cost[$val];
													$insert_sql_array1['qty'] = $this->qty[$val];
													$insert_sql_array1['total'] = $this->priceval[$val];
													$insert_sql_array1['user_id'] = $_SESSION['user_id'];
													$this->db->insert(HMS_KOT_DETAILS,$insert_sql_array1);
													$val++;
												}
												
												$_SESSION['msg'] = 'New KOT has been Generated..';
												?>
												<script type="text/javascript">
													window.location='printkot.php?kt_id=<?php echo $kt_Id;?>';
												</script> 
												<?php
												exit();
								} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->addkot('local');
							}
							break;
			default 	: 
							echo "Wrong Parameter passed";
							
		}
	
	}
	
	
    function calculateVatOnAmount($amount)
	{
		        $sql="select id,percent_value from ".HMS_TAXS." where id = 3";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				$vatamount = $amount*$row['percent_value']/100;
				return $vatamount;
	}
	
	function calculateSatOnAmount($amount)
	{
		        $sql="select id,percent_value from ".HMS_TAXS." where id = 10";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				$satamount = $amount*$row['percent_value']/100;
				return $satamount;
	}
	
	function  getProductCost($product_id)
	{
		ob_start();
		     $sql="select * from ".HMS_KOT_MENU." where  id = '".$product_id."'";
            $result= $this->db->query($sql,__FILE__,__LINE__);
            $row= $this->db->fetch_array($result);
			?>
            <input type="text" name="cost[]" readonly="readonly" class="cost form-control" value="<?php echo $row['per_pack_cost'];?>" style="width:118px; float:left;" />
         <?php 
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	
	
	function getdetails($val)
	{
		ob_start();
		if($val=='guest'){
			$sql="select id,room_no,assigned,deleted from ".HMS_ROOM." where deleted='0' and assigned='1'";
		    $result = $this->db->query($sql,__FILE__,__LINE__);
			if($this->db->num_rows($result)>0)
			{
		        ?>
		        <select  class="form-control" style="width:25%;" name="room_id" onchange="kot_obj.guestinfo(this.value,{target:'guest_div'});" required>
                <option value="">-- Select Room No. --</option>
                <?php
				while($row = $this->db->fetch_array($result))
				{
					?>
                    <option value="<?php echo $row['id'];?>"><?php echo 'Room'.$row['room_no'];?></option>
                    <?php
				}
				?>
                </select>
		        <?php 
			}
			else
			{
				?>
				<select  class="form-control" style="width:25%;" name="room_id">
                <option value="">-- No Guest Available --</option>
                </select>
                <?php
			}
			
		}
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	
		function guestinfo($room_id)
		{
		ob_start();
		    $sql="select id,guest_id,room_id,check_in_status from ".HMS_GUEST_RESERVATION." where deleted='0' and check_in_status='1' and room_id='".$room_id."'";
		    $result = $this->db->query($sql,__FILE__,__LINE__);
			$row = $this->db->fetch_array($result);
			?>
            <input type="text" name="guest_name" readonly="readonly" style="width:25%;"  class="form-control"  value="<?php echo $this->Master->FindGuestNameByGuestId($row['guest_id']);?>"/>
        <?php 
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
		}
		
		
		function TotalValutionOnKtType($val,$amt)
		{
		ob_start();
		if($val=='cmtry')
		{
			?>
            <input type="text" readonly="readonly" id="dueamount" name="dueamount" value="0" class="form-control"/>
            <?php 
		}
		else
		{
			?>
            <input type="text" readonly="readonly" id="dueamount" name="dueamount" value="<?php echo $amt;?>" class="form-control"/>
            <?php
		} 
		
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
		}
		
		
		function printkot($kt)
		{
			$sql="select * from ".HMS_KOT." where id='".$kt."'";
		    $result = $this->db->query($sql,__FILE__,__LINE__);
			$row = $this->db->fetch_array($result);
			?>
            <div class="col-sm-5 col-md-5">
        <div class="block-flat">
						<div class="header">
							
                                                         <a class="fancybox fancybox.iframe btn btn-primary btn-lg" href="printktview.php?kt_id=<?php echo $kt;?>&type=roomkt">Generate Guest KOT</a>
                                                            <h4 style="width:150px;">KOT BILL</h4>
                                                </div>
						<div class="content" id="print">
							<h5 align="center">Hotel Myriad</h5>
							<h6 align="center">19, Vidhan Sabha Marg, lucknow - 226001</h6>	
                            <h6 align="center">Ph: 0522-4072153</h6>
            <table width="100%" style="padding-bottom:15px;">
            <tr style="border:none !important;">
            <td align="left" style="border:none !important;"><strong>Bill No: </strong> <?php echo $kt;?></td>
            <td align="right" style="border:none !important;"><strong>Date </strong> <?php echo $row['order_datetime'];?></td>
            </tr>
            <tr style="border:none !important;">
            <td align="left" style="border:none !important;"><strong>Kot For: </strong> <?php if($row['kot_for']=='guest') { echo 'Room :'.$this->getRoomNoByRoomID($row['room_id']);} else { echo ucwords($row['kot_for']);}?></td>
            </tr>
            <?php if($row['kot_total']<=0)
			{
				?>
                <tr style="border:none !important;">
            <td align="left" style="border:none !important;"><strong>Kot Type: </strong> Complementry</td>
            </tr>
                <?php
			}
			?>
            </table>
             <table class="no-border" width="100%">
								<thead class="no-border">
									<tr>
										<th class="text-center">ITEM NAME</th>
										<th class="text-center">QTY</th>
										<th class="text-center">PRICE</th>
                                        <th class="text-center">AMOUNT</th>
									</tr>
								</thead>
								<tbody class="no-border-y">
                                <?php
								$sql_details="select * from ".HMS_KOT_DETAILS." where kt_id='".$kt."'";
								$result_details = $this->db->query($sql_details,__FILE__,__LINE__);
								while($row_details = $this->db->fetch_array($result_details)){ ?>
									<tr>
										<td  align="center"><?php echo $this->getItemNameByItemId($row_details['item_id']);?></td>
										<td align="center"><?php echo $row_details['qty'];?></td>
                                        <td align="center"><?php echo number_format($row_details['cost'],2);?></td>
										<td align="center"><?php echo number_format($row_details['total'],2);?></td>
									</tr>
                                 <?php } ?>
                                    <?php
									if($row['kot_amount']>0)
									{?>
                                     <tr>
										<td  colspan="3" align="right">Total:- </td>
										<td align="center"><?php echo number_format($row['kot_amount'],2);?></td>
									</tr>
                                    <tr>
										<td  colspan="3" align="right">VAT(<?php echo $this->GetVat().'%';?>):- </td>
										<td align="center"><?php echo number_format($row['kot_vat'],2);?></td>
									</tr>
                                    <tr>
										<td  colspan="3" align="right">SAT(<?php echo $this->GetSat().'%';?>):- </td>
										<td align="center"><?php echo number_format($row['kot_sat'],2);?></td>
									</tr>
                                    
                                    <tr>
										<td colspan="3" align="right">Total:- </td>
										<td align="center"><?php echo number_format($row['kot_total'],2);?></td>
									</tr>
                                    
                                 	<?php } ?>
                                    <tr>
										<td colspan="3" align="right">Round Off:- </td>
                                        <?php $round = round($row['kot_total']);?>
										<td align="center"><?php echo number_format($round,2);?></td>
									</tr>
								</tbody>
							</table>
		
						
					
             
		
						</div>
		</div>				
      </div>
	  
	  <div class="col-sm-5 col-md-5">
        <div class="block-flat">
						<div class="header">
							
                                                         <a class="fancybox fancybox.iframe btn btn-primary btn-lg" href="printktview.php?kt_id=<?php echo $kt;?>&type=kitchenkt">Generate Kitchen KOT</a>
                                                            <h4 style="width:150px;">KOT BILL</h4>
                                                </div>
						<div class="content" id="print">
							
						
							<h5 align="center">Hotel Myriad</h5>
							<h6 align="center">19, Vidhan Sabha Marg, lucknow - 226001</h6>	
                            <h6 align="center">Ph: 0522-4072153</h6>
            <table width="100%" style="padding-bottom:15px;">
            <tr style="border:none !important;">
            <td align="left" style="border:none !important;"><strong>Bill No: </strong> <?php echo $kt;?></td>
            <td align="right" style="border:none !important;"><strong>Date </strong> <?php echo $row['order_datetime'];?></td>
            </tr>
            <tr style="border:none !important;">
            <td align="left" style="border:none !important;"><strong>Kot For: </strong> <?php if($row['kot_for']=='guest') { echo 'Room :'.$this->getRoomNoByRoomID($row['room_id']);} else { echo ucwords($row['kot_for']);}?></td>
            </tr>
            <?php if($row['kot_total']<=0)
			{
				?>
                <tr style="border:none !important;">
            <td align="left" style="border:none !important;"><strong>Kot Type: </strong> Complementry</td>
            </tr>
                <?php
			}
			?>
            </table>
             <table class="no-border" width="100%">
								<thead class="no-border">
									<tr>
										<th class="text-center">ITEM NAME</th>
										<th class="text-center">QTY</th>
										<?php /*?><th class="text-center">PRICE</th>
                                        <th class="text-center">AMOUNT</th><?php */?>
									</tr>
								</thead>
								<tbody class="no-border-y">
                                <?php
								$sql_details="select * from ".HMS_KOT_DETAILS." where kt_id='".$kt."'";
								$result_details = $this->db->query($sql_details,__FILE__,__LINE__);
								while($row_details = $this->db->fetch_array($result_details)){ ?>
									<tr>
										<td  align="center"><?php echo $this->getItemNameByItemId($row_details['item_id']);?></td>
										<td align="center"><?php echo $row_details['qty'];?></td>
                              <?php /*?>          <td align="center"><?php echo number_format($row_details['cost'],2);?></td>
										<td align="center"><?php echo number_format($row_details['total'],2);?></td>
<?php */?>									</tr>
                                 <?php } ?>
                                    <?php
									if($row['kot_amount']>0)
									{?>
                                    <?php /*?> <tr>
										<td  colspan="3" align="right">Total:- </td>
										<td align="center"><?php echo number_format($row['kot_amount'],2);?></td>
									</tr>
                                    <tr>
										<td  colspan="3" align="right">VAT(<?php echo $this->GetVat().'%';?>):- </td>
										<td align="center"><?php echo number_format($row['kot_vat'],2);?></td>
									</tr>
                                    <tr>
										<td  colspan="3" align="right">SAT(<?php echo $this->GetSat().'%';?>):- </td>
										<td align="center"><?php echo number_format($row['kot_sat'],2);?></td>
									</tr>
                                    
                                    <tr>
										<td colspan="3" align="right">Total:- </td>
										<td align="center"><?php echo number_format($row['kot_total'],2);?></td>
									</tr>
                                    
                                 	<?php */?><?php } ?>
                                    <?php /*?><tr>
										<td colspan="3" align="right">Round Off:- </td>
                                        <?php $round = round($row['kot_total']);?>
										<td align="center"><?php echo number_format($round,2);?></td>
									</tr><?php */?>
								</tbody>
							</table>
		
						</div>
		</div>				
      </div>
	  
	  
            <?php 
		}
                
                
                
                
                function GenerateKOT($kt_id,$type){
                    $sql="select * from ".HMS_KOT." where id='".$kt_id."'";
		    $result = $this->db->query($sql,__FILE__,__LINE__);
			$row = $this->db->fetch_array($result);
                    ?>
            <a href="javascript: void(0);" onClick="printpage('print');"><button class="btn btn-primary" style="width:90px; font-family:verdana;font-size:13px;" value="Submit" type="submit" name="submit" id="submit">Print</button></a>
						
<div id="print">
    <?php if($type=='roomkt'){ ?>
    <p align="center" style="margin:0px; padding: 0px;"><img src="logo.png" style="height:105px;"/></p>
							<h6 align="center" style="margin:0px; padding: 0px; font-size: 14px; margin: 3px 0px 5px 0px; ;">19, Vidhan Sabha Marg, lucknow - 226001</h6>	
                            <h6 align="center" style="margin:0px; padding: 0px; font-size: 13px;"> Ph: 0522-4072153</h6>
            <table width="100%" style="padding-bottom:15px; font-size: 14px;">
            <tbody><tr style="border:none !important;">
            <td align="left" style="border:none !important; width:50%;"><strong>KOT No: </strong> <?php echo $kt_id;?></td>
            <td align="right" style="border:none !important; width:50%;"><strong>Date: </strong> <?php echo date('d-m-Y',strtotime($row['order_datetime']));?></td>
            </tr>
            <tr style="border:none !important;">
            <td align="left" style="border:none !important; "><strong>KOT For: </strong> <?php if($row['kot_for']=='guest') { echo 'Room :'.$this->getRoomNoByRoomID($row['room_id']);} else { echo ucwords($row['kot_for']);}?></td>
            <td align="right" style="border:none !important; "><strong>Time: </strong>   <?php echo date('H:i',strtotime($row['order_datetime']));?></td>
            </tr>
             <tr style="border:none !important;">
                <td align="left" style="border:none !important; " colspan="2"><strong>Waiter Name: </strong> <?php echo $row['waiter'];?></td>
            </tr> 
            <?php if($row['kot_total']<=0){ ?>
            <tr style="border:none !important;">
                <td align="left" style="border:none !important; " colspan="2"><strong>KOT Type: </strong> Complementry</td>
            </tr>
            <?php } ?>
            
                        </tbody></table>
             <table width="100%" class="no-border">
								<thead class="no-border">
                                                                    <tr>
										<th class="text-center">Item</th>
                                                                               
										<th class="text-center">Qty</th>
                                                                               
										<th class="text-center">Rate</th>
                                                                                  <th class="text-center">Amount</th>
                                                                             
									</tr>
								</thead>
								<tbody>
                                                                  <?php
								$sql_details="select * from ".HMS_KOT_DETAILS." where kt_id='".$kt_id."'";
								$result_details = $this->db->query($sql_details,__FILE__,__LINE__);
								while($row_details = $this->db->fetch_array($result_details)){ ?>   
                                                                    
                                					<tr>
										<td align="center"><?php echo $this->getItemNameByItemId($row_details['item_id']);?></td>
										<td align="center"><?php echo $row_details['qty'];?></td>
                                                                                <td align="center"><?php echo number_format($row_details['cost'],2);?></td>
										<td align="center"><?php echo number_format($row_details['total'],2);?></td>
                                                                        </tr>
                                                                           <?php } ?>
                                                                        
                                                                  </tbody>
                                                                </table>
                            <hr>
                           
                                    <table width="100%">
                                         <?php
									if($row['kot_amount']>0)
									{ ?>
                                        <tr >
										<td align="right" colspan="3" style="width: 73%;">Total:- </td>
										<td align="center"><?php echo number_format($row['kot_amount'],2);?></td>
									</tr>
                            
                                    <tr>
										<td align="right" colspan="3">VAT(<?php echo number_format($this->GetVat(),2).'%';?>):- </td>
										<td align="center"><?php echo number_format($row['kot_vat'],2);?></td>
									</tr>
                                    <tr>
										<td align="right" colspan="3">SAT(<?php echo number_format($this->GetSat(),2).'%';?>):- </td>
										<td align="center"><?php echo number_format($row['kot_sat'],2);?></td>
									</tr>
                                    
                                    <tr>
										<td align="right" colspan="3">Total:- </td>
										<td align="center"><?php echo number_format($row['kot_total'],2);?></td>
									</tr>
                                                                        <?php } ?>
                                      <?php $round = round($row['kot_total']);?>
                                                                     
                                 	                                    <tr>
										<td align="right" colspan="3">Round Off:- </td>
                                                                                <td align="center"><b><?php echo number_format($round,2);?></b> </td>
									</tr>
                                                                    
                                    </table>
                             
				<hr>
                                                            
                                
                                <p style="padding: 80px 0px 15px;">Guest Signature</p>
                               
    <?php }  else { ?>
             <p align="center" style="margin:0px; padding: 0px;"><img src="logo.png" style="height:105px;"/></p>
							<h6 align="center" style="margin:0px; padding: 0px; font-size: 14px; margin: 3px 0px 5px 0px; ;">19, Vidhan Sabha Marg, lucknow - 226001</h6>	
                            <h6 align="center" style="margin:0px; padding: 0px; font-size: 13px;"> Ph: 0522-4072153</h6>
            <table width="100%" style="padding-bottom:15px; font-size: 14px;">
            <tbody><tr style="border:none !important;">
            <td align="left" style="border:none !important; width:50%;"><strong>KOT No: </strong> <?php echo $kt_id;?></td>
            <td align="right" style="border:none !important; width:50%;"><strong>Date: </strong> <?php echo date('d-m-Y',strtotime($row['order_datetime']));?></td>
            </tr>
            <tr style="border:none !important;">
            <td align="left" style="border:none !important; "><strong>KOT For: </strong> <?php if($row['kot_for']=='guest') { echo 'Room :'.$this->getRoomNoByRoomID($row['room_id']);} else { echo ucwords($row['kot_for']);}?></td>
            <td align="right" style="border:none !important; "><strong>Time: </strong>   <?php echo date('H:i',strtotime($row['order_datetime']));?></td>
            </tr>
            <?php if($row['kot_total']<=0){ ?>
            <tr style="border:none !important;">
                <td align="left" style="border:none !important; " colspan="2"><strong>KOT Type: </strong> Complementry</td>
            </tr>
            <?php } ?>
            
                        </tbody></table>
             <table width="100%" class="no-border">
								<thead class="no-border">
                                                                    <tr>
										<th class="text-center">Item</th>
                                                                               
										<th class="text-center">Qty</th>
                                                                          </tr>
								</thead>
								<tbody>
                                                                  <?php
								$sql_details="select * from ".HMS_KOT_DETAILS." where kt_id='".$kt_id."'";
								$result_details = $this->db->query($sql_details,__FILE__,__LINE__);
								while($row_details = $this->db->fetch_array($result_details)){ ?>   
                                                                    
                                					<tr>
										<td align="center"><?php echo $this->getItemNameByItemId($row_details['item_id']);?></td>
										<td align="center"><?php echo $row_details['qty'];?></td>
                                                                       </tr>
                                                                           <?php } ?>
                                                                        
                                                                  </tbody>
                                                                </table>
                            <hr>
                           
                                   
                                                
    <?php } ?>
</div>	
            <?php
                }
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
		
		
		function getItemNameByItemId($item_id)  
	{
		        $sql="select id,item from ".HMS_KOT_MENU." where id ='".$item_id."'"; 
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['item'];
	}
	
	
	function GetVat()
	{
		        $sql="select id,percent_value from ".HMS_TAXS." where id = 3";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return  $row['percent_value'];
	}
	
	function GetSat()
	{
		        $sql="select id,percent_value from ".HMS_TAXS." where id = 10";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return  $row['percent_value'];
	}
	
	
	function getRoomNoByRoomID($room_id)
	{
		        $sql_room = "select * from ".HMS_ROOM." where id='".$room_id."'";
				$result_room= $this->db->query($sql_room,__FILE__,__LINE__);
				$row_room = $this->db->fetch_array($result_room);
				return $row_room['room_no'];
				
	}
		
	
	

}