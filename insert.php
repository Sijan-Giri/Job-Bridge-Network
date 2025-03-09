
<?php

include('connect.php');

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$query = "INSERT INTO users (name,email,password,user_type,phone,address) VALUES('$name' , '$email' , '$password' , '$user_type' , '$phone' , '$address')";

if($connect->query($query) == true) {
    header("Location:dashboard.php");
}
else {
    echo("Something went wrong!");
}
?>