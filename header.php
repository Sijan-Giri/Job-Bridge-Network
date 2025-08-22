  <script type="application/x-javascript">
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
    function hideURLbar(){ window.scrollTo(0,1); }
  </script>
  <link href="css/bootstrap-3.1.1.min.css" rel='stylesheet' type='text/css' />
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link href="css/style.css" rel='stylesheet' type='text/css' />
  <link href='//fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
  <link href="css/font-awesome.css" rel="stylesheet"> 

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job-Bridge</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/header.css">
    <style>
      /* Premium Navigation Bar */
    /* Fix navbar height */
  .navbar-nav .nav-link:hover,
  .navbar-nav .nav-link:focus {
    background-color: transparent !important; /* remove any blue hover */
    color: #fff; /* keep your text color */
    text-decoration: none; /* optional */
  }

  .navbar-brand {
    display: flex;
    align-items: center;
    height: 70px; /* same as navbar height */
    padding: 0;   /* remove default padding */
  }

  .brand-text {
    font-weight: 700;
    font-size: 1.5rem;
    color: #fff;
    line-height: 70px; /* match navbar height to vertically center */
    display: inline-block;
    transition: all 0.3s; /* smooth hover effects if needed */
  }

  .brand-text:hover {
    color: #fff; /* optional hover effect without affecting height */
  }


      /* Profile Circle */
      .profile-circle {
        width: 40px;
        height: 40px;
        background-color: #fff;
        color: #1e3c72;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        border: 2px solid #fff;
        transition: all 0.3s;
      }

      .profile-circle:hover {
        background-color: #f0f0f0;
      }

      /* Profile Dropdown */
      .profile-dropdown {
        position: absolute;
        top: 60px;
        right: 0;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-radius: 8px;
        overflow: hidden;
        display: none;
        min-width: 150px;
        z-index: 1000;
      }

      .profile-dropdown a {
        display: block;
        padding: 10px 15px;
        color: #333;
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.2s;
      }

      .profile-circle img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* ensures image covers the circle */
  border-radius: 50%; /* keeps image circular */
}


      /* Navbar container adjustment */
      .navbar-nav.ml-auto {
        display: flex;
        align-items: center;
      }

      .profile-container {
        position: relative;
        margin-left: 1rem;
      }
    </style>
  </head>
  <body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="index.php">
          <div class="brand-container">
            <span class="brand-text">Job-Seeker</span>
          </div>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="viewjobs.php" class="nav-link">View Job</a></li>
            <li class="nav-item"><a href="jobs.php" class="nav-link">Add Jobs</a></li>
            <li class="nav-item"><a href="categories.php" class="nav-link">Categories</a></li>
            <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
            <li class="nav-item"><a href="resume.php" class="nav-link">Upload Resume</a></li>

            <li class="nav-item profile-container">
              <div class="profile-circle" id="profileCircle"><img style="height-10px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Circle-icons-profile.svg/768px-Circle-icons-profile.svg.png" alt="profile"></div>
              <div class="profile-dropdown" id="profileDropdown">
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
              </div>
            </li>

          </ul>
        </div>
      </div>
    </nav>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
      const profileCircle = document.getElementById('profileCircle');
      const profileDropdown = document.getElementById('profileDropdown');

      profileCircle.addEventListener('click', () => {
        profileDropdown.style.display = profileDropdown.style.display === 'block' ? 'none' : 'block';
      });

      // Close dropdown when clicking outside
      document.addEventListener('click', function(event) {
        if (!profileCircle.contains(event.target) && !profileDropdown.contains(event.target)) {
          profileDropdown.style.display = 'none';
        }
      });

      <?php
      ?>
    </script>

  </body>
  </html>
