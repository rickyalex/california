<?php
require '../lib/PHPExcel/Classes/PHPExcel.php';
require '../lib/PHPExcel/Classes/PHPExcel/IOFactory.php';

include_once ("../includes/pprfunctions.php");



$userid = $_POST['id'];
//CHECK WHETHER THE USER IS A POSITION HOLDER OR NOT
$auth_level = authLevel($userid);

$conn = MBOS_Connection();

if($auth_level=='none'){    
    $sql_check = "select auth_level, scope, action from ppr_group where userid='".$userid."'";
    $rs = $conn->Execute($sql_check);
    if(!$rs->EOF){
       $scope = $rs->fields['scope'];
       if($scope=='all'){
           $sql = "select name, nik, department, division, sum(convert(int,point_remaining)) points
                  from mbosuser.point
                  group by nik, name, department, division";
       }
       elseif($scope=='division'){
            $sql = "select name, a.nik, b.id_reference, department, division, 
                    		sum(convert(int,point_remaining)) points
                    from mbosuser.point a, user_registration..employee b
                    where a.division = (select top 1 divname from edm..division x 
                      where divcode = (select top 1 divcode from user_registration..employee b, edm..section c 
                      where b.id_user='".$userid."' and substring(b.cost_center,7,4) = c.costcenter )) 
                    		AND b.active='Y' AND a.NIK=b.id_reference
                    group by nik, name, department, division, id_reference
                    order by name";
       }
       elseif($scope=='department'){
            $sql = "select name, nik, department, division, sum(convert(int,point_remaining)) points
                    from mbosuser.point a, user_registration..employee b
                    where a.department = (select top 1 deptname from edm..department d 
        	           where deptcode = (select top 1 deptcode from user_registration..employee b, edm..section c 
        			   where b.id_user='".$userid."' and substring(b.cost_center,7,4) = c.costcenter))
                       AND b.active='Y' AND a.NIK=b.id_reference
                    group by nik, name, department, division
                    order by name";
       }
       else{
            $sql = "select name, nik, department, division, sum(convert(int,point_remaining)) points
                    from mbosuser.point a, user_registration..employee b
                    where a.section = (select top 1 costname from user_registration..employee b, edm..section c 
                	   where b.id_user='".$userid."' and substring(b.Cost_center,7,4) = c.CostCenter)
                       AND b.active='Y' AND a.NIK=b.id_reference
                    group by nik, name, department, division
                    order by name";
       } 
   }
   $rs->Close();
}
else{
    if($auth_level=='division'){
            $sql = "select name, a.nik, b.id_reference, department, division, 
                    		sum(convert(int,point_remaining)) points
                    from mbosuser.point a, user_registration..employee b
                    where a.division = (select top 1 divname from edm..division x 
                      where divcode = (select top 1 divcode from user_registration..employee b, edm..section c 
                      where b.id_user='".$userid."' and substring(b.cost_center,7,4) = c.costcenter )) 
                    		AND b.active='Y' AND a.NIK=b.id_reference
                    group by nik, name, department, division, id_reference
                    order by name";
    }
    elseif($auth_level=='department'){
            $sql = "select name, nik, department, division, sum(convert(int,point_remaining)) points
                    from mbosuser.point a, user_registration..employee b
                    where a.department = (select top 1 deptname from edm..department d 
        	           where deptcode = (select top 1 deptcode from user_registration..employee b, edm..section c 
        			   where b.id_user='".$userid."' and substring(b.cost_center,7,4) = c.costcenter))
                       AND b.active='Y' AND a.NIK=b.id_reference
                    group by nik, name, department, division
                    order by name";
    }
    else{
            $sql = "select name, nik, department, division, sum(convert(int,point_remaining)) points
                    from mbosuser.point a, user_registration..employee b
                    where a.section = (select top 1 costname from user_registration..employee b, edm..section c 
                	   where b.id_user='".$userid."' and substring(b.Cost_center,7,4) = c.CostCenter)
                       AND b.active='Y' AND a.NIK=b.id_reference
                    group by nik, name, department, division
                    order by name";
    }
}

$rs2 = $conn->Execute($sql);
$row = 0;
$result = array();
while(!$rs2->EOF){
     array_push($result, array(
 		'name' => $rs2->fields['name'],
   		'nik' => $rs2->fields['nik'],
   		'department' => $rs2->fields['department'],
   		'division' => $rs2->fields['division'],
   		'points' => $rs2->fields['points']
   	));
     $rs2->MoveNext();
}
   
$conn->Close();

$file = "../temp/Point_".date('dMy_hms').".xls";


// $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
// $objWriter->setOffice2003Compatibility(true);
//$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
//$objPHPExcel->createSheet();

//$objWorksheet->getCellByColumnAndRow($col, $row)->getStyle();
$objPHPExcel = New PHPExcel();
$objWriter = New PHPExcel_Writer_Excel5($objPHPExcel);
//$objWriter->save($file);
$objWorksheet = $objPHPExcel->getActiveSheet();
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8); 
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')
->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()->setARGB('AAAAAAAAA');

$y=0;
$header='';
for($x=1;$x<(count($result)+1);$x++){
    if($x==1){
        while($y<5){
            switch($y){
                case 0:
                    $header = 'Name';
                    break;
                case 1:
                    $header = 'NIK';
                    break;
                case 2:
                    $header = 'Department';
                    break;
                case 3:
                    $header = 'Division';
                    break;
                case 4:
                    $header = 'Points';
                    break;
            }
            $objWorksheet->setCellValueByColumnAndRow($y, $x, $header);
            $y++;
        }
    }
    else{
        foreach($result[($x-2)] as $key => $value){
    		// if($y==1){
    			// $objWorksheet->getStyle($y,$x)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		// }
            if($y==1){
                $objWorksheet->getStyle('B')->getNumberFormat()->setFormatCode('0000000'); 

            }
            
    		$objWorksheet->setCellValueByColumnAndRow($y, $x, $value);
    		$y++;
    	}
    }
	
	$y=0;
}


$objWriter->save($file);

//buat sbg json format
//$result = json_encode($arr);
//echo $result;

$rs2->Close(); 
$conn->Close();
echo substr($file,3);
?>