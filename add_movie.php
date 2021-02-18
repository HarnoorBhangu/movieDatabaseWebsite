<?php
    session_start();
        $uid= $_SESSION["uid"];
	$db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
    
    //echo "hello";
	if ($db -> connect_error) {
	   die ("Connection failed: " . $db -> connect_error);
	}

	$q7= "SELECT wid from Watchlists where uid='$uid' AND name='Default Watchlist'";
    $r7= $db->query($q7);
    $row7=$r7->fetch_assoc();
   
    $q1 = " INSERT INTO Entries(wid,mid,dateAdded) VALUES($row7[wid],$_POST[mid],now())";

    if($db->query($q1)){
   echo 1;
   exit;
    }
      
	$db->close();
?>