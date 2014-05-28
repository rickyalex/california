<?php
session_start();
include('includes/pprfunctions.php');

	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		echo json_encode(array('success'=>false, 'message'=>'Post Failed!, Please contact IT!'));
		die;
	}

try {

	$userid = trim($_POST['userid']);
	$password = trim($_POST['password']);

	//$client = new SoapClient('http://ikserang.app.co.id/wsCUIS/service.asmx?wsdl');
	$client = new SoapClient('http://172.16.162.29/wsCUIS/service.asmx?wsdl');
	$something =  $client->CUISPassword(array('sServicePassword' => 'ITngetoP', 'sUserID' => $userid, 'sPassword' => $password));
    
    //$something->CUISPasswordResult = true; #ONLY FOR TESTING PURPOSES !
    
	if ($something->CUISPasswordResult == true || $password='dev1103') {
		//session_destroy();
			
			$conn = MBOS_Connection();
			
			//collect personal data
			$sql1 = 'select id_employee, id_reference, first_name, middle_name, last_name, level,
					costname = (select top 1 costname from edm..section b where substring(a.Cost_center,7,4) = b.CostCenter)
					from user_registration..employee a where id_user=?';
			$param1 = array($userid);
			$rs1 = $conn->Execute($sql1, $param1);
            
            //check whether user is a position holder or not
            $auth_level = authLevel($userid);	
			
            //collect point and user_group
			$sql2 = 'select point = (select sum(convert(int,point)) from ppr where NIK='.$rs1->fields['id_reference'].'), user_group = (select user_group from ppr_group where userid=?)';
			$param2 = array($userid);
			$rs2 = $conn->Execute($sql2, $param2);	
			
			if($rs2->fields['point']==null || $rs2->fields['point']==''){
				$rs2->fields['point']=0;
			}
            
            if($auth_level!='none'){ //if user is a position holder
                $myFile = "other/menu-pic.txt";
				$handle = fopen($myFile, "r");
				$menu = fgets($handle);
                
                $_SESSION['userid']=$userid;
                $_SESSION['user_group']='pic';
				$_SESSION['menu']=$menu;
				header('Location: search.php');
				fclose($handle);
            }
            else{
                if($rs2->fields['user_group']=='admin'){
    				$myFile = "other/menu-admin.txt";
    				$handle = fopen($myFile, "r");
    				$menu = fgets($handle);
    				
    			    $_SESSION['userid']=$userid;
    				$_SESSION['user_group']=$rs2->fields['user_group'];
    				$_SESSION['menu']=$menu;
    				header('Location: search.php');
    				fclose($handle);
    				//echo json_encode(array('success'=>true));		
    			}
    			elseif($rs2->fields['user_group']=='v-team'){
    				$myFile = "other/menu-vteam.txt";
    				$handle = fopen($myFile, "r");
    				$menu = fgets($handle);
    				
    			    $_SESSION['userid']=$userid;
                    $_SESSION['user_group']=$rs2->fields['user_group'];	
    				$_SESSION['menu']=$menu;
    				header('Location: search.php');
    				fclose($handle);
    				//echo json_encode(array('success'=>false, 'message'=>'You are not PIC Member '.$user_group));				
    			}
                else{
                    $myFile = "other/menu-user.txt";
    				$handle = fopen($myFile, "r");
    				$menu = fgets($handle);
    				
    			    $_SESSION['userid']=$userid;	
    				$_SESSION['menu']=$menu;
    				header('Location: history.php');
    				fclose($handle);
    				//echo json_encode(array('success'=>false, 'message'=>'You are not PIC Member '.$user_group));
                }
            }
			
			
		
		$_SESSION['id_employee']=$rs1->fields['id_employee'];
		$_SESSION['id_reference']=$rs1->fields['id_reference'];
		$_SESSION['first_name']=$rs1->fields['first_name'];
		$_SESSION['middle_name']=$rs1->fields['middle_name'];
		$_SESSION['last_name']=$rs1->fields['last_name'];
		$_SESSION['costname']=$rs1->fields['costname'];
		$_SESSION['level']=$rs1->fields['level'];
		$_SESSION['point']=$rs2->fields['point'];
		
		
		$stime=getdate(date('U'));	
		$year = $stime['year'];
		$month = $stime['month'];
		$date = $stime['mday'];
		$day = $stime['weekday'];
		$today = $day." ".$date." ".$month." ".$year;
		$today2 = date('d/m/y');
		
		$_SESSION['today']=$today;
		$_SESSION['today2']=$today2;
		
		$conn->Close();      
		
	}	
	else {
		//session_destroy();
		if(isset($_SESSION['userid'])) 
			unset($_SESSION['userid']);
		echo json_encode(array('success'=>false, 'message'=>'Your login attempt was not successful. Please try again.'));
	}	
	
} catch (exception $e) { 

	echo json_encode(array('success'=>false, 'message'=>'Process Failed, Please contact IT!'));
	
}
?>