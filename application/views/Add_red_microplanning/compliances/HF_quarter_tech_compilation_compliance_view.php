<!DOCTYPE html>

<?php  //print_r($data['data']);exit; ?>
<html>
	<head>
		<title>Red Rec Compilation Report</title>
		<meta name="description" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="noindex, nofollow" />
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- Meta Tags Goes Here -->
		<!-- Style Files Goes Here -->
		<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>/includes/assets/img/epi.png">
		<link href="<?php echo base_url(); ?>/includes/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url(); ?>/includes/dist/css/custom.css" rel="stylesheet" type="text/css">
		<!--<link href='http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'>-->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet" type="text/css">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
		<script src="<?php echo base_url(); ?>/includes/js/bootstrap-tooltip.js"></script>
	    <script src="<?php echo base_url(); ?>includes/js/jquery.js"></script>
        <script src="<?php echo base_url(); ?>/includes/js/tablefix.js"></script>
	</head>
	<style>
			#parent {
				height: 400px;
			}
			
			#fixTable {
				width: 1800px !important;
			}

		</style>

	<script>
		  $(document).ready(function() {
				$("#fixTable").tableHeadFixer(); 
			}); 
	</script>
	<body>
		<!--start of page content or body epimis1-->
		<div class="container bodycontainer">
			<div class="row">
				<div class="col-xs-1">
					<a href="#"><img src="<?php echo base_url(); ?>/includes/images/epi.png" style="height: 60px;margin-top: 14px;" alt="img-excel" data-toggle="tooltip" title="Home" data-placement="bottom"></a>
				</div>
				<div class="col-xs-9">
					<h3 style="font-weight: bold;margin-top: 30px;margin-left:112px;" class="text-center">EPI - MIS | <?php echo $this -> session -> provincename ;  ?></h3>
				</div>
				<div class="col-xs-2 text-right" style="margin-top:15px;">
					<form method="post" id="export-form" action=""><input type="hidden" name="_ga" value="GA1.2.1017546591.1539260601" /><input type="hidden" name="_gid" value="GA1.2.216667511.1539260601" /><input type="hidden" name="ci_session" value="9ce9be294e4cf9818086f1454ce57d2a029ef619" /><input type="hidden" name="export_excel" value="export_excel" />
						<div class="row">
							<div class="col-xs-2" style="margin-right: 47px; margin-top: 11px;">
								<img class="handland" data-original-title="View in Excel" onclick="document.getElementById('export-form').submit()" src="<?php echo base_url(); ?>/includes/images/excel.png" style="height:32px;margin-right:-105px;" alt="img-excel" data-toggle="tooltip" title="Excel" data-placement="bottom" />
							</div><div class="col-xs-1 col-xs-offset-2" style="margin-right: -68px;margin-top: 11px;">
								<img class="handland" onclick="window.print();" src="<?php echo base_url(); ?>/includes/images/print.png" style="height:34px;" alt="img-print" data-toggle="tooltip" data-original-title="Print" title="Print" data-placement="bottom" />
							</div>
							<div class="col-xs-1 col-xs-offset-4" style="margin-top: 11px;">
								<img class="handland" onclick="JavaScript:window.close();" src="<?php echo base_url(); ?>/includes/images/close.png" style="height:34px;" alt="img-close" data-toggle="tooltip" data-original-title="Close" title="Close" data-placement="bottom" />
							</div>
						</div>
					</form>
				</div>
			</div>
			<!--start of page content or body-->
	<div class="container bodycontainer">
				
			
				
				<div class="row">
					<div class="col-xs-12" style="margin-top: -30px;text-align:center">
						<h3 style="text-decoration: underline;">Red Rec Compilation </h3>
					</div>
					<div class="col-xs-12" style="margin-top: -12px;text-align:center">
						<h5 style="text-align: center"><?php echo isset($data['data'][0]['distcode'])? 'District Name:'.get_District_Name($data['data'][0]['distcode']): 'District Name:'.get_District_Name($data['result'][0]['distcode']) ; ?></h5>
					</div>
					
					<div class="col-xs-12" style="margin-top: -12px;text-align:center">
						<h5 style="text-align: center"><?php echo isset($data['data'][0]['uncode'])?'Union Council Name: '.get_UC_Name($data['data'][0]['uncode']):'Union code:'.get_UC_Name($data['result'][0]['uncode']); ?></h5>
					</div>
					<div class="col-xs-12" style="margin-top: -12px;text-align:center">
						<h5 style="text-align: center"><?php echo isset($data['data'][0]['technicianname'])?'Technician Name: '.($data['data'][0]['technicianname']):'Technician Name :'.($data['result'][0]['technicianname']); ?></h5>
					</div>
					<div class="col-xs-12" style="margin-top: -12px;text-align:center">
						<h5 style="text-align: center"><?php echo isset($data['data'][0]['year'])?'year: '.($moonyear=$data['data'][0]['year']):'Year :'.($moonyear=$data['result'][0]['year']); ?></h5>
					</div>
					<div class="col-xs-12" style="margin-top: -12px;text-align:center">
						<h5 style="text-align: center"><?php echo isset ($data['data'][0]['quarter'])?'Quarter :'.($data['data'][0]['quarter']):'Quarter :' .($data['result'][0]['quarter']); ?></h5>
					</div>
					<div class="col-xs-12" style="margin-top: -12px;text-align:center">
						<h5 style="text-align: center"><?php  isset ($data['data'][0]['facode'])?' facode: '.($data['data'][0]['facode']):'facode: ' .($data['result'][0]['facode']); ?></h5>
					</div>
				
				</div>
				
				<!--table for mention colour mening-->
				<table data-filter="#filter" data-filter-text-only="true" style="margin-bottom: 5px;" class="table  table-hover table-striped footable table-vcenter tbl-listing footable-loaded">
					<thead>
						<tr style="background: white;color: black;">
							<th style="width: 20%;" class="">Session scheduled but not held</th>
							<th style="background: lightcoral;" class=""></th>
							<th style="width: 20%;" class="">Session scheduled and also held</th>
							<th style="background: lightgreen;" class=""></th>
							<th style="width: 20%;" class="">Session scheduled</th>
							<th style="background: gainsboro;" class=""></th>					
						</tr>
					</thead>
				</table>	
				<!--table for mention colour mening-->				
		<div id="parent" style="overflow:auto">
				
			<table id="fixTable" class="table">
				<thead>
						<?php
					 	$monthsofqtr = array(
							"1"=>array("01"=>"January","02"=>"February","03"=>"March"),
							"2"=>array("04"=>"April","05"=>"May","06"=>"June"),
							"3"=>array("07"=>"July","08"=>"August","09"=>"September"),
							"4"=>array("10"=>"October","11"=>"November","12"=>"December")
						); 
						echo '<tr>
								<th rowspan="2">Month Day</th>';
						echo '<th colspan="2">'.implode('</th><th colspan="2">',isset ($data['data'][0]['quarter'])? $monthsofqtr[$data['data'][0]['quarter']]:$monthsofqtr[$data['result'][0]['quarter']]).'</th>';
						echo '</tr><tr>';
								for($i=1; $i<=3; $i++) {
								 echo '<th>Session type</th>';
								 echo '<th>Session site</th>'; 
								}
						echo '</tr>';
						?>
				</thead>
				<?php	
					if(empty($data['data'])){
					
					 echo '<tr><td colspan="25"> <B>You have not defined any site in this Plan </B></td> </tr>';exit;
					}
				?>
				<tbody>
				 <?php 
				$m1dates = array_column($data['data'], 'sitename','area_dateschedule_m1');
				$m2dates = array_column($data['data'], 'sitename','area_dateschedule_m2');
				$m3dates = array_column($data['data'], 'sitename','area_dateschedule_m3');
				$allmonths = array_keys($monthsofqtr[$data['data'][0]['quarter']]); 
				$currentdate= date("Y-m-d");
				for($i=1;$i<32;$i++){
					$dayy = sprintf("%01d",$i);
					if($dayy < 10){
						$dayy='0'.$dayy;
					}
					echo "<tr class='DrillDownRow' data-toggle='modal' data-target='#myModal'><td style='left: 0px;background: #008D4C !important;color: white;font-size: 16px;'>Day $i</td>";
					///////////////////////////////////////////////
					$firstdate = "$moonyear-".$allmonths[0]."-$dayy";
					$found = array_key_exists($firstdate,$m1dates);
					if($found){	
						$parts = explode("$$",$m1dates[$firstdate]);
						if($parts[2] != '1970-01-01'){
							$colour ='style="background: lightgreen;"';
						}elseif($parts[5] > $currentdate ){
							$colour ='style="background: gainsboro;"';
						}else{
							$colour ='style="background: lightcoral;"';
						}
						echo "<td ".$colour." >".$parts[1]."</td><td ".$colour.">".$parts[0]."</td>";
					}else{
						echo "<td></td><td></td>";
					}
					////////////////////////////////////////////////
					$seconddate = "$moonyear-".$allmonths[1]."-$dayy";
					$found = array_key_exists($seconddate,$m2dates);
					if($found){
						$parts = explode("$$",$m2dates[$seconddate]);
						if($parts[3] != '1970-01-01'){
							$colour ='style="background: lightgreen;"';
						}elseif($parts[6] > $currentdate ){
							$colour ='style="background: gainsboro;"';
						}else{
							$colour ='style="background: lightcoral;"';
						}
						echo "<td ".$colour." >".$parts[1]."</td><td ".$colour." >".$parts[0]."</td>";
					}else{
						echo "<td></td><td></td>";
					}
					////////////////////////////////////////////////
					$thirddate = "$moonyear-".$allmonths[2]."-$dayy";
					$found = array_key_exists($thirddate,$m3dates);
					if($found){
						$parts = explode("$$",$m3dates[$thirddate]);
						if($parts[4] > '1970-01-01'){
							$colour ='style="background: lightgreen;"';
						}elseif($parts[7] > $currentdate ){
							$colour ='style="background: gainsboro;"';
						}else{
							$colour ='style="background: lightcoral;"';
						}
						echo "<td ".$colour." >".$parts[1]."</td><td ".$colour." >".$parts[0]."</td>";
					}else{
						echo "<td></td><td></td>";
					}
					////////////////////////////////////////////////
					echo "</tr>";
				}
				
				 
				/* foreach($data['data'] as $key=>$val){
							foreach($val['quarter'] as $key=>$months){
								$sdate1 =$val['area_dateschedule_m1'];
								$sdate2 =$val['area_dateschedule_m2'];
								$sdate3 =$val['area_dateschedule_m3'];
								$daym1=  date('d', strtotime($sdate1));
								$daym2=  date('d', strtotime($sdate2));
								$daym3=  date('d', strtotime($sdate3));
							 if($daym1 == '01' || $daym2 == '01' || $daym3 == '01'){
								echo 	'<td><input type="text" value=" '.$val['session_type'].' " readonly >
								<td><input type="text" value="'. $val['sitename'] .'"  readonly ></td>';
							 }
								
						
						
									
					?>
					
					<!--<td><input type="text" value="<?php echo $val['session_type'] ?>" readonly >
					<td><input type="text" value="<?php echo $val['sitename'] ?>"  readonly ></td>-->
						<?php						
						
							}
								echo '</tr>';
				} */ ?>
