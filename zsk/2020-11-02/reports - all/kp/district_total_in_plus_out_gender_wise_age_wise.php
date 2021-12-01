<!--start of page content or body-->
<div class="container bodycontainer">
	<?php
//print_r($data);exit;
	echo $data['TopInfo'];
	 ?>
	<div id="parent">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th rowspan="3" style="min-width: 56px;">S No.</th>
					<?php if(!isset($data[0]['uncode']) && isset($data[0]['distcode'])) {?>
   	   				<th rowspan="3" style="min-width:170px;">Distcode</th>
					<th rowspan="3" style="min-width: 170px;">District</th>
   	   				<?php } else if(isset($data[0]['uncode'])) {?>
					<th rowspan="3" style="min-width:100px;">Uncode</th>
					<th rowspan="3" style="min-width: 207px;">UnionCouncil</th>
					<?php } else { ?>
					<th rowspan="3" style="min-width:100px;">EPI Center Code</th>
					<th rowspan="3" style="min-width: 207px;">EPI Center</th>
					<?php } ?>
					<!-- <th colspan="5">Target</th> -->
					<th colspan="2">BCG</th>
					<th colspan="2">HEP B</th>
					<th colspan="8">OPV</th>
					<th colspan="6">Pentavalent</th>
					<th colspan="6">PCV 10</th>
					<th colspan="2">IPV</th>
					<th colspan="4">Rota</th>
					<th colspan="2">Measles</th>
					<th rowspan="2" colspan="2">Fully Immunized</th>
					<th colspan="2">Measles</th>
					<!-- <th colspan="5">TT PL</th>
					<th colspan="5">CBAs</th> -->
				</tr>
				<tr>
					<!-- <th colspan="2" style="min-width: 78px;">Newborns</th>
					<th colspan="2">Surviving Infants</th>
					<th class="women" style="width: 74px;height: 38px;" > &nbsp;</th> -->
					<th rowspan="2">M</th>
					<!-- <th rowspan="2">%</th> -->
					<th rowspan="2">F</th>
					<!-- <th rowspan="2">%</th> -->
					<th rowspan="2">M</th>
					<!-- <th rowspan="2">%</th> -->
					<th rowspan="2">F</th>
					<!-- <th rowspan="2">%</th> -->
					<th colspan="2">0</th>
					<th colspan="2">I</th>
					<th colspan="2">II</th>
					<th colspan="2">III</th>
					<th colspan="2">I</th>
					<th colspan="2">II</th>
					<th colspan="2">III</th>
					<th colspan="2">I</th>
					<th colspan="2">II</th>
					<th colspan="2">III</th>
					<th rowspan="2">M</th>
					<!-- <th rowspan="2">%</th> -->
					<th rowspan="2">F</th>
					<!-- <th rowspan="2">%</th> -->
					<th colspan="2">I</th>
					<th colspan="2">II</th>
					<th colspan="2">I</th>
					<th colspan="2">II</th>
					<!-- <th rowspan="2">I</th>
					<th rowspan="2">II</th>
					<th rowspan="2">III</th>
					<th rowspan="2">IV</th>
					<th rowspan="2">V</th>
					<th rowspan="2">I</th>
					<th rowspan="2">II</th>
					<th rowspan="2">III</th>
					<th rowspan="2">IV</th>
					<th rowspan="2">V</th> -->
				</tr>
				<tr>
				
					<!-- <th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th> -->
					<!-- <th id="women3"> &nbsp;PLW</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<th>M</th>
					<!-- <th>%</th> -->
					<th>F</th>
					<!-- <th>%</th> -->
					<!-- <th>Doses</th> -->
					<!-- <th>%</th> -->
					<!-- <th>Doses</th> -->
					<!-- <th>%</th> -->
				</tr>
			</thead>
			<tbody>  
				<?php
				$count = 1;
				unset($data['TopInfo']);
				unset($data['exportIcons']);
				$percentage   = array(
					"percmbcg","percfbcg","percmhep",
					"percfhep","percmopv_o","percfopv_o",
					"percmopv_on","percfopv_on","percmopv_tw",
					"percfopv_tw","percmopv_th","percfopv_th",
					"percmpen_o","percfpen_o","percmpen_tw",
					"percfpen_tw","percmpen_th","percfpen_th",
					"percmpc_o","percfpc_o","percmpc_tw","percfpc_tw","percmpc_th","percfpc_th",
					"percmip_o","percfip_o","percmmea_o","percfmea_o","percmmea_tw","percfmea_tw",
					"pwperctotal_ttpl1","pwperctotal_ttpl2"
				);
				$total = array();
				foreach($data as $value)
				{
				
					foreach($value as $key => $totalv)
					{
						if($key != "distcode" && $key != "district" && $key != "districtname" && $key != "facode" && $key != "facilityname" && $key != "uncode" && $key != "unname"){
							if(key_exists($key,$total))
							{
								$total[$key] += $totalv;
							}
							else
								$total[$key] = $totalv;
						}
					}
				}
				if( /*! (($total['New Borns Male'] == 0) AND ($total['New Borns FeMale'] == 0) AND ($total['Targeted_Male_Children'] == 0) AND ($total['Targeted_Female_Children'] == 0) )*/1)
				{
					// $BCGMtarget=$total['New Borns Male'];
					// $BCGFtarget=$total['New Borns FeMale'];
					// $Mchildren=$total['Targeted_Male_Children'];
					// $Fchildren=$total['Targeted_Female_Children'];
					// $women=$total['Targeted_Women'];
					// $i=1;
					// /* to divide with target column we have made a static male columns array to know that which column have to divide on which target */
					// $maleTargetArray=array(7,11,15,19,23,27,31,35,39,43,47,51,55,59,63,67,71,75,79,81);
					// /* to divide with target column we have made a static female columns array to know that which column have to divide on which target */
					// $femaleTargetArray=array(9,13,17,21,25,29,33,37,41,45,49,53,57,61,65,69,73,77);
					// foreach($total as $key=>$value){
					// 	if(strstr($key,"perc") && in_array($i,$maleTargetArray))
					// 	{
					// 		if($i<=17){
					// 			if($BCGMtarget == 0){
					// 				$total[$key] = 0;
					// 			}
					// 			else{
					// 				$total[$key] = round(($total[$pervKey]*100/$BCGMtarget),0);
					// 			}							
					// 		}
					// 		if($i<=75 && $i>17){
					// 			if($Mchildren == 0){
					// 				$total[$key] = 0;
					// 			}
					// 			else{
					// 				$total[$key] = round(($total[$pervKey]*100/$Mchildren),0);
					// 			}							
					// 		}
					// 		if($i==79 || $i==81){
					// 			if($women == 0){
					// 				$total[$key] = 0;
					// 			}
					// 			else{
					// 				$total[$key] = round(($total[$pervKey]*100/$women),0);
					// 			}							
					// 		}
					// 	}
					// 	else if(strstr($key,"perc") && in_array($i,$femaleTargetArray))
					// 	{
					// 		if($i<=17){
					// 			if($BCGFtarget == 0){
					// 				$total[$key] = 0;
					// 			}
					// 			else{
					// 				$total[$key] = round(($total[$pervKey]*100/$BCGFtarget),0);
					// 			}							
					// 		}
					// 		if($i<=77 && $i>17){
					// 			if($Fchildren == 0){
					// 				$total[$key] = 0;
					// 			}
					// 			else{
					// 				$total[$key] = round(($total[$pervKey]*100/$Fchildren),0);
					// 			}							
					// 		}
					// 	}
					// 	else{}
					// 	$pervKey = $key;
					// 	$i++;
					// }
					foreach($data as $val)
					{
						if(/*($val['New Borns Male']==NULL || $val['New Borns FeMale']==NULL) && $val['mbcg']!=NULL*/1)
						{
							// $val['percmbcg']=
							// $val['percfbcg']=
							// $val['percmopv_o']=
							// $val['percfopv_o']=
							// $val['percmopv_o']=
							// $val['percmopv_on']=
							// $val['percfopv_on']=
							// $val['percmopv_tw']=
							// $val['percfopv_tw']=
							// $val['percmopv_th']=
							// $val['percfopv_th']=
							// $val['percfopv_th']=
							// $val['percmpen_o']=
							// $val['percfpen_o']=
							// $val['percmpen_tw']=
							// $val['percfpen_tw']=
							// $val['percmpen_th']=
							// $val['percfpen_th']=
							// $val['percmpc_o']=
							// $val['percfpc_o']=
							// $val['percmpc_tw']=
							// $val['percfpc_tw']=
							// $val['percmpc_th']=
							// $val['percfpc_th']=
							// $val['percmip_o']=
							// $val['percfip_o']=
							// $val['percmrota_on']=
							// $val['percfrota_on']=
							// $val['percmrota_tw']=
							// $val['percfrota_tw']=
							// $val['percmmea_o']=
							// $val['percfmea_o']=
							// $val['percmfully_immunized']=
							// $val['percffully_immunized']=
							// $val['percmmea_tw']=
							// $val['percfmea_tw']=
							// $val['pwperctotal_ttpl1']=
							// $val['pwperctotal_ttpl2']=100;
							
						}
						if(array_key_exists('New Borns Male',$val))
						{
							$val['New Borns Male'] = round($val['New Borns Male'],0);
						}
						if(array_key_exists('New Borns FeMale',$val))
						{
							$val['New Borns FeMale'] = round($val['New Borns FeMale'],0);
						}
						if(array_key_exists('Targeted_Male_Children',$val))
						{
							$val['Targeted_Male_Children'] = ceil($val['Targeted_Male_Children']);
						}
						if(array_key_exists('Targeted_Female_Children',$val))
						{
							$val['Targeted_Female_Children'] = round($val['Targeted_Female_Children'],0);
						}
						echo "<tr class='DrillDownRow'><td>".$count."</td><td>";
						echo implode("</td><td>",$val);
					    //echo implode("</td><td class=\"text-red\">",$val);
						echo "</td></tr>";
						$count++;
					}
					// if(array_key_exists('New Borns Male',$total))
					// {
					// 	$total['New Borns Male'] = floor($total['New Borns Male']);
					// }
					// if(!isset($data[0]['uncode'])){
					// 	if(array_key_exists('New Borns FeMale',$total))
					// 	{
					// 		$total['New Borns FeMale'] = floor($total['New Borns FeMale']);
					// 	}
					// }
					// else
					// {
					// 	if(array_key_exists('New Borns FeMale',$total))
					// 	{
					// 		$total['New Borns FeMale'] = ceil($total['New Borns FeMale']);
					// 	}
					// }
					// if(array_key_exists('Targeted_Male_Children',$total))
					// {
					// 	$total['Targeted_Male_Children'] = floor($total['Targeted_Male_Children']);
					// }
					// if(array_key_exists('Targeted_Female_Children',$total))
					// {
					// 	$total['Targeted_Female_Children'] = round($total['Targeted_Female_Children'],0);
					// }
							
					echo "<tr><td></td><td></td><td class='text-center' style='background-color: grey'><strong> Total: </strong></td><td style='background-color: grey'>";
					echo implode("</td><td style='background-color: grey'>",$total);
					//echo implode("</td><td class=\"text-red\">",$total);
					echo "</td></tr>";
				}
				else{
					echo "<tr><td></td><td></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td><td>";
				}
				?>
			</tbody>
		</table>
	</div>
