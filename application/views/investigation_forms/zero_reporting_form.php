<!--start of page content or body-->
<?php

$current_date = date('d-m-Y');?>
<div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Zero Reporting Form</div>
     <div class="panel-body">
     <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Investigation_forms/zero_reporting_save" id="getValues">
		
		<?php if(isset($zero_report_header)){ ?>
		<input type="hidden" name="edit" value="1" />
		<input type="hidden" name="group_id" value="<?php echo $group_id ; ?>" />
		<?php } ?>
        <table class="table table-bordered table-striped table-hover mytable3">
          <tbody>
          <tr>
		  <td><label>Province</label></td>
            <td><input readonly="readonly" class="form-control" value="<?php echo $this -> session -> provincename ?>" placeholder="<?php echo $this -> session -> provincename ?>" type="text"></td>
		  <td><label>District</label></td>
            <td><select class="form-control" id="distcode" name="distcode">
          	<?php if(isset($zero_report_header)){ ?>
          		<option value="<?php echo $zero_report_header[0]['distcode']; ?>"><?php echo $district; ?></option>
            <?php }else{ ?>
             <?php echo getDistricts_options(); ?>
             <?php } ?>
            </select></td>
            <td><label>Year</label></td>
            <td><select class="form-control text-center" name="year" id="year">
            	<?php if(isset($zero_report_header)){ ?>
            		<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
            	<?php }else{ ?>
             	<?php echo $years; 
						}?>
            </select></td>
           
          </tr>
          <tr>
		   <td><label>Epid. Week No</label></td>
            <td>
             <select class="form-control" name="week" id="week">
            	<?php 
				if(isset($zero_report_header)){
					//echo "danish";exit;
				?>
            		<option value="<?php echo $week;//sprintf("%02d",$week); ?>">Week <?php echo sprintf("%02d",$week); ?></option>
            	<?php }else{ ?>
					<option>--Select Week No--</option>
					<?php } ?>
            </select>
            </td>
            <td><label>Date From</label></td>
            <td>
              <input class="form-control text-center datefrom" readonly="readonly" name="date_from" id="date_from" value="<?php if(isset($zero_report_header)){ echo date('d-m-Y',strtotime($zero_report_header[0]['datefrom'])); }else{ } ?>"  placeholder="Week Start Date" type="text">
            </td>
            <td><label>Date To</label></td>
            <td><input class="form-control text-center dateto" readonly="readonly" name="date_to" id="date_to" value="<?php if(isset($zero_report_header)){ echo date('d-m-Y',strtotime($zero_report_header[0]['dateto'])); }else { } ?>" placeholder="Week End Date" type="text"  data-date-end-date="-1d"></td>
             
             
          </tr>
		 
           
          
      </tbody>
    </table>
      <div id="parent">
        <table id="fixTable"   class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
              <tr>
				<th rowspan="2" style="width:190px;">
					<input type="button" class="btn btn-primary btn-md" id="checkall" value="Select All">
					<input type="button" class="btn btn-primary btn-md hide" id="uncheckall" value="Deselect All">
					Facilities
				</th>
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
		  	if(isset($zero_report_header)){ 
		  		$lastday = $zero_report_header[0]['dateto'];
		  		//echo $lastday;
		  		$duedate = date('Y-m-d', strtotime($current_date. ' - 1 days'));
		  		$current_date;
		  		//echo $duedate;exit();
		  	}
		  	if(isset($zero_report)){ 
				foreach($zero_report as $key => $row){ 
				?>				
			<tr>
				<td><label><input value="<?php echo $row['facode']; ?>" name="facode[<?php echo $key; ?>]" type="hidden"><?php echo get_Facility_Name($row['facode']); ?></label></td>
				<td style="padding-top: 10px;"><input class="gp gpyes editRadio" name="report_submitted[<?php echo $key; ?>]" <?php if((isset($zero_report)) && ($row['report_submitted'] == 1)){ echo 'checked="checked"'; } else { echo ''; } ?> value="1" type="radio"></td>
				<td style="padding-top: 10px;"><input class="gp gpno editRadio" name="report_submitted[<?php echo $key; ?>]" <?php if((isset($zero_report)) && ($row['report_submitted'] == 0)){ echo 'checked="checked"'; } else { echo ''; } ?> value="0" type="radio"></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['aefi_cases'] ; }else { } ?>" name="aefi_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['aefi_deaths'] ; }else { } ?>" name="aefi_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['pertusis_cases'] ; }else { } ?>" name="pertusis_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['pertusis_deaths'] ; }else { } ?>" name="pertusis_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['nnt_cases'] ; }else { } ?>" name="nnt_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['nnt_deaths'] ; }else { } ?>" name="nnt_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['afp_cases'] ; }else { } ?>" name="afp_cases[<?php echo $key; ?>]"  type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['afp_deaths'] ; }else { } ?>" name="afp_deaths[<?php echo $key; ?>]"  type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['diphtheria_cases'] ; }else { } ?>" name="diphtheria_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['diphtheria_deaths'] ; }else { } ?>" name="diphtheria_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['measle_cases'] ; }else { } ?>" name="measle_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['measle_deaths'] ; }else { } ?>" name="measle_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['hepatits_cases'] ; }else { } ?>" name="hepatits_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['hepatits_deaths'] ; }else { } ?>" name="hepatits_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['tb_cases'] ; }else { } ?>" name="tb_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['tb_deaths'] ; }else { } ?>" name="tb_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['sari_cases'] ; }else { } ?>" name="sari_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['sari_deaths'] ; }else { } ?>" name="sari_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['diarrhea_cases'] ; }else { } ?>" name="diarrhea_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['diarrhea_deaths'] ; }else { } ?>" name="diarrhea_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['df_cases'] ; }else { } ?>" name="df_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['df_deaths'] ; }else { } ?>" name="df_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['dhf_cases'] ; }else { } ?>" name="dhf_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['dhf_deaths'] ; }else { } ?>" name="dhf_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['cl_cases'] ; }else { } ?>" name="cl_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['cl_deaths'] ; }else { } ?>" name="cl_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['cchf_cases'] ; }else { } ?>" name="cchf_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['cchf_deaths'] ; }else { } ?>" name="cchf_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['anthrax_cases'] ; }else { } ?>" name="anthrax_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['anthrax_deaths'] ; }else { } ?>" name="anthrax_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['meningitis_cases'] ; }else { } ?>" name="meningitis_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['meningitis_deaths'] ; }else { } ?>" name="meningitis_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['vl_cases'] ; }else { } ?>" name="vl_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['vl_deaths'] ; }else { } ?>" name="vl_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['mal_cases'] ; }else { } ?>" name="mal_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['mal_deaths'] ; }else { } ?>" name="mal_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['pneumonia_cases'] ; }else { } ?>" name="pneumonia_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['pneumonia_deaths'] ; }else { } ?>" name="pneumonia_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['dogbite_cases'] ; }else { } ?>" name="dogbite_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['dogbite_deaths'] ; }else { } ?>" name="dogbite_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['bd_cases'] ; }else { } ?>" name="bd_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['bd_deaths'] ; }else { } ?>" name="bd_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['aids_cases'] ; }else { } ?>" name="aids_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['aids_deaths'] ; }else { } ?>" name="aids_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['avh_cases'] ; }else { } ?>" name="avh_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['avh_deaths'] ; }else { } ?>" name="avh_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['tf_cases'] ; }else { } ?>" name="tf_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['tf_deaths'] ; }else { } ?>" name="tf_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['scabies_cases'] ; }else { } ?>" name="scabies_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['scabies_deaths'] ; }else { } ?>" name="scabies_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['ad_cases'] ; }else { } ?>" name="ad_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['ad_deaths'] ; }else { } ?>" name="ad_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>

				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['covid_cases'] ; }else { } ?>" name="covid_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['covid_deaths'] ; }else { } ?>" name="covid_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>

				<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['undis_cases'] ; }else { } ?>" name="undis_cases[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['undis_deaths'] ; }else { } ?>" name="undis_deaths[<?php echo $key; ?>]" type="text" <?php if((isset($zero_report)) && ($row['report_submitted'] != 1)){ echo 'readonly="readonly"'; } else { echo ''; } ?> ></td>
				
				<!--	<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['urti_cases'] ; }else { } ?>" name="urti_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['urti_deaths'] ; }else { } ?>" name="urti_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
								<!--<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['diarrhea_great_five_cases'] ; }else { } ?>" name="diarrhea_great_five_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
					<!--<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['diarrhea_great_five_deaths'] ; }else { } ?>" name="diarrhea_great_five_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
									<!---->
															<!--	<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['puo_cases'] ; }else { } ?>" name="puo_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['puo_deaths'] ; }else { } ?>" name="puo_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
					<!--<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['psy_cases'] ; }else { } ?>" name="psy_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['psy_deaths'] ; }else { } ?>" name="psy_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
									<!--<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['pneumonia_great_five_cases'] ; }else { } ?>" name="pneumonia_great_five_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
					<!--<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['pneumonia_great_five_deaths'] ; }else { } ?>" name="pneumonia_great_five_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
					<!--<td class="cases"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['others_cases'] ; }else { } ?>" name="others_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
					<td class="deaths"><input class="form-control zp numberclass" value="<?php if(isset($zero_report)){ echo $row['others_deaths'] ; }else { } ?>" name="others_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
			</tr>
		<?php 
			}
		}
		  
		  else{    
			  //echo '<pre>';print_r($resultFac);exit;
			  foreach($resultFac as $key => $row){ 
			
			?>
            <tr>
				<td><label><input value="" name="all_values[<?php echo $key; ?>]" type="hidden">
				<input value="<?php echo $row['facode']; ?>" name="facode[<?php echo $key; ?>]" type="hidden"><?php echo $row['fac_name']; ?></label></td>
				<td style="padding-top: 10px;"><input class="gp gpyes" name="report_submitted[<?php echo $key; ?>]" value="1" type="radio"></td>
				<td style="padding-top: 10px;"><input class="gp gpno" name="report_submitted[<?php echo $key; ?>]" checked="checked" value="0" type="radio"></td>
				<td class="cases"><input class="form-control zp numberclass" name="aefi_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="aefi_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="pertusis_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="pertusis_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="nnt_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="nnt_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<!--<td class="cases"><input class="form-control zp numberclass" name="diarrhea_great_five_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
				<!--<td class="deaths"><input class="form-control zp numberclass" name="diarrhea_great_five_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
				<td class="cases"><input class="form-control zp numberclass" name="afp_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="afp_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="diphtheria_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="diphtheria_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="measle_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="measle_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<!--<td class="cases"><input class="form-control zp numberclass" name="avh_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="avh_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
				<td class="cases"><input class="form-control zp numberclass" name="hepatits_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="hepatits_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="tb_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="tb_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="sari_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="sari_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="diarrhea_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="diarrhea_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="df_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="df_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="dhf_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="dhf_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="cl_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="cl_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="cchf_cases_cases[<?php echo $key; ?>]"  type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="cchf_deaths[<?php echo $key; ?>]"  type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="anthrax_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="anthrax_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="meningitis_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="meningitis_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="vl_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="vl_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			    <td class="cases"><input class="form-control zp numberclass" name="mal_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="mal_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			<!--	<td class="cases"><input class="form-control zp numberclass" name="puo_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="puo_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
				<td class="cases"><input class="form-control zp numberclass" name="pneumonia_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="pneumonia_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="dogbite_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="dogbite_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="bd_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="bd_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<!--<td class="cases"><input class="form-control zp numberclass" name="aids_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="aids_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
				<td class="cases"><input class="form-control zp numberclass" name="aids_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="aids_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="avh_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="avh_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<!--<td class="cases"><input class="form-control zp numberclass" name="pneumonia_great_five_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="pneumonia_great_five_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="sari_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="sari_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
				<td class="cases"><input class="form-control zp numberclass" name="tf_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="tf_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<!--<td class="cases"><input class="form-control zp numberclass" name="scabies_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="scabies_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>-->
				
				<td class="cases"><input class="form-control zp numberclass" name="scabies_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="scabies_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="ad_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="ad_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="covid_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="covid_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="cases"><input class="form-control zp numberclass" name="undis_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				<td class="deaths"><input class="form-control zp numberclass" name="undis_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>

			</tr>
           	<?php
			  }
		  }
		  ?>
		</tbody>
        </table>
      </div>  
        
        <div class="row">
         	<hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
				<button style="background:#008d4c;" type="submit" id="save" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
				<button style="background:#008d4c;" type="submit" name="is_temp_saved" id="myCoolForm" value="0" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Submit Form  </button>
				<button style="background: #008d4c;" type="reset" class="btn btn-primary btn-md"><i class="fa fa-repeat"></i> Reset Form </button>
				<a href="<?php echo base_url(); ?>Zero-Reporting" style="background: #008d4c" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>
      </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--end of body container-->
