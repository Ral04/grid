<?
	header('Content-Type: text/html; charset=utf-8');
	session_start(); //Запускаем сессии
	require_once("inc/init.php");
	$date_now = date_create();
	$date_now = date('d-m-Y', date_timestamp_get($date_now));
	$date_unix = strtotime($date_now);
	$user_session = $_SESSION["id"];
?>

<div class="row">
	<div class="col-xs-12 col-sm-5 col-md-10 col-lg-10">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-pencil"></i> Задачи. Дата: <span style="font-size: 23px; color: #FF2BB4; id="><?=$date_now?></span> </h1>
		<div style="display: none;"><p id="date-server"><?=$date_unix?></p><span id="authorObjID"><?=$user_session?></span></div>
	</div>
	<div class="col-xs-12 col-sm-5 col-md-2 col-lg-2">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Добавить</button>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="well">
			<div>
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#recurrent-tab" id="recurrent" aria-controls="recurrent" role="tab" data-toggle="tab">Текущие</a></li>
					<li role="presentation"><a href="#finished-tab" id="finished" aria-controls="finished" role="tab" data-toggle="tab">Завершенные</a></li>
					<li role="presentation"><a href="#helping-tab" id="helping" aria-controls="helping" role="tab" data-toggle="tab">Помогаю</a></li>
					<li role="presentation"><a href="#assigned-tab" id="assigned" aria-controls="assigned" role="tab" data-toggle="tab">Назначенные</a></li>
					<li role="presentation"><a href="#all_my-tab" id="all_my" aria-controls="all_my" role="tab" data-toggle="tab">Все</a></li>
				</ul>
				<!--filter-->
				<div class="filter-wrap">
					<form class="form-inline" id="filter-obj">
						<div class="obj-wrap-pre-form">
							<div class="obj-num">Фильтры</div>
							<div class="obj-title">
								<input list="title-list" class="input form-control change-filter"  id="filter-title" size="35">
								<datalist id="title-list"></datalist>
							</div>
							<div class="obj-from" >
								<input list="author-list" class="input form-control change-filter" id="filter-author" size="30">
								<datalist id="author-list"></datalist>
							</div>
							<div class="obj-exe">
								<input list="exe-list" class="input form-control change-filter" id="filter-exe" size="30">
								<datalist id="exe-list"></datalist>
							</div>
							<div class="obj-date">
								<input type="date" class="form-control change-filter" id="filter-start" placeholder="Дата начала">
							</div>
							<div class="obj-date-end">
								<input type="date" class="form-control change-filter" id="filter-end" placeholder="Дата завершения">
							</div>
							<div class="obj-go-to1" >
								<!--<input type="" class="form-control change-filter" id="filter-stat" placeholder="Статус">-->
								<select class="input form-control change-filter" id="filter-stat" >
									<option value="" disabled selected>Статус</option>
									<option value="recurrent">В работе</option>
									<option value="finished">Закрыты</option>
									<option value="considered">На расмотрении</option>

								</select>
							</div>
							<!--Скрытые-->
							<input type="hidden" class="form-control change-filter" id="nav-filter" >
						</div>
					</form>
				</div>
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="recurrent-tab"></div>
					<div role="tabpanel" class="tab-pane fade" id="finished-tab"></div>
					<div role="tabpanel" class="tab-pane fade" id="helping-tab"></div>
					<div role="tabpanel" class="tab-pane fade" id="assigned-tab"></div>
					<div role="tabpanel" class="tab-pane fade" id="all_my-tab"></div>
				</div>
			</div>
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

		</div>
	</div>
</div>

<!--Info-->
<div id="info_obj">
	<p><i class="fa fa-plus"></i> Задача поставлена</p>
</div>

