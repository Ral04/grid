<?php
//accounting_desigaen
	header('Content-Type: text/html; charset=utf-8');
	require_once ("inc/init.php");
  include ("../lib_grid/tasks/select_clients.php"); //Список клиентов для поиска
?>

<link rel="stylesheet" type="text/css" media="screen" href="lib_grid/css/ui.jqgrid.css" />
<script type="text/javascript"src="lib_grid/js/i18n/grid.locale-ru.js" ></script>
<script type="text/javascript"src="lib_grid/js/jquery.jqGrid.src.js" ></script>

<script type="text/javascript">
      jQuery(document).ready(function(){

              var lastSel;
              jQuery('#list').jqGrid({
                    url:'lib_grid/accounting/getdata_tasks_accounting.php',
                    datatype: 'json',
                    height: 'auto',

                    colNames:['id','Клиенты','Задача','Тип','Стоимость','Статус','Оплата','Дата start','Дата end','Исполнитель','Менеджеры','Номер счета'],
                    colModel :[
                         {name:'id',                 index:'id',                 width:30,  align:'center', sorttype:'int'}
                        ,{name:'name_clients',       index:'name_clients',       width:140, align:'left',   editable:false, edittype:'text'}
                        ,{name:'type_tasks',         index:'type_tasks',         width:200, align:'left',   editable:true,  edittype:'text'}
                        ,{name:'comm_type_tasks',    index:'comm_type_tasks',    width:160, align:'center', editable:true,  edittype:'select', editoptions:{value:'Коммерческий:Коммерческий;Внутренний:Внутренний'}}
                        ,{name:'price_tasks',        index:'price_tasks',        width:100, align:'right',  editable:true,  sorttype:'number', formatter:'integer', summaryType:'sum'}
                        ,{name:'statust_tasks',      index:'statust_tasks',      width:100, align:'center', editable:true,  edittype:'select', editoptions:{value:'В работе:В работе;Завершена:Завершена'}}
                        ,{name:'payment_tasks',      index:'payment_tasks',      width:90,  align:'center', editable:true,  edittype:'checkbox', editoptions: {value:'Да:Нет'}}
                        ,{name:'start_date_tasks',   index:'start_date_tasks',   width:100, align:'right',  editable:true,  formatter:'date'}
                        ,{name:'end_date_tasks',     index:'end_date_tasks',     width:100, align:'right',  editable:true,  formatter:'date'}
                        ,{name:'name_executors',     index:'name_executors',     width:200, align:'left',   editable:true,  edittype:'select',editoptions:{value:'1:Гераскин Максим Андреевич;2:Четверик Эдуард Николаевич;3:Мамедов Теймур Илгамович'}}
                        ,{name:'name_managers',      index:'name_managers',      width:200, align:'left',   editable:true,  edittype:'select',editoptions:{value:'1:Константинов Алексей;2:Панзин Сергей Александрович;3:Кондаков Василий Сергеевич;4:Голобурдина Анна Николаевна;5:Ефимов Александр Сергеевич;6:Воронцов Илья Константинович;7:Гераскин Максим Андреевич;8:Жигульский Павел;9:Мустофинов Александр; 10:Взоров Андрей Викторович'}}
                        ,{name:'bill_tasks',         index:'bill_tasks',         width:110, align:'right',  editable:true,  edittype:'text'}
                        ],

                    rowNum:50,
                    rowTotal: 20000,
                    rowList:[50,100,150],
                    loadonce:false,
                        mtype: 'POST',
                    rownumWidth: 40,
                    viewrecords: true,
                    //rownumbers: true,
                    gridview : true,
                        pager: '#pager',
                        sortname: 'id',
                        //viewrecords: true,
                        sortorder: 'asc',
                    caption: 'Для счетов',
                    footerrow: true,
                    loadComplete: function () {
                        var $self = $(this),
                            sum = $self.jqGrid("getCol", "price_tasks", false, "sum");
                        $self.jqGrid("footerData", "set", {comm_type_tasks: "Итого:", price_tasks: sum});
                    },
                    ondblClickRow: function(id) {
                        if (id && id != lastSel) {
                            jQuery('#list').restoreRow(lastSel);
                            jQuery('#list').editRow(id, true);
                            lastSel = id;
                        }
                    },
                    editurl: 'lib_grid/accounting/saverow_tasks_accounting.php'
                });
            //jQuery("#list").jqGrid('filterToolbar',{searchOperators : true});//для фитра
           //jQuery("#list").jqGrid('navGrid','#pager',{del:false,add:false,edit:false},{},{},{},{multipleSearch:true});


           //jQuery("#list").getGridParam("reccount")
	});

