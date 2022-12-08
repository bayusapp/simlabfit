      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">BAPP</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row" style="margin-bottom: 5px">
          <div class="col-sm-3 col-md-3 col-lg3">
            <a href="<?= base_url('Asprak/AddBAPP') ?>">
              <button class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> Add BAPP
              </button>
            </a>
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
                  <table class="table table-striped table-bordered table-hover dataTables">
                    <thead>
                      <tr>
                        <th width="7%">No</th>
                        <th width="20%">Date</th>
                        <th width="10%">Class</th>
                        <th>Courses</th>
                        <th>Lecturer Code</th>
                        <th>Modul</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($bapp as $b) {
                        $id_bapp = substr(sha1($b->id_bapp), 7, 5);
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= tanggal_inggris_pendek($b->tanggal_bapp) ?></td>
                          <td><?= $b->kelas ?></td>
                          <td><?= $b->nama_mk ?></td>
                          <td><?= $b->kode_dosen ?></td>
                          <td><?= $b->modul ?></td>
                          <td>
                            <a href="<?= base_url('Asprak/ViewBAPP/' . $id_bapp) ?>" target="_blank">
                              <button class="btn btn-sm btn-info"><i class="fa fa-eye"></i></button>
                            </a>
                            <a href="<?= base_url('Asprak/EditBAPP/' . $id_bapp) ?>">
                              <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
                            </a>
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