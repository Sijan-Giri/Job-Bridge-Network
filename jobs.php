<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Management</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
      min-height: 100vh;
    }
    /* Adjusting the container to have top and bottom padding */
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      padding: 40px 20px;
      margin-top: 60px; /* Add margin for space between header and form */
      margin-bottom: 60px; /* Add margin for space between footer and form */
    }

    /* Form container styling */
    .form-container {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      padding: 30px;
      width: 100%;
      max-width: 600px;
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
    button[type="submit"]:hover {
      background-color: #0056b3;
      transform: scale(1.02);
    }
    .cancel-link {
      text-align: center;
      margin-top: 10px;
    }
    .cancel-link a {
      text-decoration: none;
      color: #007bff;
      font-size: 14px;
    }
  </style>
</head>
<body>

<?php include('header.php'); ?>
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
  header("Location: index.php"); // Redirect after successful addition
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
  header("Location: jobs.php"); // Redirect after successful update
  exit;
}
?>

<div class="container">
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
      <div class="cancel-link">
        <a href="jobs.php" class="cancel-link">Cancel Edit</a>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include('footer.php') ?>
</body>
</html>
