<?php

	/* checks database connected safely or not*/
	// Database connection
	$conn = new mysqli('localhost','root','','login');
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
		if(mysqli_num_rows($result) == 0){
			echo "There is no account with this email, Please Sign up.".'<br>'.'<a href = "Register.html">Sign Up</a>';
		}
		else if($row['password'] != $password){ 
			echo "Incorrect Username/password.".'<br>'.'<a href = "ForgetPassword.html">Forgot Password</a>';
		}else
			echo "Welcome ".$row['firstname']." ".$row['lastname']." :)"; //Welcome msg
		
	}
	
	/*Register */
	else if(isset($_POST['register'])){
		//echo $url.'<br>';

		$firstName = $_POST['FirstName'];
		$lastName = $_POST['LastName'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$number = $_POST['mobile'];

		$sql_email = "SELECT * FROM registration WHERE email = '$email'";
		$res_email = mysqli_query($conn, $sql_email);

		if(mysqli_num_rows($res_email) > 0){ //If Account exixted with same email.
			echo "Account Exist already....".'<br>'.'<a href = "login.html">login</a>';
		}else{ //Else, Insert data into database;
			$stmt = $conn->prepare("insert into registration(firstname, lastname, email, password, number) 
				values(?, ?, ?, ?, ?)");

			$stmt->bind_param("ssssi", $firstName, $lastName, $email, $password, $number);
			$stmt->execute(); 

			echo "Registered Successfully...".'<br>'."For password recovery please proceed....".'<a href = "recoverySet.html">Set Recovery</a>';	

			$stmt->close();
		}
	}

	/* For setting password recovery*/
	if(isset($_POST['recoverySet'])){
		$email = $_POST['email'];
		$nickname = $_POST['nickname'];
		$player = $_POST['favplayer'];

		/* Updates those recovery fields which are initially null by default.*/
		$query = "UPDATE registration SET nickname = '$nickname', favcricketplayer = '$player' WHERE email = '$email'";
		mysqli_query($conn, $query);

		echo "Recovery set done Successfully....".'<br>'."You can Login now ".'<a href = "login.html">Login</a>';
		
	}
	
	/*Forgot Password*/
	else if(isset($_POST['forget_password'])){
		$email = $_POST['email'];
		$nickname = $_POST['nickname'];
		$player = $_POST['favplayer'];

		$query = "SELECT nickname, favcricketplayer ,password FROM registration WHERE email = '$email'";
		$result = mysqli_query($conn,$query);

		$row = mysqli_fetch_assoc($result);

		/* checks whether both questions are correct regarding user in databse.*/
		if($row['nickname'] == $nickname and $row['favcricketplayer'] == $player){
			echo "Your password is [".$row['password']."].".'<br>'.'<a href = "login.html">Login</a>';
		}else{
			echo "Tyr in another way";
		}
	}

	$conn->close();
?>
