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
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
  <style>
    body {
      background: url('<?= base_url("assets/img/") ?>IMG_1602.jpg') no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
  </style>
</head>

<body class="gray-bg">
  <div class="loginColumns animated fadeInDown">
    <div class="row">
      <div class="col-sm-12 col-md-6 offset-md-6">
        <?php
        if (flashdata('msg')) {
          echo flashdata('msg');
        }
        ?>
        <div class="ibox-content" style="background-color: rgba(255,255,255,0.8)">
          <center><img src=" <?= base_url('assets/img/') ?>logo.png" height="70px">
          </center>
          <form class="m-t" role="form" method="post" action="<?= base_url('Auth') ?>">
            <div class="form-group">
              <input type="text" name="username_user" id="username_user" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
              <input type="password" name="password_user" id="password_user" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
              <input type="text" name="location" id="location" class="form-control" readonly hidden>
            </div>

            <div id='map' hidden></div>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
          </form>
          <a href="<?= base_url('Auth/ForgotPassword') ?>"><small>Forgot Password?</small></a>
          <p class="text-muted text-center">
            <small>Do not have an account? Register Here as:</small>
          </p>
          <!-- <div class="row">
            <div class="col-sm-12 col-md-6" style="margin-bottom: 5px">
              <a href="#" style="color: inherit">
                <button class="btn btn-sm btn-white btn-block">Staff Laboratory</button>
              </a>
            </div>
            <div class="col-sm-12 col-md-6" style="margin-bottom: 5px">
              <a href="<?= base_url('Auth/RegisterLecture') ?>" style="color: inherit">
                <button class="btn btn-sm btn-white btn-block">Lecturer</button>
              </a>
            </div>
          </div> -->
          <div class="row">
            <div class="col-sm-12 col-md-6" style="margin-bottom: 5px">
              <a href="<?= base_url('Auth/RegisterAslab') ?>" style="color: inherit">
                <button type="button" class="btn btn-sm btn-white btn-block">Laboratory Assistant</button>
              </a>
            </div>
            <div class="col-sm-12 col-md-6" style="margin-bottom: 5px">
              <a href="<?= base_url('Auth/RegisterAsprak') ?>" style="color: inherit">
                <button class="btn btn-sm btn-white btn-block">Practicum Assistant</button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= base_url('assets/inspinia/') ?>js/jquery-3.1.1.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
  <script>
    $('#username_user').on('input', function(e) {
      $(this).val(function(i, v) {
        return v.replace(/[^\a-z]/gi, '');
      });
    });

    window.setTimeout(function() {
      $(".msg").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 3500);

    const map = L.map('map').fitWorld();

    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    function onLocationFound(e) {
      document.getElementById('location').value = e.latlng;
    }

    function onLocationError(e) {
      // alert(e.message);
      console.log(e.message);
    }

    map.on('locationfound', onLocationFound);
    map.on('locationerror', onLocationError);

    map.locate({
      setView: true,
      maxZoom: 16
    });
  </script>
</body>

</html>