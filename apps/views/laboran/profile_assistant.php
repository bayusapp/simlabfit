      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center"><?= $profil_aslab->namaLengkap ?>'s Profile<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row m-b-lg m-t-lg" style="background: url('<?= base_url('assets/img/23065.jpg') ?>'); background-position: center; height: auto; color: white">
          <div class="col-md-9 col-sm-12" style="margin: 20px 0 20px 0">
            <div class="profile-image">
              <?php
              if ($profil_aslab->fotoAslab == null) {
                $foto = base_url('assets/img/person-flat.png');
              } else {
                $foto = base_url($profil_aslab->fotoAslab);
              }
              $laboratorium = '';
              foreach ($pj as $p) {
                if ($p->idAslab == uri('3')) {
                  $laboratorium .= '- ' . $p->namaLab . '<br>';
                }
              }
              ?>
              <img src="<?= $foto ?>" class="rounded-circle circle-border m-b-md" alt="profile" style="background-color: white;">
            </div>
            <div class="profile-info">
              <div>
                <div>
                  <h2 class="no-margins"><?= $profil_aslab->namaLengkap ?></h2>
                  <h4><?= $profil_aslab->nim ?> | <i class="fa fa-phone-square"></i> <?= $profil_aslab->noTelp ?></h4>
                  <table>
                    <tr style="vertical-align: top;">
                      <td style="padding-right: 20px" width="50%"><small>Aslab in Charge:</small></td>
                      <td><small>Laboran:</small></td>
                    </tr>
                    <tr style="vertical-align: top;">
                      <td style="padding-right: 20px" width="50%"><small><?= $laboratorium ?></small></td>
                      <td><small><?= $profil_aslab->nama_laboran ?></small></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-3" style="margin-bottom: 5px">
            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editAslab"><i class="fa fa-edit"></i> Edit Profile</button>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#print"><i class="fa fa-print"></i> Print BAP</button>
            <div class="modal inmodal fade" id="print" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Print BAP Laboratory Assistant</h4>
                  </div>
                  <form method="post" action="<?= base_url('LaboratoryAssistant/PrintBAP/' . uri('3')) ?>">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <div class="form-group" id="date_picker">
                            <label class="font-bold">Start</label>
                            <div class="input-group date">
                              <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </span>
                              <input type="text" name="awal" id="awal" class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <div class="form-group" id="date_picker">
                            <label class="font-bold">End</label>
                            <div class="input-group date">
                              <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </span>
                              <input type="text" name="akhir" id="akhir" class="form-control" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <div class="form-group">
                            <label class="font-bold">Period</label>
                            <select name="periode" id="periode" class="form-control bulan">
                              <option></option>
                              <option value="1">January</option>
                              <option value="2">February</option>
                              <option value="3">March</option>
                              <option value="4">April</option>
                              <option value="5">May</option>
                              <option value="6">June</option>
                              <option value="7">July</option>
                              <option value="8">August</option>
                              <option value="9">September</option>
                              <option value="10">October</option>
                              <option value="11">November</option>
                              <option value="12">December</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <div class="form-group">
                            <label class="font-bold">Majors</label>
                            <select name="prodi" id="prodi" class="form-control prodi">
                              <option></option>
                              <?php
                              foreach ($prodi as $p) {
                                echo '<option value="' . $p->id_prodi . '">' . $p->nama_prodi . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Print</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal inmodal fade" id="editAslab" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Edit Laboratory Assistant</h4>
                  </div>
                  <form method="post" action="<?= base_url('LaboratoryAssistant/EditLaboratoryAssistant') ?>" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label class="font-bold">Name</label>
                            <input type="text" name="id_aslab" id="id_aslab" value="<?= $profil_aslab->idAslab ?>" style="display: none">
                            <input type="text" name="nama_aslab" id="nama_aslab" class="form-control" placeholder="Input Name Assistant" value="<?= $profil_aslab->namaLengkap ?>" required>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label class="font-bold">NIM</label>
                            <input type="text" name="nim_aslab" id="nim_aslab" class="form-control" placeholder="Input NIM Assistant" value="<?= $profil_aslab->nim ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label class="font-bold">Phone</label>
                            <input type="text" name="telp_aslab" id="telp_aslab" class="form-control" placeholder="Input Phone Number" value="<?= $profil_aslab->noTelp ?>" required>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label class="font-bold">Photo</label>
                            <div class="custom-file">
                              <input type="file" name="foto_aslab" id="foto_aslab" class="custom-file-input">
                              <label for="logo" class="custom-file-label">Choose file...</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label class="font-bold">Laboratory</label>
                            <select name="pj_lab[]" id="pj_lab" class="form-control laboratorium" multiple>
                              <option></option>
                              <?php
                              $pj_lab = array();
                              $i      = 0;
                              foreach ($pj as $p) {
                                array_push($pj_lab, $p->idLab);
                              }
                              $count  = count($pj_lab);
                              foreach ($lab as $l) {
                                $tmp  = $pj_lab[$i];
                                if ($l->idLab == $tmp) {
                                  echo '<option value="' . $l->idLab . '" selected>' . $l->namaLab . '</option>';
                                  if ($i < ($count - 1)) {
                                    $i++;
                                  }
                                } else {
                                  echo '<option value="' . $l->idLab . '">' . $l->namaLab . '</option>';
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label class="font-bold">Specialist</label>
                            <input type="text" name="spesialis_aslab" id="spesialis_aslab" class="form-control" placeholder="Input Specialist Assistant" value="<?= $profil_aslab->spesialisAslab ?>">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label class="font-bold">Laboran</label>
                            <select name="laboran" id="laboran" class="form-control laboran">
                              <option></option>
                              <?php
                              foreach ($laboran as $l) {
                                if ($l->id_laboran == $profil_aslab->id_laboran) {
                                  echo '<option value="' . $l->id_laboran . '" selected>' . $l->nama_laboran . '</option>';
                                } else {
                                  echo '<option value="' . $l->id_laboran . '">' . $l->nama_laboran . '</option>';
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="form-group">
                            <label class="font-bold">Aslab of the Month</label>
                            <input type="text" name="aslab_bulan" id="aslab_bulan" class="form-control" placeholder="Input Number of the Month" value="<?= $profil_aslab->aslabOfTheMonth ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 offset-md-1" style="margin-bottom: 5px">
            <select class="form-control periode" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
              <option></option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3')) ?>">All Periode</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/January') ?>">January</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/February') ?>">February</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/March') ?>">March</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/April') ?>">April</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/May') ?>">May</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/June') ?>">June</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/July') ?>">July</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/August') ?>">August</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/September') ?>">September</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/October') ?>">October</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/November') ?>">November</option>
              <option value="<?= base_url('LaboratoryAssistant/ProfileAssistant/' . uri('3') . '/December') ?>">December</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <?php
            if (flashdata('msg')) {
              echo flashdata('msg');
            }
            ?>
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover kegiatan_aslab">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th width="25%">Date</th>
                        <th width="5%">In</th>
                        <th width="5%">Out</th>
                        <th>Duration</th>
                        <th>Activities</th>
                        <th width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($kegiatan as $k) {
                        $masuk = explode(':', $k->jamMasuk);
                        $jam_masuk = $masuk[0] * 3600;
                        $menit_masuk = $masuk[1] * 60;
                        if ($k->jamKeluar == '0') {
                          $kluar = '00:00';
                        } else {
                          $kluar = $k->jamKeluar;
                        }
                        $keluar = explode(':', $kluar);
                        $jam_keluar = $keluar[0] * 3600;
                        $menit_keluar = $keluar[1] * 60;
                        $durasi = (($jam_keluar + $menit_keluar) - ($jam_masuk + $menit_masuk)) / 3600;
                        if ($durasi < 0) {
                          $durasi = '-';
                        } else {
                          $durasi = round($durasi);
                        }
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= tanggalInggris($k->aslabMasuk) ?></td>
                          <td style="text-align: center"><?= $k->masuk ?></td>
                          <td style="text-align: center"><?= $k->keluar ?></td>
                          <td style="text-align: center"><?= $durasi ?></td>
                          <td><?= $k->jurnal ?></td>
                          <td style="text-align: center;">
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editJurnal<?= $k->idJurnal ?>"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" onclick="hapus_jurnal(<?= $k->idJurnal ?>)"><i class="fa fa-trash"></i></button>
                            <div class="modal inmodal fade" id="editJurnal<?= $k->idJurnal ?>" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Edit Journal Assistant</h4>
                                  </div>
                                  <form method="post" action="<?= base_url('LaboratoryAssistant/EditJournal') ?>">
                                    <div class="modal-body">
                                      <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                          <div class="form-group">
                                            <label class="font-bold">In</label>
                                            <input type="text" name="idJurnal" value="<?= $k->idJurnal ?>" hidden>
                                            <div class="input-group clockpicker" data-autoclose="true">
                                              <input type="text" name="jamMasuk" class="form-control" value="<?= $k->masuk ?>">
                                              <span class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                              </span>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                          <div class="form-group">
                                            <label class="font-bold">Out</label>
                                            <div class="input-group clockpicker" data-autoclose="true">
                                              <input type="text" name="jamKeluar" class="form-control" value="<?= $k->keluar ?>">
                                              <span class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                              </span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                          <div class="form-group">
                                            <label class="font-bold">Activities</label>
                                            <textarea class="form-control" name="aktivitas_aslab" rows="5"><?= strip_tags($k->jurnal, '<br />') ?></textarea>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>