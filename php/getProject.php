<?php
include ("connect_db.php");
$sql = $_POST['mySql'];
$rs = $conn->Execute($sql);
$arr = array();
$x=0;
while(!$rs->EOF){

  array_push($arr, array(
		'reg_no' => $rs->fields[4],
		'project_title' => $rs->fields[6],
		'name' => $rs->fields[0],
		'nik' => $rs->fields[1],
		'end_date' => $rs->fields[11],
		'project_role' => $rs->fields[3]
		));
  $rs->MoveNext();
}
$rs->Close(); 
$conn->Close(); 

//buat sbg json format
$result = json_encode($arr);
echo $result;
?>