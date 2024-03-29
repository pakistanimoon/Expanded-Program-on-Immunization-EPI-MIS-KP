<?php if($filter == 'AccessToHealthServices'){ 
		if($dropout){
			$link = 'UtilizationOfServices';
		}
		else{
			$link = 'AccessToHealthServices';
		}
		?>
	<form class="" method="post" action="<?php echo base_url(); ?>thematic_maps/<?php echo $link; ?>">
		<?php
		if(isset($data)){
		    $reportType = $data['reportType'];
			$vaccineId = $data['vaccineId'];
			$quarter = $data['quarter'];
			$gender = $data['gender'];
			$vaccineBy = $data['vaccineBy'];
			if(isset($data['id'])){
				$id = $data['id'];?>
				<input type="hidden" name="id" value="<?php echo $id;?>">
			<?php
			}
			if($reportType == 'monthly')
				$fmonth = $data['year']."-".$data['month'];
			else if($reportType == 'quarterly')
				$fmonth = $quarter." Quarter";
			else if($reportType == 'yearly')
				$fmonth = $data['year']." (Yearly)";
		}
		$vaccinesArray = array('BCG','Hep B-Birth','OPV-0','OPV-1','OPV-2','OPV-3','PENTA-1','PENTA-2','PENTA-3','PCV10-1','PCV10-2','PCV10-3','IPV','Rota-1','Rota-2','Measles-I','Fully Immunized','Measles-II');
		?>
		<div class="form-group" id="reportTypeDiv">
			<select name="reportType" id="reportType" class="form-control">
				<option value="">Select Report Type</option>
				<option <?php echo (isset($reportType) && $reportType=="yearly")?'selected="selected"':''; ?> value="yearly">Yearly</option>
				<option <?php echo (isset($reportType) && $reportType=="biyearly")?'selected="selected"':''; ?> value="biyearly">Bi-Yearly</option>
				<option <?php echo (isset($reportType) && $reportType=="quarterly")?'selected="selected"':''; ?> value="quarterly">Quarterly</option>
				<option <?php echo (isset($reportType) && $reportType=="monthly")?'selected="selected"':''; ?> value="monthly">Monthly</option>
			</select>
		</div>
		<div class="form-group" id="yearDiv">
			<select name="year" id="year" class="form-control" required="required">
				<?php getAllYearsOptions(false,$year); ?>
			</select>
		</div>
		<div class="form-group" id="monthDiv">
			<select name="month" id="month" class="form-control" required="required">
				<?php if(isset($month)) { getAllMonthsOptionsNew(false,$year,$month);} ?>
			</select>
		</div>
		<div class="form-group" id="quarterDiv">
			<select name="quarter" id="quarter" class="form-control">
				<option value="">Select</option>
				<option <?php echo (isset($quarter) && ($quarter == "01" || $quarter == "1"))?'selected="selected"':''; ?> value="1">First</option>
				<option <?php echo (isset($quarter) && ($quarter == "02" || $quarter == "2"))?'selected="selected"':''; ?> value="2">Second</option>
				<option <?php echo (isset($quarter) && ($quarter == "03" || $quarter == "3"))?'selected="selected"':''; ?> value="3">Third</option>
				<option <?php echo (isset($quarter) && ($quarter == "04" || $quarter == "4"))?'selected="selected"':''; ?> value="4">Fourth</option>
			</select>
		</div>
		<div class="form-group" id="biyearDiv">
			<select name="biyear" id="biyear" class="form-control">
				<option <?php echo (isset($biyear) && ($biyear == "01" || $biyear == "1"))?'selected="selected"':''; ?> value="1">First Half</option>
				<option <?php echo (isset($biyear) && ($biyear == "02" || $biyear == "2"))?'selected="selected"':''; ?> value="2">Second Half</option>
			</select>
		</div>
		<div class="form-group" id="vaccineDiv">
		<?php if(! $dropout){ ?>
			<select name="vaccineId" id="vaccineId" class="form-control" required="required">
				<option <?php echo (isset($vaccineId) && $vaccineId == "1")?'selected="selected"':''; ?> value="1">BCG</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "2")?'selected="selected"':''; ?> value="2">Hep B-Birth</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "3")?'selected="selected"':''; ?> value="3">OPV-0</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "4")?'selected="selected"':''; ?> value="4">OPV-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "5")?'selected="selected"':''; ?> value="5">OPV-2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "6")?'selected="selected"':''; ?> value="6">OPV-3</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "7")?'selected="selected"':''; ?> value="7">PENTA-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "8")?'selected="selected"':''; ?> value="8">PENTA-2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "9")?'selected="selected"':''; ?> value="9">PENTA-3</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "10")?'selected="selected"':''; ?> value="10">PCV10-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "11")?'selected="selected"':''; ?> value="11">PCV10-2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "12")?'selected="selected"':''; ?> value="12">PCV10-3</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "13")?'selected="selected"':''; ?> value="13">IPV</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "14")?'selected="selected"':''; ?> value="14">Rota-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "15")?'selected="selected"':''; ?> value="15">Rota-2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "16")?'selected="selected"':''; ?> value="16">Measles-I</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "17")?'selected="selected"':''; ?> value="17">Fully Immunized</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "18")?'selected="selected"':''; ?> value="18">Measles-II</option>
			</select>
		<?php } 
		else{ ?>
			<select name="vaccineId" id="vaccineId" class="form-control" required="required">
				<option <?php echo (isset($vaccineId) && $vaccineId == "9")?'selected="selected"':''; ?> value="9">Penta 1 - Penta 3</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "18")?'selected="selected"':''; ?> value="18">Measles 1 - Measles 2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "2")?'selected="selected"':''; ?> value="2">TT 1 - TT 2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "16")?'selected="selected"':''; ?> value="16">Penta 1 - Measles 1</option>
			</select>
		<?php } ?>
		</div>
		<div class="form-group">
			<select name="gender_wise" id="gender_wise" class="form-control" required="required">
				<option <?php echo (isset($gender) && $gender == "Male")?'selected="selected"':''; ?> value="Male">Male</option>
				<option <?php echo (isset($gender) && $gender == "Female")?'selected="selected"':''; ?> value="Female">Female</option>
				<option <?php echo (isset($gender) && $gender == "Both")?'selected="selected"':''; ?> <?php echo (!isset($gender))?'selected="selected':''; ?> value="Both">Both</option>
			</select>
		</div>
		<!--<div class="form-group">
		<label style="color: white;">Coverage Area</label>
			<select name='coverage_area' class="form-control" required="required">
				<option>Inside</option>
				<option>Outside</option>
				<option>All</option>
			</select>
		</div>-->
		<!--<div class="form-group">
			<select name="vaccineBy" id="vaccineBy" class="form-control" required="required">
				<option <?php //echo (isset($vaccineBy) && $vaccineBy == "Fixed")?'selected="selected"':''; ?> value="Fixed">Fixed</option>
				<option <?php //echo (isset($vaccineBy) && $vaccineBy == "Outreach")?'selected="selected"':''; ?> value="Outreach">Outreach</option>
				<option <?php //echo (isset($vaccineBy) && $vaccineBy == "Mobile")?'selected="selected"':''; ?> value="Mobile">Mobile</option>
				<option <?php //echo (isset($vaccineBy) && $vaccineBy == "LHW")?'selected="selected"':''; ?> value="LHW">Health House</option>
				<option <?php //echo (isset($vaccineBy) && $vaccineBy == "All")?'selected="selected"':''; ?> <?php //echo (!isset($vaccineBy))?'selected="selected':''; ?> value="All">All</option>
			</select>
		</div>-->
		<div class="filter_btn">
			<button type="submit" class="formfilterbtn"> Preview </button>
		</div>
	</form>
