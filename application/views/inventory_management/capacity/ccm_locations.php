<?php 
//$nonccloctypeshtml = isset($nonccloctypes)?get_options_html($nonccloctypes,true):false;
//$ccloctypeshtml = isset($ccloctypes)?get_options_html($ccloctypes,true):false;
//$adjsttypeshtml = isset($adjsttypes)?get_options_html($adjsttypes,true):false;
?>
<style>
.capacity{ 
	/*margin-bottom: 25px;*/
	clear: both;
	border: 1px solid #77e588;
	width: 100%;
	background:inherit;
}
.itembox{
	height: 90px;
	position: inherit;
	margin-bottom: 15px;
}
.itemcontent{
	/* background-color: #578ebe; */
	background: linear-gradient(to right, #578ebe 0%,#578ebe 50%,#578ebe 50%,#578ebe 100%);
	height: inherit;
}
.redbg{
	background: linear-gradient(to right, #E00000 0%,#E00000 50%,#E00000 50%,#E00000 100%) !important;
	height: inherit;
}
.warnbg{
	background: linear-gradient(to right, #DD8521 0%,#DD8521 50%,#DD8521 50%,#DD8521 100%) !important;
	height: inherit;
}
.itemcontent .inner{
	height: inherit;
}
.capacity-body{
	padding:15px;
}
.capacity-stat {
	height: inherit;
	color:White;
	font-family:initial;
	cursor:pointer;
}
.capacity-stat .visual {
	font-size: 45px;
	padding:10px;
	opacity: 0.2;
	color: white;
    float: left;
   /*  line-height: 35px;
    width: 80px;
    height: 80px;
    display: block;
    padding-top: 10px;
    padding-left: 15px;
    margin-bottom: 10px;*/
}
.capacity-stat .details {
    position: absolute;
    padding: 15px;
    float: right;
}
.capacity-stat .details .itemtitle {
	font-size: 20px;
	float: right;
	padding-right: 15px;
	font-weight: bold;
}
.capacity-stat .details .itemdetail {
	font-size: 11px;
	float: right;
	padding-right: 10px;
}
/*green,DD8521,E00000,red*/
</style>
	<div class="container bodycontainer">
		<h3 class="page-title">Location Status</h3>
        <div class="row">
            <div class="col-md-12">
                <div style="border: 1px solid #77e588; margin-bottom: -2px;">
					<ul class="nav nav-pills">
						<li role="presentation"><a class="fa fa-table" href="<?php echo base_url();?>dryStoreStatus"><i></i><span class="strong" style="padding-left:5px">Dry Store</span><span style="display:block;padding-left:20px">Locations</span></a></li>
						<li role="presentation" class="active"><a class="fa fa-table" href="<?php echo base_url();?>ccmLocStatus"><i></i><span class="strong" style="padding-left:5px">Cold Store</span><span style="display:block;padding-left:20px">Locations</span></a></li>
					</ul>
                </div>
                <div class="capacity">
                    <div class="capacity-body">                        
                        <br/><?php 
						if(count($ccminfo)){
							foreach($ccminfo as $key=>$onebox){
								//print_r($onebox);
								if($key==0){
									echo '<div class="row"><div class="col-md-12">';
								}else if ($key%6==0){
									echo '</div></div><div class="row"><div class="col-md-12">';
								}
								$extra = '';
								if($onebox["status"]==3){
									$classtoadd = 'redbg';
								}else{
									if($onebox["stored"]>=$onebox["totcapacity"]){
										$classtoadd = 'warnbg';
									}else{
										$classtoadd = 'someused';
										if($onebox["totcapacity"]){
											$percentage = (round(($onebox["stored"]/$onebox["totcapacity"])*100,2));
										}else{
											$percentage = 0;
										}
										$extra = 'data-percent="'.$percentage.'"';
									}										
								}
								
								?>
								<div class="col-lg-2 col-md-2 itembox">
									<div class="itemcontent <?php echo $classtoadd; ?>" <?php echo $extra; ?>>
										<div class="capacity-stat" data-itemid="<?php echo $onebox["id"]; ?>">
											<div class="visual">
												<i class="fa fa-cubes"></i>
											</div>
											<div class="details">
												<div class="itemtitle">
													<?php echo $onebox["name"]; ?>
												</div>
												<div class="itemdetail">
													( <?php echo $onebox["assettype"]; ?> )
												</div>
											</div>
										</div> 
									</div>
								</div><?php
							}
							echo '</div></div>';
						}?>
                    </div>
                </div>
            </div>
        </div>
		<br/>
		<div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-2">
                <div class="btn btn-sm" style="background-color: #578ebe;">&nbsp;</div> Unused Capacity
            </div>
            <div class="col-md-2">
                <div class="btn btn-sm" style="background-color: green;">&nbsp;</div> Used Capacity
            </div>
            <div class="col-md-2">
                <div class="btn btn-sm" style="background-color: #DD8521;">&nbsp;</div> Overload
            </div>
            <div class="col-md-2">
                <div class="btn btn-sm" style="background-color: #E00000;">&nbsp;</div> Non Functional
            </div>
            <div class="col-md-2"></div>
        </div><!--end of row-->
	</div><!--end of body container-->
<script type="text/javascript">
	$(document).ready(function(){
		var issuedate=$('.dpissue').val();
		var sdate=new Date(issuedate);
		$('.dpissue').datetimepicker({
			format : 'yyyy-mm-dd hh:ii:ss',
			startView : 3,
			startDate:sdate,
			viewDate: new Date(),
			endDate : new Date(),
			todayHighlight : true,
			todayBtn : true
		});
		$(".someused").each(function(){
			var inuse = $(this).data("percent");
			$(this).closest(".itemcontent").css('background','linear-gradient(to right, green 0%,green '+inuse+'%,#578ebe '+inuse+'%,#578ebe 100%)');
		});
		$(".allchkbox").click(function(){
			$('.rowchkbox').not(this).prop('checked', this.checked);
		});
		$("#receivesavebtn").click(function(){
			var submitit = true;var totchecked = 0;
			$('.rowchkbox:checked').each(function(){
				var locval = $(this).closest("tr").find("select[name^=location]").val();
				if(locval>0){
					var dosesval = $(this).closest("tr").find("input[name^=doses]").val();
					var vialsval = $(this).closest("tr").find("input[name^=vials]").val();
					if((dosesval != "") || (vialsval != "")){
						var rsnval = $(this).closest("tr").find("select[name^=reason]").val();
						if(rsnval>0){}else{
							alert("Reason Must be selected.");submitit = false;
						}
					}
				}else{
					alert("Store in Location Must be selected.");submitit = false;
				}
				totchecked++;
			});
			if(totchecked>0 && submitit===true){
				//submit form
				$(this).closest('form').submit();
			}
		});
		$("input[name^=doses]").keyup(function(){
			var entereddoses = $(this).val();
			var dosesinvials = $(this).closest("tr").data("doses");
			var vials =  (parseInt(entereddoses,10)/parseInt(dosesinvials,10));
			var vials =  (vials>0)?vials:0;
			$(this).closest("tr").find("input[name^=vials]").val(vials);
		});
		$("input[name^=vials]").keyup(function(){
			var enteredvials = $(this).val();
			var dosesinvials = $(this).closest("tr").data("doses");
			var doses =  (parseInt(enteredvials,10) * parseInt(dosesinvials,10));
			var doses =  (doses>0)?doses:0;
			$(this).closest("tr").find("input[name^=doses]").val(doses);
		});
	});
	//click on item to see details
	$('.capacity-stat').click(function(){
	
		//alert("here");
		var ccmid=$(this).data("itemid");
		var url="<?php echo base_url();?>stock-in-bin-vaccine?ccm_id="+ccmid+"";
	window.open(url,"_blank");
	
	});
	
</script>