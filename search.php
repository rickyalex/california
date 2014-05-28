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

$today = $_SESSION['today'];
$year = substr($today,strlen($today)-4,4);

$title = 'Search - MBOS Personal Point Reward';
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
	<script type="text/javascript" src="lib/jqwidgets-ver2.5.5/scripts/jquery-1.8.2.min.js"></script>
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
			var sql = "select * from ppr order by end_date desc";
			//alert(sql);
			$.ajax({  
				type: "POST",  
				url: "php/getProject.php",  
				data: { 'mySql':sql},
				success: function(val){
					var res = JSON.parse(val);
					//alert(res);
					// INITIALIZING THE DATAGRID
		            var dataSource = new StaticDataSource({
		                columns: [{
		                    property: 'reg_no',
		                    label: 'Project ID'
		                }, {
		                    property: 'project_title',
		                    label: 'Project Title'
						}, {
		                    property: 'name',
		                    label: 'Name'	
		                }, {
		                    property: 'nik',
		                    label: 'NIK'	
		                }, {
		                    property: 'project_role',
		                    label: 'Project Role'
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
			// var sql = "select tmp.name, tmp.nik, tmp.department, tmp.division, "+
					  // "np = ( select sum(convert(int, b.point_remaining)) from npPoint as b "+
					  // "where b.point_status='active' and b.nik = tmp.nik )from "+
					  // "((select name, nik, department, division, point_remaining from ppr where nik!='') "+
					  // "union "+
					  // "(select name, nik, department, division, point_remaining from nppoint where nik!='')) as tmp";
			// var sql = "select distinct tmp.name, tmp.nik, tmp.department, tmp.division, "+
					  // "np = ( select isnull (sum(convert(int, b.point_remaining)),'0') from npPoint as b "+
					  // "where b.point_status = 'active' and b.nik = tmp.nik) from "+
					  // "((select name, nik, department, division, point_remaining from ppr where nik!='') "+
					  // "union "+
					  // "(select name, nik, department, division, point_remaining from nppoint where nik!='')) as tmp";
			var id = "<?php echo $_SESSION['userid']; ?>";
            //alert(sql);
			$.ajax({  
				type: "POST",  
				url: "php/getUserInfo.php",  
				data: { 'id':id},
				success: function(val){
					var res = JSON.parse(val);
					//alert(res);
					// INITIALIZING THE DATAGRID
		            var dataSource = new StaticDataSource({
		                columns: [{
		                    property: 'name',
		                    label: 'Name'
		                }, {
		                    property: 'nik',
		                    label: 'NIK'
						}, {
		                    property: 'division',
		                    label: 'Division'	
		                }, {
		                    property: 'department',
		                    label: 'Department'
		                }, {
		                    property: 'point_remaining',
		                    label: 'Points Remaining'
						}],
		                data: res,
		                delay: 250
		            });
					$('#MyGrid2').datagrid({
				        dataSource: dataSource
				    });
				},
				error: function(retval){ 
					alert("SQL script gagal");
				} 
			})
		});
		function approve(reg_no){
			var mode = reg_no.substring(0,1);
			var regNo = reg_no.substring(1);
			//alert(regNo);
			if (mode=="R"){
				var sql = "update redeem set status='a', last_update='<?php echo date('d-m-Y H:i:s'); ?>', approved_by='<?php echo $_SESSION['userid']; ?>' where id_redeem='"+regNo+"'";
			}
			else if (mode=="P"){
				var sql = "update npPoint set status='a', point_status='Active', last_update='<?php echo date('d-m-Y H:i:s'); ?>', approved_by='<?php echo $_SESSION['userid']; ?>' where id_ins='"+regNo+"'";
			}
			$.ajax({  
				type: "POST",  
				url: "php/updateApproval.php",  
				data: { 'mySql':sql},
				success: function(val){
						location.reload();
					},
					error: function(retval){ 
						alert("SQL script gagal");
					} 
				})
		}
		function remove(reg_no){
			var mode = reg_no.substring(0,1);
			var regNo = reg_no.substring(1);
			//alert(regNo);
			if (mode=="R"){
				var sql = "delete from redeem where id_redeem='"+regNo+"'";
			}
			else if (mode=="P"){
				var sql = "delete from npPoint where id_ins='"+regNo+"'";
			}
			$.ajax({  
				type: "POST",  
				url: "php/updateApproval.php",  
				data: { 'mySql':sql},
				success: function(val){
						location.reload();
					},
					error: function(retval){ 
						alert("SQL script gagal");
					} 
				})
		}
		function exportExcel(userid){
			$.ajax({  
				type: "POST",  
				url: "php/exportExcel.php",  
				data: { 'id':userid},
				success: function(val){
						//location.replace(val);
						window.open(val);
					},
					error: function(retval){ 
						alert("SQL script gagal");
					} 
				})
		}
	</script>
</head>
<body>
	<?php include("header.php");?>
	<div class="container">	
		<div class="row-fluid">
			<div style="border:1px solid #c6c6c6;-moz-border-radius:10px;-moz-box-shadow: 2px 2px 5px #888888;margin:0% 2% 0% 2%;padding:0 0 0.8%">
				<h1 class="modal-header">Search</h1>
				<div id="resdiv" style="padding:1%">
				<?php /*<div class="tabbable"> <!-- Only required for left/right tabs -->
					<ul class="nav nav-pills">
					   <li class="active"><a href="#tab1" data-toggle="tab">Project</a></li>
					   <li><a href="#tab2" data-toggle="tab">User Information</a></li>
					</ul>*/ ?>
					   <div class="tab-content">
							<?php /*<div class="tab-pane active" id="tab1">
								<table id="MyGrid" class="table table-bordered datagrid">
								<thead>
								<tr>
								<th>
								    <span class="datagrid-header-title">Project List</span>
								    <div class="datagrid-header-left">	
										<div class="input button">
								            <button id='export' class="btn btn-success" onclick="javascript:exportExcel();">Export to Excel</button>
								        </div>
									</div>
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
								    <span class="datagrid-header-title">User Information</span>
								    <div class="datagrid-header-left">
										<div class="input button">
								            
								                <button id='export2' class='btn btn-success' onclick="exportExcel('<?php echo $_SESSION['userid'] ?>')" >Export to Excel</button>
                                             
								        </div>
									</div>
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