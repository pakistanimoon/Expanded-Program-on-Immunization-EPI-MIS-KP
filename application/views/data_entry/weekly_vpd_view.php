 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading">Disease Surveillance Report View</div>
     <div class="panel-body">
     <form class="form-horizontal" method="post" onsubmit="return confirm('Do you really want to Approve this cross notified case?')" action="<?php echo base_url(); ?>Data_entry/weekly_vpd_Approve">
        <input type="hidden" name="recid" value="<?php echo $weeklyVPD->recid; ?>">
     <?php if(isset($weeklyVPD->rb_distcode) && $weeklyVPD->rb_distcode>0){ ?>
     <table id="rb_info" class="table table-bordered table-striped table-hover mytable2 mytable3 disabledclass">
      <thead>
        <tr>
          <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Case Refering Facility Information</th>
        </tr>
      </thead>
      <tbody>           
        <tr>
          <td><p>Province / Area</p></td>
          <td>Khyber Pakhtunkhwa</td>
          <td><p>District</p></td>
          <td>
            <p><?php if(isset($weeklyVPD)){ echo get_District_Name($weeklyVPD -> rb_distcode);} ?></p>
          </td>            
        </tr>
        <tr>
          <td><p>Tehsil / City</p></td>
          <td>
            <p><?php if(isset($weeklyVPD)){ echo get_Tehsil_Name($weeklyVPD -> rb_tcode);} ?></p>
          </td>
          <td><p>Union Council</p></td>
          <td>
            <p><?php if(isset($weeklyVPD)){ echo get_UC_Name($weeklyVPD -> rb_uncode);} ?></p>
          </td>
        </tr>
        <tr>
          <td><p>Name of Reporting Health Facility</p></td>
          <td>
            <p><?php if(isset($weeklyVPD)){ echo get_Facility_Name($weeklyVPD -> rb_facode);} ?></p>
          </td>
          <td><p>Address of Health Facility</p></td>
          <td>
            <p><?php if(isset($weeklyVPD)){ echo $weeklyVPD -> rb_faddress;} ?></p>
          </td>
        </tr>
      </tbody>
    </table>
     <?php } ?>
     	<table class="table table-bordered   table-striped table-hover  mytable3">
     	<thead>
            <tr>
              <th colspan="7" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">PART I : For Use by Reporting Facility and DHO</th>
            </tr>
        </thead>
        <tbody>
        <tbody>
        <tr>
          <td>
            <label>Province:</label>
          </td>
          <td>
            <p>Khyber Pakhtunkhwa</p>
          </td>
           <td>
            <label>District:</label>
          </td>
          <td>
            <p><?php echo $district;  ?></p>
          </td> 
          <td>
            <label>Tehsil:</label>
          </td>
          <td>
            <p><?php echo $tehsil;  ?></p>
          </td>        
        </tr>
		<tr>
        <td>
            <label>Union Council:</label>
          </td>
          <td>
            <p><?php echo $unioncouncil;  ?></p>
          </td>
          <?php if($weeklyVPD->facode != ''){ ?>
          <td>
            <label>Health Facility:</label>
          </td>
          <td>
              <p><?php echo $facility;  ?></p>
          </td>          
          <?php }else if($weeklyVPD->facode == '' && $weeklyVPD->cross_notified==1 && $weeklyVPD->distcode == $this -> session -> District){ ?>
              <td><p>Name of Health Facility</p></td>
              <td>
              <select name="facode" class="form-control">
              <?php echo getFacilities_options(false,'',$weeklyVPD -> uncode); ?>
              </select>
              </td>
              <td><p style="color:#008d4c;">Select Health Facility and approve Below</p></td>
            <?php } ?>
      	  <td>
            <label>Year:</label>
          </td>
          <td>
            <p><?php echo $weeklyVPD -> year;  ?></p>
          </td>
         </tr>
         <tr>
	     <td>
	        <label>EPI Week No:</label>
	     </td>
	      <td>
	        <p><?php echo sprintf("%2d",$weeklyVPD ->week);  ?></p>
	      </td>
	     <td><label>Date From</label></td>
	     <td><p><?php echo date('d-M-Y',strtotime($weeklyVPD -> datefrom));  ?></p></td>
	     <td><label>Date To</label></td>
	     <td><p><?php echo date('d-M-Y',strtotime($weeklyVPD -> dateto));  ?></p></td>
         </tr>
         </tbody>
        </table>
        <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
           <tr>
              <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Basic Information</th>
           </tr>
          </thead>
     	  <tbody>
     	  <tr>
     	  <td><label>Name of Case</label></td>
     	  <td><p><?php echo $weeklyVPD -> name_case;  ?></p></td>
		  <td><label>Father Name</label></td>
     	  <td><p><?php echo $weeklyVPD -> case_father_name;  ?></p></td>
		  <td><label>Cell No</label></td>
     	  <td><p><?php echo $weeklyVPD ->case_cell;  ?></p></td>
		  </tr>
		  <tr>
		  <td><label>H.No./Street No.</label></td>
		  <td><p><?php echo $weeklyVPD -> case_address;  ?></p></td>
		  <td><label>Village/Mohallah</label></td>
		  <td><p><?php echo $weeklyVPD -> cityname;  ?></p></td>
		  </tr>
		  <tr>
		  <td><label>District</label></td>
		  <td><p><?php echo get_District_Name($weeklyVPD->case_distcode);  ?></p></td>
		  <td><label>Tehsil</label></td>
		  <td><p><?php echo get_Tehsil_Name($weeklyVPD->case_tcode);  ?></p></td>
     	  <td><label>Union Council</label></td>
				<td><p><?php echo get_UC_Name($weeklyVPD->case_uncode);  ?></p></td>
		</tr>
		<tr>
		<td><label>Age Months</label></td>
     	  <td><p><?php echo $weeklyVPD ->age_months;  ?></p></td>
		  <td><label>Gender</label></td>
     	  <td>
     	   <p><?php echo isset($weeklyVPD)?(($weeklyVPD->gender=="0")?'Female':''):''; echo isset($weeklyVPD)?(($weeklyVPD->gender=="1")?'Male':''):''; ?></p>
     	  </td>
     	  </tr>
     	 <!-- <tr>
     	  
     	  <td><label>Father CNIC</label></td>
     	  <td>
     	   <p><?php echo $weeklyVPD ->case_father_nic;  ?></p>
     	  </td>
     	  
     	  </tr>-->
     	  </tbody>
        </table>
        <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Disease Information</th>
            </tr>
          </thead>
        <tbody>
          <tr>
           <tr>
	       <td><label>Type of Case</label></td>
	       <td>
	 	   <p><?php echo $weeklyVPD ->case_type;  ?></p>
     	  </td>
          </tr>
          <tr>
	     <td><label>Date of onset</label></td>
	      <td><p><?php echo (isset($weeklyVPD->case_date_onset))?date('d-m-Y',strtotime($weeklyVPD -> case_date_onset)):'';  ?></p></td>
	    <!-- <td><label>Date of Investigation</label></td>
	      <td><p><?php echo (isset($weeklyVPD->case_date_investigation))?date('d-m-Y',strtotime($weeklyVPD -> case_date_investigation)):'';  ?></p></td>-->
	     <td><label>Total No. of vaccine doses received</label></td>
	     <td>
	 	   <p><?php echo $weeklyVPD ->doses_received;  ?></p>
     	  </td>
         </tr>
         <tr>
	     <td><label>Date of last does received</label></td>
	      <td><p><?php echo (isset($weeklyVPD->case_date_last_dose_received))?date('d-m-Y',strtotime($weeklyVPD -> case_date_last_dose_received)):'';  ?></p></td>
	    <!-- <td><label>Type of Specimen Collection</label></td>
	       <td>
	 	   <p><?php echo $weeklyVPD ->case_type_speceicman;  ?></p>
     	  </td>-->
	     <td><label>Date of Specimen Collection</label></td>
	     <td><p><?php echo (isset($weeklyVPD->case_date_specieman))?date('d-m-Y',strtotime($weeklyVPD -> case_date_specieman)):'';  ?></p></td>
         </tr>
		<tr>
			<td><label>Clinical Representation of the Case</label></td>
			<td><p><?php if(isset($weeklyVPD->case_representation)){echo get_CaseRepresentation_Value($weeklyVPD->case_representation);} else {echo '';} ?></p></td>
			<?php if($weeklyVPD ->case_representation=='1000'){ ?>
		  <tr><td><p><?php echo (isset($weeklyVPD) && $weeklyVPD->other_case_representation != '')?$weeklyVPD->other_case_representation:''; ?></p></td></tr>
		  <?php } ?>
			<td><label>Others</label></td>
			<td><p><?php if(isset($weeklyVPD->other_case_representation)){echo $weeklyVPD->other_case_representation;} else {echo '';} ?></p></td>
		</tr>
        </tbody>
        </table>
      <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Lab Information</th>
            </tr>
          </thead>
      <tbody>
      	
      	   <tr>
	       <td><label>Lab Result</label></td>
	       <td>
	 	   <p><?php echo $weeklyVPD ->specieman_result;  ?></p>
     	  </td>
     	   <td><label>Remarks</label></td>
		  <td>
	 	   <p><?php echo $weeklyVPD ->remarks;  ?></p>
     	  </td>
		  
     	 </tr>
		 <tr>
		
		   <td><label>Date of Result Received</label></td>
		  <td>
	 	   <p><?php echo $weeklyVPD ->dateofresult;  ?></p>
     	  </td>
		  <td><label>Ontime</label></td>
		  <td>
	 	   <p><?php if($weeklyVPD ->ontime == "1") {echo "Yes";} else {echo "No";}  ?></p>
     	  </td>
		 </tr>
      	
      </tbody>	
     </table>
       <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Follow-up Information</th>
            </tr>
          </thead>
      <tbody>
          <tr>
          	<td><label>Date of follow-up</label></td>
          	<td><p><?php echo (isset($weeklyVPD->case_date_follow))?date('d-m-Y',strtotime($weeklyVPD -> case_date_follow)):'';  ?></p></td>
          	<td><label>Outcomes</label></td>
	        <td>
	 	     <p><?php echo $weeklyVPD ->outcomes;  ?></p>
     	    </td>
			<?php if($weeklyVPD ->outcomes == "Complication"){?>
     	    <td class="complication_type"><label>Type Of Complication</label></td>
     	    <td class="complication_type"><p><?php echo $weeklyVPD -> complication_type;  ?></p></td>
			<?php } ?>
          </tr>
		  <?php if($weeklyVPD ->outcomes == "Died"){?>
          <tr>
          	<td class="death_date"><label>Death Date</label></td>
     	    <td class="death_date"><p><?php echo (isset($weeklyVPD->death_date_follow))?date('d-m-Y',strtotime($weeklyVPD -> death_date_follow)):'';  ?></p></td>
          </tr>
		  <?php } ?>
       </tbody>    
      </table>
      <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th colspan="8" style="text-align: center; padding-top: 10px; padding-bottom: 10px;"></th>
            </tr>
          </thead>
          <tbody>
           <tr>
          	<td><label>Submission Date</label></td>
          	<td><p><?php if(isset($weeklyVPD) && $weeklyVPD->editted_date != ""){ echo date('d-m-Y',strtotime($weeklyVPD->editted_date)); } else { if($weeklyVPD->submitted_date != ""){ echo date('d-m-Y',strtotime($weeklyVPD->submitted_date)); } }  ?></p></td>
          </tr>
         </tbody>
        </table>  
        <div class="row" >
          <hr>
          <!-- <?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
          <div class="col-xs-4" style="margin-left: 74%;">
			<?php if($this -> session -> utype=="DEO" && $this -> session -> UserLevel=='3'){ ?>
            <a href="<?php echo base_url(); ?>Disease-Surveillance/Edit/<?php echo $weeklyVPD->recid; ?>" class="btn btn-md btn-success" type="reset"><i class="fa fa-pencil-square-o"></i> Update </a>
			<?php } ?>
            <a onclick="history.go(-1);" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
          </div>
          <?php } ?> -->
          <?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">                
              <?php if($weeklyVPD->cross_notified != 1){ ?>
              <a href="<?php echo base_url(); ?>Disease-Surveillance/Edit/<?php echo $weeklyVPD->recid; ?>" style="background:#008d4c;" class="btn btn-primary btn-md"><i class="fa fa-pencil-square-o"></i> Update </a>
              <?php }else if($weeklyVPD->cross_notified == 1 && $weeklyVPD->distcode == $this -> session -> District && $weeklyVPD->approval_status != "Approved"){ ?>
              <button style="background:#008d4c none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-check"></i> Approve Case</button>
              <?php 
                $this->session->set_flashdata('redirectToCurrent', current_url());
              } ?>
              <a href="<?php echo base_url(); ?>Disease-Surveillance/List" style="background:#008d4c;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
		    <?php } ?>
        </div>
        </form>
     </div>  <!--end of panel body-->
  </div> <!--end of panel panel-primary-->
</div> <!--end of row-->
</div> <!--End of page content or body-->