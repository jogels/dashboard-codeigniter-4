<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>System Information Management OPS</title>

  <!-- General CSS Files -->
  
  <link  rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

 <!-- CSS Libraries -->
  

  <!-- Template CSS -->
  <link  rel="stylesheet" href="/template/assets/css/style.css">
    <link rel="stylesheet" href="/template/assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
           <center> <div class="login-brand">
              <img src="<?= base_url() ?>/template/assets/img/ipsos.png" alt="logo" width="100" class="shadow-light rounded-circle">
            </div><br></center>
            
            <?php
            $session = session();
            $login = $session->getFlashdata('login');
            $username = $session->getFlashdata('username');
            $password = $session->getFlashdata('password');
            ?>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              
               <?php if ($username) { ?>
                <p style="color:red"><?php echo $username ?></p>
              <?php } ?>

              <?php if ($password) { ?>
                <p style="color:red"><?php echo $password ?></p>
              <?php } ?>

              <?php if ($login) { ?>
                <p style="color:green"><?php echo $login ?></p>
              <?php } ?>




              <div class="card-body">
                <form method="POST" action="<?= site_url('/auth/valid_login') ?>" class="needs-validation" novalidate="">
                    <?= csrf_field() ?>
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>

                

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>


              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="<?= site_url('/auth/register') ?>">Create One</a>
            </div>
            <div class="simple-footer">
              Copyright &copy; Ipsos
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="template/assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="/template/assets/js/scripts.js"></script>
  <script src="/template/assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>

</html>