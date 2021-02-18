<?php
$validate = true;
$error1 = "";
$email = "";
$message = "";
$message2 = "";
$message3 = "";


$ip=$_SERVER['REMOTE_ADDR'];
$db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }

    if($ip != "24.72.80.104")
    {
        $q = "INSERT INTO iplogs (ip,time) VALUES ('$ip', now() )";
        $r = $db->query($q);
    }

if (isset($_POST["submitted"]) && $_POST["submitted"])
{
    if($_SERVER["REQUEST_METHOD"]=='POST'){
    $avatar = trim($_FILES["fileToUpload"]["name"]);
    $target_dir = "avatars/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    //echo "in the show.";
    
    // Check if file already exists
    if (file_exists($target_file)) {
      $uploadOk = 1;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
      $message= "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $message= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $message2= "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message2= "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      } else {
        $message2= "Sorry, there was an error uploading your file.";
      }
    }

}
    //echo '$target_dir';
    $email = trim($_POST["email"]);
    $uname = trim($_POST["uname"]);
    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);
   
    $pswd = trim($_POST["pswd"]);
    $pswdr = trim($_POST["pswdr"]);
       

    $db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
    

    //CREATING A QUERY
    //DOUBLE QOUTE FOR A STRING AND SINGLE QUOTE FOR A VARIABLE(NO DOT OPERATOR)
    $q1 = "SELECT * FROM Users WHERE username = '$uname'";
    $r1 = $db->query($q1);
    $q3 = "SELECT * FROM Users WHERE email = '$email'";
    $r3 = $db->query($q3);
    // if the email address is already taken, THEN DONT CREATE USER
    if($r1->num_rows > 0)
    {
        $validate = false;
        $error1 = "**Username already taken. Try a different one!";

    }
    if($r3->num_rows > 0)
    {
        $validate = false;
        $error1 = "**Email address already in use. Try logging in!";
    }

    //IF THE USER INPUTS ARE VALID
    if($validate == true && $uploadOk==1)
    {
        //echo $avatar;
        $q2 = "INSERT INTO Users(username, fname, lname, email, avatar, password, isLoggedIn) VALUES ('$uname','$fname','$lname','$email','avatars/$avatar','$pswd','0')";

        // EXECUTE QUERY AND IF ITS SUCCESSFUL THEN GO AHEAD
        $r2 = $db->query($q2);
        $q6 = "SELECT uid FROM Users WHERE username='$uname'";

        // EXECUTE QUERY AND IF ITS SUCCESSFUL THEN GO AHEAD
        $r6 = $db->query($q6);
        $row6=$r6->fetch_assoc();
        //echo "hello";
        if ($r2 === true )
        {
            $q7 = "INSERT INTO Watchlists(uid,name,dateCreated) VALUES($row6[uid],'Default Watchlist',now())";
            $r7 = $db->query($q7);
            $error1 = "Sign up successful. You can now login.";
            header("Location: loginpage.php");
            $db->close();
            exit();
        }
    }
    else
    {
        $db->close();
    }


}


$validate = true;

$email = "";
$error = "";

if (isset($_POST["submitted2"]) && $_POST["submitted2"])
{
    $email = trim($_POST["email2"]);
    $password = trim($_POST["pswd2"]);
    
    $db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }


    $q="SELECT * FROM Users where email ='$email' AND password='$password'";
    //add code here to select * from table User where email = '$email' AND password = '$password'
    // start with $q = 

    $r = $db->query($q);

    //converts it into a datastructure and we can use to access user data
    //its an associative array as $row["email"];

    $row = $r->fetch_assoc();
    if($email != $row["email"] && $password != $row["password"])
    {
        //echo "credentials didnt match";
        $validate = false;
    }
    
    if($validate == true)
    {
        //echo "they match";
        session_start();
        $_SESSION["uid"] = $row["uid"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["fname"] = $row["fname"];
        $_SESSION["lname"] = $row["lname"];
        $_SESSION["avatar"] = $row["avatar"];
        $_SESSION["password"] = $row["password"];
        //$_SESSION["lname"] = $row["lname"];


        header("Location: HomePage.php");
        $db->close();
        exit();
    }
    else 
    {
        $error2 = "**The email/password combination was incorrect. Login failed.";
        //echo $error;
        $db->close();
    }
}


?>



