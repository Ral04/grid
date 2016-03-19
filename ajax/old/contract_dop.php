<?php
require_once ("inc/init.php");
include ("../lib_grid/select_contract.php");
include ("../lib_grid/select_clientage.php");
include ("../lib_grid/select_contract_dop.php");
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
                url:'lib_grid/getdata_contract_dop.php',
                datatype: 'json',
                mtype: 'POST',
                colNames:['ID', 'Номер договора',  'IDдог', 'Номер Доп.соглашения', 'Контрагент', 'Предмет договора', 'Дата заключения', 'Дата расторжения', 'Сумма с НДС', 'Условия оплаты', 'Состояние', 'Примечания'],
                colModel :[
                     {name:'id', index:'id', width:30, align:'right', search:false}
                    ,{name:'number_con', index:'number_con', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'id_con', index:'id_con', width:30, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'number_ext', index:'number_ext', width:200, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'partner', index:'partner', width:200, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'subject', index:'subject', width:140, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'date_conclusion', index:'date_conclusion', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'date_termination', index:'date_termination', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'sum_with_vat', index:'sum_with_vat', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'terms_payment', index:'terms_payment', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'status', index:'status', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ,{name:'note', index:'note', width:100, align:'right', editable:true, edittype:"text", searchoptions:{sopt:['eq','ne','bw','cn']}}
                    ],
                pager: jQuery('#pager'),
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
                editurl: 'lib_grid/saverow_contract_dop.php'
            })
                .navGrid('#pager',{view:false, del:false, add:false, edit:false}, 
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
		<h1 class="page-title txt-color-blueDark"><!-- PAGE HEADER --><i class="fa-fw fa fa-home"></i> Таблицы <span>> Доп. Договора </span></h1>
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
                <div id="pager" class="scroll" style="text-align:center;">
    		</article>
    		<!-- WIDGET END -->
    	</div>
    	<!-- end row -->
    </section>
    <!-- end widget grid -->
    <br><p>Для редактирования ячейки необходимо нажать на нее два раза левой кнопкой мыши</p> 
    <br><h2>Форма ввода новых Дополнительных Договоров</h2>
    <script type="text/javascript">
        function process(formObj)
            { var F=formObj.TooInOne;
                if(F.selectedIndex==0){return;}
                formObj.id_con.value=F.options[F.selectedIndex].value;
                formObj.number_con.value=F.options[F.selectedIndex].text;
            }
    </script>
    <form name="forform" class="smart-form" method="post" action="lib_grid/form_contract_dop.php" accept-charset="utf-8">
    <select class="input" name="TooInOne" onchange="process(this.form)">
        <option value="Номер Договора">Номер Договора:</option>
        <?php foreach($bazakontraktov as $item): ?>
        <option value="<?=$item['id']?>"><?=$item['number']?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="hidden" value="id_con" name="id_con">
    <input type="hidden" value="number_con" name="number_con">
    <input type="text" class="input" size="100" name="number_ext" placeholder="Номер Доп.соглашения"><br>
    <select name="partner" class="input" required>    
        <option value="Контрагенты:">Контрагенты:</option>
        <?php foreach($bazasotrudnikov as $item): ?>
        <option value="<?=$item['column1']?>"><?=$item['column1']?></option>
        <?php endforeach; ?>
        <option value="Физ.лица:">--Физ.лица:--</option>
        <?php foreach($bazasotrudnikovclientage as $itemc): ?>
        <option value="<?=$itemc['column1']?>"><?=$itemc['column1']?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="text" class="input" size="100" name="subject" placeholder="Предмет доп. дог"><br>
    <input type="text" class="input" size="100" name="date_conclusion" placeholder="Дата заключения"><br>
    <input type="text" class="input" size="100" name="date_termination" placeholder="Дата расторжения"><br>
    <input type="text" class="input" size="100" name="sum_with_vat" placeholder="Сумма с НДС"><br>
    <input type="text" class="input" size="100" name="terms_payment" placeholder="Условия оплаты"><br>
    <select name="status" class="input" required>    
        <option value="Статтус:">Статус:</option>
        <option value="Действующий">Действующий</option>
        <option value="Приостановлен">Приостановлен</option>
        <option value="Расторгнут">Расторгнут</option>
    </select><br>
    <input type="text" size="100" class="input" name="note" placeholder="Примечание"><br>
    <button class="btn btn-primary" style='padding:10px 22px;' type="submit" title="элемент button">Добавить договор</button>
    </form>