<?php
include("connect_db.php");

$sql = "select distinct division from point";
$rs = $conn->Execute($sql);

while(!$rs->EOF){
    echo "<option value='".$rs->fields[0]."'>".$rs->fields[0]."</option>";
    $rs->MoveNext();
}
$rs->Close(); 
$conn->Close(); 
?>