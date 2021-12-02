<!--start of page content or body-->
<?php 
date_default_timezone_set('Asia/Karachi'); // CDT
$current_date = date('d-m-Y');?>	
 <div class="container bodycontainer">
<div class="row">
 <div class="panel panel-primary">
 	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
   <div class="panel-heading"><?php if(isset($formB_Result)){?> Update District Stock Issue and Receipt Voucher Form<?php }else{ ?> Add District Stock Issue and Receipt Voucher Form<?php } ?></div>
     <div class="panel-body">
       <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>data_entry/form_A2_Save">
       	<?php if(isset($formB_Result)){ 
		?>
       		<input type="hidden" name="edit" id="edit" value="edit" />
       		<input type="hidden" name="id" id="id" value="<?php echo $formB_Result['0']['id']; ?>" />
       	<?php } ?>
        <table class="table table-bordered   table-striped table-hover  ">
          <tr>
            <td style="text-align: center;"><label>Supply from (District)</label></td>
            <td>
            <?php if(isset($formB_Result)){ ?>
            	<?php echo $district; ?>
			<? } ?>
              </td>
            <td style="text-align: center;"><label>Issued To (Facility)</label></td>
            <td>
            <?php if(isset($formB_Result)){ ?>
            	<?php echo $facility; ?>
			<? } ?>
              </td>
         </tr>
          <tr>
            <td style="text-align: center;"><label style="margin-top: 7px;">Campaign Type</label></td>
            <td><?php if(isset($formB_Result)){ echo $formB_Result['0']['campaign_type']; } ?></td>
            <td style="text-align: center;"><label style="margin-top: 7px;">Issued Date </label></td>
            <td><?php if(isset($formB_Result)){ echo  date('d-m-Y',strtotime($formB_Result['0']['form_date'])); } ?></td>
          </tr>
      </table>
        <table class="table table-bordered table-condensed table-striped table-hover mytable" id="myTable">
          <thead>
            <tr>
              <th rowspan="2">Products</th>
              <th colspan="1" rowspan="2">Doses per vial</th>
              <th colspan="1" rowspan="2">Manufacturer</th>
              <th colspan="1" rowspan="2">Batch#</th>
              <th colspan="1" rowspan="2">Expiry Date</th>
              <th colspan="3">Issue Quantity</th>
              <th colspan="3">Receive Quantity</th>
			
            </tr>
            <tr>              
              <th colspan="1">Vials/Nos.</th>
              <th colspan="1">Total Doses (G=AxF)</th>
              <th colspan="1">VVM Stage</th>
              <th colspan="1">Vials/Nos.</th>
              <th colspan="1">Total Doses (J=AxI)</th>
              <th colspan="1">VVM Stage</th>
            </tr>
            <tr style="background:white;color:black">
              <td></td>
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
          <tbody>
          	<?php $i=1; 
			$temp_val='';
			$i='0';$k=0;
			foreach($properOrderedArray  as $key => $vacc) {
				$m=0;
				if(count($vacc) > 0){
					for($m ;$m < count($vacc); $m++){
					?> 
					<tr>
					   <td style="text-align: center;padding-top: 11px;"><?php if(isset($key)){ echo $key; }  ?></td>
					  <?php if($key == 'Other' && $sorted_array[$k]['doses_per_vial'] == ''){ ?>
					 <td style="text-align: center;padding-top: 11px;"><?php if(isset($key)){ echo $key; }   ?></td>
					  <?php } ?>
					  <?php if($key != 'Other' && $sorted_array[$k]['doses_per_vial'] == ''){ ?>
					  <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>	
					  <?php }if($sorted_array[$k]['doses_per_vial'] != ''){ ?>
					  <td style="text-align: center;padding-top: 11px;"><?php echo $sorted_array[$k]['doses_per_vial']; ?></td>
					  <?php } 
					  ?>
					 <input class="form-control numberclass" name="column_id[]" value="<?php  if(isset($vacc[$m]['id'])){ echo $vacc[$m]['id']; } ?>" type="hidden">
					  <input class="form-control numberclass" name="vaccine_id[]" value="<?php  if(isset($vacc[$m]['vaccine_id'])){ echo $vacc[$m]['vaccine_id']; } ?>" type="hidden">
					  <td><?php if(isset($vacc[$m]['manufacturer'])){ echo $vacc[$m]['manufacturer']; } ?></td>
					  <td><?php if(isset($vacc[$m]['batch_no'])){ echo $vacc[$m]['batch_no']; } ?></td>
					  <td><?php if(isset($vacc[$m]['expirydate'])){ echo date('d-m-Y', strtotime($vacc[$m]['expirydate'])); } ?></td>
					  <td class="t-detail-row"><?php if(isset($vacc[$m]['iq_vialsno'])){ echo $vacc[$m]['iq_vialsno']; } ?></td>
					  <?php if($sorted_array[$k] == ''){ ?>
					  <td><?php if(isset($vacc[$m]['iq_totaldoses'])){ echo $vacc[$m]['iq_totaldoses']; } ?>"</td>
					  <td><?php if(isset($vacc[$m]['iq_vvmstage'])){ echo $vacc[$m]['iq_vvmstage']; } ?></td>
					  <?php }else{ ?>
					  <td><?php if(isset($vacc[$m]['iq_totaldoses'])){ echo $vacc[$m]['iq_totaldoses']; } ?></td>
					  <td>
						 <?php if(isset($vacc[$m]['iq_vvmstage']) ){ echo $vacc[$m]['iq_vvmstage']; } ?> </td>	
					  <?php } ?>
					  <td class="t-row"><?php if(isset($vacc[$m]['rq_vialsno'])){ echo $vacc[$m]['rq_vialsno']; } ?></td>
					  <?php if($sorted_array[$k] == ''){ ?>
					  <td><?php if(isset($vacc[$m]['rq_totaldoses'])){ echo $vacc[$m]['rq_totaldoses']; } ?></td>
					  <td><?php if(isset($vacc[$m]['rq_vvmstage'])){ echo $vacc[$m]['rq_vvmstage']; } ?></td>
					
					  <?php }else{ ?>
					  <td><?php if(isset($vacc[$m]['rq_totaldoses'])){ echo $vacc[$m]['rq_totaldoses']; } ?></td>
					  <td><?php if(isset($vacc[$m]['rq_vvmstage'])){ echo $vacc[$m]['rq_vvmstage']; } ?></td>

					  <?php 
					  } ?>  
					</tr>
				<?php $i++;; 
				}
			}else{ ?>
				<tr>
              <td style="text-align: center;padding-top: 11px;"><?php echo $key; ?></td>
              <?php if($key == 'Other' &&  $sorted_array[$k]['doses_per_vial'] == ''){ ?>
              <td></td>
              <?php } ?>
              <?php if($key != 'Other' &&  $sorted_array[$k]['doses_per_vial'] == ''){ ?>
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>	
              <?php }if( $sorted_array[$k]['doses_per_vial'] != ''){ ?>
              <td style="text-align: center;padding-top: 11px;"><?php echo $sorted_array[$k]['doses_per_vial']; ?></td>
              <?php } 
			  ?>
			  <input class="form-control numberclass" name="vaccine_id[]" value="<?php echo $sorted_array[$k]['id']; ?>" type="hidden">
			   <input class="form-control numberclass" name="column_id[]" value="" type="hidden">
              <td>
			  </td>
              <td></td>
              <td></td>
              <td></td>
              <td class="t-detail-row"></td>
              <?php if($sorted_array[$k]['doses_per_vial'] == ''){ ?>
              <td></td>
              <td>
			
			  </td>
              <?php }else{ ?>
              <td></td>
              <td>
			  </td>	
              <?php } ?>
              <td class="t-row"></td>
              <?php if($sorted_array[$k]['doses_per_vial'] == ''){ ?>
              <td></td>
              <td></td>
			 
              <?php }else{ ?>
              <td></td>
              <td>
			</td>
			
              <?php } ?>  
            </tr>
			<?php 
			}
			$k++;
			}
		
					?>
          </tbody>
        </table>
        <div class="row">
          <div class="col-sm-6">
            <table class="table table-bordered table-striped">
        	<tr>
            <td colspan="2"><label>Issued by</label></td>
            <!--<td><?php if(isset($a)){ echo $a -> issued_by_name;} ?></td> -->
          	</tr>
              <tr>
                <td><label style="margin-top: 7px;">Name</label></td>
                <td><?php if(isset($formB_Result)){ echo $formB_Result['0']['issued_by_name']; } ?></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><?php if(isset($formB_Result)){ echo $formB_Result['0']['issued_by_desg']; } ?></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Warehouse Name</label></td>
                <td><?php if(isset($formB_Result)){ echo $formB_Result['0']['issued_by_store']; } ?></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><?php if(isset($formB_Result)){ if($formB_Result['0']['issued_on'] != '1969-12-31'){ echo date('d-m-Y',strtotime($formB_Result['0']['issued_on'])); }else{ echo ''; } } else{ echo $current_date; } ?></td>
              </tr>
            </table>
          </div>
          <div class="col-sm-6">
            <table class="table table-bordered table-striped">
              <tr>
            <td colspan="2"><label>Received by</label></td>
            <!--<td><?php if(isset($a)){ echo $a -> issued_by_name;} ?></td> -->
          	</tr>
              <tr>
                <td><label style="margin-top: 7px;">Name</label></td>
                <td><?php if(isset($formB_Result)){ echo $formB_Result['0']['receive_by']; } ?></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><?php if(isset($formB_Result)){ echo $formB_Result['0']['received_by_desg']; } ?></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Warehouse Name/Store Name</label></td>
                <td><?php if(isset($formB_Result)){ echo $formB_Result['0']['received_by_store']; } ?></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><?php if(isset($formB_Result)){ if($formB_Result['0']['received_on'] != '1969-12-31'){ echo date('d-m-Y',strtotime($formB_Result['0']['received_on'])); }else{ echo ''; } } else{ echo $current_date; } ?></td>
              </tr>
            </table>
          </div>
        </div>
       <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
                
              <a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" href="<?php echo base_url(); ?>District-Issue-Receipt/Edit/<?php echo $formB_Result['0']['distcode']; ?>/<?php echo $formB_Result['0']['id']; ?>"><i class="fa fa-pencil-square-o"></i> Update </a>
             
              <a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
        </div>        
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div>