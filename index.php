<?php
include_once("./config/config.php");
include_once(DIR_URL . "config/database.php");
include_once(DIR_URL . "models/auth.php");

//If already logged in
if(isset($_SESSION['is_user_login'])) {
  header("LOCATION:" . BASE_URL . "dashboard.php");
}

//Login Functionality  (pizza123)
if (isset($_POST['submit'])) {
  $res = login($conn, $_POST);
  if ($res['status'] == true) {
    $_SESSION['is_user_login'] = true;
    $_SESSION['user'] = $res['user'];
    header("LOCATION:" . BASE_URL . "dashboard.php");
    exit;
  } else {
    $_SESSION['error'] = "Invalid login information";
    header("LOCATION:" . BASE_URL);
    exit;

  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
    href="./assets/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="./assets/css/style.css" />
  <title>Login</title>
</head>
<body style="background-color: #212529;">
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="row">
            <div class="col-md-12 login-form">
                <div class="card mb-3" style="max-width: 900px;">
                    <div class="row g-0">
                      <div class="col-md-5 ">
                        <img  src="./assets/images/login-bg.webp" style="height: 100%;" class="img-fluid rounded-start">
                      </div>
                      <div class="col-md-7">
                        <div class="card-body">
                          <h1 class="card-title text-uppercase fw-bold">Star Library</h1>
                          <?php include_once(DIR_URL . "include/alerts.php"); ?>
                          <p class="card-text">Enter email and password to login</p>
                          <form method="post" action="<?php echo BASE_URL ?>" >
                            <div class="mb-3">
                              <label class="form-label">Email address</label>
                              <input name="email" type="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                              <label  class="form-label">Password</label>
                              <input name="password" type="password" class="form-control" required>
                            </div>
                            <button name="submit" type="submit" class="btn btn-primary">Log in</button>    
                        </form>
                        <hr>
                        <a href="./forgot-password.php" class="card-link link-underline-light">Forgot Password?</a>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/aa09cc742e.js"></script>
</body>
</html>