<script>
	// Конвертор даты UNIX
	function toTimestamp(strDate){
		var datum = Date.parse(strDate);
		return datum/1000;
	}
	/*-------------------
	|  Вывод элементов  |s
	-------------------*/
	var get_id = <?print($_SESSION['id'])?>;

	$('.nav-tabs a').click(function () {
		getObj(this.id);
		resetFilter();
	});
	//Загрузка объектов
	function getObj(navSelect){
		$('#nav-filter').val(navSelect); //Для фильтра

		$.ajax({
			url: '/libs/lib_objective/get_objective.php',
			type: "POST",
			dataType: "html",
			data: {
				iduser: get_id,
				forquery: navSelect
			},
			success: function(data){
				$('#'+navSelect+'-tab').html("");
				data = JSON.parse(data);
				cont =  data.length;
				for(i = 0; i < cont; i++){
					var body_origin = data[i].objective_body;
					body = body_origin.slice(0, 600);
					var tile_origin = data[i].objective_name;
					title = tile_origin.slice(0, 30);
					doHTML(navSelect, data[i].objective_id, title, data[i].employees_full_name, data[i].objective_date_start, data[i].objective_date_end, body, data[i].objective_status, data[i].employees_full_name_exe, data[i].objective_status, data[i].objective_author_id);
					insertFilter(data[i].objective_name, data[i].employees_full_name, data[i].employees_full_name_exe, data[i].objective_author_id, data[i].objective_executor_id);
				}
				goInfo();
				objSuccess(navSelect);

			}
		});
	}
	// Создание HTML
	function doHTML(position, objNum, objTitle, objFrom, objDate, objDateEnd, objBody, odjstat, objexe, status, idAuthor){
		//console.log(idAuthor);
		var date_now_server = $('#date-server').text();
		var classFalse = "";
		if (toTimestamp(objDateEnd) < date_now_server){
			classFalse = "class-false";
		}
		var classFinished = "";
		if (odjstat == "finished"){
			classFinished = "class-finished";
		}
		if(position == "recurrent"){
			$('#'+position+'-tab').append('<div class="obj-wrap obj-st-recurrent '+classFalse+'"><div class="obj-wrap-pre"><div class="obj-num"># '+objNum+'</div><div class="obj-title">'+objTitle+'</div><div class="obj-from"  data-id_author="'+idAuthor+'">Автор: <b>'+objFrom+'</b></div><div class="obj-exe">Исполнитель: <b>'+objexe+'</b></div><div class="obj-date">'+objDate+'</div><div class="obj-date-end">'+objDateEnd+'</div><div class="obj-go-to go-to-style" id="'+objNum+'">Завершить <i class="fa fa-times"></i></div></div><br><div class="body-obj obj-fromshow" id="body_'+objNum+'"><b><i class="fa fa-caret-right"></i> </b>'+objBody+' <p><a href="/#ajax/objective_unit.php?id_obj='+objNum+'">Подробнее...</a></p></div>');
		} else if(position == "finished"){
			if (status == "finished" ){
				$('#'+position+'-tab').append('<div class="obj-wrap obj-st-finished class-finished "><div class="obj-wrap-pre"><div class="obj-num"># '+objNum+'</div><div class="obj-title">'+objTitle+'</div><div class="obj-from" data-id_author="'+idAuthor+'">Автор: <b>'+objFrom+'</b></div><div class="obj-exe">Исполнитель: <b>'+objexe+'</b></div><div class="obj-date">'+objDate+'</div><div class="obj-date-end">'+objDateEnd+'</div><div class="obj-go-to go-to-style" id="'+objNum+'">Востановить <i class="fa fa-repeat"></i></div></div><br><div class="body-obj obj-fromshow" id="body_'+objNum+'"><b><i class="fa fa-caret-right"></i> </b>'+objBody+'<p><a href="/#ajax/objective_unit.php?id_obj='+objNum+'">Подробнее...</a></p></div>');
			}else{
				$('#'+position+'-tab').append('<div class="obj-wrap obj-st-finished considered "><div class="obj-wrap-pre"><div class="obj-num"># '+objNum+'</div><div class="obj-title">'+objTitle+'</div><div class="obj-from" data-id_author="'+idAuthor+'">Автор: <b>'+objFrom+'</b></div><div class="obj-exe">Исполнитель: <b>'+objexe+'</b></div><div class="obj-date">'+objDate+'</div><div class="obj-date-end">'+objDateEnd+'</div><div class="obj-go-to go-to-style" id="'+objNum+'">Востановить <i class="fa fa-repeat"></i></div></div><br><div class="body-obj obj-fromshow" id="body_'+objNum+'"><b><i class="fa fa-caret-right"></i> </b>'+objBody+'<p><a href="/#ajax/objective_unit.php?id_obj='+objNum+'">Подробнее...</a></p></div>');
			}
		} else if(position == "assigned"){
			if(status == "considered"){
				$('#'+position+'-tab').append('<div class="obj-wrap obj-st-assigned considered '+classFalse+' '+classFinished+'"><div class="obj-wrap-pre"><div class="obj-num"># '+objNum+'</div><div class="obj-title">'+objTitle+'</div><div class="obj-from" data-id_author="'+idAuthor+'">Автор: <b>'+objFrom+'</b></div><div class="obj-exe">Исполнитель: <b>'+objexe+'</b></div><div class="obj-date">'+objDate+'</div><div class="obj-date-end">'+objDateEnd+'</div><div class="obj-go-to go-to-style btn_s_'+status+'" id="'+objNum+'">Завершить <i class="fa fa-times"></i></div></div><br><div class="body-obj obj-fromshow" id="body_'+objNum+'"><b><i class="fa fa-caret-right"></i> </b>'+objBody+'<p><a href="/#ajax/objective_unit.php?id_obj='+objNum+'">Подробнее...</a></p></div>');
			} else {
				$('#'+position+'-tab').append('<div class="obj-wrap obj-st-assigned '+classFalse+' '+classFinished+'"><div class="obj-wrap-pre"><div class="obj-num"># '+objNum+'</div><div class="obj-title">'+objTitle+'</div><div class="obj-from" data-id_author="'+idAuthor+'">Автор: <b>'+objFrom+'</b></div><div class="obj-exe">Исполнитель: <b>'+objexe+'</b></div><div class="obj-date">'+objDate+'</div><div class="obj-date-end">'+objDateEnd+'</div><div class="obj-go-to go-to-style btn_s_'+status+'" id="'+objNum+'">Завершить <i class="fa fa-times"></i></div></div><br><div class="body-obj obj-fromshow" id="body_'+objNum+'"><b><i class="fa fa-caret-right"></i> </b>'+objBody+'<p><a href="/#ajax/objective_unit.php?id_obj='+objNum+'">Подробнее...</a></p></div>');
			}
		} else if(position == "helping"){
			if(status == "considered"){
				$('#'+position+'-tab').append('<div class="obj-wrap obj-st-recurrent considered '+classFalse+'"><div class="obj-wrap-pre"><div class="obj-num"># '+objNum+'</div><div class="obj-title">'+objTitle+'</div><div class="obj-from" data-id_author="'+idAuthor+'">Автор: <b>'+objFrom+'</b></div><div class="obj-date">'+objDate+'</div><div class="obj-date-end">'+objDateEnd+'</div><div class="obj-go-to go-to-style" id="'+objNum+'">Завершить <i class="fa fa-times"></i></div></div><br><div class="body-obj obj-fromshow" id="body_'+objNum+'"><b><i class="fa fa-caret-right"></i> </b>'+objBody+' <p><a href="/#ajax/objective_unit.php?id_obj='+objNum+'">Подробнее...</a></p></div>');
			} else {
				$('#'+position+'-tab').append('<div class="obj-wrap obj-st-recurrent '+classFalse+'"><div class="obj-wrap-pre"><div class="obj-num"># '+objNum+'</div><div class="obj-title">'+objTitle+'</div><div class="obj-from" data-id_author="'+idAuthor+'">Автор: <b>'+objFrom+'</b></div><div class="obj-date">'+objDate+'</div><div class="obj-date-end">'+objDateEnd+'</div><div class="obj-go-to go-to-style" id="'+objNum+'">Завершить <i class="fa fa-times"></i></div></div><br><div class="body-obj obj-fromshow" id="body_'+objNum+'"><b><i class="fa fa-caret-right"></i> </b>'+objBody+' <p><a href="/#ajax/objective_unit.php?id_obj='+objNum+'">Подробнее...</a></p></div>');
			}
		}else{
			$('#'+position+'-tab').append('<div class="obj-wrap obj-st-else"><div class="obj-wrap-pre"><div class="obj-num"># '+objNum+'</div><div class="obj-title">'+objTitle+'</div><div class="obj-from" data-id_author="'+idAuthor+'">Автор: <b>'+objFrom+'</b></div><div class="obj-exe">Исполнитель: <b>'+objexe+'</b></div><div class="obj-date">'+objDate+'</div><div class="obj-date-end">'+objDateEnd+'</div><div class="obj-go-to go-to-style" id="'+objNum+'">Завершить <i class="fa fa-times"></i></div></div><br><div class="body-obj obj-fromshow" id="body_'+objNum+'"><b><i class="fa fa-caret-right"></i> </b>'+objBody+'<p><a href="/#ajax/objective_unit.php?id_obj='+objNum+'">Подробнее...</a></p></div>');
		}

	}
	// Табличка о создании
	function goInfo(){
		$( ".obj-wrap" ).dblclick(function() {
			//console.log("click");
			$(this).toggleClass("obj-active", 200);
			$(".body-obj", this).toggle(200);
		});
	}
	//Обновление статуса
	function objSuccess(obj_stat){
		$( ".obj-go-to" ).click(function() {
			var obj_id = this.id;
			var exequtor = $('#authorObjID').html();
			var idAuthor = $(this).siblings('.obj-from').data('id_author');
			//console.log(idAuthor);
			if(obj_stat !='assigned'){
				$(this).closest(".obj-wrap").unbind(  );
				$(this).closest(".obj-wrap").hide('slide', {direction: 'right'}, 500);

			} else {
				//$(this).closest(".obj-wrap").unbind(  );
				$(this).closest(".obj-wrap").removeClass('considered');
				$(this).closest(".obj-wrap").addClass('class-finished');
				//$('#'+obj_id).html('');
				//console.log('up stat');
				$(this).hide();
			}
			$.ajax({
				url: '/libs/lib_objective/upstat_objective.php',
				type: 'POST',
				dataType: 'TEXT',
				data:{
					id: obj_id,
					stat: obj_stat,
					author: idAuthor,
					exe: exequtor
				},
				success: function(data){
					console.log(data);
					getMyObjective();
					doMail(obj_id, 'up');// Инклюдится /inc/script.php
				}
			});
		});
	}
	/*-------------------
	|      Фильтр       |
	-------------------*/

	$('.change-filter').change(function(){
		var navSelect    = $('#nav-filter').val();
		var titleFilter  = $('#filter-title').val();

		var authorFilter = $('#filter-author').val();
			//Переписать это порно
			var authorFilterF = "";
			if(authorFilter.length > 0){
				var authorFilterP1 = authorFilter.split("(");
				var authorFilterP2 = authorFilterP1[1].split(")");
				authorFilterF  = authorFilterP2[0];
			}
		var exeFilter    = $('#filter-exe').val();
			//Переписать это порно
			var exeFilterF = "";
			if(exeFilter.length > 0){
				var exeFilterP1 = exeFilter.split("(");
				var exeFilterP2 = exeFilterP1[1].split(")");
				exeFilterF  = exeFilterP2[0];
			}
		var startFilter  = $('#filter-start').val();
		var endFilter    = $('#filter-end').val();
		var statFilter   = $('#filter-stat').val();
		console.log(titleFilter +' - '+ authorFilterF +' - '+ exeFilterF +' - '+ startFilter +' - '+ endFilter +' - '+ statFilter);
		$.ajax({
			url: '/libs/lib_objective/get_objective.php',
			type: "POST",
			dataType: "html",
			data: {
				iduser:   get_id,
				forquery: navSelect,

				titlef:   titleFilter,
				authorf:  authorFilterF,
				exef:     exeFilterF,
				startf:   startFilter,
				endf:     endFilter,
				statf:    statFilter,
			},
			success: function(data){
				$('#'+navSelect+'-tab').html("");
				data = JSON.parse(data);
				cont =  data.length;
				for(i = 0; i < cont; i++){
					var body_all = data[i].objective_body;
					var body_origin = data[i].objective_body;
					body = body_origin.slice(0, 600);
					var tile_origin = data[i].objective_name;
					title = tile_origin.slice(0, 30);
					doHTML(navSelect, data[i].objective_id, title, data[i].employees_full_name, data[i].objective_date_start, data[i].objective_date_end, body, data[i].objective_status, data[i].employees_full_name_exe, data[i].objective_status, data[i].objective_author_id);
				}
				goInfo();
			}
		})


		//var elemVal = $(this).val();
		//var elemId = $(this).attr('id');
	})

	// Для формы филтра
	function insertFilter(title, author, exe, author_id, exe_id){
		$('#title-list').append('<option>'+title+'</option>');
		$('#author-list').append('<option>'+author+' ('+author_id+')</option>');
		$('#exe-list').append('<option>'+exe+' ('+exe_id+')</option>');
	}
	// Сброс формы
	function resetFilter(){
		$('#title-list').html('');
		$('#author-list').html('');
		$('#exe-list').html('');
	}



	/*-------------------
	|       Форма       |
	-------------------*/
	function call(){
		var title = $('#obj_form_title').val();
		var datestart = $('#obj_form_datestart').val();
		var form_for = $('#obj_form_for').val();
		var form_paty = $('#obj_form_paty').val();
		var form_body = $('#obj_form_body').val();
		var form_dateend = $('#obj_form_dateend').val();

		if(title.length < 1 && datestart.length < 1){
			alert("Название и дата начала обязательны.");
		}
		$.ajax({
			url: '/libs/lib_objective/new_objective.php',
			type: "POST",
			dataType: "text",
			data: {
				obj_form_author:    get_id,
				obj_form_for:       form_for,
				obj_form_paty:      form_paty,
				obj_form_title:     title,
				obj_form_body:      form_body,
				obj_form_datestart: datestart,
				obj_form_dateend:   form_dateend
			},
			success: function(data){
				getObj('recurrent');
				$('#myModal').modal('hide');
				doInfo();
				getMyObjective();
				devastation();
				doMail(data, 'new');// Инклюдится /inc/script.php
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
	//очистка формы
	function devastation(){
		$('#obj_form_title, #obj_form_datestart, #obj_form_for, #obj_form_paty, #obj_form_body, #obj_form_dateend').val('');
	}
	/*-------------------
	|  Инициализация    |
	-------------------*/
	$( document ).ready(function() {
		getObj('recurrent');
		getList('obj_form_for');
		getList('obj_form_paty');
	});

</script>
