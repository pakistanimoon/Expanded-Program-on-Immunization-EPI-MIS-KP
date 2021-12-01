<!--start of page content or body-->
<?php //sprint_r($data);?>
<div class="container bodycontainer">
	<?php echo $data['TopInfo']; ?>
	<div class="panel panel-primary">
		<div class="panel-body">
			<table class="table table-bordered table-condensed table-striped table-hover mytable">
				<thead>
					<tr>               
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Products</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Doses per Vial</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Opening Balance</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Received</th>
						<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Children Vaccinated/<br>Doses Administered</th>-->
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2"> Vials<br>Used</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Unusable<br>Vials</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Closing<br>Balance</th>
						<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Closing<br>Balance</th>-->
						<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Max. Stock Level</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Request<br>(I=H-G)</th>-->
						<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Replenishment</th>-->
					</tr>
					<tr>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Vials/Nos.</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Doses/Nos.</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Vials/Nos.</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Doses/Nos.</th>
						<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Doses/Nos.</th>-->
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Vials/Nos.</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Doses/Nos.</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Vials/Nos.</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Doses/Nos.</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Vials/Nos.</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Doses/Nos.</th>
						<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Vials/Nos.</th>-->
					</tr>
				</thead>
				<?php
			//	print_r($data['Name']);
				/* $vaccinesArray = array(
										'BCG-20' 			=> '20',
										'DIL-BCG-20' 		=> '',
										'bOPV' 			=> '20',
										'Pentavalent-1' 	=> '10',
										'Pneumococcal-2 (PCV10)'	=> '02',
										'Measles-10' 		=> '10',
										'DIL-Measles-10'	=> '',
										'TT-10' 		=> '10',
										'TT 20' 		=> '20',
										'Hep-B-10' => '10',
										'Hep-B-02' 			=> '10',
										'IPV-5' 			=> '10',
										'IPV-10' 			=> '10',
										'Rotarix' 			=> '',
										'AD Syringe 0.5ml ' => '',
										'AD Syringe 0.05ml  ' => '',
										'Recon. Syr 2ml  ' => '',
										'Recon. Syr 5ml ' => '',
										'Vitamin A Red Capsule' => '',
										'Vitamin A Blue Capsule' => '',
										'Safety Box' => '',
										'Dropper' => '',
										
									); */
									
				//unset($data['TopInfo']);unset($data['exportIcons']);unset($data['monthfrom']);unset($data['monthto']);
				
				//$dataValues = array_values($data[0]);
				//print_r($dataValues);
				?>
				<tbody>
					<?php
					//$i = 0; 
					foreach($consumption as $key => $val){
					?>
					<tr class="DrillDownRow">
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['item_name']; ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['number_of_doses']; ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo round(($val['opening'] / $val['number_of_doses']),0); ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['opening']; ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo round(($val['received'] / $val['number_of_doses']),0); ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['received']; ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo round($val['usedvials'],0); ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['useddose']; ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo round($val['unusedvials'],0); ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['unuseddose']; ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo round((($val['opening']+$val['received']-$val['useddose']-$val['unuseddose'])/$val['number_of_doses']),0); ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo round(((($val['opening']+$val['received']-$val['useddose']-$val['unuseddose'])/$val['number_of_doses'])*$val['number_of_doses']),2); ?></td>
						<!--<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo round($val['closing'],2); ?></td>
						<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo ($val['closing']*$val['number_of_doses']); ?></td>-->
					</tr>
					<?php 
						//$i+1;
						
					} 
					?>
				</tbody>
			</table>
		</div> <!--end of panel body-->
	</div> <!--end of panel panel-primary-->
</div><!--End of page content or body-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/bootstrap-3.1.1.min.js"></script>
 <!--fortooltip-->
<script type="text/javascript">
	$(document).ready(function(){ 
	//alert("danish");
		//$('.DrillDownRow').css('cursor','pointer');
	});
 	<?php if(!$this->input->post('export_excel'))
    {?>
	/* $(document).on('click','.DrillDownRow', function(){
		var code="";
		<?php if($this->session->District){ ?>
		code="<?php echo $this->session->District; ?>";
		<?php }  ?>
		var codeLength=code.toString().length;
		var vaccine= $(this).find("td:first-child").text();
		if(vaccine=="BCG")
			vaccine="cr_r1_";
		else if(vaccine=="DIL BCG")
			vaccine="cr_r2_";
		else if(vaccine=="bOPV")
			vaccine="cr_r3_";
		else if(vaccine=="Pentavalent")
			vaccine="cr_r4_";
		else if(vaccine=="Pneumococcal (PCV 10)")
			vaccine="cr_r5_";
		else if(vaccine=="Measles")
			vaccine="cr_r6_";
		else if(vaccine=="DIL Measles")
			vaccine="cr_r7_";
		else if(vaccine=="TT10")
			vaccine="cr_r8_";
		else if(vaccine=="TT20")
			vaccine="cr_r9_";
		else if(vaccine=="HBV (Birth dose)")
			vaccine="cr_r10_";
		else if(vaccine=="IPV")
			vaccine="cr_r11_";
		
		var demand_type= "f9";
		var monthfrom= "<?php echo $datefrom; ?>";
		//alert(monthfrom);
		var monthto= "<?php echo $dateto; ?>";
		var param = "drillDown";
		//var typeWise= "facility";
        if(codeLength == 3)
        {
			url = "<?php echo base_url();?>Reports/vaccine_demand/"+code+"/"+vaccine+"/"+demand_type+"/"+monthfrom+"/"+monthto+"/"+typeWise;
        }
		else
			url = "<?php echo base_url();?>Reports/vaccine_demand/"+vaccine+"/"+demand_type+"/"+monthfrom+"/"+monthto+"/"+param;
        var win = window.open(url,'_self');
        if(win)
        {
			//Browser has allowed it to be opened
			win.focus();
		}
		else
		{
			//Broswer has blocked it
			alert('Please allow popups for this site');
		}
    });
	 */
 <?php } ?>  


</script>

