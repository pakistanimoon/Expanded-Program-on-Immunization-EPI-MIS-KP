<?php
	/* $currwhtype = $this->session->curr_wh_type;
	$currwhcode = $this->session->curr_wh_code;
	$batchexist = (isset($draftdata) and count($draftdata["batch"]))?true:false;
	if($batchexist && $draftdata["master"]->to_warehouse_code!=0){
		$selectedwhcode = substr($draftdata["master"]->to_warehouse_code,0,1);
		$selectedwhtype = $draftdata["master"]->to_warehouse_type_id;
	}else if($currwhtype=="2"){
		$selectedwhcode = substr($currwhcode,0,1);
		$selectedwhtype = "4";
	}else if($currwhtype=="4"){
		$selectedwhcode = substr($currwhcode,0,1);
		$selectedwhtype = "6";
	}else {
		$selectedwhcode = substr($currwhcode,0,1);
		$selectedwhtype = NULL;
	}
	//echo $selectedwhcode.'moon'.$selectedwhtype;exit;
	$provincesoptions = get_options_html($provinces,true,FALSE,$selectedwhcode); */
?>

<script src="<?php echo base_url(); ?>includes/js/mark/jquery.mark.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/mark/jquery.mark.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/mark/mark.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/mark/mark.min.js" type="text/javascript"></script>

<script>	/* function filterTable(Stxt, table) {
		 dehighlight(document.getElementById(table));
		 if (Stxt.value.length > 0)
		   highlight(Stxt.value.toLowerCase(), document.getElementById(table));
	} */
</script>
<style>
span.icon{
	float: right;
position: fixed;
right: 0px;
color: white;
background: #3c8dbc;
padding: 8px 10px;
border-top-left-radius: 20px;
border-bottom-left-radius: 20px;
z-index: 99999;
top: 158px;
transition:all 0.4s;
cursor : pointer;
}
.custom-control{
display: inline-block;
width: 0px;
position: fixed;
right: 25px;
height: 36px;
top: 161px;
border-radius: 3px;
border: 1px solid #3c8dbc;
background: #fff;
z-index: 99999;
transition:all 0.4s;
}
.custom-show{
	width:180px;
	padding-left: 10px;
	
	transition:all 0.4s;
}

.highlighted
    {
       background:Yellow;
    }

#return-to-top {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #3c8dbc;
    background: #3c8dbc);
    width: 50px;
    height: 50px;
    display: block;
    text-decoration: none;
    -webkit-border-radius: 35px;
    -moz-border-radius: 35px;
    border-radius: 35px;
    display: none;
    -webkit-transition: all 0.3s linear;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
#return-to-top i {
    color: #fff;
    margin: 0;
    position: relative;
    left: 16px;
    top: 13px;
    font-size: 19px;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
#return-to-top:hover {
    background: #008d4c;
}
#return-to-top:hover i {
    color: #fff;
    top: 5px;
}
span.markYellow {
  background: yellow;
  color: black;
}

span.markBlue {
  background: blue;
  color: white;
}

