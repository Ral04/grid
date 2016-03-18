<?php
header('Content-Type: text/html; charset=utf-8');
require_once ("inc/init.php");
//include ("../libs/lib_material/get_material.php"); 
include ("../libs/lib_material/select_group.php");//Список групп
?>
<!--jqGrid-->
<link rel="stylesheet" type="text/css" media="screen" href="lib_grid/css/ui.jqgrid.css" />
<script type="text/javascript"src="lib_grid/js/i18n/grid.locale-ru.js" ></script>
<script type="text/javascript"src="lib_grid/js/jquery.jqGrid.src.js" ></script>

<div class="row">
	<div class="col-xs-5 col-sm-3 col-md-2 col-lg-2">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-tree"></i> Материалы </h1>
	</div>
	<div class="col-xs-6 col-sm-5 col-md-9 col-lg-9">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalGroup"><i class="fa fa-cubes"></i> Группа Материалов</button>
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalSingl"><i class="fa fa-cube"></i> Материал</button>
	</div>
</div>

<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-2 col-md-2 col-lg-2">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-101" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<h2><strong><i class="fa fa-cubes"></i></strong> <i>Группы материалов</i></h2>       
				</header>
				<div>
					<div class="widget-body">
					<!--Body widget start-->
						<div id="all_parent" >
							<p><b><i class="fa fa-bolt"></i> Выбрать все</b></p>
						</div>
						<div id="for_parent0">
						</div>
					<!--Body widget end-->
					</div>
				</div>
			</div>

		</article>
		<article class="col-xs-12 col-sm-10 col-md-10 col-lg-10">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-102" data-widget-editbutton="false" data-widget-deletebutton="false">
				<header>
					<h2><strong><i class="fa fa-cube"></i></strong> <i>Группы материалов</i></h2>       
				</header>
				<div>
					<div class="widget-body">
					<!--Body widget start-->

					<table id="list" class="scroll"></table> 
            		<div id="pager" class="scroll" style="text-align:center;"></div>


					<!--Body widget end-->
					</div>
				</div>
			</div>

		</article>
	</div>
</section>
<!-- end widget grid -->

<!-- Modal group -->
<div class="modal fade" id="modalGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class="fa fa-cubes"></i> Группа Материалов</h4>
			</div>
			<div class="modal-body">
				<form id="group_material_form">
				
				<div class="form-group">
					<label for="group_material_name">Название группы</label>
					<input class="form-control" id="group_material_name">
				</div>

				<div class="form-group">
					<label for="group_material_parent">Родительская группа</label>
					<input list="clits" class="input form-control" name="group_material_parent" id="group_material_parent" required>
					<datalist id="clits">
						<?php foreach($clients_select as $item): ?>
							<option><?=$item['name_group']?> (<?=$item['id_group']?>)</option>
						<?php endforeach; ?>
					</datalist>
				</div>

				<div class="form-group">
					<label for="group_material_unit">Ед. измерения</label>
					<input class="form-control" id="group_material_unit">
				</div>

				<div class="form-group">
					<label for="group_material_desc">Описание</label>
					<input class="form-control" id="group_material_desc">
				</div>

				<button type="button" class="btn btn-success" id="add_group"><i class="fa fa-cubes"></i> Создать Группу</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal singl -->
<div class="modal fade" id="modalSingl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class="fa fa-cube"></i> Материал</h4>
			</div>
			<div class="modal-body">
				

				<form id="material_form">
				
				<div class="form-group">
					<label for="material_name">Материал</label>
					<input class="form-control" id="material_name">
				</div>

				<div class="form-group">
					<label for="group_for_material">Группа</label>
					<input list="clits" class="input form-control" name="group_material_parent" id="group_for_material" required>
					<datalist id="clits">
						<?php foreach($clients_select as $item): ?>
							<option><?=$item['name_group']?> (<?=$item['id_group']?>)</option>
						<?php endforeach; ?>
					</datalist>
				</div>

				<div class="form-group">
					<label for="material_size">Формат элемента</label>
					<input class="form-control" id="material_size">
				</div>

				<div class="form-group">
					<label for="material_amount">Количество</label>
					<input class="form-control" id="material_amount">
				</div>

				<button type="button" class="btn btn-info" id="add_material"><i class="fa fa-cube"></i> Добавить Материал</button>
				</form>



			</div>
			<div class="modal-footer">
				
				
			</div>
		</div>
	</div>
</div>

