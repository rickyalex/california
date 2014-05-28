<?php 
include("../lib/Adodb/adodb-exceptions.inc.php");
include("../lib/Adodb/adodb.inc.php"); 

	try { 
		$conn = ADONewConnection("ado_mssql");
		$myDSN="PROVIDER=SQLOLEDB;DRIVER={SQL Server};" . "SERVER=172.16.160.2;DATABASE=MBOS_Intranet;UID=mbosuser;PWD=mbosuser99;";
		$conn->PConnect($myDSN);  //Connect,
								  //PConnect, = persistense connection, database yg berbeda, user yg sama, server yg sama
								  //NConnect  = new connection, database berbeda, user berbeda
	} catch (exception $e) { 
		var_dump($e); 
		adodb_backtrace($e->gettrace());
		die;
	}
return $conn;
?>