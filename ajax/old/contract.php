<?php
require_once ("inc/init.php");
include ("../lib_grid/select_contract.php");
include ("../lib_grid/select_clientage.php");
?>
   
    <!--<link rel="stylesheet" type="text/css" media="screen" href="lib_grid/css/excite-bike/jquery-ui-1.10.3.custom.css" />-->
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
                url:'lib_grid/getdata_contract.php',
                datatype: 'json',
                mtype: 'POST',
                colNames:['#', 'Номер договора', 'Контрагент', 'Примечание', 'Предмет договора', 'Дата заключения', 'Дата расторжения', 'Сумма с НДС', 'Условия оплаты', 'Состояние'],
                colModel :[
                    {name:'id', index:'id', width:50, align:'right', search:false}
                    ,{name:'number', index:'number', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'partner', index:'partner', width:200, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'note', index:'note', width:200, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'subject', index:'subject', width:140, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'date_conclusion', index:'date_conclusion', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'date_termination', index:'date_termination', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'sum_with_vat', index:'sum_with_vat', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'terms_payment', index:'terms_payment', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'status', index:'status', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}

                    ],
                pager: jQuery('#pager_con'),
                rowNum:30,
                rowList:[50,100],
                sortname: 'id',
                sortorder: "asc",
                viewrecords: true,
                caption: 'Договора',
                ondblClickRow: function(id) {
                    if (id && id != lastSel) {
                        jQuery("#list").restoreRow(lastSel);
                        jQuery("#list").editRow(id, true);
                        lastSel = id;
                    }
                },
                editurl: 'lib_grid/saverow_contract.php'
            })
                .navGrid('#pager_con',{view:false, del:false, add:false, edit:false}, 
                {}, //  default settings for edit
                {}, //  default settings for add
                {},  // delete instead that del:false we need this
                {closeOnEscape:true, multipleSearch:true, closeAfterSearch:true}, // search options
                {} /* view parameters*/
            ); 
        }); 
        </script>
    <!-- row -->
    <div class="row">
	<!-- col -->
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><!-- PAGE HEADER --><i class="fa-fw fa fa-home"></i> Таблицы <span>> Контракты </span></h1>
	</div>
	<!-- end col -->
	<!-- right side of the page with the sparkline graphs -->
	<!-- col -->
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
		<!-- sparks -->
		<!--<ul id="sparks">
			<li class="sparks-info">
				<h5> My Income <span class="txt-color-blue">$47,171</span></h5>
				<div class="sparkline txt-color-blue hidden-mobile hidden-md hidden-sm">
					1300, 1877, 2500, 2577, 2000, 2100, 3000, 2700, 3631, 2471, 2700, 3631, 2471
				</div>
			</li>
			<li class="sparks-info">
				<h5> Site Traffic <span class="txt-color-purple"><i class="fa fa-arrow-circle-up" data-rel="bootstrap-tooltip" title="Increased"></i>&nbsp;45%</span></h5>
				<div class="sparkline txt-color-purple hidden-mobile hidden-md hidden-sm">
					110,150,300,130,400,240,220,310,220,300, 270, 210
				</div>
			</li>
			<li class="sparks-info">
				<h5> Site Orders <span class="txt-color-greenDark"><i class="fa fa-shopping-cart"></i>&nbsp;2447</span></h5>
				<div class="sparkline txt-color-greenDark hidden-mobile hidden-md hidden-sm">
					110,150,300,130,400,240,220,310,220,300, 270, 210
				</div>
			</li>
		</ul>
		-->
		<!-- end sparks -->
	</div>
	<!-- end col -->
    </div>
    <!-- end row -->
    <!--
    The ID "widget-grid" will start to initialize all widgets below
    You do not need to use widgets if you dont want to. Simply remove
    the <section></section> and you can use wells or panels instead
    -->
    <!-- widget grid -->
    <section id="widget-grid" class="">
	<!-- row -->
	<div class="row">
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table id="list" class="scroll"></table> 
            <div id="pager_con" class="scroll" style="text-align:center;">
		</article>
		<!-- WIDGET END -->
	</div>
	<!-- end row -->
    </section>
    <!-- end widget grid -->

    <br><p>Для редактирования ячейки необходимо нажать на нее два раза левой кнопкой мыши</p> 
    <br><h2>Форма ввода новых договоров</h2>
    <form name="forform" class="smart-form" method="post" action="lib_grid/form_contract.php" accept-charset="utf-8">
        <input type="text" class="input" size="100"  name="number" placeholder="Номер договора"><br>
        <select class="input" name="partner" required>    
            <option value="Контрагенты:">Контрагенты:</option>
            <?php foreach($bazasotrudnikov as $item): ?>
            <option value="<?=$item['column1']?>"><?=$item['column1']?></option>
            <?php endforeach; ?>
            <option value="Физ.лица:">--Физ.лица:--</option>
            <?php foreach($bazasotrudnikovclientage as $itemc): ?>
            <option value="<?=$itemc['column1']?>"><?=$itemc['column1']?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="text" class="input" size="100" name="note" placeholder="Примечание"><br>
        <input type="text" class="input" size="100" name="subject" placeholder="Предмет договора"><br>
        <input type="text" class="input" size="100" name="date_conclusion" placeholder="Дата заключения"><br>
        <input type="text" class="input" size="100" name="date_termination" placeholder="Дата расторжения"><br>
        <input type="text" class="input" size="100" name="sum_with_vat" placeholder="Сумма с НДС"><br>
        <input type="text" class="input" size="100" name="terms_payment" placeholder="Условия оплаты"><br>
        <select class="input" name="status" required>    
            <option value="Статтус:">Статус:</option>
            <option value="Действующий">Действующий</option>
            <option value="Приостановлен">Приостановлен</option>
            <option value="Расторгнут">Расторгнут</option>
        </select><br>
        <button class="btn btn-primary" style='padding:10px 22px;'  type="submit" title="элемент button">Добавить договор</button>
    </form><br>
