<?php
    $month = (isset($data['month']))?$data['month']:''; 
    $year = (isset($data['year']))?$data['year']:'';
    $dataId = '0';
    if(isset($data['distcode'])){
    	$dataId = $data['distcode'];
    }
    $fmonth = $year.'-'.$month;
    if($data['reportType'] == 'monthly'){
    	$title_M_Y = date('M Y',strtotime($fmonth));
	}else if($data['reportType'] == 'yearly'){
		$title_M_Y = $year;
	}
  //print_r($data);exit;
  $vaccinesArray = array('BCG','Hep B-Birth','OPV-0','OPV-1','OPV-2','OPV-3','PENTA-1','PENTA-2','PENTA-3','PCV10-1','PCV10-2','PCV10-3','IPV','Rota-1','Rota-2','Measles-I','Fully Immunized','Measles-II');
?>
<!--Content area--> 
<div class="flypanels-main">
    <div class="flypanels-topbar"> <a class="flypanels-button-left icon-menu" data-panel="treemenu" href="#"><i class="fa fa-bars"></i></a> <h2 class="topbar-heading">Expanded Program on Immunization Thematic Maps Dashboard</h2> </div>
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
				<div class="main_heading"> <?php echo $data['vacName'] ?> Usage Rate Data <?php if(isset($data['district'])){
					echo 'of '.$data['district'];} ?> for <?php echo $title_M_Y; ?> </div>
				<div class="carview_wraper">
					<ul class="row">
						<?php
							/*
							* Send heading, image and value to each card in 
							* different arrays to show different values, text and image.
							*/
							$cardOne['heading'] 	= "Closed Vaccine Usage Rate";
							$cardOne['image'] 		= "chart1.png";
							$cardOne['value'] 		= $indicators['closedtotal'].'%';
							$cardOne['width'] 		= '4';

							$cardTwo['heading'] 	= "Opened Vaccine Usage Rate";
							$cardTwo['image'] 		= "peichart.jpg";
							$cardTwo['value'] 		= $indicators['openedtotal'].'%';
							$cardTwo['width'] 		= '4';

							$cardThree['heading'] 	= "Total Vaccine Usage Rate";
							$cardThree['image'] 	= "complince.png";
							$cardThree['value'] 	= $indicators['total'].'%';
							$cardThree['width'] 	= '4';

							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardOne);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardTwo);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardThree);
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
							<div class="rightmmapsectionwrp" style="overflow-y: scroll;">
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
				<div class="filterRow hide">
				<?php 
					$this->load->view('thematic_maps/parts_view/filterRow'); 
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
				$filters['filter'] = 'vaccineUsageIndicator';
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
	$(document).on('click',"#reportType",function(){
		if($(this).val() == "yearly"){
			$('#month').parent('div').hide();
			$('#month').val('0');
			$('#month').removeAttr('required','required');
		}else if($(this).val() == "quarterly"){
			$('#month').parent('div').hide();
			$('#month').removeAttr('required','required');
		}else if($(this).val() == "monthly"){
			$('#month').parent('div').show();
			$('#month').attr('required','required');
		}else{}
	});
	$(document).ready(function(){
		$('.crdview_grphwrp').css('cursor','pointer');
		if($('#reportType option:selected').val() == "yearly"){
			$('#month').parent('div').hide();
			$('#month').val('0');
			$('#month').removeAttr('required','required');
		}else if($('#reportType option:selected').val() == "quarterly"){
			$('#monthDiv').hide();
			$('#month').removeAttr('required','required');
		}else if($('#reportType option:selected').val() == "monthly"){
			$('#month').parent('div').show();
			$('#month').attr('required','required');
		}else{}	
	});
	$(document).ready(function(){
		$(".dp-my").datepicker({
			autoclose: true,
			format: "yyyy-mm",
			startDate: '2016-01',
			viewMode: "months", 
			minViewMode: "months",
			endDate: new Date()
		});
		$("#monthfrom").datepicker({
		}).on('changeDate', function (selected) {
			var fromDate = new Date(selected.date.valueOf());
			var toDate = new Date($("#monthto").val());
			if(toDate < fromDate){
				$('#monthto').datepicker('setStartDate', fromDate);
				$("#monthto").val('');
			}
			else if(toDate.toString()  == 'Invalid Date' ){
				$('#monthto').datepicker('setStartDate', fromDate);
			}
		});
		if($('#year option:last').val() == new Date().getFullYear()){
			$('#year option:last').prop('selected', true);
		}else{
			$('#year option:first').prop('selected', true);
		}
	});
	$(document).on('click', '.crdview_grphwrp', function (){
		var dataId = '<?php echo $dataId; ?>';
		var reportType = '<?php echo $reportType; ?>';
		if(reportType == 'monthly'){
			var month = '<?php echo (isset($month))?$month:'0'; ?>';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
		}else if(reportType == 'yearly'){
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			var month = '0';
		}
		var indicator = '<?php echo $indicator; ?>';
		var vacc_ind = '<?php echo $vacc_ind; ?>';
		//var index = $('.clickable').index(this);
		var index = $(this).parent().index();
		//console.log(index)
		switch(index){
			case 0:
				indicator = '53';
				break;
			case 1:
				indicator = '54'
				break;
			default:
				indicator = '55';
		}
		//console.log(gender);
		var fmonth = '<?php echo $fmonth; ?>';
		if(dataId){
			var data = {distcode:dataId,ajax:true,reportType:reportType,month:month,year:year,indicator:indicator,vacc_ind:vacc_ind,map_id:'livefeedleftmap',bar_id:'bar_graph_1',fmonth:fmonth};
		}
		else{
			var data = {ajax:true,reportType:reportType,month:month,year:year,indicator:indicator,vacc_ind:vacc_ind,map_id:'livefeedleftmap',bar_id:'bar_graph_1',fmonth:fmonth};
		}
		//console.log(index);
		$.ajax({
			type: "POST",
			data: data,
			url: "<?php echo base_url(); ?>thematic_maps/ThematicVaccineIndicator/index",
			dataType: "json",
			success: function(result){
				//console.log(result);
				//$('#livefeedleftmap').html('');
				$('#livefeedleftmap').html(result.map);
				//$('#bar_graph_1').html('');
				$('#bar_graph_1').html(result.bar);
			}
		}); 
	});
	function formatter(e){
		return 'District: <b>' + e.point.name + ' (' + e.point.id + ')' + '</b><br> Year-Month: <b>' + '<?php echo $fmonth; ?>' + '</b><br> ' + 'Vaccine Usage Rate: <b>' + e.point.value + ' %</b>';
	}
	/* function eventHandler(e, run, fmonth){
		if(run){
			var dataId = e.point.id;
			var month = '<?php echo (isset($month))?($month==''?'0':$month):'0'; ?>';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			var indicator = '<?php echo $indicator; ?>';
			var vacc_ind = '<?php echo $vacc_ind; ?>';
			var reportType = '<?php echo $reportType; ?>';
        	var url = '<?php echo base_url(); ?>thematic_maps/ThematicVaccineUsageIndicator/onClickUcWiseMapData/'+dataId+'/'+month+'/'+year+'/'+indicator+'/'+vacc_ind+'/'+reportType;
        	window.open(url, '_blank');
			//draw_uc_map(e.point.id);
			//$('.map_sectionwraper').removeClass('hide');
		}
	} */
	function eventHandler(e, run, fmonth){
		var mobiletype = '<?php echo $this->agent->is_mobile(); ?> ';
		var dataId = ""+e.point.id;
		var reportType = '<?php echo $reportType; ?>';
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
		var indicator = '53';
		var vacc_ind = 'cr_r1_f6';
		var vaccineBy = 'All'; 
		

		if(run){
			//var url = '<?php echo base_url(); ?>thematic_maps/ThematicVaccineUsageIndicator/onClickUcWiseMapData/'+dataId+'/'+reportType+'/'+month+'/'+year+'/'+quarter+'/'+vaccineId+'/'+gender+'/'+vaccineBy+'/';
			var url = '<?php echo base_url(); ?>thematic_maps/ThematicVaccineUsageIndicator/onClickUcWiseMapData/'+dataId+'/'+month+'/'+year+'/'+indicator+'/'+vacc_ind+'/'+reportType;
			window.open(url, '_blank');
		}else{
			//var vaccineBy = $('#vaccineBy').val();
			var data = {uncode:dataId,vaccineId:vaccineId,reportType:reportType,month:month,year:year,gender_wise:gender,fmonth:fmonth,quarter:quarter,vaccineBy:vaccineBy};
			if(dataId > 0 && mobiletype !=true){
				$.ajax({
					type: "POST",
					data: data,
					async:false,
					url: "<?php echo base_url(); ?>thematic_maps/ThematicVaccineUsageIndicator/getUC_detailData",
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
		var reportType = '<?php echo $reportType; ?>';
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
		var vaccineBy = 'All';
		var vaccineId = '1';
		var gender = 'Both';
		var indicator = '53';
		var vacc_ind = 'cr_r1_f6';
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
				url: "<?php echo base_url(); ?>thematic_maps/ThematicVaccineUsageIndicator/getUC_detailData",
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