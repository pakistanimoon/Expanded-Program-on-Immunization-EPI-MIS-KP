
	<div class="panel-heading" style="color:white;margin-left:16px;margin-right:16px;">EPI Center Details</div>
	<div class="panel-heading">EPI Center Details(<?php echo $data['resultfac']['fac_name'];?>)</div>
				
				<div style="padding:0px 15px;margin-top:1px;">
						<table id="techdb-tbl" border="1" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true" style="top:-40px">
            <thead>
              <tr>
			   <th class="text-center Heading">Population Facility (0-11)</th> 
                <th class="text-center Heading">Annual Target (0-11)</th>				
                <th class="text-center Heading">Monthly Target (0-11)</th>
                <th class="text-center Heading">Annual Surviving Infants (0-11)</th>
				<th class="text-center Heading">Monthly Surviving Infants (0-11)</th>
                <th class="text-center Heading">Annual (PL) Women</th>                
                <th class="text-center Heading">Monthly (PL) Women</th>
                <th class="text-center Heading">Annual CBA's</th> 
                <th class="text-center Heading">Monthly CBA's</th> 
                <th class="text-center Heading">12-23 Months Annual</th> 				
                <th class="text-center Heading">12-23 Months</th> 				
                <th class="text-center Heading">Children &lt;5 Years</th> 				
                <th class="text-center Heading">Children below 15 Years</th> 				
              </tr>
            </thead>
           <tbody id="tbody" style="text-align:center;"> 


        <tr class="DrilledDown">     
          <td class="text-center" ><?php echo $provincePopulation; ?></td>
          <td class="text-center" ><?php echo $anuualTargetPopulation; ?></td>
          <td class="text-center" ><?php echo $monthlyTargetPopulation; ?></td>
          <td class="text-center" ><?php echo $annualSurvivingInfants; ?></td>		  
          <td class="text-center" ><?php echo $monthlySurvivingInfants; ?></td>
          <td class="text-center" ><?php echo $annualPregnantLactatingPlWomen; ?></td>
          <td class="text-center" ><?php echo $monthlyPregnantLactatingPlWomen; ?></td>
		  <td class="text-center" ><?php echo $cbaLadies; ?></td>
		  <td class="text-center" ><?php echo $cbaLadies/12; ?></td>
          <td class="text-center" ><?php echo $annualPnnMortality; ?></td>
          <td class="text-center" ><?php echo $monthlyPnnMortality; ?></td>
          <td class="text-center" ><?php echo $childrenLessThan5Years; ?></td>
          <td class="text-center" ><?php echo $below15Years; ?></td>
		</tr>
    </tbody>
			 </table>
		
				</div> 	
				
				<div class="panel-heading" style="color:black;margin-left:16px;margin-right:16px;">Basic Information</div>
				<div style="padding:0px 15px;margin-top:1px;">
						<table id="techdb-tbl" border="1" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true" style="top:-40px">
            <thead>
              <tr>
			    <th class="text-center Heading">EPI Center Name </th>
                <th class="text-center Heading">District</th> 
                <th class="text-center Heading">Tehsil</th>				
                <th class="text-center Heading">Union Council</th>
                <th class="text-center Heading">Area Type</th>
				<th class="text-center Heading">EPI Center Type </th>
                <th class="text-center Heading">EPI Center Address </th>                
              </tr>
            </thead>
             <tbody id="tbody" style="text-align:center;"> 

        <tr class="DrilledDown">
          <td class="text-center" ><?php echo $data['resultfac']['fac_name'];?></td>          
          <td class="text-center" ><?php echo $data['resultfac']['district'];?></td>
          <td class="text-center" ><?php echo $data['resultfac']['tehsilname'];?></td>
          <td class="text-center" ><?php echo $data['resultfac']['unioncouncil'];?></td>		  
          <td class="text-center" ><?php echo $data['resultfac']['areatype'];?></td>
          <td class="text-center" ><?php echo $data['resultfac']['fatype'];?></td>
          <td class="text-center" ><?php echo $data['resultfac']['fac_address'];?></td>
		</tr>
 
             </tbody>
			 </table>
		
				</div>

 			<div class="panel-heading" style="color:black;margin-left:16px;margin-right:16px;">Human Resource</div>	
				<div style="padding:0px 15px;margin-top:1px;">
						<table id="techdb-tbl" border="1" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true" style="top:-40px">
            <thead>
              <tr>
			     <th class="text-center Heading">S#</th> 
                <th class="text-center Heading">Designation</th>				
                <th class="text-center Heading">Name</th>
                <th class="text-center Heading">Father Name</th>
				<th class="text-center Heading">CNIC</th>
                <th class="text-center Heading">Phone</th>                
                <th class="text-center Heading">Status</th>                
              </tr>
            </thead>
             <tbody id="tbody" style="text-align:center;"> 
  <?php
      $i=0;
      foreach($data['epitechname'] as $row){
        $i++;
        ?>

        <tr class="DrilledDown">
          <td class="text-center"><span class="footable-toggle"></span><?php echo $i; ?></td>
          <td class="text-center" >EPI Technicians</td>          
          <td class="text-center" ><?php echo $row['technicianname']; ?></td>
          <td class="text-center" ><?php echo $row['fathername']; ?></td>
          <td class="text-center" ><?php echo $row['nic']; ?></td>
          <td class="text-center" ><?php echo $row['phone']; ?></td>		  
          <td class="text-center" ><?php echo $row['status']; ?></td>
		</tr>
        <?php
      }
      ?>
             </tbody>
			 
			            <tbody id="tbody" style="text-align:center;"> 
    <?php
      //$i=0;
      foreach($data['hftechname'] as $row){
        $i++;
        ?>

        <tr class="DrilledDown">
          <td class="text-center"><span class="footable-toggle"></span><?php echo $i; ?></td>
		  <td class="text-center" >HF Incharge</td>   
          <td class="text-center" ><?php echo $row['technicianname']; ?></td>
          <td class="text-center" ><?php echo $row['fathername']; ?></td>
          <td class="text-center" ><?php echo $row['nic']; ?></td>
          <td class="text-center" ><?php echo $row['phone']; ?></td>		  
          <td class="text-center"><?php echo $row['status']; ?></td>
		</tr>
        <?php
      }
      ?>
             </tbody>	
			 </table>
		
				</div> 	
				
				<div class="panel-heading" style="color:black;margin-left:16px;margin-right:16px;">Cold Chain Equipment</div>
				<div style="padding:0px 15px;margin-top:1px;">
						<table id="techdb-tbl" border="1" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true" style="top:-40px">
            <thead>
              <tr>
			    <th class="text-center Heading">S#</th>
                <th class="text-center Heading">Asset Name</th> 
                <th class="text-center Heading">Model</th>				
                <th class="text-center Heading">Make</th>
                <th class="text-center Heading">Source of Supply</th>
				<th class="text-center Heading">Status</th>
                <th class="text-center Heading">Working Since</th>                
              </tr>
            </thead>
             <tbody id="tbody" style="text-align:center;"> 
  <?php
      $i=0;
      foreach($data['working_status'] as $row){
        $i++;
        ?>

        <tr class="DrilledDown">
          <td class="text-center"><span class="footable-toggle"></span><?php echo $i; ?></td>
          <td class="text-center" ><?php echo $row['asset_type_name']; ?></td>          
          <td class="text-center" ><?php echo $row['model_name']; ?></td>
          <td class="text-center" ><?php echo $row['make_name']; ?></td>
          <td class="text-center" ><?php echo (isset($row['source_id'])?getSourceSupply($row['source_id'],TRUe):''); ?></td>
          <td class="text-center" ><?php echo (isset($row['status'])?getWorkingstatus($row['status'],TRUe):''); ?></td>		  
          <td class="text-center" ><?php echo $row['working_since']; ?></td>
		</tr>
        <?php
      }
      ?>
	  <?php if($data['working_status']==null) : ?>
    <tr class="odd">
          <td colspan="9" class="dataTables_empty" valign="top"><span class="footable-toggle"></span>No data available in Cold Chain</td>
    </tr> 
	<?php endif; ?>
             </tbody>
			 </table>
		
				</div> 	
	<!-- Start -->	
