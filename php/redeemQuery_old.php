<?php
include("../lib/Adodb/adodb-exceptions.inc.php");
include('../lib/Adodb/adodb.inc.php'); 

$nik = $_POST['nik'];
$nama = $_POST['nama'];
$trp = $_POST['trp'];
$trp2 = $_POST['trp'];
$pa = $_POST['pa'];
$in = $_POST['in'];
$today = $_POST['today'];

$content = array();
//$retval2 = array();
$myYear = getdate(date('Y'));

//if(isset($sql){
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

	$counter=1;

	//$table="redeem";
	$table="test_redeem";
	$sql3 = "select * from ".$table;
	
	try{
		$rs = $conn->Execute($sql3);
	}
	catch(Exception $ex){
		echo json_encode(array('failed'=>'Select Redeem Failed'));
		return false;
	}
	
	$myCounter = "000".$counter."";
	while(!$rs->EOF){
		$counter++;
		if($counter>999){
			$myCounter = $counter;
		}
		elseif($counter>99){
			$myCounter = "0".$counter."";
		}
		elseif($counter>9){
			$myCounter = "00".$counter."";
		}
		else
		{
			$myCounter = "000".$counter."";
		}
		$rs->MoveNext();
	}
	
	$id_redeem = "".$myYear[0]."/".$myCounter."";
	$sql2 = "";
	// $sqlPoint = "select reg_no, point_remaining, convert(datetime, end_date, 103) as mydate 
				// from ppr where nik='".$nik."'
				// union
				// select id_ins, point_remaining, convert(datetime, start_date, 103) as mydate 
				// from npPoint where nik='".$nik."' and point_status = 'active' 
				// order by mydate";
	$table = "test_point";
	//$table = "point";
	$sql_pointPool = "select id_ins, point_remaining, convert(datetime, insert_date, 103) as mydate, id_redeem
				      from ".$table." where nik='".$nik."' and point_status='active' order by mydate";
	
	try{
		$rsPoint = $conn->Execute($sql_pointPool);
	}
	catch(Exception $ex){
		echo json_encode(array('failed'=>'Point Select Failed'));
		return false;
	}
	
	while(!$rsPoint->EOF){
		$id = isset($rsPoint->fields['id_ins']) ? $rsPoint->fields['id_ins'] : '';
		$pRemain = isset($rsPoint->fields['point_remaining']) ? $rsPoint->fields['point_remaining'] : 0;
		$listedRedeem = isset($rsPoint->fields['id_redeem']) ? $rsPoint->fields['id_redeem'].', ' : '';
		
		$sqlSelect = "select top 0 * from ".$table. "where id_ins='".$id."'";
		$rs = $conn->Execute($sqlSelect);
		//$date = $rsPoint->fields['mydate'];
		
		
		//jika bukan merupakan Point Insert
		// if(strlen($id)!=9){
			// $trp = $trp - $pRemain;
			// if($trp<0){ //if the substraction is under 0
				// $pRemain = $pRemain + $trp;
				// $sql2 .= "update ppr set Point_Remaining='".$pRemain."', 
						 // Is_Used='Yes', ID_Redeem='".$id_redeem."', last_update='".date('d-m-Y H:i:s')."' 
						 // where Reg_No ='".$id."';";
				// break;
			// }
			// else if($trp==0){ #if the substraction is precisely 0
				// $pRemain = $pRemain - $pRemain;
				// $sql2 .= "update ppr set Point_Remaining='".$pRemain."', 
						 // Is_Used='Yes', ID_Redeem='".$id_redeem."', point_status='Depleted', last_update='".date('d-m-Y H:i:s')."' 
						 // where Reg_No ='".$id."';";
				// break;
			// }
			// else{
				// $pRemain = $pRemain - $pRemain;
				// $sql2 .= "update ppr set Point_Remaining='".$pRemain."', 
						 // Is_Used='Yes', ID_Redeem='".$id_redeem."', point_status='Depleted', last_update='".date('d-m-Y H:i:s')."' 
						 // where Reg_No='".$id."';";
			// }
		//}
		//else{
			$trp = $trp - $pRemain;
			if($trp<0){ //if the substraction is under 0
				$content["point_remaining"] = $pRemain + $trp;
				$content["is_used"]= "Yes";
				$content["last_update"]= date('d-m-Y H:i:s');
				$content["id_redeem"]= $listedRedeem.$id_redeem;
				
				$sql2 .= $conn->GetUpdateSQL($rs, $content);
				// $sql2 .= "update npPoint set Point_Remaining='".$pRemain."', 
						 // Is_Used='Yes', ID_Redeem='".$listedRedeem.$id_redeem."', last_update='".date('d-m-Y H:i:s')."' 
						 // where id_ins ='".$id."';";
				
				break;
			}
			else if($trp==0){ #if the substraction is precisely 0
				$content["point_remaining"] = $pRemain - $pRemain;
				$content["point_status"] = "Depleted";
				$content["is_used"]= "Yes";
				$content["last_update"]= date('d-m-Y H:i:s');
				$content["id_redeem"]= $listedRedeem.$id_redeem;
				
				$sql2 .= $conn->GetUpdateSQL($rs, $content);
				// $sql2 .= "update npPoint set Point_Remaining='".$pRemain."', 
						 // Is_Used='Yes', ID_Redeem='".$listedRedeem.$id_redeem."', point_status='Depleted', last_update='".date('d-m-Y H:i:s')."' 
						 // where id_ins ='".$id."';";
				break;
			}
			else{
				$content["point_remaining"] = $pRemain - $pRemain;
				$content["point_status"] = "Depleted";
				$content["is_used"]= "Yes";
				$content["last_update"]= date('d-m-Y H:i:s');
				$content["id_redeem"]= $listedRedeem.$id_redeem;
				
				$sql2 .= $conn->GetUpdateSQL($rs, $content);
				
				// $sql2 .= "update npPoint set Point_Remaining='".$pRemain."', 
						 // Is_Used='Yes', ID_Redeem='".$listedRedeem.$id_redeem."', point_status='Depleted', last_update='".date('d-m-Y H:i:s')."' 
						 // where id_ins='".$id."';";
			}
		//}
		// try{
			// $conn->Execute($sql2);
		// }
		// catch(Exception $ex){
			// echo json_encode(array('failed'=>'Point Substraction Failed'));
			// return false;
		// }
		$rsPoint->MoveNext();
	}
	echo json_encode(array('failed'=>$sql2));
	return false;
	die;
	
	
	// try{
		// $conn->Execute($sql2);
	// }
	// catch(Exception $ex){
		// echo json_encode(array('failed'=>'Point Substraction Failed'));
		// return false;
	// }
	
	$content2 = array();
	$table = "test_redeem";
	//$table = "redeem";
	$sqlSelect = "select top 0 * from ".$table;
	$rs = $conn->Execute($sqlSelect);
	
	$content2["id_redeem"] = $id_redeem;
	$content2["redeem_date"] = $today;
	$content2["nik"] = $nik;
	$content2["nama"] = $nama;
	$content2["item_type"] = $in;
	$content2["point_before"] = $pa;
	$content2["point_after"] = ($pa-$trp2);
	
	$sql4 = $conn->GetInsertSQL($rs, $content2);
	// $sql4 = "insert into redeem (id_redeem,redeem_date,nik,name,item_type,point_before,point_after) 
			// values ('".$id_redeem."','".$today."','".$nik."','".$nama."','".$in."','".$pa."','".($pa-$trp2)."')";

	// try{
		// $conn->Execute($sql4);
	// }
	// catch(Exception $ex){
		// echo json_encode(array('failed'=>'Redeem Insert Failed'));
		// return false;
	// }
	$rs->Close(); # optional
	$conn->Close(); # optional
	
	echo json_encode(array('success'=>'Redeem Request Sukses'));
?>