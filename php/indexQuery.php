<?php
session_start();
$userid = $_SESSION['userid'];

$arr = $_POST['myArr'];
$content = array();

if ( isset($arr) ) {
	include("../lib/Adodb/adodb-exceptions.inc.php");
	include('../lib/Adodb/adodb.inc.php'); 

	try { 
		$conn = ADONewConnection("ado_mssql");
		$myDSN="PROVIDER=SQLOLEDB;DRIVER={SQL Server};" . "SERVER=SRGSQL8;DATABASE=MBOS_Intranet;UID=mbosuser;PWD=mbosuser99;";
		$conn->PConnect($myDSN);  //Connect,
								  //PConnect, = persistense connection, database yg berbeda, user yg sama, server yg sama
								  //NConnect  = new connection, database berbeda, user berbeda
	} catch (exception $e) { 
		var_dump($e); 
		adodb_backtrace($e->gettrace());
		die;
	}
	
	$conn->SetFetchMode(ADODB_FETCH_ASSOC);
	
	$myYear = getdate(date('Y'));

	
	
	if(!$arr == ""){
		$row = count($arr);
		$content = array();
		$script ="";
			
		// $sql = "select count(id_ins) as x from nppoint";
		// $rs = $conn->Execute($sql);
		// $counter = $rs->fields['x']+3;
		for($x=0;$x<$row;$x++){
		
			// if($counter>999){
				// $myCounter = $counter;
			// }
			// elseif($counter>99){
				// $myCounter = "0".$counter."";
			// }
			// elseif($counter>9)
			// {
				// $myCounter = "00".$counter."";
			// }
			// else
			// {
				// $myCounter = "000".$counter."";
			// }
			$table = "point";
			//$table = "test_point";
			$sql = "select top(0) * from ".$table;
			$rs = $conn->Execute($sql);
	
			// $content["id_ins"] = "".$myYear[0]."/".$myCounter."";
			$content["nik"] = $arr[$x][0];
			$content["name"] = $arr[$x][1];
			$content["level"] = $arr[$x][2];
			$content["division"] = $arr[$x][3];
			$content["department"] = $arr[$x][4];
			$content["section"] = $arr[$x][5];
			$content["point"] = $arr[$x][6];
			$content["remarks"] = $arr[$x][7];
			$content["insert_date"] = date('d-m-Y H:i:s');
			$content["uploaded_by"] = $_SESSION['userid'];
			$content["last_update"] = date('d-m-Y H:i:s');
			
			$script = $script." ".$conn->GetInsertSQL($rs, $content);
			
			//$counter++;
		}
	}
	else{
		$script = "empty";
		//return false;
		die("Unable to retrieve data");
	}
	
	try{
		$conn->StartTrans();
		$conn->Execute($script);
		$conn->CompleteTrans();
	}
	catch (exception $e){ 
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
	//$conn->Close(); # optional

	echo json_encode(array('success'=>'Point Insert Success'));
}
else{
	echo json_encode(array('failed'=>'Point Insert failed'));
	die("Array Empty");
}
?>