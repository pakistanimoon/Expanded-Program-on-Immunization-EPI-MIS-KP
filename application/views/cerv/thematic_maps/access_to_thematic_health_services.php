<?php
    $month = (isset($data['month']))?$data['month']:''; 
    $year = (isset($data['year']))?$data['year']:'';
    $dataId = 0;
    if(isset($data['id'])){
    	$dataId = $data['id'];
    }
    $fmonth = $year.'-'.$month;
    if($data['reportType'] == 'monthly'){
    	$title_M_Y = date('M Y',strtotime($fmonth));
		$hovermap = $year.'-'.$month;
		$hovermap1 = "Year-Month:";
	}else if($data['reportType'] == 'quarterly'){
		$month = '';
		$quarter = $data['quarter'];
		$title_M_Y = 'Quarter '.$quarter.' of '.$year;
		$hovermap = $year.'-'.$quarter;
		$hovermap1 = "Year-Qtr:";
	}else if($data['reportType'] == 'yearly'){
		$title_M_Y = $year;
		$hovermap = $year;
		$hovermap1 = "Year:";
	}
  //print_r($data['indicators'][0]);exit;
  $vaccinesArray = array('BCG','Hep B-Birth','OPV-0','OPV-1','OPV-2','OPV-3','PENTA-1','PENTA-2','PENTA-3','PCV10-1','PCV10-2','PCV10-3','IPV','Rota-1','Rota-2','Measles-I','Fully Immunized','Measles-II');
