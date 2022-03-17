<?php
	//from winscp
	session_start();
	
	$_SESSION['loggedin'] = false;
	$_SESSION = [];
	session_destroy();
	setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0);
	
	echo "<h2>You have successfully logged out</h2>" . "<br>";
	echo "<a href='index.php'>Back to Home Page</a>";
	
	//set logged in to false, clear the session variables, and destroy the session to log out
?>