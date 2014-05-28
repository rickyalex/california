<?php
session_start();

if(!isset($_SESSION['userid']) || !isset($_SESSION['today']))  {
	unset($_SESSION['today']);
	header('Location: Login.php');
	die;
}

$today = $_SESSION['today'];
$year = substr($today,strlen($today)-4,4);

$title = 'Personal Points - MBOS Personal Point Reward';

include("php/getPersonalPoint.php");
?>


<!DOCTYPE html>
<html lang="en" class="fuelux">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
	<title><?php echo $title; ?></title>
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />
	<!--fuelUX -->
	<script src="lib/fuelux-master/lib/underscore-min.js" type="text/javascript"></script>
	<script src="lib/fuelux-master/sample/datasource.js" type="text/javascript"></script>
	<!-- jquery -->
	<script type="text/javascript" src="jqwidgets-ver2.5.5/scripts/jquery-1.8.2.min.js"></script>
	<!-- bootstrap -->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="lib/fuelux-master/dist/loader.min.js" type="text/javascript"></script>
	
	<script>
	$(function () {
		$('#BrandLink, #ReturnLink').click(function () {
			$('body').data('scrollspy').activate('#controls');
		});
		$('#MySearch').on('searched', function (e, text) {
			alert('Searched: ' + text);
		});
		var sql = "select * from ppr where NIK='<?php echo $_SESSION['id_reference'];?>' order by End_Date";
		//alert(sql);
		$.ajax({  
			type: "POST",  
			url: "php/getHistory.php",  
			data: { 'mySql':sql},
			success: function(val){
				var res = JSON.parse(val);
				//alert(res);
				// INITIALIZING THE DATAGRID
	            var dataSource = new StaticDataSource({
	                columns: [{
	                    property: 'Reg_No',
	                    label: 'Reg No'
	                }, {
	                    property: 'Project_Title',
	                    label: 'Project Title'
					}, {
	                    property: 'Project_Role',
	                    label: 'Role'	
	                }, {
	                    property: 'Start_Date',
	                    label: 'Start Date'
	                }, {
	                    property: 'End_Date',
	                    label: 'End Date'
					}, {
	                    property: 'Point',
	                    label: 'Reward (Point)'
					}, {
	                    property: 'Is_Used',
	                    label: 'Is Used'
					}, {
	                    property: 'Point_Remaining',
	                    label: 'Point Remaining'
	                }],
	                data: res,
	                delay: 250
	            });
				$('#MyGrid').datagrid({
			        dataSource: dataSource
			    });
				},
				error: function(retval){ 
					alert("SQL script gagal");
				} 
			})
	});
	$(function () {
		$('#BrandLink, #ReturnLink').click(function () {
			$('body').data('scrollspy').activate('#controls');
		});
		$('#MySearch').on('searched', function (e, text) {
			alert('Searched: ' + text);
		});
		var table = "point";
		var sql = "select * from "+table+" where NIK='<?php echo $_SESSION['id_reference'];?>' order by insert_date desc";
		//var sql = "select * from npPoint where NIK='<?php echo $_SESSION['id_reference'];?>' order by start_date desc";
		//alert(sql);
		$.ajax({  
			type: "POST",  
			url: "php/getNPPoint.php",  
			data: { 'mySql':sql},
			success: function(val){
				var res = JSON.parse(val);
				//alert(res);
				// INITIALIZING THE DATAGRID
				var dataSource2 = new StaticDataSource({
	                columns: [{
	                    property: 'point',
	                    label: 'Inserted Point'
					}, {
	                    property: 'remarks',
	                    label: 'Remarks'	
	                }, {
	                    property: 'insert_date',
	                    label: 'Date'	
	                }, {
	                    property: 'is_used',
	                    label: 'Is Used'
	                }, {
	                    property: 'point_remaining',
	                    label: 'Point Remaining'
					}, {
	                    property: 'point_status',
	                    label: 'Point Status'
					}, {
	                    property: 'status',
	                    label: 'Approval Status'
					}],
	                data: res,
	                delay: 250
	            });
				$('#MyGrid2').datagrid({
			        dataSource: dataSource2
			    });
				},
				error: function(retval){ 
					alert("SQL script gagal");
				} 
			})
	});
	</script>