<?php } ?>

<?php if($filter == 'vaccineCompliance'){ ?>
	<form method="post" action="<?php echo base_url(); ?>thematic_maps/ThematicCompliance">
	<?php
		if(isset($data['id']) && isset($data['districtName'])){
			$id = $data['id'];?>
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<input type="hidden" name="districtName" value="<?php echo $districtName;?>">
		<?php
		}?>
		<div class="form-group">
			<select name="compType" id="compType" class="form-control" required="required">
				<option <?php echo (isset($compType) && ($compType == "Vaccination" ))?'selected="selected"':''; ?> value="Vaccination">Vaccination Compliance</option>
				<option <?php echo (isset($compType) && ($compType == "Consumption" ))?'selected="selected"':''; ?> value="Consumption">Consumption Compliance</option>
				<option <?php echo (isset($compType) && ($compType == "ZeroReporting" ))?'selected="selected"':''; ?> value="ZeroReporting">Zero Reporting Compliance</option>
			</select>
		</div>
		<div class="form-group" id="reportTypeDiv">
			<select name="reportType" id="reportType" class="form-control">
				<option value="">Select Report Type</option>
				<option <?php echo (isset($reportType) && $reportType=="yearly")?'selected="selected"':''; ?> value="yearly">Yearly</option>
				<option <?php echo (isset($reportType) && $reportType=="biyearly")?'selected="selected"':''; ?> value="biyearly">Bi-Yearly</option>
				<option <?php echo (isset($reportType) && $reportType=="quarterly")?'selected="selected"':''; ?> value="quarterly">Quarterly</option>
				<option <?php echo (isset($reportType) && $reportType=="monthly")?'selected="selected"':''; ?> value="monthly">Monthly</option>
			</select>
		</div>
		<div class="form-group" id="yearDiv">
			<select name="year" id="year" class="form-control" required="required">
				<?php getAllYearsOptions(false,$year); ?>
			</select>
		</div>
		<div class="form-group" id="biyearDiv">
			<select name="biyear" id="biyear" class="form-control">
				<option <?php echo (isset($biyear) && ($biyear == "01" || $biyear == "1"))?'selected="selected"':''; ?> value="1">First Half</option>
				<option <?php echo (isset($biyear) && ($biyear == "02" || $biyear == "2"))?'selected="selected"':''; ?> value="2">Second Half</option>
			</select>
		</div>
		<div class="form-group" id="monthDiv">
			<select name="month" id="month" class="form-control" required="required">
				<?php getAllMonthsOptionsNew(false,$year,$month); ?>
			</select>
		</div>
		<div class="form-group" id="weekDiv">
			<select name="week" id="week" class="filter-status  form-control">
				<option value="0">--Select Week--</option>
			</select>
		</div>
		<div class="form-group" id="quarterDiv">
			<select name="quarter" id="quarter" class="form-control">
				<option value="">Select</option>
				<option <?php echo (isset($quarter) && ($quarter == "01" || $quarter == "1"))?'selected="selected"':''; ?> value="1">First</option>
				<option <?php echo (isset($quarter) && ($quarter == "02" || $quarter == "2"))?'selected="selected"':''; ?> value="2">Second</option>
				<option <?php echo (isset($quarter) && ($quarter == "03" || $quarter == "3"))?'selected="selected"':''; ?> value="3">Third</option>
				<option <?php echo (isset($quarter) && ($quarter == "04" || $quarter == "4"))?'selected="selected"':''; ?> value="4">Fourth</option>
			</select>
		</div>
		<div class="filter_btn">
			<button type="submit" class="formfilterbtn"> Preview </button>
		</div>
	</form>
<?php } ?>

