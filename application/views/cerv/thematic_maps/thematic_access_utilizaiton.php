<?php
  $month = (isset($data['month']))?$data['month']:'';
  $year = (isset($data['year']))?$data['year']:'';
  $fmonth = $year.'-'.$month;
  //print_r($data);exit;
    $dataId = 0;
    if(isset($data['id'])){
    	$dataId = $data['id'];
    }
    $fmonth = $year.'-'.$month;
    if($data['reportType'] == 'monthly'){
    	$title_M_Y = date('M Y',strtotime($fmonth));
		$hovermap = $year;
		$hovermap1 = "Year:";
	}
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
				<div class="main_heading"> <?php echo $heading['mapName'] ?> </div>
				<div class="carview_wraper">
					<ul class="row">
						<?php
							/*
							* Send heading, image and value to each card in 
							* different arrays to show different values, text and image.
							*/
							$cardOne['heading'] 	= "Overall Coverage";
							$cardOne['image'] 		= "chart1.png";
							$cardOne['value'] 		= number_format($coverage,0)."%"; // For Numeric Values Send value formated in number_format.
							$cardOne['width'] 		= 4;
							$cardTwo['heading'] 	= "Overall Dropout";
							$cardTwo['image'] 		= "peichart.jpg";
							$cardTwo['value'] 		= number_format($dropout,0)."%"; // For Numeric Values Send value formated in number_format.
							$cardTwo['width'] 		= 4;
							$cardThree['heading'] 	= "Category ";
							$cardThree['image'] 	= "total.png";
							$cardThree['value'] 	= (isset($zeroData) && $zeroData =="0")?'Third':$category; // For Percentage Values Send value concatenated with % to be shown in percentage.
							$cardTwo['width'] 		= 4;
							/*$cardFour['heading'] 	= "Total Active Technician";
							$cardFour['image'] 		= "complince.png";
							$cardFour['value']		= number_format($indicators['tot_active']); // For Numeric Values Send value formated in number_format. */
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
						<div class="col-md-5" style="height: 630px;overflow-y: auto;overflow-x: hidden;">
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
				$filterRow['month']= $month;
				$filters['filter'] = 'thematicaccessutilization';
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
	$data['code'] = $id;
	$data['id'] = 'livefeedleftmap';
	//print_r($serieses);exit;
	$data['serieses'] = $serieses;
	//$data['indicators'] = $indicators;
	$data['heading'] = $heading;
	$data['fmonth'] = $fmonth;
	$data['filter'] = 'thematicaccessutilization';
	$data['colorAxis'] = $colorAxis;
	$this -> load -> view('thematic_maps/parts_view/map', $data); 
	unset($data['serieses']);
	$data['id'] = 'bar_graph_1';
	$data['plotYaxis'] = isset($plotYaxis)?$plotYaxis:null;
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
			}else if($('#reportType').val() == "biyearly"){
				$('#monthDiv').hide();
				$('#month').removeAttr('required','required');
				$('#month').val('0');
				$('#quarter').removeAttr('required','required');
				$('#weekDiv').hide();
				$('#week').removeAttr('required','required');
				$('#quarterDiv').hide();
				$('#biyearDiv').show();
				$('#biyear').attr('required','required');
			}else if($('#reportType').val() == "quarterly"){
				$('#monthDiv').hide();
				$('#month').removeAttr('required','required');
				$('#weekDiv').hide();
				$('#week').removeAttr('required','required');
				$('#quarterDiv').show();
				$('#quarter').attr('required','required');
				$('#weekDiv').hide();
				$('#biyearDiv').hide();
				$('#biyear').removeAttr('required','required');
			}else{
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
		}else if($(this).val() == "biyearly"){
			$('#monthDiv').hide();
			$('#month').removeAttr('required','required');
			$('#month').val('0');
			$('#quarter').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#biyearDiv').show();
			$('#biyear').attr('required','required');
		}else if($(this).val() == "quarterly"){
			$('#monthDiv').hide();
			$('#month').removeAttr('required','required');
			$('#weekDiv').hide();
			$('#week').removeAttr('required','required');
			$('#quarterDiv').show();
			$('#quarter').attr('required','required');
			$('#weekDiv').hide();
			$('#biyearDiv').hide();
			$('#biyear').removeAttr('required','required');
		}else if($(this).val() == "monthly"){
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
			}else if($('#reportType option:selected').val() == "biyearly"){
				$('#monthDiv').hide();
				$('#month').val('0');
				$('#month').removeAttr('required','required');
				$('#quarterDiv').hide();
				$('#quarter').removeAttr('required','required');
				$('#biyearDiv').show();
				$('#biyear').attr('required','required');
				$('#weekDiv').hide();
				$('#week').removeAttr('required','required');
			}else if($('#reportType option:selected').val() == "quarterly"){
				$('#monthDiv').hide();
				$('#month').removeAttr('required','required');
				$('#quarterDiv').show();
				$('#quarter').attr('required','required');
				$('#weekDiv').hide();
				$('#week').removeAttr('required','required');
				$('#biyearDiv').hide();
				$('#biyear').removeAttr('required','required');
			}else if($('#reportType option:selected').val() == "monthly"){
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
	function draw_uc(id){
		var dataId = id;
		var fmonth = '<?php echo $fmonth; ?>';
		var url = '<?php echo base_url(); ?>/thematic_maps/ThematicAccessUtilization/UcWiseMapData/'+id+'/'+fmonth;
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
	function formatter(e,ucwisemap='false'){
		var text= 'District';
		if(ucwisemap == 'true'){
			text = 'Union Council';
		}
		var code='<?php echo $id; ?>';
		if(code){
			return text+': <b>' + e.point.name + ' (' + e.point.id + ')' + '</b><br><?php echo $hovermap1; ?><b>' + '<?php echo $hovermap; ?>';
		}else{
			return text+': <b>' + e.point.name + ' (' + e.point.id + ')' + '</b><br><?php echo $hovermap1; ?><b>' + '<?php echo $hovermap; ?>';
		}
	}
	function eventHandler(e, run, fmonth){
		var dataId = e.point.id;//alert(e.point.name);
		var reportType = '<?php echo (isset($reportType))?$reportType:'monthly';?>';
		var compType = '<?php echo isset($compType)?$compType:''; ?>';
		/* var month = '<?php echo (isset($month))?$month:'month'; ?>';
		var year = '<?php echo (isset($year))?$year:'0'; ?>';
		var quarter = '<?php echo (isset($quarter))?$quarter:'0'; ?>'; */
		if(reportType == 'monthly' && compType != 'ZeroReporting'){
			var month = '<?php echo (isset($month))?$month:'0'; ?>';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			var quarter = 0;
			var week = 0;
			var biyear = 0;
		}else if(reportType == 'quarterly' && compType != 'ZeroReporting'){
			var month = 0;
			var week = 0;
			var biyear = 0;
			var quarter = '<?php echo (isset($quarter))?$quarter:'0'; ?>';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
		}
		else if(reportType == 'Weekly'){
			var week = '<?php echo (isset($week))?$week:'all'; ?>';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			var month = '0';
			var quarter = 0;
			var biyear = 0;
		}else if(reportType == 'biyearly' && compType != 'ZeroReporting'){
			var month = 0;
			var week = 0;
			var quarter = 0;
			var biyear = '<?php echo (isset($biyear))?$biyear:'01'; ?>';
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
		}else if(reportType == 'yearly'){
			var week = 0;
			var year = '<?php echo (isset($year))?$year:'0'; ?>';
			var month = '0';
			var quarter = 0;
			var biyear = 0;
		}
		if(run){
        	var url = '<?php echo base_url(); ?>thematic_maps/ThematicAccessUtilization/UcWiseMapData/'+dataId+'/'+reportType+'/'+year+'/'+month+'/'+quarter+'/'+compType+'/'+week+'/'+biyear;
        	window.open(url, '_blank');
		}
	}
</script>