<?php
class Authentication // Basic class for authentication
{
var $user_id;
var $user_name;
var $user_type;
var $db;	
var $groups=array();
var $adminuser;


		 function __construct()
		 {
			$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
			if(isset($_SESSION['user_name'])){
			$this->user_name=$_SESSION['user_name'];
			$this->user_id=$_SESSION['user_id'];
			$this->groups=$_SESSION['groups'];
			$this->user_type=$_SESSION['user_type'];
			}
		 }  
		 
		function setHttp_Referer($http_referer)
		{
			$_SESSION['http_referer'] =	'..'.$http_referer;		
		}
				  
		function Create_Session($user_name,$user_id,$groups,$user_type){
			$this->user_name=$user_name;
			$this->user_id=$user_id;
			$this->groups=$groups;
			$this->user_type=$user_type;
			$_SESSION['user_name'] = $this->user_name;
			$_SESSION['user_id'] = $this->user_id;
			$_SESSION['groups']= $this->groups;
			$_SESSION['user_type'] = $this->user_type;
			$_SESSION['msg']=$this->WelcomeMessage();
		}
		
		function Get_user_id()
		{
			return $this->user_id;
		}

		function Get_user_name()
		{
			return $this->user_name;
		}
		
		function Get_group()
		{
			return $this->groups;
		}
		
		function Get_user_type()
		{
			return $this->user_type;
		}
		
		function Destroy_Session(){
    		unset($_SESSION['user_name']); 
			unset($_SESSION['user_id']); 
			unset($_SESSION['groups']); 
			unset($_SESSION['user_type']); 
			unset($_SESSION['http_referer']); 
			$_SESSION['msg']='You have logged out successfully';
			?>
			<script type="text/javascript">
			window.location="index.php";
			</script>
			<?php
		}
		function Destroy_Session_admin(){
    		unset($_SESSION['user_name']); 
			unset($_SESSION['user_id']); 
			unset($_SESSION['groups']); 
			unset($_SESSION['user_type']); 
			unset($_SESSION['http_referer']); 
			$_SESSION['msg']='You have logged out successfully';
			?>
			<script type="text/javascript">
			window.location="admin_login/index.php";
			</script>
			<?php
		}
		
		function checkAuthentication()
		{
			//check for the valid login
			if(isset($_SESSION['user_name']))
			return true;
			else return false;
		}
		
		function Checklogin()
		{
			$this->setHttp_Referer($_SERVER['REQUEST_URI']);  
			if(!$this->checkAuthentication()){
			$_SESSION['error_msg']='Please login here first..';
			$this->GotoLogin();
			exit();
			}
		
		
		}
		
		function GotoLogin()
		{
			?>
				<script type="text/javascript">
				window.location='login.php';
				</script>
			<?php
			}

		function checkAdminAuthentication()
		{
			//check for the valid login
			if(isset($_SESSION['user_name']))
			return true;
			else return false;
		}
		
		function CheckAdminlogin()
		{
			$this->setHttp_Referer($_SERVER['REQUEST_URI']);  
			if(!$this->checkAdminAuthentication()){
			$_SESSION['error_msg']='Please login here first..';
			$this->GotoAdminLogin();
			exit();
			}
		
		
		}

		function GotoAdminLogin()
		{
			?>
				<script type="text/javascript">
				window.location='index.php';
				</script>
			<?php }

		function SendToRefrerPage()
		{	
			if($_SERVER['HTTP_REFERER']==''){
			?>
			<script type="text/javascript">
			  window.location='home.php';
			  </script>
			<?php
			}
			else
			{
			?>
				<script type="text/javascript">
				window.location='<?php echo $_SERVER['HTTP_REFERER']; ?>';
				</script>
			<?php }		
			exit();
		}
		
		function CheckAuthorization($access_rules,$access_rules_type,$returnValue=false)
		{
			//check for the group access
			$access=true;
			$search_array = array('first' => 1, 'second' => 4);
			foreach($access_rules as $key => $value)
			{
				if (array_key_exists($key, $this->groups))
				{
					if($value!=$this->groups[$key])
					{
						$access=false;
						if($access_rules_type=='all')
						break;
					}
					else
					{
						$access=true;
						if($access_rules_type=='any')
						break;
					}
				}
				else
				{
						$access=false;
						if($access_rules_type=='all')
						break;
				}
			}
			
			if(!$access and !$returnValue)
			{
				$_SESSION['error_msg']='oops !! Your are not authorised to access this page, Please contact Administrator.';
				$this->SendToRefrerPage();
			}
			else
			return $access;
		}
		
		function WelcomeMessage()
		{
			return "Welcome ".$this->user_name." , You have logged in successfully.. ";
		
		}
		function IfAlreadyLogin()
		{
			if($this->checkAdminAuthentication()==true)
			{
				?>
				<script language="javascript">window.location='../dashboard.php'</script>
                <?php
			}
			else
			{
				
			}
		}
	}	
?>
