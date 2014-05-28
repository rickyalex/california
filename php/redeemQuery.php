<?php

	include("../lib/Adodb/adodb-exceptions.inc.php");
	include('../lib/Adodb/adodb.inc.php'); 
    //include_once('functions.php');

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
	
$conn->SetFetchMode(ADODB_FETCH_ASSOC);

$get = isset ($_POST['data']) ? $_POST['data'] : '';
if($get==''){
    echo json_encode(array('success'=>false, 'message'=>'Post failed !'));
    return false;
}

$myYear = getdate(date('Y'));

$arr = array();
$arr['nama'] = $get[0];
$arr['trp'] = $get[1];
$arr['trp2'] = $get[1];
$arr['pa'] = $get[2];
$arr['in'] = $get[3];
$arr['today'] = $get[4];
$arr['nik'] = $get[5];

$table="redeem";
//$table="test_redeem";
$sql = "select * from ".$table;
	
try{
	$rs = $conn->Execute($sql);
}
catch(Exception $ex){
	echo json_encode(array('success'=>false, 'message'=> 'Select Redeem failed !'));
	return false;
}


$sqlUpdate = "";
//$table = "test_point";
$table = "point";
$sql_pointPool = "select id_ins, point_remaining, convert(datetime, insert_date, 103) as mydate, id_redeem
			      from ".$table." where nik='".$arr['nik']."' and point_status='active' order by mydate";

try{
	$rsPoint = $conn->Execute($sql_pointPool);
}
catch(Exception $ex){
	echo json_encode(array('success'=>false, 'message'=> 'Select Point failed !'));
	return false;
}	

while(!$rsPoint->EOF){
    
	$id = isset($rsPoint->fields['id_ins']) ? $rsPoint->fields['id_ins'] : '';
	$pRemain = isset($rsPoint->fields['point_remaining']) ? $rsPoint->fields['point_remaining'] : 0;
	$listedRedeem = isset($rsPoint->fields['id_redeem']) ? $rsPoint->fields['id_redeem'].', ' : '';
	
	$sqlSelect = "select top 0 * from ".$table." where id_ins='".$id."'";
	$rsSelect = $conn->Execute($sqlSelect);
	
		if(($arr['trp'] - $pRemain)<0){ //if the substraction is under 0 (redeem points are used up)
			$content["point_remaining"] = $pRemain - $arr['trp'];
			$content["point_status"] = "Active";
			$content["is_used"]= "Yes";
			$content["last_update"]= date('d-m-Y H:i:s');
			$content["id_redeem"]= $listedRedeem.date("dmyHis");
			
			$sqlUpdate .= $conn->GetUpdateSQL($rsSelect, $content);
            $arr['trp'] = 0;
		}
		elseif(($arr['trp'] - $pRemain)>0){ //the substraction is above 0
			$content["point_remaining"] = $pRemain - $pRemain;
			$content["point_status"] = "Depleted";
			$content["is_used"]= "Yes";
			$content["last_update"]= date('d-m-Y H:i:s');
			$content["id_redeem"]= $listedRedeem.date("dmyHis");
			
			$sqlUpdate .= $conn->GetUpdateSQL($rsSelect, $content);
            $arr['trp'] = $arr['trp'] - $pRemain;
		}
        elseif(($arr['trp'] - $pRemain)==0){ //the substraction points is exactly 0
            $content["point_remaining"] = $pRemain - $pRemain;
			$content["point_status"] = "Depleted";
			$content["is_used"]= "Yes";
			$content["last_update"]= date('d-m-Y H:i:s');
			$content["id_redeem"]= $listedRedeem.date("dmyHis");
			
			$sqlUpdate .= $conn->GetUpdateSQL($rsSelect, $content);
            $arr['trp'] = $arr['trp'] - $pRemain;
        }
		
	//}
	if($arr['trp']==0) break;
    else $rsPoint->MoveNext();
}

//$content2 = array();
//$content2["id_redeem"] = date("dmyHis");
//$content2["redeem_date"] = date('d-m-Y');
//$content2["nik"] = $arr['nik'];
//$content2["name"] = $arr['nama'];
//$content2["item_type"] = $arr['in'];
//$content2["point_before"] = $arr['pa'];
//$content2["point_after"] = ($arr['pa']-$arr['trp2']);
//$content2["last_update"] = date('d-m-Y H:i:s');

//$sqlRedeem = $conn->GetInsertSQL($rs, $content2);
$sqlRedeem = "INSERT INTO redeem ( ID_REDEEM, REDEEM_DATE, NIK, NAME, ITEM_TYPE, POINT_BEFORE, POINT_AFTER, LAST_UPDATE ) VALUES ( '".date('dmyHis')."', '".date('Y-m-d H:i:s')."', '".$arr['nik']."', '".$arr['nama']."', '".$arr['in']."', '".$arr['pa']."', '".($arr['pa']-$arr['trp2'])."', '".date('Y-m-d H:i:s')."')";
try{
    $conn->autoCommit = false;
    $conn->autoRollback = true;
    $conn->StartTrans();
	$conn->Execute($sqlUpdate);
	$conn->Execute($sqlRedeem);
    $conn->CompleteTrans();
}
catch(Exception $ex){
	echo json_encode(array('success'=>false,'message'=>'Redeem Failed. Please contact your Administrator'));
	return false;
}
	
echo json_encode(array('success'=>true,'message'=>'Redeem Success'));

$rs->close();
$conn->close();
?>