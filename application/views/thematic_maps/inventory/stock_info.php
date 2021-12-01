<?php
$activitydata = array();
$tabs = array();
$bardata = array();
$allsum = 0;
$summary = get_defined_vars()['_ci_data']['_ci_vars'];
foreach($reportdata as $key=>$row){
	$totalrow = 0;
	$totalrow += $row["totalm1"];
	$totalrow += $row["totalm2"];
	$totalrow += $row["totalm3"];
	$totalrow += $row["totalm4"];
	$totalrow += $row["totalm5"];
	$totalrow += $row["totalm6"];
	$totalrow += $row["totalm7"];
	$totalrow += $row["totalm8"];
	$totalrow += $row["totalm9"];
	$totalrow += $row["totalm10"];
	$totalrow += $row["totalm11"];
	$totalrow += $row["totalm12"];
	$basedata = array(
		"label"=>$row["item_name"],"value"=>$totalrow,"data"=>array(
			array("label"=>"January","value"=>$row["totalm1"],"svalue"=>@round($row["totalm1"]/$totalrow*100,2)),
			array("label"=>"February","value"=>$row["totalm2"],"svalue"=>@round($row["totalm2"]/$totalrow*100,2)),
			array("label"=>"March","value"=>$row["totalm3"],"svalue"=>@round($row["totalm3"]/$totalrow*100,2)),
			array("label"=>"April","value"=>$row["totalm4"],"svalue"=>@round($row["totalm4"]/$totalrow*100,2)),
			array("label"=>"May","value"=>$row["totalm5"],"svalue"=>@round($row["totalm5"]/$totalrow*100,2)),
			array("label"=>"June","value"=>$row["totalm6"],"svalue"=>@round($row["totalm6"]/$totalrow*100,2)),
			array("label"=>"July","value"=>$row["totalm7"],"svalue"=>@round($row["totalm7"]/$totalrow*100,2)),
			array("label"=>"August","value"=>$row["totalm8"],"svalue"=>@round($row["totalm8"]/$totalrow*100,2)),
			array("label"=>"September","value"=>$row["totalm9"],"svalue"=>@round($row["totalm9"]/$totalrow*100,2)),
			array("label"=>"October","value"=>$row["totalm10"],"svalue"=>@round($row["totalm10"]/$totalrow*100,2)),
			array("label"=>"November","value"=>$row["totalm11"],"svalue"=>@round($row["totalm11"]/$totalrow*100,2)),
			array("label"=>"December","value"=>$row["totalm12"],"svalue"=>@round($row["totalm12"]/$totalrow*100,2))
		)
	);		
	$prodname = trim($row["item_name"]);
	$prodname = preg_replace('/ \(.*/', '', $prodname);
	$bardata[] = array(
		"label"=>$prodname.' ('.$row["activity"].')',
		"value"=>$totalrow,
		"link"=>"j-showAlert-".$row["activity"].",".$prodname
	);
	$activitydata[$row["activity"]]["total"] = isset($activitydata[$row["activity"]]["total"])?$activitydata[$row["activity"]]["total"]+$totalrow:$totalrow;
	$allsum += isset($allsum)?$totalrow:$totalrow;
	$activitydata[$row["activity"]]["data"][] = $basedata;
	$allmonths = array("January","February","March","April","May","June","July","August","September","October","November","December");
	foreach($allmonths as $key => $onemonth){
		$activitydata[$row["activity"]]["monthly"][$key] = array("label"=>$key,"value"=>isset($activitydata[$row["activity"]]["monthly"][$key]["value"])?$activitydata[$row["activity"]]["monthly"][$key]["value"]+$row["totalm".($key+1)]:$row["totalm".($key+1)]);
		$catsdata[$row["category"]]["monthly"][$key] = array("label"=>$key,"value"=>isset($catsdata[$row["category"]]["monthly"][$key]["value"])?$catsdata[$row["category"]]["monthly"][$key]["value"]+$row["totalm".($key+1)]:$row["totalm".($key+1)]);
	}
	$piedata[$row["activity"].'_'.$prodname] = array(
		array("label"=>"January","value"=>$row["totalm1"]),
		array("label"=>"February","value"=>$row["totalm2"]),
		array("label"=>"March","value"=>$row["totalm3"]),
		array("label"=>"April","value"=>$row["totalm4"]),
		array("label"=>"May","value"=>$row["totalm5"]),
		array("label"=>"June","value"=>$row["totalm6"]),
		array("label"=>"July","value"=>$row["totalm7"]),
		array("label"=>"August","value"=>$row["totalm8"]),
		array("label"=>"September","value"=>$row["totalm9"]),
		array("label"=>"October","value"=>$row["totalm10"]),
		array("label"=>"November","value"=>$row["totalm11"]),
		array("label"=>"December","value"=>$row["totalm12"])
	);
}
foreach($activitydata as $key=>$oneactivity){
	foreach($oneactivity["data"] as $key1=>$oneactivityinn){
		$oneactivity["data"][$key1]["svalue"] = @round($oneactivity["data"][$key1]["value"]/$oneactivity["total"]*100,2);
	}
	$dataSet[] = array("label"=>$key,"value"=>$oneactivity["total"],"svalue"=>@round($oneactivity["total"]/$allsum*100,2),"data"=>$oneactivity["data"]);
	$tabs[] = $key;
	$summary[$key]["monthly"] = $oneactivity["monthly"];
}
foreach($catsdata as $key=>$onecat){
	/* foreach($oneactivity["data"] as $key1=>$oneactivityinn){
		$oneactivity["data"][$key1]["svalue"] = @round($oneactivity["data"][$key1]["value"]/$oneactivity["total"]*100,2);
	} */
	//$dataSet[] = array("label"=>$key,"value"=>$oneactivity["total"],"svalue"=>@round($oneactivity["total"]/$allsum*100,2),"data"=>$oneactivity["data"]);
	$cats[] = $key;
	$summary[$key]["monthly"] = $onecat["monthly"];
}
if(!isset($_REQUEST['export_excel'])){
	if(isset($edit)){
		$this->load->view('thematic_template/script', $data['edit'] = $edit);
	}else{
		$this->load->view('thematic_template/script');
	}
}
$indtitle="";if(isset($indicator)){switch($indicator){case 1:$indtitle="Issued";break;case 2:$indtitle="Received";break;case 3:$indtitle="Stock In Hand";break;} }
if(isset($wh_code)){
	if($wh_code=="all")
	{
		$store="All Districts";
	}
	else{
		$store = get_store_name(TRUE,$wh_type,$wh_code); 
	} 
}
$summary["activities"] = $tabs;
$summary["categories"] = $cats;
$summary["indtitle"] = $indtitle;
$summary["store"] = $store;
?>
<!--Content area--> 
<div class="flypanels-main">
    <div class="flypanels-topbar"> <a class="flypanels-button-left icon-menu" data-panel="treemenu" href="#"><i class="fa fa-bars"></i></a> <h2 class="topbar-heading">Expanded Program on Immunization Stock Info Dashboard</h2> </div>
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
				<div class="main_heading"> <?php echo $heading['chartName'] ?> </div>
				<div class="carview_wraper">
					<ul class="row">
						<?php
							/*
							* Send heading, image and value to each card in 
							* different arrays to show different values, text and image.
							*/
							$footercards = false;
							$totdisplyed = 0;
							$remainingccminfo = $ccminfo;
							foreach($ccminfo as $key=>$oneasset){
								unset($remainingccminfo[$key]);
								if($oneasset["status"]==3){
									continue;
								}
								$cardinfo['heading'] 	= $oneasset["name"].' (Stored/Capacity in Litres)';
								$cardinfo['image'] 		= "total.png";
								$cardinfo['value'] 		= round($oneasset["stored"],0).'/'.$oneasset["totcapacity"];
								$this -> load -> view('thematic_maps/parts_view/top_cards', $cardinfo);
								if(++$totdisplyed==4){
									$footercards = true;
									break;
								}
							}
						?>
					</ul>
				</div>
				<div class="map_sectionwraper">
					<div class="row">
						<div class="col-md-7">
							<div class="leftmmapsectionwrp">
								<div id="tree_map_container" class="livefeedleftmap"></div>								
							</div>
						</div>				
						<div class="col-md-5" style="height: 630px;overflow-y: auto;overflow-x: hidden;">
							<div class="rightmmapsectionwrp">
								<div id="bar_graph_container" class="bar_graph_1" style="height:1000px"></div>
							</div>
							<!--Modal for popup Pie -->							
							<div class="modal fade in" id="prod_monthly_pie" role="dialog" style="display: none;transition: all;">
								<div class="modal-dialog" style="height: 300px;">
									<!-- Modal content-->
									<div class="modal-content" style="height: 100%;">
										<!--<div class="modal-header" style="height: 15%;">
											<h4 id="prod_monthly_pie_title" class="modal-title text-center"></h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="top:-22px; position:relative;opacity: 1;">
											  <span aria-hidden="true" class="badge" style="background-color: #aaadaa;color: #fefefe;">&times;</span>
											</button>		
										</div>-->
										<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: 0px 5px 1px 0px;opacity: 1;overflow: hidden;position: inherit;z-index: 9;">
											<span aria-hidden="true" class="badge" style="background-color: #aaadaa;color: #fefefe;">&times;</span>
										</button>
										<div class="modal-body" id="prod_monthly_pie_container" style="height: 100%;"></div>
										<!--<div class="modal-footer" style="height: 10%;padding: 7px;">
											<h6 id="prod_monthly_pie_footer" class="modal-title text-center"></h6>
										</div>-->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ucdetailsdata">
					<?php $this -> load -> view('thematic_maps/parts_view/invn_detail_tab',['tabs'=>$tabs,'summary'=>$summary]); ?>					
				</div>
			</div>
			<div class="graph_listingwrp">
				<ul class="row">
				<?php
					$totdisplyed = 0;
					foreach($remainingccminfo as $key=>$oneasset){
						if($oneasset["status"]==3){
							continue;
						}
						$cardinfo['heading'] 	= $oneasset["name"].' (Stored/Capacity ltr)';
						$cardinfo['image'] 		= "total.png";
						$cardinfo['value'] 		= $oneasset["stored"].'/'.$oneasset["totcapacity"];
						$this -> load -> view('thematic_maps/parts_view/bottom_cards', $cardinfo);
						if(++$totdisplyed==6 && next( $remainingccminfo )/* !($key === array_key_last($array)) */){
							echo '</ul></div><div class="graph_listingwrp"><ul class="row">';
							$totdisplyed = 0;
						}
					}
				?>
				</ul>
			</div>
		</div>
    </div>				
