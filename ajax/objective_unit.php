<?
	header('Content-Type: text/html; charset=utf-8');
	session_start(); //Запускаем сессии
	$get_id = $_GET['id_obj'];
	require_once("inc/init.php");
	require_once("..//libs/lib_objective/get_objective_unit.php");
	require_once("..//libs/lib_objective/get_comments.php");
	$user_session = $_SESSION["id"];
	$unit_author_id;
?>

<div class="row">
	<div class="col-xs-12 col-sm-5 col-md-10 col-lg-10">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-wrench"></i> Задача <?=$unit_id;?></h1>
		<p id='id_unit' style="display: none;"><?=$unit_id;?></p>
	</div>
	<div class="col-xs-12 col-sm-5 col-md-2 col-lg-2">
		<a href="/?#ajax/objective.php"><button type="button" class="btn btn-success" data-toggle="modal"><i class="fa fa-undo"></i> Вернутся к списку</button></a>
	</div>
</div>

<div class="well"> 
	<div class="row">
		<div class="col-sm-12">
			<h1><span class="semi-bold"><div class="edit" id="edit_name" data-toggle="tooltip" data-placement="top" title="Для ритактирования кликните два раза."><?=$unit_name;?></div></span><br>
				<small class="text-danger slideInRight fast animated" id="setAuthor">
					<p>Автор: <strong><?=$unit_author;?> </strong><span id="authorObjID"><?=$unit_author_id?></span></p>
					<p id="exe_place">Исполнитель: <strong><?=$unit_executor;?></strong></p>
					<!-- Форма Выбора исполнителя исполнителя -->
					<form id="add_obj" style="display: none">
						<div class="form-group">
							<label for="">Изменить исполнителя:</label>
							<select class="input form-control" id="temporary_select" required>
							<option disabled>Выберете исполнителя</option>
							</select>
						</div>
					</form>
				</small>
			</h1>
			<div class="alert fade in">
				<form>
					<input type="hidden" id="getStat" value=<?=$unit_status;?>>
					<button class="close" id="status"> Завершить</button>
				</form>
				<span id="statText"><i class="fa fa-spinner"></i><strong> Статус:</strong> <?=$unit_status_fase;?> </span>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<h1><span class="semi-bold">Описание</span><br></h1>
			<div class="edit" id="edit_body" data-toggle="tooltip" data-placement="top" title="Для ритактирования кликните два раза."><?=$unit_body;?></div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<h1><span class="semi-bold">Сроки</span><br></h1>
			<div>
				<p id='time_start'>Дата инициализации: <?print date('d.m.Y', $unix_start)?></p>
				<form id="obj_date_star" style='display:none;'>
					<label for="">Дата инициализации:</label>
					<input type="date" class="form-control" style="width:150px;">
				</form>
			</div>
			<div>
				<p id='time_end'>Дата завершения: <?print date('d.m.Y', $unix_end)?></p>
				<form id="obj_date_end" style='display:none;'>
					<label for="">Дата завершения:</label>
					<input type="date" class="form-control" style="width:150px;">
				</form>
			</div>
			<!--
			<div>
				<small class="text-danger slideInRight fast animated"><strong>Осталось <?=$days_left;?> Дня(ей)</strong></small>
			</div>
			<div class="progress">
				<div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?=$days_delta;?>%">
				<span class="sr-only">20% Complete</span>
				</div>
			</div>
			-->
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<h1><span class="semi-bold">Соисполнители </span> <i class="fa fa-plus" id="acc-assist"></i></h1>
			



			<form id="add_assist" action="javascript:void(null);" style="display: none;">
				<!--<select class="input form-control" id="select_assist" required></select>-->
				<div id="select_assist">
				</div>
				<button type="submit" class="btn btn-default">Добавить</button>
			</form>
			<br>



			<div id="assistants">

			</div>
		</div>
	</div>
