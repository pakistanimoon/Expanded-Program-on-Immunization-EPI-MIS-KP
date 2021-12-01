$(document).ready(function(){
	$('input[name^=ttri_r]').keyup(function(e){
		var thisName = $(this).attr("name");
		var parts = thisName.split("_");
		var row = parts[1];
		var toaddPL=0;var toaddNPL=0;
		for(i=1; i<=4; i++){
			var toadd = ($("input[name=ttri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=ttri_"+row+"_f"+i+"]").val()):0;
			toaddPL = toaddPL + toadd;
			i++;
			toadd = ($("input[name=ttri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=ttri_"+row+"_f"+i+"]").val()):0;
			toaddNPL = toaddNPL + toadd;
		}
		$("input[name=ttri_"+row+"_f5]").val(toaddPL); 
		$("input[name=ttri_"+row+"_f6]").val(toaddNPL);	 
	});
});