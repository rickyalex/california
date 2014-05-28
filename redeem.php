<?php
session_start();

if(!isset($_SESSION['userid']) || !isset($_SESSION['today']))  {
	unset($_SESSION['today']);
	header('Location: Login.php');
	die;
}

$title = 'Redeem Request - MBOS Personal Point Reward';

include("php/getPersonalPoint.php");
?>


<!DOCTYPE html>
<html lang="en" class="fuelux">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
    <meta charset="UTF-8">
	<title><?php echo $title; ?></title>
	<script src="lib/fuelux-master/lib/underscore-min.js" type="text/javascript"></script>
	<script src="lib/fuelux-master/sample/datasource.js" type="text/javascript"></script>
    

	<link rel="stylesheet" href="lib/jqwidgets-ver2.5.5/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/scripts/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/jqwidgets/jqxdata.js"></script>

    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/jqwidgets/jqxgrid.columnsresize.js"></script>

    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/jqwidgets/jqxdropdownbutton.js"></script>
    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="lib/jqwidgets-ver2.5.5/jqwidgets/jqxdropdownlist.js"></script>   
    
    <script type="text/javascript" src="js/generatedata.js"></script>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	
	<script src="lib/fuelux-master/dist/loader.min.js" type="text/javascript"></script>
	<script>
		$(document).ready(function () {
			
			var lv = <?php echo $_SESSION['level'];?>;
			//alert(lv);
			document.getElementById('in_sisa').value=document.getElementById('in_point').value;
			
            var theme = "";
			var tipe = 'barang';
			
			// prepare the data
		            var data = generatedata(12);

		            var source =
		            {
		                localdata: data,
		                datatype: "array",
		                updaterow: function (rowid, rowdata) {
		                    // synchronize with the server - send update command   
		                }
		            };

		            var dataAdapter = new $.jqx.dataAdapter(source);

		            // initialize jqxGrid
		            $("#jqxdropdownbutton").jqxDropDownButton({ width: 270, height: 25, theme: theme });
					if(lv<8){
			            $("#jqxgrid").jqxGrid(
				            {
				                width: 600,
				                source: dataAdapter,
				                theme: theme,
				                pageable: false,
				                autoheight: true,
				                columnsresize: true,
				                columns: [
				                  { text: 'Jenis Barang', columntype: 'textbox', datafield: 'barang_lt8', width: 540 },
				                  { text: 'Point', datafield: 'point_lt8', width: 60, cellsalign: 'right' }
				                ]
				            });
					}
					else{
						$("#jqxgrid").jqxGrid(
			            {
			                width: 600,
			                source: dataAdapter,
			                theme: theme,
			                pageable: false,
			                autoheight: true,
			                columnsresize: true,
			                columns: [
			                  { text: 'Jenis Barang', columntype: 'textbox', datafield: 'barang_gte8', width: 540 },
			                  { text: 'Point', datafield: 'point_gte8', width: 60, cellsalign: 'right' }
			                ]
			            });
					}

			$(":radio[name='r_tipe']").change(function(){
				if($(":radio[id='r_tipe1']").is(':checked')){
					tipe = 'barang';
					// prepare the data
		            var data = generatedata(12);

		            var source =
		            {
		                localdata: data,
		                datatype: "array",
		                updaterow: function (rowid, rowdata) {
		                    // synchronize with the server - send update command   
		                }
		            };

		            var dataAdapter = new $.jqx.dataAdapter(source);

		            // initialize jqxGrid
		            $("#jqxdropdownbutton").jqxDropDownButton({ width: 270, height: 25, theme: theme });
					$("#jqxgrid").jqxGrid('clear');
					$("#jqxgrid").jqxGrid('render');
					$("#jqxgrid").jqxGrid('refreshdata');
					$("#jqxgrid").jqxGrid('refresh');
					if(lv<8){
			            $("#jqxgrid").jqxGrid(
				            {
				                width: 600,
				                source: dataAdapter,
				                theme: theme,
				                pageable: false,
				                autoheight: true,
				                columnsresize: true,
				                columns: [
				                  { text: 'Jenis Barang', datafield: 'barang_lt8', width: 540 },
				                  { text: 'Point', datafield: 'point_lt8', width: 60, cellsalign: 'right' }
				                ]
				            });
					}
					else{
						$("#jqxgrid").jqxGrid(
			            {
			                width: 600,
			                source: dataAdapter,
			                theme: theme,
			                pageable: false,
			                autoheight: true,
			                columnsresize: true,
			                columns: [
			                  { text: 'Jenis Barang', datafield: 'barang_gte8', width: 540 },
			                  { text: 'Point', datafield: 'point_gte8', width: 60, cellsalign: 'right' }
			                ]
			            });
					}
				}
				else{
					tipe = 'cash';
					// prepare the data
		            var data = generatedata(12);

		            var source =
		            {
		                localdata: data,
		                datatype: "array",
		                updaterow: function (rowid, rowdata) {
		                    // synchronize with the server - send update command   
		                }
		            };

		            var dataAdapter = new $.jqx.dataAdapter(source);

		            // initialize jqxGrid
		            $("#jqxdropdownbutton").jqxDropDownButton({ width: 270, height: 25, theme: theme });
					$("#jqxgrid").jqxGrid('clear');
					$("#jqxgrid").jqxGrid('render');
					$("#jqxgrid").jqxGrid('refreshdata');
					$("#jqxgrid").jqxGrid('refresh');
					if(lv<8){
			            $("#jqxgrid").jqxGrid(
				            {
				                width: 210,
				                source: dataAdapter,
				                theme: theme,
				                pageable: false,
				                autoheight: true,
				                columnsresize: true,
				                columns: [
				                  { text: 'Cash', datafield: 'cash_lt8', width: 150, cellsalign: 'right' },
				                  { text: 'Point', datafield: 'point_lt8', width: 60, cellsalign: 'right' }
				                ]
				            });
					}
					else{
						$("#jqxgrid").jqxGrid(
			            {
			                width: 210,
			                source: dataAdapter,
			                theme: theme,
			                pageable: false,
			                autoheight: true,
			                columnsresize: true,
			                columns: [
			                  { text: 'Cash', datafield: 'cash_gte8', width: 150, cellsalign: 'right' },
			                  { text: 'Point', datafield: 'point_gte8', width: 60, cellsalign: 'right' }
			                ]
			            });
					}
				}
			});
			
				$("#jqxgrid").on('rowclick', function (event) {
					var args = event.args;
		            var row = $("#jqxgrid").jqxGrid('getrowdata', args.rowindex);
					
					if (tipe=='cash')
						var content = row['cash_lt8'];
					else if (tipe=='barang')
						var content = row['barang_lt8'];
						
					if(lv<8){
						var dropDownContent = '<div style="position: relative; margin-left: 3px; margin-top: 3px;">' + content + '</div>';
						$("#jqxdropdownbutton").jqxDropDownButton('setContent', dropDownContent);
					}
					else{
						var dropDownContent = '<div style="position: relative; margin-left: 3px; margin-top: 3px;">' + content + '</div>';
			            $("#jqxdropdownbutton").jqxDropDownButton('setContent', dropDownContent);
					}
					//alert(args.rowindex);
					
					if(args.rowindex != -1){
							if(lv<8){
								document.getElementById('in_terpakai').value=$('#jqxgrid').jqxGrid('getcellvalue',args.rowindex,'point_lt8');
							}
							else{
								document.getElementById('in_terpakai').value=$('#jqxgrid').jqxGrid('getcellvalue',args.rowindex,'point_gte8');
							}
							//$('#jqxgrid').jqxGrid('selectrow', args.rowindex);
							var trp = document.getElementById('in_terpakai').value;
							var pnt = document.getElementById('in_point').value;
							var tot = pnt - trp;
							if(tot<0){
								document.getElementById('in_point').style.background='#FF9999';
								document.getElementById('in_point').style.color='#FFF';
								$('#submit').attr("disabled","disabled");
								alert('Point anda tidak mencukupi');
								location.reload();
							}
							else{
								document.getElementById('in_point').style.background='#CCFF66';
								document.getElementById('in_terpakai').style.background='#FFD699';
								document.getElementById('in_sisa').style.background='#CCFF66';
								document.getElementById('in_sisa').value=tot;
							}
							//alert(pnt-trp);
					}
	            });

            
        });
		
		function myConfirm(){
			var arr = [];
			var lv = <?php echo $_SESSION['level'];?>;
			var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
			//alert(rowindex);
			if(rowindex > -1){
				var x;
				arr[0] = $("#in_nama").val();
				arr[1] = $("#in_terpakai").val();
				arr[2] = $("#in_point").val();
				//var itemName = document.getElementById('items').options[document.getElementById('items').selectedIndex].text;
				if(lv<8){
					arr[3] = $('#jqxgrid').jqxGrid('getcellvalue',rowindex,'barang_lt8');
				}
				else{
					arr[3] = $('#jqxgrid').jqxGrid('getcellvalue',rowindex,'barang_gte8');
				}
				//alert(itemName);
				var r=confirm("Point yang terpakai tidak dapat dikembalikan. Lanjutkan Redeem ?");
				if(r==true){
				    $('#submit').attr("disabled","disabled");
                    $('#clear').attr("disabled","disabled");
					document.getElementById('in_point').style.background='';
					document.getElementById('in_terpakai').style.background='';
					document.getElementById('in_sisa').style.background='';
					//var pnt = document.getElementById('in_point').value;
					//var trp = document.getElementById('in_terpakai').value;
					//var tot = pnt - trp;
					//pnt = tot;
					//trp =0;
					arr[4] = '<?php echo trim($_SESSION['today2']); ?>';
					arr[5] = '<?php echo trim($_SESSION['id_reference']); ?>';
					data = arr;
					//alert(sql);
					$.ajax({
						async: false,
						type: "POST",  
						url: "php/redeemQuery.php",  
						data: {'data':data},
						success: function(val){ 
							var result = eval('(' + val + ')');
							if(result.success==true) alert(result.message);
							location.reload();
						},
						error: function(err){
							var result = eval('(' + err + ')');
                            if(result.success==false) alert(result.message);
							//alert(result.failed);
							location.reload();
						} 
					})
				}
				else{
					return false;
				}
				//document.getElementById("demo").innerHTML=x;
			}
			else{
				alert("Silahkan pilih jenis barang");
				return false;
			}
		}
		function myClear(){
			var trp = document.getElementById('in_terpakai').value =0;
			var pnt = document.getElementById('in_point').value;
			var tot = pnt - trp;
			$("#jqxgrid").jqxGrid('clearselection');
			var dropDownContent = '<div style="position: relative; margin-left: 3px; margin-top: 3px;"></div>';
			$("#jqxdropdownbutton").jqxDropDownButton('setContent', dropDownContent);
			document.getElementById('in_sisa').value = tot;
			document.getElementById('in_point').style.background='';
			document.getElementById('in_point').style.color='';
			document.getElementById('in_terpakai').style.background='';
			document.getElementById('in_sisa').style.background='';
		}
		
		$(function () {
			$('#BrandLink, #ReturnLink').click(function () {
				$('body').data('scrollspy').activate('#controls');
			});
			$('#MySearch').on('searched', function (e, text) {
				alert('Searched: ' + text);
			});
			//var table = "test_redeem";
			var table = "redeem";
			var sql = "select * from "+table+" where NIK='<?php echo trim($_SESSION['id_reference']);?>' order by ID_Redeem DESC";
			//alert(sql);
			$.ajax({  
				type: "POST",  
				url: "php/getRedeem.php",
				data: { 'mySql':sql},
				success: function(val){
					var res = JSON.parse(val);
					//alert(res);
					// INITIALIZING THE DATAGRID
		            var dataSource = new StaticDataSource({
		                columns: [{
		                    property: 'ID_Redeem',
		                    label: 'ID Redeem'
		                }, {
		                    property: 'Redeem_Date',
		                    label: 'Redeem Date'
		                }, {
		                    property: 'Item_Type',
		                    label: 'Item Type'
		                }, {
		                    property: 'Status',
		                    label: 'Status'
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

	</script>
</head>
<body>
	<?php include("header.php");?>
	<div class="container" style="margin-bottom:5%">
		<div class="row-fluid">
			<div style="border:1px solid #c6c6c6;-moz-border-radius:10px;-moz-box-shadow: 2px 2px 5px #888888;margin:0% 2% 0% 2%;padding:0 0 0.8%">
				<h1 class="modal-header">Redeem Request</h1>
				<div class="row-fluid">
					<div class="span6">
					
					<form name="request" class="form-horizontal" type="post">
						<div class="control-group">
							<label class="control-label" for="in_nik">ID Employee :</label>
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
						<div class="control-group">
							<label class="control-label" for="r_tipe">Tipe Redeem :</label>
							<div class="controls">
							<label class="radio inline">
								<input type="radio" name="r_tipe" id="r_tipe1" value="option1" checked>
								Barang
							</label>
							<label class="radio inline">
								<input type="radio" name="r_tipe" id="r_tipe2" value="option2">
								Uang Cash
							</label>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="in_nama">Jenis Barang :</label>
							<div class="controls">
								<div id='jqxWidget'>
									<div id="jqxdropdownbutton">
										<div id="jqxgrid">
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</form>
					</div>
					<div class="span6">
					<form name="request2" class="form-horizontal" type="post">
						<div class="control-group">
							<label class="control-label" for="in_point">Point yang dimiliki :</label>
							<div class="controls">
								<input name="in_point" id="in_point" class="input-medium" type="text" value="<?php echo $myPoint; ?>" disabled>
							</div>
						</div>
						<br><br><br><br><br>
						<div class="control-group">
							<label class="control-label" for="in_terpakai">Point Terpakai :</label>
							<div class="controls">
								<input name="in_terpakai" id="in_terpakai" class="input-medium" type="text" value="0" disabled>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="in_sisa">Sisa Point :</label>
							<div class="controls">
								<input name="in_sisa" id="in_sisa" class="input-medium" type="text" value="0" disabled>
							</div>
						</div>	
					</form>
					</div>
				<div class="offset7">
					<button id="submit"  class="btn btn-primary" type="button" name="submit" onclick="javascript:myConfirm();">Submit</button>
					<button id="clear" class="btn" type="button" name="clear" onclick="javascript:myClear();">Clear</button>
					<button id="cancel"  class="btn" type="button" name="cancel" onclick="javascript:history.back();">Cancel</button>	
				</div>
			</div>
			<div id="resdiv" style="padding:1%;border:1px solid #c6c6c6;-moz-border-radius:10px;margin:1% 2% 3% 2%">
				<div id="result_frame">
					<table id="MyGrid" class="table table-bordered datagrid">
					<thead>
					<tr>
					<th>
					    <span class="datagrid-header-title">Redeem History</span>
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
				</div>
			</div>
		</div>
	</div>
</body>
</html>