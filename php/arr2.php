<?php
session_start();
$userid = $_SESSION['userid'];

$content = $_POST['myArr'];

if ( isset($content) ) {
	include("../lib/Adodb/adodb-exceptions.inc.php");
include('../lib/Adodb/adodb.inc.php'); 

	try { 
		$conn = ADONewConnection("ado_mssql");
		$myDSN="PROVIDER=SQLOLEDB;DRIVER={SQL Server};" . "SERVER=SRGSQL8;DATABASE=MBOS_Intranet;UID=mbosuser;PWD=mbosuser99;";
		$conn->PConnect($myDSN);  //Connect,
								  //PConnect, = persistense connection, database yg berbeda, user yg sama, server yg sama
								  //NConnect  = new connection, database berbeda, user berbeda
		echo "success";
	} catch (exception $e) { 
		var_dump($e); 
		adodb_backtrace($e->gettrace());
		die;
	}
	
	$filename = "post.txt";
	$handle = fopen($filename, "w+");
	
	if(!$content == ""){
		$script = ltrim($content);
		$script = substr_replace($script,"",0,1);
		$script = str_ireplace("[","insert into test_PPR (Name, NIK, Level, Project_Role, Reg_No, Rev_No, " . 
								   "Project_Title, Location, Division, Department, Start_Date, End_Date, Project_Status, Metric, " .
								   "Metric_UOM, Metric_Sign, Metric_Baseline, Metric_Target, Metric_Actual, Metric_TAR, " .
								   "FB_Target, FB_Actual, FB_Verified, Point, Uploaded_By) values (",$script);
		$script = str_ireplace("'"," ",$script); //cleans the ' away
		$script = str_ireplace('"',"'",$script); //replaces " with '
		$script = str_ireplace("\'","",$script);		
		$script = str_ireplace("],",");",$script);
		$script = str_ireplace("]]",");",$script);
		$script[strlen($script)] = "";
		fwrite($handle, $script);
		fclose($handle); 
	}
	else{
		$script = "empty";
		return false;
		die("Unable to retrieve data");
	}
	
	$handle2 = fopen($filename, "r");
	
	while(!feof($handle2))
	{
		$script2 = fgets($handle2);
	}
	
	try{
		$conn->StartTrans();
		$conn->Execute($script2);
		$conn->CompleteTrans();
	}
	catch (exception $e) { 
		var_dump($e); 
		adodb_backtrace($e->gettrace());
		return $e;
	}
	
	// try{
		//$conn->StartTrans();
		// $sql = "select * from ppr where Project_Role='Leader'";
		// $rs2 = $conn->Execute($sql);
		// $updateSQL = $conn->GetUpdateSQL($rs2, $emp);
		// $conn->Execute($updateSQL);
		//if ($rs) $rs = $conn->Execute($sql2);

		//$conn->Execute($sql2);

		//$conn->CompleteTrans();
	// }
	// catch (exception $e) { 
		   // var_dump($e); 
		   // adodb_backtrace($e->gettrace());
		   // die;
	// }
	fclose($handle2);
	$conn->Close(); # optional

	return "Data Upload Success";
}
else{
	die("Array Empty");
}
?>