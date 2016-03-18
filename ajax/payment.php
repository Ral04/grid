<?php
header('Content-Type: text/html; charset=utf-8');
require_once ("inc/init.php");
include ("../lib_grid/payment/select_executors.php");
include ("../lib_grid/payment/select_managers.php");
include ("../lib_grid/payment/select_clients.php");

$rights = $_COOKIE['fortask'];


    if($rights == "direktor@bilbordtv.ru" 
    || $rights == 'mag@bilbordtv.ru' 
    || $rights == 'beta'
    || $rights == 'Znatnova'
    ){
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
                    url:'lib_grid/payment/getdata_tasks.php',
                    datatype: 'json',
                    mtype: 'POST',
                    colNames:['id','Оплата','Клиенты','Задача','Тип','Стоимость','Статус','Дата start','Дата end','Исполнитель','Менеджеры'],
                    colModel :[
                         {name:'id',                 index:'id',                 width:30,  align:'center'}
                        ,{name:'payment_tasks',      index:'payment_tasks',      width:100, align:'center', editable:true, edittype:"text"}
						,{name:'name_clients',       index:'name_clients',       width:140, align:'left', editable:true, edittype:"text"}
                        ,{name:'type_tasks',         index:'type_tasks',         width:200, align:'left', editable:true, edittype:"text"}
                        ,{name:'comm_type_tasks',    index:'comm_type_tasks',    width:160, align:'center', editable:true, edittype:"text"}
                        ,{name:'price_tasks',        index:'price_tasks',        width:100, align:'right', editable:true, edittype:"text"}
                        ,{name:'statust_tasks',      index:'statust_tasks',      width:100, align:'right', editable:true, edittype:"text"}
                        ,{name:'start_date_tasks',   index:'start_date_tasks',   width:100, align:'right', editable:true, edittype:"text"}
                        ,{name:'end_date_tasks',     index:'end_date_tasks',     width:100, align:'right', editable:true, edittype:"text"}
                        ,{name:'name_executors',     index:'name_executors',     width:200, align:'left', editable:true, edittype:"text"}
                        ,{name:'name_managers',      index:'name_managers',      width:200, align:'left', editable:true, edittype:"text"}
                        ],
                    pager: jQuery('#pager'),
                    loadonce:true,//для фитра 
                    rowNum:30,
                    rowList:[50,100],
                    sortname: 'id',
                    sortorder: "asc",
                    viewrecords: true,
                    caption: 'Задачи',
                    ondblClickRow: function(id) {
                        if (id && id != lastSel) {
                            jQuery("#list").restoreRow(lastSel);
                            jQuery("#list").editRow(id, true);
                            lastSel = id;
                        }
                    },
                    editurl: 'lib_grid/payment/saverow_tasks.php'
                });
                jQuery("#list").jqGrid('filterToolbar',{searchOperators : true});//для фитра 
            }); 
    </script>

<h2>Данные по оплате</h2>
<p>Оплаченным работам в столбце <b>Оплата</b> присвоить: «<b>Да</b>» или «<b>Оплачено</b>».</p>

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
<!-- Button trigger modal -->
<?php
}else{print("<i class=\"fa fa-exclamation-triangle\"></i> Нет доступа.");}
?>