<?php 
session_start();
include("database/db_connect.php"); 

$userId = $_SESSION['userid'] ?? null;

if (!$userId) {
    echo "<script>alert('Please login first'); window.location.href='login.php';</script>";
    exit;
}

$query = "SELECT name, email, roletype FROM user WHERE userid='$userId' LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<script>alert('User not found'); window.location.href='login.php';</script>";
    exit;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Profile</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
body {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #1a1c2c, #2a3a6d);
}
.profile-card {
    background: #ffffff;
    width: 400px;
    border-radius: 16px;
    padding: 40px 30px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    text-align: center;
    position: relative;
}
.profile-card::before {
    content: '';
    position: absolute;
    top: -50px;
    left: -50px;
    width: 500px;
    height: 500px;
    background: rgba(69, 243, 255, 0.15);
    border-radius: 50%;
    z-index: 0;
}
.profile-card h2 {
    color: #0d1f4c;
    margin-bottom: 10px;
    font-size: 1.8em;
    z-index: 1;
    position: relative;
}
.profile-card p {
    color: #3a3a3a;
    margin: 6px 0;
    font-size: 1em;
    z-index: 1;
    position: relative;
}
.profile-card .info {
    margin-top: 20px;
    text-align: left;
}
.profile-card .info div {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #e0e0e0;
}
.profile-card .info div:last-child { border-bottom: none; }
.profile-card .info div span { font-weight: 500; color: #0d1f4c; }
.profile-card .info div strong { color: #1e3a8a; }
.edit-btn {
    margin-top: 25px;
    display: inline-block;
    text-decoration: none;
    background: linear-gradient(90deg, #45f3ff, #1e3a8a);
    color: #fff;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
}
.edit-btn:hover {
    background: linear-gradient(90deg, #1e3a8a, #45f3ff);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
</style>
</head>
<body>

<div class="profile-card">
    <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?></h2>
    <div class="info">
        <div><span>Full Name:</span> <strong><?php echo htmlspecialchars($user['name']); ?></strong></div>
        <div><span>Email:</span> <strong><?php echo htmlspecialchars($user['email']); ?></strong></div>
        <div><span>Role:</span> <strong><?php echo htmlspecialchars($user['roletype']); ?></strong></div>
    </div>
    <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
</div>

</body>
</html>
