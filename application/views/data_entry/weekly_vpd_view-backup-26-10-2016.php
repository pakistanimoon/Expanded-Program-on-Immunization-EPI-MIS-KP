<div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading">Disease Surveillance Report View</div>
     <div class="panel-body">
     	<table class="table table-bordered   table-striped table-hover  mytable3">
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
          </div>
          <td>
            <label>Health Facility:</label>
          </td>
          <td>
              <p><?php echo $facility;  ?></p>
          </td>
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
		 <tr>
		 <td><label>Case Reported</label></td>
              <td><?php echo isset($weeklyVPD)?(($weeklyVPD->case_reported=="0")?'No':'Yes'):''; ?></td> 
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
     	  <td><label>Gender</label></td>
     	  <td>
     	   <p><?php echo isset($weeklyVPD)?(($weeklyVPD->gender=="0")?'Female':''):''; echo isset($weeklyVPD)?(($weeklyVPD->gender=="1")?'Male':''):''; ?></p>
     	  </td>
     	  <td><label>Age Months</label></td>
     	  <td><p><?php echo $weeklyVPD ->age_months;  ?></p></td>
     	  </tr>
     	  <tr>
     	  <td><label>Father Name</label></td>
     	  <td><p><?php echo $weeklyVPD -> case_father_name;  ?></p></td>
     	  <td><label>Father CNIC</label></td>
     	  <td>
     	   <p><?php echo $weeklyVPD ->case_father_nic;  ?></p>
     	  </td>
     	  <td><label>Cell No</label></td>
     	  <td><p><?php echo $weeklyVPD ->case_cell;  ?></p></td>
     	  </tr>
     	  <tr>
			  <td><label>Address</label></td>
			  <td><p><?php echo $weeklyVPD -> case_address;  ?></p></td>
			  <td><label>District</label></td>
			  <td><p><?php echo get_District_Name($weeklyVPD->case_distcode);  ?></p></td>
			  <td><label>Tehsil</label></td>
			  <td><p><?php echo get_Tehsil_Name($weeklyVPD->case_tcode);  ?></p></td>
     	  </tr>
		  <tr>
				<td><label>Union Council</label></td>
				<td><p><?php echo get_UC_Name($weeklyVPD->case_uncode);  ?></p></td>
				<td></td>
				<td></td>
		  </tr>
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
	     <td><label>Date of Investigation</label></td>
	      <td><p><?php echo (isset($weeklyVPD->case_date_investigation))?date('d-m-Y',strtotime($weeklyVPD -> case_date_investigation)):'';  ?></p></td>
	     <td><label>Total No. of vaccine doses received</label></td>
	     <td>
	 	   <p><?php echo $weeklyVPD ->doses_received;  ?></p>
     	  </td>
         </tr>
         <tr>
	     <td><label>Date of last does received</label></td>
	      <td><p><?php echo (isset($weeklyVPD->case_date_last_dose_received))?date('d-m-Y',strtotime($weeklyVPD -> case_date_last_dose_received)):'';  ?></p></td>
	     <td><label>Type of Specimen Collection</label></td>
	       <td>
	 	   <p><?php echo $weeklyVPD ->case_type_speceicman;  ?></p>
     	  </td>
	     <td><label>Date of Specimen Collection</label></td>
	     <td><p><?php echo (isset($weeklyVPD->case_date_specieman))?date('d-m-Y',strtotime($weeklyVPD -> case_date_specieman)):'';  ?></p></td>
         </tr>
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
	       <td><label>Specimen Result</label></td>
	       <td>
	 	   <p><?php echo $weeklyVPD ->specieman_result;  ?></p>
     	  </td>
     	  <td><label>Clinical representation of the case</label></td>
	       <td>
	 	   <p><?php echo (isset($weeklyVPD->case_representation))?($weeklyVPD ->case_representation=='999')?'NA':(($weeklyVPD ->case_representation=='1000')?'Other':get_CaseRepresentation_Value($weeklyVPD ->case_representation)):'';  ?></p>
     	  </td>
		  <?php if($weeklyVPD ->case_representation=='1000'){ ?>
		  <tr><td><p><?php echo (isset($weeklyVPD) && $weeklyVPD->other_case_representation != '')?$weeklyVPD->other_case_representation:''; ?></p></td></tr>
		  <?php } ?>
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
          <?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
          <div class="col-xs-4" style="margin-left: 74%;">
            <a href="<?php echo base_url(); ?>Disease-Surveillance/Edit/<?php echo $weeklyVPD->recid; ?>" class="btn btn-md btn-success" type="reset"><i class="fa fa-pencil-square-o"></i> Update </a>
            <a onclick="history.go(-1);" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
          </div>
          <?php } ?>
        </div>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->