<?php if($filter == 'immunize'){ ?>
		<form class="" method="post" action="<?php echo base_url(); ?>thematic_maps/FullyImmunizedCoverage">
		<?php
		if(isset($data)){
			$reportType = $data['reportType'];
			$quarter = $data['quarter'];
			$gender = $data['gender'];
			$vaccineBy = $data['vaccineBy'];
			if(isset($data['id'])){
				$id = $data['id'];?>
				<input type="hidden" name="id" value="<?php echo $id;?>">
			<?php
			}
			if($reportType == 'monthly')
				$fmonth = $data['year']."-".$data['month'];
			else if($reportType == 'quarterly')
				$fmonth = $quarter." Quarter";
			else if($reportType == 'yearly')
				$fmonth = $data['year']." (Yearly)";
		} ?>
		<div class="form-group" id="reportTypeDiv">
			<select name="reportType" id="reportType" class="form-control">
				<option value="">Select Report Type</option>
				<option <?php echo (isset($reportType) && $reportType=="yearly")?'selected="selected"':''; ?> value="yearly">Yearly</option>
				<option <?php echo (isset($reportType) && $reportType=="biyearly")?'selected="selected"':''; ?> value="biyearly">Bi-Yearly</option>
				<option <?php echo (isset($reportType) && $reportType=="quarterly")?'selected="selected"':''; ?> value="quarterly">Quarterly</option>
				<option <?php echo (isset($reportType) && $reportType=="monthly")?'selected="selected"':''; ?> value="monthly">Monthly</option>
			</select>
		</div>
		<div class="form-group" id="yearDiv">
			<select name="year" id="year" class="form-control" required="required">
				<?php getAllYearsOptions(false,$year); ?>
			</select>
		</div>
		<div class="form-group" id="monthDiv">
			<select name="month" id="month" class="form-control" required="required">
				<?php if(isset($month)) { getAllMonthsOptionsNew(false,$year,$month);} ?>
			</select>
		</div>
		<div class="form-group" id="biyearDiv">
			<select name="biyear" id="biyear" class="form-control">
				<option <?php echo (isset($biyear) && ($biyear == "01" || $biyear == "1"))?'selected="selected"':''; ?> value="1">First Half</option>
				<option <?php echo (isset($biyear) && ($biyear == "02" || $biyear == "2"))?'selected="selected"':''; ?> value="2">Second Half</option>
			</select>
		</div>
		<div class="form-group" id="quarterDiv">
			<select name="quarter" id="quarter" class="form-control">
				<option value="">Select</option>
				<option <?php echo (isset($quarter) && ($quarter == "01" || $quarter == "1"))?'selected="selected"':''; ?> value="1">First</option>
				<option <?php echo (isset($quarter) && ($quarter == "02" || $quarter == "2"))?'selected="selected"':''; ?> value="2">Second</option>
				<option <?php echo (isset($quarter) && ($quarter == "03" || $quarter == "3"))?'selected="selected"':''; ?> value="3">Third</option>
				<option <?php echo (isset($quarter) && ($quarter == "04" || $quarter == "4"))?'selected="selected"':''; ?> value="4">Fourth</option>
			</select>
		</div>
		<div class="form-group">
			<select name="gender_wise" id="gender_wise" class="form-control" required="required">
				<option <?php echo (isset($gender) && $gender == "Male")?'selected="selected"':''; ?> value="Male">Male</option>
				<option <?php echo (isset($gender) && $gender == "Female")?'selected="selected"':''; ?> value="Female">Female</option>
				<option <?php echo (isset($gender) && $gender == "Both")?'selected="selected"':''; ?> <?php echo (!isset($gender))?'selected="selected':''; ?> value="Both">Both</option>
			</select>
		</div>
		<div class="form-group">
			<select name="vaccineBy" id="vaccineBy" class="form-control" required="required">
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "Fixed")?'selected="selected"':''; ?> value="Fixed">Fixed</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "Outreach")?'selected="selected"':''; ?> value="Outreach">Outreach</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "Mobile")?'selected="selected"':''; ?> value="Mobile">Mobile</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "LHW")?'selected="selected"':''; ?> value="LHW">Health House</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "All")?'selected="selected"':''; ?> <?php echo (!isset($vaccineBy))?'selected="selected':''; ?> value="All">All</option>
			</select>
		</div>
		<div class="filter_btn">
			<button type="submit" class="formfilterbtn"> Preview </button>
		</div>
	</form>
