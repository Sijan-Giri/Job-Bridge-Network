<?php include("header.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Applications</title>
<style>
body { font-family:'Roboto', sans-serif; margin:0; padding:0; background:#f4f6f9; }
main { padding:50px 20px 400px; max-width:1400px; margin:0 auto; }
h1 { text-align:center; color:#111827; margin-bottom:20px; }

.table-container {
    background:#fff;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    overflow-x:auto;
}
.styled-table {
    width:100%; border-collapse:separate; border-spacing:0;
    font-size:15px; border-radius:12px; overflow:hidden; min-width:1200px;
}
.styled-table thead {
    background: linear-gradient(135deg,#667eea,#764ba2);
    color:white; text-transform:uppercase; font-weight:600; font-size:13px;
    position: sticky; top:0; z-index:10;
}
.styled-table th, .styled-table td { padding:16px 18px; text-align:left; }
.styled-table tbody tr:nth-child(even) { background-color:#f8fafd; }
.styled-table tbody tr:hover { background-color:#eaf2ff; transition:0.2s; }

.action-btn {
    padding:6px 12px; border:none; border-radius:8px; font-size:13px;
    color:white; margin-right:6px; cursor:pointer; transition:all 0.3s; text-decoration:none; display:inline-block;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}
.action-btn.view { background: linear-gradient(135deg,#43cea2,#185a9d); }
.action-btn.view:hover { transform:scale(1.05); box-shadow:0 6px 18px rgba(0,0,0,0.2); }
.action-btn.status { background: linear-gradient(135deg,#f6d365,#fda085); }
.action-btn.status:hover { transform:scale(1.05); box-shadow:0 6px 18px rgba(0,0,0,0.2); }
.action-btn.delete { background: linear-gradient(135deg,#f85032,#e73827); }
.action-btn.delete:hover { transform:scale(1.05); box-shadow:0 6px 18px rgba(0,0,0,0.2); }

.status-select {
    padding:6px 10px; border-radius:6px; border:1px solid #ccc; font-size:13px;
    transition:0.2s;
}
.status-select:focus { outline:none; border-color:#667eea; box-shadow:0 0 6px rgba(102,126,234,0.4); }

@media(max-width:768px){
    th, td { font-size:14px; padding:12px; }
    .action-btn { font-size:12px; padding:5px 8px; }
}
</style>
</head>
<body>
<?php include("database/db_connect.php"); ?>

<?php
if (isset($_POST['updateStatus']) && isset($_POST['appid'])) {
    $appid = intval($_POST['appid']);
    $newStatus = $_POST['status'];

    $stmt = $conn->prepare("UPDATE application SET applicationStatus=? WHERE appid=?");
    $stmt->bind_param("si", $newStatus, $appid);

    if($stmt->execute()){
        echo "<script>alert('Status updated successfully'); window.location.href='viewapplications.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to update status');</script>";
    }
    $stmt->close();
}

if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
    $appid = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM application WHERE appid=?");
    $stmt->bind_param("i",$appid);
    if($stmt->execute()){
        echo "<script>alert('Application deleted successfully'); window.location.href='viewapplications.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete application'); window.location.href='viewapplications.php';</script>";
    }
    $stmt->close();
}
?>

<main>
<h1>💼 Job Applications</h1>

<div class="table-container">
<table class="styled-table">
<thead>
<tr>
<th>id</th>
<th>Applicant</th>
<th>Job</th>
<th>CV</th>
<th>Status</th>
<th>Applied On</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
$query = "SELECT a.*, u.name AS username, j.name AS jobname 
          FROM application a
          LEFT JOIN user u ON a.userid=u.userid
          LEFT JOIN jobs j ON a.jobid=j.jobid
          ORDER BY a.date DESC";
$result = mysqli_query($conn, $query);
$count = 1;

if($result && mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $appid = htmlspecialchars($row['appid']);
        echo "<tr>";
        echo "<td>".$count++."</td>";
        echo "<td>".htmlspecialchars($row['username'])."</td>";
        echo "<td>".htmlspecialchars($row['jobname'])."</td>";
        echo "<td><a href='".htmlspecialchars($row['cv'])."' target='_blank' class='action-btn view'>View CV</a></td>";
        echo "<td>
              <form method='POST' style='display:inline-block;'>
              <input type='hidden' name='appid' value='$appid'>
              <select name='status' class='status-select'>
                  <option value='pending' ".($row['applicationStatus']=='pending'?'selected':'').">Pending</option>
                  <option value='selected' ".($row['applicationStatus']=='selected'?'selected':'').">Selected</option>
                  <option value='rejected' ".($row['applicationStatus']=='rejected'?'selected':'').">Rejected</option>
              </select>
              <button type='submit' name='updateStatus' class='action-btn status'>Update</button>
              </form>
              </td>";
        echo "<td>".htmlspecialchars($row['date'])."</td>";
        echo "<td>
              <a href='javascript:void(0);' onclick='confirmDelete($appid)' class='action-btn delete'>Delete</a>
              </td>";
        echo "</tr>";
    }
}else{
    echo "<tr><td colspan='7' style='text-align:center;'>No applications found.</td></tr>";
}
?>
</tbody>
</table>
</div>
</main>

<script>
function confirmDelete(appId){
    if(confirm("Are you sure you want to delete this application?")){
        window.location.href = "viewapplications.php?delete="+appId;
    }
}
</script>

<?php include("footer.php"); ?>
</body>
</html>
