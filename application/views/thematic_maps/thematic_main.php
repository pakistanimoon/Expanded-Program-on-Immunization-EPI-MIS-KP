<?php
  $month = (isset($data['month']))?$data['month']:''; 
  $year = (isset($data['year']))?$data['year']:'';
  $fmonth = $year.'-'.$month;
  //print_r($data);exit;
?>
<!--Content area--> 
<div class="flypanels-main">
    <div class="flypanels-topbar"> <a class="flypanels-button-left icon-menu" data-panel="treemenu" href="#"><i class="fa fa-bars"></i></a> <h2 class="topbar-heading">Expanded Program on Immunization Thematic Maps Dashboard</h2> </div>
    <div class="header_profilewraper">
		<div class="profile_dropdown">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> <?php echo $this -> session -> User_Name; ?> </button>
				<ul class="dropdown-menu">
					<li><a href="<?php echo base_url();?>Logout"> <i class="fa fa-key" aria-hidden="true"></i> Sign out </a></li>
				</ul>
			</div>
		</div>
    </div>
    <div class="loading hide">Loading&#8230;</div>
    <div class="flypanels-content">
		<div class="container-fluid">
			<div class="content_mainwraper">
				<div class="main_heading"> <?php echo $heading['mapName'] ?> Data <?php if(isset($heading['district'])){
					echo 'of '.$heading['district'];} ?> for <?php echo date('M Y',strtotime($fmonth)); ?> </div>
				<div class="carview_wraper">
					<ul class="row">
						<?php
							/*
							* Send heading, image and value to each card in 
							* different arrays to show different values, text and image.
							*/
							$cardOne['heading'] 	= "REPORTING FACILITIES";
							$cardOne['image'] 		= "chart1.png";
							$cardOne['value'] 		= number_format($totalDue); // For Numeric Values Send value formated in number_format.
							$cardTwo['heading'] 	= "SUBMITTED FACILITIES REPORTS";
							$cardTwo['image'] 		= "peichart.jpg";
							$cardTwo['value'] 		= number_format($totalSub); // For Numeric Values Send value formated in number_format.
							$cardThree['heading'] 	= "COMPLIANCE";
							$cardThree['image'] 	= "complince.png";
							$cardThree['value'] 	= $totalComp."%"; // For Percentage Values Send value concatenated with % to be shown in percentage.
							$cardFour['heading'] 	= "No. of Vaccinators";
							$cardFour['image'] 		= "vaccine.png";
							$cardFour['value']		= number_format($indicators['tot_technicians']); // For Numeric Values Send value formated in number_format.
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardOne);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardTwo);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardThree);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardFour);
						?>
					</ul>
				</div>
				<div class="map_sectionwraper">
					<div class="row">
						<div class="col-md-7">
							<div class="leftmmapsectionwrp">
								<div id="livefeedleftmap" class="livefeedleftmap"></div>
							</div>
						</div>				
						<div class="col-md-5">
							<div class="rightmmapsectionwrp">
								<div id="bar_graph_1" class="bar_graph_1"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="map_sectionwraper hide">
					<div class="row">
						<div class="col-md-7">
							<div class="leftmmapsectionwrp">
								<div id="livefeedleftmap1" class="livefeedleftmap1"></div>
							</div>
						</div>				
						<div class="col-md-5">
							<div class="rightmmapsectionwrp">
								<div id="bar_graph_2" class="bar_graph_2"></div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<div class="graph_listingwrp">
				<ul class="row">
				<?php
					/*
					* Send heading, image and value to each card in 
					* different arrays to show different values, text and image.
					*/
					$bottomCardOne['heading'] 		= "Monthly Target";
					$bottomCardOne['image'] 		= "visit.png";
					$bottomCardOne['value'] 		= number_format($indicators['monthlyTargetPopulation']); // For Numeric Values Send value formated in number_format.
					$bottomCardTwo['heading'] 		= "Monthly Surviving Infants";
					$bottomCardTwo['image'] 		= "servign.png";
					$bottomCardTwo['value'] 		= number_format($indicators['monthlySurvivingInfants']); // For Numeric Values Send value formated in number_format.
					$bottomCardThree['heading'] 	= "Monthly Pregnant Woman";
					$bottomCardThree['image'] 		= "wome.png";
					$bottomCardThree['value'] 		= number_format($indicators['monthlyPregnantLactatingPlWomen']); // For Percentage Values Send value concatenated with % to be shown in percentage.
					$bottomCardFour['heading'] 		= "Monthly CBA's";
					$bottomCardFour['image'] 		= "cba.png";
					$bottomCardFour['value']		= number_format($indicators['monthlyCbaLadies']); // For Numeric Values Send value formated in number_format.
					$this -> load -> view('thematic_maps/parts_view/bottom_cards', $bottomCardOne);
					$this -> load -> view('thematic_maps/parts_view/bottom_cards', $bottomCardTwo);
					$this -> load -> view('thematic_maps/parts_view/bottom_cards', $bottomCardThree);
					$this -> load -> view('thematic_maps/parts_view/bottom_cards', $bottomCardFour); 
				?>
				</ul>
			</div>
		</div>
    </div>				
