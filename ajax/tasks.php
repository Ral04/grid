<?php
// tasks
header('Content-Type: text/html; charset=utf-8');
require_once ("inc/init.php");
include ("../lib_grid/tasks/select_executors.php");
include ("../lib_grid/tasks/select_managers.php");
include ("../lib_grid/tasks/select_clients.php");
?>
    <link rel="stylesheet" type="text/css" media="screen" href="lib_grid/css/ui.jqgrid.css" />
    <!--подключаем js jQueru и плагины грида-->
    <!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
    <!--<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>-->
    <script type="text/javascript"src="lib_grid/js/i18n/grid.locale-ru.js" ></script>
    <script type="text/javascript"src="lib_grid/js/jquery.jqGrid.src.js" ></script>
    <!--
    <script type="text/javascript"src="/lib_grid/js/grid480/js/jquery.jqGrid.min.js" ></script>
    <script type="text/javascript"src="/lib_grid/js/grid480/js/i18n/grid.locale-ru.js" ></script>
    -->
    <script type="text/javascript">
      jQuery(document).ready(function(){
              var load_type = false;
              var lastSel;
              var mygrid =  jQuery("#list").jqGrid({
                    url:'lib_grid/tasks/getdata_tasks.php',
                    datatype: 'json',
                    height: 'auto',
                    mtype: 'POST',
                    colNames:['id','Клиенты','Задача','Тип','Стоимость','Статус','Оплата','Дата start','Дата end','Исполнитель','Менеджеры'],
                    colModel :[
                         {name:'id',                 index:'id',                 width:30,  align:'center'}
                        ,{name:'name_clients',       index:'name_clients',       width:140, align:'left',   editable:false, edittype:"text"}
                        ,{name:'type_tasks',         index:'type_tasks',         width:200, align:'left',   editable:true,  edittype:"text"}
                        ,{name:'comm_type_tasks',    index:'comm_type_tasks',    width:160, align:'center', editable:true,  edittype:"select",editoptions:{value:"Коммерческий:Коммерческий;Внутренний:Внутренний"}}
                        ,{name:'price_tasks',        index:'price_tasks',        width:100, align:'right',  editable:true,  sorttype:'number',formatter:'number', summaryType:'sum'}
                        ,{name:'statust_tasks',      index:'statust_tasks',      width:100, align:'center', editable:true,  edittype:"select",editoptions:{value:"В работе:В работе;Завершена:Завершена"}}
                        ,{name:'payment_tasks',      index:'payment_tasks',      width:100, align:'center', editable:true,  edittype:"checkbox",editoptions: {value:"Да:Нет"}}
                        ,{name:'start_date_tasks',   index:'start_date_tasks',   width:100, align:'right',  editable:true,  formatter:'date'}
                        ,{name:'end_date_tasks',     index:'end_date_tasks',     width:100, align:'right',  editable:true,  formatter:'date'}
                        ,{name:'name_executors',     index:'name_executors',     width:200, align:'left',   editable:true,  edittype:"select",editoptions:{value:"1:Гераскин Максим Андреевич;2:Четверик Эдуард Николаевич;3:Мамедов Теймур Илгамович"}}
                        ,{name:'name_managers',      index:'name_managers',      width:200, align:'left',   editable:true,  edittype:"select",editoptions:{value:"1:Константинов Алексей;2:Панзин Сергей Александрович;3:Кондаков Василий Сергеевич;4:Голобурдина Анна Николаевна;5:Ефимов Александр Сергеевич;6:Воронцов Илья Константинович;7:Гераскин Максим Андреевич;8:Жигульский Павел;9:Мустофинов Александр; 10:Взоров Андрей Викторович; 11:Мамедов Теймур Илгамович"}}
                        ],
                    pager: '#pager',
                    loadonce:load_type,//для фитра
                    rowNum:30,
                    rowList:[30,50,100],
                    sortname: 'id',
                    sortorder: "asc",
                    viewrecords: true,
                    //rownumbers: true,
                    gridview : true,
                    caption: 'Задачи',
                    ondblClickRow: function(id) {
                        if (id && id != lastSel) {
                            jQuery("#list").restoreRow(lastSel);
                            jQuery("#list").editRow(id, true);
                            lastSel = id;
                        }
                    },
                    editurl: 'lib_grid/tasks/saverow_tasks.php'
                });
            //jQuery("#list").jqGrid('filterToolbar',{searchOperators : true});//для фитра
            });
    </script>

    <script type="text/javascript">
    $('#myTabs a').click(function (e) {
      e.preventDefault()
        $(this).tab('show')
    })
    </script>

    <script type="text/javascript">
        // Добавление нового контарогента.
        function AjaxFormRequest() {
            var cname = $( '#clients_name' ).val();
                if (cname.length > 0){
                        $('#mess_client').append('Контрогент добавлен <i class="fa fa-smile-o" style="color: #51D600;"></i><br>');
                            jQuery.ajax({
                                url:      "lib_grid/clients/saverow_clients_ajax.php", //Адрес подгружаемой страницы
                                type:     "POST", //Тип запроса
                                dataType: "html", //Тип данных
                                data: jQuery("#" + "aform").serialize(),
                                success: function(result) { //Если все нормально
                                    //$('#result').val(response);
                                    //$('#result').html('Последний добавленный (' + response +')');
                                    result_data = JSON.parse(result);
                                    $( "#clits" ).append("<option>"+result_data.name+" ("+result_data.id+")</option>");
                                    //console.log(result_data.id);
                                    //console.log(result_data.name);
                                },
                                error: function(result) { //Если ошибка
                                    document.getElementById("result").innerHTML = "Error sent form";
                                }
                             });
                } else{
                        $('#mess_client').html('Название пустрое <i class="fa fa-meh-o" style="color: #F00;"></i><br>');
                    }
        }
    </script>

