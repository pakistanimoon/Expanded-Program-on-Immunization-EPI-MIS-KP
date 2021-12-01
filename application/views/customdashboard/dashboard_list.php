<section class="custom-interface">
	<!-- -->
	<div class="row" style="margin-left:0px; margin-right:0px;">
		<div class="col-md-12 col-create">
			<table class="table table-bordered table-striped update-hide">
				<thead>
					<tr>
						<th colspan="4">
							<span><button class="btn btn-primary-cst" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Create</button></span>
						</th>
					</tr>	
					<tr>
						<th style="width:30%;">Name</th>
						<th>Creation Date</th>
						<th style="width:25%;">Type</th>
						<th style="width:10%;">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=0;
					foreach($userDashboards as $key => $dashboard){
					?>
					<tr data-id="<?php echo $dashboard['pk_id']; ?>">
						<td><a href="<?php echo base_url('customdashboard/Custom_Dashboard/open_dashboard').'/'.$dashboard['pk_id']; ?>"><span><?php echo $dashboard['tittle']; ?></span></a></td>
						<td><?php echo $dashboard['created_datetime'];?></td>
						<td><?php echo (isset($dashboard['type']))?$dashboard['type']:''; ?></td>
						<td class="text-center">
							<!-- <button class="btn btn-primary-cst">Update</button> -->
							<?php if($dashboard['user'] == $user){ ?>
							<span title="Update" class="bg rowUpdate edit" id="edit[<?php echo $i; ?>]"><i class="fas fa-recycle"></i></span>
							<?php } ?>
							<span title="Save" class="bg rowUpdate save" id="save.entry[<?php echo $i; ?>]" style="display:none"><i class="far fa-save"></i></span>
							<span title="Cancle" class="bg rowUpdate cancel" id="cancel[<?php echo $i; ?>]" style="display:none"><i class="far fa-close"></i></span>
							<?php if($dashboard['user'] != $user){ ?>
							<span title="Hide" class="bg hidebtn" id=""><i class="far fa-eye-slash"></i></span>
							<?php } ?>
							<a class="view" href="<?php echo base_url('customdashboard/Custom_Dashboard/open_dashboard').'/'.$dashboard['pk_id']; ?>"><span title="Open" class="bg" id=""><i class="far fa-eye"></i></span></a>
						</td>
					</tr>
					<?php $i++; } ?>
				</tbody>
			</table>
		</div>
		<div class="col-md-12 dragdiv component-container ui-sortable"></div>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><span style="color:#232323;">Create Dashboard</span></h4>
				</div>
				<div class="modal-body">
					<form id="createdashboard" action="<?php echo base_url('customdashboard/Custom_Dashboard/create_dashboard'); ?>" method="POST">
						<div class="row">
							<div class="div-radio">
								<input type="radio" id="control_02" name="temptype" value="0" checked>
								<label for="control_02">
									<h5><i class="fas fa-chalkboard"></i> Blank Template</h5>
								</label>
							</div>
							<div class="div-radio">
								<input type="radio" id="control_03" name="temptype" value="1">
								<label for="control_03">
									<h5><i class="fas fa-laptop-code"></i> Starter Template</h5>
								</label>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 pl-5">
								<div class="form-check form-check-inline cst-form-check-inline pl-4">
									<input class="form-check-input" type="radio" id="inlineCheckbox1" value="1" name="dashboardtype" checked>
									<label class="form-check-label afterNone" for="inlineCheckbox1">Public</label>
								</div>
								<div class="form-check form-check-inline cst-form-check-inline pl-4">
									<input class="form-check-input" type="radio" id="inlineCheckbox2" value="2" name="dashboardtype">
									<label class="form-check-label afterNone" for="inlineCheckbox2">Private</label>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<div class="col-md-5 col-xs-5">
								<input type="text" class="form-control" required name="dashboardname" value="Untitled Dashboard" style="height:31px; width:118%;" />
							</div>
							<div class="col-md-4 col-xs-4">
								<button class="btn btn-primary-cst" type="submit"  style="position:relative; left:4px">Create Dashboard</button>
							</div>
							<div class="col-md-3 col-xs-3">
								<button class="btn btn-primary-cst" data-dismiss="modal">Cancle</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