.custom-add-voucher{
	    background-color: #3c8dbc;
    color: #fff;
    padding: 10px;
    border-radius: 50px 0px 0px 50px;
    position: fixed;
    right: -113px;
    transition: all 0.3s;
    top: 214px;
    box-shadow: 1px 1px 6px 3px #e0dede;
	z-index:99;
}
.custom-add-voucher > i{
	font-size:20px;
	position:relative;
	top:2px;
}
.custom-add-voucher > span{
	margin-left:10px;
}
.custom-add-voucher:hover{
	right: -5px;
	color:#fff;
}
.custom-add-voucher:active{
	color:#fff;
}
.custom-add-voucher:visited{
	color:#fff;
}
</style>
<section class="content">
    <div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary bt bb bl br ml10 mr10">
				<div class="panel-heading">
					<!--<span>Issued Voucher List</span> <span><input type="text" class="form-control custom-control" id="stxt" onkeyup="filterTable(this,'search_here')"/> </span> <span class="icon"><i class="fa fa-search"></i></input></span>-->
					<span>Issued Voucher List</span> <span><input type="text" class="form-control custom-control custom1" id="search"/> </span> <span class="icon"><i class="fa fa-search"></i></input></span>
				</div>
				<div class="panel-body">
						<!--<div class="row">
							<div class="col-md-3 storetd <?php //echo ($batchexist)?'hide':''; ?>">
								<label>Store<span style="color:red">*</span></label>
								<select id="to_warehouse_type_id" name="to_warehouse_type_id" required="required" class="form-control">
									<?php //get_warehouse_type_option(FALSE,NULL,$selectedwhtype,false,TRUE); ?>
								</select> 
							</div>
							<div class="col-md-3 protd hide">
								<label>Province<span style="color:red">*</span></label>
								<select id="warehouse_province" required="required" class="form-control">
									<?php //echo $provincesoptions; ?>
								</select>
							</div>
							<div class="col-md-3 storeloctd storeuctd <?php //echo ($batchexist && $draftdata["master"]->to_warehouse_type_id==6)?'':'hide'; ?>">
								<label>Store UC<span style="color:red">*</span></label>
								<select id="uccode" name="uccode" class="form-control" <?php //echo ($batchexist)?'disabled="disabled"':''; ?>>
								</select>
							</div>
							<div class="col-md-3 storeloctd <?php //echo ($batchexist)?'':'hide'; ?>">
								<label>Store Location<span style="color:red">*</span></label>
								<select id="code"  name="code" required="required" class="form-control" <?php //echo ($batchexist)?'disabled="disabled"':''; ?>>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Purpose / Activity<span style="color:red">*</span></label>
								<select id="activity" name="activity" required="required" class="form-control" <?php //echo ($batchexist)?'disabled="disabled"':''; ?>>
									<?php //get_purposes(FALSE,(($batchexist)?$draftdata["master"]->stakeholder_activity_id:NULL)); ?>
								</select>
							</div>
							<div class="col-md-3">
								<label>Issuance Date<span style="color:red">*</span></label>
								<input class="form-control dpwt" name="trans_date_time"  id="trans_date_time" type="text" <?php //echo ($batchexist)?'disabled="disabled" value="'.$draftdata["master"]->transaction_date.'"':' value="'.date("Y-m-d H:i:s").'"'; ?> readonly="readonly">
							</div>
							<div class="col-md-3">
								<label>Reference / Issued By</label>
								<input class="form-control" name="trans_ref" id="trans_ref" type="text">
							</div>
							<div class="col-md-3" style="text-align: right;">
								<label>&nbsp;<span style="color:red">&nbsp;</span></label>
								<button style="background:#008d4c;" type="button" id="additemsbtn" class="btn btn-primary btn-md form-control" role="button"><i class="fa fa-arrow-down "></i> Add Voucher Items </button>
							</div>
						</div>-->
						<div class="row">
							<div style="text-align: right;" class="col-md-12">
								<?php 
								if($this -> session -> flashdata('message')){ ?>
									<label class="text-center pull-left" style="padding-top: 9px;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></label> <?php 
								} ?>
								<!--<a href="<?php echo base_url("invnissue"); ?>" style="background:#008d4c;" class="btn btn-primary btn-md pull-right"><i class="fa fa-arrow-right"></i> Add New Voucher </a>-->
								<a href="<?php echo base_url("invnissue"); ?>" class="custom-add-voucher">
								<i class="fas fa-plus"></i>
									<span>Add new Voucher</span>
								</a>
							</div>
						</div>
						<div class="voucherslist">
							<div class="row mt10">
								<div class="col-md-12">
									<table id="search_here" class=" container table table-bordered table-hover table-striped table-vcenter tbl-listing">
										<thead>
											<tr>
												<th style="width:15%;"><label>Transaction Date</label></th>
												<th style="width:10%;"><label>Voucher Number</label></th>
												<th><label>Issued to</label></th>
												<th style="width:10%;"><label>Activity</label></th>
												<th style="width:6%;"><label>Batches in Voucher</label></th>
												<th style="width:7%;"><label>created By</label></th>
												<th style="width:12%;"><label>created On</label></th>
												<th style="width:10%"><label>Voucher Status</label></th>
												<th style="width:3%"><label>Action</label></th>
											</tr>
										</thead>
										<tbody id="ajax_data">
											<?php foreach($issuedvouchers as $key=>$singlerec){
												$recid = $singlerec["pk_id"];
												$vouchernum = $singlerec["transaction_number"]; 
												?>
												<tr>
													<td>
														<span><?php echo $singlerec["transaction_date"]; ?></span>
													</td>
													<td>
														<span><?php echo $vouchernum; ?></span>
													</td>
													<td>
														<span class="pull-left"><?php echo $singlerec["store"]; ?></span>
													</td>
													<td>
														<span><?php echo $singlerec["activity"]; ?></span>
													</td>
													<td>
														<span><?php echo $singlerec["transaction_counter"]; ?></span>
													</td>
													<td>
														<span><?php echo $singlerec["created_by"]; ?></span>
													</td>
													<td>
														<span><?php echo $singlerec["created_date"]; ?></span>
													</td>
													<td>
														<span><?php echo $stat = $singlerec["voucherstat"]; ?></span>
													</td>
													<td>
													<?php if($stat != 'In Process'){ ?>
														<a href="<?php echo base_url("voucher/".$vouchernum); ?>" target="_blank"><span class="fa fa-print cursor-hand pull-left" style="cursor:pointer"></span></a>
													<?php }?>	
														<?php if($stat != 'Received' && $stat != 'In Process'){ ?>
															<span data-id="<?php echo $singlerec["pk_id"]; ?>" class="fa fa-pencil cursor-hand actionedit pull-right" style="cursor:pointer"></span>
														<?php } ?>														
													</td>
												</tr><?php 
											}?>
										</tbody>	
									</table>
									<div id="button" class="container" style="text-align: center" onclick="loadmore();" value="loadmore"><button style="background:#008d4c;" class="btn btn-primary btn-md">Load more..</button></div>
									<input type="hidden" name="limit" id="limit" value="50"/>
									<input type="hidden" name="offset" id="offset" value="50"/>
									<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
								</div>
							</div>
						</div> 
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
</section><!-- /.content -->
<script>
$(document).ready(function(){
	$(document).on('click','.actionedit',function(){
		if(confirm("Do You realy want to edit this?")){
			var masterId = $(this).data("id");
			window.location.href = '<?php echo base_url("editinvnIssue"); ?>'+'/'+masterId;
		}
	});
	$('#search').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        $([document.documentElement, document.body]).animate({
        scrollTop: $(".markYellow").offset().top
    }, 'speed');
    }
}); 

	
	//Filter
