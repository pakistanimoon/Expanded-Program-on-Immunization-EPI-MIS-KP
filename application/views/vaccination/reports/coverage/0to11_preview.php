<?php 
	if($TopInfo!=''){
	    echo $TopInfo;
	}
	//echo "abc"; exit();

	//echo getReportTable($result);
	//$this->load->view("vaccination/reports/coverage/tabledata",["tabledata"=>$result]);  
?>
<div id="parent" style="overflow:auto">
	<table id="fixTable" class="table table-bordered table-hover table-striped">
		<thead>				
			<tr>
				<th class="Heading text-center" rowspan="3" style="min-width:80px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">S No.</th>
				<?php if(!isset($inucresult[0]['uncode']) && isset($inucresult[0]['distcode'])) {
					$codecolumn = "distcode";?>
				<th class="Heading text-center" rowspan="3" style="min-width:170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">Distcode</th>
				<th class="Heading text-center" rowspan="3" style="min-width: 170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">District</th>
				<?php } else if(isset($inucresult[0]['tcode'])) {?>
				<th class="Heading text-center" rowspan="3" style="min-width:170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">Tehsil Code</th>
				<th class="Heading text-center" rowspan="3" style="min-width: 170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">Tehsil Name</th>
				<?php } else if(isset($inucresult[0]['uncode'])) {
					$codecolumn = "uncode";?>
				<th class="Heading text-center" rowspan="3" style="min-width:170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">Uncode</th>
				<th class="Heading text-center" rowspan="3" style="min-width: 170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">UnionCouncil</th>
				<?php } else { ?>
				<th class="Heading text-center" rowspan="3" style="min-width:170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">EPI Center Code</th>
				<th class="Heading text-center" rowspan="3" style="min-width:170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">EPI Center</th>
				<?php } ?>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3">Target</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">BCG</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">HEP B</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="8">OPV</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="6">Pentavalent</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="6">PCV 10</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">IPV</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">Rota</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Measles</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" colspan="2">Fully Immunized</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Measles</th>
				<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="7">TT Pregnant Women</th>							
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="5">TT Non-Pregnant Women (15-49 Years)</th> -->
			</tr>
			<tr>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Newborns</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Surviving Infants</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">PLW</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">0</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">III</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">III</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">III</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
				<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">III</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">IV</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">V</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">III</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">IV</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">V</th> -->
			</tr>
			<tr>
			
				<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" id="women3"> &nbsp;PLW</th> -->
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Total</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Doses</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Doses</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
			</tr>
		</thead>
		<tbody>  
			<?php
			$count = 1;
			unset($inucresult['TopInfo']);
			unset($inucresult['exportIcons']);
			$percentage   = array(
				"perctbcg","percthep","perctopv_o",
				"perctopv_on","perctopv_tw","perctopv_th",
				"perctpen_o","perctpen_tw",
				"percfpen_tw","perctpen_th",
				"perctpc_o","perctpc_tw","perctpc_th",
				"perctip_o","perctrota_o","perctrota_tw","perctmea_o","perctmea_tw",
				"pwperctotal_ttpl1","pwperctotal_ttpl2"
			);
			$total = array();
			if($this-> input-> post('age_wise')=='0to11')
				$outuctotalcounts = array_column($outucresult,'totalagegroup1','uniquecol');
			elseif($this-> input-> post('age_wise')=='12to23')
				$outuctotalcounts = array_column($outucresult,'totalagegroup2','uniquecol');
			elseif($this-> input-> post('age_wise')=='above2')
				$outuctotalcounts = array_column($outucresult,'totalagegroup3','uniquecol');
			// $outucpregcounts = array_column($outucresult,'totalpregnant','uniquecol');
			// $outucnonpregcounts = array_column($outucresult,'totalnonpregnant','uniquecol');
			$pregkeys = array("pwtotal_ttpl1"=>"tt_o","pwtotal_ttpl2"=>"tt_tw","total_ttpl3"=>"tt_th","total_ttpl4"=>"tt_fo","total_ttpl5"=>"tt_fi");
			$nonpregkeys = array("total_ttnonpl1"=>"tt_o","total_ttnonpl2"=>"tt_tw","total_ttnonpl3"=>"tt_th","total_ttnonpl4"=>"tt_fo","total_ttnonpl5"=>"tt_fi");
			//print_r($inucresult);exit();
			foreach($inucresult as $arraykey => $value)
			{
				$BCGTtarget=$value['Total New Borns'];
				$Tchildren=$value['Total_Targeted_Children'];
				$women=$value['Targeted_Women'];
				$i=0;
				foreach($value as $key => $totalv)
				{
					if($key != "distcode" && $key != "districtname" && $key != "facode" && $key != "facilityname" && $key != "uncode" && $key != "unname" && $key != "tcode" && $key != "tehsilname"){
						if(!strstr($key,"perc")){
							//work to add data covered by other ucs
							if(key_exists($key,$pregkeys)){
								//$arraytouse = $outucpregcounts;
								$uniquekey = $value[$codecolumn].$pregkeys[$key];
							}else if(key_exists($key,$nonpregkeys)){
								//$arraytouse = $outucnonpregcounts;
								$uniquekey = $value[$codecolumn].$nonpregkeys[$key];
							}else{
								$arraytouse = $outuctotalcounts;
								$uniquekey = $value[$codecolumn].ltrim($key,"t");
							}
							if(key_exists($uniquekey,$arraytouse)){
								//add values in array
								$inucresult[$arraykey][$key] = $inucresult[$arraykey][$key]+$arraytouse[$uniquekey];
								$totalv = $totalv+$arraytouse[$uniquekey];
							}
						}else{
							if($i<3){
								if($BCGTtarget == 0){
									$inucresult[$arraykey][$key] = 0;
								}
								else{
									$inucresult[$arraykey][$key] = round(($inucresult[$arraykey][$pervKey]*100/$BCGTtarget),0);
								}
							}else if($i<18){
								if($Tchildren == 0){
									$inucresult[$arraykey][$key] = 0;
								}
								else{
									$inucresult[$arraykey][$key] = round(($inucresult[$arraykey][$pervKey]*100/$Tchildren),0);
								}
							}else{
								if($women == 0){
									$inucresult[$arraykey][$key] = 0;
								}
								else{
									$inucresult[$arraykey][$key] = round(($inucresult[$arraykey][$pervKey]*100/$women),0);
								}	
							}
							$i++;
						}
						$pervKey = $key;
						if(key_exists($key,$total))
						{
							$total[$key] += $totalv;
						}
						else
							$total[$key] = $totalv;
					}
				}
			}
			if( isset($total['Total New Borns']) && (! (($total['Total New Borns'] == 0) AND ($total['Total_Targeted_Children'] == 0) )))
			{
				$BCGTtarget=$total['Total New Borns'];
				$Tchildren=$total['Total_Targeted_Children'];
				$women=$total['Targeted_Women'];
				$i=1;
				$maleTargetArray=array(5,7,9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41,43);
				foreach($total as $key=>$value){
					if(strstr($key,"perc") && in_array($i,$maleTargetArray))
					{
						if($i<=9){
							if($BCGTtarget == 0){
								$total[$key] = 0;
							}
							else{
								$total[$key] = round(($total[$pervKey]*100/$BCGTtarget),0);
							}								
						}
						if($i<=39 && $i>=11){
							if($Tchildren == 0){
								$total[$key] = 0;
							}
							else{
								$total[$key] = round(($total[$pervKey]*100/$Tchildren),0);
							}
						}								
						if($i==41 || $i==43){
							if($women == 0){
								$total[$key] = 0;
							}
							else{
								$total[$key] = round(($total[$pervKey]*100/$women),0);
							}								
						}
					}					
					$pervKey = $key;
					$i++;
				}
				foreach($inucresult as $val)
				{
					if(array_key_exists('Total New Borns',$val))
					{
						$val['Total New Borns'] = round($val['Total New Borns'],0);
					}
					if(array_key_exists('Total_Targeted_Children',$val))
					{
						$val['Total_Targeted_Children'] = round($val['Total_Targeted_Children'],0);
					}
					echo "<tr class='DrillDownRow'><td style='text-align:center; border: 1px solid black;' class='text-center'>".$count."</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
					echo implode("</td><td style='text-align:center; border: 1px solid black;' class=\"text-red\">",array_map(function($v){
						if($v != '')
							return $v;
						return 0;
					},array_values($val)));
					
					echo "</td></tr>";
					$count++;
				}
				if(isset($inucresult[0][$codecolumn])){
					if(array_key_exists('Total New Borns',$total))
						{
							$total['Total New Borns'] = ceil($total['Total New Borns']);
						}
						
					if(array_key_exists('Total_Targeted_Children',$total))
						{
							$total['Total_Targeted_Children'] = ceil($total['Total_Targeted_Children']);
						}
				}
				echo "<tr style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black;'><td style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black;'></td><td style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black;'></td><td class='text-center' style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black;'><strong> Total: </strong></td><td style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black; font-weight: bold;'>";
				echo implode("</td><td style='min-width:80px; background: #D3D3D3; width: 200; border: 1px solid black; font-weight: bold;' class=\"text-red\">",$total);
				echo "</td></tr>";
			}
			else{
				echo "<tr style='background-color: D3D3D3'><td></td><td></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td><td>";
			}
			?>
		</tbody>
	</table>
