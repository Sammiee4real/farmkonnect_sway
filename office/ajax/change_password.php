<?php 
  require_once('../config/database_functions.php');
  $passcode = $_POST['passcode'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];

  // echo explode('_', $passcode)[0];

  $password_reset = confirm_password_change($passcode,$password,$cpassword);
  $password_reset_dec = json_decode($password_reset,true); 
     if($password_reset_dec['status'] != 111){
        echo $password_reset_dec['msg'];
      } else{
        echo 200;
      }

  



?>