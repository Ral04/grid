<?php
require_once("inc/init.php"); 
require_once("../lib_reg/profile.php");						
?>



<!-- row -->
<div class="row">

	<!-- col -->
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><!-- PAGE HEADER --><i class="fa-fw fa fa-file-o"></i> Other Pages <span>>
			Profile </span></h1>
	</div>
	<!-- end col -->

	<!-- right side of the page with the sparkline graphs -->
	<!-- col -->
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
		<!-- sparks -->
		<!--
		<ul id="sparks">
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

<!-- row -->

<div class="row">

	<div class="col-sm-12">

			<div class="well well-sm">

				<div class="row">

					<div class="col-sm-12 col-md-12 col-lg-6">
						<div class="well well-light well-sm no-margin no-padding">

							<div class="row">

								<div class="col-sm-12">
									<div id="myCarousel" class="carousel fade profile-carousel">

										<div class="air air-top-left padding-10">
											<h4 class="txt-color-white font-md"><?print date("j / n / Y"); ?></h4>
										</div>
										<ol class="carousel-indicators">
											<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
											<li data-target="#myCarousel" data-slide-to="1" class=""></li>
											<li data-target="#myCarousel" data-slide-to="2" class=""></li>
										</ol>
										<div class="carousel-inner">
											<!-- Slide 1 -->
											<div class="item active">
												<img src="img/demo/s1.jpg" alt="">
											</div>
											<!-- Slide 2 -->
											<div class="item">
												<img src="img/demo/s2.jpg" alt="">
											</div>
											<!-- Slide 3 -->
											<div class="item">
												<img src="img/demo/m3.jpg" alt="">
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-12">

									<div class="row">

										<div class="col-sm-3 profile-pic">
											<img src="img/avatars/avaj.jpg">
										</div>
										<div class="col-sm-9">
											<h1><?print $full_name;?><span class="semi-bold">(<?print $short_name;?>)</span>
											<br>
											<small> <?print $position;?></small></h1>

											<ul class="list-unstyled">
												<li>
													<p class="text-muted">
														<i class="fa fa-phone"></i> <?print $phone?></span>
													</p>
												</li>
												<li>
													<p class="text-muted">
														<i class="fa fa-envelope"></i> <?print $email?>
													</p>
												</li>
												<li>
													<p class="text-muted">
														<i class="fa fa-info"></i> <?print $info?>
													</p>
												</li>
											</ul>
											<form >
  												<i class="fa fa-heart-o"></i> <input type="color" name="favcolor" id="set-color" value=<?=$color?>>
  												<input type="hidden" name="favcolor" id="set-id" value=<?=$id?>>
											</form>
											<br>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
								</div>
							</div>
							<!-- end row -->
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-6">
					</div>
				</div>

			</div>


	</div>

</div>

<!-- end row -->

</section>
<!-- end widget grid -->


<script>
$('#set-color').change(function() {
	var color  = $('#set-color').val();
	var id  = $('#set-id').val();
	$.ajax({
		url: '/lib_reg/set_color.php',
		type: "POST",
		data: { color: color, id: id},
		success: function(data) {
        	$('.fa').animate({color: data}, 1000, function() {});
  			$('.fa').animate({color: '#a8a8a8'}, 1000, function() { });

		}
	});
});
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
	
	/*
	 * ALL PAGE RELATED SCRIPTS CAN GO BELOW HERE
	 * eg alert("my home function");
	 * 
	 * var pagefunction = function() {
	 *   ...
	 * }
	 * loadScript("js/plugin/_PLUGIN_NAME_.js", pagefunction);
	 * 
	 * TO LOAD A SCRIPT:
	 * var pagefunction = function (){ 
	 *  loadScript(".../plugin.js", run_after_loaded);	
	 * }
	 * 
	 * OR
	 * 
	 * loadScript(".../plugin.js", run_after_loaded);
	 */

	// PAGE RELATED SCRIPTS

	// pagefunction
	
	var pagefunction = function() {
		
	};
	
	// end pagefunction
	
	// run pagefunction on load

	pagefunction();

</script>
