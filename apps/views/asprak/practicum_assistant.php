      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">List of Practicum Assistant</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="tabs-container">
              <ul class="nav nav-tabs" role="tablist">
                <?php
                $ta = $this->a->cekTahunAjaranAsprak(userdata('nim'))->result();
                $no = 1;
                foreach ($ta as $t) {
                  if ($no == 1) {
                    $status = 'active';
                  } else {
                    $status = '';
                  }
                ?>
                  <li><a class="nav-link <?= $status ?>" data-toggle="tab" href="#<?= $t->id_ta ?>"> <?= $t->ta ?></a></li>
                <?php
                  $no++;
                }
                ?>
              </ul>
              <div class="tab-content">
                <?php
                $ta = $this->a->cekTahunAjaranAsprak(userdata('nim'))->result();
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
                          $mk = $this->a->daftarAsprakMKPeriode(userdata('nim'), $t->id_ta)->result();
                          $no = 1;
                          foreach ($mk as $m) {
                            if ($no == 1) {
                              $status_2 = 'active';
                            } else {
                              $status_2 = '';
                            }
                          ?>
                            <li><a class="nav-link <?= $status_2 ?>" data-toggle="tab" href="#<?= $m->kode_mk ?>"> <?= $m->nama_mk ?></a></li>
                          <?php
                            $no++;
                          }
                          ?>
                        </ul>
                        <div class="tab-content">
                          <?php
                          $mk = $this->a->daftarASprakMKPeriode(userdata('nim'), $t->id_ta)->result();
                          $no = 1;
                          foreach ($mk as $m) {
                            if ($no == 1) {
                              $status_2 = 'active';
                            } else {
                              $status_2 = '';
                            }
                          ?>
                            <div role="tabpanel" id="<?= $m->kode_mk ?>" class="tab-pane <?= $status_2 ?>">
                              <div class="panel-body">
                                <div class="table-responsive">
                                  <table class="table table-striped table-bordered table-hover dataTables" width="100%">
                                    <thead>
                                      <tr>
                                        <th width="7%">No</th>
                                        <th width="15%">NIM</th>
                                        <th>Name</th>
                                        <th width="15%">Phone Number</th>
                                        <th width="15%">Status</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $daftar = $this->a->daftarAsprakMK($m->id_ta, $m->id_daftar_mk)->result();
                                      $no = 1;
                                      foreach ($daftar as $d) {
                                      ?>
                                        <tr>
                                          <td><?= $no++ ?></td>
                                          <td><?= $d->nim_asprak ?></td>
                                          <td><?= $d->nama_asprak ?></td>
                                          <td>
                                            <?php
                                            if ($d->kontak_asprak == null) {
                                              echo '<center>-</center>';
                                            } else {
                                              echo '<a href="http://wa.me/' . $d->kontak_asprak . '" style="color: #676a6c">' . $d->kontak_asprak . '</a>';
                                            }
                                            ?>
                                          </td>
                                          <td>
                                            <?php
                                            if ($d->posisi == '0') {
                                              echo 'Member';
                                            } elseif ($d->posisi == '1') {
                                              echo 'Coordinator';
                                            }
                                            ?>
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
                          <?php
                            $no++;
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