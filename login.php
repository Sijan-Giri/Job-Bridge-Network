<?php
session_start();
include("database/db_connect.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM user WHERE email='$username' OR name='$username' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['userid'] = $user['userid'];
                $_SESSION['username'] = $user['name'];
                $_SESSION['roletype'] = $user['roletype'];

                header("Location: index.php");
                exit;
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "User not found!";
        }
    } else {
        $error = "All fields are required!";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Animated Login Form</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{display:flex;justify-content:center;align-items:center;min-height:100vh;flex-direction:column;background:#23242a;}
.box{position:relative;width:380px;height:420px;background:#1c1c1c;border-radius:8px;overflow:hidden;}
.box::before,.box::after{content:'';z-index:1;position:absolute;top:-50%;left:-50%;width:380px;height:420px;transform-origin:bottom right;background:linear-gradient(0deg,transparent,#45f3ff,#45f3ff);animation:animate 6s linear infinite;}
.box::after{animation-delay:-3s;}
@keyframes animate{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}
form{position:absolute;inset:2px;background:#28292d;padding:50px 40px;border-radius:8px;z-index:2;display:flex;flex-direction:column;}
h2{color:#45f3ff;font-weight:500;text-align:center;letter-spacing:0.1em;}
.inputBox{position:relative;width:300px;margin-top:35px;}
.inputBox input{position:relative;width:100%;padding:20px 10px 10px;background:transparent;outline:none;box-shadow:none;border:none;color:#23242a;font-size:1em;letter-spacing:0.05em;transition:0.5s;z-index:10;}
.inputBox span{position:absolute;left:0;padding:20px 0px 10px;pointer-events:none;font-size:1em;color:#8f8f8f;letter-spacing:0.05em;transition:0.5s;}
.inputBox input:valid ~ span,input:focus ~ span{color:#45f3ff;transform:translateX(0px) translateY(-34px);font-size:0.75em;}
.inputBox i{position:absolute;left:0;bottom:0;width:100%;height:2px;background:#45f3ff;border-radius:4px;overflow:hidden;transition:0.5s;pointer-events:none;z-index:9;}
.inputBox input:valid ~ i,input:focus ~ i{height:44px;}
.links{display:flex;justify-content:space-between;}
.links a{margin:10px 0;font-size:0.75em;color:#8f8f8f;text-decoration:none;}
.links a:hover,.links a:nth-child(2){color:#45f3ff;}
input[type="submit"]{border:none;outline:none;padding:11px 25px;background:#45f3ff;cursor:pointer;border-radius:4px;font-weight:600;width:100px;margin-top:10px;}
input[type="submit"]:active{opacity:0.8;}
.error-msg{color:#ff4d4f;text-align:center;margin-bottom:10px;}
</style>
</head>
<body>

<div class="box">
    <form method="POST" autocomplete="off">
        <h2>Login</h2>

        <?php if(!empty($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="inputBox">
            <input type="text" name="username" required="required">
            <span>Username / Email</span>
            <i></i>
        </div>

        <div class="inputBox">
            <input type="password" name="password" required="required">
            <span>Password</span>
            <i></i>
        </div>

        <div class="links">
            <a href="#">Forgot Password ?</a>
            <a href="register.php">Signup</a>
        </div>

        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>
