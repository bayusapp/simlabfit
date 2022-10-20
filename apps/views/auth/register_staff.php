<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistem Informasi Manajemen (SIM) Laboratorium, Fakultas Ilmu Terapan, Telkom University">
  <meta name="author" content="Alit Yuniargan Eskaluspita, Bayu Setya Ajie Perdana Putra, Fajri Ardiansyah">
  <title><?= $title ?></title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>" />
  <link href="<?= base_url('assets/inspinia/') ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/animate.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/style.css" rel="stylesheet">
  <style>
    html,
    body {
      height: 100%;
      margin: 0 2% 0 2%;
      background: url('<?= base_url("assets/img/") ?>IMG_1602.jpg') no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
  </style>
</head>

<body>
  <div class="h-100 row align-items-center animated fadeInDown">
    <div class="col">
      <div class="row">
        <div class="col-sm-12 col-md-4 offset-md-4">
          <?php
          if (flashdata('msg')) {
            echo flashdata('msg');
          }
          ?>
          <div class="ibox-content" style="background-color: rgba(255,255,255,0.8)">
            <center><img src=" <?= base_url('assets/img/') ?>logo.png" height="70px" style="margin-bottom: 20px">
            </center>
            <h3 style="text-align: center; margin-bottom: 20px">Create New Account for Staff Laboratory</h3>
            <form class="m-t" role="form" method="post" action="<?= base_url('Auth/RegisterStaff') ?>">
              <div class="form-group">
                <input type="text" name="nip_laboran" id="nip_laboran" class="form-control" placeholder="Input Your NIP" required>
              </div>
              <div class="form-group">
                <input type="text" name="username_user" id="username_user" class="form-control" placeholder="Username" required onkeyup="cekUsername()">
                <p id="status_username" style="text-align: center"></p>
              </div>
              <div class="form-group">
                <input type="text" name="email_user" id="email_user" class="form-control" placeholder="Input Your Email" required>
              </div>
              <div class="form-group">
                <input type="password" name="password_user" id="password_user" class="form-control" placeholder="Password" required>
              </div>
              <button type="submit" name="submit" id="submit" class="btn btn-primary block full-width m-b">Register</button>
            </form>
            <p class="text-muted text-center">
              <small>Already have an account?</small>
            </p>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <a href="<?= base_url() ?>" style="color: inherit">
                  <button class="btn btn-sm btn-white btn-block">Login</button>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= base_url('assets/inspinia/') ?>js/jquery-3.1.1.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/bootstrap.min.js"></script>
  <script>
    function cekUsername() {
      var username = document.getElementById('username_user').value;
      if (username) {
        $.ajax({
          url: '<?= base_url('Auth/ajaxCekUsername') ?>',
          type: 'post',
          data: {
            username: username
          },
          success: function(response) {
            if (response == 'null') {
              document.getElementById('submit').disabled = false;
              $('#status_username').html('');
              return true;
            } else {
              document.getElementById('submit').disabled = true;
              $('#status_username').html(response);
              $('#status_username').css('color', '#ff0004', 'important');
              return false;
            }
          }
        });
      } else {
        $('#status_username').html('');
        return false;
      }
    }
  </script>
</body>

</html>