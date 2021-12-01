<?php $index=1;
	//print_r($row);exit;
?>
<?php 
	$index=1; 
	$previousYear = date("Y")-1;
	$currentYear = date("Y");
	$nextYear = date("Y")+1;
?>
<?php foreach ($row as $i => $value) { ?>
	<tr>
		<td class='text-center Heading'><?php echo $index; ?></td>
		<td class='text-left' style="text-align-last: center;"><?php echo $value['unioncouncil']; ?></td>
		<td class='text-left'style="text-align-last: center;"> 
			<select name="facode[]" class="form-control">
				<?php echo getFLCF_optionsbyuncode(false, $value['facode'], $value['uncode']);  ?>
			</select>
		</td>
		<td class='text-left' style="text-align-last: center;">
			<?php echo $value['village']; ?>
			<input type='hidden' name='village[]' value="<?php echo $value['vcode']; ?>" readonly class='form-control'>
		</td>             
		<input type='hidden' name='tcode[]' value="<?php echo $value['tcode']; ?>">
		<input type='hidden' name='uncode[]' value="<?php echo $value['uncode']; ?>">
		<input type='hidden' name='distcode[]' value="<?php echo $value['distcode']; ?>">
		<td class='text-center'>
			<input readonly value='<?php if(isset($value['previous']) && !empty($value['previous'])){echo $value['previous'];}else{ echo 0; } ?>' class='form-control text-center numberclass previous'>
			<!--<input class='form-control text-center numberclass previous' name='previous[]' value='<?php if(isset($value['previous']) && !empty($value['previous'])){echo $value['previous'];}else{ echo 0; } ?>'>-->
		</td>
		<td class='text-left'>
			<input class='form-control text-center numberclass current' name='current[]' value='<?php if(isset($value['current']) && !empty($value['current'])){echo $value['current'] ;}else{ echo 0; } ?>'>
		</td>
		<td class='text-left'>
			<input class='form-control text-center group1 numberclass next'   name='next[]' id='textNextYear' disabled='disabled' value='<?php if(isset($value['next']) && !empty($value['next'])){echo $value['next'];}else{ echo 0; } ?>'>
		</td>
	</tr>
	<input type='hidden' name='addeddate[]' value='<?php echo $value['added_date']; ?>'>
    <?php $index++;
 } ?> 
    <tr>
		<td class="text-right" colspan="3"><strong>Total: </strong></td>
		<td></td>
		<td class="text-center"><strong><p id="previoustotal"></p></strong></td>
		<td class="text-center"><strong><p id="currenttotal"></p></strong></td>
		<td class="text-center"><strong><p id="nexttotal"></p></strong></td>
	</tr>           
</div><!--end of body container -->
<!--<div class="container">
	<div class="row">
		<div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
			<button style="background:#008d4c;" type="submit" class="btn btn-primary btn-md" role="button">Submit</button>
		</div>
	</div>
</div>-->
      
<script type="text/javascript">
	$('#nextYear').change(function() {
		if (this.checked) {
			$("input.group1").removeAttr("disabled");
		}
		else {
			$("input.group1").attr("disabled", true);
		}
	});
	$(document).ready(function(){
		var tcode = $('#tcode').val(); 
		if(tcode !=''){
			$("#submit").removeAttr('disabled');
			$(".current").removeAttr("disabled");
		}
		var $previoussum = 0;
		$('.previous').each(function(k,v){
			if( ! isNaN(parseInt($(this).val()))){
				$previoussum += parseInt($(this).val());
			}
		});
		var $currentsum = 0;
		$('.current').each(function(k,v){
			if( ! isNaN(parseInt($(this).val()))){
				$currentsum += parseInt($(this).val());
			}
		});
		var $nextsum = 0;
		$('.next').each(function(k,v){
			if( ! isNaN(parseInt($(this).val()))){
				$nextsum += parseInt($(this).val());
			}
		});
		$('#previoustotal').text($previoussum);
		$('#currenttotal').text($currentsum);
		$('#nexttotal').text($nextsum);
	});
	$(document).on('keyup','.next,.current',function(){
		var $previoussum = 0;
		$('.previous').each(function(k,v){
			if( ! isNaN(parseInt($(this).val()))){
				$previoussum += parseInt($(this).val());
			}
		});
		var $currentsum = 0;
		$('.current').each(function(k,v){
			if( ! isNaN(parseInt($(this).val()))){
				$currentsum += parseInt($(this).val());
			}
		});
		var $nextsum = 0;
		$('.next').each(function(k,v){
			if( ! isNaN(parseInt($(this).val()))){
				$nextsum += parseInt($(this).val());
			}
		});
		$('#previoustotal').text($previoussum);
		$('#currenttotal').text($currentsum);
		$('#nexttotal').text($nextsum);
	});
</script>