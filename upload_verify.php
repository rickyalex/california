<?php
session_start();

if(!isset($_SESSION['userid']) || !isset($_SESSION['today']))  {
	unset($_SESSION['today']);
	header('Location: Login.php');
	die;
}

$title = 'Upload Verification - MBOS Personal Point Reward';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.tablescroll.css"/>
	<script type="text/javascript" src="easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.tablescroll.js"></script>
	<script type="text/javascript" src="js/json2.js"></script>
</head>
<body>
	<?php include('header.php'); ?>
	<div class="container">	
		<div class="row-fluid">
		
			<div id="disp1" style="height:600px;border:1px solid #c6c6c6;-moz-border-radius:10px;-moz-box-shadow: 2px 2px 5px #888888;margin:0% 2% 2% 2%">
				<div><h1 class="modal-header">Upload Verification</h1></div>
				
					<?php include("php/getExcel.php");?>
				
				
				
				<div id="progbar" class="progress progress-striped active" style="visibility:hidden;margin:1%;width:100px"><div class="bar" style="width:100%"></div>
			</div>
		</div>
	</div>
	
	<script>
		
		function scrolify(myTable, height){
			var oTbl = myTable;
			var oTblDiv = $("<div/>");
			oTblDiv.css('height', height);
			oTblDiv.css('overflow', 'scroll');
			oTbl.wrap(oTblDiv);
			
			oTbl.attr("data-item-original-width", oTbl.width());
			oTbl.find('thead tr td').each(function(){
				$(this).attr("data-item-original-width",$(this).width());
			});
			oTbl.find('tbody tr:eq(0) td').each(function(){
				$(this).attr("data-item-original-width",$(this).width());
			});
			
			var newTbl = oTbl.clone();
			
			oTbl.find('thead tr').remove();
			newTbl.find('tbody tr').remove();
			oTbl.parent().parent().prepend(newTbl);
			newTbl.wrap("<div/>");
			
			newTbl.width(newTbl.attr('data-item-original-width'));
			newTbl.find('thead tr td').each(function(){
				$(this).width($(this).attr("data-item-original-width"));
			});
		}
		function storeData(myBut){
			var but = myBut;
			but.attr("disabled","disabled");
			but.html('Loading...');
			var arr = [];
			
			if($("#template").text()=="Index Competition"||$("#template").text()=="i-Suggest") {
				$(".myRow").each(function(i){
					arr[i] = [];
					if($("#template").text()=="i-Suggest"){
						$(this).find("td").slice(1,9).each(function(j){
							arr[i][j] = $(this).text();
						});
					}
					else{
						$(this).find("td").slice(2,10).each(function(j){
							arr[i][j] = $(this).text();
						});
					}
				});
				url = "php/indexQuery.php";
				data = arr;
			}
			$.ajax({
				async: false,
				type: "POST",  
				url: url,  
				data: { 'myArr':data },
				success: function(val){
					var result = eval('(' + val + ')');
					if(result.success){
						alert(result.success);
						//but.removeAttr("disabled");
						//but.html("Submit");
						history.back();
						//document.getElementById("progbar").style.visibility="hidden";
					}
					else{
						alert(result.failed);
						return false;
					}
					//window.location.replace("upload.php");
				},
				error: function(err){
					var result = eval('(' + err + ')');
					alert(result.failed);
					//alert(err);
				}
			})
		}
		$(document).ready(function(){
			scrolify($('#table1'), 320);
		});
		$(document).ready(function(){
			var count=0;
			$(function(){	
				$(":checkbox[name='checkModify']").change(function(){
					if($(this).is(":checked")){
						count++;
						$(":checkbox").attr("disabled", "disabled");
						$(this).removeAttr("disabled");
						$(this).each(function(){
							if($("#template").text()!="Project E-MPRO"){
								$(this).closest("tr").find("div").slice(0,1).each(function(){
									//$(this).closest("tr").find("div#v").slice(2,25).each(function(){
										$(this).html($("<textarea/>",{html:this.innerHTML}));
										//$(this).attr('class','textEdit');
										//console.log($(this).find("textarea").val());										
									//});
								});
							}
						});
					}
					else{
						$(this).each(function(){
							$(":checkbox").removeAttr("disabled");
						});
							if($("#template").text()!="Project E-MPRO"){
								$(this).closest("tr").find("div").slice(0,1).each(function(){
									if($('textarea').val().length==7){
										$(this).html($("textarea").val());
										
										$(this).parent().parent().attr('class','edited');
										console.log($(this).parent().parent().attr('class'));
										var id = $(this).html(); //first DIV contains NIK
						
										if(id!="" || id!=null){
											$.ajax({
												async: false,
												type: "POST",  
												url: "php/getInfo.php",  
												data: { 'id':id },
												success: function(val){
													var result = eval('(' + val + ')');
													if (result.err){
														$('.edited').parent().attr('class','myRow error');
														$('.edited').parent().find('div').slice(1,6).each(function(){
															$(this).html('');
														});
														return false;
													}
													else{
																if(result.middle_name!="") $('.edited').parent().find('div:eq(1)').html(result.first_name+" "+result.middle_name+" "+result.last_name);
																else $('.edited').parent().find('div:eq(1)').html(result.first_name+" "+result.last_name);
																$('.edited').parent().find('div:eq(2)').html(result.level);
																$('.edited').parent().find('div:eq(3)').html(result.div);
																$('.edited').parent().find('div:eq(4)').html(result.dept);
																$('.edited').parent().find('div:eq(5)').html(result.costname);
																$('.edited').parent().attr('class','myRow');
													}
												},
												error: function(err){
													var result = eval('(' + err + ')');
													alert(result.failed);
													//alert(err);
												}
											})
										}
										console.log($(this).parent().parent().attr('class'));
									}
									else{
										$(this).html($("textarea").val());
										$(this).parent().parent().attr('class','myRow error');
										$(this).parent().parent().find('div').slice(1,6).each(function(){
											$(this).html('');
										});
										//console.log('error');
										
										
									}
								});
							}
						
								var invalid=0;
								$(".myRow").each(function(){
									if($(this).attr('class')=='myRow error'){
										invalid++;
									}
								});
								$("#invalid").val(invalid);
								if(invalid==0){
									$("#divInvalid").css({'visibility':'hidden'});
									$("#submit").removeAttr('disabled');
								}
								else{
									$("#divInvalid").css({'visibility':'visible'});
									$("#submit").attr('disabled','disabled');
								}
					}
					//}
				//});
				});
			if($("#template").text()=="Index Competition"){
				var invalid=0;
				$(".myRow").each(function(){
					if($(this).attr('class')=='myRow error'){
						invalid++;
					}
				});
				if($("#invalid").val()!=0){
				    $("#divInvalid").css({'visibility':'visible'});
					$("#submit").attr('disabled','disabled');
                    alert('Incorrect Employee ID detected. Please make sure the ID(s) are correct');
				}
				else{
                    $("#divInvalid").css({'visibility':'hidden'});
					$("#submit").removeAttr('disabled');
				}
                
				if($("#dup").val()!=0){
					$("#submit").attr('disabled','disabled');
					alert("The points for this section on this Week has already been posted before. Please make sure the File & Week is correct");
					history.back();
				}
				else if($("#winner").val().substring(0,1)=="0"){
					$("#submit").attr('disabled','disabled');
					alert('No points found. Make sure the Week is correct');
					history.back();
				}
                
			}
			else if($("#template").text()=="i-Suggest"){
				if(($("#gold").val().substring(0,1)=="0")&&($("#silver").val().substring(0,1)=="0")&&($("#bronze").val().substring(0,1)=="0")){
					$("#submit").attr('disabled','disabled');
					alert('No i-Suggest reward found. Make sure the File is correct');
					history.back();
				}
				else if($("#dup").val()!=0){
					//$("#submit").attr('disabled','disabled');
					//alert("One or more iSuggest(s) in this template has already been posted before. Please make sure the File is correct");
					//history.back();
				}
			}
			$("#submit").click(function(){
				//document.getElementById("progbar").style.visibility="Loading..";
				if(count==0){
					var con = confirm("No fields are edited, continue submit data ?");
					if(con==true){
						storeData($("#submit"));
					}
					else{
						return false;
					}
				}
				else{
					storeData($("#submit"));
				}
			});
			});
		});	
	</script>
</body>
</html>