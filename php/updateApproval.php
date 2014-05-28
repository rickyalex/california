<?php
include ("connect_db.php");
$sql = $_POST['mySql'];
$rs = $conn->Execute($sql);

$rs->Close(); 
$conn->Close();
?>