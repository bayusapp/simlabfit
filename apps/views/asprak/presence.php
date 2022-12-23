      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <?php
          $nama_asprak = $this->db->get_where('asprak', array('nim_asprak' => userdata('nim')))->row();
          ?>
          <h2 style="text-align: center"><?= $nama_asprak->nama_asprak ?>'s Presence</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <?php
            if (flashdata('msg')) {
              echo flashdata('msg');
            }
            $org = check_org_ip();
            if ($org == 'TELKOM UNIVERSITY') {
            ?>
              <!-- <a href="<?= base_url('Asprak/AddPresence') ?>">
                <button class="btn btn-sm btn-primary" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Add Presence</button>
              </a> -->
              <button class="btn btn-sm btn-primary" style="margin-bottom: 10px;" data-toggle="modal" data-target="#addPresence"><i class="fa fa-plus"></i> Add Presence</button>
              <div class="modal inmodal fade" id="addPresence" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      <h4 class="modal-title">Add Presence</h4>
                    </div>
                    <form method="post" action="<?= base_url('Asprak/AddPresence') ?>">
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group" id="date_picker">
                              <label class="font-bold">Date</label>
                              <div class="input-group date">
                                <span class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" name="tgl_asprak" id="tgl_asprak" class="form-control" value="<?= date('m/d/Y') ?>" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                              <label class="font-bold">Start</label>
                              <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" name="jam_masuk" id="jam_masuk" class="form-control" placeholder="09:30" required>
                                <span class="input-group-addon">
                                  <span class="fa fa-clock-o"></span>
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                              <label class="font-bold">End</label>
                              <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" name="jam_selesai" id="jam_selesai" class="form-control" placeholder="09:30" required>
                                <span class="input-group-addon">
                                  <span class="fa fa-clock-o"></span>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                              <label class="font-bold">Schedule</label>
                              <select name="jadwal_asprak" id="jadwal_asprak" class="form-control jadwal" required>
                                <option></option>
                                <?php
                                foreach ($jadwal as $j) {
                                ?>
                                  <option value="<?= $j->id_jadwal_lab ?>"><?= hariInggris($j->hari_ke) . ' ' . $j->masuk . ' - ' . $j->selesai . ' | ' . $j->kodeRuang . ' | ' . $j->kode_mk . ' - ' . $j->nama_mk . ' | ' . $j->kode_dosen ?></option>
                                <?php
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                              <label class="font-bold">Practicum Modul</label>
                              <input type="text" name="modul_praktikum" id="modul_praktikum" class="form-control" placeholder="Modul 1: Pengenalan Algoritma" required>
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
            <?php
            }
            ?>
            <div class="ibox">
              <div class="ibox-content">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover dataTables">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th width="13%">Date</th>
                        <th width="5%">Start</th>
                        <th width="5%">End</th>
                        <th width="20%">Courses</th>
                        <th width="9%">Class</th>
                        <th width="9%">Lecturer Code</th>
                        <th>Modul</th>
                        <th width="7%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($data as $d) {
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= tanggal_inggris_pendek($d->tanggal) ?></td>
                          <td style="text-align: center;"><?= $d->masuk ?></td>
                          <td style="text-align: center;"><?= $d->selesai ?></td>
                          <td><?= $d->nama_mk ?></td>
                          <td style="text-align: center;"><?= $d->kelas ?></td>
                          <td style="text-align: center;"><?= $d->kode_dosen ?></td>
                          <td><?= $d->modul ?></td>
                          <td style="text-align: center">
                            <span class="tooltip-demo">
                              <span data-toggle="modal" data-target="#<?= substr(sha1($d->id_presensi_asprak), 7, 7) ?>">
                                <button class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit your presence">
                                  <i class="fa fa-edit"></i>
                                </button>
                              </span>
                            </span>
                            <span class="tooltip-demo">
                              <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Remove your presence" onclick="hapus_presensi('<?= substr(sha1($d->id_presensi_asprak), 7, 7) ?>')"><i class="fa fa-trash"></i></button>
                            </span>
                          </td>
                          <div class="modal inmodal fade" id="<?= substr(sha1($d->id_presensi_asprak), 7, 7) ?>" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <h4 class="modal-title">Edit Presence</h4>
                                </div>
                                <form action="<?= base_url('Asprak/EditPresence/' . substr(sha1($d->id_presensi_asprak), 7, 7)) ?>" method="post">
                                  <div class="modal-body">
                                    <div class="row">
                                      <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group" id="date_picker">
                                          <label class="font-bold">Date</label>
                                          <div class="input-group date">
                                            <span class="input-group-addon">
                                              <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" name="tgl_asprak" id="tgl_asprak" class="form-control" value="<?= convert_datepicker($d->tanggal) ?>" required>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                          <label class="font-bold">Start</label>
                                          <div class="input-group clockpicker" data-autoclose="true">
                                            <input type="text" value="<?= $d->masuk ?>" name="jam_masuk" id="jam_masuk" class="form-control" placeholder="09:30" required>
                                            <span class="input-group-addon">
                                              <span class="fa fa-clock-o"></span>
                                            </span>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                          <label class="font-bold">End</label>
                                          <div class="input-group clockpicker" data-autoclose="true">
                                            <input type="text" name="jam_selesai" id="jam_selesai" class="form-control" value="<?= $d->selesai ?>" placeholder="09:30" required>
                                            <span class="input-group-addon">
                                              <span class="fa fa-clock-o"></span>
                                            </span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                          <label class="font-bold">Schedule</label>
                                          <select name="jadwal_asprak" id="jadwal_asprak" class="form-control jadwal" required>
                                            <option></option>
                                            <?php
                                            foreach ($jadwal as $j) {
                                              if ($j->id_jadwal_lab == $d->id_jadwal_lab) {
                                            ?>
                                                <option value="<?= $j->id_jadwal_lab ?>" selected><?= hariInggris($j->hari_ke) . ' ' . $j->masuk . ' - ' . $j->selesai . ' | ' . $j->kodeRuang . ' | ' . $j->kode_mk . ' - ' . $j->nama_mk . ' | ' . $j->kode_dosen ?></option>
                                              <?php
                                              } else {
                                              ?>
                                                <option value="<?= $j->id_jadwal_lab ?>"><?= hariInggris($j->hari_ke) . ' ' . $j->masuk . ' - ' . $j->selesai . ' | ' . $j->kodeRuang . ' | ' . $j->kode_mk . ' - ' . $j->nama_mk . ' | ' . $j->kode_dosen ?></option>
                                            <?php
                                              }
                                            }
                                            ?>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                          <label class="font-bold">Practicum Modul</label>
                                          <input type="text" name="modul_praktikum" id="modul_praktikum" class="form-control" value="<?= $d->modul ?>" placeholder="Modul 1: Pengenalan Algoritma" required>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
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