</div>
<?php if(!$this->input->post('export_excel'))
{ ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
	<script type="text/javascript">
		var report_indicator= "<?php echo (isset($data['report_indicator']))?$data['report_indicator']:''; ?>";
		var report_type= "<?php echo (isset($data['report_type']))?$data['report_type']:''; ?>";
		$('.DrillDownRow').css('cursor','pointer');//do it later and ll change as clickedReport
		$(document).ready(function(){
			$("#fixTable").tableHeadFixer({"left" : 3});
			$("#stockouttable tbody tr td").each(function(i){
				var datainsidecell = $(this).text();
				if(datainsidecell=="0"){
					if(report_type==1 && report_indicator==1 ){
						$(this).css("background","Green");
					}else{
						$(this).css("background","Red");
					}
				}
				if(datainsidecell==""){
					if(report_type==1 && report_indicator==1 ){
						$(this).css("background","Grey");
					}else{
						$(this).css("background","Grey");
					}
				}
			});
			if(report_indicator==1){
				//to compare required and available stock
				$("#stockouttable tbody tr").each(function(row){
					var prevcellval = "";
					$(this).find("td").each(function(cell){
						if(cell !=0 && cell!=1){
							var datainsidecell = parseInt($(this).text());
							if(cell%2 == 1 && prevcellval!==0){
								if(datainsidecell!=""){
									if(report_type==1 && report_indicator==1 ){
										//$(this).css("background","Green");
									}else{
										if(prevcellval < datainsidecell ){
											$("#stockouttable tbody tr:nth-child("+(row+1)+") td:nth-child("+(cell)+")").css("background","Orange");
											//$(this).css("background","Blue");
										}
									}
								}else{
									prevcellval = "";
								}
							}
							prevcellval = datainsidecell;
						}
					});
				});
			}
		});
		$(document).on('click',".DrillDownRow", function(){
	        var code = $(this).find("td:first-child").text();
			var codeLength=code.toString().length;
			//var report_indicator= "<?php echo (isset($data['report_indicator']))?$data['report_indicator']:''; ?>";
			var fmonth= "<?php echo (isset($data['fmonth']))?$data['fmonth']:NULL; ?>";
			if(codeLength == 3)
	        {
				url = "<?php echo base_url();?>vaccination/reports/coverage/preview";
	        }
			if(codeLength == 6)
	        {
				url = "<?php echo base_url();?>vaccination/view/"+fmonth+"/"+code;
	        }
			$(
				'<form method="post" action="'+url+'" target="_blank">'+
					'<input type="hidden" name="moon" value="formposted">'+
					'<input type="hidden" name="distcode" value="'+code+'">'+
					'<input type="hidden" name="fmonth" value="'+fmonth+'">'+
					'<input type="hidden" name="report_indicator" value="'+report_indicator+'">'+
					'<input type="hidden" name="report_type" value="2">'+
					'<input type="hidden" name="vaccines" value="<?php echo (isset($data['vaccines']) && $data['vaccines']!="")?implode(',',$data['vaccines']):''; ?>">'+
				'</form>'
			).appendTo('body').submit().remove();
	    });
	</script>
<?php } ?>