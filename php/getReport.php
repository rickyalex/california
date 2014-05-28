<?php
include ("connect_db.php");
$sql = $_POST['mySql'];
$rs = $conn->Execute($sql);
$arr = array();
$x=0;
while(!$rs->EOF){

  array_push($arr, array(
		'Reg_No' => $rs->fields[0],
		'Project_Title' => $rs->fields[1],
		'End_Date' => $rs->fields[2],
		'total' => $rs->fields[3]
	));
  $rs->MoveNext();
}
$rs->Close(); 
$conn->Close(); 

//buat sbg json format
$result = json_encode($arr);
echo $result;
?>