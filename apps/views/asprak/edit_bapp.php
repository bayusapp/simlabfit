      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Edit BAPP</h2>
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
            <div class="ibox">
              <div class="ibox-content">
                <form method="post" action="<?= base_url('Asprak/EditBAPP') ?>" id="form">
                  <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="font-bold">Modul</label>
                        <input type="text" name="modul" id="modul" class="form-control" placeholder="Example: Modul 1: Pengenalan Algoritma dan Pemrograman" value="<?= $data->modul ?>">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-grou">
                        <label class="font-bold">Major</label>
                        <select name="prodi" id="prodi" class="form-control prodi">
                          <option></option>
                          <?php
                          foreach ($prodi as $p) {
                            if ($p->id_prodi == $data->id_prodi) {
                              echo '<option value ="' . $p->id_prodi . '" selected>' . $p->strata . ' ' . $p->nama_prodi . '</option>';
                            } else {
                              echo '<option value ="' . $p->id_prodi . '">' . $p->strata . ' ' . $p->nama_prodi . '</option>';
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="font-bold">Courses Code / Courses Name</label>
                        <select name="mk" id="mk" class="form-control mk">
                          <option></option>
                          <?php
                          foreach ($mk as $m) {
                            if ($m->id_mk == $data->id_mk) {
                              echo '<option value="' . $m->id_mk . '" selected>' . $m->kode_mk . ' - ' . $m->nama_mk . '</option>';
                            } else {
                              echo '<option value="' . $m->id_mk . '">' . $m->kode_mk . ' - ' . $m->nama_mk . '</option>';
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="font-bold">Room</label>
                        <select name="lab" id="lab" class="form-control lab">
                          <option></option>
                          <?php
                          foreach ($lab as $l) {
                            if ($data->id_lab == $l->idLab) {
                              echo '<option value="' . $l->idLab . '" selected>' . $l->kodeRuang . ' - ' . $l->namaLab . '</option>';
                            } else {
                              echo '<option value="' . $l->idLab . '">' . $l->kodeRuang . ' - ' . $l->namaLab . '</option>';
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="font-bold">Class</label>
                        <input type="text" name="kelas" id="kelas" class="form-control" placeholder="Example: D3IF-45-01" value="<?=$data->kelas?>">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="font-bold">Lecturer</label>
                        <select name="dosen" id="dosen" class="form-control dosen">
                          <option></option>
                          <?php
                          foreach ($dosen as $d) {
                            if ($data->id_dosen == $d->id_dosen) {
                              echo '<option value="' . $d->id_dosen . '" selected>' . $d->kode_dosen . ' - ' . $d->nama_dosen . '</option>';
                            } else {
                              echo '<option value="' . $d->id_dosen . '">' . $d->kode_dosen . ' - ' . $d->nama_dosen . '</option>';
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-group" id="date_picker">
                        <label class="font-bold">Date</label>
                        <div class="input-group date">
                          <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </span>
                          <?php
                          $tanggal  = $data->tanggal_bapp;
                          $pisah    = explode('-', $tanggal);
                          $urut     = array($pisah[1], $pisah[2], $pisah[0]);
                          $tanggal  = implode('/', $urut);
                          ?>
                          <input type="text" name="tanggal" id="tanggal" class="form-control" value="<?= $tanggal ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                      <div class="form-group">
                        <label class="font-bold">Number of Students</label>
                        <input type="number" name="jumlah_mhs" id="jumlah_mhs" class="form-control" placeholder="30">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">
                      <div class="form-group">
                        <label class="font-bold">Number of Absent Students</label>
                        <input type="number" name="absen_mhs" id="absen_mhs" class="form-control" placeholder="5">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="font-bold">NIM of Absent Students</label> <code>separate with comma</code>
                        <input type="text" name="nim_absen" id="nim_absen" class="form-control" placeholder="Example: 6701234567, 6701234568, 6701234569, etc">
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label class="font-bold">Lecturer is Present/Not</label>
                        <div class="row">
                          <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="radio">
                              <input type="radio" name="dosen_hadir" id="dosen_hadir" value="1" onclick="opsi_kehadiran()" <?php if ($data->kehadiran_dosen == '1') { echo 'checked';}?>>
                              <label for="dosen_hadir">Present</label>
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="radio">
                              <input type="radio" name="dosen_hadir" id="dosen_tidak_hadir" value="0" onclick="opsi_kehadiran()" <?php if ($data->kehadiran_dosen == '0') { echo 'checked';}?>>
                              <label for="dosen_tidak_hadir">Not Present</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label class="font-bold">Coming Hour</label>
                        <?php
                        if ($data->dosen_datang == null) {
                          $jam_datang = '00:00';
                        } else {
                          $jam_datang = $data->dosen_datang;
                        }
                        ?>
                        <div class="input-group clockpicker" data-autoclose="true">
                          <input type="text" name="jam_datang" id="jam_datang" class="form-control" value="<?=$jam_datang?>" <?php if ($data->dosen_datang == null) { echo 'disabled';}?>>
                          <span class="input-group-addon">
                            <span class="fa fa-clock-o"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label class="font-bold">Return Hour</label>
                        <?php
                        if ($data->dosen_pulang == null) {
                          $jam_pulang = '';
                        } else {
                          $jam_pulang = $data->dosen_pulang;
                        }
                        ?>
                        <div class="input-group clockpicker" data-autoclose="true">
                          <input type="text" name="jam_pulang" id="jam_pulang" class="form-control" value="<?=$jam_pulang?>" <?php if ($data->dosen_pulang == null) { echo 'disabled';}?>>
                          <span class="input-group-addon">
                            <span class="fa fa-clock-o"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label class="font-bold">NIM KM</label>
                        <input type="text" name="nim_km" id="nim_km" class="form-control" placeholder="Example: 6701234567" value="<?=$data->nim_km?>" onkeypress="return nimKM(event)">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label class="font-bold">Name KM</label>
                        <input type="text" name="nama_km" id="nama_km" class="form-control" placeholder="Example: Budi Santoso" value="<?=$data->nama_km?>">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label class="font-bold">KM Signature</label>
                        <?php
                        if ($data->ttd_km == null) {
                        ?>
                          <span class="tag-ingo">Put signature below,</span>
                          <div id="signArea">
                            <div class="sig sigWrapper" style="height:auto;">
                              <div class="typed"></div>
                              <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                            </div>
                          </div>
                          <div style="margin-top: 5px">
                            <button type="button" class="btn btn-warning btn-sm btnClearSign" id="btnClearSign">Clear Sign</button>
                          </div>
                          <input type="text" name="tmp_sign" id="tmp_sign" hidden>
                        <?php
                        } else {
                          echo '<img src="' . base_url($data->ttd_km) . '" style="max-height: 100px">';
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label class="font-bold">List Practicum Assistant</label>
                        <select name="asprak[]" id="asprak" class="form-control asprak" multiple="multiple">
                          <option></option>
                          <?php
                          foreach ($asprak as $a) {
                            echo '<option value="' . $a->nim_asprak . '">' . $a->nim_asprak . ' - ' . $a->nama_asprak . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="font-bold">Notes During Practicum</label>
                        <textarea name="catatan_praktikum" id="catatan_praktikum" class="form-control" rows="5"><?=$data->catatan_praktikum?></textarea>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="font-bold">Complaint(s) about Room/Laboratory</label>
                        <textarea name="komplain" id="komplain" class="form-control" rows="5"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 col-md-2 col-lg-2">
                      <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>