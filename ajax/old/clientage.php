<?php
require_once ("inc/init.php");
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
                    url:'lib_grid/getdata_clientage.php',
                    datatype: 'json',
                    mtype: 'POST',
                    colNames:['#', 'ФИО', 'Паспорт Серия/Номер', 'Выдан кем/когда', 'Код под.', 'Адрес', 'Телефон'],
                    colModel :[
                        {name:'id', index:'id', width:30, align:'center'}
                        ,{name:'column1', index:'column1', width:200, align:'right', editable:true, edittype:"text"}
                        ,{name:'column2', index:'column2', width:180, align:'right', editable:true, edittype:"text"}
                        ,{name:'column3', index:'column3', width:220, align:'right', editable:true, edittype:"text"}
                        ,{name:'column4', index:'column4', width:100, align:'right', editable:true, edittype:"text"}
                        ,{name:'column5', index:'column5', width:220, align:'right', editable:true, edittype:"text"}
                        ,{name:'column6', index:'column6', width:160, align:'right', editable:true, edittype:"text"}
                        ],
                    pager: jQuery('#pager'),
                    rowNum:30,
                    rowList:[50,100],
                    sortname: 'id',
                    sortorder: "asc",
                    viewrecords: true,
                    caption: 'Клиенты',
                    ondblClickRow: function(id) {
                        if (id && id != lastSel) {
                            jQuery("#list").restoreRow(lastSel);
                            jQuery("#list").editRow(id, true);
                            lastSel = id;
                        }
                    },
                    editurl: 'lib_grid/saverow_clientage.php'
                }); 
            }); 
    </script>
    <!-- row -->
    <div class="row">
	<!-- col -->
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><!-- PAGE HEADER --><i class="fa-fw fa fa-home"></i> Таблицы <span>> Клиенты </span></h1>
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
<br><h2>Форма ввода новых Клиентов</h2>
<form method="post" class="smart-form" action="lib_grid/form_clientage.php" accept-charset="utf-8">
    <input type="text" class="input" size="100" name="column1" placeholder="ФИО:"><br>
    <input type="text" class="input" size="100" name="column2" placeholder="Паспорт Серия/Номер:"><br>
    <input type="text" class="input" size="100" name="column3" placeholder="Выдан кем/когда:"><br>
    <input type="text" class="input" size="100" name="column4" placeholder="Код под.:"><br>
    <input type="text" class="input" size="100" name="column5" placeholder="Адрес:"><br>
    <input type="text" class="input" size="100" name="column6" placeholder="Телефон:"><br>
    <input class="btn btn-primary" style='padding:10px 22px;' type="submit" value="Добавить контрогента">
</form><br>