</script>

<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-sitemap"></i> Бухгалтерия <span>>  Выставление счетов (Дизайн)  </span></h1>
	</div>
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
	</div>
</div>

<div class="well">
	<section id="widget-grid" class="">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <form id="accounting-form" ation="javascript:void(0)">
                    <div class="form-group">
                        <p>Период:</p>
                        <input id="form_start" type="date">
                        <input id="form_end" type="date">
                        <input type="checkbox" id="without-bills"> Только без счетов.
                    </div>
                    <div class="form-group">
                        <p>Заказчик:</p>
                        <input list="clits" class="input form-control" name="id_clients" id="accounting_clients" required>
                        <datalist id="clits">
                            <?php foreach($clients_select as $item): ?>
                                <option><?=$item['name_clients']?> (<?=$item['id']?>)</option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <button type="button" id="send_form"  class="btn btn-info"><i class="fa fa-refresh"></i> Обновить</button>
                        <button type="button" id="for_print"  class="btn btn-success"><i class="fa fa-print"></i> На печать</button>
                    </div>
                </form>

                <br>
                <p id="print_client"></p>
                <p id="print_time"></p>
                <table id="list" class="scroll"></table>
            	<div id="pager" class="scroll" style="text-align:center;"></div>

			</article>
		</div>
	</section>
</div>

<script>
    $('#send_form').click(function(){
        var start  = $('#form_start').val();
        var end    = $('#form_end').val();
        var client = $("input[name*='id_clients']").val();
        var clientF = 0;

        if (client.length > 1) {
            var clientP1 = client.split("(");
            var clientP2 = clientP1[1].split(")");
            var clientF  = clientP2[0];
        }
        var bills    = $('#without-bills').is(':checked');
        jQuery("#list").jqGrid('setGridParam', { url: 'lib_grid/accounting/getdata_tasks_accounting.php?start='+start+'&end='+end+'&bill='+bills+'&client='+clientF}).trigger("reloadGrid");
    });

    $('#for_print').click(function(){
        var start  = $('#form_start').val();
        var end    = $('#form_end').val();
        if (start.length > 1 && end.length == 0){
            var rawDateString = start;
            var dateArray = rawDateString.split('-');
            var dateString = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
            $('#print_time').html('Периуд: c ' + dateString);
        } else if (start.length > 1 && end.length > 1){
            var rawDateString = start;
            var dateArray = rawDateString.split('-');
            var dateString = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
            $('#print_time').html('Периуд: c ' + start + ' по ' + end);
        }

        var client = $("input[name*='id_clients']").val();
        if (client.length > 1) {
            var clientP1 = client.split("(");
            var clientP2 = clientP1[0];
            $('#print_client').html('Клиент: ' + clientP2);
        }

        $('#main').css('margin-left', '0');
        window.print();
        $('#main').css('margin-left', '220px');
    });

</script>



<style>
    @media print{
        @page {size:landscape;}

        #left-panel,
        #ribbon,
        #shortcut,
        #header,
        #accounting-form,
        #pager,
        .page-footer,
        .page-title,
        .ui-widget-header{
            display: none !important;
        }

        td, .ui-jqgrid-sortable{
            border: 1px solid;
            min-height: 38px;
            padding: 2px;
        }
    }
</style>
