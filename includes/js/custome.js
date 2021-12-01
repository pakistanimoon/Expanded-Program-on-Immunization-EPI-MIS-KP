function search_table(value){
 $("#example tr").each(function(){
  var found = "false";
  $(this).each(function(){
   
   if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >=0){
    found = "true";
    console.log(found);
   }
  });
  if(found == "true"){
   $(this).show();
  }else{
   $(this).hide();
  }
 })
}