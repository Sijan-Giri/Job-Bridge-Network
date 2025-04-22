<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Job Management</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
      min-height: 100vh;
    }
    .container {
      display: flex;
      flex-wrap: wrap;
      align-items: flex-start;
      justify-content: space-between;
      padding: 40px 20px;
      max-width: 1200px;
      margin: auto;
      gap: 30px;
    }
    .form-container {
      margin-top: 80px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
      padding: 30px;
      flex: 1 1 45%;
      min-width: 300px;
    }
    .form-container h2 {
      text-align: center;
      font-size: 26px;
      margin-bottom: 25px;
      color: #333;
    }
    label {
      font-size: 14px;
      margin-bottom: 8px;
      display: block;
      color: #444;
    }
    input[type="text"], input[type="date"], textarea, select {
      width: 100%;
      padding: 14px 16px;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #f9f9f9;
      margin-bottom: 20px;
      outline: none;
      transition: border 0.3s;
    }
    input[type="text"]:focus, textarea:focus, select:focus {
      border-color: #007bff;
      box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
    }
    button[type="submit"] {
      width: 100%;
      padding: 14px;
      background-color: #007bff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 500;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s;
    }
    button:hover {
      background-color: #0056b3;
      transform: scale(1.02);
    }
    .table-container {
      margin-top: 80px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 0;
      flex: 1 1 45%;
      min-width: 300px;
      max-height: 600px;
      overflow-y: auto;
      overflow-x: auto;
      margin-bottom: 180px;
    }
    .styled-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      min-width: 600px;
      font-size: 15px;
      border-radius: 12px;
      overflow: hidden;
      background-color: white;
    }
    .styled-table thead {
      background: linear-gradient(to right, #007bff, #3399ff);
      color: white;
      text-transform: uppercase;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: 0.04em;
      position: sticky;
      top: 0;
      z-index: 10;
    }
    .styled-table th, .styled-table td {
      padding: 16px 18px;
      text-align: left;
    }
    .styled-table tbody tr:nth-child(even) {
      background-color: #f8fafd;
    }
    .styled-table tbody tr:hover {
      background-color: #eaf2ff;
      transition: background-color 0.2s ease-in-out;
    }
    .styled-table td:first-child, .styled-table th:first-child {
      border-top-left-radius: 10px;
      border-bottom-left-radius: 10px;
    }
    .styled-table td:last-child, .styled-table th:last-child {
      border-top-right-radius: 10px;
      border-bottom-right-radius: 10px;
    }
    .action-btn {
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      font-size: 13px;
      color: white;
      margin-right: 6px;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.2s;
    }
    .action-btn:hover {
      transform: scale(1.05);
      opacity: 0.9;
    }
    .action-btn.edit {
      background-color: #28a745;
    }
    .action-btn.delete {
      background-color: #dc3545;
    }
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        padding: 20px;
      }
      .form-container h2 {
        font-size: 22px;
      }
      input, button {
        font-size: 14px;
        padding: 12px;
      }
      th, td {
        font-size: 14px;
      }
      .action-btn {
        font-size: 12px;
        padding: 6px 10px;
      }
      .styled-table {
        min-width: 100%;
      }
    }
  </style>
</head>
<body>

<?php include('header.php') ?>
<?php include("database/db_connect.php"); ?>

<?php
$editMode = false;
$editJobId = '';
$editData = [
  'name' => '', 'description' => '', 'skill' => '',
  'timing' => '', 'date' => '', 'salary' => '',
  'location' => '', 'catid' => ''
];

// Get categories for dropdown
$categoryList = mysqli_query($conn, "SELECT * FROM categories");

// Edit mode
if (isset($_GET['edit'])) {
  $editMode = true;
  $editJobId = $_GET['edit'];
  $result = mysqli_query($conn, "SELECT * FROM jobs WHERE jobid = $editJobId");
  $editData = mysqli_fetch_assoc($result);
}

// Handle Add
if (isset($_POST['addjob'])) {
  $query = "INSERT INTO jobs (name, description, skill, timing, date, salary, location, catid) VALUES (
    '".mysqli_real_escape_string($conn, $_POST['name'])."',
    '".mysqli_real_escape_string($conn, $_POST['description'])."',
    '".mysqli_real_escape_string($conn, $_POST['skill'])."',
    '".mysqli_real_escape_string($conn, $_POST['timing'])."',
    '".mysqli_real_escape_string($conn, $_POST['date'])."',
    '".mysqli_real_escape_string($conn, $_POST['salary'])."',
    '".mysqli_real_escape_string($conn, $_POST['location'])."',
    '".mysqli_real_escape_string($conn, $_POST['catid'])."'
  )";

  mysqli_query($conn, $query);

  exit;
}

