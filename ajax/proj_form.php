<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once ("inc/init.php");
/*
	$dbh = new PDO ('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPass);
	$dbh->exec('SET CHARACTER SET utf8');
	$stmt = $dbh->query('SELECT id, name_clients FROM accounts_list');
*/

	require_once("..//libs/get_clients_list.php");
?>

<div class="row">
	<div class="col-xs-5 col-sm-3 col-md-2 col-lg-2">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-cogs"></i> Новый проект </h1>
	</div>
</div>

<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
		<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-101" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<h2><strong><i class="fa fa-check-square-o"></i></strong> <i>Новый проект (входные данные):</i></h2>
				</header>
				<div>
					<div class="widget-body">
					<!--Body widget start-->
					<form id="main-form" class="form-horizontal">
						<!---->
						<fieldset>
							<legend>#1 Общие пункты</legend>
						</fieldset>

						<div class="form-group">
							<label class="col-md-2 control-label">Название проекта</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="title-obj" placeholder="Название проекта" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Договор</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="contract-obj" placeholder="Договор" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Общая стоимость</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="ttlpay-obj" placeholder="Общая стоимость" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Оплаченно</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="pay-obj"  placeholder="Оплаченно" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Коментарий</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="comm-obj" placeholder="Коментарий" >
							</div>
						</div>
<!---->
						<div class="form-group">
							<label class="col-md-2 control-label">Даты</label>
							<div class="col-md-2">
								<input type="date" class="form-control" id="start-obj" >
							</div>
							<div class="col-md-2">
								<input type="date" class="form-control" id="end-obj" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Подрядчик</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="contractor-obj" placeholder="Подрядчик" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Клинет</label>
							<div class="col-md-10">
								<input type="text" class="form-control" list="accounts" id="clients-obj" placeholder="Клинет" >
										<datalist id="accounts">
											<option></option>
											<?php
												while ($row = $stmt->fetch()){
													echo("<option>".$row['name_clients']." (".$row['id'].")</option>");
												}
											?>
										</datalist>
							</div>
						</div>
<!---->
						<!---->
						<fieldset>
							<legend>#2 Адрес</legend>
						</fieldset>

						<div class="form-group">
							<label class="col-md-2 control-label">Город</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="sity-obj" placeholder="Город" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Улица</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="street-obj" placeholder="Улица" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Строение</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="building-obj" placeholder="Строение" >
							</div>
						</div>

						<!---->
						<fieldset>
							<legend>#3 Материалы</legend>
						</fieldset>

						<div class="form-group">
							<label class="col-md-2 control-label">Группы</label>
							<div class="col-md-4">
								<div id="all_parent"  onclick="doEvent()">
									<p><b><i class="fa fa-bolt"></i> Выбрать все</b></p>
								</div>
								<div id="for_parent0">
								</div>
							</div>
							<div class="col-md-6">
								<div id="material-select">
								</div>
							</div>
						</div>

						<!--материялов-->
						<div class="form-group material-wrap">
						</div>

						<!---->
						<fieldset>
							<legend>#4 Подтверждение</legend>
						</fieldset>

						<div id="button-form" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Создать</div>
					</form>

					<!---->
					<div id="block_proj_new">
						<fieldset>
							<legend>#5 Проект создан</legend>
						</fieldset>
						<div class="col-md-2">
							<p class="proj_new"><i class="fa fa-exclamation"></i> Новый проект создан.</p>
						</div>
					</div>



					<!--Body widget end-->
					</div>
				</div>
			</div>
		</article>
	</div>
</section>


