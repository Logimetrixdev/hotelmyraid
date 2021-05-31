<?php

/* 
 * This class is responcible for the master values of taxes included in all hotel activity
 * Author: Abhishek Kumar Mishra
 * Created Date: 31/3/2014
 */

class MasterTaxClass
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
	
	
	function TaxValuesManagement()
	{
		
		?>
                <div class="col-md-9">
                <div class="block-flat" style="min-height:550px;">
                <div class="header">							
                <h4>Manage All Taxes</h4>
                </div>
                <div class="content">
               
			  <div class="col-md-12" style="padding-bottom:7px;">
			  <div class="col-sm-2">
              <strong>S. No.</strong>
	          </div>
			  <div class="col-sm-3">
              <strong>Tax Name</strong>
			  </div>
              <div class="col-sm-3">
              <strong>Tax Value</strong>
			  </div>
              <div class="col-sm-2">
              <strong>Tax For</strong>
			  </div>
              <div class="col-sm-2">
              <strong>Action</strong>
			  </div>
			  </div>
              <?php
				$sql="select * from ".HMS_TAXS." order by used_for";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$cnt = $this->db->num_rows($result);
				if($cnt>0)
				{
							$x=1;
							while($row = $this->db->fetch_array($result))
							{
							?>
           
							<div class="col-md-12" style="height:40px;">
							<div class="col-sm-2">
							<?php echo $x;?>
							</div>
							<div class="col-sm-3">
							<?php echo $row['tax_name'];?>
							</div>
							<div class="col-sm-3">
							<?php echo $row['percent_value'];?>%
                           
							</div>
                            <div class="col-sm-2">
							<?php if($row['used_for']=='b') { echo 'Banquet';} else{ echo 'Room';}?>
                            </div>
							<div class="col-sm-2">
							<a class="btn btn-primary btn-flat" href="managetaxes.php?index=editTax&tax_id=<?php echo $row['id'];?>">Edit Tax</a>
							</div>
							</div>
         
							<?php
							$x++;
							}
				}
				else
				{
							?>
                            <div class="col-md-12">
							<h4>Sorry! No Tax Available.</h4>
							</div>
                            <?php
				}
				?>
              
                </div>
                </div>
                </div>
        <?php
	}
	
	
	function EditTaxValues($tax_id)
	{
			$FormName = "frm_tax";
						$ControlNames=array("tax_name"        =>array('tax_name',"","kindly enter tax name","span_tax_name"),
						"percent_value"        =>array('percent_value',"","kindly enter tax value","span_percent_value")
						);
                            $ValidationFunctionName="ChecktaxValidity";
					
						$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
						echo $JsCodeForFormValidation;
		
		?>
        <form  enctype="multipart/form-data" action="" class="form-horizontal group-border-dashed" method="post" name="<?php echo $FormName;?>">
                <div class="col-md-9">
                <div class="block-flat" style="min-height:350px;">
                <div class="header">							
                <h4>Manage <?php echo $this->Master->GetTaxType($tax_id);?></h4>
                </div>
                <div class="content">
               <div class="form-group">
			  <div class="col-md-12" >
			  <div class="col-sm-4">
              <strong>Tax Name</strong>
	          </div>
			  <div class="col-sm-8">
              <input type="text" name="tax_name" value="<?php echo $this->Master->GetTaxType($tax_id);?>"/>
              <span style="color:#F00; font-weight:600;" id="span_tax_name"></span>
			  </div>
               </div>
               </div>
               <div class="form-group">
                <div class="col-md-12" style="margin-top:3px;">
			  <div class="col-sm-4">
              <strong>Tax Value</strong>
	          </div>
			  <div class="col-sm-8">
              <input type="text" name="percent_value" value="<?php echo $this->Master->GetTaxValue($tax_id);?>"/> (only persent value)
              <span style="color:#F00; font-weight:600;" id="span_percent_value"></span>
			  </div>
               </div>
               </div>
               <div class="form-group">
             <div class="col-md-12" style="padding-bottom:7px; height:30px;">
			  <div class="col-sm-4">
              
	          </div>
			  <div class="col-sm-8">
              <input type="button" class="btn btn-primary btn-flat" name="edittax" value="Edit Tax" onclick=" if(<?php echo $ValidationFunctionName ?>()) {tax_obj.editaxdeatils(this.form.tax_name.value,this.form.percent_value.value,'<?php echo $tax_id;?>',{}); } "/>
			  </div>
               </div>
           </div>
              
                </div>
                </div>
                </div>
                </form>
        <?php
		
	}
	
	
	function editaxdeatils($taxName, $tax_value, $tax_id)
	{
		ob_start();
		
			$update_sql_array2 = array();
			$update_sql_array2['tax_name'] = $taxName;
			$update_sql_array2['percent_value'] = $tax_value;
			$this->db->update(HMS_TAXS,$update_sql_array2,'id',$tax_id);
			$_SESSION['msg'] = $taxName.' is successfully updated to '.$tax_value.'%';
			?>
			<script>
			window.location='managetaxes.php'
			</script>
		    <?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;	
	}
	

}