<h2>Задачи отдела дизайна</h2>
<p>*Для редактирования ячейки необходимо нажать на нее два раза левой кнопкой мыши</p>
<p>*Формат даты: <b>ГОД-МЕСЯЦ-ДЕНЬ</b> Пример 2015-07-13</p>
<!-- Button trigger modal -->
<p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Добавить
</button>

<!--<button type="button" class="btn btn-primary" id='filter_serch' >
  Фильтр поиска
</button>
-->
</p>


<!-- widget grid -->
<section id="widget-grid" class="">
	<!-- row -->
	<div class="row">
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table id="list" class="scroll"></table>
            <div id="pager" class="scroll" style="text-align:center;"></div>
		</article>
		<!-- WIDGET END -->
	</div>
	<!-- end row -->
</section>
<!-- end widget grid -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Форма ввода новых Задач</h4>
      </div>

    <div class="modal-body">
        <div>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#for_mtasks" aria-controls="for_mtasks" role="tab" data-toggle="tab">Добавить задачу</a></li>
            <li role="presentation"><a href="#for_clients" aria-controls="for_clients" role="tab" data-toggle="tab">Добавить клиента</a></li>

          </ul>

          <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="for_mtasks"><br>
                    <!--Добавление новой задачи-->
                    <form method="post"  action="lib_grid/tasks/form_tasks.php" accept-charset="utf-8">
                        <input type="text" class="input form-control" size="10" name="type_tasks"         placeholder=" Задача"><br>
                        <select class="input form-control" name="comm_type_tasks" required>
                            <option value="Нет данных">Комерция:</option>
                            <option value="Коммерческий">Коммерческий</option>
                            <option value="Внутренний">Внутренний</option>
                        </select><br>
                        <input type="text" class="input form-control" size="10" name="price_tasks"        placeholder=" Цена"><br>
                        <select class="input form-control" name="statust_tasks" required>
                            <option value="Нет данных">Статус:</option>
                            <option value="В работе">В работе</option>
                            <option value="Завершена">Завершена</option>
                        </select><br>
                        <input type="date" class="input form-control" size="10" name="start_date_tasks"   placeholder=" Дата инизиализации"><br>
                        <input type="date" class="input form-control" size="10" name="end_date_tasks"     placeholder=" Дата завершения"><br>

                        <select class="input form-control" name="id_executots" required>
                            <option value="Исполнители:">Исполнители:</option>
                            <?php foreach($executors_select as $item): ?>
                            <option value="<?=$item['id']?>"><?=$item['name_executors']?></option>
                            <?php endforeach; ?>
                        </select><br>
                        <select class="input form-control" name="id_managers" required>
                            <option value="Исполнители:">Менеджеры:</option>
                            <?php foreach($managers_select as $item): ?>
                            <option value="<?=$item['id']?>"><?=$item['name_managers']?></option>
                            <?php endforeach; ?>
                        </select><br>

                        <input list="clits" class="input form-control" name="id_clients" required>
                        <datalist id="clits">
                            <?php foreach($clients_select as $item): ?>
                                <option><?=$item['name_clients']?> (<?=$item['id']?>)</option>
                            <?php endforeach; ?>
                        </datalist><br>



                        <input class="btn btn-primary" style='padding:10px 22px;' type="submit" value="Добавить Задачу">
                    </form>


                </div>
                <div role="tabpanel" class="tab-pane" id="for_clients"><br>
                    <!-- Добавление нового контарогента-->
                    <form method="post" class="smart-form" id="aform"  accept-charset="utf-8">
                        <input id='clients_name' type="text" class="input form-control" size="10" name="name_clients"    placeholder=" Название:"><br>
                        <input type="text" class="input form-control" size="10" name="address_clients" placeholder=" Адрес:"><br>
                        <input type="text" class="input form-control" size="10" name="phone_clients"   placeholder=" Телефон:"><br>
                        <input type="text" class="input form-control" size="10" name="bank_clients"    placeholder=" Банк:"><br>
                        <input type="text" class="input form-control" size="10" name="account_clients" placeholder=" Р/С:"><br>
                        <input type="text" class="input form-control" size="10" name="bik_clients"     placeholder=" БИК:"><br>
                        <input type="text" class="input form-control" size="10" name="k_c_clients"     placeholder=" К/С:"><br>
                        <input type="text" class="input form-control" size="10" name="inn_clients"     placeholder=" ИНН:"><br>
                        <input type="text" class="input form-control" size="10" name="kpp_clients"     placeholder=" КПП:"><br>
                        <!--<input class="btn btn-primary" style='padding:10px 22px;' type="submit" value="Добавить контрогента">-->
                        <div id='mess_client'></div>
                        <input  type="button" class="btn btn-primary" style='padding:10px 22px;' value="Добавить контрогента" onclick="AjaxFormRequest()" />
                    </form>


                </div>
            </div>



        </div>
        </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
