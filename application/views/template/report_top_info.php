
<hr> 
<div class="row">
	<div class="col-xs-8" style="margin-top: -30px;margin-left: 30.4%;">
		<h3 style="text-decoration: underline;"><?php echo isset($title)?$title:"EPI Report" ?></h3>
    </div>
</div>
<div class="row">
	<div class="col-xs-1" style="margin-top: -13px; margin-left: 30.4%;">
		<h4>Province:</h4>
	</div>
	<div class="col-xs-4" style="margin-top:-12px;margin-left: 15px;">
		<h5><?php echo $this -> session -> provincename; ?></h5>
	</div>
</div>
<?php 
$distcode=isset($distcode)?$distcode:$this -> session -> District;
if($distcode > 0)
{?> 
	<div class="row">
		<div class="col-xs-1" style="margin-top:-14px; margin-left: 30.4%;">
			<h4>District:</h4>
		</div>
		<div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
			<h5><?php echo get_District_Name($distcode); ?></h5>
		</div>
	</div><?php 
}
$tcode=isset($tcode)?$tcode:$this -> session -> Tehsil;
if($tcode > 0)
{?> 
	<div class="row">
		<div class="col-xs-1" style="margin-top:-14px; margin-left: 30.4%;">
			<h4>Tehsil:</h4>
		</div>
		<div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
			<h5><?php echo get_Tehsil_Name($tcode); ?></h5>
		</div>
	</div><?php 
}
$facode=isset($facode)?$facode:$this -> session -> Facility;
if($facode > 0)
{?> 
	<div class="row">
		<div class="col-xs-1" style="margin-top:-14px; margin-left: 30.4%;">
			<h4>Facility:</h4>
		</div>
		<div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
			<h5><?php echo get_Facility_Name($facode); ?></h5>
		</div>
	</div><?php 
}
$year=isset($year)?$year:"";
if($year > 0)
{?> 
	<div class="row">
		<div class="col-xs-1" style="margin-top:-14px;margin-left: 30.4%;">
			<h4>Year:</h4>
		</div>
		<div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
			<h5><?php echo $year; ?></h5>
		</div>
	</div><?php 
}
$month=isset($month)?$month:"";
if($month > 0)
{?> 
	<div class="row">
		<div class="col-xs-1" style="margin-top:-14px;margin-left: 30.4%;">
			<h4>Month:</h4>
		</div>
		<div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
			<h5><?php echo monthname($month); ?></h5>
		</div>
	</div><?php 
} ?>