<script>
	/*---------------------
	|    User Script      |
	---------------------*/
	//Инициализация 
	$(document).ready(function(){
		getMaterial();    
	});

	//Функции конструктора групп
	function getMaterial(){
		$.ajax({
				url: '../libs/lib_material/get_material.php',
				success: function(data){
					//console.log(data);
					creationHTML(data);
				}
		});
	}
	function creationHTML(jData){
		var jObj = JSON.parse(jData);
		var jObjCount = jObj.length;
		for (i = 0; i < jObjCount; i++){
			//console.log(jObj[i]);
			htmlElemrnt('#for_parent'+jObj[i].parent_group, jObj[i], jObj[i].parent_level_group);
		}
	}

	function htmlElemrnt(divS, objElem, indent){
		$(divS).append('<div class="parent_group" style="margin-left:' + (indent*10) + 'px;" id="for_parent' + objElem.id_group + '"><div class="material_group" onclick="doEvent('+ objElem.id_group +')">' + objElem.name_group + '</div></div>');
	}

	//Форма создания новой группы
	$('#add_group').click(function(){
		var nameGroup   = $('#group_material_name').val();
		var parentGroup = $('#group_material_parent').val();
		//console.log(parentGroup);
		if (parentGroup.length > 1) {
			var parentGroupP1 = parentGroup.split("(");
			var parentGroupP2 = parentGroupP1[1].split(")");
			var parentGroupF  = parentGroupP2[0]; 
		}
		var unitGroup = $('#group_material_unit').val();
		var descGroup = $('#group_material_desc').val();
		$.ajax({
			url: '/libs/lib_material/add_material_group.php',
			type: 'POST',
			dataType:'TEXT',
			data:{
				name:   nameGroup,
				parent: parentGroupF,
				unit: unitGroup,
				desc: descGroup
			},
			success: function(data){
				console.log(data);
				$('#for_parent0').html('');
				getMaterial();
				$('#clits').append("<option>"+nameGroup+" ("+data+")</option>");
				$('#group_material_name').val('');
				$('#group_material_parent').val('');
				$('#group_material_unit').val('');
				$('#group_material_desc').val('');
				$('#modalGroup').modal('hide');
			}
		});
	});

	//Форма создания Нового Материала
	$('#add_material').click(function(){
		var name	    = $('#material_name').val();
		var group_for	= $('#group_for_material').val();
			var group_forP1 = group_for.split("(");
			var group_forP2 = group_forP1[1].split(")");
			var group_forF  = group_forP2[0]; 
		var size	    = $('#material_size').val();
		var amounty  	= $('#material_amount').val();

		$.ajax({
			url: '/libs/lib_material/add_material.php',
			type: 'POST',
			data: {
				name: name,
				group_for: group_forF,
				size: size,
				amounty: amounty
			},
			success: function(data){
				//console.log(data);
				jQuery("#list").jqGrid('setGridParam', { url: 'lib_grid/material/getdata_material.php?id_group=' + group_forF }).trigger("reloadGrid");
				$('#material_name').val('');
				$('#group_for_material').val('');
				$('#material_size').val('');
				$('#material_amount').val('');
				$('#modalSingl').modal('hide');
			}
		});
	});


	// Событие вызова МАТЕРИАЛА
	function doEvent(id) {
		console.log(id);
		        jQuery("#list").jqGrid('setGridParam', { url: 'lib_grid/material/getdata_material.php?id_group=' + id }).trigger("reloadGrid");
	}

	// Выбрать все материалы
	$('#all_parent').click(function(){
		jQuery("#list").jqGrid('setGridParam', { url: 'lib_grid/material/getdata_material.php' }).trigger("reloadGrid");
	})
</script>



<script>

	jQuery(document).ready(function(){
        var lastSel;
        jQuery('#list').jqGrid({
            url:'lib_grid/material/getdata_material.php',
			datatype: 'json',
			height: 'auto',
                    
                    colNames :['id','Название','Колличество','Размеры', 'Размеры','Группа'],
                    colModel :[
                         {name:'id',     index:'id',     width:30,  align:'center',  sorttype:'int'}
                        ,{name:'name_material',      index:'name_material',      width:180, align:'left',    editable:true,  edittype:'text'}
                        ,{name:'amount_material',    index:'amount_material',    width:180, align:'right',   editable:true,  edittype:'text'}
                        ,{name:'size_type_material', index:'size_type_material', width:180, align:'right',   editable:true,  edittype:'text'}
                        ,{name:'size_material',      index:'size_material',      width:180, align:'right',   editable:true,  edittype:'text'}
                        ,{name:'name_group',         index:'name_group',         width:180, align:'left',    editable:false, edittype:'text'}
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
                    caption: 'Материалы',
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
                    editurl: 'lib_grid/material/saverow_material.php'
                });
	});


</script>




<script>
	
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