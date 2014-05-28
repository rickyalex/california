<?php
include ("connect_db.php");
$sql = $_POST['mySql'];
$rs = $conn->Execute($sql);
$arr = array();
$x=0;
while(!$rs->EOF){

  array_push($arr, array(
		'ID_Redeem' 	=> $rs->fields[0],
		'Redeem_Date' 	=> $rs->fields[1],
		'NIK'			=> $rs->fields[2],
		'Name'			=> $rs->fields[3],
		'Item_Type'		=> $rs->fields[4],
		'Point_Before'	=> $rs->fields[5],
		'Point_After'	=> $rs->fields[6],
		'Status'		=> $rs->fields[7]=='a' ? "approved" : "waiting"
	));
  $rs->MoveNext();
}
$rs->Close(); 
$conn->Close(); 

//buat sbg json format
$result = json_encode($arr);
echo $result;
?>