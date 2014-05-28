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

	$rs = $conn->Execute($sql);
	
	$rs->Close();
	$conn->Close();

$result = json_encode($rs->fields);
echo $result;
?>