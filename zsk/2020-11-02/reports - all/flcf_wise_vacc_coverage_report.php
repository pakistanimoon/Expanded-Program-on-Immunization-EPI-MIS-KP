<!--start of page content or body-->
 <div class="container bodycontainer">
	<div class="row">
		
		<?php echo $data['TopInfo']; ?>
     <table  class="table tableuc table-condensed footable table-vcenter tbl-consolidated-uc row-border  order-column" data-filter="#filter" data-filter-text-only="true">
        <thead>
			<tr style="background-color: #15681E;color: #FFF;">
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" class="thuc col">S.No</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" class="thuc col"><?php if($distcode > 0){echo "FLCF Code";}else{echo "Distcode";} ?></th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" class="thuc col"><?php if($distcode > 0){echo "Name of FLCF";}else{echo "District";} ?></th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" class="thuc col"><?php if($distcode > 0){echo "Name of UC";}else{echo "UCs";} ?></th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3" class="thuc col">Target</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" class="thuc col">BCG</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" class="thuc col">%</th>-->
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" class="thuc col">Hep B</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" class="thuc col">%</th>-->
				
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4" class="thuc col">OPV</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3" class="thuc col">Pentavalent</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3" class="thuc col">PVC 10</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" class="thuc col">IPV</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" class="thuc col">%</th>-->
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2" class="thuc col">Measles</th>
			  
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="5" class="thuc col">TT PL</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="5" class="thuc col">CBAs</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3" class="thuc col">Drop Outs</th>


			</tr>
			<tr>

				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">BCG/OPVO</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">Children</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">Women</th>
			
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">0</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">I</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->
				 <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">II</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->
				 <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">III</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->

				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">I</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->
				 <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">II</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->
				 <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">III</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->

				 <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">I</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->
				 <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">II</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->
				 <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">III</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->

				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">I</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">II</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->

				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">I</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->
				 <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">II</th>
				<!--<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">%</th>-->
				 <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">III</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">IV</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">V</th>

				 <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">II</th>
				 <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">III</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">IV</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">V</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">BCG-MI</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">PI-PIII</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="thuc col">TTI-TTII</th>
			</tr>
		</thead>
		<tbody id="tbody tablebody">  
			<?php
			$count = 1;
			unset($data['TopInfo']);
			unset($data['exportIcons']);
			foreach($data as $val)
			{
				echo "<tr class=\"Coverage\"><td style='text-align:center; border: 1px solid black;' class=\"tduc\">".$count."</td>
				<td style='text-align:center; border: 1px solid black;' class=\"tduc\">";
				//print_r($val);
				echo implode("</td><td style='text-align:center; border: 1px solid black;' class=\"tduc\">",$val);
				/* $criNames   = array("total_bcg","total_hepb","total_opv0","total_opv1","total_opv2","total_opv3","total_pentavalent1","total_pentavalent2","total_pentavalent3","total_pcv10_1","total_pcv10_2","total_pcv10_3","total_ipv","total_measles1","total_measles2");
				$ttNames 	= array("Total_TTPL1","Total_TTPL2","Total_TTPL3","Total_TTPL4","Total_TTPL5","Total_TTNonPL1","Total_TTNonPL2","Total_TTNonPL3","Total_TTNonPL4","Total_TTNonPL5");
				echo "<tr><td class=\"tduc\">".$count."</td>";
				foreach($val as $key => $oneCol)
				{
					echo '<td class="tduc">'.$oneCol.'</td>';
					if(in_array($key,$criNames))
					{
						$total = ($val["totalimmun"]>0)?$val["totalimmun"]:1;
						echo '<td class="tduc">'.round((($oneCol*100)/$total),2).'</td>';
					}
				}
				echo "</tr>"; */
				echo "</td></tr>";
				$count++;
			}
			?>
        </tbody>
    </table>



  </div><!--end of row-->
  </div><!--End of page content or body-->


<!--start of footer-->
<br>
<br>

<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/bootstrap-3.1.1.min.js"></script>
 <!--fortooltip-->
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    $('.Coverage').css('cursor','pointer');
});

    $('.Coverage').on('click', function(){
		var code = $(this).find("td:nth-child(2)").text();
		//console.log(code);
	    var distCode = 0;
	    var facode = 0;
	    var url = '';
	     <?php if($_REQUEST['report_year'] != '') { ?>
          	var year='<?php echo $_REQUEST['report_year']; ?>';
          <?php }else{ ?>
          	var year='<?php echo $_GET['report_year']; ?>';
          	<?php } ?>
	    if(code.toString().length == 6){
	    	facode = code;
	    	url = "<?php echo base_url();?>System_setup/flcf_view?facode="+facode;
	    }
	     
	    if(code.toString().length == 3){
	    	url = "<?php echo base_url();?>Reports/flcf_wise_vacc_coverage?distcode="+code+"&report_year="+year;
	    }
		var win = window.open(url,'_self');
	    if(win){
	        //Browser has allowed it to be opened
	        win.focus();
	    }else{
	        //Broswer has blocked it
	        alert('Please allow popups for this site');
	    }
	});


//start of script for highlight whole tr and td
/* function firefoxFix() {
    if ( /firefox/.test( window.navigator.userAgent.toLowerCase() ) ) {
        var tds = document.getElementsByTagName( 'td' ),
            ths = document.getElementsByTagName( 'th' );
        for( var index = 0; index < tds.length; index++ ) {
            tds[index].innerHTML = '<div class="ff-fix">' + tds[index].innerHTML + '</div>';                     
        };
        for( var index = 0; index < ths.length; index++ ) {
            ths[index].innerHTML = 
                  '<div class="' + ths[index].className + '">' 
                + ths[index].innerHTML 
                + '</div>';                     
            ths[index].className = '';
        };
        var style = '<style>'
            + 'td, th { padding: 0 !important; }' 
            + 'td:hover::before, td:hover::after { background-color: transparent !important; }'
            + '</style>';
        document.head.insertAdjacentHTML( 'beforeEnd', style );
    };
};

firefoxFix(); */
//end of script for highlight whole tr and td
</script>
