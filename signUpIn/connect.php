<?php
$host = "localhost";
$user = "root";
$password = "Ujjawal@7307";
$db = "signupforms";

$con = mysqli_connect($host, $user, $password, $db);


if (!$con) {
    die(mysqli_error($con)); // Display error only if connection fails
}


?>