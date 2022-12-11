      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Practicum Assistant Schedule<br>School of Applied Science School's Laboratory</h2>
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
            <div class="row">
              <div class="col-md-2 col-sm-2" style="margin-bottom: 5px">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAsprak"><i class="fa fa-plus"></i> Add Practicum Assistant Schedule</button>
                <div class="modal inmodal fade" id="addAsprak" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Add Practicum Assistant Schedule</h4>
                      </div>
                      <form action="<?= base_url('Practicum/SaveAsprakSchedule') ?>" method="post">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                              <div class="form-group">
                                <label class="font-bold">Practicum Assistant</label>
                                <select name="asprak" id="asprak" class="form-control daftar_asprak">
                                  <option></option>
                                  <?php
                                  foreach ($asprak as $a) {
                                    echo '<option value="' . $a->nim_asprak . '">' . $a->nim_asprak . ' - ' . $a->nama_asprak . '</option>';
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                              <div class="form-group">
                                <label class="font-bold">Schedule</label>
                                <select name="jadwal_lab[]" id="jadwal_lab" class="form-control jadwal_lab" multiple>
                                  <option></option>
                                  <?php
                                  foreach ($jadwal_lab as $j) {
                                    echo '<option value="' . $j->id_jadwal_lab . '">' . $j->kodeRuang . ' | ' . $j->hari . ' ' . $j->masuk . ' - ' . $j->selesai . ' | ' . $j->kode_dosen . ' | ' . $j->kode_mk . ' ' . $j->nama_mk . '</option>';
                                  }
                                  ?>
                                </select>
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
            </div>
            <div class="tabs-container">
              <ul class="nav nav-tabs" role="tablist">
                <?php
                $no = 1;
                foreach ($ta as $t) {
                  if ($no == 1) {
                    $status = 'active';
                  } else {
                    $status = '';
                  }
                ?>
                  <li><a class="nav-link <?= $status ?>" data-toggle="tab" href="#<?= $t->id_ta ?>"><?= $t->ta ?></a></li>
                <?php
                  $no++;
                }
                ?>
              </ul>
              <div class="tab-content">
                <?php
                $no = 1;
                foreach ($ta as $t) {
                  if ($no == 1) {
                    $status = 'active';
                  } else {
                    $status = '';
                  }
                ?>
                  <div role="tabpanel" id="<?= $t->id_ta ?>" class="tab-pane <?= $status ?>">
                    <div class="panel-body">
                      <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                          <?php
                          $ambil_prodi_mk = $this->db->query('select distinct daftar_mk.kode_prodi from daftarasprak join daftar_mk on daftarasprak.id_daftar_mk = daftar_mk.id_daftar_mk join prodi on daftar_mk.kode_prodi = prodi.kode_prodi where daftarasprak.id_ta = "' . $t->id_ta . '" order by prodi.id_prodi asc')->result();
                          foreach ($ambil_prodi_mk as $a) {
                          ?>
                            <li><a class="nav-link" data-toggle="tab" href="#<?= $a->kode_prodi ?>"><?= $a->kode_prodi ?></a></li>
                          <?php
                          }
                          ?>
                        </ul>
                        <div class="tab-content">
                          <?php
                          $ambil_prodi_mk = $this->db->query('select distinct daftar_mk.kode_prodi from daftarasprak join daftar_mk on daftarasprak.id_daftar_mk = daftar_mk.id_daftar_mk join prodi on daftar_mk.kode_prodi = prodi.kode_prodi where daftarasprak.id_ta = "' . $t->id_ta . '" order by prodi.id_prodi asc')->result();
                          foreach ($ambil_prodi_mk as $a) {
                          ?>
                            <div role="tabpanel" id="<?= $a->kode_prodi ?>" class="tab-pane">
                              <div class="panel-body">
                                <div class="tabs-container">
                                  <ul class="nav nav-tabs" role="tablist">
                                    <?php
                                    $ambil_daftar_mk = $this->db->query('select distinct matakuliah.kode_mk, matakuliah.nama_mk from matakuliah join daftar_mk on matakuliah.kode_mk = daftar_mk.kode_mk join daftarasprak on daftar_mk.id_daftar_mk = daftarasprak.id_daftar_mk where daftar_mk.id_ta = "' . $t->id_ta . '" and daftar_mk.kode_prodi = "' . $a->kode_prodi . '" order by matakuliah.kode_mk asc')->result();
                                    foreach ($ambil_daftar_mk as $m) {
                                      echo '<li><a class="nav-link" data-toggle="tab" href="#' . $t->id_ta . '_' . $m->kode_mk . '">' . $m->kode_mk . '</a></li>';
                                    }
                                    ?>
                                  </ul>
                                  <div class="tab-content">
                                    <?php
                                    $ambil_daftar_mk = $this->db->query('select distinct matakuliah.kode_mk, matakuliah.nama_mk from matakuliah join daftar_mk on matakuliah.kode_mk = daftar_mk.kode_mk join daftarasprak on daftar_mk.id_daftar_mk = daftarasprak.id_daftar_mk where daftar_mk.id_ta = "' . $t->id_ta . '" and daftar_mk.kode_prodi = "' . $a->kode_prodi . '" order by matakuliah.kode_mk asc')->result();
                                    foreach ($ambil_daftar_mk as $m) {
                                    ?>
                                      <div role="tabpanel" id="<?= $t->id_ta . '_' . $m->kode_mk ?>" class="tab-pane">
                                        <div class="panel-body">
                                          <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover asprak" style="width: 100% !important;">
                                              <thead>
                                                <tr>
                                                  <th width="7%">No</th>
                                                  <th width="13%">NIM</th>
                                                  <th width="25%">Name</th>
                                                  <th>Courses</th>
                                                  <th width="15%">Hour</th>
                                                  <th width="10%">Action</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <?php
                                                $data = $this->m->daftarJadwalAsprak($t->id_ta, $a->kode_prodi, $m->kode_mk)->result();
                                                $no = 1;
                                                foreach ($data as $d) {
                                                ?>
                                                  <tr>
                                                    <td><?= $no ?></td>
                                                    <td><?= $d->nim_asprak ?></td>
                                                    <td><?= $d->nama_asprak ?></td>
                                                    <td><?= $d->kode_mk . ' - ' . $d->nama_mk ?></td>
                                                    <td><?= $d->masuk . ' - ' . $d->selesai ?></td>
                                                    <td style="text-align: center;">
                                                      <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
                                                      <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                  </tr>
                                                <?php
                                                  $no++;
                                                }
                                                ?>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    <?php
                                    }
                                    ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                  $no++;
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        function hanya_angka(event) {
          var angka = (event.which) ? event.which : event.keyCode
          if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
            return false;
          return true;
        }

        function hapus_matakuliah(id) {
          $.ajax({
            url: '<?= base_url('Practicum/ajaxMataKuliah') ?>',
            method: 'post',
            data: {
              id: id
            },
            success: function(response) {
              swal({
                title: 'Are you sure?',
                text: 'Do you want to delete "' + response + '"',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                closeOnConfirm: false
              }, function() {
                swal({
                  title: 'Deleted!',
                  text: 'Courses been deleted',
                  timer: 1500,
                  type: 'success',
                  showConfirmButton: false
                }, function() {
                  window.location.href = '<?= base_url('Practicum/DeleteCourses/') ?>' + id;
                });
              });
            }
          });
        }
      </script>