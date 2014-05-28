<?php
	include("./lib/Adodb/adodb-exceptions.inc.php");
	include("./lib/Adodb/adodb.inc.php"); 

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
	//$sql = "select sum(convert(int,point_remaining)) from ppr where nik='".$_SESSION['id_employee']."'";
	// $sql="select (select sum(convert(int, a.point_remaining)) from ppr as a 
		 // where a.NIK='".$_SESSION['id_employee']."') as Project,
		 // (select sum(convert(int, b.point_remaining)) from npPoint as b 
		 // where b.point_status='active' and b.nik='".$_SESSION['id_reference']."') as Non_Project";
	// $sql="select (select sum(convert(int, a.point_remaining)) from ppr as a 
		  // where a.NIK='".$_SESSION['id_employee']."') as Project,
		  // (select sum(convert(int, b.point_remaining)) from point as b 
		  // where b.point_status='active' and b.nik='".$_SESSION['id_reference']."') as Non_Project";
	$table = "point";
	//$table = "test_point";
	$sql = "select sum(convert(int,point_remaining)) from ".$table." where 
		    nik='".$_SESSION['id_reference']."' and point_status='active'";
	$rs = $conn->Execute($sql);
	if($rs->fields[0]==null){
		$myPoint =0;
	}
	else
	{
		$myPoint = $rs->fields[0];
	}
	
	// if($rs->fields[1]==null){
		// $npPoint =0;
	// }
	// else
	// {
		// $npPoint = $rs->fields[1];
	// }
	
	//$myPoint = $pprPoint + $npPoint;
	
	$rs->Close();
	$conn->Close();
?>