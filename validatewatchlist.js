function SignUpForm3(event){

    var elements=event.currentTarget;

   
    var list=elements[0].value;
    

    var msg_list=document.getElementById("msg_list");
   
    msg_list.innerHTML = "";

    var result=true;
    var textNode;
    var htmlNode;

    if (list == null || list == "") {
        textNode = document.createTextNode("Watchlist name cannot be empty");
        msg_list.appendChild(textNode);
        result = false;
    
      }
      else if(list.length>15){
        textNode = document.createTextNode("Watchlist name cannot be more than 15 characters");
        msg_list.appendChild(textNode);
        result = false;
      }
      

if(result==false){
     event.preventDefault(); 
}
    
}