<?
	// objectives_overview
	header('Content-Type: text/html; charset=utf-8');
	session_start(); //Запускаем сессии
	require_once("inc/init.php");
	require_once("..//libs/lib_objective/overviwe_objective.php");
	$date_now = date_create();
	$date_now =  date('d-m-Y', date_timestamp_get($date_now));
?>
<div class="row">
	<div class="col-xs-12 col-sm-5 col-md-10 col-lg-10">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-bar-chart"></i> Задачи обзор. Дата: <span style="font-size: 23px; color: #FF2BB4;"><?=$date_now?></span></h1>
	</div>
	<div class="col-xs-12 col-sm-5 col-md-2 col-lg-2">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Добавить</button>
	</div>
</div>

<div class="well">
<div class="row">
	<div class="col-md-12">
<?
	foreach ($sorted_results as $arr) {
		$start_obj =  minValueInArray($arr, "objective_date_start");
		$end_obj = maxValueInArray($arr, "objective_date_end");
		print("<div class=\"wrap-time\">");
		print("<h3>".$arr[0]['employees_full_name'].": Колличество задач - <b>".count($arr)."</b></h3>");
		create_time_line($start_obj, $end_obj, $arr);
		print("</div>");
	}
?>
	</div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Поставить новую Задачу</h4>
			</div>
			<div class="modal-body">
			<!--form-->
			<form id="add_obj"  action="javascript:void(null);" onsubmit="call()">
				<div class="form-group">
					<label for="obj_form_for">Исполнитель *</label>
					<select class="input form-control" id="obj_form_for" required>
						<option disabled>Выберете исполнителя</option>
					</select>
				</div>
				<div class="form-group" style="display:none;">
					<label for="obj_form_paty">Наблюдатель/помошник</label>
					<select class="input form-control" id="obj_form_paty" >
						<option value="">Нет</option>
					</select>
				</div>
				<div class="form-group">
					<label for="obj_form_title">Название задачи *</label>
					<input type="text" class="form-control" id="obj_form_title" placeholder="Название задачи">
				</div>
				<div class="form-group">
					<label for="obj_form_body">Описание</label>
					<textarea class="form-control" id="obj_form_body" placeholder="Описание" rows="3"></textarea>
				</div>
				<div class="form-group">
					<label for="obj_form_datestart">Дата начала *</label>
					<input type="date" class="form-control" id="obj_form_datestart" value>
				</div>
				<div class="form-group">
					<label for="obj_form_dateend">Дата завершения</label>
					<input type="date" class="form-control" id="obj_form_dateend" >
				</div>
				<button type="submit" id="goform" class="btn btn-info">Создать <i class="fa fa-plus-square"></i></button>
			</form>
			<!--form End-->
		</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть <i class="fa fa-times"></i></button>
			</div>
		</div>
	</div>
</div>

<!--Info-->
<div id="info_obj">
	<p><i class="fa fa-plus"></i> Задача поставлена</p>
</div>

<script>
	var triger;
	$('.wrap-time').click(function(){

		if ( triger != 1 ){
			$('.line-wrap', this).fadeIn(function(){
				triger = 1;

			});
		} else {
			$('.line-wrap', this).fadeOut(function(){
				triger = 0;
			});
		}
	});

	/*-------------------
	|       Форма       |
	-------------------*/
	var get_id = <?print($_SESSION['id'])?>;

	function call(){
		var title = $('#obj_form_title').val();
		var datestart = $('#obj_form_datestart').val();
		if(title.length < 1 && datestart.length < 1){
			alert("Название и дата начала обязательны.");
		}

		$.ajax({
			url: '/libs/lib_objective/new_objective.php',
			type: "POST",
			dataType: "text",
			data: {
				obj_form_author: get_id,
				obj_form_for: $('#obj_form_for').val(),
				obj_form_paty: $('#obj_form_paty').val(),
				obj_form_title: title,
				obj_form_body: $('#obj_form_body').val(),
				obj_form_datestart: datestart,
				obj_form_dateend: $('#obj_form_dateend').val()
			},
			success: function(data){
				//getObj('recurrent');
				$('#myModal').modal('hide');
				doInfo();
				getMyObjective();
				location.reload();
			}
		});
	}

	// Список сотрудников
	function getList(post) {
		var list;
		var cont;
		$.ajax({
			url: 'libs/get_employees_list.php',
			type: "POST",
			dataType: "json",
			success: function(data){
				list = data
				cont = list.length;
				for(i = 0; i < cont; i++){
					$('#'+post).append('<option value="'+list[i].id+'">'+list[i].employees_full_name+'</option>');
				}
			}
		});
	}

	//Информационное сообщение
	function doInfo(){
		$('#info_obj').animate({bottom: 75}, 500);
		setTimeout(function doInfoClose(){
			$('#info_obj').animate({bottom: -40}, 500);
		}, 3000);
	}

	$( document ).ready(function() {
		getList('obj_form_for');
		getList('obj_form_paty');
	});


</script>
