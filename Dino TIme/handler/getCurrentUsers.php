<?php
$userData = mysqli_query($con,"select * from signedIn order by id");

  $response = array();
  while($row = mysqli_fetch_assoc($userData)){
    $response[] = $row;
?>