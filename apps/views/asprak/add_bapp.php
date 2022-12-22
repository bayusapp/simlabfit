      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Add BAPP</h2>
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
                <form method="post" action="<?= base_url('Asprak/AddBAPP') ?>" id="form">
                  <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="font-bold">Modul</label>
                        <input type="text" name="modul" id="modul" class="form-control" placeholder="Example: Modul 1: Pengenalan Algoritma dan Pemrograman" required>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-grou">
                        <label class="font-bold">Major</label>
                        <select name="prodi" id="prodi" class="form-control prodi">
                          <option></option>
                          <?php
                          foreach ($prodi as $p) {
                            echo '<option value ="' . $p->id_prodi . '">' . $p->strata . ' ' . $p->nama_prodi . '</option>';
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
                            echo '<option value="' . $m->id_mk . '">' . $m->kode_mk . ' - ' . $m->nama_mk . '</option>';
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
                            echo '<option value="' . $l->idLab . '">' . $l->kodeRuang . ' - ' . $l->namaLab . '</option>';
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
                        <input type="text" name="kelas" id="kelas" class="form-control" placeholder="Example: D3IF-45-01">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="font-bold">Lecturer</label>
                        <select name="dosen" id="dosen" class="form-control dosen">
                          <option></option>
                          <?php
                          foreach ($dosen as $d) {
                            echo '<option value="' . $d->id_dosen . '">' . $d->kode_dosen . ' - ' . $d->nama_dosen . '</option>';
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
                          <input type="text" name="tanggal" id="tanggal" class="form-control" value="<?= date('m/d/Y') ?>">
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
                              <input type="radio" name="dosen_hadir" id="dosen_hadir" value="1" onclick="opsi_kehadiran()">
                              <label for="dosen_hadir">Present</label>
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="radio">
                              <input type="radio" name="dosen_hadir" id="dosen_tidak_hadir" value="0" onclick="opsi_kehadiran()">
                              <label for="dosen_tidak_hadir">Not Present</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label class="font-bold">Coming Hour</label>
                        <div class="input-group clockpicker" data-autoclose="true">
                          <input type="text" name="jam_datang" id="jam_datang" class="form-control" value="09:30">
                          <span class="input-group-addon">
                            <span class="fa fa-clock-o"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label class="font-bold">Return Hour</label>
                        <div class="input-group clockpicker" data-autoclose="true">
                          <input type="text" name="jam_pulang" id="jam_pulang" class="form-control" value="09:30">
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
                        <input type="text" name="nim_km" id="nim_km" class="form-control" placeholder="Example: 6701234567" onkeypress="return nimKM(event)">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label class="font-bold">Name KM</label>
                        <input type="text" name="nama_km" id="nama_km" class="form-control" placeholder="Example: Budi Santoso">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label class="font-bold">KM Signature</label>
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
                        <textarea name="catatan_praktikum" id="catatan_praktikum" class="form-control" rows="5"></textarea>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label class="font-bold">Have a Complaint(s) about Room/Laboratory</label>
                        <div class="row">
                          <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="radio">
                              <input type="radio" name="keluhan" id="ya_ada" value="1" onclick="komplainScript()">
                              <label for="ya_ada">Yes</label>
                            </div>
                          </div>
                          <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="radio">
                              <input type="radio" name="keluhan" id="tidak_ada" value="0" onclick="komplainScript()">
                              <label for="tidak_ada">No</label>
                            </div>
                          </div>
                        </div>
                        <textarea name="komplain" id="catatan_komplain" class="form-control" rows="3" disabled></textarea>
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