$(document).ready(function(){
	$('input[name^=cri_r]').keyup(function(e){
		var thisName = $(this).attr("name");
		var parts = thisName.split("_");
		var row = parts[1];
		var toaddM=0;var toaddF=0;
		for(i=1; i<=12; i++){
			var toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
			toaddM = toaddM + toadd;
			i++;
			toadd = ($("input[name=cri_"+row+"_f"+i+"]").val() !== undefined)?parseInt($("input[name=cri_"+row+"_f"+i+"]").val()):0;
			toaddF = toaddF + toadd;
		}
		$("input[name=cri_"+row+"_f13]").val(toaddM);
		$("input[name=cri_"+row+"_f14]").val(toaddF);	
	});
});
