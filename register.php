<?php 
include("database/db_connect.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    if (!empty($name) && !empty($email) && !empty($password)) {
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $checkEmailQuery = "SELECT * FROM user WHERE email='$email' LIMIT 1";
        $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

        if ($checkEmailResult === false) {
            die("Database query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($checkEmailResult) > 0) {
            echo "<script>alert('Email already registered! Please login.'); window.location.href='login.php';</script>";
        } else {
            $insertQuery = "INSERT INTO user (name, email, password, roletype) 
                            VALUES ('$name', '$email', '$hashedPassword', 'user')";
            $insertResult = mysqli_query($conn, $insertQuery);

            if ($insertResult) {
                echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Registration failed: " . mysqli_error($conn) . "');</script>";
            }
        }
    } else {
        echo "<script>alert('All fields are required!');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register Form</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
		* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
		body {
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			background: #23242a;
		}
		.box {
			position: relative;
			width: 400px;
			height: 520px;
			background: #1c1c1c;
			border-radius: 8px;
			overflow: hidden;
		}
		.box::before, .box::after {
			content: '';
			z-index: 1;
			position: absolute;
			top: -50%;
			left: -50%;
			width: 400px;
			height: 520px;
			transform-origin: bottom right;
			background: linear-gradient(0deg,transparent,#45f3ff,#45f3ff);
			animation: animate 6s linear infinite;
		}
		.box::after { animation-delay: -3s; }
		@keyframes animate { 
			0% { transform: rotate(0deg); } 
			100% { transform: rotate(360deg); } 
		}
		form {
			position: absolute;
			inset: 2px;
			background: #28292d;
			padding: 50px 40px;
			border-radius: 8px;
			z-index: 2;
			display: flex;
			flex-direction: column;
		}
		h2 {
			color: #45f3ff;
			font-weight: 500;
			text-align: center;
			letter-spacing: 0.1em;
		}
		.inputBox { position: relative; width: 100%; margin-top: 35px; }
		.inputBox input {
			position: relative; width: 100%; padding: 20px 10px 10px;
			background: transparent; outline: none; border: none;
			color: #fff; font-size: 1em; letter-spacing: 0.05em;
			transition: 0.5s; z-index: 10;
		}
		.inputBox span {
			position: absolute; left: 0; padding: 20px 0 10px;
			pointer-events: none; font-size: 1em; color: #8f8f8f; transition: 0.5s;
		}
		.inputBox input:valid ~ span, 
		.inputBox input:focus ~ span {
			color: #45f3ff; 
			transform: translateY(-34px); 
			font-size: 0.75em;
		}
		.inputBox i {
			position: absolute; left: 0; bottom: 0; width: 100%; height: 2px;
			background: #45f3ff; border-radius: 4px; transition: 0.5s; pointer-events: none; z-index: 9;
		}
		.inputBox input:valid ~ i, 
		.inputBox input:focus ~ i { height: 44px; }
		input[type="submit"] {
			border: none; outline: none; padding: 11px 25px;
			background: #45f3ff; cursor: pointer; border-radius: 4px;
			font-weight: 600; width: 100%; margin-top: 20px;
		}
		input[type="submit"]:active { opacity: 0.8; }
	</style>
</head>
<body>
	<div class="box">
		<form method="POST" action="">
			<h2>Register</h2>

			<div class="inputBox">
				<input type="text" name="name" required="required">
				<span>Full Name</span>
				<i></i>
			</div>

			<div class="inputBox">
				<input type="email" name="email" required="required">
				<span>Email</span>
				<i></i>
			</div>

			<div class="inputBox">
				<input type="password" name="password" required="required">
				<span>Password</span>
				<i></i>
			</div>

			<input type="submit" value="Register">
		</form>
	</div>
</body>
</html>
