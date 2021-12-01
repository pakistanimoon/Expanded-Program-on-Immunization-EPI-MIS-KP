<br>
<?php echo $listing_filters; ?>


<div class="modal fade bs-example-modal-lg" tabindex="-1" id="myLargeModalLabel" role="dialog" aria-labelledby="myLargeModalLabel">


					  <div class="modal-dialog modal-lg">
					  
					    <div class="modal-content">

 <div class="panel panel-primary mypanel">

                            <div class="panel-heading text-center">New Report Type</div>

  	                          <div class="panel-body">

    	      	                <form name="dataform" id="dataform" action="lhsdb_save.php" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
									
									<div class="row">

    	      	                		<div class="col-md-2 col-md-offset-3 col-sm-3 col-sm-offset-3  cmargin5">

    	      	                			<label>Report Tittle</label>

    	      	                		</div>

    	      	                		<div class="col-md-3 col-sm-4">

    	      	                			<input class="form-control" name="adv_rpt_title" id="adv_rpt_title" type="text">

    	      	                		</div>

    	      	                	</div><br>
    	      	                	<div class="row bgrowlis">

    	      	                		<div class="col-md-3 col-sm-3 cmargin5">

    	      	                			<label>Selected Fields</label>

    	      	                		</div>

    	      	                		<div class="col-md-1 col-md-offset-7 col-sm-1 col-sm-offset-7 cmargin5">

    	      	                			<label>Action</label>

    	      	                		</div>

    	      	                	</div>
									<div class="row" style="background-color:rgb(234, 240, 242);">

    	      	                		<div class="datarry col-md-11 col-md-offset-1"  id='rowid'>

    	      	                			

    	      	                		</div>  	      	   
    	      	                	</div>
    	      	                	
    	      	                	<hr>
    	      	                	
    	      	                	<div class="row">

    	      	                		<div class="col-md-2 col-md-offset-3 col-sm-3 col-sm-offset-3  cmargin5">

    	      	                			<label>Data Elements</label>

    	      	                		</div>

    	      	                		<div class="col-md-3 col-sm-4">

    	      	                		<select id="sections" name="sections" class="sections-drop  form-control" >
											<option value="0">-- Select --</option>
											<?php 
											if(isset($allSections)){
												foreach($allSections as $oneSec)

												{
													echo '<option value="'.$oneSec["secid"].'">'.$oneSec["description"].'</option>';

												}
											}?>
										</select>



    	      	                		</div>
										
										<div class="col-xs-2"></div>

    	      	                	</div>
									<div class="row" id="showttri" style="display:none">
									<div class="col-md-2 col-md-offset-3 col-sm-3 col-sm-offset-3  cmargin5">

    	      	                			<label>Vaccination</label>

    	      	                		</div>
										<div class="col-md-3 col-sm-4">
										<select class="sections-drop form-control" id="ttri" name="ttri">
										  <option value="">Select...</option>
										  <option value="TT-1">TT-1</option>
										  <option value="TT-2">TT-2</option>
										  <option value="TT-3">TT-3</option>
										  <option value="TT-4">TT-4</option>
										  <option value="TT-5">TT-5</option>
										</select>
									</div>
									</div>
									<div class="row" id="showcri" style="display:none">
									<div class="col-md-2 col-md-offset-3 col-sm-3 col-sm-offset-3  cmargin5">

    	      	                			<label>Vaccines</label>

    	      	                		</div>
										<div class="col-md-3 col-sm-4">
										<select class="sections-drop form-control" id="cri" name="cri">
											<option value="">Select...</option>
											<option value="BCG">BCG</option>
											<option value="Hep B">Hep B</option>
											<option value="OPV-0">OPV-0</option>
											<option value="OPV-1">OPV-1</option>
											<option value="OPV-2">OPV-2</option>
											<option value="OPV-3">OPV-3</option>
											<option value="PENTA-1">PENTA-1</option>
											<option value="PENTA-2">PENTA-2</option>
											<option value="PENTA-3">PENTA-3</option>
											<option value="PENTA-3">PENTA-3</option>
											<option value="PCV10-2">PCV10-2</option>
											<option value="PCV10-3">PCV10-3</option>
											<option value="IPV">IPV</option>
											<option value="ROTA-1">ROTA-1</option>
											<option value="ROTA-2">ROTA-2</option>
											<option value="Measles-1">Measles-1</option>
											<option value="Measles-2">Measles-2</option>
											<option value="Fully Immunized">Fully Immunized</option>
														
										</select>
									</div>
									</div>

    	      	                	<hr>

    	      	                	<div class="row">
										<div class="section_fields col-xs-12">
											
										</div>
									</div>
									
									</form>

    	      	                </div>

    	      	            </div>

					    </div>

					  </div>

					</div>
