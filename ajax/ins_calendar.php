<?
header('Content-Type: text/html; charset=utf-8');
session_start(); //Запускаем сессии
//$date = date_create();
//$date = date_format($date, 'Y-m-d H:i:s');
$_time = time();
$str_time = date('H:i:s', $_time);
$arr_time = explode(':', $str_time);
        
$h = $arr_time[0] * 60 * 60;
$m = $arr_time[1] * 60;
$s = $arr_time[2];
        
$start_day = $_time - ($h+$m+$s);
$date = $start_day;

?>
<?php require_once("inc/init.php"); ?>
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-wrench"></i> Монтажники <span>> Календарь <button type="button" id="ref_bttn" class="btn btn-success"><i class="fa fa-refresh"></i> Обновить</button></span></h1>
        
	</div>
</div>


	<meat carset="utf-8">
	<link href='lib_installers/css/fullcalendar.css' rel='stylesheet' />
	<link href='lib_installers/css/fullcalendar.print.css' rel='stylesheet' media='print' />
	<!--<link href='lib_installers/css/style.css' rel='stylesheet' />-->
    
    <!-- DATE PICKER-->
    <link href='lib_installers/date_picker/jquery-ui-timepicker-addon.css' rel='stylesheet' media='print' />
    <script type="text/javascript" src='lib_installers/date_picker/jquery-ui-timepicker-addon.js'>          </script>
    <script type="text/javascript" src='lib_installers/date_picker/jquery-ui-sliderAccess.js'>              </script>
    <script type="text/javascript" src='lib_installers/date_picker/i18n/jquery-ui-timepicker-addon-i18n.js'></script>

	<!-- DATE Fullcalendar-->
	<script type="text/javascript" src='lib_installers/js/lib/moment.min.js'></script>
	<!--<script type="text/javascript" src='lib_installers/js/lib/jquery.min.js'></script>-->
	<script type="text/javascript" src='lib_installers/js/lib/jquery-ui.custom.min.js'></script>
	<script type="text/javascript" src='lib_installers/js/fullcalendar.js'></script>

    <style>
        .ui_tpicker_second_label, 
        .ui_tpicker_second,
        .ui_tpicker_millisec_label,
        .ui_tpicker_millisec,
        .ui_tpicker_microsec_label,
        .ui_tpicker_microsec,
        .ui_tpicker_timezone_label,
        .ui_tpicker_timezone{display: none;}
    </style>


	<script>
        var author        = "<?print($_SESSION['login']);?>";
        var author_access = "<?print($_SESSION['access']);?>";
        var author_name   = "<?print($_SESSION['name']);?>";
        var time_server   = "<?print($date);?>";
        var full_author   = (author+' '+author_access+' '+author_name);
        var full_access   = "extended";
        //console.log(author+' '+author_access);
        var time_clnt;
        var click_event = [];
        var id_event;

		$(document).ready(function() {
            $('#form_event_start, #form_event_end').datetimepicker({
                timeOnlyTitle: 'Выберите время',
                timeText: 'Время',
                hourText: 'Часы',
                minuteText: 'Минуты',
                secondText: 'Секунды',
                currentText: 'Сейчас',
                closeText: 'ОК',
                monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
                dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
                dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
                dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
                prevText: '<',
                nextText: '>',
                firstDay: 1,
                dateFormat: 'yy-mm-dd',
                //dateFormat: 'yy-mm-dd hh:mma'
                addSliderAccess: true,
                sliderAccessArgs: { touchonly: false }

            });
            
            //form_event_start.datetimepicker({hourGrid: 4, minuteGrid: 10, dateFormat: 'mm/dd/yy'});
            //event_end.datetimepicker({hourGrid: 4, minuteGrid: 10, dateFormat: 'mm/dd/yy'});

			/* initialize the external events
			-----------------------------------------------------------------*/
			$('#external-events .fc-event').each(function() {
				// store data so the calendar knows to render an event upon drop
				// создание эвентов после дропа
				$(this).data('event', {
					title: $.trim($(this).text()), // use the element's text as the event title
					stick: true // maintain when user navigates (see docs on the renderEvent method)
				});

				// make the event draggable using jQuery UI
				$(this).draggable({
					zIndex: 999,
					revert: true,      // will cause the event to go back to its
					revertDuration: 0  //  original position after the drag
				});

			});

			/* initialize the calendar
			-----------------------------------------------------------------*/
			
			$('#calendar').fullCalendar({

				//Основные настройки
                firstDay: 1,
                businessHours:
                {
                    start: '00:00', 
                    end: '23:59',
                    dow: [ 1, 2, 3, 4, 5, 6, 7 ]
                },
				header: {
					left:   'prev,next today',
					center: 'title',
					right:  'month,agendaWeek,agendaDay'
				},
                nextDayThreshold: "00:00:00",
                timeFormat: 'H:mm',

				editable: true,
				droppable: true, // this allows things to be dropped onto the calendar
				selectable: true,
				events: "lib_installers/fullcalendar/events.php",// ЧТЕНИЕ Эвентов из SQL DB
                monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                monthNamesShort: ['Янв.','Фев.','Март','Апр.','Май','Июнь','Июль','Авг.','Сент.','Окт.','Ноя.','Дек.'],
                dayNames: ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],
                dayNamesShort: ["ВС","ПН","ВТ","СР","ЧТ","ПТ","СБ"],
                buttonText: {
                    today: "Сегодня",
                    month: "Месяц",
                    week: "Неделя",
                    day: "День"
                },

				eventDrop: function(event, delta) {
	        		form_event_author  = event.className[0];
                    form_event_access  = event.className[1];
                    time_clnt_st = (parseInt(new Date(event.start._i).getTime()/1000));
                    time_clnt    = (parseInt(new Date(event.start._i).getTime()/1000)) + (delta._days * 86400);
                    function do_drop(){
                        //console.log(event.start._i);
                        //console.log(delta._days);
                        var start_drop = moment(event.start).format('YYYY-MM-DDTHH:mm:ssZ'); 
    	        		var end_drop   = moment(event.end).format('YYYY-MM-DDTHH:mm:ssZ'); 
    	        		var all_d_drop = event.allDay;
    					var event_id   = event._id;
                        $.ajax({
              				url:  'lib_installers/fullcalendar/update_events.php',
              				type: 'POST',
              				data: 'title='+event.title+'&event_id='+event_id+'&start_drop='+start_drop+'&end_drop='+end_drop+'&all_d_drop='+all_d_drop,
    				        success: function(json) {
                			$('#calendar').fullCalendar('refetchEvents');
              				}
    		         	});
                    }  
                    if(author_access == full_access || (form_event_author == author && time_server <= time_clnt && time_server <= time_clnt_st)){
                        do_drop();
                        //alert(form_event_access+'=='+full_access+' '+form_event_author+'=='+author)
                    }else{
                        alert("У Вас нет прав на редактирование этого элемента. (Drop)");
                        $('#calendar').fullCalendar('refetchEvents');
                    }
      			},

                dayClick: function(date, allDay, jsEvent, view) {
                    //console.log(click_event);
                    click_event.push(event.timeStamp);
                    var cnt_click = click_event.length;
                    if (cnt_click >= 2){
                        if(click_event[click_event.length - 1] - click_event[click_event.length - 2] < 300){
                            $( "#arr_data" ).empty();
                            $( "#form_file" ).hide();
                            $('#event_author').html(' ');
                            emptyForm();
                            day_click = moment(date).format('YYYY-MM-DDTHH:mm:ssZ'); 
                            $('#form_event_start').val(day_click);
                            formOpen('add');
                            time_clnt = (parseInt(new Date(moment(date).format('YYYY-MM-DD HH:mm:ss')).getTime()/1000));
                            click_event = [];
                        }
                    }
                },

                eventRender: function(event, element, calEvent) {
                    element.bind('dblclick', function() {
                        form_event_id          = event._id;
                        id_event = form_event_id;
                        form_event_type        = event.title;
                        form_event_start       = event._start._i;
                        form_event_description = event.description;
                        form_event_color       = event.color;
                        if(event._end){
                            form_event_end = event._end._i;
                        }
                        form_event_allday = event._allDay;
                        form_event_author = event.className[0];
                        form_event_access = event.className[1];
                        form_event_name   = event.className[2];
                        //console.log(form_event_name);
                        $('#event_author').html('. Автор: '+form_event_name);
                        $('#form_event_type').val(form_event_type);
                        $('#form_event_start').val(form_event_start);
                        $('#form_event_end').val(form_event_end);
                        $('#form_event_allday').val(form_event_allday);
                        $('#form_event_description').val(form_event_description);
                        formOpen('edit');
                        time_clnt = (parseInt(new Date(event.start._i).getTime()/1000));
                        $( "#form_file" ).show();
                        $( "#arr_data" ).html('<p>Нет файлов</p>');
                        /*-----------------------------
                        |   Просмотр файлов           |
                        -----------------------------*/
                        function show_file(){
                            $.ajax({
                                url:  'lib_installers/fullcalendar/show_file.php',
                                type: 'POST',
                                data: {id_event: id_event},
                                success: function(json) {
                                    console.log(json)
                                    jarr = JSON.parse(json);
                                    if(jarr.length >2 ){
                                        $( "#arr_data" ).empty();
                                        for(i = 2; i < jarr.length; i++){
                                            $( "#arr_data" ).append('<p><a target="_blank" href="/data/calendar_files/'+id_event+'/'+jarr[i]+'">'+jarr[i]+' <i class="fa fa-download"></i></a></p>' );
                                        }
                                    }else{
                                        $( "#arr_data" ).html('<p>Нет файлов</p>');
                                    }
                                }
                            });
                        }
                        /*-----------------------------
                        |   Загрузка файла на сервер  |
                        -----------------------------*/
                                $('#go_file').click(function( event ){
                                    //alert(id_event);
                                    var formData = new FormData($('#form_f')[0]);
                                    formData.append('id_event', id_event);
                                    $.ajax({
                                        type: "POST",
                                        processData: false,
                                        contentType: false,
                                        url:  'lib_installers/fullcalendar/add_file.php',
                                        data:  formData 
                                    })
                                    .done(function( data ) {
        
                                        show_file()

                                    });
                                    
                                });
                        show_file()
                        return id_event;
                    });
                },

		        eventResize: function (event, delta, start, end, sdayDelta, view) {
                    console.log(event.allDay);
                    form_event_author  = event.className[0];
                    form_event_access  = event.className[1];
                    //console.log(event.allDay);
                    function do_res(){
                        var end_event      = event.end.format("YYYY-MM-DD hh:mma");
                        var alld_event     = event.allDay;
                        var end_Delta_days = delta._days;
                        var end_Delta_msec = delta._milliseconds;
                        $.ajax({
              				url:  'lib_installers/fullcalendar/update_events_rsize.php',
              				type: 'POST',
              				data: 'title='+ event.title+ '&end_Delta_days='+end_Delta_days+'&end_Delta_msec='+end_Delta_msec+'&end_event='+end_event+'&id_event='+event._id+'&allDay='+event.allDay,
    				        success: function(json) {
                			//	alert("Updated Successfully");
                            $('#calendar').fullCalendar('refetchEvents');
              				}
    		         	});
                    }
                    if(author_access == full_access || form_event_author == author){
                        do_res()
                    } else {
                        alert("У Вас нет прав на редактирование этого элемента.(RE)");
                        $('#calendar').fullCalendar('refetchEvents');
                    }
        		},
			});

	 		/* режимы открытия формы */
	 		var day_click;
	 		var event_type = $('#event_type');
	 		var form = $('#dialog-form');
            function formOpen(mode) {
                if(mode == 'add') {
                    /* скрываем кнопки Удалить, Изменить и отображаем Добавить*/
                    $('#add').show();
                    $('#edit').hide();
                    $("#delete").button("option", "disabled", true);
                }
                else if(mode == 'edit') {
                    /* скрываем кнопку Добавить, отображаем Изменить и Удалить*/
                    $('#edit').show();
                    $('#add').hide();
                    $("#delete").button("option", "disabled", false);
                }
                form.dialog('open');
            }
            /* обработчик формы добавления  ПЕРЕПИСАТЬ!!!!!!"*/
            var form_event_id;
            var form_event_type;
            var form_event_start;
            var form_event_end;
            var form_event_allday;
            var form_event_description;
            var form_event_color;
            var form_event_author;
            var form_event_access;
            var form_event_name;

            form.dialog({ 
                autoOpen: false,
                buttons: [{
                    id: 'add',
                    class: 'btn btn-default',
                    text: 'Добавить',
                    click: function() {
                    	form_event_type  = $('#form_event_type').val();
                    	form_event_start = $('#form_event_start').val();
                    	form_event_end   = $('#form_event_end').val();
                    	if (form_event_end.length > 5){
							form_event_allday =  true;
                    	}else{
                    		form_event_allday =  false;
                    	}
                    	form_event_description = $('#form_event_description').val();
                    	form_event_allday      = $('#form_event_allday').val();
                    	form_event_color       = $('#form_event_color').val();
                        form_event_file        = $('#form_event_file').val();
                    	var url;
                        time_clnt = (parseInt(new Date(form_event_start).getTime()/1000));
                        if (author_access == full_access || time_server <= time_clnt){
                            $.ajax({
                				url:  'lib_installers/fullcalendar/add_events.php',
                				type: 'POST',
                				data: {
                					form_event_type:        form_event_type,
                					form_event_start:       form_event_start,
                					form_event_end:         form_event_end,
                					form_event_description: form_event_description,
                					form_event_allday:      form_event_allday,
                					url:                    url,
                					form_event_color:       form_event_color,
                                    form_event_class:       full_author,
                                    form_event_file:        form_event_file
                				},
                				success: function(json) {
                  				//	alert('Added Successfully');
                               $('#calendar').fullCalendar('refetchEvents');
                				}
                			});
                        }else{
                            alert("У Вас нет прав на создание события в прошлом.");
                        }

						//emptyForm();
						$(this).dialog('close');
                        $('#calendar').fullCalendar('refetchEvents');
                    }
                },
                {   
                	id: 'edit',
                	class: 'btn btn-default',
                    text: 'Изменить',
                    click: function() {
                        //emptyForm();
                    	form_event_type   = $('#form_event_type').val();
                    	form_event_start  = $('#form_event_start').val();
                    	form_event_end    = $('#form_event_end').val();
                    	form_event_allday = $('#form_event_allday').val();
                    	form_event_description = $('#form_event_description').val();
                    	form_event_color = $('#form_event_color').val();
                        function du_ajax(){
                        	$.ajax({
                				url:  'lib_installers/fullcalendar/update_events_form.php',
                				type: 'POST',
              					data: {
    	          					form_event_id:          form_event_id,
                					form_event_type:        form_event_type,
                					form_event_start:       form_event_start,
                					form_event_end:         form_event_end,
                					form_event_allday:      form_event_allday,
                					form_event_description: form_event_description,
                					form_event_color:       form_event_color
              					},
                				success: function(json) {
                  				//	alert('Added Successfully');
                                $('#calendar').fullCalendar('refetchEvents');

                				}
                			});
                        };
                        //console.log(time_server);
                        //console.log(time_clnt);
                        time_clnt_t = (parseInt(new Date(form_event_start).getTime()/1000));

                        console.log('----------------------');
                        console.log(form_event_author);
                        console.log(author);
                        console.log(time_server);
                        console.log(time_clnt);//
                        console.log(time_server);
                        console.log(time_clnt_t);//
                        console.log('----------------------');

                        
                        if(author_access == full_access || (form_event_author == author && time_server <= time_clnt && time_server <= time_clnt_t)){
                            du_ajax()
                        }else{
                            alert("У Вас нет прав на редактирование этого элемента или назначать дату прошлого.");
                        }
                    	$(this).dialog('close');
						$('#calendar').fullCalendar('refetchEvents');
                       //emptyForm();
                	}
                },
                {   
                	id: 'cancel',
                	class: 'btn btn-default',
                    text: 'Отмена',
                    click: function() { 
                        $(this).dialog('close');
                        //emptyForm();
                    }
                },
                {   
                	id: 'delete',
                	class: 'btn btn-default',
                    text: 'Удалить',
                    click: function() { 
                        function du_ajax_del(){
                            $.ajax({
                                url:  'lib_installers/fullcalendar/del_event.php',
                                type: 'POST',
                                data: {
                                    form_event_id:form_event_id
                                },
                                success: function(json) {
                                    //alert('Added Successfully');
                               $('#calendar').fullCalendar('refetchEvents');
                                }
                            });
                        };
                        if(author_access == full_access || (form_event_author == author && time_server <= time_clnt)){
                            du_ajax_del()
                        }else{
                            alert("У Вас нет прав на редактирование этого элемента");
                        };
                        $(this).dialog('close');
                        //emptyForm();
                    },
                    //disabled: true
                }]
            });

        $( "#ref_bttn" ).click(function() {
            $('#calendar').fullCalendar('refetchEvents');
        });

        function emptyForm() {
            $('#form_event_id').val("");
            $('#form_event_type').val("");
            $('#form_event_start').val("");
            $('#form_event_end').val("");
            $('#form_event_allday').val("");
            $('#form_event_description').val("");
            $('#form_event_color').val("");
        }
    });
    </script>


