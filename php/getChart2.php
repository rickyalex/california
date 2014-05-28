<?php
include("connect_db.php");

$scp = $_POST['myScp'];
$year = $_POST['myYear'];
$res = array();
$i=0;
if($scp!="Serang Mill"){

$sql = "select sda_jan = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='01' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SDA'),
		sda_feb = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='02' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SDA'),
		sda_mar = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='03' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SDA'),
		sda_apr = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='04' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SDA'),
		sda_may = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='05' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SDA'),
		sda_jun = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='06' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SDA'),
		sda_jul = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='07' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SDA'),
		sda_aug = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='08' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SDA'),
		sda_sep = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='09' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SDA'),
		sda_oct = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='10' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SDA'),
		sda_nov = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='11' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SDA'),
		sda_dec = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='12' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SDA'),
		spc_jan = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='01' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SPC'),
		spc_feb = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='02' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SPC'),
		spc_mar = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='03' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SPC'),
		spc_apr = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='04' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SPC'),
		spc_may = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='05' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SPC'),
		spc_jun = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='06' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SPC'),
		spc_jul = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='07' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SPC'),
		spc_aug = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='08' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SPC'),
		spc_sep = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='09' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SPC'),
		spc_oct = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='10' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SPC'),
		spc_nov = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='11' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SPC'),
		spc_dec = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='12' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SPC'),
		sga_jan = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='01' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SGA'),
		sga_feb = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='02' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SGA'),
		sga_mar = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='03' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SGA'),
		sga_apr = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='04' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SGA'),
		sga_may = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='05' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SGA'),
		sga_jun = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='06' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SGA'),
		sga_jul = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='07' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SGA'),
		sga_aug = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='08' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SGA'),
		sga_sep = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='09' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SGA'),
		sga_oct = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='10' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SGA'),
		sga_nov = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='11' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SGA'),
		sga_dec = (select isnull (sum(convert(int, point)),'0') from ppr 
		where division like '".$scp."%' and substring (start_date,4,2)='12' 
		and substring (start_date,7,4)='".$year."' and substring(Reg_No,11,3)='SGA')";
}

	$rs = $conn->Execute($sql);
	
	$rs->Close();
	$conn->Close();

$result = json_encode($rs->fields);
echo $result;
?>