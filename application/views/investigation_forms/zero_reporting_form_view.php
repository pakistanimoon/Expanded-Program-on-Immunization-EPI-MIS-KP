<!--start of page content or body-->
<?php
date_default_timezone_set('Asia/Karachi'); // CDT
$current_date = date('d-m-Y');?>
<div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Zero Reporting Form</div>
     <div class="panel-body">
   		
        <table class="table table-bordered   table-striped table-hover  mytable3">
          <tbody>
          <tr>
		  <td><label>Province</label></td>
            <td> <p><?php echo $this -> session -> provincename ?></p></td>
		  <td><label>District</label></td>
            <td><p><?php echo $district;  ?></p></td>
            <td><label>Year</label></td>
            <td><p><?php echo $year;  ?></p></td>
           
          </tr>
          <tr>
		   <td><label>Epid. Week No</label></td>
           <td><p><?php echo $week;  ?></p></td>
           <td><label>Date From</label></td>
           <td><p><?php echo date("d-M-Y",strtotime($datefrom));  ?></p></td>
            <td><label>Date To</label></td>
           <td><p><?php echo date("d-M-Y",strtotime($dateto));  ?></p></td>
             
             
          </tr>
		 
           
          
      </tbody>
    </table>
      <div id="parent">
        <table id="fixTable"   class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
              <tr>
                <th rowspan="2" style="width:190px;">Facilities</th>
                <th colspan="2">Report Submitted</th>
