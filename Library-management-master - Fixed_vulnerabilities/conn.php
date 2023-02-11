<?php
	 //$con=mysql_connect('localhost','root','37890fhasd') or die(mysql_error());
	 //mysql_select_db('library') or die("cannot select DB");


//Example 03

//Vulnerable code

	$mysqli = new mysqli('localhost','root','','library');

//Modified code

  $host = getenv('DB_HOST');
  $username = getenv('DB_USERNAME');
  $password = getenv('DB_PASSWORD');
  $dbname = getenv('DB_NAME');

  $mysqli = new mysqli($host, $username, $password, $dbname);

//Modified code end

	if($mysqli->connect_error)
	{
		die('Connection Error('.$mysqli->connect_errno.')'.$mysqli->connect_error);
	}


?>