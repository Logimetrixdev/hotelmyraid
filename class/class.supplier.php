<?php
class Supplier
{
	function __construct()
	{
					$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
					$this->validity = new ClsJSFormValidation();
					$this->Form = new ValidateForm();
					$this->auth=new Authentication();
					$this->noti=new Notification();
	}
	
	function Add_Supplier($runat)
	{
		switch($runat)
		{
		
			case 'local':
			$FormName = "form_login";
							$ControlNames=array("supplier_name"			=>array('supplier_name',"''","Kindly enter supplier name","span_supplier_name"),
												"company_name"			=>array('company_name',"''","Kindly enter company name","span_company_name"),
												"company_phone"			=>array('company_phone',"''","Kindly enter company phone","span_company_phone"),
												"ctp_1"			=>array('ctp_1',"''","Kindly enter contact person name","span_ctp_1"),
												"ctp_phone_1"			=>array('ctp_phone_1',"''","Kindly enter contact person name phone","span_ctp_phone_1")
												);
	
							$ValidationFunctionName="CheckLoginValidity";
						
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
			?>
            <div class="row-fluid">
        				<div class="span10">
                        <a class="btn btn-danger" href="all_supplier.php" style="float:right;">View All Supplier</a>
                        </div>
                        </div>
                        
            <div class="row-fluid" >
                        <div class="span10">
							<h3 class="heading">Supplier Company Details</h3>
							<form class="form_validation_ttip" action="" method="post" name="<?php echo $FormName ?>">
								<div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Supplier Name <span class="f_req">*</span></label>
											<input type="text" name="supplier_name" class="span12" />
											<span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_supplier_name"></span>
										</div>
                                        <div class="span5">
											<label>Company Name <span class="f_req">*</span></label>
											<input type="text" name="company_name" class="span12" />
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_company_name"></span>
										</div>
									</div>
									
								</div>
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Company Email <span class="f_req"></span></label>
											<input type="text" name="company_email" class="span12" />
											
										</div>
                                        <div class="span5">
											<label>Company Phone <span class="f_req">*</span></label>
											<input type="text" name="company_phone" class="span12" />
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_company_phone"></span>
										</div>
									</div>
									
								</div>
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Company Website <span class="f_req"></span></label>
											<input type="text" name="company_website" class="span12" />
											
										</div>
                                   </div>
								</div>
                                
                                <h3 class="heading">Contact Person: #1</h3>
								<div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Contact Person Name <span class="f_req">*</span></label>
											<input type="text" name="ctp_1" class="span12" />
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_ctp_1"></span>
											
										</div>
                                        <div class="span5">
											<label>Company Person Email <span class="f_req"></span></label>
											<input type="text" name="ctp_email_1" class="span12" />
										</div>
									</div>
									
								</div>
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Company Person Phone <span class="f_req">*</span></label>
											<input type="text" name="ctp_phone_1" class="span12" />
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_ctp_phone_1"></span>
											
										</div>
                                        <div class="span5">
											<label>Company Person Designation <span class="f_req"></span></label>
											<input type="text" name="ctp_designation_1" class="span12" />
										</div>
									</div>
									
								</div>
                                
                                
                                 <h3 class="heading">Contact Person: #2</h3>
								<div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Contact Person Name <span class="f_req"></span></label>
											<input type="text" name="ctp_2" class="span12" />
											
										</div>
                                        <div class="span5">
											<label>Company Person Email <span class="f_req"></span></label>
											<input type="text" name="ctp_email_2" class="span12" />
										</div>
									</div>
									
								</div>
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Company Person Phone <span class="f_req"></span></label>
											<input type="text" name="ctp_phone_2" class="span12" />
											
										</div>
                                        <div class="span5">
											<label>Company Person Designation <span class="f_req"></span></label>
											<input type="text" name="ctp_designation_2" class="span12" />
										</div>
									</div>
									
								</div>
                                
								<div class="formSep">
									<div class="row-fluid">
										<div class="span4">
											<label>Remark <span class="f_req"></span></label>
											<textarea name="remark" id="your_message" cols="10" rows="3" class="span12"></textarea>
										</div>
                          
									</div>
								</div>
								
								
								<div class="form-actions">
									<button class="btn btn-danger" type="submit" name="submit" value="Add Supplier" onclick="return <?php echo $ValidationFunctionName ?>();">Add Supplier</button>
									<button class="btn">Cancel</button>
								</div>
							</form>
                        </div>
                    </div>
            <?php
			break;
			case 'server':
			extract($_POST);
			
			
			
			$this->supplier_name = $supplier_name;
			$this->company_name = $company_name;
			$this->company_email = $company_email;
			$this->company_phone = $company_phone;
			$this->company_website = $company_website;
			$this->ctp_1 = $ctp_1;
			$this->ctp_email_1 = $ctp_email_1;
			$this->ctp_phone_1 = $ctp_phone_1;
			$this->ctp_designation_1 = $ctp_designation_1;
			$this->ctp_2 = $ctp_2;
			$this->ctp_email_2 = $ctp_email_2;
			$this->ctp_phone_2 =$ctp_phone_2;
			$this->ctp_designation_2 = $ctp_designation_2;
			$this->remark = $remark;
			
			$return = true;
			
		if($this->Form->ValidField($supplier_name,'empty','Please enter supplier name')==false)
		    $return =false;
		if($this->Form->ValidField($company_name,'empty','Please enter company name')==false)
			$return =false;
		if($this->Form->ValidField($company_phone,'empty','Please enter company phone')==false)
		    $return =false;
		if($this->Form->ValidField($ctp_1,'empty','Please enter contact person name')==false)
			$return =false;
		if($this->Form->ValidField($ctp_phone_1,'empty','Please enter contact person phone no.')==false)
			$return =false;
			
			
			
			/*
			`id`, `supplier_name`, `company_name`, `company_email`, `company_phone`, `company_website`, `ctp_1`, `ctp_email_1`, `ctp_phone_1`, `ctp_designation_1`, `ctp_2`, `ctp_email_2`, `ctp_phone_2`, `ctp_designation_2`, `remark`, `status`, `time_stamp`*/
			
			
			if($return){
							
							$insert_sql_array = array();
							$insert_sql_array['supplier_name'] = $this->supplier_name;
							$insert_sql_array['company_name'] = $this->company_name;
							$insert_sql_array['company_email'] = $this->company_email;
							$insert_sql_array['company_phone'] = $this->company_phone;
							$insert_sql_array['company_website'] = $this->company_website;
							$insert_sql_array['ctp_1'] = $this->ctp_1;
							$insert_sql_array['ctp_email_1'] =$this->ctp_email_1;
							$insert_sql_array['ctp_phone_1'] = $this->ctp_phone_1;
							
							$insert_sql_array['ctp_designation_1'] = $this->ctp_designation_1;
							$insert_sql_array['ctp_2'] = $this->ctp_2;
							$insert_sql_array['ctp_email_2'] =$this->ctp_email_2;
							$insert_sql_array['ctp_phone_2'] = $this->ctp_phone_2;
							$insert_sql_array['ctp_designation_2'] = $this->ctp_designation_2;
						    $insert_sql_array['remark'] = $this->remark;
							$this->db->insert(INFINITE_SUPPLIER,$insert_sql_array);
							
							$_SESSION['msg'] = 'Supplier Details has been Successfully Added';	
							
							?>
							<script type="text/javascript">
							window.location = 'add_supplier.php';
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->Add_Supplier('local');
							}
							
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
	
	function Show_all_supplier()
	{
		?>
        				<div class="row-fluid">
        				<div class="span12">
                        <a class="btn btn-danger" href="add_supplier.php" style="float:right;">Add Supplier</a>
                        </div>
                        </div>
        <div class="row-fluid">
        
                        <div class="span12">
                         <table class="table table-striped table-bordered dTableR" id="dt_a">
                                <thead>
                                    <tr>
                                        <th width="10%">S.No.</th>
                                        <th width="15%">Supplier Name</th>
                                        <th width="20%">Company Name</th>
                                        <th width="15%">Contact No.</th>
                                         <th width="25%">Contact Person [Contact No.]</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
							$i=1;
						    $sql = "select * from ".INFINITE_SUPPLIER." order by time_stamp";
							$record = $this->db->query($sql,__FILE__,__LINE__);
							while($row = $this->db->fetch_array($record))
							{
							?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $row['supplier_name'];?></td>
                                        <td><?php echo $row['company_name'];?></td>
                                         <td><?php echo $row['company_phone'];?></td> 
                                        <td><?php echo $row['ctp_1'];?> [ <?php echo $row['ctp_phone_1'];?> ]</td>
                                       <td>
            <a title="View" href="all_supplier.php?index=viewsupplier&sid=<?php echo $row['id'];?>"><i class="splashy-document_letter_new"></i></a>
            <a title="Edit" href="add_supplier.php?index=editSupplier&sid=<?php echo $row['id'];?>"><i class="splashy-document_letter_edit"></i></a>
            <?php
			if($row['status']=='active')
			{
			?>
                 <a title="Block" href="#" onclick="javascript: if(confirm('If you click on OK the Supplier status will be Block?')) { supplier_obj.blockSupplier('<?php echo $row['id'];?>',{}) }; return false;"><i class="splashy-document_letter_remove"></i></a>
              <?php
			}
			else
			{
			?>
             <a title="Active" href="#" onclick="javascript: if(confirm('If you click on OK the Supplier status will be Active?')) { supplier_obj.activeSupplier('<?php echo $row['id'];?>',{}) }; return false;"><i class="splashy-document_letter_okay"></i></a>
           
            <?php
			}
			?>
           
            
            <a title="Delete" href="#" onclick="javascript: if(confirm('If you click on OK the Supplier will be deleted?')) { supplier_obj.deleterSupplier('<?php echo $row['id'];?>',{}) }; return false;"><i class="splashy-contact_grey_remove"></i></a>
            
            
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
	
	
	
	function blockSupplier($id)
	{
				ob_start();
				
				$update_array = array();
				$update_array['status'] = 'block';
				
				$this->db->update(INFINITE_SUPPLIER,$update_array,'id',$id);
				$_SESSION['msg']='Supplier has been Blocked successfully';
				?>
				<script type="text/javascript">
					location.reload(true);
				</script>
				<?php
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
	}
	
	
	function activeSupplier($id)
	{
				ob_start();
				
				$update_array = array();
				$update_array['status'] = 'active';
				
				$this->db->update(INFINITE_SUPPLIER,$update_array,'id',$id);
				$_SESSION['msg']='Supplier has been Active successfully';
				?>
				<script type="text/javascript">
					location.reload(true);
				</script>
				<?php
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
	}
	
	function deleterSupplier($id)
	{
		ob_start();
		
		
		$sql="delete from ".INFINITE_SUPPLIER." where id='".$id."'";
		$this->db->query($sql,__FILE__,__LINE__);


		$_SESSION['msg']='Supplier has been deleted successfully';
				?>
				<script type="text/javascript">
					location.reload(true);
				</script>
				<?php
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
				
	}
	
	
	function view_supplier($sid)
	{
		 				$sql = "select * from ".INFINITE_SUPPLIER." where id='".$sid."'";
						$record = $this->db->query($sql,__FILE__,__LINE__);
						$row = $this->db->fetch_array($record);
							
		?>
         
        <div class="row-fluid">
                        <div class="span12">
                            <h3 class="heading">Company Profile</h3>
                            <div class="row-fluid">
                                <div class="span8">
                                    <form class="form-horizontal">
                                        <fieldset>
                                        <?php
										if($row['supplier_name']!='')
										{
											?>
                                            <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"> <strong>Supplier Name:</strong></label>
                                                <div class="controls text_line">
                                                   <?php echo $row['supplier_name'];?>
                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                         <?php
										if($row['company_name']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Company Name:</strong></label>
                                                <div class="controls text_line">
                                                    <?php echo $row['company_name'];?>
                                                </div>
                                            </div>
                                          <?php
										}
										?>
                                        <?php
										if($row['company_email']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Email:</strong></label>
                                                <div class="controls text_line">
                                                     <?php echo $row['company_email'];?>
                                                </div>
                                            </div>
                                         <?php
										}
										?>
                                         <?php
										if($row['company_phone']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Contact No.:</strong></label>
                                                <div class="controls text_line">
														 <?php echo $row['company_phone'];?>                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                         <?php
										if($row['company_website']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Website:</strong></label>
                                                <div class="controls text_line">
                                                    <?php echo $row['company_website'];?>
                                                </div>
                                            </div>
                                          <?php
										}
										?>
                                         <?php
										if($row['ctp_1']!='')
										{
											?>
                                            <h3 class="heading">Contact Person: #1</h3>
                                            <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Person Name:</strong></label>
                                                <div class="controls text_line">
                                                   <?php echo $row['ctp_1'];?>
                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                         <?php
										if($row['ctp_email_1']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Email:</strong></label>
                                                <div class="controls text_line">
                                                     <?php echo $row['ctp_email_1'];?>
                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                            
                                             <?php
										if($row['ctp_phone_1']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Contact No.:</strong></label>
                                                <div class="controls text_line">
                                                     <?php echo $row['ctp_phone_1'];?>
                                                </div>
                                            </div>
                                            <?php
											
										}
										?>
                                         <?php
										if($row['ctp_designation_1']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Designation:</strong></label>
                                                <div class="controls text_line">
                                                    <?php echo $row['ctp_designation_1'];?>
                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                        <?php
										if($row['ctp_2']!='')
										{
											?>
                                            
                                             <h3 class="heading">Contact Person: #2</h3>
                                            <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Person Name:</strong></label>
                                                <div class="controls text_line">
                                                     <?php echo $row['ctp_2'];?>                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                        <?php
										if($row['ctp_email_2']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Email:</strong></label>
                                                <div class="controls text_line">
                                                   <?php echo $row['ctp_email_2'];?>
                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                        <?php
										if($row['ctp_phone_2']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Contact No.:</strong></label>
                                                <div class="controls text_line">
                                                    <?php echo $row['ctp_phone_2'];?>
                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                        <?php
										if($row['ctp_designation_2']!='')
										{
											?>
                                             <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Designation:</strong></label>
                                                <div class="controls text_line">
                                                    <?php echo $row['ctp_designation_2'];?>
                                                </div>
                                            </div>
                                            <?php
										}
										?>
                                            <?php
										if($row['remark']!='')
										{
											?>
                                            <div class="control-group formSep" style="margin-bottom:2px; padding-bottom:2px;">
                                                <label class="control-label"><strong>Remark:</strong></label>
                                                <div class="controls text_line">
                                                     <?php echo $row['remark'];?>
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
	
	
	
	function Edit_Supplier($runat,$sid)
	{
		switch($runat)
		{
		
			case 'local':
			$FormName = "form_edit";
							$ControlNames=array("supplier_name"			=>array('supplier_name',"''","Kindly enter supplier name","span_supplier_name"),
												"company_name"			=>array('company_name',"''","Kindly enter company name","span_company_name"),
												"company_phone"			=>array('company_phone',"''","Kindly enter company phone","span_company_phone"),
												"ctp_1"			=>array('ctp_1',"''","Kindly enter contact person name","span_ctp_1"),
												"ctp_phone_1"			=>array('ctp_phone_1',"''","Kindly enter contact person name phone","span_ctp_phone_1")
												);
	
							$ValidationFunctionName="CheckEditnValidity";
						
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
							
							$sql = "select * from ".INFINITE_SUPPLIER." where id='".$sid."'";
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
							<h3 class="heading">Supplier Company Details</h3>
							<form class="form_validation_ttip" action="" method="post" name="<?php echo $FormName ?>">
								<div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Supplier Name <span class="f_req">*</span></label>
											<input type="text" name="supplier_name" class="span12" value="<?php echo $row['supplier_name'];?>" />
											<span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_supplier_name"></span>
										</div>
                                        <div class="span5">
											<label>Company Name <span class="f_req">*</span></label>
											<input type="text" name="company_name" class="span12" value="<?php echo $row['company_name'];?>"/>
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_company_name"></span>
										</div>
									</div>
									
								</div>
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Company Email <span class="f_req"></span></label>
											<input type="text" name="company_email" class="span12" value="<?php echo $row['company_email'];?>"/>
											
										</div>
                                        <div class="span5">
											<label>Company Phone <span class="f_req">*</span></label>
											<input type="text" name="company_phone" class="span12" value="<?php echo $row['company_phone'];?>"/>
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_company_phone"></span>
										</div>
									</div>
									
								</div>
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Company Website <span class="f_req"></span></label>
											<input type="text" name="company_website" class="span12" value="<?php echo $row['company_website'];?>" />
											
										</div>
                                   </div>
								</div>
                                
                                <h3 class="heading">Contact Person: #1</h3>
								<div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Contact Person Name <span class="f_req">*</span></label>
											<input type="text" name="ctp_1" class="span12" value="<?php echo $row['ctp_1'];?>" />
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_ctp_1"></span>
											
										</div>
                                        <div class="span5">
											<label>Company Person Email <span class="f_req"></span></label>
											<input type="text" name="ctp_email_1" class="span12" value="<?php echo $row['ctp_email_1'];?>"/>
										</div>
									</div>
									
								</div>
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Company Person Phone <span class="f_req">*</span></label>
											<input type="text" name="ctp_phone_1" class="span12" value="<?php echo $row['ctp_phone_1'];?>"/>
                                            <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_ctp_phone_1"></span>
											
										</div>
                                        <div class="span5">
											<label>Company Person Designation <span class="f_req"></span></label>
											<input type="text" name="ctp_designation_1" class="span12" value="<?php echo $row['ctp_designation_1'];?>"/>
										</div>
									</div>
									
								</div>
                                
                                
                                <h3 class="heading">Contact Person: #2</h3>
								<div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Contact Person Name <span class="f_req"></span></label>
											<input type="text" name="ctp_2" class="span12" value="<?php echo $row['ctp_2'];?>"/>
											
										</div>
                                        <div class="span5">
											<label>Company Person Email <span class="f_req"></span></label>
											<input type="text" name="ctp_email_2" class="span12" value="<?php echo $row['ctp_email_2'];?>"/>
										</div>
									</div>
									
								</div>
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Company Person Phone <span class="f_req"></span></label>
											<input type="text" name="ctp_phone_2" class="span12" value="<?php echo $row['ctp_phone_2'];?>"/>
											
										</div>
                                        <div class="span5">
											<label>Company Person Designation <span class="f_req"></span></label>
											<input type="text" name="ctp_designation_2" class="span12" value="<?php echo $row['ctp_designation_2'];?>"/>
										</div>
									</div>
									
								</div>
                                
								<div class="formSep">
									<div class="row-fluid">
										<div class="span4">
											<label>Remark <span class="f_req"></span></label>
											<textarea name="remark" id="your_message" cols="10" rows="3" class="span12"><?php echo $row['ctp_2'];?></textarea>
										</div>
                          
									</div>
								</div>
                                
								
								
								
								<div class="form-actions">
									<button class="btn btn-danger" type="submit" name="submited" value="Edit Supplier" onclick="return <?php echo $ValidationFunctionName ?>();">Edit Supplier</button>
									<button class="btn">Cancel</button>
								</div>
							</form>
                        </div>
                    </div>
            <?php
			break;
			case 'server':
			extract($_POST);
			
			
			
			$this->supplier_name = $supplier_name;
			$this->company_name = $company_name;
			$this->company_email = $company_email;
			$this->company_phone = $company_phone;
			$this->company_website = $company_website;
			$this->ctp_1 = $ctp_1;
			$this->ctp_email_1 = $ctp_email_1;
			$this->ctp_phone_1 = $ctp_phone_1;
			$this->ctp_designation_1 = $ctp_designation_1;
			$this->ctp_2 = $ctp_2;
			$this->ctp_email_2 = $ctp_email_2;
			$this->ctp_phone_2 =$ctp_phone_2;
			$this->ctp_designation_2 = $ctp_designation_2;
			$this->remark = $remark;
			
			$return = true;
			
		if($this->Form->ValidField($supplier_name,'empty','Please enter supplier name')==false)
		    $return =false;
		if($this->Form->ValidField($company_name,'empty','Please enter company name')==false)
			$return =false;
		if($this->Form->ValidField($company_phone,'empty','Please enter company phone')==false)
		    $return =false;
		if($this->Form->ValidField($ctp_1,'empty','Please enter contact person name')==false)
			$return =false;
		if($this->Form->ValidField($ctp_phone_1,'empty','Please enter contact person phone no.')==false)
			$return =false;
			
			
			if($return){
							
							$update_sql_array = array();
							$update_sql_array['supplier_name'] = $this->supplier_name;
							$update_sql_array['company_name'] = $this->company_name;
							$update_sql_array['company_email'] = $this->company_email;
							$update_sql_array['company_phone'] = $this->company_phone;
							$update_sql_array['company_website'] = $this->company_website;
							$update_sql_array['ctp_1'] = $this->ctp_1;
							$update_sql_array['ctp_email_1'] =$this->ctp_email_1;
							$update_sql_array['ctp_phone_1'] = $this->ctp_phone_1;
							
							$update_sql_array['ctp_designation_1'] = $this->ctp_designation_1;
							$update_sql_array['ctp_2'] = $this->ctp_2;
							$update_sql_array['ctp_email_2'] =$this->ctp_email_2;
							$update_sql_array['ctp_phone_2'] = $this->ctp_phone_2;
							$update_sql_array['ctp_designation_2'] = $this->ctp_designation_2;
						    $update_sql_array['remark'] = $this->remark;
							$this->db->update(INFINITE_SUPPLIER,$update_sql_array,'id',$sid);
							
							$_SESSION['msg'] = 'Supplier Details has been Successfully Updated';	
							
							?>
							<script type="text/javascript">
							window.location = 'all_supplier.php';
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->Edit_Supplier('local',$sid);
							}
							
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
	
	
	
}
?>