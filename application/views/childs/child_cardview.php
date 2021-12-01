
<style>
#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 135px;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  height:400px !important;
  width:400px !important;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
@page{
	margin:0mm !important;
}

@media print
{
body * { visibility: hidden; }
#section-to-print * { visibility: visible;}
  #section-to-print { margin:0mm 0mm 0mm 0mm !important;transform: scale(0.9,0.9); margin-top:-20px !important;overflow:hidden !Important;page-break-after:avoid !important;}

  .top-img img{ height:50px !important; width:50px !important;}
  table td.barcode-img img, td.child-img img{
	  height:50px!important; width:50px !important;
  }
  table.info{
	  margin-top:-20px;
  }
}

.img-150{
	height: 150px !important;
	width: 150px !important; 
	padding: 4px !important;
}

</style>
    
  <section id="wrapper">
      <div class="container-fluid">
          <div class="row">
              <div class="col-lg-12">
                  <section id="header">
                      <div class="container">
					  <div id="section-to-print">
                          <div class="row">
                              <div class="col-lg-12">
                                  <table class="table mb-0">
                                      <tbody>
                                         <tr class="light-bg top-img">
                                             <td colspan="3">
                                                 <img  src="<?php echo base_url();?>includes/images/epi.png" alt="">
                                             </td>
                                         </tr>
                                          <tr class="light-bg">
                                              <td class="child-img text-center verticle-middle top-border-none">
												<img id="myImg" src="<?php echo base_url()?>webapis/cerv/assets/childs/<?php echo $childDataview[0]['child_registration_no'];?>.jpg" class="img-150" alt="">
												</td>
											          
                                              <td class="epi-logo text-center verticle-middle top-border-none">
	                                           <!-- <img src="images/logo/epiLogo.png" alt="">-->
                                                  <h6 class="mt-2"><?php echo $childDataview[0]['nameofchild'];?> </br>
												  <span>
												  <?php if($childDataview[0]['gender']=="m")
													echo'S/O';
													
												else
													echo'D/O';
												?>
												  </span></br> <?php echo $childDataview[0]['fathername'];?></h6>  
                                              </td>
                                              <td class="barcode-img  top-border-none text-center verticle-middle"><img src="https://chart.googleapis.com/chart?chs=150x150&amp;cht=qr&amp;chl={&quot;facode&quot;:&quot;<?php echo $childDataview[0]['reg_facode'];?>&quot;,&quot;year&quot;:&quot;<?php echo substr($childDataview[0]['dateofbirth'],0,4);?>&quot;,&quot;cardno&quot;:&quot;<?php echo $childDataview[0]['cardno'];?>&quot;}&amp;choe=UTF-8" alt=""></td>
                                          </tr>
                                      </tbody>
                                  </table>
                                  <table class="table table-bordered info mb-0 text-left">
                                      <tbody>
                                          <tr class="">
                                              <td><label for="district">District/Tehsil/Uc <urdu>ضلع۔ تحصیل ۔ یوسی</urdu></label></td>
                                              <td><span><?php echo $childDataview[0]['district'];?>, <?php echo $childDataview[0]['tehsil'];?>, <?php echo $childDataview[0]['unioncouncil'];?></span></td>
                                          </tr>
                                          <tr>
                                              <td><label for="EPICenter">EPI Center <urdu>ای۔پی۔آئی سنٹر کا نام</urdu></label></td>
                                              <td><span><?php echo $childDataview[0]['facilityname'];?></span></td>
                                          </tr>
                                          <tr>
                                              <td><label for="VaccinatorName">Vaccinator Name <urdu>ٹیکہ لگانے والے کا نام</urdu></label></td>
                                              <td><span><?php echo $childDataview[0]['technicianname'];?></span></td>
                                          </tr>
                                           <tr>
                                              <td><label for="cardNumber#">Card Number <urdu>کارڈ نمبر</urdu></label></td>
                                              <td><span><?php echo $childDataview[0]['cardno'];?></span></td>
                                          </tr>
										  <?php 
										  $bdate = $childDataview[0]['dateofbirth'];
										  ?>
                                          <tr>
                                              <td><label for="DateOfBirth">Date Of Birth</label> <urdu>تاریخ پیدائش</urdu></td>
                                              <td><span><?php echo date("M d, Y", strtotime($bdate));?></span></td>
                                          </tr>
                                          <tr>
                                              <td><label for="Gender">Gender <urdu>جنس</urdu></label></td>
                                              <td class="verticle-middle">
												<span>
												<?php if($childDataview[0]['gender']=="m")
													echo'<i class="fas fa-check text-green"></i> Male <urdu class="display-inline">مرد</urdu>';
													
												else
													echo'<i class="fas fa-check text-green"></i> Female <urdu class="display-inline">عورت</urdu>';
												?>	
												
												</span>
											  </td>
                                          </tr>
                                          <tr>
                                              <td><label for="MotherName">Mother Name <urdu>ماں کا نام</urdu></label></td>
                                              <td><span><?php echo $childDataview[0]['mothername'];?></span></td>
                                          </tr>
                                          <tr>
                                              <td><label for="FatherName">Father/Guardian Name <urdu>والد/سربراہ کا نام</urdu></label></td>
                                              <td><span><?php echo $childDataview[0]['fathername'];?></span></td>
                                          </tr>
                                          <tr>
                                              <td><label for="CNIC">Father/Guardian CNIC <urdu>والد/سربراہ کا شناختی کارڈ نمبر</urdu></label></td>
                                              <td><span><?php echo $childDataview[0]['fathercnic'];?></span></td>
                                          </tr>
                                          <tr>
                                              <td><label for="Contact">Father/Guardian Contact # <urdu>والد/سربراہ کا فون نمبر</urdu></label></td>
                                              <td><span><?php echo $childDataview[0]['contactno'];?></span></td>
                                          </tr>
										  <tr>
                                              <td><label for="Contact">Complete Address<urdu>مکمل پتہ</urdu></label></td>
                                              <td><span><?php echo $childDataview[0]['address'];?> <?php echo $childDataview[0]['villagename'];?>, UC <?php echo $childDataview[0]['unioncouncil']; ?>, Tehsil <?php echo $childDataview[0]['tehsil']; ?>, District <?php echo $childDataview[0]['district'];?></span></td>
                                          </tr>
										  
                                        </tbody>
                                  </table>
                                  <table class="table custom-table-bordered vaccination">
                                      <thead>
                                          <tr>
                                              <th colspan="6">Vaccination Details <urdu>ویکسین کی تفصیل </urdu></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr class="verticle">
                                              <td>Valid Age <urdu class="display-block"> عمر کی منا سبت</urdu></td>
                                              <td>Name of Vaccination <urdu class="display-block">ویکسین کا نام</urdu></td>
                                              <td>Vaccination Date <urdu class="display-block">ویکسین لگانے کی تاریخ</urdu></td>
                                              <td>STC/PRT/MOB <urdu class="display-block"> ویکسین کا ذریعہ</urdu></td>
                                              <td>Next Vaccination Date <urdu class="display-block">آئندہ ویکسین کی تاریخ</urdu></td>
                                              <td>Vaccination Signature <urdu class="display-block">ویکسین لگانے والے کے دسخط</urdu></td>
                                          </tr>
                                          <tr>
                                              <td rowspan="3" class="bg text-center custom-black-border">At Birth <urdu class="display-block">پیدائش کے فورََا بعد</urdu></td>
                                              <td class="vaccination-td">
                                                  <span>
												  <?php if($childDataview[0]['bcg']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  BCG
												  </span>
                                                     
                                              </td>
											  <?php 
										        $bcgdate = $childDataview[0]['bcg'];
											  ?>
                                              <td><?php if(isset($bcgdate))
											  echo date("M d, Y", strtotime($bcgdate));?></td>
                                              <td>
											  <?php if($childDataview[0]['bcg']!=NULL) {?>
											   <!--<a href="" target="_blank" rel="noopener" onclick="return popitup('http://isbhosp.nhsrc.pk/webapis/testhtml1.php?lat=<?php echo $childDataview[0]['latitude'];?>&long=<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>-->
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											  </td>
                                              <td>
											  <?php if($childDataview[0]['bcg'] == NULL && $childDataview[0]['opv1'] == NULL && $childDataview[0]['opv2'] == NULL && $childDataview[0]['opv3'] == NULL /* && $childDataview[0]['measles1'] == NULL */){
											  echo date("M d, Y", strtotime($bdate));}?>
											  </td>
                                              <td rowspan="3" class="custom-black-border"></td>
                                          </tr>
										  <tr>
											<td class="vaccination-td">
												 <span>
												  <?php if($childDataview[0]['opv0']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  OPV-0</span> 
											</td>
											<?php 
										        $opv0date = $childDataview[0]['opv0'];
										      ?>
											<td><?php if(isset($opv0date))
											echo date("M d, Y", strtotime($opv0date));?></td>
											<td>
											<?php if($childDataview[0]['opv0']!=NULL) {?>
											<a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											<?php }?>
											</td>
											<td>
											<?php if($childDataview[0]['opv0']==NULL && $childDataview[0]['opv1'] == NULL && $childDataview[0]['opv2'] == NULL && $childDataview[0]['opv3'] == NULL /* && $childDataview[0]['measles1'] == NULL */){
											  echo date("M d, Y", strtotime($bdate));}?>
											  </td>
										  </tr>
										   <tr>
											<td class="vaccination-td">
											 <span>
												  <?php if($childDataview[0]['hepb']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  HEP B</span>  
											</td>
											<?php 
										        $hepbdate = $childDataview[0]['hepb'];
										      ?>
											<td><?php if(isset($hepbdate))
											echo date("M d, Y", strtotime($hepbdate));?></td>
											<td>
											<?php if($childDataview[0]['hepb']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											</td>
											<td>
											<?php if($childDataview[0]['hepb']==NULL && $childDataview[0]['opv1'] == NULL && $childDataview[0]['opv2'] == NULL && $childDataview[0]['opv3'] == NULL /* && $childDataview[0]['measles1'] == NULL */){
											  echo date("M d, Y", strtotime($bdate));}?>
											</td>
										  </tr>
                                          <tr>
                                              <td rowspan="4" class="bg text-center custom-black-border">At Six Week <urdu class="display-block">چھ ہفتہ کی عمر میں</urdu></td>
                                              <td class="vaccination-td custom-top-border">
                                                  <span>
												  <?php if($childDataview[0]['opv1']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												   OPV-I</span>
                                              </td>
											  <?php 
										        $opv1date = $childDataview[0]['opv1'];
										      ?>
                                              <td class="custom-top-border" style="white-space:nowrap;<?php echo ($childDataview[0]['opv1'] != NULL && $childDataview[0]['opv1'] < date('Y-m-d', strtotime($childDataview[0]['dateofbirth']. ' + 43 days')))?'color:#FFF;background-color:red':''; ?>">
											  <?php if(isset($opv1date))
											  echo date("M d, Y", strtotime($opv1date));?></td>
                                              <td class="custom-top-border">
											  <?php if($childDataview[0]['opv1']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											  </td>
                                              <td class="custom-top-border">
											  <?php if($childDataview[0]['opv1']==NULL && $childDataview[0]['opv2'] == NULL && $childDataview[0]['opv3'] == NULL /* && $childDataview[0]['measles1'] == NULL */){
											  echo date("M d, Y", strtotime("$bdate +42 days"));}?>
											  </td>
                                              <td rowspan="4" class="custom-black-border"></td>
                                          </tr>
										  <tr>
											<td class="vaccination-td">
												 <span>
												  <?php if($childDataview[0]['rota1']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  Rota-I</span>
											</td>
											<?php 
										        $rota1date = $childDataview[0]['rota1'];
										      ?>
											<td style="white-space:nowrap;<?php echo ($childDataview[0]['rota1'] != NULL && $childDataview[0]['rota1'] < date('Y-m-d', strtotime($childDataview[0]['dateofbirth']. ' + 43 days')))?'color:#FFF;background-color:red':''; ?>" >
											<?php if(isset($rota1date))
											echo date("M d, Y", strtotime($rota1date));?></td>
											<td>
											<?php if($childDataview[0]['rota1']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											</td>
											<td>
											<?php if($childDataview[0]['rota1']==NULL && $childDataview[0]['rota2'] == NULL /* && $childDataview[0]['measles1'] == NULL */){
											  echo date("M d, Y", strtotime("$bdate +42 days"));}?>
											</td>
										  </tr>
										  <tr>
											<td class="vaccination-td">
												 <span>
												  <?php if($childDataview[0]['penta1']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  Penta-I</span>
											</td>
											<?php 
										        $penta1date = $childDataview[0]['penta1'];
										    ?>
											<td style="white-space:nowrap;<?php echo ($childDataview[0]['penta1'] != NULL && $childDataview[0]['penta1'] < date('Y-m-d', strtotime($childDataview[0]['dateofbirth']. ' + 43 days')))?'color:#FFF;background-color:red':''; ?>">
											<?php if(isset($penta1date))
											echo date("M d, Y", strtotime($penta1date));?></td>
											<td>
											<?php if($childDataview[0]['penta1']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											</td>
											<td>
											<?php if($childDataview[0]['penta1']==NULL && $childDataview[0]['penta2'] == NULL && $childDataview[0]['penta3'] == NULL /* && $childDataview[0]['measles1'] == NULL */){
											  echo date("M d, Y", strtotime("$bdate +42 days"));}?>
											</td>
										  </tr>
										  <tr>
											<td class="vaccination-td">
												<span>
												  <?php if($childDataview[0]['pcv1']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  PCV10-I </span> 
											</td>
											<?php 
										        $pcv1date = $childDataview[0]['pcv1'];
										    ?>
											<td style="white-space:nowrap;<?php echo ($childDataview[0]['pcv1'] != NULL && $childDataview[0]['pcv1'] < date('Y-m-d', strtotime($childDataview[0]['dateofbirth']. ' + 43 days')))?'color:#FFF;background-color:red':''; ?>" >
											<?php if(isset($pcv1date))
											echo date("M d, Y", strtotime($pcv1date));?></td>
											<td>
											<?php if($childDataview[0]['pcv1']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											</td>
											<td>
											<?php if($childDataview[0]['pcv1']==NULL && $childDataview[0]['pcv2'] == NULL && $childDataview[0]['pcv3'] == NULL /* && $childDataview[0]['measles1'] == NULL */){
											  echo date("M d, Y", strtotime("$bdate +42 days"));}?>
											</td>
										  </tr>
										  <!-- -->
                                          <tr>
                                              <td rowspan="4" class="bg text-center custom-black-border">At Ten Week <urdu class="display-block">دس ہفتہ کی عمر میں</urdu></td>
                                              <td class="vaccination-td custom-top-border">
                                                  <span>
												  <?php if($childDataview[0]['opv2']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												   OPV-2</span>
                                              </td>
											  <?php 
										        $opv2date = $childDataview[0]['opv2'];
										      ?>
                                              <td class="custom-top-border" style="white-space:nowrap;<?php echo ($childDataview[0]['opv1'] != NULL && $childDataview[0]['opv2'] != NULL && $childDataview[0]['opv2'] < date('Y-m-d', strtotime($childDataview[0]['opv1']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>">
											  <?php if(isset($opv2date))
											  echo date("M d, Y", strtotime($opv2date));?></td>
                                              <td class="custom-top-border">
											  <?php if($childDataview[0]['opv2']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											   <!--<a href="<?php echo base_url(); ?>" onclick="return popitup(<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?><?php echo $childDataview[0]['longitude'];?>)"><?php echo $childDataview[0]['facilityname'];?></a>-->
											  <?php }?>
											  </td>
												<td class="custom-top-border">
													<?php 
													if($childDataview[0]['opv2']==NULL && $childDataview[0]['opv3'] == NULL /* && $childDataview[0]['measles1'] == NULL */){
														if($childDataview[0]['opv1'] == NULL){}else{
															echo date("M d, Y", strtotime("{$childDataview[0]['opv1']} +29 days"));
														}
													}
													?>
												</td>
                                              <td rowspan="4" class="custom-black-border"></td>
                                          </tr>
										  <tr>
											<td class="vaccination-td">
												 <span>
												   <?php if($childDataview[0]['rota2']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												   Rota-2</span>  
											</td>
											<?php 
										        $rota2date = $childDataview[0]['rota2'];
										      ?>
											<td style="white-space:nowrap;<?php echo ($childDataview[0]['rota1'] != NULL && $childDataview[0]['rota2'] != NULL && $childDataview[0]['rota2'] < date('Y-m-d', strtotime($childDataview[0]['rota1']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>" >
											<?php if(isset($rota2date)) 
											echo date("M d, Y", strtotime($rota2date));?></td>
											<td>
											<?php if($childDataview[0]['rota2']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											</td>
											<td class="custom-top-border">
												<?php 
												if($childDataview[0]['rota2']==NULL /* && $childDataview[0]['measles1'] == NULL */){
													if($childDataview[0]['rota1'] == NULL){}else{
														echo date("M d, Y", strtotime("{$childDataview[0]['rota1']} +29 days"));
													}
												}
												?>
											</td>
										  </tr>
										  <tr>
											<td class="vaccination-td">
												 <span>
												  <?php if($childDataview[0]['penta2']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  Penta-2</span>
											</td>
											<?php 
										        $penta2date = $childDataview[0]['penta2'];
										    ?>
											<td style="white-space:nowrap;<?php echo ($childDataview[0]['penta1'] != NULL && $childDataview[0]['penta2'] != NULL && $childDataview[0]['penta2'] < date('Y-m-d', strtotime($childDataview[0]['penta1']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>">
											<?php if(isset($penta2date))
											echo date("M d, Y", strtotime($penta2date));?></td>
											<td>
											<?php if($childDataview[0]['penta2']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											</td>
											<td class="custom-top-border">
												<?php 
												if($childDataview[0]['penta2']==NULL && $childDataview[0]['penta3'] == NULL /* && $childDataview[0]['measles1'] == NULL */){
													if($childDataview[0]['penta1'] == NULL){}else{
														echo date("M d, Y", strtotime("{$childDataview[0]['penta1']} +29 days"));
													}
												}
												?>
											</td>
										  </tr>
										<tr>
											<td class="vaccination-td">
												<span>
												  <?php if($childDataview[0]['pcv2']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  PCV10-2</span> 
											</td>
											<?php 
										        $pcv2date = $childDataview[0]['pcv2'];
										    ?>
											<td style="white-space:nowrap;<?php echo ($childDataview[0]['pcv1'] != NULL && $childDataview[0]['pcv2'] != NULL && $childDataview[0]['pcv2'] < date('Y-m-d', strtotime($childDataview[0]['pcv1']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>" >
											<?php if(isset($pcv2date))
											echo date("M d, Y", strtotime($pcv2date));?></td>
											<td>
											<?php if($childDataview[0]['pcv2']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											  </td>
											<td class="custom-top-border">
												<?php 
												if($childDataview[0]['pcv2']==NULL && $childDataview[0]['pcv3'] == NULL /* && $childDataview[0]['measles1'] == NULL */){
													if($childDataview[0]['pcv1'] == NULL){}else{
														echo date("M d, Y", strtotime("{$childDataview[0]['pcv1']} +29 days"));
													}
												}
												?>
											</td>
										  </tr>
										  <!-- -->
                                          <tr>
                                              <td rowspan="4" class="bg text-center custom-black-border">At Fourteen Week <urdu class="display-block">چودہ ہفتہ کی عمر میں</urdu></td>
                                              <td class="vaccination-td custom-top-border">
                                                  <span>
												  <?php if($childDataview[0]['opv3']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  OPV-3</span>
                                              </td>
											  <?php 
										        $opv3date = $childDataview[0]['opv3'];
										      ?>
                                              <td class="custom-top-border" style="white-space:nowrap;<?php echo ($childDataview[0]['opv2'] != NULL && $childDataview[0]['opv3'] != NULL && $childDataview[0]['opv3'] < date('Y-m-d', strtotime($childDataview[0]['opv2']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>">
											  <?php if(isset($opv3date))
											  echo date("M d, Y", strtotime($opv3date));?></td>
                                              <td class="custom-top-border">
											  <?php if($childDataview[0]['opv3']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											  </td>
                                              <td class="custom-top-border">
													<?php 
													if($childDataview[0]['opv3']==NULL /* && $childDataview[0]['measles1'] == NULL */){
														if($childDataview[0]['opv2'] == NULL){}else{
															echo date("M d, Y", strtotime("{$childDataview[0]['opv2']} +29 days"));
														}
													}
													?>
												</td>
                                              <td rowspan="4" class="custom-black-border"></td>
                                          </tr>
										  
										  <tr>
											<td class="vaccination-td">
												 <span>
												  <?php if($childDataview[0]['ipv']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  IPV</span>  
											</td>
											<?php 
										        $ipvdate = $childDataview[0]['ipv'];
										    ?>
											<td style="white-space:nowrap;<?php echo ($childDataview[0]['penta2'] != NULL && $childDataview[0]['ipv'] != NULL && $childDataview[0]['ipv'] < date('Y-m-d', strtotime($childDataview[0]['penta2']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>" >
											<?php if(isset($ipvdate))
											echo date("M d, Y", strtotime($ipvdate));?></td>
											<td>
											<?php if($childDataview[0]['ipv']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											  </td>
											<td>
											<?php if($childDataview[0]['ipv']==NULL /* && $childDataview[0]['measles1'] == NULL */){
											echo date("M d, Y", strtotime("$bdate +98 days"));}?>
											</td>
										  </tr>
										  <tr>
											<td class="vaccination-td">
												<span>
												  <?php if($childDataview[0]['penta3']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  Penta-3</span>
											</td>
											<?php 
										        $penta3date = $childDataview[0]['penta3'];
										    ?>
											<td style="white-space:nowrap;<?php echo ($childDataview[0]['penta2'] != NULL && $childDataview[0]['penta3'] != NULL && $childDataview[0]['penta3'] < date('Y-m-d', strtotime($childDataview[0]['penta2']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>">
											<?php if(isset($penta3date))
											echo date("M d, Y", strtotime($penta3date));?></td>
											<td>
											<?php if($childDataview[0]['penta3']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											  </td>
											<td class="custom-top-border">
													<?php 
													if($childDataview[0]['penta3']==NULL /* && $childDataview[0]['measles1'] == NULL */){
														if($childDataview[0]['penta2'] == NULL){}else{
															echo date("M d, Y", strtotime("{$childDataview[0]['penta2']} +29 days"));
														}
													}
													?>
												</td>
										  </tr>
										  <tr>
											<td class="vaccination-td">
												<span>
												  <?php if($childDataview[0]['pcv3']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  PCV10-3</span> 
											</td>
											<?php 
										        $pcv3date = $childDataview[0]['pcv3'];
										    ?>
											<td style="white-space:nowrap;<?php echo ($childDataview[0]['pcv2'] != NULL && $childDataview[0]['pcv3'] != NULL && $childDataview[0]['pcv3'] < date('Y-m-d', strtotime($childDataview[0]['pcv2']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>" >
											<?php if(isset($pcv3date))
											echo date("M d, Y", strtotime($pcv3date));?></td>
											<td>
											<?php if($childDataview[0]['pcv3']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											  </td>
											<td class="custom-top-border">
												<?php 
												if($childDataview[0]['pcv3']==NULL /* && $childDataview[0]['measles1'] == NULL */){
													if($childDataview[0]['pcv2'] == NULL){}else{
														echo date("M d, Y", strtotime("{$childDataview[0]['pcv2']} +29 days"));
													}
												}
												?>
											</td>
										  </tr>
										  <!-- -->
                                          <tr>
                                              <td class="bg text-center custom-black-border">At Nine Months <urdu class="display-block">نو ماہ کی عمر میں</urdu></td>
                                              <td class="vaccination-td custom-top-border">
                                                  <span>
												  <?php if($childDataview[0]['measles1']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  Measles-1</span>
                                              </td>
											  <?php 
										        $measles1date = $childDataview[0]['measles1'];
										      ?>
                                              <td class="custom-top-border" style="white-space:nowrap;<?php echo ($childDataview[0]['measles1'] != NULL && $childDataview[0]['measles1'] < date('Y-m-d', strtotime($childDataview[0]['dateofbirth']. ' +9 month +1 day')))?'color:#FFF;background-color:red':''; ?>" >
											  <?php if(isset($measles1date))
											  echo date("M d, Y", strtotime($measles1date));?></td>
                                              <td class="custom-top-border">
											  <?php if($childDataview[0]['measles1']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											  </td>
                                              <td class="custom-top-border">
											  <?php if($childDataview[0]['measles1']==NULL && $childDataview[0]['measles2'] == NULL){
											  echo date("M d, Y", strtotime("$bdate +9 month"));}?>
											  </td>
                                              <td class="custom-black-border"></td>
                                          </tr>
                                          <tr>
                                              <td class="bg text-center custom-black-border">At Fifteen Months <urdu class="display-block">پندرہ ماہ کی عمر میں</urdu></td>
                                              <td class="vaccination-td verticle-middle custom-top-border">
                                                  <span>
												  <?php if($childDataview[0]['measles2']!=NULL){
													  echo'<i class="fas fa-check"></i>';
												  }
												  else{
													  echo'<i class="fas fa-times"></i>';
												  }?>
												  Measles-2</span>
                                              </td>
											  <?php 
										        $measles2date = $childDataview[0]['measles2'];
										      ?>
                                              <td class="custom-top-border" style="white-space:nowrap;<?php echo ($childDataview[0]['measles1'] != NULL && $childDataview[0]['measles2'] != NULL && ($childDataview[0]['measles2'] < date('Y-m-d', strtotime($childDataview[0]['dateofbirth']. ' +1 year +3 month +1 day'))) && ($childDataview[0]['measles2'] < date('Y-m-d',strtotime($childDataview[0]['measles1']. ' + 29 days'))))?'color:#FFF;background-color:red':''; ?>">
											  <?php if(isset($measles2date))
											  echo date("M d, Y", strtotime($measles2date));?></td>
                                              <td class="custom-top-border">
											  <?php if($childDataview[0]['measles2']!=NULL) {?>
											   <a href="" target="_blank" rel="noopener" onclick="return popitup('<?php echo base_url(); ?>Reports/ChildVaccinationMap/<?php echo $childDataview[0]['latitude'];?>/<?php echo $childDataview[0]['longitude'];?>')"><?php echo $childDataview[0]['facilityname'];?></a>
											  <?php }?>
											  </td>
												<td class="custom-top-border">
													<?php 
													if($childDataview[0]['measles2']==NULL){
														if($childDataview[0]['measles1'] == NULL){}else{
															if(date('Y-m-d') > date("Y-m-d", strtotime("$bdate +15 month")))
																echo date("M d, Y", strtotime("$bdate +15 month"));
															else
																echo date("M d, Y", strtotime("{$childDataview[0]['measles1']} +29 days"));
														}
													}
													?>
												</td>
                                              <td class="custom-black-border"></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
						 </div> 
                          <div class="row">
                              <div class="col-lg-12 text-center">
                                  <button onclick="myFunction()" class="btn btn-success" ><i class="fas fa-print"></i> PRINT</button>
                                  <a href="<?php echo base_url();?>childs/Reports/child_cardview?cardno=<?php echo $childDataview[0]['child_registration_no'];?>" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
                              </div>
                          </div>
                      </div>
                  </section>
              </div>
          </div>
      </div>
  </section>
  <!-- The Modal -->
	<div id="myModal" class="modal">
		<span class="close">&times;</span>
		<img class="modal-content" id="img01">
		<div id="caption"></div>
	</div>   
   <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}

<!--
/* function popitup(url) {
	newwindow=window.open(url,'name','height=600,width=600');
	if (window.focus) {newwindow.focus()}
	return false;
} */

// -->
<!-- print
function myFunction() {
  window.print();
}
// -->

//jquery for print
/* function printData()
{
   var divToPrint=document.getElementById("section-to-print");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

$('button').on('click',function(){
printData();
}) */
</script>