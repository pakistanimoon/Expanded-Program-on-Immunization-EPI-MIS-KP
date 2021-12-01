<?php
	$fmonthfrom = (isset($data['fmonthfrom']))?$data['fmonthfrom']:''; 
	$fmonthto = (isset($data['fmonthto']))?$data['fmonthto']:'';
	$month = (isset($data['month']))?$data['month']:''; 
	$year = (isset($data['year']))?$data['year']:'';
	$from_week = (isset($data['from_week']))?$data['from_week']:'1';
	$to_week = (isset($data['to_week']))?$data['to_week']:lastWeek($year);
	$fweekfrom = $year.'-'.sprintf("%02d", $from_week);
	$fweekto = $year.'-'.sprintf("%02d", $to_week);
	$fmonth = $year.'-'.$month;
	//print_r($data);exit;
    $dataId = 0;
    if(isset($data['id'])){
    	$dataId = $data['id'];
    }
    $fmonth = $year.'-'.$month;
    if($data['reportType'] == 'monthly'){
    	$title_M_Y = date('M Y',strtotime($fmonth));
		$hovermap1 = $fmonthfrom;
		$hovermap2 = "Period From:";
		$hovermap3 = $fmonthto;
		$hovermap4 = "Period To:";
	}
	// else if($data['reportType'] == 'quarterly'){
	// 	$month = '';
	// 	$quarter = $data['quarter'];
	// 	$title_M_Y = 'Quarter '.$quarter.' of '.$year;
	// 	$hovermap = $year.'-'.$quarter;
	// 	$hovermap1 = "Year-Qtr:";
	// }else if($data['reportType'] == 'yearly'){
	// 	$title_M_Y = $year;
	// 	$hovermap = $year;
	// 	$hovermap1 = "Year:";
	// }
	else if($data['reportType'] == 'Weekly'){
		$hovermap1 = $fweekfrom;
		$hovermap2 = "Week From:";
		$hovermap3 = $fweekto;
		$hovermap4 = "Week To:";
	}
	// else if($data['reportType'] == 'biyearly'){
	// 	$title_M_Y = $year;
	// 	$hovermap = $year;
	// 	$hovermap1 = "Year : ".(($biyear==1)?'<b> 1ist </b>':'<b> 2nd </b>')."<b> Half </b>";
	// }
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
							$cardOne['heading'] 	= "Total Due Reports";
							$cardOne['image'] 		= "chart1.png";
							$cardOne['value'] 		= (int)$totalDue; // For Numeric Values Send value formated in number_format.
							$cardTwo['heading'] 	= "Submitted Reports";
							$cardTwo['image'] 		= "peichart.jpg";
							$cardTwo['value'] 		= (int)$totalSub; // For Numeric Values Send value formated in number_format.
							$cardThree['heading'] 	= "Timeliness  ";
							$cardThree['image'] 	= "timely.png";
							$cardThree['value'] 	= (int)$timelyness."%"; // For Percentage Values Send value concatenated with % to be shown in percentage.
							$cardFour['heading'] 	= "Completeness";
							$cardFour['image'] 		= "complince.png";
							$cardFour['value']		= (int)$totalComp."%"; // For Numeric Values Send value formated in number_format.
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
				
			</div>
			<div class="graph_listingwrp">
				<ul class="row">
				<?php
					/*
					* Send heading, image and value to each card in 
					* different arrays to show different values, text and image.
					
					$bottomCardOne['heading'] 		= "Monthly New Born";
					$bottomCardOne['image'] 		= "visit.png";
					$bottomCardOne['value'] 		= number_format($indicators['monthlyTargetPopulation']); // For Numeric Values Send value formated in number_format.
					$bottomCardTwo['heading'] 		= "Monthly Surviving Infants";
					$bottomCardTwo['image'] 		= "servign.png";
					$bottomCardTwo['value'] 		= number_format($indicators['monthlySurvivingInfants']); // For Numeric Values Send value formated in number_format.
					$bottomCardThree['heading'] 	= "Monthly Pregnant Women";
					$bottomCardThree['image'] 		= "wome.png";
					$bottomCardThree['value'] 		= number_format($indicators['monthlyPregnantLactatingPlWomen']); // For Percentage Values Send value concatenated with % to be shown in percentage.
					$bottomCardFour['heading'] 		= "Monthly CBA";
					$bottomCardFour['image'] 		= "cba.png";
					$bottomCardFour['value']		= number_format($indicators['monthlyCbaLadies']); // For Numeric Values Send value formated in number_format.
					$this -> load -> view('thematic_maps/parts_view/bottom_cards', $bottomCardOne);
					$this -> load -> view('thematic_maps/parts_view/bottom_cards', $bottomCardTwo);
					$this -> load -> view('thematic_maps/parts_view/bottom_cards', $bottomCardThree);
					$this -> load -> view('thematic_maps/parts_view/bottom_cards', $bottomCardFour); */
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
	//echo "abc"; exit();
	//print_r($data); exit();
	$this -> load -> view('thematic_maps/parts_view/map', $data); 
	//print_r($data); exit();
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
	$(document).on('click',"#compType",function(){
		if($(this).val() == "ZeroReporting"){
			$('#monthDiv').hide();
			$('#month').removeAttr('required','required');
			$('#weekDiv').show();
			$('#week').attr('required','required');
			$('#reportTypeDiv').hide();
			$('#reportType').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
			$('#biyearDiv').hide();
			$('#biyear').removeAttr('required','required');
		}else{
			/* $('#reportType').val('monthly');
			$('#reportTypeDiv').show();
			$('#reportType').attr('required','required');
			$('#monthDiv').show();
			$('#month').attr('required','required');
			$('#weekDiv').hide();
			$('#week').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
			$('#biyearDiv').hide();
			$('#biyear').removeAttr('required','required'); */
			$('#reportTypeDiv').show();
			$('#reportType').attr('required','required');
			if($('#reportType').val() == "yearly"){
				$('#monthDiv').hide();
				//$('#month').val('0');
				$('#month').removeAttr('required','required');
				$('#quarterDiv').hide();
				$('#quarter').removeAttr('required','required');
				$('#weekDiv').hide();
				$('#week').removeAttr('required','required');
				$('#biyearDiv').hide();
				$('#biyear').removeAttr('required','required');
			}
			else{
				$('#reportType').val('monthly');
				$('#monthDiv').show();
				$('#month').attr('required','required');
				$('#weekDiv').hide();
				$('#week').removeAttr('required','required');
				$('#quarterDiv').hide();
				$('#quarter').removeAttr('required','required');
				$('#weekDiv').hide();
				$('#biyearDiv').hide();
				$('#biyear').removeAttr('required','required');
			}
		}
	});
	$('#compType').trigger('click');	
	$(document).on('change','#year',function(){
		var year = $('#year').val();
		var week = '<?php echo (isset($from_week))?$from_week:'1' ?>';
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year+'&week='+week,
			success: function(response){
				$('#week').html('');
				$('#week').html(response.trim());
			}
		});
	});
	$(document).ready(function(){
		$('.crdview_grphwrp').css('cursor','pointer');
		$( "#year" ).trigger( "change" );
		/* var year = $('#year').val();
		var week = '<?php echo (isset($week))?$week:'all' ?>';
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year+'&week='+week,
			success: function(response){
				$('#week').html('');
				$('#week').html(response.trim());
			}
		}); */
	});
	$(document).on('click',"#reportType",function(){
		if($(this).val() == "yearly"){
			$('#monthDiv').hide();
			//$('#month').val('0');
			$('#month').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
			$('#weekDiv').hide();
			$('#week').removeAttr('required','required');
			$('#weekDiv').hide();
			$('#biyearDiv').hide();
			$('#biyear').removeAttr('required','required');
		}
		else if($(this).val() == "monthly"){
			$('#monthDiv').show();
			$('#month').attr('required','required');
			$('#weekDiv').hide();
			$('#week').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
			$('#weekDiv').hide();
			$('#biyearDiv').hide();
			$('#biyear').removeAttr('required','required');
		}else{}
	});
	$(document).ready(function(){
		$('.crdview_grphwrp').css('cursor','pointer');
		if($('#compType').val() == "ZeroReporting"){
			$('#monthDiv').hide();
			$('#month').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
			$('#reportTypeDiv').hide();
			$('#reportType').removeAttr('required','required');
			$('#biyearDiv').hide();
			$('#biyear').removeAttr('required','required');
			
		}else{
			if($('#reportType option:selected').val() == "yearly"){
				$('#monthDiv').hide();
				$('#month').val('0');
				$('#month').removeAttr('required','required');
				$('#quarterDiv').hide();
				$('#quarter').removeAttr('required','required');
				$('#weekDiv').hide();
				$('#week').removeAttr('required','required');
				$('#biyearDiv').hide();
				$('#biyear').removeAttr('required','required');
			}
			else if($('#reportType option:selected').val() == "monthly"){
				$('#monthDiv').show();
				$('#month').attr('required','required');
				$('#quarterDiv').hide();
				$('#quarter').removeAttr('required','required');
				$('#weekDiv').hide();
				$('#week').removeAttr('required','required');
				$('#biyearDiv').hide();
				$('#biyear').removeAttr('required','required');
			}else{}	
		}		
	});
	$(document).on('click', '.crdview_grphwrp', function (){
		var dataId = <?php echo $dataId; ?>;
		var reportType = '<?php echo $reportType; ?>';
		var compType = '<?php echo $compType; ?>';
		if(reportType == 'monthly' && compType != 'ZeroReporting'){
			var fmonthfrom = '<?php echo (isset($fmonthfrom))?$fmonthfrom:'0'; ?>';
			var fmonthto = '<?php echo (isset($fmonthto))?$fmonthto:'0'; ?>';
			var year = '0';
			var month = '0';
			var quarter = 0;
			var weekfrom = 0;
			var weekto = 0;
			var biyear = 0;
		}
		else if(reportType == 'Weekly'){
			var fmonthfrom = '0';
			var fmonthto = '0';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			var month = '0';
			var quarter = 0;
			var from_week = '<?php echo (isset($from_week))?$from_week:'1'; ?>';
			var to_week = '<?php echo (isset($to_week))?$to_week:lastWeek($year); ?>';
			var biyear = 0;
		}

		var index = $(this).parent().index();
		var vaccination_by = '';
		switch(index){
			case 2:
				reportStatus = 'timely';
				break;
			case 3:
				reportStatus = 'complete';
				break;
			default:
				reportStatus = 'complete';
		}
		var fmonth = '<?php echo $fmonth; ?>';

		if(dataId){
			var data = {reportStatus:reportStatus,id:dataId,ajax:true,reportType:reportType,month:month,year:year,map_id:'livefeedleftmap',bar_id:'bar_graph_1',fmonthfrom:fmonthfrom,fmonthto:fmonthto,quarter:year,compType:compType,from_week:from_week,to_week:to_week};
		}
		else{
			var data = {reportStatus:reportStatus,id:dataId,ajax:true,reportType:reportType,month:month,year:year,map_id:'livefeedleftmap',bar_id:'bar_graph_1',fmonthfrom:fmonthfrom,fmonthto:fmonthto,quarter:year,compType:compType,from_week:from_week,to_week:to_week};
		}
		if(index=='2' || index=='3')
		{
			$.ajax({
				type: "POST",
				data: data,
				url: "<?php echo base_url(); ?>thematic_maps/ThematicCompliance",
				dataType: "json",
				success: function(result){
					$('#livefeedleftmap').html(result.map);
					//$('#bar_graph_1').html('');
					$('#bar_graph_1').html(result.bar);
				}
			});
		}		
	});
	function draw_uc(id){
		var dataId = id;
		var fmonth = '<?php echo $fmonth; ?>';
		var url = '<?php echo base_url(); ?>/thematic_maps/ThematicCompliance/UcWiseMapData/'+id+'/'+fmonth;
		 $.ajax({
			type: "POST",
			data: {id:dataId,fmonth:fmonth,map_id:'livefeedleftmap1',bar_id:'bar_graph_2'},
			url: "<?php echo base_url(); ?>thematic_maps/Thematic_compliance/UcWiseMapData",
			dataType: "json",
			success: function(result){
				$('#livefeedleftmap1').html(result.map);
				$('#bar_graph_2').html(result.bar);
			}
		});  
	}
	$(document).on('change','#year',function(){
		var year = $('#year').val();
		var from_week = '<?php echo isset($from_week)?$from_week:'01' ?>';
		var to_week = '<?php echo isset($to_week)?$to_week:'01' ?>';
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year+'&week='+from_week,
			success: function(response){
				$('#from_week').html(response);
				$("#from_week option[value='0']").remove();
				$("#to_week option[value='']").remove();
			}
		});
		if(from_week!=''){
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getEpiFromTOWeeks',
				data:'from_week='+from_week+'&to_week='+to_week+'&year='+year,
				success: function(response){
					$('#to_week').html(response);
					$("#to_week option[value='']").remove();
				}
			});
		}
		
	});
	function formatter(e,ucwisemap='false'){
		var text= 'District';
		if(ucwisemap == 'true'){
			text = 'Union Council';
		}
		return text+': <b>' + e.point.name + ' (' + e.point.id + ')' + '</b><br><?php echo $hovermap2; ?><b>' + ' <?php echo $hovermap1; ?>' + '</b><br><?php echo $hovermap4; ?><b>' + ' <?php echo $hovermap3; ?>' + '</b><br> Total Due: <b>' + e.point.due  + '</b><br> Total Submitted: <b>' + e.point.sub + '</b><br> Percentage: <b>' + e.point.value + ' %</b>';
	}
	function eventHandler(e, run, fmonth){
		var dataId = e.point.id;//alert(e.point.name);
		var reportType = '<?php echo (isset($reportType))?$reportType:'monthly';?>';
		var compType = '<?php echo $compType; ?>';
		var curr_year = '<?php echo date('Y'); ?>';
		var curr_month = '<?php echo date('m'); ?>';
		if(reportType == 'monthly' && compType != 'ZeroReporting'){
			var fmonthfrom = '<?php echo (isset($fmonthfrom))?$fmonthfrom:'0'; ?>';
			var fmonthto = '<?php echo (isset($fmonthto))?$fmonthto:'0'; ?>';
			var year = '0';
			var month = '0';
			var quarter = 0;
			var from_week = 0;
			var to_week = 0;
			var biyear = 0;
		}
		else if(reportType == 'Weekly'){
			var fmonthfrom = '0';
			var fmonthto = '0';
			var year = '<?php echo (isset($year))?$year:date('Y'); ?>';
			var month = '0';
			var quarter = 0;
			var from_week = '<?php echo (isset($from_week))?$from_week:'01'; ?>';
			var to_week = '<?php echo (isset($to_week))?$to_week:lastWeek($year); ?>';
			var biyear = 0;
		}
		if(run){
			if(compType != 'ZeroReporting'){
        		var url = '<?php echo base_url(); ?>thematic_maps/ThematicCompliance/UcWiseMapData/'+dataId+'/'+reportType+'/'+fmonthfrom+'/'+fmonthto+'/'+year+'/'+compType+'/'+from_week+'/'+to_week;
        	}
        	else{
        		var url = '<?php echo base_url(); ?>thematic_maps/ThematicCompliance/UcWiseMapData/'+dataId+'/'+reportType+'/'+fmonthfrom+'/'+fmonthto+'/'+year+'/'+compType+'/'+from_week+'/'+to_week;
        	}
        	window.open(url, '_blank');
			//draw_uc_map(e.point.id);
			//$('.loading').removeClass('hide');
			//$('.map_sectionwraper').removeClass('hide');
		}
	}
</script>