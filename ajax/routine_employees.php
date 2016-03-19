<?
header('Content-Type: text/html; charset=utf-8');
session_start(); //Запускаем сессии
?>
<?php 
	require_once("inc/init.php");
	require_once("../libs/lib_employees/get_employees.php");
?>


<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-sitemap"></i> Распорядок <span>> Сотрудники </span></h1>
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
<p>Система для внутреннего учта Работы отдела </p>
<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
	<header>
		<span class="widget-icon"> <i class="fa fa-table"></i> </span>
		<h2>Сотрудники:</h2>
	</header>
	<div>
		<div class="jarviswidget-editbox">
		</div>
		<div class="widget-body">
			<p><i class="fa fa-users"></i></p>
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Ф.И.О</th>
							<th>Коротное имя</th>
							<th>Телефон</th>
							<th>E-mail</th>
							<th>Уровень доступа</th>
						</tr>
					</thead>
					<tbody>
						<?
							foreach ($result as $row) {
								print("<tr>");
								print ("<td>".$row['employees_full_name']."</td>");
								print ("<td>".$row['employees_short_name']."</td>");
								print ("<td>".$row['employees_phone']."</td>");
								print ("<td>".$row['employees_email']."</td>");
								print ("<td>".$row['employees_access']."</td>");
								print("</tr>");
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>