$(function() {

  $("#search").on("keyup", function() {
    var keyword = $(this).val(),
      options = {
        "element": "span",
        "className": "markYellow",
        "separateWordSearch": false,
		"noMatch": function(){document.getElementById("search").style.backgroundColor = "#FBAEC0";},
		"each": function(){document.getElementById("search").style.backgroundColor = "";},
      },
      $ctx = $("#search_here tbody tr");
    $ctx.unmark({
      done: function() {
        $ctx.mark(keyword, options);
      }
    });
  });

});
});


	//Hide load more button
	var total_rows = "<?php echo $issuedvouchers[0]["full_count"]; ?>";
	$('#search_here').on('update', function(){
		var rowCount = $('#search_here>tbody >tr').length;
		if(rowCount == total_rows)
		{
			$("#button").hide();
		}
	});
	var total_rows = "<?php echo $issuedvouchers[0]["full_count"]; ?>";
	var previousScroll = 0;
		$(window).scroll(function() {
		   if($(window).scrollTop() + $(window).height() > $(document).height() - 50) 
		{
			var currentScroll = $(this).scrollTop();
			if (currentScroll > previousScroll)
			{
				var rowCount = $('#search_here>tbody >tr').length;
				if(rowCount < total_rows)
				{
				loadmore();
				}	 
			}
		   
		}
		   previousScroll = currentScroll;
		});
	
	//Loadmore 50 Records
	var page = 2;
	function loadmore()
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>inventory/Provincial/stock_issue",
			data:{
				ajax: true,
				page:page,
				offset :$('#offset').val(),
				limit :$('#limit').val()
			},
			datatype:"json", 
			success :function(data){
				$("#ajax_data").append(data);
				$("#search_here").trigger('update');
			}
		});
		page++;
	};
	
	
//scroll to top
var btn = $('#return-to-top');

$(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() > 1000) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});
	
</script>
<script>
$(document).ready(function(){
  $(".icon").click(function(){
    $(".custom1").toggleClass("custom-show");
	 document.getElementById("search").style.backgroundColor = "";
	 $(".custom-show").focus();
	 $( "#search" ).val('');
	 $ctx = $("#search_here tbody tr");
     $ctx.unmark();
  });
});
</script>