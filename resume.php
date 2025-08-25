
<?php
session_start(); 
include('database/db_connect.php');

if (!isset($_SESSION['userid'])) {
    die("Please login to access this page.");
}

$user_id = $_SESSION['userid'];
?>
<?php include('header.php') ?>
<?php
$conn->query("CREATE TABLE IF NOT EXISTS resumes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, 
    filename VARCHAR(255) NOT NULL,
    filepath VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    $res = $conn->query("SELECT filepath FROM resumes WHERE id=$del_id AND user_id=$user_id");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $fpath = $row['filepath'];
        if (file_exists($fpath)) {
            unlink($fpath);
        }
        $conn->query("DELETE FROM resumes WHERE id=$del_id AND user_id=$user_id");
        $msg = "Resume deleted successfully!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['resume'])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES['resume']['name']);
    $targetFile = $targetDir . time() . "_" . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $allowedTypes = ['pdf', 'doc', 'docx'];
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $targetFile)) {
            $stmt = $conn->prepare("INSERT INTO resumes (user_id, filename, filepath) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $fileName, $targetFile);
            $stmt->execute();
            $stmt->close();
            $msg = "Resume uploaded successfully!";
        } else {
            $msg = "Error uploading file!";
        }
    } else {
        $msg = "Only PDF, DOC, DOCX files are allowed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Upload Resume</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --bg: #0b1020;
            --card: #0f172a; 
            --card-2: #111827; 
            --text: #e5e7eb;  
            --muted: #9ca3af; 
            --line: rgba(255,255,255,0.08);
            --brand: #2563eb; 
            --brand-500:#3b82f6;
            --brand-700:#1d4ed8;
            --accent: #38bdf8; 
            --green: #22c55e;
            --red: #ef4444;
            --shadow: 0 20px 50px rgba(2, 6, 23, .65);
            --radius: 16px;
        }
        *{ box-sizing: border-box }
        html,body{ height:100% }
        body{
            margin:0;
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji","Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            color: var(--text);
            background:
                radial-gradient(1200px 500px at 20% -10%, rgba(37,99,235,.25), transparent 60%),
                radial-gradient(800px 400px at 90% 10%, rgba(56,189,248,.18), transparent 60%),
                linear-gradient(180deg, #0a0f1e, #0b1020 40%, #0b1020);
        }

        .shell{
            max-width: 1100px;
            margin: 48px auto;
            padding: 0 20px;
        }
        .header{
            position: relative;
            border: 1px solid var(--line);
            background:
                linear-gradient(180deg, rgba(255,255,255,.04), rgba(255,255,255,.02)),
                radial-gradient(600px 200px at 20% 0%, rgba(59,130,246,.10), transparent 70%),
                var(--card);
            backdrop-filter: blur(10px);
            border-radius: calc(var(--radius) + 6px);
            padding: 26px 26px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        .header::after{
            content:"";
            position:absolute;
            inset: 0;
            background: radial-gradient(800px 120px at 60% -20%, rgba(56,189,248,.10), transparent 70%);
            pointer-events:none;
        }
        .brandbar{
            display:flex; align-items:center; gap:14px; flex-wrap: wrap; justify-content: space-between;
        }
        .brand{
            display:flex; align-items:center; gap:12px;
        }
        .brand-badge{
            width:42px;height:42px;border-radius:12px;
            background: conic-gradient(from 220deg at 50% 50%, var(--brand), var(--accent), var(--brand-700));
            box-shadow: 0 8px 30px rgba(37,99,235,.45);
        }
        .brand h1{
            font-size: clamp(20px, 2.4vw, 28px);
            margin:0;
            letter-spacing: .2px;
        }
        .subtitle{
            margin:2px 0 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .grid{
            display:grid; gap: 18px;
            grid-template-columns: 1.1fr .9fr;
            margin-top: 18px;
        }
        @media (max-width: 920px){
            .grid{ grid-template-columns: 1fr; }
        }
        .card{
            border:1px solid var(--line);
            background:
                linear-gradient(180deg, rgba(255,255,255,.03), rgba(255,255,255,.015)),
                var(--card-2);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        .card-head{
            display:flex; align-items:center; justify-content: space-between;
            padding: 16px 18px;
            border-bottom:1px solid var(--line);
        }
        .card-head h3{ margin:0; font-size: 16px; letter-spacing:.2px }
        .card-body{ padding: 18px; }

        .drop{
            position: relative;
            border:1.5px dashed rgba(148,163,184,.35);
            border-radius: calc(var(--radius) - 2px);
            padding: 26px;
            display:flex; align-items:center; justify-content:center; flex-direction: column; gap: 10px;
            background:
                radial-gradient(800px 200px at 50% 0%, rgba(37,99,235,.08), transparent 70%),
                linear-gradient(180deg, rgba(15,23,42,.65), rgba(15,23,42,.75));
            transition: border-color .2s ease, background .2s ease, transform .1s ease;
        }
        .drop:hover{ border-color: rgba(59,130,246,.7); transform: translateY(-1px); }
        .drop.uploading{ opacity:.7; pointer-events:none; }
        .drop .icon{
            width:42px;height:42px;border-radius:12px;
            display:grid;place-items:center;
            background: linear-gradient(135deg, var(--brand), var(--brand-500));
            box-shadow: 0 10px 30px rgba(37,99,235,.4);
        }
        .drop .hint{ color: var(--muted); font-size:13px }
        .drop .formats{ color:#b3cdfd; font-size:12px }

        .hidden-input{ position:absolute; inset:0; opacity:0; cursor:pointer }

        .actions{ display:flex; gap:10px; flex-wrap: wrap; justify-content:center; }
        .btn{
            appearance:none; border:none; cursor:pointer;
            padding: 10px 16px; border-radius: 12px;
            font-weight: 600; letter-spacing:.2px;
            transition: transform .06s ease, box-shadow .2s ease, background .2s ease, opacity .2s ease;
            display:inline-flex; align-items:center; gap:10px;
            box-shadow: 0 10px 30px rgba(37,99,235,.25);
            background: linear-gradient(180deg, var(--brand), var(--brand-700));
            color:white;
        }
        .btn:hover{ transform: translateY(-1px) }
        .btn:active{ transform: translateY(0px) scale(.99) }

        .ghost{
            background: transparent; color: #c7d2fe; border:1px solid rgba(99,102,241,.35);
            box-shadow:none;
        }

        .message{
            margin: 0 0 12px 0; padding: 10px 12px;
            border-radius: 12px;
            background: rgba(34,197,94,.08);
            border:1px solid rgba(34,197,94,.25);
            color: #86efac;
        }
        .error{ background: rgba(239,68,68,.08); border-color: rgba(239,68,68,.25); color: #fecaca; }

        .table-wrap{
            overflow:auto; max-height: 520px; border-radius: calc(var(--radius) - 4px);
            border:1px solid var(--line);
        }
        table{
            width:100%; border-collapse: collapse; min-width: 560px;
            background: linear-gradient(180deg, rgba(255,255,255,.01), rgba(255,255,255,.02));
        }
        th, td{ padding: 12px 14px; border-bottom:1px solid var(--line); text-align: left; }
        th{
            position:sticky; top:0; backdrop-filter: blur(6px);
            background: linear-gradient(180deg, rgba(15,23,42,.95), rgba(15,23,42,.85));
            font-weight: 600; font-size: 13px; color:#c7d2fe;
            z-index: 1;
        }
        tbody tr{ transition: background .15s ease }
        tbody tr:hover{ background: rgba(99,102,241,.06) }
        td{ color: #dbe4ff; font-size: 14px }

        .link{
            color:#93c5fd; text-decoration: none; font-weight:600; border-bottom:1px dashed rgba(147,197,253,.45);
        }
        .link:hover{ color:#bfdbfe; border-bottom-color: transparent }

        .note{
            margin-top: 12px; color: var(--muted); font-size: 12px; text-align:center;
        }

        .quick-meta{
            display:flex; gap:10px; flex-wrap: wrap; margin-top: 8px;
        }
        .badge{
            font-size: 11px; color:#c7d2fe; border:1px solid rgba(99,102,241,.35);
            padding: 6px 10px; border-radius: 999px; background: rgba(99,102,241,.08);
        }

        :focus-visible{
            outline: 2px solid var(--brand-500);
            outline-offset: 2px;
            border-radius: 12px;
        }
        .toast{
            position: fixed; right: 20px; bottom: 20px;
            background: linear-gradient(180deg, #0b132a, #0b142a);
            border:1px solid var(--line);
            color:#e5edff; padding: 12px 14px; border-radius: 12px;
            box-shadow: var(--shadow);
            opacity:0; transform: translateY(8px);
            transition: opacity .2s ease, transform .2s ease;
            pointer-events:none; font-size: 14px;
        }
        .toast.show{ opacity:1; transform: translateY(0) }
    </style>
</head>
<body>
<div class="shell">
    <section class="header">
        <div class="brandbar">
            <div class="brand">
                <div class="brand-badge" aria-hidden="true"></div>
                <div>
                    <h1>Upload Your Resume Here</h1>
                    <p class="subtitle">Upload & manage your resumes — polished for recruiters.</p>
                    <div class="quick-meta">
                        <span class="badge">PDF · DOC · DOCX</span>
                        <span class="badge">Secure Storage</span>
                        <span class="badge">One-click View</span>
                    </div>
                </div>
            </div>
            <a class="btn ghost" href="#" onclick="event.preventDefault(); window.scrollTo({top:document.body.scrollHeight, behavior:'smooth'})">
                View History
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M7 10l5 5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </section>

    <div class="grid" role="region" aria-label="Resume uploader and history">
        <section class="card" aria-labelledby="uploadTitle">
            <div class="card-head">
                <h3 id="uploadTitle">Upload Resume</h3>
                <small style="color:var(--muted)">Keep it updated to stand out</small>
            </div>
            <div class="card-body">
                <?php if (!empty($msg)) {
                    $isError = (stripos($msg, 'error') !== false || stripos($msg, 'Only') !== false);
                    $cls = $isError ? 'message error' : 'message';
                    echo "<p class='{$cls}'>$msg</p>";
                } ?>

                <form id="uploadForm" action="resume.php" method="POST" enctype="multipart/form-data" novalidate>
                    <div id="dropzone" class="drop" tabindex="0" aria-describedby="dropHelp">
                        <div class="icon" aria-hidden="true">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                <path d="M12 16V4m0 0l-4 4m4-4l4 4M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div style="text-align:center">
                            <div style="font-weight:600; letter-spacing:.2px">Drag & drop your resume here</div>
                            <div class="hint" id="dropHelp">or click to browse your files</div>
                            <div class="formats">Accepted formats: PDF, DOC, DOCX</div>
                            <div id="fileName" class="hint" style="margin-top:6px; display:none"></div>
                        </div>
                        <input id="fileInput" class="hidden-input" type="file" name="resume" required />
                    </div>

                    <div class="actions" style="margin-top:14px">
                        <button type="submit" class="btn" id="submitBtn">Upload Resume</button>
                        <button type="button" class="btn ghost" id="clearBtn">Clear Selection</button>
                    </div>
                    <p class="note">By uploading, you agree to our terms. Make sure your resume does not include sensitive personal numbers.</p>
                </form>
            </div>
        </section>

        <section class="card" aria-labelledby="historyTitle">
            <div class="card-head">
                <h3 id="historyTitle">Your Uploaded Resumes</h3>
                <small style="color:var(--muted)">Latest first</small>
            </div>
            <div class="card-body">
                <div class="table-wrap">
                    <table role="table" aria-label="Uploaded resumes table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>File Name</th>
                            <th>Uploaded At</th>
                            <th>View</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM resumes WHERE user_id = $user_id ORDER BY uploaded_at DESC");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $fid = htmlspecialchars($row['id']);
                                $fname = htmlspecialchars($row['filename']);
                                $fwhen = htmlspecialchars($row['uploaded_at']);
                                $fpath = htmlspecialchars($row['filepath']);
                                echo "<tr>
                                        <td>{$fid}</td>
                                        <td title='{$fname}' style='max-width:280px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;'>{$fname}</td>
                                        <td>{$fwhen}</td>
                                        <td><a class='link' href='{$fpath}' target='_blank' rel='noopener'>View</a></td>
                                        <td><a class='link' href='resume.php?delete={$fid}' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' style='color:#a5b4fc'>No resumes uploaded yet.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

<div id="toast" class="toast" role="status" aria-live="polite"></div>

<script>
(function(){
    const drop = document.getElementById('dropzone');
    const input = document.getElementById('fileInput');
    const nameEl = document.getElementById('fileName');
    const clearBtn = document.getElementById('clearBtn');
    const form = document.getElementById('uploadForm');
    const submitBtn = document.getElementById('submitBtn');
    const toast = document.getElementById('toast');

    const showToast = (msg) => {
        toast.textContent = msg;
        toast.classList.add('show');
        setTimeout(()=> toast.classList.remove('show'), 2400);
    };

    const setFileName = (file) => {
        if(!file){ nameEl.style.display='none'; nameEl.textContent=''; return; }
        nameEl.textContent = 'Selected: ' + file.name;
        nameEl.style.display='block';
    };
    const prevent = e => { e.preventDefault(); e.stopPropagation(); };
    ['dragenter','dragover','dragleave','drop'].forEach(evt => {
        drop.addEventListener(evt, prevent, false);
    });
    drop.addEventListener('dragover', () => drop.style.borderColor='rgba(59,130,246,.9)');
    drop.addEventListener('dragleave', () => drop.style.borderColor='rgba(148,163,184,.35)');
    drop.addEventListener('drop', (e)=>{
        const dt = e.dataTransfer;
        if(dt && dt.files && dt.files[0]){
            input.files = dt.files;
            setFileName(dt.files[0]);
        }
        drop.style.borderColor='rgba(148,163,184,.35)';
    });
    drop.addEventListener('click', () => input.click());
    drop.addEventListener('keydown', (e)=>{ if(e.key==='Enter' || e.key===' '){ e.preventDefault(); input.click(); } });

    input.addEventListener('change', (e) => {
        const f = e.target.files && e.target.files[0];
        setFileName(f);
        if(f) showToast('Ready to upload: ' + f.name);
    });

    clearBtn.addEventListener('click', ()=>{
        input.value='';
        setFileName(null);
        showToast('Selection cleared');
    });

    form.addEventListener('submit', ()=>{
        drop.classList.add('uploading');
        submitBtn.disabled = true;
        submitBtn.style.opacity = .8;
        submitBtn.textContent = 'Uploading...';
    });
})();
</script>
</body>
</html>
