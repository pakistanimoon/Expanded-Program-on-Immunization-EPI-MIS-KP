<?php if( ! $this -> input -> post('export_excel')){ ?>  
				<div class="panel-body">
					<form method="post" id="filter-form">
						<div class="row" style="width:100%; padding:4px 17px">
						<!--	<div class="col-md-2 col-md-offset-1">
								<label>Tehsil:</label>
							</div> 
							<div class="col-md-3">
								<?php
									$distcode = $this-> session-> District; 
									$query="SELECT distinct tcode, tehsilname(tcode) as tehsil from tehsil where distcode='{$distcode}' order by tehsil ASC";
									$result = $this->db->query($query)->result_array();
								?>
								<select class="form-control filter-status" name="tcode" id="ticode">
									<option value="">-- Select --</option>
								<?php foreach ($result as $key => $value) { ?>
									<option value="<?php echo $value['tcode']; ?>"><?php echo $value['tehsil']; ?></option>
									<?php } ?>
								</select>
							</div>-->
						<!--	<div class="col-md-2 col-md-offset-1">
								<label>Union Council:</label>
							</div>
							<div class="col-md-3">
								<?php
									$distcode = $this-> session-> District; 
									$query="SELECT distinct uncode ,un_name,unname(uncode) as unioncouncil from unioncouncil where distcode='{$distcode}' order by un_name ASC";
									$result = $this->db->query($query)->result_array();
								?>
								<select class="form-control filter-status" name="uncode" id="uncode">
									<option value="">-- Select --</option>
								<?php foreach ($result as $key => $value) { ?>
									<option value="<?php echo $value['uncode']; ?>"><?php echo $value['unioncouncil']; ?></option>
									<?php } ?>
								</select>
							</div>
							</div>-->
						</div>
<div class="container bodycontainer">
<?php 
	if($TopInfo!=''){
		echo $TopInfo;
	}
?>
<style>
td{
	padding:4px !important;
}
</style>
	<div id="parent">
<?php } ?>
		<table id="fixTable" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Action</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Card No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Gender</th>
								  
							  
								
																				  
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Paternity with Nationality</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">UnionCouncil</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Village</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Complete Address</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Contact</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Date of Birth</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" colspan="17" style="text-align:center">Date of Vaccination</th>
				</tr>
				<tr >
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="2">BCG</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="2">HEPB</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" colspan="4">OPV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" colspan="3">Pentavalent</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" colspan="3">PCV10</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" colspan="">IPV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" colspan="2">Rota</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" colspan="2">Measles</th>
				</tr>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">0</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">1</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">2</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">3</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">1</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">2</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">3</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">1</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">2</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">3</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black"></th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">1</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">2</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">1</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">2</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$startpoint = isset($startpoint)?$startpoint:0;
			foreach($PVRresult as $key => $val){ ?>
				<tr style="cursor: pointer;">
				    <!--<input type="hidden" name="child_registration_no" value="<?php echo $val['child_registration_no']; ?>" />-->
				     <td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'>
														  
		 
						<a target="_blank" href="<?php echo base_url('Reports/ChildRegistrationEdit').'/'.$val['recno']; ?>"><i class="fa fa-edit btn btn-primary btn-xs" style="padding:1px 1px !important;"></i></a>
						<a class="delrecord" data-recno="<?php echo $val['recno']; ?>"><i class="fa fa-trash btn btn-danger btn-xs" style="padding:1px 1px !important;"></i></a>
					</td>
					
				    <td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'>
						<!--<?php echo $key+1; ?>-->
						<?php echo ++$startpoint; ?>
						<input type="hidden" name="child_registration_no" value="<?php echo $val['child_registration_no']; ?>" />
					</td>
					<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'><?php echo $val['childcode']; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'><?php echo $val['name_of_child']; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'><?php echo $val['Gender']; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'><?php echo $val['fname']; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'><?php echo $val['unioncouncil']; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'><?php echo $val['villagemohallah']; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'><?php echo $val['address']; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'><?php echo $val['contactno']; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'><?php echo (isset($val['date_of_birth']) && $val['date_of_birth'] != NULL)?date("M d, Y", strtotime($val['date_of_birth'])):''; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'><?php echo (isset($val['bcg']) && $val['bcg'] != NULL)?date("M d, Y", strtotime($val['bcg'])):''; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'><?php echo (isset($val['hepb']) && $val['hepb'] != NULL)?date("M d, Y", strtotime($val['hepb'])):''; ?></td>
					<td style='text-align:center; border: 1px solid black;' class='text-center DrillDownRow'><?php echo (isset($val['opv0']) && $val['opv0'] != NULL)?date("M d, Y", strtotime($val['opv0'])):''; ?></td>
					<?php if(isset($defaulters) && $defaulters == 1){ ?>
					
					
					
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('opv1',$val['date_of_birth']); echo ($val['opv1'] != NULL)?'green':(($doseResult == NULL || ($val['opv2'] != NULL || $val['opv3'] != NULL))?'grey':'red'); ?>"><?php echo ($val['opv1'] != NULL)?date("M d, Y", strtotime($val['opv1'])):(($doseResult == NULL || ($val['opv2'] != NULL || $val['opv3'] != NULL))?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('opv2',$val['opv1']); echo ($val['opv2'] != NULL)?'green':(($doseResult == NULL || $val['opv3'] != NULL)?'grey':'red'); ?>"><?php echo ($val['opv2'] != NULL)?date("M d, Y", strtotime($val['opv2'])):(($doseResult == NULL || $val['opv3'] != NULL)?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('opv3',$val['opv2']); echo ($val['opv3'] != NULL)?'green':(($doseResult == NULL)?'grey':'red'); ?>"><?php echo ($val['opv3'] != NULL)?date("M d, Y", strtotime($val['opv3'])):(($doseResult == NULL)?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('penta1',$val['date_of_birth']); echo ($val['penta1'] != NULL)?'green':(($doseResult == NULL || ($val['penta2'] != NULL || $val['penta3'] != NULL))?'grey':'red'); ?>"><?php echo ($val['penta1'] != NULL)?date("M d, Y", strtotime($val['penta1'])):(($doseResult == NULL || ($val['penta2'] != NULL || $val['penta3'] != NULL))?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('penta2',$val['penta1']); echo ($val['penta2'] != NULL)?'green':(($doseResult == NULL || $val['penta3'] != NULL)?'grey':'red'); ?>"><?php echo ($val['penta2'] != NULL)?date("M d, Y", strtotime($val['penta2'])):(($doseResult == NULL || $val['penta3'] != NULL)?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('penta3',$val['penta2']); echo ($val['penta3'] != NULL)?'green':(($doseResult == NULL)?'grey':'red'); ?>"><?php echo ($val['penta3'] != NULL)?date("M d, Y", strtotime($val['penta3'])):(($doseResult == NULL)?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('pcv1',$val['date_of_birth']); echo ($val['pcv10_1'] != NULL)?'green':(($doseResult == NULL || ($val['pcv10_2'] != NULL && $val['pcv10_3'] != NULL))?'grey':'red'); ?>"><?php echo ($val['pcv10_1'] != NULL)?date("M d, Y", strtotime($val['pcv10_1'])):(($doseResult == NULL || ($val['pcv10_2'] != NULL && $val['pcv10_3'] != NULL))?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('pcv2',$val['pcv10_1']); echo ($val['pcv10_2'] != NULL)?'green':(($doseResult == NULL || $val['pcv10_3'] != NULL)?'grey':'red'); ?>"><?php echo ($val['pcv10_2'] != NULL)?date("M d, Y", strtotime($val['pcv10_2'])):(($doseResult == NULL || $val['pcv10_3'] != NULL)?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('pcv3',$val['pcv10_2']); echo ($val['pcv10_3'] != NULL)?'green':(($doseResult == NULL)?'grey':'red'); ?>"><?php echo ($val['pcv10_3'] != NULL)?date("M d, Y", strtotime($val['pcv10_3'])):(($doseResult == NULL)?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('ipv',$val['date_of_birth']); echo ($val['ipv'] != NULL)?'green':(($doseResult == NULL)?'grey':'red'); ?>"><?php echo ($val['ipv'] != NULL)?date("M d, Y", strtotime($val['ipv'])):(($doseResult == NULL)?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('rota1',$val['date_of_birth']); echo ($val['rota1'] != NULL)?'green':(($doseResult == NULL || $val['rota2'] != NULL)?'grey':'red'); ?>"><?php echo ($val['rota1'] != NULL)?date("M d, Y", strtotime($val['rota1'])):(($doseResult == NULL || $val['rota2'] != NULL)?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('rota2',$val['rota1']); echo ($val['rota2'] != NULL)?'green':(($doseResult == NULL)?'grey':'red'); ?>"><?php echo ($val['rota2'] != NULL)?date("M d, Y", strtotime($val['rota2'])):(($doseResult == NULL)?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('measles1',$val['date_of_birth']); echo ($val['measles1'] != NULL)?'green':(($doseResult == NULL || $val['measles2'] != NULL)?'grey':'red'); ?>"><?php echo ($val['measles1'] != NULL)?date("M d, Y", strtotime($val['measles1'])):(($doseResult == NULL || $val['measles2'] != NULL)?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<td class='text-center DrillDownRow' style="text-align:center; border: 1px solid black; white-space:nowrap;color:#FFF;background-color:<?php $doseResult = dueDoses('measles2',$val['date_of_birth']); echo ($val['measles2'] != NULL)?'green':(($doseResult == NULL)?'grey':'red'); ?>"><?php echo ($val['measles2'] != NULL)?date("M d, Y", strtotime($val['measles2'])):(($doseResult == NULL)?'':date("M d, Y", strtotime($doseResult))); ?></td>
					<?php }else{ ?>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['opv1'] != NULL && $val['opv1'] < date('Y-m-d', strtotime($val['date_of_birth']. ' + 43 days')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['opv1']) && $val['opv1'] != NULL)?date("M d, Y", strtotime($val['opv1'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['opv1'] != NULL && $val['opv2'] != NULL && $val['opv2'] < date('Y-m-d', strtotime($val['opv1']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['opv2']) && $val['opv2'] != NULL)?date("M d, Y", strtotime($val['opv2'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['opv2'] != NULL && $val['opv3'] != NULL && $val['opv3'] < date('Y-m-d', strtotime($val['opv2']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['opv3']) && $val['opv3'] != NULL)?date("M d, Y", strtotime($val['opv3'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['penta1'] != NULL && $val['penta1'] < date('Y-m-d', strtotime($val['date_of_birth']. ' + 43 days')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['penta1']) && $val['penta1'] != NULL)?date("M d, Y", strtotime($val['penta1'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['penta1'] != NULL && $val['penta2'] != NULL && $val['penta2'] < date('Y-m-d', strtotime($val['penta1']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['penta2']) && $val['penta2'] != NULL)?date("M d, Y", strtotime($val['penta2'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['penta2'] != NULL && $val['penta3'] != NULL && $val['penta3'] < date('Y-m-d', strtotime($val['penta2']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['penta3']) && $val['penta3'] != NULL)?date("M d, Y", strtotime($val['penta3'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['pcv10_1'] != NULL && $val['pcv10_1'] < date('Y-m-d', strtotime($val['date_of_birth']. ' + 43 days')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['pcv10_1']) && $val['pcv10_1'] != NULL)?date("M d, Y", strtotime($val['pcv10_1'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['pcv10_1'] != NULL && $val['pcv10_2'] != NULL && $val['pcv10_2'] < date('Y-m-d', strtotime($val['pcv10_1']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['pcv10_2']) && $val['pcv10_2'] != NULL)?date("M d, Y", strtotime($val['pcv10_2'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['pcv10_2'] != NULL && $val['pcv10_3'] != NULL && $val['pcv10_3'] < date('Y-m-d', strtotime($val['pcv10_2']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['pcv10_3']) && $val['pcv10_3'] != NULL)?date("M d, Y", strtotime($val['pcv10_3'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['penta2'] != NULL && $val['ipv'] != NULL && $val['ipv'] < date('Y-m-d', strtotime($val['date_of_birth']. ' + 99 days')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['ipv']) && $val['ipv'] != NULL)?date("M d, Y", strtotime($val['ipv'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['rota1'] != NULL && $val['rota1'] < date('Y-m-d', strtotime($val['date_of_birth']. ' + 43 days')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['rota1']) && $val['rota1'] != NULL)?date("M d, Y", strtotime($val['rota1'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['rota1'] != NULL && $val['rota2'] != NULL && $val['rota2'] < date('Y-m-d', strtotime($val['rota1']. ' + 29 days')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['rota2']) && $val['rota2'] != NULL)?date("M d, Y", strtotime($val['rota2'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['measles1'] != NULL && $val['measles1'] < date('Y-m-d', strtotime($val['date_of_birth']. ' +9 month +1 day')))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['measles1']) && $val['measles1'] != NULL)?date("M d, Y", strtotime($val['measles1'])):''; ?></td>
					<td class="DrillDownRow" style="text-align:center; border: 1px solid black; white-space:nowrap<?php echo ($val['measles1'] != NULL && $val['measles2'] != NULL && ($val['measles2'] < date('Y-m-d', strtotime($val['date_of_birth']. ' +1 year +3 month +1 day'))) && ($val['measles2'] < date('Y-m-d',strtotime($val['measles1']. ' + 29 days'))))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['measles2']) && $val['measles2'] != NULL)?date("M d, Y", strtotime($val['measles2'])):''; ?></td>
					<?php } ?>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php if( ! $this -> input -> post('export_excel')){ ?>
	</div>
</div>
<div class="row">
				<div class="col-sm-12" align="center">
					<div id="paging">
						<?php 
						// displaying paginaiton.
						echo $pagination;
						?> 
					</div>
				</div>
		</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#fixTable").tableHeadFixer({"left" : 3});
	});
		<?php } ?>
<?php  if(!$this->input->post('export_excel')){ ?>

	$('.DrillDownRow').css('cursor','pointer');
	$(document).on('click','.delrecord',function(){
		var recordInstance = $(this);
		var recno = $(this).data('recno');
		if(confirm('Do you really want to delete this?') === true){
			$.ajax({
				type: "GET",
				data: {recno:recno},
				url: "<?php echo base_url(); ?>childs/Reports/delete_child_record",
				success: function(result){
					console.log(result);
					if(result == true){
						recordInstance.closest('tr').css('backgroud-color','red');
						recordInstance.closest('tr').css('color','white');
						recordInstance.closest('tr').fadeOut("slow");
						//alert('Deletion Successful');
					}
				}
			});
		}
	});
    $(document).on('click',".DrillDownRow", function(){
        var cardno = $(this).closest('tr').find("input[name='child_registration_no']:eq(0)").val();
        //var cardno = $(this).find("td:eq(1)").text();
		//alert(cardno);
        var url = ''; 
        url = "<?php echo base_url();?>childs/Reports/child_cardview?cardno="+cardno;		
        var win = window.open(url,'_blank');
        if(win){
          //Browser has allowed it to be opened
          win.focus();
        }else{
          //Broswer has blocked it
          alert('Please allow popups for this site');
        }
      });
		$('.filter-status').on('change' , function (){
			$('#tbody').html('');
			$('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
			var page = $(this).attr("id"); //get page number from link
			$.ajax({
				type: "GET",
				data: $('#filter-form').serialize(),
				dataType: "json",					
				url: "<?php echo base_url(); ?>Ajax_red_rec/situation_analysis_filter",
				success: function(result){
					console.log(result);
					$('#tbody').html('');
					if(result != null){
						$("#filter").val('');
						$('#tbody').html(result.tbody);
						$('#paging').html(result.paging);
					}
				}
			});
		}); 
  </script>
<?php } ?>