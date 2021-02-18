function fetch_data()
    {
        var letter = document.getElementById("search_text").value;
        
        $.ajax({
            url:"show_records.php?q=" + letter,
            method:"GET",
           
            success:function(data)
            {
                $('#image_data').html(data);

            }
        })
    
    }