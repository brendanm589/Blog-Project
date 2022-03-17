<html>
	<head>
		<title>Some Nonsense</title>
	</head>
</html>
<?php 
	//from winscp
	require('mysqli_connect.php');
	session_start();
	
	if(@$_SESSION['loggedin'] == false)
	{
		echo "<a href='login.html'>Login</a> &nbsp &nbsp";  //if logged in is false, link to login page
		echo "<a href='register.html'>Register</a>";
	}
	else
	{
		echo "<a href='addBlogPosting.html'>Write Post</a> &nbsp &nbsp";  //if logged in is true, link to post submission page
		echo "<a href='logout.php'>Logout</a>";                           //or to logout page
	} 
	
	echo "<h1 align='center'>Some Nonsense</h1>";
	echo "<br>";
	
	if(isset($_GET['page']))
	{
		@$pageno = $_GET['page'];
		$startpos = ($_GET['page'] - 1) * 5;
	}                                            
	else
	{
		@$pageno = $_GET['page'];
		$startpos = 0;
	}
	
	$q = 'SELECT users.name, posts.post_body, posts.time, posts.postid FROM users INNER JOIN posts ON users.userid = posts.userid ORDER BY time DESC LIMIT ?,5';
	
	$stmt = mysqli_prepare($dbc, $q);
	mysqli_stmt_bind_param($stmt, 'i', $startpos);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);                                           //pull name, post, and time from database
	mysqli_stmt_bind_result($stmt, $uname, $pbody, $ptime, $_SESSION['pid']);
	$rows = mysqli_stmt_num_rows($stmt);
	
	if($rows > 0)
	{
		while(mysqli_stmt_fetch($stmt))
		{
			echo "<table border=1 align='center' width=50%>";
			echo "<tr>";
			echo "<td width=33%><b>$uname</b></td>";               //print the post results in a table
			echo "<td width=34%><b>$pbody</b></td>";               //followed by the comments if there are any
			echo "<td width=33%><b>$ptime</b></td>";
			echo "</tr>";
			echo "<tr colspan=3>";
			$_GET['pid'] = $_SESSION['pid'];	
			echo "<td><a href='viewComment.php?pid=$_SESSION[pid]'>Comments</a></td>";		
			echo "</tr>";
			echo "</table>";
			echo "<br> <br>";
			echo "<hr width=75%>";
			echo "<br><br>";
		}
	}
	else
	{
		echo "<p align='center'>There are no posts to show.</p>";
	}
	
	echo "<br>";
	
	if($pageno == "")
	{
		$pageno = 1;
	}
	
	if($pageno == 1)
	{
		$pageno++;                                                                 //add paging to show 5 posts at a time
		echo "<p align='center'><a href='?page=$pageno'>Next Page</a></p>";        //starting with the most recent
	}
	
	elseif($pageno > 1 && $rows !== 0)
	{
		$pageno--;
		echo "<p align='center'><a href='?page=$pageno'>Previous Page</a>" . "&nbsp &nbsp";
		$pageno++;
		$pageno++;
		echo "<a href='?page=$pageno'>Next Page</a></p>";
	}
	
	elseif($pageno > 1 && $rows == 0)
	{
		$pageno--;
		echo "<p align='center'><a href='?page=$pageno'>Previous Page</a></p>";
	}
?>