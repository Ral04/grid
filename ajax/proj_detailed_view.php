<?php
  header('Content-Type: text/html; charset=utf-8');
  require_once ("inc/init.php");
  require_once("..//libs/get_clients_list.php");
  session_start();
  $id_user = $_SESSION['id'];
  $id_projects = $_GET['id'];
  print '<script>var idUser = '.$id_user.';</script>';
  print '<script>var idProj = '.$id_projects.';</script>';


?>


<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark"><i class="fa fa-briefcase"></i> Проекты <span>> Проект </span></h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
      <div class="cont-proj">
      </div>
    </div>
</div>

<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
		<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-101" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<h2><strong><i class="fa fa-briefcase"></i></strong> <i>Проект:</i></h2>
				</header>
				<div>
					<div class="widget-body">
					<!--Body widget start-->
          <fieldset>
            <legend>#1 Общие пункты <button type="button" class="btn btn-default" id="show-form-1"><i class="fa fa-pencil"></i> Редактировать</button></legend>
          </fieldset>
          <div class="proj-wpar" id="item-1">
          </div>
          <div class="" id="for-form-1">
            <!--FORM STAR-->
            <form class="form-horizontal" id="form-material">
              <div class="form-group">
                <label class="col-md-2 control-label">Название проекта</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="title-obj" placeholder="Название проекта" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Договор</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="contract-obj" placeholder="Договор" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Общая стоимость</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="ttlpay-obj" placeholder="Общая стоимость" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Оплаченно</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="pay-obj"  placeholder="Оплаченно" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Коментарий</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="comm-obj" placeholder="Коментарий" >
                </div>
              </div>
            <!---->
              <div class="form-group">
                <label class="col-md-2 control-label">Даты</label>
                <div class="col-md-2">
                  <input type="date" class="form-control" id="start-obj" >
                </div>
                <div class="col-md-2">
                  <input type="date" class="form-control" id="end-obj" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Подрядчик</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="contractor-obj" placeholder="Подрядчик" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Клинет</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" list="accounts" id="clients-obj" placeholder="Клинет" >
                      <datalist id="accounts">
                        <option></option>
                        <?php
                          while ($row = $stmt->fetch()){
                            echo("<option>".$row['name_clients']." (".$row['id'].")</option>");
                          }
                        ?>
                      </datalist>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Город</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="sity-obj" placeholder="Город" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Улица</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="street-obj" placeholder="Улица" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Строение</label>
                <div class="col-md-10">
                  <input type="text" class="form-control" id="building-obj" placeholder="Строение" >
                </div>
              </div>
              <div class="submit-wrap">
                <button type="button" class="btn btn-primary" id="material-submit"><i class="fa fa-floppy-o"></i> Сохранить</button>
              </div>
            </form>
            <!--FORM END-->
          </div>



          <fieldset>
            <legend>#2 Материалы</legend>
          </fieldset>
          <div class="proj-wpar" id="item-2">
          </div>
          <div class="" id="for-form-3">
          </div>


					<!--Body widget end-->
					</div>
				</div>
			</div>
		</article>
	</div>
</section>

<script>
/*------------------
|  Данные проекта  |
------------------*/
function getProject(){
  $.ajax({
    url:'libs/lib_projects/get_project.php',
    type:'POST',
    datatype:"JSON",
    data:{
      id_user:idUser,
      id_proj:idProj
    },
    success: function(data){
      sortData(JSON.parse(data));
    }
  })
}

function sortData(jData){
  console.log(jData);
  var projObj = {
    /*
        idProj: {
        id: 'id-proj',
        title: 'id',
        data: jData[0].id
      },
    */
      titleProj: {
        id: 'title-proj',
        title: 'Название',
        data: jData[0].project_title
      },
      startProj: {
        id: 'start-proj',
        title: 'Начало',
        data: jData[0].project_start
      },
      endProj: {
        id: 'end-proj',
        title: 'Сдача',
        data: jData[0].project_end
      },
      commProj: {
        id: 'comm-proj',
        title: 'Комментарий',
        data: jData[0].project_comm
      },
      clientProj: {
        id: 'clients-proj',
        title: 'Заказчик',
        data: jData[0].clients,
        clientsid: jData[0].project_id_clients
      },
      contractProj: {
        id: 'contract-proj',
        title: 'Договор',
        data: jData[0].project_contract
      },
      ttlpayProj: {
        id: 'ttlpay-proj',
        title: 'Стоимость',
        data: jData[0].project_ttlpay
      },
      payProj: {
        id: 'pay-proj',
        title: 'Оплаченно',
        data: jData[0].project_pay
      },
      contractorProj: {
        id: 'contractor-proj',
        title: 'Подрядчик',
        data: jData[0].project_contractor
      },
      sityProj: {
        id: 'sity-proj',
        title: 'Город',
        data: jData[0].project_sity
      },
      streetProj: {
        id: 'street-proj',
        title: 'Улица',
        data: jData[0].project_street
      },
      buildingProj: {
        id: 'buildings-proj',
        title: 'Строение',
        data: jData[0].project_building
      }
    };
    createHtml(projObj);
  }

  function createHtml(objInput){
    //console.log(objInput);
    //console.log(objInput.buildingProj.title);
    $('#item-1').html('');
    for (key in objInput) {
      $('#item-1').append('<div class="proj-elem" id="'+objInput[key].id+'">'+objInput[key].title+': <span><b>'+objInput[key].data+'</b></span></div>');
    }
    forForm(objInput);
  }

