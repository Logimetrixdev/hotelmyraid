<?php

/* 
 * This class is responcible for the master tables value link (country, ID card type etc..) of HMS
 * Author: Abhishek Kumar Mishra
 * Created Date: 31/3/2014
 */

class MasterClass
{
	
	function __construct()
	{	
					$this->db = new database(DATABASE_HOST,DATABASE_PORT,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
					$this->validity = new ClsJSFormValidation();
					$this->Form = new ValidateForm();
					$this->auth=new Authentication();
					$this->noti=new Notification();
	}
	
	
	
	function Identfication_Type($res_id='')
	{
				$sql_get_id_type="select * from ".HMS_GUEST_IDENTIFICATION." where reservation_id='".$res_id."'";
				$result_get_id_type = $this->db->query($sql_get_id_type,__FILE__,__LINE__);
				$row_get_id_type = $this->db->fetch_array($result_get_id_type);
				$user_id_type = $row_get_id_type['identification_id'];
		?>
				<select class="form-control" name="identification_id" required>
				<option value="">-- Select ID Type --</option>
				<?php
				$sql="select * from ".HMS_IDENTY." where deleted='0'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				while($row = $this->db->fetch_array($result))
				{
				?>
				<option value="<?php echo $row['id'];?>" <?php if($row['id']==$user_id_type) { echo 'selected="selected"';}?> ><?php echo $row['name'];?></option>
				<?php
				}
				?>
				</select>
		<?php
	}
	
	function GetGuestIDByReseravtionId($reservationId)
	{
				$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$reservationId."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['guest_id'];
	}
	
	
	
	/*function RoomBaicPrice($id)
	{
				$sql_room_type="select * from ".HMS_ROOM_TYPE." where id='".$id."'";
				$result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
				$row_room_type = $this->db->fetch_array($result_room_type);
				
				return $row_room_type['base_price'];
	}
	
	
	function TotalCostPerAddOns($id,$no_of_person,$nights)
	{
	
	            $sql="select * from ".HMS_PRODUCT." where id='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				$totaladdonsCost = $row['per_person_cost']*$no_of_person*$nights;
		        return $totaladdonsCost;
	}*/
	
	function FindGuestNameByGuestId($id)
	{
	
				$sql="select * from ".HMS_GUEST." where id='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				$guestname = $row['title'].' '.$row['first_name'].' '.$row['last_name'];
				return $guestname;
	}
	
	function FindGuestPhoneByGuestId($id)
	{
	
				$sql="select * from ".HMS_GUEST." where id='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['phone'];
	}
	
	function FindGuestEmailByGuestId($id)
	{
	
				$sql="select * from ".HMS_GUEST." where id='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['email'];
	}
	
	function FindGuestAddressByGuestId($id)
	{
	
				$sql="select * from ".HMS_GUEST." where id='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['address'];
	}
	
	function FindGuestZipcodeByGuestId($id)
	{
	
				$sql="select * from ".HMS_GUEST." where id='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['zipcode'];
	}
	
	function FindGuestCityByGuestId($id)
	{
	
				$sql="select * from ".HMS_GUEST." where id='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_city="select * from ".HMS_CITY." where id='".$row['city_id']."'";
				$result_city = $this->db->query($sql_city,__FILE__,__LINE__);
				$row_city = $this->db->fetch_array($result_city);
				
				return $row_city['name'];
	}
	
	function FindGuestStateByGuestId($id)
	{
	
				$sql="select * from ".HMS_GUEST." where id='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_state="select * from ".HMS_STATE." where id='".$row['state_id']."'";
				$result_state = $this->db->query($sql_state,__FILE__,__LINE__);
				$row_state = $this->db->fetch_array($result_state);
				
				return $row_state['name'];
	}
	
	function FindGuestCountryByGuestId($id)
	{
	
				$sql="select * from ".HMS_GUEST." where id='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_country="select * from ".HMS_COUNTRY." where id='".$row['country_id']."'";
				$result_country = $this->db->query($sql_country,__FILE__,__LINE__);
				$row_country = $this->db->fetch_array($result_country);
				
				return $row_country['name'];
	}
	
	function FindGuestIdentificationTypeByReservationId($id)
	{
				$sql="select * from ".HMS_GUEST_IDENTIFICATION." where reservation_id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_id_type="select * from ".HMS_IDENTY." where id='".$row['identification_id']."'";
				$result_id_type = $this->db->query($sql_id_type,__FILE__,__LINE__);
				$row_id_type = $this->db->fetch_array($result_id_type);
				
				return $row_id_type['name'];
				
	}
	
	function FindGuestIdentificationNumberByReservationId($id)
	{
		
				$sql="select * from ".HMS_GUEST_IDENTIFICATION." where reservation_id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				return $row['identification_number'];
				
	}
	
	function FindGuestIdentificationExpByReservationId($id)
	{
		
				$sql="select * from ".HMS_GUEST_IDENTIFICATION." where reservation_id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				return $row['identity_exp_date'];
				
	}
	
	
	function FindIdentityCityByReservationId($id)
	{
	
				$sql="select * from ".HMS_GUEST_IDENTIFICATION." where reservation_id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_city="select * from ".HMS_CITY." where id='".$row['identify_city_id']."'";
				$result_city = $this->db->query($sql_city,__FILE__,__LINE__);
				$row_city = $this->db->fetch_array($result_city);
				
				return $row_city['name'];
	}
	
	function FindIdentityStateByReservationId($id)
	{
	
				$sql="select * from ".HMS_GUEST_IDENTIFICATION." where reservation_id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_state="select * from ".HMS_STATE." where id='".$row['identify_state_id']."'";
				$result_state = $this->db->query($sql_state,__FILE__,__LINE__);
				$row_state = $this->db->fetch_array($result_state);
				
				return $row_state['name'];
	}
	
	function FindIdentityCountryByReservationId($id)
	{
	
				$sql="select * from ".HMS_GUEST_IDENTIFICATION." where reservation_id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_country="select * from ".HMS_COUNTRY." where id='".$row['identify_country_id']."'";
				$result_country = $this->db->query($sql_country,__FILE__,__LINE__);
				$row_country = $this->db->fetch_array($result_country);
				
				return $row_country['name'];
	}
	
	
	
	function getRoomTotalAmount($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['total_room_cost'];
	}
	
	function getExtraBedCost($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['extra_bed_cost'];
	}
	
	
	/*function FindTaxByreservation($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['applicable_tax_id'];
	}*/
	
	function ArrivalDateByReservationId($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['arrival'];
	}
	
	function DeparturelDateByReservationId($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['departure'];
	}
	
	function TotalNightsByReservationId($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['no_of_nights'];
	}
	
	function RoomTypeByReservationId($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_room_type="select * from ".HMS_ROOM_TYPE." where id='".$row['room_type_id']."'";
				$result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
				$row_room_type = $this->db->fetch_array($result_room_type);
				
				return $row_room_type['name'];
				
	}
	
	function RoomIDByReservationId($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['room_id'];
	}
	
	

	
	
	function TotalBookedRoomsByReservationId($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['no_of_rooms'];
	}
	
	function TotalAdultReservationId($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['adult_count'];
	}
	
	function TotalChildReservationId($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['child_count'];
	}
	
	/*function BasicPriceByReservationId($id)
	{
		        $sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_room_type="select * from ".HMS_ROOM_TYPE." where id='".$row['room_type_id']."'";
				$result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
				$row_room_type = $this->db->fetch_array($result_room_type);
				
				return $row_room_type['base_price'];
	}*/
	
	function TotalRoomCost($no_of_room, $room_type_id, $no_of_nights, $occpancy)
	{
		if($occpancy==1)
		{
				$sql_room_type="select * from ".HMS_ROOM_TYPE." where id='".$room_type_id."'";
				$result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
				$row_room_type = $this->db->fetch_array($result_room_type);
				
				$total = $no_of_room*$no_of_nights*$row_room_type['base_price'];
		}
		else
		{
				$sql_room_type="select * from ".HMS_ROOM_TYPE." where id='".$room_type_id."'";
				$result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
				$row_room_type = $this->db->fetch_array($result_room_type);
				
				$total = $no_of_room*$no_of_nights*$row_room_type['higher_price'];	
		}
		return $total;
	}
	
	/*function TotalPersons($adult='',$child='')
	{
		$total = $adult + $child;
		return $total;
	}*/
	
	/*function FindaddonsnameById($id)
	{
	
		        $sql="select * from ".HMS_PRODUCT." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
			
				return $row['title'];
	}
	
	function FindBasicPriceById($id)
	{
			$sql="select * from ".HMS_PRODUCT." where id ='".$id."'";
			$result = $this->db->query($sql,__FILE__,__LINE__);
			$row = $this->db->fetch_array($result);
			return $row['per_person_cost'];
	}
	
	function TotaladdonsCost($no_of_room, $room_basic_price, $no_of_nights)
	{
		$total = $no_of_room*$room_basic_price*$no_of_nights;
		return $total;
	}*/
	
	
	function TotalProductCost($id)
	{
				$roomCost =0;
				$bedCost = 0;
				$totalproductCost = 0;
				
				
				$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				$roomCost = $row['total_room_cost'];
				$bedCost = $row['extra_bed_cost'];
				
				$totalproductCost = $roomCost+$bedCost;
				
				return $totalproductCost;
									
	}
	
	/*function AllAddOnsCostForPayment($id)
	{
				$addonsCost=0;
				
				$sql_addons="select * from ".HMS_GUEST_ADDONS." where reservation_id ='".$id."'";
				$result_addons = $this->db->query($sql_addons,__FILE__,__LINE__);
				while($row_addons = $this->db->fetch_array($result_addons))
				{
					$addonsCost = $addonsCost+$row_addons['amount'];
				}
				
				$addonsCost;
				
				return $addonsCost;
									
	}*/
	
	function GetTaxType($id)
	{
		        $sql="select * from ".HMS_TAXS." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['tax_name'];
	}
	
	function GetTaxValue($id)
	{
		        $sql="select * from ".HMS_TAXS." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['percent_value'];
	}
	
	
	function GetTaxValueOnProduct($total,$tax)
	{
		
		$totaltax = 0;
		$taxvalue = $total*$tax/100;
		
		return round($taxvalue);
	}
	
	
	function TotalPayAableAmount($total,$tax1='',$tax2='')
	{
		/*return $amount = $total+$tax1+$tax2;*/
		return $amount = $total+$tax1+$tax2;
	}
	
	function GetRoomNumberById($id)
	{
					$sql_room="select * from ".HMS_ROOM." where id='".$id."'";
                    $result_room = $this->db->query($sql_room,__FILE__,__LINE__);
					$row_room = $this->db->fetch_array($result_room);
					return $row_room['room_no'];
	}
	
	function extra_bed_cost($no_of_bed,$room_type_id)
	{
				$sql_room_type = "select * from ".HMS_ROOM_TYPE." where id='".$room_type_id."'";
				$result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
				$row_room_type = $this->db->fetch_array($result_room_type);
				$bedCost = $row_room_type['extra_bed_price']*$no_of_bed;
				return $bedCost;
	}
	
	function ExtraBedAllowed($id)
	{
				$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['extra_bed'];
		
	}
	function ExtraBedPriceOnReservation($id)
	{
				$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['extra_bed_cost'];
		
	}
	
	function RoomTypeByRoomTypeId($room_type_id)
	{
		        $sql_room_type = "select * from ".HMS_ROOM_TYPE." where id='".$room_type_id."'";
				$result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
				$row_room_type = $this->db->fetch_array($result_room_type);
				return $row_room_type['name'];
				
	}
	
	function getServiceTaxonTotal($amount,$tax)
	{
		$serTax = $amount*$tax/100;
		return $serTax;
	}
	
	
	function getreservationOccpany($reservation_Id)
	{
				$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$reservation_Id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['occupancy'];
	}
	
	
	function GetRoomPriceByReservationIdforSingleOccupany($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_room_type="select * from ".HMS_ROOM_TYPE." where id='".$row['room_type_id']."'";
				$result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
				$row_room_type = $this->db->fetch_array($result_room_type);
				
				return $row_room_type['base_price'];
				
	}
	
	function GetRoomPriceByReservationIdforDoubleOccupany($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_room_type="select * from ".HMS_ROOM_TYPE." where id='".$row['room_type_id']."'";
				$result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
				$row_room_type = $this->db->fetch_array($result_room_type);
				
				return $row_room_type['higher_price'];
				
	}
	
	
	
	function GetRoomPriceByReservationId($id)
	{
	    		$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_room_type="select * from ".HMS_ROOM_TYPE." where id='".$row['room_type_id']."'";
				$result_room_type = $this->db->query($sql_room_type,__FILE__,__LINE__);
				$row_room_type = $this->db->fetch_array($result_room_type);
				
				return $row_room_type['base_price'];
				
	}
	
	function GetBookingTotalAmount($id)
	{
		$sql="select * from ".HMS_RESERVATION_PAYMENTS." where reservation_id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['total_amount'];
	}
	
	function GetAdvanceAmount($id)
	{
		$sql="select * from ".HMS_RESERVATION_PAYMENTS." where reservation_id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['advance_amount'];
	}
	
	function GetDiscountAmount($id)
	{
		$sql="select * from ".HMS_RESERVATION_PAYMENTS." where reservation_id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['discount'];
	}
	function GetRemainingAmount($id)
	{
		$sql="select * from ".HMS_RESERVATION_PAYMENTS." where reservation_id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['remain_amount'];
	}
	
	/*Banquet Module funtions start from here*/
	
	function Event_Type()
	{
		?>
	    <select class="form-control" name="event_type_id" required>
				<option value="">--Event Type--</option>
				<?php
				$sql="select * from ".HMS_EVENT_TYPE." where status=1 and deleted=1";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				while($row = $this->db->fetch_array($result))
				{
				?>
				<option value="<?php echo $row['id'];?>"><?php echo $row['event'];?></option>
				<?php
				}
				?>
				</select>
				
		<?php
		
	}
	
	
	
	function Banquet_Type()
	{
		?>
	    <select class="form-control" name="banquet_id" required>
				<option value="">-- Banquet --</option>
				<?php
				$sql="select * from ".HMS_BANQUET_TYPE." where status=1 and deleted=1";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				while($row = $this->db->fetch_array($result))
				{
				?>
				<option value="<?php echo $row['id'];?>"><?php echo $row['banquet'];?></option>
				<?php
				}
				?>
				</select>
				
		<?php  
		
	}
	
	function getBanquetName($id)
	{
		$sql="select * from ".HMS_BANQUET_TYPE." where id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['banquet'];
	}
	
	
	function getbanquetnamebybanquetId($id)
	{
		$sql="select id, banquet_id from ".HMS_BANQUETS." where id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		
		$sql_bq="select * from ".HMS_BANQUET_TYPE." where id='".$row['banquet_id']."'";
		$result_bq = $this->db->query($sql_bq,__FILE__,__LINE__);
		$row_bq = $this->db->fetch_array($result_bq);
		return $row_bq['banquet'];
	}
	
	
	
	function getBanquetbookingPersonName($id)
	{
		$sql="select id,person_name from ".HMS_BANQUETS." where id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['person_name'];
	}
	
	function FindGuestAddress($id)
	{
		$sql="select id,address from ".HMS_BANQUETS." where id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['address'];
	}
	
	function FindGuestMob($id)
	{
		$sql="select id,phone from ".HMS_BANQUETS." where id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['phone'];
	}
	
	function FindGuestEmail($id)
	{
		$sql="select id,email from ".HMS_BANQUETS." where id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['email'];
	}
	
	function FindBanquetBookingDate($id)
	{
		$sql="select id,event_date_start from ".HMS_BANQUETS." where id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['event_date_start'];
	}
	
	function FindBanquetBookingStartTime($id)
	{
		$sql="select id,start_time from ".HMS_BANQUETS." where id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['start_time'];
	}
	
	function FindBanquetBookingEndTime($id)
	{
		$sql="select id,end_time from ".HMS_BANQUETS." where id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['end_time'];
	}
	
	function getpaymentIdBybanquetBookingId($bqtId)
	{
		$sql="select id,banquet_id from ".HMS_BANQUETS_PAY." where banquet_id ='".$bqtId."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$count_variable = $this->db->num_rows($result);
		if($count_variable>0)
		{
			$row = $this->db->fetch_array($result);
			$setVal = $row['id'];
		}
		else
		{
			$setVal=0;
		}
		
		return $setVal;
		
	}
	
	
	function FindBookingCity($id)
	{
	
				$sql="select * from ".HMS_BANQUETS." where id='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_city="select * from ".HMS_CITY." where id='".$row['city_id']."'";
				$result_city = $this->db->query($sql_city,__FILE__,__LINE__);
				$row_city = $this->db->fetch_array($result_city);
				
				return $row_city['name'];
	}
	
	function FindBookingState($id)
	{
	
				$sql="select * from ".HMS_BANQUETS." where id='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_city="select * from ".HMS_STATE." where id='".$row['state_id']."'";
				$result_city = $this->db->query($sql_city,__FILE__,__LINE__);
				$row_city = $this->db->fetch_array($result_city);
				
				return $row_city['name'];
	}
	
	function FindBookingCountry($id)
	{
	
				$sql="select * from ".HMS_BANQUETS." where id='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				$sql_city="select * from ".HMS_COUNTRY." where id='".$row['country_id']."'";
				$result_city = $this->db->query($sql_city,__FILE__,__LINE__);
				$row_city = $this->db->fetch_array($result_city);
				
				return $row_city['name'];
	}
	
	
	
	function getItemPrice($id)
	{
		$sql="select id,per_pack_cost from ".HMS_BANQUET_MENU." where id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['per_pack_cost'];
	}
	
	function getItemName($id)
	{
		$sql="select id,item from ".HMS_BANQUET_MENU." where id='".$id."'";
		$result = $this->db->query($sql,__FILE__,__LINE__);
		$row = $this->db->fetch_array($result);
		return $row['item'];
	}
	
	// this function is used at selected checkbox.when user back and regenerate memu list
	function getValueMenuIdIsalredyAddedInBooking($banquetId,$itemId)
	{
		
	   $sql_bitem="select * from ".HMS_BANQUETS_RESERVATION_ITEMS." where banquet_id='".$banquetId."' and item_id='".$itemId."'";
	   $result_bitem = $this->db->query($sql_bitem,__FILE__,__LINE__);
	   $count_variable = $this->db->num_rows($result_bitem);
	   if($count_variable>0)
		   $setval = true;
		else
		  $setval = false;
		  
		  return $setval;
	}
	//end
	// this function is used at time when user back and regenerate memu list it delete all the previous item form banquet item table.
	function DeletePreviousExistingItemsForBooking($banquetId)
	{
		$sql="delete from ".HMS_BANQUETS_RESERVATION_ITEMS." where banquet_id='".$banquetId."'";
	    $this->db->query($sql,__FILE__,__LINE__);
	}
	//end
	
	
	/* Some Room Type Master function is here */
	
	function gettotalRoomCountofRoomType($room_type_id)
	{
		$sql_room="select * from ".HMS_ROOM." where room_type_id='".$room_type_id."' and deleted='0'";
		 $result_room = $this->db->query($sql_room,__FILE__,__LINE__);
		$count = $this->db->num_rows($result_room);
		//$row_room = $this->db->fetch_array($result_room);
		return $count;
	}
	
	function GetGusetIdByReservationID($id)
	{
		        $sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['guest_id'];
	}
	
	function GetUserLevelByUserTypeId($id)
	{
		        $sql="select * from ".HMS_USER_LEVEL." where id ='".$id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['user_type'];
	}
	
	
	function GetRoomStatusbyAssignedValue($Value)
	{
		
		switch($Value)
		{
			case 0:
			$returnValue = 'Room Available'; 
			break;
			case 1:
			$returnValue = 'Room Booked'; 
			break;
			case 2:
			$returnValue = 'Under Housekeeping'; 
			break;
			default:
			$returnValue = 'Exceptional Case Occured.'; 
			break;
			
		}
		return $returnValue; 
	}
	
	
	function GetReservationType($reservation_id)
	{
		
				$sql="select * from ".HMS_GUEST_RESERVATION." where id ='".$reservation_id."'";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['booking_type'];
		
	}
	
	//// below functions are responcible for tax getting on both package and with out package ///
	
	/*function GetVatforWithPackage()
	{
				$sql="select id,percent_value from ".HMS_TAXS." where id=5";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				return $row['percent_value'];
	}
	
	function GetSatforWithPackage()
	{
				$sql="select id,percent_value from ".HMS_TAXS." where id=6";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['percent_value'];
	}
	
	function GetServiceTaxforWithPackage()
	{ 
				$sql="select id,percent_value from ".HMS_TAXS." where id =7";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['percent_value'];
	}*/
	
	
	
	//// below functions are responcible for tax getting on both package and with out package ///
	
	function GetVatforWithPackage()
	{
				$sql="select id,percent_value from ".HMS_TAXS." where id=5";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				
				return $row['percent_value'];
	}
	
	function GetSatforWithPackage()
	{
				$sql="select id,percent_value from ".HMS_TAXS." where id=6";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['percent_value'];
	}
	
	function GetServiceTaxforWithPackage()
	{ 
				$sql="select id,percent_value from ".HMS_TAXS." where id =7";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['percent_value'];
	}
	
	function GetServiceTaxforWithOutPackage()
	{
		        $sql="select id,percent_value from ".HMS_TAXS." where id =9";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['percent_value'];
	}
	
	function GetServiceCharge()
	{
		        $sql="select id,percent_value from ".HMS_TAXS." where id =8";
				$result = $this->db->query($sql,__FILE__,__LINE__);
				$row = $this->db->fetch_array($result);
				return $row['percent_value'];
	}
	
	function GetServiceChargeValue($total)
	{
		$SCPercentage = $this->GetServiceCharge();
		$SCAmont = $total*$SCPercentage/100;
		return $SCAmont;
	}
	
	function GetVaTonTotal($total){
		$VatPercentage = $this->GetVatforWithPackage();
		$VatAmont = $total*$VatPercentage/100;
		return $VatAmont;
	}
	
	function GetSatonTotal($total){
		$SatPercentage = $this->GetSatforWithPackage();
		$SatAmont = $total*$SatPercentage/100;
		return $SatAmont;
	}
	
	function GetServiceTaxonTotalAmount($total){
		$SerTaxPercentage = $this->GetServiceTaxforWithPackage();
		$SerTaxAmont = $total*$SerTaxPercentage/100;
		return $SerTaxAmont;
	}
	
	function GetServiceTaxonTotalAmountOnlyHall($total)
	{
		$SerTaxPercentage = $this->GetServiceTaxforWithOutPackage();
		$SerTaxAmont = $total*$SerTaxPercentage/100;
		return $SerTaxAmont;
	}
	
	function CalculateServiceTaxOnExtraHours($amount)
	{
		$SerTaxPercentage=0;
		$SerTaxPercentage = $this->GetServiceTaxforWithOutPackage();
		$ServiceTaxOnExtraHours = $amount*$SerTaxPercentage/100;
		return $ServiceTaxOnExtraHours;
	}
	
	function CalculteTaxOnExtraPacks($amount)
	{
		$vatTaxPercentage = $this->GetVatforWithPackage();
		$SatTaxPercentage = $this->GetSatforWithPackage();
		$SerTaxPercentage = $this->GetServiceTaxforWithPackage();
		
		$VatOnExtraPacks = $amount*$vatTaxPercentage/100;
		$SatOnExtraPacks = $amount*$SatTaxPercentage/100;
		$SerTaxOnExtraPacks = $amount*$SerTaxPercentage/100;
		$totalTaxOnPacks = $VatOnExtraPacks+$SatOnExtraPacks+$SerTaxOnExtraPacks;
		
		 /*?>?>
        <script>
		alert('<?php echo $totalTaxOnPacks?>');
        </script>
        <?php<?php */
		
		return $totalTaxOnPacks; 
	}
	
	
	
	
	
	

}