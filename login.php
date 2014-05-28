<?php
session_start();

$url = $_SERVER['PHP_SELF'];

$title = 'Login - MBOS Personal Point Reward';

$stime=getdate(date('U'));	
$year = $stime['year'];
$month = $stime['month'];
$date = $stime['mday'];
$day = $stime['weekday'];
$today = $day." ".$date." ".$month." ".$year;


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<script type="text/javascript" src="easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	
	
	<script>
		function check(){
			if(document.forms['form_login']['userid'].value==null || document.forms['form_login']['password'].value==""){
				alert("Isi Username dan Password");
				return false;
			}
		}
	</script>
</head>
<body>
	<div class="page-header"><div class="img"></div></div>
	
	<div class="container">	
		<div class="row-fluid">
			<div class="span6" style="float:left;border:1px solid #c6c6c6;-moz-border-radius:10px;-moz-box-shadow: 2px 2px 5px #888888;margin:2% 5% 0% 5%;padding:0 0 0.8%">
				<h3 class="modal-header">Top 10 Point Achievements (Lv.1 - 7)</h2>
				<table class="table table-condensed" style="font-size:0.9em">
					<thead>
						<tr><td><b>#</b></td><td><b>Name</b></td><td><b>Division</b></td><td><b>Point</b></td></tr>
					</thead>
					<tbody>
						<?php include('php/getTopTen.php'); ?>
					</tbody>
				</table>
			</div>
			<div class="span4" style="float:right;border:1px solid #c6c6c6;-moz-border-radius:10px;-moz-box-shadow: 2px 2px 5px #888888;margin:2% 7% 0% 2%;padding:0 0 0.8%">
				<h1 class="modal-header">Login</h1>
				<form id="form_login" style="font-family:Tahoma;font-size:0.8em" action="LoginCheck.php" onsubmit="return check()" method="post" enctype="multipart/form-data">
				<div style="padding: 0 0 0 3%">
					<label class="text">Username:
					<input style="margin-left:3%"type="text" name="userid" id="userid" />
					</label>
					<label class="text">Password:
					<input style="margin-left:3.7%"type="password" name="password" id="password" />
					</label>	
					<button id="submit" style="float:right;margin-right:24%"class="btn btn-primary" type="submit" name="submit">Login</button>
				</div>	
			</form>
			</div>
		</div>
	</div>
</body>
</html>