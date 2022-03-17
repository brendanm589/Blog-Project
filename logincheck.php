<?php
	//from winscp
	require('mysqli_connect.php');
	session_start();
	
	if(isset($_POST['submit']))
	{
		$email = htmlspecialchars(trim($_POST['email']));
		$password = htmlspecialchars(trim($_POST['password']));

		if(empty($email))
		{
			echo "Email field cannot be empty." . "<br><br>";
		}
		if(empty($password))                            //print error messages if fields are empty
		{
			echo "Password field cannot be empty." . "<br><br>";
		}
		if(empty($email) || empty($password))
		{
			echo "<a href='login.html'>Back to Login</a>";  //add link back to login page if either field is empty,
		}                                                       //or if both fields are empty
	
		$q2 = 'SELECT email, password, userid FROM users WHERE email = ? && password = SHA1(?)';
	
		$stmt2 = mysqli_prepare($dbc, $q2);
		mysqli_stmt_bind_param($stmt2, 'ss', $email, $password);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_store_result($stmt2);                                 //pull email address and password from database
		mysqli_stmt_bind_result($stmt2, $em, $pass, $_SESSION['uid']);
		$rows2 = mysqli_stmt_num_rows($stmt2);
		
		if(!empty($email) && !empty($password))
		{
			while(mysqli_stmt_fetch($stmt2))
			{
				if($email == $em && sha1($password) == $pass)
				{
					echo "<h2>You have successfully logged in.</h2>" . "<br>";   //if email and hashed password from the form match the 
					echo "<a href='index.php'>Back to Home Page</a>";            //values from the database, then the user is logged in
					$_SESSION['loggedin'] = true;                                //and there is a link back to home page
				}
			}
				if($email !== $em || sha1($password) !== $pass)
				{
					echo "<h2>Incorrect information has been entered.</h2>" . "<br>";  //if either email or hashed password from the form
					echo "<a href='login.html'>Back to Login</a>";                     //don't match the values from the database, then the
					$_SESSION['loggedin'] = false;                                     //user is not  logged in and there is a link back
				}                                                                      //to the login page
		}
	}
?>