<?php //print_r($data); exit;?>
				   <input type="hidden" id="pk_id" name="pk_id" value="<?php if(isset($data[0]['pk_id'])){echo $data[0]['pk_id'];} ?>"/>
				    <input type="hidden" id="asset_id" name="asset_id" value="<?php if(isset($data[0]['asset_id'])){echo $data[0]['asset_id'];} ?>"/>
				   <input type="hidden" id="ccm_sub_asset_type_id" name="ccm_sub_asset_type_id" value="<?php if(isset($data[0]['ccm_sub_asset_type_id'])){echo $data[0]['ccm_sub_asset_type_id'];} ?>"/>
				   <input type="hidden" id="warehouse_type_id" name="warehouse_type_id" value="<?php if(isset($data[0]['warehouse_type_id'])){echo $data[0]['warehouse_type_id'];} ?>"/>
				   <input type="hidden" id="procode" name="procode" value="<?php if(isset($data[0]['procode'])){echo $data[0]['procode'];} ?>"/>
				   <input type="hidden" id="distcode" name="distcode" value="<?php if(isset($data[0]['distcode'])){echo $data[0]['distcode'];} ?>"/>
				   <input type="hidden" id="tcode" name="tcode" value="<?php if(isset($data[0]['tcode'])){echo $data[0]['tcode'];} ?>"/>
				   <input type="hidden" id="uncode" name="uncode" value="<?php if(isset($data[0]['uncode'])){echo $data[0]['uncode'];} ?>"/>
				   <input type="hidden" id="facode" name="facode" value="<?php if(isset($data[0]['facode'])){echo $data[0]['facode'];} ?>"/>
					
					<div class="row">
					  <div class="col-md-3">
							<label for="Store">Working Status<span style="color:red;">*</span></label>
					    </div>
			               <div class="col-md-7 store_hid">
							<select class="form-control text-center status" name="status"  required="">
							  <?php echo getWorkingstatus($data[0]['status']); ?>
						     </select>					
						    </div>
                    </div>							
                    <div class="row" style="margin-top:10px;">
						<div class="col-md-3">
							<label for="Store">Reasons<span style="color:red;">*</span></label>
						</div>
			               <div class="col-md-7 store_hid">
			                  <select class="form-control text-center reason" name="reasons" id="reason" required="">
							    <?php echo getReasons(); ?>
						      </select>
			               </div>
                    </div>
                    <div class="row" style="margin-top:10px;">			
			            <div class="col-md-3">
							<label for="Store">Utilizations<span style="color:red;">*</span></label>
						</div>
			              <div class="col-md-7 store_hid">
			                  <select class="form-control text-center" name="utilizations" id="case_type" required="">
							    <?php echo getUtilization(); ?>
						      </select>
			              </div>
                    </div>
					<div class="row" style="margin-top:10px;">			
			            <div class="col-md-3">
							<label for="Store">Status Date<span style="color:red;">*</span></label>
						</div>
			              <div class="col-md-7 store_hid">
			                  <input type="text" id="status_date" name="status_date" class="dpcct form-control" readonly="true" required="">
			              </div>
                    </div>
                    <div class="row" style="margin-top:10px;">			
			            <div class="col-md-3">
						  <label for="Store">Description<span style="color:red;">*</span></label>
						</div>
			             <div class="col-md-7 store_hid">
			               <textarea type="text" rows="2" cols="37" name="description" required="">

						   </textarea>
			             </div>						
					</div>
<script type="text/javascript">				
   $(function () {
						$('.dpcct').datetimepicker({
							format : 'yyyy-mm-dd hh:ii:ss',
							color: "green",
							startView : 2,
							viewDate: new Date(),
							endDate : new Date(),
							todayHighlight : true,
							todayBtn : true
						});
					$(document).on("change",".dpcct",function(e) {
						var inputdate = $('#working_since').val();
						var inputdate1 = inputdate.split(" ");
						var enterdate = inputdate1[0];
						var d= new Date();
						var month = d.getMonth()+1;
						if(month < 10){
							month = "0"+month;
						}
						var currentdate = d.getFullYear() + "-" + (month) + "-" + d.getDate();
						var currnttime = d.getHours()+ "-" + d.getMinutes() + "-" + d.getSeconds();
						var dateshoul = currentdate +" "+ currnttime;
						if(enterdate > currentdate){
							alert('SORRY! Stricted For Future Entry.');
							$('#working_since').val(dateshoul);
						}						
					})
				});               
</script>