<?php //print_r($aefi_info); exit(); ?>
<div class="container bodycontainer">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading"> Adverse Events Following Immunisation (AEFI) Report Form</div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <table class="table table-bordered table-striped table-hover mytable3">
                        <tbody>
                            <tr>
                                <td><label>Name of Case</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["casename"];} ?></td>
                                <td><label>Gender</label></td>
                                <td><?php if(isset($aefi_info)){ echo ($aefi_info["gender"]=="1")?"Male":"Female";} ?></td>
                                <td><label>Date of birth</label></td>
                                <td><?php if(isset($aefi_info)){ echo date('d-m-Y',strtotime($aefi_info["dob"]));} ?></td>
                            </tr>
                            <tr>
                                <td><label>Age<small> (in years)</small></label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["age"];} ?></td>
                                <td><label>Years</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["years"];} ?></td>
                                <td><label>Months</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["months"];} ?></td>
                            </tr>
                            <tr>
                                <td><label>Weeks</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["weeks"];} ?></td>
                                <td><label>Father's name</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["fathername"];} ?></td>
                                </td>
                                <td><label>Husband's name </label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["husbandname"];} ?></td>
                            </tr>
                            <tr>
                                <td><label>Cell Number</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["cellnumber"];} ?></td>
                                <td><label>Village</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["village"];} ?></td>
                                <td><label>Province</label></td>
                                <td><?php echo $this -> session -> provincename; ?></td>
                            </tr>
                            <tr>
                                <td><label>District</label></td>
                                <td><?php if(isset($aefi_info)){ echo get_District_Name($aefi_info["distcode"]);} ?></td>
                                <td><label>Tehsil/Taluka</label></td>
                                <td><?php if(isset($aefi_info)){ echo get_Tehsil_Name($aefi_info["tcode"]);} ?></td>
                                <td><label>UC</label></td>
                                <td><?php if(isset($aefi_info)){ echo get_UC_Name($aefi_info["uncode"]);} ?></td>
                            </tr>
                            <tr>
                                <td><label>Health Facility</label></td>
                                <td><?php if(isset($aefi_info)){ echo get_Facility_Name($aefi_info["facode"]);} ?></td>
                                <td><label>Year</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["year"];} ?></td>
                                <td><label>EPI Week No</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["week"];} ?></td>
                            </tr>	  
                            <tr>
                                <td><label>Date From</label></td>
                                <td><?php if(isset($aefi_info)){ echo date('d-M-Y',strtotime($aefi_info["datefrom"]));} ?></td>
                                <td><label>Date To</label></td>
                                <td><?php if(isset($aefi_info)){ echo date('d-M-Y',strtotime($aefi_info["dateto"]));} ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                        <thead>
                            <tr>
                                <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Clinical Information (Major complaints put tick as appropriate)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label>a) BCG Lymphadenitis</label></td>
                                <td><?php echo (isset($aefi_info) & ($aefi_info["mc_bcg"]==1))?'Yes':'No';?></td>
                                <td><label>b) Severe Local Reaction</label></td>
                                <td><?php echo (isset($aefi_info) & ($aefi_info["mc_severe"]==1))?'Yes':'No';?></td>
                                <td><label>c) Injection site abscess</label></td>
                                <td><?php echo (isset($aefi_info) & ($aefi_info["mc_abscess"]==1))?'Yes':'No';?></td>
                            </tr>
                            <tr>
                                <td><label>d) Fever</label></td>
                                <td><?php echo (isset($aefi_info) & ($aefi_info["mc_fever"]==1))?'Yes':'No';?></td>
                                <td><label>e) Rash</label></td>
                                <td><?php echo (isset($aefi_info) & ($aefi_info["mc_rash"]==1))?'Yes':'No';?></td>
                                <td><label>f) Convulsion</label></td>
                                <td><?php echo (isset($aefi_info) & ($aefi_info["mc_convulsion"]==1))?'Yes':'No';?></td>
                            </tr>
                            <tr>
                                <td><label>g) Unconsciousness</label></td>
                                <td><?php echo (isset($aefi_info) & ($aefi_info["mc_unconscious"]==1))?'Yes':'No';?></td>
                                <td><label>h) Respiratory Distress</label></td>
                                <td><?php echo (isset($aefi_info) & ($aefi_info["mc_respiratory"]==1))?'Yes':'No';?></td>
                                <td><label>i) Swelling of body or face</label></td>
                                <td><?php echo (isset($aefi_info) & ($aefi_info["mc_swelling"]==1))?'Yes':'No';?></td>
                            </tr>
                            <tr>
                                <td><label>j) Others</label></td>
                                <td>
                                    <?php echo '<p>'.((isset($aefi_info))?$aefi_info["mc_other"]:"-").'</p>';?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label>Emergency / initial treatment given<br>(in case where b,e,f,g,h or j)</label></td>
                                <td>
                                    <table style="width:100%;margin-top: 6px;">
                                        <tr>
                                            <td><?php echo (isset($aefi_info) & ($aefi_info["mc_treatment"]==1))?'Yes':'No';?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td><label>Is the case hospitalized</label></td>
                                <td>
                                    <table style="width:100%;margin-top: 6px;">
                                        <tr>
                                            <td><?php echo (isset($aefi_info) & ($aefi_info["mc_hospitalized"]==1))?'Yes':'No'; ?></td>
                                        </tr>
                                    </table>
                                </td> 
                                <td><label>If Yes, Name and address of the hospital</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["mc_hosp_address"];} ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                        <thead>
                            <tr>
                                <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">Information regarding vaccine and vaccination</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label>Date of vaccination</label></td>
                                <td><?php if(isset($aefi_info)){ echo date('d-m-Y',strtotime($aefi_info["vacc_date"]));} ?></td>
                                <td><label>Name of vaccine(s) recieved on this day</label></td>
                                <td>
                                    <?php //if(isset($aefi_info)){ echo $aefi_info["vacc_name"];} ?>
                                    <?php
                                        if($aefi_info['vacc_name']>=1 && $aefi_info['vacc_name']<=100000){
                                            echo getVaccineName($aefi_info['vacc_name']);
                                        }
                                        else{
                                            echo $aefi_info['vacc_name'];
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Name of manufacturer & Batch/Lot no. of vaccine(s)</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["vacc_manufacturer"];} ?></td>
                                <td><label>Expiry date of vaccine(s)</label></td>
                                <td><?php if(isset($aefi_info)){ echo date('d-m-Y',strtotime($aefi_info["vacc_exp"]));} ?></td> 
                            </tr>
                            <tr>
                                <td><label>Name and address of vaccination center</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["vacc_center"];} ?></td>
                                <td><label>Name & designation of person who vaccinated</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["vacc_vaccinator"];} ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                        <thead>
                            <tr>
                                <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label>Name of the reporting person</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["rep_person"]; } ?></td>
                                <td><label>Designation of the reporting person</label></td>
                                <td><?php if(isset($aefi_info)){ echo $aefi_info["rep_desg"];} ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-condensed table-striped table-hover mytable3">
                        <thead>
                            <tr>
                                <th colspan="8" style="text-align: center; padding-top: 10px; padding-bottom: 10px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label>Submission Date</label></td>
                                <td><?php if(isset($aefi_info)) { echo date('d-m-Y',strtotime($aefi_info['submitted_date'])); } ?></td>
                            </tr>
                        </tbody> 
                    </table>
                    <div class="row"> 
                        <hr>
                        <?php if(($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO')) { ?>
                        <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                            <a href="<?php echo base_url()."AEFI-CIF/Edit/".$aefi_info["id"]; ?>" class="btn btn-md btn-success" type="reset"><i class="fa fa-pencil-square-o"></i> Update </a>
                            <a class="btn btn-md btn-success" href="<?php echo base_url()."AEFI-CIF/List"; ?>" onclick="history.go(-1);" ><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                        <?php } else { ?>
                            <a class="btn btn-md btn-success" href="<?php echo base_url()."AEFI-CIF/List"; ?>" onclick="history.go(-1);"><i class="fa fa-arrow-left"></i> Back</a>
                        <?php } ?>
                    </div>      
                </form>
            </div> <!--end of panel body-->
        </div> <!--end of panel panel-primary-->
    </div><!--end of row-->
</div><!--end of body container-->
