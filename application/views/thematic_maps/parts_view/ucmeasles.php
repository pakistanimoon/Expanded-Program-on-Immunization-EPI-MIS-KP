<?php
	$total_suspectedCases = $summary-> suspected;
	$total_confirmedCases = $summary-> confirmed_measles + $summary-> confirmed_rubella;
	$perc_total_confirmedCases = ($total_suspectedCases > 0)?round(($total_confirmedCases/$total_suspectedCases)*100):0;
	$perc_confirmedMeasles_cases = ($total_suspectedCases > 0)?round(($summary-> confirmed_measles/$total_suspectedCases)*100):0;
	$perc_confirmedRubella_cases = ($total_suspectedCases > 0)?round(($summary-> confirmed_rubella/$total_suspectedCases)*100):0;
	$total_negativeCases = $summary-> negative;
	$perc_total_confirmedCases = ($total_suspectedCases > 0)?round(($total_confirmedCases/$total_suspectedCases)*100):0;
	$total_resultAwaitedCases = $total_suspectedCases - ($total_confirmedCases + $total_negativeCases);
	$total_resultAwaitedCases_perc = ($total_suspectedCases > 0)?round(($total_resultAwaitedCases/$total_suspectedCases)*100):0;
?>

<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- FontAwesome Include -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>covid/assets/fonts/fontawesome/css/all.css">
		<!-- Favicon -->
		<link rel="icon" href="<?php echo base_url(); ?>covid/assets/images/favicon.ico">
		<!-- Animate -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>covid/assets/animate/animate.min.css">
		<!-- AOS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>covid/assets/aos/aos.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>covid/assets/css/customcolors.css">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>covid/assets/bootstrap/bootstrap.min.css">
		<!-- Datatables Css -->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
		<!-- Styling -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>covid/assets/css/style.css">
		
		<title>Measles | Dashboard</title>
		<style>
			#second_section .tabs_row {
				height: 403px;
				background: #fff;
			}
		</style>
	</head>
	<body  data-aos-easing="ease-out-back" data-aos-duration="1000" data-aos-delay="0">
		<h3 data-aos="fade-down" style="background: #5493d6;text-align: center;color: #fff;">Measles Updates Dashboard</h3>
		<section id="second_section">
			<div class="container-fluid">
				<div class="row">
					<div  class="col-lg-6">
						<div class="row m-0 border_panel tabs_row" data-aos="fade-left">
							<div class="col-lg-12">
								<div id="idabc"></div>
							</div>
						</div>
					</div>
					<div data-aos="fade-left" class="col-lg-6 col-md-6 col-sm-12 col-12 pie-innersize-div p-0">
						<div class="row">
							<div data-aos="fade-right" class="col-lg-12 col-md-12 col-sm-12 col-12 pie-innersize-div">
								<div class="row m-0 border_panel">
									<div class="col-lg-6">
										<div id="pie-casesbygender"></div>
									</div>
									<div class="col-lg-6" style="position: relative; left: -35px;">
										<div class="progress mt-3">
											<div class="progress-bar" style="width:100%"></div>
										</div>
										<span class="detail">Total Suspected Cases are: <?php echo $summary -> suspected; ?></span>
										<div class="progress mt-4">
											<div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" style="width:<?php echo $summary -> perc_activecases; ?>%"></div>
										</div>
										<span class="detail">Cross Notified Pending Cases: <?php echo $summary -> crossnotified; ?> </span>
										<div class="progress mt-4">
											<div class="progress-bar progress-bar-striped progress-bar-animated" style="width:<?php echo $summary -> perc_male; ?>%"></div>
										</div>
										 <span class="detail">Male Cases: <?php echo $summary -> male; ?> (<?php echo round($summary -> perc_male); ?> % of Suspected Cases)</span>
										<div class="progress mt-4">
											<div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" style="width:<?php echo $summary -> perc_female; ?>%"></div>
										</div>
										<span class="detail">Female Cases: <?php echo $summary -> female; ?> (<?php echo round($summary -> perc_female); ?> % of Suspected Cases)</span>
									</div>
								</div>
							</div>
							<div data-aos="fade-right" class="col-lg-12 col-md-12 col-sm-12 col-12 pie-innersize-div">
								<div class="row m-0 border_panel">
									<div class="col-lg-6">
										<div id="pie-casesbyresult"></div>
									</div>
									<div class="col-lg-6" style="position: relative; left: -35px;">
										<div class="progress mt-3">
											<div class="progress-bar" style="width:100%"></div>
										</div>
										<span class="detail">Total Suspected Cases are: <?php echo $summary -> suspected; ?></span>
										<div class="progress mt-4">
											<div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" style="width:<?php echo $perc_total_confirmedCases; ?>%"></div>
										</div>
										 <span class="detail">Positive Cases: <?php echo $total_confirmedCases; ?> (<?php echo $perc_total_confirmedCases; ?> % of Suspected Cases)</span>
										<div class="progress mt-4">
											<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width:<?php echo $summary -> perc_negative; ?>%"></div>
										</div>
										<span class="detail">Negative Cases: <?php echo $summary -> negative; ?> (<?php echo round($summary -> perc_negative); ?> % of Suspected Cases)</span>
										<div class="progress mt-4">
											<div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width:<?php echo $summary -> perc_resultawaited; ?>%"></div>
										</div>
										<span class="detail">Result Awaited: <?php echo $total_resultAwaitedCases; ?> (<?php echo $total_resultAwaitedCases_perc; ?> % of Suspected Cases)</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</section>
		<section id="leftdiv">
			<div class="container-fluid">
				<div class="row">
					<div data-aos="fade-right" class="col-lg-3 custom-sidebar">
						<div class="leftSide_box">
							<img src="<?php //echo base_url(); ?>covid/assets/images/logo.svg" class="logo-side" alt="">
							<div class="row m-0 border-bottom">
								<div class="col-lg-4">
									<div class="inner-div">
										<img src="<?php echo base_url(); ?>covid/assets/images/icons/suspected.svg" alt="" class="img-fluid">
									</div>
								</div>
								<div class="col-lg-8 text-center">
									<h1 class="mb-0 cst-suspected-text"><?php echo ($summary -> suspected > 0)?$summary -> suspected:0; ?></h1>
									<h6>Suspected Cases</h6>
									 <div class="progress">
										<div class="progress-bar progress-bar-striped progress-bar-animated cst-suspected-bg" style="width:100%"></div>
									  </div>
								</div>
							</div>
							<div class="row m-0 border-bottom">
								<div class="col-lg-4">
									<div class="inner-div">
										<img src="<?php echo base_url(); ?>covid/assets/images/icons/active.svg" alt="" class="img-fluid">
									</div>
								</div>
								<div class="col-lg-8 text-center">
									<h1 class="mb-0 cst-active-text"><?php echo ($summary -> crossnotified > 0)?$summary -> crossnotified:0; ?></h1>
									<h6>Cross Notified Cases</h6>
									<div class="progress">
										<div class="progress-bar progress-bar-striped progress-bar-animated cst-active-bg" style="width:3%"></div>
									</div>
								</div>
							</div>
							<div class="row m-0 border-bottom">
								<div class="col-lg-4">
									<div class="inner-div">
										<img src="<?php echo base_url(); ?>covid/assets/images/icons/confirmed.svg" alt="" class="img-fluid">
									</div>
								</div>
								<div class="col-lg-8 text-center">
									<h1 class="mb-0 cst-confirmed-text"><?php echo $summary-> confirmed_measles; ?></h1>
									<h6>Measles Confirmed Cases</h6>
									<div class="progress">
										<div class="progress-bar progress-bar-striped progress-bar-animated cst-confirmed-bg" style="width:<?php echo $perc_confirmedMeasles_cases; ?>%"></div>
									</div>
								</div>
							</div>
							<div class="row m-0 border-bottom">
								<div class="col-lg-4">
									<div class="inner-div">
										<img src="<?php echo base_url(); ?>covid/assets/images/icons/negative.svg" alt="" class="img-fluid">
									</div>
								</div>
								<div class="col-lg-8 text-center border-bottom">
									<h1 class="mb-0 cst-negative-text"><?php echo $summary-> confirmed_rubella; ?></h1>
									<h6>Rubella Confirmed Cases</h6>
									<div class="progress">
										<div class="progress-bar progress-bar-striped progress-bar-animated cst-negative-bg" style="width:<?php echo $perc_confirmedRubella_cases; ?>%"></div>
									</div>
								</div>
							</div>
							<div class="row m-0 border-bottom">
								<div class="col-lg-4">
									<div class="inner-div">
										<img src="<?php echo base_url(); ?>covid/assets/images/icons/resultawaited.svg" alt="" class="img-fluid">
									</div>
								</div>
								<div class="col-lg-8 text-center">
									<h1 class="mb-0 cst-resultawaited-text"><?php echo ($total_resultAwaitedCases > 0)?$total_resultAwaitedCases:0; ?></h1>
									<h6>Result Awaited</h6>
									<div class="progress">
										<div class="progress-bar progress-bar-striped progress-bar-animated cst-resultawaited-bg" style="width:<?php echo $total_resultAwaitedCases_perc; ?>%"></div>
									</div>
								</div>
							</div>							
							<div class="row m-0 border-bottom">
								<div class="col-lg-4">
									<div class="inner-div">
										<img src="<?php echo base_url(); ?>covid/assets/images/icons/recoverd.svg" alt="" class="img-fluid">
									</div>
								</div>
								<div class="col-lg-8 text-center">
									<h1 class="mb-0 cst-recover-text"><?php echo ($summary -> recovered > 0)?$summary -> recovered:0; ?></h1>
									<h6>Recovered</h6>
									<div class="progress">
										<div class="progress-bar progress-bar-striped progress-bar-animated cst-recover-bg" style="width:<?php echo $summary -> perc_recovered; ?>%"></div>
									</div>
								</div>
							</div>
							<div class="row m-0 border-bottom">
								<div class="col-lg-4">
									<div class="inner-div">
										<img src="<?php echo base_url(); ?>covid/assets/images/icons/death.svg" alt="" class="img-fluid">
									</div>
								</div>
								<div class="col-lg-8 text-center">
									<h1 class="mb-0 cst-death-text"><?php echo ($summary -> deaths > 0)?$summary -> deaths:0; ?></h1>
									<h6>Deaths</h6>
									<div class="progress">
										<div class="progress-bar progress-bar-striped progress-bar-animated cst-death-bg" style="width:<?php echo $summary -> perc_deaths; ?>%"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php //print_r($districtSummary); ?>
					<div data-aos="fade-left" class="col-lg-9 datatable-box">
						<table id="example" class="table table-striped table-bordered" style="width:100%">
							<thead>
								<tr>
									<th rowspan="2">District</th>
									<th class="text-center"  rowspan="2">Suspected Cases</th>
									<th class="text-center"  rowspan="2">Cross Notified <br>(Pending)</th>
									<th class="text-center"  colspan="2">Positive Measles</th>
									<th class="text-center"  colspan="2">Positive Rubella</th>
									<th class="text-center"  colspan="2">Negative</th>
									<th class="text-center"  colspan="2">Result Awaited</th>
									<th class="text-center"  colspan="2">Recovered</th>
									<th class="text-center"  colspan="2">Deaths</th>
								</tr>
								<tr>
									<th class="text-center" >Cases</th>
									<th class="text-center" >%</th>
									<th class="text-center" >Cases</th>
									<th class="text-center" >%</th>
									<th class="text-center" >Cases</th>
									<th class="text-center" >%</th>
									<th class="text-center" >Cases</th>
									<th class="text-center" >%</th>
									<th class="text-center" >Cases</th>
									<th class="text-center" >%</th>
									<th class="text-center" >Cases</th>
									<th class="text-center" >%</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($districtSummary as $row){ ?>
								<tr>
									<td><?php echo $row['districtname']; ?></td>
									<td class="text-center"><?php echo ($row['suspected']===null)? 0:$row['suspected']; ?></td>
									<td class="text-center"><?php echo ($row['crossnotified']===null)? 0:$row['crossnotified']; ?></td>
									<td class="text-center"><?php echo ($row['confirmed_measles']===null)? 0:$row['confirmed_measles']; ?></td>
									<td class="text-center"><?php echo round($row['perc_confirmed_measles']); ?></td>
									<td class="text-center"><?php echo ($row['confirmed_rubella']===null)? 0:$row['confirmed_rubella']; ?></td>
									<td class="text-center"><?php echo round($row['perc_confirmed_rubella']); ?></td>
									<td class="text-center"><?php echo ($row['negative']===null)? 0:$row['negative']; ?></td>
									<td class="text-center"><?php echo round($row['perc_negative']); ?></td>
									<td class="text-center"><?php echo ($row['resultawaited']===null)? 0:$row['resultawaited']; ?></td>
									<td class="text-center"><?php echo round($row['perc_resultawaited']); ?></td>
									<!-- <td class="text-center"><?php //echo ($row['activecases']===null && $row['activecases'] < 1)? 0:$row['activecases']; ?></td>
									<td class="text-center"><?php //echo round($row['perc_activecases']); ?></td> -->
									<!-- <td class="text-center"><?php //echo ($row['activecases']===null || $row['activecases'] < 1)? 0:$row['activecases']; ?></td>
									<td class="text-center"><?php //echo ($row['perc_activecases']===null || $row['perc_activecases'] < 0)? 0:round($row['perc_activecases']); ?></td>  -->
									<td class="text-center"><?php echo ($row['recovered']===null)? 0:$row['recovered']; ?></td>
									<td class="text-center"><?php echo round($row['perc_recovered']); ?></td> 
									<td class="text-center"><?php echo ($row['deaths']===null)? 0:$row['deaths']; ?></td>
									<td class="text-center"><?php echo round($row['perc_deaths']); ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>
		
		<section id="second_section">
			<div class="container-fluid">
				<div class="row">
					<div data-aos="fade-right" class="col-lg-6 col-md-6 col-sm-12 col-12 pie-innersize-div">
						<div class="row m-0 border_panel">
							<div class="col-lg-6 p-0">
								<div id="pie-innersize1"></div>
							</div>
							<div class="col-lg-6" style="position: relative; left: -35px;">
								<div class="progress mt-5">
									<div class="progress-bar" style="width:100%"></div>
								</div>
								<span class="detail">Total Suspected Cases area: <?php echo $summary -> suspected; ?></span>
								<div class="progress mt-4">
									<div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" style="width:3%"></div>
								</div>
								<span class="detail">Cross Notified Cases: <?php echo $summary -> crossnotified; ?></span>
								<div class="progress mt-4">
									<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width:<?php echo $summary -> perc_recovered; ?>%"></div>
								</div>
								 <span class="detail">Recovered Cases: <?php echo $summary -> recovered; ?> (<?php echo round($summary -> perc_recovered); ?> % of Suspected Cases)</span>
								<div class="progress mt-4">
									<div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" style="width:<?php echo $summary -> perc_deaths; ?>%"></div>
								</div>
								<span class="detail">Deaths: <?php echo $summary -> deaths; ?> (<?php echo round($summary -> perc_deaths); ?> % of Suspected Cases)</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="row m-0 tabs_row border_panel" data-aos="fade-left" style="height: 300px;">
							<div class="col-md-2 p-0">
								<ul class="nav nav-pills flex-column" id="myTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="suspected-tab" data-toggle="tab" href="#suspected<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" role="tab" aria-controls="suspected<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" aria-selected="true">Suspected</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="confirmed-tab" data-toggle="tab" href="#confirmed<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" role="tab" aria-controls="confirmed<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" aria-selected="true">Confirmed</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="deaths-tab" data-toggle="tab" href="#deaths<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" role="tab" aria-controls="deaths<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" aria-selected="false">Deaths</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="recovered-tab" data-toggle="tab" href="#recovered<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" role="tab" aria-controls="recovered<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" aria-selected="false">Recoverd</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="male-tab" data-toggle="tab" href="#male<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" role="tab" aria-controls="male<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" aria-selected="false">Male Cases</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="female-tab" data-toggle="tab" href="#female<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" role="tab" aria-controls="female<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" aria-selected="false">Female Cases</a>
									</li>
								</ul>
							</div>
							<!-- /.col-md-4 -->
							<div class="col-md-10">
								<div class="tab-content" id="myTabContent<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>">
									<div class="tab-pane fade show active" id="suspected<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" role="tabpanel" aria-labelledby="suspected-tab">
										<div id="container0<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>"></div>
									</div>
									<div class="tab-pane fade" id="confirmed<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" role="tabpanel" aria-labelledby="confirmed-tab">
										<div id="container1<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>"></div>
									</div>
									<div class="tab-pane fade" id="deaths<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" role="tabpanel" aria-labelledby="deaths-tab">
										<div id="container2<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>"></div>
									</div>
									<div class="tab-pane fade" id="recovered<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" role="tabpanel" aria-labelledby="recovered-tab">
										<div id="container3<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>"></div>
									</div>
									<div class="tab-pane fade" id="male<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" role="tabpanel" aria-labelledby="male-tab">
										<div id="container4<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>"></div>
									</div>
									<div class="tab-pane fade" id="female<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>" role="tabpanel" aria-labelledby="female-tab">
										<div id="container5<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>"></div>
									</div>
								</div>
							</div>
							<!-- /.col-md-8 -->
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Jquery -->
		<script src="<?php echo base_url(); ?>covid/assets/js/jquery-3.4.1.min.js"></script>
		<!-- Hightcharts -->
		<script src="https://code.highcharts.com/highcharts.src.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>
		<script src="https://code.highcharts.com/maps/modules/map.js"></script>
		<!-- Data Tables -->
		<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="<?php echo base_url(); ?>covid/assets/bootstrap/popper.min.js"></script>
		<script src="<?php echo base_url(); ?>covid/assets/bootstrap/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>covid/assets/aos/aos.js"></script>
		<script>
			function isMobileDevice() {
				return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
			};
			
			function formatter(e,ucwisemap=false){
				var text= 'District';
				if(ucwisemap == true){
					text = 'Union Council';
				}
				return text+': <b>' + e.point.name + ' (' + e.point.id + ')' + '</b><br> Total Suspected Cases: <b>' + e.point.value  + '</b>';
			}
	
			$('#idabc').highcharts('Map', {
				title: {
					text: '<?php echo $typeWise; ?> Wise Measles Suspected Cases'
				},
				subtitle: {
					text: '<?php echo $subtitle; ?>'
				},
				credits: {
					enabled: true,
					href: 'http://pacetec.net/',
					text: 'Pace Technologies'
				},
				mapNavigation: {
					enabled: true,
					buttonOptions: {
						verticalAlign: 'bottom'
					}
				}, 
				legend: {
					align: 'left',
					verticalAlign: 'top',
					x: 0,
					y: 70,
					floating: true,
					layout: 'vertical',
					valueDecimals: 0,
					backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255, 255, 255, 0.85)'
				},
				tooltip: {
					formatter: function () {
						<?php
						if($distcode && $distcode != NULL){ ?>
							return formatter(this,true);
						<?php
						}else{ ?>
						return formatter(this,false);
						<?php } ?>
					}
				},
				colorAxis: {
					type : 'logarithmic',
					maxColor: '#dc3545'
				},
				plotOptions: {
						series: {
							events: {
								click: function (e) {
									if(isMobileDevice){
										//eventHandler(e, run, fmonth, casetype);
									}
								}
							},
							dataLabels:{
								align: 'center',
								enabled: true,
								allowOverlap : false,
								style:{
									fontSize : '8px',
									color : 'contrast'
								},
								formatter: function () {
									return this.point.name+':'+this.point.value;
								},
								backgroundColor: undefined,
								crop : false,
								overflow : "justify",
							}
						}
				},
				series: <?php echo $serieses; ?>,
				exporting: {
					buttons: {
						contextButton: {
							menuItems: [{
								textKey: 'downloadPNG',
								onclick: function () {
									this.exportChart({
										type : 'image/png'
									});
								}
							}, {
								textKey: 'downloadJPEG',
								onclick: function () {
									this.exportChart({
										type: 'image/jpeg'
									});
								}
							},{
								textKey: 'downloadPDF',
								onclick: function () {
									this.exportChart({
										type : 'application/pdf'
									});
								}
							}]
						}
					}
				}
			});
			// for Animate
			function testAnim(x) {
				$('#animationSandbox').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					$(this).removeClass();
				});
			};

			$(document).ready(function(){
				$(document).on('click', '.js--triggerAnimation', function(e){
					e.preventDefault();
					var anim = $('.js--animations').val();
					testAnim(anim);
				});
				$(document).on('change','.js--animations', function(){
					var anim = $(this).val();
					testAnim(anim);
				});
			});
			// for AOS
			AOS.init({
				easing: 'ease-out-back',
				duration: 1000
			});
			// for AOS Loading
			$(document).on('click','.hero__scroll', function(e) {
				$('html, body').animate({
					scrollTop: $(window).height()
				}, 1200);
			});
		</script>
		<script>
			$(document).on('click',".top-li", function(){
				$(".top-li").removeClass('active');
				$(this).toggleClass("active");
			});
			$(document).on("click", function(e) {
				if ($(e.target).is(".top-li") === false) {
					$(".top-li").removeClass("active");
				}
			});
			// For Data Table
			$(document).ready(function() {
				$('#example').DataTable({
					"pageLength": 10,
					"order": [[ 1, "desc" ]]
				});
			});
		</script>
		<script>
			/*
			-----------------------------------------------------------
								Pie InnerSize Chart  - 1
			-----------------------------------------------------------
			*/
			Highcharts.chart('pie-innersize1', {
				chart: {
					 backgroundColor: false,
					type: 'pie',
					height: '300px',
					spacingLeft: 0
					
				},
				plotOptions: {
					pie: {
						innerSize: '70%',
						 dataLabels: {
							distance: '2%'
						}
					},
				},
				colors: ['#dc3545','#28a745','#ffc107'],
				exporting:false,
				title:false,
				series: [{
					 showInLegend: true,
					data: [
						['Deaths',      <?php echo round($summary -> deaths); ?>],
						['Recover',      <?php echo round($summary -> recovered); ?>],
						['Cross Notified',      <?php echo round($summary -> crossnotified); ?>]
					]
				}],
			});
			/*
			-----------------------------------------------------------
								Pie CASES by Result
			-----------------------------------------------------------
			*/
			Highcharts.chart('pie-casesbyresult', {
				chart: {
					 backgroundColor: false,
					type: 'pie',
					height: '200px',
					spacingBottom: -2,
					spacingTop: -2,
					spacingLeft: 0
					
				},
				plotOptions: {
					pie: {
						innerSize: '70%',
						 dataLabels: {
						distance: '2%'
						}
					},
				},
				colors: ['#dc3545','#28a745','#17a2b8'],
				exporting:false,
				title:false,
				series: [{
					 showInLegend: true,
					data: [
						['Positive',      <?php echo round($total_confirmedCases); ?>],
						['Negative',      <?php echo round($summary -> negative); ?>],
						['Result Awaited',      <?php echo round($summary -> resultawaited); ?>]
					]
				}],
			});
			/*
			-----------------------------------------------------------
								Pie CASES by Outcome
			-----------------------------------------------------------
			*/
			Highcharts.chart('pie-casesbygender', {
				chart: {
					 backgroundColor: false,
					type: 'pie',
					height: '200px',
					spacingBottom: -2,
					spacingTop: -2,
					spacingLeft: 0
					
				},
				plotOptions: {
					pie: {
						innerSize: '70%',
						 dataLabels: {
						distance: '2%'
						}
					},
				},
				colors: ['#007bff','#dc3545'],
				exporting:false,
				title:false,
				series: [{
					 showInLegend: true,
					data: [
						['Male',      <?php echo round($summary -> male); ?>],
						['Female',      <?php echo round($summary -> female); ?>]
					]
				}],
			});
		</script>
		<script>
			/* Suspected Cases */
			Highcharts.chart('container0'+'<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>', {
				chart: {
					type: 'column',
					height: '300px'
				},
				title: {
					text: 'Suspected Cases'
				},
				subtitle: {
					text: 'Weekly Suspected Cases'
				},
				xAxis: {
					type: 'category',
					labels: {
						rotation: -45,
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Weekly Cases'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'No of Cases: <b>{point.y:.1f}</b>'
				},
				series: [{
					name: 'Week Cases',
					data: [
					<?php foreach($weeklySuspected as $row){ ?>
						["<?php echo $row['fweek']; ?>", <?php echo $row['cnt']; ?>],
					<?php } ?>
					],
					dataLabels: {
						enabled: true,
						rotation: -90,
						color: '#FFFFFF',
						align: 'right',
						format: '{point.y:.1f}', // one decimal
						y: 10, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}]
			});
			/* Confirmed Cases */
			Highcharts.chart('container1'+'<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>', {
				chart: {
					type: 'column',
					height: '300px'
				},
				title: {
					text: 'Confirmed Cases'
				},
				subtitle: {
					text: 'Weekly Confirmed Cases'
				},
				xAxis: {
					type: 'category',
					labels: {
						rotation: -45,
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Weekly Cases'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'No of Cases: <b>{point.y:.1f}</b>'
				},
				series: [{
					name: 'Week Cases',
					data: [
						<?php foreach($weeklyConfirmed as $row){ ?>
							["<?php echo $row['fweek']; ?>", <?php echo $row['cnt']; ?>],
						<?php } ?>
					],
					dataLabels: {
						enabled: true,
						rotation: -90,
						color: '#FFFFFF',
						align: 'right',
						format: '{point.y:.1f}', // one decimal
						y: 10, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}]
			});
			/* Deaths Cases */
			Highcharts.chart('container2'+'<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>', {
				chart: {
					type: 'column',
					height: '300px'
				},
				title: {
					text: 'Measles Deaths'
				},
				subtitle: {
					text: 'Weekly Measles Deaths'
				},
				xAxis: {
					type: 'category',
					labels: {
						rotation: -45,
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Weekly Deaths'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'No of Deaths: <b>{point.y:.1f}</b>'
				},
				series: [{
					name: 'Week Deaths',
					data: [
						<?php foreach($weeklyDeaths as $row){ ?>
							["<?php echo $row['fweek']; ?>", <?php echo $row['cnt']; ?>],
						<?php } ?>
					],
					dataLabels: {
						enabled: true,
						rotation: -90,
						color: '#FFFFFF',
						align: 'right',
						format: '{point.y:.1f}', // one decimal
						y: 10, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}]
			});
			/* Recovered Cases */
			Highcharts.chart('container3'+'<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>', {
				chart: {
					type: 'column',
					height: '300px'
				},
				title: {
					text: 'Recovered Cases'
				},
				subtitle: {
					text: 'Weekly Recovered Cases'
				},
				xAxis: {
					type: 'category',
					labels: {
						rotation: -45,
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Weekly Recoverd Cases'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'No of Cases: <b>{point.y:.1f}</b>'
				},
				series: [{
					name: 'Week Recoverd Cases',
					data: [
						<?php foreach($weeklyRecovered as $row){ ?>
							["<?php echo $row['fweek']; ?>", <?php echo $row['cnt']; ?>],
						<?php } ?>
					],
					dataLabels: {
						enabled: true,
						rotation: -90,
						color: '#FFFFFF',
						align: 'right',
						format: '{point.y:.1f}', // one decimal
						y: 10, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}]
			});
			/* Confirmed Cases */
			Highcharts.chart('container4'+'<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>', {
				chart: {
					type: 'column',
					height: '300px'
				},
				title: {
					text: 'Male Cases'
				},
				subtitle: {
					text: 'Weekly Male Cases'
				},
				xAxis: {
					type: 'category',
					labels: {
						rotation: -45,
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Male Cases'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'No of Cases: <b>{point.y:.1f}</b>'
				},
				series: [{
					name: 'Week Cases',
					data: [
						<?php foreach($weeklyMale as $row){ ?>
							["<?php echo $row['fweek']; ?>", <?php echo $row['cnt']; ?>],
						<?php } ?>
					],
					dataLabels: {
						enabled: true,
						rotation: -90,
						color: '#FFFFFF',
						align: 'right',
						format: '{point.y:.1f}', // one decimal
						y: 10, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}]
			});
			/* Female Cases */
			Highcharts.chart('container5'+'<?php echo ($distcode && $distcode != NULL)?$distcode:''; ?>', {
				chart: {
					type: 'column',
					height: '300px'
				},
				title: {
					text: 'Female Cases'
				},
				subtitle: {
					text: 'Weekly Female Cases'
				},
				xAxis: {
					type: 'category',
					labels: {
						rotation: -45,
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Weekly Cases'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: 'No of Cases: <b>{point.y:.1f}</b>'
				},
				series: [{
					name: 'Week Cases',
					data: [
						<?php foreach($weeklyFemale as $row){ ?>
							["<?php echo $row['fweek']; ?>", <?php echo $row['cnt']; ?>],
						<?php } ?>
					],
					dataLabels: {
						enabled: true,
						rotation: -90,
						color: '#FFFFFF',
						align: 'right',
						format: '{point.y:.1f}', // one decimal
						y: 10, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}]
			});
		</script>
	</body>
</html>