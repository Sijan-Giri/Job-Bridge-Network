<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WerkLinker - Find Your Dream Job</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        body {
            background-color: #f8f9fa;
            color: #212529;
        }
        a {
            text-decoration: none;
            color: inherit;
        }

        /* Hero Section */
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 80px 100px;
            background-color: #f8f9fa;
        }
        .hero-left {
            max-width: 550px;
        }
        .hero-left h1 {
            font-size: 48px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
        }
        .hero-left p {
            font-size: 16px;
            margin-bottom: 30px;
            color: #6c757d;
        }
        .search-box {
            display: flex;
            max-width: 400px;
            margin-top: 20px;
        }
        .search-box input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            border-radius: 6px 0 0 6px;
            outline: none;
            font-size: 14px;
        }
        .search-box button {
            padding: 12px 20px;
            border: none;
            background-color: #0d6efd;
            color: white;
            border-radius: 0 6px 6px 0;
            cursor: pointer;
            font-weight: 500;
        }
        .hero-right img {
            max-width: 500px;
            border-radius: 8px;
        }

        /* Trusted Section */
        .trusted {
            text-align: center;
            padding: 60px 20px;
        }
        .trusted h2 {
            font-size: 24px;
            margin-bottom: 25px;
        }
        .trusted img {
            max-height: 40px;
            margin: 0 20px;
            vertical-align: middle;
        }

        /* Categories Section */
        .categories {
            text-align: center;
            padding: 60px 20px;
        }
        .categories h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .categories p {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 30px;
        }
        .category-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        .category-buttons button {
            padding: 10px 20px;
            border: 1px solid #0d6efd;
            background: white;
            color: #0d6efd;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        .category-buttons button:hover,
        .category-buttons button.active {
            background-color: #0d6efd;
            color: white;
        }

        /* Card Section */
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 60px 20px;
        }
        .card {
            width: 280px;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
        }
        .card:hover { transform: translateY(-5px); }
        .card-img { width: 100%; height: 180px; object-fit: cover; }
        .card-body { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; }
        .card-title { font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem; color: #111827; }
        .card-text { font-size: 0.9rem; color: #4b5563; margin-bottom: 10px; flex:1; }
        .card-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #fff;
            background-color: #1d4ed8;
            border-radius: 0.5rem;
            text-decoration: none;
            justify-content: center;
        }
        .card-btn:hover { background-color: #1e40af; }
        .card-icon { width: 14px; height: 10px; margin-left: 0.5rem; }

        @media (max-width: 992px) {
            .hero { flex-direction: column; text-align: center; padding: 50px 20px; }
            .hero-left { max-width: 100%; }
            .hero-right img { max-width: 100%; margin-top: 30px; }
        }
    </style>
</head>
<?php include('header.php'); ?>
<body>

    <section class="hero">
        <div class="hero-left">
            <h1>Find Your Perfect Dream Jobs With WerkLinker</h1>
            <p>Good life begins with a good company. Start explore thousands of jobs in one place and find your dream job.</p>
            <div class="search-box">
                <input type="text" id="searchInput" onkeyup="filterCards()" placeholder="Search job or skill">
                <button class="button">Find Jobs</button>
            </div>
        </div>
        <div class="hero-right">
            <img src="https://karunasarawak.com/wp-content/uploads/2023/10/job-vacancy-Kuching-at-Karuna-min.jpg" alt="Hero Image">
        </div>
    </section>

    <section class="trusted">
        <h2>Trusted <span style="color:#0d6efd;">1000+</span> company find best jobseeker</h2>
        <div class="companies">
            <img src="https://cdn.mos.cms.futurecdn.net/R4DgSdP6erUexko5KuX6UF-970-80.jpg.webp" alt="YouTube">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" alt="Google">
            <img src="https://upload.wikimedia.org/wikipedia/commons/1/19/Spotify_logo_without_text.svg" alt="Spotify">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Pinterest-logo.png" alt="Pinterest">
            <img src="https://upload.wikimedia.org/wikipedia/commons/3/33/Figma-logo.svg" alt="Figma">
        </div>
    </section>

    <section class="categories">
        <h2>Find your perfect dream jobs</h2>
        <p>WerkLinker present for help candidate for meet the dream company</p>
        <div class="category-buttons">
            <button class="active">All</button>
            <button>Marketing</button>
            <button>Sales</button>
            <button>UI/UX Design</button>
            <button>Developer</button>
            <button>Human Resources</button>
        </div>
    </section>

    <section class="card-container" id="cardContainer">
        <?php
            include('database/db_connect.php');
            $query = "SELECT j.*, c.name AS catname FROM jobs j LEFT JOIN categories c ON j.catid = c.catid ORDER BY j.date DESC";
            $result = mysqli_query($conn, $query);

            if($result && mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="card">';
                    echo '<a href="singlejob.php?id='.$row['jobid'].'"><img class="card-img" src="https://media.istockphoto.com/id/1450969748/photo/developer-working-with-new-program.jpg?s=2048x2048&w=is&k=20&c=iFBySg9gYWU20rRPhwafcTBroJB_0qCBuotH2BcPQGs=" alt="Job Image"></a>';
                    echo '<div class="card-body">';
                    echo '<a href="singlejob.php?id='.$row['jobid'].'"><h5 class="card-title">'.htmlspecialchars($row['name']).'</h5></a>';
                    echo '<p class="card-text">'.htmlspecialchars($row['description']).'</p>';  
                    echo '<a href="singlejob.php?id='.$row['jobid'].'" class="card-btn">Read More<svg class="card-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg></a>';
                    echo '</div></div>';
                }
            } else {
                echo '<p style="text-align:center;">No jobs found.</p>';
            }
        ?>
    </section>

<script>
    function filterCards(){
        const input = document.getElementById('searchInput').value.toLowerCase();
        const cards = document.querySelectorAll('.card');
        cards.forEach(card=>{
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const skill = card.querySelector('.card-body div').textContent.toLowerCase();
            if(title.includes(input) || skill.includes(input)){
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>

</body>
<?php include('footer.php'); ?>
</html>
