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
	}else if($data['reportType'] == 'biyearly'){
		$title_M_Y = $year;
		$hovermap = $year;
		$hovermap1 = "Year : ".(($biyear==1)?'<b> 1ist </b>':'<b> 2nd </b>')."<b> Half </b>";
	}
  //print_r($data['indicators'][0]);exit;
  $vaccinesArray = array('BCG','Hep B-Birth','OPV-0','OPV-1','OPV-2','OPV-3','PENTA-1','PENTA-2','PENTA-3','PCV10-1','PCV10-2','PCV10-3','IPV-1','Rota-1','Rota-2','MR-I','Fully Immunized','MR-II','DTP','TCV','IPV-2');
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
			<input type="hidden" id="vaccineBy" value="">
			<div class="content_mainwraper">
				<div class="main_heading"> <?php echo $heading['mapName'] ?><?php if(isset($heading['district'])){
					echo 'of '.$heading['district'];} ?>  <?php //echo $title_M_Y; ?> </div>
				<div class="carview_wraper">
					<ul class="row">
						<?php
							/*
							* Send heading, image and value to each card in 
							* different arrays to show different values, text and image.
							*/
							$vacName = str_replace('Coverage', '', $heading['mapName']);
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


							/*$cardFour['heading'] 	= $vacName." Male Coverage";
							$cardFour['image'] 		= "vaccine.png";
							$cardFour['value']		= $data['indicators']['mcoverage']."%";
							$cardFour['width'] 		= '4';

							$cardFive['heading'] 	= $vacName." Female Coverage";
							$cardFive['image'] 		= "vaccine.png";
							$cardFive['value']		= $data['indicators']['fcoverage']."%";
							$cardFive['width'] 		= '4';

							$cardSix['heading'] 	= $vacName." Total Coverage";
							$cardSix['image'] 		= "vaccine.png";
							$cardSix['value']		= $data['indicators']['totalcoverage']."%";
							$cardSix['width'] 		= '4';*/

							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardOne);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardTwo);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardThree);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardFour);
							$this -> load -> view('thematic_maps/parts_view/top_cards_2', $cardFive);
							//$this -> load -> view('thematic_maps/parts_view/top_cards', $cardSix);
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
							<div class="rightmmapsectionwrp" style="overflow-x: scroll;">
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
					$filterRow['month']= $month;
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
				$filters['filter'] = 'AccessToHealthServices';
				$filters['dropout'] = false;
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
			$('#biyearDiv').hide();
			$('#quarter').removeAttr('required','required');
		}else if($(this).val() == "biyearly"){
			$('#monthDiv').hide();
			$('#month').removeAttr('required','required');
			$('#quarter').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#biyearDiv').show();
			$('#biyear').attr('required','required');
		}else if($(this).val() == "quarterly"){
			$('#monthDiv').hide();
			$('#biyearDiv').hide();
			$('#biyear').removeAttr('required','required');
			$('#month').removeAttr('required','required');
			$('#quarterDiv').show();
			$('#quarter').attr('required','required');
		}else if($(this).val() == "monthly"){
			$('#monthDiv').show();
			$('#month').attr('required','required');
			$('#quarterDiv').hide();
			$('#biyearDiv').hide();
			$('#quarter').removeAttr('required','required');
		}else{}
	});
	$(document).ready(function(){
		$('.crdview_grphwrp').css('cursor','pointer');
		$('#reportType').trigger('click'); //using trigger function instead
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
		var index = $(this).parent().index();
		var vaccination_by = '';
		switch(index){
			case 0:
				vaccination_by = 'Fixed';
				break;
			case 1:
				vaccination_by = 'Outreach'
				break;
			case 2:
				vaccination_by = 'Mobile'
				break;
			case 3:
				vaccination_by = 'LHW'
				break;
			case 4:
				vaccination_by = 'total'
				break;
			default:
				vaccination_by = 'total';
		}
		var fmonth = '<?php echo $fmonth; ?>';
		if(dataId){
			var data = {vaccineId:vaccineId,vaccineBy:vaccination_by,id:dataId,ajax:true,reportType:reportType,month:month,year:year,gender_wise:gender,map_id:'livefeedleftmap',bar_id:'bar_graph_1',fmonth:fmonth};
		}
		else{
			var data = {vaccineId:vaccineId,vaccineBy:vaccination_by,id:dataId,ajax:true,reportType:reportType,month:month,year:year,gender_wise:gender,map_id:'livefeedleftmap',bar_id:'bar_graph_1',fmonth:fmonth};
		}
		$.ajax({
			type: "POST",
			data: data,
			url: "<?php echo base_url(); ?>thematic_maps/AccessToHealthServices/index",
			dataType: "json",
			success: function(result){
				$('#livefeedleftmap').html(result.map);
				$('#bar_graph_1').html(result.bar);
				$('#vaccineBy').val(result.otherParameters.vaccineBy);
			}
		}); 
	});
	function formatter(e,ucwisemap='false'){
		var text= 'District';
		if(ucwisemap == 'true'){
			text = 'Union Council';
		}
		return text+': <b>' + e.point.name + ' (' + e.point.id + ')' + '</b><br> <?php echo $hovermap1; ?> <b>' + '<?php echo $hovermap; ?>' + '</b><br> ' + '<?php echo $vaccinesArray[$vaccineId-1]; ?> Vaccination: <b>' + e.point.value + '</b>';
	}
	function eventHandler(e, run, fmonth){
		var dataId = ""+e.point.id;
		var reportType = '<?php echo $reportType; ?>';
		var biyear = '0';
		var month = '0';
		var quarter = '0';
		if(reportType == 'monthly'){
			var month = '<?php echo (isset($month))?$month:'0'; ?>';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			//var quarter = 0;
		}else if(reportType == 'quarterly'){
			var month = '';
			var quarter = '<?php echo (isset($quarter))?$quarter:'0'; ?>';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
		}else if(reportType == 'biyearly'){
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			//var month = '0';
			//var quarter = '0';
			var biyear = '<?php echo (isset($biyear))?$biyear:'1'; ?>';
		}else if(reportType == 'yearly'){
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			//var month = '0';
			//var quarter = '0';
		}
		var vaccineId = '<?php echo $vaccineId; ?>';
		var gender = '<?php echo $gender; ?>';
		 if(run){
			var vaccineBy = '<?php echo $vaccineBy; ?>';
			/*if(getRequest){
				var data = {distcode:dataId,vaccineId:vaccineId,reportType:reportType,month:month,year:year,gender_wise:gender,fmonth:fmonth,quarter:quarter,vaccineBy:vaccineBy};
				if(dataId > 0){
					$.ajax({
						type: "POST",
						data: data,
						async:false,
						url: "<?php echo base_url(); ?>thematic_maps/AccessToHealthServices/getUC_detailData",
						success: function(result){
							$('.ucdetailsdata').html(result);
							$('.ucdetailsdata').removeClass('hide');
						}
					});
				}
			}else{
				var url = '<?php echo base_url(); ?>thematic_maps/AccessToHealthServices/onClickUcWiseMapData/'+dataId+'/'+reportType+'/'+month+'/'+year+'/'+quarter+'/'+vaccineId+'/'+gender+'/'+vaccineBy+'/';
				window.open(url, '_blank');
			} */
			var url = '<?php echo base_url(); ?>thematic_maps/AccessToHealthServices/onClickUcWiseMapData/'+dataId+'/'+reportType+'/'+month+'/'+year+'/'+quarter+'/'+vaccineId+'/'+gender+'/'+vaccineBy+'/'+biyear+'/';
			window.open(url, '_blank');
		}else{
			var vaccineBy = $('#vaccineBy').val();
			var data = {uncode:dataId,vaccineId:vaccineId,reportType:reportType,month:month,year:year,gender_wise:gender,fmonth:fmonth,quarter:quarter,vaccineBy:vaccineBy,biyear:biyear};
			if(dataId > 0){
				$.ajax({
					type: "POST",
					data: data,
					async:false,
					url: "<?php echo base_url(); ?>thematic_maps/AccessToHealthServices/getUC_detailData",
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
		}else if(reportType == 'biyearly'){
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			var biyear = '<?php echo (isset($biyear))?$biyear:'01'; ?>';
			var month = '0';
			var quarter = 0;
		}else if(reportType == 'yearly'){
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			var month = '0';
			var quarter = 0;
		}
		var vaccineId = '<?php echo $vaccineId; ?>';
		var gender = '<?php echo $gender; ?>';
		var vaccineBy = '<?php echo $vaccineBy; ?>';
		var code="";
		var services ='outreach';
		if(dataId.length==3){
			var data = {distcode:dataId,vaccineId:vaccineId,reportType:reportType,month:month,year:year,gender_wise:gender,fmonth:fmonth,quarter:quarter,vaccineBy:vaccineBy,services:services,biyear:biyear};
		}
		if(dataId.length==9){
			var data = {uncode:dataId,vaccineId:vaccineId,reportType:reportType,month:month,year:year,gender_wise:gender,fmonth:fmonth,quarter:quarter,vaccineBy:vaccineBy,services:services,biyear:biyear};
		}
		
		if(dataId){
			$.ajax({
				type: "POST",
				data: data,
				async:false,
				url: "<?php echo base_url(); ?>thematic_maps/AccessToHealthServices/getUC_detailData",
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
	$(document).ready(function(){
		var services ='outreach';
		var dataId = '3';
		var month = '<?php echo (isset($month))?$month:'0'; ?>';
		var year = '<?php echo (isset($year))?$year:'0'; ?>';
		var data = {procode:dataId,vaccineId:'1',reportType:'monthly',month:month,year:year,gender_wise:'Both',vaccineBy:'All',services:services};
		$.ajax({
			type: "POST",
			data: data,
			async:false,
			url: "<?php echo base_url(); ?>thematic_maps/AccessToHealthServices/getUC_detailData",
			success: function(result){
				$('.ucdetailsdata').html(result);
				$('.ucdetailsdata').removeClass('hide');
				$('.filterRow').removeClass('hide');
				$('#code').val(dataId);
				//scrolltodiv('filterRow');
			}
		});
	});
</script>