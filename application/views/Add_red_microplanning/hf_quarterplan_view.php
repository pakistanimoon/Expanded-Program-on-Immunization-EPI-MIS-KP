<?php //print_r($filter_view);exit; ?>
<html lang="en"><head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
   <title>Excel Export</title>
<style>
table{
	width:100%;
}
table.none-td-border{
	
}
table.none-td-border tbody td{
	border:1px solid transparent;
	text-align:left;
}
</style>  
  <style>
       table thead{
        background: #008046;
        color: white;
        text-align: center;
       }
       .table thead th{
           font-size:14px;
       }
       .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{
           font-size:13px;
           font-weight: 800;
           padding:2px;
       }
       .table thead th, .table tbody td{
           vertical-align: middle;
           text-align: center;
       }
	   @media print
		{
		.noprint {
			display:none;
			}
		}
    </style>
	</head>
	<body>
		<div class="container">
		<div class="row">
		    <div class="col-lg-12 panel panel-primary" >
				<a href="<?php echo base_url(); ?>red_rec_microplan/Facility_quarterplan/hf_quarterplan_view/<?php echo $data[0]['facode']; ?>/<?php echo $data[0]['year']; ?>/<?php echo $data[0]['quarter']; ?>/<?php echo $data[0]['techniciancode'];?>/<?php echo 'excel'; ?>" data-toggle="tooltip" title="Excel" class="btn btn-xs btn-default noprint" style="float: right;"><img src="<?php echo base_url(); ?>/includes/images/excel.png" style="width:37px;"></a>
				<div class="panel-heading" style="font-size:17px;font-weight: bold; text-align: center;">
					Health Facility Workplan for a Quarter (3 months)<span class="urdu" style="font-size:12px; font-weight:400;">مرکز صحت کى سہ ماہى منصوبہ بندى برائے حفاظتى ٹیکہ جات</span>
				</div>
					
						<!--	<table class="none-td-border" style="width:100%; table-layout:fixed;">
							<tbody>
								<tr>
									<td style="font-weight:800;border:1px solid #a2a2a2;text-align:center;"><label>Tehsil:</label></td>
									<td style="font-weight:800;border:1px solid #a2a2a2;text-align:center;"><label><?php echo $data[0]['tehsil']; ?></label></td>
									<td style="font-weight:800;border:1px solid #a2a2a2;text-align:center;"><label>Union Council:</label></td>
									<td style="font-weight:800;border:1px solid #a2a2a2;text-align:center;"><label><?php echo $data[0]['uc_name']; ?></label></td>
								</tr>
								<tr>
									<td style="font-weight:800;border:1px solid #a2a2a2;text-align:center;"><label>Health Facility:</label></td>
									<td style="font-weight:800;border:1px solid #a2a2a2;text-align:center;"><label><?php echo $data[0]['facility']; ?></label></td>
									<td style="font-weight:800;border:1px solid #a2a2a2;text-align:center;"><label>Technician:</label></td>
									<td style="font-weight:800;border:1px solid #a2a2a2;text-align:center;"><label><?php echo get_Technician_Name($data[0]['techniciancode']); ?></label></td>
								</tr>
								<tr>
									<td style="font-weight:800;border:1px solid #a2a2a2;text-align:center;"><label>Year:</label></td>
									<td style="font-weight:800;border:1px solid #a2a2a2;text-align:center;"><label><?php echo $data[0]['year']; ?></label></td>
									<td style="font-weight:800;border:1px solid #a2a2a2;text-align:center;"><label>Quarter::</label></td>
									<td style="font-weight:800;border:1px solid #a2a2a2;text-align:center;"><label><?php echo $data[0]['quarter']; ?></label></td>
								</tr>
							</tbody>
						</table> -->
							<div style=" text-align: center border:3px solid transparent;">
								<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Tehsil:<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $data[0]['tehsil']; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Union Council:<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $data[0]['uc_name']; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
							</div>
							<div style=" text-align: center border:3px solid transparent;">
								<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Facility:<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $data[0]['facility']; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Technician:<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<?php if($data[0]['year']=='2019' || $data[0]['year']=='2018'){ ?>
									<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo get_Technician_Name($data[0]['techniciancode']); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<?php }else{ ?>
									<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo get_Hr_Name($data[0]['techniciancode'],'01'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>	
								<?php } ?>
							</div>
							<div style=" text-align: center border:3px solid transparent;">
								<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Year:<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $data[0]['year']; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Quarter:<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<span style="width:22%; display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $data[0]['quarter']; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
							</div>
				</div>
				<table class="table table-bordered table-redrec">
		            <thead>
		                <tr>
		                    <th style="text-align:center; border:1px solid; vertical-align:middle;width:100px;">Area Name</th>
		                    <th style="text-align:center; border:1px solid; vertical-align:middle;">No of Sessions per month</th>
		                    <th style="text-align:center; border:1px solid; vertical-align:middle;width:100px;">Site Name</th>
							<?php if($data[0]['quarter'] == 1) {?>
							<th colspan="2" class="qtr" id="m1" style="text-align:center; border:1px solid; vertical-align:middle;">January</th>
							<th colspan="2" class="qtr" id="m2" style="text-align:center; border:1px solid; vertical-align:middle;">February</th>
							<th colspan="2" class="qtr" id="m3"  style="text-align:center; border:1px solid; vertical-align:middle;">March</th>
							<?php } else if($data[0]['quarter'] == 2) { ?>
							<th colspan="2" class="qtr" id="m1" style="text-align:center; border:1px solid; vertical-align:middle;">April</th>
							<th colspan="2" class="qtr" id="m2" style="text-align:center; border:1px solid; vertical-align:middle;">May</th>
							<th colspan="2" class="qtr" id="m3"  style="text-align:center; border:1px solid; vertical-align:middle;">June</th>
							<?php } else if($data[0]['quarter'] == 3) { ?>
							<th colspan="2" class="qtr" id="m1" style="text-align:center; border:1px solid; vertical-align:middle;">July</th>
							<th colspan="2" class="qtr" id="m2" style="text-align:center; border:1px solid; vertical-align:middle;">August</th>
							<th colspan="2" class="qtr" id="m3"  style="text-align:center; border:1px solid; vertical-align:middle;">September</th>
							<?php } else if($data[0]['quarter'] == 4) { ?>
							<th colspan="2" class="qtr" id="m1" style="text-align:center; border:1px solid; vertical-align:middle;">October</th>
							<th colspan="2" class="qtr" id="m2" style="text-align:center; border:1px solid; vertical-align:middle;">November</th>
							<th colspan="2" class="qtr" id="m3"  style="text-align:center; border:1px solid; vertical-align:middle;">December</th>
							<?php } else  { ?>
							<th colspan="2" class="qtr" id="m1" style="text-align:center; border:1px solid; vertical-align:middle;">January</th>
							<th colspan="2" class="qtr" id="m2" style="text-align:center; border:1px solid; vertical-align:middle;">February</th>
							<th colspan="2" class="qtr" id="m3"  style="text-align:center; border:1px solid; vertical-align:middle;">March</th>
							<?php } ?>
		                </tr>
		            </thead>
		            <tbody>
						<?php  
							$var1=$moon2 = $moon = 0;
							$var1=$moon3 = $moon4 = 0;
							foreach($datat2 as $key => $val){
							$numarea = $key+1;
							$numar = $var1;
						?>
		                <tr>
							<!-- data 2-->
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;" rowspan="<?php echo ($datat2[$numar]['area_num_sessions']*2)+3 ; ?>"><?php echo get_Village_Name($datat2[$numar]['area_code']); ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;" rowspan="<?php echo ($datat2[$numar]['area_num_sessions']*2)+3 ; ?>"><?php echo $datat2[$numar]['area_num_sessions']; ?></td>
							<!-- data 3-->
							<?php 
								$moon=$moon2;
								for($index=1;$index<=$val['area_num_sessions'];$index++)
								{ $var = $index - 1; 
							?>
							<?php if(isset($datat3[$moon]['session_type']) AND $datat3[$moon]['session_type']=='Fixed'){ ?>
							<td style="text-align:center; border:1px solid; vertical-align:middle;"><?php if(isset($datat3[$moon]['sitename_s'])) { echo get_Facility_Name($datat3[$moon]['sitename_s']); } ?></td>
							<?php } else { ?>
							<td style="text-align:center; border:1px solid; vertical-align:middle;"><?php if(isset($datat3[$moon]['sitename_s'])) { echo $datat3[$moon]['sitename_s']; } ?></td>
							<?php } ?>
							
							<td style="text-align:center; border:1px solid; vertical-align:middle;">Date of Scheduled</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php if(isset($datat3[$moon]['area_dateschedule_m1'])) { echo date('Y-m-d', strtotime($datat3[$moon]['area_dateschedule_m1'])); } ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;">Date of Scheduled</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php if(isset($datat3[$moon]['area_dateschedule_m2'])) { echo date('Y-m-d', strtotime($datat3[$moon]['area_dateschedule_m2'])); } ?></td>
							<td style="text-align:center; border:1px solid; vertical-align:middle;">Date of Scheduled</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php if(isset($datat3[$moon]['area_dateschedule_m3'])) { echo date('Y-m-d', strtotime($datat3[$moon]['area_dateschedule_m3'])); } ?></td>
							
					   </tr>
						<?php $moon++;} $moon2=$moon2+$val['area_num_sessions'];?>
		                <tr>
							<?php 
								$moon3=$moon4;
								for($index=1;$index<=$val['area_num_sessions'];$index++)  
								{ $var = $index - 1;  
							?>
							<?php if(isset($datat3[$moon3]['session_type']) AND $datat3[$moon3]['session_type']=='Fixed'){ ?>
							<td style="text-align:center; border:1px solid; vertical-align:middle;"><?php if(isset($datat3[$moon3]['sitename_h'])) { echo get_Facility_Name($datat3[$moon3]['sitename_h']); } ?></td>
		                    <?php }else{ ?>
							<td style="text-align:center; border:1px solid; vertical-align:middle;"><?php if(isset($datat3[$moon3]['sitename_h'])) { echo $datat3[$moon3]['sitename_h']; } ?></td>
							<?php } ?>
							<td style="text-align:center; border:1px solid; vertical-align:middle;">Date of Heald</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php if(isset($datat3[$moon3]['area_dateheld_m1'])) { echo date('Y-m-d', strtotime($datat3[$moon3]['area_dateheld_m1'])); } ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;">Date of Heald</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php if(isset($datat3[$moon3]['area_dateheld_m2'])) { echo date('Y-m-d', strtotime($datat3[$moon3]['area_dateheld_m2'])); } ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;">Date of Heald</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php if(isset($datat3[$moon3]['area_dateheld_m3'])) { echo date('Y-m-d', strtotime($datat3[$moon3]['area_dateheld_m3'])); } ?></td>
							
		                </tr>
						 <?php $moon3++;} $moon4=$moon4+$val['area_num_sessions']; ?>
		                <tr>
		                    <td rowspan="3" style="text-align:center; border:1px solid; vertical-align:middle;">&nbsp;</td>
		                    <?php if(isset($datat3[$moon3]['session_type']) AND $datat3[$moon3]['session_type']=='Fixed'){ ?>
							<td style="text-align:center; border:1px solid; vertical-align:middle;">Transport</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;">Transport</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"></td>
                            <td style="text-align:center; border:1px solid; vertical-align:middle;">Transport</td>
                            <td style="text-align:center; border:1px solid; vertical-align:middle;"></td>
							<?php } else { ?>
							<td style="text-align:center; border:1px solid; vertical-align:middle;">Transport</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $datat2[$numar]['area_transport_m1']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;">Transport</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $datat2[$numar]['area_transport_m2']; ?></td>
                            <td style="text-align:center; border:1px solid; vertical-align:middle;">Transport</td>
                            <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $datat2[$numar]['area_transport_m3']; ?></td>
							<?php } ?>
		                </tr>
		                <tr>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;">Person Responsible</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $datat2[$numar]['area_resperson_m1']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;">Person Responsible</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $datat2[$numar]['area_resperson_m2']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;">Person Responsible</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $datat2[$numar]['area_resperson_m3']; ?></td>
		                </tr>
		                <tr>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;">District Support (Y/N)</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $datat2[$numar]['area_distsupport_m1']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;">District Support (Y/N)</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $datat2[$numar]['area_distsupport_m2']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;">District Support (Y/N)</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $datat2[$numar]['area_distsupport_m3']; ?></td>
		                </tr>
						<!-- End-->
						<?php $var1++; } ?>		
		                <!-- table bottom Start-->
		                <tr>
		                    <td colspan="3" rowspan="2" style="text-align:center; border:1px solid; vertical-align:middle;">Activities for hard to reach and problem areas</td>
							<?php for($i=1; $i<=3; $i++) { ?>	
						   <td style="text-align:center; border:1px solid; vertical-align:middle;">Activities</td>
								<td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['ra_activities_m'.$i]; ?></td>
		                   <?php } ?>
		                </tr>
		                <tr>
							<?php for($i=1; $i<=3; $i++) { ?>	
								<td style="text-align:center; border:1px solid; vertical-align:middle;">Person Responsible</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['ra_resperson_m'.$i]; ?></td>
							<?php } ?>
		                   
		                </tr>
		                <tr>
		                    <td colspan="3" rowspan="2" style="text-align:center; border:1px solid; vertical-align:middle;">Regular Activities</td>
		                    <?php for($i=1; $i<=3; $i++) { ?>	
							<td style="text-align:center; border:1px solid; vertical-align:middle;">Activities</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['ra_activities_m'.$i]; ?></td>
		                   <?php } ?>
		                </tr>
		                <tr>
							<?php for($i=1; $i<=3; $i++) { ?>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;">Person Responsible</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['ra_resperson_m'.$i]; ?></td>
							<?php } ?>
		                </tr>
		                <tr>
		                    <td colspan="3" rowspan="6" style="text-align:center; border:1px solid; vertical-align:middle;">Monitoring of session implementation</td>
		                    <td rowspan="3" style="text-align:center; border:1px solid; vertical-align:middle;">No. of session held</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sh_fixed_m1']; ?></td>
		                    <td rowspan="3" style="text-align:center; border:1px solid; vertical-align:middle;">No. of session held</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sh_fixed_m2']; ?></td>
		                    <td rowspan="3" style="text-align:center; border:1px solid; vertical-align:middle;">No. of session held</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sh_fixed_m3']; ?></td>
		                </tr>
		                <tr>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sh_outreach_m1']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sh_outreach_m2']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sh_outreach_m3']; ?></td>
		                </tr>
		                <tr>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sh_mobile_m1']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sh_mobile_m2']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sh_mobile_m3']; ?></td>
		                </tr>
		                <tr>
		                    <td rowspan="3" style="text-align:center; border:1px solid; vertical-align:middle;">No. of session held</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sp_fixed_m1']; ?></td>
		                    <td rowspan="3" style="text-align:center; border:1px solid; vertical-align:middle;">No. of session held</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sp_fixed_m2']; ?></td>
		                    <td rowspan="3" style="text-align:center; border:1px solid; vertical-align:middle;">No. of session held</td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sp_fixed_m3']; ?></td>
		                </tr>
		                <tr>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sp_outreach_m1']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sp_outreach_m2']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sp_outreach_m3']; ?></td>
		                </tr>
		                <tr>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sp_mobile_m1']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sp_mobile_m2']; ?></td>
		                    <td style="text-align:center; border:1px solid; vertical-align:middle;"><?php echo $data[0]['sp_mobile_m3']; ?></td>
		                </tr>
		            </tbody>
		        </table>
				<div class="row">
					<div class="col-md-11">
						<div class="save_cancel">
						<?php if($filter_view == 1){?>
							<a href="<?php echo base_url();?>Compliance-Filter/HF-Quarterplan">	<button type="button" id="form_cancel"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
						<?php } elseif ($filter_view == 2) {?>
							<a href="<?php echo base_url();?>red_rec_microplan/RedRec_report/redrec_Filters"><button type="button" id="form_cancel"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
						<?php } else {?>
							<a href="<?php echo base_url();?>red_rec_microplan/Facility_quarterplan/hf_quarterplan_list"><button type="button" id="form_cancel"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
						<?php } ?>
						</div>
					</div>
				</div>
		    </div>
		</div>
	</div>
	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.2.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>