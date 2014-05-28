<?php
session_start();
$userid = $_SESSION['userid'];

$arr = $_POST['myArr'];
$content = array();

if ( isset($arr) ) {
	include("../lib/Adodb/adodb-exceptions.inc.php");
	include('../lib/Adodb/adodb.inc.php'); 

	try { 
		$conn = ADONewConnection("ado_mssql");
		$myDSN="PROVIDER=SQLOLEDB;DRIVER={SQL Server};" . "SERVER=SRGSQL8;DATABASE=MBOS_Intranet;UID=mbosuser;PWD=mbosuser99;";
		$conn->PConnect($myDSN);  //Connect,
								  //PConnect, = persistense connection, database yg berbeda, user yg sama, server yg sama
								  //NConnect  = new connection, database berbeda, user berbeda
	} catch (exception $e) { 
		var_dump($e); 
		adodb_backtrace($e->gettrace());
		die;
	}
	
	$conn->SetFetchMode(ADODB_FETCH_ASSOC);
	
	$myYear = getdate(date('Y')); 

	
	
	if(!$arr == ""){
		$row = count($arr);
		$content = array();
		$script ="";
		$counter = 0;
		for($x=0;$x<$row;$x++){
			if(substr($arr[$x][4],5,4)=="8368"){ #if mill code is 8368
				if(substr($arr[$x][4],10,13)!="JDI"){ #if project is NOT JDI
					if(strtolower($arr[$x][3])=="leader"){ #distribute points for leader
						if(substr($arr[$x][4],10,13)=="SDA") $content[$x]["point"]=20;
						else if(substr($arr[$x][4],10,13)=="SPC") $content[$x]["point"]=12;
						else if(substr($arr[$x][4],10,13)=="SGA") $content[$x]["point"]=6;
						//else $content[$row]["point"]=0;
					}
					else if(strtolower($arr[$x][3])=="co-leader"){ #distribute points for co-leader
						if(substr($arr[$x][4],10,13)=="SDA") $content[$x]["point"]=10;
						else if(substr($arr[$x][4],10,13)=="SPC") $content[$x]["point"]=8;
						else if(substr($arr[$x][4],10,13)=="SGA") $content[$x]["point"]=4;
						//else $content[$row]["point"]=0;
					}
					else if(strtolower($arr[$x][3])=="champion"){ #distribute points for champion
						if(substr($arr[$x][4],10,13)=="SDA") $content[$x]["point"]=15;
						else if(substr($arr[$x][4],10,13)=="SPC") $content[$x]["point"]=12;
						//else $content[$row]["point"]=0;
					}
					//$table = "ppr"; #actual table
					$table = "test_ppr"; #test table
					$sql = "select top(0) * from ".$table."";
					$rs = $conn->Execute($sql);
					
					//insert values into array
					$content[$x]["name"]=$arr[$x][0];
					$content[$x]["nik"]=$arr[$x][1];
					$content[$x]["level"]=$arr[$x][2];
					$content[$x]["project_role"]=$arr[$x][3];
					$content[$x]["reg_no"]=$arr[$x][4];
					//$content[$x]["rev_no"]=$arr[$x][5];
					$content[$x]["project_title"]=$arr[$x][5];
					//$content[$x]["location"]=$arr[$x][7];
					$content[$x]["division"]=$arr[$x][6];
					$content[$x]["department"]=$arr[$x][7];
					$content[$x]["start_date"]=$arr[$x][8];
					$content[$x]["end_date"]=$arr[$x][9];
					// $content[$x]["project_status"]=$arr[$x][12];
					// $content[$x]["metric"]=$arr[$x][13];
					// $content[$x]["metric_uom"]=$arr[$x][14];
					// $content[$x]["metric_sign"]=$arr[$x][15];
					// $content[$x]["metric_baseline"]=$arr[$x][16];
					// $content[$x]["metric_target"]=$arr[$x][17];
					// $content[$x]["metric_actual"]=$arr[$x][18];
					// $content[$x]["metric_tar"]=$arr[$x][19];
					// $content[$x]["fb_target"]=$arr[$x][20];
					// $content[$x]["fb_actual"]=$arr[$x][21];
					// $content[$x]["fb_verified"]=$arr[$x][22];
					$content[$x]["uploaded_by"]=$_SESSION["userid"];
					
					$script = $script." ".$conn->GetInsertSQL($rs, $content[$x]);
				}
			}
		}
		
		//loop to search for non co-leader projects
		$pointer=array(); #initialize array
		$pointer["found"]=false; #initialize found value
		for($y=0;$y<$row;$y++){
			if($content[$y]["project_role"]!="co-leader"){ #find projects with no co-leader
				$sql2="select * from ppr where reg_no='".$content[$y]["reg_no"]."'";
				$rs=$conn->Execute($sql2);
				while(!$rs->EOF){
					if(strlower($rs->fields["project_role"]=="co-leader")){
						$pointer["found"]=true; #co-leader found, break loop
						break;
					}
					$rs->MoveNext();
				}
				if($pointer["found"]!=true){
					$pointer["reg_no"]=$content[$y]["reg_no"]; #initiate pointer
					for($pointer_num=0;$pointer_num<$row;$pointer_num++){
						if($content[$pointer_num]["reg_no"]==$pointer["reg_no"]){ #loop 
							if($pointer["project_role"]=="leader"){ #distribute the points to the project leader
								if(substr($pointer["reg_no"],10,13)=="SDA") $content[$pointer_num]["point"]=$content[$pointer_num]["point"]+10;
								elseif(substr($pointer["reg_no"],10,13)=="SPC") $content[$pointer_num]["point"]=$content[$pointer_num]["point"]+8;
								elseif(substr($pointer["reg_no"],10,13)=="SGA") $content[$pointer_num]["point"]=$content[$pointer_num]["point"]+4;
							}
						}
					}
				}
				
			}
		}

			// if($pointer==$
		//}
			
		// $sql = "select count(id_ins) as x from nppoint";
		// $rs = $conn->Execute($sql);
		// $counter = $rs->fields['x']+1;
		// for($x=0;$x<$row;$x++){
		
			// if($counter>999){
				// $myCounter = $counter;
			// }
			// elseif($counter>99){
				// $myCounter = "0".$counter."";
			// }
			// elseif($counter>9)
			// {
				// $myCounter = "00".$counter."";
			// }
			// else
			// {
				// $myCounter = "000".$counter."";
			// }
			// $sql2 = "select top(0) * from nppoint";
			// $rs2 = $conn->Execute($sql2);
	
			// $content["id_ins"] = "".$myYear[0]."/".$myCounter."";
			// $content["nik"] = $arr[$x][0];
			// $content["name"] = $arr[$x][1];
			// $content["level"] = $arr[$x][2];
			// $content["division"] = $arr[$x][3];
			// $content["department"] = $arr[$x][4];
			// $content["section"] = $arr[$x][5];
			// $content["point"] = $arr[$x][6];
			// $content["remarks"] = $arr[$x][7];
			// $content["start_date"] = date('d-m-Y H:i:s');
			// $content["uploaded_by"] = $_SESSION['userid'];
			// $content["last_update"] = date('d-m-Y H:i:s');
			
			// $script = $script." ".$conn->GetInsertSQL($rs2, $content);
			
			// $counter++;
		// }
	}
	else{
		$script = "empty";
		//return false;
		die("Unable to retrieve data");
	}
	/*
	try{
		$conn->StartTrans();
		$conn->Execute($script);
		$conn->CompleteTrans();
	}
	catch (exception $e){ 
		var_dump($e); 
		adodb_backtrace($e->gettrace());
		return $e;
	}
	*/
	
	
	// try{
		//$conn->StartTrans();
		// $sql = "select * from ppr where Project_Role='Leader'";
		// $rs2 = $conn->Execute($sql);
		// $updateSQL = $conn->GetUpdateSQL($rs2, $emp);
		// $conn->Execute($updateSQL);
		//if ($rs) $rs = $conn->Execute($sql2);

		//$conn->Execute($sql2);

		//$conn->CompleteTrans();
	// }
	// catch (exception $e) { 
		   // var_dump($e); 
		   // adodb_backtrace($e->gettrace());
		   // die;
	// }
	//$conn->Close(); # optional

	//echo json_encode(array('success'=>'Point Insert Success'));
	echo json_encode(array('success'=>$script));
}
else{
	echo json_encode(array('failed'=>'Point Insert failed'));
	die("Array Empty");
}
?>