<br>
<script type="text/javascript" src="<?php echo base_url(); ?>/includes/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/bootstrap-multiselect.js" type="text/javascript"></script>
<link   href="<?php echo base_url(); ?>includes/css/bootstrap-multiselect.css" type="text/css" rel="stylesheet"/>
<?php echo $listing_filters; ?>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="myLargeModalLabel" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
		    <div class="modal-content" style="height:550px; overflow:auto;">
                <div class="panel panel-primary mypanel" style="margin-top:0px;">
				  <div class="panel-heading text-center" id="reporttitle" >New Report Type</div>
                    <div class="panel-body">
    	      	    <form name="dataform" id="dataform" action="lhsdb_save.php" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
						
						<div class="row">
							<div class="col-md-2 col-md-offset-3 col-sm-3 col-sm-offset-3  cmargin5">
                            <label>Report Tittle</label>
							</div>
							<div class="col-md-3 col-sm-4">
							<input class="form-control" placeholder="Report Title" name="adv_rpt_title" id="adv_rpt_title" type="text">
                            </div>
						</div>
						<br>
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
						
						<div class="row" id="showcfi" style="display:none">
							<div class="col-md-2 col-md-offset-3 col-sm-3 col-sm-offset-3  cmargin5">
							<label>CIF</label>
							</div>
							<div class="col-md-3 col-sm-4">
							<select class="sections-drop form-control" id="cfi" name="cfi">
							    <option value="0">-- Select --</option>
							    <option value="AEFI" id="AEFI">AEFI</option>
							    <option value="AFP" id="AFP">AFP</option>
							    <option value="Measles" id="Measles">Measles</option>
							    <option value="NNT" id="NNT">NNT</option>
							    <option value="Measles" id="Measles">Others</option>
							</select>
							</div>
						</div>
						<div class="row" id="elemid">
						    <div class="col-md-2 col-md-offset-3 col-sm-3 col-sm-offset-3  cmargin5">
							<label>Data Elements</label>
							</div>
							<div class="col-md-3 col-sm-4">
							<select id="sections" name="sections" class="sections-drop  form-control" >
							<option value="0">-- Select --</option>
							    <?php foreach($allSections as $oneSec)
							    { 
									echo '<option value="'.$oneSec["secid"].'">'.$oneSec["description"].'</option>';
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
								<option value="PCV10-1">PCV10-1</option>
								<option value="PCV10-2">PCV10-2</option>
								<option value="PCV10-3">PCV10-3</option>
								<option value="IPV-1">IPV-1</option> 
								<option value="Measles-1">MR-1</option>
								<option value="Measles-2">MR-2</option>
								<!--<option value="Fully Immunized">Fully Immunized</option>-->
								<option value="IPV-2">IPV-2</option>
								<option value="TCV">TCV</option>
											
							</select>
							</div>
						</div>
						<div class="row" id="showhfcr" style="display:none">
							<div class="col-md-2 col-md-offset-3 col-sm-3 col-sm-offset-3  cmargin5">
							<label>Products</label>
							</div>
							<div class="col-md-3 col-sm-4">
							<select class="sections-drop form-control" id="hfcr" name="hfcr">
								<option value="">Select...</option>
								<option value="BCG">BCG</option>
								<option value="DIL BCG">DIL BCG</option>
								<option value="bOPV">bOPV</option>
							    <option value="Pentavalent">Pentavalent</option>
								<option value="Pneumococcal (PCV10)">Pneumococcal (PCV10)</option>
								<option value="Measles">MR</option>
								<option value="BCG">DIL Measles</option>
								<option value="DIL Measles">BCG</option>
								<option value="TT 10">TT 10</option>
								<option value="TT 20">TT 20</option>
								<option value="HBV (Birth dose)">HBV (Birth dose)</option>
								<option value="IPV">IPV</option>
								<option value="AD Syringes 0.5 ml">AD Syringes 0.5 ml</option>
								<option value="AD Syringes 0.05 ml">AD Syringes 0.05 ml</option>
								<option value="Recon. Syringes (2 ml)">Recon. Syringes (2 ml)</option>
								<option value="Recon. Syringes (5 ml)">Recon. Syringes (5 ml)</option>
								<option value="Safety Boxes">Safety Boxes</option>
							    <option value="Other">Other</option>
							</select>
							</div>
						</div>
						<div class="row" id="showdsiv" style="display:none">
							<div class="col-md-2 col-md-offset-3 col-sm-3 col-sm-offset-3  cmargin5">
							<label>Products</label>
							</div>
							<div class="col-md-3 col-sm-4">
							<select class="sections-drop form-control" id="dsiv" name="dsiv">
								<option value="">Select...</option>
								<option value="mOPV1">mOPV1</option>
								<option value="bOPV">bOPV</option>
								<option value="Measles/MR">Measles/MR</option>
								<option value="DIL Measles">DIL Measles</option>
								<option value="TT">TT</option>
								<option value="AD Syringes 0.5 ml">AD Syringes 0.5 ml</option>
								<option value="Recon. Syringes (5 ml)">Recon. Syringes (5 ml)</option>
								<option value="Safety Boxes">Safety Boxes</option>
								<option value="Other">Other</option>
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
<!----HRAdvanceDeletepopup------->
	<style>
span.tbl-td-icon{
	padding:0px 10px;
	cursor: pointer;
}
table thead {
	background: #08b063;
    	color: #fff;	
}
table thead th{
	padding:4px;
	font-weight:600;
}
.close-times{
}
</style>
	   <div class="modal fade" tabindex="-1" id="popup" role="dialog" aria-labelledby="mySmallModalLabel">
		  <div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="panel panel-primary mypanelnew">
				
                    <div class="panel-heading text-center">Advance Report
					<span class="close-times" style="position: relative;top: -10px;right: -60px;" data-dismiss="modal" id="clo"><i class="fa fa-times text-danger"></i> </span>
					</div>
                    <div class="panel-body">
    	      	    <form name="dataform" id="dataform" action="lhsdb_save.php" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onsubmit="">
                        <table id="tblreport" class="table table-bordered table-hover" style="">
                            <thead style="background: #08b063;color: #fff;">
                                <tr>
                                	<th style="padding: 4px;font-weight: 600;width: 6%;">S.no</th>
                               		<th>Report</th>
                                 	<th>Action</th>
                                </tr>    
                            </thead>
                            <tbody>
                                <?php $serial = 1;
		                        foreach($allReports as $key=>$row): ?>
								<tr>
							        <td><?php echo $serial ?></td>
									<td><?php echo $row['report_title'] ?></td>
									<td>
                                     <span class="tbl-td-icon edit"  data-dismiss="modal" data-attr="<?php echo $row['report_id']?>" style="padding: 0px 10px;cursor: pointer;
                                     " data-toggle="modal" data-target="#myLargeModalLabel"><i class="fa fa-pencil text-primary"></i></span>
                                     <span class="tbl-td-icon delete" data-dismiss="modal" data-attr="<?php echo $row['report_id']?>"><i class="fa fa-trash-o text-danger"></i></span>
									 <!--<input value = "" name= "report_id" hidden >-->
									<!--<input type="hidden" id="foo" name="report_id" value="" />-->
                                    </td>
					            <?php $serial++; ?>
								</tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
					</form>
                      <div class="row">
                       <div class="col-md-12" style="text-align: right;">
                         <button class="text-right btn btn-danger" data-dismiss="modal" id="close" style="font-weight: 600;"><i class="fa fa-times"></i>Cancel</button>
					   </div>
                      </div>
					</div>
				</div>
			</div>
		  </div>
		</div>
<!------HRAdvanceDeletepopup-------->	
	
    <script type="text/javascript">
	$(document).ready(function(){
		if((isExists('monthto') && isExists('monthfrom'))){
			$('#pre-btn').prop('disabled', true);
			$(document).on('change','.dp-my',function(){
				if(($('#monthto').val() !="" && $('#monthfrom').val() !="" && $( "#report_id" ).val()!=0)){
					$('#pre-btn').prop('disabled', false);
				}else{
					$('#pre-btn').prop('disabled', true);
				}
			});
		}
		
		//HRAdvance Report
	//	var $report_id
		 var report_id = $( "#report_id" ).val();
		if(report_id==0){
			$('#pre-btn').prop('disabled', true);
		}	
		else{
			$('#pre-btn').prop('disabled', false);
		}
		
		
		
		
		function isExists(elemId){
			if($('#'+elemId).length > 0){
				return true;
			}else{
				return false;
			}
		}
		    var dist = $("#distcode").val();
		    if(dist>0)
				$('#typewise').show();
		    else
		        $('#typewise').hide();
		$(document).on('change','#sections', function(e){
				var select = $(this).val();
			if(select== "ttri"){			
				$('#showttri').show();
			}
			if(select== 0 || select=="cri" || select=="es"){			
				$('#showttri').hide();
			}
		});
		$(document).on('change','#sections', function(e){
			var select = $(this).val();
			if(select== "cri"){			
			$('#showcri').show();
			}
			if(select== 0 || select=="ttri" || select=="es"){			
			$('#showcri').hide();
			}
		});
		$(document).on('change','#sections', function(e){
			var select = $(this).val();
			if(select== "hfcr"){			
			$('#showhfcr').show();
			}
			if(select== 0 || select=="dsiv"){			
			$('#showhfcr').hide();
			}
		});
		$(document).on('change','#sections', function(e){
			var select = $(this).val();
			if(select== "dsiv"){			
			$('#showdsiv').show();
			}
			if(select== 0 || select=="hfcr"){			
			$('#showdsiv').hide();
			}
		});
		
		//function to save advance report and its fields into db
		$(document).on('click','#advReportAddBtn', function(e){
			var reportid = $("#reportid").val();
			var tbl_select = $("#cfi").val();
			//alert(reportid);
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			var title = $("input[name=adv_rpt_title]").val();
			if(title!="")
			{
		    //getting all selected fields
			var fIds = $(".datarry .row").map(function () {
			return this.id;
			}).get().filter(Boolean);
			if(fIds!=""){
				$.ajax({
						type: "POST",
						data: {title:title,fIds:fIds,lastsgment:lastsgment,reportid:reportid,tbl_select:tbl_select},
						url: "<?php echo base_url(); ?>Ajax_calls/createReport",
					success: function(result){
						if(result.indexOf("Error")==0)
						{
						alert(result);
						}
							else
						{
						$("#report_id").html(result);
						$("input[name=adv_rpt_title]").val('');
						$("#sec_fields").val('');
						$("#col-md-8 col-md-offset-1 col-sm-8").val('');
						alert('New report added.');
						//$('#myLargeModalLabel').modal('hide');
						$('#myLargeModalLabel').hide();
						window.location.reload(); 
						}
				    }
			    });
			}
			else{
			alert("Error: Report fields must be selected");
			}
			}else{
			alert("Error: Report title cannot be null");
			}
		});
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "es"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
			if(selected == "ttri" || selected == "cri")
			{
			$('.section_fields').html('');
			}
		});
		$(document).on('change','#ttri', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
				$.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
					}
				});
		});
		$(document).on('change','#cri', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
				$.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
					}
				});
		});
		$(document).on('change','#hfcr', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
				$.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
					}
				});
		});
		//developing...
		$(document).on('change','#dsiv', function(e){
			var label = $("#sections option:selected").text();
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
				$.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					}
			    });
	    });
		
		//HRAdvance Report
		
			$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "bi"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		$(document).ready(function() { 	
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == 0){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    }); 
			}
			});
			$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "aaq"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "jd"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
			$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "ti"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
			$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "bd"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		//DSAdvanceReport
		$(document).on('change','#cfi', function(e){
			var value = $(this).val();
			if(value!='0'){
			    $.ajax({
						type: 'POST',
						url:'<?php echo base_url(); ?>Advance_Reports/get_dataelement',
						//dataType: "json",
						data:'value='+value,
					    success: function(response){
							//alert(response);
							 //console.log(response);
							 $('#elemid').show();
							 $("#sections").html(response);
			        }
		        });
			}
		    if(value == 0 ){			
			 $('#elemid').hide();
			 $('.section_fields').hide();
			}
		});  
		
		if(window.location.href ==="<?php echo base_url(); ?>Advance-Report/Filters/Disease-Surveillance-Advance-Report"){
	      //alert("abc");
          $('#showcfi').show();
		  $('#elemid').hide();
		}
		else if (window.location.href ==="<?php echo base_url(); ?>Advance-Report/Filters/Disease-Surveillance-Advance-Report#"){
		  $('#showcfi').show();
		  $('#elemid').hide();
		}
		
		//MeaslesandOthers
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "bii"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
			$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "ap"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
			$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "di"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "la"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "fu"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		//NNT
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "biin"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "apn"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "misn"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
			$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "macn"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "dpn"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "bsn"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "tmn"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "crn"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		//AFP
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "biiaf"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "apaf"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
			$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "diaf"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
			$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "ssaf"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "lraf"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "fuaf"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		//AEFI
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "biiae"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "ciae"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "irvae"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});
		
		//function to add fields for criteria of advance report
	$(document).on('click','#CriteriaAddBtn', function(e){
			var secId = $(this).data("sec");
			var totalnum = $(".datarry").find('[id^='+secId+'-]').length;
			var rows='';
			if(totalnum>0){
				
			}else{
				var secLabel = $("#sections option:selected").text();
				rows += '<div class="row"><div class="col-md-12 col-sm-12 bgrow2"><label>'+secLabel+'</label></div></div>';
			}			
			$("input[name=sec_fields]:checked").each(function (){
				var uniqueId = secId+"-"+$(this).val();
				if (document.getElementById(uniqueId)) {
					alert("Already Selected");
				}else{
					rows += '<div class="row" id="'+uniqueId+'"><div class="col-md-8 col-md-offset-1 col-sm-8">'+$(this).parent().parent().find('.sec_field_label').text()+'</div><div class="col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1"> <a style="color: black;" href="#" class="del_selected_field" data-id="'+uniqueId+'"><i class="fa fa-trash-o"> Delete</i></a></div></div>';
				}
			});
			if(totalnum>0){ 
				//section already exist, append row after last appended child of same section
				$('.datarry').find('[id^='+secId+'-]').last().append(rows);
			    $('.datarry').find('[id^='+secId+'-]').css({"margin-left": "auto", "margin-right": "auto"});		
			}else{
				//section does not exist, append row at the end of datarry class
				$('.datarry').append(rows);
			}
			$('input[name=sec_fields]').prop( "checked", false );
	});
		$(document).on('click','.del_selected_field', function(){
		    var idd = $(this).data("id"); 
			//alert(idd);
			$('.row[id='+idd+']').remove();
	    });
        /* $(document).on('click','#closeReportAddBtn', function(e){
        	//alert("xxx");
			$('#myLargeModalLabel').modal('hide');
        });  */	
		
		$(document).on('click','#closeReportAddBtn', function(e){
        	//alert("abc");
			$('.modal').hide();
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
				
				}).on('changeDate', function (selected){
						var minDate = new Date(selected.date.valueOf());
						$('#monthto').datepicker('setStartDate', minDate);
					});
	});
	    $(document).on('change','#distcode',function(){
		    var distcode = $("#distcode").val();
			if(distcode>0)
				$('#typewise').show();
			else
				$('#typewise').hide();
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
		//HRAdvance Delete Report
		$('.delete').click("#tblreport .delete",function(){
			 if (confirm("Do you want to delete this Report?")) {
                var row = $(this).closest("tr");
			    //var report_id = $(this).parent().find('td').attr('data-attr');
			    var report_id = $(this).attr('data-attr');
			    //alert(report_id);
		          $.ajax({
						type: 'POST',
						url:'<?php echo base_url(); ?>Advance_Reports/delete_report',
						dataType: "json",
						data:'report_id='+report_id,
					    success: function(response){
						//console.log(response);
						row.remove();
						window.location.reload(); 
			        }
		        });
		    }
	    });
	
	    $(function () {
           $(".delete").bind("click", function () {
            $("#report_id option:selected").remove();
           });
        })
	
	    $(document).on('click','#close', function(e){
        	//alert("abc");
			$('.modal').hide();
        });  
		$(document).on('click','#clo', function(e){
        	//alert("abc");
			$('.modal').hide();
        });  
		//End HRAdvance Delete Report
		
		//HRAdvance Edit Report
			$('.edit').click(function(){
			var report_id = $(this).attr('data-attr');
				
		          $.ajax({
						type: 'POST',
						url:'<?php echo base_url(); ?>Advance_Reports/edit_report',
						dataType: "json",
						data:'report_id='+report_id,
					    success: function(response){
							 //alert(response);
							 console.log(response);
							 //console.log(response[0].report_title);
							 //alert(response[0].report_id);
							 $("#adv_rpt_title").val(response[0].report_title);
							 //$("#adv_rpt_title").val(response[0].report_id);
			        }
		       });
	        });
	
	    //NewReportid assign
            $(document).ready(function(){
             $("#new-btn").click(function(){
              $("#rowid").empty();
		      $("#adv_rpt_title").val('');
              });
            });
		   
	
	
	        $('.edit').click(function(){
		     var report_id = $(this).attr('data-attr');
		
		          $.ajax({
						type: 'POST',
						url:'<?php echo base_url(); ?>Advance_Reports/edit_report_data',
						//dataType: "json",
						data:'report_id='+report_id,
					    success: function(response){
							//alert(response);
							//console.log(response);
							 $("#rowid").html(response);
			        }
		        });
				
		    }); 

//ajax from week,to week
	
	$(document).on('change','#from_week',function(){
		var from_week = $("#from_week :selected").val();
		if(from_week!=''){
			var year = $('#year').val();
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getEpiFromTOWeeks',
				data:'from_week='+from_week+'&year='+year,
				success: function(response){
					$('#to_week').html(response);
				}
			});
		}
	});
		$(document).on('change','#from_week',function(){
		var week_from = $(this).val();
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeksDates',
			data:'epiweek='+week_from+'&year='+year,
			success: function(response){
				var obj = JSON.parse(response);
				$('#datefrom').val(obj.startDate);
				//$('#week_to').val(obj.EndDate);
			}
		});
	}); 
	$(document).on('change','#to_week',function(){
		var week_to = $(this).val();
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeksDates',
			data:'epiweek='+week_to+'&year='+year,
			success: function(response){
				var obj = JSON.parse(response);
				//$('#week_from').val(obj.startDate);
				$('#toweek').val(obj.EndDate);
			}
		});
	}); 
	///New HFCRAdvance Report
			$(document).on('change','#sections', function(e){
			var url = location.href; 
			var lastsgment = url.substring(url.lastIndexOf('/') + 1);
			$('.section_fields').html('');
			var selected = $(this).val();
			if(selected == "epic"){
			    $.ajax({
						type: "POST",
						data: "sec="+$(this).val()+"&lastsgment="+lastsgment,
						url: "<?php echo base_url(); ?>Ajax_calls/getSecFields",
					success: function(result){
						$('.section_fields').html(result);
					
				    }
			    });
			}
		});	
		$(document).on('change','#year',function(){
		var year = $(this).val();
		$.ajax({
			type: 'POST', 
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#from_week').html(response.trim());
				$('#to_week').html(response.trim());
				$('#datefrom').val('');
				$('#toweek').val('');
				
			}
		});
	});
</script>