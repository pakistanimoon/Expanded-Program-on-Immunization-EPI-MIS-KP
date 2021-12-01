$(document).ready(function(){
 $(document).on("keyup","td.t-row,td.t-row1,td.t-row2",function(e) {
	var row = $(this).parent().parent().children().index($(this).parent());    
    var a1 = parseFloat($('#myTable tbody tr:eq('+row+') td:eq(3)').html());
	if(!isNaN(a1) && !isNaN(parseFloat($(this).children().val()))){
		$('#myTable tbody tr:eq('+row+') td:eq(5)').children().val(a1*parseFloat($(this).children().val()));
		var total1 = parseFloat(document.getElementById("res").value);
		var total2 = parseFloat(document.getElementById("res1").value);
		var total3 = parseFloat($('#myTable tbody tr:eq('+row+') td:eq(5)').children().val());
		var grand=total1+total2+total3;
		if(!isNaN(grand) && grand!=''){
			$('#myTable tbody tr:eq('+row+') td:eq(7)').children().val(grand);
			document.getElementById("live_births").value = grand;
		}
	}
 });
 
	/////////////////////////////Js Code For Section No 14 Step 1////////////////////////////////////
 $(document).on("keyup","td.row1",function(e) {
	
	var row = $(this).parent().parent().children().index($(this).parent()); 
	var a1 = parseFloat($('#mySecTable tbody tr:eq('+row+') td:eq(3)').html());
	var kk = parseFloat($('#mySecTable tbody tr:eq('+row+') td:eq(1)').children().val());
	if(!isNaN(a1) && !isNaN(parseFloat($(this).children().val()))){
		$('#mySecTable tbody tr:eq('+row+') td:eq(5)').children().val(a1*parseFloat($(this).children().val()));
		var p = $('#mySecTable tbody tr:eq('+row+') td:eq(5)').children().val();
		var a2 = parseFloat($('td.fifty1').html());
		document.getElementById("sec14Tab1").value = p;
		var a2 = Math.round(a2/p); 
		if(a2 == 'Infinity'){
			a2= '0';
		}
		document.getElementById("sec14Tab2").value = a2;
		document.getElementById("gt").value = a2;
	}
		if(parseFloat($(this).children().val())!=''){
			document.getElementById("enable2").disabled = true;
		}
		if(isNaN(kk)){
			document.getElementById("sec14Tab1").value = '';
			document.getElementById("sec14Tab2").value = '';
			document.getElementById("sec14").value = '';
			document.getElementById("gt").value = '';
			document.getElementById("enable2").disabled = false;
		}
  });
 $(document).on("keyup","td.row2",function(e) {
	   
	var row = $(this).parent().parent().children().index($(this).parent()); 
	var a1 = parseFloat($('#mySecTable tbody tr:eq('+row+') td:eq(3)').html());
	var kk = parseFloat($('#mySecTable tbody tr:eq('+row+') td:eq(1)').children().val());
	if(!isNaN(a1) && !isNaN(parseFloat($(this).children().val()))){
		if(parseFloat($(this).children().val())!=''){
			document.getElementById("disable1").disabled = true;
		}
		else{
			document.getElementById("disable1").disabled = false;
		}
		$('#mySecTable tbody tr:eq('+row+') td:eq(5)').children().val(a1*parseFloat($(this).children().val()));
		var p = $('#mySecTable tbody tr:eq('+row+') td:eq(5)').children().val();
		var a2 = parseFloat($('td.fifty2').html());
		document.getElementById("sec14aTab1").value = p;
		var a2 = Math.round(a2/p);  
		if(a2 == 'Infinity'){
			a2= '0';
		}
		document.getElementById("sec14aTab2").value = a2;
		document.getElementById("gt").value = a2;
	}
		if(parseFloat($(this).children().val())!=''){
			document.getElementById("disable1").disabled = true;
		}
		if(isNaN(kk)){
			document.getElementById("sec14aTab1").value = '';
			document.getElementById("sec14aTab2").value = '';
			document.getElementById("sec14a").value = '';
			document.getElementById("gt").value = '';
			document.getElementById("disable1").disabled = false;
		}
  });

	/////////////////////////////Js Code For Section No 15 Step 1////////////////////////////////////
	$(document).on("keyup","td.t-rowtable1,td.t-rowtable2,td.t-rowtable3,td.t-rowtable4,td.t-rowtable5,td.t-rowtable6",function(e) {
		var row = $(this).parent().parent().children().index($(this).parent()); 
		var a1 = parseFloat($('#mytable2 tbody tr:eq('+row+') td:eq(4)').text());
		var t = parseFloat($(this).children().val());

		if(!isNaN(t) && !isNaN(parseFloat($(this).children().val()))){
			$('#mytable2 tbody tr:eq('+row+') td:eq(6)').children().val(t*a1);
			var t1 = parseFloat(document.getElementById("r1").value);
			var t2 = parseFloat(document.getElementById("r2").value);
			var t3 = parseFloat(document.getElementById("r3").value);
			var t4 = parseFloat(document.getElementById("r4").value);
			var t5 = parseFloat(document.getElementById("r5").value);
			var t6 = parseFloat(document.getElementById("r6").value);
			var grand=t1+t2+t3+t4+t5+t6;
			if(!isNaN(grand) && grand!=''){
				$('#grand').val(grand);
				var six = $('#6').text();
				var totalr= parseFloat(grand/six);
				document.getElementById("rtotal").value = Math.round(totalr); ;
			}
		}
	});
	/////////////////////////////Js Code For Section No 15 Step 2////////////////////////////////////
	$(document).on("keyup","td.t-stepTwoTable1",function(e) {
		var row = $(this).parent().parent().children().index($(this).parent()); 
		var inputOne = parseFloat($(this).children().val());
		var a1 = parseFloat($('#mytable2 tbody tr:eq('+row+') td:eq(3)').text());
		var a2 = parseFloat($('#mytable2 tbody tr:eq('+row+') td:eq(5)').text());
		var grandTotal =  parseFloat(inputOne / a1 * a2);
		if(!isNaN(grandTotal) && grandTotal!=''){
			document.getElementById("grandTotal").value = Math.round(grandTotal);
			document.getElementById("nro").value = parseFloat(document.getElementById("rtotal").value);
			document.getElementById("sec15step2tot").value = parseFloat(document.getElementById("grandTotal").value);
			var r = Math.round(parseFloat(document.getElementById("nro").value)/parseFloat(document.getElementById("sec15step2tot").value));
			if(r == 'Infinity'){
				r= '0';
			}
			document.getElementById("rs1").value = r;
			document.getElementById("reserve_stock").value = r;
		}
		//alert(grandTotal);
	});

	/////////////////////////////Js Code For Section No 16////////////////////////////////////
	$(document).on("keyup","td.sec16Field2,td.sec16partBField2,td.sec16partBField3",function(e) {
		var row = $(this).parent().parent().children().index($(this).parent());
		var a1 = parseFloat($('#sec16Table1 tbody tr:eq('+row+') td:eq(1)').text());	
		var a2 = parseFloat($('#sec16Table1 tbody tr:eq('+row+') td:eq(3)').children().val());
		var inputOne = parseFloat($(this).children().val());
		if(!isNaN(a1) && !isNaN(a2) && !isNaN(inputOne)){
			var a3 = parseFloat($('#sec16Table1 tbody tr:eq('+row+') td:eq(5)').text());
			var grand= a1*a2*inputOne;
			$('#sec16Table1 tbody tr:eq('+row+') td:eq(7)').children().val(grand);
			var t1 = parseFloat(document.getElementById("StepA").value);
			var t2 = parseFloat(document.getElementById("StepB").value);
			var t3 = parseFloat(document.getElementById("StepC").value);
			var grandTotal=t1+t2+t3;
			if(!isNaN(grandTotal)){
				document.getElementById("sec16Total").value = grandTotal;
				document.getElementById("sec16Total3").value = grandTotal;
				
			}
		}
	});
	
	/////////////////////////////Js Code For Section No 17////////////////////////////////////
	$(document).on("keyup","td.sec17Field1",function(e) {
		var row = $(this).parent().parent().children().index($(this).parent());
		var t1 = parseFloat($('#sec17Table1 tbody tr:eq('+row+') td:eq(1)').children().val());
		var t2 = parseFloat($('#sec17Table1 tbody tr:eq('+row+') td:eq(3)').children().val());
		var t3 = parseFloat($('#sec17Table1 tbody tr:eq('+row+') td:eq(5)').children().val());
		var t4 = parseFloat($('#sec17Table1 tbody tr:eq('+row+') td:eq(7)').children().val());
		var rt = 0;
		if(!isNaN(t1)){ rt = t1;}
		if(!isNaN(t2)){ rt += t2;}
		if(!isNaN(t3)){ rt += t3;}
		if(!isNaN(t4)){ rt += t4;}
		var ab = 0;
		var	a =	parseFloat(document.getElementById("sec17A").value);
		if(!isNaN(a)){ ab = a;}
		if(!isNaN(rt) && rt!=''){
			document.getElementById("sec17res").value = rt;
			var a11 = parseFloat($('#sec17Table1 tbody tr:eq('+row+') td:eq(11)').text());
			$('#sec17Table1 tbody tr:eq('+row+') td:eq(13)').children().val(rt*a11);
			var b = parseFloat($('#sec17Table1 tbody tr:eq('+row+') td:eq(13)').children().val());
			if(b!=0){ ab += b;}
		}
		if(!isNaN(ab)){
			document.getElementById("totAB").value = ab;
			document.getElementById("sec171a").value = ab;
		}
	});
/////////////////////////////Js Code For Section No 17 Table2////////////////////////////////////
	$(document).on("keyup","td.sec17tab2Field1,td.sec17tab2Field2,td.sec17tab2Field3,td.sec17tab2Field4,td.sec17tab2Field5,td.sec17tab2Field6,td.sec17tab2Field7",function(e) {
		var row = $(this).parent().parent().children().index($(this).parent());
		var t2 = parseFloat($('#sec17Table2 tbody tr:eq('+row+') td:eq(1)').children().val());
		var t3 = parseFloat($('#sec17Table2 tbody tr:eq('+row+') td:eq(3)').children().val());
		var t4 = parseFloat($('#sec17Table2 tbody tr:eq('+row+') td:eq(5)').children().val());
		var grand = t2*t3*t4;
		if(!isNaN(grand)){
			$('#sec17Table2 tbody tr:eq('+row+') td:eq(7)').children().val(grand);
			var a11 = parseFloat($('#sec17Table2 tbody tr:eq('+row+') td:eq(9)').text());
			var b = parseFloat($('#sec17Table2 tbody tr:eq('+row+') td:eq(7)').children().val());
			$('#sec17Table2 tbody tr:eq('+row+') td:eq(11)').children().val(b/a11);
		}
	});
	
});

  
