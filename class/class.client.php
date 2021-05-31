<?php
 /***********************************************************************************

Class Discription : This class will handle all the operations of a client

Functions : Add_Client(); This is use to Add new client
			Show_all_client(); this use to Show all Clients
			view_client(); this use to show particular client Details
			clientSellingDetails() This function use to show All the invoices of the client
************************************************************************************/
class Client
{
	function __construct()
	{
					$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
					$this->validity = new ClsJSFormValidation();
					$this->Form = new ValidateForm();
					$this->auth=new Authentication();
					$this->noti=new Notification();
	}
	
	function Add_Client($runat)
	{
		switch($runat)
		
		{
		
			case 'local':
			$FormName = "form_login";
							$ControlNames=array("client_name"			=>array('client_name',"''","Kindly enter client name","span_client_name"),
												"contact"			=>array('contact',"''","Kindly enter contact no.","span_contact"),
											    "client_address"			=>array('client_address',"''","Kindly enter address","span_client_address")
												);
	
							$ValidationFunctionName="CheckLoginValidity";
						
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
			?>
            <div class="row-fluid">
        				<div class="span10">
                        <a class="btn btn-danger" href="all_client.php" style="float:right;">View All Client</a>
                        </div>
                        </div>
                        
            <div class="row-fluid" >
                        <div class="span10">
							<h3 class="heading">Client Details</h3>
							<form  enctype="multipart/form-data" action="" method="post" name="<?php echo $FormName ?>">
								<div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Client Name <span class="f_req">*</span></label>
											<input type="text" name="client_name" class="span12" />
											<span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_client_name"></span>
										</div>
                                        <div class="span5">
											<label>Contact No.<span class="f_req">*</span></label>
											<input type="text" name="contact" class="span12" />
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_contact"></span>
										</div>
									</div>
                                  </div>
                                  
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>State<span class="f_req"></span></label>
											<input type="text" name="state" class="span12" />
											 
										</div>
                                        <div class="span5">
											<label>City<span class="f_req"></span></label>
											<input type="text" name="city" class="span12" />
                                           
										</div>
									</div>
									
								</div>
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>E-mail<span class="f_req"></span></label>
											<input type="text" name="e_mail" class="span12" />
											 
										</div>
                                        <div class="span5">
											<label>Address<span class="f_req">*</span></label>
											<textarea name="client_address" id="your_message" cols="10" rows="3" class="span12"></textarea>
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_client_address"></span>
										</div>
									</div>
									
								</div>
                                <div class="form-actions">
									<button class="btn btn-danger" type="submit" name="submit" value="Add Client" onclick="return <?php echo $ValidationFunctionName?>();">Add Client</button>
									<button class="btn">Cancel</button>
								</div>
							</form>
                        </div>
                    </div>
            <?php
			break;
			case 'server':
			extract($_POST);
			
			$this->client_name = $client_name;
			$this->contact = $contact;
			$this->state = $state;
			$this->city = $city;
			$this->e_mail = $e_mail;
			$this->client_address = $client_address;
			
			
			$return = true;
		if($this->Form->ValidField($client_name,'empty','Please enter client name')==false)
		    $return =false;
		if($this->Form->ValidField($contact,'empty','Please enter contact no.')==false)
			$return =false;
	    if($this->Form->ValidField($client_address,'empty','Please enter client address')==false)
			$return =false;
		
			if($return){
							$insert_sql_array = array();
							$insert_sql_array['client_name'] = $this->client_name;
							$insert_sql_array['contact'] = $this->contact;
							$insert_sql_array['state'] = $this->state;
							$insert_sql_array['city'] = $this->city;
							$insert_sql_array['e_mail'] = $this->e_mail;
							$insert_sql_array['client_address'] = $this->client_address;
							
							$this->db->insert(INFINITE_CLIENT,$insert_sql_array);
						
							$_SESSION['msg'] = 'Client Details has been Successfully Added';	
							
							?>
							<script type="text/javascript">
							window.location = 'add_client.php';
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->Add_Client('local');
							}
							
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
	
	function Show_all_client()
	{
		?>
        				<div class="row-fluid">
        				<div class="span12">
                        <a class="btn btn-danger" href="add_client.php" style="float:right;">Add Client</a>
                        </div>
                        </div>
        <div class="row-fluid">
        
                        <div class="span12">
                         <table class="table table-striped table-bordered dTableR" id="dt_a">
                                <thead>
                                    <tr>
                                        <th width="9%">S.No.</th>
                                        <th width="30%">Client Name</th>
                                        <th width="20%">Contact No. </th>
                                       
                                         <th width="25%">Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
							$i=1;
						    $sql = "select * from ".INFINITE_CLIENT." order by time_stamp";
							$record = $this->db->query($sql,__FILE__,__LINE__);
							while($row = $this->db->fetch_array($record))
							{
							?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $row['client_name'];?></td>
                                        <td><?php echo $row['contact'];?></td>
                                         
                                         <td><p align="justify" style="max-height:35px; overflow:auto;"><?php echo $row['client_address'];?></p></td>
                                         
                                          
                                        
                                       <td>
            <a title="View" href="all_client.php?index=viewclient&sid=<?php echo $row['id'];?>"><i class="splashy-document_letter_new"></i></a>
            <a title="Edit" href="add_client.php?index=editclient&sid=<?php echo $row['id'];?>"><i class="splashy-document_letter_edit"></i></a>
            <?php
			if($row['status']=='active')
			{
			?>
                 <a title="Block" href="#" onclick="javascript: if(confirm('If you click on OK the Client will be Blocked?')) { client_obj.blockClient('<?php echo $row['id'];?>',{}) }; return false;"><i class="splashy-document_letter_remove"></i></a>
              <?php
			}
			else
			{
			?>
             <a title="Active" href="#" onclick="javascript: if(confirm('If you click on OK the Client will be active?')) { client_obj.activeClient('<?php echo $row['id'];?>',{}) }; return false;"><i class="splashy-document_letter_okay"></i></a>
           
            <?php
			}
			?>
           
            
            <a title="Delete" href="#" onclick="javascript: if(confirm('If you click on OK the Client will be deleted?')) { client_obj.deleteClient('<?php echo $row['id'];?>',{}) }; return false;"><i class="splashy-contact_grey_remove"></i></a>
            
            
                                        </td>
                                    </tr>
                                  
                            <?php
							$i++;
							}
							?>
                                </tbody>
                            </table>
                        </div>
                    </div>
        <?php
		
	}
	
	
	
	function blockClient($id)
	{
				ob_start();
				
				$update_array = array();
				$update_array['status'] = 'block';
				
				$this->db->update(INFINITE_CLIENT,$update_array,'id',$id);
				$_SESSION['msg']='Client has been Blocked successfully';
				?>
				<script type="text/javascript">
					location.reload(true);
				</script>
				<?php
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
	}
	
	
	function activeClient($id)
	{
				ob_start();
				
				$update_array = array();
				$update_array['status'] = 'active';
				
				$this->db->update(INFINITE_CLIENT,$update_array,'id',$id);
				$_SESSION['msg']='Client has been Active successfully';
				?>
				<script type="text/javascript">
					location.reload(true);
				</script>
				<?php
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
	}
	
	function deleteClient($id)
	{
		ob_start();
		
		
		$sql="delete from ".INFINITE_CLIENT." where id='".$id."'";
		$this->db->query($sql,__FILE__,__LINE__);


		$_SESSION['msg']='Client has been deleted successfully';
				?>
				<script type="text/javascript">
					location.reload(true);
				</script>
                
				<?php
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
				
	}
	
	
	function view_client($sid)
	{
		 				$sql = "select * from ".INFINITE_CLIENT." where id='".$sid."'";
						$record = $this->db->query($sql,__FILE__,__LINE__);
						$row = $this->db->fetch_array($record);
							
		?>
         
        <div class="row-fluid">
                        <div class="span12">
                            <h3 class="heading">Client Profile</h3>
                            <div class="row-fluid">
                                <div class="span8">
                                    <form class="form-horizontal">
                                        <fieldset>
                                        <?php
										if($row['client_name']!='')
										{
											?>
                                            <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"> <strong>Client Name:</strong></label>
                                                <div class="controls text_line">
                                                   <?php echo $row['client_name'];?>
                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                         <?php
										if($row['contect']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Contact no.:</strong></label>
                                                <div class="controls text_line">
                                                    <?php echo $row['contact'];?>
                                                </div>
                                            </div>
                                          <?php
										}
										?>
                                        <?php
										if($row['city']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>City:</strong></label>
                                                <div class="controls text_line">
                                                     <?php echo $row['city'];?>
                                                </div>
                                            </div>
                                         <?php
										}
										?>
                                         <?php
										if($row['state']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>State:</strong></label>
                                                <div class="controls text_line">
														 <?php echo $row['state'];?>                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                         <?php
										if($row['e_mail']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>E-mail:</strong></label>
                                                <div class="controls text_line">
                                                    <?php echo $row['e_mail'];?>
                                                </div>
                                            </div>
                                          <?php
										}
										?>
                                         <?php
										if($row['client_address']!='')
										{
											?>
                                            
                                            <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Address:</strong></label>
                                                <div class="controls text_line">
                                                   <?php echo $row['client_address'];?>
                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                         <?php
										if($row['left_amount']!='')
										{
											?>
                                            
                                            <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Balance Due:</strong></label>
                                                <div class="controls text_line">
                                                   <?php echo $row['left_amount'];?>
                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                    
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                    
        <?php
	}
	
	
	
	function Edit_Client($runat,$sid)
	{
		switch($runat)
		{
		
			case 'local':
			$FormName = "form_edit";
							$ControlNames=array("client_name"			=>array('client_name',"''","Kindly enter client name","span_client_name"),
												"contact"			=>array('contact',"''","Kindly enter contact name","span_contact"),
												"client_address"			=>array('client_address',"''","Kindly enter client address","span_client_address")
												);
	
							$ValidationFunctionName="CheckEditnValidity";
						
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
							
							$sql = "select * from ".INFINITE_CLIENT." where id='".$sid."'";
						$record = $this->db->query($sql,__FILE__,__LINE__);
						$row = $this->db->fetch_array($record);
					
			?>
           <!-- <div class="row-fluid">
        				<div class="span10">
                        <a class="btn btn-danger" href="all_supplier.php" style="float:right;">View All Supplier</a>
                        </div>
                        </div>
                        -->
                        
            <div class="row-fluid" >
                        <div class="span10">
							<h3 class="heading">Client Details</h3>
							<form class="" action="" method="post" name="<?php echo $FormName ?>">
								<div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Client Name <span class="f_req">*</span></label>
											<input type="text" name="client_name" class="span12" value="<?php echo $row['client_name'];?>" />
											<span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_client_name"></span>
										</div>
                                        <div class="span5">
											<label>Contact no. <span class="f_req">*</span></label>
											<input type="text" name="contact" class="span12" value="<?php echo $row['contact'];?>"/>
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_contact"></span>
										</div>
									</div>
									
								</div>
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>State<span class="f_req"></span></label>
											<input type="text" name="state" class="span12" value="<?php echo $row['state'];?>"/>
											
										</div>
                                        <div class="span5">
											<label>City<span class="f_req"></span></label>
											<input type="text" name="city" class="span12" value="<?php echo $row['city'];?>"/>
                                            
										</div>
									</div>
									
								</div>
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>E-mail <span class="f_req"></span></label>
											<input type="text" name="e_mail" class="span12" value="<?php echo $row['e_mail'];?>"/>
											
										</div>
                                        <div class="span5">
											<label>Address<span class="f_req">*</span></label>
                                           <textarea name="client_address" id="your_message" cols="10" rows="3" class="span12"><?php echo $row['client_address'];?></textarea>
											
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_client_address"></span>
										</div>
									</div>
									
								</div>
                                <div class="form-actions">
									<button class="btn btn-danger" type="submit" name="submited" value="Edit Client" onclick="return <?php echo $ValidationFunctionName ?>();">Edit Client</button>
									<button class="btn">Cancel</button>
								</div>
							</form>
                        </div>
                    </div>
            <?php
			break;
			case 'server':
			extract($_POST);
			
			
			
			$this->client_name = $client_name;
			$this->contact = $contact;
			$this->client_address = $client_address;
			
			
			$return = true;
			
		if($this->Form->ValidField($client_name,'empty','Please enter client name')==false)
		    $return =false;
		if($this->Form->ValidField($contact,'empty','Please enter contact')==false)
			$return =false;
		if($this->Form->ValidField($client_address,'empty','Please enter client address')==false)
			$return =false;	
			
			
			
			/*
			`id`, `supplier_name`, `company_name`, `company_email`, `company_phone`, `company_website`, `ctp_1`, `ctp_email_1`, `ctp_phone_1`, `ctp_designation_1`, `ctp_2`, `ctp_email_2`, `ctp_phone_2`, `ctp_designation_2`, `remark`, `status`, `time_stamp`*/
			
			
			if($return){
							
							$update_sql_array = array();
							$update_sql_array['client_name'] = $this->client_name;
							$update_sql_array['contact'] = $this->contact;
							
							$update_sql_array['client_address'] = $this->client_address;
							
							$this->db->update(INFINITE_CLIENT,$update_sql_array,'id',$sid);
							
							$_SESSION['msg'] = 'Client Details has been Successfully Updated';	
							
							?>
							<script type="text/javascript">
							window.location = 'all_client.php';
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->Edit_client('local',$sid);
							}
							
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
	
	function clientSellingDetails($clientId)
	{
		
		?>
        				
        <div class="row-fluid">
        
                        <div class="span12">
                         <table class="table table-striped table-bordered dTableR" id="dt_a">
                                <thead>
                                    <tr>
                                        <th width="9%">S.No.</th>
                                        <th width="10%">Invoice Id</th>
                                        <th width="20%">Invoice Date</th>
                                         <th width="25%">Total Due</th>
                                           <th width="25%">Amount Paid</th>
                                            <th width="25%">Balance Due</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
							$i=1;
						    $sql = "select * from ".INFINITE_INVOICE_PRE." where client_id = '".$clientId."'";
							$record = $this->db->query($sql,__FILE__,__LINE__);
							while($row = $this->db->fetch_array($record))
							{
							?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $row['invoice_id'];?></td>
                                        <td><?php echo $row['invoice_date'];?></td>
                                         <td>Rs. <?php echo $row['total_due'];?></td>
                                          <td>Rs. <?php echo $row['amount_paid'];?></td>
                                           <td>Rs. <?php echo $row['balance_due'];?></td>
                                        
                                       <td>
            <a title="View" href="invoice.php?invoiceId=<?php echo $row['id'];?>" target="_blank"><i class="splashy-document_letter_new"></i></a>
          <?php /*?>  <a title="Delete" href="#" onclick="javascript: if(confirm('If you click on OK the Client will be deleted?')) { client_obj.deleteClient('<?php echo $row['id'];?>',{}) }; return false;"><i class="splashy-contact_grey_remove"></i></a><?php */?>
            
            
                                        </td>
                                    </tr>
                                  
                            <?php
							$i++;
							}
							?>
                                </tbody>
                            </table>
                        </div>
                    </div>
        <?php
		
	
		
	}
	
	
	
}
?>