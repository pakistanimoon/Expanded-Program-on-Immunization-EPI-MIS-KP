<!--start of page content or body-->
<div class="container bodycontainer">  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Vaccine Carriers, Ccold Boxes & Ice Packs</div>
     <div class="panel-body">
       <form class="form-horizontal">
        <table class="table table-bordered   table-striped table-hover  2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Administrative levels and EPI facility identification</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label>1. Province</label></td>
              <td>Kyber Pakhtunkhwa</td>
              <td><label>2. District</label></td> 
              <td><?php echo get_District_Name($gdata->distcode); ?></td>    
            </tr>
            <tr>
              <td><label>3. Tehsil</label></td>
              <td><?php echo (isset($gdata->tcode) && $gdata->tcode>0)?get_Tehsil_Name($gdata->tcode):''; ?></td>
              <td><label>4. Union Council</label></td>
              <td><?php echo get_UC_Name($gdata->uncode); ?></td>
            </tr>
            <tr>
              <td><label>5. Name of (health) facility</label></td>
              <td><?php echo get_Facility_Name($gdata->facode); ?></td>
            </tr>
            <tr>
				<td><label>6. Year</label></td>
				<td> <?php if(isset($gdata->year)) { echo $gdata->year;} ?> </td>
				<td><label>7. Quarter</label></td>
				<td> <?php if(isset($gdata->quarter)) { echo $gdata->quarter;} ?> </td>
			</tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover  2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Vaccine cold box and carrier information </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="4">
                <label>6. Quantities of vaccine cold boxes and carriers</label><br>Fill in a separate line for each model of cold box and vaccine carrier found at health facility, using the Catalogue ID referenced for each model in the Equipment Identification Booklet and always starts with the letter E.
              </td>
            </tr>                           
          </tbody>
        </table>
        <table class="table table-bordered table-condensed table-striped table-hover " style="margin-top: -21px;">
          <thead>
		  <tr>

              <th rowspan="2">Catalogue ID</th>
              <th rowspan="2">Cold Box / Vaccine Carrie</th>
              <th rowspan="2">Total available for vaccination activities</th>
              <th rowspan="2">Quantity not working</th>
              <th colspan="3">Internal Dimensions Leave blank if found in Catalogue and ID written in Column 1</th>
              <th rowspan="2" colspan="7">Equipment Code Code is needed on all Cold Boxes and Standard Vaccine Carriers NOT for Rotary Vaccine Carriers</th>             
            </tr>
            <tr>
              <th>Length (cm)</th>
              <th>Width (cm)</th>
              <th>Height (cm)</th>
            </tr>             
          </thead>
          <tbody>
		  <?php
				foreach($gdataDetail as $key => $val){
			?>
           <tr>
              <td><?php echo $val['catalogue_id']; ?></td>
              <td><?php echo $val['cb_vc']; ?></td>
              <td><?php echo $val['tot_vacc']; ?></td>
              <td><?php echo $val['quntt_not_working']; ?></td>
              <td><?php echo $val['dimension_length']; ?></td>
              <td><?php echo $val['dimension_width']; ?></td>
              <td><?php echo $val['dimension_height']; ?></td>
              <td><?php echo $val['eq_code_r1_f1']; ?></td>
              <td>&#8212;</td>
              <td><?php echo $val['eq_code_r1_f2']; ?></td>
              <td><?php echo $val['eq_code_r1_f3']; ?></td>
              <td><?php echo $val['eq_code_r1_f4']; ?></td>
              <td>&#8212;</td>
              <td><?php echo $val['eq_code_r1_f5']; ?></td>
            </tr>
				<?php } ?>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover  2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Ice pack information </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="4">
                <label>7. Quantity of standard ice packs in good condition
                </label>
              </td>
            </tr>                           
          </tbody>
        </table>
        <table class="table table-bordered table-condensed table-striped table-hover " style="margin-top: -21px;">
          <tbody>
		  <?php $labels = array(

							'Ice pack size in Litters',
							'Quantity'
						);

						for($i=1; $i<=count($labels); $i++){ ?>
            <tr>
              <td><label><?php echo $labels[$i-1]; ?></label></td>
              <td><?php $var ='ii_r'.$i.'_f1'; echo isset($gdata)?$gdata->$var:''; ?></td>
              <td><?php $var ='ii_r'.$i.'_f2'; echo isset($gdata)?$gdata->$var:''; ?></td>
              <td><?php $var ='ii_r'.$i.'_f3'; echo isset($gdata)?$gdata->$var:''; ?></td>
              <td><?php $var ='ii_r'.$i.'_f4'; echo isset($gdata)?$gdata->$var:''; ?></td>
              <td><?php $var ='ii_r'.$i.'_f5'; echo isset($gdata)?$gdata->$var:''; ?></td>
              <td><?php $var ='ii_r'.$i.'_f6'; echo isset($gdata)?$gdata->$var:''; ?></td>
              <td><?php $var ='ii_r'.$i.'_f7'; echo isset($gdata)?$gdata->$var:''; ?></td>
              <td><?php $var ='ii_r'.$i.'_f8'; echo isset($gdata)?$gdata->$var:''; ?></td>
              <td><?php $var ='ii_r'.$i.'_f9'; echo isset($gdata)?$gdata->$var:''; ?></td>
              <td><?php $var ='ii_r'.$i.'_f10'; echo isset($gdata)?$gdata->$var:''; ?></td>
              <td><?php $var ='ii_r'.$i.'_f11'; echo isset($gdata)?$gdata->$var:''; ?></td>
            </tr>
						<?php }?>
           </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Person responsible for cold chain at the facility</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><?php echo $gdata->pr_name ?></td>
                      <td><label>Designation</label></td>
                      <td><?php echo $gdata->pr_desg ?></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><?php echo $gdata->pr_mob ?></td>
                      <td><label>Email</label></td>
                      <td><?php echo $gdata->pr_email ?></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    2">
                  <thead>
                    <tr>
                      <th colspan="6" style="text-align:center;">Cold Chain Inventory team leader's information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><?php echo $gdata->cc_name ?></td>
                      <td><label>Mobile number</label></td>
                      <td><?php echo $gdata->cc_mob ?></td>  
                      <td><label>Date</label></td>
                      <td><?php echo date('d-m-Y',strtotime($gdata->date_submitted)); ?></td>   
                    </tr>
                  </tbody>
                </table>
                <div class="row">
                  <hr>
                  <div style="text-align: right;" class="col-md-4 col-md-offset-8">
				<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>                   
				   <a href="<?php echo base_url(); ?>Vaccine-Carriers/Edit/<?php echo $gdata->id; ?>" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md" ><i class="fa fa-pencil-square-o"></i> Update </a>
                <?php } ?>    
					<a href="<?php echo base_url(); ?>Vaccine-Carriers/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
                  </div>
                </div>                 
		</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->