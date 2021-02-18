<?php
    session_start();
        $uid= $_SESSION["uid"];
        $email = $_SESSION["email"];
        $username = $_SESSION["username"];
        $fname = $_SESSION["fname"];
        $lname = $_SESSION["lname"];
        $avatar = $_SESSION["avatar"];
        $password = $_SESSION["password"];
       
    if (isset($_POST["submitted"]) && $_POST["submitted"])
   { 

    //$uid = $_POST["userid"];
    $watchlist = trim($_POST["watchlist"]);
    if (empty($watchlist)) {
        header("Location: watchlistdir.php");
        $db->close();
        exit();
    }

    $db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
    
        
        $q1 = " INSERT INTO Watchlists(uid,name,dateCreated) VALUES('$uid','$watchlist',now())";
        $r1 = $db->query($q1);
        $q = " SELECT * FROM Watchlists where uid=$uid";
        $r = $db->query($q);
   } 


	else if(isset($_SESSION["email"]))
	{
		$db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
	  	if ($db->connect_error) {
	  		die ("Connection failed: " . $db->connect_error);
		}
	
		$q = " SELECT * FROM Watchlists where uid=$uid";
        $r = $db->query($q);
        
	}

	else
	{	
        header("Location: loginpage.php");
		exit();
	}
?>


<!DOCTYPE   html>
<html>
    <head>
        <title>watchlist page</title>
        <link rel=stylesheet href="stylesheet.css">
        <script type="text/javascript" src="validatehomepage.js"></script>
        <script type="text/javascript" src="validatewatchlist.js"> </script> 
        <script src="add_watchlist.js"></script>
        <script type="text/javascript" src="count.js"> </script> 
        <script type="text/javascript" src="validate2.js"> </script> 
        <script src="scripts.js"></script>
        <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script> 
        <script src="deletemoviescript.js"></script>

    </head>
    <body>
        <header>
            <h1 >Cinema Bazaar: Browse, Rate and Personalize<br>&emsp;&ensp;&emsp;&emsp; &emsp;&emsp;&emsp;Your Movie Collection</h1>
        </header>
    </header>

    <nav>
        <button class="button" style="align-content: center;"><a href="HomePage.php">Home</a></button>
        <button class="button" style="align-content: center;"><a href="watchlistdir.php"> Watchlists</a></button>
        &emsp;&emsp;
        <form id="SearchBar">
            <input name="search" style="font-size:16pt;" type="text" placeholder="Search for media here" id="search_text" />
        </form>
        <script src="events.js"></script>

        <div class="grid-containerx" id="image_data">
</div>

        <script type="text/javascript" src="eventhomepage.js"></script>

            <h3 style="color: black;">Create a new watchlist:  </h3>
        <form id="NewWatchlist" action="watchlistdir.php" method="post">
            <table>
                <input type="hidden" name="submitted" value="1"/>
                <input type="hidden" name="userid" value="<?=$uid?>"/>
                <tr><td><label style="font-size: medium;" id="msg_list" class="err_msg"></label></td></tr>
                <tr><td><input style="font-size:16pt;" onkeyup="countChars(this)" type="text" id="add" name="watchlist"></td>
                <td><input  style="font-size:16pt; border-radius: 4px; background-color: rgb(151, 132, 132);" type="submit" value="Add" /></td>
                <td><p id="charNum">15 characters remaining</p></td>
                </tr>
                
            
            </table>
            </form>
            <script src="add_watchlist.js"></script>
    </nav>

    <article>
    <table >
        <tr>Logged in as:</tr>    
        <tr><th><img src="<?= $_SESSION['avatar']?>" width="50" height="50" style="border:solid;" ></td><td><? echo $_SESSION['username'];?></th></tr>
        <tr><td><button style="font-size:10pt; border-radius: 4px; background-color: rgb(185, 121, 121);"><a href='logout.php'>Logout</a></button></td></tr>  
        </table>
        <br />
        

    <br>
        Need a new account?
            <button style="font-size:10pt; border-radius: 4px; background-color: rgb(185, 121, 121);"><a href="logout.php">Sign Up here</a></button>

    </article>
  
<form id="watchlist" >
    <h2>Your Watchlists:</h2>
    <table>
    <?
   
    $i=1;
    while($row=$r->fetch_assoc())
    {
    ?>
        
        <tr>
        <td><?=$i?><td>
        <td><a href="watchlist.php?wid=<?=$row['wid']?>"> <?=$row["name"]?></a></td>
        <td><button type="button" class="delete" name="delete" id="<?=$row['wid']?>">Delete</button></td>
            <tr>
           
    <?$i=$i+1;
    }
    ?>
    <script src="deletemovieevent.js"></script> 
       <p style="color:red;">**Attention: You cannot delete your Default Watchlist.</p>

       </form>
      
  
<?php		
	$db->close();
?>     
</body>

</html>
