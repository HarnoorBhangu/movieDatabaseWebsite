<?php
    session_start();
    $uid= $_SESSION["uid"];
        $email = $_SESSION["email"];
        $username = $_SESSION["username"];
        $fname = $_SESSION["fname"];
        $lname = $_SESSION["lname"];
        $avatar = $_SESSION["avatar"];
        $password = $_SESSION["password"];
        $ip=$_SERVER['REMOTE_ADDR'];
    if (isset($_POST["submitted"]) && $_POST["submitted"])
   {

    $uid = $_POST["userid"];
    $sort= $_POST["sort"];
    $number=$_POST["number"];
    if (empty($sort)) {
        header("Location: HomePage.php");
        $db->close();
        exit();
    }
    $db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }

    if($sort=="title"){

    $q = " SELECT * FROM  Movies ORDER BY $sort ASC LIMIT $number";

    }
    else if($sort=="year")
    {

        $q = " SELECT * FROM  Movies ORDER BY $sort DESC LIMIT $number";

    }
    $state="Top ".$number." movies by ".$sort. "";
    $r = $db->query($q);
   }


   else if (isset($_POST["submitted2"]) && $_POST["submitted2"])
   {

    $uid = $_POST["userid"];
    $origin=$_POST["origin"];
    $genre=$_POST["genre"];
    if (empty($origin) && empty($genre)) {
        header("Location: HomePage.php");
        $db->close();
        exit();
    }
    $db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }


    if($origin!="select" && $genre!="select"){
        $state="Top ".$origin." ".$genre. " movies list: ";
        //echo $state;
        $q = " SELECT * FROM  Movies where origin LIKE '%$origin%' AND genre LIKE '%$genre%'";


    }
    else if($origin=="select" && $genre!="select")
    {
        $state="Top ".$genre. " movies list: ";
        $q = " SELECT * FROM  Movies where genre LIKE '%$genre%'";

    }
    else if($origin!="select" && $genre=="select")
    {
        $state="Top ".$origin. " movies list: ";
        $q = " SELECT * FROM  Movies where origin LIKE '%$origin%'";


    }
    else{
        header("Location: HomePage.php");
        $db->close();
        exit();
    }
    $r = $db->query($q);
   }

   else if (isset($_POST["submitted3"]) && $_POST["submitted3"])
   {

    $uid = $_POST["userid"];
    $search= $_POST["search"];
    $db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }


    $q = " SELECT * FROM  Movies where title LIKE '%$search%' OR genre LIKE '%$search%' OR year LIKE '%$search%' OR origin LIKE '%$search%'";
    $r = $db->query($q);
    $state="Your top Search Results for ".$search. " are: ";


   }

//    else if (isset($_POST["submitted5"]) && $_POST["submitted5"])
//    {
//     $mid= $_POST["mid"];
//     $db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
//     if ($db->connect_error)
//     {
//         die ("Connection failed: " . $db->connect_error);
//     }
//     $q7= "SELECT wid from Watchlists where uid='$uid' AND name='Default Watchlist'";
//     $r7= $db->query($q7);
//     $row7=$r7->fetch_assoc();
//    // echo $row7['wid'];
//     //echo $mid;
//     $q1 = " INSERT INTO Entries(wid,mid,dateAdded) VALUES($row7[wid],$mid,now())";
//     $r1 = $db->query($q1);

//     $q = " SELECT * FROM Ratings where uid=$uid ORDER BY rating DESC LIMIT 15";
//     $r = $db->query($q);
//     $state="Top rated movies by ".$fname;
//     if(mysqli_num_rows($r)<=0)
//     {
//         $q = " SELECT * FROM Movies ORDER BY title LIKE '%an%' DESC LIMIT 15";
//         $r = $db->query($q);
//         $state="You haven't Rated any movie yet. Here is a selection to choose from: ";

//     }

