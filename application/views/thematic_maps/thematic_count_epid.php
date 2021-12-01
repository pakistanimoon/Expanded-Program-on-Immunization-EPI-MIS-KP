<?php
    $month = $week =(isset($data['week']))?$data['week']:''; 
    $year = (isset($data['year']))?$data['year']:'';
    $dataId = 0;
    if(isset($data['id'])){
    	$dataId = $data['id'];
    }
    $fmonth = $year.'-'.$month;
  	//print_r($data);exit;
  $vaccinesArray = array('BCG','Hep B-Birth','OPV-0','OPV-1','OPV-2','OPV-3','PENTA-1','PENTA-2','PENTA-3','PCV10-1','PCV10-2','PCV10-3','IPV-1','Rota-1','Rota-2','MR-I','Fully Immunized','MR-II','DTP','TCV','IPV-2');
?>
<!--Content area--> 
<div class="flypanels-main">
    <div class="flypanels-topbar"> 
		<a class="flypanels-button-left icon-menu" data-panel="treemenu" href="#"><i class="fa fa-bars"></i></a>
		<h5 class="h5-heading">EPI Dashboard</h5>
		<h2 class="topbar-heading">Expanded Program on Immunization Thematic Maps Dashboard</h2>
	</div>
    <div class="header_profilewraper">
		<div class="profile_dropdown">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> <span class="fed-username"><?php echo $this -> session -> User_Name; ?></span> </button>
				<ul class="dropdown-menu signout-ul">
					<li><a href="<?php echo base_url();?>Logout"> <i class="fa fa-key" aria-hidden="true"></i> Sign out </a></li>
				</ul>
			</div>
		</div>
    </div>
    <div class="loading hide">Loading&#8230;</div>
    <div class="flypanels-content">
		<div class="container-fluid">
			<div class="content_mainwraper">
				<div class="main_heading"> 
					<span class="big-screen"><?php echo $heading['mapName'] ?></span>
					<span class="small-screen"><?php echo $heading['mapName'] ?></span> 
				</div>
				<div class="carview_wraper">
					<ul class="row">
						<?php
							/*
							* Send heading, image and value to each card in 
							* different arrays to show different values, text and image.
							*/
							$cardOne['heading'] 	= 'Male Cases';
							$cardOne['image'] 		= "male.png";
							$cardOne['value'] 		= $data['indicators']['mtotal']; // For Numeric Values Send value formated in number_format.
							$cardOne['width'] 		= '4';

							$cardTwo['heading'] 	= 'Female Cases';
							$cardTwo['image'] 		= "female.png";
							$cardTwo['value'] 		= $data['indicators']['ftotal']; // For Numeric Values Send value formated in number_format.
							$cardTwo['width'] 		= '4';

							$cardThree['heading'] 	= 'Total Cases';
							$cardThree['image'] 	= "total.png";
							$cardThree['value'] 	= $data['indicators']['alltotal']; // For Percentage Values Send value concatenated with % to be shown in percentage.
							$cardThree['width'] 	= '4';

							/*$cardFour['heading'] 	= 'Measles 1 - Measles 2';
							$cardFour['image'] 		= "vaccine.png";
							$cardFour['value']		= $data['indicators']['m1tom2dropout']."%"; // For Numeric Values Send value formated in number_format.
							$cardFour['width'] 		= '3';*/

							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardOne);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardTwo);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardThree);
							//$this -> load -> view('thematic_maps/parts_view/top_cards', $cardFour);
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
						<div class="col-md-5" >
							<div class="rightmmapsectionwrp scrollset">
								<div id="bar_graph_1" class="" ></div>
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
					$filterRow['month']=$month;
					$this->load->view('thematic_maps/parts_view/filterRow',$filterRow); 
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
				$filters['filter'] = 'EPID';
				$filters['to_week'] = $to_week;
				$filters['from_week'] = $from_week; 
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
	$data['filter'] = 'AccessToHealthServices';
	$data['colorAxis'] = $colorAxis;

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
		/* var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#week').html('');
				$('#week').html(response.trim());
			}
		}); */
		$( "#year" ).trigger( "change" );
	});
	$(document).on('change','#year',function(){
		var year = $('#year').val();
		//var week = '<?php echo isset($week)?$week:'all' ?>';
		var week = '<?php echo isset($from_week)?$from_week:'all' ?>';
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year+'&week='+week,
			success: function(response){
				/* $('#week').html('');
				$('#week').html(response.trim()); */
				$('#from_week').html(response);
				//$('#to_week').val('');
			}
		});
	});
	function formatter(e,ucwisemap='false'){
		var text= 'District';
		if(ucwisemap == 'true'){
			text = 'Union Council';
		}
		return text+': <b>' + e.point.name + ' (' + e.point.id + ')' + '</b><br> Year-Week: <b>' + '<?php echo $fmonth; ?>' + '</b><br> ' + '<?php echo $data['heading']['mapName']; ?>: <b>' + e.point.value + '</b>';
	}
	/* function eventHandler(e, run, fmonth){
		if(run){
			var dataId = e.point.id;
			var year = '<?php echo $year; ?>';
			var week = '<?php echo $month; ?>';
			var disease = '<?php echo $data['disease']; ?>';
			var gender = '<?php echo $data['gender']; ?>';
        	var url = '<?php echo base_url(); ?>thematic_maps/ThematicCountEPID/onClickUcWiseMapData/'+dataId+'/'+year+'/'+week+'/'+disease+'/'+gender;
        	window.open(url, '_blank');
			//draw_uc_map(e.point.id);
			//$('.loading').removeClass('hide');
			//$('.map_sectionwraper').removeClass('hide');
		}
	} */
	function eventHandler(e, run, fmonth){
		var mobiletype = '<?php echo $this->agent->is_mobile(); ?> ';
		var dataId = ""+e.point.id;
		var reportType = 'yearly';
		if(reportType == 'monthly'){
			var month = '<?php echo (isset($month))?$month:'0'; ?>';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			var quarter = 0;
		}else if(reportType == 'quarterly'){
			var month = '';
			var quarter = '<?php echo (isset($quarter))?$quarter:'0'; ?>';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
		}else if(reportType == 'yearly'){
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			var month = '0';
			var quarter = 0;
		}
		var vaccineId = '1';
		var gender = 'Both';
		var vaccineBy = 'All';var disease='all';
		//var week = 'All';
		var from_week = 'All';
		var to_week = 'All';
		 if(run){
			 var disease = '<?php echo $data['disease']; ?>';
			//var vaccineBy = 'All';
			//var url = '<?php echo base_url(); ?>thematic_maps/ThematicCountEPID/onClickUcWiseMapData/'+dataId+'/'+reportType+'/'+month+'/'+year+'/'+disease+'/'+disease+'/'+gender+'/'+vaccineBy+'/';
			//var week = '<?php echo $week; ?>';
			var from_week = '<?php echo $from_week; ?>';
			var to_week = '<?php echo $to_week; ?>';
			//var url = '<?php echo base_url(); ?>thematic_maps/ThematicCountEPID/onClickUcWiseMapData/'+dataId+'/'+year+'/'+week+'/'+disease+'/'+gender;
			var url = '<?php echo base_url(); ?>thematic_maps/ThematicCountEPID/onClickUcWiseMapData/'+dataId+'/'+year+'/'+from_week+'/'+to_week+'/'+disease+'/'+gender;
			window.open(url, '_blank');
		}else{
			//var vaccineBy = $('#vaccineBy').val();
			var data = {uncode:dataId,vaccineId:vaccineId,reportType:reportType,month:month,year:year,gender_wise:gender,fmonth:fmonth,quarter:quarter,vaccineBy:vaccineBy};
			if(dataId > 0 && mobiletype !=true){
				$.ajax({
					type: "POST",
					data: data,
					async:false,
					url: "<?php echo base_url(); ?>thematic_maps/ThematicCountEPID/getUC_detailData",
					success: function(result){
						$('.ucdetailsdata').html(result);
						$('.ucdetailsdata').removeClass('hide');
						$('.filterRow').removeClass('hide');
						$('#code').val(dataId);
						scrolltodiv('filterRow');
						
					}
				});
			}
		}
	}
	function getDistrictWiseData(e, fmonth){
		var dataId = ""+e.point.id;
		var reportType = 'yearly';
		if(reportType == 'monthly'){
			var month = '<?php echo (isset($month))?$month:'0'; ?>';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			var quarter = 0;
		}else if(reportType == 'quarterly'){
			var month = '';
			var quarter = '<?php echo (isset($quarter))?$quarter:'0'; ?>';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
		}else if(reportType == 'yearly'){
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			var month = '0';
			var quarter = 0;
		}
		var vaccineId = '1';
		var gender = 'Both';
		var vaccineBy = 'All';
		var code="";
		if(dataId.length==3){
			var data = {distcode:dataId,vaccineId:vaccineId,reportType:reportType,month:month,year:year,gender_wise:gender,fmonth:fmonth,quarter:quarter,vaccineBy:vaccineBy};
		}
		if(dataId.length==9){
			var data = {uncode:dataId,vaccineId:vaccineId,reportType:reportType,month:month,year:year,gender_wise:gender,fmonth:fmonth,quarter:quarter,vaccineBy:vaccineBy};
		}
		
		if(dataId > 0){
			$.ajax({
				type: "POST",
				data: data,
				async:false,
				url: "<?php echo base_url(); ?>thematic_maps/ThematicCountEPID/getUC_detailData",
				success: function(result){
					$('.ucdetailsdata').html(result);
					$('.ucdetailsdata').removeClass('hide');
					$('.filterRow').removeClass('hide');
					$('#code').val(dataId);
					scrolltodiv('filterRow');
				}
			});
		}
	}
</script>