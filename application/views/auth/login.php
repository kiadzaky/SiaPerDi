<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url() ?>/node_modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/components.css">
  
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('pwa') ?>/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('pwa') ?>/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('pwa') ?>/favicon-16x16.png">
  <link rel="manifest" href="<?= base_url() ?>/site.webmanifest">
  <link rel="mask-icon" href="<?= base_url('pwa') ?>/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#00aba9">
  <meta name="theme-color" content="#ffffff">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/upup/addtohomescreen.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
            <img src="<?= base_url('assets/img/unsplash/pd.jpg') ?>" alt="logo" width="80" class="shadow-light rounded-circle mb-5 mt-2">
            <h4 class="text-dark font-weight-normal">Selamat Datang <span class="font-weight-bold">Admin dan Pelatih</span></h4>
            <p class="text-muted">Login dahulu sebelum masuk.</p>
            <?= $this->session->userdata('message'); ?>
            <form method="POST" action="<?=base_url('auth')?>" class="needs-validation" novalidate="">
              <div class="form-group">
                <label for="email">Username</label>
                <input id="email" type="text" class="form-control" name="username" tabindex="1" required autofocus>
                <div class="invalid-feedback">
                  Please fill in your Username
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

              <!-- <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                  <label class="custom-control-label" for="remember-me">Remember Me</label>
                </div>
              </div> -->

              <div class="form-group text-right">
                <!-- <a href="auth-forgot-password.html" class="float-left mt-3">
                  Forgot Password?
                </a> -->
                <input type="submit" name="submit" value="MASUK" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
              </div>

              <!-- <div class="mt-5 text-center">
                Don't have an account? <a href="auth-register.html">Create new one</a>
              </div> -->
            </form>
            
            <div class="text-center mt-5 text-small">
              Copyright &copy; 💙 by Stisla and Kia Dzaky
              <!-- <div class="mt-2">
                <a href="#">Privacy Policy</a>
                <div class="bullet"></div>
                <a href="#">Terms of Service</a>
              </div> -->
            </div>
          </div>
        </div>
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="<?= base_url('assets/img/unsplash/pd.jpg') ?>">
          <div class="absolute-bottom-left index-2">
            <div class="text-light p-5 pb-2">
              <div class="mb-5 pb-3">
                <h1 class="mb-2 display-4 font-weight-bold">Selamat Datang</h1>
                <h5 class="font-weight-normal text-muted-transparent">Perisai Diri Jember</h5>
              </div>
              <!-- Photo by <a class="text-light bb" target="_blank" href="https://unsplash.com/photos/a8lTjWJJgLA">Justin Kauffman</a> on <a class="text-light bb" target="_blank" href="https://unsplash.com">Unsplash</a> -->
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
  <script src="<?= base_url() ?>/assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="<?= base_url() ?>/assets/js/scripts.js"></script>
  <script src="<?= base_url() ?>/assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script src="<?=base_url('upup/')?>/upup.min.js"></script>
  <script>
    UpUp.start({
      'content-url': '<?=base_url()?>',
      'service-worker-url': '<?=base_url('upup/')?>upup.sw.min.js',
      'content': 'Cek Koneksi Anda',
      // 'assets': ['css/bootstrap.min.css', 'css/offline.css']
    });
  </script>
  <script>
   if ('serviceWorker' in navigator) {
      console.log("Will the service worker register?");
      navigator.serviceWorker.register('<?=base_url('upup/')?>upup.sw.min.js')
        .then(function(reg){
          console.log("Yes, it did.");
         addToHomescreen();
       }).catch(function(err) {
          console.log("No it didn't. This happened:", err);
          
      });
   }
  </script>
  <script type="text/javascript" src="<?=base_url('upup/')?>/addtohomescreen.js"></script>
  <script type="text/javascript" src="<?=base_url('upup/')?>/addtohomescreen.min.js"></script>
  <script type="text/javascript">
    if(
    (("standalone" in window.navigator) && !window.navigator.standalone) // ios
    || //or
      (!window.matchMedia('(display-mode: standalone)').matches)// android
    ){
      addToHomescreen();
    }
    
  </script>
</body>
</html>
