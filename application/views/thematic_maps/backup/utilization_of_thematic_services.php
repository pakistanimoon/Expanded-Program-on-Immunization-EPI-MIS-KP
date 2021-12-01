<?php
	$month = (isset($data['month']))?$data['month']:'01'; 
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
  
  $vaccinesArray = array('9' => 'P1 - P3', '18' => 'M1 - M2', '2' => 'TT 1 - TT 2', '16' => 'P1 - M1');
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
				<div class="main_heading"> <?php echo $heading['mapName'] ?><?php //if(isset($heading['district'])){
					//echo 'of '.$heading['district'];} ?> <?php //echo $title_M_Y; ?> </div>
				<div class="carview_wraper">
					<ul class="row">
						<?php
							/*
							* Send heading, image and value to each card in 
							* different arrays to show different values, text and image.
							*/
							$cardOne['heading'] 	= 'Dropout Male';
							$cardOne['image'] 		= "male.png";
							$cardOne['value'] 		= round(($data['indicators']['mdropout']<0)?0:$data['indicators']['mdropout'])."%"; // For Numeric Values Send value formated in number_format.
							$cardOne['width'] 		= '4';

							$cardTwo['heading'] 	= 'Dropout Female';
							$cardTwo['image'] 		= "female.png";
							$cardTwo['value'] 		= round(($data['indicators']['fdropout']<0)?0:$data['indicators']['fdropout'])."%"; // For Numeric Values Send value formated in number_format.
							$cardTwo['width'] 		= '4';

							$cardThree['heading'] 	= 'Total Dropout';
							$cardThree['image'] 	= "total.png";
							$cardThree['value'] 	= round(($data['indicators']['totaldropout']<0)?0:$data['indicators']['totaldropout'])."%"; // For Percentage Values Send value concatenated with % to be shown in percentage.
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
				$filters['filter'] = 'AccessToHealthServices';
				$filters['dropout'] = true;
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
			$('#monthDiv').hide();
			$('#month').val('0');
			$('#month').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
		}else if($(this).val() == "quarterly"){
			$('#monthDiv').hide();
			$('#month').removeAttr('required','required');
			$('#quarterDiv').show();
			$('#quarter').attr('required','required');
		}else if($(this).val() == "monthly"){
			$('#monthDiv').show();
			$('#month').attr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
		}else{}
	});
$(document).ready(function(){
	$('.crdview_grphwrp').css('cursor','pointer');
	if($('#reportType option:selected').val() == "yearly"){
		$('#monthDiv').hide();
		$('#month').val('0');
		$('#month').removeAttr('required','required');
		$('#quarterDiv').hide();
		$('#quarter').removeAttr('required','required');
	}else if($('#reportType option:selected').val() == "quarterly"){
		$('#monthDiv').hide();
		$('#month').removeAttr('required','required');
		$('#quarterDiv').show();
		$('#quarter').attr('required','required');
	}else if($('#reportType option:selected').val() == "monthly"){
		$('#monthDiv').show();
		$('#month').attr('required','required');
		$('#quarterDiv').hide();
		$('#quarter').removeAttr('required','required');
	}else{}	

	
});
	$(document).on('click', '.crdview_grphwrp', function (){
		var dataId = <?php echo $dataId; ?>;
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

		var vaccineId = '<?php echo $vaccineId; ?>';
		var gender = '<?php echo $gender; ?>';
		//var index = $('.clickable').index(this);
		var index = $(this).parent().index();
		console.log(index);
		switch(index){
			case 0:
				gender = 'Male';
				break;
			case 1:
				gender = 'Female'
				break;
			default:
				gender = 'Both';
		}
		//console.log(gender);
		var vaccineBy = '<?php echo $vaccineBy; ?>';
		var fmonth = '<?php echo $fmonth; ?>';
		if(dataId){
			var data = {id:dataId,ajax:true,reportType:reportType,month:month,year:year,quarter:quarter,vaccineId:vaccineId,gender_wise:gender,vaccineBy:vaccineBy,map_id:'livefeedleftmap',bar_id:'bar_graph_1',fmonth:fmonth};
		}
		else{
			var data = {ajax:true,reportType:reportType,month:month,year:year,quarter:quarter,vaccineId:vaccineId,gender_wise:gender,vaccineBy:vaccineBy,map_id:'livefeedleftmap',bar_id:'bar_graph_1',fmonth:fmonth};
		}
		//console.log(data);
		$.ajax({
			type: "POST",
			data: data,
			url: "<?php echo base_url(); ?>thematic_maps/UtilizationOfServices/index",
			dataType: "json",
			success: function(result){
				//console.log(result);
				$('#livefeedleftmap').html(result.map);
				$('#bar_graph_1').html(result.bar);
			}
		}); 
	});
	function formatter(e,ucwisemap='false'){
		var text= 'District';
		if(ucwisemap == 'true'){
			text = 'Union Council';
		}
		return text+': <b>' + e.point.name + ' (' + e.point.id + ')' + '</b><br> <?php echo $hovermap1; ?> <b>' + '<?php echo $hovermap; ?>' + '</b><br> ' + '<?php echo $vaccinesArray[$vaccineId]; ?> Dropout: <b>' + e.point.value + ' %</b>';
	}
	/* function eventHandler(e, run, fmonth){
		if(run){
			var dataId = e.point.id;
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
			var vaccineId = '<?php echo $vaccineId; ?>';
			var gender = '<?php echo $gender; ?>';
			var vaccineBy = '<?php echo $vaccineBy; ?>';
        	var url = '<?php echo base_url(); ?>thematic_maps/UtilizationOfServices/onClickUcWiseMapData/'+dataId+'/'+reportType+'/'+month+'/'+year+'/'+quarter+'/'+vaccineId+'/'+gender+'/'+vaccineBy+'/';
        	window.open(url, '_blank');
			//draw_uc_map(e.point.id);
			//$('.loading').removeClass('hide');
			//$('.map_sectionwraper').removeClass('hide');
		}
	} */
	function eventHandler(e, run, fmonth){
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
		var vaccineId = '<?php echo $vaccineId; ?>';
		var gender = '<?php echo $gender; ?>';
		 if(run){
			var vaccineBy = '<?php echo $vaccineBy; ?>';
			var url = '<?php echo base_url(); ?>thematic_maps/UtilizationOfServices/onClickUcWiseMapData/'+dataId+'/'+reportType+'/'+month+'/'+year+'/'+quarter+'/'+vaccineId+'/'+gender+'/'+vaccineBy;
			window.open(url, '_blank');
		}else{
			var vaccineBy = $('#vaccineBy').val();
			var data = {uncode:dataId,vaccineId:vaccineId,reportType:reportType,month:month,year:year,gender_wise:gender,fmonth:fmonth,quarter:quarter,vaccineBy:vaccineBy};
			if(dataId > 0){
				$.ajax({
					type: "POST",
					data: data,
					async:false,
					url: "<?php echo base_url(); ?>thematic_maps/UtilizationOfServices/getUC_detailData",
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
		var vaccineId = '<?php echo $vaccineId; ?>';
		var gender = '<?php echo $gender; ?>';
		var vaccineBy = '<?php echo $vaccineBy; ?>';
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
				url: "<?php echo base_url(); ?>thematic_maps/UtilizationOfServices/getUC_detailData",
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