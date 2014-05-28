<?php
	session_start();

	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		echo json_encode(array('success'=>false, 'message'=>'Post Failed!, Please contact IT!'));
		die;
	}

try {

	//$arrName = $_POST['arrName'];
	$id = $_POST['id'];
	$arrInfo = array();

	//$client = new SoapClient('http://ikserang.app.co.id/wsCUIS/service.asmx?wsdl');
	//$client = new SoapClient('http://172.16.162.29/wsCUIS/service.asmx?wsdl');
	//$something =  $client->CUISPassword(array('sServicePassword' => 'ITngetoP', 'sUserID' => $userid, 'sPassword' => $password));

	//if ($something->CUISPasswordResult == true) {
		//session_destroy();
		
			include("../lib/Adodb/adodb-exceptions.inc.php");
            include('../lib/Adodb/adodb.inc.php'); 	
			
			
			
			$conn = ADONewConnection("ado_mssql");
			//$conn2 = ADONewConnection("ado_mssql");
			if (!$conn) {
				die(json_encode(array('success'=>false, 'message'=>'Connection failed!'))); 
			}
			//$setMBOS="PROVIDER=MSDASQL;DRIVER={SQL Server};" . "SERVER=SRGSQL8;DATABASE=MBOS_Intranet;UID=mbosuser;PWD=mbosuser99;";
			$setEOF="PROVIDER=MSDASQL;DRIVER={SQL Server};" . "SERVER=SRGSQL8;DATABASE=User_Registration;UID=eoffice;PWD=srgeoffice235;";
			$conn->PConnect($setEOF);  //Connect, 
			//$conn2->PConnect($setEOF);	//PConnect, = persistense connection, database yg berbeda, user yg sama, server yg sama
									    //NConnect  = new connection, database berbeda, user berbeda
									  
						
			$conn->SetFetchMode(ADODB_FETCH_ASSOC);
			//$conn2->SetFetchMode(ADODB_FETCH_ASSOC);
			

				//$fName = $arrName[0];
				//$mName = $arrName[1];
				//$lName = $arrName[2];
			if(strlen($id)==7){
				$sql = "select first_name, middle_name, last_name, level, 
				  div = (select top 1 divname from edm..division x 
				  where divcode = (select top 1 divcode from edm..section b 
				  where substring(a.cost_center,7,4) = b.costcenter)), 
				  dept = (select top 1 deptname from edm..department d 
				  where deptcode = (select top 1 deptcode from edm..section b 
				  where substring(a.cost_center,7,4) = b.costcenter)), 
				  costname = (select top 1 costname from edm..section b 
				  where substring(a.Cost_center,7,4) = b.CostCenter) 
				  from employee a where id_reference=?";
				$param = array($id);
			}
			else{
				$sql = "select first_name, middle_name, last_name, level, 
				  div = (select top 1 divname from edm..division x 
				  where divcode = (select top 1 divcode from edm..section b 
				  where substring(a.cost_center,7,4) = b.costcenter)), 
				  dept = (select top 1 deptname from edm..department d 
				  where deptcode = (select top 1 deptcode from edm..section b 
				  where substring(a.cost_center,7,4) = b.costcenter)), 
				  costname = (select top 1 costname from edm..section b 
				  where substring(a.Cost_center,7,4) = b.CostCenter) 
				  from employee a where id_employee=?";
				$param = array($id);
			}
				
				$rs = $conn->Execute($sql, $param);
				
				if($rs->fields['first_name']==''){
					echo json_encode(array('err'=>'Data not found. Make sure NIK is correct'));
				}
				else{
			
					//$arrInfo['id_employee']=$rs->fields['id_employee'];
					$arrInfo['first_name']=trim($rs->fields['first_name']);
					$arrInfo['middle_name']=trim($rs->fields['middle_name']);
					$arrInfo['last_name']=trim($rs->fields['last_name']);
					$arrInfo['costname']=trim($rs->fields['costname']);
					$arrInfo['level']=trim($rs->fields['level']);
					$arrInfo['div']=trim($rs->fields['div']);
					$arrInfo['dept']=trim($rs->fields['dept']);
					// array_push($arrInfo, array(
						// 'id_employee' => $rs->[0],
						// 'first_name' => $rs->[1],
						// 'middle_name' => $rs->[2],
						// 'last_name' => $rs->[3],
						// 'level' => $rs->[4],
						// 'costname' => $rs->[5]
					// ));
				}

} catch (exception $e) { 

	echo json_encode(array('success'=>false, 'message'=>'Process Failed, Please contact IT!'));
	
}
if ($arrInfo!=null || count($arrInfo)!=0){
	echo json_encode($arrInfo);
}
?>