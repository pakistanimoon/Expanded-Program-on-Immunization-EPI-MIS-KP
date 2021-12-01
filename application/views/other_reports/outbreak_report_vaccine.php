<head>                                          
		<title>Outbreak Response List Report | EPI-MIS</title>
		<!--****************************************Meta Tags Start Here***********************************-->

		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">	
        <!--****************************************Style Files Start Here***********************************-->        
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link href="<?php echo base_url(); ?>includes/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url(); ?>includes/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    	<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">    
		<!-- <link href="<?php echo base_url(); ?>includes/dist/css/AdminLTE.css" rel="stylesheet" type="text/css"> -->
        <link href="<?php echo base_url(); ?>includes/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>includes/dist/css/custom.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url(); ?>includes/dist/css/loader.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url(); ?>includes/dist/css/dashboard.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url(); ?>includes/dist/css/animate.min.css" rel="stylesheet" type="text/css">
		<!--<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">-->
		<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/b-1.5.1/b-html5-1.5.1/datatables.min.css"/>-->		
		<link href="<?php echo base_url(); ?>includes/dist/css/style.css" rel="stylesheet" type="text/css">		
		<link href="<?php echo base_url(); ?>includes/css/new_form_style.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url(); ?>includes/redrec/css/custom.css" rel="stylesheet" type="text/css">		
	   <!--****************************************Style Files Ends Here***********************************-->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>		
	</head>
	<div class="row">
				<div class="col-xs-1">
					<a href="http://epikp.pacemis.com/"><img src="http://epikp.pacemis.com/includes/images/epi.png" style="height: 60px;margin-top: 14px;" alt="img-excel" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Home"></a>
				</div>
				
				<div class="col-xs-9">
					<?php
					 $Province=$this -> session -> Province;
					 if ($Province==3) { ?>
					 <h3 style="font-weight: bold;margin-top: 30px;margin-left:112px;" class="text-center">EPI - MIS | Khyber Pakhtunkhwa</h3>
					<?php } if ($Province==5) { ?>
						<h3 style="font-weight: bold;margin-top: 30px;margin-left:112px;" class="text-center">EPI - MIS | AJK</h3>
					<?php } if ($Province==8) { ?>
						<h3 style="font-weight: bold;margin-top: 30px;margin-left:112px;" class="text-center">EPI - MIS | FATA</h3>
					<?php } if ($Province==6) { ?>
					<h3 style="font-weight: bold;margin-top: 30px;margin-left:112px;" class="text-center">EPI - MIS | Gilgit Baltistan</h3>
					<?php } if ($Province==4) { ?>
					<h3 style="font-weight: bold;margin-top: 30px;margin-left:112px;" class="text-center">EPI - MIS | Balochistan</h3>
				<?php } if ($Province==7) { ?>
					<h3 style="font-weight: bold;margin-top: 30px;margin-left:112px;" class="text-center">EPI - MIS | Islamabad</h3>
					<?php } ?>				
				</div>
	</div>
	<?php if ($argu['0']!='' && $argu['0']!=0){ ?>
		
	
<div class="row">
		<div class="col-xs-6 text-right">
			<label>District: </label>
		</div>
		<div class="col-xs-6 text-left">
			<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo get_District_Name($argu['0']);?> </td>
		</div>
  	 </div>
	<?php } //if($argu['1']!='' && $argu['1']!=0) //{ ?>  	 
 <!-- <div class="row">
		<div class="col-xs-6 text-right">
			<label>Tehsil: </label>
		</div>
		<div class="col-xs-6 text-left">
			<td><?php //echo  get_Tehsil_Name($argu['1']); ?> </td>
		</div>
  	 </div>
<?php //} if($argu['2']!='') { ?>
 <div class="row">
		<div class="col-xs-6 text-right">
			<label>Union Council: </label>
		</div>
		<div class="col-xs-6 text-left">
			<td><?php //echo  get_UC_Name($argu['2']);?> </td>
		</div>
  	 </div>
