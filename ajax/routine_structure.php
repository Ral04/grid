<?
	header('Content-Type: text/html; charset=utf-8');
	session_start(); //Запускаем сессии
	require_once("inc/init.php");
	require_once("../libs/lib_employees/get_employees_structure.php");

	$arr_name = [];
	$arr_position = [];
	$arr_div_employees = [];

	foreach ($result as $row) {
		array_push($arr_name, $row['employees_full_name']);
		array_push($arr_position, $row['employees_position']);
		array_push($arr_div_employees, $row['employees_division']);
	}	

	$arr_division = array_unique($arr_div_employees);
	
	function get_employees($value, $arr_name, $arr_div_employees){
		$rez = '';
		for($i = 0; $i < count($arr_name); $i++){
			if($value == $arr_div_employees[$i]){
				print('<li><span><i class="icon-leaf"></i>'. $arr_name[$i] .'</span></li>');
			}

		}
		
	}

	function dodivision($arr_division, $arr_name, $arr_div_employees){
		foreach ($arr_division as $value) {
			if($value != "" & $value != "-"){	
				print('<div class="mdl-bloc col-sm-12 col-md-4 col-lg-2"><div class="r-part r-part-mdl"><p>'. $value.'</p><div class="widget-body"><div class="tree smart-form"><ul><li><span><i class="fa fa-lg fa-folder-open"></i>Сотрудники</span><ul>');
				get_employees($value, $arr_name, $arr_div_employees);
				print('</ul></li></ul></div></div></div><div class="l-part l-part-mdl"><p><i class="fa fa-star-half-o"></i></p></div></div>');
			}	
		}
	}
	


?>
<style>
.top-bloc{
	margin: 0 auto;
    width: 300px;
    padding: 10px;
    background: #fff;
    overflow: hidden;
}
.mdl-bloc{
	/*
	float: left;
    width: 300px;
    */
    padding: 10px;
    background: #fff;
    overflow: hidden;
}
.l-part{
	float: right;
    width: 0%;
    color: #F1F1F1;
    height: 100%;
    padding-top: 6px;
    text-align: center;
opacity: 0;
    -webkit-transition: 0.5s;
    -moz-transition: 0.5s;
    -o-transition: 0.5s;
    transition: 0.5s;

}



.r-part{
	float: right; 
	width: 90%;
	border-top: 1px solid;
    border-left: 4px solid;
    border-bottom: 1px solid;
    border-right: 1px solid;
}
.r-part>p{
	text-align: center;
	font-size: 14px;
	border-bottom:1px dashed #3A3633;
	height: 40px;
    padding-top: 10px;
}

.top-bloc:hover .l-part{
	width: 10%;
	opacity: 1;
}
.mdl-bloc:hover .l-part{
	width: 10%;
	opacity: 1;
}

/*top*/

.l-part-top{background-color: #931313; }
.r-part-top{border-color: #931313; min-height: 300px;}
.l-part-mdl{background-color: #727677;}
.r-part-mdl{border-color: #727677;min-height: 300px;}




</style>

<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-sitemap"></i> Распорядок <span>>  Структура Компании </span></h1>
	</div>
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
	</div>
</div>




<!-- widget grid -->
<section id="widget-grid" class="">

	<!-- row -->
	<div class="row">
		<!-- NEW WIDGET START -->
		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blue" id="wid-id-7" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-editbutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-sitemap"></i> </span>
					<h2>Схема компании:</h2>
				</header>
				<!-- widget div-->
				<div style="padding-bottom: 70px;">

					<div class="jarviswidget-editbox">

					</div>



					<div class="top-bloc">
						<div class="r-part r-part-top">
							<p>Билборд ТВ и Широкий формат</p>
							<div class="widget-body">
								<div class="tree smart-form">
									<ul>
										<li>
											<span><i class="fa fa-lg fa-folder-open"></i>Сотрудники</span>
											<ul>
												<li><span><i class="icon-leaf"></i>Константинов Алексей Александрович</span></li>
												<li><span><i class="icon-leaf"></i>Воронцов Илья Константинович</span></li>
												<li><span><i class="icon-leaf"></i>Созинов Сергей Сергеевич</span></li>
											</ul>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="l-part l-part-top">
							<p><i class="fa fa-star"></i></p>
						</div>
					</div>
				
				<?
					dodivision($arr_division, $arr_name, $arr_div_employees);
				?>
				



					
				</div>
			</div>
		</article>




	</div>
	<div class="row">
	</div>

</section>
<!-- end widget grid -->

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

	// PAGE RELATED SCRIPTS
	// pagefunction
	
	var pagefunction = function() {
		
		loadScript("js/plugin/bootstraptree/bootstrap-tree.min.js");

	};
	
	// end pagefunction
	
	// run pagefunction on load

	pagefunction();
	
</script>
