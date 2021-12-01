<!--start of page content or body-->
<div class="container bodycontainer">
	<?php 
		echo $TopInfo;
		//echo $htmlData;
		//print_r($data); exit();
		//print_r($hrdata); exit();
	?>	
</div><!--End of page content or body-->

<?php    
//print_r($moonhrtypes);exit;
//print_r($moonhrstatus);exit;

if(!empty($hrdata)) 
{
	$count = 0;
	$insidecode = '';
	$moon = array();
	$districtrow = $allitems = array_unique($moonhrtypes);//array_unique(array_column($hrdata,"post_hr_sub_type_id","post_hr_sub_type_id"));
	$totalitems = count($allitems);
	$districtrow = $defaultrow = array_fill_keys($districtrow, '');
	$returnData = ' <table class="table table-condensed table-bordered table-hover table-striped footable table-vcenter listing-report-table tbl-listing" data-filter="#filter" data-filter-text-only="true">';
	foreach($hrdata as $key => $value)
	{ 
		if($count == 0)
		{
			$returnData .= "<thead><tr><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>";
			if($totalitems>=1){ 
				//only show total row
				$allnames = array_map("get_subtype_name",$allitems);
				$basecolumns = array_keys($value);
				array_splice($basecolumns, -2);
				$returnData .= implode("</th><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>",array_map("ucwords",$basecolumns));
				$returnData .= "</th><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>";
				$returnData .= implode("</th><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>",array_map("ucwords",$allnames));
			}else{
				unset($value["post_hr_sub_type_id"]);
				$returnData .= implode("</th><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>",array_map("ucwords",array_keys($value)));
			}			
			$returnData .= "</th></tr></thead><tbody>";
		}
		$count++;
		$class="";
		if($totalitems>=1){
			if($insidecode!=$value["distcode"]){
				if($insidecode!=''){
					$returnData .= implode("</td><td style='text-align:center; border: 1px solid black;'", array_map(function($v){
						if(is_numeric($v)){
							return "class='text-center'>".$v;
						}
						return ">".$v;
					},array_values($districtrow)));
					$districtrow = $defaultrow;
					$returnData .= "</td></tr>";
				}
				$returnData .= '<tr class="DrillDownRow"><td style="text-align:center; border: 1px solid black;"';
				//$hrtype=implode(",", array_unique(array_column($hrdata,"post_hr_sub_type_id"))); 
				$returnData .= " class='text-center'>".$value["distcode"]."</td><td style='text-align:center; border: 1px solid black;' class='text-center'>".$value["district"]."</td><td style='text-align:center; border: 1px solid black;' class='text-center'";
			}
			//$districtrow[$value["item_id"]] = array_slice( $value, -1, 1, TRUE );	
				if($moonhrstatus=="Transferred" ||$moonhrstatus=="Posted"){
					$districtrow[$value["pre_hr_sub_type_id"]] = $value["count"];			
				}else{
					$districtrow[$value["post_hr_sub_type_id"]] = $value["count"];			
				}		
			$insidecode=$value["distcode"];
		}/* else{
			unset($value["post_hr_sub_type_id"]);
			$returnData .= '<tr class="DrillDownRow"><td ';
			$returnData .= implode("</td><td ", array_map(function($v){
				if(is_numeric($v)){
					return "class='text-center'>".$v;
				}
				return ">".$v;
			},array_values($value)));
			$returnData .= "</td></tr>";
		}	 */			
		foreach($value as $k => $v)
		{
			if(is_numeric($v))
			{
				$moon[$k] =  key_exists($k,$moon)?$moon[$k]+$v:$v;
			}
			else{
				$moon[$k] =  key_exists($k,$moon)?$moon[$k]:$v;
			}
		}
	}
	if($totalitems>=1){
		$returnData .= implode("</td><td style='text-align:center; border: 1px solid black;'", array_map(function($v){
			if(is_numeric($v)){
				return "class='text-center'>".$v;
			}
			return ">".$v;
		},array_values($districtrow)));
		$returnData .= "</td></tr> ";
	} 
	
	if($count == 0)
	{
		$returnData .= "<thead><tr><th> No Record Found </th></tr></thead><tbody>";
	}
	$returnData .= "</tbody></table>";
	
		//$hrtype=implode(",", array_unique(array_column($hrdata,"post_hr_sub_type_id"))); 
		//echo $hrtype; 
}
else
{
	$returnData = "<div class='alert alert-info' style='text-align:center; width:26%;border-color:#090909;margin-left:31%' role='alert'><label>Sorry! No Record Found</label></div>";
}
echo $returnData;
?>



<!--start of footer-->
<br>
<br>

<!--JS -->
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
 <!--fortooltip-->
<script type="text/javascript">
	$('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
        var code = $(this).find("td:eq(0)").text();
		var type_id = '<?php echo $hrtype=implode("_", $moonhrtypes); ?>';
		var status = '<?php echo $moonhrstatus; ?>';
		 <?php if(isset($data['tcode'])) { ?>
			var tcode='<?php echo $data['tcode']; ?>';
		<?php } else {?>
			var tcode='';
		<?php }?>
		<?php if(isset($data['uncode'])) { ?>
			var uncode='<?php echo $data['uncode']; ?>';
		<?php } else {?>
			var uncode='';
		<?php }?>
		<?php if(isset($data['facode'])) { ?>
			var facode='<?php echo $data['facode']; ?>';
		<?php } else {?>
			var facode='';
		<?php }?>
       // alert(code); exit();
		 /* if(code.toString().length == 6){
			url = "<?php echo base_url();?>System_setup/flcf_view?facode="+code;
		}  */
		if(code.toString().length == 3){
			//url =  "<?php echo base_url();?>HR_Reports/HR_Summary_Report_Detail?code="+code+"&type="+type_id+"&status=&sup_type";
			//url = "<?php echo base_url();?>HR_Reports/HR_Summary_Report_Detail/"+code+"/"+tcode+"/"+uncode+"/"+facode+"";  
			url = "<?php echo base_url();?>HR_Reports/HR_Summary_Report_Detail/"+code+"/"+type_id+"/"+status+"/"+tcode+"/"+uncode+"/"+facode+"";  
		}
		var win = window.open(url,'_blank');
		if(win){
			//Browser has allowed it to be opened
			win.focus();
		}else{
			//Broswer has blocked it
			alert('Please allow popups for this site');
		}
    });  
</script>