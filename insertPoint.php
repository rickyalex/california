<?php
session_start();

if(!isset($_SESSION['userid']) || !isset($_SESSION['today']))  {
	unset($_SESSION['today']);
	header('Location: login.php');
	die;
}

if(!isset($_SESSION['user_group'])){
	header('Location: 404.php');
}

$today = $_SESSION['today'];
//$year = getdate(date('Y'));
$year = substr($today,strlen($today)-4,4);

$title = 'Insert Point - MBOS Personal Point Reward';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=EDGE" charset="utf-8">
	<title><?php echo $title; ?></title>
	
	<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	
	<link rel="stylesheet" href="jqwidgets-ver2.5.5/jqwidgets/styles/jqx.base.css" type="text/css" />
	<script type="text/javascript" src="jqwidgets-ver2.5.5/scripts/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="jqwidgets-ver2.5.5/scripts/gettheme.js"></script>
	<script type="text/javascript" src="jqwidgets-ver2.5.5/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets-ver2.5.5/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="jqwidgets-ver2.5.5/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="jqwidgets-ver2.5.5/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="jqwidgets-ver2.5.5/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="jqwidgets-ver2.5.5/jqwidgets/jqxcombobox.js"></script>

	
	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />
	
	<style>
	.infoDiv{
		display:none;
	}
	</style>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
    $(document).ready(function(){
        $("#typeSelect").change(function(){
            if($(this).prop('value')=='pro'){
                $("#juaraInput").css({'display':'none'});
                $("#yearInput").css({'display':'none'});
                $("#regNoinput").css({'display':'block'});
                $("#roleInput").css({'display':'block'});
            }
            else if($(this).prop('value')=='vteam'){
                $("#regNoinput").css({'display':'none'});
                $("#roleInput").css({'display':'none'});
                $("#juaraInput").css({'display':'none'});
                $("#yearInput").css({'display':'block'});
            }
            else if($(this).prop('value')=='comp'){
                $("#juaraInput").css({'display':'block'});
                $("#yearInput").css({'display':'block'});
                $("#regNoinput").css({'display':'none'});
                $("#roleInput").css({'display':'none'});
            }
        });
    })
            // $(document).ready(function () {
                // var theme = getTheme();

				// $.ajax({  
					// type: "POST",  
					// url: "getName.php",
					// success: function(val){

			                //prepare the data
			                // var source =
			                // {
			                    // datatype: "json",
			                    // datafields: [
			                        // { name: 'Name' }
			                    // ],
			                    // id: 'id',
								// localdata: val,
			                    // async: false
			                // };
			                // var dataAdapter = new $.jqx.dataAdapter(source);

			                //Create a jqxComboBox
			                // $("#jqxWidget").jqxComboBox({ source: dataAdapter, displayMember: "Name", valueMember: "Name", width: 200, height: 25, theme: theme });

			                //bind to the select event.
			                // $("#jqxWidget").bind('select', function (event) {
			                    // if (event.args) {
			                        // var item = event.args.item;
			                        // if (item) {
			                            // var valueelement = $("<div></div>");
			                            // valueelement.html("Value: " + item.value);
			                            // var labelelement = $("<div></div>");
			                            // labelelement.html("Label: " + item.label);

			                            // $("#selectionlog").children().remove();
			                        // }
			                    // }
			                // });
						// },
						// error: function(retval){ 
							// alert("SQL script gagal");
						// } 
					// })
            // });
					function getInfo(){
						//var index = $("#jqxWidget").jqxComboBox('getSelectedIndex');
						//var name = $("#jqxWidget").jqxComboBox('getItem',index).value;
						//var arrName = new Array();
						//arrName = name.split(" ");
						
						var id = $('#nik').val();
						//alert(arrName);
						$.ajax({
							type: "POST",
							url: 'php/getInfo.php',
							data: {'id':id},
							success: function(val){
								var result = eval('(' + val + ')');
								if(result.err){
									alert(result.err);
									$('.infoDiv').css({'display':'none'});
								}
								else{
									var res = JSON.parse(val);
									//alert(res.id_employee);
									$('.infoDiv').css({'display':'block'});
									if(res.middle_name!="") document.getElementById('name').value = res.first_name+" "+res.middle_name+" "+res.last_name;
									else document.getElementById('name').value = res.first_name+" "+res.last_name;
									document.getElementById('seksi').value = res.costname;
									document.getElementById('level').value = res.level;
								}
							},
							error: function(err){
								//var res = JSON.parse(err);
								//var result = eval('(' + err + ')');
								alert(err);
							}
						})
						//alert(name);
					}
                    
					function myConfirm(){
						//var index = $("#jqxWidget").jqxComboBox('getSelectedIndex');
						//var name = $("#jqxWidget").jqxComboBox('getItem',index).value;
						var name = document.getElementById('name').value;
						var nik = document.getElementById('nik').value;
						var seksi = document.getElementById('seksi').value;
						var lv = document.getElementById('level').value;
						var remarks = document.getElementById('remarks').value;
						var point = document.getElementById('point').value;
                        var year = document.getElementById('Year').value;
                        var month = document.getElementById('Month').value;
                        var juara = document.getElementById("juara").options[document.getElementById("juara").selectedIndex].text;
                        var regno = document.getElementById('regNo').value.toUpperCase();
                        var role = document.getElementById('role').value;
						var typeText = document.getElementById("typeSelect").options[document.getElementById("typeSelect").selectedIndex].text;
                        var type = document.getElementById("typeSelect").value;
                        
						if(point== '' || point== null){
							alert('Masukkan jumlah point yang akan di Insert');
							return false;
						}
                        
						if(type=="pro"){
						  if(regno== '' || regno== null){
							alert('Reg No harus diisi');
							return false;
						  }
                          else{
                            if(role== '' || role== null){
 							  alert('Role harus diisi');
    						  return false;
	                        }
                            else{
                              var remarkText = role+'-'+regno;
                              remarks = remarkText; 
                            }
                          }
						}
                        else if(type=="vteam"){
                          if(year== '' || year==null){
                            alert('Year harus diisi');
                            return false;
                          }
                          else{
                            if(month== '' || month==null){
                              alert('Month harus diisi');
                              return false;
                            }
                            else{
                              var remarkText = typeText+' '+month+' '+year;
                              remarks = remarkText; 
                            }
                          }
                        }
                        else{
                            if(year== '' || year==null){
                                alert('Year harus diisi');
                                return false;
                            }
                            else{
                              if(year== '' || year==null){
                                alert('Year harus diisi');
                                return false;
                              }
                              else{
                                if(month== '' || month==null){
                                  alert('Month harus diisi');
                                  return false;
                                }
                                else{
                                  var remarkText = typeText+' '+juara+' '+month+' '+year;
                                  remarks = remarkText;
                                }
                              }
                            }
                        }
                        
                        //alert(remarks);
                        
                        $.ajax({
  							type: "POST",
  							url: 'php/insertPointQuery.php',
  							data: {'name':name,'nik':nik,'seksi':seksi,'lv':lv,'remarks':remarks,'point':point},
  							success: function(val){
  								var result = eval('(' + val + ')');
  								alert(result.success);
  								document.getElementById('remarks').value = '';
  								document.getElementById('point').value = '';
  								$('.infoDiv').css({'display':'none'});
  							},
  							error: function(err){
  								var result = eval('(' + err + ')');
  								alert(result.success);
  							}
  						})
 
					}
        </script>

