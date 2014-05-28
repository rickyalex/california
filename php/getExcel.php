<?php
ob_start();
$template = $_POST['r_tipe'];
$week = $_POST['week'];

//include('includes/pprfunctions.php');
include ("includes/database.php");
require_once 'lib/PHPExcel/Classes/PHPExcel/IOFactory.php';


//IOFactory set to auto detect file formatting
$objPHPExcel = PHPExcel_IOFactory::load($_FILES["asd"]["tmp_name"]);
$objWorksheet = $objPHPExcel->getActiveSheet();

$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
$pointer=1;
$invalid=0;
$dup=0;
$null=0;

$conn = MBOS_Connection();

//if file is empty
if($objPHPExcel =="" || $objPHPExcel ==null){
	echo "<div><center><span>File Upload gagal. Pastikan file yang diupload sudah terpilih dan benar, kemudian coba upload kembali</span>\n";
	echo "<br><br><button class='btn btn-large' type='button' onclick='history.back();'>Back</button></center></div>";
}
else{
	if($template=="Index Competition" && $objWorksheet->getCellByColumnAndRow(0, 2)->getValue()=="NIK" && $objWorksheet->getCellByColumnAndRow(1, 1)->getValue()!=""){

		echo "<center><span id='template'>".$template."</span></center>";
		echo "<div class='span5' style='padding:1% 1%;float:left'>";
		echo "<div style='border:0.5px solid #D6D6FF;-moz-border-radius:3px;padding:0.5% 1%'><span style='font-size:0.8em'>Template Info</span></div><br><br>";
		
		$pointer = 0;
		$arrInvalid = array();
        $arrNull = array();
		//exception case for Converting Index Competition
		$section = (rtrim(ltrim(strtolower($objWorksheet->getCellByColumnAndRow(0, 1)->getValue()))));
        $tyear = (rtrim(ltrim(strtolower($objWorksheet->getCellByColumnAndRow(1, 1)->getValue()))));
		// if($section=="flexo plant 1"||$section=="flexo plant 2"||$section=="vega plant 1"||$section=="vega plant 2"){
			// $section = "Finishing";
		// }
		for ($row = 4; $row <= $highestRow; ++$row) {
			$point = $objWorksheet->getCellByColumnAndRow($week+1, $row)->getValue();
			$nik = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
			$name = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
            
            if(rtrim(ltrim($point))!="" || rtrim(ltrim($point))!=NULL){
                if($nik!=""){
                    $sql = "select section = (select top 1 costname from edm..section b 
    					 where substring(a.Cost_center,7,4) = b.CostCenter) 
    					 from user_registration..employee a where id_reference='".$nik."'";
        			$rs = $conn->Execute($sql);
                    
                    //$table = "test_point";
        			$table = "point";
                    
        			if($rs->fields["section"]!=null){
                        $sec=$rs->fields["section"];
                        $sql2 = "select count(*) as dup from ".$table." where section='".$sec."' and remarks like '%Week ".$week." th.".$tyear."%'";
                        //echo $sql2;
                        $rs2 = $conn->Execute($sql2);
                        
                        if($rs2->fields["dup"]!=0){ //count duplicates
        				    //$dup++; //count duplicates
                            //$firephp->log($sql2); 
        				    //break;
                        }
                        
                        if($section=="flexo & vega plant 1" || $section=="flexo & vega plant 2"){
            				if(strlen($nik)==1 || strlen($nik)==2 || strlen($nik)==3 || strlen($nik)==4 || strlen($nik)==6){
            					$arrInvalid[$row] = $name;
                                //$firephp->log($arrInvalid);
            					$invalid++;
            				}
            			}
            			else{
            				if (strlen($nik)!=7){
            					$arrInvalid[$row] = $name;
                                //$firephp->log($arrInvalid);
            					$invalid++;
            				}
            			}
                    }
                    else {
                      $arrInvalid[$row] = $nik;
                      //$firephp->log($nik, 'null');
                      $invalid++;   
                    }
                   
                }
                else{
                   $arrInvalid[$row] = 'NIK empty';
                   //$firephp->log($nik, 'null');
                   $invalid++;
                }
                //$firephp->log($row, 'row');
                $pointer++;
            }		
		}
        
        //$firephp->log($invalid,'invalid');
        
		echo "<div class='form-horizontal'>";
		echo "<div class='control-group'>
				<label class='control-label' for='section'>Section :</label>
					<div class='controls'>
					<input id='section' name='section' type='text' value='".$section."'disabled />
				</div>
			  </div>";
		echo "<div class='control-group'>
				<label class='control-label' for='section'>Week :</label>
					<div class='controls'>
					<input id='week' class='input-mini' name='week' type='text' value='".$week."'disabled />
				</div>
			  </div>";
        echo "<div class='control-group'>
				<label class='control-label' for='section'>Year :</label>
					<div class='controls'>
					<input id='tyear' class='input-mini' name='tyear' type='text' value='".$tyear."'disabled />
				</div>
			  </div>";
		echo "<div class='control-group'>
				<label class='control-label' for='section'>Index Competition Winners :</label>
					<div class='controls'>
					<input id='winner' class='input-mini' name='winner' type='text' value='".$pointer." people' disabled />
				</div>
			  </div>";
		//display duplicates	 
		echo "<input id='dup' class='input-mini' name='dup' type='hidden' value='".$dup."' disabled />";
		echo "<input id='invalid' class='input-mini' name='invalid' type='hidden' value='".$invalid."' disabled />";
        //display error rows
		echo "<div id='divInvalid' class='control-group error' ";
		if($invalid>0){
		  echo "style='visibility:visible'>";
          //$firephp->log(count($arrNull),'total null');
          //$firephp->log($arrNull,'arrNull');
          $x= 0;
          echo "<div class='control-group'>
				<label class='control-label' for='section'>Incorrect ID(s) :</label>
					<div class='controls'>
					<textarea cols='5' rows='5'>";
          foreach($arrInvalid as $key => $value){
            echo $value.PHP_EOL;
            $x++;
          }
          echo "</textarea></div></div></div>";
		} 
		else echo "></div>";
		
		
		echo "<div class='control-group'><div class='controls'>";
		echo "<button id='submit' style='margin:0% 1% 0 0;float:left' class='btn btn-primary' type='submit' name='submit' data-loading-text='Loading...' autocomplete='off'>Submit</button>";
		echo "<button id='modify' style='margin:0% 3% 0 0;float:left' class='btn' type='button' name='modify' onclick='javascript:history.back();'>Cancel</button>";
		echo "</div></div>";
		echo "</div>";
		echo "</div>";
		echo "<div class='span6' style='padding:1% 1%;float:right'>";
		echo "<table id=\"table1\" class=\"table table-bordered table-condensed\" style=\"font-size:0.8em;width:100%\" cellspacing=\"0\">\n";			
		echo "<thead><tr><td>Details</td></tr></thead><tbody>\n";
		echo "<tr>\n";
		echo "<th>Edit</th>\n";
		echo "<th>No</th>\n";
		for ($col = 0; $col <= 7; ++$col) {//total column to be displayed
		   
		    switch($col){
				case 0:
					echo "<th>NIK</th>\n";
					break;
				case 1:
					echo "<th>Name</th>\n";
					break;
				case 2:
					echo "<th>Level</th>\n";
					break;
				case 3:
					echo "<th>Division</th>\n";
					break;
				case 4:
					echo "<th>Department</th>\n";
					break;
				case 5:
					echo "<th>Section</th>\n";
					break;
				case 6:
					echo "<th>Point</th>\n";
					break;
				case 7:
					echo "<th>Remarks</th>\n";
					break;
				}
		  }
		echo "</tr>\n";
		
		$pointer=1;
				
		for ($row = 4; $row <= $highestRow; ++$row) {
		 
		  $arr[$row] = array();
		  $point = $objWorksheet->getCellByColumnAndRow($week+1, $row)->getValue();
		  $nik = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
		  $sql = "select first_name, middle_name, last_name, level, 
				  div = (select top 1 divname from edm..division x 
				  where divcode = (select top 1 divcode from edm..section b 
				  where substring(a.cost_center,7,4) = b.costcenter)), 
				  dept = (select top 1 deptname from edm..department d 
				  where deptcode = (select top 1 deptcode from edm..section b 
				  where substring(a.cost_center,7,4) = b.costcenter)), 
				  section = (select top 1 costname from edm..section b 
				  where substring(a.Cost_center,7,4) = b.CostCenter) 
				  from user_registration..employee a where id_reference='".$nik."'";
		  $rs = $conn->Execute($sql);
          if ($point!=""){
              if($rs->fields["first_name"]!=null){
    			if ($section=="flexo & vega plant 1" || $section=="flexo & vega plant 2"){
    				if (strlen($nik)!=5){	
    				    echo "<tr class='myRow"; 
    					if (strlen($nik)!=7 || $nik=="") echo " error";
    					echo "'>\n";
    					echo "<td width='3%'><input id=".$row." type='checkbox' name='checkModify' /></td>\n";
    					echo "<td width='3%'>".$pointer."</td>\n";
    					for ($col = 0; $col <= 7; ++$col) {//total column to be displayed
    					  $arr[$row][$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
    					  $point = $objWorksheet->getCellByColumnAndRow($week+1, $row);
    						  
    					  switch($col){
    						case 0:
    							if (strlen($arr[$row][$col])==5) break;
    							else echo "<td width='5%'><div class='nik'>".$arr[$row][$col]."</div></td>\n";
    							break;
    						case 1:
    							if (strlen($nik)!=7 || $nik=="") echo "<td width='20%'><div class='nama'>".$arr[$row][$col]."</div></td>\n";
    							else echo "<td width='20%'><div class='nama'>".rtrim(ltrim($rs->fields["first_name"]))." ".rtrim(ltrim($rs->fields["middle_name"]))." ".rtrim(ltrim($rs->fields["last_name"]))."</div></td>\n";
    							break;
    						case 2:
    							if (isset($rs->fields["level"])) echo "<td width='5%'><div class='level'>".rtrim(ltrim($rs->fields["level"]))."</div></td>\n";
    							else echo "<td width='5%'><div class='level'></div></td>\n";
    							break;
    						case 3:
    							if (isset($rs->fields["div"])) echo "<td width='5%'><div class='division'>".rtrim(ltrim($rs->fields["div"]))."</div></td>\n";
    							else echo "<td width='5%'><div class='division'></div></td>\n";
    							break;
    							
    						case 4:
    							if (isset($rs->fields["dept"])) echo "<td width='5%'><div class='department'>".rtrim(ltrim($rs->fields["dept"]))."</div></td>\n";
    							else echo "<td width='5%'><div class='department'></div></td>\n";
    							break;
    						case 5:
    							if (isset($rs->fields["section"])) echo "<td width='5%'><div class='section'>".rtrim(ltrim($rs->fields["section"]))."</div></td>\n";
    							else echo "<td width='5%'><div class='section'></div></td>\n";
    							break;
    						case 6:
    							if(strlen($point)==4) echo "<td width='10%'><div class='week'>".substr($point,0,2)."</div></td>\n";
    							else echo "<td width='10%'><div class='week'>".substr($point,0,1)."</div></td>\n";
    							break;
    						case 7:
    							if(strlen($point)==4) echo "<td width='40%'><div class='remarks'>Index Competition Juara ".substr($point,3,4)." Week ".$week." th.".$tyear."</div></td>\n";
    							else echo "<td width='40%'><div class='remarks'>Index Competition Juara ".substr($point,2,3)." Week ".$week." th.".$tyear."</div></td>\n";
    							break;
    					  }
    					}
    					echo "</tr>" . "\n";
    					$pointer++;
    				}		
    			}
    			else{	
    				echo "<tr class='myRow"; 
    				if (strlen($nik)!=7 || $nik=="") echo " error";
    				echo "'>\n";
    				echo "<td width='3%'><input id=".$row." type='checkbox' name='checkModify' /></td>\n";
    				echo "<td width='3%'>".$pointer."</td>\n";
    				for ($col = 0; $col <= 7; ++$col) {//total column to be displayed
    				  $arr[$row][$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
    				  $point = $objWorksheet->getCellByColumnAndRow($week+1, $row);
    					  
    				  switch($col){
    					case 0:
    						if (strlen($arr[$row][$col])==5) break;
    						else echo "<td width='5%'><div class='nik'>".$arr[$row][$col]."</div></td>\n";
    						break;
    					case 1:
    						if (strlen($nik)!=7 || $nik=="") echo "<td width='20%'><div class='nama'>".$arr[$row][$col]."</div></td>\n";
    						else echo "<td width='20%'><div class='nama'>".rtrim(ltrim($rs->fields["first_name"]))." ".rtrim(ltrim($rs->fields["middle_name"]))." ".rtrim(ltrim($rs->fields["last_name"]))."</div></td>\n";
    						break;
    					case 2:
    						if (isset($rs->fields["level"])) echo "<td width='5%'><div class='level'>".rtrim(ltrim($rs->fields["level"]))."</div></td>\n";
    						else echo "<td width='5%'><div class='level'></div></td>\n";
    						break;
    					case 3:
    						if (isset($rs->fields["div"])) echo "<td width='5%'><div class='division'>".rtrim(ltrim($rs->fields["division"]))."</div></td>\n";
    						else echo "<td width='5%'><div class='division'></div></td>\n";
    						break;
    						
    					case 4:
    						if (isset($rs->fields["dept"])) echo "<td width='5%'><div class='department'>".rtrim(ltrim($rs->fields["dept"]))."</div></td>\n";
    						else echo "<td width='5%'><div class='department'></div></td>\n";
    						break;
    					case 5:
    						if (isset($rs->fields["section"])) echo "<td width='5%'><div class='section'>".rtrim(ltrim($rs->fields["section"]))."</div></td>\n";
    						else echo "<td width='5%'><div class='section'></div></td>\n";
    						break;
    					case 6:
    						if(strlen($point)==4) echo "<td width='10%'><div class='week'>".substr($point,0,2)."</div></td>\n";
    						else echo "<td width='10%'><div class='week'>".substr($point,0,1)."</div></td>\n";
    						break;
    					case 7:
    						if(strlen($point)==4) echo "<td width='40%'><div class='remarks'>Index Competition Juara ".substr($point,3,4)." Week ".$week." th.".$tyear."</div></td>\n";
    						else echo "<td width='40%'><div class='remarks'>Index Competition Juara ".substr($point,2,3)." Week ".$week." th.".$tyear."</div></td>\n";
    						break;
    				  }
    				}
    				echo "</tr>" . "\n";
    				$pointer++;
    			}
              }
              else{
                //$firephp->log($nik,'invalid nik');
              }
          }
		}
		echo"</tbody>\n";
		echo "</table>" . "\n";
		
		echo "</div>";
	}
    else if(strtolower($template)=="6r6s" && strtolower($objWorksheet->getCellByColumnAndRow(0, 1)->getValue())=="6r6s" && $objWorksheet->getCellByColumnAndRow(1, 1)->getValue()!=""){
		
		echo "<center><span id='template'>".$template."</span></center>";
		echo "<div class='span5' style='padding:1% 1%;float:left'>";
		echo "<div style='border:0.5px solid #D6D6FF;-moz-border-radius:3px;padding:0.5% 1%'><span style='font-size:0.8em'>Template Info</span></div><br><br>";
		
		$pointer = $pointer - 1;
		$arrInvalid = array();
		//exception case for Converting Index Competition
        $tyear = (rtrim(ltrim(strtolower($objWorksheet->getCellByColumnAndRow(1, 1)->getValue()))));
		// if($section=="flexo plant 1"||$section=="flexo plant 2"||$section=="vega plant 1"||$section=="vega plant 2"){
			// $section = "Finishing";
		// }
		for ($row = 4; $row <= $highestRow; ++$row) {
			$point = $objWorksheet->getCellByColumnAndRow($week+1, $row)->getValue();
			$nik = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
			$name = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
			$sql = "select section = (select top 1 costname from edm..section b 
					 where substring(a.Cost_center,7,4) = b.CostCenter) 
					 from user_registration..employee a where id_reference='".$nik."'";
			$rs = $conn->Execute($sql);
            
            //$table = "test_point";
			$table = "point";
            
            if (strlen($nik)!=7 && $point!=""){
    			$arrInvalid[$row] = $name;
                $invalid++;
			}
            
			if($rs->fields["section"]!=null){
                $sec=$rs->fields["section"];
                $sql2 = "select count(*) as dup from ".$table." where section='".$sec."' and remarks like '%Week ".$week." th.".$tyear."%'";
                //echo $sql2;
                $rs2 = $conn->Execute($sql2);
                
                if($rs2->fields["dup"]!=0){ //count duplicates
				    //$dup++; 
				    //break;
                }

    			if($point!=""){
    				$pointer++;
    			}
            }	
		}
		echo "<div class='form-horizontal'>";
		echo "<div class='control-group'>
				<label class='control-label' for='section'>Week :</label>
					<div class='controls'>
					<input id='week' class='input-mini' name='week' type='text' value='".$week."'disabled />
				</div>
			  </div>";
        echo "<div class='control-group'>
				<label class='control-label' for='section'>Year :</label>
					<div class='controls'>
					<input id='tyear' class='input-mini' name='tyear' type='text' value='".$tyear."'disabled />
				</div>
			  </div>";
		echo "<div class='control-group'>
				<label class='control-label' for='section'>6R/6S Winners :</label>
					<div class='controls'>
					<input id='winner' class='input-mini' name='winner' type='text' value='".$pointer." people' disabled />
				</div>
			  </div>";
		//display duplicates	 
	    echo "<input id='dup' class='input-mini' name='dup' type='hidden' value='".$dup."' disabled />";
		echo "<input id='invalid' class='input-mini' name='invalid' type='hidden' value='".$invalid."' disabled />";
        //display error rows
		echo "<div id='divInvalid' class='control-group error' ";
		if($invalid>0){
		  echo "style='visibility:visible'>";
          //$firephp->log(count($arrNull),'total null');
          //$firephp->log($arrNull,'arrNull');
          $x= 0;
          echo "<div class='control-group'>
				<label class='control-label' for='section'>Incorrect ID(s) :</label>
					<div class='controls'>
					<textarea cols='5' rows='5'>";
          foreach($arrInvalid as $key => $value){
            echo $value.PHP_EOL;
            $x++;
          }
          echo "</textarea></div></div></div>";
		} 
		else echo "></div>";
		
		
		echo "<div class='control-group'><div class='controls'>";
		echo "<button id='submit' style='margin:0% 1% 0 0;float:left' class='btn btn-primary' type='submit' name='submit' data-loading-text='Loading...' autocomplete='off'>Submit</button>";
		echo "<button id='modify' style='margin:0% 3% 0 0;float:left' class='btn' type='button' name='modify' onclick='javascript:history.back();'>Cancel</button>";
		echo "</div></div>";
		echo "</div>";
		echo "</div>";
		echo "<div class='span6' style='padding:1% 1%;float:right'>";
		echo "<table id=\"table1\" class=\"table table-bordered table-condensed\" style=\"font-size:0.8em;width:100%\" cellspacing=\"0\">\n";			
		echo "<thead><tr><td>Details</td></tr></thead><tbody>\n";
		echo "<tr>\n";
		echo "<th>Edit</th>\n";
		echo "<th>No</th>\n";
		for ($col = 0; $col <= 7; ++$col) {//total column to be displayed
		   
		    switch($col){
				case 0:
					echo "<th>NIK</th>\n";
					break;
				case 1:
					echo "<th>Name</th>\n";
					break;
				case 2:
					echo "<th>Level</th>\n";
					break;
				case 3:
					echo "<th>Division</th>\n";
					break;
				case 4:
					echo "<th>Department</th>\n";
					break;
				case 5:
					echo "<th>Section</th>\n";
					break;
				case 6:
					echo "<th>Point</th>\n";
					break;
				case 7:
					echo "<th>Remarks</th>\n";
					break;
				}
		  }
		echo "</tr>\n";
		
		$pointer=1;
				
		for ($row = 4; $row <= $highestRow; ++$row) {
		 
		  $arr[$row] = array();
		  $point = $objWorksheet->getCellByColumnAndRow($week+1, $row)->getValue();
		  $nik = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
		  $sql = "select first_name, middle_name, last_name, level, 
				  div = (select top 1 divname from edm..division x 
				  where divcode = (select top 1 divcode from edm..section b 
				  where substring(a.cost_center,7,4) = b.costcenter)), 
				  dept = (select top 1 deptname from edm..department d 
				  where deptcode = (select top 1 deptcode from edm..section b 
				  where substring(a.cost_center,7,4) = b.costcenter)), 
				  section = (select top 1 costname from edm..section b 
				  where substring(a.Cost_center,7,4) = b.CostCenter) 
				  from user_registration..employee a where id_reference='".$nik."'";
		  $rs = $conn->Execute($sql);
          
          //if($rs->fields[0]!=null){
				if ($point!=""){
						
						echo "<tr class='myRow"; 
						if (strlen($nik)!=7 || $nik=="") echo " error";
						echo "'>\n";
						echo "<td width='3%'><input id=".$row." type='checkbox' name='checkModify' /></td>\n";
						echo "<td width='3%'>".$pointer."</td>\n";
						for ($col = 0; $col <= 7; ++$col) {//total column to be displayed
						  $arr[$row][$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
						  $point = $objWorksheet->getCellByColumnAndRow($week+1, $row);
						  
						  switch($col){
							case 0:
								if (strlen($arr[$row][$col])==5) break;
								else echo "<td width='5%'><div class='nik'>".$arr[$row][$col]."</div></td>\n";
								break;
							case 1:
								if (isset($rs->fields["first_name"])) echo "<td width='20%'><div class='nama'>".rtrim(ltrim($rs->fields["first_name"]))." ".rtrim(ltrim($rs->fields["middle_name"]))." ".rtrim(ltrim($rs->fields["last_name"]))."</div></td>\n";
                                else echo "<td width='20%'><div class='nama'>".$arr[$row][$col]."</div></td>\n";
								break;
							case 2:
								if (isset($rs->fields["level"])) echo "<td width='5%'><div class='level'>".rtrim(ltrim($rs->fields["level"]))."</div></td>\n";
								else echo "<td width='5%'><div class='level'></div></td>\n";
								break;
							case 3:
								if (isset($rs->fields["div"])) echo "<td width='5%'><div class='division'>".rtrim(ltrim($rs->fields["div"]))."</div></td>\n";
								else echo "<td width='5%'><div class='division'></div></td>\n";
								break;
								
							case 4:
								if (isset($rs->fields["dept"])) echo "<td width='5%'><div class='department'>".rtrim(ltrim($rs->fields["dept"]))."</div></td>\n";
								else echo "<td width='5%'><div class='department'></div></td>\n";
								break;
							case 5:
								if (isset($rs->fields["section"])) echo "<td width='5%'><div class='section'>".rtrim(ltrim($rs->fields["section"]))."</div></td>\n";
								else echo "<td width='5%'><div class='section'></div></td>\n";
								break;
							case 6:
								if(strlen($point)==4) echo "<td width='10%'><div class='week'>".substr($point,0,2)."</div></td>\n";
								else echo "<td width='10%'><div class='week'>".substr($point,0,1)."</div></td>\n";
								break;
							case 7:
								if(strlen($point)==4) echo "<td width='40%'><div class='remarks'>6R/6S Competition Juara ".substr($point,3,4)." Week ".$week." th.".$tyear."</div></td>\n";
								else echo "<td width='40%'><div class='remarks'>6R/6S Competition Juara ".substr($point,2,3)." Week ".$week." th.".$tyear."</div></td>\n";
								break;
						  }
						}
						echo "</tr>" . "\n";
						$pointer++;
			}
          //}
          //else{
          //  break;
          //}
		}
		echo"</tbody>\n";
		echo "</table>" . "\n";
		
		echo "</div>";
	}
	else if($template=="i-Suggest" && $objWorksheet->getCellByColumnAndRow(2, 1)->getValue()=="Suggestion"){
        
		$arr2 = array();
		echo "<center><span id='template'>".$template."</span></center>";
		$gold=0;$silver=0;$bronze=0;$other=0;$dup=0;
        
		for ($row = 2; $row <= $highestRow; ++$row) {
			$reward = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
			$suggestion = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
			$nik = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
            
			$table = "point";
			$sql2 = "select count(*) as dup from ".$table." where remarks like '%".rtrim(ltrim($suggestion))."%'";
			$rs2 = $conn->Execute($sql2);
			
			if($rs2->fields["dup"]!=0) {
			    //$dup++; //count duplicates
                $firephp->log($suggestion);
			}
			else{
				if(rtrim(ltrim(strtolower($reward)))=="gold"){
					$gold++;
				}
				elseif(rtrim(ltrim(strtolower($reward)))=="silver"){
					$silver++;
				}
				elseif(rtrim(ltrim(strtolower($reward)))=="bronze"){
					$bronze++;
				}
			}         
			
			$arr2[$row][0] = $rs2->fields["dup"];
			$arr2[$row][1] = $suggestion;
		}
//        die;
		
		echo "<div class='span5' style='padding:1% 1%;float:left'>";
		echo "<div style='border:0.5px solid #D6D6FF;-moz-border-radius:3px;padding:0.5% 1%'><span style='font-size:0.8em'>Template Info</span></div><br><br>";
		echo "<div class='form-horizontal'>";
		echo "<div class='control-group'>
				<label class='control-label' for='section'>Gold :</label>
					<div class='controls'>
					<input id='gold' class='input-mini' name='gold' type='text' value='".$gold."'disabled />
				</div>
			  </div>";
		echo "<div class='control-group'>
				<label class='control-label' for='section'>Silver :</label>
					<div class='controls'>
					<input id='silver' class='input-mini' name='silver' type='text' value='".$silver."'disabled />
				</div>
			  </div>";
		echo "<div class='control-group'>
				<label class='control-label' for='section'>Bronze :</label>
					<div class='controls'>
					<input id='bronze' class='input-mini' name='bronze' type='text' value='".$bronze."'disabled />
				</div>
			  </div>";
		echo "<div class='control-group'>
				<label class='control-label' for='section'>Total Rows :</label>
					<div class='controls'>
					<input id='row' class='input-mini' name='row' type='text' value='".($gold+$silver+$bronze)."'disabled />
				</div>
			  </div>";
		if($dup>0){
		echo "<div class='control-group error'>
				<label class='control-label' for='section'>Duplicate Rows :</label>
					<div class='controls'>
					<input id='dup' class='input-mini' name='dup' type='text' value='".$dup."'disabled />
				</div>
			  </div>";
		}
		echo "<div class='control-group'><div class='controls'>";
		echo "<button id='submit' style='margin:0% 1% 0 0;float:left' class='btn btn-primary' type='submit' name='submit' data-loading-text='Loading...' autocomplete='off'>Submit</button>";
		echo "<button id='modify' style='margin:0% 3% 0 0;float:left' class='btn' type='button' name='modify' onclick='javascript:history.back();'>Cancel</button>";
		echo "</div></div>";
		echo "</div>";
		echo "</div>";
		echo "<div class='span6' style='padding:1% 1%;float:right'>";
		echo "<table id=\"table1\" class=\"table table-bordered table-condensed\" style=\"font-size:0.8em;width:100%\" cellspacing=\"0\">\n";			
		echo "<thead><tr><td>Details</td></tr></thead><tbody>\n";
		echo "<tr>\n";
		echo "<th>No</th>\n";
		for ($col = 0; $col <= 7; ++$col) {//total column to be displayed
		   
		    switch($col){
				case 0:
					echo "<th>NIK</th>\n";
					break;
				case 1:
					echo "<th>Name</th>\n";
					break;
				case 2:
					echo "<th>Level</th>\n";
					break;
				case 3:
					echo "<th>Division</th>\n";
					break;
				case 4:
					echo "<th>Department</th>\n";
					break;
				case 5:
					echo "<th>Section</th>\n";
					break;
				case 6:
					echo "<th>Point</th>\n";
					break;
				case 7:
					echo "<th>Remarks</th>\n";
					break;
				}
		}
		echo "</tr>\n";
		
		$pointer=1;
		
		for ($row = 2; $row <= $highestRow; ++$row) {
			$reward = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
			$suggestion = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
			$nik = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
			$sql = "select first_name, middle_name, last_name, level, 
				  div = (select top 1 divname from edm..division x 
				  where divcode = (select top 1 divcode from edm..section b 
				  where substring(a.cost_center,7,4) = b.costcenter)), 
				  dept = (select top 1 deptname from edm..department d 
				  where deptcode = (select top 1 deptcode from edm..section b 
				  where substring(a.cost_center,7,4) = b.costcenter)), 
				  section = (select top 1 costname from edm..section b 
				  where substring(a.Cost_center,7,4) = b.CostCenter) 
				  from user_registration..employee a where id_reference='".$nik."'";
			$rs = $conn->Execute($sql);
			
			
			if($arr2[$row][0]!=1){
				if(rtrim(ltrim(strtolower($reward)))=="gold"||rtrim(ltrim(strtolower($reward)))=="silver"||rtrim(ltrim(strtolower($reward)))=="bronze"){
					echo "<tr class='myRow'>";
					echo "<td width='3%'>".$pointer."</td>\n";
					for ($col = 0; $col <= 9; ++$col) {//total column to be displayed
					  $arr[$row][$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
					}			  
					echo "<td width='5%'><div class='nik'>".$nik."</div></td>";

					echo "<td width='15%'><div class='name'>".rtrim(ltrim($rs->fields["first_name"]))." ".rtrim(ltrim($rs->fields["middle_name"]))." ".rtrim(ltrim($rs->fields["last_name"]))."</div></td>";

					if (isset($rs->fields["level"])) echo "<td width='5%'><div class='level'>".rtrim(ltrim($rs->fields["level"]))."</div></td>\n";
					else echo "<td width='5%'><div class='level'></div></td>\n";
							
					echo "<td width='15%'><div class='division'>".rtrim(ltrim($rs->fields["div"]))."</div></td>";
					
					if (isset($rs->fields["dept"])) echo "<td width='15%'><div class='department'>".rtrim(ltrim($rs->fields["dept"]))."</div></td>\n";
					else echo "<td width='15%'><div class='department'></div></td>\n";
							
					if (isset($rs->fields["section"])) echo "<td width='15%'><div class='section'>".rtrim(ltrim($rs->fields["section"]))."</div></td>\n";
					else echo "<td width='15%'><div class='section'></div></td>\n";

					echo "<td width='5%'><div class='point'>";
							
					if (rtrim(ltrim(strtolower($arr[$row][1])))=="gold") echo "10";
					else if(rtrim(ltrim(strtolower($arr[$row][1])))=="silver") echo "5";
					else if(rtrim(ltrim(strtolower($arr[$row][1])))=="bronze") echo "3";
					echo "</div></td>";

					echo "<td width='25%'><div class='remarks'>Realized i-Suggest : ".$arr[$row][1].". No Suggestion : ".$arr2[$row][1]."</div></td>";						
					
					$pointer++;
				}
			}
			else $invalid++;
		}	
		echo "</table>\n";
	}
	else
	{
		echo "<div><center><span>File yang diupload bukan format yang anda pilih. Pastikan pilihan template dan file yang diupload adalah benar, kemudian coba upload kembali</span>\n";
		echo "<br><br><button class='btn btn-large' type='button' onclick='history.back();'>Back</button></center></div>";
	}
}
$objPHPExcel->disconnectWorksheets();
unset($objPHPExcel);


?>