</div><!--End of page content or body-->
<!--start of footer-->
<br>
<br>
<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#fixTable").tableHeadFixer({"left" : 3});
		$('.DrillDownRow').css('cursor','pointer');
		// $('.text-red').each(function(){
		// 	var abc = [9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41,43,45,47,49,51,53,55,57,59,61,63,65,67,69,71,73,75,77,79,81,83];
		// 	if(inArray($(this).index(),abc)){
		// 		$(this).addClass('text-center');
		// 		if(parseInt($(this).text()) < 80){
		// 			$(this).css('background-color','red'); 
		// 		}
		// 	}
		// });
	});
	function inArray(needle, haystack) {
		var length = haystack.length;
		for(var i = 0; i < length; i++) {
			if(haystack[i] == needle) return true;
		}
		return false;
	}
	$('.DrillDownRow').on('click', function(){
		var code = $(this).find("td:nth-child(2)").text();
		var datefrom = "<?php echo $monthfrom; ?>";
		var dateto = "<?php echo $monthto; ?>";
        var typeWise="uc";
		var vaccinetype="<?php echo $vaccination_type; ?>";
		var vacc_to="<?php echo $vacc_to; ?>";
		var age_wise="<?php echo $age_wise;?>";
		var in_out_coverage="<?php echo $in_out_coverage;?>";
		var distdrilldown="<?php echo "dist_to_uc";?>";
		var distcode = 0;
	    var facode = 0;
	    var url = '';	     
	   <?php if(isset($data['year'])) { ?>
				var year='<?php echo $data['year']; ?>';				
		<?php }else{ ?>
				var year='<?php echo date('Y'); ?>';
		<?php } ?>
	    if(code.toString().length == 3 && in_out_coverage == 'in_district'){
	    	url = "<?php echo base_url();?>Reports/flcf_wise_vaccination_malefemale_coverage?distcode="+code+"&typeWise="+typeWise+"&monthfrom="+datefrom+"&monthto="+dateto+"&vaccination_type="+vaccinetype+"&vacc_to="+vacc_to+"&age_wise="+age_wise+"&distdrilldown="+distdrilldown+"&in_out_coverage="+in_out_coverage;
		}
		var win = window.open(url,'_self');
	    if(win){
	        win.focus();
	    }else{
	        //Broswer has blocked it
	        alert('Please allow popups for this site');
	    }
	});
	
</script>