<?php } ?>

<?php if($filter == 'vaccineIndicator'){
		if(isset($data)){
		    $reportType = $data['reportType'];
		    $indicator = $data['indicator'];
		    $vacc_ind = $data['vacc_ind'];
			}?>
		<form class="" method="post" action="<?php echo base_url(); ?>thematic_maps/ThematicVaccineIndicator">
		<?php if(isset($data['distcode'])){
				$id = $data['distcode'];?>
				<input type="hidden" name="distcode" value="<?php echo $distcode;?>">
			<?php
			}?>
		<div class="form-group" id="reportTypeDiv">
			<select name="reportType" id="reportType" class="form-control">
				<option value="">Select Report Type</option>
				<option <?php echo (isset($reportType) && $reportType=="yearly")?'selected="selected"':''; ?> value="yearly">Yearly</option>
				<option <?php echo (isset($reportType) && $reportType=="monthly")?'selected="selected"':''; ?> value="monthly">Monthly</option>
			</select>
		</div>
		<div class="form-group">
			<select name="year" id="year" class="form-control" required="required">
				<?php getAllYearsOptions(false,$year); ?>
			</select>
		</div>
		<div class="form-group">
			<select name="month" id="month" class="form-control" required="required">
				<?php if(isset($month)) { getAllMonthsOptionsNew(false,$year,$month);} ?>
			</select>
		</div>
		<div class="form-group">
			<select name="indicator" id="vaccineindicator" class="form-control">
				<option <?php echo (isset($indicator) && $indicator=="54")?'selected="selected"':''; ?> value="54">Opened Vial Wastage Rate</option>
				<option <?php echo (isset($indicator) && $indicator=="53")?'selected="selected"':''; ?> value="53">Closed Vial Wastage Rate</option>
				<option <?php echo (isset($indicator) && $indicator=="55")?'selected="selected"':''; ?> value="55">Vaccine Wastage Rate (Closed & Open Vial)</option>				
			</select>
		</div>
		<div id="StockoutRate" class="form-group">
			<select class="form-control" name="vacc_ind" id="vacc_ind">
				<?php echo getActiveVaccinesOptions($vacc_ind,$indicator); ?>
				<!--<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r1_f6")?'selected="selected"':''; ?> value="cr_r1_f6">BCG</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r2_f6")?'selected="selected"':''; ?> value="cr_r2_f6">DIL BCG</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r3_f6")?'selected="selected"':''; ?> value="cr_r3_f6">bOPV</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r4_f6")?'selected="selected"':''; ?> value="cr_r4_f6">Pentavalent</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r5_f6")?'selected="selected"':''; ?> value="cr_r5_f6">Pneumococcal(PCV10)</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r6_f6")?'selected="selected"':''; ?> value="cr_r6_f6">Measles</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r7_f6")?'selected="selected"':''; ?> value="cr_r7_f6">DIL Measles</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r8_f6")?'selected="selected"':''; ?> value="cr_r8_f6">TT 10</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r9_f6")?'selected="selected"':''; ?> value="cr_r9_f6">TT 20</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r10_f6")?'selected="selected"':''; ?> value="cr_r10_f6">HEP B - 10</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r20_f6")?'selected="selected"':''; ?> value="cr_r20_f6">HEP B - 02</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r19_f6")?'selected="selected"':''; ?> value="cr_r19_f6">IPV-5</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r11_f6")?'selected="selected"':''; ?> value="cr_r11_f6">IPV-10</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r18_f6")?'selected="selected"':''; ?> value="cr_r18_f6">Rotarix</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r12_f6")?'selected="selected"':''; ?> value="cr_r12_f6">AD Syringes 0.5 ml</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r13_f6")?'selected="selected"':''; ?> value="cr_r13_f6">AD Syringes 0.05 ml</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r14_f6")?'selected="selected"':''; ?> value="cr_r14_f6">Recon.Syringes (2 ml)</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r15_f6")?'selected="selected"':''; ?> value="cr_r15_f6">Recon. Syringes (5 ml)</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r21_f6")?'selected="selected"':''; ?> value="cr_r21_f6">Vitamin A Red Capsule</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r22_f6")?'selected="selected"':''; ?> value="cr_r22_f6">Vitamin A Blue Capsule</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r16_f6")?'selected="selected"':''; ?> value="cr_r16_f6">Safety Boxes</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r23_f6")?'selected="selected"':''; ?> value="cr_r23_f6">Dropper</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r17_f6")?'selected="selected"':''; ?> value="cr_r17_f6">Other</option>-->
			</select>
		</div>
		<div class="filter_btn">
			<button type="submit" class="formfilterbtn"> Preview </button>
		</div>
	</form>