</div>
    <!--Content area-->    
    <!--filter bar-->
<div class="filterbarwraper">
	<div id="mySidenavR" class="sidenavR">
		<a href="javascript:void(0)" class="closebtn" title="Filters" onclick="closeNavR()">×</a>
		<div class="filter_formwrp">
			<h2> Filters </h2>
			<?php 
				/*
				*	This will load filter form based on 
				*	name provided to filters array.
				*/
				$filters['filter'] = 'vaccineCompliance';
				$this->load->view('thematic_maps/parts_view/filters',$filters); ?>
		</div>
	</div>
	<div class="container-fluid">
		<span class="tooglebtnfilter"  onclick="openNavR()"><img src="<?php echo base_url();?>includes/images1/filericon.png"></span>
	</div>
</div>
  <!--filter bar-->
<?php 
	if(!isset($_REQUEST['export_excel'])){
		if(isset($edit)){
			$this->load->view('thematic_template/script', $data['edit'] = $edit);
		}else{
			$this->load->view('thematic_template/script');
		}
	}
	$data['id'] = 'livefeedleftmap';
	//print_r($serieses);exit;
	$data['serieses'] = $serieses;
	$data['indicators'] = $indicators;
	$data['heading'] = $heading;
	$data['fmonth'] = $fmonth;
	$data['filter'] = 'vaccineCompliance';
	$data['colorAxis'] = $colorAxis;
	$this -> load -> view('thematic_maps/parts_view/map', $data); 
	unset($data['serieses']);
	$data['id'] = 'bar_graph_1';
	$data['serieses_ranking'] = $serieses_ranking;
	$data['serieses_ranking_cat'] = $serieses_ranking_cat;
	$this -> load -> view('thematic_maps/parts_view/bar_graph', $data); 
?>
<script type="text/javascript">
	function draw_uc(id){
		var dataId = id;
		var fmonth = '<?php echo $fmonth; ?>';
		var url = '<?php echo base_url(); ?>/thematic_maps/ThematicCompliance/UcWiseMapData/'+id+'/'+fmonth;
		/* $.ajax({
			type: "POST",
			data: {id:dataId,fmonth:fmonth,map_id:'livefeedleftmap1',bar_id:'bar_graph_2'},
			url: "<?php echo base_url(); ?>thematic_maps/Thematic_compliance/UcWiseMapData",
			dataType: "json",
			success: function(result){
				$('#livefeedleftmap1').html(result.map);
				$('#bar_graph_2').html(result.bar);
			}
		}); */ 
	}
	function formatter(e){
		return 'District: <b>' + e.point.name + ' (' + e.point.id + ')' + '</b><br>Year-Month: <b>' + e.point.fmonth  + '</b><br> Total Due: <b>' + e.point.due  + '</b><br> Total Submitted: <b>' + e.point.sub + '</b><br> Percentage: <b>' + e.point.value + ' %</b>';
	}
	function eventHandler(e, run, fmonth){
		if(run){
        	var url = '<?php echo base_url(); ?>thematic_maps/ThematicCompliance/UcWiseMapData/'+e.point.id+'/'+fmonth+'/'+e.point.name;
        	window.open(url, '_blank');
			//draw_uc_map(e.point.id);
			$('.loading').removeClass('hide');
			//$('.map_sectionwraper').removeClass('hide');
		}
	}
</script>