</div>
<?php   
 
	/*
	*	<!--filter bar-->
	*	This will load filter form based on 
	*	name provided to filters array.
	*/
	echo $listing_filters;
	/*<!--filter bar-->*/
	if(!isset($_REQUEST['export_excel'])){
		if(isset($edit)){
			$this->load->view('thematic_template/script', $data['edit'] = $edit);
		}else{
			$this->load->view('thematic_template/script');
		}
	}
 ?>
<script type="text/javascript">
	//set last index of year to selected as default
	$("#year option:last").attr("selected", "selected");
	var cursorX = 0;
	var cursorY= 0;
	//to get mouse click position globally
	document.addEventListener('click', printMousePos, true);
	function printMousePos(e){
		cursorX = e.pageX;
		cursorY= e.pageY;
	}
	var allproddata = jQuery.parseJSON('<?php echo json_encode($piedata); ?>');
	//for tree map
	const dataSource = {
		"data": [
		{
			"label": "Activity Wise Yearly Stock <?php echo $indtitle; ?> Distribution Tree",
			"value": "<?php echo $allsum; ?>",
			"data": <?php echo json_encode($dataSet,true); ?>
		}],
		"colorrange": {
			"mapbypercent": "1",
			"gradient": "1",
			"minvalue": "0",
			"code": "#F2726F",
			"startlabel": "Lowest",
			"endlabel": "Highest",
			"color": [
				{
					"code": "#FFC533",
					"maxvalue": "20",
					"label": "Medium"
				},
				{
					"code": "#FFC533",
					"maxvalue": "50",
					"label": "High"
				},
				{
					"code": "#62B58F",
					"maxvalue": "100",
					"label": "Static"
				}
			]
		},
		"chart": {
			"algorithm": "squarified",
			"caption": "Stock <?php echo $indtitle; ?> (Vials/Pieces) Chart",
			"subcaption": "<?php if(isset($year)){ echo 'Year '.$year; } ?><br><?php echo $store; ?>",
			"theme": "fusion",
			"shownavigationbar": "1",
			"legendcaption": "Weightage in Parent Category",
			"plottooltext": "<b>$label</b><br>Quantity: <b>$value vials/pcs</b><br>Percentage in Category: <b>$svalue%</b>",
			"baseFontSize": "10",
			"exportEnabled": "1"
		}
	};
	//for bar graph
	var bardataSource = {
		"chart": {
			"caption": "Product Wise Stock <?php echo $indtitle; ?> Chart - <?php if(isset($year)){ echo 'Year '.$year; } ?><br><?php echo $store; ?>",
			"yaxisname": "Quantity (Vials/Pieces)",
			"aligncaptionwithcanvas": "0",
			"plottooltext": "<b>$dataValue</b> (Vials/Pieces) received",
			"theme": "zune",
			"exportEnabled": "1"
		},
		"data": <?php echo json_encode($bardata,true); ?>
	};	
	//display charts/grphs
	FusionCharts.ready(function() {
		var treechart = new FusionCharts({
		  type: "treemap",
		  renderAt: "tree_map_container",
		  width: "100%",
		  height: "100%",
		  dataFormat: "json",
		  dataSource
		}).render();
		var bargraph = new FusionCharts({
			type: "bar2d",
			renderAt: "bar_graph_container",
			width: "100%",
			height: "100%",
			dataFormat: "json",
			dataSource: bardataSource,
			events: {
				'dataplotClick': function(evt, args) {
					$("#prod_monthly_pie").css({width: "20%"});					
					$("#prod_monthly_pie .modal-dialog").css({width: "auto"});
					//for modal x axis
					var screenwidth = $(window).width();
					var seventyper = Math.ceil(screenwidth*79/100);
					var mousepos = cursorX;
					if(mousepos>seventyper){
						//open left side
						cursorX = seventyper;
					}
					//for modal y axis
					var screenheight = $(window).height();
					var remheight = screenheight-350;
					var mousepos = cursorY;
					if(mousepos>remheight){
						//open up side
						cursorY = remheight;
					}else{
						cursorY = cursorY-20;
					}
					$("#prod_monthly_pie").css({left: cursorX});
					$("#prod_monthly_pie").css({top: cursorY});					
					$('#prod_monthly_pie').modal('show');
					$('.modal-backdrop').attr('class',"");
					window.showAlert = function(str) {
						var arr = str.split(",");
						var curr_prod_data = '';
						curr_prod_data = allproddata[arr[0]+'_'+arr[1]];
						curr_prod_data = JSON.stringify(curr_prod_data);
						//for pie chart
						var piedataSource = {
							"chart": {
								"caption": 'Monthly Stock Received',
								"subCaption": arr[1]+' - '+arr[0],
								//"numberPrefix": "$",
								"bgColor": "#ffffff",
								"startingAngle": "90",
								//"showLegend": "1",
								//"defaultCenterLabel": arr[2],
								"centerLabel": "$value",
								//"centerLabelBold": "1",
								"showTooltip": "1",
								"decimals": "1",
								
								//"alignSubCaptionWithCanvas": "1",
								//"SubcaptionHorizontalPadding": "2",
								//"captionOnTop": "0",
								//"SubcaptionAlignment": "right",
								
								"theme": "zune",
								"exportEnabled": "1"
							},
							"data": JSON.parse(curr_prod_data)
						};
						var piegraph = new FusionCharts({
							type: "doughnut3d",
							type: "doughnut3d",
							renderAt: "prod_monthly_pie_container",
							width: "100%",
							height: "100%",
							dataFormat: "json",
							dataSource: piedataSource
						}).render();						
					};
				}
			}
		}).render();
	});
	$("#summarytab").trigger("click");
</script>