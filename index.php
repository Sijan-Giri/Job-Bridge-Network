<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JobSeeker - Premium Job Search</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Inter',sans-serif; }
    body { color:#212529; background:#f8f9fa; }
    a { text-decoration:none; color:inherit; }

    .hero { display:flex; justify-content:space-between; align-items:center; padding:80px 100px; background:#f8f9fa; flex-wrap:wrap; }
    .hero-left { max-width:550px; }
    .hero-left h1 { font-size:48px; font-weight:700; margin-bottom:20px; }
    .hero-left p { font-size:16px; color:#6c757d; margin-bottom:30px; }
    .hero-right img { max-width:500px; border-radius:8px; }

    .trusted { text-align:center; padding:60px 20px; }
    .trusted h2 { font-size:24px; margin-bottom:25px; }
    .trusted img { max-height:40px; margin:0 20px; vertical-align:middle; }

    .filters { display:flex; flex-wrap:wrap; justify-content:center; gap:15px; padding:30px 20px; background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.05); margin:30px auto; max-width:1200px; }
    .filters input, .filters select, .filters button { padding:10px 15px; border:1px solid #dee2e6; border-radius:6px; font-size:14px; }
    .filters button { background:#1d4ed8; color:white; cursor:pointer; font-weight:600; }
    .filters button:hover { background:#1e40af; }

    .card-container { display:flex; flex-wrap:wrap; justify-content:center; gap:30px; padding:40px 20px; }
    .card { width:280px; background:#fff; border:1px solid #e5e7eb; border-radius:0.5rem; box-shadow:0 1px 2px rgba(0,0,0,0.05); overflow:hidden; transition:transform 0.3s; display:flex; flex-direction:column; }
    .card:hover { transform:translateY(-5px); }
    .card-img { width:100%; height:180px; object-fit:cover; }
    .card-body { padding:1.25rem; flex:1; display:flex; flex-direction:column; }
    .card-title { font-size:1.2rem; font-weight:700; margin-bottom:0.5rem; color:#111827; }
    .card-text { font-size:0.9rem; color:#4b5563; margin-bottom:10px; flex:1; }
    .card-btn { display:inline-flex; align-items:center; padding:0.5rem 0.75rem; font-size:0.875rem; font-weight:500; color:#fff; background-color:#1d4ed8; border-radius:0.5rem; text-decoration:none; justify-content:center; }
    .card-btn:hover { background-color:#1e40af; }
    .category-badge { display:inline-block; background-color:#10B981; color:white; padding:4px 10px; border-radius:9999px; font-size:12px; margin-bottom:5px; }
    .card-location, .card-type, .card-salary { font-size:12px; color:#6b7280; margin-bottom:4px; }

    @media (max-width:992px) { .hero { flex-direction:column; text-align:center; padding:50px 20px; } .hero-right img { max-width:100%; margin-top:30px; } }
  </style>
</head>
<body>

<section class="hero">
  <div class="hero-left">
    <h1>Find Your Perfect Dream Jobs With JobSeeker</h1>
    <p>Good life begins with a good company. Explore thousands of jobs in one place and find your dream job.</p>
  </div>
  <div class="hero-right">
    <img src="https://karunasarawak.com/wp-content/uploads/2023/10/job-vacancy-Kuching-at-Karuna-min.jpg" alt="Hero Image">
  </div>
</section>

<section class="trusted">
  <h2>Trusted <span style="color:#0d6efd;">1000+</span> companies find best jobseekers</h2>
  <div class="companies">
    <img src="https://cdn.mos.cms.futurecdn.net/R4DgSdP6erUexko5KuX6UF-970-80.jpg.webp" alt="YouTube">
    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" alt="Google">
    <img src="https://upload.wikimedia.org/wikipedia/commons/1/19/Spotify_logo_without_text.svg" alt="Spotify">
    <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Pinterest-logo.png" alt="Pinterest">
    <img src="https://upload.wikimedia.org/wikipedia/commons/3/33/Figma-logo.svg" alt="Figma">
  </div>
</section>

<section class="filters">
  <form method="GET" style="display:flex; flex-wrap:wrap; gap:15px; justify-content:center;">
    <input type="text" name="keyword" placeholder="Search jobs by title or skill" value="<?php echo $_GET['keyword'] ?? '' ?>">
    
    <select name="category">
      <option value="">All Categories</option>
      <?php
        include('database/db_connect.php');
        $catQuery = "SELECT * FROM categories";
        $catResult = mysqli_query($conn, $catQuery);
        while($cat = mysqli_fetch_assoc($catResult)){
          $selected = (isset($_GET['category']) && strtolower($_GET['category']) == strtolower($cat['name'])) ? 'selected' : '';
          echo '<option value="'.strtolower($cat['name']).'" '.$selected.'>'.htmlspecialchars($cat['name']).'</option>';
        }
      ?>
    </select>

    <select name="location">
      <option value="">All Locations</option>
      <?php
        $locQuery = "SELECT DISTINCT location FROM jobs";
        $locResult = mysqli_query($conn, $locQuery);
        while($loc = mysqli_fetch_assoc($locResult)){
          $selected = (isset($_GET['location']) && strtolower($_GET['location']) == strtolower($loc['location'])) ? 'selected' : '';
          echo '<option value="'.strtolower($loc['location']).'" '.$selected.'>'.htmlspecialchars($loc['location']).'</option>';
        }
      ?>
    </select>

    <select name="jobtype">
      <option value="">All Types</option>
      <?php 
        $types = ["full-time","part-time","internship","remote"];
        foreach($types as $t){
          $selected = (isset($_GET['jobtype']) && $_GET['jobtype']==$t) ? 'selected' : '';
          echo "<option value='$t' $selected>".ucfirst($t)."</option>";
        }
      ?>
    </select>

    <input type="range" name="salary" min="0" max="200000" step="5000" 
           value="<?php echo $_GET['salary'] ?? 200000; ?>" 
           oninput="document.getElementById('salaryLabel').textContent='Max Salary: Rs.'+this.value">
    <span id="salaryLabel">Max Salary: Rs.<?php echo $_GET['salary'] ?? 200000; ?></span>

    <button type="submit">Apply Filter</button>
  </form>
</section>

<section class="card-container" id="cardContainer">
  <?php
    // build SQL with filters
    $conditions = [];
    if(!empty($_GET['keyword'])){
      $kw = mysqli_real_escape_string($conn, $_GET['keyword']);
      $conditions[] = "(j.name LIKE '%$kw%' OR j.description LIKE '%$kw%' OR j.skill LIKE '%$kw%')";
    }
    if(!empty($_GET['category'])){
      $cat = mysqli_real_escape_string($conn, $_GET['category']);
      $conditions[] = "LOWER(c.name) = '$cat'";
    }
    if(!empty($_GET['location'])){
      $loc = mysqli_real_escape_string($conn, $_GET['location']);
      $conditions[] = "LOWER(j.location) = '$loc'";
    }
    if(!empty($_GET['jobtype'])){
      $jt = mysqli_real_escape_string($conn, $_GET['jobtype']);
      $conditions[] = "LOWER(j.timing) = '$jt'";
    }
    if(!empty($_GET['salary'])){
      $sal = intval($_GET['salary']);
      $conditions[] = "j.salary <= $sal";
    }

    $where = count($conditions) ? "WHERE ".implode(" AND ", $conditions) : "";
    $query = "SELECT j.*, c.name AS catname FROM jobs j LEFT JOIN categories c ON j.catid=c.catid $where ORDER BY j.date DESC";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        echo '<div class="card">';
        echo '<a href="singlejob.php?id='.$row['jobid'].'"><img class="card-img" src="https://images.stockcake.com/public/a/8/7/a878486a-27b3-4c4e-9ab7-4227831a98dc_large/software-developer-working-stockcake.jpg" alt="Job Image"></a>';
        echo '<div class="card-body">';
        echo '<span class="category-badge">'.htmlspecialchars($row['catname']).'</span>';
        echo '<h5 class="card-title">'.htmlspecialchars($row['name']).'</h5>';
        echo '<p class="card-text">'.htmlspecialchars($row['description']).'</p>';
        echo '<a href="singlejob.php?id='.$row['jobid'].'" class="card-btn">Read More</a>';
        echo '</div></div>';
      }
    } else {
      echo '<p style="text-align:center;">No jobs found.</p>';
    }
  ?>
</section>

</body>
<?php include('footer.php'); ?>
</html>
