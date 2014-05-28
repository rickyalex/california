<?php
include ("connect_db.php");
$sql = $_POST['mySql'];
$rs = $conn->Execute($sql);
$arr = array();
$x=0;
while(!$rs->EOF){

  array_push($arr, array(
		'id_redeem' => $rs->fields[0],
		'name' => $rs->fields[3],
		'nik' => $rs->fields[2],
		'redeem_date' => $rs->fields[1],
		'item_type' => $rs->fields[4],
		'status' => $rs->fields[7]=='a' ? "Approved" : "Waiting",
		'approve' => $rs->fields[7]=='a' ? "<center><img src='images/tree_dnd_yes.png' /></center>" : '<center><a style="cursor:pointer" onclick="approve(\'R'.$rs->fields[0].'\');">Approve</a></center>'
	));
  $rs->MoveNext();
}
$rs->Close(); 
$conn->Close(); 

//buat sbg json format
$result = json_encode($arr);
echo $result;
?>