/*-----------------------
|  Данные по материялм  |
-----------------------*/

  function forForm(data){
    $('#title-obj').val(data.titleProj.data);
    $('#contract-obj').val(data.contractProj.data);
    $('#ttlpay-obj').val(data.ttlpayProj.data);
    $('#pay-obj').val(data.payProj.data);
    $('#comm-obj').val(data.commProj.data);
    $('#start-obj').val(data.startProj.data);
    $('#end-obj').val(data.endProj.data);
    $('#contractor-obj').val(data.contractorProj.data);
    $('#clients-obj').val(data.clientProj.data + ' (' + data.clientProj.clientsid + ')');
    $('#sity-obj').val(data.sityProj.data);
    $('#street-obj').val(data.streetProj.data);
    $('#building-obj').val(data.buildingProj.data);
  }

  function getMaterials(){
    $.ajax({
      url: 'libs/lib_projects/get_materials.php',
      type: 'POST',
      datatype:"JSON",
      data: {id_proj:idProj},
      success: function(data){
        sortDataMat(JSON.parse(data));
      }
    });
  }

  function sortDataMat(inputObj){
    var comutInput = inputObj.length;
    //console.log(inputObj);
    for(i=0; i < comutInput; i++){
      $('#item-2').append('<div class="proj-mat"><div class="title-mat"><i class="fa fa-cubes"></i> <b>'+inputObj[i].name_material+':</b></div> <div class="amount_mat">'+inputObj[i].amount_spent+'</div></div>');
    }
  }

/*------------------
|  Форма материял  |
------------------*/

$('#material-submit').click(function(){

  var idInpyt = [];
  //console.log(idInpyt);
  $('#form-material :input').each(function(){
    //var id = $(this).attr('id');
    var id = $(this).val();
    idInpyt.push(id);
  });
  //console.log(idInpyt);

  $.ajax({
    url: '../libs/lib_projects/editing_project.php',
    type: 'POST',
    //dataType: 'JSON',
    dataType: 'TEXT',
    data: {
        id: idProj,
        data_static: idInpyt
      },
    success: function(data){
      getProject();
      state2();
    }
  })

});

/*------------
|  Анимации  |
-------- ---*/
var countAnim = 0;

function state1(){
  $('#for-form-1').fadeIn();
  $('#item-1').hide();
  return countAnim = 1;
}
function state2(){
  $('#item-1').fadeIn();
  $('#for-form-1').hide();
  return countAnim = 0;
}

$('#show-form-1').click(function(){
  if (countAnim == 0) {
    console.log(countAnim );
    state1();
  }else{
    state2();
  }

});



//Инициализации
getProject();
getMaterials();
</script>

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
	// PAGE RELATED SCRIPTS
	// pagefunction
	var pagefunction = function() {
		// switch style change
		$('input[name="checkbox-style"]').change(function() {
			//alert($(this).val())
			$this = $(this);
			if ($this.attr('value') === "switch-1") {
				$("#switch-1").show();
				$("#switch-2").hide();
			} else if ($this.attr('value') === "switch-2") {
				$("#switch-1").hide();
				$("#switch-2").show();
			}

		});
		// tab - pills toggle
		$('#show-tabs').click(function() {
			$this = $(this);
			if($this.prop('checked')){
				$("#widget-tab-1").removeClass("nav-pills").addClass("nav-tabs");
			} else {
				$("#widget-tab-1").removeClass("nav-tabs").addClass("nav-pills");
			}
		});
	};
	// end pagefunction
	// run pagefunction on load
	pagefunction();
</script>
