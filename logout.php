<?php 
session_start();
// delete all of the session variables
$_SESSION = array();
session_destroy();
	

header("Location: loginpage.php");
exit();

?>