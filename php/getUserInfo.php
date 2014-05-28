<?php

include ("../includes/pprfunctions.php");

$conn = MBOS_Connection();


$userid = $_POST['id'];

//CHECK WHETHER THE USER IS A POSITION HOLDER OR NOT
$auth_level = authLevel($userid);
if($auth_level=='none'){
    //CHECK WHETHER THE USER IS INCLUDED IN PPR GROUP OR NOT 
    $sql_check = "select auth_level, scope, action from ppr_group where userid='".$userid."'";
    $rs = $conn->Execute($sql_check);
    if(!$rs->EOF){
        $scope = $rs->fields['scope'];
        if($scope=='all'){
            $sql = "select name, nik, department, division, sum(convert(int,point_remaining)) points
                    from mbosuser.point a, user_registration..employee b
                    where a.nik = b.id_reference and b.active='y'
                    group by a.nik, a.name, a.department, a.division";
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
        
        $rs = $conn->Execute($sql);
    
        //$firephp->log($scope,'scope');
        //$firephp->log($sql,'sql');
        //die;
        
        $arr = array();
        $x=0;
        while(!$rs->EOF){
        
          array_push($arr, array(
        		'name' => $rs->fields['name'],
        		'nik' => $rs->fields['nik'],
        		'department' => $rs->fields['department'],
        		'division' => $rs->fields['division'],
        		'point_remaining' => $rs->fields['points']
        		));
          $rs->MoveNext();
        }
    }
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
        
    $rs = $conn->Execute($sql);
    
    //$firephp->log($scope,'scope');
    //$firephp->log($sql,'sql');
    //die;
        
    $arr = array();
    $x=0;
    while(!$rs->EOF){
        
        array_push($arr, array(
    		'name' => $rs->fields['name'],
       		'nik' => $rs->fields['nik'],
       		'department' => $rs->fields['department'],
       		'division' => $rs->fields['division'],
       		'point_remaining' => $rs->fields['points']
     		));
        $rs->MoveNext();
    }
}



$rs->Close(); 
$conn->Close(); 

//buat sbg json format
$result = json_encode($arr);
echo $result;
?>