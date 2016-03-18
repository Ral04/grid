<?
header('Content-Type: text/html; charset=utf-8');
session_start(); //Запускаем сессии
/*-------------------
|  Таблица отпуков  |
-------------------*/
?>
<?php 
    require_once("inc/init.php");
    require_once("../libs/lib_employees/get_employees_holiday.php");

    function parse_timestamp($start, $end){
        $start = strtotime($start);
        $end = strtotime($end);
        if (!$end){
            $end = $start + 86400;;
        }
        $date_delta = $end - $start;
        $day    = ( $date_delta / 86400 ) % 30;
        $hour   = ( $date_delta / 3600 ) % 24;
        $min    = ( $date_delta / 60 ) % 60;
        return $day;
    }

    function get_status($start, $end){
        $start = strtotime($start);
        $end   = strtotime($end);
        $now   = time();

        if($now > $end){
            return "Закрыт";
        }elseif($now < $start){
            return "Предстоит";
        }elseif($start <= $now && $end >= $now){
            return "В отпуске";
        }
    }

?>
<script>
    function do_status(id_event, set_status){
        $.ajax({
            url: "../libs/lib_employees/form_status.php",
            method: "POST",
            //dataType: 'json',
            data: {
                id: id_event,
                status: set_status 
            },
            success: function(data){
                if(data == 1){
                    $( '#elem'+id_event ).addClass( "success" );
                    $( '#elem'+id_event ).html( "Согласованно" );
                }else {
                    $( '#elem'+id_event ).removeClass( "success" );
                    $( '#elem'+id_event ).html( "На рассмотрении" );
                }

                if(data == 1){
                    $( '#btm'+id_event ).html('<td id="btm'+id_event+'"><button type="button" class="btn btn-successdefault" onclick="do_status('+id_event+', 0)">Отменить</button></td>');
                }else {
                    $( '#btm'+id_event ).html('<td id="btm'+id_event+'"><button type="button" class="btn btn-success" onclick="do_status('+id_event+', 1)">Одобрить </button></td>');
                }
            }
        });
    }
    function do_document(id_event) {
        $.ajax({
            url: "../lib_routine/word/do_docx.php",
            method: "POST",
            data: {id:id_event},
            success: function(data){
                document.location.href = "/lib_routine/word/holiday.doc";
            }
        });
    }
</script>

<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark"><i class="fa fa-sitemap"></i> Распорядок <span>> Таблицы отпусков </span></h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
    </div>
