      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Practicum Assistant<br>School of Applied Science School's Laboratory</h2>
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
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAsprak"><i class="fa fa-plus"></i> Add Practicum Assistant</button>
                <div class="modal inmodal fade" id="addAsprak" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Add Practicum Assistant</h4>
                      </div>
                      <form action="<?= base_url('Practicum/AddPracticumAssistant') ?>" method="post">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                              <div class="form-group">
                                <label class="font-bold">NIM Practicum Assistant</label>
                                <input type="text" name="nim_asprak" id="nim_asprak" class="form-control" placeholder="Example: 6701140001" onkeypress="return nim(event)">
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                              <div class="form-group">
                                <label class="font-bold">Name Practicum Assistant</label>
                                <input type="text" name="nama_asprak" id="nama_asprak" class="form-control" placeholder="Example: Budi Santoso">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-12 col-md-5 col-lg-5">
                              <div class="form-group">
                                <label class="font-bold">Courses</label>
                                <select class="daftar_mk form-control" name="matkul">
                                  <option></option>
                                  <?php
                                  foreach ($mk as $m) {
                                    echo '<option value="' . $m->kode_mk . '">' . $m->kode_mk . ' - ' . $m->nama_mk . '</option>';
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-3">
                              <div class="form-group">
                                <label class="font-bold">Period</label>
                                <select class="periode form-control" name="periode">
                                  <option></option>
                                  <?php
                                  foreach ($periode as $p) {
                                    echo '<option value="' . $p->id_ta . '">' . $p->ta . '</option>';
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                              <div class="form-group">
                                <label class="font-bold">Position</label>
                                <div class="row" style="margin-top: -10px;">
                                  <div class="col-sm-6">
                                    <div class="radio">
                                      <input type="radio" name="posisi" id="koordinator" class="form-control" value="1">
                                      <label for="koordinator">Coordinator</label>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="radio">
                                      <input type="radio" name="posisi" id="anggota" class="form-control" value="0">
                                      <label for="anggota">Member</label>
                                    </div>
                                  </div>
                                </div>
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
                                <div class="table-responsive">
                                  <table class="table table-striped table-bordered table-hover asprak" style="width: 100% !important;">
                                    <thead>
                                      <tr>
                                        <th width="7%">No</th>
                                        <th width="13%">NIM</th>
                                        <th width="25%">Name</th>
                                        <th width="15%">Contact</th>
                                        <th>Courses</th>
                                        <th width="10%">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $data = $this->m->daftarAsprak($t->id_ta, $a->kode_prodi)->result();
                                      $no = 1;
                                      foreach ($data as $d) {
                                      ?>
                                        <tr>
                                          <td><?= $no ?></td>
                                          <td><?= $d->nim_asprak ?></td>
                                          <td><?= $d->nama_asprak ?></td>
                                          <td>
                                            <?php
                                            if ($d->kontak_asprak) {
                                              echo '<a href="https://wa.me/' . $d->kontak_asprak . '" target=_blank style="color: #676a6c">' . $d->kontak_asprak . '</a>';
                                            } else {
                                              echo '<center>-</center>';
                                            }
                                            ?>
                                          </td>
                                          <td><?= $d->kode_mk . ' - ' . $d->nama_mk ?></td>
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