<script>
	/* $(function () {
		var options = {
			format : "dd-mm-yyyy",
			startDate : "01-01-1925",
			endDate: "12-12-2000"
		};
		$('.dp').datepicker(options);
		
	}); */
	function checkDate() {
		var week = $("#week").val();
		var year = $('#year').val();
		var distcode = $('#distcode').val();

		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/check_week_zero_report', 
			data:'epiweek='+week+'&year='+year+'&distcode='+distcode,
			success: function(data){
				if(data!=''){
					var d = data.trim();
					if(d=='yes'){
						var r = confirm('Report For Selected Month Already Exist');
						if (r == true) {
							window.history.go(-1);
						} 
						else {
							$("#week")[0].selectedIndex = 0;
							$('#date_from').val("");
							$('#date_to').val("");
							$('#week').trigger("change");
						}
					}
					else{

					}
				}
			}
		});	
	}
$(document).ready(function(){
	<?php if(!isset($zero_report)){ ?>
		$(document).on('click','.gp,.gpyes,.gpno',function(){
			var row = $(this).parent().parent().index();
			var v = $(this).val();
			
			if(v == 1){
				$('#myTable tr:eq('+row+') td.cases').find('input').removeAttr("readonly", "readonly");
				$('#myTable tr:eq('+row+') td.cases').find('input').val(0);
				$('#myTable tr:eq('+row+') td.deaths').find('input').val(0);
				$('#myTable tr:eq('+row+') td.cases :input').on("keyup",function(){
					if($(this).val() > 0){
						$(this).closest('td').next().find('input').removeAttr("readonly", "readonly");
						$('#myTable tr:eq('+row+') td.deaths :input').on("keyup",function(){
							var r = parseInt($(this).closest('td').prev().find('input').val());
							var b = parseInt($(this).val());
							if(b > r){
								//alert('Deaths should be equal or less than cases');
								$(this).val(0);
								alert('Deaths should be equal or less than cases!');
								$(this).css("color","#FFF");
							}
							else{
								$(this).css("background-color","#FFF");
								$(this).css("color","#000");
							}
						});
					}
					else{
						$(this).closest('td').next().find('input').attr("readonly", "readonly");
					}
				});
			}
			else{
				$('#myTable tr:eq('+row+') td.cases').find('input').attr("readonly", "readonly");
				$('#myTable tr:eq('+row+') td.cases').find('input').val('');
				$('#myTable tr:eq('+row+') td.deaths').find('input').val('');
			}
		});
	<?php } ?>

	<?php if(isset($zero_report)) { ?>
		$(document).on('click','.gp,.gpyes,.gpno',function(){
			var row = $(this).parent().parent().index();
			var v = $(this).val();
			
			if(v == 1){
				$('#myTable tr:eq('+row+') td.cases').find('input').removeAttr("readonly", "readonly");
				//$('#myTable tr:eq('+row+') td.deaths').find('input').removeAttr("readonly", "readonly");
				$('#myTable tr:eq('+row+') td.cases').find('input').val(0);
				$('#myTable tr:eq('+row+') td.deaths').find('input').val(0);
				
			}
			else{
				$('#myTable tr:eq('+row+') td.cases, td.deaths').find('input').attr("readonly", "readonly");
				$('#myTable tr:eq('+row+') td.cases').find('input').val('');
				$('#myTable tr:eq('+row+') td.deaths').find('input').val('');
			}
		});


		$('#myTable tr td.cases :input').on("keyup",function(){
			if($(this).val() > 0){
				$(this).closest('td').next().find('input').removeAttr("readonly", "readonly");
				$('#myTable tr td.deaths :input').on("keyup",function(){
					var r = parseInt($(this).closest('td').prev().find('input').val());
					var b = parseInt($(this).val());
					if(b > r){
						//alert('Deaths should be equal or less than cases');
						$(this).val(0);
						alert('Deaths should be equal or less than cases!');
						$(this).css("color","#FFF");
					}
					else{
						$(this).css("background-color","#FFF");
						$(this).css("color","#000");
					}
				});
			}
			else{
				$(this).closest('td').next().find('input').attr("readonly", "readonly");
			}
		});


		//$('.gp').trigger("click");
	<?php } ?>

	<?php if(!isset($zero_report)){ ?>
		var year = $("#year").val();
		var report = "zero_report";
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeks',
			data:'year='+year+'&report='+report,
			success: function(response){
				$('#week').html(response);
				document.getElementById("year").style.borderColor = "";
				$('#week').trigger("change");
			}
		});
	<?php } ?>
	