</div>
<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">
    <header>
        <span class="widget-icon"><i class="fa fa-table"></i></span>
        <h2>Отпуска:</h2>
    </header>
    <div>
        <div class="jarviswidget-editbox">
        </div>
        <div class="widget-body no-padding">
            <table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">
                <thead>
                    <tr>
                        <th class="hasinput">
                            <input type="text" class="form-control" placeholder="ID" />
                        </th>
                        <th class="hasinput">
                            <input type="text" class="form-control" placeholder="Фильтр ФИО" />
                        </th>
                        <th class="hasinput ">
                            <input id="dateselect_filter" type="text" placeholder="Окончание отпуска" class="form-control datepicker" data-dateformat="yy-mm-dd">
                        </th> 
                        <th class="hasinput ">
                            <input id="dateselect_filter" type="text" placeholder="Окончание отпуска" class="form-control datepicker" data-dateformat="yy-mm-dd">
                        </th> 
                        <th class="hasinput">
                            <input type="text" class="form-control" placeholder="Фильтр статуса" />
                        </th>
                        <th class="hasinput">
                            <input type="text" class="form-control" placeholder="Фильтр по дням" />
                        </th>
                        <th class="hasinput">
                            <input type="text" class="form-control" placeholder="Фильтр описаня" />
                        </th>    
                        <th class="hasinput">
                            <input type="text" class="form-control" placeholder="Фильтр статус" />
                        </th>
                        <th class="hasinput">
                        </th>
                        <th class="hasinput">
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 25px;">ID</th>
                        <th>Ф.И.О</th>
                        <th>Начало отпуска</th>
                        <th>Окончание отпуск</th>
                        <th>Статус</th>
                        <th>Дни</th>
                        <th>Описание</th>
                        <th>Статус</th>
                        <th style="width: 25px;">Одобрить</th>
                        <th style="width: 25px;">Скачать</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                        foreach ($result as $row) {
                            $name = 'sdfsdf';
                            $start = strtotime($row['start']);
                            $start = date('d-m-Y H:i:s', $start);
                            $end = strtotime($row['end']);
                            $end = date('d-m-Y H:i:s', $end);
                            print ("<tr>");
                            print ("<td style=\"text-align: center;\">".$row['id']."</td>");
                            print ("<td>".$row['title']."</td>");
                            print ("<td>".$start."</td>");
                            print ("<td>".$end."</td>");
                            print ("<td>".get_status($row['start'], $row['end'])."</td>");
                            print ("<td>".

                                    ceil((strtotime($row['end']) - strtotime($row['start']))/86400)
                                //parse_timestamp($row['start'], $row['end'])




                                ."</td>");
                            print ("<td>".$row['description']."</td>");
                            if($row['status'] == 1 ){
                                print ("<td id=\"elem".$row['id']."\" class=\"success\">Согласованно</td>");
                            } else{
                                print ("<td id=\"elem".$row['id']."\" >На рассмотрении</td>");
                            }
                           
                            if($_SESSION['access'] == 'extended'){
                                if($row['status'] == 1 ){
                                    print ('<td id="btm'.$row['id'].'"><button type="button" class="btn btn-default" onclick="do_status('.$row["id"].', 0)">Отменить</button></td>');
                                } else{
                                    print ('<td id="btm'.$row['id'].'"><button type="button" class="btn btn-success" onclick="do_status('.$row["id"].', 1)">Одобрить</button></td>');
                                }
                            } else {
                                print("<td style=\"tsext-align: center;\"><i class=\"fa fa-exclamation-triangle\"></i></td>");
                            }   
                            print('<td style="text-align: center;"><button type="button" class="btn btn-info" onclick="do_document('.$row['id'].')"><i class="fa fa-download"></i></button></td>');
                            print("</tr>");
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">

    /* DO NOT REMOVE : GLOBAL FUNCTIONS!
     *
     * pageSetUp(); WILL CALL THE FOLLOWING FUNCTIONS
     *
     * // activate tooltips
     * $("[rel=tooltip]").tooltip();
     *
     * // activate popovers
     * $("[rel=popover]").popover();
     *
     * // activate popovers with hover states
     * $("[rel=popover-hover]").popover({ trigger: "hover" });
     *
     * // activate inline charts
     * runAllCharts();
     *
     * // setup widgets
     * setup_widgets_desktop();
     *
     * // run form elements
     * runAllForms();
     *
     ********************************
     *
     * pageSetUp() is needed whenever you load a page.
     * It initializes and checks for all basic elements of the page
     * and makes rendering easier.
     *
     */

    pageSetUp();
    
    /*
     * ALL PAGE RELATED SCRIPTS CAN GO BELOW HERE
     * eg alert("my home function");
     * 
     * var pagefunction = function() {
     *   ...
     * }
     * loadScript("js/plugin/_PLUGIN_NAME_.js", pagefunction);
     * 
     */
    
    // PAGE RELATED SCRIPTS
    
    // pagefunction 
    var pagefunction = function() {
        //console.log("cleared");
        
        /* // DOM Position key index //
        
            l - Length changing (dropdown)
            f - Filtering input (search)
            t - The Table! (datatable)
            i - Information (records)
            p - Pagination (paging)
            r - pRocessing 
            < and > - div elements
            <"#id" and > - div with an id
            <"class" and > - div with a class
            <"#id.class" and > - div with an id and class
            
            Also see: http://legacy.datatables.net/usage/features
        */  

        /* BASIC ;*/
            var responsiveHelper_dt_basic = undefined;
            var responsiveHelper_datatable_fixed_column = undefined;
            var responsiveHelper_datatable_col_reorder = undefined;
            var responsiveHelper_datatable_tabletools = undefined;
            
            var breakpointDefinition = {
                tablet : 1024,
                phone : 480
            };

            $('#dt_basic').dataTable({
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
                    "t"+
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "autoWidth" : true,
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });

        /* END BASIC */
        
        /* COLUMN FILTER  */
        var otable = $('#datatable_fixed_column').DataTable({
            //"bFilter": false,
            //"bInfo": false,
            //"bLengthChange": false
            //"bAutoWidth": false,
            //"bPaginate": false,
            //"bStateSave": true // saves sort state using localStorage
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
                    "t"+
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth" : true,
            "preDrawCallback" : function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_fixed_column) {
                    responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_datatable_fixed_column.respond();
            }       
        
        });
        
        // custom toolbar
        $("div.toolbar").html('<div class="text-right"><img src="img/logo.png" alt="SmartAdmin" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');
               
        // Apply the filter
        $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {
            
            otable
                .column( $(this).parent().index()+':visible' )
                .search( this.value )
                .draw();
                
        } );
        /* END COLUMN FILTER */   
    
        /* COLUMN SHOW - HIDE */
        $('#datatable_col_reorder').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
                    "t"+
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth" : true,
            "preDrawCallback" : function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_col_reorder) {
                    responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_datatable_col_reorder.respond();
            }           
        });
        
        /* END COLUMN SHOW - HIDE */

        /* TABLETOOLS */
        $('#datatable_tabletools').dataTable({
            
            // Tabletools options: 
            //   https://datatables.net/extensions/tabletools/button_options
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
                    "t"+
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "oTableTools": {
                 "aButtons": [
                 "copy",
                 "csv",
                 "xls",
                    {
                        "sExtends": "pdf",
                        "sTitle": "SmartAdmin_PDF",
                        "sPdfMessage": "SmartAdmin PDF Export",
                        "sPdfSize": "letter"
                    },
                    {
                        "sExtends": "print",
                        "sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                    }
                 ],
                "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
            "autoWidth" : true,
            "preDrawCallback" : function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_tabletools) {
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            }
        });
        
        /* END TABLETOOLS */

    };

    // load related plugins
    
    loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
        loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
            loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
                loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
                    loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
                });
            });
        });
    });


</script>