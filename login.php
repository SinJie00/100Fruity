
<?php
	session_start();
  //Redirect the user to index page if logged in.
  if (isset($_SESSION['login'])){
    header('Location: index.php');
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="api/assets/img/logo-ct-dark.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <title>
    Login
  </title>
  <!--  Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="api/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="api/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="api/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="api/assets/css/soft-ui-dashboard.css?v=1.0.6" rel="stylesheet" />
</head>
<body class="" background="api/assets/img/background.jpg" style="background-size:cover;">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card mt-11">
                <div class="card-header text-center">
                  <h3 class="font-weight-bolder text-info text-gradient">Welcome to <br> 100% Fruit Inventory System</h3>
                </div>
                <div class="card-body">
                  <form role="form" id="loginform">
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="text" name="email" id="email" class="form-control" aria-label="Email" aria-describedby="email-addon">
                      <small id="validateemail" class="text-danger"></small>
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="password" name="password" id="password" class="form-control" aria-label="Password" aria-describedby="password-addon">
                      <small id="validatepassword" class="text-danger"></small>
                    </div>
                    <div class="text-center">
                      <input type="submit" id="btnlogin" class="btn bg-gradient-info w-100 mt-4 mb-0" value="Login">
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-2 text-sm mx-auto">
                    Don't have an account?
                    <a href="register.php" class="text-info text-gradient font-weight-bold">Register</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-white">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> 100% Fruity Inventory System 2022 by Full House
          </p>
        </div>
      </div>
    </div>
  </footer>
</body>
<script src="api/assets/js/login.js">
</script>
</html>

