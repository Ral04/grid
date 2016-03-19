<?
header('Content-Type: text/html; charset=utf-8');
require_once("inc/init.php");
require_once ("../lib_reports/dbdata.php");
require_once ("../lib_reports/tasks_db.php");
$query = "SELECT tasks.id,
                 tasks.type_tasks, 
                 tasks.comm_type_tasks, 
                 tasks.price_tasks, 
                 tasks.statust_tasks, 
                 tasks.start_date_tasks, 
                 tasks.end_date_tasks, 
                 executors.name_executors,
                 managers.name_managers,
                 clients.name_clients
                        FROM tasks, executors, managers, clients
                        WHERE tasks.id_executots = executors.id 
                          AND tasks.id_managers = managers.id 
                          AND tasks.id_clients = clients.id";
$result = mysql_query($query) or die(mysql_error());
?>

<script>
var date_design = new Date();
var month_design = ( '0' + (date_design.getMonth()+1) ).slice( -2 );
var year_design = date_design.getFullYear();
var next_month_design = ( '0' + (date_design.getMonth()+1) ).slice( -2 );
next_month_design = next_month_design * 1 + 1;
next_month_design = ( '0' + (next_month_design) ).slice( -2 );

$( document ).ready(function() {
   $('#date_now').val(year_design+'-'+month_design+'-01');
   	//console.log(next_month_design);
	if(next_month_design > 12){
		$('#date_now_end').val((year_design*1+1)+'-'+01+'-01');
		//console.log((year_design*1+1)+'-'+01+'-01');
	}else{
		$('#date_now_end').val(year_design+'-'+next_month_design+'-01');
		//console.log(year_design+'-'+next_month_design+'-01');
	}
});


</script>

<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-bar-chart-o"></i> Отчеты <span>> Отчеты по исполнителям </span></h1>
	</div>
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

	</div>
</div>
<!-- widget grid -->
<p>Параметры фильтра:</p>


<form method="post" action="" id="aform">
	<select  multipletype="text" name="r_executors" value="" placeholder="Исполнитель" style="height: 38px;">
    	<option value="">Все</option>
    	<option value="Гераскин Максим Андреевич">Гераскин Максим Андреевич</option>
    	<option value="Четверик Эдуард Николаевич">Четверик Эдуард Николаевич</option>
    	<option value="Мамедов Теймур Илгамович">Мамедов Теймур Илгамович</option>
	</select>
    <input type="date" id="date_now" name="start_date" value="" />
    <input type="date" id="date_now_end" name="end_date" value="" />
    <input type="button" value="Go" onclick="AjaxFormRequest()" id="clickme" class="btn btn-primary" />
</form>
<br>
<div class="col-md-1">
	<!--<a href="/exel/" style="font-size: 27px;"><i class="fa fa-download"></i> <i class="fa fa-file-excel-o"></i></a>-->
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Выгрузить в Exel <i class="fa fa-file-excel-o"></i></button>


</div>

<br>

<div id="dead-table">
	<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
	    <thead>
			<tr>
				<th data-hide="phone">Исполнители</th>
				<th data-hide="phone">Стоимость</th>
				<th data-hide="phone">Клиент</th>
				<th data-hide="phone">Задача</th>
				<th data-hide="phone,tablet">Начало задачи</th>
				<th data-hide="phone,tablet">Завершение задачи</th>
			</tr>
	    </thead>
		<tbody>
			<?
			while ($row = mysql_fetch_array($result)){
                $startDate = date("d-m-Y", strtotime($row['start_date_tasks']));
                $endtDate = date("d-m-Y", strtotime($row['end_date_tasks']));

				print "<tr><td>".$row['name_executors']."</td>";
				print "<td>".$row['price_tasks']."</td>";
				print "<td>".$row['name_clients']."</td>";
				print "<td>".$row['type_tasks']."</td>";
				print "<td>".$startDate."</td>";
				print "<td>".$endtDate."</td></tr>";
				$total_prise += ($row['price_tasks']);
				};
			?>

		</tbody>	
	</table>
	<br>
	<div>
		<table style="width: 30%;" class="table table-striped table-bordered">
			<tr>
				<td style="text-align: right;"><b>Итого:</b></td>
				<td><b><?print$total_prise;?></b></td>
			</tr>
		</table>
	</div>		
</div>
<div id="result"></div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Формирование отчета в Exel</h4>
      </div>
      <div class="modal-body">
        <!--Modal body start-->
        <form class="form-inline" action="/exel/index.php" method="POST">
        	<div>
        		<label>Выберете сотрудников</label><br>
        		<select class="form-control" name="exe">
	  				<option value="all">Все дизайнеры</option>
  					<option value="1">Гераскин Максим Андреевич</option>
  					<option value="2">Четверик Эдуард Николаевич</option>
  					<option value="3">Мамедов Теймур Илгамович</option>
  					<option value="4">Созинов Сергей Сергеевич</option>
				</select>
			</div>
			<hr>
			<div class="form-group">
				<label>c</label>
				<input type="date" class="form-control" name="date_star">
			</div>
			<div class="form-group">
				<label>до</label>
				<input type="date" class="form-control" name="date_end">
			</div>
			<br><hr>
			<input type="submit" value="Создать" class="btn btn-success">

        </form>
        <!--Modal body end-->
      </div>
    </div>
  </div>
