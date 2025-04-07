<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <!-- Stylesheet -->
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #080710;
            font-family: 'Poppins', sans-serif;
        }
        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }
        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }
        .shape:first-child {
            background: linear-gradient(#1845ad, #23a2f6);
            left: -80px;
            top: -80px;
        }
        .shape:last-child {
            background: linear-gradient(to right, #ff512f, #f09819);
            right: -30px;
            bottom: -80px;
        }
        form {
            height: 580px;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
            transition: width 0.3s, height 0.3s;
        }
        form * {
            color: #ffffff;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }
        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
        }
        label {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
        }
        input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }
        ::placeholder {
            color: #e5e5e5;
        }
        button {
            margin-top: 50px;
            width: 100%;
            background-color: #ffffff;
            color: #080710;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }
        .social {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }
        .social div {
            background: red;
            width: 150px;
            border-radius: 3px;
            padding: 5px 10px 10px 5px;
            background-color: rgba(255, 255, 255, 0.27);
            color: #eaf0fb;
            text-align: center;
        }
        .social div:hover {
            background-color: rgba(255, 255, 255, 0.47);
        }
        .social .fb {
            margin-left: 25px;
        }
        .social i {
            margin-right: 4px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .background {
                width: 350px;
                height: 400px;
            }
            form {
                width: 90%;
                height: auto;
                padding: 30px 25px;
            }
            form h3 {
                font-size: 28px;
            }
            button {
                font-size: 16px;
                padding: 12px 0;
            }
            label {
                font-size: 14px;
            }
            input {
                font-size: 12px;
                height: 45px;
            }
        }

        @media (max-width: 480px) {
            .background {
                width: 280px;
                height: 350px;
            }
            form {
                width: 90%;
                padding: 20px 15px;
            }
            form h3 {
                font-size: 24px;
            }
            button {
                font-size: 14px;
                padding: 10px 0;
            }
            input {
                font-size: 12px;
                height: 40px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/admin_login.js" defer></script>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="POST" action="admin_login.php">
        <h3>Admin Login</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Enter username..." name="username   " id="username">

        <label for="email">Email</label>
        <input type="email" placeholder="Enter email..." name="email" id="email">

        <label for="password">Password</label>
        <input type="password" placeholder="Enter password..." name="password" id="password">

        <button type="submit" id="submit">Log In</button>

    </form>
</body>
</html>

<?php
include('connection/connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_username = $_POST['username'];
    $admin_email = $_POST['email'];
    $admin_password = $_POST['password'];

    $query = "SELECT * FROM users WHERE name = '$admin_username' AND email = '$admin_email' AND password = '$admin_password'";
    $result = $connect->query($query);

    if ($result && $result->num_rows > 0) {
        echo "success";
    } else {
        echo "Invalid username or password.";
    }
}
?>

