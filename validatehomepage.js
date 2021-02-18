function SignUpForm(event){
    var elements=event.currentTarget;

   
    var search=elements[0].value;
    

    var msg_search=document.getElementById("msg_search");
   
    msg_search.innerHTML = "";

    var result=true;
    var textNode;
    var htmlNode;

    if (search == null || search == "") {
        textNode = document.createTextNode("**Search Box Empty");
        msg_search.appendChild(textNode);
        result = false;
    
      }

if(result==false){
     event.preventDefault(); 
}

}