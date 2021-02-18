
function SignUpForm(event){
    
    var elements=event.currentTarget;

    //get all fields into variables
    var fname=elements[1].value;
    var lname=elements[2].value;
    var email=elements[3].value;
    var uname=elements[4].value;
    var avatar=elements[5].value;
    var pswd=elements[6].value;
    var pswdr=elements[7].value;

    var regex_email = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
    // var regex_uname = /^[a-zA-Z0-9_-]+$/;
    var regex_pswd  = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

    var msg_avatar=document.getElementById("msg_avatar");
    var msg_email=document.getElementById("msg_email");
    var msg_uname=document.getElementById("msg_uname");
    var msg_fname=document.getElementById("msg_fname");
    var msg_lname=document.getElementById("msg_lname");
    var msg_pswd=document.getElementById("msg_pswd");
    var msg_pswdr=document.getElementById("msg_pswdr");
    msg_avatar.innerHTML = "";
    msg_email.innerHTML  = "";
    msg_uname.innerHTML = "";
    msg_pswd.innerHTML  = "";
    msg_pswdr.innerHTML = "";
    msg_lname.innerHTML  = "";
    msg_fname.innerHTML = "";


    var result=true;
    var textNode;
    var htmlNode;

    if (email == null || email == "") {
       
        msg_email.innerHTML="Email address empty";
        result = false;
      } 
    else if (regex_email.test(email) == false) {
        textNode = document.createTextNode("Email address wrong format example: username@somewhere.sth");
        msg_email.appendChild(textNode);
        result = true;         //
      }

    if (uname == null || uname == "") {
        textNode = document.createTextNode("Username empty.");
        msg_uname.appendChild(textNode);
        result = false;
    
      }

    if (fname == null || fname == "") {
        textNode = document.createTextNode("First name is empty.");
        msg_fname.appendChild(textNode);
        result = false;
    
      }

    if (lname == null || lname == "") {
        textNode = document.createTextNode("Last name is empty.");
        msg_lname.appendChild(textNode);
        result = false;
    
      }
      if(avatar=="Pick Avatar"){
        textNode = document.createTextNode("Choose any Avatar");
        msg_avatar.appendChild(textNode);
        result = false;
      }

    if (pswd == null || pswd == "") {
        textNode = document.createTextNode("Password empty.");
        msg_pswd.appendChild(textNode);
        result = false;
      } 
      else if (regex_pswd.test(pswd) == false) {
        textNode = document.createTextNode("Password should be atleast 8 characters, at least 1 number and 1 symbol");
        msg_pswd.appendChild(textNode);
        result = false;
      }  
      else if(pswdr!=pswd){
        textNode = document.createTextNode("Passwords don't match");
        msg_pswdr.appendChild(textNode);
        result = false;
      }

if(result==false){
     event.preventDefault(); 
}

}