<!--start of page content or body-->
<div class="container bodycontainer">
    <div class="row">
        <div class="panel panel-primary">
        	<?php if($this -> session -> flashdata('message')) { ?>
                <div class="alert alert-success text-center" role="alert">
                    <strong><?php echo $this -> session -> flashdata('message'); ?></strong>
                </div>
            <?php } ?>
            <ol class="breadcrumb">
            <?php echo $this->breadcrumbs->show(); ?>
            </ol> 
            <div class="panel-heading"> List of Zero Reporting Form </div>
            <div class="panel-body">
                <form method="post" id="filter-form">
                    <div class="row">   
                        <div class="form-group">
                            <label class="col-xs-1 col-xs-offset-1 control-label lbl-setting"  for="facode" >Search:</label>
                            <div class="col-xs-3">
                                <input id="filter" name="searchParam" class="form-control form-control" type="text"/>
                            </div>
                            <label class="col-xs-1 col-xs-offset-1 control-label lbl-setting"  for = "facode" >Year-Week:</label>
                            <div class="col-xs-1" style="width: 13.79%;">
                                <select id="year" name="year" class="filter-status  form-control">
                                    <option value="0">All Years</option>
                                    <?php foreach($resultYear as $row) { ?>
                                        <option value="<?php echo $row['year']; ?>"><?php echo $row['year']; ?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                            <div class="col-xs-1" style="width: 13.79%;">
                                <select id="week" name="week" style="margin-left: -28px;" class="filter-status  form-control">
                                <option value="0">All Weeks</option>
                                <?php foreach($resultWeek as $row){ ?>
                                    <option value="<?php echo $row['week']; ?>"><?php echo $row['week']; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <br>
                <table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
                    <thead>
                        <tr>
                            <th class="text-center Heading">S#</th>
                            <th class="text-center Heading">District</th>
                            <th class="text-center Heading">Year</th>
                            <th class="text-center Heading">Week</th>
                            <th class="text-center Heading">Date From</th>
                            <th class="text-center Heading">Date To</th>
                            <?php if (($_SESSION['utype']=='DEO') || ($_SESSION['utype']=='idsrs_manager') ){?>
                                <th class="text-center Heading">
                                    <a href="<?php echo base_url(); ?>Zero-Reporting-Add" data-toggle="tooltip" title="Add New Zero Reporting Form">
                                        <button class="submit btn-success btn-sm">
                                        <i class="fa fa-plus"></i> Add New</button>
                                    </a>
                                </th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                            $i=$startpoint;
                            foreach($result as $row){
                                $i++;
                            ?>
                            <tr>
                                <td class="text-center">
                                    <input type="hidden" class="group_id" name="group_id" value="<?php echo $row['group_id']; ?>">
                                    <?php echo $i; ?>
                                </td>
            					<td class="text-center"><?php echo $row['districtname']; ?></td>
            					<td class="text-center year"><?php echo $row['year']; ?></td>
                                <td class="text-center week"><?php echo $row['week']; ?></td>
            					<td class="text-center"><?php if(($row['datefrom'])!=''){ echo date("d-M-Y",strtotime($row['datefrom']));} ?></td>
                                <td class="text-center"><?php if(($row['dateto'])!=''){ echo date("d-M-Y",strtotime($row['dateto']));} ?></td>					
                                <?php if(($_SESSION['utype']=='DEO') || ($_SESSION['utype']=='idsrs_manager')) { ?>
				                <td class="text-center">  
                                    <a href="<?php echo base_url(); ?>Zero-Reporting/View/<?php echo $row['fweek']; ?>/<?php echo $row['group_id']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="<?php echo base_url(); ?>Zero-Reporting/Edit/<?php echo $row['fweek']; ?>/<?php echo $row['group_id']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                    <?php if($max_group_id[0]['max_group_id'] == $row['group_id']) { ?>
                                        <a onclick="delete_report(this)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>
                                    <?php } ?>
                                </td>
                                <?php } ?>
                            </tr>
						<?php } ?>
                    </tbody>
                </table>
                <br>
                <div class="row">
                    <div class="col-sm-12" align="center">
                        <div id="paging">
                        <?php 
                            // displaying paginaiton.
                            echo $pagination;
                        ?> 
                        </div>
                    </div>
                </div>
            </div> <!--end of panel body-->
        </div> <!--end of panel panel-primary-->
    </div><!--end of row-->
</div><!--End of page content or body-->

<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('.footable').footable();
    });
    $('.filter-status').on('change' , function (){
    	$('#tbody').html('');
    	$('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
    	//get page number from link
    	$.ajax({
    		type: "GET",
    		data: $('#filter-form').serialize(),
    		url: "<?php echo base_url(); ?>Ajax_calls/zero_reporting_filter", 
    		dataType: "json",
    		success: function(result){
    			$('#tbody').html('');
    			if(result != null){
    				$('#tbody').html(result.tbody);
    				$('#paging').html(result.paging); 
    			}
    		}
    	});
    });

    function delete_report(rpt){
        var group_id = $(rpt).closest('tr').find('.group_id').val();
        var year = $(rpt).closest('tr').find('.year').text();
        var week = $(rpt).closest('tr').find('.week').text();
        //alert(group_id);
        if(week<10){
            var fweek = year+'-0'+week;
        }
        else{
            var fweek = year+'-'+week;
        }

        var response=confirm("Are you sure you want to delete this report?");
        if(response==true && group_id!="" && fweek!="")
        {
            window.location.href="<?php echo base_url(); ?>Investigation_forms/zero_report_delete/"+fweek+"/"+group_id;
        }
        else
        {
            //do nothing
        }    
    };
</script>