</div>





<script>
	function AjaxFormRequest() {
        jQuery.ajax({
            url:      "http://grid.bilbordtv.ru/lib_reports/executors_form.php", //Адрес подгружаемой страницы
            type:     "POST", //Тип запроса
            dataType: "html", //Тип данных
	        data: jQuery("#" + "aform").serialize(), 
            success: function(response) { //Если все нормально
            document.getElementById("result").innerHTML = response;
            },
            error: function(response) { //Если ошибка
            document.getElementById("result").innerHTML = "Error sent form";
            },
        });
	}


    $( "#clickme" ).click(function() {
		$( "#dead-table" ).detach();
		
	});
</script>

<script type="text/javascript">

	/* DO NOT REMOVE : GLOBAL FUNCTIONS!
	 *
	 * pageSetUp(); WILL CALL THE FOLLOWING FUNCTIONS
	 *
	 * // activate tooltips
	 * $("[rel=tooltip]").tooltip();
	 *
	 * // activate popovers
	 * $("[rel=popover]").popover();
	 *
	 * // activate popovers with hover states
	 * $("[rel=popover-hover]").popover({ trigger: "hover" });
	 *
	 * // activate inline charts
	 * runAllCharts();
	 *
	 * // setup widgets
	 * setup_widgets_desktop();
	 *
	 * // run form elements
	 * runAllForms();
	 *
	 ********************************
	 *
	 * pageSetUp() is needed whenever you load a page.
	 * It initializes and checks for all basic elements of the page
	 * and makes rendering easier.
	 *
	 */

	pageSetUp();
	
	/*
	 * ALL PAGE RELATED SCRIPTS CAN GO BELOW HERE
	 * eg alert("my home function");
	 * 
	 * var pagefunction = function() {
	 *   ...
	 * }
	 * loadScript("js/plugin/_PLUGIN_NAME_.js", pagefunction);
	 * 
	 */
	
	// PAGE RELATED SCRIPTS
	
	// pagefunction	

	var pagefunction = function() {
		//console.log("cleared");
		
		/* // DOM Position key index //
		
			l - Length changing (dropdown)
			f - Filtering input (search)
			t - The Table! (datatable)
			i - Information (records)
			p - Pagination (paging)
			r - pRocessing 
			< and > - div elements
			<"#id" and > - div with an id
			<"class" and > - div with a class
			<"#id.class" and > - div with an id and class
			
			Also see: http://legacy.datatables.net/usage/features
		*/	

		/* BASIC ;*/
			var responsiveHelper_dt_basic = undefined;
			var responsiveHelper_datatable_fixed_column = undefined;
			var responsiveHelper_datatable_col_reorder = undefined;
			var responsiveHelper_datatable_tabletools = undefined;
			
			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};

		
			$('#dt_basic').dataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_dt_basic.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_dt_basic.respond();
				}
			});

			
		/* END BASIC */
		
		/* COLUMN FILTER  */
	    var otable = $('#datatable_fixed_column').DataTable({
	    	//"bFilter": false,
	    	//"bInfo": false,
	    	//"bLengthChange": false
	    	//"bAutoWidth": false,
	    	//"bPaginate": false,
	    	//"bStateSave": true // saves sort state using localStorage
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_fixed_column) {
					responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_fixed_column.respond();
			}		
		
	    });
	    
	    // custom toolbar
	    $("div.toolbar").html('<div class="text-right"><img src="img/logo.png" alt="SmartAdmin" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');
	    	   
	    // Apply the filter
	    $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {
	    	
	        otable
	            .column( $(this).parent().index()+':visible' )
	            .search( this.value )
	            .draw();
	            
	    } );
	    /* END COLUMN FILTER */   
    
		/* COLUMN SHOW - HIDE */
		$('#datatable_col_reorder').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_col_reorder) {
					responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_col_reorder.respond();
			}			
		});
		
		/* END COLUMN SHOW - HIDE */

		/* TABLETOOLS */
		$('#datatable_tabletools').dataTable({
			
			// Tabletools options: 
			//   https://datatables.net/extensions/tabletools/button_options
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
	        "oTableTools": {
	        	 "aButtons": [
	             "copy",
	             "csv",
	             "xls",
	                {
	                    "sExtends": "pdf",
	                    "sTitle": "SmartAdmin_PDF",
	                    "sPdfMessage": "SmartAdmin PDF Export",
	                    "sPdfSize": "letter"
	                },
	             	{
                    	"sExtends": "print",
                    	"sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                	}
	             ],
	            "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
	        },
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_tabletools) {
					responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_tabletools.respond();
			}
		});
		
		/* END TABLETOOLS */

	};

	// load related plugins
	
	loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
		loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
			loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
				loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
					loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
				});
			});
		});
	});


</script>
