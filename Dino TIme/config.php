<?php

$host = "localhost";
$user = "root";
$password = "3258";
$dbname = "Dino";

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
?>