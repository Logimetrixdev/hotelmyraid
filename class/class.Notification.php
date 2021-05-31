<?php
//**************** Notification class Created for displaying notification messages across the website ****************
	class Notification
	{
	
		var $notice;	
		var $timeout;
	
		function __construct()
		{
			$this->notice=$_SESSION[msg];
			$this->error=$_SESSION[error_msg];
			$this->timeout=20000;
		}
		function SetNote($note)
		{
			$this->notice=$note;
		}
		
		function SetTimeout($SetTimeout)
		{
			$this->SetTimeout=$SetTimeout;
		}
		
		function Notify()
		{
			if($this->notice!='') {
			?>
			<script type="text/javascript">
			setTimeout('document.getElementById("message_t").style.display="none";',<?php echo $this->timeout; ?>);
			</script> 
            <div class="alert alert-success" id="message_t" >
								<strong>Success!</strong> <?php echo $this->notice; ?>
							</div>
			<?php
			$this->destroy_note();
			}
			else if($this->error!='')
			{
			?>
			<script type="text/javascript">
			setTimeout('document.getElementById("message_er").style.display="none";',<?php echo $this->timeout; ?>);
			</script> 
			 <div class="alert alert-danger" >
								<strong>Error!</strong> <?php echo $this->error; ?>
			</div>
			<?php
			$this->destroy_note();
			}
		}
		
		function destroy_note()
		{
			$_SESSION['msg']='';
			$_SESSION['error_msg']='';
		}
	
	}

?>