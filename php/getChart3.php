<?php
include("connect_db.php");

$scp = $_POST['myScp'];
$year = $_POST['myYear'];
$res = array();
$i=0;
if($scp!="Serang Mill"){

$sql = "select ic_jan = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='01' 
		and substring (start_date,7,4)='".$year."' and remarks like 'Index%'),
		ic_feb = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='02' 
		and substring (start_date,7,4)='".$year."' and remarks like 'Index%'),
		ic_mar = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='03' 
		and substring (start_date,7,4)='".$year."' and remarks like 'Index%'),
		ic_apr = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='04' 
		and substring (start_date,7,4)='".$year."' and remarks like 'Index%'),
		ic_may = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='05' 
		and substring (start_date,7,4)='".$year."' and remarks like 'Index%'),
		ic_jun = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='06' 
		and substring (start_date,7,4)='".$year."' and remarks like 'Index%'),
		ic_jul = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='07' 
		and substring (start_date,7,4)='".$year."' and remarks like 'Index%'),
		ic_aug = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='08' 
		and substring (start_date,7,4)='".$year."' and remarks like 'Index%'),
		ic_sep = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='09' 
		and substring (start_date,7,4)='".$year."' and remarks like 'Index%'),
		ic_oct = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='10' 
		and substring (start_date,7,4)='".$year."' and remarks like 'Index%'),
		ic_nov = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='11' 
		and substring (start_date,7,4)='".$year."' and remarks like 'Index%'),
		ic_dec = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='12' 
		and substring (start_date,7,4)='".$year."' and remarks like 'Index%'),
		is_jan = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='01' 
		and substring (start_date,7,4)='".$year."' and remarks like '%i-Suggest%'),
		is_feb = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='02' 
		and substring (start_date,7,4)='".$year."' and remarks like '%i-Suggest%'),
		is_mar = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='03' 
		and substring (start_date,7,4)='".$year."' and remarks like '%i-Suggest%'),
		is_apr = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='04' 
		and substring (start_date,7,4)='".$year."' and remarks like '%i-Suggest%'),
		is_may = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='05' 
		and substring (start_date,7,4)='".$year."' and remarks like '%i-Suggest%'),
		is_jun = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='06' 
		and substring (start_date,7,4)='".$year."' and remarks like '%i-Suggest%'),
		is_jul = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='07' 
		and substring (start_date,7,4)='".$year."' and remarks like '%i-Suggest%'),
		is_aug = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='08' 
		and substring (start_date,7,4)='".$year."' and remarks like '%i-Suggest%'),
		is_sep = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='09' 
		and substring (start_date,7,4)='".$year."' and remarks like '%i-Suggest%'),
		is_oct = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='10' 
		and substring (start_date,7,4)='".$year."' and remarks like '%i-Suggest%'),
		is_nov = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='11' 
		and substring (start_date,7,4)='".$year."' and remarks like '%i-Suggest%'),
		is_dec = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='12' 
		and substring (start_date,7,4)='".$year."' and remarks like '%i-Suggest%'),
		v_jan = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='01' 
		and substring (start_date,7,4)='".$year."' and remarks like 'V-Team%'),
		v_feb = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='02' 
		and substring (start_date,7,4)='".$year."' and remarks like 'V-Team%'),
		v_mar = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='03' 
		and substring (start_date,7,4)='".$year."' and remarks like 'V-Team%'),
		v_apr = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='04' 
		and substring (start_date,7,4)='".$year."' and remarks like 'V-Team%'),
		v_may = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='05' 
		and substring (start_date,7,4)='".$year."' and remarks like 'V-Team%'),
		v_jun = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='06' 
		and substring (start_date,7,4)='".$year."' and remarks like 'V-Team%'),
		v_jul = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='07' 
		and substring (start_date,7,4)='".$year."' and remarks like 'V-Team%'),
		v_aug = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='08' 
		and substring (start_date,7,4)='".$year."' and remarks like 'V-Team%'),
		v_sep = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='09' 
		and substring (start_date,7,4)='".$year."' and remarks like 'V-Team%'),
		v_oct = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='10' 
		and substring (start_date,7,4)='".$year."' and remarks like 'V-Team%'),
		v_nov = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='11' 
		and substring (start_date,7,4)='".$year."' and remarks like 'V-Team%'),
		v_dec = (select isnull (sum(convert(int, point)),'0') from nppoint 
		where division like '".$scp."%' and substring (start_date,4,2)='12' 
		and substring (start_date,7,4)='".$year."' and remarks like 'V-Team%')";
}

	$rs = $conn->Execute($sql);
	
	$rs->Close();
	$conn->Close();

$result = json_encode($rs->fields);
echo $result;
?>