</div>
<div class="well"> 
	<div class="row">
		<div class="col-sm-12">
			<h1><span class="semi-bold">Коментарии</span> <i class="fa fa-plus" id="acc-comm"></i></h1>
			<form  id='addCommForm' action="javascript:void(null);" style="display: none;">
				<textarea class="form-control" id="add-commbody"  rows="3"></textarea>
				<input type="hidden" id="add-author"  value=<?=$user_session?>>
				<input type="hidden" id="add-idobj"  value=<?=$unit_id;?>>
				<button type="submit" class="btn btn-default">Добавить</button>
			</form>
			<table class="table table-striped table-hover table-comm">
		<?
			foreach ($results as $val) {
				print ("<tr><td><div class=\"comm-wrap\">
						<p class=\"comm-head\"># ".$val['comments_obj_id']." ".$val['employees_full_name']."</p>
						<p class=\"comm-body\">".$val['comments_obj_body']."</p>

						<form class=\"formComm\" action=\"javascript:void(null);\" style=\"display: none;\">
							<textarea class=\"form-control new_comm\" rows=\"3\">".$val['comments_obj_body']."</textarea>
							<input type=\"hidden\" class=\"id_comm\" value=\"".$val['comments_obj_id']."\">
							<input type=\"hidden\" class=\"id_comm_autor\" value=\"".$val['comments_obj_author']."\">
							<button type=\"submit\" class=\"btn btn-default\"><i class=\"fa fa-floppy-o\"></i></button>
						</form>
					</div></td></tr>");
				}
		?>
			</table>
		</div>
	</div>
</div>

<script>
	/*Получить соисполнителей*/
	function getAssistants (){
		var idUnit = $('#id_unit').html();
		$.ajax({
			url: 'libs/lib_objective/get_objective_party.php',
			type: 'POST',
			dataType: 'json',
			data: {
				id_obj: idUnit
			},
			success: function(data){
				var cout_party = data.length
				$('#assistants').html('');
				for(var i = 0; i < cout_party; i++ ){
					$('#assistants').append('<p id=\'partyId_'+data[i].id_employees+'\'>'+data[i].employees_full_name +' <span class="ass_del"><i class="fa fa-times"></i></span></p>');
					$('#checkt_'+data[i].id_employees).addClass( "ass_selected" )
					//console.log('checkt_'+data[i].id_employees);
				}
				delAssist();
			}
		})
	}

	/* Соисполнители */
	$('#add_assist').submit(function(){
		//var addАssist = $('#select_assist').val();
		//var name = $('#select_assist option:selected').text();
		var idUnit = $('#id_unit').html();
		var arrАssist = $('input:checkbox:checked').map(function() {
    		return this.value;
		}).get();

		$.ajax({
			url: 'libs/lib_objective/add_assistant.php',
			type: "POST",
			data: {
				assist: arrАssist,
				id: idUnit
			},
			success: function(data){
				console.log(data);
				getAssistants();
				$('#add_assist').hide();
			}
		});
	});

	/*Изменение статуса задачи*/
	function doStatus (){
		var idUnit   = $('#id_unit').html();
		var unitStat = $('#getStat').val();
		var author   = $('#add-author').val();
		var exequtor = $('#authorObjID').html();		
		console.log(author);

		$.ajax({
			url: 'libs/lib_objective/upstat_objective.php',
			type: 'POST',
			data: {
				id: idUnit,
				stat: unitStat,
				author: author,
				exe: exequtor
			},
			success: function(data){
				$('#getStat').val(data.trim());
				checkStat(data.trim());
			}
		});
	}

	function checkStat(unitStat_a) {
		if (unitStat_a == "recurrent"){
			$('.alert').removeClass( 'alert-success' );
			$('.alert').addClass('alert-warning');
			$('#statText').html('<i class="fa fa-spinner"></i><strong> Статус:</strong> Активна');
			$('#status').html('Завершить');
		} else if (unitStat_a == "considered"){
			$('.alert').removeClass( 'alert-success' );
			$('.alert').addClass( 'alert-warning' );
			$('#statText').html('<i class="fa fa-spinner"></i><strong> Статус:</strong> На рассмотрении');
			$('#status').html('Завершить');
		} else if(unitStat_a == "finished"){
			$('.alert').removeClass( "alert-warning" );
			$('.alert').addClass( "alert-success" );
			$('#statText').html('<i class="fa fa-chevron-down"></i><strong> Статус:</strong> Завершина');
			$('#status').html('Возабновить');
		}
	}
	function upStatus() {
		$('[data-toggle="tooltip"]').tooltip();
		checkStat($('#getStat').val());
	}
	$('#status').click(function(){
		doStatus(); 
	})
	$( document ).ready(function() {
		upStatus();
	});

	$('#acc-comm').click(function(){
		$('#addCommForm').toggle( "slow", function() {
		// Animation complete.
		});
	})

	$('#acc-assist').click(function(){
		$('#add_assist').toggle( "slow", function() {
		// Animation complete.
		});
	})

	// Редактирование Коментария
	function upComm(getElem, getComm){
		$('.formComm').submit(function() {
			var new_comm = $('.new_comm', this).val();
			var	id_comm = $('.id_comm', this).val();
			var	id_comm_autor = $('.id_comm_autor', this).val();
			if(id_comm_autor == <?=$user_session?>){
				$.ajax({
					url: 'libs/lib_objective/upcomm_objective.php',
					type: "POST",
					data: {
							comm: new_comm,
							id_comm: id_comm,	
							id_autor: id_comm_autor
						},
						success: function(data){
							getElem.hide();
							getComm.html(new_comm);
						}
				});
				} else {
					alert("Вы можете редактировать только Ваши комментарии.");
				}
		});
	}

	$('.comm-wrap').dblclick(function(){
		var thisForm = $('.formComm', this);
		var thisbody = $('.comm-body', this);
		thisForm.show();
		upComm(thisForm, thisbody);
	})

	//Добавить коментарий

	$('#addCommForm').submit(function(){
		var addAuthor = $('#add-author').val();
		var addComm = $('#add-commbody').val();
		var addidobj =$('#add-idobj').val();
		
		$.ajax({
			url: 'libs/lib_objective/add_comments.php',
			type: "POST",
			data: {
				id_autor: addAuthor,
				id_obj: addidobj,
				comm: addComm
			},
			success: function(data){
				console.log(data);
				$('.table-comm').append('<tr><td><div class="comm-wrap new-Comm"><p class="comm-head">'+addAuthor+'</p><p class="comm-body">'+addComm+'</p></div></td></tr>');
				$('#addCommForm').hide();
			}
		});

	});

	// Инициализации
	$( document ).ready(function() {
    	getAssistants();
	});
		
		// Список сотрудников
	function getList(post, optionORcheckbox) {
		console.log('getList');
		var list;
		var cont;
		$.ajax({
			url: 'libs/get_employees_list.php',
			type: "POST",
			dataType: "json",
			success: function(data){
				list = data
				cont = list.length;
				if (optionORcheckbox == 'option'){
					for(i = 0; i < cont; i++){
						$('#'+post).append('<option value="'+list[i].id+'">'+list[i].employees_full_name+'</option>');
						

					}
				} else if(optionORcheckbox == 'checkbox'){
					for(i = 0; i < cont; i++){
						//console.log(list[i]);
						$('#'+post).append('<div class="check-block" id="checkt_'+list[i].id+'"><input type="checkbox"  value="'+list[i].id+'"> '+list[i].employees_full_name+'</div>');
						
					}
				} 
			getAssistants();
			}
		});
	}



</script>

<?
	if($user_session == $unit_author_id){
?>

<script>
	function doForm(){
		var idUnit = $('#id_unit').html();
		var elem = $('#elem_type').val();
		var val = $('#new_conten').val();
		doUpdate(idUnit, elem, val);
	}

	function doUpdate(objID, elem, val){
		$.ajax({
			url: 'libs/lib_objective/upunit_objective.php',
			type: 'POST',
			data: {
				id: objID,
				elem: elem,
				val: val
			},
			success: function(data) {
				$('#' + elem).html(val);
			}
		});
	}

	function setAuthor(){
		$( "#add_obj" ).show( "slow" );
	}

	function setTime(idForm, what){
		/*what =  start or end*/
		$( '#' + idForm ).change(function () {
			var idUnit = $('#id_unit').html();
			var newTime = $('#'+idForm+'  input' ).val();
			$.ajax({
				url: 'libs/lib_objective/uptime_objective.php',
				type: "POST",
				data: {
					id: idUnit,
					time: newTime,
					what: what
					},
				success: function(data){
					if (what == "start"){
						$('#time_start').html('Дата инициализации: ' + data);
					} else if (what == "end"){
						$('#time_end').html('Дата завершения: ' + data);
					}

				}
			});
			$( '#' + idForm ).hide();
		})
	}

	// Инициализации
	$('.edit').dblclick(function(){
		var typeEdit = $(this).attr('id');
		var typeContent = $(this).html();
		$(this).html('<form id="formEdit" action="javascript:void(null);" onsubmit="doForm()"><textarea class="form-control" id="new_conten" rows="3">'+typeContent+'</textarea><input type="hidden" id="elem_type" value="'+typeEdit+'"><button type="submit" class="btn btn-default"><i class="fa fa-floppy-o"></i></button></form>');
		$(this).unbind();
	});

	$('#setAuthor').dblclick(function(){
		setAuthor();
	})

	$("#add_obj").change(function () {
		$( "#temporary_select option:selected" ).each(function() {
			var idUnit = $('#id_unit').html();
			var idExe = $( this ).val();
			var nameExe = $( this ).text();
			$.ajax({
				url: '/libs/lib_objective/upfor_objective.php',
				type: 'POST',
				data: {
					id: idUnit,
					exe: idExe
				}
			});
			$('#exe_place').html('Исполнитель: <strong>'+nameExe+'</strong>');
			$('#add_obj').hide(  );
		});
	})

	$('#time_start').dblclick(function(){
		$('#obj_date_star').show();
	})

	$('#time_end').dblclick(function(){
		$('#obj_date_end').show();
	})

	/*Удаление соисполнителя*/
	function delAssist(){
		$('.ass_del').click(function(){
			var idUnit = $('#id_unit').html();
			var idAssist = $(this).parent().attr('id');
			idAssist_s = idAssist.split('_')


			$.ajax({
				url: 'libs/lib_objective/del_assist.php',
				type: 'POST',
				data: {
					unit: idUnit,
					assist: idAssist_s[1]
				},
				success: function(data){
					$('#'+idAssist).fadeOut();
				}
			});
		})
	}

	/* Document - ready */
	$( document ).ready(function() {
		getList('temporary_select', 'option');
		getList('select_assist', 'checkbox');
		
		setTime('obj_date_star', 'start');
		setTime('obj_date_end', 'end');
		
	});

</script>

<? } else { ?>

<script>


// Инициализации
	$( document ).ready(function() {
		getList('temporary_select', 'option');
		getList('select_assist', 'checkbox');
		
		//setTime('obj_date_star', 'start');
		//setTime('obj_date_end', 'end');
		
	});


	$('.edit').dblclick(function(){
		alert("У Вас нет прав на редактирование данной позиции.");
	});

	$('#setAuthor').dblclick(function(){
		alert("У Вас нет прав на редактирование данной позиции.");
	})

	$("#add_obj").change(function () {
		alert("У Вас нет прав на редактирование данной позиции.");
	})

	$('#time_start').dblclick(function(){
		alert("У Вас нет прав на редактирование данной позиции.");
	})
	$('#time_end').dblclick(function(){
		alert("У Вас нет прав на редактирование данной позиции.");
	})

		/*Удаление соисполнителя*/
	function delAssist(){
		$('.ass_del').click(function(){
			alert("У Вас нет прав на удаление соисполнителя.");
		})
	}
</script>

<? } ?>