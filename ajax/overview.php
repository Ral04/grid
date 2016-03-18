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
    <!-- row -->
    <div class="row">
	<!-- col -->
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><!-- PAGE HEADER --><i class="fa-fw fa fa-home"></i> Таблицы <span>> Обзорная Таблица </span></h1>
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
                        <table id="listsg11"></table>
                        <div id="pagersg11"></div>
    		</article>
    		<!-- WIDGET END -->
    	</div>
    	<!-- end row -->
    </section>
    <!-- end widget grid -->
    <script type="text/javascript">
        jQuery("#listsg11").jqGrid({
        url:'lib_grid/getdata_paret_sub.php?q=1',
        datatype: "xml",
        //datatype: 'json',
        //mtype: 'POST',
        height: 320,
        colNames:['ID', 'Номер договора', 'Контрагент', 'Примечание', 'Предмет договора', 'Дата заключения', 'Дата расторжения', 'Сумма с НДС', 'Условия оплаты', 'Состояние'],
        colModel:[
        
          {name:'id', index:'id', width:50, align:'right', search:false},
            {name:'number',index:'number', width:100,align:"right" },
            {name:'partner',index:'partner', width:100, align:"right"},
            {name:'note',index:'note', width:120, align:"right"},
            {name:'subject',index:'subject', width:120, align:"right"},   
            {name:'date_conclusion',index:'date_conclusion', width:100, align:"right"},    
            {name:'date_termination',index:'date_termination', width:100, align:"right"},
            {name:'sum_with_vat',index:'sum_with_vat', width:100, align:"right"},   
            {name:'terms_payment',index:'terms_payment', width:100, align:"right"},   
            {name:'status',index:'status', width:100, align:"right"}
        ],
        rowNum:15,
        rowList:[30,50,100],
        pager: '#pagersg11',
        sortname: 'number',
        viewrecords: true,
        sortorder: "asc",
        multiselect: false,
        subGrid: true,
        caption: "Обзорная таблица",
        subGridRowExpanded: function(subgrid_id, row_id) {
        var subgrid_table_id, pager_id_sub;
        subgrid_table_id = subgrid_id+"_t";
        pager_id_sub = "p_"+subgrid_table_id;
        $("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id_sub+"' class='scroll'></div>");
        jQuery("#"+subgrid_table_id).jqGrid({
            url:"lib_grid/getdata_sub.php?q=2&id="+row_id,
            datatype: "xml",
            colNames:[ 'Номер договора', 'Номер Доп.соглашения', 'Контрагент', 'Предмет договора', 'Дата заключения', 'Дата расторжения', 'Сумма с НДС', 'Условия оплаты', 'Состояние', 'Примечания'],
            colModel: [
                {name:"number_con", index:"number_con", width:80, edittype:"text"},
                {name:"number_ext", index:"number_ext", width:80, align:"right"},
                {name:"partner", index:"partner", width:80, align:"right"},
                {name:"subject", index:"column10", width:80, align:"right"},
                {name:"date_conclusion", index:"date_conclusion", width:80, align:"right"},
                {name:"date_termination", index:"date_termination", width:80, align:"right"},
                {name:"sum_with_vat", index:"sum_with_vat", width:80, align:"right"},
                {name:"terms_payment", index:"terms_payment", width:80, align:"right"},
                {name:"status", index:"status", width:80, align:"right"},
                {name:"note", index:"note", width:80, align:"right"}
                 ],
            rowNum:20,
            pager: pager_id_sub,
            sortname: 'number_con',
            sortorder: "asc",
            
        });
        jQuery("#"+subgrid_table_id).jqGrid('navGrid',"#"+pager_id_sub,{edit:false,add:false,del:false})
      },
      subGridRowColapsed: function(subgrid_id, row_id) {
      }
    });
    jQuery("#listsg11").jqGrid('navGrid','#pagersg11',{add:false,edit:false,del:false});
    </script>

