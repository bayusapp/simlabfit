      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Honor<br>School of Applied Science School's Laboratory</h2>
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
            <div class="tabs-container">
              <ul class="nav nav-tabs" role="tablist">
                <li><a class="nav-link active" data-toggle="tab" href="#pengajuan"> Submission</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#pengambilan"> Withdraw</a></li>
              </ul>
              <div class="tab-content">
                <div role="tabpanel" id="pengajuan" class="tab-pane active">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div>
                          <canvas id="lineChart" height="70"></canvas>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="margin-bottom: 15px">
                      <div class="col-md-1">
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addSubmission"><i class="fa fa-plus"></i></button>
                        <div class="modal inmodal fade" id="addSubmission" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title">Add Submission</h4>
                              </div>
                              <form method="post" action="<?= base_url('Finance/AddSubmission') ?>" enctype="multipart/form-data">
                                <div class="modal-body">
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Type</label>
                                    <div class="col-sm-10">
                                      <select name="tipe_submission" id="tipe_submission" class="type_submission form-control">
                                        <option></option>
                                        <option value="01">Pertanggungan Umum</option>
                                        <option value="02">Honor Aslab</option>
                                        <option value="03">Honor Asprak</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Major</label>
                                    <div class="col-sm-10">
                                      <select name="prodi" id="prodi" class="prodi form-control">
                                        <option></option>
                                        <?php
                                        foreach ($prodi as $p) {
                                          echo '<option value="' . $p->kode_prodi . '">' . $p->strata . ' ' . $p->nama_prodi . '</option>';
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Year</label>
                                    <div class="col-sm-10">
                                      <select name="ta" id="ta" class="ta form-control">
                                        <option></option>
                                        <?php
                                        foreach ($tahun_ajaran as $t) {
                                          echo '<option value="' . $t->id_ta . '">' . $t->ta . '</option>';
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Period</label>
                                    <div class="col-sm-10">
                                      <select name="periode" id="periode" class="periode form-control">
                                        <option></option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Laboran</label>
                                    <div class="col-sm-10">
                                      <select name="pembuat" id="pembuat" class="pembuat form-control">
                                        <option></option>
                                        <?php
                                        foreach ($laboran as $l) {
                                          echo '<option value="' . $l->id_laboran . '">' . $l->nama_laboran . '</option>';
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">File</label>
                                    <div class="col-sm-10">
                                      <div class="custom-file">
                                        <input type="file" name="file_csv" id="logo" class="custom-file-input">
                                        <label for="logo" class="custom-file-label">Choose file...</label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#daftarBayar"><i class="fa fa-print"></i> Print Daftar Bayar</button>
                        <div class="modal inmodal fade" id="daftarBayar" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title">Daftar Bayar</h4>
                              </div>
                              <form method="post" action="<?= base_url('Finance/DaftarBayar') ?>" target="_blank">
                                <div class="modal-body">
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Major</label>
                                    <div class="col-sm-10">
                                      <select name="prodi" id="prodi" class="prodi form-control">
                                        <option></option>
                                        <?php
                                        foreach ($prodi as $p) {
                                          echo '<option value="' . $p->kode_prodi . '">' . $p->strata . ' ' . $p->nama_prodi . '</option>';
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Year</label>
                                    <div class="col-sm-10">
                                      <select name="ta" id="ta" class="ta form-control">
                                        <option></option>
                                        <?php
                                        foreach ($tahun_ajaran as $t) {
                                          echo '<option value="' . $t->id_ta . '">' . $t->ta . '</option>';
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label class="col-sm-2 col-form-label font-bold">Period</label>
                                    <div class="col-sm-10">
                                      <select name="periode" id="periode" class="periode form-control">
                                        <option></option>
                                        <?php
                                        $periode_asprak = $this->db->where('asprak', '1')->order_by('angka_bulan')->get('periode')->result();
                                        foreach ($periode_asprak as $pa) {
                                          echo '<option value="' . $pa->angka_bulan . '">' . bulanPanjang($pa->angka_bulan) . '</option>';
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover submission" width="100%">
                            <thead>
                              <tr>
                                <th>No PK</th>
                                <th>Information</th>
                                <th style="text-align: left">Nominal</th>
                                <th>Date of Filing</th>
                                <th>Date Obtained</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" id="pengambilan" class="tab-pane">
                  <div class="panel-body">
                    <ul class="nav nav-tabs" role="tablist">
                      <li><a class="nav-link active" data-toggle="tab" href="#asprak"> Asprak</a></li>
                      <li><a class="nav-link" data-toggle="tab" href="#aslab"> Aslab</a></li>
                    </ul>
                    <div class="tab-content">
                      <div role="tabpanel" id="asprak" class="tab-pane active">
                        <div class="panel-body">
                          <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover asprak" width="100%">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Courses Code</th>
                                  <th>Courses</th>
                                  <th>NIM</th>
                                  <th>Name</th>
                                  <th>Periode</th>
                                  <th>Amount</th>
                                  <th>Withdraw Option</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div role="tabpanel" id="aslab" class="tab-pane">
                        <div class="panel-body">
                          <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover aslab" width="100%">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>NIM</th>
                                  <th>Name</th>
                                  <th>Periode</th>
                                  <th>Amount</th>
                                  <th>Withdraw Option</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $no = 1;
                                foreach ($withdraw_aslab as $w) {
                                ?>
                                  <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $w->nim ?></td>
                                    <td><?= $w->namaLengkap ?></td>
                                    <td><?= $w->bulan ?></td>
                                    <td style="text-align: right">Rp <?= number_format($w->nominal, 0, '', '.') ?></td>
                                    <td><?= $w->opsi_pengambilan ?></td>
                                    <td>
                                      <?php
                                      if ($w->status_honor == '0') {
                                        echo 'On Process';
                                      } elseif ($w->status_honor == '1') {
                                        echo 'Ready To Take';
                                      } elseif ($w->status_honor == '2') {
                                        echo 'Requested';
                                      } elseif ($w->status_honor == '3') {
                                        echo 'Taken';
                                      }
                                      ?>
                                    </td>
                                    <td style="text-align: center">
                                      <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detail_aslab<?= $w->id_honor_aslab ?>"><i class="fa fa-eye"></i></button>
                                      <?php
                                      if ($w->status_honor == '2') {
                                        echo '<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#upload_bukti_aslab' . $w->id_honor_aslab . '"><i class="fa fa-edit"></i></button>';
                                      ?>
                                        <div class="modal inmodal fade" id="upload_bukti_aslab<?= $w->id_honor_aslab ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title">Upload Evidence of Transfer</h4>
                                              </div>
                                              <form method="post" action="<?= base_url('Finance/UploadEvidenceAslab') ?>" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                  <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                      <div class="form-group">
                                                        <label class="font-bold">NIM</label>
                                                        <br>
                                                        <label><?= $w->nim ?></label>
                                                        <input type="text" name="id_honor_aslab" id="id_honor_aslab" value="<?= $w->id_honor_aslab ?>" style="display: none">
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                      <div class="form-group">
                                                        <label class="font-bold">Name</label>
                                                        <br>
                                                        <label><?= $w->namaLengkap ?></label>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                      <div class="form-group">
                                                        <label class="font-bold">Periode</label>
                                                        <br>
                                                        <label><?= $w->bulan ?></label>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                      <div class="form-group">
                                                        <label class="font-bold">Amount</label>
                                                        <br>
                                                        <label>Rp <?= number_format($w->nominal, 0, '', '.') ?></label>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                      <div class="form-group">
                                                        <label class="font-bold">Bank Account Number</label>
                                                        <br>
                                                        <label><?= $w->norek . '<br>' . $w->nama_rekening ?></label>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                      <div class="form-group">
                                                        <label class="font-bold">LinkAja</label>
                                                        <br>
                                                        <label><?= $w->linkaja ?></label>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                      <div class="form-group">
                                                        <label class="font-bold">Evidence of Transfer</label>
                                                        <div class="custom-file">
                                                          <input id="logo" type="file" class="custom-file-input" name="bukti_transfer" accept="image/*">
                                                          <label for="logo" class="custom-file-label">Choose file...</label>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                  <button type="submit" class="btn btn-primary">Upload</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      <?php
                                      } elseif ($w->status_honor == '3') {
                                      ?>
                                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#bukti_transfer_aslab<?= $w->id_honor_aslab ?>"><i class="fa fa-file"></i></button>
                                        <div class="modal inmodal" id="bukti_transfer_aslab<?= $w->id_honor_aslab ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content animated bounceInRight">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title">Evidence of Transfer</h4>
                                              </div>
                                              <div class="modal-body">
                                                <img src="<?= base_url($w->bukti_transfer) ?>">
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      <?php
                                      }
                                      ?>
                                    </td>
                                    <div class="modal inmodal fade" id="detail_aslab<?= $w->id_honor_aslab ?>" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Detail Withdraw</h4>
                                          </div>
                                          <div class="modal-body">
                                            <div class="form-group row">
                                              <label class="col-md-5 col-sm-6 col-form-label">NIM</label>
                                              <label class="col-md-5 col-sm-6 col-form-label"><?= $w->nim ?></label>
                                            </div>
                                            <div class="form-group row">
                                              <label class="col-md-5 col-sm-6 col-form-label">Name</label>
                                              <label class="col-md-5 col-sm-6 col-form-label"><?= $w->namaLengkap ?></label>
                                            </div>
                                            <div class="form-group row">
                                              <label class="col-md-5 col-sm-6 col-form-label">Amount</label>
                                              <label class="col-md-5 col-sm-6 col-form-label">Rp <?= number_format($w->nominal, 0, '', '.') ?></label>
                                            </div>
                                            <div class="form-group row">
                                              <label class="col-md-5 col-sm-6 col-form-label">Withdraw Option</label>
                                              <label class="col-md-5 col-sm-6 col-form-label"><?= $w->opsi_pengambilan ?></label>
                                            </div>
                                            <div class="form-group row">
                                              <label class="col-md-5 col-sm-6 col-form-label">Bank Account Number</label>
                                              <label class="col-md-5 col-sm-6 col-form-label"><?= $w->norek . ' - ' . $w->nama_rekening ?></label>
                                            </div>
                                            <div class="form-group row">
                                              <label class="col-md-5 col-sm-6 col-form-label">LinkAja</label>
                                              <label class="col-md-2 col-sm-6 col-form-label"><?= $w->linkaja ?></label>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                          </div>
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
              </div>
            </div>
          </div>
        </div>
      </div>