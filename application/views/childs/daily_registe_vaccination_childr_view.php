<style>
	td.th-heading{
		background:#8adcb6;
	}
	td label{
		margin-bottom:0px;
	}
</style>
<div class="container bodycontainer">
<?php
if($TopInfo!=''){
		echo $TopInfo;
	}

?>
<?php 
$total_bcg = $total_hepb = $total_opv0 = $total_opv1 = $total_opv2 = $total_opv3 = $total_penta1 = $total_penta2 = $total_penta3  = $total_ipv = $total_pcv1 = $total_pcv2 = $total_pcv3 = $total_rota1  = $total_rota2 = $total_measles1 = $total_measles2 = $total_tt1 = $total_tt2 = $total_tt3 = $total_tt4 = $total_tt5 = 0;
	foreach($Dailyresult as $key2 => $val2){
             $total_bcg = $total_bcg + ((isset($val2['bcg']) && $val2['bcg'] == $selectedDate)?1:0);
			 $total_hepb = $total_hepb + ((isset($val2['hepb']) && $val2['hepb'] == $selectedDate)?1:0);
			 $total_opv0 = $total_opv0 + ((isset($val2['opv0']) && $val2['opv0'] == $selectedDate)?1:0);
			 $total_opv1 = $total_opv1 + ((isset($val2['opv1']) && $val2['opv1'] == $selectedDate)?1:0);
			 $total_opv2 = $total_opv2 + ((isset($val2['opv2']) && $val2['opv2'] == $selectedDate)?1:0);
			 $total_opv3 = $total_opv3 + ((isset($val2['opv3']) && $val2['opv3'] == $selectedDate)?1:0);
			 $total_penta1 = $total_penta1 + ((isset($val2['penta1']) && $val2['penta1'] == $selectedDate)?1:0);
			 $total_penta2 = $total_penta2 + ((isset($val2['penta2']) && $val2['penta2'] == $selectedDate)?1:0);
			 $total_penta3 = $total_penta3 + ((isset($val2['penta3']) && $val2['penta3'] == $selectedDate)?1:0);
			 $total_ipv = $total_ipv + ((isset($val2['ipv']) && $val2['ipv'] == $selectedDate)?1:0);
			 $total_pcv1 = $total_pcv1 + ((isset($val2['pcv1']) && $val2['pcv1'] == $selectedDate)?1:0);
			 $total_pcv2 = $total_pcv2 + ((isset($val2['pcv2']) && $val2['pcv2'] == $selectedDate)?1:0);
			 $total_pcv3 = $total_pcv3 + ((isset($val2['pcv3']) && $val2['pcv3'] == $selectedDate)?1:0);
			 $total_rota1 = $total_rota1 + ((isset($val2['rota1']) && $val2['rota1'] == $selectedDate)?1:0);
			 $total_rota2 = $total_rota2 + ((isset($val2['rota2']) && $val2['rota2'] == $selectedDate)?1:0);
			 $total_measles1 = $total_measles1 + ((isset($val2['measles1']) && $val2['measles1'] == $selectedDate)?1:0);
			 $total_measles2 = $total_measles2 + ((isset($val2['measles2']) && $val2['measles2'] == $selectedDate)?1:0);
			 $total_tt1 = $total_tt1 + ((isset($val2['tt1']) && $val2['tt1'] == $selectedDate)?1:0);
			 $total_tt2 = $total_tt2 + ((isset($val2['tt2']) && $val2['tt2'] == $selectedDate)?1:0);
			 $total_tt3 = $total_tt3 + ((isset($val2['tt3']) && $val2['tt3'] == $selectedDate)?1:0);
			 $total_tt4 = $total_tt4 + ((isset($val2['tt4']) && $val2['tt4'] == $selectedDate)?1:0);
			 $total_tt5 = $total_tt5 + ((isset($val2['tt5']) && $val2['tt5'] == $selectedDate)?1:0);
	}//exit;
	
	?>
				
				<div class="row">
					<div class="col-md-4">
						<table class="table rpt-tmp-table" >
							<tbody>
							<tr>
								<td colspan="2" class="th-heading"><label>At Birth</label></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>BCG</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_bcg; ?></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>HEP-B</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_hepb; ?></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>OPV-0</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_opv0; ?></td>
							</tr>
							</tbody>
						</table>
					</div>
					
					<div class="col-md-4">
						<table class="table rpt-tmp-table" >
							<tbody>
							<tr>
								<td colspan="2" class="th-heading"><label>At Six Week</label></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>OPV-1</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_opv1; ?></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>Rota-1</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_rota1; ?></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>Penta-1</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_penta1; ?></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>PCV-1</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_pcv1; ?></td>
							</tr>
							</tbody>
						</table>
					</div>
					
					<div class="col-md-4">

						<table class="table rpt-tmp-table" >
							<tbody>
							<tr>
								<td colspan="2" class="th-heading"><label>At Ten Week</label></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>OPV-2</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_opv2; ?></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>Rota-2</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_rota2; ?></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>Penta-2</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_penta2; ?></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>PCV-2</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_pcv2; ?></td>
							</tr>
							</tbody>
						</table>

					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<table class="table rpt-tmp-table" >
							<tbody>
							<tr>
								<td colspan="2" class="th-heading"><label>At Fourteen Week</label></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>OPV-3</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_opv3; ?></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>Penta-3</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_penta3; ?></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>IPV</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_ipv; ?></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>Penta-3</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_penta3; ?></td>
							</tr>
							</tbody>
						</table>
					</div>
					
					<div class="col-md-4">
						<table class="table rpt-tmp-table" >
							<tbody>
							<tr>
								<td colspan="2" class="th-heading"><label>At Nine Months</label></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>Measles-1</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_measles1; ?></td>
							</tr>
							<tr><td colspan="2"></td></tr>
							<tr>
								<td colspan="2" class="th-heading"><label>At Fifteen Months</label></td>
							</tr>
							<tr>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><label>Measles-2</label></td>
								<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_measles2; ?></td>
							</tr>
							</tbody>
						</table>
					</div>
					
					<div class="col-md-4">

						<table class="table rpt-tmp-table" >
							<tbody>
								<tr>
									<td colspan="2" class="th-heading"><label>TT</label></td>
								</tr>
								<tr>
									<td style='text-align:center; border: 1px solid black;' class='text-center'><label>I</label></td>
									<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_tt1; ?></td>
								</tr>
								<tr>
									<td style='text-align:center; border: 1px solid black;' class='text-center'><label>II</label></td>
									<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_tt2; ?></td>
								</tr>
								<tr>
									<td style='text-align:center; border: 1px solid black;' class='text-center'><label>III</label></td>
									<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_tt3; ?></td>
								</tr>
								<tr>
									<td style='text-align:center; border: 1px solid black;' class='text-center'><label>IV</label></td>
									<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_tt4; ?></td>
								</tr>
								<tr>
									<td style='text-align:center; border: 1px solid black;' class='text-center'><label>V</label></td>
									<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $total_tt5; ?></td>
								</tr>
							</tbody>
						</table>

					</div>
				</div>
				
	<div id="parent">
		<table id="fixTable" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Card No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Paternity with Nationality</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Complete Address</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Date of Birth</th>
					
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="22">Date of Vaccination
					<?php if(isset($Dailyresult[0]['submitteddate']))
					echo date("M d, Y", strtotime($monthdate)); ?>
					</th>
				</tr>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">BCG</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black"  rowspan="2">HEPB</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black"  colspan="4">OPV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black"  colspan="3">Pentavalent</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black"  colspan="3">PCV10</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black"  colspan="">IPV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black"  colspan="2">Rota</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black"  colspan="2">Measles</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black"  colspan="5">TT</th>
				</tr>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >0</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >1</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >2</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >3</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >1</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >2</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >3</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >1</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >2</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >3</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" ></th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >1</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >2</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >1</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >2</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >III</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >IV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" >V</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($Dailyresult as $key => $val)
			{ 
			?>
				<tr class="DrillDownRow" style="cursor: pointer;">
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $key+1; ?>
					<input type="hidden" name="child_registration_no" data-type="<?php echo (isset($val['child_registration_no']))?'child':'mother'; ?>" value="<?php echo (isset($val['child_registration_no']))?$val['child_registration_no']:((isset($val['mother_registration_no']))?$val['mother_registration_no']:''); ?>" />
					</td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo $val['cardno']; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo (isset($val['nameofchild']))?$val['nameofchild']:(isset($val['mother_name'])?$val['mother_name']:''); ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo (isset($val['fathername']))?$val['fathername']:(isset($val['husband_name'])?$val['husband_name']:''); ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo (isset($val['housestreet']))?$val['housestreet']:(isset($val['village'])?$val['village']:''); ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php echo (isset($val['dateofbirth']))?date("M d, Y", strtotime($val['dateofbirth'])):''; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['bcg'])) && $val['bcg'] != NULL && $val['bcg'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;"> 	&#x2714; </p>';}else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['hepb'])) && $val['hepb'] != NULL && $val['hepb'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>';}else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['opv0'])) && $val['opv0'] != NULL && $val['opv0'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>';}else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['opv1'])) && $val['opv1'] != NULL && $val['opv1'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>';}else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['opv2'])) && $val['opv2'] != NULL && $val['opv2'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					} ?></td> 
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['opv3'])) && $val['opv3'] != NULL && $val['opv3'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['penta1'])) && $val['penta1'] != NULL && $val['penta1'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['penta2'])) && $val['penta2'] != NULL && $val['penta2'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['penta3'])) && $val['penta3'] != NULL && $val['penta3'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['pcv1'])) && $val['pcv1'] != NULL && $val['pcv1'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['pcv2'])) && $val['pcv2'] != NULL && $val['pcv2'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['pcv3'])) && $val['pcv3'] != NULL && $val['pcv3'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['ipv'])) && $val['ipv'] != NULL && $val['ipv'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['rota1'])) && $val['rota1'] != NULL && $val['rota1'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['rota2'])) && $val['rota2'] != NULL && $val['rota2'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['measles1'])) && $val['measles1'] != NULL && $val['measles1'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if((isset($val['measles2'])) && $val['measles2'] != NULL && $val['measles2'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if(isset($val['tt1']) && $val['tt1'] != NULL && $val['tt1'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if(isset($val['tt1']) && $val['tt2'] != NULL && $val['tt2'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if(isset($val['tt1']) && $val['tt3'] != NULL && $val['tt3'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if(isset($val['tt1']) && $val['tt4'] != NULL && $val['tt4'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center'><?php if(isset($val['tt1']) && $val['tt5'] != NULL && $val['tt5'] == $selectedDate){
					echo '<p class="text-center" title="'.date("M d, Y",strtotime($selectedDate)).'" style="color:green;font-weight: bold;font-size: 16px;">&#x2714; </p>' ; }else{
						echo '';
					}?></td>
				</tr>
			<?php }?>
			</tbody>
		</table>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#fixTable").tableHeadFixer({"left" : 3});
	});
	
<?php  if(!$this->input->post('export_excel')){ ?>

  $('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
        var cardno = $(this).find("input[name='child_registration_no']:eq(0)").val();
		var type = $(this).find("input[name='child_registration_no']:eq(0)").data('type');
        var url = ''; 
		if(type=='child'){
			url = "<?php echo base_url();?>childs/Reports/child_cardview?cardno="+cardno;
		}else{
			url = "<?php echo base_url();?>childs/Reports/mother_cardview?cardno="+cardno;
		}
        var win = window.open(url,'_blank');
        if(win){
          //Browser has allowed it to be opened
          win.focus();
        }else{
          //Broswer has blocked it
          alert('Please allow popups for this site');
        }
      });
  </script>
<?php } ?>	
	
</script>