<!DOCTYPE html>
<html>
    <head>
        <title>loginpage</title>
        
         <link rel="stylesheet" href="stylesheet.css"> 
         <script type="text/javascript" src="validate.js"> </script>  
         <script type="text/javascript" src="validate2.js"> </script> 
    </head>
<body>

    <header>
        <h1 class="header" >Cinema Bazaar: Browse, Rate and Personalize<br>&emsp;&ensp; &emsp;&emsp;&emsp;&emsp;&emsp;Your Movie Collection </h1>
             <form class="form1" action="loginpage.php" id="SignUp2" method="post">
             <input type="hidden" name="submitted2" value="1"/>
             <table>
                  <tr class="err_msg"><?
                    if (isset($_POST["submitted2"]) && $_POST["submitted2"]){
                     echo $error2;
                     }
                    ?>
                  </tr>
               
                   <tr>
                    <td><label style="font-size: medium;" id="msg_uname2" class="err_msg"></label></td>
                    <td><label style="font-size: medium;" id="msg_pswd2" class="err_msg"></label></td>
                   </tr>
                   <tr>
                       <td>Email</td>
                       <td>Password</td>
                       
                   </tr>
                   <tr>
                        <td><input id="email2" type="text" name="email2"></td>
                        <td><input id="pswd2" type="password" name="pswd2"></td>
                        <td> <input type="submit" value="Login" /></td>
                        <td> <input type="reset" value="Reset" /></td>
                   </tr>
                </table> 
               <br />
              
              
        </form> 
        <script type="text/javascript" src="signup-r2.js"></script>
       
    </header>


    <section>
        <h2>
            With your premium account/Bazaar &#9824
        </h2>
        <h4><b>Personalized Recommendations</b><br>
        <i>Discover shows you will love</i></h4>
        
        <h4><b>Your watchlist</b><br><i>Stay connected and recieve email notifications</i></h4>
        
        <h4><b>Rate our movies</b><br><i>Keep track of what you watch</i></h4>
        
  
        <aside>
        <form id="SignUp" action="loginpage.php" method="post" enctype="multipart/form-data">
         <input type="hidden" name="submitted" value="1"/> 

            <h1 style="font-size: xx-large;color: #004E7C;">Create an account</h1>

            <p class="err_msg"><?
            if (isset($_POST["submitted"]) && $_POST["submitted"]){
                echo $error1; 
                echo "<br>"; 
                echo $message; 
                echo "<br>";
                echo $message2;

            }
           ?></p>

            <table>
                <tr>
                    <td>&nbsp;</td>
                    <td style="font-size: medium;" id="msg_fname" class="err_msg"></td>
                    <td>&nbsp;</td>
                    <td style="font-size: medium;" id="msg_lname" class="err_msg"></td>
                </tr>
                <tr>
                    <td>First Name: </td>
                    <td> <input type="text" id="fname" name="fname" size="20" /></td>
               
                    <td>Last Name: </td>
                    <td> <input type="text" id="lname" name="lname" size="20" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td style="font-size: medium;" id="msg_email" class="err_msg"></td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td> <input type="text" id="email" name="email" size="20" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td style="font-size: medium;" id="msg_uname" class="err_msg"></td>
                
                    <td>&nbsp;</td>
                    <td style="font-size: medium;" id="msg_avatar" class="err_msg"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td> <input type="text" id="uname" name="uname" size="20" /></td>
                    <td>Avatar: </td>
                    <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
                </tr>
    
                <tr>
                    <td>&nbsp;</td>
                    <td style="font-size: medium;" id="msg_pswd" class="err_msg"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td> <input type="password" id="pswd" name="pswd" size="20" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td style="font-size: medium;" id="msg_pswdr" class="err_msg"></td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td> <input type="password" id="pswdr" name="pswdr" size="20" /></td>
                </tr>
             
    
        </table>
        <br />
        <input style="font-size:16pt; border-radius: 4px; background-color: rgb(151, 132, 132);" type="submit" value="Sign up" />
		<input style="font-size:16pt; border-radius: 4px; background-color: rgb(151, 132, 132);"type="reset" value="Reset" />
        

    </form>
    <script type="text/javascript" src="signup-r.js"></script>
</aside>
<br />

<h3>Click here to Continue as guest
    <button style="font-size:16pt; border-radius: 4px; background-color: rgb(185, 121, 121);"><a href="guestfiles/HomePage2.php">>></a></button>
    </h3>
</section>

</body>

</html>