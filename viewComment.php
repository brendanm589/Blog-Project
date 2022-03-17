<?php
	//from winscp
	require('mysqli_connect.php');
	session_start();
	
	$q4 = 'SELECT users.name, comments.comment_body, comments.time FROM comments INNER JOIN users INNER JOIN posts ON 
	posts.postid = comments.postid && users.userid = comments.userid WHERE comments.postid = ?';

	$stmt4 = mysqli_prepare($dbc, $q4);
	mysqli_stmt_bind_param($stmt4, 'i', $_GET['pid']);
	mysqli_stmt_execute($stmt4);                                  //pull comments from the database according to the postid
	mysqli_stmt_store_result($stmt4);
	mysqli_stmt_bind_result($stmt4, $uname2, $cbody, $ctime);
	$rows4 = mysqli_stmt_num_rows($stmt4);
	
	if($rows4 > 0)
	{
		while(mysqli_stmt_fetch($stmt4))
		{
			echo "<table border=1 align='center' width=50%>";
			echo "<tr>";
			echo "<td width=33%>$uname2</td>";       //print the comments in a table
			echo "<td width=34%>$cbody</td>";
			echo "<td width=33%>$ctime</td>";
			echo "</tr>";
			echo "</table>";
		}
	}
	else
	{
		echo "<p align='center'>There are no comments for this post.</p>";
	}
?>