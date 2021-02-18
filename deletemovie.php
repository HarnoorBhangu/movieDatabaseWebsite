<?php
	session_start();
    $uid= $_SESSION["uid"];
       
    $db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
	
	if ($db -> connect_error) {
	   die ("Connection failed: " . $db -> connect_error);
    }
//     $q2 = "SELECT name FROM Watchlists WHERE uid=$uid AND wid=$_POST[image_id]";
//     $r2 = $db->query($q2);

//     $row2=$r2->fetch_assoc();
//     //echo $row2[name];
//     if($row2[name]=="Default Watchlist")
// {
//     echo 0;
//     exit;
// }
// else
// {
    $q1 = " DELETE FROM Watchlists WHERE uid=$uid AND wid=$_POST[image_id]";
    $r1 = $db->query($q1);
    echo 1;
    exit;

// }

	$db->close();
?>