<!--<div class="container">
	<div class="modal fade" id="myModal1" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
	<!--		<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Health Facility Workplan</h4>
				</div>
				<div class="modal-body">
						<div id="mergermodalbody"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
  </div>
</div>-->


					
				<!--End for one row record-->
				       <!-- <tr>
						<?php// for($i=1; $i<=31; $i++) { ?>
						
							<td style="left: 0px;background: #008D4C !important;color: white;font-size: 16px;"><?php echo "Day-$i"; ?></td>-->
						    <?php
							/* $arrm1=$arrm2=$arrm3=array();
							for($m=0;$m<3;$m++){
								$arrm1[$m] = $arrm2[$m] = $arrm3[$m] = '<td><input type="text"  placeholder="type"></td><td><input type="text"  placeholder="site"></td>';   
							}
							$currenttc = 0;
							foreach($data['data'] as $key => $val){
								if($currenttc!=$val["techniciancode"]){
									
									for($m=0;$m<3;$m++){
										echo $arrm1[$m] = $arrm2[$m] = $arrm3[$m] = '<td><input type="text"  placeholder="type"></td><td><input type="text"  placeholder="site"></td>';   
									}
									$currenttc = $val["techniciancode"];
								}$arrm1=$arrm2=$arrm3=array();
								for($day=0;$day<31;$day++){
									$htmlofm1[$day] = $htmlofm2[$day] = $htmlofm3[$day] = '<td><input type="text" ><br><input type="text"  ></td>';
								}
								foreach($monthsofqtr[$val['quarter']] as $key=>$months){
									$sdate1 =$val['area_dateschedule_m1'];
									$sdate2 =$val['area_dateschedule_m2'];
									$sdate3 =$val['area_dateschedule_m3'];
									$daym1=  date('d', strtotime($sdate1));
									$daym2=  date('d', strtotime($sdate2));
									$daym3=  date('d', strtotime($sdate3));
									$daym1 = sprintf("%01d",$daym1)-1;
									$daym2 = sprintf("%01d",$daym2)-1;
									$daym3 = sprintf("%01d",$daym3)-1;
									////////////this code is for background color red green//////////////
									$hdate1 =$val['area_dateheld_m1'];
									$hdate2 =$val['area_dateheld_m2'];
									$hdate3 =$val['area_dateheld_m3'];
									$currentdate= date("Y-m-d");
									$dayh1=  date('d', strtotime($hdate1));
									$dayh2=  date('d', strtotime($hdate2));
									$dayh3=  date('d', strtotime($hdate3));
									$dayh1 = sprintf("%01d",$dayh1)-1;
									$dayh2 = sprintf("%01d",$dayh2)-1;
									$dayh3 = sprintf("%01d",$dayh3)-1;
									if( ${"dayh".($key+1)} > 0){
										$colour ='style="background: lightgreen;"';
									}elseif( ${"sdate".($key+1)} > $currentdate ){
										$colour ='style="background: gainsboro;"';
									}else{
										$colour ='style="background: lightcoral;"';
									}/////////////////////////
									${"arrm".($key+1)}[${"daym".($key+1)}] = '<td> 
									<input type="text" value="'.$val['session_type'] .'" '.$colour.' readonly ><br> 
									<input type="text" value="'.$val['sitename'].'"      '.$colour.' style="background: red;"  readonly >  </td>';
								}					
							
							
							}echo'</tr>';
						}  */?>
						
				      
				
				
				
				
				
				
				
				
				
				     <?php
					 
				   	/* if(empty($data['data'])){
	                 
					 echo '<tr><td colspan="25"> <B>Data not available ! </B></td> </tr>';exit;
                    }
					$htmlofm1=$htmlofm2=$htmlofm3=array();
					for($day=0;$day<31;$day++){
						$htmlofm1[$day] = $htmlofm2[$day] = $htmlofm3[$day] = '<td><input type="text"  placeholder="check"><br><input type="text"  placeholder="check"></td>';
					}
					$currentuc = 0;
					$prevucrowspan = 0;
					$currenttc = 0;
					$prevucname = '';
					$prevtechniciancode = '';
					$monthsofqtr = array(
						"1"=>array("January","February","March"),
						"2"=>array("April","May","June"),
						"3"=>array("July","August","September"),
						"4"=>array("October","November","December")
					);
					foreach($data['data'] as $key => $val){
						if($currenttc!=$val["techniciancode"]){
							foreach($monthsofqtr[$val['quarter']] as $key=>$months){
								if($currenttc==0){}else{
									echo '<tr><td  class="uc" data-ucode="'.$prevuccode.'">'.$prevucname.'</td>';
									if(($key+1)==1){
										echo '<td rowspan="3">'.$prevtechniciancode.'</td>';
									}
									echo '<td>'.$months.'</td> <td><input type="text" value="Session Type" disabled ><br><input type="text" value="Session Site" disabled ></td>'.implode('',${"htmlofm".($key+1)}).' </tr>';
									${"htmlofm".($key+1)} = array();
								}
								$prevucrowspan++;
							}
							for($day=0;$day<31;$day++){
								$htmlofm1[$day] = $htmlofm2[$day] = $htmlofm3[$day] = '<td><input type="text" ><br><input type="text"  ></td>';
							}
							$currentuc = $val["uncode"];
							$currenttc = $val["techniciancode"];
							$prevuccode = $val["uncode"];
							$prevucname = $val["ucname"];
							$prevtechniciancode = $val["technicianname"];
						}
						
						foreach($monthsofqtr[$val['quarter']] as $key=>$months){
						
							$sdate1 =$val['area_dateschedule_m1'];
							$sdate2 =$val['area_dateschedule_m2'];
							$sdate3 =$val['area_dateschedule_m3'];
							$daym1=  date('d', strtotime($sdate1));
							$daym2=  date('d', strtotime($sdate2));
							$daym3=  date('d', strtotime($sdate3));
							$daym1 = sprintf("%01d",$daym1)-1;
							$daym2 = sprintf("%01d",$daym2)-1;
							$daym3 = sprintf("%01d",$daym3)-1;
							////////////this code is for background color red green//////////////
							$hdate1 =$val['area_dateheld_m1'];
							$hdate2 =$val['area_dateheld_m2'];
							$hdate3 =$val['area_dateheld_m3'];
						    $currentdate= date("Y-m-d");
							$dayh1=  date('d', strtotime($hdate1));
							$dayh2=  date('d', strtotime($hdate2));
							$dayh3=  date('d', strtotime($hdate3));
							$dayh1 = sprintf("%01d",$dayh1)-1;
							$dayh2 = sprintf("%01d",$dayh2)-1;
							$dayh3 = sprintf("%01d",$dayh3)-1;
							if( ${"dayh".($key+1)} > 0){
								$colour ='style="background: lightgreen;"';
							}elseif( ${"sdate".($key+1)} > $currentdate ){
								$colour ='style="background: gainsboro;"';
							}else{
								$colour ='style="background: lightcoral;"';
							}/////////////////////////
							${"htmlofm".($key+1)}[${"daym".($key+1)}] = '<td> 
							<input type="text" value="'.$val['session_type'] .'" '.$colour.' readonly ><br> 
							<input type="text" value="'.$val['sitename'].'"      '.$colour.' style="background: red;"  readonly >  </td>';
						}					
					}
					foreach($monthsofqtr[$val['quarter']] as $key=>$months){
						if($currentuc==0){}else{
							echo '<tr><td class="uc" data-ucode="'.$prevuccode.'">'.$prevucname.'</td>';
							if(($key+1)==1){
								echo '<td rowspan="3">'.$prevtechniciancode.'</td>';
							}
							echo '<td>'.$months.'</td><td><input type="text" value="Session Type" disabled ><br><input type="text" value="Session Site" disabled ></td>'.implode('',${"htmlofm".($key+1)}).'</tr>';
						}
					}
					   */ ?>
				</tbody>
			</table>
		</div>		
	</div>
			<footer class="main-footer">
				<!-- To the right -->
				<div class="pull-right hidden-xs">
				  <!-- Anything you want -->
				</div>
				<!-- Default to the left -->
				<strong>Copyright &copy; all rights reserved. Department of Health <?php echo $this -> session -> provincename ;  ?>.</strong>
			</footer>
