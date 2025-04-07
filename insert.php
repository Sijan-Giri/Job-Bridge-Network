
<?php

include('connect.php');

$admin_username = $_POST['name'];
$admin_email = $_POST['email'];
$admin_pass = $_POST['password'];

$query = "INSERT INTO users (name,email,password) VALUES('$name' , '$email' , '$password')";

if($connect->query($query) == true) {
    header("Location:dashboard.php");
}
else {
    echo("Something went wrong!");
}
?>