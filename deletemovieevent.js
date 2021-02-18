
$(document).ready(function(){
$(document).on('click','.delete',function(){
var image_id = $(this).attr("id");
var el = this;
var action = "delete";
if(confirm("Please confirm to delete watchlist successfully?"))
{
    $.ajax({
        url:"deletemovie.php",
        method:"POST",
        data:{image_id:image_id, action:action},
        success:function(data)
        {
   
            if(data == 1){
          // Remove row from HTML Table
          $(el).closest('tr').css('background','tomato');
          $(el).closest('tr').fadeOut(800,function(){
             $(this).remove();
          });
            }else{
          alert('Invalid ID.');
            }
  
          }
    })
}
else{
return false;
}
});

   
});

