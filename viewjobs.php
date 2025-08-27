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
    }

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

    /* Action buttons like categories */
    .action-btn {
      padding: 8px 14px; border:none; border-radius:6px; font-size:13px;
      color:white; margin-right:6px; cursor:pointer; transition:0.3s; text-decoration:none; display:inline-block;
    }
    .action-btn.edit { background-color:#28a745; }
    .action-btn.edit:hover { transform:scale(1.05); opacity:0.9; }
    .action-btn.delete { background-color:#dc3545; }
    .action-btn.delete:hover { transform:scale(1.05); opacity:0.9; }

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
// Delete job
if (isset($_GET['delete'])) {
    $jobId = $_GET['delete'];
    $deleteQuery = "DELETE FROM jobs WHERE jobid = '$jobId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<script>alert('Job deleted successfully'); window.location.href='jobs.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete job');</script>";
    }
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
          <th>#</th>
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
                        <a href='editjob.php?id=$jobId' class='action-btn edit'>Edit</a>
                        <a href='jobs.php?delete=$jobId' class='action-btn delete' onclick='return confirm(\"Are you sure you want to delete this job?\");'>Delete</a>
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
  const input = document.getElementById("searchInput");
  const filter = input.value.toLowerCase();
  const rows = document.querySelectorAll("#jobsTable tbody tr");

  rows.forEach(row => {
    const title = row.cells[1].textContent.toLowerCase();
    const skill = row.cells[3].textContent.toLowerCase();
    row.style.display = (title.includes(filter) || skill.includes(filter)) ? "" : "none";
  });
}
</script>

<?php include("footer.php"); ?>
</body>
</html>
