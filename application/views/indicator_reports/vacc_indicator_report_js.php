
<script type="text/javascript">
$( document ).ready(function() {
var indicator= "<?php echo $data['indicator']; ?>";
//alert(indicator);

//Penta1-Measle1 dropout
    if(indicator==24 || indicator==25 || indicator==26 ||indicator==27){
		var a=parseInt($('.table tr:last').find("td:nth-last-child(3)").html());
		var b=($('.table tr:last').find("td:nth-last-child(2)").html());
		$('.table tr:last').find("td:nth-last-child(6)").text('');
		var total=(a-b);
        var totalpenatameasel1=((total/a)*100).toFixed(2);
		var round =Math.round(totalpenatameasel1);
	   ($('.table tr:last').find("td:nth-last-child(1)").text(round+ "%"));
	}else if(indicator==23){
		var a= parseInt($('.table tr:last').find("td:nth-last-child(2)").html());
		var b= parseInt($('.table tr:last').find("td:nth-last-child(3)").html());
		var c= parseInt($('.table tr:last').find("td:nth-last-child(4)").html());
		var d= parseInt($('.table tr:last').find("td:nth-last-child(5)").html());
		var e= parseInt($('.table tr:last').find("td:nth-last-child(6)").html());
		//$('.table tr:last').find("td:nth-last-child(7)").text('');
		$('.table tr:last').find("td:nth-last-child(8)").text('');
		if(e<=0){
			$('.table tr:last').find("td:nth-last-child(1)").html()
		}else{
		var totalall= a + b + c + d;
	    var livebirth=(e*3.533/100).toFixed(2); 
		var tt2coverage=(totalall/livebirth *100).toFixed(2);
		var round =Math.round(tt2coverage);
		($('.table tr:last').find("td:nth-last-child(1)").text(round+ "%"));
		}
	}
	else{
		var a=($('.table tr:last').find("td:nth-last-child(9)").html());
		var b=($('.table tr:last').find("td:nth-last-child(8)").html());
		var c=($('.table tr:last').find("td:nth-last-child(6)").html());
		var d=($('.table tr:last').find("td:nth-last-child(5)").html());
		var e=($('.table tr:last').find("td:nth-last-child(3)").html());
		var f=($('.table tr:last').find("td:nth-last-child(2)").html());
		$('.table tr:last').find("td:nth-last-child(11)").text('');
		$('.table tr:last').find("td:nth-last-child(12)").text('');
		//alert(e);
		
		if(b <= 0){
			$('.table tr:last').find("td:nth-last-child(7)").html()
		}
		else{  
			var totalmalecoverage=(a/b*100).toFixed(2); 
			var round =Math.round(totalmalecoverage);  
			($('.table tr:last').find("td:nth-last-child(7)").text(round+ "%"));
		}
		if(d <= 0){
			$('.table tr:last').find("td:nth-last-child(4)").html()
		}
		else{ 
			var totalfemalecoverage=(c/d*100).toFixed(2); 
			var round =Math.round(totalfemalecoverage);  
			($('.table tr:last').find("td:nth-last-child(4)").text(round+ "%"));
		}
		if(f <= 0){
			$('.table tr:last').find("td:nth-last-child(1)").html()
		}
		else{  
			var totalcoverage=(e/f*100).toFixed(2);
            var round =Math.round(totalcoverage);  			
			($('.table tr:last').find("td:nth-last-child(1)").text(round+ "%"));
		} 
	}




   }); 
</script>