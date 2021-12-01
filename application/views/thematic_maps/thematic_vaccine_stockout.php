<?php 
    $month = (isset($data['month']))?$data['month']:''; 
    $year = (isset($data['year']))?$data['year']:'';
    $dataId = '0';
    if(isset($data['id'])){
    	$dataId = $data['id'];
    }
    $fmonth = $year.'-'.$month;
	//echo '<pre>';print_r($fmonth);exit;
    if($data['reportType'] == 'monthly'){
    	$title_M_Y = date('M Y',strtotime($fmonth));
		$hovermap = $year.'-'.$month;
		$hovermap1 = "Year-Month:";
	}
	
    $tablerows = '';
	$totalsubmitted = $totaldue = $totalhfstockout = 0;
	$dataSeries = $dataSeries1 = array();
	$serieses_ranking = array(
		'name'		=> "District Wise Stockout Ranking",
		'type'		=> 'bar',
		'animation' => true,
		'dataLabels'=> array('enabled'=>true,'align'=>'center'),
		'data'		=> array()
	);
	usort($vacctbldata, function ($a, $b)
	{
	  return $b['value'] - $a['value'];
	});
	foreach($vacctbldata as $key=>$onereg){
		$valforcolor = ($onereg["submitted"]<=0)?-1:$onereg["value"];
		$rankcolor = getstockoutRankColor($valforcolor);
		$tablerows .= '<tr style="background-color:'.$rankcolor.'">
			<td>'.$onereg["shortname"].'</td>
			<td class="text-center">'.$onereg["due"].'</td>
			<td class="text-center">'.$onereg["submitted"].'</td>
			<td class="text-center">'.$onereg["stockout"].'</td>
			
		</tr>';
		$totaldue += $onereg["due"];
		$totalsubmitted += $onereg["submitted"];
		$totalhfstockout += $onereg["stockout"];
		$serieses_ranking['data'][$key] = array(
			'id'		=> $onereg["id"],
			'name'		=> $onereg["name"],
			'shortname'	=> $onereg["shortname"],
			'color'		=> $rankcolor,
			'due'	=> $onereg["due"],
			'submitted'	=> $onereg["submitted"],
			'stockout'	=> $onereg["stockout"],
			'y'		=> $onereg["value"]
		);
		$serieses_ranking_cat[] = $onereg["name"];
	}
	array_push($dataSeries,$serieses_ranking);
	$serieses_ranking = json_encode($dataSeries,JSON_NUMERIC_CHECK);
	array_push($dataSeries1,$serieses_ranking_cat);
	$serieses_ranking_cat = json_encode($dataSeries1,JSON_NUMERIC_CHECK);
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
							$cardOne['heading'] 	= "Total Functional Facilities";
							$cardOne['image'] 		= "chart1.png";
							$cardOne['value'] 		= (isset($totaldue) && $totaldue >0)?$totaldue:'0';
							$cardOne['width'] 		= '3';
							
							$cardFour['heading'] 	= "Total Reports Submitted";
							$cardFour['image'] 		= "pie2cart.jpg";//"chart2.png";
							$cardFour['value'] 		= (isset($totalsubmitted) && $totalsubmitted >0)?$totalsubmitted:'0';
							$cardFour['width'] 		= '3';

							$cardTwo['heading'] 	= "Total Facilities Stockout";
							$cardTwo['image'] 		= "peichart.jpg";
							$cardTwo['value'] 		= (isset($totalhfstockout) && $totalhfstockout >0)?$totalhfstockout:'0';
							$cardTwo['width'] 		= '3';

							$cardThree['heading'] 	= "Overall Stockout Rate";
							$cardThree['image'] 	= "complince.png";
							$cardThree['value'] 	= ((isset($totalsubmitted) && $totalsubmitted >0)?round($totalhfstockout/$totalsubmitted,2)*100:'0').'%';
							$cardThree['width'] 	= '3';

							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardOne);
							$this -> load -> view('thematic_maps/parts_view/top_cards', $cardFour);
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
						<div class="col-md-5" style="height:637px">
						<div class="row" >
							<div class="col-md-12">
								<div class="rightmmapsectionwrp scrollset">
									<div id="bar_graph_1" class="" >
									</div>
								</div>
							</div>
						</div>
						<div class="row" style="height:318.5px; overflow-y:scroll;margin-top:10px;">
							<div class="col-md-12">
								<div style="padding: 14px;background: white; border-radius: 4px; margin: 10px 0px; min-height:318.5px;">
									<table class="table-bordered table-stripped table-hover" style="font-size: 11px;color:black;width:100%;">
								<thead>
									<tr class="section-title" style="font-size:12px;">
										<th style="padding:0px 2px;">Name</th>
										<th style="padding:0px 2px;" class="text-center">Due Rep</th>
										<th style="padding:0px 2px;" class="text-center">Sub Rep</th>
										<th style="padding:0px 2px;" class="text-center">Stockout HF</th>
										
									</tr>
								</thead>
								<tbody>
									<?php echo $tablerows; ?>
								</tbody>
							</table> 
								</div>
							</div>
						</div>
							
							
							
							<!-- <div style="width: 100%;height:318.5px;overflow: scroll;">
							<table class="table-bordered table-stripped table-hover" style="font-size: 11px;color:black;width:100%;height:100%;">
								<thead>
									<tr class="section-title" style="font-size:12px;">
										<th style="padding:0px 2px;">Name</th>
										<th style="padding:0px 2px;" class="text-center">Due Rep</th>
										<th style="padding:0px 2px;" class="text-center">Sub Rep</th>
										<th style="padding:0px 2px;" class="text-center">Stockout HF</th>
										<th style="padding:0px 2px;" class="text-center">Stockout Rate</th>
									</tr>
								</thead>
								<tbody>
									<?php echo $tablerows; ?>
								</tbody>
							</table> 
							</div>-->
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
				$filters['month'] =$month;
				$filters['year'] =$year;
				$filters['filter'] = 'vaccineStockout';
				//$filters['filter_html'] = $data['filter_html'];
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
	//$data['indicators'] = $indicators;
	$data['heading'] = $heading;
	$data['fmonth'] = $fmonth;
	$data['filter'] = 'AccessToHealthServices';
	$data['colorAxis'] = $colorAxis;
	$this -> load -> view('thematic_maps/parts_view/map', $data); 
	/* unset($data['serieses']); */ 
	$data['id'] = 'bar_graph_1';
	$data['serieses_ranking'] = $serieses_ranking;
	$data['serieses_ranking_cat'] = $serieses_ranking_cat;
	//print_r($data);exit;
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
		if($(this).val() == "monthly"){
			$('#month').parent('div').show();
			$('#month').attr('required','required');
		}else{}
	});
	$(document).ready(function(){
		//$('.crdview_grphwrp').css('cursor','pointer');
		if($('#reportType option:selected').val() == "monthly"){
			$('#month').parent('div').show();
			$('#month').attr('required','required');
		}else{}	
	});
	function formatter(e,ucwisemap='false'){
		var code = e.point.id;
		var clength = code.toString().length;
		var text= '';
		if(clength==1){
			text= 'Province';
		}
		if(clength==3){
			text= 'District';
		}
		if(clength == 9){
			text = 'Union Council';
		}
		return text+': <b>' + e.point.name + ' (' + code + ')' + '</b>'+
		'<br> <?php echo $hovermap1; ?> <b>' + '<?php echo $hovermap; ?>' + '</b>'+
		'<br> ' + 'Total Functional Facilities: <b>' + e.point.due + '</b>'+
		'<br> ' + 'Total Submitted Reports: <b>' + e.point.submitted + '</b>'+
		'<br> ' + 'Total Stockout Facilities: <b>' + e.point.stockout + '</b>'+
		'<br> ' + 'Vaccine Stockout Rate: <b>' + e.point.value + ' %</b>';
	}
	function eventHandler(e, run, fmonth){
		var mobiletype = '<?php echo $this->agent->is_mobile(); ?> ';
		var dataId = ""+e.point.id;
		var reportType = '<?php echo $reportType; ?>';
		var indicator = '';//'<?php //echo $indicator; ?>';
		var vacc_ind = '<?php echo $vacc_ind; ?>';
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
		if(run){
			var $redirect_base_url = '<?php echo base_url(); ?>';
			if(parseInt(dataId) == 3){
				$redirect_base_url = 'http://epimis.cres.pk/';
			}else if(dataId == 4){
				$redirect_base_url = 'http://balochistan.epimis.pk/';
			}else if(dataId == 5){
				$redirect_base_url = 'http://ajk.epimis.pk/';
			}else if(dataId == 6){
				$redirect_base_url = 'http://gb.epimis.pk/';
			}else if(dataId == 7){
				$redirect_base_url = 'http://islamabad.epimis.pk/';
			}else if(dataId == 8){
				$redirect_base_url = 'http://fata.epimis.pk/';
			}
			var $code = '<?php echo md5(date("Y-n-d")); ?>';
			if(parseInt(dataId) == 1 || parseInt(dataId) == 2 || parseInt(dataId) == 9){}else{
				var url = $redirect_base_url+'thematic_maps/ThematicStockout/index/'+dataId+'/'+reportType+'/'+month+'/'+year+'/'+quarter+'/'+vacc_ind+'/?code='+$code;
				window.open(url, '_blank');
			}
		}else{
			var vaccineBy = $('#vaccineBy').val();
			var data = {uncode:dataId,vaccineId:vaccineId,reportType:reportType,month:month,year:year,gender_wise:gender,fmonth:fmonth,quarter:quarter,vaccineBy:vaccineBy};
			if(dataId > 0 && mobiletype !=true){
				$.ajax({
					type: "POST",
					data: data,
					async:false,
					//url: "<?php echo base_url(); ?>thematic_maps/ThematicVaccineIndicator/getUC_detailData",
					url: "<?php echo base_url(); ?>thematic_maps/ThematicStockout/getUC_detailData",
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
		
		var $redirect_base_url = '<?php echo base_url(); ?>';
		var dataId = ""+e.point.id;
		var $code = '<?php echo md5(date("Y-n-d")); ?>';
		var reportType = '<?php echo $reportType; ?>';
		var vacc_ind = '<?php echo $vacc_ind; ?>';
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
		if(dataId.length==8 || dataId.length==9){
			var data = {uncode:dataId,vaccineId:vaccineId,reportType:reportType,month:month,year:year,gender_wise:gender,fmonth:fmonth,quarter:quarter,vaccineBy:vaccineBy};
		}
		if(dataId.length==1){
			var data = {procode:dataId,vaccineId:vaccineId,reportType:reportType,month:month,year:year,gender_wise:gender,fmonth:fmonth,quarter:quarter,vaccineBy:vaccineBy};
		}
		if(dataId.length!=9){
		var url = $redirect_base_url+'thematic_maps/ThematicStockout/index/'+dataId+'/'+reportType+'/'+month+'/'+year+'/'+quarter+'/'+vacc_ind+'/?code='+$code;
				window.open(url, '_blank');
		}
/* 		if(dataId > 0){
			$.ajax({
				type: "POST",
				data: data,
				async:false,
				//url: "<?php echo base_url(); ?>thematic_maps/ThematicVaccineIndicator/getUC_detailData",
				url: "<?php echo base_url(); ?>thematic_maps/ThematicStockout/getUC_detailData",
				success: function(result){
					$('.ucdetailsdata').html(result);
					$('.ucdetailsdata').removeClass('hide');
					$('.filterRow').removeClass('hide');
					$('#code').val(dataId);
					scrolltodiv('filterRow');
				}
			});
		} */
	}
console.log(<?php echo json_encode($vacctbldata);?>);
</script>