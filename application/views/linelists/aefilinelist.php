<div class="" style="font-size: 12px;">  
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading"> AEFI WEEKLY Line List of Suspected Cases</div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <table class="table table-bordered   table-striped table-hover  mytable">
                        <tr>
                            <td><label>District</label></td> 
                            <td><?php echo $districtName; ?></td>
                            <td><label>Province/Area</label></td>
                            <td><?php echo $this -> session -> provincename ?></td>
                            <td><label># of Reporting Unit</label></td>
                            <td><?php if(isset($allReportingFLCF)){ echo $allReportingFLCF; } ?></td>
                        </tr>
                        <tr>
                            <td><label># of Report Received</label></td>
                            <td><?php if(isset($ReportingCenters)){ echo $ReportingCenters; } ?></td>
                            <!--<td><label>Reporting Epidemiologic Week No:</label></td>
                            <td><?php// echo ($this->input->post('week'))?sprintf('%02d',$this->input->post('week')):''; ?></td>
                            <td><label>Year</label></td>
                            <td><?php //echo ($this->input->post('year'))?$this->input->post('year'):''; ?></td> -->
                            <td><label>Epi Week From</label></td>
                            <td><?php echo (isset($week_from))?$year.'-'.sprintf('%02d',$week_from):''; ?>
                            </td>
                            <td><label>Epi Week To</label></td>
                            <td><?php echo (isset($week_to))?$year.'-'.sprintf('%02d',$week_to):''; ?>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-bordered table-condensed table-striped table-hover mytable">
                        <thead>
                            <tr>
                                <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){ ?>
                                <th rowspan="3">Action</th>
                                <?php }?> 
                                <th rowspan="2">S #</th>
                                <th rowspan="2">Patient Name</th>
                                <th rowspan="2">Health Facility</th>
                                <th rowspan="2">Union Council</th>
                                <th rowspan="2">Tehsil/Taluka</th>
                                <th rowspan="2">Gender</th>
                                <th rowspan="2">Date of<br>birth/age</th>
                                <th rowspan="2">Date vaccine<br>given</th>
                                <th rowspan="2">Date of AEFI<br>onset</th>
                                <th rowspan="2">Suspected<br>Vaccine</th>
                                <th rowspan="3">AEFI*</th>
                                <th rowspan="2">Hospita<br>lization<br>(Yes/No)</th>
                                <th rowspan="2">Death<br>(Yes/No)</th>				
                            </tr>                        
                        </thead>
                        <tbody>
                            <?php
                                if(isset($aefi)){
                                    foreach($aefi as $key => $row){
                                        if($row['gender']=='1')
                                            $gender= 'Male';
                                        else if($row['gender']=='2')
                                            $gender= 'Female';
                                        else
                                            $gender= ''; 
                            ?>
                            <tr class="DrillDownRow">
                                <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){ ?>
                                <td>
                                    <!-- <a href="<?php //echo base_url(); ?>AFP-CIF/Edit/<?php //echo $row['facode']; ?>/<?php //echo $row['id']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a> --> 
                                    <a href="<?php echo base_url(); ?>AEFI-CIF/Edit/<?php echo $row['id']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                </td>               
                                <?php } ?> 
                                <td style="display:none;"><?php echo $row['id']; ?></td>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $row['casename']; ?></td>
                                <td><?php echo $row['facilityname']; ?></td>
                                <td><?php echo $row['unname']; ?></td>
                                <td><?php echo $row['tehsil']; ?></td>
                                <td><?php echo $gender; ?></td>
                                <td><?php echo isset($row['dob']) ? date('d-m-Y',strtotime($row['dob'])) : ''; ?></td>
                                <td><?php echo isset($row['vacc_date']) ? date('d-m-Y',strtotime($row['vacc_date'])) : ''; ?></td>
                                <td><?php echo isset($row['date_aefi_onset']) ? date('d-m-Y',strtotime($row['date_aefi_onset'])) : ''; ?></td>
                                <td><?php echo $row['vacc_name']; ?></td>
                                <td><?php echo $row['complaints']; ?></td>
                                <td><?php echo $row['mc_hospitalized']=='1' ? 'Yes' : 'No'; ; ?></td>
                                <td><?php echo $row['death']; ?></td>
                            </tr>
                            <?php } } ?> 
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-4">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td><label>Compiled by</label></td>
                                        <!--
                                        <td>
                                        <table style="width:100%;">
                                        <tr>
                                        <td> Date </td>
                                        <td><?php echo date('d-m-Y'); ?></td>
                                        </tr>
                                        </table>
                                        </td>-->
                                    </tr>
                                    <tr>
                                        <td><label>Name</label></td>
                                        <td><?php if(isset($downPortion)){ echo $downPortion[0]['name']; }?></td>
                                    </tr>
                                    <tr>
                                        <td><label>Designation</label></td>
                                        <td><?php if(isset($downPortion)){ echo $downPortion[0]['designation']; } ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4"></div>
                    </div>       
                    <div class="row">
                        <hr>
                        <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                            <!--<a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" href="#"><i class="fa fa-pencil-square-o"></i> Update </a>-->
                            <label class="text-right">Compiled Date: <?php echo date('d/m/Y'); ?></label>
                            <!--<a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>-->
                        </div>
                    </div>
                    <table class="table table-bordered table-striped" style="margin-top: 10px;">
                        <tbody>
                            <tr>
                                <td>*Reporting For district level Reporting unit will be respective reporting health facility.for Provincial level compitition Reporting unit wilbe respective reporting district </td>
                            </tr>
                            <tr>
                                <td>**Type of case means AFP Measlics.NT Pertusis Deptheria Childhood TB etc </td>
                            </tr>
                            <tr>
                                <td>***Case epid number only applicable for AFP and measics cases to be filled at district level </td>
                            </tr>
                            <tr>
                                <td>****Date of investigation Only applicable for AFP Measies and NT cases To be filled at district level from CIF </td>
                            </tr>
                            <tr>
                                <td>*****Date of specimen collection Only applicable for AFP and measles cases To  be filled at district level from CIF</td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div> <!--end of panel body-->
        </div> <!--end of panel panel-primary-->
    </div><!--end of row-->
</div><!--End of page content or body-->  
<?php if(!$this->input->post('export_excel')){ ?>
    <script type="text/javascript">
        $('.DrillDownRow').css('cursor','pointer');
        $(document).on('click',".DrillDownRow", function(){
            var ulevel = '<?php echo $_SESSION['UserLevel']; ?>';
            if(ulevel==3){
                var code = $(this).find("td:nth-child(3)").text();
            }
            else{
                var code = $(this).find("td:first-child(2)").text();
            }
    		var url = '';
    		url = "<?php echo base_url(); ?>AEFI-CIF/View/"+code;       
            var win = window.open(url,'_self');
            if(win){
                //Browser has allowed it to be opened
                win.focus();
            }
            else{
                //Broswer has blocked it
                alert('Please allow popups for this site');
            }      
        });
    </script>
<?php } ?>