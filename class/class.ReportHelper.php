<?php

/* 
 * This class is responcible for the reports
 * Author: Abhishek Kumar Mishra
 * Created Date: 22/09/2014
 */

class HotelReportHelper
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
	

	
    function GetTotalRoomCount()
	{
			  $k=0;
              $sql ="select id,name from ".HMS_ROOM_TYPE." where deleted=1";
			  $result = $this->db->query($sql,__FILE__,__LINE__);
			  while($row = $this->db->fetch_array($result))
			  { $sql_bitem = "select id from ".HMS_ROOM." where deleted=0 and room_type_id='".$row['id']."'";
				    $result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
					while($row_bitem = $this->db->fetch_array($result_bitem))
					{$k++;} }
			  
			  return $k;
			 
	}
	
	
	function getTodaysArrival()
	{
		$this->crd = date("Y-m-d");
		$sql = "select count(id) as total from ".HMS_GUEST_RESERVATION." where arrival='".$this->crd."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		$num_rows = $row['total'];
		return $num_rows;
	}
	
	function getTodaysDeparture()
	{
		$this->crd = date("Y-m-d");
		$sql = "select count(id) as total from ".HMS_GUEST_RESERVATION." where departure='".$this->crd."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		$num_rows = $row['total'];
		return $num_rows;
	}
	
	function getTomorrowArrival()
	{
			$this->crd = date("Y-m-d");
			$next_date = date('Y-m-d', strtotime($this->crd . ' + 1 day'));
			$sql = "select count(id) as total from ".HMS_GUEST_RESERVATION." where arrival='".$next_date."'";
			$result = $this->db->query($sql,__FILE__,__LINE__);
			$row = $this->db->fetch_array($result);
			$num_rows = $row['total'];
			return $num_rows;
	}
	
	function getTomorrowDeparture()
	{
			$this->crd = date("Y-m-d");
			$next_date = date('Y-m-d', strtotime($this->crd . ' + 1 day'));
			$sql = "select count(id) as total from ".HMS_GUEST_RESERVATION." where departure='".$next_date."'";
			$result = $this->db->query($sql,__FILE__,__LINE__);
			$row = $this->db->fetch_array($result);
			$num_rows = $row['total'];
			return $num_rows;
	}
	
	
	
	

}