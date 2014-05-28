<?php
include ("connect_db.php");
$sql = $_POST['mySql'];
$rs = $conn->Execute($sql);
$arr = array();
$x=0;
while(!$rs->EOF){

  array_push($arr, array(
		'id_ins' => $rs->fields[0],
		'name' => $rs->fields[2],
		'nik' => $rs->fields[1],
		'insert_date' => $rs->fields[7],
		'point' => $rs->fields[9],
		'remarks' => $rs->fields[13],
		'status' => $rs->fields[8]=='a' ? "Approved" : "Waiting",
		'approve' => $rs->fields[8]=='a' ? "<center><img src='images/tree_dnd_yes.png' /></center>" : '<center><a style="cursor:pointer" onclick="approve(\'P'.$rs->fields[0].'\');">Approve</a></center>'
	));
  $rs->MoveNext();
}
$rs->Close(); 
$conn->Close(); 

//buat sbg json format
$result = json_encode($arr);
echo $result;
?>