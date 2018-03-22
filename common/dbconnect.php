<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$db = "balsasaniugan";
	// Create connection
	$conn = new mysqli($servername, $username, $password,$db);
	// Check connection
	if ($conn->connect_error) {
	    echo "DatabaseConnectionError";
	    die("Connection failed: " . $conn->connect_error);
	}
?>