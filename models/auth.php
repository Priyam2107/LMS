<?php
ini_set('SMTP', "server.com");
ini_set('smtp_port', "587");
ini_set('sendmail_from', "priyamjain021@gmail.com");

//function to login
function login($conn, $param)
{
  extract($param);

  $sql = "select * from users where email = '$email'";
  $res = $conn->query($sql);
  if ($res->num_rows > 0) {
    $user = $res->fetch_assoc();
    $hash = $user['password'];
    if (password_verify($password, $hash)) {
      $result = array('status' => true, 'user' => $user);
    } else {
      $result = array('status' => false);
    }
  } else {
    $result = array('status' => false);
  }
  return $result;
}


//function to forgot password
function forgotPassword($conn, $param)
{
  extract($param);

  $sql = "select * from users where email = '$email'";
  $res = $conn->query($sql);
  if ($res->num_rows > 0) {
    $user = $res->fetch_assoc();
  
    $user_id = $user['id'];
    $datetime = date("Y-m-d H:i:s");

    //Generate otp
    $otp = rand(1111, 9999);

    //Send reset password email with otp
    $to = $email;
    $subject = "Forgot Password Request";
    $message = "Please use this OTP <b>$otp</b> to reset your password";
    // $headers = "From: webmaster@lms.com" . "\r\n";
    $res = mail($to, $subject, $message);
   var_dump($res);
    exit;
    if($res){
      $result = array('status' => true);
      $sql = "insert into reset_password (user_id, reset_code, created_at) values ($user_id, '$otp' '$datetime')";
      $conn->query($sql);
      $result = array('status' => true);
    } else {
      $result = array('status' => false);
    }
  } else {
    $result = array('status' => false);
  }
  return $result;
}
