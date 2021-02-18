
$(document).ready(function(){
    $(document).on('click','.add',function(){
    var mid = $(this).attr("id");
    var el = this;
    var action = "add";
        $.ajax({
            url:"add_movie.php",
            method:"POST",
            data:{mid:mid, action:action},
            success:function(data)
            {
                if(data==1)
                {
                alert("Movie was added to your Default Watchlist");
                }
                else{
                    alert("Error adding movie to the watchlist.");
                }
               // $(".add").remove();

              }
        })
    });

    });