//    }

	else if(isset($_SESSION["email"]))
	{

        //gotten all the variable values from the form submission through session variable

    //close the connection
   // mysql_close($db);


		// load the database and get the orders for this user
		$db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
	  	if ($db->connect_error) {
	  		die ("Connection failed: " . $db->connect_error);
		}



		$q = " SELECT * FROM Ratings where uid=$uid ORDER BY rating DESC LIMIT 15";
        $r = $db->query($q);
        $state="Top rated movies by ".$fname;
        if(mysqli_num_rows($r)<=0)
        {
            $q = " SELECT * FROM Movies ORDER BY title LIKE '%an%' DESC LIMIT 15";
            $r = $db->query($q);
            $state="You haven't Rated any movie yet. Here is a selection to choose from: ";

        }
        //INSERT INTO who (uid,uname,time,IPAddress) VALUES(32435,"sdfd",now(),"565");
        //INSERT INTO who (uid,uname,time) VALUES(1234,"harnoor","645 4");
        $q6 = "INSERT INTO who (uid,uname,time,IPAddress) VALUES('$_SESSION[uid]','$_SESSION[username]',now(), '$ip')";
		$r6 = $db->query($q6);
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
        <title>homepage</title>
        <link rel=stylesheet href="stylesheet.css">
        <script src="add_movie.js"></script>
        <script type="text/javascript" src="validatehomepage.js"></script>
        <script type="text/javascript" src="validate2.js"> </script>
        <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
        <script src="scripts.js"></script>



    </head>
    <body>
       <header>

        <h1 >Cinema Bazaar: Browse, Rate and Personalize<br>&emsp;&ensp;&emsp;&emsp; &emsp;&emsp;&emsp;Your Movie Collection</h1>

    </header>

    <nav>

        <button class="button" style="align-content: center;"><a href="HomePage.php">Home</a></button>
        <button class="button" style="align-content: center;"><a href="watchlistdir.php"> Watchlists</a></button>
        <form id="SearchBar">
            <input name="search" style="font-size:16pt;" type="text" placeholder="Search for media here" id="search_text" />
        </form>
        <script src="events.js"></script>

        <div class="grid-containerx" id="image_data">
</div>

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


    <main>

<form id="search" class="form" action="HomePage.php" method="post">
    <h2>Filter Movie Database:</h2>
    <input type="hidden" name="submitted2" value="1"/>
    <input type="hidden" name="userid" value="<?=$uid?>"/>
    <label> Origin: </label>
    <select style="width:120px;" name="origin">
    <option value="select">select</option>
    <option value="American">American</option>
    <option value="Australian">Australian</option>
    <option value="Bollywood">Bollywood</option>
    <option value="British">British</option>
    <option value="Canadian">Canadian</option>
    <option value="Chinese">Chinese</option>
    <option value="Japanese">Japanese</option>
    <option value="Punjabi">Punjabi</option>
    <option value="Russian">Russian</option>
    </select>
    <label> Genre: </label>
    <select style="width:120px;" name="genre">
    <option value="select">select</option>
    <option value="action">action</option>
    <option value="adventure">adventure</option>
    <option value="biography">biography</option>
    <option value="comedy">Comedy</option>
    <option value="crime">crime</option>
    <option value="drama">drama</option>
    <option value="family">family</option>
    <option value="fantasy">fantasy</option>
    <option value="horror">horror</option>
    <option value="musical">musical</option>
    <option value="mystery">mystery</option>
    <option value="patriotic">patriotic</option>
    <option value="romance">romance</option>
    <option value="sci-fi">sci-fi</option>
    <option value="social">social</option>
    <option value="sports">sports</option>
    <option value="spy">spy</option>
    <option value="suspense">suspense</option>
    <option value="thriller">thriller</option>
    <option value="war">war</option>
    <option value="western">western</option>
    <option value="wuxia">wuxia</option>
    <option value="zombie">zombie</option>
    </select>
    <input class="button" type="submit" style="align-content: center;">

</form>
<form class="form" id="sort" action="HomePage.php" method="post">
                        <h2>Sort Movie Database: </h2>
                        <input type="hidden" name="submitted" value="1"/>
                        <input type="hidden" name="userid" value="<?=$uid?>"/>
                        <input type="radio" name="sort" value="year">By Year
                        <input type="radio" name="sort" value="title">By Title
                        <input style="align-content: center;" class="button" type="submit">
                        <br><label> Display </label>
    <select style="width:120px;" name="number">
    <option value="15">15</option>
    <option value="25">25</option>
    <option value="35">35</option>
    <option value="50">50</option>
    <option value="75">75</option>
    <option value="100">100</option>
    <option value="150">150</option>

    </select>
    <label> sorted movies </label>
</form>


<p id="search" style="background-color:#B73225">
<?=$state?><br>:


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
        <?

$q7= "SELECT wid from Watchlists where uid='$uid' AND name='Default Watchlist'";
$r7= $db->query($q7);
$row7=$r7->fetch_assoc();
        $q8="SELECT * FROM Entries where wid=$row7[wid] AND mid=$row2[mid]";
        $r8=$db->query($q8);

        if($r8->fetch_assoc()<=0){
        ?>

        <button name="add" style="font-size:10pt; border-radius: 2px; background-color:
        rgb(151, 132, 132);" class="add" type="button" id="<?=$row2['mid']?>">&#43;watchlist</button>
<?}
else
{?>
<br>
       <input  style="font-size:10pt; border-radius: 2px; background-color: rgb(151, 132, 132);" type="submit" value="&#10003;watchlist" />
<?}?>


   </div>
           <?
       }

   }
else{
    ?>

    <p style="color:red; background-color:black">List Empty. No records found <br></p>
<?}
?>
 <script src="add_movie_event.js"></script>
<?php
	$db->close();
?>
    </div>
    </p>
    </main>

</body>

</html>