<!--JS -->
<script src="<?php echo base_url(); ?>/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>/includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>/includes/bootstrap/js/bootstrap.min.js"></script>
<script>

/* $(document).ready(function(){
	var uniqucs = [];
	$("td.uc").each(function(index){
		var uccode = $(this).data("ucode");
		uniqucs[uccode] = (uniqucs[uccode]>0)?uniqucs[uccode]+1:1;
	});
	for(var ind in uniqucs){
		var value = uniqucs[ind];
		$('.uc[data-ucode="'+ind+'"]:first').attr("rowspan",value);
		$('.uc[data-ucode="'+ind+'"]').not(':first').remove();
	}
}); */
</script>
<script type="text/javascript">
var modal = document.getElementById('myModal');

	 $(document).ready(function(){
		$('.DrillDownRow').css('cursor','pointer');
			
	});
	$('.DrillDownRow').on('click', function(){
		//$('#myModal1').modal('show');
			var facode = '<?php echo $data['data'][0]['facode']; ?>';
			var year = '<?php echo $data['data'][0]['year']; ?>';
			var quarter = '<?php echo $data['data'][0]['quarter']; ?>';
			var code = '<?php echo $data['data'][0]['techniciancode']; ?>';
			var filter_view=01;
			//alert(filter_view);
		if(code.toString().length == 9){
			url = "<?php echo base_url();?>red_rec_microplan/Facility_quarterplan/hf_quarterplan_view/"+facode+"/"+year+"/"+quarter+"/"+code+"/"+filter_view;
			var win = window.open(url,'_self');
			if(win){
				win.focus();
			}else{
				alert('Please allow popups for this site');
			}
		}
			
	}); 
</script>


	</body>
</html>

