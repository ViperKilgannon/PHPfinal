<?php
include "config.php";

switch(){
    case 1: 
        include "/handler/getCurrentUsers.php";
        break;
    case 2:
        include "/handler/createUser.php";
        break;
}


$data = json_decode(file_get_contents("php://input"));

$request = $data->request;

// Fetch current signed in records
if($request == 1){
  $userData = mysqli_query($con,"select * from signedIn order by id");

  $response = array();
  while($row = mysqli_fetch_assoc($userData)){
    $response[] = $row;
  }

  echo json_encode($response);
  exit;
}

// Add new user record
if($request == 2){
  $username = $data->username;
  $name = $data->name;
  $password = $data->password_hash($password, PASSWORD_DEFAULT);;

  $userData = mysqli_query($con,"SELECT * FROM users WHERE username='".$username."'");
  if(mysqli_num_rows($userData) == 0){
    mysqli_query($con,"INSERT INTO users(username,name,email) VALUES('".$username."','".$name."','".$password."')");
    echo "Insert successfully";
  }else{
    echo "Username already exists.";
  }

  exit;
}

// Update record
if($request == 3){
  $id = $data->id;
  $name = $data->name;
  $email = $data->email;

  mysqli_query($con,"UPDATE users SET name='".$name."',email='".$email."' WHERE id=".$id);
 
  echo "Update successfully";
  exit;
}

// Delete record
if($request == 4){
  $id = $data->id;

  mysqli_query($con,"DELETE FROM users WHERE id=".$id);

  echo "Delete successfully";
  exit;
}
?>