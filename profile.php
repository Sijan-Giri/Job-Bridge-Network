<?php
session_start();
include('database/db_connect.php');

// ✅ Check login
if (!isset($_SESSION['userid'])) {
    header("Location: login.php?redirect=profile.php");
    exit();
}

// ✅ Fetch user info
$userId = $_SESSION['userid'];
$stmt = $conn->prepare("SELECT * FROM user WHERE userid = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// ✅ Delete applied job
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $appid = intval($_GET['delete']);
    $delStmt = $conn->prepare("DELETE FROM application WHERE appid=? AND userid=?");
    $delStmt->bind_param("ii", $appid, $userId);
    if ($delStmt->execute()) {
        echo "<script>alert('Job application deleted successfully'); window.location.href='profile.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete application');</script>";
    }
    $delStmt->close();
}

// ✅ Fetch applied jobs with status
$jobs = [];
$jobStmt = $conn->prepare("
    SELECT a.*, j.name AS job_name, j.location, j.timing, j.salary, c.name AS category 
    FROM application a 
    JOIN jobs j ON a.jobid = j.jobid 
    LEFT JOIN categories c ON j.catid = c.catid 
    WHERE a.userid = ? 
    ORDER BY a.date DESC
");
$jobStmt->bind_param("i", $userId);
$jobStmt->execute();
$jobResult = $jobStmt->get_result();
while ($row = $jobResult->fetch_assoc()) {
    $jobs[] = $row;
}
$jobStmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile Page</title>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body {
  font-family: 'Open Sans', sans-serif;
  background: linear-gradient(to right, #2c74f5, #00c6ff);
  margin: 0;
  padding: 20px;
}
.profile-container {
  max-width: 900px;
  margin: auto;
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  display: flex;
  gap: 30px;
  position: relative;
}
.back-arrow {
  position: absolute;
  top: 20px;
  left: 20px;
  font-size: 24px;
  color: #2c74f5;
  cursor: pointer;
  transition: transform 0.2s, color 0.2s;
}
.back-arrow:hover {
  color: #1e40af;
  transform: translateX(-5px);
}
.profile-left {
  width: 250px;
  text-align: center;
}
.profile-left img {
  width: 100%;
  border-radius: 8px;
}
.change-photo {
  margin-top: -35px;
  background: rgba(0, 0, 0, 0.6);
  color: white;
  padding: 5px;
  font-size: 14px;
  cursor: pointer;
}
.profile-links {
  margin-top: 20px;
  text-align: left;
}
.profile-links h4 {
  font-size: 13px;
  font-weight: 600;
  color: #777;
  margin-bottom: 8px;
}
.profile-links a {
  display: block;
  color: #2c74f5;
  font-size: 14px;
  margin-bottom: 6px;
  text-decoration: none;
}
.profile-right {
  flex: 1;
}
.profile-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.profile-header h2 {
  margin: 0;
  font-weight: 600;
}
.profile-header p {
  margin: 4px 0 0 0;
  color: #2c74f5;
  font-size: 14px;
}
.edit-btn {
  padding: 6px 14px;
  background: #f1f1f1;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  border: 1px solid #ddd;
}
.tabs {
  margin-top: 15px;
  border-bottom: 1px solid #ddd;
}
.tabs a {
  margin-right: 20px;
  font-size: 14px;
  color: #2c74f5;
  text-decoration: none;
  padding-bottom: 5px;
  display: inline-block;
}
.info {
  margin-top: 15px;
}
.info-row {
  display: flex;
  margin-bottom: 8px;
  font-size: 14px;
}
.info-row div:first-child {
  width: 120px;
  font-weight: 600;
  color: #555;
}
.info-row div:last-child {
  color: #2c74f5;
}
.job-section {
  margin-top: 30px;
}
.job-card {
  background: white;
  border-radius: 12px;
  padding: 15px;
  margin-bottom: 15px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  position: relative;
}
.job-card h3 {
  margin: 0 0 5px 0;
  color: #1e3a8a;
}
.job-details {
  font-size: 13px;
  color: #555;
  margin-bottom: 5px;
}
.badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 9999px;
  font-size: 12px;
  font-weight: 600;
  color: white;
}
.download-btn {
  display: inline-block;
  background: #2563eb;
  color: white;
  padding: 6px 12px;
  border-radius: 8px;
  font-size: 13px;
  text-decoration: none;
  margin-top: 5px;
}
.download-btn:hover {
  background: #1e40af;
}
.delete-btn {
  position: absolute;
  top: 15px;
  right: 15px;
  background: #ef4444;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 6px 12px;
  cursor: pointer;
  font-size: 13px;
  transition: transform 0.2s, box-shadow 0.2s;
}
.delete-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
</style>
</head>
<body>

<div class="profile-container">

  <div class="back-arrow" onclick="history.back()">&larr;</div>

  <div class="profile-left">
    <img src="https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png" alt="Profile Photo">
    <div class="change-photo">Change Photo</div>

    <div class="profile-links">
      <h4>WORK LINK</h4>
      <a href="#">Website Link</a>
      <a href="#">Portfolio</a>

      <h4 style="margin-top: 15px;">SKILLS</h4>
      <a href="#">Web Designer</a>
      <a href="#">Web Developer</a>
      <a href="#">PHP</a>
      <a href="#">JavaScript</a>
    </div>
  </div>

  <div class="profile-right">
    <div class="profile-header">
      <div>
        <h2><?= htmlspecialchars($user['name']) ?></h2>
        <p>Total Applied Jobs: <?= count($jobs) ?></p>
      </div>
      <div class="edit-btn">Edit Profile</div>
    </div>

    <div class="tabs">
      <a href="#">User</a>
      <a href="#">Info</a>
    </div>

    <div class="info">
      <div class="info-row"><div>Name</div><div><?= htmlspecialchars($user['name']) ?></div></div>
      <div class="info-row"><div>Email</div><div><?= htmlspecialchars($user['email']) ?></div></div>
    </div>

    <div class="job-section">
      <h3>Jobs You Applied For</h3>
      <?php if(count($jobs) > 0): ?>
        <?php foreach($jobs as $job): ?>
          <div class="job-card">
            <h3><?= htmlspecialchars($job['job_name']) ?></h3>
            <div class="job-details">
              <span class="badge"><?= htmlspecialchars($job['category']) ?></span>
              <span class="badge" style="background: <?= 
                  $job['applicationStatus']=='selected'?'#10b981':
                  ($job['applicationStatus']=='rejected'?'#ef4444':'#facc15'); 
              ?>; margin-left:8px;">
                <?= ucfirst($job['applicationStatus'] ?? 'pending') ?>
              </span>
            </div>
            <div class="job-details">
              Location: <?= htmlspecialchars($job['location']) ?> | 
              Timing: <?= htmlspecialchars($job['timing']) ?> | 
              Salary: Rs. <?= htmlspecialchars($job['salary']) ?>
            </div>
            <div class="job-details">Applied On: <?= htmlspecialchars($job['date']) ?></div>
            <?php if($job['cv']): ?>
              <a href="uploads/resumes/<?= htmlspecialchars($job['cv']) ?>" class="download-btn" target="_blank">Download CV</a>
            <?php endif; ?>
            <!-- Delete Button -->
            <a href="profile.php?delete=<?= $job['appid'] ?>" onclick="return confirm('Are you sure you want to delete this application?');" class="delete-btn">Delete</a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>You haven’t applied to any jobs yet.</p>
      <?php endif; ?>
    </div>

  </div>
</div>

</body>
</html>
