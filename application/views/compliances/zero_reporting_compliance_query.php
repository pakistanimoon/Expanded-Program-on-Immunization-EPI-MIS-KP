

<!--start of page content or body-->
 <div class="container bodycontainer">
		<?php 
			echo $TopInfo;
			echo $tableData;
		?>			
  </div><!--End of page content or body-->
	<div id="query">
	<div>
<!--start of footer-->
<br>
<br>

<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
 <!--fortooltip-->
<script type="text/javascript">
	$(document).ready(function(){
	<?php if(!$this->session->District){ ?>
		$("#fixTable").tableHeadFixer({"left" : 2});
	<?php }else{ ?>
		$("#fixTable").tableHeadFixer({"left" : 3});
	<?php } ?>
		
		$('.clickedReport').css('cursor','pointer');
		$('.mrClicked').css('cursor','pointer');
		$('.Compliance').css('cursor','pointer');
		
		$(document).on('click','.clickedReport', function(){
			var code = $(this).data('value');
			
			<?php if(isset($data['year'])) { ?>
				var year='<?php echo $data['year']; ?>';
			<?php }else{ ?>
				var year='<?php echo date('Y'); ?>';
			<?php } ?>	
				
			if(code.toString().length == 3){
				url = "<?php echo base_url();?>Compliances/Zero_Compliance/"+code+"/"+year;
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
		var cnt = 1;
		$(document).ajaxStop(function(){
			if(cnt == 1){
				console.log(cnt);
				var data = $("#parent").html();
				var xhr = $.ajax({
					type: "POST",
					data: "ajax=true&export_data=" + data,
					url: "<?php echo base_url(); ?>Compliances/export_excel",
					success: function(result){
						cnt++;
						$("#export-form").prop('enctype', "multipart/form-data");
						$("#export-form").prop('action', "Export");
						$("#export-form").css('display', 'block');
					}
				});
			}
		})
		//to get data from server
		var districtData = '<?php echo $district_data; ?>';
		if( ! districtData){
			$("table tbody tr").each(function(){
				var lastone = $("table tbody tr:last-child").index();
				if($(this).index()==lastone){
					//alert($(this).index());
				}
				else{
					$("#export-form").css('display','none');
					var codee = $(this).find("td:first-child").text();
					
					var firsthrml = '<td style="background-color: whitesmoke; position: relative; left: 0px;">'+$(this).find("td:first-child").html()+'</td>';
					var secondhrml = '<td style="background-color: whitesmoke; position: relative; left: 0px;">'+$(this).find("td:nth-child(2)").html()+'</td>';
					var curRow = $(this);
					var htnl = '<td colspan="52"><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> </td>';
					curRow.html(firsthrml+secondhrml+htnl);
					if(codee>0){
						$.ajax({
							type: "POST",
							data: "fyear=" + <?php echo $year; ?> + "&distcode=" + codee,
							url: "<?php echo base_url(); ?>Ajax_calls/moonzerorepcomp_data",
							success: function(result){
								curRow.html(firsthrml+secondhrml+result);
							$('#query').append(result);
								//code to print here
							}
						});
					}	
				}			
			});
		}
		else{
			$("#export-form").prop('enctype', "multipart/form-data");
			$("#export-form").prop('action', "Export");
		}
	});
	
</script>