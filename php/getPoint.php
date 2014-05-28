<?php
include("connect_db.php");

$scp = $_POST['myScp'];
$year = $_POST['myYear'];
$res = array();
$i=0;
if($scp!="Serang Mill"){

$sql = "select p_jan = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='01' 
		and substring (start_date,7,4)='".$year."'),
		p_feb = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='02' 
		and substring (start_date,7,4)='".$year."'),
		p_mar = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='03' 
		and substring (start_date,7,4)='".$year."'),
		p_apr = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='04' 
		and substring (start_date,7,4)='".$year."'),
		p_may = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='05' 
		and substring (start_date,7,4)='".$year."'),
		p_jun = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='06' 
		and substring (start_date,7,4)='".$year."'),
		p_jul = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='07' 
		and substring (start_date,7,4)='".$year."'),
		p_aug = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='08' 
		and substring (start_date,7,4)='".$year."'),
		p_sep = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='09' 
		and substring (start_date,7,4)='".$year."'),
		p_oct = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='10' 
		and substring (start_date,7,4)='".$year."'),
		p_nov = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='11' 
		and substring (start_date,7,4)='".$year."'),
		p_dec = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='12' 
		and substring (start_date,7,4)='".$year."'),
		np_jan = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='01' 
		and substring (start_date,7,4)='".$year."'),
		np_feb = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='02' 
		and substring (start_date,7,4)='".$year."'),
		np_mar = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='03' 
		and substring (start_date,7,4)='".$year."'),
		np_apr = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='04' 
		and substring (start_date,7,4)='".$year."'),
		np_may = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='05' 
		and substring (start_date,7,4)='".$year."'),
		np_jun = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='06' 
		and substring (start_date,7,4)='".$year."'),
		np_jul = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='07' 
		and substring (start_date,7,4)='".$year."'),
		np_aug = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='08' 
		and substring (start_date,7,4)='".$year."'),
		np_sep = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='09' 
		and substring (start_date,7,4)='".$year."'),
		np_oct = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='10' 
		and substring (start_date,7,4)='".$year."'),
		np_nov = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='11' 
		and substring (start_date,7,4)='".$year."'),
		np_dec = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='12' 
		and substring (start_date,7,4)='".$year."')";
}
else{
	$sql = "select (select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SGA' and substring (End_date,4,2)='01' and substring(End_date,7,4)='".$year."') as SGA_JAN, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SGA' and substring (End_date,4,2)='02' and substring(End_date,7,4)='".$year."') as SGA_FEB, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SGA' and substring (End_date,4,2)='03' and substring(End_date,7,4)='".$year."') as SGA_MAR, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SGA' and substring (End_date,4,2)='04' and substring(End_date,7,4)='".$year."') as SGA_APR, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SGA' and substring (End_date,4,2)='05' and substring(End_date,7,4)='".$year."') as SGA_MAY, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SGA' and substring (End_date,4,2)='06' and substring(End_date,7,4)='".$year."') as SGA_JUN, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SGA' and substring (End_date,4,2)='07' and substring(End_date,7,4)='".$year."') as SGA_JUL, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SGA' and substring (End_date,4,2)='08' and substring(End_date,7,4)='".$year."') as SGA_AUG, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SGA' and substring (End_date,4,2)='09' and substring(End_date,7,4)='".$year."') as SGA_SEP, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SGA' and substring (End_date,4,2)='10' and substring(End_date,7,4)='".$year."') as SGA_OCT, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SGA' and substring (End_date,4,2)='11' and substring(End_date,7,4)='".$year."') as SGA_NOV, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SGA' and substring (End_date,4,2)='12' and substring(End_date,7,4)='".$year."') as SGA_DEC, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and substring (End_date,4,2)='01' and substring(End_date,7,4)='".$year."') as SDA_JAN, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and substring (End_date,4,2)='02' and substring(End_date,7,4)='".$year."') as SDA_FEB, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and substring (End_date,4,2)='03' and substring(End_date,7,4)='".$year."') as SDA_MAR, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and substring (End_date,4,2)='04' and substring(End_date,7,4)='".$year."') as SDA_APR, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and substring (End_date,4,2)='05' and substring(End_date,7,4)='".$year."') as SDA_MAY, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and substring (End_date,4,2)='06' and substring(End_date,7,4)='".$year."') as SDA_JUN, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and substring (End_date,4,2)='07' and substring(End_date,7,4)='".$year."') as SDA_JUL, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and substring (End_date,4,2)='08' and substring(End_date,7,4)='".$year."') as SDA_AUG, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and substring (End_date,4,2)='09' and substring(End_date,7,4)='".$year."') as SDA_SEP, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and substring (End_date,4,2)='10' and substring(End_date,7,4)='".$year."') as SDA_OCT, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and substring (End_date,4,2)='11' and substring(End_date,7,4)='".$year."') as SDA_NOV, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and substring (End_date,4,2)='12' and substring(End_date,7,4)='".$year."') as SDA_DEC,
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and substring (End_date,4,2)='01' and substring(End_date,7,4)='".$year."') as SPC_JAN, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and substring (End_date,4,2)='02' and substring(End_date,7,4)='".$year."') as SPC_FEB, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and substring (End_date,4,2)='03' and substring(End_date,7,4)='".$year."') as SPC_MAR, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and substring (End_date,4,2)='04' and substring(End_date,7,4)='".$year."') as SPC_APR, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and substring (End_date,4,2)='05' and substring(End_date,7,4)='".$year."') as SPC_MAY, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and substring (End_date,4,2)='06' and substring(End_date,7,4)='".$year."') as SPC_JUN, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and substring (End_date,4,2)='07' and substring(End_date,7,4)='".$year."') as SPC_JUL, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and substring (End_date,4,2)='08' and substring(End_date,7,4)='".$year."') as SPC_AUG, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and substring (End_date,4,2)='09' and substring(End_date,7,4)='".$year."') as SPC_SEP, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and substring (End_date,4,2)='10' and substring(End_date,7,4)='".$year."') as SPC_OCT, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and substring (End_date,4,2)='11' and substring(End_date,7,4)='".$year."') as SPC_NOV, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and substring (End_date,4,2)='12' and substring(End_date,7,4)='".$year."') as SPC_DEC";
}	
		/* (select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SDA' and division like 'Adm%' and substring(End_date,7,4)='".$year."') as SDA, 
		(select sum(convert(int,point_remaining)) from ppr 
		where substring(Reg_No,11,3)='SPC' and division like 'Adm%' and substring(End_date,7,4)='".$year."') as SPC"; */
	$rs = $conn->Execute($sql);
	
	/* while(!$rs->EOF){
		array_push($res, array(
		'SGAJan' 	=> $rs->fields[0],
		'SGAFeb' 	=> $rs->fields[1],
		'SGAMar'	=> $rs->fields[2],
		'SGAApr'	=> $rs->fields[3],
		'SGAMay'	=> $rs->fields[4],
		'SGAJun'	=> $rs->fields[5],
		'SGAJul'	=> $rs->fields[6],
		'SGAAug'	=> $rs->fields[7],
		'SGASep'	=> $rs->fields[8],
		'SGAOct'	=> $rs->fields[9],
		'SGANov'	=> $rs->fields[10],
		'SGADec'	=> $rs->fields[11],
		'SDAJan' 	=> $rs->fields[12],
		'SDAFeb' 	=> $rs->fields[13],
		'SDAMar'	=> $rs->fields[14],
		'SDAApr'	=> $rs->fields[15],
		'SDAMay'	=> $rs->fields[16],
		'SDAJun'	=> $rs->fields[17],
		'SDAJul'	=> $rs->fields[18],
		'SDAAug'	=> $rs->fields[19],
		'SDASep'	=> $rs->fields[20],
		'SDAOct'	=> $rs->fields[21],
		'SDANov'	=> $rs->fields[22],
		'SDADec'	=> $rs->fields[23]
	));
    $rs->MoveNext();
   }  */
	
	/* while(i<24){
	  if($rs->fields[$i]==null){
	    $res[$i]=0;
	  }
	  else{
	    $res[$i]=$rs->fields[$i];
	  }
	  $i++;
	} */
	
	/* $rs->fields[0]==null ? $res[0] = 0 : $res[0] = $rs->fields[0];
	$rs->fields[1]==null ? $res[1] = 0 : $res[1] = $rs->fields[1];
	$rs->fields[2]==null ? $res[2] = 0 : $res[2] = $rs->fields[2]; */
	
	$rs->Close();
	$conn->Close();

$result = json_encode($rs->fields);
echo $result;
?>
