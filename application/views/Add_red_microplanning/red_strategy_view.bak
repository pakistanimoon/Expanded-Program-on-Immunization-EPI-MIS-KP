<button style="float:right;padding:5px;color:white;" id="excel4" ><i class="fa fa-file-excel-o" aria-hidden="true">Excel</i></button>
<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');//print_r($data);exit;//print_r($data);exit;
?>
<!-- <div class="content-wrapper"> -->
<section class="content">			
	<div class="container">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:17px;border-color:white !important;">
					Using the RED Strategy for Problem Solving <br><span class="urdu" style="font-size:12px; font-weight:400;">حفاظتى ٹىکہ جات کے مسائل کو حل کرنے کىلئے RED حکمت عملى کا استعمال</span>
				</div>
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">Using the RED Strategy for Problem Solving Form View</div>
				<form class="form-inline" method="post" action="<?php echo base_url();?>red_microplan/Red_strategy/red_strategy_save">
				
					<div class="panel-body" style="padding-top:1px;">
						<table class="table table-bordered plan_table" >
							<thead>
								<tr>
									<th style="border-left-color:black;">RED components<br><span class="urdu">حکمت عملى کے اجزاء RED</span></th>
									<th>Problems<br><span class="urdu">مسائل</span></th>
									<th>Activities with limited resources<br><span class="urdu">محدود وسائل کے ساتھ اقدامات</span></th>
									<th style="width:18%;">Activities needing resources and assistance from district<br><span class="urdu">وہ اقدامات جن کیلئے وسائل اور ضلعى سطح سے مدد درکار ہوں</span></th>
									<th>When (date)<br><span class="urdu">کب</span></th>
									<th>Area name <br><span class="urdu">علاقے کا نام</span></th>
									<th style="border-right-color:black;">Responsible Person<br><span class="urdu"> ذمہ دار شخص کا نام</span></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$labels = array(
									"Re-establishment of outreach services <br><span class=\"urdu\">آوٹ رىچ کو بہتر بنانا</span>",
									"Supportive supervision <br><span class=\"urdu\">نگرانی برائےاصلاح</span>",
									"Community links with service delivery <br><span class=\"urdu\">حفاظتى ٹیکہ جات کیلئے لوگوں سے روابط</span>",
									"Monitoring and use of data for action <br><span class=\"urdu\">نگرانی اور حفاظتى ٹیکہ جات کے اعدادوشمارکا استعمال</span>",
									"Planning and management of resources <br><span class=\"urdu\">وسائل کی منصوبہ بندی اور ان کا استعمال</span>"
								);
								$i=1;
							//	foreach($data as $key=>$val) {
									for($index=1;$index<=count($labels);$index++) { ?>
									<tr>
										<td><?php echo $labels[$index-1]; ?></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['f4_problems_r'.$index.'_c1']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['f4_actlimitres_r'.$index.'_c2']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['f4_actneedresources_r'.$index.'_c3']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['f4_date_r'.$index.'_c4']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['f4_area_r'.$index.'_c5']; ?></p></td>
										<td><p style="margin-top: 6px;"><?php echo $data[0]['f4_person_r'.$index.'_c6']; ?></p></td>
									</tr>
								<?php }// } ?>
							</tbody>							
						</table>
						<div class="row">
							<div class="col-md-12">
								<a href="<?php echo base_url();?>red_rec_microplan/Red_strategy/red_strategy_list"><button type="button" class="form-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
								<a href="<?php echo base_url();?>red_rec_microplan/Red_strategy/red_strategy_edit/<?php echo $data[0]['facode']; ?>/<?php echo $data[0]['year']; ?>"><button type="button" class="form-btn"><i class="fa fa-pencil" aria-hidden="true"></i> Update</button></a>	
							</div>
						</div>				
					</div> <!--end of panel body-->
				</form>
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$('#excel4').on('click', function () {
			
	var techniciancode =<?php echo $data[0]['techniciancode']; ?>;
	var year =<?php echo $data[0]['year']; ?>;
		//alert(year);
		 
		 var url="<?php echo base_url(); ?>Ajax_red_rec/excel_red_strategy_view/"+techniciancode+"/"+year;
		window.open(url,"_blank");
				
	});
</script>