<?php } ?>

<?php if($filter == 'vaccineUsageIndicator'){
		if(isset($data)){
		    $reportType = $data['reportType'];
		    $vacc_ind = $data['vacc_ind'];}?>
		<form class="" method="post" action="<?php echo base_url(); ?>thematic_maps/ThematicVaccineUsageIndicator">
		<?php if(isset($data['distcode'])){
				$id = $data['distcode'];?>
				<input type="hidden" name="distcode" value="<?php echo $distcode;?>">
			<?php
			}?>
		<div class="form-group" id="reportTypeDiv">
			<select name="reportType" id="reportType" class="form-control">
				<option value="">Select Report Type</option>
				<option <?php echo (isset($reportType) && $reportType=="yearly")?'selected="selected"':''; ?> value="yearly">Yearly</option>
				<option <?php echo (isset($reportType) && $reportType=="monthly")?'selected="selected"':''; ?> value="monthly">Monthly</option>
			</select>
		</div>
		<div class="form-group">
			<select name="year" id="year" class="form-control" required="required">
				<?php getAllYearsOptions(false,$year); ?>
			</select>
		</div>
		<div class="form-group">
			<select name="month" id="month" class="form-control" required="required">
				<?php if(isset($month)) { getAllMonthsOptionsNew(false,$year,$month);} ?>
			</select>
		</div>
		<div class="form-group">
			<select name="indicator" id="indicator" class="form-control">
				<option <?php echo (isset($indicator) && $indicator=="53")?'selected="selected"':''; ?> value="53">Closed Vial Usage Rate</option>
				<option <?php echo (isset($indicator) && $indicator=="54")?'selected="selected"':''; ?> value="54">Opened Vial Usage Rate</option>
				<option <?php echo (isset($indicator) && $indicator=="55")?'selected="selected"':''; ?> value="55">Vaccine Usage rate</option>
			</select>
		</div>
		<div id="StockoutRate" class="form-group">
			<select class="form-control" name="vacc_ind" id="vacc_ind">
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r1_f6")?'selected="selected"':''; ?> value="cr_r1_f6">BCG</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r2_f6")?'selected="selected"':''; ?> value="cr_r2_f6">DIL BCG</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r3_f6")?'selected="selected"':''; ?> value="cr_r3_f6">bOPV</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r4_f6")?'selected="selected"':''; ?> value="cr_r4_f6">Pentavalent</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r5_f6")?'selected="selected"':''; ?> value="cr_r5_f6">Pneumococcal(PCV10)</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r6_f6")?'selected="selected"':''; ?> value="cr_r6_f6">Measles</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r7_f6")?'selected="selected"':''; ?> value="cr_r7_f6">DIL Measles</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r8_f6")?'selected="selected"':''; ?> value="cr_r8_f6">TT 10</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r9_f6")?'selected="selected"':''; ?> value="cr_r9_f6">TT 20</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r10_f6")?'selected="selected"':''; ?> value="cr_r10_f6">HBV (Birth dose)</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r11_f6")?'selected="selected"':''; ?> value="cr_r11_f6">IPV</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r12_f6")?'selected="selected"':''; ?> value="cr_r12_f6">AD Syringes 0.5 ml</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r13_f6")?'selected="selected"':''; ?> value="cr_r13_f6">AD Syringes 0.05 ml</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r14_f6")?'selected="selected"':''; ?> value="cr_r14_f6">Recon.Syringes (2 ml)</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r15_f6")?'selected="selected"':''; ?> value="cr_r15_f6">Recon. Syringes (5 ml)</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r16_f6")?'selected="selected"':''; ?> value="cr_r16_f6">Safety Boxes</option>
				<option <?php echo (isset($vacc_ind) && $vacc_ind=="cr_r17_f6")?'selected="selected"':''; ?> value="cr_r17_f6">Other</option>
			</select>
		</div>
		<div class="filter_btn">
			<button type="submit" class="formfilterbtn"> Preview </button>
		</div>
	</form>
