<?php
	session_start();
    $uid= $_SESSION["uid"];
        $email = $_SESSION["email"];
        $username = $_SESSION["username"];
        $fname = $_SESSION["fname"];
        $lname = $_SESSION["lname"];
        $avatar = $_SESSION["avatar"];
        $password = $_SESSION["password"];
    $db = new mysqli("localhost", "hbi701", "qwerty", "hbi701");
	
	if ($db -> connect_error) {
	   die ("Connection failed: " . $db -> connect_error);
	}

    $q = $_GET['q'];
    if(!empty($q) && $q!=" "&& $q!="  "&& $q!="  ")
    {
    $query="SELECT * FROM  Movies where title LIKE '%$q%' OR genre LIKE '%$q%' OR year LIKE '%$q%' OR origin LIKE '%$q%' LIMIT 15";
    
    if($result=$db->query($query))
    {

    while($row=$result->fetch_assoc()){

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

       
     
        $output ="<div class=grid-itemx><a href='moviedetail.php?mid=$row2[mid]'>
        <img src='$row2[poster].jpg' alt='movie' style='width:150px;height:200px;'>
        </a><br>$row2[title]($row2[year])<br>
        ";
               
        if($r3->num_rows > 0 )
        {
            $output.="
        <strong>Rated:</strong>"; 
               $i=0; while($i<$row3['rating']){ $output.="&#11088;"; $i=$i+1;}
   
       
        }
        
       else
       { 
        $output.="<strong>No ratings by you</strong>";
  
          
       }

        if($r4->num_rows > 0 )
       {
        $output.="<br>
       <strong>Last Viewed:</strong> <br>
              $row4[timeViewed];
              ";
   }
       else
        {   $output.="<br> <strong>Not viewed yet</strong>";
   
           
        }
        
        
        $q7= "SELECT wid from Watchlists where uid=$uid AND name='Default Watchlist'";
        $r7= $db->query($q7);
        $row7=$r7->fetch_assoc();
        $q8="SELECT * FROM Entries where wid=$row7[wid] AND mid=$row2[mid]";
        $r8=$db->query($q8);

        if($r8->fetch_assoc()<=0){
            $output.="
          <form id='add' action='HomePage.php' method='post'>
               <input type='hidden' name='submitted5' value='1'/>
               <input type='hidden' name='mid' value= $row2[mid] >
               <input  style='font-size:10pt; border-radius: 2px; background-color: rgb(151, 132, 132);' type='submit' value='&#43;watchlist' />
      
       </form>
       ";
}
else
{
    $output.="
<br>
       <input  style='font-size:10pt; border-radius: 2px; background-color: rgb(151, 132, 132);' type='submit' value=&#10003;watchlist />         
";
    }

    $output.="
   </div>
        ";   
        echo $output;
       }
   }
else{
   
    $output.="
   <p style='color:red; background-color:black'>No search results found <br></p>
";
}


       
}

	
	$db->close();
?>


