<?php 
	//from winscp
	require('mysqli_connect.php');
	session_start();
	
	if(isset($_POST['addPost']))
	{
		$title = htmlspecialchars(trim($_POST['title']));
		$posting = htmlspecialchars(trim($_POST['posting']));
		if(empty($title))
		{
			echo "Please enter a title." . "<br><br>";
		}
		if(empty($posting))
		{
			echo "Post field cannot be empty." . "<br><br>";  //make sure neither field is empty
		}
		if(empty($title) || empty($posting))
		{
			echo "<a href='addBlogPosting.html'>Back to Post Submission</a>" . "<br><br>";  //add a link back to the post submission page 
		}                                                                                   //if they left something empty
		
		if(@$_SESSION['loggedin'] == true)  //can only post if logged in
		{
			if(!empty($title) && !empty($posting))
			{
				$q3 = 'INSERT INTO posts (title, post_body, userid, time) VALUES (?, ?, ?, NOW())';
	
				$stmt3 = mysqli_prepare($dbc, $q3);
				mysqli_stmt_bind_param($stmt3, 'ssi', $title, $posting, $_SESSION['uid']);   //if nothing is empty, insert the post into 
				mysqli_stmt_execute($stmt3);                                                 //the database
				if(mysqli_stmt_affected_rows($stmt3) == 1)
				{
					echo "<h2>Your post has been submitted!</h2>";
					echo "<a href='index.php'>Back to Home Page</a>";  //link to homepage if successful
				}
				else        
				{
					echo "<h2>Something went wrong. Please try again.</h2>";
					echo "<a href='addBlogPosting.html'>Back to Post Submission</a>";  //link back to submission page if unsuccessful
				}
			}
		}
		else
		{
			echo "<h2>You must login in order to post.</h2>";
		}
	}
			
?>