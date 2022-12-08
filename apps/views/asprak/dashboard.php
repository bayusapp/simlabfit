      <div class="wrapper wrapper-content animated fadeInDown">
        <div class="row">
          <div class="col-md-12">
            <?php
            if (flashdata('msg')) {
              echo flashdata('msg');
            }
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-6">
            <?php
            $jam_sekarang = date('H:i');
            $org = check_org_ip();
            if ($org == 'TELKOM UNIVERSITY') {
              if ($jadwal_asprak == 'true') {
                if ($tap_masuk == 'belumMasuk') {
            ?>
                  <a href="<?= base_url('Asprak/SubmitTapMasuk/' . $cek_jadwal->id_jadwal_asprak . '/' . $cek_jadwal->id_jadwal_lab) ?>">
                    <div class="widget style1 navy-bg">
                      <div class="row">
                        <div class="col-sm-2">
                          <i class="fa fa-check-circle-o fa-3x"></i>
                        </div>
                        <div class="col-sm-10 text-right">
                          <span>You Can Click Here for Your Presence in</span>
                          <h4 class="font-bold"><?= $cek_jadwal->kelas . ' | ' . $cek_jadwal->nama_mk ?></h4>
                        </div>
                      </div>
                    </div>
                  </a>
                <?php
                } elseif ($tap_masuk == 'sudahMasuk' && $tap_keluar == 'belumKeluar') {
                ?>
                  <a href="<?= base_url('Asprak/SubmitTapKeluar/' . $cek_jadwal->id_jadwal_asprak . '/' . $cek_jadwal->id_jadwal_lab) ?>">
                    <div class="widget style1 navy-bg">
                      <div class="row">
                        <div class="col-sm-2">
                          <i class="fa fa-check-circle-o fa-3x"></i>
                        </div>
                        <div class="col-sm-10 text-right">
                          <span>You Can Click Here for Finish Your Presence in</span>
                          <h4 class="font-bold"><?= $cek_jadwal->kelas . ' | ' . $cek_jadwal->nama_mk ?></h4>
                        </div>
                      </div>
                    </div>
                  </a>
                <?php
                } elseif ($tap_masuk == 'sudahMasuk' && $tap_keluar == 'sudahKeluar') {
                ?>
                  <div class="widget style1 red-bg">
                    <div class="row">
                      <div class="col-sm-2">
                        <i class="fa fa-ban fa-3x"></i>
                      </div>
                      <div class="col-sm-10 text-right">
                        <span>Thanks for Your Attended in</span>
                        <h4 class="font-bold"><?= $cek_jadwal->kelas . ' | ' . $cek_jadwal->nama_mk ?></h4>
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>
              <?php
              } elseif ($jadwal_asprak == 'false') {
              ?>
                <a href="<?= base_url('Asprak/Schedule') ?>">
                  <div class="widget style1 red-bg">
                    <div class="row">
                      <div class="col-sm-2">
                        <i class="fa fa-ban fa-3x"></i>
                      </div>
                      <div class="col-sm-10 text-right">
                        <span>You Can't Click Here for Absen</span>
                        <h4 class="font-bold">See Your Schedule</h4>
                      </div>
                    </div>
                  </div>
                </a>
              <?php
              }
            } else {
              ?>
              <div class="widget style1 red-bg">
                <div class="row">
                  <div class="col-sm-2">
                    <i class="fa fa-ban fa-3x"></i>
                  </div>
                  <div class="col-sm-10 text-right">
                    <span>You are not connected to TUNE Network</span>
                    <h4 class="font-bold">Please Connect to TUNE Network</h4>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="widget style1 white-bg">
              <div class="row">
                <div class="col-3">
                  <i class="fa fa-money fa-3x"></i>
                </div>
                <div class="col-9 text-right">
                  <?php
                  if (date('m') == 12 && date('d') <= 5) {
                    $periode = date('F', strtotime('-1 months')) . ' - ' . date('F');
                  } elseif (date('m') == 12 && date('d') >= 6) {
                    $periode = date('F') . ' - ' . date('F', strtotime('+1 months'));
                  } elseif (date('m') == 1 && date('d') <= 5) {
                    $periode = date('F', strtotime('-1 months')) . ' - ' . date('F');
                  } elseif (date('m') == 1 && date('d') >= 6) {
                    $periode = date('F') . ' - ' . date('F', strtotime('+1 months'));
                  } else {
                    $periode = date('F', strtotime('-1 months')) . ' - ' . date('F');
                  }
                  ?>
                  <span>Salary Recapitulation for <?= $periode ?></span>
                  <h4 class="font-bold">Rp <?= number_format($rekap_honor->gaji, 0, ',', '.') ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox ">
              <div id="ibox-content">
                <h2 style="text-align: center">Announcement</h2>
                <div id="vertical-timeline" class="vertical-container light-timeline">
                  <?php
                  foreach ($pengumuman as $p) {
                  ?>
                    <div class="vertical-timeline-block">
                      <?php
                      if ($p->tipePengumuman == 'Meeting') {
                        echo '<div class="vertical-timeline-icon navy-bg"><i class="fa fa-briefcase"></i></div>';
                      } elseif ($p->tipePengumuman == 'Sharing Knowledge') {
                        echo '<div class="vertical-timeline-icon blue-bg"><i class="fa fa-share-alt"></i></div>';
                      } elseif ($p->tipePengumuman == 'General') {
                        echo '<div class="vertical-timeline-icon yellow-bg"><i class="fa fa-bullhorn"></i></div>';
                      } elseif ($p->tipePengumuman == 'Practicum Assistant') {
                        echo '<div class="vertical-timeline-icon red-bg"><i class="fa fa-users"></i></div>';
                      }
                      ?>
                      <div class="vertical-timeline-content">
                        <h2><?= $p->namaPengumuman ?></h2>
                        <p><?= $p->isiPengumuman ?></p>
                        <span class="vertical-date">
                          <?= tanggal_inggris($p->tglPengumuman) ?>
                        </span>
                      </div>
                    </div>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>