<?php
include ("connect_db.php");
$sql = $_POST['mySql'];
$rs = $conn->Execute($sql);
$arr = array();
$x=0;
while(!$rs->EOF){

  array_push($arr, array(
		'insert_date' => $rs->fields[7],
		'status' => $rs->fields[8] == 'a' ? "Approved" : "Waiting",
		'point' => $rs->fields[9],
		'is_used' => $rs->fields[10],
		'point_remaining' => $rs->fields[11],
		'point_status' => $rs->fields[12],
		'remarks' =>$rs->fields[13],
		'uploaded_by' => $rs->fields[14]
	));
  $rs->MoveNext();
}
$rs->Close(); 
$conn->Close(); 

//buat sbg json format
$result = json_encode($arr);
echo $result;
?>