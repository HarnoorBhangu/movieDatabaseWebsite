<?php
    session_start();
    $mid= $_GET["mid"];
    if (isset($_POST["submitted"]) && $_POST["submitted"])
   { 

    $mid = $_POST["movieid"];
    $rating = $_POST["rating"];
    if (empty($rating)) {
        header("Location: moviedetail.php?mid=$mid");
        $db->close();
        exit();
    }
    $db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
    
  
    $q1 = "INSERT INTO Ratings(uid,mid,rating,dateRated) VALUES($_SESSION[uid],$mid,$rating,now())";
    $r1 = $db->query($q1);

        if ($r1 === true )
        {
            header("Location:moviedetail.php?mid=$mid");
        }
 

   } 
        
   else if (isset($_POST["submitted3"]) && $_POST["submitted3"])
   { 

    $search= $_POST["search"];
    $db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
    
   
    $q = " SELECT * FROM  Movies where title LIKE '%$search%' OR genre LIKE '%$search%' OR director LIKE '%$search%' OR cast LIKE '%$search%' OR year LIKE '%$search%' OR origin LIKE '%$search%'";
    $r = $db->query($q);
  
   }

	else if(isset($_SESSION["email"]))
	{
		
        //gotten all the variable values from the form submission through session variable
        $mid= $_GET["mid"];
    
		// load the database and get the orders for this user
		$db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
	  	if ($db->connect_error) {
	  		die ("Connection failed: " . $db->connect_error);
		}
	
		$q = "SELECT mid,title,year,origin,genre,poster,director,wikilink,cast FROM Movies WHERE mid=$mid";
		$result = $db->query($q);	
        $q2 = "INSERT INTO Views (uid,mid,timeViewed) VALUES($_SESSION[uid],$mid,now())";
		$r2 = $db->query($q2);
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
<body> 
    <?php
    $row = $result->fetch_assoc();
    ?>
<table style="border:double; padding:50px; background-color: #f0e1b9ff;">
<tr >
<td >
    <img src="<?= $row['poster']?>.jpg"  alt="Art" height="300" width="200">
    <br>

   <?$q = "SELECT * FROM Ratings WHERE mid=$mid AND uid=$_SESSION[uid]";
        $result1 = $db->query($q);
        $row2 = $result1->fetch_assoc();
       if($result1->num_rows > 0)
    {?>
        <p><i>Your Rating: <?$i=0; while($i<$row2["rating"]){?> &#11088; <? $i=$i+1;}?></i></p>
    <? }
   else
    {?>
    <form class="form" action="moviedetail.php" method="post">
                        <input type="hidden" name="submitted" value="1"/>
                        <input type="hidden" name="movieid" value="<?=$mid?>"/>
                        <input type="radio" name="rating" value="1">1
                        <input type="radio" name="rating" value="2">2
                        <input type="radio" name="rating" value="3">3
                        <input type="radio" name="rating" value="4">4
                        <input type="radio" name="rating" value="5">5
                        <input type="submit" value="Rate">
        </form> 
    <?}?>
    </td>

    <td>
    <h1><?=$row["title"]?></h1>
    
    <p>
    <strong>Year Released:</strong><?=$row["year"]?><br>
    <strong>Genre:</strong><?=$row["genre"]?><br>
    <strong>Origin:</strong><?=$row["origin"]?><br>
        <strong>Directed by:</strong> <?=$row["director"]?><br>
        <strong>Cast:</strong> <?=$row["cast"]?><br>
    </p>
           
    For more Information, Go to this <i><a href="<?=$row["wikilink"]?>"> Wikipedia Page</a></i>
</body>
</td>
</tr>
 </table>
 <?php		
	$db->close();
?>   
</body>
</html>