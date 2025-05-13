<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Jobs List</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f6f8;
    }
    header, footer {
      position: sticky;
      left: 0;
      right: 0;
      z-index: 1000;
    }
    header {
      top: 0;
    }
    footer {
      bottom: 0;
      text-align: center;
    }
    main {
      padding: 100px 20px 80px; /* space for fixed header/footer */
      max-width: 1200px;
      margin: 0 auto;
    }
    h1 {
      text-align: center;
      color: #111827;
      margin-bottom: 20px;
    }
    .search-box {
      text-align: center;
      margin-bottom: 20px;
    }
    .search-box input {
      padding: 10px;
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }
    .table-container {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      overflow-x: auto;
      margin-bottom: 80px;
    }
    .styled-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      font-size: 15px;
      border-radius: 12px;
      overflow: hidden;
      background-color: white;
      min-width: 1000px;
    }
    .styled-table thead {
      background: linear-gradient(to right, #007bff, #3399ff);
      color: white;
      text-transform: uppercase;
      font-size: 13px;
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
    }
    .category-badge {
      display: inline-block;
      background-color: #10B981;
      color: white;
      padding: 4px 10px;
      border-radius: 9999px;
      font-size: 12px;
    }
    @media (max-width: 768px) {
      .search-box input {
        width: 90%;
      }
    }
  </style>
</head>
<body>

  <header>
    <?php include('header.php'); ?>
  </header>

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
          </tr>
        </thead>
        <tbody>
          <?php
            include('database/db_connect.php');
            $query = "SELECT j.*, c.name AS catname FROM jobs j LEFT JOIN categories c ON j.catid = c.catid ORDER BY j.date DESC";
            $result = mysqli_query($conn, $query);
            $count = 1;
            if ($result && mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $count++ . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['skill']) . "</td>";
                echo "<td>" . htmlspecialchars($row['timing']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                echo "<td>Rs. " . htmlspecialchars($row['salary']) . "</td>";
                echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                echo "<td><span class='category-badge'>" . htmlspecialchars($row['catname']) . "</span></td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='9' style='text-align:center;'>No jobs found.</td></tr>";
            }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <footer>
    <?php include('footer.php'); ?>
  </footer>

  <script>
    function filterJobs() {
      const input = document.getElementById("searchInput");
      const filter = input.value.toLowerCase();
      const rows = document.querySelectorAll("#jobsTable tbody tr");

      rows.forEach(row => {
        const title = row.cells[1].textContent.toLowerCase();
        const skill = row.cells[3].textContent.toLowerCase();
        if (title.includes(filter) || skill.includes(filter)) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    }
  </script>
</body>
</html>
