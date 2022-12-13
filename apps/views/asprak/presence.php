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
            ?>
            <a href="<?= base_url('Asprak/AddPresence') ?>">
              <button class="btn btn-sm btn-primary" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Add Presence</button>
            </a>
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
                            <div class="tooltip-demo">
                              <span data-toggle="modal" data-target="#<?= substr(sha1($d->id_presensi_asprak), 7, 7) ?>">
                                <button class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit your presence">
                                  <i class="fa fa-edit"></i>
                                </button>
                              </span>
                            </div>
                          </td>
                          <div class="modal inmodal fade" id="<?= substr(sha1($d->id_presensi_asprak), 7, 7) ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <div class="form-group">
                                          <label class="font-bold">Date</label>
                                          <input type="text" class="form-control" value="<?= tanggal_inggris_pendek($d->tanggal) ?>" readonly>
                                        </div>
                                      </div>
                                      <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                          <label class="font-bold">Start</label>
                                          <input type="text" class="form-control" value="<?= $d->masuk ?>" readonly>
                                        </div>
                                      </div>
                                      <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                          <label class="font-bold">Start</label>
                                          <input type="text" class="form-control" value="<?= $d->selesai ?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                          <label class="font-bold">Courses</label>
                                          <input type="text" class="form-control" value="<?= $d->nama_mk ?>" readonly>
                                        </div>
                                      </div>
                                      <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                          <label class="font-bold">Class</label>
                                          <input type="text" class="form-control" value="<?= $d->kelas ?>" readonly>
                                        </div>
                                      </div>
                                      <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                          <label class="font-bold">Lecturer Code</label>
                                          <input type="text" class="form-control" value="<?= $d->kode_dosen ?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                          <label class="font-bold">Modul</label>
                                          <input type="text" name="modul" id="modul" class="form-control" value="<?= $d->modul ?>">
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