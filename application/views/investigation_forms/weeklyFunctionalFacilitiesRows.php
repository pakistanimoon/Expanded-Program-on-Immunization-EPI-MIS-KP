<?php
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
		<td class="cases"><input class="form-control zp numberclass" name="afp_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="deaths"><input class="form-control zp numberclass" name="afp_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="cases"><input class="form-control zp numberclass" name="diphtheria_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="deaths"><input class="form-control zp numberclass" name="diphtheria_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="cases"><input class="form-control zp numberclass" name="measle_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="deaths"><input class="form-control zp numberclass" name="measle_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
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
		<td class="cases"><input class="form-control zp numberclass" name="pneumonia_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="deaths"><input class="form-control zp numberclass" name="pneumonia_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="cases"><input class="form-control zp numberclass" name="dogbite_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="deaths"><input class="form-control zp numberclass" name="dogbite_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="cases"><input class="form-control zp numberclass" name="bd_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="deaths"><input class="form-control zp numberclass" name="bd_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="cases"><input class="form-control zp numberclass" name="aids_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="deaths"><input class="form-control zp numberclass" name="aids_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="cases"><input class="form-control zp numberclass" name="avh_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="deaths"><input class="form-control zp numberclass" name="avh_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="cases"><input class="form-control zp numberclass" name="tf_cases[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
		<td class="deaths"><input class="form-control zp numberclass" name="tf_deaths[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
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