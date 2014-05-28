<?php

/**
 * @author lolkittens
 * @copyright 2014
 */

include_once('../connect_db_user.php');

function GetLotusNotes($id_employee=''){
    $LN_mail = '';
	try {
		$sql   = " SELECT TOP 1 email1 FROM user_registration..employee WHERE id_employee = ? ";
		$param = array($id_employee);
		$rs    = $conn->Execute($sql, $param);
		if (!$rs->EOF) {
			$LN_mail = trim($rs->fields['email1']);
		}
		$rs->Close();
	} 
	catch (exception $e) { 
		 //echo 'Caught exception: ',  $e->getMessage(), "\n";
	} 			
	return $LN_mail;
}

?>