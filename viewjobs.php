<?php include("header.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Jobs List</title>
<style>
body { font-family: 'Roboto', sans-serif; margin:0; padding:0; background-color:#f4f6f8; }
main { padding: 100px 20px 80px; max-width: 1400px; margin:0 auto; }
h1 { text-align:center; color:#111827; margin-bottom:20px; }

.search-box { text-align:center; margin-bottom:20px; }
.search-box input {
  padding:10px; width:300px; border:1px solid #ccc; border-radius:6px; font-size:14px;
  transition:0.3s;
}
.search-box input:focus { outline:none; border-color:#007bff; box-shadow:0 0 8px rgba(0,123,255,0.2); }

.table-container {
  background: #fff; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1);
  overflow-x:auto; margin-bottom:80px;
}

.styled-table {
  width:100%; border-collapse: separate; border-spacing:0;
  font-size:15px; border-radius:12px; overflow:hidden; background-color:white; min-width:1200px;
}

.styled-table thead {
  background: linear-gradient(to right,#007bff,#3399ff); color:white; text-transform:uppercase; font-size:13px; font-weight:600;
  position: sticky; top:0; z-index:10;
}

.styled-table th, .styled-table td { padding:16px 18px; text-align:left; }
.styled-table tbody tr:nth-child(even) { background-color:#f8fafd; }
.styled-table tbody tr:hover { background-color:#eaf2ff; transition:0.2s; }

.category-badge { display:inline-block; background-color:#10B981; color:white; padding:4px 10px; border-radius:9999px; font-size:12px; }

/* Premium action buttons */
.action-btn {
  padding: 8px 14px; border:none; border-radius:8px; font-size:13px;
  color:white; margin-right:6px; cursor:pointer; transition:all 0.3s; text-decoration:none; display:inline-block;
  box-shadow:0 4px 12px rgba(0,0,0,0.1);
}
.action-btn.edit { background: linear-gradient(135deg,#43cea2,#185a9d); }
.action-btn.edit:hover { transform:scale(1.05); box-shadow:0 6px 18px rgba(0,0,0,0.2); }
.action-btn.delete { background: linear-gradient(135deg,#f85032,#e73827); }
.action-btn.delete:hover { transform:scale(1.05); box-shadow:0 6px 18px rgba(0,0,0,0.2); }

@media (max-width:768px){
  .search-box input { width:90%; }
  th, td { font-size:14px; }
  .action-btn { font-size:12px; padding:6px 10px; }
}
</style>
</head>
<body>
<?php include("database/db_connect.php"); ?>

<?php
// Delete job safely using prepared statement
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $jobId = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM jobs WHERE jobid = ?");
    $stmt->bind_param("i", $jobId);

    if ($stmt->execute()) {
        echo "<script>alert('Job deleted successfully'); window.location.href='viewjobs.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete job'); window.location.href='viewjobs.php';</script>";
    }

    $stmt->close();
}
?>

<main>
  <h1>Available Job Listings</h1>

  <div class="search-box">
    <input type="text" id="searchInput" onkeyup="filterJobs()" placeholder="Search jobs by title or skill...">
  </div>

  <div class="table-container">
    <table class="styled-table" id="jobsTable">
      <thead>
        <tr>
          <th>id</th>
          <th>Job Title</th>
          <th>Description</th>
          <th>Skill</th>
          <th>Timing</th>
          <th>Date</th>
          <th>Salary</th>
          <th>Location</th>
          <th>Category</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT j.*, c.name AS catname FROM jobs j LEFT JOIN categories c ON j.catid = c.catid ORDER BY j.date DESC";
        $result = mysqli_query($conn, $query);
        $count = 1;

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $jobId = htmlspecialchars($row['jobid']);
                echo "<tr>";
                echo "<td>" . $count++ . "</td>";
                echo "<td><a href='singlejob.php?id=$jobId'>" . htmlspecialchars($row['name']) . "</a></td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['skill']) . "</td>";
                echo "<td>" . htmlspecialchars($row['timing']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                echo "<td>Rs. " . htmlspecialchars($row['salary']) . "</td>";
                echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                echo "<td><span class='category-badge'>" . htmlspecialchars($row['catname']) . "</span></td>";
                echo "<td>
                        <a href='javascript:void(0);' onclick='confirmDelete($jobId)' class='action-btn delete'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10' style='text-align:center;'>No jobs found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</main>

<script>
function filterJobs() {
  const input = document.getElementById("searchInput").value.toLowerCase();
  const rows = document.querySelectorAll("#jobsTable tbody tr");

  rows.forEach(row => {
    const title = row.cells[1].textContent.toLowerCase();
    const skill = row.cells[3].textContent.toLowerCase();
    row.style.display = (title.includes(input) || skill.includes(input)) ? "" : "none";
  });
}

function confirmDelete(jobId) {
  if(confirm("Are you sure you want to delete this job?")) {
      window.location.href = "viewjobs.php?delete=" + jobId;
  }
}
</script>

<?php include("footer.php"); ?>
</body>
</html>
