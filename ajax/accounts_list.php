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
                jQuery("#account").jqGrid({
                    url:'/lib_accounts/grid/getdata_accounts.php',
                    datatype: 'json',
                    mtype: 'POST',
                    autowidth: true,
                    colNames:['id', 'Название', 'Имя контрагента', 'Адрес', 'Телефон', 'Банк', 'Р/С', 'БИК', 'К/С', 'ИНН', 'КПП'],
                    colModel :[
                         {name:'id',              index:'id',              width:25,  align:'center'}
                        ,{name:'name_clients',    index:'name_clients',    width:200, align:'left', editable:true, edittype:"text"}
                        ,{name:'name2_clients',   index:'name2_clients',    width:200, align:'left', editable:true, edittype:"text"}
                        ,{name:'address_clients', index:'address_clients', width:355, align:'left', editable:true, edittype:"text"}
                        ,{name:'phone_clients',   index:'phone_clients',   width:180, align:'left', editable:true, edittype:"text"}
                        ,{name:'bank_clients',    index:'bank_clients',    width:180, align:'left', editable:true, edittype:"text"}
                        ,{name:'account_clients', index:'account_clients', width:180, align:'left', editable:true, edittype:"text"}
                        ,{name:'bik_clients',     index:'bik_clients',     width:100, align:'left', editable:true, edittype:"text"}
                        ,{name:'k_c_clients',     index:'k_c_clients',     width:100, align:'left', editable:true, edittype:"text"}
                        ,{name:'inn_clients',     index:'inn_clients',     width:100, align:'left', editable:true, edittype:"text"}
                        ,{name:'kpp_clients',     index:'kpp_clients',     width:100, align:'left', editable:true, edittype:"text"}
                        ],
                    pager: jQuery('#pager_clients'),
                    rowNum:30,
                    rowList:[30,50,100],
                    sortname: 'id',
                    sortorder: "asc",
                    viewrecords: true,
                    caption: 'Контрагенты',
                    ondblClickRow: function(id) {
                        if (id && id != lastSel) {
                            jQuery("#account").restoreRow(lastSel);
                            jQuery("#account").editRow(id, true);
                            lastSel = id;
                        }
                    },
                    editurl: '/lib_accounts/grid/saverow_accounts.php'
                });
            });
</script>

<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark"><i class="fa fa-users"></i> Контрагенты <span>> Таблицы контрагентов </span></h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalClients">Добавить контрагента</button>
    </div>

</div>

<br><p>*Для редактирования ячейки необходимо нажать на нее два раза левой кнопкой мыши</p>
<section id="widget-grid" class="">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table id="account" class="scroll"></table>
            <div id="pager_clients" class="scroll" style="text-align:center;"></div>


        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModalClients" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Форма ввода новых Контрагентов</h4>
      </div>
      <div class="modal-body">
        <form method="post" class="smart-form" action="/lib_accounts/grid/form_accounts.php" accept-charset="utf-8">
            <input type="text" class="input form-control" size="10" name="name_clients"    placeholder=" Название:"><br>
            <input type="text" class="input form-control" size="10" name="name2_clients"   placeholder=" Имя контрагента:"><br>
            <input type="text" class="input form-control" size="10" name="address_clients" placeholder=" Адрес:"><br>
            <input type="text" class="input form-control" size="10" name="phone_clients"   placeholder=" Телефон:"><br>
            <input type="text" class="input form-control" size="10" name="bank_clients"    placeholder=" Банк:"><br>
            <input type="text" class="input form-control" size="10" name="account_clients" placeholder=" Р/С:"><br>
            <input type="text" class="input form-control" size="10" name="bik_clients"     placeholder=" БИК:"><br>
            <input type="text" class="input form-control" size="10" name="k_c_clients"     placeholder=" К/С:"><br>
            <input type="text" class="input form-control" size="10" name="inn_clients"     placeholder=" ИНН:"><br>
            <input type="text" class="input form-control" size="10" name="kpp_clients"     placeholder=" КПП:"><br>
            <input type="text" class="input form-control" size="10" name="contact_person"       placeholder=" Контактное лицо"><br>
            <input type="text" class="input form-control" size="10" name="contact_person_mail"  placeholder=" (КЛ)mail"><br>
            <input type="text" class="input form-control" size="10" name="contact_person_phone" placeholder=" (КЛ)Телефон"><br>
            <input type="text" class="input form-control" size="10" name="note"                 placeholder=" Примечание"><br>
            <input class="btn btn-primary" style='padding:10px 22px;' type="submit" value="Добавить контрогента">
        </form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
