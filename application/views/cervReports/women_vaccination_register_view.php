<?php $utype=$_SESSION["UserType"]; 
?>
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
		<table id="fixTable" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Card No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Husband Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">UnionCouncil</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3" id="village1" class="vl">Complete Address</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3" id="cnt1" class="cn">Contact</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" rowspan="3">Age in Years</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" colspan="17" style="text-align:center">Date of Vaccination</th>
				</tr>
				<tr >
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black" colspan="5">TT</th>
				</tr>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">1</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">2</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">3</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">4</th>
                    <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black">5</th>
				</tr>
			</thead>
			<tbody>
			<?php
			//echo "abcd"; print_r($defaulters); exit;
			$startpoint = isset($startpoint)?$startpoint:0;
			foreach($PVRresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <!--<input type="hidden" name="child_registration_no" value="<?php echo $val['mother_registration_no']; ?>" />-->
				   <td style='text-align:center; border: 1px solid black' class='text-center'>
						<!--<?php echo $key+1; ?>-->
						<?php echo ++$startpoint; ?>
						<input type="hidden" name="child_registration_no" value="<?php echo $val['mother_registration_no']; ?>" />
					</td>
					<td style='text-align:center; border: 1px solid black' class='text-center'><?php echo $val['mothercode']; ?></td>
					<td style='text-align:center; border: 1px solid black' class='text-center'><?php echo $val['mother_name']; ?></td>
					<td style='text-align:center; border: 1px solid black' class='text-center'><?php echo $val['husband_name']; ?></td>
					<td style='text-align:center; border: 1px solid black' class='text-center'><?php echo $val['unioncouncil']; ?></td>
					<td style='text-align:center; border: 1px solid black' class='text-center v1'><?php echo $val['village']; ?></td>
					<td style='text-align:center; border: 1px solid black' class='text-center cn'><?php echo $val['contactno']; ?></td>
                    <td style='text-align:center; border: 1px solid black' class='text-center'><?php echo $val['mother_age']; ?></td>
					<?php $date = date('Y-m-d'); if(isset($defaulters) && $defaulters == 1){ ?>

					<!-- tt1 -->
					<td class='text-center' style="text-align:center;white-space:nowrap;color:#FFF;background-color:					
					<?php 
					if ($val['tt1'] != NULL)
						echo 'green';
					else
						if ($val['tt1'] != NULL && $val['tt1'] > date('Y-m-d', strtotime($date)))
							echo 'red';
						else if ($val['tt1'] == NULL)
							echo 'grey';
					?>">
					<?php 
						if ($val['tt1'] != NULL && $val['tt1'] < date('Y-m-d', strtotime($date)))
							echo date("M d, Y", strtotime($val['tt1']));
						else
							if ($val['tt1'] != NULL || $val['tt1'] > date('Y-m-d', strtotime($date)))
								echo date("M d, Y", strtotime($date));
							else if ($val['tt1'] == NULL)
								echo "";
					?></td>

					<!-- tt2 -->
					<td class='text-center' style="text-align:center;white-space:nowrap;color:#FFF;background-color:
					<?php 
					$doseResult = dueDoses_women('tt2',$val['tt1']);
					if ($val['tt2'] != NULL && $doseResult <= date('Y-m-d', strtotime($val['tt1']. ' + 30 days')))
						echo 'green';
					else
						if ($val['tt2'] != NULL || $doseResult == NULL)
							echo 'grey';
						else 
							echo 'red';
					?>">
					<?php
						if ($val['tt2'] != NULL && $doseResult <= date('Y-m-d', strtotime($val['tt1']. ' + 30 days')))
							echo date("M d, Y", strtotime($val['tt2']));
						else
							if ($val['tt2'] != NULL || $doseResult == NULL)
								echo "";
							else
								echo date("M d, Y", strtotime($doseResult));
					?></td>

					<!-- tt3 -->
					<td class='text-center' style="text-align:center;white-space:nowrap;color:#FFF;background-color:
					<?php 
					$doseResult = dueDoses_women('tt3',$val['tt2']);
					if ($val['tt3'] != NULL && $doseResult <= date('Y-m-d', strtotime($val['tt2']. ' + 6 month')))
						echo 'green';
					else
						if ($val['tt3'] != NULL || $doseResult == NULL)
							echo 'grey';
						else
							echo 'red';
					?>">
					<?php
						if ($val['tt3'] != NULL && $doseResult <= date('Y-m-d', strtotime($val['tt2']. ' + 6 month')))
							echo date("M d, Y", strtotime($val['tt3']));
						else
							if ($val['tt3'] != NULL || $doseResult == NULL)
								echo "";
							else
								echo date("M d, Y", strtotime($doseResult));
					?></td>

					<!-- tt4 -->
					<td class='text-center' style="text-align:center;white-space:nowrap;color:#FFF;background-color:
					<?php 
					$doseResult = dueDoses_women('tt4',$val['tt3']);
					if ($val['tt4'] != NULL && $doseResult <= date('Y-m-d', strtotime($val['tt3']. ' + 1 year')))
						echo 'green';
					else
						if ($val['tt4'] != NULL || $doseResult == NULL)
							echo 'grey';
						else
							echo 'red';
					?>">
					<?php
						if ($val['tt4'] != NULL && $doseResult <= date('Y-m-d', strtotime($val['tt3']. ' + 1 year')))
							echo date("M d, Y", strtotime($val['tt4']));
						else
							if ($val['tt4'] != NULL || $doseResult == NULL)
								echo "";
							else
								echo date("M d, Y", strtotime($doseResult));
					?></td>
					
					<!-- tt5 -->
					<td class='text-center' style="text-align:center;white-space:nowrap;color:#FFF;background-color:
					<?php 
					$doseResult = dueDoses_women('tt5',$val['tt4']);
					if ($val['tt5'] != NULL && $doseResult <= date('Y-m-d', strtotime($val['tt4']. ' + 1 year')))
						echo 'green';
					else
						if ($val['tt5'] != NULL || $doseResult == NULL)
							echo 'grey';
						else
							echo 'red';
					?>">
					<?php
						if ($val['tt5'] != NULL && $doseResult <= date('Y-m-d', strtotime($val['tt4']. ' + 1 year')))
							echo date("M d, Y", strtotime($val['tt5']));
						else
							if ($val['tt5'] != NULL || $doseResult == NULL)
								echo "";
							else
								echo date("M d, Y", strtotime($doseResult));
					?></td>

					<?php }else{ ?>
					<td class='text-center' style='text-align:center; border: 1px solid black';<?php $date = date('Y-m-d'); echo (isset($val['tt1']) && $val['tt1'] != NULL && $val['tt1'] > date('Y-m-d', strtotime($date)))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['tt1']) && $val['tt1'] != NULL)?date("M d, Y", strtotime($val['tt1'])):''; ?></td>
					<td class='text-center' style='text-align:center; border: 1px solid black';<?php $date = date('Y-m-d'); echo (isset($val['tt2']) && $val['tt2'] != NULL && ($val['tt2'] < date('Y-m-d', strtotime($val['tt1']. ' + 30 days')) || $val['tt2'] > date('Y-m-d', strtotime($date))))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['tt2']) && $val['tt2'] != NULL && $val['tt2'])?date("M d, Y", strtotime($val['tt2'])):''; ?></td>
                    <td class='text-center' style='text-align:center; border: 1px solid black';<?php $date = date('Y-m-d'); echo (isset($val['tt3']) && $val['tt3'] != NULL && ($val['tt3'] < date('Y-m-d', strtotime($val['tt2']. ' + 6 month')) || $val['tt3'] > date('Y-m-d', strtotime($date))))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['tt3']) && $val['tt3'] != NULL)?date("M d, Y", strtotime($val['tt3'])):''; ?></td>
                    <td class='text-center' style='text-align:center; border: 1px solid black';<?php $date = date('Y-m-d'); echo (isset($val['tt4']) && $val['tt4'] != NULL && ($val['tt4'] < date('Y-m-d', strtotime($val['tt3']. ' + 1 year')) || $val['tt4'] > date('Y-m-d', strtotime($date))))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['tt4']) && $val['tt4'] != NULL)?date("M d, Y", strtotime($val['tt4'])):''; ?></td>
                    <td class='text-center' style='text-align:center; border: 1px solid black';<?php $date = date('Y-m-d'); echo (isset($val['tt5']) && $val['tt5'] != NULL && ($val['tt5'] < date('Y-m-d', strtotime($val['tt4']. ' + 1 year')) || $val['tt5'] > date('Y-m-d', strtotime($date))))?'color:#FFF;background-color:red':''; ?>"><?php echo (isset($val['tt5']) && $val['tt5'] != NULL)?date("M d, Y", strtotime($val['tt5'])):''; ?></td>
					<?php } ?>
				</tr>
			<?php } ?>
			</tbody>
		</table>
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
	<?php if($utype=="Manager") {?>
			$(document).ready(function(){
				var className = $('#village1').attr('class');
				$('.'+className).hide();

				var className2 = $('#cnt1').attr('class');
				$('.'+className2).hide();
				// $('#village1').hide();
				// $('#village').hide();
				// $('#cnt').hide();
				// $('#cnt1').hide();					
			});
	<?php } ?>
<?php  if(!$this->input->post('export_excel')){ ?>

  $('.DrillDownRow').css('cursor','pointer');
    // $(document).on('click',".DrillDownRow", function(){
    //     var cardno = $(this).find("input[name='mother_registration_no']:eq(0)").val();
    //     //var cardno = $(this).find("td:eq(1)").text();
	// 	//alert(cardno);
    //     var url = ''; 
    //     url = "<?php echo base_url();?>childs/Reports/child_cardview?cardno="+cardno;		
    //     var win = window.open(url,'_blank');
    //     if(win){
    //       //Browser has allowed it to be opened
    //       win.focus();
    //     }else{
    //       //Broswer has blocked it
    //       alert('Please allow popups for this site');
    //     }
    //   });
	  $(function () {
			$('.footable').DataTable();
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