/* //code to disable save button starts here;
					$(document).on('change','#week',function(){
				$('#save').attr('disabled', 'disabled');
				function updateFormEnabled() {
					if (verifyAdSettings()) {
						//alert("usman");
						$('#save').attr('disabled', false);
					} else {
						//alert("danish");
						$('#save').attr('disabled', 'disabled');
					}
				}
				function verifyAdSettings() {
					if ($('#week').val() != null) {
						return true;
					} else {
						return false
					}
				}
				$('#week').change(updateFormEnabled);
					});
//code to disable save button ends here

//code to disable submit button starts here
				$(document).on('change','#week',function(){
				$('#myCoolForm').attr('disabled', 'disabled');
				function updateForm() {
					if (verifyAdSettings()) {
						//alert("usman");
						$('#myCoolForm').attr('disabled', false);
					} else {
						//alert("danish");
						$('#myCoolForm').attr('disabled', 'disabled');
					}
				}
				function verifyAdSettings() {
					if ($('#week').val() != null) {
						return true;
					} else {
						return false
					}
				}
				$('#week').change(updateForm);
					});
//code to disable submit ends here */
	
		$(document).on('change','#year',function(){
			var fu1 = document.getElementById("week");
			var year = $("#year").val();
			var week = $("#week").val();
			var report = "zero_report";
			if(year == ""){
				$("#week").html("");
				$('#date_from').val("");
				$('#date_to').val("");
			}
			else{
				$.ajax({
					type: 'POST',
					url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeks',
					data:'year='+year+'&report='+report,
					success: function(response){
						if(response == 1){
							var curr_year = new Date().getFullYear(); //Exchange year with current year.
							document.getElementById("year").style.borderColor = "red";
							//alert("Year is restricted to current and previouse!");
							alert("Year is restricted to current and previous!");
							$.ajax({
								type: 'POST',
								url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeks', 
								data:'year='+curr_year,
								success: function(response){
									$('#week').html(response);
									$('#year').val(curr_year);
									var year = $("#year").val();
									var week = $("#week").val();
									document.getElementById("year").style.borderColor = "";
									$.ajax({
										type: 'POST',
										url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeksDates', 
										data:'epiweek='+week+'&year='+year,
										success: function(response){
											var obj = JSON.parse(response);
											$('#date_from').val(obj.startDate);
											$('#date_to').val(obj.EndDate);
										}
									});
									checkDate();
								}
							});
						}else{
							$('#week').html(response);
							document.getElementById("year").style.borderColor = "";
							week = $('#week').val();
							$.ajax({
								type: 'POST',
								url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeksDates', 
								data:'epiweek='+week+'&year='+year,
								success: function(response){
									var obj = JSON.parse(response);
									$('#date_from').val(obj.startDate);
									$('#date_to').val(obj.EndDate);
								}
							});
							checkDate();
						}
					}
				});
			}
		});
	
	$(document).on('change','#week',function(){
		var week = $("#week").val();
		var year = $('#year').val();
		if(week == 0 && year !=""){
			$('#date_from').val("");
			$('#date_to').val("");
		}else{
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeksDates', 
				data:'epiweek='+week+'&year='+year,
				success: function(response){
					var obj = JSON.parse(response);
					$('#date_from').val(obj.startDate);
					$('#date_to').val(obj.EndDate);
				}
			});
			<?php if( ! isset($zero_report)){ ?>
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getFunctionalFacilitiesForSelectedWeek',
				data:'year='+year+'&week='+week,
				success: function(response){
					$('#myTable').html(response);
				}
			});
			<?php } ?>
		<?php if(!isset($zero_report)){ ?>
			 checkDate();
		<?php }?>
		}
	});
	<?php if(!isset($zero_report)){ ?>
	
	$(document).on('change','.datefrom',function(){
		var week = $("#week").val();
		var date_from = $('.datefrom').val();
		var year = date_from.split("-");
		// if years options are empty
		var yearCheck = $("#year").val();
		if(yearCheck == ""){
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getYears', 
				data:'year='+year[2],
				success: function(response){
					$('#year').html(response);
				}
			});
		}
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/get_idsWeeks', 
			data:'date_from='+date_from+'&year='+year[2],
			success: function(response){
				$('#week').html(response);
				$('#week').trigger("change");
			}
		});
		checkDate();
	});
	$(document).on('change','.dateto',function(){
		var week = $("#week").val();
		var date_to = $('.dateto').val();
		var year = date_to.split("-");
		// if years options are empty
		var yearCheck = $("#year").val();
		if(yearCheck == ""){
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getYears', 
				data:'year='+year[2],
				success: function(response){
					$('#year').html(response);
				}
			});
		}
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/get_idsWeeks', 
			data:'date_to='+date_to+'&year='+year[2],
			success: function(response){
				$('#week').html(response);
				$('#week').trigger("change");
			}
		});
		checkDate();
	});

	<?php } ?>
	
	<?php if(isset($zero_report)){ ?>
		$('#date_from').attr("disabled","disabled") ;
		$('#date_to').attr("disabled","disabled") ;
	<?php } ?>
});
//code to disable starts
//$('#save').prop('disabled', 'disabled');
//$('#myCoolForm').prop('disabled', 'disabled');
$(document).on('change','#week,#year',function(){
    if (buttonsDisable($(this).val())) {
		//alert(buttonsDisable());
		$('#myCoolForm').prop('disabled', false);
        $('#save').prop('disabled', false);
		//}
    } else {
		$('#myCoolForm').prop('disabled', true);
        $('#save').prop('disabled', true);
    }
});
function buttonsDisable(e) {
    if (e > 0) {
        return true;
    } else {
        return false;
    }
}
//code to disable ends
////Code For Save Form With Control+S Event//////////////
	$(document).on('keydown', function(e){
		if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
	$(document).on('click','#checkall',function(){
		$('.gpyes').each(function(){
			$(this).prop('checked',true);
			$(this).trigger('click');
		});
		$(this).addClass('hide');
		$('#uncheckall').removeClass('hide');
	});
	$(document).on('click','#uncheckall',function(){
		$('.gpno').each(function(){
			$(this).prop('checked',true);
			$(this).trigger('click');
		});
		$(this).addClass('hide');
		$('#checkall').removeClass('hide');
	});	

 </script>