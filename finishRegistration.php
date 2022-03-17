<?php
	//from winscp
	require('mysqli_connect.php');
	session_start();
	
	$available = true;
	
	if(isset($_POST['rsubmit']))
	{
		$remail = htmlspecialchars(trim($_POST['remail']));
		$rpassword = htmlspecialchars(trim($_POST['rpassword']));
		$rcpassword = htmlspecialchars(trim($_POST['rcpassword']));
		$rname = htmlspecialchars(trim($_POST['rname']));
		
		if(empty($remail))
		{
			echo "Email field cannot be empty." . "<br><br>";
		}
		if(empty($rpassword))
		{
			echo "Password field cannot be empty." . "<br><br>";
		}
		if(empty($rcpassword))
		{
			echo "Password confirmation field cannot be empty." . "<br><br>";
		}
		if(empty($rname))
		{
			echo "Name field cannot be empty." . "<br><br>";
		}
		if(empty($remail) || empty($rpassword) || empty($rcpassword) || empty($rname))
		{
			echo "<a href='register.html'>Back to Registration Page</a>";
		}
		
		if(!empty($remail) && !empty($rpassword) && !empty($rcpassword) && !empty($rname))
		{
			if($rpassword !== $rcpassword)
			{
				echo "Passwords do not match. Please try again." . "<br><br>";
				echo "<a href='register.html'>Back to Registration Page</a>";
			}
			else 
			{
				$q6 = 'SELECT email AS email FROM users';
				$r6 = mysqli_query($dbc, $q6);
				$num6 = mysqli_num_rows($r6);
				if($num6 > 0)
				{
					while($row6 = mysqli_fetch_array($r6))
					{
						if($row6['email'] == $remail)
						{
							echo "That email address is already in use." . "<br><br>";
							echo "<a href='register.html'>Back to Registration Page</a>";
							$available = false;
							//break;
						}
					}
				}
				if($available == true)
				{
					$q5 = 'INSERT INTO users (password, email, name) VALUES (SHA1(?), ?, ?)';
			
					$stmt5 = mysqli_prepare($dbc, $q5);
					mysqli_stmt_bind_param($stmt5, 'sss', $rpassword, $remail, $rname);
					mysqli_stmt_execute($stmt5);
					if(mysqli_stmt_affected_rows($stmt5) == 1)
					{
						echo "<h2>You are now registered!</h2>";
						echo "<a href='index.php'>Back to Home Page</a>";
					}
					else
					{
						echo "<h2>Something went wrong. Please try again.</h2>";
						echo "<a href='register.html'>Back to Registration Page</a>";
					}
				}
			}
		}
	}
?>