<?php
// Include the database connection
include('database/db_connect.php');

// Check if the 'id' parameter is set and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $jobId = $_GET['id'];

  // Prepare the SQL query to fetch the job details
  $stmt = $conn->prepare("SELECT j.*, c.name AS catname FROM jobs j LEFT JOIN categories c ON j.catid = c.catid WHERE j.jobid = ?");
  $stmt->bind_param("i", $jobId);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if a job was found
  if ($result && $result->num_rows > 0) {
    $job = $result->fetch_assoc();
  } else {
    $error_message = "Job not found!";
  }

  // Close the statement and connection
  $stmt->close();
} else {
  $error_message = "Invalid job ID.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Job Details</title>

  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .container {
      max-width: 60%;
      margin: 40px auto;
      border-radius: 12px;
      padding: 20px;
      animation: fadeIn 0.5s ease-in-out;
    }

    h1 {
      font-size: 24px;
      color: #111827;
      margin-bottom: 15px;
      font-weight: bold;
    }

    .job-detail {
      margin-bottom: 16px;
    }

    .label {
      font-weight: bold;
      color: #6B7280;
      margin-bottom: 4px;
    }

    .value {
      font-size: 16px;
      color: #374151;
    }

    .category-badge {
      background-color: #10B981;
      color: white;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 14px;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #2563EB;
      color: white;
      font-weight: 600;
      text-decoration: none;
      border-radius: 8px;
      text-align: center;
    }

    .back-link:hover {
      background-color: #1D4ED8;
    }

    /* Card-style product layout */
    .card {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      margin-bottom: 180px;
      width: 70%; /* Makes the card smaller (30% smaller than previous size) */
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .card img {
      width: 100%;
      height: auto;
    }

    .card-body {
      padding: 16px;
      background-color: #fff;
    }

    .price {
      font-size: 18px;
      font-weight: bold;
      color: #374151;
    }

    .card-title {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .description {
      font-size: 14px;
      color: #6B7280;
      margin-bottom: 15px;
    }

    .apply-button {
      background-color: #2563EB;
      color: white;
      font-weight: bold;
      padding: 12px 20px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-align: center;
      width: 100%;
    }

    .apply-button:hover {
      background-color: #1D4ED8;
    }

    /* Fade-In Animation */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      .container {
        padding: 15px;
      }
    }
  </style>
</head>
<body>

<?php include('header.php'); ?>

<div class="container">
  <?php if (isset($job)): ?>
    <div class="card">
      <div class="relative">
        <img class="w-full" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTPsI71bMgiWNRJyrOlqCw2o3XETLqd3weD-Q&s" alt="Job Image">
        <div class="absolute top-0 right-0 bg-red-500 text-white px-2 py-1 m-2 rounded-md text-sm font-medium">HOT JOB</div>
      </div>

      <div class="card-body">
        <h1 class="card-title"><?= htmlspecialchars($job['name']) ?></h1>

        <!-- Description -->
        <p class="description"><?= nl2br(htmlspecialchars($job['description'])) ?></p>

        <!-- Job Details -->
        <div class="job-detail">
          <span class="label">Job Name:</span>
          <div class="value"><?= htmlspecialchars($job['name']) ?></div>
        </div>

        <div class="job-detail">
          <span class="label">Skills Required:</span>
          <div class="value"><?= htmlspecialchars($job['skill']) ?></div>
        </div>

        <div class="job-detail">
          <span class="label">Timing:</span>
          <div class="value"><?= htmlspecialchars($job['timing']) ?></div>
        </div>

        <div class="job-detail">
          <span class="label">Location:</span>
          <div class="value"><?= htmlspecialchars($job['location']) ?></div>
        </div>

        <div class="job-detail">
          <span class="label">Salary:</span>
          <div class="value">Rs. <?= htmlspecialchars($job['salary']) ?></div>
        </div>

        <div class="job-detail">
          <span class="label">Category:</span>
          <div class="category-badge"><?= htmlspecialchars($job['catname']) ?></div>
        </div>

        <!-- Apply Button -->
        <button class="apply-button" onclick="window.location.href='apply.php?jobid=<?= $job['jobid'] ?>'">Apply Now</button>

        <a href="viewjobs.php" class="back-link">&larr; Back to Job Listings</a>
      </div>
    </div>
  <?php elseif (isset($error_message)): ?>
    <h2><?= $error_message ?></h2>
    <a href="viewjobs.php" class="back-link">&larr; Back to Job Listings</a>
  <?php endif; ?>
</div>

<?php include('footer.php'); ?>

</body>
</html>
