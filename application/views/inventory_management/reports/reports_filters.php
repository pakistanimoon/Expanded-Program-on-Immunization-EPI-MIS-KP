<br>
<?php echo $listing_filters; 
$currentYear = date('Y');

?>
<script type="text/javascript" src="<?php echo base_url(); ?>/includes/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/bootstrap-multiselect.js" type="text/javascript"></script>
<link   href="<?php echo base_url(); ?>includes/css/bootstrap-multiselect.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
	//stock_movement_reports
	$('#unioncouncil').css('display','none');
	$('#union_council-label').css('display','none');
	//yearly_status report,inventory_status,expiry_rate,vaccine_distribution; 
	$('#uc').css('display','none');
	$('#uc-label').css('display','none');
	//set last index of year to selected
	$("#year option:last").attr("selected", "selected");
	//please discuss before uncommenting below lines.
	/* $(document).ready(function(){

		$("#year").trigger("change");
	}); */
	function get_store_locations(to_warehouse_type_id,fieldname/* ,warehouse_procode */){
		//warehouse_procode = warehouse_procode || 0;
		/* if(to_warehouse_type_id==6){
			var fieldname = 'uccode';
		}else{ */
		//	var fieldname = 'warehouse_store';//'code';
		//}
		$("select[name="+fieldname+"]").html('');//$('#'+fieldname).trigger("change");
		$.ajax({
			type: "POST",
			datatype: "JSON",
			async:false, 
			data: {to_warehouse_type_id: to_warehouse_type_id,warehouse_procode:<?php echo $this->session->Province; ?>},
			url: "<?php echo base_url("getstoreloc"); ?>",
			success: function(result){
				result = JSON.parse(result);				
				/* if(to_warehouse_type_id==4)
					$("select[name="+fieldname+"]").append('<option value="all">All</option>'); */
				$("select[name="+fieldname+"]").append(result.optionshtml);
			}
		});
	}
	function get_fac_store_locations(warehouse_uccode,fieldname)
	{		
		$.ajax({
			type: "POST",
			data:{warehouse_uccode:warehouse_uccode},
			datatype: "JSON",
			url: "<?php echo base_url("getfacstoreloc"); ?>",
			success: function(result){
				result = JSON.parse(result);
				$("select[name="+fieldname+"]").html(result.optionshtml);
				
			}
		});
	}	
	$('#unioncouncil').on('change', function (e, data) {
		var warehouseuc=$('#unioncouncil').val();
		get_fac_store_locations(warehouseuc,'to_warehouse_store');
	});
	$('#uc').on('change', function (e, data) {
		var warehouseuc=$('#uc').val();
		get_fac_store_locations(warehouseuc,'warehouse_store');
	});
	$(document).on('change','#warehousestore',function(){
		var towarehouselevel = $('#towarehouselevel').val();
		get_store_locations(towarehouselevel,'union_council');
		$('#unioncouncil').trigger("change");
	});
	$(document).on('change','#warehouselevel',function(){
		var warehouselevel = $(this).val();	
		if(warehouselevel==1)
		{
			$('#unioncouncil').css('display','none');
			$('#union_council-label').css('display','none'); 
			$('#uc-label').css('display','none');
			$('#uc').css('display','none');
			get_store_locations(warehouselevel,'warehouse_store');
			//$('#towarehouselevel').empty();
			$('#towarehouselevel').val('2');
			var towarehouselevel = $('#towarehouselevel').val();
			get_store_locations(towarehouselevel,'to_warehouse_store');
            $("#towarehouselevel option[value='1']").remove();
			$("#towarehouselevel option[value='5']").remove();
			$("#towarehouselevel option[value='6']").remove();
        }else if(warehouselevel==2){
			$('#unioncouncil').css('display','none');
			$('#union_council-label').css('display','none'); 
			$('#uc-label').css('display','none');
			$('#uc').css('display','none');
			$('#towarehouselevel').val('4');
			var towarehouselevel = $('#towarehouselevel').val();
			get_store_locations(warehouselevel,'warehouse_store');
			get_store_locations(towarehouselevel,'to_warehouse_store');
            $("#towarehouselevel option[value='5']").remove();
			$("#towarehouselevel option[value='6']").remove();
        }else if(warehouselevel==4){
			get_store_locations(warehouselevel,'warehouse_store');
            //newcode
			$("#towarehouselevel option[value='5']").remove();
			$('#towarehouselevel').append('<option value="5">Tehsil</option>');
			$('#towarehouselevel').val('5');
			var towarehouselevel1 = $('#towarehouselevel').val();
			
			//endcode
			$("#towarehouselevel option[value='6']").remove();
            $('#towarehouselevel').append('<option value="6">Union Council</option>');
			$('#towarehouselevel').val('6');
			var towarehouselevel = $('#towarehouselevel').val();
			var level=<?php echo $this -> session -> UserLevel; ?>;
			$('#union_council-label').css('display','');
			$('#unioncouncil').css('display','');
			$('#uc-label').css('display','none');
			$('#uc').css('display','none');
			get_store_locations(towarehouselevel,'union_council');
			$('#unioncouncil').trigger("change",[{fieldname:'to_warehouse_store'}]);
            $("#towarehouselevel option[value='1']").remove();
        }//newcode
		else if(warehouselevel==5){
			$('#unioncouncil').css('display','none');
			$('#union_council-label').css('display','none'); 
			$('#uc-label').css('display','none');
			$('#uc').css('display','none');
			$('#towarehouselevel').val('5');
			var towarehouselevel = $('#towarehouselevel').val();
			get_store_locations(warehouselevel,'warehouse_store');
			get_store_locations(towarehouselevel,'to_warehouse_store');
		}//endcode
		else{
            $('#uc-label').css('display','');
			$('#uc').css('display','');
			get_store_locations(warehouselevel,'uc');
			$('#uc').trigger("change",[{fieldname:'warehouse_store'}]);
		}
	});
	$('#warehouselevel').trigger("change");
	$(document).on('change','#towarehouselevel',function(){
		var warehouselevel = $(this).val();	
		if(warehouselevel==1){
			$('#unioncouncil').css('display','none');
			$('#union_council-label').css('display','none'); 
			get_store_locations(warehouselevel,'to_warehouse_store');
		}else if(warehouselevel==2){
			$('#unioncouncil').css('display','none');
			$('#union_council-label').css('display','none'); 
			get_store_locations(warehouselevel,'to_warehouse_store');
		}else if(warehouselevel==4){
			get_store_locations(warehouselevel,'to_warehouse_store');
			$('#union_council-label').css('display','none');
			$('#unioncouncil').css('display','none')
			//$("#towarehouselevel option[value='6']").remove();
		}//newcode
		else if(warehouselevel==5){
			get_store_locations(warehouselevel,'to_warehouse_store');
			$('#union_council-label').css('display','none');
			$('#unioncouncil').css('display','none')
			//$("#towarehouselevel option[value='5']").remove();
		} 
		else{
			var towarehouselevel = $('#towarehouselevel').val();
			var level=<?php echo $this -> session -> UserLevel; ?>;
			$('#union_council-label').css('display','');
			$('#unioncouncil').css('display','');
			$('#uc-label').css('display','none');
			$('#uc').css('display','none');
			get_store_locations(towarehouselevel,'union_council');
			$('#unioncouncil').trigger("change",[{fieldname:'to_warehouse_store'}]);
		} //endcode

});
	$(document).ready(function(){
		if((isExists('monthto') && isExists('monthfrom'))){
			//$('#pre-btn').prop('disabled', true);
			$(document).on('change','.dp-my',function(){
				if(($('#monthto').val() !="" && $('#monthfrom').val() !="")){
					$('#pre-btn').prop('disabled', false);
				}else{
					$('#pre-btn').prop('disabled', true);
				}
			});
		}
		if(isExists('report_type')){
			$('#pre-btn').prop('disabled', true);
			$(document).on('change','#report_type',function(){
				if($('#report_type').val() !=0){
					$('#pre-btn').prop('disabled', false);
				}else{
					$('#pre-btn').prop('disabled', true);
				}
			});
		}
       <?php if($this -> session -> UserLevel==4){ ?>
	    var tcode= <?php echo $this->session->Tehsil; ?>;
		$('#tcode').val(tcode);
		$('#tcode').trigger("change");
		<?php } ?>
		
/* if($('input[name=report_type]:checked').val() == "yearly"){
			$('#month').val('');
			$('#month').removeAttr('required','required');
		}
		else if($('input[name=report_type]:checked').val() == "monthly"){
			$('#month').attr('required','required');
		}else{} */
		/* var dist = $("#distcode").val();
		if(dist>0)
			$('#typeWise').show();
		else
			$('#typeWise').hide();
		if($('#year option:last').val() == new Date().getFullYear()){
			$('#year option:last').prop('selected', true);
		}else{
			$('#year option:first').prop('selected', true);
		} */
		/* var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#week').html(response);
			}
		}); */
	});
	/* if(isNameExists('invnRepType') && ($("input[name=invnRepType]:checked").val() =="storewise")){
		$('#pre-btn').prop('disabled', true);
		$(document).on('change','#month',function(){
			var selectedval = $("#month:checked").val();
			if((selectedval !=="")){
				$('#pre-btn').prop('disabled', false);
			}else{
				$('#pre-btn').prop('disabled', true);
			}
		});
	} */
	$(document).on('change','input[name=invnRepType]',function(){
		var selectedval = $("input[name=invnRepType]:checked").val();
		if( selectedval == "monthwise"){
			$('#monthfrom').closest(".form-group").hide();
			$('#monthto').closest(".form-group").hide();
			$('#monthto').val('');
			$('#monthfrom').val('');
			$('#year').closest(".form-group").show();
			$('#year').val((new Date).getFullYear() );
			$('#monthfrom').removeAttr("required");
			$('#monthto').removeAttr("required");
		}else if( selectedval == "storewise"){
			$('#monthfrom').closest(".form-group").show();
			$('#monthto').closest(".form-group").show();
			$('#monthfrom').attr("required","required");
			$('#monthto').attr("required","required");
			$('#year').closest(".form-group").hide();
			$('#year').val('');
			/* $('#warehouselevel').val('2');
			$('#warehouselevel').trigger("change"); */
		}
	});
	$('input[name=invnRepType]').trigger("change");
	/* $("#distcode").click(function(){
		var distcode = $("#distcode").val();
		if(distcode>0)
			$('#typeWise').show();
		else
			$('#typeWise').hide();
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
	}); */	
	function isExists(elemId){
		if($('#'+elemId).length > 0){
			return true;
		}else{
			return false;
		}
	}
	function isNameExists(elemName){
		if($('input[name='+elemName+']').length > 0){
			return true;
		}else{
			return false;
		}
	}
	$(".dp-my").datepicker({
		autoclose: true,
		format: "yyyy-mm",
		viewMode: "months", 
		minViewMode: "months",
		orientation: "top"
	});
	$(".dpcurr").datepicker({
		autoclose: true,
		format: "yyyy-mm-dd"
	});
	$("#monthfrom").datepicker({
	}).on('changeDate', function (selected) {
		var minDate = new Date(selected.date.valueOf());
		$('#monthto').datepicker('setStartDate', minDate);
	});
	$("#datefrom").datepicker({}).on('changeDate', function (selected) {
		if($("#datefrom").val()>$('#dateto').val()){
			$('#dateto').val('');
		}
		var minDate = new Date(selected.date.valueOf());
		$('#dateto').datepicker('setStartDate', minDate);
	});
		$('#purpose').on('change', function () {
		var purpose=$(this).val();
		$('#product').html('');
				$.ajax({
			type: "POST",
			data:{purpose:purpose},
			//datatype: "JSON",
			url: "<?php echo base_url("inventory/Reports/get_purpose_product"); ?>",
			success: function(result){
				console.log(result);
				//result = JSON.parse(result);
				$('#product').html(result);
				}
				});
	});
    <?php if(isset($data['type'])): ?>
	var type = '<?php echo $data['type']; ?>';
	if( type == "current_stock")
	{
		//$("body").has("hr").remove();
		if($("body").has("hr")){
			$("hr").remove();
		}
		$("#distcode option[value='0']").text("Provincial Store");
		activity_purpose();
		category();
		
	}
	<?php endif; ?>
	function category()
	{
		$( 
			'<div class="row" id="StockoutRate">'+
				'<div class="form-group">'+
					'<label class="col-xs-3 control-label" for = "vacc_ind" >Select Category</label>'+
					'<div class="col-xs-7">'+
						'<select class="form-control" name="vacc_ind[]" id="vacc_ind" multiple="multiple" required>'+
							'<option value="1">Vaccine</option>'+
							'<option value="2">Non-Vaccine</option>'+
							'<option value="3">Dilluent</option>'+
						'</select>'+
					'</div>'+
				'</div>'+
			'</div>'+
			'<hr>'
		).insertBefore(
			$('.content-wrapper').find('section').find('.row').find('.row:last')
		);
		$("#vacc_ind").multiselect('destroy');
		document.getElementById("vacc_ind").setAttribute("multiple", "multiple"); 
		$('#vacc_ind').multiselect({
			includeSelectAllOption: true,
			buttonClass: 'form-control',
			buttonWidth: '311px',
			enableFiltering: true,
			maxHeight: 118,
			onSelectAll: function() {
			$('button[class="multiselect"]').attr('title',false);	
			},
			buttonTitle: function() {},
		});
		
		$("#vacc_ind").multiselect('selectAll', false);
		$('#vacc_ind').multiselect('rebuild');
	};
	
	function activity_purpose()
	{
		$( 
			'<div class="row" id="activity">'+
				'<div class="form-group">'+
					'<label class="col-xs-3 control-label" for = "act_purpose" >Select Purpose</label>'+
					'<div class="col-xs-7">'+
						'<select class="form-control" name="act_purpose[]" id="act_purpose" multiple="multiple" required>'+
							'<option value="1">Routine</option>'+
							'<option value="2">Campaign</option>'+
							'<option value="3">IHR (International Health Regulation)</option>'+
							'<option value="4">PTP (Permanent Transit Vaccination Points)</option>'+
							'<option value="5">Case Response/Mopup</option>'+
						'</select>'+
					'</div>'+
				'</div>'+
			'</div>'
		).insertBefore(
			$('.content-wrapper').find('section').find('.row').find('.row:last')
		);
		$("#act_purpose").multiselect('destroy');
		document.getElementById("act_purpose").setAttribute("multiple", "multiple"); 
		$('#act_purpose').multiselect({
			includeSelectAllOption: true,
			buttonClass: 'form-control',
			buttonWidth: '311px',
			enableFiltering: true,
			maxHeight: 118,
			onSelectAll: function() {
			$('button[class="multiselect"]').attr('title',false);	
			},
			buttonTitle: function() {},
		});
		$("#act_purpose").multiselect('selectAll', false);
		$('#act_purpose').multiselect('rebuild'); 
	};
</script>