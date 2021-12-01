<a href="<?php echo base_url(); ?>System_setup/flcf_view_excel/<?php echo $data['facode'];?>/<?php echo $data['years'];?>" data-toggle="tooltip" target="_blank" title="Excel" class="btn btn-xs btn-default" style="float: right;"><img src="<?php echo base_url(); ?>/includes/images/Excel.png" style="width:41px;margin-top:9px">
	</a>
<div class="container bodycontainer">
<div class="row">
<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
  <div class="panel panel-primary">
    <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 

    <div class="panel-heading">EPI Center Details(<?php echo $resultfac['fac_name'];?>)</div>

  	   <div class="panel-body">  
	   		
            <div class="row row-tiles">
		      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 animated fadeInDown">
			    <div class="panel panel-default">
				  <td><label>Year</label>
					<select id="dashyear" name="year" class="form-control">
						<?php echo getAllYearsOptionsIncludingCurrent(false); ?>
					</select>
				  </td>
			    </div>
		     </div>
			<!-- <div class="row" style="margin-top:20px;font-weight: bold;">
			  <div class="col-xs-1 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" > </label>
                      </div>
                      <div class="col-xs-0 cmargin5">
                        <span> <?php echo $resultfac['fac_name'];?> </span>
                       </div>
				</div>-->	  
	        </div> 
