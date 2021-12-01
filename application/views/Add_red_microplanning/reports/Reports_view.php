<!DOCTYPE html>
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
	    <script src="<?php echo base_url(); ?>/includes/js/jquery.js"></script>
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
				$("#fixTable").tableHeadFixer({"left" : 4}); 
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
						<h5 style="text-align: center"><?php echo 'District Name: '.get_District_Name($data['distcode']).' '; ?></h5>
					</div>
					<div class="col-xs-12" style="margin-top: -12px;text-align:center">
						<h5 style="text-align: center"><?php echo 'Quarter: '.$data['quarter'].''; ?></h5>
					</div>
				</div>
		<div id="parent">
				
			<table id="fixTable" class="table">
				<thead>
					<tr>
						<th>&nbsp;Name&nbsp;of&nbsp;UC&nbsp;</th>
						<th>Technician Name</th>
						<th>Month</th>
						<th>&nbsp;EPi&nbsp;Center&nbsp;Type&nbsp;</th>
						<?php for($i=1; $i<=31; $i++) { ?>
							<th><?php echo "Day-$i"; ?></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
				
				    <?php
					
				   	if(empty($data['data'])){
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
							${"htmlofm".($key+1)}[${"daym".($key+1)}] = '<td><input type="text" value="'.$val['session_type'] .'" readonly ><br><input type="text" value="'.$val['sitename'].'" readonly >  </td>';
						}
					}
					foreach($monthsofqtr[$val['quarter']] as $key=>$months){
						if($currentuc==0){}else{
							echo '<tr><td class="uc" data-ucode="'.$prevuccode.'">'.$prevucname.'</td>';
							if(($key+1)==1){
								echo '<td rowspan="3">'.$prevtechniciancode.'</td>';echo '$prevtechniciancode';
							}
							echo '<td>'.$months.'</td><td><input type="text" value="Session Type" disabled ><br><input type="text" value="Session Site" disabled ></td>'.implode('',${"htmlofm".($key+1)}).'</tr>';
						}
					}
					   ?>
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
				<strong>Copyright &copy; all rights reserved. Department of Health, <?php echo $this -> session -> provincename ;  ?>.</strong>
			</footer>
<!--JS -->
<script src="<?php echo base_url(); ?>/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>/includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>/includes/bootstrap/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
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
});
</script>
</body>
</html>