<script src="<?php echo base_url(); ?>includes/js/bootstrap-multiselect.js" type="text/javascript"></script>
<link   href="<?php echo base_url(); ?>includes/css/bootstrap-multiselect.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
	$(document).ready(function(){
		
		<?php if($this -> session -> UserLevel==4){ ?>
	    var tcode= <?php echo $this->session->Tehsil; ?>;
		$('#tcode').val(tcode);
		$('#tcode').trigger("change");
		<?php } ?>
		
		
		$(document).on('change','#sections', function(e){
			var select = $(this).val();
			if(select== "ttri"){			
			$('#showttri').show();
			}
			if(select== 0 || select=="cri" || select=="es" ){			
			$('#showttri').hide();
			}
		});
		$(document).on('change','#sections', function(e){
			var select = $(this).val();
			if(select== "cri"){			
			$('#showcri').show();
			}
			if(select== 0 || select=="ttri" || select=="es" ){			
			$('#showcri').hide();
			}
		});
		//function to save advance report and its fields into db
		$(document).on('click','#advReportAddBtn', function(e){
			var title = $("input[name=adv_rpt_title]").val();
			if(title!="")
			{
				//getting all selected fields
				var fIds = $(".datarry .row").map(function () {
					return this.id;
				}).get().filter(Boolean);
				
				if(fIds!="")
				{

					$.ajax({
						type: "POST",
						data: {title:title,fIds:fIds},
						url: "<?php echo base_url(); ?>Ajax_calls/createReport",
						success: function(result){
							if(result.indexOf("Error")==0)
							{
								alert(result);
							}else{
								$("#advRptTitle").html(result);
								$("input[name=adv_rpt_title]").val('');
								$("#sec_fields").val('');
								$("#col-md-8 col-md-offset-1 col-sm-8").val('');

								alert('New report added.');
								$('#myLargeModalLabel').modal('hide');

								
							}
						}
					});
				}else{
					alert("Error: Report fields must be selected");
				}
			}else{
				alert("Error: Report title cannot be null");
			}
		});
		$(document).on('change','#sections', function(e){
			$.ajax({
				type: "POST",
				
				data: "sec="+$(this).val(),
				url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
				success: function(result){
					
					$('.section_fields').html(result);
					
				}
			});
		});
		$(document).on('change','#ttri', function(e){
			$.ajax({
				type: "POST",
				
				data: "sec="+$(this).val(),
				url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
				success: function(result){
					
					$('.section_fields').html(result);
					
				}
			});
		});
		$(document).on('change','#cri', function(e){
			$.ajax({
				type: "POST",
				
				data: "sec="+$(this).val(),
				url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
				success: function(result){
					
					$('.section_fields').html(result);
					
				}
			});
		});
		//function to add fields for criteria of advance report
		$(document).on('click','#CriteriaAddBtn', function(e){
			var secId = $(this).data("sec");
			
			var secLabel = $("#sections option:selected").text();
			
			var rows='<div class="row"><div class="col-md-12 col-sm-12 bgrow2"><label>'+secLabel+'</label></div></div>';

			$("input[name=sec_fields]:checked").each(function () {
				var uniqueId = secId+"-"+$(this).val();
				
				
				rows += '<div class="row" id="'+uniqueId+'"><div class="col-md-8 col-md-offset-1 col-sm-8">'+$(this).parent().parent().find('.sec_field_label').text()+'</div><div class="col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1"> <a style="color: black;" href="#" class="del_selected_field" data-id="'+uniqueId+'"><i class="fa fa-trash-o"> Delete</i></a></div></div>';
			});

			$('.datarry').append(rows);
		});
		
	

	$(document).on('click','.del_selected_field', function(){
		var idd = $(this).data("id");
		$('.row[id='+idd+']').remove();
	});


		$(document).on('click','#closeReportAddBtn', function(e){
			$('#myLargeModalLabel').modal('hide');

		});
	
		
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#week').html(response);
			}
		});
		$(".dp-my").datepicker({
			autoclose: true,
			format: "mm-yyyy",
			viewMode: "months", 
			minViewMode: "months"
		});
		$("#monthfrom").datepicker({
		}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			$('#monthto').datepicker('setStartDate', minDate);
		});
	});
	$(document).on('change','#year',function(){
		var year = $(this).val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#week').html(response);
			}
		});
	});
	/* $(document).on('change','#week',function(){
		var week = $(this).val();
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeksDates',
			data:'epiweek='+week+'&year='+year,
			success: function(response){
				var obj = JSON.parse(response);
				$('#datefrom').val(obj.startDate);
				$('#dateto').val(obj.EndDate);
			}
		});
	}); */
		$(document).on('click','#pre-btn', function(){
		var type_id = $('#type_id').val();
		//alert(type_id); exit();
		if(type_id==''){
			alert('Please Select HR Type'); 
			return false;
		}
	});
<?php if($this->uri->segment(3)=="HR-Summary-Report"){ ?>
		$(
			'<div class="row ">'+
				'<div class="form-group">'+
					'<label for="status" class="col-xs-3 control-label" id="status-label">Status</label>'+
						'<div class="col-xs-7">'+
							'<select name="status" id="status" class="form-control">'+
								'<?php echo get_all_status(true); ?>'+
							'</select>'+
  					    '</div>'+
				'</div>'+
			'</div>'
		).insertBefore(
			$('.content-wrapper').find('section').find('.row').find('.row:last')
		); 
		
		 $( 
			'<div class="row" id="HRType">'+
				'<div class="form-group">'+
					'<label class="col-xs-3 control-label" for = "type_id" >Select HR</label>'+
					'<div class="col-xs-7">'+
						'<select class="form-control" name="type_id[]" id="type_id" multiple="multiple">'+
							'<?php echo get_all_subtype_name(true); ?>'+
						'</select>'+
					'</div>'+
				'</div>'+
			'</div>' 
		).insertBefore(
			$('.content-wrapper').find('section').find('.row').find('.row:last')
		);  
		$("#type_id").multiselect('destroy');
		document.getElementById("type_id").setAttribute("multiple", "multiple"); 
		$('#type_id').multiselect({
			includeSelectAllOption: true,
			buttonClass: 'form-control',
			buttonWidth: '311px',
			enableFiltering: true,
			maxHeight: 118   
		});
		$('#type_id').multiselect('rebuild');
<?php }?>
</script>