?>
<!--Content area--> 
<div class="flypanels-main">
	<div class="flypanels-topbar"> 
		<a class="flypanels-button-left icon-menu" data-panel="treemenu" href="#"><i class="fa fa-bars"></i></a>
		<h5 class="h5-heading">CERV Dashboard</h5>
		<h2 class="topbar-heading">Child Electronic Registration & Vaccination Dashboard</h2>
	</div>
	<div class="header_profilewraper">
		<div class="profile_dropdown">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> <span class="fed-username"><?php echo $this -> session -> User_Name; ?></span> </button>
				<ul class="dropdown-menu signout-ul">
					<li><a href="<?php echo base_url();?>Logout"> <i class="fa fa-key" aria-hidden="true"></i> Sign out </a>
					</li>
				</ul>
			</div>
		</div>
	</div>
    <div class="loading hide">Loading&#8230;</div>
    <div class="flypanels-content">
		<div class="container-fluid">
			<input type="hidden" id="vaccineBy" value="">
			<div class="content_mainwraper">
				<div class="main_heading"> 
					<span class="big-screen"><?php echo $heading['mapName'] ?></span>
					<span class="small-screen"><?php echo $heading['mapName'] ?></span> 
				</div>
				<!--<div class="carview_wraper">
					<ul class="row">
						<?php
							/*
							* Send heading, image and value to each card in 
							* different arrays to show different values, text and image.
							*/
							/* $vacName = str_replace('Coverage', '', $heading['mapName']);
							$cardOne['heading'] 	= "Fixed Vaccination";
							$cardOne['image'] 		= "fixedvaccination.png";
							$cardOne['value'] 		= number_format($data['indicators'][0]['fixedvaccination']); // For Numeric Values Send value formated in number_format.
							$cardOne['width'] 		= '2';

							$cardTwo['heading'] 	= "Outreach Vaccination";
							$cardTwo['image'] 		= "outreachvaccination.png";
							$cardTwo['value'] 		= number_format($data['indicators'][0]['outreachvaccination']); // For Numeric Values Send value formated in number_format.
							$cardTwo['width'] 		= '2';

							$cardThree['heading'] 	= "Mobile Vaccination";
							$cardThree['image'] 	= "mobile.png";
							$cardThree['value'] 	= number_format($data['indicators'][0]['mobilevaccination']); // For Percentage Values Send value concatenated with % to be shown in percentage.
							$cardThree['width'] 	= '2';
							
							$cardFour['heading'] 	= "LHW Vaccination";
							$cardFour['image'] 		= "female.png";
							$cardFour['value'] 		= number_format($data['indicators'][0]['healthhousevaccination']); // For Percentage Values Send value concatenated with % to be shown in percentage.
							$cardFour['width'] 		= '2';
							
							$cardFive['heading'] 	= "Total Target";
							$cardFive['heading_2'] 	= "Total Coverage";
							$cardFive['image'] 		= "total.png";
							$cardFive['value'] 		= number_format($data['indicators'][1]['totaltarget']); // For Percentage Values Send value concatenated with % to be shown in percentage.
							$cardFive['value_2'] 	= round(number_format($data['indicators'][1]['totalcoverage'])).'%';
							$cardFive['width'] 		= '4';
							$this -> load -> view('cerv/thematic_maps/parts_view/top_cards', $cardOne);
							$this -> load -> view('cerv/thematic_maps/parts_view/top_cards', $cardTwo);
							$this -> load -> view('cerv/thematic_maps/parts_view/top_cards', $cardThree);
							$this -> load -> view('cerv/thematic_maps/parts_view/top_cards', $cardFour);
							$this -> load -> view('cerv/thematic_maps/parts_view/top_cards_2', $cardFive); */
						?>
					</ul>
				</div>-->
				<div class="map_sectionwraper">
					<div class="row">
						<div class="col-md-7">
							<div class="leftmmapsectionwrp">
								<div id="livefeedleftmap" class="livefeedleftmap"></div>
							</div>
						</div>				
						<div class="col-md-5" style="height: 636px;overflow-y: auto;overflow-x: hidden;">
							<div class="rightmmapsectionwrp">
								<div id="bar_graph_1" class="bar_graph_1" style="height:1000px"></div>
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
				<div class="filterRow hide">
				<?php
					$filterRow['month']= $month;
					$this->load->view('cerv/thematic_maps/parts_view/filterRow',$filterRow); 
				?>
				</div>
				<br>
				<div class="ucdetailsdata hide">
				</div>
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
				$filters['filter'] = 'AccessToHealthServices';
				$filters['dropout'] = false;
				$this->load->view('cerv/thematic_maps/parts_view/filters',$filters); ?>
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
	$data['serieses'] = $serieses;
	$data['indicators'] = $indicators;
	$data['heading'] = $heading;
	$data['fmonth'] = $fmonth;
	$data['filter'] = 'AccessToHealthServices';
	$data['colorAxis'] = $colorAxis;
	$this -> load -> view('cerv/thematic_maps/parts_view/map', $data); 
	unset($data['serieses']);
	$data['id'] = 'bar_graph_1';
	$data['serieses_ranking'] = $serieses_ranking;
	$data['serieses_ranking_cat'] = $serieses_ranking_cat;
	$this -> load -> view('cerv/thematic_maps/parts_view/bar_graph', $data); 
?>
<script type="text/javascript">
	$( document ).ajaxStart(function() {
		$('.loading').removeClass('hide'); 
	});
	$( document ).ajaxComplete(function() {
		$('.loading').addClass('hide'); 
	});
	$(document).on('click',"#reportType",function(){
		if($(this).val() == "yearly"){
			$('#monthDiv').hide();
			$('#month').val('0');
			$('#month').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
			$('#biyearDiv').hide();
			$('#biyear').removeAttr('required','required');
		}else if($(this).val() == "biyearly"){
			$('#monthDiv').hide();
			$('#month').removeAttr('required','required');
			$('#quarter').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#biyearDiv').show();
			$('#biyear').attr('required','required');
		}else if($(this).val() == "quarterly"){
			$('#monthDiv').hide();
			$('#month').removeAttr('required','required');
			$('#quarterDiv').show();
			$('#quarter').attr('required','required');
			$('#biyearDiv').hide();
			$('#biyear').removeAttr('required','required');
		}else if($(this).val() == "monthly"){
			$('#monthDiv').show();
			$('#month').attr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
			$('#biyearDiv').hide();
			$('#biyear').removeAttr('required','required');
		}else{}
	});
	$(document).ready(function(){
		$('.crdview_grphwrp').css('cursor','pointer');
		$('#reportType').trigger('click');

		
	});
</script>