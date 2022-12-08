      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">BAP</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <?php
            if (flashdata('msg')) {
              echo flashdata('msg');
            }
            ?>
            <?php
            if ($profil->kontak_asprak == null || $profil->email_asprak == null || $profil->ttd_asprak == null || $profil->id_bank == null || $profil->norek_asprak == null || $profil->nama_rekening == null) {
              echo '<div class="alert alert-danger">Please complete your personal information in <b>Setting Menu before submit BAP</b></div>';
            } else {
            ?>
              <form method="post" action="<?= base_url('Asprak/PrintBAP') ?>" target="_blank">
                <div class="row">
                  <div class="col-md-5 offset-md-1 col-sm-5" style="margin-bottom: 5px">
                    <select name="matapraktikum" id="matapraktikum" class="matapraktikum form-control">
                      <option></option>
                      <?php
                      foreach ($mk as $mk) {
                      ?>
                        <option value="<?= $mk->id_daftar_mk ?>"><?= $mk->strata . '' . $mk->kode_prodi . ' | ' . $mk->kode_mk . ' ' . $mk->nama_mk ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-3 col-sm-3" style="margin-bottom: 5px">
                    <select name="bulan" id="bulan" class="periode_bap form-control">
                      <option></option>
                      <?php
                      if (date('m') == 12 && date('d') >= 6) {
                      ?>
                        <option value="'<?= date('Y') ?>-12-06' and '<?= date('Y', strtotime('+1 years')) ?>-01-05'|1|Januari">January</option>
                      <?php
                      } elseif (date('m') == 1 && date('d') <= 5) {
                      ?>
                        <option value="'<?= date('Y', strtotime('-1 years')) ?>-12-06' and '<?= date('Y') ?>-01-05'|1|Januari">January</option>
                      <?php
                      }
                      ?>
                      <option value="'<?= date('Y') ?>-01-06' and '<?= date('Y') ?>-02-05'|2|Februari">February</option>
                      <option value="'<?= date('Y') ?>-02-06' and '<?= date('Y') ?>-03-05'|3|Maret">March</option>
                      <option value="'<?= date('Y') ?>-03-06' and '<?= date('Y') ?>-04-05'|4|April">April</option>
                      <option value="'<?= date('Y') ?>-04-06' and '<?= date('Y') ?>-05-05'|5|Mei">May</option>
                      <option value="'<?= date('Y') ?>-05-06' and '<?= date('Y') ?>-06-05'|6|Juni">June</option>
                      <option value="'<?= date('Y') ?>-06-06' and '<?= date('Y') ?>-07-05'|7|Juli">July</option>
                      <option value="'<?= date('Y') ?>-07-06' and '<?= date('Y') ?>-08-05'|8|Agustus">August</option>
                      <option value="'<?= date('Y') ?>-08-06' and '<?= date('Y') ?>-09-05'|9|September">September</option>
                      <option value="'<?= date('Y') ?>-09-06' and '<?= date('Y') ?>-10-05'|10|Oktober">October</option>
                      <option value="'<?= date('Y') ?>-10-06' and '<?= date('Y') ?>-11-05'|11|November">November</option>
                      <option value="'<?= date('Y') ?>-11-06' and '<?= date('Y') ?>-12-05'|12|Desember">December</option>
                    </select>
                  </div>
                  <div class="col-md-3 col-sm-3">
                    <button class="btn btn-primary btn-sm" type="submit" name="print" id="print"><i class="fa fa-print"></i> Print BAP</button>
                  </div>
                </div>
              </form>
              <div class="ibox">
                <input type="text" name="course" id="course" class="form-control" style="display: none;"><input type="text" name="month" id="month" class="form-control" style="display: none;">
                <div class="ibox-content">
                  <div id="tampil"></div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>