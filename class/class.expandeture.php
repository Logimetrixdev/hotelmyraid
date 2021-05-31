<?php

 /***********************************************************************************

Class Discription : This class will handle the expandetures . Like Add Expendetures, Show all Profits, Show All Expences

Functions : addExpenses(); This is use to Add Expenses
			showAllProfit(); this use to Show all Profits
			showExpenses(); this use to show All Expenses
************************************************************************************/
class expandeture
{
	function __construct()
	{
					$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
					$this->validity = new ClsJSFormValidation();
					$this->Form = new ValidateForm();
					$this->auth=new Authentication();
					$this->noti=new Notification();
	}
	
	function addExpenses($runat)
	{
		switch($runat)
		
		{
		
			case 'local':
			$FormName = "form_login";
							$ControlNames=array("given_to"			=>array('given_to',"''","Kindly enter a name.","span_given_to"),
												"given_by"			=>array('given_by',"''","Kindly enter a name.","span_given_by"),
												"given_amount"			=>array('given_amount',"''","Kindly enter an amount.","span_given_amount"),
												"given_date"			=>array('given_date',"''","Kindly select a date.","span_given_date")
												
												);
	
							$ValidationFunctionName="CheckLoginValidity";
						
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
							
							 $sql = "select * from ".INFINITE_CLIENT." where id = '".$clientId."'";
							$record = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($record);
			?>
            <div class="row-fluid">
        				<div class="span10">
                        <a class="btn btn-danger" href="expenses.php" style="float:right;">View All Records</a>
                        </div>
                        </div>
                        
            <div class="row-fluid" >
                        <div class="span10">
							<h3 class="heading">Expendeture Details</h3>
							<form  enctype="multipart/form-data" action="" method="post" name="<?php echo $FormName ?>">
								<div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Given To <span class="f_req">*</span></label>
											<input type="text" name="given_to"  value="<?php echo $_REQUEST['given_to']; ?>" class="span12" />
											 <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_given_to"></span>
										</div>
									</div>
                                  </div>
                                  
                                <div class="formSep">
									<div class="row-fluid">
										<div class="span5">
											<label>Given By<span class="f_req"></span></label>
											<input type="text" name="given_by" value="<?php echo $_REQUEST['given_by']; ?>" class="span12" />
											 <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_given_by"></span> 
										</div>
                                        </div>
                                        </div>
                                         <div class="formSep">
                                         <div class="row-fluid">
                                        <div class="span5">
											<label>Amount<span class="f_req"></span></label>
											<input type="text" value="<?php echo $_REQUEST['amount']; ?>" name="given_amount" class="span12" />
                                           <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_given_amount"></span>
										</div>
									</div>
									</div>
                                    <div class="formSep">
                                         <div class="row-fluid">
                                        <div class="span5">
											<label>Given date<span class="f_req"></span></label>
											<input type="text" id="" value="<?php echo date("d-m-Y") ?>" readonly="readonly" name="given_date" class="span12" />
                                           <span style="color:#F00; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600;" id="span_given_date"></span>
										</div>
									</div>
									</div>
							
                                
                                <div class="form-actions">
								<button class="btn btn-danger" type="submit" name="submit" value="submit" onclick="return <?php echo $ValidationFunctionName?>();">Submit</button>
								</div>
							</form>
                        </div>
                    </div>
            <?php
			break;
			case 'server':
			extract($_POST);
			
			$this->given_to = $given_to;
			$this->given_by = $given_by;
			$this->given_amount = $given_amount;
			$this->given_date = $given_date;
			
			$return = true;
			if($this->Form->ValidField($given_to,'empty','Please enter a name.')==false)
		    $return =false;
			if($this->Form->ValidField($given_by,'empty','Please enter a name.')==false)
		    $return =false;
			if($this->Form->ValidField($given_amount,'empty','Please enter an amount.')==false)
		    $return =false;
			if($this->Form->ValidField($given_date,'empty','Please select a date.')==false)
		    $return =false;
		
			if($return){
							$insert_sql_array = array();
							$insert_sql_array['user_id'] = $_SESSION['user_id'];
							$insert_sql_array['given_to'] = $this->given_to;
							$insert_sql_array['given_by'] = $this->given_by;
							$insert_sql_array['given_amount'] = $this->given_amount;
							$insert_sql_array['given_date'] = $this->given_date;
							$this->db->insert(INFINITE_EXPENSES,$insert_sql_array);
						
							$_SESSION['msg'] = 'Expendeture Details has been Successfully Added';	
							
							?>
							<script type="text/javascript">
							window.location = 'expences.php';
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->submitDebt('local');
							}
							
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
	
	function showAllProfit()
	{
					$sql="select * from ".INFINITE_INVOICE_PRE." order by invoice_date";
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
					
					$sql_pro="select * from ".INFINITE_INVOICE_PRE;
					$result_pro= $this->db->query($sql_pro,__FILE__,__LINE__);
					while($row_pro = $this->db->fetch_array($result_pro))
					{
						$profit=$profit+$row_pro['total_profit'];
					}
		?>
        				
                        <div class="span11">
                         <h2> All Selling Record</h2>
                       <hr />
                      
                         <table class="table table-striped table-bordered dTableR" >
                                <thead>
                                    <tr>
                                        <th width="9%">S.No.</th>
                                        <th width="15%">Invoice No.</th>
                                        <th width="15%">Invoice Date</th>
                                        <th width="15%">Supplier Price </th>
                                         <th width="15%">Client Price</th>
                                         
                                          <th width="15%">Paid Amount</th>
                                           <th width="15%">Net Profit/Loss</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
								$total_profit=0;
						$result= $this->db->query($sql,__FILE__,__LINE__);
						$cnt = $this->db->num_rows($result);
						if($cnt>0)
						{
						$x=1;
							while($row = $this->db->fetch_array($result))
							{
								
							?>	
                                    <tr>
                                        <td><?php echo $x;?></td>
                                        <td><?php echo $row['invoice_id'];?></td>
                                        <td><?php echo $row['invoice_date'];?></td>
                                         <td>&#8377;&nbsp;&nbsp; <?php echo number_format($row['total_supplier_price'],2);?></td>
                                          <td>&#8377;&nbsp;&nbsp; <?php echo number_format($row['total_client_price'],2);?></td>
                                          
                                       	 <td>&#8377;&nbsp;&nbsp; <?php echo number_format($row['amount_paid'],2);?></td>
                                         <td><?php echo number_format($row['total_profit'],2); if($row['total_profit']>0) echo'(Profit)'; elseif($row['total_profit']<0) echo '(Loss)'; else echo 'NP/NA'?></td>
                                    </tr>
                            <?php
							$i++;
								$total_profit = $total_profit+$row['total_profit'];
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
                            <?php echo '<h3 align="right">Total Profit : '.$total_profit.'</h3>'; ?>
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
			
				<a href="expandeture.php" class="btn btn-info">&laquo;&laquo;</a>
<a href="expandeture.php<?php if($pgr >=2 ) {echo '?pg=';echo $pgr-1; } else { echo $pg; }?>" class="btn btn-info">&laquo;</a>
				
				<?php if($pgr == $lastpage && ($pgr-4) >= 1 ) { ?>
				<a href="expandeture.php?pg=<?php echo $pgr-4;?>" class="btn btn-info"><?php echo $pgr-4; ?></a>
				<?php } ?>
				
				<?php if($pgr == $lastpage || $pgr == $lastpage-1) { 
				if(($pgr-3) >= 1){
				?>
				<a href="expandeture.php?pg=<?php echo $pgr-3;?>" class="btn btn-info"><?php echo $pgr-3; ?></a>
				<?php } }?>
				
				<?php $temp0=$pgr-2;
					if($temp0 >= 1) {				
				?>
				<a href="expandeture.php?pg=<?php echo $pgr-2;?>" class="btn btn-info"><?php echo $pgr-2;?></a>
				<?php } ?>
				
				<?php $temp1=$pgr-1;
					if($temp1 >= 1) {				
				?>
				<a href="expandeture.php?pg=<?php echo $pgr-1;?>" class="btn btn-info"><?php echo $pgr-1;?></a>
				<?php } ?>
				
				<a href="expandeture.php?pg=<?php if($pgr !='') {echo $pgr;} else { echo 1; }?>" class="btn btn-info active"><?php if($pgr !='') {echo $pgr;} else { echo 1; }?></a>
				
				<?php $temp2=$pgr+1;
					if($temp2 <= $lastpage) {				
				?>
				<a href="expandeture.php?pg=<?php echo $pgr+1;?>" class="btn btn-info"><?php echo $pgr+1;?></a>
				<?php } ?>
				<?php $temp3=$pgr+2;
					if($temp3 <= $lastpage) {				
				?>
				<a href="expandeture.php?pg=<?php echo $pgr+2;?>" class="btn btn-info"><?php echo $pgr+2;?></a>
				<?php } ?>
				
				<?php if($pgr == 1 || $pgr == 2) { 
				if(($pgr+3) <= $lastpage) {
				?>
				<a href="expandeture.php?pg=<?php echo $pgr+3;?>" class="btn btn-info"><?php echo $pgr+3; ?></a>
				<?php } }?>
				
				<?php if($pgr == 1 && ($pgr+4) <= $lastpage) { ?>
				<a href="expandeture.php?pg=<?php echo $pgr+4;?>" class="btn btn-info"><?php echo $pgr+4; ?></a>
				<?php } ?>
				
				<a href="expandeture.php?pg=<?php echo $pgr+1;?>" class="btn btn-info">&raquo;</a>
				
				<a href="expandeture.php?pg=<?php echo $lastpage;?>" class="btn btn-info">&raquo;&raquo;</a>
			</div>
            </div>
             <div align="right">Total Pages - <?php echo $lastpage;?></div>
			<div align="right">Total Records - <?php echo $numpages;?></div>
                        </div>
        <?php
	}
	
	function searchProfit()
	{
		?>
        <form class="well form-inline">
        
										<p class="f_legend">Inline form</p>
										<div class="span3">
								<div class="input-append" id="">
									<input class="span6" type="text" class="datepicker"  /><span class="add-on"><i class="splashy-calendar_day_up"></i></span>
								</div>
								<span class="help-block">Daterange - date start</span>
							</div>
							<div class="span3">
								<div class="input-append date" id="dp_end">
									<input class="span6" type="text" readonly="readonly" /><span class="add-on"><i class="splashy-calendar_day_down"></i></span>
								</div>
								<span class="help-block">Daterange - date end</span>
							</div>
									</form>
        <?php
	}
	
	
	function showExpenses()
	{
		
					$sql="select * from ".INFINITE_EXPENSES." order by given_date";
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
					
					$exp=0;
					$sql_exp="select * from ".INFINITE_EXPENSES;
					$result_exp= $this->db->query($sql_exp,__FILE__,__LINE__);
					while($row_exp = $this->db->fetch_array($result_exp))
					{
						$exp=$exp+$row_exp['given_amount'];
					}
		?>
        			<div class="row-fluid">
        				<div class="span10">
                        <a class="btn btn-danger" href="expences.php?index=add_expenses" style="float:right;">Add Expenses</a>
                        </div>
                        </div>
        
                        <div class="span10">
                         <h2> All Expenses Record</h2>
                         
                       <hr />
                        <h2> Total Expenses : <?php echo $exp; ?></h2>
                        <hr />
                         <table class="table table-striped table-bordered dTableR" >
                                <thead>
                                    <tr>
                                        <th width="9%">S.No.</th>
                                        <th width="20%">Given By</th>
                                        <th width="20%">Given To</th>
                                        <th width="15%">Given Date </th>
                                         <th width="15%">Given Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
								$total_exp=0;
						$result= $this->db->query($sql,__FILE__,__LINE__);
						$cnt = $this->db->num_rows($result);
						if($cnt>0)
						{
						$x=1;
							while($row = $this->db->fetch_array($result))
							{
								
							?>	
                                    <tr>
                                        <td><?php echo $x;?></td>
                                        <td><?php echo $row['given_by'];?></td>
                                        <td><?php echo $row['given_to'];?></td>
                                         <td><?php echo $row['given_date'];?></td>
                                          <td>&#8377;&nbsp;<?php echo number_format($row['given_amount'],2);?></td>
                                        
                                       
                                    </tr>
                            <?php
							$x++;
								$total_exp = $total_exp+$row['given_amount'];
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
                            <?php echo '<h3 align="right">Total Expenses : '.$total_exp.'</h3>'; ?>
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
			
				<a href="expences.php" class="btn btn-info">&laquo;&laquo;</a>
<a href="expences.php<?php if($pgr >=2 ) {echo '?pg=';echo $pgr-1; } else { echo $pg; }?>" class="btn btn-info">&laquo;</a>
				
				<?php if($pgr == $lastpage && ($pgr-4) >= 1 ) { ?>
				<a href="expences.php?pg=<?php echo $pgr-4;?>" class="btn btn-info"><?php echo $pgr-4; ?></a>
				<?php } ?>
				
				<?php if($pgr == $lastpage || $pgr == $lastpage-1) { 
				if(($pgr-3) >= 1){
				?>
				<a href="expences.php?pg=<?php echo $pgr-3;?>" class="btn btn-info"><?php echo $pgr-3; ?></a>
				<?php } }?>
				
				<?php $temp0=$pgr-2;
					if($temp0 >= 1) {				
				?>
				<a href="expences.php?pg=<?php echo $pgr-2;?>" class="btn btn-info"><?php echo $pgr-2;?></a>
				<?php } ?>
				
				<?php $temp1=$pgr-1;
					if($temp1 >= 1) {				
				?>
				<a href="expences.php?pg=<?php echo $pgr-1;?>" class="btn btn-info"><?php echo $pgr-1;?></a>
				<?php } ?>
				
				<a href="expences.php?pg=<?php if($pgr !='') {echo $pgr;} else { echo 1; }?>" class="btn btn-info active"><?php if($pgr !='') {echo $pgr;} else { echo 1; }?></a>
				
				<?php $temp2=$pgr+1;
					if($temp2 <= $lastpage) {				
				?>
				<a href="expences.php?pg=<?php echo $pgr+1;?>" class="btn btn-info"><?php echo $pgr+1;?></a>
				<?php } ?>
				<?php $temp3=$pgr+2;
					if($temp3 <= $lastpage) {				
				?>
				<a href="expences.php?pg=<?php echo $pgr+2;?>" class="btn btn-info"><?php echo $pgr+2;?></a>
				<?php } ?>
				
				<?php if($pgr == 1 || $pgr == 2) { 
				if(($pgr+3) <= $lastpage) {
				?>
				<a href="expences.php?pg=<?php echo $pgr+3;?>" class="btn btn-info"><?php echo $pgr+3; ?></a>
				<?php } }?>
				
				<?php if($pgr == 1 && ($pgr+4) <= $lastpage) { ?>
				<a href="expences.php?pg=<?php echo $pgr+4;?>" class="btn btn-info"><?php echo $pgr+4; ?></a>
				<?php } ?>
				
				<a href="expences.php?pg=<?php echo $pgr+1;?>" class="btn btn-info">&raquo;</a>
				
				<a href="expences.php?pg=<?php echo $lastpage;?>" class="btn btn-info">&raquo;&raquo;</a>
			</div>
            </div>
             <div align="right">Total Pages - <?php echo $lastpage;?></div>
			<div align="right">Total Records - <?php echo $numpages;?></div>
            
                        </div>
                    
        <?php
		
	
	}
	
	
}
?>