</head>
<body>
	<?php include("header.php");?>
	<div class="container">	
		<div class="row-fluid">
			<div style="border:1px solid #c6c6c6;-moz-border-radius:10px;-moz-box-shadow: 2px 2px 5px #888888;margin:0% 2% 5% 2%;padding:0 0 0.8%">
				<h1 class="modal-header">Personal Points</h1>
				<div class="row-fluid">
					<div class="span6">
						<form name="emp_data" class="form-horizontal" type="post">
						<div class="control-group">
							<label class="control-label" for="in_point">ID Employee :</label>
							<div class="controls">
								<input name="in_nik" id="in_nik" class="input-medium" type="text" value="<?php echo $_SESSION['id_reference']; ?>" disabled>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="in_nama">Nama :</label>
							<div class="controls">
								<input name="in_nama" id="in_nama" class="input-xlarge" type="text" value="<?php echo rtrim($_SESSION['first_name'])." ".$_SESSION['middle_name']." ".$_SESSION['last_name']; ?>" disabled>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="in_seksi">Seksi :</label>
							<div class="controls">
								<input name="in_seksi" id="in_seksi" class="input-xlarge" type="text" value="<?php echo $_SESSION['costname']; ?>" disabled>
							</div>
						</div>
						</form>
					</div>
					<div class="span6">
						<form name="!" class="form-horizontal" action="#" type="post"> 
						<div class="control-group">
							<label class="control-label" for="in_point">Point yang dimiliki :</label>
							<div class="controls">
								<input name="in_point" id="in_point" class="input-medium" type="text" value="<?php echo $myPoint; ?>" disabled>
							</div>
						</div>
						</form>
					</div>
				</div>
				<div id="resdiv" style="padding:1%">
				<?php /*<div class="tabbable"> <!-- Only required for left/right tabs -->
					 <ul class="nav nav-tabs">
					   <li class="active"><a href="#tab1" data-toggle="tab">Project Based</a></li>
					   <li><a href="#tab2" data-toggle="tab">Non-Project Based</a></li>
					</ul>*/ ?>
					   <div class="tab-content">
							<?php /*<div class="tab-pane active" id="tab1">
								<table id="MyGrid" class="table table-bordered datagrid">
								<thead>
								<tr>
								<th>
								    <span class="datagrid-header-title">Project Based Points</span>
								    <div class="datagrid-header-left"></div>
								    <div class="datagrid-header-right">
								        <div class="input-append search">
								            <input type="text" class="input-medium" placeholder="Search">
								            <button class="btn"><i class="icon-search"></i></button>
								        </div>
								   </div>
								</th>
								</tr>
								</thead>
								  
								<tfoot>
								<tr>
								<th>
								   <div class="datagrid-footer-left" style="display:none;">
								    <div class="grid-controls">
								        <span><span class="grid-start"></span> - <span class="grid-end"></span> of
								        <span class="grid-count"></span></span>
								        <select class="grid-pagesize">
								            <option>10</option>
								            <option>20</option>
								            <option>50</option>
								            <option>100</option>
								        </select>
								        <span>Per Page</span>
								    </div>
								   </div>
								   <div class="datagrid-footer-right" style="display:none;">
								    <div class="grid-pager">
								        <button class="btn grid-prevpage">
								            <i class="icon-chevron-left"></i>
								        </button>
								        <span>Page</span>
								        <div class="input-append dropdown combobox">
								            <input class="span1" type="text">
								        </div>
								        <span>of <span class="grid-pages"></span></span>
								        <button class="btn grid-nextpage">
								            <i class="icon-chevron-right"></i>
								        </button>
								    </div>
								   </div>
								</th>
								</tr>
								</tfoot>
								</table>
							</div>*/ ?>
							<?php //<div class="tab-pane fade" id="tab2"> ?>
								<table id="MyGrid2" class="table table-bordered datagrid">
								<thead>
								<tr>
								<th>
								    <span class="datagrid-header-title">Point History</span>
								    <div class="datagrid-header-left"></div>
								    <div class="datagrid-header-right">
								        <div class="input-append search">
								            <input type="text" class="input-medium" placeholder="Search">
								            <button class="btn"><i class="icon-search"></i></button>
								        </div>
								   </div>
								</th>
								</tr>
								</thead>
								  
								<tfoot>
								<tr>
								<th>
								   <div class="datagrid-footer-left" style="display:none;">
								    <div class="grid-controls">
								        <span><span class="grid-start"></span> - <span class="grid-end"></span> of
								        <span class="grid-count"></span></span>
								        <select class="grid-pagesize">
								            <option>10</option>
								            <option>20</option>
								            <option>50</option>
								            <option>100</option>
								        </select>
								        <span>Per Page</span>
								    </div>
								   </div>
								   <div class="datagrid-footer-right" style="display:none;">
								    <div class="grid-pager">
								        <button class="btn grid-prevpage">
								            <i class="icon-chevron-left"></i>
								        </button>
								        <span>Page</span>
								        <div class="input-append dropdown combobox">
								            <input class="span1" type="text">
								        </div>
								        <span>of <span class="grid-pages"></span></span>
								        <button class="btn grid-nextpage">
								            <i class="icon-chevron-right"></i>
								        </button>
								    </div>
								   </div>
								</th>
								</tr>
								</tfoot>
								</table>
							<?php //</div> ?>
					  </div>
				</div>
					
				</div>
			</div>
		</div>
	</div>
</body>
</html>