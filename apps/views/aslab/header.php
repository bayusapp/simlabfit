<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Sistem Informasi Manajemen (SIM) Laboratorium, Fakultas Ilmu Terapan, Telkom University">
  <meta name="author" content="Alit Yuniargan Eskaluspita, Bayu Setya Ajie Perdana Putra, Fajri Ardiansyah">
  <title><?= $title ?></title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>" />
  <link href="<?= base_url('assets/inspinia/') ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/dataTables/datatables.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/datapicker/datepicker3.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/select2/select2.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/iCheck/custom.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/plugins/toastr/toastr.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/animate.css" rel="stylesheet">
  <link href="<?= base_url('assets/inspinia/') ?>css/style.css" rel="stylesheet">
  <style>
    .select2-dropdown {
      z-index: 10060 !important;
      /*1051;*/
    }

    .select2 {
      width: 100% !important;
    }
  </style>
</head>

<body class="fixed-sidebar">
  <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
          <li class="nav-header">
            <div class="dropdown profile-element">
              <?php
              if (userdata('login') == 'laboran') {
              ?>
                <img alt="image" class="rounded-circle" src="<?= base_url('assets/') ?>img/302383.jpg" height="48px" width="48px" />
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                  <span class="block m-t-xs font-bold"><?= userdata('nama') ?></span>
                  <span class="text-muted text-xs block"><?= userdata('jabatan') ?></span>
                </a>
              <?php
              } elseif (userdata('login') == 'aslab') {
                $data_aslab = $this->db->get_where('aslab', array('idAslab' => userdata('id_aslab')))->row();
                if ($data_aslab->fotoAslab == null) {
                  $foto = base_url('assets/img/person-flat.png');
                } else {
                  $foto = base_url($data_aslab->fotoAslab);
                }
              ?>
                <img alt="image" class="rounded-circle" src="<?= $foto ?>" height="48px" width="48px" />
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                  <span class="block m-t-xs font-bold"><?= $data_aslab->namaLengkap ?></span>
                  <span class="text-muted text-xs block"><?= userdata('jabatan') ?></span>
                </a>
              <?php
              }
              ?>
            </div>
            <div class="logo-element">
              <img alt="image" class="rounded-circle" src="<?= base_url('assets/') ?>img/favicon.png" height="50px" height="50px">
            </div>
          </li>
          <?php
          if (uri('1') == 'Dashboard') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Dashboard') ?>">
            <i class="fa fa-dashboard"></i>
            <span class="nav-label">Dashboard</span>
          </a>
          </li>
          <?php
          if (uri('1') == 'StockLists') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('StockLists') ?>">
            <i class="fa fa-barcode"></i>
            <span class="nav-label">Stock Lists</span>
          </a>
          </li>
          <?php
          if (uri('2') == 'Practicum' || uri('2') == 'ViewLaboratory' || uri('2') == 'Research') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="#">
            <i class="fa fa-bank"></i>
            <span class="nav-label">Laboratory</span>
            <span class="fa arrow"></span>
          </a>
          <ul class="nav nav-second-level collapse">
            <?php
            if (uri('2') == 'Practicum') {
              echo '<li class="active">';
            } else {
              echo '<li>';
            }
            ?>
            <a href="<?= base_url('Laboratory/Practicum') ?>">Practicum</a>
            </li>
            <?php
            if (uri('2') == 'Research') {
              echo '<li class="active">';
            } else {
              echo '<li>';
            }
            ?>
            <a href="<?= base_url('Laboratory/Research') ?>">Research</a>
            </li>
          </ul>
          </li>
          <?php
          $id_aslab = substr(sha1(userdata('id_aslab')), 6, 4);
          if ((uri('1') == 'LaboratoryAssistant' && (uri('3') != $id_aslab && uri('2') != 'Report')) || uri('2') == 'ProfileAssistant' && uri('3') != $id_aslab) {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('LaboratoryAssistant') ?>">
            <i class="fa fa-users"></i>
            <span class="nav-label">Laboratory Assistant</span>
          </a>
          </li>
          <?php
          if (uri('2') == 'ProfileAssistant' && uri('3') == $id_aslab) {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . $id_aslab) ?>">
            <i class="fa fa-users"></i>
            <span class="nav-label">Your Profile</span>
          </a>
          </li>
          <?php
          if (uri('1') == 'Schedule') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Schedule') ?>">
            <i class="fa fa-calendar"></i>
            <span class="nav-label">Schedule</span>
          </a>
          </li>
          <?php
          if (uri('2') == 'Equipment' || uri('2') == 'Laboratory') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="#">
            <i class="fa fa-legal"></i>
            <span class="nav-label">Borrowing</span>
            <span class="fa arrow"></span>
          </a>
          <ul class="nav nav-second-level collapse">
            <?php
            if (uri('2') == 'Equipment') {
              echo '<li class="active">';
            } else {
              echo '<li>';
            }
            ?>
            <a href="<?= base_url('Borrowing/Equipment') ?>">Equipment</a>
            </li>
            <?php
            if (uri('2') == 'Laboratory') {
              echo '<li class="active">';
            } else {
              echo '<li>';
            }
            ?>
            <a href="<?= base_url('Borrowing/Laboratory') ?>">Laboratory</a>
            </li>
          </ul>
          </li>
          <?php
          if (uri('1') == 'Complaint') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Complaint') ?>">
            <i class="fa fa-thumbs-down"></i>
            <span class="nav-label">Complaint</span>
          </a>
          </li>
          <?php
          if (uri('1') == 'Finance') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Finance/Honor') ?>">
            <i class="fa fa-money"></i>
            <span class="nav-label">Salary</span>
          </a>
          </li>
          <?php
          if (uri('2') == 'Report') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('LaboratoryAssistant/Report') ?>">
            <i class="fa fa-file-o"></i>
            <span class="nav-label">Report</span>
          </a>
          </li>
          <?php
          if (uri('1') == 'Setting') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('Setting') ?>">
            <i class="fa fa-gear"></i>
            <span class="nav-label">Setting</span>
          </a>
          </li>
          <?php
          if (uri('1') == 'HistoryLogin') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
          <a href="<?= base_url('HistoryLogin') ?>">
            <i class="fa fa-history"></i>
            <span class="nav-label">History Login</span>
          </a>
          </li>
        </ul>
      </div>
    </nav>
    <div id="page-wrapper" class="gray-bg dashbard-1">
      <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
          <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#">
              <i class="fa fa-bars"></i>
            </a>
          </div>
          <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
              <a class="dropdown-toggle count-info" data-toggle="dropdown" href="<?= base_url('assets/inspinia/') ?>#">
                <i class="fa fa-bell"></i>
                <span class="label label-primary"><?= $jumlah_komplain + $jumlah_pinjam_alat + $jumlah_pinjam_lab ?></span>
              </a>
              <ul class="dropdown-menu dropdown-alerts">
                <li>
                  <a href="<?= base_url('Complaint') ?>" class="dropdown-item">
                    <div>
                      <i class="fa fa-thumbs-down fa-fw"></i> You have <?= $jumlah_komplain ?> complaint(s)
                    </div>
                  </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                  <a href="<?= base_url('Borrowing/Equipment') ?>" class="dropdown-item">
                    <div>
                      <i class="fa fa-hdd-o fa-fw"></i> You have <?= $jumlah_pinjam_alat ?> borrowing equipment(s)
                    </div>
                  </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                  <a href="<?= base_url('Borrowing/Laboratory') ?>" class="dropdown-item">
                    <div>
                      <i class="fa fa-hotel fa-fw"></i> You have <?= $jumlah_pinjam_lab ?> borrowing laboratory(s)
                    </div>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <a href="<?= base_url('Auth/Logout') ?>">
                <i class="fa fa-sign-out"></i> Log out
              </a>
            </li>
          </ul>
        </nav>
      </div>