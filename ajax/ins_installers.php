<?php
require_once ("inc/init.php");
header('Content-Type: text/html; charset=utf-8');
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
                jQuery("#executors").jqGrid({
                    url:'lib_grid/executors/getdata_executors.php',
                    datatype: 'json',
                    mtype: 'POST',
                    colNames:['id', 'ФИО', 'Должность', 'Телефон', 'E-mail'],
                    colModel :[
                         {name:'id',                 index:'id',                 width:30, align:'center'}
                        ,{name:'name_executors',     index:'name_executors',     width:200, align:'right', editable:true, edittype:"text"}
                        ,{name:'position_executors', index:'position_executors', width:180, align:'right', editable:true, edittype:"text"}
                        ,{name:'phone_executors',    index:'phone_executors',    width:220, align:'right', editable:true, edittype:"text"}
                        ,{name:'email_executors',    index:'email_executors',    width:220, align:'right', editable:true, edittype:"text"}
                        ],
                    pager: jQuery('#pager_executors'),
                    rowNum:3,
                    rowList:[50,100],
                    sortname: 'id',
                    sortorder: "asc",
                    viewrecords: true,
                    caption: 'Исполнители',
                    ondblClickRow: function(id) {
                        if (id && id != lastSel) {
                            jQuery("#executors").restoreRow(lastSel);
                            jQuery("#executors").editRow(id, true);
                            lastSel = id;
                        }
                    },
                    editurl: 'lib_grid/executors/saverow_executors.php'
                }); 
            }); 
    </script>

<h2>Дополнительно</h2>
<br><p>*Для редактирования ячейки необходимо нажать на нее два раза левой кнопкой мыши</p> 
<!-- widget grid -->
<section id="widget-grid" class="">

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <table id="executors" class="scroll"></table> 
            <div id="pager_executors" class="scroll" style="text-align:center;"></div>
            <br>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalExe">
                Добавить Исполнителя
            </button>
        </div>
    </div>

</section>
<!-- end widget grid -->


<!--******************
|  Modal Executors   |
*******************-->
<div class="modal fade" id="myModalExe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Форма ввода новых Исполнителей</h4>
      </div>
      <div class="modal-body">
        <form method="post" class="smart-form" action="lib_grid/executors/form_executors.php" accept-charset="utf-8">
            <input type="text" class="input form-control" size="10" name="name_executors" placeholder=" ФИО:"><br>
            <input type="text" class="input form-control" size="10" name="position_executors" placeholder=" Должность:"><br>
            <input type="text" class="input form-control" size="10" name="phone_executors" placeholder=" Телефон:"><br>
            <input type="text" class="input form-control" size="10" name="email_executors" placeholder=" E-mail:"><br>
            <input class="btn btn-primary" style='padding:10px 22px;' type="submit" value="Добавить контрогента">
        </form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>