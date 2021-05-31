<?php

/**
 * Copyright (c) 2010-2013 Techno Vibes (http://technovibes.net/)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Version: 1.2.4
 * Author: Ayush Khanna (www.ayushkhanna.in) contact email- ayush@technovibes.net 
 * Company Name: Techno Vibes
 * Official website: www.TechnoVibes.net
 * Contact Email: info@technovibes.net
 * Phone: +91-9889683302
 * TERMS OF USE -
 * 
 * This File is Property of Techno Vibes Only, No one can use or modify this file with prior written information at email info@technovibes.net .  
 * 
 * Copyright © 2010 Techno Vibes (www.technovibes.net)
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are also not allowed:
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission (on email info@technovibes.net).
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
.---------------------------------------------------------------------------.
|    Author: Ayush Khanna (Techno Vibes)                                    |
|    Contact Email: ayush@technovibes.net                                   |
|    Phone: +91-9889683302                                                  |
|    Copyright (c) 2009-2015, Techno Vibes. All Rights Reserved.            |
|   Support: Email to ayush@technovibes.net                                 |
| ------------------------------------------------------------------------- |
|   License: Distributed under the Lesser General Public License (LGPL)     |
|            http://www.gnu.org/copyleft/lesser.html                        |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
| ------------------------------------------------------------------------- |
| We offer a number of paid services (www.technovibes.net):                 |
| - Web Hosting on highly optimized fast and secure servers                 |
| - Technology Consulting                                                   |
| - Oursourcing (highly qualified programmers and graphic designers)        |
'---------------------------------------------------------------------------'
 
 */
 
 
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//														Techno Vibes (ayush@technovibes.net)									//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//		This Page is to Generate Javascript Codes For Form Validation																//
	//				[ Limitation: ]																										//
	//==================================================================================================================================//
	//	function ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields="",$ErrorMsgForSameFields=""):- 	//
	//			This Function Takes 5 Parameter																							//
	//	$FormName = The Name of the Form Inside which the HTML Controls(Eg. Textbox, List) are.											//
	//	$ControlNames = Two dimensional Array Consists Control Name, Value for Check and Error Message(expected).						//
	//	$ValidationFunctionName = The Name of Javascript Function Which will generated.													//
	//	$SameFields = Two Control Names in One Dimensional Format which Contents needed to be Same.										//
	//	$ErrorMsgForSameFields = Expected Error Message Which Will Returned For Same Field.												//
	//----------------------------------------------------------------------------------------------------------------------------------//
	/*
		Example:- 
				require_once("ClsJSFormValidation.cls.php");
				$Validity=new ClsJSFormValidation;
				$FormName="all";
				$ControlNames=array("txtName"			=>array("txtName","''","Please Enter Your Name.","spanname"));
				$ValidationFunctionName="CheckValidity";
				$SameFields=array("txtPassword","txtConfirmPassword");
				$ErrorMsgForSameFields="Password and Confirm Password Are not Same.";
				$JsCodeForFormValidation=$Validity->ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields,$ErrorMsgForSameFields);
				echo $JsCodeForFormValidation;
	*/		
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	class ClsJSFormValidation
	{
		function ShowJSFormValidationCode($FormName,$ControlNames,$ValidationFunctionName,$SameFields="",$ErrorMsgForSameFields="")
		{
			$JSValidation="<script language='javascript1.2'>
							function $ValidationFunctionName()
							{	
							
							var ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i; 
							var ck_number = /^\d+$/;
							var ck_price = /^\d+(\.\d\d)?$/;
							var ck_postalCode = /^[A-Za-z]{1}\d[A-Za-z]{1}\d[A-Za-z]{1}\d$/;
							var ck_mobile = /^\d\d\d\d\d\d\d\d\d\d$/;
							var ck_phone_number9 = /^\d\d\d\d\d\d\d\d\d$/;
							var ck_password =  /^[A-Za-z0-9!@#$%^&*()_]{6,20}$/;
							var ck_username =  /^[A-Za-z0-9_]{6,20}$/;

							var returnValue=true;\n";
			foreach($ControlNames as $SingleControlName) {
					switch($SingleControlName[1])
					{
						case "''": 		
										$JSValidation.="
											if(document.$FormName.$SingleControlName[0].value=='')
											{
												document.getElementById('$SingleControlName[3]').className='noteerror';
											document.getElementById('$SingleControlName[3]').innerHTML=' $SingleControlName[2]';
												//document.$FormName.$SingleControlName[0].focus();			
												returnValue=false;
											 }
											 else
											 {
												document.getElementById('$SingleControlName[3]').className='';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }	\n";
									
										break;
						case "Number":	$JSValidation.="
											var number;
											number=document.$FormName.$SingleControlName[0].value;

											if (!ck_number.test(number))
											{
												document.getElementById('$SingleControlName[3]').className='noteerror';
											document.getElementById('$SingleControlName[3]').innerHTML=' $SingleControlName[2]';
												//document.$FormName.$SingleControlName[0].focus();			
												returnValue=false;
											}
											else
											 {
												document.getElementById('$SingleControlName[3]').className='';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }		\n";
										break;

						case "Price":	$JSValidation.="
											var price;
											price=document.$FormName.$SingleControlName[0].value;

											if (!ck_price.test(price))
											{
												document.getElementById('$SingleControlName[3]').className='noteerror';
												document.getElementById('$SingleControlName[3]').innerHTML=' Please enter price in format(0.00) only.';
												//document.$FormName.$SingleControlName[0].focus();			
												returnValue=false;
											}
											else
											 {
												document.getElementById('$SingleControlName[3]').className='';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }		\n";
										break;

						case "Mobile":	$JSValidation.="
											var mobile;
											mobile=document.$FormName.$SingleControlName[0].value;

											if (!ck_mobile.test(mobile))
											{
												document.getElementById('$SingleControlName[3]').className='noteerror';
												document.getElementById('$SingleControlName[3]').innerHTML=' $SingleControlName[2].';
												//document.$FormName.$SingleControlName[0].focus();			
												returnValue=false;
											}
											else
											 {
												document.getElementById('$SingleControlName[3]').className='';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }		\n";
										break;

						case "VPhoneNumber9":	$JSValidation.="
											var phone_number9;
											phone_number9=document.$FormName.$SingleControlName[0].value;

											if(phone_number9){
											if (!ck_phone_number9.test(phone_number9))
											{
												document.getElementById('$SingleControlName[3]').className='noteerror';
												document.getElementById('$SingleControlName[3]').innerHTML='$SingleControlName[2].';
												//document.$FormName.$SingleControlName[0].focus();			
												returnValue=false;
											}
											else
											 {
												document.getElementById('$SingleControlName[3]').className='';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }
											}else
											 {
												document.getElementById('$SingleControlName[3]').className='';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }
											 		\n";
										break;

							case "EMail":	$JSValidation.="
												var checkEmail;
												checkEmail=document.$FormName.$SingleControlName[0].value;
	
												if (!ck_email.test(checkEmail))
												{
													document.getElementById('$SingleControlName[3]').className='noteerror';
													document.getElementById('$SingleControlName[3]').innerHTML=' $SingleControlName[2]';
													//document.$FormName.$SingleControlName[0].focus();			
													returnValue=false;
												}
												else
												 {
													document.getElementById('$SingleControlName[3]').className='';
													document.getElementById('$SingleControlName[3]').innerHTML='';
												 }		\n";
										break;

							case "VPostalCode":	$JSValidation.="
												var postalCode;
												postalCode=document.$FormName.$SingleControlName[0].value;
	
												if(postalCode){
												if (!ck_postalCode.test(postalCode))
												{
													document.getElementById('$SingleControlName[3]').className='noteerror';
													document.getElementById('$SingleControlName[3]').innerHTML='<br>Please enter postal code in the format A1B2C3.';
													//document.$FormName.$SingleControlName[0].focus();			
													returnValue=false;
												}
												else
												 {
													document.getElementById('$SingleControlName[3]').className='';
													document.getElementById('$SingleControlName[3]').innerHTML='';
												 }
												}else
												 {
													document.getElementById('$SingleControlName[3]').className='';
													document.getElementById('$SingleControlName[3]').innerHTML='';
												 }
												 		\n";
										break;

							case "VEMail":	$JSValidation.="
												var checkEmail;
												checkEmail=document.$FormName.$SingleControlName[0].value;
	
												if(checkEmail){
												if (!ck_email.test(checkEmail))
												{
													document.getElementById('$SingleControlName[3]').className='noteerror';
													document.getElementById('$SingleControlName[3]').innerHTML=' Invalid Email Address.';
													//document.$FormName.$SingleControlName[0].focus();			
													returnValue=false;
												}
												else
												 {
													document.getElementById('$SingleControlName[3]').className='';
													document.getElementById('$SingleControlName[3]').innerHTML='';
												 }
												}else
												 {
													document.getElementById('$SingleControlName[3]').className='';
													document.getElementById('$SingleControlName[3]').innerHTML='';
												 }
												 \n";
										break;
						case "Agree": 		
										$JSValidation.="
											if(!(document.$FormName.$SingleControlName[0].checked))
											{
												document.getElementById('$SingleControlName[3]').className='noteerror';
												document.getElementById('$SingleControlName[3]').innerHTML='You must accept the terms and conditions to proceed.';
												//document.$FormName.$SingleControlName[0].focus();			
												returnValue=false;
											 }
											 else
											 {
												document.getElementById('$SingleControlName[3]').className='';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }	\n";
									
										break;
						case "UserName":	$JSValidation.="
											var username;
											username=document.$FormName.$SingleControlName[0].value;
											if(!ck_username.test(username))
											{
												document.getElementById('$SingleControlName[3]').className='required';
												document.getElementById('$SingleControlName[3]').innerHTML='Please enter a valid name.';
												//document.$FormName.$SingleControlName[0].focus();			
												returnValue=false;
											}
											else
											 {
												document.getElementById('$SingleControlName[3]').className='normal';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }		\n";
										break;
						case "Password":	$JSValidation.="
											var password;
											password=document.$FormName.$SingleControlName[0].value;
											if(!ck_password.test(password))
											{
												document.getElementById('$SingleControlName[3]').className='noteerror';
												document.getElementById('$SingleControlName[3]').innerHTML=' Invalid Password. Should be in range(6-20)';
												//document.$FormName.$SingleControlName[0].focus();			
												returnValue=false;
											}
											else
											 {
												document.getElementById('$SingleControlName[3]').className='';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }		\n";
										break;
						case "VPassword":	$JSValidation.="
											var password;
											password=document.$FormName.$SingleControlName[0].value;
											if(password){
											if(!ck_password.test(password))
											{
												document.getElementById('$SingleControlName[3]').className='noteerror';
												document.getElementById('$SingleControlName[3]').innerHTML=' Invalid Password. Should be in range(6-20)';
												//document.$FormName.$SingleControlName[0].focus();			
												returnValue=false;
											}
											else
											 {
												document.getElementById('$SingleControlName[3]').className='';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }
											}else
											 {
												document.getElementById('$SingleControlName[3]').className='';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }
											 		\n";
										break;
						case "RePassword":	$JSValidation.="
											var repassword;
											repassword=document.$FormName.$SingleControlName[0].value;
											password=document.$FormName.$SingleControlName[4].value;
											if(!ck_password.test(repassword))
											{
												document.getElementById('$SingleControlName[3]').className='noteerror';
												document.getElementById('$SingleControlName[3]').innerHTML=' Invalid Password.';
												//document.$FormName.$SingleControlName[0].focus();			
												returnValue=false;
											}
											else if(repassword!=password) {
												document.getElementById('$SingleControlName[3]').className='noteerror';
												document.getElementById('$SingleControlName[3]').innerHTML=' $SingleControlName[2]';
												//document.$FormName.$SingleControlName[0].focus();			
												returnValue=false;
											}
											else {
												document.getElementById('$SingleControlName[3]').className='';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }		\n";
										break;
						default: 			$JSValidation.="
											if(document.$FormName.$SingleControlName[0].value=='')
											{
												document.getElementById('$SingleControlName[3]').className='noteerror';
												document.getElementById('$SingleControlName[3]').innerHTML=' $SingleControlName[2]';
												//document.$FormName.$SingleControlName[0].focus();			
												returnValue=false;
											 }
											  else
											 {
												document.getElementById('$SingleControlName[3]').className='';
												document.getElementById('$SingleControlName[3]').innerHTML='';
											 }	\n";
									

					}	//End of Switch
				}		
			$JSValidation.=" return returnValue;
							 }		//End of JS Validation Function
							 </script>	\n";
			return $JSValidation;
		}
	
	
}
?>