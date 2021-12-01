$(document).ready(function(){
	$(document).on('change','.test',function(){
		
		var v1=$('#cr_r1_f4').val();
		var v2=$('#cr_r2_f4').val();
			if(v2!=''){
				if(v1 != v2	){
					$('#cr_r2_f4').css("background-color","#F54F4F");
					alert("DIL BCG must equal to BCG Vail Used ! ");	
				}
				else{
				    $('#cr_r2_f4').css("background-color","#FFF");
				}
			}
		 var v1=$('#cr_r6_f4').val();
		var v2=$('#cr_r7_f4').val();
			if(v2!=''){
				if(v1 != v2	){
					$('#cr_r7_f4').css("background-color","#F54F4F");
					alert("DIL Measles must equal to Measles Vail Used ! ");	
				}
				else{
				    $('#cr_r7_f4').css("background-color","#FFF");
				}
			}			
	});
});

$(document).ready(function(){
    $(document).on('change','.ob',function(){
		var	row=$(this).closest('tr');
		var dv   = isNaN(parseInt(row.find('td:nth-child(2)').text())) ? 0 : parseInt(row.find('td:nth-child(2)').text());
		var obp  = isNaN(parseInt(row.find('td:nth-child(3)').find('input').val())) ? 0 : parseInt(row.find('td:nth-child(3)').find('input').val());
		var rec  = isNaN(parseInt(row.find('td:nth-child(4)').find('input').val())) ? 0 :parseInt(row.find('td:nth-child(4)').find('input').val());
		var cvda = isNaN(parseInt(row.find('td:nth-child(5)').find('input').val())) ? 0 :parseInt(row.find('td:nth-child(5)').find('input').val());
		var vu   = isNaN(parseInt(row.find('td:nth-child(6)').find('input').val())) ? 0 :parseInt(row.find('td:nth-child(6)').find('input').val());
		var uv   = isNaN(parseInt(row.find('td:nth-child(7)').find('input').val())) ? 0 :parseInt(row.find('td:nth-child(7)').find('input').val());
		///////for children vacinate <= to given doeses/////
		
			
		/* if(v1!=""){
			if(vu!="")
			if(vu!=v1)
				alert("must be equal");
		} */
		
		var total=parseInt(obp+rec);
			if (cvda > total){
					alert('Value is must be less then '+total+'');
					row.find('td:nth-child(5)').find('input').css("background-color","#F54F4F");
		    }
			else{
					row.find('td:nth-child(5)').find('input').css("background-color","#FFF");
			}
		///////for closing balance /////
		var totaluv =parseInt(uv)+parseInt(vu);
			if (dv ==0){
				var dvz=1;
			    var totalvil= total/parseInt(dvz);
				//alert(totalvil);
			}
			else			{ 
				var totalvil= parseInt(total/(dv));
			}
			if(totaluv > totalvil){
					alert("Used and Unused vail is greater then recived and Opening balance ")
			}	
		var cb=parseInt(totalvil) - parseInt(totaluv);
			if(cb < 0 ){
				row.find('td:nth-child(8)').find('input').css("background-color","#F54F4F");
				row.find('td:nth-child(8)').find('input').val(cb);
			}
			else{
				row.find('td:nth-child(8)').find('input').css("background-color","#FFF");
				row.find('td:nth-child(8)').find('input').val(cb);				
			}  
		///////used vaile greater than child vactinate doses administe/////
        if(dv > 0 ){
		var cv =parseInt(cvda) / parseInt(dv);
	    var cvupround =Math.ceil(cv)
        if ((vu <cvupround)&&(vu!='')){
			row.find('td:nth-child(6)').find('input').css("background-color","#F54F4F");
			alert("Vail Used must equal to "+cvupround+"");
		}
        else{
			
		    row.find('td:nth-child(6)').find('input').css("background-color","#FFF");
		}
        }
        /* if ( dv==0 )
		{
			if( vu != )
		} */			
	});
});
	
	