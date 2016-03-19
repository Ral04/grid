<?php
header('Content-Type: text/html; charset=utf-8');
require_once ("inc/init.php");
include ("../lib_grid/tasks/select_executors.php");
include ("../lib_grid/tasks/select_managers.php");
include ("../lib_grid/tasks/select_clients.php");
?>
    <link rel="stylesheet" type="text/css" media="screen" href="lib_grid/css/ui.jqgrid.css" />
    <!--подключаем js jQueru и плагины грида-->
    <!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript"src="lib_grid/js/i18n/grid.locale-ru.js" ></script>
    <script type="text/javascript"src="lib_grid/js/jquery.jqGrid.src.js" ></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
                var lastSel;
                jQuery("#list").jqGrid({
                    url:'lib_grid/tasks/getdata_tasks.php',
                    datatype: 'json',
                    height: 'auto',
                    mtype: 'POST',
                    colNames:['id','Клиенты','Задача','Тип','Стоимость','Статус','Оплата','Дата start','Дата end','Исполнитель','Менеджеры'],
                    colModel :[
                         {name:'id',                 index:'id',                 width:30,  align:'center'}
                        ,{name:'name_clients',       index:'name_clients',       width:140, align:'left',   editable:false, edittype:"text"}
                        ,{name:'type_tasks',         index:'type_tasks',         width:200, align:'left',   editable:false, edittype:"text"}
                        ,{name:'comm_type_tasks',    index:'comm_type_tasks',    width:160, align:'center', editable:false, edittype:"text"}
                        ,{name:'price_tasks',        index:'price_tasks',        width:100, align:'right',  editable:false, sorttype:'number',formatter:'number', summaryType:'sum'}
                         
                        ,{name:'statust_tasks',      index:'statust_tasks',      width:100, align:'center', editable:false, edittype:"text"}
                        ,{name:'payment_tasks',      index:'payment_tasks',      width:100, align:'center', editable:false, edittype:"text"}
                        ,{name:'start_date_tasks',   index:'start_date_tasks',   width:100, align:'right',  editable:false, formatter:'date'}
                        ,{name:'end_date_tasks',     index:'end_date_tasks',     width:100, align:'right',  editable:false, formatter:'date'}
                        ,{name:'name_executors',     index:'name_executors',     width:200, align:'left',   editable:false, edittype:"text"}
                        ,{name:'name_managers',      index:'name_managers',      width:200, align:'left',   editable:false, edittype:"text"}
                        
                        ],
                    pager: jQuery('#pager'),
                    loadonce:true,//для фитра 
                    rowNum:100,
                    rowList:[50,100],
                    sortname: 'id',
                    sortorder: "asc",
                    viewrecords: true,
                    caption: 'Задачи',
                       grouping: true,
                        groupingView : {
                            groupField : ['name_executors'],
                            groupColumnShow : [true],
                            groupText : ['<b>{0}</b>'],
                            groupCollapse : false,
                            groupOrder: ['asc'],
                            groupSummary : [true],
                            groupDataSorted : true
                        },
                    ondblClickRow: function(id) {
                        if (id && id != lastSel) {
                            jQuery("#list").restoreRow(lastSel);
                            jQuery("#list").editRow(id, true);
                            lastSel = id;
                        }
                    },
                    editurl: 'lib_grid/tasks/saverow_tasks.php'
                });
                jQuery("#list").jqGrid('filterToolbar',{searchOperators : true});//для фитра 
            }); 
    </script>

<h2>Задачи</h2>
<p>*Для редактирования ячейки необходимо нажать на нее два раза левой кнопкой мыши</p>
<p>*Формат даты: <b>ГОД-МЕСЯЦ-ДЕНЬ</b> Пример 2015-07-13</p> 

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Добавить</button>
<br>

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
<br>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Форма ввода новых Задач</h4>
      </div>
      <div class="modal-body">
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
                <?php foreach($clients_select as $item): ?>
                <option value="<?=$item['id']?>"><?=$item['name_clients']?></option>
                <?php endforeach; ?>
            </select><br>
            <input class="btn btn-primary" style='padding:10px 22px;' type="submit" value="Добавить">
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>