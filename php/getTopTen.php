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
	
	// $sql = "select name, division, total from (select top 10 name, division, (select sum(convert(int,point_remaining)))
			// as total from ppr group by nik, name, division order by total desc) as a
			// union
			// select name, division, total from (select top 10 name, division, (select sum(convert(int,point_remaining)))
			// as total from npPoint where point_status='active' group by nik, name, division order by total desc) as b order by total desc";
	$sql = "select name, division, total from (select top 10 name, division, (select sum(convert(int,point_remaining)))
			as total from Point where point_status='active' and level<8 and nik!='9100430' and nik!='9000349' group by nik, name, division order by total desc) as b order by total desc";		
	$rs = $conn->Execute($sql);
	if(!$rs){
		$myPoint =0;
	}
	else
	{
		$x = 1;
		while(!$rs->EOF){
			echo "<tr"; switch ($x){
				case 1 :
					echo ' class="success"';
					break;
				case 2 :
					echo ' class="warning"';
					break;
				case 3 :
					echo ' class="info"';
					break;
				}
				echo "><td>".$x."</td><td>".$rs->fields[0]."</td><td>".$rs->fields[1]."</td><td>".$rs->fields[2]."</td></tr>".PHP_EOL;
			$rs->MoveNext();
			$x++;
		}
	$x = 1;
	}
	$rs->Close();
	$conn->Close();
?>