<?php if(!empty($data2)): ?>
	<div class="panel-heading" style="color:black;margin-left:16px;margin-right:16px;">Inventory(Stock)- From Closing Balance Consumption Report(<?php echo $data2[0]['fmonth']; ?>)</div>
	<div style="margin-top:1px;">
		<table id="techdb-tbl" border="1" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true" style="top:-40px">
			  <thead>
					  <tr>
						<th class="text-center Heading">Item</th>
						<th class="text-center Heading">No. of doses in vial</th> 
						<th class="text-center Heading">No. of available batches</th>				
						<th class="text-center Heading">Available Quantity in Vials</th>
						<th class="text-center Heading">Available Quantity in Doses</th>       
					  </tr>
					</thead>
			<tbody id="ajax_data" style="text-align:center;"> 
			<?php                                
				foreach($data2 as $key=>$singlerec){
			 ?>
				<tr class="DrilledDown">
				<td class="text-left"><?php echo $singlerec["item"]; ?></td>
				<td class="text-center"><?php echo $singlerec["batch_doses"] ?></td>
				<td class="text-center"><?php echo $singlerec["batch_number"]; ?></td>
				<td class="text-center"><?php echo $singlerec["closing_vials"]; ?></td>
				<td class="text-center"><?php echo $singlerec["closing_doses"]; ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
<?php endif; ?>

<!---start-->
			<div class="panel-body">
				<!--it is use for show message-->
				<!--<form name="dataform" id="dataform" action="<?php echo base_url(); ?>Status/Save/<?php echo $facode; ?>" method="POST" class="form-horizontal form-bordered">-->     
					<input type="hidden" value="<?php echo (isset($facode)?$facode : '') ?>" name="facode">
					<div class="panel-heading" style="color:black;margin-left:2px;margin-right:2px;">EPI Center Functional Status</div>
					<table class="table table-bordered table-striped table-hover mytable2 mytable3" border="1">
						<!--<thead>
							<tr>
								<th style="border-right:0px;width: 40%;">
								</th>
								<th style="text-align: left;padding-top: 10px;padding-bottom: 15px;border-left: 0;border-right: 0px;">EPI Center Functional Status</th>
							</tr>
						</thead>-->
						<tbody>
							<tr>
								<td colspan="9">
									<div class="tab-content">                  
										<div class="tab-pane active" id="tab-1">
											<table style="width: 100%;">
												<tbody>
												
												</tbody>
											</table>
											<table border="1" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
												<thead>
													
													<tr>
														<th class="text-center Heading"style="width:315px;">Status</th>
														<th class="text-center Heading"style="width:315px;">Start Month</th>
														<th class="text-center Heading"style="width:315px;">End Month</th>
														<th class="text-center Heading"style="width:315px;">Reason</th>
													</tr>
												</thead>
												<tbody id="tbody">	
													<?php 
													if(isset($data['status_data'])){
														$count = count($data['status_data']);
														$first_row = $count;
														$cnt = $count;
														foreach($data['status_data'] as $data1){
															if($first_row === $cnt)
															{
																$start_month = $data1['m_y_from'];
																if( ! empty($start_month))
																{
																	$start_month = date('Y-m', strtotime($data1['m_y_from'].' first day of next month'));
																	$first_row = 0;
																	$cnt = 1;
																}
															}
															if($data1['m_y_from'] != ''){ ?>
																<tr>
																	<td class="text-center"><?php echo $data1['case']; ?></td>
																	<td class="text-center"><?php echo $data1['m_y_from']; ?></td>
																	<td class="text-center"><?php echo $data1['m_y_to'];?></td>
																	<td class="text-center"><?php if(isset($data1['reason_vacc'])) { echo $data1['reason_vacc']; }?></td>
																	<?php
																	if( ! ($count > 1)){ ?>
																		<td class="text-center"></td>
																	<?php 
																	}else{
																		$count = 0; ?>
																		<!--<td class="text-center">
																			<a href="<?php echo base_url(); ?>Status/Delete/<?php echo $data['id'];?>/<?php echo $data['facode'];?>/vacc" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>
																		</td> -->
																	<?php
																	} ?>
																</tr>
															<?php 
															}else{
																$count--;
															}
														}
													} ?> 
												</tbody>
											</table>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				<!--</form>-->
			</div> <!--end of panel body-->
		
			
<!---end--->

<!---start-->
			<div class="panel-body">
				<!--it is use for show message-->    
					<input type="hidden" value="<?php echo (isset($facode)?$facode : '') ?>" name="facode">
					<div class="panel-heading" style="color:black;margin-left:2px;margin-right:2px;">Surveillance Site Functional Status</div>
					<table border="1" class="table table-bordered table-striped table-hover mytable2 mytable3">
						<!--<thead>
							<tr>
								<th style="border-right:0px;width: 40%;">
								</th>
								<th style="text-align: left;padding-top: 15px;padding-bottom: 10px;border-left: 0;border-right: 0px;">Surveillance Site Functional Status</th>
							</tr>
						</thead>-->
						<tbody>
							<tr>
								<td colspan="9">
									<div class="tab-content">                  
										<div class="tab-pane active" id="tab-2">
											<table style="width: 100%;">
												<tbody>
												
												</tbody>
											</table>
											
											<table border="1" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
												<thead>
													
													<tr>
														<th class="text-center Heading"style="width:315px;">Status</th>
														<th class="text-center Heading"style="width:315px;">Start Week</th>
														<th class="text-center Heading"style="width:315px;">End Week</th>
														<th class="text-center Heading"style="width:315px;">Reason</th>
												
													</tr>
												</thead>
												<tbody id="tbody">	
													<?php 
													if(isset($data['status_data'])){
															//print_r($data); exit;
														$count = count($data['status_data']);
														foreach($data['status_data'] as $data2){ 
														// print_r($data1); exit;
															if($data2['w_y_from'] != ''){ ?>
																<tr>
																	<td class="text-center"><?php echo $data2['case']; ?></td>
																	<td class="text-center"><?php echo $data2['w_y_from'];?></td>
																	<td class="text-center"><?php echo $data2['w_y_to'];?></td>
																	<td class="text-center"><?php echo $data2['reason_ds'];?></td>
																	<?php
																	if( ! ($count > 1)){ ?>
																		<td class="text-center"></td>
																	<?php 
																	}else{
																		$count = 0; ?>
																		<!--<td class="text-center">
																			<a href="<?php echo base_url(); ?>Status/Delete/<?php echo $data['id'];?>/<?php echo $data['facode'];?>/ds" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>
																		</td> -->
																	<?php
																	} ?>
																</tr>
															<?php 
															}else{
																$count--;
															} ?>
														<?php 
														} 
													} ?>
												</tbody>
											</table>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
			</div> <!--end of panel body-->
<!---end--->	