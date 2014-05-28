<?php
include_once ("database.php");

/**
 * @author lolkittens
 * @copyright 2014
 */

function DefineScope($userid){

    
    $conn = MBOS_Connection();
    
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
           $sql = "select name, nik, department, division, sum(convert(int,point_remaining)) points
                  from mbosuser.test_point a, user_registration..employee b
                  where a.division = (select top 1 divname from edm..division x 
            		  where divcode = (select top 1 divcode from edm..section c 
        			  where b.id_user='".$userid."' and substring(b.cost_center,7,4) = c.costcenter))
                  group by nik, name, department, division
                  order by name";
       }
       elseif($scope=='department'){
           $sql = "select name, nik, department, division, sum(convert(int,point_remaining)) points
                   from mbosuser.point a, user_registration..employee b
                   where a.department = (select top 1 deptname from edm..department d 
            		  where deptcode = (select top 1 deptcode from edm..section c 
        			  where b.id_user='".$userid."' and substring(b.cost_center,7,4) = c.costcenter))
                   group by nik, name, department, division
                   order by name";
       }
       else{
           $sql = "select name, nik, department, division, sum(convert(int,point_remaining)) points
                  from mbosuser.point a, user_registration..employee b
                  where a.section = (select top 1 costname from edm..section c 
                	   where b.id_user='".$userid."' and substring(b.Cost_center,7,4) = c.CostCenter)
                  group by nik, name, department, division
                  order by name";
       }
   }
        
   $rs = $conn->Execute($sql);
   $row = 0;
   $result = array();
   while(!$rs->EOF){
       $result[$row]['name'] = $rs->fields['name'];
       $result[$row]['nik'] = $rs->fields['nik'];
       $result[$row]['department'] = $rs->fields['department'];
       $result[$row]['division'] = $rs->fields['division'];
       $result[$row]['points'] = $rs->fields['points'];
       $row++;
   }
   
   $conn->Close();
        
   return $result;          
}

function authLevel($userid){
    //global $firephp;
    
    $conn = MBOS_Connection();

    $sql = '';
    $auth_level = '';
    $org_category = '';
    try {
        $sql = "select top 1 org_category from user_registration..employee a
                inner join master_data..organization_line2 b
                on a.id_employee=b.position_holder and a.org_code = b.org_code and a.id_user='".$userid."'";
        $rs = $conn->Execute($sql);
        if(!$rs->EOF){
            $org_category = $rs->fields['org_category'];
            switch($org_category){
                case 1 :
                    $auth_level = "division";
                    break;
                case 2 :
                    $auth_level = "department";
                    break;
                case 3 :
                    $auth_level = "section";
                    break;
            }    
        } 
        else $auth_level = 'none';
    }
	catch (exception $e) { 
		var_dump($e);
        //die; 
	} 	
    return $auth_level;
    
}



?>