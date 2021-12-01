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
						<li role="presentation" class="active"><a class="fa fa-table" href="<?php echo base_url();?>dryStoreStatus"><i></i><span class="strong" style="padding-left:5px">Dry Store</span><span style="display:block;padding-left:20px">Locations</span></a></li>
						<li role="presentation" ><a class="fa fa-table" href="<?php echo base_url();?>ccmLocStatus"><i></i><span class="strong" style="padding-left:5px">Cold Store</span><span style="display:block;padding-left:20px">Locations</span></a></li>
					</ul>
                </div>
				<div class="capacity">
                    <div class="capacity-body">                        
                      
                                                                <form method="POST" name="location_status" id="location_status" action="<?php echo base_url();?>dryStoreStatus" >
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label" for="area">Store<span class="red">*</span></label>
                                            <div class="controls">
                                                
<select name="area" id="area" required class="form-control">
    <option value="" selected="selected">Select</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
</select>                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label" for="level">Row<span class="red">*</span></label>
                                            <div class="controls">
                                                
<select name="level" id="level" required class="form-control">
    <option value="" selected="selected">Select</option>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
    <option value="F">F</option>
    <option value="G">G</option>
    <option value="H">H</option>
</select>                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group pull-right">
                                                <button class="btn btn-primary" type="submit" id="showstatus" name="showstatus">Show Status</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                           
						<?php if(empty($searchResult)){}else{?>
						
                                <table style="border: none; width: 100%;">
                                                                            <tbody><tr style="border: 3px solid #d3d3d3;">
                                                                                            <td style="width:100%;height: 86px; padding: 4px; border-right: 4px solid #d3d3d3; border-left: 4px solid #d3d3d3;">
                                                                                                                <table style="border: 2px solid green; width:100%;">
                                                            <tbody>
															<?php foreach($searchResult as $key=>$value){?>
															<tr>
                                                                <Td style="background-color:green;color:white"><a target="_blank" style="background-color:green;color:white"   href="<?php echo base_url();?>stock-in-bin?id=<?php echo $value['pk_id'];?>"><?php echo $value['location_name'];?></a></td>
                                                            </tr>
                                                            <?php }?>
                                                        </tbody></table>
                                                    </td>
                                                                                    </tr>
                                                                        </tbody></table>
                           	
						<?php }?>
						 </div> 
                    
                </div>
				   </div>
        </div>
</div>		