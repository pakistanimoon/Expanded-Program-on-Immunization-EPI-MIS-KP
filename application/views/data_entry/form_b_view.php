<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading">HF Consumption and Requisition Form</div>
     <div class="panel-body">
       <form class="form-horizontal">
        <table class="table table-bordered   table-striped table-hover  mytable">
         <tr>
            <td><label>Province</label></td>
            <td><?php echo $this -> session -> provincename ?></td>
            <td><label>District</label></td>
            <td><?php if(isset($a)){ echo get_District_Name($a -> distcode);} ?></td>
            <td><label>Date (MM/YY)</label></td>
            <td><?php if(isset($a)){ echo monthname($month). " " . $year;} ?></td>
          </tr>
        
          <tr>
           <td><label>Tehsil/Taluka</label></td>
            <td><?php if(isset($a)){ echo get_Tehsil_Name($a -> tcode);} ?></td>
            <td><label>UC</label></td>
            <td><?php if(isset($a)){ echo get_UC_Name($a -> uncode);} ?></td>
            <td><label>Health Facility/Store</label></td>
            <td><?php if(isset($a)){ echo get_Facility_Name($a -> facode);} ?></td>
          </tr>
         
      </table>

        <table class="table table-bordered table-condensed table-striped table-hover mytable" style=" text-align-last: center; ">
          <thead>
            <tr>
               
              <th  rowspan="2" style="width: 13%;">Products</th>
              <th  rowspan="2">Doses per Vial</th>
              <th>Opening Balance</th>
              <th>Received</th>
              <th>Children Vaccinated/<br>Doses Administered</th>
              <th>Vials<br>Used</th>
              <th>Unusable<br>Vials</th>
              <th>Closing<br>Balance</th>
              <!--<th>Max. Stock Level</th>
              <th>Request<br>(I=H-G)</th>
              <th>Replenishment</th>-->
            </tr>
            <tr>
              <th>Doses/Nos.</th>
              <th>Doses/Nos.</th>
              <th>Doses/Nos.</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
              <!--<th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>-->
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
             <!-- <th>H</th>
              <th>I</th>
              <th>J</th> -->
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>BCG</td>
              <td>20</td>
              <td><?php if(isset($a)){ echo $a -> cr_r1_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r1_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r1_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r1_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r1_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r1_f6;} ?></td>
              <!--<td><?php if(isset($a)){ echo $a -> cr_r1_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r1_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r1_f9;} ?></td>-->
            </tr>
            <tr>
              <td>DIL BCG</td>
              <td style="background-color:#eee;"></td>
              <td><?php if(isset($a)){ echo $a -> cr_r2_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r2_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r2_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r2_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r2_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r2_f6;} ?></td>
             <!-- <td><?php if(isset($a)){ echo $a -> cr_r2_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r2_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r2_f9;} ?></td>-->
            </tr>
            <tr>
              <td>bOPV</td>
              <td>20</td>
              <td><?php if(isset($a)){ echo $a -> cr_r3_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r3_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r3_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r3_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r3_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r3_f6;} ?></td>
             <!-- <td><?php if(isset($a)){ echo $a -> cr_r3_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r3_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r3_f9;} ?></td>-->
            </tr>
            <tr>
              <td>Pentavalent</td>
              <td>01</td>
              <td><?php if(isset($a)){ echo $a -> cr_r4_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r4_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r4_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r4_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r4_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r4_f6;} ?></td>
             <!-- <td><?php if(isset($a)){ echo $a -> cr_r4_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r4_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r4_f9;} ?></td>-->
            </tr>
            <tr>
              <td>Pneumococcal (PCV 10)</td>
              <td>02</td>
              <td><?php if(isset($a)){ echo $a -> cr_r5_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r5_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r5_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r5_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r5_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r5_f6;} ?></td>
            <!--  <td><?php if(isset($a)){ echo $a -> cr_r5_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r5_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r5_f9;} ?></td>-->
            </tr>
            <tr>
              <td>Measles</td>
              <td>10</td>
              <td><?php if(isset($a)){ echo $a -> cr_r6_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r6_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r6_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r6_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r6_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r6_f6;} ?></td>
             <!-- <td><?php if(isset($a)){ echo $a -> cr_r6_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r6_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r6_f9;} ?></td>-->
            </tr>
            <tr>
              <td>DIL Measles</td>
              <td style="background-color:#eee;"></td>
              <td><?php if(isset($a)){ echo $a -> cr_r7_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r7_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r7_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r7_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r7_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r7_f6;} ?></td>
             <!-- <td><?php if(isset($a)){ echo $a -> cr_r7_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r7_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r7_f9;} ?></td>-->
            </tr>
            <tr>
              <td>TT</td>
              <td>10</td>
              <td><?php if(isset($a)){ echo $a -> cr_r8_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r8_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r8_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r8_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r8_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r8_f6;} ?></td>
            <!--  <td><?php if(isset($a)){ echo $a -> cr_r8_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r8_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r8_f9;} ?></td> -->
            </tr>
            <tr>
              <td>TT</td>
              <td>20</td>
              <td><?php if(isset($a)){ echo $a -> cr_r9_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r9_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r9_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r9_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r9_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r9_f6;} ?></td>
             <!-- <td><?php if(isset($a)){ echo $a -> cr_r9_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r9_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r9_f9;} ?></td>-->
            </tr>
            <tr>
              <td>HBV (Birth dose)</td>
              <td>10</td>
              <td><?php if(isset($a)){ echo $a -> cr_r10_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r10_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r10_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r10_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r10_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r10_f6;} ?></td>
             <!-- <td><?php if(isset($a)){ echo $a -> cr_r10_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r10_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r10_f9;} ?></td>-->
            </tr>
            <tr>
              <td>IPV</td>
              <td>10</td>
              <td><?php if(isset($a)){ echo $a -> cr_r11_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r11_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r11_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r11_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r11_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r11_f6;} ?></td>
              <!--<td><?php if(isset($a)){ echo $a -> cr_r11_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r11_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r11_f9;} ?></td>-->
            </tr>
			<tr>
              <td>IPV</td>
              <td>05</td>
              <td><?php if(isset($a)){ echo $a -> cr_r19_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r19_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r19_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r19_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r19_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r19_f6;} ?></td>
             <!-- <td><?php if(isset($a)){ echo $a -> cr_r19_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r19_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r19_f9;} ?></td> -->
            </tr>
			 <tr>
              <td>Rota</td>
              <td style="background-color:#eee;"></td>
              <td><?php if(isset($a)){ echo $a -> cr_r18_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r18_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r18_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r18_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r18_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r18_f6;} ?></td>
          <!--    <td><?php if(isset($a)){ echo $a -> cr_r18_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r18_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r18_f9;} ?></td> -->
            </tr>
            <tr>
              <td>AD Syringes 0.5 ml</td>
              <td style="background-color:#eee;"></td>
              <td><?php if(isset($a)){ echo $a -> cr_r12_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r12_f2;} ?></td>
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>      
              <td><?php if(isset($a)){ echo $a -> cr_r12_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r12_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r12_f6;} ?></td>
             <!-- <td><?php if(isset($a)){ echo $a -> cr_r12_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r12_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r12_f9;} ?></td> -->
            </tr>
            <tr>
              <td>AD Syringes 0.05 ml</td>
              <td style="background-color:#eee;"></td>
              <td><?php if(isset($a)){ echo $a -> cr_r13_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r13_f2;} ?></td>
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>      
              <td><?php if(isset($a)){ echo $a -> cr_r13_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r13_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r13_f6;} ?></td>
             <!-- <td><?php if(isset($a)){ echo $a -> cr_r13_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r13_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r13_f9;} ?></td>-->
            </tr>
            <tr>
              <td>Recon. Syringes 2 ml</td>
              <td style="background-color:#eee;"></td>
              <td><?php if(isset($a)){ echo $a -> cr_r14_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r14_f2;} ?></td>
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>      
              <td><?php if(isset($a)){ echo $a -> cr_r14_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r14_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r14_f6;} ?></td>
             <!-- <td><?php if(isset($a)){ echo $a -> cr_r14_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r14_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r14_f9;} ?></td> -->
            </tr>
            <tr>
              <td>Recon. Syringes 5 ml</td>
              <td style="background-color:#eee;"></td>
              <td><?php if(isset($a)){ echo $a -> cr_r15_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r15_f2;} ?></td>
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>      
              <td><?php if(isset($a)){ echo $a -> cr_r15_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r15_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r15_f6;} ?></td>
              <!--<td><?php if(isset($a)){ echo $a -> cr_r15_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r15_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r15_f9;} ?></td>-->
            </tr>
            <tr>
              <td>Safety Boxes</td>
              <td style="background-color:#eee;"></td>
              <td><?php if(isset($a)){ echo $a -> cr_r16_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r16_f2;} ?></td>
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>      
              <td><?php if(isset($a)){ echo $a -> cr_r16_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r16_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r16_f6;} ?></td>
             <!-- <td><?php if(isset($a)){ echo $a -> cr_r16_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r16_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r16_f9;} ?></td> -->
            </tr>
            <tr>
              <td>Other</td>
              <td style="background-color:#eee;"></td>
              <td><?php if(isset($a)){ echo $a -> cr_r17_f1;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r17_f2;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r17_f3;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r17_f4;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r17_f5;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r17_f6;} ?></td>
              <!--<td><?php if(isset($a)){ echo $a -> cr_r17_f7;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r17_f8;} ?></td>
              <td><?php if(isset($a)){ echo $a -> cr_r17_f9;} ?></td> -->
            </tr>
             
          </tbody>
        </table>

        <div class="row">
          <div class="col-sm-12">
            <table class="table table-bordered table-striped">
              <tr>
                <td><label>Prepared by</label></td>
                <td><?php if(isset($a)){ echo $a -> prepare_by;} ?></td>
               
                <td><label>Medical Officer / In-charge Name</label></td>
                <td><?php if(isset($a)){ echo $a -> incharge;} ?></td>
              
                <td><label>Date</label></td>
                <td><?php if(isset($a)){ echo $a -> date_submitted;} ?></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
                
              <a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" href="<?php echo base_url(); ?>HF-Consumption-Requisition/Edit/<?php echo $a->fmonth; ?>/<?php echo $a->facode; ?>"><i class="fa fa-pencil-square-o"></i> Update </a>
             
              <a href="<?php echo base_url(); ?>HF-Consumption-Requisition/List" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
        </div>
        


        

    
        
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->