<?php } ?>

<?php if($filter == 'EPID'){
		if(isset($data)){
		    $disease = $data['disease'];
		    $gender = $data['gender'];
			}?>
		<form class="" method="post" action="<?php echo base_url(); ?>thematic_maps/ThematicCountEPID">
		<?php 
			if(isset($data['id'])){
					$id = $data['id'];?>
					<input type="hidden" name="id" value="<?php echo $id;?>">
		<?php	}
			echo $data['yearFilter']; ?>
		<div class="form-group">
			<select name="week" id="week" class="filter-status  form-control">
				<option value="0">--Select Week--</option>
			</select>
		</div>
		<div class="form-group">
			<select name="disease" id="disease" class="form-control">
				<?php echo getAllDiseasesOptions($disease); ?>
				<!--<option <?php echo (isset($disease) && $disease=="measles")?'selected="selected"':''; ?> value="measles">Measles</option>
				<option <?php echo (isset($disease) && $disease=="afp")?'selected="selected"':''; ?> value="afp">Acute Flacid Pralysis</option>
				<option <?php echo (isset($disease) && $disease=="diphtheria")?'selected="selected"':''; ?> value="diphtheria">Diphtheria</option>
				<option <?php echo (isset($disease) && $disease=="pertussis")?'selected="selected"':''; ?> value="pertussis">Pertussis</option>
				<option <?php echo (isset($disease) && $disease=="pneumonia")?'selected="selected"':''; ?> value="pneumonia">Pneumonia</option>
				<option <?php echo (isset($disease) && $disease=="childhood tb")?'selected="selected"':''; ?> value="childhood tb">Childhood TB</option>
				<option <?php echo (isset($disease) && $disease=="meningitis")?'selected="selected"':''; ?> value="meningitis">Meningitis</option>
				<option <?php echo (isset($disease) && $disease=="hepatitis")?'selected="selected"':''; ?> value="hepatitis">Hepatitis</option>-->
			</select>
		</div>  			
		<div class="form-group">
			<select name="gender" id="gender" class="form-control" required="required">
				<option <?php echo (isset($gender) && $gender == "1")?'selected="selected"':''; ?> value="1">Male</option>
				<option <?php echo (isset($gender) && $gender == "0")?'selected="selected"':''; ?> value="0">Female</option>
				<option <?php echo (isset($gender) && $gender == "Both")?'selected="selected"':''; ?> <?php echo (!isset($gender))?'selected="selected':''; ?> value="Both">Both</option>
			</select>
		</div>
		<div class="form-group">
			<label style="color:white;">Filter by Result</label>
			<select name="investigationResult" id="investigationResult" class="form-control" required="required">
				<?php echo getAllSpecimenResults($disease); ?>
			</select>
		</div>
		<div class="filter_btn">
			<button type="submit" class="formfilterbtn"> Preview </button>
		</div>
	</form>
<?php } ?>

