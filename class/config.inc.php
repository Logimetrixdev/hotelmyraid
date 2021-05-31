<?php
	@session_start();
/*	
$host = '';

if (isset($_SERVER['HTTP_HOST'])) //some says that this might not be set in IIS

		$host = $_SERVER['HTTP_HOST'];

	else if (isset($_SERVER['SERVER_NAME']))

		$host = $_SERVER['SERVER_NAME'];

$CFG['site']['url'] = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://'

                       . $host

                       . str_replace(

					   			array('admin/'),

					   			'',

								substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')+1)

							);

$CFG['site']['project_path'] = str_replace(

									array('\\', 'admin/', 'class/'),

									array('/' , ''       , ''),

								    substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/')+1)
									);
									
*/	//**************** include classes *************************
	require_once("global.config.php");
        
	require_once("database.inc.php");
	require_once("class.user.php");
	require_once("class.Authentication.php");
	require_once("ClsJSFormValidation.cls.php");
	require_once("class.FormValidation.php");
	require_once("class.Notification.php");
	require_once("liveX/PHPLiveX.php");
	require_once("class.layout.php");
	require_once("class.banquet_reservation.php");
	require_once("class.reservation.php");
	require_once("class.master.php");
	require_once("class.phpmailer.php");
	require_once("class.housekeeping.php");
	require_once("class.Kot.php");
	 require_once("class.TaxReport.php");
	require_once("class.Report.php");
	require_once("class.ReportHelper.php");
	require_once("class.Report_Kot.php");
	//**************** Database Configuration local development server ****************
	/*define("DATABASE_HOST","localhost",true);
	define("DATABASE_PORT","3306",true);
	define("DATABASE_USER","root",true);
	define("DATABASE_PASSWORD","",true);
	define("DATABASE_NAME","lawfunda",true);*/
	
	//**************** Database Configuration online development server ****************
	
	define("DATABASE_HOST","localhost",true);
	define("DATABASE_PORT","",true);
	define("DATABASE_USER","sjslayjy_lalganj",true);
	define("DATABASE_PASSWORD","Abhishek@987",true);
	define("DATABASE_NAME","sjslayjy_pmms",true);
	
	//*************** Set Time Zone ***************************//
	
	date_default_timezone_set("Asia/Kolkata");
	
?>