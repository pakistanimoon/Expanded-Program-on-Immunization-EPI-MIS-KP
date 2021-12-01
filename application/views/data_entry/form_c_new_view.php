<!--start of page content or body-->

 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> UC Demand, Consumption & Receipt Form View</div>
     <div class="panel-body">
       <form class="form-horizontal">
        <table class="table table-bordered   table-striped table-hover  mytable">
          <tr>
            <td><label>Campaigns Type</label></td>
            <td><?php if(isset($a)){ echo $campaign_type;} ?></td>
            <td><label >From</label></td>
            <td><?php if(isset($a)){ echo $start_date;} ?></td>
            
            <td><label >To</label></td>
            <td><?php if(isset($a)){ echo $end_date;} ?></td>
          </tr>
          <tr>
            <td><label >Province</label></td>
            <td><?php if(isset($a)){ echo "Khyber Pakhtunkhwa";} ?></td>            
            <td><label >District</label></td>
            <td><?php if(isset($a)){ echo $district; } ?></td>
            <td><label >Vaccine Type</label></td>
            <td><?php if(isset($a)){ echo $vaccine_name->vaccine_name;} ?></td>
          </tr>
         
      </table>
         




        <div id="parent">
        <table id="fixTable"   class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th rowspan="3">Union Councils</th>
			  <th rowspan="3" colspan="2">Report Submitted</th>
              <th colspan="8">DEMAND</th>
              <th colspan="4">CONSUMPTION</th>
            </tr>
            <tr>               
              
              <th rowspan="2">Doses per<br>Vial</th>
              <th rowspan="2">Target #</th>
              <th rowspan="2">Wastage factor</th>
              <th colspan="2">Required</th>
              <th>Opening Balance</th>
              <th>Request<br>G=E-F</th>
              <th>Received</th>
              <th rowspan="2">Children Vaccinated/<br>Doses Administered </th>
              <th>Vials Used</th>
              <th>Unusable Vials</th>
              <th>Closing Balance</th>
            </tr>

            <tr>
              <th>Doses D=BxC</th>
              <th>Vials/Nos. E=D/A</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
            </tr>
            <tr style="background: white none repeat scroll 0% 0%; color: black;">
              <th></th>
			  <th style="font-weight:500;">Yes</th>
			  <th style="font-weight:500;">No</th>
              <th>A</th>
              <th>B</th>
              <th>C</th>
              <th>D</th>
              <th>E</th>
              <th>F</th>
              <th>G</th>
              <th>H</th>
              <th>I</th>
              <th>J</th>
              <th>K</th>
              <th>L</th>
            </tr>
          </thead>
         <tbody id="myTable">
          	<?php if(isset($a)){ 
					foreach($a as $key => $row){ 
			?>
				 <td><label><?php echo get_UC_Name($row['uncode']); ?></label></td>
				  <td class="cases"><p class="text-center"><?php echo $row['report_submitted'] == '1' ? '&#10004;' : ''; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['report_submitted'] == '0' ? '&#10007;' : ''; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['othername']!= '0' ? $row['othername'] : $row['doses_per_vial']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['target']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['wastage_facter']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['required_doses']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['required_vials']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['opening_bal_vials']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['requested_vials']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['recieved_vials']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['child_vacc_dose']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['vials_used']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['vials_unused']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['closing_bal']; ?></p></td>
				</tr>
            <?php    
					} 
				} ?>
          </tbody>
        </table>
	</div>
<br>
        <div class="row">
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label >Requested by</label></td>
                <td><?php if(isset($a)){ echo $requested_by_name;} ?></td>
              </tr>
              <tr>
                <td><label >Designation</label></td>
                <td><?php if(isset($a)){ echo $requested_by_desg;} ?></td>
              </tr>
              <tr>
                <td><label >Store Name</label></td>
                <td><?php if(isset($a)){ echo $requested_by_store;} ?></td>
              </tr>
              <tr>
                <td><label >Date</label></td>
                <td><?php if(isset($a)){ echo $requested_on;} ?></td>
              </tr>
            </tbody>
          </table>
          </div>
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label >Received by</label></td>
                <td><?php if(isset($a)){ echo $received_by_name;} ?></td>
              </tr>
              <tr>
                <td><label >Designation</label></td>
                <td><?php if(isset($a)){ echo $received_by_desg;} ?></td>
              </tr>
              <tr>
                <td><label >Store Name</label></td>
                <td><?php if(isset($a)){ echo $received_by_name;} ?></td>
              </tr>
              <tr>
                <td><label >Date</label></td>
                <td><?php if(isset($a)){ echo $received_on;} ?></td>
              </tr>
            </tbody>
          </table>
          </div>
            <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                  <td><label >Data Entered by</label></td>
                  <td><?php if(isset($a)){ echo $reported_by_name;} ?></td>
                </tr>
                <tr>
                  <td><label >Designation</label></td>
                  <td><?php if(isset($a)){ echo $reported_by_desg;} ?></td>
                </tr>
                <tr>
                  <td><label >Store Name</label></td>
                  <td><?php if(isset($a)){ echo $reported_by_name;} ?></td>
                </tr>
                <tr>
                  <td><label >Date</label></td>
                  <td><?php if(isset($a)){ echo $reported_on;} ?></td>
                </tr>
             </tbody>
           </table>
          </div>
         </div>
		 
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
                
              <a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" href="<?php echo base_url(); ?>UC-Demand-Consumption/Edit/<?php echo $this -> uri -> segment (3);?>"><i class="fa fa-pencil-square-o"></i> Update </a>
             
              <a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
        </div>
        


        

    
        
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->