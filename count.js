function countChars(obj){
    var maxChar = 15;
    var CurrChar = obj.value.length;
    var remainChar = (maxChar - CurrChar);
    
    if(remainChar < 0){
        document.getElementById("charNum").innerHTML = '<span style="color: red;">You have exceeded the limit of '+maxChar+' characters</span>';
    }else{
        document.getElementById("charNum").innerHTML = remainChar+' characters remaining';
    }
}