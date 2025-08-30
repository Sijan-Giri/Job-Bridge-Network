<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("database/db_connect.php");

// Check if logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

// Delete user if requested
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);

    // Prevent self-deletion
    if ($deleteId != $_SESSION['userid']) {
        $stmt = $conn->prepare("DELETE FROM user WHERE userid = ?");
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('User deleted successfully'); window.location.href='viewusers.php';</script>";
    } else {
        echo "<script>alert('You cannot delete your own account'); window.location.href='viewusers.php';</script>";
    }
}

// Fetch all users
$query = "SELECT * FROM user ORDER BY userid DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Users</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
body { font-family:'Inter',sans-serif; background:#f4f6f9; margin:0; color:#333; }
header { background: linear-gradient(135deg,#667eea,#764ba2); padding:1rem 2rem; color:#fff; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.1);}
h1 { margin:0; font-size:1.8rem; font-weight:600; }
.container { max-width:1200px; margin:2rem auto; background:#fff; padding:2rem; border-radius:16px; box-shadow:0 8px 24px rgba(0,0,0,0.08);}
.flex-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.back-btn { text-decoration:none; padding: 6px 14px; border-radius:8px; font-weight:600; color:#fff; background: linear-gradient(135deg,#43cea2,#185a9d); box-shadow:0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s ease; }
.back-btn:hover { transform: scale(1.05); box-shadow:0 6px 18px rgba(0,0,0,0.2); }
.search-bar { display:flex; }
.search-bar input { padding:0.6rem 1rem; border:1px solid #ddd; border-radius:10px; width:250px; font-size:0.9rem; transition:0.2s;}
.search-bar input:focus { outline:none; border-color:#667eea; box-shadow:0 0 6px rgba(102,126,234,0.4);}
table { width:100%; border-collapse:collapse; border-radius:12px; overflow:hidden; }
th,td { padding:1rem; text-align:left; font-size:0.95rem; }
th { background:#f9fafc; font-weight:600; color:#555; }
tr:nth-child(even) { background:#fafafa; }
tr:hover { background:#f0f4ff; transition:0.3s; }
.badge { display:inline-block; padding:0.3rem 0.7rem; border-radius:12px; font-size:0.8rem; font-weight:600; color:#fff; }
.badge.admin { background:#e53e3e; }
.badge.employer { background:#3182ce; }
.badge.employee { background:#38a169; }
.badge.user { background:#805ad5; }
.action-buttons { display:flex; gap:10px; }
.btn { padding:6px 12px; border-radius:8px; font-size:0.85rem; font-weight:600; text-decoration:none; transition:all 0.3s ease; color:#fff; box-shadow:0 4px 12px rgba(0,0,0,0.1);}
.btn-edit { background: linear-gradient(135deg,#43cea2,#185a9d); }
.btn-edit:hover { transform: scale(1.05); box-shadow:0 6px 18px rgba(0,0,0,0.2); }
.btn-delete { background: linear-gradient(135deg,#f85032,#e73827); }
.btn-delete:hover { transform: scale(1.05); box-shadow:0 6px 18px rgba(0,0,0,0.2); }
.no-data { text-align:center; padding:2rem; font-size:1rem; color:#777; }
</style>
<script>
function searchTable() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let rows = document.querySelectorAll("#userTable tbody tr");
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(input) ? "" : "none";
    });
}
function confirmDelete(userId) {
    if(confirm("Are you sure you want to delete this user?")) {
        window.location.href = "viewusers.php?delete=" + userId;
    }
}
</script>
</head>
<body>
<header>
<h1>👥 Registered Users</h1>
</header>

<div class="container">
<div class="flex-top">
  <!-- Back Arrow -->
  <a href="index.php" class="back-btn">&#8592; Back</a>

  <!-- Search Bar -->
  <div class="search-bar">
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search users...">
  </div>
</div>

<table id="userTable">
<thead>
<tr>
<th>User ID</th>
<th>Username</th>
<th>Email</th>
<th>Role</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php if($result && $result->num_rows > 0): ?>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?php echo htmlspecialchars($row['userid']); ?></td>
<td><?php echo htmlspecialchars($row['name']); ?></td>
<td><?php echo htmlspecialchars($row['email']); ?></td>
<td><span class="badge <?php echo strtolower($row['roletype']); ?>"><?php echo ucfirst($row['roletype']); ?></span></td>
<td>
<div class="action-buttons">
<a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['userid']; ?>)" class="btn btn-delete">Delete</a>
</div>
</td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="5" class="no-data">🚫 No users found</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>

</body>
</html>
