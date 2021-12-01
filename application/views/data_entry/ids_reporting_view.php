<div class="container bodycontainer">
<div class="row">
    <div class="panel panel-primary">
   <div class="panel-heading"> Reporting Form</div>
     <div class="panel-body">
     
	  	<table class="table table-bordered   table-striped table-hover  mytable3">
          <tbody>
        <tr>
          <td>
            <label>Province:</label>
          </td>
          <td>
            <p>Khyber Pakhtunkhwa</p>
          </td>
           <td>
            <label>District:</label>
          </td>
          <td>
            <p><?php echo $district;  ?></p>
          </td> 
          <td>
            <label>Tehsil:</label>
          </td>
          <td>
            <p><?php echo $tehsil;  ?></p>
          </td>        
        </tr>
		<tr>
        <td>
            <label>Union Council:</label>
          </td>
          <td>
            <p><?php echo $unioncouncil;  ?></p>
          </div>
          <td>
            <label>Health Facility:</label>
          </td>
          <td>
              <p><?php echo $facility;  ?></p>
          </td>
          <td>
            <label>Year:</label>
          </td>
          <td>
            <p><?php echo $idsReport -> year;  ?></p>
          </td>
         </tr>
         <tr>
	     <td>
	        <label>EPI Week No:</label>
	     </td>
	      <td>
	        <p><?php echo sprintf("%2d",$idsReport -> epi_week);  ?></p>
	      </td>
	     <td><label>Date From</label></td>
	     <td><p><?php echo date('d-M-Y',strtotime($idsReport -> date_from));  ?></p></td>
	     <td><label>Date To</label></td>
	     <td><p><?php echo date('d-M-Y',strtotime($idsReport -> date_to));  ?></p></td>
         </tr>
         </tbody>
        </table>
        
    <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th style="padding-top: 10px; padding-bottom: 10px;">Diseases Under Surveillance</th>
              <th>Cases</th>
              <th>Deaths</th>
            </tr>
          </thead>
          <tbody>
				<?php foreach($resultsec as $val){
						$k=$val['id'];
						$query_sec="select * from ids_diseases where sec_id='$k'";
						$result=$this->db->query($query_sec);
						$sec=$result->result_array();  ?>
								<tr>
								<td colspan="3" style="background: rgba(120, 120, 120, 0.16) none repeat scroll 0% 0%;color: black;"><label><?php echo $val['respiratory_diseases'] ;?></label>
							</td>
							</tr>
					<?php foreach($sec as $row){ 
						$val1= $row['disease_short_name']."_cases";
						$val2= $row['disease_short_name']."_deaths";
					?>
							<tr>
				
							  <td><label><?php echo $row['disease_name'];?></label></td>
							  <td><p><?php echo $idsReport -> $val1;  ?></p></td>
							  <td><p><?php echo $idsReport -> $val2;  ?></p></td>
							</tr>
					<?php 	}
						} ?>
					<tr>
					<td><label>Others</label><td>
					<?php  echo $idsReport->other;  ?>
					<td></td>
					</tr>		
		  </tbody>
        </table>
        <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th colspan="10" style="padding-top:10px;padding-bottom:10px;">Total Consultations from OPD Register (Sex and Age Category)</th>
            </tr>
            <tr>
              <th colspan="5">MALE</th>
              <th colspan="5">FEMALE</th>
            </tr>
            <tr>
              <th>< 1 year</th>
              <th>1-4</th>
              <th>5-14</th>
              <th>15-49</th>
              <th>50+</th>
              <th>< 1 year</th>
              <th>1-4</th>
              <th>5-14</th>
              <th>15-49</th>
              <th>50+</th>
            </tr>
          </thead>
          <tbody>
            <tr id="myTable">
               <td><p><?php echo $idsReport -> tm_less_one;  ?></p></td>
               <td><p><?php echo $idsReport -> tm_oneto_four;  ?></p></td>
               <td><p><?php echo $idsReport -> tm_five_fourteen;  ?></p></td>
               <td><p><?php echo $idsReport -> tm_fifteen_fourtynine;  ?></p></td>
               <td><p><?php echo $idsReport -> tm_fifty_plus;  ?></p></td>
              <td><p><?php echo $idsReport -> tf_less_one;  ?></p></td>
              <td><p><?php echo $idsReport -> tf_oneto_four;  ?></p></td>
               <td><p><?php echo $idsReport -> tf_five_fourteen;  ?></p></td>
              <td><p><?php echo $idsReport -> tf_fifteen_fourtynine;  ?></p></td>
              <td><p><?php echo $idsReport -> tf_fifty_plus;  ?></p></td>
            </tr>
            <tr>
              <td colspan="6" style="text-align:right;"><label>Total OPD Attendance</label>
              </td>
              <td colspan="6"><p><?php echo $idsReport -> tot_opd_attendance;  ?></p></td>
            </tr>
          </tbody>
          
        </table>
      
 <hr>
          <?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
          <div class="col-xs-4" style="margin-left: 74%;">
            <a href="<?php echo base_url(); ?>data_entry/ids_report_edit/<?php echo $idsReport->facode; ?>/<?php echo $idsReport->fweek; ?>" class="btn btn-md btn-success" type="reset"><i class="fa fa-pencil-square-o"></i> Update </a>
            <a href="<?php echo base_url(); ?>Data_entry/weekly_vpd_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
          </div>
          <?php } ?>     
      </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
 </div>
</div><!--end of container-->