<th colspan="2">AEFI</th>
				<th colspan="2">Pertussis</th>
				<th colspan="2">Neonatal Tetanus</th>
				<th colspan="2">Acute Flaccid Paralysis</th>
				<th colspan="2">Diphtheria</th>
				<th colspan="2">Measles</th>
				<th colspan="2">Hepatitis B < 5 years</th>
				<th colspan="2">Childhood Tuberculosis</th>
                <th colspan="2"> Severe Acute respiratory illness(Including Influenza)</th>
                <th colspan="2">Acute Watery Diarrhea</th>
				<!--<th colspan="2">Acute Watery Diarrhea/ Suspected Cholera >5 year</th>-->
				<th colspan="2">Dengue Fever</th>
				<th colspan="2">Dengue Hemorrhagic Fever</th>
				<th colspan="2">Cutaneous Leishmaniasis</th>
				<th colspan="2">Crimean Congo Hemorrhagic Fever</th>
				<th colspan="2">Anthrax</th>
				<th colspan="2">Meningitis</th>
				<th colspan="2">Visceral Leishmaniasis</th>
				<th colspan="2">Malaria</th>
				<th colspan="2">Pneumonia</th>
				<th colspan="2">Dog Bite</th>
				<th colspan="2">Bloody Diarrhea</th>
				<th colspan="2">HIV/AIDS</th>
				<th colspan="2">Acute Viral Hepatitis(Acute Jaundice Syndrome)</th>
				<th colspan="2">Typhoid</th>
				<th colspan="2">Scabies</th>
				<th colspan="2">Acute Diarrhea</th>
				<th colspan="2">Coronavirus (COVID-19)</th>
				<th colspan="2">Others</th>
				</tr>
              <tr>
               <th style="font-weight:500;">Yes</th>
                <th style="font-weight:500;">No</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
                <th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
                <th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<!--<th style="font-weight:500;">Cases</th>-->
               <!-- <th style="font-weight:500;">Deaths</th> -->
                <th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
                <th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
                <th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
                <th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
                <th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
                <th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
                <th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
                <th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<!--<th style="font-weight:500;">Cases</th>-->
               <!-- <th style="font-weight:500;">Deaths</th>-->
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
                <th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<!--<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>
				<th style="font-weight:500;">Cases</th>
                <th style="font-weight:500;">Deaths</th>-->
              </tr>
          </thead>
          <tbody id="myTable">
		  <?php
		 foreach($zero_report as $key => $row){ 
			
			?>
            <tr>
              <td><label><?php echo get_Facility_Name($row['facode']); ?></label></td>
			  <td class="cases"><p class="text-center"><?php echo $row['report_submitted'] == '1' ? '&#10004;' : ''; ?></p></td>
			  <td class="cases"><p class="text-center"><?php echo $row['report_submitted'] == '0' ? '&#10007;' : ''; ?></p></td>
              <td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['aefi_cases'] ; }else { } ?>" name="aefi_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['aefi_deaths'] ; }else { } ?>" name="aefi_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['pertusis_cases'] ; }else { } ?>" name="pertusis_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['pertusis_deaths'] ; }else { } ?>" name="pertusis_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['nnt_cases'] ; }else { } ?>" name="nnt_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['nnt_deaths'] ; }else { } ?>" name="nnt_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['afp_cases'] ; }else { } ?>" name="afp_cases[<?php echo $key; ?>]"  type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['afp_deaths'] ; }else { } ?>" name="afp_deaths[<?php echo $key; ?>]"  type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['diphtheria_cases'] ; }else { } ?>" name="diphtheria_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['diphtheria_deaths'] ; }else { } ?>" name="diphtheria_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['measle_cases'] ; }else { } ?>" name="measle_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['measle_deaths'] ; }else { } ?>" name="measle_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['hepatits_cases'] ; }else { } ?>" name="hepatits_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['hepatits_deaths'] ; }else { } ?>" name="hepatits_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['tb_cases'] ; }else { } ?>" name="tb_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['tb_deaths'] ; }else { } ?>" name="tb_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['sari_cases'] ; }else { } ?>" name="sari_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['sari_deaths'] ; }else { } ?>" name="sari_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['diarrhea_cases'] ; }else { } ?>" name="diarrhea_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['diarrhea_deaths'] ; }else { } ?>" name="diarrhea_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['df_cases'] ; }else { } ?>" name="df_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['df_deaths'] ; }else { } ?>" name="df_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['dhf_cases'] ; }else { } ?>" name="dhf_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['dhf_deaths'] ; }else { } ?>" name="dhf_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['cl_cases'] ; }else { } ?>" name="cl_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['cl_deaths'] ; }else { } ?>" name="cl_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['cchf_cases'] ; }else { } ?>" name="cchf_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['cchf_deaths'] ; }else { } ?>" name="cchf_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['anthrax_cases'] ; }else { } ?>" name="anthrax_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['anthrax_deaths'] ; }else { } ?>" name="anthrax_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['meningitis_cases'] ; }else { } ?>" name="meningitis_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['meningitis_deaths'] ; }else { } ?>" name="meningitis_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['vl_cases'] ; }else { } ?>" name="vl_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['vl_deaths'] ; }else { } ?>" name="vl_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['mal_cases'] ; }else { } ?>" name="mal_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['mal_deaths'] ; }else { } ?>" name="mal_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['pneumonia_cases'] ; }else { } ?>" name="pneumonia_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['pneumonia_deaths'] ; }else { } ?>" name="pneumonia_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['dogbite_cases'] ; }else { } ?>" name="dogbite_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['dogbite_deaths'] ; }else { } ?>" name="dogbite_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['bd_cases'] ; }else { } ?>" name="bd_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['bd_deaths'] ; }else { } ?>" name="bd_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['aids_cases'] ; }else { } ?>" name="aids_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['aids_deaths'] ; }else { } ?>" name="aids_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['avh_cases'] ; }else { } ?>" name="avh_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['avh_deaths'] ; }else { } ?>" name="avh_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['tf_cases'] ; }else { } ?>" name="tf_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['tf_deaths'] ; }else { } ?>" name="tf_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['scabies_cases'] ; }else { } ?>" name="scabies_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['scabies_deaths'] ; }else { } ?>" name="scabies_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['ad_cases'] ; }else { } ?>" name="ad_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['ad_deaths'] ; }else { } ?>" name="ad_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>

					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['covid_cases'] ; }else { } ?>" name="covid_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['covid_deaths'] ; }else { } ?>" name="covid_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>

					<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['undis_cases'] ; }else { } ?>" name="undis_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['undis_deaths'] ; }else { } ?>" name="undis_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				
			 </tr>
           	<?php 
			
			} ?>
          </tbody>
        </table>
      </div>
	  
        
        <div class="row">
         <hr>
            <?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
          <div class="col-xs-4" style="margin-left: 74%;">
            <a href="<?php echo base_url(); ?>Zero-Reporting/Edit/<?php echo $fweek; ?>/<?php echo $group_id; ?>" class="btn btn-md btn-success" type="reset"><i class="fa fa-pencil-square-o"></i> Update </a>
            <a href="<?php echo base_url(); ?>Zero-Reporting" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
          </div>
          <?php } ?>   
        </div>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--end of body container-->