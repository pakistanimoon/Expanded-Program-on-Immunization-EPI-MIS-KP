<!--start of page content or body-->
<?php 
date_default_timezone_set('Asia/Karachi'); // CDT
$current_date = date('d-m-Y');  ?>	
 <div class="container bodycontainer">
<div class="row">
 <div class="panel panel-primary">
 	
   <div class="panel-heading"> <div class="panel-heading"> District Stock Issue and Receipt Voucher Form View</div></div>
     <div class="panel-body">
       
        <table class="table table-bordered   table-striped table-hover  ">
          <tr>
            <td style="text-align: left;"><label>Supply from (District)</label></td>
            <td>
            <?php if(isset($a2)){ ?>
            	<?php echo $district; ?>
			<? } ?>
              </td>
			  <td><label>Campaigns Type</label></td>
            <td><?php if(isset($a2)){ echo $campaign_type;} ?></td>
            
         </tr>
          <tr>
           <td style="text-align: left;"><label >Vaccine Type</label></td>
            <td><?php if(isset($a2)){ echo $vaccine_name->vaccine_name;} ?></td>
            <td><label style="margin-top: 7px;">Issued Date </label></td>
            <td><?php if(isset($a2)){ echo  date('d-m-Y',strtotime($a2['0']['form_date'])); } ?></td>
          </tr>
      </table>
      <div id="parent">
        <table id="fixTable"   class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th rowspan="2" colspan="1">Union Councils</th>
			  <th rowspan="2" colspan="2">Report Submitted</th>
              <th colspan="1" rowspan="2">Doses<br>per<br>vial</th>
              <th colspan="1" rowspan="2">Manufacturer</th>
              <th colspan="1" rowspan="2">Batch#</th>
              <th colspan="1" rowspan="2">Expiry Date</th>
              <th colspan="3">Issue Quantity</th>
              <th colspan="3">Receive Quantity</th>
			 
            </tr>
            <tr>              
              <th colspan="1">Vials/Nos.</th>
              <th colspan="1">Total Doses (F=AxE)</th>
              <th colspan="1">VVM Stage</th>
              <th colspan="1">Vials/Nos.</th>
              <th colspan="1">Total Doses (I=AxH)</th>
              <th colspan="1">VVM Stage</th>
            </tr>
            <tr style="background:white;color:black">
              <th></th>
			  <th style="font-weight:500;">Yes</th>
			  <th style="font-weight:500;">No</th>
              <th>A</th>
              <th>B</th>
              <th>C</th>
              <th>D</th>
              <th>E</th>
              <th>F</th>
              <th>G</th>
              <th>H</th>
              <th>I</th>
              <th>J</th>
             
            </tr>            
          </thead>
         <tbody id="myTable">
          		<?php if(isset($a2)){ 
					foreach($a2 as $key => $row){ 
				?>
				<tr>
				 <td><label><?php echo get_UC_Name($row['uncode']); ?></label></td>
				  <td class="cases"><p class="text-center"><?php echo $row['report_submitted'] == '1' ? '&#10004;' : ''; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['report_submitted'] == '0' ? '&#10007;' : ''; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['othername']!= '0' ? $row['othername'] : $row['doses_per_vial']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['manufacturer']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['batch_no']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php if(isset($row['expirydate'])){ if($row['expirydate'] != '1970-01-01'){ echo date('d-m-Y',strtotime($row['expirydate'])); }else{ echo ''; } } else{ echo ''; } ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['iq_vialsno']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['iq_totaldoses']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['iq_vvmstage']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['rq_vialsno']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['rq_totaldoses']; ?></p></td>
				  <td class="cases"><p class="text-center"><?php echo $row['rq_vvmstage']; ?></p></td>
				</tr>
				
          
           
			
         <?php    
				} 
				} 
              ?>
           
          </tbody>
        </table>
	</div>
        <div class="row">
          <div class="col-sm-6">
            <table class="table table-bordered table-striped">
        	<tr>
            <td colspan="2"><label>Issued by</label></td>
            
          	</tr>
              <tr>
                <td><label style="margin-top: 7px;">Name</label></td>
                <td><?php if(isset($a2)){ echo $a2['0']['issued_by_name']; } ?></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><?php if(isset($a2)){ echo $a2['0']['issued_by_desg']; } ?></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Warehouse Name</label></td>
                <td><?php if(isset($a2)){ echo $a2['0']['issued_by_store']; } ?></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><?php if(isset($a2)){ if($a2['0']['issued_on'] != '1969-12-31'){ echo date('d-m-Y',strtotime($a2['0']['issued_on'])); }else{ echo ''; } } else{ echo $current_date; } ?></td>
              </tr>
            </table>
          </div>
          <div class="col-sm-6">
            <table class="table table-bordered table-striped">
              <tr>
            <td colspan="2"><label>Received by</label></td>
         
          	</tr>
              <tr>
                <td><label style="margin-top: 7px;">Name</label></td>
                <td><?php if(isset($a2)){ echo $a2['0']['receive_by']; } ?></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><?php if(isset($a2)){ echo $a2['0']['received_by_desg']; } ?></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Warehouse Name/Store Name</label></td>
                <td><?php if(isset($a2)){ echo $a2['0']['received_by_store']; } ?></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><?php if(isset($a2)){ if($a2['0']['received_on'] != '1969-12-31'){ echo date('d-m-Y',strtotime($a2['0']['received_on'])); }else{ echo ''; } } else{ echo $current_date; } ?></td>
              </tr>
            </table>
          </div>
        </div>
       <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
                
              <a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" href="<?php echo base_url(); ?>District-Issue-Receipt/Edit/<?php echo $a2['0']['group_id']; ?>"><i class="fa fa-pencil-square-o"></i> Update </a>
             
              <a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
        </div>        
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div>