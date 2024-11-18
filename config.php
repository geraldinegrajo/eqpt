<?php
// Database configuration
$host = 'localhost'; // Your database host
$db = 'ITC127ETEEAPBATCH2-2024-FERRERA'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

$link = mysqli_connect($host, $user, $pass, $db);

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
