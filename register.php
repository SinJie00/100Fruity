<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="api/assets/img/logo-ct-dark.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <title>
    Register
  </title>
  <!-- Fonts and icons -->
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
<body>
  <main class="main-content  mt-0">
    <section class="">
      <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('api/assets/img/register-bg.jpg');">
        <span class="mask bg-gradient-dark opacity-2"></span>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5 text-center mx-auto">
              <h1 class="text-white mb-2 mt-5">Welcome!</h1>
              <p class="text-lead text-white">100% Fruity Inventory System 2022</p>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row mt-lg-n12 mt-md-n6 mt-n8">
          <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
            <div class="card z-index-0">
              <div class="card-header text-center">
                <h4 class="text-info text-gradient font-weight-bolder">Register</h4>
              </div>
              <div class="card-body mt-lg-n4">
                <form role="form text-left" id="registerform">
                  <label>Full Name</label>
                  <div class="mb-3">
                    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Ali" aria-label="Full Name">
                    <small id="validatefullname" class="text-danger"></small>
                  </div>
                  <label>Username</label>
                  <div class="mb-3">
                    <input type="text" name="username" id="username" class="form-control" placeholder="ali" aria-label="User Name">
                    <small id="validateusername" class="text-danger"></small>
                  </div>
                  <label>Email</label>
                  <div class="mb-3">
                    <input type="text" name="email" id="email" class="form-control" placeholder="xxx@gmail.com" aria-label="Email" aria-describedby="email-addon">
                    <small id="validateemail" class="text-danger"></small>
                  </div>
                  <label>Phone Number</label>
                  <div class="mb-3">
                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="(+60)1x-xxxxxxx | (+60)11-xxxxxxxx | 01x-xxxxxxx " aria-label="Phone" aria-describedby="phone-addon">
                    <small id="validatephone" class="text-danger"></small>
                  </div>
                  <label>Password</label>
                  <div class="mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Ali123" aria-label="Password" aria-describedby="password-addon">
                    <small id="validatepassword" class="text-danger"></small>
                  </div>
                  <div class="text-center">
                    <input type="submit" class="btn bg-gradient-info w-100 my-4 mb-2" value="Register">
                  </div>
                  <p class="text-sm mt-3 mb-0">Already have an account? <a href="login.php" class="text-info text-gradient font-weight-bold">Login</a></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-8 mx-auto text-center">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> 100% Fruity Inventory System 2022 by Full House
          </p>
        </div>
      </div>
    </div>
  </footer>
  </main>
<script src="api/assets/js/register.js">
</script>
</body>
</html>