</head>
<body>
	<?php include("header.php");?>
	<div class="container">	
		<div class="row-fluid">
			<div style="height:400px;border:1px solid #c6c6c6;-moz-border-radius:10px;-moz-box-shadow: 2px 2px 5px #888888;margin:0% 2% 5% 2%">
				<div><h1 class="modal-header">Insert Point</h1></div>
				<div class="form-horizontal">
					<div class="span3" style="height:20px;float:left">
						<div class="control-group">
							<label class="control-label" for="nik">NIK :</label>
							<div class="controls">
								<input id="nik" class="input-small" name="nik" type="text" />
							</div>	
						</div>
						
						<div id="infoButton" class="control-group">
							<div class="controls">
								<button id="search"  class="btn btn-primary"  href="javascript:void(0);" onclick="getInfo();">Search</button>
							</div>
						</div>
						
					</div>
					<div class="span4">
						<span class="infoDiv">
							<div class="control-group">
								<label class="control-label" for="nik">Name :</label>
								<div class="controls">
									<input id="name" class="input-large" name="name" type="text" disabled />
								</div>
							</div>
                            <div class="control-group">
								<label class="control-label" for="type">Type :</label>
								<div class="controls">
				                    <select id="typeSelect" name="typeSelect" class="input-large">
                                        <option value="" disabled selected>---Please Select---</option>
    									<option value="pro">Project</option>
    									<option value="vteam">V-Team Section</option>
                                        <option value="vteam">V-Team Department</option>
                                        <option value="vteam">V-Team Division</option>
                                        <option value="comp">i-Suggest Competition</option>
                                        <option value="comp">SGA Competition</option>
                                        <option value="comp">JDI Competition</option>
    									<option value="comp">Section Head Competition</option>
                                        <option value="comp">Division Head Competition</option>
   								    </select>
								</div>
							</div>
                            <div id="regNoinput" class="control-group" style="display:none;">
								<label class="control-label" for="regNo">Reg No :</label>
								<div class="controls">
									<input id="regNo" class="input-large" name="regNo" type="text" style="text-transform:uppercase" placeholder="EMPRO Registration Number"/>
								</div>	
							</div>
                            <div id="roleInput" class="control-group" style="display:none;">
								<label class="control-label" for="role">Role :</label>
								<div class="controls">
				                    <select id="role" name="role" class="input-large">
                                        <option value="" disabled selected>---Please Select---</option>
    									<option value="Leader">Leader</option>
                                        <option value="Co-leader">Co-Leader</option>
                                        <option value="Member">Member</option>
    									<option value="Main Sponsor">Main Sponsor</option>
                                        <option value="Sponsor">Sponsor</option>
                                        <option value="Facilitator">Facilitator/Consultant</option>
    									<option value="Administrator">Administrator</option>
                                        <option value="V-Team">V-Team</option>
   								    </select>
								</div>
							</div>
                            <div id="juaraInput" class="control-group" style="display:none;">
								<label class="control-label" for="juaraInput">Juara :</label>
								<div class="controls">
									<select name="juara" id="juara" class="input-mini">
                                        <option value="" disabled selected>---Select---</option>
                                        <option value="1">Juara 1</option>
                                        <option value="2">Juara 2</option>
                                        <option value="3">Juara 3</option>
                                    </select>
								</div>	
							</div>
                            <div id="yearInput" class="control-group inline" style="display:none;">
                                <label class="control-label" for="Year">Year/Month :</label>
                                <div class="controls">
                                    <select name="Year" id="Year" class="input-mini">
                                        <option value="" disabled selected>---Select---</option>
                                        <option value=<?php echo $year;?>><?php echo $year;?></option>
                                        <option value=<?php echo $year-1;?>><?php echo $year-1;?></option>
                                        <option value=<?php echo $year-2;?>><?php echo $year-2;?></option>
                                    </select>
                                    <select name="Month" id="Month" class="input-small">
                                        <option value="" disabled selected>---Select---</option>
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>
                                    </select>
                                </div>
                            </div>
							<input id="remarks" name="remarks" type="hidden"/>
							<div class="control-group">
								<label class="control-label" for="point">Point to Insert :</label>
								<div class="controls">
									<input id="point" class="input-mini" name="point" type="text" />
								</div>
							</div>
							<div id="submitButton" class="control-group">
							<div class="controls">
								<button id="submit"  class="btn btn-primary"  onclick="myConfirm();">Submit</button>
							</div>
						</div>
						</span>
					</div>
					<div class="span3">
						<span class="infoDiv">
							<div class="control-group">
								<label class="control-label" for="seksi">Section :</label>
								<div class="controls">
									<input id="seksi" class="input-large" name="seksi" type="text" disabled />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="level">Level :</label>
								<div class="controls">
									<input id="level" class="input-mini" name="level" type="text" disabled />
								</div>
							</div>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>