<div class="row">
	<!--
<div class="col-md-2">
		<div id='external-events'>
			<h4>Draggable Events</h4>
			<div class='fc-event'>My Event 1</div>
			<div class='fc-event'>My Event 2</div>
			<div class='fc-event'>My Event 3</div>
			<div class='fc-event'>My Event 4</div>
			<div class='fc-event'>My Event 5</div>
			<p>
				<input type='checkbox' id='drop-remove' />
				<label for='drop-remove'>remove after drop</label>
			</p>
		</div>
</div>
-->
<div class="col-md-12">		
    <div class="jarviswidget jarviswidget-color-blueDark">
        <header style="height: 54px;"><h2><i class="fa fa-calendar"></i> Календарь событий монтажа.</h2></header>
		<div id='calendar' ></div>
		<div style='clear:both'></div>
    </div>
</div>


</div>
</div>

<!---**************************
|      Форма календаря        |
****************************-->

<div id="dialog-form" title="Событие">
    <p class="validateTips"></p>
    <form method="post" enctype="multipart/form-data">
        <p>
        	<label for="event_type">Тип события<span id="event_author"> (автор)<span></label>
    		<input type="text" class="form-control" name="event_type" id="form_event_type" value="" placeholder="Новое событие">
    	</p>
        <p>
        	<label for="event_start">Начало</label>
        	<input type="text" class="form-control" name="event_start" id="form_event_start" value="">
    	</p>
        <p>
        	<label for="event_end">Конец</label>
       		<input type="text" class="form-control" name="event_end" id="form_event_end" value="">
    	</p>
    	<p>
        	<label for="event_allday">Полный день</label>
       		<select class="form-control" name="event_allday" id="form_event_allday">
       			<option value="true"> Да</option>
       			<option value="false"> Нет</option>
       		</select>
    	</p>
    	<p>
        	<label for="event_description">Описание</label>
       		<textarea type="text" class="form-control" name="event_description" id="form_event_description" value="" placeholder="Описание">
            </textarea>
    	</p>
    	<p>
        	<label for="event_color">Цвет</label>
       		<select class="form-control"  name="event_color" id="form_event_color">
       			<option value="#3a87ad" style="color:#3a87ad;"> Синий</option>
       			<option value="#6495ED" style="color:#6495ED;"> Голубой </option>
       			<option value="#FF7F50" style="color:#FF7F50;"> Оранжевый</option>
       			<option value="#66CDAA" style="color:#66CDAA;"> Зеленый</option>
       		</select>
    	</p>
        <input type="hidden" name="event_id" id="event_id" value="">
    </form>
    <hr>
    <div id="form_file">
        <form id="form_f" method="post"  enctype="multipart/form-data" style="width: 100%; height: 31px;">
            <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
            <input type="file" name="userfile" multiple="multiple" style="width: 80%; float: left;">
            <div id="go_file" class="btn btn-info btn-xs" style="width: 19%; float: left;"><i class="fa fa-cloud-download"></i></div>
        </form>
    </div>

    <div id='arr_data' style="text-align: right;">
    </div>   

    <div class="ajax-respond"></div>


</div>