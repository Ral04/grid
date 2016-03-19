<?php
    require_once ("inc/init.php");
    header('Content-Type: text/html; charset=utf-8');
    //для форм
    $dbName = 'biltv_grid';
    $dbUser = 'biltv_mysql';
    $dbPass = 'uvxxoe1q';
    $dbHost = 'biltv.mysql';
    $dbh = new PDO ('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPass);
    $dbh->exec('SET CHARACTER SET utf8');
    $stmt = $dbh->query('SELECT id, name_clients FROM accounts_list');
    $stmt_1 = $dbh->query('SELECT id, our_company FROM accounts_our_cmp');
    $stmt_2 = $dbh->query('SELECT id, employees_full_name FROM employees WHERE employees_category = \'leading_manager\'');
?>
<link rel="stylesheet" type="text/css" media="screen" href="lib_grid/css/ui.jqgrid.css" />
<!--подключаем js jQueru и плагины грида-->
<!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript"src="lib_grid/js/i18n/grid.locale-ru.js" ></script>
<script type="text/javascript"src="lib_grid/js/jquery.jqGrid.src.js" ></script>
<style>
.accountghead_0{
    background-color: #EFEFEF;
    color: #3A3633;
}
</style>

<script type="text/javascript">
    jQuery(document).ready(function(){
        // Функция вызова ajax
        function testAjax() {
            return $.ajax({
                url: "/lib_accounts/do_session.php",
                method: 'POST',
                dataType: 'json',
                /*success:function (data) {
                    data;
                },*/
          });
        }
        // Создание обьекта
        var dataManager = testAjax();

        // Обращение к свойствам и атрибудам объекта
        dataManager.success(function (data) {
            data.length
            var managerGrid = "";
            for(i = 0; i < data.length/2; i++){
                managerGrid += data[i] + ":" + data[data.length/2 + i] + ";";
            }
                // jqGrid
                var lastSel;
                jQuery("#account").jqGrid({
                    url:'/lib_accounts/grid/connection/getdata_accounts_c.php',
                    datatype: 'json',
                    mtype: 'POST',
                    autowidth: true,
                    colNames:['id', 'Контрагент', 'Наша компания', 'Контактное лицо', 'Email', 'Телефон', 'Зметки', 'Мэнеджер'],
                    colModel :[
                         {name:'id',                  index:'id',                  width:30,  align:'center'}
                        ,{name:'name_clients',        index:'name_clients',        width:180, align:'right', editable:true, edittype:"text",   classes: "textclass"}
                        ,{name:'our_company',         index:'our_company',         width:180, align:'right', editable:true, edittype:"select", editoptions:{value:"1:Широкий формат;2:Битлорд-тв;3:ИП Ефимов"}}
                        ,{name:'contact_person',      index:'contact_person',      width:180, align:'right', editable:true, edittype:"text"}
                        ,{name:'cp_mail',             index:'cp_mail',             width:180, align:'right', editable:true, edittype:"text"}
                        ,{name:'cp_phone',            index:'cp_phone',            width:180, align:'right', editable:true, edittype:"text"}
                        ,{name:'note',                index:'note',                width:180, align:'right', editable:true, edittype:"text"}
                        ,{name:'employees_full_name', index:'employees_full_name', width:180, align:'right', editable:true, edittype:"select", editoptions:{value:managerGrid}}
                        ],
                    pager: jQuery('#pager_clients'),
                    rowNum: 30,
                    rowList: [30,50,100],
                    sortname: 'id',
                    sortorder: "asc",
                    viewrecords: true,
                    caption: 'Контрагенты',
                    multiselect: true,
                    grouping: true,
                    groupingView : {
                        groupField : ['name_clients'],
                        groupColumnShow : [false],
                        groupText : ['<b>{0}</b>'],
                        groupCollapse : true,
                        groupOrder: ['desc']
                    },
                    ondblClickRow: function(id) {
                        if (id && id != lastSel) {
                            jQuery("#account").restoreRow(lastSel);
                            jQuery("#account").editRow(id, true);
                            lastSel = id;
                        }
                    },
                    editurl: '/lib_accounts/grid/connection/saverow_accounts_c.php'
                });
        });
    });
</script>

<script>
    //Чек боксы
    $("#m1").click( function() {
        var sel_items;
        sel_items = jQuery("#account").jqGrid('getGridParam','selarrrow');
        sel_items = sel_items.toString();
        console.log( sel_items );
        $("#fild-1").val( sel_items );
        $("#to-exel").submit();
    });
</script>

<script type="text/javascript">
//Ajax Форма
        function AjaxFormRequest() {
            var cname = $( '#clients_name' ).val();
                if (cname.length > 0){
                        $('#mess_client').append('Контрогент добавлен <i class="fa fa-smile-o" style="color: #51D600;"></i><br>');
                            jQuery.ajax({
                                url:      "lib_accounts/form_ajax_accounts.php", //Адрес подгружаемой страницы
                                type:     "POST", //Тип запроса
                                dataType: "html", //Тип данных
                                data: jQuery("#" + "aform").serialize(),
                                success: function(response) { //Если все нормально
                                   //document.getElementById("result").innerHTML = response;
                                   //$('#result').val( response);
                                   //$('#result').html( 'Последний добавленный (' + response +')');
                                   result_data = JSON.parse(response);
                                   $( "#result" ).append("<option>"+result_data.name+" ("+result_data.id+")</option>");

                                },

                                error: function(response) { //Если ошибка
                                    document.getElementById("result").innerHTML = "Error sent form";
                                }
                             });
                } else{
                        $('#mess_client').html('Название пустрое <i class="fa fa-meh-o" style="color: #F00;"></i><br>');
                    }
        }
</script>


<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark"><i class="fa fa-users"></i> Контрагенты <span>> Кураторы </span></h1>
    </div>
</div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalClients">Добавить контрагента</button>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            <form id="to-exel" method="post" action="/exel/accounts/index.php">
            <input type="hidden" name="fild" id="fild-1">
            </form>
            <button class="btn btn-success" id="m1"><i class="fa fa-file-excel-o"></i> Лист доставки</button>
        </div>
    </div>

<br>
<p>*Для редактирования ячейки необходимо нажать на нее два раза левой кнопкой мыши</p>
<section id="widget-grid" class="">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table id="account" class="scroll"></table>
            <div id="pager_clients" class="scroll" style="text-align:center;"></div>
        </div>
    </div>
    <br>
</section>
<br>

<!-- Modal  -->
<div class="modal fade" id="myModalClients" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Форма ввода новых Контрагентов</h4>
      </div>
      <div class="modal-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#for_mtasks" aria-controls="for_mtasks" role="tab" data-toggle="tab">Добавить Контактное лицо</a></li>
            <li role="presentation"><a href="#for_clients" aria-controls="for_clients" role="tab" data-toggle="tab">Добавить Контрагент</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="for_mtasks"><br>
            <!--Контактное лицо-->
                <form method="post" class="smart-form" action="/lib_accounts/grid/connection/form_accounts_s.php" accept-charset="utf-8">
                    <label class="control-label" for="inputWarning1">Контрагент</label><br>
                    <input list="accounts" name="account" id="inputWarning1" class="input form-control">
                        <datalist id="accounts">
                        <option id="result"></option>
                        <?
                            while ($row = $stmt->fetch()){
                                echo("<option> ".$row['name_clients']." (".$row['id'].")</option>");
                            }
                        ?>
                        </datalist>
                    <br>
                    <label class="control-label" for="inputWarning2">Юр. Лица</label>
                    <select class="input form-control" id="inputWarning2" name="our_company">
                        <?
                            while ($row = $stmt_1->fetch()){
                                echo("<option value=\"".$row['id']."\"> ".$row['our_company']."</option>");
                            }
                        ?>
                    </select><br>
                    <label class="control-label" for="inputWarning3">Менеджер</label>
                    <select class="input form-control" id="inputWarning3" name="manager">
                        <?
                            while ($row = $stmt_2->fetch()){
                                echo("<option value=\"".$row['id']."\"> ".$row['employees_full_name']."</option>");
                            }
                        ?>
                    </select><br>
                    <input type="text" class="input form-control" size="10" name="contact_person"   placeholder=" Контактное лицо'"><br>
                    <input type="text" class="input form-control" size="10" name="cp_mail"          placeholder=" Email Контакта"><br>
                    <input type="text" class="input form-control" size="10" name="cp_phone"         placeholder=" Телефон Контакта"><br>
                    <input type="text" class="input form-control" size="10" name="note"             placeholder=" Примечание"><br>
                    <input class="btn btn-primary" style='padding:10px 22px;' type="submit" value="Добавить контактное лицо">
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="for_clients"><br>
            <!--Добавить контарогентов-->
                <form method="post" class="smart-form" id="aform"  accept-charset="utf-8">
                    <input type="text" class="input form-control" size="10" name="name_clients"    placeholder=" Название:" id='clients_name'><br>
                    <input type="text" class="input form-control" size="10" name="address_clients" placeholder=" Адрес:"><br>
                    <input type="text" class="input form-control" size="10" name="phone_clients"   placeholder=" Телефон:"><br>
                    <input type="text" class="input form-control" size="10" name="bank_clients"    placeholder=" Банк:"><br>
                    <input type="text" class="input form-control" size="10" name="account_clients" placeholder=" Р/С:"><br>
                    <input type="text" class="input form-control" size="10" name="bik_clients"     placeholder=" БИК:"><br>
                    <input type="text" class="input form-control" size="10" name="k_c_clients"     placeholder=" К/С:"><br>
                    <input type="text" class="input form-control" size="10" name="inn_clients"     placeholder=" ИНН:"><br>
                    <input type="text" class="input form-control" size="10" name="kpp_clients"     placeholder=" КПП:"><br>
                    <!--<input class="btn btn-primary" style='padding:10px 22px;' type="submit" value="Добавить контрогента">-->
                    <div id='mess_client'></div>
                    <input  type="button" class="btn btn-primary" style='padding:10px 22px;' value="Добавить контрогента" onclick="AjaxFormRequest()" id="do_form" />
                </form>

            </div>
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