<br>  
              <div id='indicator'>
			    <?php echo $this -> load -> view('system_setup/indicatorcardsflcf', $data, TRUE); ?>
             </div>
			<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
            <div class="row">
              <div class="col-xs-7 cmargin5" style="margin-left:75%;">
    			<a href=" <?php echo base_url(); ?>Population/Facilities" class="btn btn-md btn-success "><i class="fa fa-pencil-square-o"></i> Update Population</a>                                                    
						  </div>
				    </div>
               <?php }?>

   <br> 	   
           <div class="panel-heading" style="color:white;">Basic Information</div>
    	   	<form name="dataform" id="dataform" action="<?php echo base_url();?>System_setup/flcf_add" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
               <input type="hidden" name="facode" id="facode"  value="<?php echo $resultfac['facode']; ?>"  class="form-control "/>
			
               
				
									<?php



									if($this->input->get('facode')){

										?>

										<input type="hidden" name="edit" value="2" />

										<?php

									}



									?>

	     
	              <div class="form-group">

                      <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" > EPI Center Name </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1 cmargin5">
                        <span> <?php echo $resultfac['fac_name'];?> </span>
                        <input type="hidden" required name="facode" id="facode" readonly="readonly" placeholder="Facility Code"  class="form-control "  value="<?php echo (isset($resultfac) ? $resultfac['facode'] : '') ;?>"/>

                      </div>
                     <!--<div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Population</label>
                      </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo $resultfac['catchment_area_pop'];?> </span>
                      </div>-->
					  <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "bankbranch" > District </label>
                      </div>
                      <div class="col-xs-2  cmargin5">
                        <span> <?php echo $resultfac['district'];?> </span>
                      </div>
                    </div>
                    
                    <div class="row">
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "bankaccount" >Tehsil</label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1 cmargin5">
                        <span> <?php echo $resultfac['tehsilname'];?> </span>
                      </div>
					  
					  <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "nic" > Union Council </label>
                      </div>
                      <div class="col-xs-2  cmargin5">
                        <span> <?php echo $resultfac['unioncouncil'];?> </span>
                      </div>
                    </div>
					
					<div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "date_of_birth" > Area Type </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1 cmargin5">
                         <span> <?php echo $resultfac['areatype'];?> </span>
                      </div>
					  
					  <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "distcode" > EPI Center Type </label>
                  </div>
                    <div class="col-xs-2  cmargin5">
                    <span> <?php echo $resultfac['fatype'];?> </span>
                    </div>
					  
                    </div>

                <div class="row">
                  
                      <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > EPI Center Address </label>
                </div>
                 <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $resultfac['fac_address'];?> </span>
                 </div>
		
                </div>
				<br>
				   <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
            <div class="row">
              <div class="col-xs-7 cmargin5" style="margin-left:75%;">
    						<a href=" <?php echo base_url(); ?>System_setup/flcf_add?facode=<?php echo $resultfac['facode']; ?>" class="btn btn-md btn-success "><i class="fa fa-pencil-square-o"></i> Update Details</a>                                                    
						  </div>
				    </div>
               <?php }?>
			   <br>
				<div class="panel-heading" style="color:white;margin-left:16px;margin-right:16px;">Human Resource</div>
				<div style="padding:0px 15px;margin-top:1px;">
						<table id="techdb-tbl" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true" style="top:-40px">
            <thead>
              <tr>
                <th class="text-center Heading">S#</th> 
                <th class="text-center Heading">Designation</th>				
                <th class="text-center Heading">Name</th>
                <th class="text-center Heading">Father Name</th>
				<th class="text-center Heading">CNIC</th>
                <th class="text-center Heading">Phone</th>                
                <th class="text-center Heading">Status</th>
				<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
				<th class="text-center Heading">Action</th>
				<?php } ?>
              </tr>
            </thead>
             <tbody id="tbody" style="text-align:center;"> 
			  <!-- <?php if($epitechname==null) : ?>
    <tr class="odd">
          <td colspan="9" class="dataTables_empty" valign="top"><span class="footable-toggle"></span>No data available in EPI Technicians</td>
    </tr> 
	<?php endif; ?>-->
  <?php
      $i=0;
      foreach($epitechname as $row){
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
		     <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
          <td class="text-center">
            <a data-original-title="View" href="<?php echo base_url(); ?>Technician/View/<?php echo $row['techniciancode']?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
            <a data-original-title="Edit" href="<?php echo base_url(); ?>Technician/Edit/<?php echo $row['techniciancode']?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	      </td>
	       <?php } ?>
	   
	  
		</tr>
        <?php
      }
      ?>
	
             </tbody>
			 <!--</table>
			 
				<table id="techdb-tbl" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true" style="top:-40px">
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
            </thead>-->	 

             <tbody id="tbody" style="text-align:center;"> 
  <?php
      //$i=0;
      foreach($hftechname as $row){
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
		    <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
          <td class="text-center">
            <a data-original-title="View" href="<?php echo base_url(); ?>HF-Incharge/View/<?php echo $row['techniciancode']?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
            <a data-original-title="Edit" href="<?php echo base_url(); ?>HF-Incharge/Edit/<?php echo $row['techniciancode']?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	      </td>
	       <?php } ?>
		</tr>
        <?php
      }
      ?>
 <!--<?php if($hftechname==null) : ?>
    <tr class="odd">
          <td colspan="9" class="dataTables_empty" valign="top"><span class="footable-toggle"></span>No data available in HF Incharge</td>
    </tr> 
	<?php endif; ?>-->
	 
             </tbody>			 
          </table>
				</div>

				
				<div class="panel-heading" style="color:white;margin-left:16px;margin-right:16px;">Cold Chain Equipment</div>
				
				<div style="padding:0px 15px;margin-top:1px;">
						<table id="techdb-tbl" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true" style="top:-40px">
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
      foreach($working_status as $row){
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
	  <?php if($working_status==null) : ?>
    <tr class="odd">
          <td colspan="9" class="dataTables_empty" valign="top"><span class="footable-toggle"></span>No data available in Cold Chain</td>
    </tr> 
	<?php endif; ?>
             </tbody>
			 </table>
		
				</div> 	
<!---start-->
			<div class="panel-body">
				<!--it is use for show message-->
				<!--<form name="dataform" id="dataform" action="<?php echo base_url(); ?>Status/Save/<?php echo $facode; ?>" method="POST" class="form-horizontal form-bordered">-->     
					<input type="hidden" value="<?php echo (isset($facode)?$facode : '') ?>" name="facode">
					<div class="panel-heading" style="color:white;margin-left:2px;margin-right:2px;">EPI Center Functional Status</div>
					<table class="table table-bordered table-striped table-hover mytable2 mytable3">
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
											<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
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
													if(isset($status_data)){
														$count = count($status_data);
														$first_row = $count;
														$cnt = $count;
														foreach($status_data as $data){
															if($first_row === $cnt)
															{
																$start_month = $data['m_y_from'];
																if( ! empty($start_month))
																{
																	$start_month = date('Y-m', strtotime($data['m_y_from'].' first day of next month'));
																	$first_row = 0;
																	$cnt = 1;
																}
															}
															if($data['m_y_from'] != ''){ ?>
																<tr>
																	<td class="text-center"><?php echo $data['status']; ?></td>
																	<td class="text-center"><?php echo $data['m_y_from']; ?></td>
																	<td class="text-center"><?php echo $data['m_y_to'];?></td>
																	<td class="text-center"><?php if(isset($data['reason_vacc'])) { echo $data['reason_vacc']; }?></td>
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
				<!--<form name="dataform" id="dataform" action="<?php echo base_url(); ?>Status/Save/<?php echo $facode; ?>" method="POST" class="form-horizontal form-bordered">-->     
					<input type="hidden" value="<?php echo (isset($facode)?$facode : '') ?>" name="facode">
					<div class="panel-heading" style="color:white;margin-left:2px;margin-right:2px;">Surveillance Site Functional Status</div>
					<table class="table table-bordered table-striped table-hover mytable2 mytable3">
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
											
											<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
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
													if(isset($status_data)){
														$count = count($status_data);
														foreach($status_data as $data){
															if($data['w_y_from'] != ''){ ?>
																<tr>
																	<td class="text-center"><?php echo $data['status']; ?></td>
																	<td class="text-center"><?php echo $data['w_y_from'];?></td>
																	<td class="text-center"><?php echo $data['w_y_to'];?></td>
																	<td class="text-center"><?php echo $data['reason_ds'];?></td>
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
				<!--</form>-->
            	   
            <div class="row">
              <div class="col-xs-7 cmargin5" style="margin-left:76%;">
			 
			  <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
			    <a href="<?php echo base_url();?>System_setup/flcf_list" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
				<a href=" <?php echo base_url(); ?>Status/View/<?php echo $resultfac['facode']; ?>" class="btn btn-md btn-success "><i class="fa fa-pencil-square-o"></i> Update Status</a>                                                    
			  <?php } else if (($_SESSION['UserLevel']=='4') && ($_SESSION['utype']=='Store') ){?>
			       <a href="<?php echo base_url();?>setup_listing/VPD_Centers_listing" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
			  <?php }else{?>
				   <a href="<?php echo base_url();?>setup_listing/listing/EPI_Centers" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
			 <?php }?>
			  </div>
				    </div>
               
			</div> <!--end of panel body-->
<!---end--->		
              </div>	  
	
              
            </form>		
             
      
  	</div> <!--end of panel body-->

 </div> <!--end of panel panel-primary-->

</div><!--end of row-->	



</div><!--End of page content or body contaier-->
<script type="text/javascript">
$(document).on('change','#dashyear',function(){
	$('#showForms').html('');
	var year=$(this).val();
	var facode=$("#facode").val();
	//alert(facode);
	var data = {year:year,facode:facode,ajax:true};
	if(year!=0){
		$.ajax({
			type: "POST",
			data:data,
			async:true,
			dataType : 'json',
			url: "<?php echo base_url(); ?>System_setup/flcf_view",
			success: function(result){
				$('#indicator').html(result.cards);
			}
		});
	}
});
</script>





