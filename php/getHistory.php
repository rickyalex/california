<?php
include ("connect_db.php");
$sql = $_POST['mySql'];
$rs = $conn->Execute($sql);
$arr = array();
$x=0;
while(!$rs->EOF){

  array_push($arr, array(
		'Project_Role' => $rs->fields[3],
		'Reg_No' => $rs->fields[4],
		'Project_Title' => $rs->fields[6],
		'Start_Date' => $rs->fields[10],
		'End_Date' => $rs->fields[11],
		'Point' => $rs->fields[23],
		'Is_Used' => $rs->fields[24],
		'Point_Remaining' => $rs->fields[25]
	));
  $rs->MoveNext();
}
$rs->Close(); 
$conn->Close(); 

//buat sbg json format
$result = json_encode($arr);
echo $result;
?>