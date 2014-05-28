<?php
session_start();
//include('connect_db.php');

include('../lib/Adodb/adodb.inc.php'); 

try { 
		$conn = ADONewConnection("ado_mssql");
		$conn2 = ADONewConnection("ado_mssql");
		$myDSN="PROVIDER=SQLOLEDB;DRIVER={SQL Server};" . "SERVER=SRGSQL8;DATABASE=MBOS_Intranet;UID=mbosuser;PWD=mbosuser99;";
		$myDSN2="PROVIDER=SQLOLEDB;DRIVER={SQL Server};" . "SERVER=SRGSQL8;DATABASE=User_Registration;UID=eoffice;PWD=srgeoffice235;";
		$conn->PConnect($myDSN);  
		$conn2->PConnect($myDSN2); //Connect,
								   //PConnect, = persistense connection, database yg berbeda, user yg sama, server yg sama
								   //NConnect  = new connection, database berbeda, user berbeda
	} catch (exception $e) { 
		   var_dump($e); 
		   adodb_backtrace($e->gettrace());
		   die;
	} 	
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$conn2->SetFetchMode(ADODB_FETCH_ASSOC);

$myYear = getdate(date('Y'));

//$table = "npPoint";
//$table = "test_Point";
$table = "point";
$sql = "select * from ".$table;
$rs = $conn->Execute($sql);


// $counter=3;
// $myCounter = "000".$counter."";
// while(!$rs->EOF){
	// $counter++;
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
	// $rs->MoveNext();
// }

$sql2 = "select div = (select top 1 divname from edm..division a 
where divcode = (select top 1 divcode from edm..section b 
where substring(c.cost_center,7,4) = b.costcenter)), 
dept = (select top 1 deptname from edm..department d 
where deptcode = (select top 1 deptcode from edm..section b 
where substring(c.cost_center,7,4) = b.costcenter))
from employee c where c.id_reference='".$_POST['nik']."'";

$rs2 = $conn2->Execute($sql2);

	//$arr["id_ins"] = "".$myYear[0]."/".$myCounter."";
	$arr["name"] = trim($_POST['name']);
	$arr["nik"] = trim($_POST['nik']);
	$arr["level"] = trim($_POST['lv']);
	$arr["division"] = str_replace('-','',trim($rs2->fields['div']));
	$arr["department"] = trim($rs2->fields['dept']);
	$arr["section"] = trim($_POST['seksi']);
	$arr["insert_date"] = date('d-m-Y H:i:s');
	$arr["point"] = trim($_POST['point']);
	$arr["remarks"] = trim($_POST['remarks']);
	$arr["uploaded_by"] = $_SESSION['userid'];
	$arr["last_update"] = date('d-m-Y H:i:s');

    $sql_check = "select count(*) from ".$table." where nik='".$arr["nik"]."' AND remarks='".$arr["remarks"]."";
    $rs_check = $conn->Execute($sql_check);
    if ($rs_check->fields[0]!=0){
        echo json_encode(array('failed'=>'Points with this Remark for this person was already inserted'));
        return false;   
    }
    else{
        try{
        	$insert = $conn->GetInsertSQL($rs, $arr);
        	$conn->Execute($insert);
        }
        catch(Exception $ex ){
        	echo json_encode(array('failed'=>'Point Insert failed'));
        	return false;
        }
    }


$rs->Close(); 
$rs_check->Close(); 
$conn->Close();
$rs2->Close(); 
$conn2->Close();

echo json_encode(array('success'=>'Point Insert success'));
?>