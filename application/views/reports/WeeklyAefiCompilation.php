<!--start of page content or body kp-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> EPI 10 AEFI Weekly Compilation Form For District /Province</div>
     <div class="panel-body">
       <form class="form-horizontal">
        <table class="table table-bordered   table-striped table-hover  mytable">
          <tr>
            <td><label>District</label></td>
            <td>Name of District</td>
            <td><label>Province / Area</label></td>
            <td>Name of Area</td>
            
            <td><label>Reporting Epidemiologic Week No</label></td>
            <td>20</td>
          </tr>
          <tr>
            <td><label>Date from (Sunday)</label></td>
            <td>12-11-2016</td>
            <td><label>To (Saturday)</label></td>
            <td>12-12-2016</td>
            <td><label>No. of reporting sites/unit</label></td>
            <td>20</td>
          </tr>
          <tr>
            <td><label>No. reported</label></td>
            <td>20</td>
            <td><label>No. reported on time</label></td>
            <td>20</td>
            <td><label>No. of AEFI cases (if no, write "0")</label></td>
            <td>20</td>
          </tr>
      </table>
         




        <table class="table table-bordered table-condensed table-striped table-hover mytable">
          <thead>
            <tr>
              <th>S No</th>
              <th>UnionCouncil</th>
              <th>Tehsil/Taluka</th>
              <th>Sex</th>
              <th>Date of<br>birth/age</th>
              <th>Date vaccine given</th>
              <th>Date of AEFI onset</th>
              <th>Suspected Vaccine</th>
              <th>AEFI*</th>
              <th>Hospitalization</th>
              <th>Death</th>
            </tr>
             
          </thead>
          <tbody>
          	<?php foreach($tableResult as $key => $val){ ?>
            <tr>
              <td><?php echo $key+1; ?></td>
              <td><?php echo get_UC_Name($val['uncode']); ?></td>
              <td><?php echo get_Tehsil_Name($val['tcode']); ?></td>
              <td>Male</td>
              <td>20</td>
              <td>20</td>
              <td>20</td>
              <td>20</td>
              <td>20</td>
              <td>Yes</td>
              <td>No</td>
            </tr>
            <?php } ?>
            <tr>
              <td colspan="11">*Write any of the following severe local reactionabscess BCG lymphadenitis encephalitis/encephalopathy,<br> loss of consciousness, anaphyiaxis, high fever, convulsion, toxic-shock, syndrome, AFP, other(describe) </td>
            </tr>
          </tbody>
        </table>

        <div class="row">
          <div class="col-sm-6">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label>Prepared by</label></td>
                <td>Muhammad Khan</td>
              </tr>
              <tr>
                <td><label>Designation</label></td>
                <td>Officer</td>
              </tr>
              <tr>
                <td><label>Date</label></td>
                <td>12-12-2016</td>
              </tr>
            </tbody>
          </table>
          </div>
          <div class="col-sm-6">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label>Submitted by</label></td>
                <td>Muhammad Ali</td>
              </tr>
              <tr>
                <td><label>Designation</label></td>
                <td>Vistor</td>
              </tr>
              <tr>
                <td><label>Date</label></td>
                <td>12-12-2016</td>
              </tr>
            </tbody>
          </table>
          </div>
           
        </div>
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
                
              <a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" href="#"><i class="fa fa-pencil-square-o"></i> Update </a>
             
              <a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
        </div>
        <table class="table table-bordered table-striped" style="margin-top: 10px;">
          <tr>
            <td>*Write any of the following severe local reactionabscess BCG lymphadenitis encephalitis/encephalopathy, loss of consciousness, anaphyiaxis, high fever, convulsion, toxic-shock, syndrome, AFP, other(describe) </td>
          </tr>
        </table>
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->