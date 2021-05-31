<?php
  class User
  {
	 				function __construct(){
					$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
					$this->validity = new ClsJSFormValidation();
					$this->Form = new ValidateForm();
					$this->auth=new Authentication();
					$this->noti=new Notification();
					$this->Master=new MasterClass();
					$this->objMail = new PHPMailer();
				}
	
	 				 function AdminMainLogin($runat)
					 {
								switch($runat)
								{
												case 'local':
												$FormName = "form_AdminMainLogin";
							$ControlNames=array("adminuser"			=>array('adminuser',"''","Kindly enter user name!","span_adminuser"),
												"password"			=>array('password',"''","Kindly enter password!","span_password")
												);
	
							$ValidationFunctionName="CheckAdminMainLoginValidity";
						
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
												?>
												<div class="block-flat">
			<div class="header">							
				<h3 class="text-center">Admin Login</h3>
			</div>
			<div>
				<form style="margin-bottom: 0px !important;" class="form-horizontal" method="post" enctype="multipart/form-data" name="<?php echo $FormName ?>" action="">
					<div class="content">
						<h4 class="title">Login Access</h4>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group" style="margin-bottom:5px;">
										<span class="input-group-addon"><i class="fa fa-user"></i></span>
										<input type="text" placeholder="Username" id="username" name="adminuser"  class="form-control">
									</div>
                                    <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-weight:600; font-size:13px" id="span_adminuser"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group" style="margin-bottom:5px;">
										<span class="input-group-addon"><i class="fa fa-lock"></i></span>
										<input type="password" placeholder="Password" id="password" name="password"  class="form-control">
									</div>
                                    <span style="color:#F63233; font-weight:600;  font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:13px" id="span_password" ></span>
								</div>
							</div>
							
					</div>
					<div class="foot">
                    <a href="../forget_password.php"><span style=" color: #2494F2;float: left;font-size: 14px;font-weight: 600; text-decoration: underline;">Ohh.. Password Lost?</span></a>
						<button class="btn btn-primary" data-dismiss="modal" type="submit" name="submit" value="Log In" onclick="return <?php echo $ValidationFunctionName ?>();">Log me in</button>
					</div>
				</form>
			</div>
		</div>
	<?php
                          	break;
							case 'server':
							extract($_POST);
							
							$this->adminuser = $adminuser;
						    $this->password = $password;
							
						$return =true;
						if($this->Form->ValidField($adminuser,'empty','Please Enter User Name')==false)
							$return =false;
						if($this->Form->ValidField($password,'empty','Please Enter Your Password')==false)
							$return =false;
							
							if($return){
						    $sql = "select * from ".HMS_USER." where username='".$adminuser."'";
							$record = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($record);
							if($this->adminuser == $row['username'] and $this->password == $row['password'])
								{
									switch($row['user_type_id'])
									{
										case 3:
										$_SESSION['error_msg']='You are not allowed here kindly login from front desk';
										?>
										<script type="text/javascript">
										window.location="index.php";
										</script>
										<?php
										exit();
										break;
										default:
											if($row['status'] == 2)
											{
											$_SESSION['error_msg']='User Blocked ! Contact Administrator ..';
											?>
											<script type="text/javascript">
											window.location="index.php";
											</script>
											<?php
											exit();
											}
											
											else
											{
											$this->user_id= $row['id'];
											$this->user_type= $row['user_type_id'];
											
											$this->auth->Create_Session($this->adminuser,$this->user_id,'',$this->user_type);
											$_SESSION['msg']='You are successfully logged In...';
											?>
											<script type="text/javascript">
											window.location="../dashboard.php";
											</script>
											<?php
											}
									break;
									}
								}
								else
									{
									$_SESSION['error_msg']='Invalid login credential please try again..';
								}
							?>
							<script type="text/javascript">
							window.location="<?php echo $_SERVER['PHP_SELF'] ?>";
							</script>
							<?php
							}
							else
							{
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->AdminMainLogin('local');
							}
							break;
							default:
							echo "No Argument";
							break;
							
						}
								
					}
					 function AdminLogin($runat)
					 {
								switch($runat)
								{
												case 'local':
												$FormName = "form_login";
							$ControlNames=array("adminuser"			=>array('adminuser',"''","Kindly enter user name!","span_adminuser"),
												"password"			=>array('password',"''","Kindly enter password!","span_password")
												);
	
							$ValidationFunctionName="CheckLoginValidity";
						
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
												?>
												<form method="post" action="" enctype="multipart/form-data" id="" name="<?php echo $FormName ?>" > 
 <input type="text" id="txtUser" name="adminuser" placeholder="Username" />
 <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_adminuser"></span>	
 <input type="password" id="txtPassword" name="password" placeholder="Password" style="margin-top:15px;" /> 
  
 <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:12px" id="span_password"></span> 
 <a href="forget_password.php"><span style=" color: #2494F2;float: left;font-size: 14px;font-weight: 600; text-decoration: underline; margin-top:20px;">Ohh.. Password Lost?</span></a>
 <input type="submit" name="submit" value="Log In" style="box-sizing: border-box;
overflow: visible;
-moz-user-select: none;
    background-color: #FFFFFF;
    color: #333333;
    border-radius: 0;
    box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.12), 1px 1px 0 rgba(255, 255, 255, 0.2) inset;
    font-size: 13px;
    margin-bottom: 5px !important;
    margin-left: 180px;
    outline: medium none;
	cursor:pointer;
    padding: 3px 9px; height:auto; width:auto; font-weight:600; margin-top:10px;" onclick="return <?php echo $ValidationFunctionName ?>();"/>
 </form>
	<?php
                          	break;
							case 'server':
							extract($_POST);
							
							$this->adminuser = $adminuser;
						    $this->password = $password;
							
						$return =true;
						if($this->Form->ValidField($adminuser,'empty','Please Enter User Name')==false)
							$return =false;
						if($this->Form->ValidField($password,'empty','Please Enter Your Password')==false)
							$return =false;
							
							if($return){
						    $sql = "select * from ".HMS_USER." where username='".$adminuser."'";
							$record = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($record);
							if($this->adminuser == $row['username'] and $this->password == $row['password'])
								{
									switch($row['user_type_id'])
									{
										case 1:
										$_SESSION['error_msg']='Kindly login from here for accessing full features.';
										?>
										<script type="text/javascript">
										window.location="admin_login/index.php";
										</script>
										<?php
										exit();
										break;
										case 2:
										$_SESSION['error_msg']='Kindly login from here for accessing full features.';
										?>
										<script type="text/javascript">
										window.location="admin_login/index.php";
										</script>
										<?php
										exit();
										break;
										default:
											if($row['status'] == 2)
											{
											$_SESSION['error_msg']='User Blocked ! Contact Administrator ..';
											?>
											<script type="text/javascript">
											window.location="index.php";
											</script>
											<?php
											exit();
											}
											
											else
											{
											$this->user_id= $row['id'];
											$this->user_type= $row['user_type_id'];
											
											$this->auth->Create_Session($this->adminuser,$this->user_id,'',$this->user_type);
											$_SESSION['msg']='You are successfully logged In...';
											?>
											<script type="text/javascript">
											window.location="../dashboard.php";
											</script>
											<?php
											}
									break;
									}
								}
								else
								{
									$_SESSION['error_msg']='Invalid login credential please try again..';
								}
							?>
							<script type="text/javascript">
							window.location="<?php echo $_SERVER['PHP_SELF'] ?>";
							</script>
							<?php
							}
							else
							{
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->AdminLogin('local');
							}
							break;
							default:
							echo "No Argument";
							break;
							
						}
								
					}
					
	
					
	function Add_User($runat)
	{
		switch($runat)
		{
		
			case 'local':
			$FormName = "form_adduser";
							$ControlNames=array("fullname"			=>array('fullname',"''","Kindly enter name","span_fullname"),
												"contact"			=>array('contact',"Mobile","Kindly enter contact number","span_contact"),
												"username"			=>array('username',"UserName","Kindly enter user name","span_username"),
												"email"			=>array('email',"EMail","Kindly enter Email","span_email"),
												"password"			=>array('password',"Password","Kindly enter  password","span_password"),
												"repassword"			=>array('repassword',"RePassword","Password Donot Match","spanrepassword",'password'),					
												"user_type_id"			=>array('user_type_id',"''","Kindly select user level","span_user_type_id")
												);
	
							$ValidationFunctionName="CheckAdduserValidity";
						
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
			?>
            <div class="col-sm-7 col-md-7">
        <div class="block-flat">
          <div class="header">							
            <h4>Add New User</h4>
            
          </div>
          <div class="content">
			
         <form method="post" action="" enctype="multipart/form-data" id="" name="<?php echo $FormName ?>" >
         <div class="form-group">
              <label>Name <span style="color:#B30D2E;">*</span></label> 
              <input type="text" name="fullname"   placeholder="Name Please..." class="form-control">
               <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_fullname"></span>
            </div>
            <div class="form-group">
              <label>User Name <span style="color:#B30D2E;">*</span></label> 
              <input type="text" name="username"   placeholder="Username Please..." class="form-control">
              
               <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_username"></span>
            </div>
           
            <div class="form-group"> 
              <label>Password <span style="color:#B30D2E;">*</span></label>
               <input  type="password" name="password" placeholder="Password Please..."  class="form-control">
               <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_password"></span> 
            </div> 
            <div class="form-group"> 
              <label>Repeat Password <span style="color:#B30D2E;">*</span></label>
               <input  type="password" name="repassword"  placeholder="Re-password Please..." class="form-control">
                     <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="spanrepassword"></span> 
            </div> 
             <div class="form-group">
              <label>Email address <span style="color:#B30D2E;">*</span></label>
               <input type="text" name="email"   placeholder="Email Please..." class="form-control">
                <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_email"></span> 
            </div>
             <div class="form-group">
              <label>Contact No. <span style="color:#B30D2E;">*</span></label>
               <input type="text" name="contact"  placeholder="Phone Please..." class="form-control">
               <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_contact"></span>
            </div>
             <div class="form-group"> 
              <label>User Level <span style="color:#B30D2E;">*</span></label>
               <select name="user_type_id" class="form-control">
                            <option value="">--- Select User Level ---</option>
							<?php
                            $sql="select * from ".HMS_USER_LEVEL." where 1";
                            $result = $this->db->query($sql,__FILE__,__LINE__);
                            while($row = $this->db->fetch_array($result))
                            {
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['user_type'];?></option>
                            <?php
                            }
                            ?>
                            </select>
                            <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_user_type_id"></span>
            </div> 
            
            
            <div class="form-group"> 
             <label>Upload Photo:</label> 
			  <input type="file" name="filess" value=""/>
            </div>
            
            
            
              <button class="btn btn-primary" type="submit" value="Add User" name="submit" onclick="return <?php echo $ValidationFunctionName ?>();">Add user</button>
              <button class="btn btn-default">Cancel</button>
            </form>
          
          </div>
        </div>				
      </div>
           <?php
			break;
			case 'server':
			extract($_POST);
			
			
			 $tmx=time();
			 				
							//$path=$_FILES["filess"]["name"];
							//move_uploaded_file($_FILES["filess"][tmp_name],"proof/".$path); 
							if ($_FILES["filess"]["error"] > 0)
							{
							//echo "Error: " . $_FILES["filess"]["error"] . "<br />";
							echo 'Invalid file';
							}
							else
							{
							  "Upload: " . $_FILES["file"]["name"] . "<br />";
							 "Type: " . $_FILES["file"]["type"] . "<br />";
							 "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
							 "Stored in: " . $_FILES["file"]["tmp_name"];
							 $tmpname=$_FILES["filess"]["name"];
							
							$name= explode('.',$tmpname);
							$tmp=$_FILES["filess"]["type"];
							$type= explode('/',$tmp);
							if($type[1]=='jpeg'||$type[1]=='JPEG'||$type[1]=='jpg'||$type[1]=='JPG'||$type[1]=='png'||$type[1]=='PNG'||$type[1]=='gif'||$type[1]=='GIF')
								{						
							 $path= 'userpic'.$tmx.".".$type[1];	
						   
							move_uploaded_file($_FILES["filess"][tmp_name],"user_pic/".$path);
							}
								else
								{
									echo 'Invalid file';
								}
							}
			
			$this->user_pic = $path;
			$this->fullname = $fullname;
			$this->contact = $contact;
			$this->email = $email;
			$this->username = $username;
			$this->password = $password;
			$this->user_type_id = $user_type_id;
			$return = true;
			
		if($this->Form->ValidField($fullname,'empty','Please enter name')==false)
		    $return =false;
		if($this->Form->ValidField($contact,'empty','Please enter contact')==false)
			$return =false;
		if($this->Form->ValidField($username,'empty','Please enter user name')==false)
		    $return =false;
		if($this->Form->ValidField($password,'empty','Please enter password')==false)
			$return =false;
	    if($this->Form->ValidField($user_type_id,'empty','Please select user level')==false)
			$return =false;
		
			
			    $sql = "select * from ".HMS_USER." where username='".$this->username."'";
				$record = $this->db->query($sql,__FILE__,__LINE__);
				$cnt = $this->db->num_rows($record);
				if($cnt>0)
				{
					$_SESSION['error_msg'] = 'User already exists';
					?>
                    <script type="text/javascript">
							window.location = 'addusers.php';
							</script>
                    <?php
					exit();
				}
			
			
			
			if($return){
							
							$insert_sql_array = array();
							$insert_sql_array['name'] = ucwords($this->fullname);
							$insert_sql_array['contact'] = $this->contact;
							$insert_sql_array['email'] = $this->email;
							$insert_sql_array['email_code'] = md5(md5(md5($this->email)));
							
							$insert_sql_array['username'] = $this->username;
							$insert_sql_array['password'] = $this->password;
							$insert_sql_array['user_type_id'] =$this->user_type_id;
							$this->db->insert(HMS_USER,$insert_sql_array);
							$userId = $this->db->last_insert_id();
							
							$insert_sql_array1 = array();
							$insert_sql_array1['user_id'] = $userId;
							$insert_sql_array1['user_pic'] = $this->user_pic;
							$this->db->insert(HMS_USER_PIC,$insert_sql_array1);
						
						
								
								
							$_SESSION['msg'] = 'User Details has been Successfully Added';	
							
							?>
							<script type="text/javascript">
							window.location = 'viewAllusers.php?index=View_User&user_id=<?php echo $userId;?>';
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->Add_User('local');
							}
							
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
	
	
		
	function Advance_Search($name,$username,$contact,$user_type,$user_status)
	{
	?>
    <div class="col-sm-5 col-md-5">
            <div class="block-flat" style="min-height:350px;">
            <div class="header">							
            <h4>Advance Search</h4>
            </div>
	   <div class="content">
            <form method="get" action="viewAllusers.php" enctype="multipart/form-data" id="" name="searchUser" >
              <div class="form-group">
              <label class="col-sm-4 control-label">Name: </label>
              <div class="col-sm-8" style="margin-bottom:5px;">
                <input type="text"  class="form-control" name="name" value="<?php echo $_REQUEST[$name];?>">
              </div>
              </div>
              <div class="form-group">
              <label class="col-sm-4 control-label" >Username: </label>
              <div class="col-sm-8">
                <input type="text"  class="form-control" name="username" value="<?php echo $_REQUEST[$username];?>" style="margin-bottom:5px;">
              </div>
              </div>
              <div class="form-group">
              <label class="col-sm-4 control-label">Contact: </label>
              <div class="col-sm-8">
                <input type="text"  class="form-control" name="contact" value="<?php echo $_REQUEST[$contact];?>" style="margin-bottom:5px;">
              </div>
              </div>
			  <div class="form-group">
              <label class="col-sm-4 control-label">User Status: </label>
              <div class="col-sm-8">
              <select class="form-control" name="user_status" style="margin-bottom:5px;">
							<option value=""> 	-- User Status --  </option>
                            <option <?php if($_REQUEST[$user_status]==1) { echo 'selected="selected"';} ?>  value="1">Active</option>
                            <option <?php if($_REQUEST[$user_status]==2) { echo 'selected="selected"';} ?> value="2">Block</option>
               </select>
              </div>
              </div>
			  
			  <div class="form-group">
              <label class="col-sm-4 control-label">User Type: </label>
              <div class="col-sm-8">
              <select class="form-control" name="user_type" style="margin-bottom:5px;">
							<option value=""> 	--User Type --</option>
							<?php
                            $sql="select * from ".HMS_USER_LEVEL." where 1";
                            $result = $this->db->query($sql,__FILE__,__LINE__);
                            while($row = $this->db->fetch_array($result))
                            {
                            ?>
                            <option value="<?php echo $row['id'];?>" <?php if($_REQUEST[$user_status]==$row['id']) { echo 'selected="selected"';} ?>><?php echo $row['user_type'];?></option>
                            <?php
                            }
                            ?>
						  </select>
              </div>
              </div>
              <div class="form-group">
              <div class="col-sm-offset-4 col-sm-8">
                <button class="btn btn-primary" type="submit">Search</button>
                <button class="btn btn-default">Cancel</button>
              </div>
              </div>
            </form>
          </div>
           </div>				
            </div>
	<?php
	}
	
	
	function Show_all_user($name='',$username='',$contact='',$user_type='',$user_status='')
	{
		?><div class="col-md-12">
					<div class="block-flat">
                    
						<div class="header">
                        	<h4>All Users</h4>
                      </div>
						<div class="content">
							<div class="table-responsive">
								<table class="table table-bordered" id="datatable" >
									<thead>
										<tr>
											<th>S. No.</th>
											<th>Name</th>
											<th>User Name</th>
											<th>User Level</th>
                                            <th>Contact No.</th>
                                           <th>Operations</th>
										</tr>
									</thead>
									<tbody>
                                    <?php
				$sql="select * from ".HMS_USER." where deleted='0'";
				if($name)
				{
					$sql .= " and name like '".$name."%'";
				}
				if($username)
				{
					$sql .= " and username like '".$username."%'";
				}
				if($contact)
				{
					$sql .= " and contact like '".$contact."%'";
				}
				if($user_type)
				{
					$sql .= " and user_type_id ='".$user_type."'";
				}
				if($user_status)
				{
					$sql .= " and status ='".$user_status."'";
				}
				$sql .= " order by created desc";
		//echo $sql;
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
											<td><?php echo $row['name'];?></td>
											<td><?php echo $row['username'];?></td>
                                            <td><?php echo $this->Master->GetUserLevelByUserTypeId($row['user_type_id']);?></td>
                                            <td><?php echo $row['contact'];?></td>
											
                                            
											<td class="center"><div class="btn-group"><button class="btn btn-default btn-xs" type="button">Actions</button><button data-toggle="dropdown" class="btn btn-xs btn-primary dropdown-toggle" type="button"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul role="menu" class="dropdown-menu pull-right"><li><a href="viewAllusers.php?index=View_User&user_id=<?php echo $row['id'];?>" title="View User">View User</a></li>
                                        <?php if($row['status']==1){?>
               <li><a href="javascript: void(0);" title="Block User" onclick="javascript: if(confirm('Do u want to Block this User?')) { user_obj.blockUser('<?php echo $row['id'];?>',{}) }; return false;">Block this user</a></li>
                 <?php
			   }
					elseif($row['status']==2)
					{
						?>
                       <li> <a href="javascript: void(0);" title="Active User" onclick="javascript: if(confirm('Do u want to Active this User?')) { user_obj.unblockUser('<?php echo $row['id'];?>',{}) }; return false;">Active this user</a></li>
           <?php					
					}
					?>
                    
                                            <li class="divider"></li><li> <a  href="javascript: void(0);" title="Active User" onclick="javascript: if(confirm('Do u want to delete this User?')) { user_obj.removeUser('<?php echo $row['id'];?>',{}) }; return false;" >Remove</a></li></ul></div></td>
										</tr>
										<?php 
							$x++;
							}
				}
				else
				{
					?>
                   					 <tr class="odd gradeX">
											<td colspan="5"><h4>Sorry! No User  Available</h4></td>
											
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
			
				<a href="viewAllusers.php" class="btn btn-info">&laquo;&laquo;</a>
<a href="viewAllusers.php<?php if($pgr >=2 ) {echo '?pg=';echo $pgr-1; } else { echo $pg; }?>&name=<?php echo $_REQUEST['name'];?>&username=<?php echo $_REQUEST['username'];?>&contact=<?php echo $_REQUEST['contact'];?>&user_type=<?php echo $_REQUEST['user_type'];?>&user_status=<?php echo $_REQUEST['user_status'];?>" class="btn btn-info">&laquo;</a>
				
				<?php if($pgr == $lastpage && ($pgr-4) >= 1 ) { ?>
				<a href="viewAllusers.php?pg=<?php echo $pgr-4;?>&name=<?php echo $_REQUEST['name'];?>&username=<?php echo $_REQUEST['username'];?>&contact=<?php echo $_REQUEST['contact'];?>&user_type=<?php echo $_REQUEST['user_type'];?>&user_status=<?php echo $_REQUEST['user_status'];?>" class="btn btn-info"><?php echo $pgr-4; ?></a>
				<?php } ?>
				
				<?php if($pgr == $lastpage || $pgr == $lastpage-1) { 
				if(($pgr-3) >= 1){
				?>
				<a href="viewAllusers.php?pg=<?php echo $pgr-3;?>&name=<?php echo $_REQUEST['name'];?>&username=<?php echo $_REQUEST['username'];?>&contact=<?php echo $_REQUEST['contact'];?>&user_type=<?php echo $_REQUEST['user_type'];?>&user_status=<?php echo $_REQUEST['user_status'];?>" class="btn btn-info"><?php echo $pgr-3; ?></a>
				<?php } }?>
				
				<?php $temp0=$pgr-2;
					if($temp0 >= 1) {				
				?>
				<a href="viewAllusers.php?pg=<?php echo $pgr-2;?>&name=<?php echo $_REQUEST['name'];?>&username=<?php echo $_REQUEST['username'];?>&contact=<?php echo $_REQUEST['contact'];?>&user_type=<?php echo $_REQUEST['user_type'];?>&user_status=<?php echo $_REQUEST['user_status'];?>" class="btn btn-info"><?php echo $pgr-2;?></a>
				<?php } ?>
				
				<?php $temp1=$pgr-1;
					if($temp1 >= 1) {				
				?>
				<a href="viewAllusers.php?pg=<?php echo $pgr-1;?>&name=<?php echo $_REQUEST['name'];?>&username=<?php echo $_REQUEST['username'];?>&contact=<?php echo $_REQUEST['contact'];?>&user_type=<?php echo $_REQUEST['user_type'];?>&user_status=<?php echo $_REQUEST['user_status'];?>" class="btn btn-info"><?php echo $pgr-1;?></a>
				<?php } ?>
				
				<a href="viewAllusers.php?pg=<?php if($pgr !='') {echo $pgr;} else { echo 1; }?>&name=<?php echo $_REQUEST['name'];?>&username=<?php echo $_REQUEST['username'];?>&contact=<?php echo $_REQUEST['contact'];?>&user_type=<?php echo $_REQUEST['user_type'];?>&user_status=<?php echo $_REQUEST['user_status'];?>" class="btn btn-info active"><?php if($pgr !='') {echo $pgr;} else { echo 1; }?></a>
				
				<?php $temp2=$pgr+1;
					if($temp2 <= $lastpage) {				
				?>
				<a href="viewAllusers.php?pg=<?php echo $pgr+1;?>&name=<?php echo $_REQUEST['name'];?>&username=<?php echo $_REQUEST['username'];?>&contact=<?php echo $_REQUEST['contact'];?>&user_type=<?php echo $_REQUEST['user_type'];?>&user_status=<?php echo $_REQUEST['user_status'];?>" class="btn btn-info"><?php echo $pgr+1;?></a>
				<?php } ?>
				<?php $temp3=$pgr+2;
					if($temp3 <= $lastpage) {				
				?>
				<a href="viewAllusers.php?pg=<?php echo $pgr+2;?>&name=<?php echo $_REQUEST['name'];?>&username=<?php echo $_REQUEST['username'];?>&contact=<?php echo $_REQUEST['contact'];?>&user_type=<?php echo $_REQUEST['user_type'];?>&user_status=<?php echo $_REQUEST['user_status'];?>" class="btn btn-info"><?php echo $pgr+2;?></a>
				<?php } ?>
				
				<?php if($pgr == 1 || $pgr == 2) { 
				if(($pgr+3) <= $lastpage) {
				?>
				<a href="viewAllusers.php?pg=<?php echo $pgr+3;?>&name=<?php echo $_REQUEST['name'];?>&username=<?php echo $_REQUEST['username'];?>&contact=<?php echo $_REQUEST['contact'];?>&user_type=<?php echo $_REQUEST['user_type'];?>&user_status=<?php echo $_REQUEST['user_status'];?>" class="btn btn-info"><?php echo $pgr+3; ?></a>
				<?php } }?>
				
				<?php if($pgr == 1 && ($pgr+4) <= $lastpage) { ?>
				<a href="viewAllusers.php?pg=<?php echo $pgr+4;?>&name=<?php echo $_REQUEST['name'];?>&username=<?php echo $_REQUEST['username'];?>&contact=<?php echo $_REQUEST['contact'];?>&user_type=<?php echo $_REQUEST['user_type'];?>&user_status=<?php echo $_REQUEST['user_status'];?>" class="btn btn-info"><?php echo $pgr+4; ?></a>
				<?php } ?>
				
				<a href="viewAllusers.php?pg=<?php echo $pgr+1;?>&name=<?php echo $_REQUEST['name'];?>&username=<?php echo $_REQUEST['username'];?>&contact=<?php echo $_REQUEST['contact'];?>&user_type=<?php echo $_REQUEST['user_type'];?>&user_status=<?php echo $_REQUEST['user_status'];?>" class="btn btn-info">&raquo;</a>
				
				<a href="viewAllusers.php?pg=<?php echo $lastpage;?>&name=<?php echo $_REQUEST['name'];?>&username=<?php echo $_REQUEST['username'];?>&contact=<?php echo $_REQUEST['contact'];?>&user_type=<?php echo $_REQUEST['user_type'];?>&user_status=<?php echo $_REQUEST['user_status'];?>" class="btn btn-info">&raquo;&raquo;</a>
			</div>
            </div>
             <div align="right">Total Pages - <?php echo $lastpage;?></div>
			<div align="right">Total Records - <?php echo $numpages;?></div>							
							</div>
						</div>
					</div>				
				</div>
			
        <?php
		
	}
	
	function SearchUser($name,$username,$contact,$user_type,$user_status)
	{
		
		?>
        		<div class="col-lg-12">
					<div class="block-flat" style="min-height:225px !important;">
                    <a href="addusers.php?index=new" class="btn btn-primary btn-flat" style="float:right;">Add New User</a>
						<div class="header">							
							<h4>Search User</h4>
						</div>
						<div class="content">
<form method="get" action="viewAllusers.php" enctype="multipart/form-data" id="" name="searchUser" >
<div class="col-lg-4">
<div class="form-group">
<input type="text" name="name"    placeholder="Name Please..." class="form-control" value="<?php echo $_REQUEST['name'];?>">
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<input type="text" name="username"   placeholder="Username Please..." value="<?php echo $_REQUEST['username'];?>" class="form-control">
</div>
</div>
<div class="col-lg-4">
<div class="form-group">
<input type="text" name="contact"   placeholder="Phone Please..." value="<?php echo $_REQUEST['contact'];?>" class="form-control">
</div>
</div>
    <div class="col-lg-3">
    <div class="form-group"> 
    
    <select name="user_type" class="form-control">
    <option value="">--- Select User Level ---</option>
    <?php
    $sql="select * from ".HMS_USER_LEVEL." where 1";
    $result = $this->db->query($sql,__FILE__,__LINE__);
    while($row = $this->db->fetch_array($result))
    {
    ?>
    <option value="<?php echo $row['id'];?>" <?php if($_REQUEST['user_type']==$row['id']) { echo 'selected="selected"';} ?>><?php echo $row['user_type'];?></option>
    <?php
    }
    ?>
    </select>
    
    </div>
    </div>  
    
    
    <div class="col-lg-3">
    <div class="form-group"> 
    
    <select name="user_status" class="form-control">
    <option value="">--- Select Status ---</option>
     <option <?php if($_REQUEST['user_status']==1) { echo 'selected="selected"';} ?>  value="1">Active</option>
                            <option <?php if($_REQUEST['user_status']==2) { echo 'selected="selected"';} ?> value="2">Block</option>
    </select>
    
    </div>
    </div> 
        <div class="col-lg-4">
         <div class="form-group"> 
        <button class="btn btn-primary" type="submit" value="Search User" name="submit">Search User</button>
        </div>
        </div>              
            </form>
						</div>
					</div>				
				</div>	
        <?php
	}
	
	function unblockUser($id)
	{
				ob_start();
				
				$update_array = array();
				$update_array['status'] = 1;
				
				$this->db->update(HMS_USER,$update_array,'id',$id);
				$_SESSION['msg']='User has been Un-Blocked successfully';
				?>
				<script type="text/javascript">
					location.reload(true);
				</script>
				<?php
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
	}
	
	
	
	
	function blockUser($id)
	{
				ob_start();
				
				$update_array = array();
				$update_array['status'] = 2;
				$this->db->update(HMS_USER,$update_array,'id',$id);
				$_SESSION['msg']='User has been Blocked successfully';
				?>
				<script type="text/javascript">
					location.reload(true);
				</script>
				<?php
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
	}
	
	function removeUser($id)
	{
		ob_start();
		
		
			
			/* User pic is deleted from database */	
				            $sql_folder="select * from ".HMS_USER_PIC." where user_id='".$id."'";
							$records_folder = $this->db->query($sql_folder,__FILE__,__LINE__);
							$row_folder = $this->db->fetch_array($records_folder);
							$path_old= 'user_pic/'.$row_folder['user_pic'];
							
							
							unlink($path_old);
							
							$sql_del_old_pic2="delete from ".HMS_USER_PIC." where user_id='".$id."'";
							$this->db->query($sql_del_old_pic2,__FILE__,__LINE__);
							
		/* User Information is not deleted from database only recyleed */
				$update_array = array();
				$update_array['deleted'] = 1;
				$this->db->update(HMS_USER,$update_array,'id',$id);
			
		


				$_SESSION['msg']='User has been deleted successfully';
				?>
				<script type="text/javascript">
				window.location='viewAllusers.php';
					
				</script>
				<?php
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
				
	}
	
	
	function ViewUser($userId)
	{
							$sql="select * from ".HMS_USER." where id='".$userId."'";
							$records = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($records);
							
		                    $sql_folder="select * from ".HMS_USER_PIC." where user_id='".$userId."'";
							$records_folder = $this->db->query($sql_folder,__FILE__,__LINE__);
							$row_folder = $this->db->fetch_array($records_folder);
							//$path= 'user_pic/'.$row_folder['user_pic'];
		?>
        <div class="col-sm-9">
        
        <div class="block-flat profile-info">
          <div class="row">
           <div class="col-sm-3">
              <div class="avatar">
              <?php
			  if($row_folder['user_pic']!='')
			  {
				?>
                 <img class="profile-avatar" src="user_pic/<?php echo $row_folder['user_pic'];?>">
               
                <?php
			  }
			  else
			  {
				  ?>
                  <img class="profile-avatar" src="images/av.jpg">
                  <?php
			  }
			  ?>
              
              </div>
            </div>
            <div class="col-sm-6">
              <div class="personal">
                <h4 class="name"><?php echo $row['name'];?></h4>
                 <p class="description"><strong>User Name: </strong><?php echo $row['username'];?></p>
                 <p class="description"><strong>Email Id: </strong><?php echo $row['email'];?></p>
                 <p class="description"><strong>Phone: </strong><?php echo $row['contact'];?></p>
                  <p class="description"><strong>User Level: </strong> <?php if($row['user_type_id']==1) { echo 'Admin Level';} elseif($row['user_type_id']==2){ echo 'Mangerial Level';} else { echo 'FrontDesk Level';}?></p>
                </div>
            </div>
             <div class="col-sm-3">
                        <div class="dropdown clearfix">
								  <ul class="dropdown-menu static-mn spacer">
									<li><a href="#" tabindex="-1">Action</a></li>
                                      <?php if($row['status']==1){?>
               <li><a href="javascript: void(0);" title="Block User" tabindex="-1" onclick="javascript: if(confirm('Do u want to Block this User?')) { user_obj.blockUser('<?php echo $row['id'];?>',{}) }; return false;">Block this user</a></li>
                 <?php
			   }
					elseif($row['status']==2)
					{
						?>
                       <li> <a href="javascript: void(0);" tabindex="-1" title="Active User" onclick="javascript: if(confirm('Do u want to Active this User?')) { user_obj.unblockUser('<?php echo $row['id'];?>',{}) }; return false;">Active this user</a></li>
           <?php					
					}
					?>
                    
                                            <li class="divider"></li><li> <a  href="javascript: void(0);"  tabindex="-1" title="Active User" onclick="javascript: if(confirm('Do u want to delete this User?')) { user_obj.removeUser('<?php echo $row['id'];?>',{}) }; return false;" >Remove</a></li>
                                            
									
								  </ul>
								</div>
            </div>
          </div>
        </div>
      </div>
        <?php
	}
	
	
	
	
	
	function UserprofileView($userId)
	{
							$sql="select * from ".HMS_USER." where id='".$userId."'";
							$records = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($records);
							
		                    $sql_folder="select * from ".HMS_USER_PIC." where user_id='".$userId."'";
							$records_folder = $this->db->query($sql_folder,__FILE__,__LINE__);
							$row_folder = $this->db->fetch_array($records_folder);
							//$path= 'user_pic/'.$row_folder['user_pic'];
		?>
        <div class="col-sm-9">
        
        <div class="block-flat profile-info">
          <div class="row">
           <div class="col-sm-3">
              <div class="avatar">
              <?php
			  if($row_folder['user_pic']!='')
			  {
				?>
                 <img class="profile-avatar" src="user_pic/<?php echo $row_folder['user_pic'];?>">
               
                <?php
			  }
			  else
			  {
				  ?>
                  <img class="profile-avatar" src="images/av.jpg">
                  <?php
			  }
			  ?>
              
              </div>
            </div>
            <div class="col-sm-6">
              <div class="personal">
                <h4 class="name"><?php echo $row['name'];?></h4>
                 <p class="description"><strong>User Name: </strong><?php echo $row['username'];?></p>
                 <p class="description"><strong>Email Id: </strong><?php echo $row['email'];?></p>
                 <p class="description"><strong>Phone: </strong><?php echo $row['contact'];?></p>
                  <p class="description"><strong>User Level: </strong> <?php if($row['user_type_id']==1) { echo 'Admin Level';} elseif($row['user_type_id']==2){ echo 'Mangerial Level';} else { echo 'FrontDesk Level';}?></p>
                </div>
            </div>
             
          </div>
        </div>
      </div>
        <?php
	}
	
	
	
	function EditProfile($runat,$uid)
	{
		switch($runat)
		{
		
			case 'local':
			$FormName = "form_edit";
						$ControlNames=array("fullname"			=>array('fullname',"''","Kindly enter name","span_fullname"),
												"contact"			=>array('contact',"Mobile","Kindly enter contact number","span_contact"),
												"username"			=>array('username',"UserName","Kindly enter user name","span_username"),
												"email"			=>array('email',"EMail","Kindly enter Email","span_email")
											);
							$ValidationFunctionName="CheckEditnValidity";
						
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
							
						$sql = "select * from ".HMS_USER." where id='".$uid."'";
						$record = $this->db->query($sql,__FILE__,__LINE__);
						$row = $this->db->fetch_array($record);
						
						
			?>
         <div class="col-sm-7 col-md-7">
        <div class="block-flat">
          <div class="header">							
            <h4>Edit Profile</h4>
            
          </div>
          <div class="content">
			
         <form method="post" action="" enctype="multipart/form-data" id="" name="<?php echo $FormName ?>" >
         <div class="form-group">
              <label>Name <span style="color:#B30D2E;">*</span></label> 
              <input type="text" name="fullname"   placeholder="Name Please..." class="form-control" value="<?php echo $row['name'];?>">
               <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_fullname"></span>
            </div>
            <div class="form-group">
              <label>User Name <span style="color:#B30D2E;">*</span></label> 
              <input type="text" name="username" readonly="readonly"   placeholder="Username Please..." class="form-control" value="<?php echo $row['username'];?>">
              
               <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_username"></span>
            </div>
           
             <div class="form-group">
              <label>Email address <span style="color:#B30D2E;">*</span></label>
               <input type="text" name="email"   placeholder="Email Please..." class="form-control" value="<?php echo $row['email'];?>">
                <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_email"></span> 
            </div>
             <div class="form-group">
              <label>Contact No. <span style="color:#B30D2E;">*</span></label>
               <input type="text" name="contact"  placeholder="Phone Please..." class="form-control" value="<?php echo $row['contact'];?>">
               <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_contact"></span>
            </div>
             <div class="form-group"> 
             <label>Upload Photo:</label> 
			  <input type="file" name="filess" value=""/>
            </div>
            <button class="btn btn-primary" type="submit" value="Edit Profile" name="submit" onclick="return <?php echo $ValidationFunctionName ?>();">Edit Profile</button>
              <button class="btn btn-default">Cancel</button>
            </form>
          
          </div>
        </div>				
      </div>
            
            <?php
			break;
			case 'server':
			extract($_POST);
			$tmx=time();
							if ($_FILES["filess"]["error"] > 0)
							{
							//echo "Error: " . $_FILES["filess"]["error"] . "<br />";
							echo 'Invalid file';
							}
							else
							{
							$sql_folder="select * from ".HMS_USER_PIC." where user_id='".$uid."'";
							$records_folder = $this->db->query($sql_folder,__FILE__,__LINE__);
							$row_folder = $this->db->fetch_array($records_folder);
							$path_old= 'user_pic/'.$row_folder['user_pic'];
							
							unlink($path_old);
							
							echo "Upload: " . $_FILES["file"]["name"] . "<br />";
							echo "Type: " . $_FILES["file"]["type"] . "<br />";
							echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
							echo "Stored in: " . $_FILES["file"]["tmp_name"];
							$tmpname=$_FILES["filess"]["name"];
							$name= explode('.',$tmpname);
							$tmp=$_FILES["filess"]["type"];
							$type= explode('/',$tmp);
							if($type[1]=='jpeg'||$type[1]=='JPEG'||$type[1]=='jpg'||$type[1]=='JPG'||$type[1]=='png'||$type[1]=='PNG'||$type[1]=='gif'||$type[1]=='GIF')
								{						
						  $path= 'userpic'.$tmx.".".$type[1];
							move_uploaded_file($_FILES["filess"][tmp_name],"user_pic/".$path); 
							}
								else
								{
									echo 'Invalid file';
								}
							}
				$this->user_pic = $path;
				$this->fullname = $fullname;
				$this->contact = $contact;
				$this->email = $email;
				$this->username = $username;
				$return = true;
			
		if($this->Form->ValidField($fullname,'empty','Please enter name')==false)
		    $return =false;
		if($this->Form->ValidField($contact,'empty','Please enter contact')==false)
			$return =false;
		if($this->Form->ValidField($username,'empty','Please enter user name')==false)
		    $return =false;
		if($this->Form->ValidField($email,'empty','Please enter email address')==false)
		    $return =false;
		
		
			
			    /*$sql = "select * from ".HMS_USER." where username='".$this->username."'";
				$record = $this->db->query($sql,__FILE__,__LINE__);
				$cnt = $this->db->num_rows($record);
				if($cnt>0)
				{
					$_SESSION['error_msg'] = 'User already exists';
					?>
                    <script type="text/javascript">
							window.location = 'profile_view.php?index=profile_edit&user_id=<?php echo $uid;?>';
							</script>
                    <?php
					exit();
				}*/
			
			if($return){
							
							$update_sql_array = array();
							$update_sql_array['username'] = $this->username;
							$update_sql_array['name'] = $this->fullname;
							$update_sql_array['contact'] = $this->contact;
							$update_sql_array['email'] = $this->email;
							$update_sql_array['email_code'] = md5(md5(md5($this->email)));
							$this->db->update(HMS_USER,$update_sql_array,'id',$uid);
							
							
							$update_sql_array2 = array();
							$update_sql_array2['user_pic'] = $this->user_pic;
							$this->db->update(HMS_USER_PIC,$update_sql_array2,'user_id',$uid);
							
							$_SESSION['msg'] = 'User Details has been Successfully Updated';	
							
							?>
							<script type="text/javascript">
							window.location = 'profile_view.php?index=profile_edit&user_id=<?php echo $uid;?>';
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->EditProfile('local',$uid);
							}
							
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
		

		
		function logOut()
		{
			if($_SESSION['user_type']==1)
			{
				$this->auth->Destroy_Session_admin();
			}
			elseif($_SESSION['user_type']==2)
			{
				$this->auth->Destroy_Session_admin();
			}
			else
			{
				$this->auth->Destroy_Session();
			}
		}
		
		
		function ChangePassword($runat)
	{
		
		switch($runat){
			case 'local' :
							
							$FormName = "frm_changeuserChangePassword";
							$ControlNames=array("oldpassword"			=>array('oldpassword',"''","Please enter Old Password","span_oldpassword"),
												"password"			=>array('password',"Password","Please enter Password","span_password"),
												"repassword"			=>array('repassword',"RePassword","Password Donot Match","span_repassword",'password')
												);
	
							$ValidationFunctionName="CheckPWChangePasswordValidity";
						
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
							
							?>
                            <div class="col-sm-7 col-md-7">
        <div class="block-flat">
          <div class="header">							
            <h4>Change Password</h4>
            
          </div>
          <div class="content">
			
         <form method="post" action="" enctype="multipart/form-data" id="" name="<?php echo $FormName ?>" >
         <div class="form-group">
              <label>Old Password <span style="color:#B30D2E;">*</span></label> 
              <input type="password" name="oldpassword"   placeholder="Old Password Please..." class="form-control">
               <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_oldpassword"></span>
            </div>
            <div class="form-group">
              <label>Password <span style="color:#B30D2E;">*</span></label> 
              <input type="password" name="password"   placeholder="password Please..." class="form-control" value="">
              
               <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_password"></span>
            </div>
           
             <div class="form-group">
              <label>Confirm Password <span style="color:#B30D2E;">*</span></label>
               <input type="password" name="repassword"   placeholder="Confirm Password Please..." class="form-control" value="">
                <span style="color:#F63233; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  font-size:12px" id="span_repassword"></span> 
            </div>
             
             
            <button class="btn btn-primary" type="submit" value="Change Password" name="submit" onclick="return <?php echo $ValidationFunctionName ?>();">Change Password</button>
              <button class="btn btn-default">Cancel</button>
            </form>
          
          </div>
        </div>				
      </div>
							<?php
							break;
			case 'server' :
							
						extract($_POST);
						$this->password=$password;
						
						//server side validation
						$return =true;
						if($this->Form->ValidField($oldpassword,'empty','Please enter old password')==false)
							$return =false;
						if($this->Form->ValidField($password,'empty','Please enter new password')==false)
							$return =false;
						if($this->Form->ValidField($repassword,'empty','Password Donot Match')==false)
							$return =false;
						
							
						if($return){
							$sql = "select * from ".HMS_USER." where id='".$_SESSION['user_id']."'";
							$record = $this->db->query($sql,__FILE__,__LINE__);
							$row = $this->db->fetch_array($record);
							if($oldpassword == $row['password'])
								{
									$update_sql_array = array();
									$update_sql_array['password'] = $this->password;
									
									$this->db->update(HMS_USER,$update_sql_array,'id',$_SESSION['user_id']);
									$_SESSION['msg']='Password Changed Successfully';
									?>
									<script type="text/javascript">
									window.location="profile_view.php?index=change_pass";
									</script>
									<?php
									exit();
								}
								else
								{
									$_SESSION['error_msg']='Old password do not match, please try again ...';
								}
							?>
							<script type="text/javascript">
							window.location="profile_view.php?index=change_pass";
							</script>
							<?php
							exit();
							}
							else
							{
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->ChangePassword('local');
							}
						break;
			default : echo 'Wrong Paramemter passed';
		}
	
	}
		
	function forgetpass($runat)
	{
		switch($runat)
		{
			case 'local' :
		$FormName = "frm_forgetPassword";
						$ControlNames=array("email" =>array('email',"EMail","Kindly Enter Your Email Address","span_email")
						);

						$ValidationFunctionName="CheckforgotpwjjValidity";
					
						$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
						echo $JsCodeForFormValidation;
						?>
                        <form style="margin-bottom: 0px !important;" class="form-horizontal" action="" method="post"   name="<?php echo $FormName;?>" enctype="multipart/form-data">
					<div class="content">
						<?php echo $this->noti->Notify();?>
            <p class="text-center">Don't worry, we'll send you an email to reset your password.</p>
              <hr/>

              
							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
										<input type="text" name="email" placeholder="Your Email" class="form-control">
   
                                        
									</div>
                  <div id="email-error"> <span style="color: #FF0000; font-family: 'Lucida Sans Unicode','Lucida Grande',sans-serif; font-weight: 600;" id="span_email"></span></div>
								</div>
							</div>
             <p class="spacer text-center"><a href="index.php">Login from here?</a></p>
            <button class="btn btn-block btn-primary btn-rad btn-lg" name="submit" onclick="return <?php echo $ValidationFunctionName ?>();" type="submit" value="Reset Password" >Reset Password</button>
            
            
							
					</div>
                    </form>
			
	 <?php  
	 break;
		case 'server' :
							
				extract($_POST);
				 $this->email = $email;
				$return = true;
			
				if($this->Form->ValidField($email,'empty','kindly enter email address')==false)
		         $return =false;			
							
						
							
			    $sql = "select * from ".HMS_USER." where email='".$this->email."'";
				$record = $this->db->query($sql,__FILE__,__LINE__);
				$cnt = $this->db->num_rows($record);
				if($cnt<1)
				{
					$_SESSION['error_msg'] = 'Sorry, no user account is found by this email address.Please try again...';
					?>
                    <script type="text/javascript">
							window.location = 'forget_password.php';
							</script>
                    <?php
					exit();
				}
			
			
			
			if($return){
							
								$this->objMail->IsHTML(true);
								$this->objMail->From = "info@myriadhospitality.in";
								$this->objMail->FromName = "Hotel Myriad";
								$this->objMail->Sender = 'info@myriadhospitality.in';
								$this->objMail->AddAddress($this->email);
								$this->objMail->Subject = 'Reset Password';							
															
								$this->objMail->Body = '<br/>Reset Password Request<br/><br/><br/>';
								$this->objMail->Body .= 'We have received a request to reset your password from the email:<br/>';
								$this->objMail->Body .=  $this->email.'<br/><br/>';
								$this->objMail->Body .= 'Please follow the link below or copy and paste it in your browser to reset your password.<br/><br/>';
								
								$this->objMail->Body .= '<a href="'.$_SERVER['HTTP_HOST'].'/resetpassword.php?email='. $this->email.'&code='.md5(md5(md5($this->email))).'">'.$this->site_url.$_SERVER['HTTP_HOST'].'/resetpassword.php?email='.$this->email.'&code='.md5(md5(md5($this->email))).'</a><br/><br/>';
								$this->objMail->Body .= 'If you did not request to reset your password,inform us for further action.<br/><br/>';
								$this->objMail->Body .= 'For any queries, contact us on '.TOP_PHONENUMBER.'<br/><br/>';
								
								$this->objMail->Body .= 'Regards,<br/>';
								$this->objMail->Body .= 'Hotel Myriad<br/><br/><br/>';
								
								$this->objMail->Body .= '<hr><br/>';
								
								$this->objMail->WordWrap = 50;
								$this->objMail->Send();
						
						
								
								
							$_SESSION['msg'] = 'Check your email - we sent you an email with a link. Click on the link to reset your password.';	
							
							?>
							<script type="text/javascript">
							window.location = 'forget_password.php';
							</script>
							<?php
							exit();
							
							} else {
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->forgetpass('local');
							}
							
			break;
			default:
			echo "no argument passed";
			break;
		}
	}
   
   
   function ResetPasswordMail($runat,$email,$email_code)
	 {
		
		switch($runat)
		{
			case 'local' :
							$FormName = "frm_Pwts";
							$ControlNames=array(
					"password"			=>array('password',"Password","Please enter Password","spanpassword"),
					"repassword"			=>array('repassword',"RePassword","Password Donot Match","spanrepassword",'password')
												);
	
							$ValidationFunctionName="Checkfrm_PwtsVValidity";
							$JsCodeForFormValidation=$this->validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
							echo $JsCodeForFormValidation;
							
							?>
                            <form style="margin-bottom: 0px !important;" class="form-horizontal" action="" method="post"   name="<?php echo $FormName;?>" enctype="multipart/form-data">
					<div class="content">
						<?php echo $this->noti->Notify();?>
           			

              
							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-lock"></i></span>
										<input type="password" name="password" placeholder="Your Password" class="form-control">
   
                                        
									</div>
                  <div id="email-error"> <span style="color: #FF0000; font-family: 'Lucida Sans Unicode','Lucida Grande',sans-serif; font-weight: 600;" id="spanpassword"></span></div>
								</div>
                                <div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-lock"></i></span>
										<input type="password" name="repassword" placeholder="Your Password" class="form-control">
   
                                        
									</div>
                  <div id="email-error"> <span style="color: #FF0000; font-family: 'Lucida Sans Unicode','Lucida Grande',sans-serif; font-weight: 600;" id="spanrepassword"></span></div>
								</div>
							</div>
             <p class="spacer text-center"><a href="index.php">Login from here?</a></p>
            <button class="btn btn-block btn-primary btn-rad btn-lg" name="submit" onclick="return <?php echo $ValidationFunctionName ?>();" type="submit" value="Reset Password" >Reset Password</button>
            
            
							
					</div>
                    </form>
							
						<?php
							break;
			case 'server' :
							
						  extract($_POST);
							$this->password = $password;
							$this->repassword = $repassword;

						$return =true;
						if($this->Form->ValidField($password,'empty','Please Enter  Password')==false)
							$return =false;
						if($return){
							
									$update_sql_array = array();
									$update_sql_array['password'] = $password;
									$this->db->update(HMS_USER,$update_sql_array,'email_code',$email_code);
									
									$_SESSION['msg']='Password Changed Successfully';
									?>
									<script type="text/javascript">
									window.location="index.php";
									</script>
									<?php
									exit();
								
							}
							else
							{
							echo $this->Form->ErrtxtPrefix.$this->Form->ErrorString.$this->Form->ErrtxtSufix; 
							$this->ResetPasswordMail('local',$email,$$email_code);
							}
						break;
			default : echo 'Wrong Paramemter passed';
		}
	
	}
		
		
	
}
?>