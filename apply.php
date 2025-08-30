<?php
session_start();
include('database/db_connect.php');

if (!isset($_SESSION['userid'])) {
    header("Location: login.php?redirect=apply.php?jobid=" . ($_GET['jobid'] ?? 0));
    exit();
}

$jobId = isset($_GET['jobid']) ? intval($_GET['jobid']) : 0;
$userId = $_SESSION['userid'];
$message = "";
$success = false;
$redirect = false;

$cvFile = "";
$cvStmt = $conn->prepare("SELECT filepath FROM resumes WHERE user_id=? ORDER BY uploaded_at DESC LIMIT 1");
if (!$cvStmt) die("Prepare failed (CV fetch): " . $conn->error);
$cvStmt->bind_param("i", $userId);
$cvStmt->execute();
$cvResult = $cvStmt->get_result();
if ($cvResult->num_rows > 0) {
    $row = $cvResult->fetch_assoc();
    $cvFile = $row['filepath'];
}
$cvStmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coverLetter = mysqli_real_escape_string($conn, $_POST['cover_letter'] ?? '');
    $date = date('Y-m-d');

    $checkStmt = $conn->prepare("SELECT * FROM application WHERE jobid=? AND userid=?");
    if (!$checkStmt) die("Prepare failed (check application): " . $conn->error);
    $checkStmt->bind_param("ii", $jobId, $userId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $message = "⚠️ You have already applied for this job.";
        $redirect = true;
    } else {
        $insertStmt = $conn->prepare("INSERT INTO application (jobid, userid, cv, cover_letter, date) VALUES (?, ?, ?, ?, ?)");
        if (!$insertStmt) die("Prepare failed (insert application): " . $conn->error);
        $insertStmt->bind_param("iisss", $jobId, $userId, $cvFile, $coverLetter, $date);

        if ($insertStmt->execute()) {
            $message = "Application submitted successfully!";
            $success = true;
            $redirect = true;
        } else {
            $message = "Error submitting application: " . $insertStmt->error;
        }
        $insertStmt->close();
    }

    $checkStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Apply for Job</title>
<style>
body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #e0e7ff, #f8fafc);
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
}
.container {
    width: 100%;
    max-width: 700px;
    margin: 80px 20px 50px;
    background: rgba(255, 255, 255, 0.96);
    backdrop-filter: blur(14px);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.12);
    animation: fadeIn 0.6s ease-in-out;
}
h1 {
    font-size: 28px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 30px;
    background: linear-gradient(90deg, #1e3a8a, #2563eb);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    font-size: 15px;
    color: #374151;
}
textarea {
    width: 100%;
    padding: 14px 16px;
    margin-bottom: 22px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    font-size: 15px;
    background: #f9fafb;
    transition: all 0.3s ease;
}
textarea:focus {
    outline: none;
    border-color: #2563eb;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
}
.btn {
    display: inline-block;
    width: 100%;
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;
    padding: 16px;
    border: none;
    border-radius: 14px;
    font-size: 17px;
    font-weight: 600;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.25s ease-in-out;
}
.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
}
.message {
    margin-bottom: 20px;
    font-weight: 600;
    text-align: center;
    padding: 12px 15px;
    border-radius: 10px;
    font-size: 15px;
    animation: fadeIn 0.4s ease-in-out;
}
.success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #86efac;
}
.error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}
.redirect-card {
    margin-top: 25px;
    padding: 20px 30px;
    border-radius: 16px;
    background: linear-gradient(145deg, #f0f4ff, #e0e7ff);
    border: 3px solid transparent;
    background-clip: padding-box, border-box;
    position: relative;
    text-align: center;
    animation: scaleUp 0.5s ease-in-out;
    box-shadow: 0 10px 25px rgba(37, 99, 235, 0.2);
}
.redirect-card::before {
    content: '';
    position: absolute;
    top: -3px; left: -3px; right: -3px; bottom: -3px;
    border-radius: 16px;
    background: linear-gradient(90deg, #2563eb, #1e40af);
    z-index: -1;
}
.countdown {
    font-weight: 700;
    font-size: 24px;
    color: #1e3a8a;
    display: inline-block;
    padding: 5px 12px;
    border-radius: 8px;
    background: linear-gradient(135deg, #93c5fd, #60a5fa);
    color: #fff;
    margin-left: 8px;
}
@keyframes fadeIn { from {opacity:0; transform:translateY(20px);} to {opacity:1; transform:translateY(0);} }
@keyframes scaleUp { from {transform: scale(0.9); opacity:0;} to {transform: scale(1); opacity:1;} }
@media(max-width:768px){ .container { margin: 60px 15px; padding: 28px; } h1 { font-size: 24px; } .countdown { font-size: 20px; } }
</style>
</head>
<body>
<div class="container">
    <h1>Apply for Job</h1>

    <?php if ($message): ?>
        <p class="message <?= $success ? 'success' : 'error' ?>"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="cover_letter">Cover Letter (Optional)</label>
        <textarea name="cover_letter" rows="5" placeholder="Write why you’re the right fit..."></textarea>

        <?php if ($cvFile): ?>
            <p>Your uploaded CV: <a href="<?= htmlspecialchars($cvFile) ?>" target="_blank" style="color:#2563eb; text-decoration:underline;">View CV</a></p>
        <?php else: ?>
            <p style="color:red;">⚠️ No CV found. Please upload one in your profile first.</p>
        <?php endif; ?>

        <button type="submit" class="btn" <?= !$cvFile ? 'disabled' : '' ?>>Submit Application</button>
    </form>

    <?php if ($redirect): ?>
        <div class="redirect-card">
            You will be redirected in <span id="countdown" class="countdown">5</span> seconds...
        </div>
    <?php endif; ?>
</div>

<?php if ($redirect): ?>
<script>
let countdown = 5;
const interval = setInterval(() => {
    countdown--;
    document.getElementById('countdown').innerText = countdown;
    if(countdown <= 0){
        clearInterval(interval);
        window.location.href = 'index.php';
    }
}, 1000);
</script>
<?php endif; ?>
</body>
</html>
