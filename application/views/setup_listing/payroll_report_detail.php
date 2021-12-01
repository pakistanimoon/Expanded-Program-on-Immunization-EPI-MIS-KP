<!DOCTYPE html>
<html>
<head>
<title><?php echo isset($pageTitle)?$pageTitle:"LHW - MIS | Khyber Pakhtunkhwa"; ?></title>
<link href="<?php echo base_url() ?>includes/css/bootstrap-3.1.1.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url() ?>includes/css/custom.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Oswald:300,400,700' rel='stylesheet' type='text/css'>

<link href='http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'>
</head>

<body>
<div class="container container-custom-width">
	<div class="row">
        <div class="col-xs-5 col-xs-offset-3">
	       	<img src="<?php echo base_url() ?>includes/images/lhwmis.png" style="height: 60px;
			margin-top: 1px;" alt="logo">
	        <h3 style="font-weight: bold;
			margin-top: -41px;" class="text-center">LHW - MIS | Khyber Pakhtunkhwa
			</h3>
	    </div>
	    <div class="col-xs-1 col-xs-offset-2" style="margin-right:-68px;margin-top: 11px;">
			<a onclick="document.getElementById('export-form').submit()" href="#">
				<img src="<?php echo base_url() ?>includes/images/excel.png" style="height:32px;" alt="img-excel" data-toggle="tooltip" title="View in Excel" data-placement="bottom">
			</a>	    	
	   	</div>
	    <div class="col-xs-1" style="margin-right: -68px;margin-top: 11px;">
			<a onclick="window.print();" href="#">
				<img src="<?php echo base_url() ?>includes/images/print.png" style="height:34px;" alt="img-print" data-toggle="tooltip" title="Print" data-placement="bottom">
			</a>
	    </div>
	    <div class="col-xs-1" style="margin-top: 11px;">
	    	<img src="<?php echo base_url() ?>includes/images/close.png" style="height:34px;" alt="img-close" data-toggle="tooltip" title="Close" data-placement="bottom">
	    </div>
    </div>
	<br />
	<div class="row">
		<div class="col-xs-6 col-xs-offset-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-3">
							<label>Code:</label>
						</div>
						<div class="col-xs-3">
							<p><?php echo $topData["code"]; ?></p>
						</div>
						<div class="col-xs-3">
							<label>Name:</label>
						</div>
						<div class="col-xs-3">
							<p><?php echo $topData["name"]; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">
							<label>Type:</label>
						</div>
						<div class="col-xs-3">
							<p><?php echo $report_name; ?></p>
						</div>
						<div class="col-xs-3">
							<label>CNIC:</label>
						</div>
						<div class="col-xs-3">
							<p><?php echo $topData["nic"]; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">
							<label>Bank Name:</label>
						</div>
						<div class="col-xs-3">
							<p><?php echo $topData["bankbranch"]; ?></p>
						</div>
						<div class="col-xs-3">
							<label>Account #:</label>
						</div>
						<div class="col-xs-3">
							<p><?php echo $topData["bankaccount"]; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">
							<label>Facility Name:</label>
						</div>
						<div class="col-xs-3">
							<p><?php echo $topData["facility"]; ?></p>
						</div>
						<div class="col-xs-3">
							<label>District Name:</label>
						</div>
						<div class="col-xs-3">
							<p><?php echo $topData["district"]; ?></p>
						</div>
					</div>
					<?php 
					$fmonth = $allData[0]["fmonth"];
					$splitted = explode("-",$fmonth);
					echo '<h4>'.$splitted[0].'</h4>'; ?>
					<table data-filter-text-only="true" data-filter="#filter" class="table table-condensed table-bordered table-hover table-striped footable table-vcenter">
						<thead>
							<tr style="background-color: #0072C6;color: #FFF;">
								<th class="Heading text-center">Month</th>
								<th class="Heading text-center">Total Monthly Salary Paid</th>
							</tr>						
						</thead>
						<tbody>
						<?php 
							//top table info
							//echo '<p>'.implode(",",$topData).'</p>';
							$year = 0;$totalPaid=0;
							foreach($allData as $onedata)
							{
								$fmonth = $onedata["fmonth"];
								$splitted = explode("-",$fmonth);
								if(($year != $splitted[0]) && ($year != "0"))
								{
									?>
									</tbody></table><?php									
									//mean another year heading should show here
									echo '<h4>'.$splitted[0].'</h4>';
									?>
									<table data-filter-text-only="true" data-filter="#filter" class="table table-condensed table-bordered table-hover table-striped footable table-vcenter">
										<thead>
											<tr style="background-color: #0072C6;color: #FFF;">
												<th class="Heading text-center">Month</th>
												<th class="Heading text-center">Total Monthly Salary Paid</th>
											</tr>						
										</thead>
									<tbody>
									<?php
								}
								//month list in table.
								$totalPaid += $onedata["totalmonthlysalary"];
								?>
								<tr>
									<td class="text-center"><?php echo $onedata["fmonth"]; ?></td>
									<td class="text-center"><?php echo $onedata["totalmonthlysalary"]; ?></td>
								</tr>
								<?php $year = $splitted[0];
							}
							if(count($allData)>0){}else{echo '<tr><td colspan="2">No record found</td><tr>';}
						?>
						</tbody>
					</table>
					
					<table class="table table-condensed table-bordered table-hover table-striped footable table-vcenter" data-filter="#filter" data-filter-text-only="true">
						<thead>
							<tr style="background-color: #000;color: #FFF;">
								<th class="Heading text-center" width="26%">Total:</th>
								<th class="Heading text-center"><?php echo $totalPaid; ?></th>
							</tr>						
						</thead>
					</table>
				</div><!--end of pannel-body-->
			</div><!--end of pannel-->
		</div>
 		<!--<h3 style="font-weight:bold ;margin-left:15px;">LHW - MIS | Khyber Pakhtunkhwa</h3>
        <hr> 
		<div class="row" style="margin-bottom: -20px;">
			<div class="col-xs-8 col-xs-offset-4">
				<h4 style="margin-top: 0px; margin-left: 40px; font-weight: bold;"><?php echo $subtitle;?></h4>
			</div>
		</div>-->
		
	</div><!--end of row main-->
</div><!--End of page content or body contaier-->
  <!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>includes/js/bootstrap-3.1.1.min.js"></script>
 <!--fortooltip-->
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

<!--for navbar fixed at top-->
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});

var pos = $('#nav').offset().top;
var nav = $('#nav');
$(window).scroll(function () {
        if ($(this).scrollTop() > pos) {
            nav.addClass("f-nav");
        } else {
            nav.removeClass("f-nav");
        }
    });
</script>
</body>
</html>