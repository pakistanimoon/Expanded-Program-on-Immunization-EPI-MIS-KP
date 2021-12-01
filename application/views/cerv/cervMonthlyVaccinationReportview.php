<?php   
//print_r($data);exit;

?>
<div class="container bodycontainer">  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Facility Monthly Vaccination Reporting Form</div>
     <div class="panel-body">
      <form class="form-horizontal">
        <table class="table table-bordered   table-striped table-hover mytable4">
          <tbody>
          <tr>
		 
            
            <td style="text-align:left;"><label>Year - Month</label></td>
            <td>
              <?php if(isset($data)){
                echo '<p>'.$data['monthfrom'].'</p>';
              } ?>
            </td>
            <td style="text-align:left;"><label>District</label></td>
            <td>
              <p>
                <?php 
                  if(isset($data['distcode'])){
                    echo get_District_Name($data['distcode']);
                  }
                ?>
            </p>
            </td>
          </tr>
          <tr>
            <td style="text-align:left;"><label>Tehsil</label></td>
            <td><p>
            <?php 
              if(isset($data['tcode'])){
                echo get_Tehsil_Name($data["tcode"]);
              }
            ?> 
            </p></td>
            <td style="text-align:left;"><label>Union Council</label></td>
            <td>
              <p>
              <?php 
                if(isset($data['uncode'])){
                  echo get_UC_Name($data["uncode"]);
                }
              ?>
            </p>
            </td>
            
          </tr>
         
        
      </tbody>
    </table>
    
  
  <div id="parent"> 
			
       <table id="fixTable" class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
							 <tr>
                <th colspan="5"  style="width:45%; border-right:0;">
								<ul class="nav nav-tabs" style="border-bottom:none;">
																
								</ul>
								</th>
								<th colspan="15" style="text-align: left; padding-top: 10px; padding-bottom: 10px;border-left: 0;">A. Childhood Routine Immunization</th>
              </tr>
          </thead>
						<tbody>
							<tr style="padding:0px;">
								<td colspan="20" style="padding:0px;">
									<div class="tab-content">
										
										<div class="tab-pane active" id="tab-1">
													<table class="table table-bordered table-condensed table-striped table-hover mytable3" >
														<thead class="trans">
														              <tr>
                <th rowspan="2">Vaccination by</th>
                <th rowspan="2">Vaccination<br>Given to<br>Children</th>
                <th colspan="18">Vaccines</th>
              </tr>
              <tr>
                <th>&nbsp;&nbsp;BCG&nbsp;&nbsp;</th>
                <th>Hep B-Birth</th>
                <th>OPV-0</th>
                <th>OPV-1</th>
                <th>OPV-2</th>
                <th>OPV-3</th>
                <th>PENTA<br>-1</th>
                <th>PENTA<br>-2</th>
                <th>PENTA<br>-3</th>
                <th>PCV10<br>-1</th>
                <th>PCV10<br>-2</th>
                <th>PCV10<br>-3</th>
                <th>&nbsp;&nbsp;IPV&nbsp;&nbsp;</th>
                <th>Rota-1</th>
                <th>Rota-2</th>
                <th>Measles<br>-1</th>
                <th>Measles<br>-2</th>
              </tr>
														</thead>
														<tbody>
          <?php
    $columnsToDisableArr =  array("14","15","17");
    $individualColumnsToDisableArr = array("cri_r3_f1","cri_r4_f1","cri_r5_f1","cri_r6_f1","cri_r7_f1","cri_r8_f1","cri_r9_f1","cri_r10_f1","cri_r11_f1","cri_r12_f1","cri_r13_f1","cri_r14_f1","cri_r15_f1","cri_r16_f1","cri_r17_f1","cri_r18_f1","cri_r19_f1","cri_r20_f1","cri_r21_f1","cri_r22_f1","cri_r23_f1","cri_r24_f1","cri_r3_f2","cri_r3_f3","cri_r4_f2","cri_r4_f3",
    "cri_r5_f2","cri_r5_f3","cri_r6_f2","cri_r6_f3","cri_r9_f2","cri_r10_f2","cri_r11_f2","cri_r12_f2","cri_r15_f2","cri_r16_f2","cri_r17_f2","cri_r18_f2","cri_r21_f2","cri_r22_f2","cri_r23_f2","cri_r24_f2","cri_r9_f3","cri_r10_f3","cri_r11_f3","cri_r12_f3","cri_r15_f3","cri_r16_f3","cri_r17_f3","cri_r18_f3","cri_r21_f3","cri_r22_f3","cri_r23_f3","cri_r24_f3","cri_r5_f10",
    "cri_r6_f10","cri_r11_f10","cri_r12_f10","cri_r17_f10","cri_r18_f10","cri_r23_f10","cri_r24_f10","cri_r5_f11","cri_r6_f11","cri_r11_f11","cri_r12_f11","cri_r17_f11","cri_r18_f11","cri_r23_f11","cri_r24_f11","cri_r5_f12","cri_r6_f12","cri_r11_f12","cri_r12_f12","cri_r17_f12","cri_r18_f12","cri_r23_f12","cri_r24_f12","cri_r3_f13","cri_r4_f13","cri_r5_f13","cri_r6_f13",
    "cri_r9_f13","cri_r10_f13","cri_r11_f13","cri_r12_f13","cri_r15_f13","cri_r16_f13","cri_r17_f13","cri_r18_f13","cri_r21_f13","cri_r22_f13","cri_r23_f13","cri_r24_f13","cri_r7_f16","cri_r8_f16","cri_r19_f16","cri_r20_f16","cri_r21_f16","cri_r22_f16","cri_r23_f16","cri_r24_f16","cri_r1_f18","cri_r2_f18","cri_r7_f18","cri_r8_f18","cri_r13_f18","cri_r14_f18","cri_r19_f18",
    "cri_r20_f18","cri_r21_f18","cri_r22_f18","cri_r23_f18","cri_r24_f18");
    $mainHeadingArr = array("Vaccinator (Fixed)","Vaccinator (Outreach)","Vaccinator (Mobile)","Health House (LHW)");
    $otherHeadingsArr = array("0-11 Months","12-23 Months","2 Years and Above");
    $vaccineArray = array('bcg','hepb','opv0','opv1','opv2','opv3','penta1','penta2','penta3','pcv1','pcv2','pcv3','ipv','rota1','rota2','measles1','measles2');
	$row = 1;
      for($main=1;$main<=4;$main++){ 
      ?>
            <tr>
              <td><label style="padding-top: 66px;"><?php echo $mainHeadingArr[$main-1]; ?></label></td>
              <td style="padding-left: 0px; padding-right: 0px;">
               <?php for($ind=0;$ind < 3;$ind++){ ?>
                <table class="table table-condensed table-bordered" style="width: 100%;margin-bottom: -5px;margin-top: -6px;">
                  <tbody>
                    <tr>
                      <td><label style="font-weight:600;"><?php echo $otherHeadingsArr[$ind]; ?></label></td>
                      <td style="padding: 0px;width:30%;">
                        <table class="table table-condensed table-striped table-bordered" style="width:100%;margin-bottom:-1px;margin-top: 3px;">
                          <tbody>
                            <tr>
                              <td><label style="margin-bottom: 0px;">M</label></td>
                            </tr>
                            <tr>
                              <td><label style="margin-bottom: 0px;">F</label></td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <?php } ?>
              </td>
              <?php
        for($col=1;$col<=17;$col++){
          if($main == 2)
            $row = 7;
          else if($main == 3)
            $row = 13;
          else if($main == 4)
            $row = 19;
          else
            $row = 1;
           ?>
              <td style="padding-left: 0px; padding-right: 0px;">
                <table class="table table-striped table-condensed" style="width: 100%;margin-bottom: -1px;margin-top: -5px;">
                  <tbody>
                  <?php for($row;$row<=24;$row++){ 
					$gender = ($row%2==0)?'f':'m';
					if(in_array($row,array(1,2,7,8,13,14,19,20))){
						$interval = '11 months';
					}else if(in_array($row,array(3,4,9,10,15,16,21,22))){
						$interval = '23 months';
					}else if(in_array($row,array(5,6,11,12,17,18,23,24))){
						$interval = '2 years';
					} 
				  ?>
                    <tr>
                      <td  style="text-align:center;"  <?php  $var="cri_r".$row."_f".$col; echo (in_array($var,$individualColumnsToDisableArr) || in_array($col,$columnsToDisableArr))?'readonly="readonly"':''; ?> ><?php echo getvaccinereport($vaccineArray[$col-1],$interval,$gender,$data); ?></td>
                    </tr>
                    <?php
                    if($row%6==0){
                      break;
                    }
                    ?>
                  <?php   } ?>
                   
                  </tbody>
                </table>
              </td>   
          <?php   } ?>
            </tr>
        <?php } ?>   
            <tr>
              <td><label style="padding-top: 8px;">Total Children Vaccinated</label></td>
              <td style="padding-left: 0px; padding-right: 0px;">
                <table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -6px;">
                  <tbody>
                    <tr>
                       
                      <td style="padding: 0px;">
                        <table class="table table-condensed table-striped table-bordered" style="width:100%;margin-bottom:-1px;">
                          <tbody>
                            <tr>
                              <td><label style="margin-bottom: 0px;font-weight:600;">Male</label></td>
                            </tr>
                            <tr>
                              <td><label style="padding: 3px;font-weight:600;">Female</label></td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <?php for($col=1;$col<=17;$col++){ ?>
              <td style="padding-left: 0px; padding-right: 0px;">
                <table class="table table-striped table-condensed" style="width: 100%;margin-bottom: -1px;margin-top: -5px;">
                  <tbody>
                    <?php  for($row=25;$row<=26;$row++){ ?>
                      <tr>
                        <td style="text-align:center;"  <?php $var="cri_r".$row."_f".$col; ?> > <?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></td>
                      </tr>
                    <?php } ?> 
                  </tbody>
                </table>
              </td>
              <?php } ?>
            </tr>
          </tbody>
				</table>
			</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
	</div>




        <table class="table table-bordered table-condensed table-striped table-hover mytable3 mytable4">
        <thead>
              <tr>
                <th colspan="3" style="border-right:0;">
									<ul class="nav nav-tabs" style="border-bottom:none;">
																		
									</ul>
								</th>
								<th colspan="6" style="text-align: left; padding-top: 10px; padding-bottom: 10px; border-left:0;">B. TT Routine Immunization</th>
              </tr>
          </thead>
          <tbody>
						<tr>
							<td colspan="9" style="padding:0px;">
								<div class="tab-content">
									 <div class="tab-pane active in" id="tab-4">
											<table class="table table-bordered table-condensed table-striped table-hover mytable3">
												<thead class="trans">
													    <tr>
                <th rowspan="2">Vaccination by</th>
                <th rowspan="2" style="min-width: 230px;">Vaccination Given to Children</th>
                <th colspan="6">Vaccines</th>
              </tr>
              <tr>
                <th>TT-1</th>
                <th>TT-2</th>
                <th>TT-3</th>
                <th>TT-4</th>
                <th>TT-5</th>
                <th>Children Protected<br>at Birth</th>
              </tr>
												</thead>
												<tbody>
										 
          <?php
            $mainHeadingArr = array("Fixed","Outreach","Mobile","Health House (LHW)","Total Vaccinated");
            $Nrow = 1;
            for($main=1;$main<=5;$main++){ 
          ?>
            <tr>
              <td><label style="padding-top: 30px;"><?php echo $mainHeadingArr[$main-1]; ?></label></td>
              <td style="padding-left: 0px; padding-right: 0px;padding-bottom: 0px;">
                <table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -5px;">
                  <tbody>
                    <tr><td style="text-align: left;"><label style="padding-top: 9px;">Pregnant Women</label></td></tr>
                    <tr><td style="text-align: left;"><label style="padding-top: 9px;">Non-Pregnant Women (15-49 Years)</label></td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <?php
              for($col=1;$col<=6;$col++){
                if($main == 2)
                  $Nrow = 3;
                else if($main == 3)
                  $Nrow = 5;
                else if($main == 4)
                  $Nrow = 7;
                else if($main == 5)
                  $Nrow = 9;
                else
                  $Nrow = 1;
              ?>
              <td style="padding-left: 0px; padding-right: 0px;padding-bottom: 0px;">
                <table class="table table-condensed" style="width: 100%;margin-bottom: 0px;margin-top: -5px;">
                  <tbody>
                  <?php 
                    for($Nrow;$Nrow<=10;$Nrow++){ ?>
                    <tr>
                      <td style="padding:12px; text-align:center;" <?php $var="ttri_r".$Nrow."_f".$col; ?> ><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></td>
                    </tr>
                    <?php
                      if($Nrow%2==0){
                        break;
                      }
                      ?>
                  <?php } ?>                        
                  </tbody>
                </table>
              </td>
            <?php } ?>
            </tr>
          <?php }  ?> 
          </tbody>
											</table>
									</div>
									 <div class="tab-pane" id="tab-5">
																	<table class="table table-bordered table-condensed table-striped table-hover mytable3">
												<thead class="trans">
													    <tr>
                <th rowspan="2">Vaccination by</th>
                <th rowspan="2" style="min-width: 230px;">Vaccination Given to Children</th>
                <th colspan="6">Vaccines</th>
              </tr>
              <tr>
                <th>TT-1</th>
                <th>TT-2</th>
                <th>TT-3</th>
                <th>TT-4</th>
                <th>TT-5</th>
                <th>Children Protected<br>at Birth</th>
              </tr>
												</thead>
												<tbody>
										 
          <?php
            $mainHeadingArr = array("Fixed ","Outreach","Mobile","Health House (LHW)","Total Vaccinated");
            $Nrow = 1;
            for($main=1;$main<=5;$main++){ 
          ?>
            <tr>
              <td><label style="padding-top: 30px;"><?php echo $mainHeadingArr[$main-1]; ?></label></td>
              <td style="padding-left: 0px; padding-right: 0px;padding-bottom: 0px;">
                <table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -5px;">
                  <tbody>
                    <tr><td style="text-align: left;"><label style="padding-top: 9px;">Pregnant Women</label></td></tr>
                    <tr><td style="text-align: left;"><label style="padding-top: 9px;">Non-Pregnant Women (15-49 Years)</label></td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <?php
              for($col=1;$col<=6;$col++){
                if($main == 2)
                  $Nrow = 3;
                else if($main == 3)
                  $Nrow = 5;
                else if($main == 4)
                  $Nrow = 7;
                else if($main == 5)
                  $Nrow = 9;
                else
                  $Nrow = 1;
              ?>
              <td style="padding-left: 0px; padding-right: 0px;padding-bottom: 0px;">
                <table class="table table-condensed" style="width: 100%;margin-bottom: 0px;margin-top: -5px;">
                  <tbody>
                  <?php 
                    for($Nrow;$Nrow<=10;$Nrow++){ ?>
                    <tr>
                      <td style="padding:12px; text-align:center;" <?php $var="ttoui_r".$Nrow."_f".$col; ?> ><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></td>
                    </tr>
                    <?php
                      if($Nrow%2==0){
                        break;
                      }
                      ?>
                  <?php } ?>                        
                  </tbody>
                </table>
              </td>
            <?php } ?>
            </tr>
          <?php }  ?> 
          </tbody>
		  </table>
									</div>
									
			<div class="tab-pane" id="tab-6">
																	<table class="table table-bordered table-condensed table-striped table-hover mytable3">
												<thead class="trans">
													    <tr>
                <th rowspan="2">Vaccination by</th>
                <th rowspan="2" style="min-width: 230px;">Vaccination Given to Children</th>
                <th colspan="6">Vaccines</th>
              </tr>
              <tr>
                <th>TT-1</th>
                <th>TT-2</th>
                <th>TT-3</th>
                <th>TT-4</th>
                <th>TT-5</th>
                <th>Children Protected<br>at Birth</th>
              </tr>
												</thead>
												<tbody>
										 
          <?php
            $mainHeadingArr = array("Fixed","Outreach","Mobile","Health House (LHW)","Total Vaccinated");
            $Nrow = 1;
            for($main=1;$main<=5;$main++){ 
          ?>
            <tr>
              <td><label style="padding-top: 30px;"><?php echo $mainHeadingArr[$main-1]; ?></label></td>
              <td style="padding-left: 0px; padding-right: 0px;padding-bottom: 0px;">
                <table class="table table-condensed table-bordered" style="width: 100%; margin-bottom: -6px; margin-top: -5px;">
                  <tbody>
                    <tr><td style="text-align: left;"><label style="padding-top: 9px;">Pregnant Women</label></td></tr>
                    <tr><td style="text-align: left;"><label style="padding-top: 9px;">Non-Pregnant Women (15-49 Years)</label></td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <?php
              for($col=1;$col<=6;$col++){
                if($main == 2)
                  $Nrow = 3;
                else if($main == 3)
                  $Nrow = 5;
                else if($main == 4)
                  $Nrow = 7;
                else if($main == 5)
                  $Nrow = 9;
                else
                  $Nrow = 1;
              ?>
              <td style="padding-left: 0px; padding-right: 0px;padding-bottom: 0px;">
                <table class="table table-condensed" style="width: 100%;margin-bottom: 0px;margin-top: -5px;">
                  <tbody>
                  <?php 
                    for($Nrow;$Nrow<=10;$Nrow++){ ?>
                    <tr>
                      <td style="padding:12px; text-align:center;" <?php $var="ttod_r".$Nrow."_f".$col; ?> ><?php echo (isset($fmvrf_info_od))? $fmvrf_info_od[$var]:'0'; ?></td>
                    </tr>
                    <?php
                      if($Nrow%2==0){
                        break;
                      }
                      ?>
                  <?php } ?>
                  </tbody>
                </table>
              </td>
            <?php } ?>
            </tr>
          <?php }  ?> 
          </tbody>
		  </table>
									</div>
									
								</div>
							</td>
						</tr>
					</tbody>
		  </table>
									</div>
									
								</div>
							</td>
						</tr>
					</tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <tbody>
            <tr>
              <td><label>Name of Vaccinator</label></td>
              <td><p><?php echo isset($fmvrf_info)?$fmvrf_info["vacc_name"]:"";?></p></td>
              <td><label>Name of LHS</label></td> 
              <td><p><?php echo isset($fmvrf_info)?$fmvrf_info["lhsname"]:"";?></p></td>
              <td><label>Name of Facility Incharge</label></td>
              <td><p><?php echo isset($fmvrf_info)?$fmvrf_info["incharge_name"]:"";?></p></td>
            </tr>
          </tbody>
        </table>
         
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--end of body container-->