$(document).on('click', '.edit', function(e){
	var i =$(this).closest('tr').index();
	$(this).hide().siblings('.hidebtn,.view').hide();
    $(this).hide().siblings('.save, .cancel').show();
    var currentTD = $(this).closest('td').siblings();
	var tittle = $(this).closest('tr').children('td:first').text();
	var type   = $(this).closest('tr').children().eq(2).text();
	var rowfirsttd = "<input type='text' class='form-control' name='dashboardname' style='height:31px; width:102%;' value='"+tittle+"'>";
	var radiovl = radiovl2 = 0;
	
	var checked = checked2 = "";
	if(type=="Private"){
		radiovl2 = 2;
		checked2 = "checked='checked'";
	}else if(type=="Public"){
		radiovl = 1;
		checked = "checked='checked'";			
	}
	var rowthirdtd = "<div class='form-check form-check-inline cst-form-check-inline pl-4'><input class='form-check-input inlineCheckbox' type='radio' id='inlineCheckbox1' value='"+radiovl+"' name='dashboardtype"+[i]+"' "+checked+"></input><label class='form-check-label afterNone' for='inlineCheckbox1'>Public</label><input class='form-check-input inlineCheckbox' type='radio' id='inlineCheckbox2' value='"+radiovl2+"' name='dashboardtype"+[i]+"' "+checked2+"></input><label class='form-check-label afterNone' for='inlineCheckbox2'>Private</label></div>";
	$.each(currentTD, function () {
		$(this).closest('tr').children('td:first').html(rowfirsttd);
		$(this).closest('tr').children().eq(2).html(rowthirdtd);
		
     });
});
$(document).on('click', '.cancel', function() {
	var dashboard_id = $(this).closest("tr").data('id');
	var i =$(this).closest('tr').index();
    var $btn = $(this);
	var tittle = $("input[name=dashboardname]").val(); 
	var type   = $('input[name=dashboardtype'+[i]+']:checked').val();
	if(type == 2)
		type = 'Private';
	else
		type = 'Public';
	$('.update-hide').find('.hidebtn').show();
	$( "#save\\.entry\\["+i+"\\]" ).hide();
	$(this).hide().siblings('.view').show();
	$btn.hide().siblings('.edit').show();
	currentTD = $(this).closest('td').siblings();
    $.each(currentTD, function () {
		$(this).closest('tr').children('td:first').html("<a href='<?php echo base_url(); ?>customdashboard/Custom_Dashboard/open_dashboard/"+dashboard_id+"'>"+tittle+"</a>");
		$(this).closest('tr').children().eq(2).html(type);
    });
});
$('.update-hide').on('click', '.save', function() {
	var i =$(this).closest('tr').index();
	var dashboard_id = $(this).closest("tr").data('id');
	var name = $("input[name=dashboardname]").val();
	var type   = $( 'input[name=dashboardtype'+[i]+']:checked').val();
	$.ajax({
		type: "POST",
		data: {dashboard_id:dashboard_id,name:name,type:type},
		url: "<?php echo base_url(); ?>Dashboard_ajax_calls/updateListingDashboards",
		success: function(result){
			console.log(result);
			location.reload();
		}
	});
});
$(document).on('change','#inlineCheckbox1', function() {
	$(this).val('1');
	$('#inlineCheckbox2').val('0');
	$("#inlineCheckbox1").prop("checked", true);
	$("#inlineCheckbox2").prop("checked", false);
});
$(document).on('change','#inlineCheckbox2', function() {
	$(this).val('2');
	$('#inlineCheckbox1').val('0');
	$("#inlineCheckbox2").prop("checked", true);
	$("#inlineCheckbox1").prop("checked", false);
});
///hide the dashboard
$(document).on('click', '.hidebtn', function() {
	var dashboard_id = $(this).closest("tr").data('id');
	var result = confirm("This Dashboard Will not Available For You! Are You Sure to Remove?");
	if (result === true) {
		$.ajax({
			type: "POST",
			data: {dashboard_id:dashboard_id},
			url: "<?php echo base_url(); ?>Dashboard_ajax_calls/hideDashboard",
			success: function(result){
				alert(result);
				location.reload();
			}
		});
	}	
});
</script>