<?php if($filter == 'VPD'){
		if(isset($data)){
		    $disease = $data['disease'];
		    $gender = $data['gender'];
			}?>
		<form class="" method="post" action="<?php echo base_url(); ?>thematic_maps/ThematicVPD">
		<?php if(isset($data['special'])){?>
					<input type="hidden" name="special" value="<?php echo $data['special'];?>">
		<?php }
			if(isset($data['id'])){
					$id = $data['id'];?>
					<input type="hidden" name="id" value="<?php echo $id;?>">
		<?php	}
			echo $data['yearFilter']; ?>
		<!--<div class="form-group" id="monthDiv">
			<select name="month" id="month" class="form-control" required="required">
				<?php //if(isset($month)) {getAllMonthsOptionsNew(false,$year,$month);} ?>
			</select>
		</div> -->
		<div class="form-group">
			<select name="disease" id="disease" class="form-control">
				<option <?php echo (isset($disease) && $disease=="all")?'selected="selected"':''; ?> value="all">All Diseases</option>
				<option <?php echo (isset($disease) && $disease=="measles")?'selected="selected"':''; ?> value="measles">Measles</option>
				<option <?php echo (isset($disease) && $disease=="nnt")?'selected="selected"':''; ?> value="nnt">NNT</option>
				<option <?php echo (isset($disease) && $disease=="afp")?'selected="selected"':''; ?> value="afp">Acute Flacid Pralysis</option>
				<option <?php echo (isset($disease) && $disease=="diphtheria")?'selected="selected"':''; ?> value="diphtheria">Diphtheria</option>
				<option <?php echo (isset($disease) && $disease=="pertussis")?'selected="selected"':''; ?> value="pertussis">Pertussis</option>
				<option <?php echo (isset($disease) && $disease=="pneumonia")?'selected="selected"':''; ?> value="pneumonia">Pneumonia</option>
				<option <?php echo (isset($disease) && $disease=="childhood tb")?'selected="selected"':''; ?> value="childhood tb">Childhood TB</option>
				<option <?php echo (isset($disease) && $disease=="meningitis")?'selected="selected"':''; ?> value="meningitis">Meningitis</option>
				<option <?php echo (isset($disease) && $disease=="hepatitis")?'selected="selected"':''; ?> value="hepatitis">Hepatitis</option>
			</select>
		</div>  			
		<div class="form-group">
			<select name="gender" id="gender" class="form-control" required="required">
				<option <?php echo (isset($gender) && $gender == "1")?'selected="selected"':''; ?> value="1">Male</option>
				<option <?php echo (isset($gender) && $gender == "0")?'selected="selected"':''; ?> value="0">Female</option>
				<option <?php echo (isset($gender) && $gender == "Both")?'selected="selected"':''; ?> <?php echo (!isset($gender))?'selected="selected':''; ?> value="Both">Both</option>
			</select>
		</div>
		<div class="filter_btn">
			<button type="submit" class="formfilterbtn"> Preview </button>
		</div>
	</form>
<?php } ?>

