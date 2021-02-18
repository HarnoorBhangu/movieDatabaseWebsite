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

    $wid= $_POST["wid"];
    $mid=$_POST["movie"];
    if (empty($wid)) {
        header("Location: watchlist.php");
        $db->close();
        exit();
    }

    $db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
    
        $q1 = " DELETE FROM Entries WHERE mid=$mid AND wid='$wid'";
        $r1 = $db->query($q1);

        $q = " SELECT * FROM Entries where wid=$wid";
        $r = $db->query($q);
   } 
    else if(isset($_SESSION["email"]))
	{
        $wid= $_GET["wid"];
		$db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
	  	if ($db->connect_error) {
	  		die ("Connection failed: " . $db->connect_error);
		}
    
		$q = " SELECT * FROM Entries where wid=$wid";
        $r = $db->query($q);
        
	}

	else
	{	
        header("Location: loginpage.php");
		exit();
	}
?>



<!DOCTYPE   php>
<php>
    <head>
        <title>watchlist</title>
        <link rel=stylesheet href="stylesheet.css">
        <script type="text/javascript" src="validatehomepage.js"></script>
        <script type="text/javascript" src="validate2.js"> </script> 
        <script src="scripts.js"></script>
        <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script> 
    </head>
    <body>
       <header>
        <h1 >Cinema Bazaar: Browse, Rate and Personalize<br>&emsp;&ensp;&emsp;&emsp; &emsp;&emsp;&emsp;Your Movie Collection</h1>

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

        <script type="text/javascript" src="eventhomepage.js"></script>
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
<p id="search" style="background-color:#B7322">Your watchlist contains the following selection of Movies:<br>

    <div class="grid-container">
<?

if(mysqli_num_rows($r)>0){
     
     while ($row = $r->fetch_assoc()) 
     {	
          //query for rating
          $q3 = " SELECT * FROM Ratings where mid=$row[mid] AND uid=$uid ";
          $r3 = $db->query($q3);
          $row3 = $r3->fetch_assoc();	
          $q4 = " SELECT * FROM Views where mid=$row[mid] AND uid=$uid order by timeViewed DESC";
          $r4 = $db->query($q4);
          $row4 = $r4->fetch_assoc();
         //query for 
         $q2 = " SELECT * FROM Movies where mid=$row[mid]";
         $r2 = $db->query($q2);
         $row2 = $r2->fetch_assoc();	
         ?>

               <div class="grid-item"><a href="moviedetail.php?mid=<?=$row2['mid']?>">
                <img src="<?=$row2['poster']?>.jpg" alt="movie" style="width:150px;height:200px;">
                </a><br><?=$row2['title']?>(<?=$row2['year']?>)<br>
                <?if($r3->num_rows > 0 )
         {?>
         <strong>Rated:</strong> 
                <?$i=0; while($i<$row3["rating"]){?> &#11088; <? $i=$i+1;}?>
    
        <?
         }
         
        else
        {?>  <strong>No ratings by you</strong>
   
           <?
        }

         if($r4->num_rows > 0 )
        {?><br>
        <strong>Last Viewed:</strong> <br>
               <?=$row4["timeViewed"];
    }
        else
         {?>  <br><strong>Not viewed yet</strong>
    
            <?
         }
         ?>

         <?;
        
         ?>
           <form id="delete" action="watchlist.php?wid=<?=$wid?>" method="post">
                <input type="hidden" name="submitted" value="1"/>
                <input type="hidden" name="wid" value="<?=$wid?>">
                <input type="hidden" name="mid" value="<?=$row2['mid']?>">
                <input type="checkbox" name="movie" value="<?=$row2['mid']?>">
                

    </div>
            <?
        }
    }
else{
    ?>
    
    <p style="color:red; background-color:black">Watchlist is Empty. <br></p>
<?}
?>
</div>
<input  class="button" style="align-content: center;" type="submit" value="Delete Selected" />
       
       </form>
       
       </section>
<?php		
	$db->close();
?>      
    
        
    </form>
      

   

        
          

        
     
        
       
         
</body>

</php>