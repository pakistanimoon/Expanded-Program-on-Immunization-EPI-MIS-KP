		<section id="rev_filters">
			<div class="container">
				<div class="row" id="rev_filter">
					<form id="filter-form" method="GET" style="width:100%; display:inherit">
					<div class="col-lg-4">
						<input type="radio" <?php echo (isset($period) && $period=='yearly')?'checked':''; ?> class="cst-radio-filter" id="yearly" value="yearly" name="filter">
						<label for="yearly">Yearly</label>
						<input type="radio" <?php echo (isset($period) && $period=='biyearly')?'checked':''; ?> class="cst-radio-filter" id="biyearly" value="biyearly" name="filter">
						<label for="biyearly">Bi-Yearly</label>
						<input type="radio" <?php echo (isset($period) && $period=='quarterly')?'checked':''; ?> class="cst-radio-filter" id="quarterly" value="quarterly" name="filter">
						<label for="quarterly">Quarterly</label>
						<input type="radio" <?php echo (isset($period) && $period=='monthly')?'checked':''; ?> class="cst-radio-filter" id="monthly" value="monthly" name="filter">
						<label for="monthly">Monthly</label>
					</div>
					<div class="col-lg-7">
						<div class="row">
							<div class="col-lg-3">
								<select class="form-control form-control-cst" id="year" name="year">
									<?php getAllYearsOptions(); ?>
								</select>
							</div>
							<div class="col-lg-3">
								<select class="form-control form-control-cst" disabled id="bi-year" name="biyear">
									<option <?php echo (isset($biyear) && $biyear==1)?'selected="selected"':''; ?> value="1">First Half</option>
									<option <?php echo (isset($biyear) && $biyear==2)?'selected="selected"':''; ?> value="2">Second Half</option>
								</select>
							</div>
							<div class="col-lg-3">
								<select class="form-control form-control-cst" disabled id="quarter" name="quarter">
									<option <?php echo (isset($quarter) && $quarter==1)?'selected="selected"':''; ?> value="1">Quarter 1</option>
									<option <?php echo (isset($quarter) && $quarter==2)?'selected="selected"':''; ?> value="2">Quarter 2</option>
									<option <?php echo (isset($quarter) && $quarter==3)?'selected="selected"':''; ?> value="3">Quarter 3</option>
									<option <?php echo (isset($quarter) && $quarter==4)?'selected="selected"':''; ?> value="4">Quarter 4</option>
								</select> 
							</div>
							<div class="col-lg-3">
								<select class="form-control form-control-cst" disabled id="month" name="month">
									<?php echo getAllMonthsOptions(); ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-lg-1">
						<button value="submit" type="submit" class="btn btn-success review_btn-success">Submit</button>
					</div>
					</form>
				</div>
			</div>
		</section>