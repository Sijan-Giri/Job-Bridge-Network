<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('database/db_connect.php');

$roletype = '';
if (isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];
    $res = $conn->query("SELECT roletype FROM user WHERE userid = $user_id LIMIT 1");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $roletype = $row['roletype']; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job-Bridge-Network</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background: #f5f7fb;
      padding-top: 90px;  
    }

    .container {
      margin-bottom: 40px; 
    }

    nav.navbar {
      background: linear-gradient(135deg, rgba(30,60,114,0.85), rgba(42,82,152,0.85));
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      height: 75px;
      border-bottom: 1px solid rgba(255,255,255,0.15);
      box-shadow: 0 8px 30px rgba(0,0,0,0.25);
      transition: all 0.5s ease;
      margin-bottom: 20px;
    }

    nav.navbar:hover {
      background: linear-gradient(135deg, rgba(0,123,255,0.9), rgba(42,82,152,0.9));
      transform: scale(1.01);
    }

    .navbar-brand {
      display: flex;
      align-items: center;
      height: 75px;
      padding: 0;
    }

    .brand-text {
      font-weight: 800;
      font-size: 1.8rem;
      color: #fff;
      letter-spacing: 1px;
      background: linear-gradient(90deg, #ffdd57, #fff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: shine 3s infinite linear;
    }

    @keyframes shine {
      from { background-position: -200px; }
      to { background-position: 200px; }
    }

    .navbar-nav .nav-link {
      color: #fff !important;
      margin: 0 10px;
      font-weight: 500;
      font-size: 1.05rem;
      position: relative;
      transition: all 0.3s ease;
    }

    .navbar-nav .nav-link::after {
      content: '';
      position: absolute;
      bottom: -6px;
      left: 0;
      width: 0%;
      height: 3px;
      background: #ffdd57;
      border-radius: 5px;
      transition: width 0.3s ease;
    }

    .navbar-nav .nav-link:hover::after {
      width: 100%;
    }

    .navbar-nav .nav-link:hover {
      color: #ffdd57 !important;
      transform: translateY(-3px);
      text-shadow: 0 0 6px rgba(255,221,87,0.7);
    }

    .profile-circle {
      width: 48px;
      height: 48px;
      background: rgba(255,255,255,0.95);
      color: #1e3c72;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      border: 2px solid #fff;
      transition: all 0.4s ease;
      animation: pulseGlow 2.5s infinite;
      overflow: hidden;
    }

    .profile-circle:hover {
      transform: rotate(10deg) scale(1.1);
      box-shadow: 0 0 20px rgba(255,255,255,0.8);
    }

    .profile-circle img {
      width: 100%;
      height: 100%;
      object-fit: cover; 
      border-radius: 50%; 
    }

    .profile-dropdown {
      position: absolute;
      top: 75px;
      right: 0;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(0,0,0,0.05);
      box-shadow: 0 12px 30px rgba(0,0,0,0.2);
      border-radius: 14px;
      display: none;
      min-width: 180px;
      animation: fadeInUp 0.4s ease;
      transform-origin: top right;
      z-index: 1000;
    }

    .profile-dropdown a {
      display: block;
      padding: 12px 20px;
      color: #333;
      text-decoration: none;
      font-size: 1rem;
      transition: all 0.3s ease;
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .profile-dropdown a:last-child {
      border-bottom: none;
    }

    .profile-dropdown a:hover {
      background: #007bff;
      color: #fff;
      padding-left: 28px;
    }

    .profile-container {
      position: relative;
      margin-left: 1rem;
    }

    @keyframes fadeInUp {
      0% {opacity: 0; transform: translateY(20px);}
      100% {opacity: 1; transform: translateY(0);}
    }

    @keyframes pulseGlow {
      0% {box-shadow: 0 0 0 rgba(255,255,255,0.5);}
      50% {box-shadow: 0 0 25px rgba(255,255,255,0.9);}
      100% {box-shadow: 0 0 0 rgba(255,255,255,0.5);}
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <span class="brand-text">Job-Seeker</span>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <?php if (!isset($_SESSION['userid'])): ?>
          <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
          <li class="nav-item"><a href="register.php" class="nav-link">Register</a></li>
        <?php else: ?>
          <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>

          <?php if ($roletype === 'admin'): ?>
              <li class="nav-item"><a href="viewjobs.php" class="nav-link">View Jobs</a></li>
              <li class="nav-item"><a href="viewusers.php" class="nav-link">View Users</a></li>
              <li class="nav-item"><a href="categories.php" class="nav-link">Categories</a></li>

          <?php elseif ($roletype === 'user'): ?>
              <li class="nav-item"><a href="resume.php" class="nav-link">Upload Resume</a></li>

          <?php elseif ($roletype === 'employee'): ?>
              <li class="nav-item"><a href="jobs.php" class="nav-link">Post Jobs</a></li>
              <li class="nav-item"><a href="viewapplications.php" class="nav-link">View Applications</a></li>
          <?php endif; ?>

          <li class="nav-item profile-container">
            <div class="profile-circle" id="profileCircle">
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Circle-icons-profile.svg/768px-Circle-icons-profile.svg.png" alt="profile">
            </div>
            <div class="profile-dropdown" id="profileDropdown">
              <a href="profile.php">Profile</a>
              <a href="logout.php">Logout</a>
            </div>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
  const profileCircle = document.getElementById('profileCircle');
  const profileDropdown = document.getElementById('profileDropdown');

  if(profileCircle) {
    profileCircle.addEventListener('click', () => {
      profileDropdown.style.display = 
        profileDropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function(event) {
      if (!profileCircle.contains(event.target) && !profileDropdown.contains(event.target)) {
        profileDropdown.style.display = 'none';
      }
    });
  }
</script>

</body>
</html>
