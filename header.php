<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap-3.1.1.min.css" rel='stylesheet' type='text/css' />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,600,700,800,900' rel='stylesheet' type='text/css'>
<!----font-Awesome----->
<link href="css/font-awesome.css" rel="stylesheet"> 



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job-Bridge</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <style>
    /* Global Styles */
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    /* Style the brand container */
.brand-container {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 5px 10px;
}

.brand-logo {
  width: 40px;  /* Logo size */
  height: auto;
  margin-right: 10px;  /* Space between logo and text */
}

.brand-text {
  font-size: 24px;  /* Font size of the brand name */
  font-weight: 600;  /* Bold text */
  color: #ff9f00;  /* Vibrant brand color */
  letter-spacing: 2px;  /* Slight spacing between letters */
  text-transform: uppercase;  /* Capitalize letters */
  font-family: 'Roboto', sans-serif;
  transition: color 0.3s ease, transform 0.3s ease;
}

/* Hover effect for brand text */
.brand-text:hover {
  color: #003f87;  /* Dark blue color on hover */
  transform: scale(1.1);  /* Slightly increase the size on hover */
}

/* Gradient background for navbar brand on hover */
.navbar-brand:hover {
  background: linear-gradient(to right, #ff9f00, #0056b3);  /* Gradient effect */
  border-radius: 10px;  /* Rounded corners */
  padding: 8px 15px;
}


    .navbar {
      background-color: #0056b3; /* Job-Bridge blue color */
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar-dark .navbar-nav .nav-link {
      color: #fff;
      padding: 14px 20px;
      font-weight: 500;
    }

    .navbar-dark .navbar-nav .nav-link:hover,
    .navbar-dark .navbar-nav .nav-link:focus {
      background-color: #003f87; /* Darker blue for hover */
      color: #ff9f00;
      border-radius: 5px;
    }

    .navbar-dark .navbar-brand img {
      width: 150px; /* Default logo size */
      height: auto;
    }

    .navbar-toggler {
      border: none;
    }

    .navbar-toggler-icon {
      background-color: #fff;
    }

    /* Dropdown Menu */
    .dropdown-menu {
      background-color: #0056b3;
      border-radius: 8px;
      padding: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .dropdown-menu .dropdown-item {
      color: #fff;
      padding: 10px 20px;
    }

    .dropdown-menu .dropdown-item:hover,
    .dropdown-menu .dropdown-item:focus {
      background-color: #ff9f00;
      color: #fff;
      border-radius: 5px;
    }

    .multi-column-dropdown .divider {
      background-color: #444;
      margin: 10px 0;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      .navbar-nav {
        margin-top: 10px;
      }

      .navbar-nav .nav-item {
        padding: 10px;
      }

      .navbar-collapse {
        background-color: #0056b3;
      }

      .navbar-brand {
        margin-left: auto;
        margin-right: auto;
      }

      .navbar-brand img {
        width: 120px; /* Reduced logo size on small screens */
      }
    }

    @media (min-width: 1200px) {
      .navbar-brand img {
        width: 180px; /* Larger logo on bigger screens */
      }
    }
  </style>
</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
    <a class="navbar-brand" href="index.html">
  <div class="brand-container">
    <span class="brand-text">Job-Seeker</span>
  </div>
</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a href="index.php" class="nav-link" id="navbarRecruiters" role="button" aria-haspopup="true" aria-expanded="false">
              Home
            </a>
          </li>
          <li class="nav-item dropdown">
            <a href="viewjobs.php" class="nav-link" id="navbarRecruiters" role="button" aria-haspopup="true" aria-expanded="false">
              View Job
            </a>
          </li>
          <li class="nav-item dropdown">
            <a href="jobs.php" class="nav-link" id="navbarRecruiters" role="button" aria-haspopup="true" aria-expanded="false">
              Add Jobs
            </a>
          </li>
          <li class="nav-item dropdown">
            <a href="categories.php" class="nav-link" id="navbarRecruiters" role="button" aria-haspopup="true" aria-expanded="false">
              Categories
            </a>
          </li>
          <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="resume.html">Upload Resume</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
