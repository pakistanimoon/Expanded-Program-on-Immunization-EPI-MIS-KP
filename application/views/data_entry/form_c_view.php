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
            <td><?php if(isset($a)){ echo $a -> campaign_type;} ?></td>
            <td><label >From</label></td>
            <td><?php if(isset($a)){ echo $a -> start_date;} ?></td>
            
            <td><label >To</label></td>
            <td><?php if(isset($a)){ echo $a -> end_date;} ?></td>
          </tr>
          <tr>
            <td><label >Province</label></td>
            <td><?php if(isset($a)){ echo "Khyber Pakhtunkhwa";} ?></td>            
            <td><label >District</label></td>
            <td><?php if(isset($a)){ echo get_District_Name($a -> distcode);} ?></td>
            <td><label >Tehsil</label></td>
            <td><?php if(isset($a)){ echo get_Tehsil_Name($a -> tcode);} ?></td>
          </tr>
          <tr>

            <td><label >UC</label></td>
            <td><?php if(isset($a)){ echo get_UC_Name($a -> uncode);} ?></td>
                        
          </tr>
      </table>
         




        <table class="table table-bordered table-condensed table-striped table-hover mytable">
          <thead>
            <tr>
              <th rowspan="3">Product</th>
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
          <tbody>
            <tr>
              <td>mOPV1</td>
              <td>20</td>
              <td><?php if(isset($a)){ echo $a -> dcr_r1_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r1_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r1_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r1_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r1_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r1_f6;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r1_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r1_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r1_f9;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r1_f10;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r1_f11;} ?></td>
            </tr>
            <tr>
              <td>bOPV</td>
              <td>20</td>
              <td><?php if(isset($a)){ echo $a -> dcr_r2_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r2_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r2_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r2_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r2_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r2_f6;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r2_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r2_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r2_f9;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r2_f10;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r2_f11;} ?></td>
            </tr>
            <!--<tr>
              <td>tOPV</td>
              <td>20</td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f6;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f9;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f10;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f11;} ?></td>
            </tr>-->
            <tr>
              <td>Measles</td>
              <td>10</td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f6;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f9;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f10;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r3_f11;} ?></td>
            </tr>
            <tr>
              <td>DIL Measles</td>
              <td style="padding-top:11px;background-color:#eee;"></td>
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>  
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>  
              <td><?php if(isset($a)){ echo $a -> dcr_r4_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r4_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r4_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r4_f6;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r4_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r4_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r4_f9;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r4_f10;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r4_f11;} ?></td>
            </tr>
            <tr>
              <td>TT</td>
              <td>20</td>
              <td><?php if(isset($a)){ echo $a -> dcr_r5_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r5_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r5_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r5_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r5_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r5_f6;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r5_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r5_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r5_f9;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r5_f10;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r5_f11;} ?></td>
            </tr>
            <tr>
              <td>AD Syringes 0.5 ml</td>
              <td style="padding-top:11px;background-color:#eee;"></td>
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>  
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td> 
              <td><?php if(isset($a)){ echo $a -> dcr_r6_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r6_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r6_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r6_f6;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r6_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r6_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r6_f9;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r6_f10;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r6_f11;} ?></td>
            </tr>
            <tr>
              <td>Recon. Syringes 5 ml</td>
              <td style="background-color:#eee;"></td>
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>  
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td> 
              <td><?php if(isset($a)){ echo $a -> dcr_r7_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r7_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r7_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r7_f6;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r7_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r7_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r7_f9;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r7_f10;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r7_f11;} ?></td>
            </tr>
            <tr>
              <td>Safety Boxes</td>
              <td style="padding-top:11px;background-color:#eee;"></td>
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>  
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td> 
              <td><?php if(isset($a)){ echo $a -> dcr_r8_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r8_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r8_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r8_f6;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r8_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r8_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r8_f9;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r8_f10;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r8_f11;} ?></td>
            </tr>
            <tr>
              <td>Other</td>
              <td><?php if(isset($a)){ echo $a -> othername;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r9_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r9_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r9_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r9_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r9_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r9_f6;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r9_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r9_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r9_f9;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r9_f10;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r9_f11;} ?></td>
            </tr>
            <!-- <tr>
              <td>Other</td>
              <td><?php if(isset($a)){ echo $a -> othername;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r10_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r10_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r10_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r10_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r10_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r10_f6;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r10_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r10_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r10_f9;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r10_f10;} ?></td>
              <td><?php if(isset($a)){ echo $a -> dcr_r10_f11;} ?></td>
            </tr> -->

          </tbody>
        </table>

        <div class="row">
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label >Requested by</label></td>
                <td><?php if(isset($a)){ echo $a -> requested_by_name;} ?></td>
              </tr>
              <tr>
                <td><label >Designation</label></td>
                <td><?php if(isset($a)){ echo $a -> requested_by_desg;} ?></td>
              </tr>
              <tr>
                <td><label >Store Name</label></td>
                <td><?php if(isset($a)){ echo $a -> requested_by_store;} ?></td>
              </tr>
              <tr>
                <td><label >Date</label></td>
                <td><?php if(isset($a)){ echo $a -> requested_on;} ?></td>
              </tr>
            </tbody>
          </table>
          </div>
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label >Received by</label></td>
                <td><?php if(isset($a)){ echo $a -> received_by_name;} ?></td>
              </tr>
              <tr>
                <td><label >Designation</label></td>
                <td><?php if(isset($a)){ echo $a -> received_by_desg;} ?></td>
              </tr>
              <tr>
                <td><label >Store Name</label></td>
                <td><?php if(isset($a)){ echo $a -> received_by_name;} ?></td>
              </tr>
              <tr>
                <td><label >Date</label></td>
                <td><?php if(isset($a)){ echo $a -> received_on;} ?></td>
              </tr>
            </tbody>
          </table>
          </div>
            <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                  <td><label >Data Entered by</label></td>
                  <td><?php if(isset($a)){ echo $a -> reported_by_name;} ?></td>
                </tr>
                <tr>
                  <td><label >Designation</label></td>
                  <td><?php if(isset($a)){ echo $a -> reported_by_desg;} ?></td>
                </tr>
                <tr>
                  <td><label >Store Name</label></td>
                  <td><?php if(isset($a)){ echo $a -> reported_by_name;} ?></td>
                </tr>
                <tr>
                  <td><label >Date</label></td>
                  <td><?php if(isset($a)){ echo $a -> reported_on;} ?></td>
                </tr>
             </tbody>
           </table>
          </div>
         </div>
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
                
              <a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" href="<?php echo base_url(); ?>UC-Demand-Consumption/Edit/<?php echo $a->uncode; ?>/<?php echo $a->id; ?>"><i class="fa fa-pencil-square-o"></i> Update </a>
             
              <a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
        </div>
        


        

    
        
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->