<?php //} if($argu['3']!='') { ?>
 <div class="row">
		<div class="col-xs-6 text-right">
			<label>Village: </label>
		</div>
		<div class="col-xs-6 text-left">
			<td><?php //echo get_Village_Name($argu['3']);?> </td>
		</div>
  	 </div> -->
<?php //} 
if($argu['1']!='') { ?>

 <div class="row">
		<div class="col-xs-6 text-right">
			<label>Date of Activity From: </label>
		</div>
		<div class="col-xs-6 text-left">
			<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $argu['1']?> </td>
		</div>
  	 </div>
<?php } if($argu['2']!='') { ?>
<div class="row">
		<div class="col-xs-6 text-right">
			<label>Date of Activity To: </label>
		</div>
		<div class="col-xs-6 text-left">
			<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $argu['2']?> </td>
		</div>
  	 </div>
<?php } //if($argu['6']!='') { ?>
<!-- <div class="row">
		<div class="col-xs-6 text-right">
			<label>Age Froup From: </label>
		</div>
		<div class="col-xs-6 text-left">
			<td><?php //echo $argu['6']?> </td>
		</div>
  	 </div>
<?php// } if($argu['7']!='') { ?>

 <div class="row">
		<div class="col-xs-6 text-right">
			<label>Age Group To: </label>
		</div>
		<div class="col-xs-6 text-left">
			<td><?php //echo $argu['7']?> </td>
		</div>
  	 </div> -->
	<?php //} ?>  	 
		<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary"  style="margin-top: 70px">
			<div class="panel-heading"> Outbreak Response List Report</div>
			<div class="panel-body">					
					<table class="table table-bordered plan_table">						
						<thead>
							<tr>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" style="width:10%;">All Vaccines List</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">0-11 M</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">12-23 M</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">&gt; 2 Years</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Total</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="1">T</th>									
							</tr>
							<tr>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
								<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M-F</th>
							</tr>							
						</thead>
						<tbody id="trRow">
							<?php
							$m_m=0;
							$m_f=0;
							$m_m1=0;
							$m_f1=0;
							$years_m=0;
							$years_f=0;
							$total_m=0;
							$total_f=0;
							$total_m_f=0;							
							 	foreach ($outbreak_report as $view){?>
							<tr>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $view['vaccines']?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php $m_m=$m_m+$view['0_11_m_m']; echo $view['0_11_m_m']?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php $m_f=$m_f+$view['0_11_m_f']; echo $view['0_11_m_f']?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php $m_m1=$m_m1+$view['12_23_m_m']; echo $view['12_23_m_m']?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php $m_f1=$m_f1+$view['12_23_m_f']; echo $view['12_23_m_f']?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php $years_m=$years_m+$view['years_m']; echo $view['years_m']?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php $years_f=$years_f+$view['years_f']; echo $view['years_f']?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php $total_m=$total_m+$view['total_m']; echo $view['total_m']?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php $total_f=$total_f+$view['total_f']; echo $view['total_f']?></td>
								<td style="text-align:center; border: 1px solid black;" class="text-center"><?php $total_m_f=$total_m_f+$view['total_m_f']; echo $view['total_m_f']?></td>			 
							</tr>
							<?php } ?>
							<tr>
								<td style="background-color: black;color: white;">Total</td>
								<td style="background-color: black;color: white;"><?php echo $m_m;?></td>
								<td style="background-color: black;color: white;"><?php echo $m_f;?></td>
								<td style="background-color: black;color: white;"><?php echo $m_m1;?></td>
								<td style="background-color: black;color: white;"><?php echo $m_f1;?></td>
								<td style="background-color: black;color: white;"><?php echo $years_m;?></td>
								<td style="background-color: black;color: white;"><?php echo $years_f;?></td>
								<td style="background-color: black;color: white;"><?php echo $total_m;?></td>
								<td style="background-color: black;color: white;"><?php echo $total_f;?></td>
								<td style="background-color: black;color: white;"><?php echo $total_m_f;?></td>
							</tr>
						</tbody>					
					</table>		
			</div>
		</div>
	</div>
</div>
