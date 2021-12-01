<?php
?>
<!--Content area--> 
<div class="flypanels-main">
    <!--<div class="flypanels-topbar"> 
		<a class="flypanels-button-left icon-menu" data-panel="treemenu" href="#"><i class="fa fa-bars"></i></a>
		<h5 class="h5-heading">Jordan Dashboard</h5>
		<h2 class="topbar-heading">Jordan Thematic Maps Dashboard</h2>
	</div>-->
    <!--<div class="header_profilewraper">
		<div class="profile_dropdown">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> <span class="fed-username"><?php echo 'jordan_user'; ?></span> </button>
				<ul class="dropdown-menu signout-ul">
					<li><a href="#"> <i class="fa fa-key" aria-hidden="true"></i> Sign out </a></li>
				</ul>
			</div>
		</div>
    </div>-->
    <div class="loading hide">Loading&#8230;</div>
    <div class="flypanels-content">
		<div class="container-fluid">
			<div class="content_mainwraper">
				<!--<div class="main_heading"> 
					<span class="big-screen"><?php echo $heading['mapName'] ?></span>
					<span class="small-screen"><?php echo $heading['mapName'] ?></span> 
				</div>-->
				<!--<div class="carview_wraper">
					<ul class="row">
						<?php
							/*
							* Send heading, image and value to each card in 
							* different arrays to show different values, text and image.
							*/
							/* $cardOne['heading'] 	= "Measles %";
							$cardOne['image'] 		= "chart1.png";
							$cardOne['value'] 		= 93; // For Numeric Values Send value formated in number_format.
							$cardTwo['heading'] 	= "OPV3 %";
							$cardTwo['image'] 		= "peichart.jpg";
							$cardTwo['value'] 		= 101; // For Numeric Values Send value formated in number_format.
							$cardThree['heading'] 	= "HBV3 %";
							$cardThree['image'] 	= "timely.png";
							$cardThree['value'] 	= 101; // For Percentage Values Send value concatenated with % to be shown in percentage.
							$cardFour['heading'] 	= "TT2+ %";
							$cardFour['image'] 		= "complince.png";
							$cardFour['value']		= 21; // For Numeric Values Send value formated in number_format.
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardOne);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardTwo);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardThree);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardFour); */
						?>
					</ul>
				</div>-->
				<div class="map_sectionwraper">
					<div class="row">
						<div class="col-md-12">
							<div class="leftmmapsectionwrp">
								<div id="livefeedleftmap" class="livefeedleftmap"></div>
							</div>
						</div>				
						<!--<div class="col-md-5" >
							<div class="rightmmapsectionwrp scrollset">
								<div id="bar_graph_1" class="" ></div>
							</div>
						</div>-->
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
				</ul>
			</div>
		</div>
    </div>				
</div>
    <!--Content area-->    
    <!--filter bar-->
<!--<div class="filterbarwraper">
	<div id="mySidenavR" class="sidenavR">
		<a href="javascript:void(0)" class="closebtn" title="Filters" onclick="closeNavR()">×</a>
		<div class="filter_formwrp">
			<h2> Filters </h2>
			<?php 
				/*
				*	This will load filter form based on 
				*	name provided to filters array.
				*/
				/* $filters['filter'] = 'nil';
				$this->load->view('thematic_maps/parts_view/filters',$filters); */ ?>
		</div>
	</div>
	<div class="container-fluid">
		<span class="tooglebtnfilter"  onclick=""><img src="<?php echo base_url();?>includes/images1/filericon.png"></span>
	</div>
</div>-->
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
	//$data['indicators'] = $indicators;
	$data['heading'] = $heading;
	$data['fmonth'] = "";
	$data['filter'] = 'nil';
	//$data['colorAxis'] = $colorAxis;
	$this -> load -> view('thematic_maps/parts_view/map', $data); 
	unset($data['serieses']);
	$data['id'] = 'bar_graph_1';
	$data['serieses_ranking'] = $serieses_ranking;
	$data['serieses_ranking_cat'] = $serieses_ranking_cat;
	$this -> load -> view('thematic_maps/parts_view/bar_graph', $data); 
?>
<script type="text/javascript">
	$( document ).ajaxStart(function() {
		$('.loading').removeClass('hide'); 
	});
	$( document ).ajaxComplete(function() {
		$('.loading').addClass('hide'); 
	});
	$(document).ready(function(){
		$('.crdview_grphwrp').css('cursor','pointer');
	});

	function formatter(e,distwisemap='false'){
		var dataId = ""+e.point.id;
		if(dataId.length <= 2){
			var text= 'Governorate';
		} else {
			text = 'District';
		}
		return text+': <b>' + e.point.name + ' (' + e.point.id + ')' + '</b><br> ' + '% of Infants and Pregnant Women: <b>' + e.point.value + '</b>';
	}

	function eventHandler(e, run){
		var dataId = ""+e.point.id;
		if(run){
			if(dataId.length <= 2){
				var url = '<?php echo base_url(); ?>thematic_maps/AccessToHealthServices/onClickDistrictWiseMapData/'+dataId+'/';
				window.open(url, '_blank');
			}
			else{}
		}
		else{
	
		}
	}
</script>