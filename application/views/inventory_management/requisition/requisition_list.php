<?php //print_r($storetype); exit ?>
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
	    background-color: #8c22e3;
    color: #fff;
    padding: 10px;
   /*  border-radius: 50px 0px 0px 50px; */
    position: fixed;
    right: -113px;
    transition: all 0.3s;
    top: 214px;
  /*   box-shadow: 1px 1px 6px 3px #e0dede; */
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

.search-custom-hover{
top: 168px;
background: #cf3a2f;
right: -169px;
transition:0.4s all;
}
	@-moz-document url-prefix() {
		.search-custom-hover{
			right:-191px;
		}
		.search-custom-hover .fa-search {
			right: 9px !important; 
		} 
	}
.search-custom-hover .fa-search{
right:6px;
}
.custom-control-hover{
display: inline-block ;  
width: 80%;
margin-left: 10px;
height: 24px
}
.search-custom-hover:hover, .search-custom-hover:focus-within{
right:0px;
}
</style>
<section class="content">
    <div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary bt bb bl br ml10 mr10">
				<div class="panel-heading">
					<span>Requisition List</span> 
				</div>
				<div class="panel-body">
						<div class="voucherslist">
							<div class="row mt10">
								<div class="col-md-12">
									<table id="search_here" class=" container table table-bordered table-hover table-striped table-vcenter tbl-listing" style="width: 100%;">
										<thead>
											<tr>
												<th style="width:20%;"><label>Store Code</label></th>
												<th style="width:20%;"><label>Store Name</label></th>
												<th style="width:20%;"><label>Requisition Date</label></th>
												<th style="width:20%;"><label># of Items</label></th>
												<th style="width:20%"><label>Action</label><input id="refresh_checkbox"  type="checkbox" style="margin-left: 7px;"></th>
											</tr>
										</thead>
										<tbody id="ajax_data">
                                            <?php 
                                                if($allwarehouses){
                                                    foreach($allwarehouses as $key=>$singlerec){
                                                    //$recid = $singlerec["pk_id"];
                                                    //$vouchernum = $singlerec["transaction_number"]; 
                                                    ?>
                                                    <tr id="<?php echo $singlerec['code']; ?>">
                                                        <td>
                                                            <span><?php echo $singlerec["code"]; ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo $singlerec["name"]; ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo $singlerec["Record Date"]; ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo $singlerec["totalitems"]; ?></span>
                                                        </td>
                                                        <td>
                                                        <?php //if($stat != 'In Process'){ ?>
                                                            <a href="<?php //echo base_url("voucher/".$vouchernum); ?>"><span class="fa fa-eye cursor-hand"></span></a>
                                                            <a  data-code="<?php echo $singlerec['code']; ?>"; data-type="<?php echo $storetype; ?>" href="javascript:void(0)" onclick="refresh(this)"><span class="fa fa-refresh cursor-hand actionedit" style="margin-left: 7px;"></span></a>
                                                            <input class="refresh_checkbox" data-code="<?php echo $singlerec['code']; ?>"; data-type="<?php echo $storetype; ?>" name="checkbox_refresh" type="checkbox" style="margin-left: 7px;">													
                                                        </td>
                                                    </tr><?php 
                                                    }?>
                                                    <tr>
                                                        <td colspan="4">
                                                        </td>
                                                        <td style="padding: 0px 15px 0px 15px;">  
                                                            <button style="background:#008d4c;color: white !important;" id="submit_refresh" type="button" class="btn btn-primary btn-md form-control text-white" role="button"><i class="fa fa-refresh"></i> Generate Requisition </button>
                                                        <td>
                                                    </tr>
                                                <?php }else{?>
                                                    <tr>
                                                        <td colspan="5">  
                                                            <span>No Data Found</span>
                                                        <td>
                                                    </tr>
                                                <?php } ?>
										</tbody>	
									</table>
								</div>
							</div>
						</div> 
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
</section><!-- /.content -->
<script>
//$(document).ready(function(){
	$(document).on('click','#submit_refresh',function(){
        //console.log('hi');
		$('#loading_icon').removeClass('hide');
        $('#loading').text('Please Wait! It may take 4 to 5 minutes');
        $('input[name="checkbox_refresh"]:checked').each(function() {
        //console.log(this.value);
        //console.log('hi');
        var code = this.getAttribute('data-code');
		var type = this.getAttribute('data-type');
        //console.log(code);
            $.ajax({
                type: "POST",
				async: false,
                url: '<?php echo base_url("/requisition_refresh"); ?>',
                data: {"storecode":code, "storetype":type},
                dataType:'json', 
                success: function(data){
                    //$('#311140').remove();
                    //alert(data.code);
                    var row =   '';
                    var row =   '<td><span>'+data.code+'</span></td>\
                                <td><span>'+data.name+'</span></td>\
                                <td><span>'+data.RecordDate+'</span></td>\
                                <td><span>'+data.totalitems+'</span></td>\
                                <td>\
                                    <a href="#"><span class="fa fa-eye cursor-hand"></span></a>\
                                    <a  data-code="'+data.code+'"; data-type="'+data.storetype+'" href="javascript:void(0)" onclick="refresh(this)"><span class="fa fa-refresh cursor-hand actionedit" style="margin-left: 7px;"></span></a>\
                                    <input class="refresh_checkbox" data-code="'+data.code+'"; data-type="'+data.storetype+'"  name="checkbox_refresh" type="checkbox" style="margin-left: 7px;"\></td>\
                                        ';
                                $('#'+data.code).html(row);

                }
            });
        });
		$('#loading_icon').addClass('hide');
        $('#loading').text('Please Wait! It may take some time');
        $('#refresh_checkbox').prop('checked', false);
    });
    $('#refresh_checkbox').click(function () {    
        $('input:checkbox').prop('checked', this.checked);    
    });
    //$('#loading_icon').removeClass('hide');
//});
function refresh(obj){
		if(confirm("Do You realy want to refresh this?")){
			var code = obj.getAttribute('data-code');
			var type = obj.getAttribute('data-type');

            $.ajax({
            type: "POST",
            url: '<?php echo base_url("/requisition_refresh"); ?>',
            data: {"storecode":code, "storetype":type},
			dataType:'json',
            success: function(data){
                //$('#311140').remove();
                //alert(data.code);
                var row =   '';
                var row =   '<td><span>'+data.code+'</span></td>\
                            <td><span>'+data.name+'</span></td>\
                            <td><span>'+data.RecordDate+'</span></td>\
                            <td><span>'+data.totalitems+'</span></td>\
                            <td>\
                                <a href="#"><span class="fa fa-eye cursor-hand"></span></a>\
                                <a  data-code="'+data.code+'"; data-type="'+data.storetype+'" href="javascript:void(0)" onclick="refresh(this)"><span class="fa fa-refresh cursor-hand actionedit" style="margin-left: 7px;"></span></a>\
                                <input data-code="'+data.code+'"; data-type="'+data.storetype+'" type="checkbox" style="margin-left:7px;"\></td>\
                                    ';
                            $('#'+data.code).html(row);
			}
        });
		}
    }
//});
</script>