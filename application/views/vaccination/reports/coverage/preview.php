<?php 
if($TopInfo!=''){
    echo $TopInfo;
}
//echo getReportTable($result);
$this->load->view("vaccination/reports/stock/tabledata",["tabledata"=>$result]);  

  ?>
<?php if(!$this->input->post('export_excel'))
        { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
	var report_indicator= "<?php echo (isset($data['report_indicator']))?$data['report_indicator']:''; ?>";
	var report_type= "<?php echo (isset($data['report_type']))?$data['report_type']:''; ?>";
	$('.DrillDownRow').css('cursor','pointer');//do it later and ll change as clickedReport
	$(document).ready(function(){
		$("#stockouttable tbody tr td").each(function(i){
			var datainsidecell = $(this).text();
			if(datainsidecell=="0"){
				if(report_type==1 && report_indicator==1 ){
					$(this).css("background","Green");
				}else{
					$(this).css("background","Red");
				}
			}
			if(datainsidecell==""){
				if(report_type==1 && report_indicator==1 ){
					$(this).css("background","Grey");
				}else{
					$(this).css("background","Grey");
				}
			}
		});
		if(report_indicator==1){
			//to compare required and available stock
			$("#stockouttable tbody tr").each(function(row){
				var prevcellval = "";
				$(this).find("td").each(function(cell){
					if(cell !=0 && cell!=1){
						var datainsidecell = parseInt($(this).text());
						if(cell%2 == 1 && prevcellval!==0){
							if(datainsidecell!=""){
								if(report_type==1 && report_indicator==1 ){
									//$(this).css("background","Green");
								}else{
									if(prevcellval < datainsidecell ){
										$("#stockouttable tbody tr:nth-child("+(row+1)+") td:nth-child("+(cell)+")").css("background","Orange");
										//$(this).css("background","Blue");
									}
								}
							}else{
								prevcellval = "";
							}
						}
						prevcellval = datainsidecell;
					}
				});
			});
		}
	});
	$(document).on('click',".DrillDownRow", function(){
        var code = $(this).find("td:first-child").text();
		var codeLength=code.toString().length;
		//var report_indicator= "<?php echo (isset($data['report_indicator']))?$data['report_indicator']:''; ?>";
		var fmonth= "<?php echo (isset($data['fmonth']))?$data['fmonth']:NULL; ?>";
		if(codeLength == 3)
        {
			url = "<?php echo base_url();?>vaccination/reports/stockout/preview";
        }
		if(codeLength == 6)
        {
			url = "<?php echo base_url();?>vaccination/view/"+fmonth+"/"+code;
        }
		$(
			'<form method="post" action="'+url+'" target="_blank">'+
				'<input type="hidden" name="moon" value="formposted">'+
				'<input type="hidden" name="distcode" value="'+code+'">'+
				'<input type="hidden" name="fmonth" value="'+fmonth+'">'+
				'<input type="hidden" name="report_indicator" value="'+report_indicator+'">'+
				'<input type="hidden" name="report_type" value="2">'+
				'<input type="hidden" name="vaccines" value="<?php echo (isset($data['vaccines']) && $data['vaccines']!="")?implode(',',$data['vaccines']):''; ?>">'+
			'</form>'
		).appendTo('body').submit().remove();
    });
 </script>
     <?php } ?>