<script>

	// Инициализация
	$( document ).ready(function() {
	    getMaterial();
	});

	// Создание групп
	function getMaterial(){
		$.ajax({
			url: '../libs/lib_material/get_material.php',
			success: function(data){
				creationHTML(data);
			}
		});
	}

	function creationHTML(jData){
		var jObj = JSON.parse(jData);
		var jObjCount = jObj.length;
		for (i = 0; i < jObjCount; i++){
			htmlElemrnt('#for_parent'+jObj[i].parent_group, jObj[i], jObj[i].parent_level_group);
		}
	}

	function htmlElemrnt(divS, objElem, indent){
		$(divS).append('<div class="parent_group" style="margin-left:' + (indent*10) + 'px;" id="for_parent' + objElem.id_group + '"><div class="material_group" onclick="doEvent('+ objElem.id_group +')">' + objElem.name_group + '</div></div>');
	}

	// Событие вызова МАТЕРИАЛА
	function doEvent(id){
		$.ajax({
			url: '../libs/lib_material/get_form_material.php',
			type: 'POST',
			data: {id: id},
			success: function(data){
				data = JSON.parse(data);
				createMaterialForm(data);
			}
		})
	}

	function createMaterialForm(material){
		$('#material-select').html('');
		var count = material.length;
		for(i = 0; i < count; i++){
			//$('#material-select').append('<div><input class="check-material" type="checkbox" value="'+material[i].id_material+'"> <b>'+material[i].name_material+'</b> ('+material[i].size_material+')</div>');
			$('#material-select').append('<div class="btn btn-default btn-material" id=btn-material-'+material[i].id_material+' onclick="addMaterial('+material[i].id_material+', &quot '+material[i].name_material+' &quot, &quot '+material[i].size_material+' &quot, &quot '+material[i].size_type_material+' &quot, '+material[i].amount_material+')"><b>'+material[i].name_material+'</b> ('+material[i].size_material+')</div>');
		}
	}
	// Создание inputa
	function addMaterial(id, title, size, type, amount){
		$('<style>#btn-material-'+id+' { background-color: #a3fff9; }</style>').appendTo('body');
		$('.material-wrap').append('<div class="form-group" id="ipt-material'+id+'"><label class="col-md-2 control-label">'+title+' (<b>'+amount+'</b>; '+size+'; '+type+')</label><div class="col-md-4"><input id="'+id+'" class="material-input  form-control" type="number" class="form-control" placeholder="1" min="1" max="'+amount+'"><div class="del-material" onclick="doDel('+id+')"><i class="fa fa-times"></i></div></div></div>');
	}
	// Удаление inputa
	function doDel(id){
		$('#ipt-material'+id).remove();
	}

	// SUBBMIT
	$('#button-form').click(function(){
		var idInpyt = [];
		$('#main-form :input').each(function(){
			var id = $(this).attr('id');
			console.log(id);
			idInpyt.push(id);
		});

		console.log(idInpyt);

		// static
		var staticData = idInpyt.slice(0, 12);
		var staticCount = staticData.length;
		var staticObj = {};
		for(i = 0; i < staticCount; i++){
			staticObj[staticData[i]] = $('#'+staticData[i]).val();
		}
		staticObj = JSON.stringify(staticObj);

		// material
		var materialData = idInpyt.slice(12);
		var materialCount = materialData.length;
		var materialObj = {};
		for(i = 0; i < materialCount; i++){
			materialObj[materialData[i]] = $('#'+materialData[i]).val();
		}
		materialObj = JSON.stringify(materialObj);

		console.log(staticObj);
		console.log(materialObj);

		$.ajax({
			url: '../libs/lib_projects/new_projects.php',
			type: 'POST',
			//dataType: 'JSON',
			dataType: 'TEXT',
			data: {
					data_static: staticObj,
					data_material: materialObj
				},
			success: function(data){
				console.log(data);
				$('#block_proj_new').fadeIn();
				$('#button-form').fadeOut();
			}
		})

		/*
		console.log(idInpyt);
		console.log(staticData);
		console.log(materialData);
		*/
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
	// PAGE RELATED SCRIPTS
	// pagefunction
	var pagefunction = function() {
		// switch style change
		$('input[name="checkbox-style"]').change(function() {
			//alert($(this).val())
			$this = $(this);
			if ($this.attr('value') === "switch-1") {
				$("#switch-1").show();
				$("#switch-2").hide();
			} else if ($this.attr('value') === "switch-2") {
				$("#switch-1").hide();
				$("#switch-2").show();
			}

		});
		// tab - pills toggle
		$('#show-tabs').click(function() {
			$this = $(this);
			if($this.prop('checked')){
				$("#widget-tab-1").removeClass("nav-pills").addClass("nav-tabs");
			} else {
				$("#widget-tab-1").removeClass("nav-tabs").addClass("nav-pills");
			}
		});
	};
	// end pagefunction
	// run pagefunction on load
	pagefunction();
</script>
