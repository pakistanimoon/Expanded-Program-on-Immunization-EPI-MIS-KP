<style>
	label{
		border-bottom:1px solid lightgray;
		width:100%;
		font-weight:400;
		margin-bottom:0px;
	}
#fixTable thead th{
	width:200px !important;
}
</style>
<div class="container bodycontainer">
	<?php
		echo $TopInfo;
	?>
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
					<tr>
						<th>&nbsp;Name&nbsp;of&nbsp;UC&nbsp;</th>
						<th>Technician Name</th>
						<th>Month</th>
						<th>&nbsp;EPi&nbsp;Center&nbsp;Type&nbsp;</th>
						<?php for($i=1; $i<=31; $i++) { ?>
							<th><?php echo "Day-$i"; ?></th>
						<?Php  } ?>
					</tr>
				</thead>
				<tbody>
				
				    <?php
				   	if(empty($data)){
	                   echo '<tr><td colspan="25"> <B>Data not available ! </B></td> </tr>';exit;
                    }
					$htmlofm1=$htmlofm2=$htmlofm3=array();
					for($day=0;$day<31;$day++){
						$htmlofm1[$day] = $htmlofm2[$day] = $htmlofm3[$day] = '<td><input type="text"  placeholder="check"><br><input type="text"  placeholder="check"></td>';
					}
					$currentuc = 0;
					$prevucrowspan = 0;
					$currenttc = 0;
					$facode=0;
					$techcode=0;
					$prevucname = '';
					$prevtechniciancode = '';
					$monthsofqtr = array(
						"1"=>array("January","February","March"),
						"2"=>array("April","May","June"),
						"3"=>array("July","August","September"),
						"4"=>array("October","November","December")
					);
					foreach($data as $key => $val){
						if($currenttc!=$val["techniciancode"]){
							foreach($monthsofqtr[$val['quarter']] as $key=>$months){
								if($currenttc==0){}else{
									echo '<tr class="DrillDownRow" data-facode="'.$facode.'" data-techcode="'.$techcode.'"><td  class="uc" data-ucode="'.$prevuccode.'">'.$prevucname.'</td>';
									if(($key+1)==1){
										echo '<td rowspan="3">'.$prevtechniciancode.'</td>';
									}									
									echo '<td>'.$months.'</td> <td><label  class="disabled" for="u">Session Type</label><br><label  class="disabled" for="u">Session Site</label> <br><label  class="disabled" for="u">Area Name</label> </td>'.implode('',${"htmlofm".($key+1)}).' </tr>';
									${"htmlofm".($key+1)} = array();
								}
								$prevucrowspan++;
							}
							for($day=0;$day<31;$day++){
								$htmlofm1[$day] = $htmlofm2[$day] = $htmlofm3[$day] = '<td><label class="blank_label"><span></span></label><br><label class="blank_label"><span></span></label><br><label class="blank_label"><span></span></label></td>';
							}
							$currentuc = $val["uncode"];
							$facode=$val["facode"];
							$currenttc = $val["techniciancode"];
							$prevuccode = $val["uncode"];
							$prevucname = $val["ucname"];
							$prevtechniciancode = $val["technicianname"];
							$techcode=$val["techniciancode"];
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
								$colour ='style="background: lightgreen; width:100%;white-space: nowrap;"';
							}elseif( ${"sdate".($key+1)} > $currentdate ){
								$colour ='style="background: gainsboro; width:100%;white-space: nowrap;"';
							}else{
								$colour ='style="background: lightcoral; width:100%;white-space: nowrap;"';
							}/////////////////////////
							${"htmlofm".($key+1)}[${"daym".($key+1)}] = '<td>
							<label  '.$colour.'>'. $val['session_type'] .'</label><br> 
							<label  '.$colour.'>'.$val['sitename'].'</label><br>
							<label  '.$colour.'>'. get_Village_Name ($val['area_code']).'</label></td>';
						}					
					}
					foreach($monthsofqtr[$val['quarter']] as $key=>$months){
						if($currentuc==0){}else{
							echo '<tr class="DrillDownRow" data-facode="'.$facode.'" data-techcode="'.$techcode.'" ><td class="uc" data-ucode="'.$prevuccode.'">'.$prevucname.'</td>';
							if(($key+1)==1){
								echo '<td   rowspan="3"> '.$prevtechniciancode.'</td>';								
							}
							echo '<td>'.$months.'</td><td><label  class="disabled" for="u">Session Type</label><br><label  class="disabled" for="u">Session Site</label><br><label  class="disabled" for="u">Area Name</label></td>'.implode('',${"htmlofm".($key+1)}).'</tr>';
							
						}
					} 
					   ?>
				</tbody>		
				<input type='text' hidden value="<?php echo $year;  ?>" id='year'>
				<input type='text' hidden value="<?php echo $quarter;  ?>" id='quarter'>
			</table>
	</div>
</div><!--End of page content or body-->
<!--start of footer-->
<br>
<br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
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
<script type="text/javascript">

	$(document).ready(function(){
		//$("#fixTable").tableHeadFixer({"left" : 1});
		$('.DrillDownRow').css('cursor','pointer');
	});
  	$('.DrillDownRow').on('click', function(){
		var year = $('#year').val();		
		var quarter = $('#quarter').val();		
		var filter_view=2;
		var code = $(this).data('techcode');
		var facode = $(this).data('facode');
		if(code.toString().length == 9){
				//url = "<?php echo base_url();?>red_rec_microplan/Facility_quarterplan/situation_analysis_view/"+facode+"/"+year+"/"+quarter+"/"+techcode+"/"+filter_view;
				url = "<?php echo base_url();?>red_rec_microplan/Situation_analysis/situation_analysis_view/"+code+"/"+year+"/"+filter_view;
				var win = window.open(url,'_self');
			if(win){
				win.focus();
			}else{	//Broswer has blocked it
			alert('Please allow popups for this site');
			}
		}	   
	});
	
</script>
<!-- Script for empty Label> -->
<script>
$( "span:empty" )
  .text( "null" )
  .css( "visibility", "hidden" );
</script>
