<?php
	$firstName = $_POST['FirstName'];
	$lastName = $_POST['LastName'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$number = $_POST['mobile'];

	// Database connection
	$conn = new mysqli('localhost','root','','data');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into registration(firstName, lastName, email, password, number) 
			values(?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssi", $firstName, $lastName, $email, $password, $number);
		$stmt->execute(); 
		echo "Registration successfully...";
		$stmt->close();
		$conn->close();
	}
?>