<?php
include("connect.php");

$query = "SELECT * FROM users";
$data = $connect->query($query)
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome <?php $data ?></h1>
</body>
</html>