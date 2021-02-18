
function SignUpForm2(event){
   
    var elements=event.currentTarget;

    //get all fields into variables
    var uname2=elements[1].value;
    var pswd2=elements[2].value;

    var regex_pswd  = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

   
    var msg_uname2=document.getElementById("msg_uname2");
    var msg_pswd2=document.getElementById("msg_pswd2");
    msg_uname2.innerHTML = "";
    msg_pswd2.innerHTML  = "";



    var result=true;
    var textNode;
    var htmlNode;

    if (uname2 == null || uname2 == "") {
        textNode = document.createTextNode("Email empty.");
        msg_uname2.appendChild(textNode);
        result = false;
    
      }



    if (pswd2 == null || pswd2 == "") {
        textNode = document.createTextNode("Password empty.");
        msg_pswd2.appendChild(textNode);
        result = false;
      } 
      else if (regex_pswd.test(pswd2) == false) {
        textNode = document.createTextNode("Password wrong format");
        msg_pswd2.appendChild(textNode);
        result = false;
      }  

if(result==false){
     event.preventDefault(); 
}
else{
  window.location.href='HomePage.php';
}
    
}