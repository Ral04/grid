<?php
header('Content-Type: text/html; charset=utf-8');
require_once ("inc/init.php");
?>
    <link rel="stylesheet" type="text/css" media="screen" href="lib_grid/css/ui.jqgrid.css" />
    <script type="text/javascript"src="lib_grid/js/i18n/grid.locale-ru.js" ></script>
    <script type="text/javascript"src="lib_grid/js/jquery.jqGrid.src.js" ></script>

    <script type="text/javascript">
      jQuery(document).ready(function(){
              var load_type = false;
              var lastSel;
              var mygrid =  jQuery("#list").jqGrid({
                    url:'lib_grid/projects/getdata_projects.php',
                    datatype: 'json',
                    height: 'auto',
                    mtype: 'POST',
                    colNames:['id','Проект','Договор','Стоимость','Оплачено','Комментарий','Start','End','Подрядчик','Город','Улица','Строение','url','Криент'],
                    colModel:[
                         {name:'id',                 index:'id',                 width:30,  editable:false, align:'center'}
                        ,{name:'project_title',      index:'project_title',      width:180, editable:false, align:'center'}
                        ,{name:'project_contract',   index:'project_contract',   width:180, editable:false, align:'center'}
                        ,{name:'project_ttlpay',     index:'project_ttlpay',     width:80,  editable:false, align:'center'}
                        ,{name:'project_pay',        index:'project_pay',        width:80,  editable:false, align:'center'}
                        ,{name:'project_comm',       index:'project_comm',       width:180, editable:false, align:'center'}
                        ,{name:'project_start',      index:'project_start',      width:100, editable:false, align:'center'}
                        ,{name:'project_end',        index:'project_end',        width:100, editable:false, align:'center'}
                        ,{name:'project_contractor', index:'project_contractor', width:180, editable:false, align:'center'}
                        ,{name:'project_sity',       index:'project_sity',       width:180, editable:false, align:'center'}
                        ,{name:'project_street',     index:'project_street',     width:180, editable:false, align:'center'}
                        ,{name:'project_building',   index:'project_building',   width:180, editable:false, align:'center'}
                        ,{name:'url',                index:'url',                width:80,  editable:'select', formatter:'showlink', align:'center', formatoptions:{baseLinkUrl:'#ajax/proj_detailed_view.php'}}
                        ,{name:'name_client',        index:'name_client',        width:180, editable:false, align:'center'}
                    ],
                    pager: '#pager',
                    loadonce:load_type,//для фитра
                    rowNum: 30,
                    rowList :[30,50,100],
                    sortname: 'id',
                    sortorder: "asc",
                    viewrecords: true,
                    rownumbers: false,
                    gridview: true,
                    caption: 'Проекты',

                    ondblClickRow: function(id) {
                        if (id && id != lastSel) {
                            jQuery("#list").restoreRow(lastSel);
                            jQuery("#list").editRow(id, true);
                            lastSel = id;
                        }
                    },
                    editurl: 'lib_grid/projects/severow_projects.php'
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

        function AjaxFormRequest() {
            var cname = $( '#clients_name' ).val();
                if (cname.length > 0){
                        $('#mess_client').append('Контрогент добавлен <i class="fa fa-smile-o" style="color: #51D600;"></i><br>');
                            jQuery.ajax({
                                url:      "lib_grid/clients/saverow_clients_ajax.php", //Адрес подгружаемой страницы
                                type:     "POST", //Тип запроса
                                dataType: "html", //Тип данных
                                data: jQuery("#" + "aform").serialize(),
                                success: function(response) { //Если все нормально
                                   document.getElementById("result").innerHTML = response;
                                },

                                error: function(response) { //Если ошибка
                                    document.getElementById("result").innerHTML = "Error sent form";
                                }
                             });
                } else{
                        $('#mess_client').html('Название пустрое <i class="fa fa-meh-o" style="color: #F00;"></i><br>');
                    }
        }

    </script>



<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark"><i class="fa fa-briefcase"></i> Проекты <span>> Список проектов </span></h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
    </div>
</div>

<!--
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Добавить
</button>
-->


<!--***************************
|    Инициализация таблиц     |
****************************-->


<div class="well">
    <section id="widget-grid" class="">
    	<div class="row">
    		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table id="list" class="scroll"></table>
                <div id="pager" class="scroll" style="text-align:center;"></div>
    		</article>
    	</div>
    </section>
</div>


<!--***************************
|            Modal            |
****************************-->
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
                        <select class="input form-control" name="id_clients" required>
                            <option value="Исполнители:">Клиенты:</option>
                            <option id="result">

                            </option>
                            <?php foreach($clients_select as $item): ?>
                            <option value="<?=$item['id']?>"><?=$item['name_clients']?></option>
                            <?php endforeach; ?>

                        </select><br>
                        <input class="btn btn-primary" style='padding:10px 22px;' type="submit" value="Добавить Задачу">
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="for_clients"><br>
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
