<?
header('Content-Type: text/html; charset=utf-8');
session_start(); //Запускаем сессии
?>
<?php require_once("inc/init.php"); ?>
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Главная <span>> Описание </span></h1>
	</div>
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
		<!--<ul id="sparks" class="">
			<li class="sparks-info">
				<h5> My Income <span class="txt-color-blue">$47,171</span></h5>
				<div class="sparkline txt-color-blue hidden-mobile hidden-md hidden-sm">
					1300, 1877, 2500, 2577, 2000, 2100, 3000, 2700, 3631, 2471, 2700, 3631, 2471
				</div>
			</li>
			<li class="sparks-info">
				<h5> Site Traffic <span class="txt-color-purple"><i class="fa fa-arrow-circle-up"></i>&nbsp;45%</span></h5>
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
	</div>
</div>
<!-- widget grid -->
<p>Система для внутреннего учта Работ</p>


<div class="row plwp">
	<div class="col-md-3">
		<div class="plate-wrap" id="pw1">
			<i class="fa fa-cogs"></i>
			<p>Щиток </p>
		</div>
	</div>
	<div class="col-md-3">
		<div class="plate-wrap" id="pw2">
			<i class="fa fa-pencil-square-o"></i>
			<p>Перышко</p>
		</div>
	</div>
	<div class="col-md-3">
		<a href="/#ajax/tasks.php">
		<div class="plate-wrap" id="pw3">
			<i class="fa fa-picture-o"></i>
			<p>Дизайн</p>
		</div>
		</a>
	</div>
	<div class="col-md-3">
		<div class="plate-wrap" id="pw4">
			<i class="fa fa-briefcase"></i>
			<p>Проекты</p>
		</div>
	</div>
</div>

<div class="row plwp">
	<div class="col-md-3">
		<a href="/#ajax/accounting_design.php">
		<div class="plate-wrap" id="pw5">
			<i class="fa fa-bar-chart"></i>
			<p>Бухгалтерия</p>
		</div>
		</a>
	</div>
	<div class="col-md-3">
		<a href="/#ajax/routine_holiday.php">
		<div class="plate-wrap" id="pw6">
			<i class="fa fa-sitemap"></i>
			<p>Распорядок</p>
		</div>
		</a>
	</div>
	<div class="col-md-3">
		<a href="/#ajax/accounts_connection.php">
		<div class="plate-wrap" id="pw7">
			<i class="fa fa-users"></i>
			<p>Контрагенты</p>
		</div>
		</a>
	</div>
	<div class="col-md-3">
		<a href="/#ajax/objective.php">
			<div class="plate-wrap" id="pw8">
			<i class="fa fa-share-alt"></i>
			<p>Задачи</p>
		</div>
		</a>
	</div>
</div>

<div class="row plwp">
	<div class="col-md-3">
		<a href="/#ajax/ins_calendar.php">
		<div class="plate-wrap" id="pw9">
			<i class="fa fa-wrench"></i>
			<p>Монтаж</p>
		</div>
		</a>
	</div>
</div>	





<?
echo "<br/><br/><a href=\"?is_exit=1\"><button type=\"button\" class=\"btn-lg btn-warning\"><i class=\"fa fa-sign-out\"></i> Выход из системы</button></a>";
?>


<!--
<p>Вывести на печать: </p>
<menu>
	<button class="btn btn-primary" style='padding:10px 22px;'  type="button" onclick="window.open(this.href='lib_grid/print_contract.php','_blank'); return false;">Договора</button>
    <button class="btn btn-primary" style='padding:10px 22px;'  type="button" onclick="window.open(this.href='lib_grid/print_partners.php','_blank'); return false;">Контрагенты</button>
	<button class="btn btn-primary" style='padding:10px 22px;'  type="button" onclick="window.open(this.href='lib_grid/print_clientage.php','_blank'); return false;">Клиенты</button>
</menu>
-->