<?php

	/* checks databse connected safely or not*/
	// Database connection
	$conn = new mysqli('localhost','root','','data');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	}

			/*Login */
	if(isset($_POST['sign-in'])){ 
		$email = $_POST['email'];
		$password = $_POST['password'];



		$query = "SELECT firstname, lastname, password FROM registration WHERE email = '$email'";
		
		$result = mysqli_query($conn,$query);
		$row = mysqli_fetch_assoc($result);
		/*Check if the password given is compatible with the password in database.
			if both are equal "Incorrect username/password" msg is prompted
			else, welcome msg should be prompted.*/
		//$length = count($row);
		// if($row['password'] != $password){ 
		// 	echo "Incorrect Username/password.";
		// }else
		echo "Welcome ".$row['firstname']." ".$row['lastname']." :)"; //Welcome msg
		
	}
	
			/*Register */
	else if(isset($_POST['register'])){

		$firstName = $_POST['FirstName'];
		$lastName = $_POST['LastName'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$number = $_POST['mobile'];


		$sql_email = "SELECT * FROM registration WHERE email = '$email'";
		$res_email = mysqli_query($conn, $sql_email);
		if(mysqli_num_rows($res_email) > 0){ //If Account exixted with same email.
			echo "Account Exist already....";
			echo '<a href = "login.html">login</a>';
		}else{ //Else, Insert data into database;
			$stmt = $conn->prepare("insert into registration(firstname, lastname, email, password, number) 
				values(?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssi", $firstName, $lastName, $email, $password, $number);
			$stmt->execute(); 
			echo "Registration successfully...";
			$stmt->close();
			
		}
	}
	$conn->close();
?>
