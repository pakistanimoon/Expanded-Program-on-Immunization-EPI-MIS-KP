<?php //print_r($AllAssetresult); exit;?>

<div class="container bodycontainer">
<?php 
if($TopInfo!=''){
     echo $TopInfo;
  }
   //echo $htmlData; 
  ?>
  <div id="parent" style="overflow:auto">
		<table id="fixTable" class="table table-bordered table-hover table-striped">
		<!---District store level----->
		<?php if(isset($districtAssetresult)){?>
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Distcode</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">District Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Assets Availability</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">No of Assets</th>
				</tr>
			</thead>
			<?php if(!$districtAssetresult==0){?>
			<?php foreach($districtAssetresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['distcode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['district']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if($val['assets']==0)
						echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					else
						echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check text-green"></i></p>';
					?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['assets']; ?></td>
	
				</tr>
			<?php } ?>
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td style="text-align:center; border: 1px solid black;" class="text-center" colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			<tbody>

			</tbody>
		<?php }else if(isset($AlldistrictAssetresult)){?>
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Distcode</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">District Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Refrigerator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Cold Room</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Voltage Regulator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Generator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Transport</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Vaccine Carriers</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Cold Box</th>
				</tr>
			</thead>
			<?php if(!$AlldistrictAssetresult==0){?>
			<?php foreach($AlldistrictAssetresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['distcode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['district']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['refrigerator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['coldroom']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['voltageregulator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['generator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['transport']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['vaccinecarriers']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['coldbox']; ?></td>
				</tr>
			<?php } ?>
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td style="text-align:center; border: 1px solid black;" class="text-center" colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			<tbody>

			</tbody>
		<?php }?>
		<!---Tehsil store level----->
		<?php if(isset($tehsilAssetresult)){?>
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Tcode</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Tehsil Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Assets Availability</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">No of Assets</th>
				</tr>
			</thead>
			<?php if(!$tehsilAssetresult==0){?>
			<?php foreach($tehsilAssetresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['tcode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['tehsil']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if($val['assets']==0)
						echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					else
						echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check text-green"></i></p>';
					?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['assets']; ?></td>
	
				</tr>
			<?php } ?>
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td style="text-align:center; border: 1px solid black;" class="text-center" colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			<tbody>

			</tbody>
		<?php }else if(isset($AlltehsilAssetresult)){?>
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Tcode</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Tehsil Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Refrigerator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Cold Room</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Voltage Regulator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Generator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Transport</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Vaccine Carriers</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Cold Box</th>
				</tr>
			</thead>
			<?php if(!$AlltehsilAssetresult==0){?>
			<?php foreach($AlltehsilAssetresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['tcode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['tehsil']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['refrigerator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['coldroom']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['voltageregulator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['generator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['transport']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['vaccinecarriers']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['coldbox']; ?></td>
				</tr>
			<?php } ?>
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			<tbody>

			</tbody>
		<?php }?>
		<!---Union Council store level----->
		<?php if(isset($AllunionAssetresult)){?>
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Uncode</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Union Council</th>-->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Facode</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Facility</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Refrigerator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Cold Room</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Voltage Regulator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Generator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Transport</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Vaccine Carriers</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Cold Box</th>
				</tr>
			</thead>
			<?php if(!$AllunionAssetresult==0){?>
			<?php foreach($AllunionAssetresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<!--<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['uncode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['unname']; ?></td>-->
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['facode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['fac_name']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['refrigerator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['coldroom']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['voltageregulator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['generator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['transport']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['vaccinecarriers']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['coldbox']; ?></td>
				</tr>
			<?php } ?>
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			<tbody>

			</tbody>
		<?php }else if(isset($unionAssetresult)){?>
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Uncode</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Union Council</th>-->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Facode</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Facility</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Assets Availability</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">No of Assets</th>
				</tr>
			</thead>
			<?php if(!$unionAssetresult==0){?>
			<?php foreach($unionAssetresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<!--<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['uncode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['unname']; ?></td>-->
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['facode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['fac_name']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if($val['assets']==0)
						echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					else
						echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check text-green"></i></p>';
					?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['assets']; ?></td>
				</tr>
			<?php } ?>
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			<tbody>

			</tbody>
		<?php } ?>	
		<!---unallocated store level----->
			<?php if(isset($unallocatedAssetresult)){?>
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Assets Availability</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">No of Assets</th>
				</tr>
			</thead>
			<?php if(!$unallocatedAssetresult==0){?>
			<?php foreach($unallocatedAssetresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['storecode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['storename']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if($val['assets']==0)
						echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					else
						echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check text-green"></i></p>';
					?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['assets']; ?></td>
				</tr>
			<?php } ?>
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			<tbody>

			</tbody>
		<?php }else if(isset($AllunallocatedAssetresult)){?>
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Refrigerator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Cold Room</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Voltage Regulator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Generator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Transport</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Vaccine Carriers</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Cold Box</th>
				</tr>
			</thead>
			<?php if(!$AllunallocatedAssetresult==0){?>
			<?php foreach($AllunallocatedAssetresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['distcode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center">Unallocated(<?php echo $val['district']; ?>)</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['refrigerator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['coldroom']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['voltageregulator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['generator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['transport']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['vaccinecarriers']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['coldbox']; ?></td>
				</tr>
			<?php } ?>
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			<tbody>

			</tbody>
		<?php }else if(isset($emptunallocatedAssetresult)){?>
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Refrigerator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Cold Room</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Voltage Regulator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Generator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Transport</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Vaccine Carriers</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Cold Box</th>
				</tr>
			</thead>
			<?php if(!$emptunallocatedAssetresult==0){?>
			<?php foreach($emptunallocatedAssetresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['procode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['province']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['refrigerator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['coldroom']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['voltageregulator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['generator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['transport']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['vaccinecarriers']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['coldbox']; ?></td>
				</tr>
			<?php } ?>
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			<tbody>

			</tbody>
		<?php }?>
		
		<!---Provincial Store level----->
		  <?php if(isset($provincialAssetresult)){?>
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Assets Availability</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">No of Assets</th>
				</tr>
			</thead>
			<?php if(!$provincialAssetresult==0){?>
			<?php foreach($provincialAssetresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['procode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['province']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if($val['assets']==0)
						echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					else
						echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check text-green"></i></p>';
					?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['assets']; ?></td>
				</tr>
			<?php } ?>
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			<tbody>

			</tbody>
		<?php }else if(isset($AllprovincialAssetresult)){?>
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Refrigerator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Cold Room</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Voltage Regulator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Generator</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Transport</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Vaccine Carriers</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Cold Box</th>
				</tr>
			</thead>
			<?php if(!$AllprovincialAssetresult==0){?>
			<?php foreach($AllprovincialAssetresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['procode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['province']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['refrigerator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['coldroom']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['voltageregulator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['generator']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['transport']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['vaccinecarriers']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['coldbox']; ?></td>
				</tr>
			<?php } ?>
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			<tbody>

			</tbody>
		<?php }?>
		
		</table>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://epibeta.pacemis.com/includes/js/tableHeadFixer.js"></script>
<script src="http://epibeta.pacemis.com/includes/bootstrap/js/bootstrap.min.js"></script>
<script>
		$(document).ready(function() {
				$("#fixTable").tableHeadFixer(); 
	    });
		  $('.DrillDownRow').css('cursor','pointer');
        $(document).on('click',".DrillDownRow", function(){
			var code = $(this).find("td:eq(1)").text();
			var store_level = '<?php echo $this-> input-> get_post('store_level'); ?>';
			var working_status = '<?php echo $this-> input-> get_post('working_status'); ?>';
			var type = '<?php echo $this-> input-> get_post('asset_type'); ?>';
			if( type ==''){
				var asset_type = 0;
			}else{
				var asset_type = '<?php echo $this-> input-> get_post('asset_type'); ?>';
			}
			//alert(asset_type); exit();
			//alert(code); exit();
			//var distcode = code.substr(0,3);
			//var facode = code.substr(0,6);
			var url = '';  
			url = "<?php echo base_url();?>cold_chain/Reports/asset_availability_report_view/"+code+"/"+store_level+"/"+asset_type+"/"+working_status+"";         
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