// Handle Update
if (isset($_POST['updatejob'])) {
  $query = "UPDATE jobs SET 
    name = '".mysqli_real_escape_string($conn, $_POST['name'])."',
    description = '".mysqli_real_escape_string($conn, $_POST['description'])."',
    skill = '".mysqli_real_escape_string($conn, $_POST['skill'])."',
    timing = '".mysqli_real_escape_string($conn, $_POST['timing'])."',
    date = '".mysqli_real_escape_string($conn, $_POST['date'])."',
    salary = '".mysqli_real_escape_string($conn, $_POST['salary'])."',
    location = '".mysqli_real_escape_string($conn, $_POST['location'])."',
    catid = '".mysqli_real_escape_string($conn, $_POST['catid'])."'
    WHERE jobid = $editJobId";
  mysqli_query($conn, $query);
  header("Location: jobs.php");
  exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
  $deleteId = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM jobs WHERE jobid = $deleteId");
  header("Location: jobs.php");
  exit;
}
?>

<div class="container">
  <!-- Form Container -->
  <div class="form-container">
    <h2><?php echo $editMode ? 'Edit Job' : 'Add Job'; ?></h2>
    <form method="POST" action="jobs.php<?php echo $editMode ? '?edit=' . $editJobId : ''; ?>">
      <label>Job Title</label>
      <input type="text" name="name" value="<?php echo $editData['name']; ?>" required>

      <label>Description</label>
      <textarea name="description" required><?php echo $editData['description']; ?></textarea>

      <label>Skill</label>
      <input type="text" name="skill" value="<?php echo $editData['skill']; ?>" required>

      <label>Timing</label>
      <input type="text" name="timing" value="<?php echo $editData['timing']; ?>" required>

      <label>Date</label>
      <input type="date" name="date" value="<?php echo $editData['date']; ?>" required>

      <label>Salary</label>
      <input type="text" name="salary" value="<?php echo $editData['salary']; ?>" required>

      <label>Location</label>
      <input type="text" name="location" value="<?php echo $editData['location']; ?>" required>

      <label>Category</label>
      <select name="catid" required>
        <option value="">Select Category</option>
        <?php
          while ($cat = mysqli_fetch_assoc($categoryList)) {
            $selected = ($cat['catid'] == $editData['catid']) ? 'selected' : '';
            echo "<option value='{$cat['catid']}' $selected>{$cat['name']}</option>";
          }
        ?>
      </select>

      <button type="submit" name="<?php echo $editMode ? 'updatejob' : 'addjob'; ?>">
        <?php echo $editMode ? 'Update Job' : 'Add Job'; ?>
      </button>
    </form>
    <?php if ($editMode): ?>
      <p style="text-align:center; margin-top:10px;">
        <a href="jobs.php" style="text-decoration:none; color:#007bff;">Cancel Edit</a>
      </p>
    <?php endif; ?>
  </div>

  <!-- Table -->
  <div class="table-container">
    <table class="styled-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Skill</th>
          <th>Timing</th>
          <th>Date</th>
          <th>Salary</th>
          <th>Location</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $jobs = mysqli_query($conn, "SELECT * FROM jobs");
          if ($jobs && mysqli_num_rows($jobs) > 0) {
            while ($job = mysqli_fetch_assoc($jobs)) {
              echo "<tr>";
              echo "<td>{$job['jobid']}</td>";
              echo "<td>".htmlspecialchars($job['name'])."</td>";
              echo "<td>".htmlspecialchars($job['skill'])."</td>";
              echo "<td>".htmlspecialchars($job['timing'])."</td>";
              echo "<td>{$job['date']}</td>";
              echo "<td>".htmlspecialchars($job['salary'])."</td>";
              echo "<td>".htmlspecialchars($job['location'])."</td>";
              echo "<td>
                      <a href='jobs.php?edit={$job['jobid']}' class='action-btn edit'>Edit</a>
                      <a href='jobs.php?delete={$job['jobid']}' class='action-btn delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='8'>No jobs found.</td></tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
</div>

<?php include("footer.php") ?>
</body>
</html>
