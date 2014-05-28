<?php
session_start();

if(!isset($_SESSION['userid']) || !isset($_SESSION['today']))  {
	unset($_SESSION['today']);
	header('Location: Login.php');
	die;
}

if(!isset($_SESSION['user_group'])){
	header('Location: 404.php');
}

$title = 'Template Upload - MBOS Personal Point Reward';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />

	<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<script type="text/javascript" src="easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	
	
	<script>
		$(document).ready(function(){
			$(":radio[name='r_tipe']").change(function(){
				if($(":radio[id='r_tipe2']").is(':checked')||$(":radio[id='r_tipe3']").is(':checked')) $("#weekInput").css({'display':'block'});
				else $("#weekInput").css({'display':'none'});
			});
		});
	
		function check(but){
			var myBut = but;
			var ext_ok = false;
			
			
			but.attr("disabled","disabled");
			but.html('Loading...');
			
			if(document.forms['form_upload']['file'].value==null || document.forms['form_upload']['file'].value==""){
				alert("Silahkan pilih file terlebih dahulu");
				but.removeAttr("disabled");
				but.html("Submit");
				return false;
			}
			
			//kalau weeknya kosong
			if($(":radio[id='r_tipe2']").is(':checked')||$(":radio[id='r_tipe3']").is(':checked')){
				if($("#week").val()==null || $("#week").val()==""){
					alert("Silahkan tentukan Week yang akan diinput");
					but.removeAttr("disabled");
					but.html("Submit");
					return false;
				}
			}
			
			str=document.forms['form_upload']['file'].value.toUpperCase();
			
	        if((str.slice(str.length - 4) == ".XLS")||(str.slice(str.length - 5) == ".XLSX")){
				ext_ok = true;
	        }else{
				ext_ok = false;
			}
			
			if(ext_ok==false){
				alert('Format file bukan Excel');
				but.removeAttr("disabled");
				but.html("Submit");
				return false;
			}
			
		}
		
	</script>
</head>
<body>
	<?php include('header.php'); ?>
	<div class="container">	
		<div class="row-fluid">
			<div style="height:300px;border:1px solid #c6c6c6;-moz-border-radius:10px;-moz-box-shadow: 2px 2px 5px #888888;margin:0% 2%;padding:0 0 0.8%">
				<h1 class="modal-header">Template Upload</h1>
				<div class="span7">
					<form id="form_upload" class="form-horizontal" style="font-family:Tahoma;font-size:0.8em" action="upload_verify.php" onsubmit="return check($('#submit'))" method="post" enctype="multipart/form-data">
						<div class="control-group">
							<label class="control-label" for="r_tipe">Jenis Template :</label>
							<div class="controls">
								<?php /*<label class="radio">
									<input type="radio" name="r_tipe" id="r_tipe1" value="Project E-MPRO" checked />
									Project E-MPRO
								</label>*/ ?>
								<label class="radio">
									<input type="radio" name="r_tipe" id="r_tipe1" value="i-Suggest" checked/>
									i-Suggest
								</label>
								<label class="radio">
									<input type="radio" name="r_tipe" id="r_tipe2" value="Index Competition" />
									Index Competition
								</label>
                                <label class="radio">
									<input type="radio" name="r_tipe" id="r_tipe3" value="6R6S" />
									6R6S
								</label>
								<span id="weekInput" style="display:none">
									<label class="radio inline">
										Week : <input type="text" class="input-mini" name="week" id="week" />
									</label>
								</span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="nik">Filename :</label>
							<div class="controls">
								<input style="float:left" type="file" name="asd" id="file" />
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<button id="submit" class="btn btn-primary" type="submit" name="submit" data-loading-text='Loading...' autocomplete='off'>Submit</button>
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</body>
</html>