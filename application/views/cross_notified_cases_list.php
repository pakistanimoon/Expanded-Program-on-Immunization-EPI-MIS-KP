<div class="container bodycontainer">
<div class="row">
   <div class="panel panel-primary">
    	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
    	<ol class="breadcrumb">
         	<?php  echo $this->breadcrumbs->show();?>
      	</ol>
      	<?php 
	      	if($this -> uri -> segment(3) != '') {
				$districtcode = $this -> uri -> segment(3);
			}
			else{
				$districtcode = $this -> session -> District;
			}

			if($this -> uri -> segment(4) != '') {
				$year = $this -> uri -> segment(4);
				$yearString = "Year - $year";
			}
			else{
				$yearString = "";
			}
		?>
      <div class="panel-heading"> List of Pending Cases Cross Notified to <?php echo get_District_Name($districtcode); ?> <br> <?php echo $yearString; ?> </div>
      <div class="panel-body">
			
			<!-- <br> -->
			<table data-filter="#filter" data-filter-text-only="true" style="margin-bottom: 0px;" class="table  table-hover table-striped footable table-vcenter tbl-listing footable-loaded">
				<thead>
					
				</thead>
			</table>
			<br>
			<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
				<thead>
					<tr>
						<th class="text-center Heading">Year-Week</th>
						<th class="text-center Heading">Measles</th>
						<th class="text-center Heading">Diphtheria</th>
						<th class="text-center Heading">AFP</th>
						<th class="text-center Heading">NNT</th>
						<th class="text-center Heading">Other Diseases</th>
					</tr>
				</thead>        
				<?php if(($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') && ($this -> session -> District) || ($this -> uri -> segment(3) == '')){ ?>
					<tbody id="tbody">
						<?php
							//$i=0;
							foreach($mergedQuery as $key=>$row) { ?>
								<tr>
									<td class="text-center" style="background-color: #2E8B57; color: white; font-size: 100%;">
										<?php 
											if($row['fweek'] != '') 
												{echo $row['fweek'];}
											else{}
										 ?>										
									</td>
									<td class="text-center">
										<?php 
											if(isset($row['msl_cases']) && $row['msl_cases']!=''){
												//echo $row['msl_cases'];
												echo '<a href="'.base_url().'Measles_investigation/measles_investigation_list/'.$row['fweek'].'" style="color:red" target="_blank"><strong>'.$row['msl_cases'].'</strong></a>'; 
											}
											else{ 
												echo '0';
											} 
										?>										
									</td>
									<td class="text-center">
										<?php 
											if(isset($row['diph_cases']) && $row['diph_cases']!=''){
												//echo $row['msl_cases'];
												echo '<a href="'.base_url().'Case_investigation/case_investigation_list/'.$row['fweek'].'/'.$row['case_type'].'" style="color:red" target="_blank"><strong>'.$row['diph_cases'].'</strong></a>'; 
											}
											else{ 
												echo '0';
											} 
										?>										
									</td>																	
									<td class="text-center">
										<?php
											if(isset($row['afp_cases']) && $row['afp_cases'] != NULL){
												//echo $row['afp_cases'];
												echo '<a href="'.base_url().'AFP-CIF/List/'.$row['fweek'].'" style="color:red" target="_blank"><strong>'.$row['afp_cases'].'</strong></a>';
											}
											else{ 
												echo '0'; 
											} 
										?>										
									</td>
									<td class="text-center">
										<?php
											if(isset($row['nnt_cases']) && $row['nnt_cases'] != NULL){
												//echo $row['nnt_cases'];
												echo '<a href="'.base_url().'NNT-CIF/List/'.$row['fweek'].'" style="color:red" target="_blank"><strong>'.$row['nnt_cases'].'</strong></a>';
											}
											else{ 
												echo '0'; 
											}
										?>										
									</td>
									<td class="text-center">
										<?php 
											if(isset($row['other_cases']) && $row['other_cases'] !=''){
												//echo $row['other_cases'];
												echo '<a href="'.base_url().'Case_investigation/case_investigation_list/'.$row['fweek'].'" style="color:red" target="_blank"><strong>'.$row['other_cases'].'</strong></a>';
											}
											else{
												echo '0'; 
											} 
										?>	
									</td>
								</tr>
						<?php $key+1; } ?>
						<tr>
							<td class="text-center" style="background-color: #2F4F4F; color: white; font-size: 100%; font-weight: bold;">Total</td>
							<td class="text-center" style="background-color: #2F4F4F; color: white; font-size: 100%; font-weight: bold;"><?php echo $mslCasesSUM[0]['msl_cases']; ?></td>
							<td class="text-center" style="background-color: #2F4F4F; color: white; font-size: 100%; font-weight: bold;"><?php echo $diphCasesSUM[0]['diph_cases']; ?></td>							
							<td class="text-center" style="background-color: #2F4F4F; color: white; font-size: 100%; font-weight: bold;"><?php echo $afpCasesSUM[0]['afp_cases']; ?></td>
							<td class="text-center" style="background-color: #2F4F4F; color: white; font-size: 100%; font-weight: bold;"><?php echo $nntCasesSUM[0]['nnt_cases']; ?></td>
							<td class="text-center" style="background-color: #2F4F4F; color: white; font-size: 100%; font-weight: bold;"><?php echo $mainCasesSUM[0]['other_cases']; ?></td>
						</tr>
					</tbody>
				<?php } else { ?>
					<tbody id="tbody">
						<?php
							//$i=0;
							foreach($mergedQuery as $key=>$row) { ?>
								<tr>
									<!-- <td class="text-center"><?php //echo $key+1; ?></td> -->
									<td class="text-center" style="background-color: #2E8B57; color: white; font-size: 100%;">
										<?php 
											if($row['fweek'] != '') 
												{echo $row['fweek'];}
											else{}
										 ?>										
									</td>
									<td class="text-center">
										<?php 
											if(isset($row['msl_cases']) && $row['msl_cases']!=''){
												//echo $row['msl_cases'];
												echo '<strong style="color:red">'.$row['msl_cases'].'</strong>';
											}
											else{ 
												echo '0';
											} 
										?>										
									</td>
									<td class="text-center">
										<?php 
											if(isset($row['diph_cases']) && $row['diph_cases']!=''){
												//echo $row['msl_cases'];
												echo '<strong style="color:red">'.$row['diph_cases'].'</strong>';
											}
											else{ 
												echo '0';
											} 
										?>										
									</td>																	
									<td class="text-center">
										<?php
											if(isset($row['afp_cases']) && $row['afp_cases'] != NULL){
												//echo $row['afp_cases'];
												echo '<strong style="color:red">'.$row['afp_cases'].'</strong>';
											}
											else{ 
												echo '0'; 
											} 
										?>										
									</td>
									<td class="text-center">
										<?php
											if(isset($row['nnt_cases']) && $row['nnt_cases'] != NULL){
												//echo $row['nnt_cases'];
												echo '<strong style="color:red">'.$row['nnt_cases'].'</strong>';
											}
											else{ 
												echo '0'; 
											}
										?>										
									</td>
									<td class="text-center">
										<?php 
											if(isset($row['other_cases']) && $row['other_cases'] !=''){
												//echo $row['other_cases'];
												echo '<strong style="color:red">'.$row['other_cases'].'</strong>';
											}
											else{
												echo '0'; 
											} 
										?>	
									</td>
								</tr>
							<?php $key+1; } ?>
								<tr>
									<td class="text-center" style="background-color: #2F4F4F; color: white; font-size: 100%; font-weight: bold;">Total</td>
									<td class="text-center" style="background-color: #2F4F4F; color: white; font-size: 100%; font-weight: bold;"><?php echo $mslCasesSUM[0]['msl_cases']; ?></td>
									<td class="text-center" style="background-color: #2F4F4F; color: white; font-size: 100%; font-weight: bold;"><?php echo $diphCasesSUM[0]['diph_cases']; ?></td>							
									<td class="text-center" style="background-color: #2F4F4F; color: white; font-size: 100%; font-weight: bold;"><?php echo $afpCasesSUM[0]['afp_cases']; ?></td>
									<td class="text-center" style="background-color: #2F4F4F; color: white; font-size: 100%; font-weight: bold;"><?php echo $nntCasesSUM[0]['nnt_cases']; ?></td>
									<td class="text-center" style="background-color: #2F4F4F; color: white; font-size: 100%; font-weight: bold;"><?php echo $mainCasesSUM[0]['other_cases']; ?></td>
								</tr>
						</tbody>
					<?php } ?>
         	</table>
         	<br>			
    		</div> <!--end of panel body-->
 		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->