<?php if($filter == 'Morbidity'){
		if(isset($data)){
		    $disease = $data['disease'];
		    //$gender = $data['gender'];
			}?>
		<form class="" method="post" action="<?php echo base_url(); ?>thematic_maps/ThematicMorbidity">
		<?php if(isset($data['special'])){?>
					<input type="hidden" name="special" value="<?php echo $data['special'];?>">
		<?php }
			if(isset($data['id'])){
					$id = $data['id'];?>
					<input type="hidden" name="id" value="<?php echo $id;?>">
		<?php	}
			echo $data['yearFilter']; ?>
		<!--<div class="form-group" id="monthDiv">
			<select name="month" id="month" class="form-control" required="required">
				<?php //if(isset($month)) {getAllMonthsOptionsNew(false,$year,$month);} ?>
			</select>
		</div> -->
		<!--<div class="form-group">
			<select name="week" id="week" class="filter-status  form-control">
				<option value="0">--Select Week--</option>
			</select>
		</div>-->
		<div class="form-group">
			<select name="disease" id="disease" class="form-control">
				<!-- <option <?php //echo (isset($disease) && $disease=="all")?'selected="selected"':''; ?> value="all">All Diseases</option>-->
				<option <?php echo (isset($disease) && $disease=="1")?'selected="selected"':''; ?> value="1">Acute (upper) respiratory infections</option>
				<option <?php echo (isset($disease) && $disease=="22")?'selected="selected"':''; ?> value="22">Other unusual diseases (Specify)</option>
				<option <?php echo (isset($disease) && $disease=="5")?'selected="selected"':''; ?> value="5">Acute Diarrhea (Other than Cholera)</option>
				<option <?php echo (isset($disease) && $disease=="19")?'selected="selected"':''; ?> value="19">Suspected Measles</option>
				<option <?php echo (isset($disease) && $disease=="2")?'selected="selected"':''; ?> value="2">Acute Watery Diarrhea/ Suspected Cholera <5 year</option>
				<option <?php echo (isset($disease) && $disease=="13")?'selected="selected"':''; ?> value="13">Suspected Malaria</option>
				<option <?php echo (isset($disease) && $disease=="20")?'selected="selected"':''; ?> value="20">Pyrexia Of Unknown Origin</option>
				<option <?php echo (isset($disease) && $disease=="3")?'selected="selected"':''; ?> value="3">Acute Watery Diarrhea/ Suspected Cholera >5 year</option>
				<option <?php echo (isset($disease) && $disease=="6")?'selected="selected"':''; ?> value="6">Suspected Enteric/Typhoid Fever</option>
				
				<option <?php echo (isset($disease) && $disease=="4")?'selected="selected"':''; ?> value="4">Bloody Diarrhea</option>
				<option <?php echo (isset($disease) && $disease=="27")?'selected="selected"':''; ?> value="27">Severe Acute Respiratory Infection</option>
				<option <?php echo (isset($disease) && $disease=="25")?'selected="selected"':''; ?> value="25">Pneumonia < 5 years</option>
				<option <?php echo (isset($disease) && $disease=="15")?'selected="selected"':''; ?> value="15">Acute Flaccid Paralysis</option>
				<option <?php echo (isset($disease) && $disease=="11")?'selected="selected"':''; ?> value="11">Cutaneous Leishmaniasis</option>
				<option <?php echo (isset($disease) && $disease=="26")?'selected="selected"':''; ?> value="26">Pneumonia > 5 years</option>
				<option <?php echo (isset($disease) && $disease=="21")?'selected="selected"':''; ?> value="21">Chronic Viral Hepatitis (B &C)</option>
				<option <?php echo (isset($disease) && $disease=="7")?'selected="selected"':''; ?> value="7">Suspected Acute Viral Hepatitis (Hep. A & E)</option>
				<option <?php echo (isset($disease) && $disease=="14")?'selected="selected"':''; ?> value="14">Neonatal Tetanus</option>
				
				<option <?php echo (isset($disease) && $disease=="12")?'selected="selected"':''; ?> value="12">Visceral Leishmaniasis</option>
				<option <?php echo (isset($disease) && $disease=="18")?'selected="selected"':''; ?> value="18">Suspected Diphtheria</option>
				<option <?php echo (isset($disease) && $disease=="17")?'selected="selected"':''; ?> value="17">Suspected Pertussis</option>
				<option <?php echo (isset($disease) && $disease=="23")?'selected="selected"':''; ?> value="23">Hepatits</option>
				<option <?php echo (isset($disease) && $disease=="24")?'selected="selected"':''; ?> value="24">Suspected Meningits</option>
				<option <?php echo (isset($disease) && $disease=="8")?'selected="selected"':''; ?> value="8">Suspected Dengue Hemorrhagic Fever</option>
				<option <?php echo (isset($disease) && $disease=="16")?'selected="selected"':''; ?> value="16">Childhood Tuberculosis</option>
				<option <?php echo (isset($disease) && $disease=="10")?'selected="selected"':''; ?> value="10">Suspected Crimean Congo Hemorrhagic Fever</option>
				<option <?php echo (isset($disease) && $disease=="9")?'selected="selected"':''; ?> value="9">Suspected Dengue Fever</option>
			</select>
		</div>  			
		<div class="form-group">
			<select name="casetype" id="casetype" class="form-control" required="required">
				<option <?php echo (isset($disease) && $disease=="10")?'selected="selected"':''; ?> value="cases">Cases</option>
				<option <?php echo (isset($disease) && $disease=="9")?'selected="selected"':''; ?> value="deaths">Deaths</option>
			</select>
		</div>
		<div class="filter_btn">
			<button type="submit" class="formfilterbtn"> Preview </button>
		</div>
	</form>
<?php } ?>

<script type="text/javascript">
	$(document).on('change','#vaccineindicator',function(){
		var $indicatorId = $(this).val();
		$.ajax({
			type: "POST",
			data: {indicatorid:$indicatorId},
			url: "<?php echo base_url(); ?>thematic_maps/ThematicVaccineIndicator/getActiveVaccinesOptions",
			success: function(result){
				$('#vacc_ind').html(result);
			}
		}); 
	});
	$(document).on('change','#disease',function(){
		var $diseaseId = $(this).val();
		$.ajax({
			type: "POST",
			data: {diseaseId:$diseaseId},
			url: "<?php echo base_url(); ?>thematic_maps/ThematicCountEPID/getAllSpecimenResultsOptions",
			success: function(result){
				$('#investigationResult').html(result);
			}
		}); 
	});
</script>