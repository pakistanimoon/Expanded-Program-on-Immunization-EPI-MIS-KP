	<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
	<script src="<?php echo base_url(); ?>includes/Highcharts-4.2.6/js/themes/grid-light.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var dashboard_id = '<?php echo $dashboard_id ?>';
			$('.component-container').sortable({
				cursor: 'move',
				placeholder: 'ui-state-highlight',
				start: function(e, ui) {
					$(this).attr('data-previndex', ui.item.index());
					//console.log('start: ' + ui.item.index())
					ui.placeholder.width(ui.item.find('.panel').width());
					ui.placeholder.height(ui.item.find('.panel').height());
					ui.placeholder.addClass(ui.item.attr("class"));
				},
				 update : function(event, ui1) {
					 //----------code to update sorting of tabs
					var newIndexarray = [];
					$.each($('.create-div1'), function(index1, element) {
						var indval = $(this).data('widgetidupd');
						newIndexarray.push(indval);
					});
					//console.log(newIndexarray);
					$.ajax({
						type: "POST",
						data: {dashboard_id:dashboard_id,arraySort:newIndexarray},
						url: "<?php echo base_url(); ?>Dashboard_ajax_calls/updateWidgetSort",
						success: function(result){
							console.log(result);
						}
					});
				   //--------------
				}
			});
		});
	</script>
	<section class="custom-interface">
		<div class="row" style="margin-left:0px; margin-right:0px;">
			<div class="col-md-12 col-create">
				<table class="table table-bordered table-striped" id="table-widget">
					<thead>
						<tr>
							<th colspan="2">
								<h3 style="margin:0px;"><?php echo getDashboardName($dashboard_id); ?></h3>
							</th>
							<th class="text-right" style="width:200px;">
							<?php if($user){ ?>
								<a class="btn btn-primary-cst" data-dashboardid="<?php echo $this -> uri -> segment(4); ?>" id="del-dashboard"><i class="fa fa-times"></i> Delete Dashboard</a><span></span>
							<?php } ?>
							</th>
						</tr>
						<tr>
							<th colspan="2">
								<span><button class="btn btn-primary-cst " data-toggle="modal" data-target="#myModal2"><i class="fa fa-plus"></i> Add Widget</button></span>
							</th>
							<th class="text-right">
								<a href="<?php echo base_url(); ?>custom-dashboard"><i class="fa fa-th"></i> Dashboard List</a>
							</th>
							
						</tr>	
					</thead>
					<tbody>
						<!-- <tr> -->
							<!-- <td>Custom Report 1</td> -->
							<!-- <td>Dec 5, 2018</td> -->
							<!-- <td>Private</td> -->
						<!-- </tr> -->
					</tbody>
				</table>
			</div>			
			<div class="col-md-12 dragdiv component-container ui-sortable">
				<?php 
				if(isset($display) && ! empty($display)){
					foreach($display as $key => $val){ ?>
					<!--<a class="btn ibtnDel-col" type="button"> <i class="fas fa-pencil-alt"></i> </a>-->
					<?php echo $val; ?>
				<?php }
				}?>
			</div>
			<div class="col-md-12 text-right show-refresh">
				<a onclick="location.reload();" style="cursor:pointer;"><i class="fa fa-recycle"></i> Refresh Dashboard</a>
			</div>
		</div>
		<form id="widget-form" name="myform">
			<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog top-10" role="document">
					<div class="modal-content border-radius-4" style="width:645px; height:650px; overflow:scroll;" >
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel"><span style="color:#232323;">Add a Widget <i class="fa fa-widget"></i></span></h4>
						</div>
						<div class="modal-body block-widget">
							<div class="row customRow">
								<!-- -->
								<input type="hidden" name="dashboard" value="<?php echo $dashboard_id; ?>">
								<div class="col-md-12 form-group">
									<strong>Widget Title</strong>
									<input type="text" id="widget_title" name="widget_title" class="form-control width-80 border-radius-3" >
								</div>
								<div class="col-md-12 form-group">
									<strong>Module</strong>
									<select class="form-control width-80" name="module" id="module">
										<option>--Select Module--</option>
										<?php getModulesOptions(); ?>
									</select>
								</div>
								<div class="col-md-12 form-group">
									<strong class="display-block">Standard Widget</strong>
								</div>
								<?php getAllStandardWidgets(); ?>
								<div class="col-md-12 form-group">
									<strong>Show the following Indicator : </strong>
									<select class="form-control width-80" name="indicator" id="indicator">
										<option>--Select Module first--</option>
									</select>
								</div>
								<div class="col-md-12 form-group subind hide">
									<strong>Show the following Indicator : </strong>
									<select class="form-control width-80" name="subindicator" id="subindicator">
										
									</select>
								</div>
								<div class="col-md-12 form-group">
									<strong class="display-block" >Filter this data</strong>
								</div>
								<!-- -->
							</div>
							<div class="row">
								<div class="modal-footer">
									<div class="col-md-4 col-xs-4">
										<button class="btn btn-primary-cst" id="create-div" type="submit" style="position:relative; left:4px"><i class="fa fa-plus"></i> Create</button>
									</div>
									<div class="col-md-3 col-xs-3">
										<button class="btn btn-primary-cst" data-dismiss="modal"><i class="fa fa-times"></i> Cancle</button>
									</div>
								</div>
								<!--<div class="col-md-5 col-xs-5">
									<strong><a href="">Clone Widget</a></strong>
								</div>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
	
	<script type="text/javascript">
		$(document).ready(function () {
			$('#myModal2').modal('show');
			var counter = 0;
			$("#addrow").on("click", function () {
				var newRow = $("<div class='row bg-secondary'>");
				var cols = "";

				cols += '<div class="col-md-3"><select class="form-control" style="margin-left:10px;" name="name '+ counter +'"><option  selected >Only show</option><option>Dont Show</option></select></div><div class="col-md-3"><select class="form-control"><option value="">Exactly matching</option><option value="">Regular Expression</option><option value="">Begins With</option><option value="">Ends With</option><option value="" selected="selected">Containing</option></select></div><div class="col-md-4"><input type="text" placeholder="Filter by Name" class="form-control"></div>';
				
				cols += '<div class="col-md-2"><i type="button" class="fa fa-times ibtnDel btn-md"></i></div>';
				newRow.append(cols);
				$("div.customRow").append(newRow);
				counter++;
			});
			$("div.block-widget").on("click", ".ibtnDel", function (event) {
				$(this).closest("div.row").remove();       
				counter -= 1
			});
			$("#create-div").on("click", function () {
				var newRow = $("<div class='col-md-6 create-div1 component-container ui-sortable' data-width='col-md-6 col-sm-6 col-xs-12' '>");
				var cols = "";
				cols += '<h4>Page preview</h4>';
				cols += '<a class="btn ibtnDel-col" type="button"> <i class="fa fa-times"></i> </a>';
				cols += '<a class="btn ibtnDel-col" type="button"> <i class="fas fa-pencil-alt"></i> </a>';
				cols += '<canvas id="canvas'+ counter+'"></canvas>';
				newRow.append(cols);
				$("div.dragdiv").append(newRow);
				counter++;
			});
			/* delete dashboard widget function */
			$("div.row").on("click", ".ibtnDel-col", function (event) {
				var result = confirm("Do you really want to delete?");
				if (result === true) {
					var $widgetID = $(this).data('widgetid');
					var $obj = $(this);
					$.ajax({
						type: "POST",
						data: {widgetId:$widgetID},
						url: "<?php echo base_url(); ?>Dashboard_ajax_calls/deleteDashboardWidget",
						success: function(result){
							alert('Widget deleted successfully!');
							$($obj).closest("div.col-md-6").remove();
						}
					});
				}
			});
			/* delete dashboard function */
			$("div.row").on("click", "#del-dashboard", function (event) {
				var result = confirm("Do you really want to delete this dashboard?");
				if (result === true) {
					var $dashboardID = $(this).data('dashboardid');
					var $obj = $(this);
					$.ajax({
						type: "POST",
						data: {dashboardId:$dashboardID},
						url: "<?php echo base_url(); ?>Dashboard_ajax_calls/deleteDashboard",
						success: function(result){
							alert('Dashboard deleted successfully!');
							window.location.href="<?php echo base_url(); ?>custom-dashboard";
						}
					});
				}
			});
		});
		$( "#widget-form" ).on( "submit", function( event ) {
			event.preventDefault();
			var data = $( this ).serialize();
			$.ajax({
				type: "POST",
				data: data,
				url: "<?php echo base_url(); ?>Dashboard_ajax_calls/saveDashboardNewWidget",
				success: function(result){
					console.log(result);
					$('#myModal2').modal('hide');
					alert('New Widget added successfully!');
					location.reload();
				}
			});
			//console.log( $( this ).serialize() );
			
		});
		<!-- window.onload = function() { -->
		/* var n = 0;
		$(document).on('click','#create-div',function() {
			var ctx = document.getElementById("canvas"+n+"").getContext('2d');
			window.myLine = new Chart(ctx, config);
			n++;
			var data = $('#widget-form').serialize();
		}); */
		/* document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});
			window.myLine.update();
		}); */
		//var colorNames = Object.keys(window.chartColors);
		/* document.getElementById('addDataset').addEventListener('click', function() {
			var colorName = colorNames[config.data.datasets.length % colorNames.length];
			var newColor = window.chartColors[colorName];
			var newDataset = {
				label: 'Dataset ' + config.data.datasets.length,
				backgroundColor: newColor,
				borderColor: newColor,
				data: [],
				fill: false
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
			}

			config.data.datasets.push(newDataset);
			window.myLine.update();
		}); */
		/* document.getElementById('addData').addEventListener('click', function() {
			if (config.data.datasets.length > 0) {
				var month = MONTHS[config.data.labels.length % MONTHS.length];
				config.data.labels.push(month);

				config.data.datasets.forEach(function(dataset) {
					dataset.data.push(randomScalingFactor());
				});

				window.myLine.update();
			}
		}); */
		/* document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myLine.update();
		}); */
		/* document.getElementById('removeData').addEventListener('click', function() {
			config.data.labels.splice(-1, 1); // remove the label first
			config.data.datasets.forEach(function(dataset) {
				dataset.data.pop();
			});
			window.myLine.update();
		}); */
		
		$(document).on('change','#module',function(){
			var widgetId = parseInt($("input[name='widget']:checked").val());
			var moduleId = parseInt($("#module").val());
			$("div.bg-secondary").remove();
			if(widgetId > 0 && moduleId > 0){
				$.ajax({
					type: "POST",
					data: {widgetId:widgetId,moduleId:moduleId},
					url: "<?php echo base_url(); ?>Dashboard_ajax_calls/getWidgetIndicators",
					success: function(result){
						$('#indicator').html(result);
					}
				});
			}
		});
		$(document).on('click','.widget-name',function(){
			var widgetId = parseInt($("input[name='widget']:checked").val());
			var moduleId = parseInt($("#module").val());
			$("div.bg-secondary").remove();
			if(widgetId > 0 && moduleId > 0){
				$.ajax({
					type: "POST",
					data: {widgetId:widgetId,moduleId:moduleId},
					url: "<?php echo base_url(); ?>Dashboard_ajax_calls/getWidgetIndicators",
					success: function(result){
						$('#indicator').html(result);
						$('.subind').addClass('hide');
					}
				});
			}
		});
		$(document).on('click','#indicator',function(){
			var indicatorId = parseInt($("#indicator").val());
			var moduleId = parseInt($("#module").val());
			if(indicatorId > 0 && moduleId > 0){
				$.ajax({
					type: "POST",
					async:false,
					data: {indicatorId:indicatorId,moduleId:moduleId},
					url: "<?php echo base_url(); ?>Dashboard_ajax_calls/getIndicatorSubIndicators",
					success: function(result){
						if(result.trim() == ''){
							$('.subind').addClass('hide');
						}else{
							$('.subind').removeClass('hide');
							$('#subindicator').html(result);
						}
					}
				});
				var subIndicatorId = parseInt($("#subindicator").val());
				if(indicatorId > 0 && subIndicatorId > 0){
					$.ajax({
						type: "POST",
						data: {indicatorId:indicatorId,subIndicatorId:subIndicatorId},
						url: "<?php echo base_url(); ?>Dashboard_ajax_calls/getIndicatorFilters",
						success: function(result){
							if(result.trim() == ''){
								
							}else{
								$("div.bg-secondary").remove();
								$("div.customRow").append(result);
							}
						}
					});
				}
			}
		});
		$(document).on('change','#subindicator',function(){
			var indicatorId = parseInt($("#indicator").val());
			var subIndicatorId = parseInt($("#subindicator").val());
			if(indicatorId > 0 && subIndicatorId > 0){
				$.ajax({
					type: "POST",
					data: {indicatorId:indicatorId,subIndicatorId:subIndicatorId},
					url: "<?php echo base_url(); ?>Dashboard_ajax_calls/getIndicatorFilters",
					success: function(result){
						if(result.trim() == ''){
							
						}else{
							$("div.bg-secondary").remove();
							$("div.customRow").append(result);
						}
					}
				});
			}
		});
		$('.filter-info-div').css('cursor','pointer');
		$(document).on('click','.filter-info-div',function(){
			$(this).closest('div').find('.widget-filter-div').toggleClass('hide');
		});
	</script>