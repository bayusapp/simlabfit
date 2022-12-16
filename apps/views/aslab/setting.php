      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Setting<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <?php
        if (flashdata('msg')) {
          echo flashdata('msg');
        }
        ?>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="tabs-container">
              <ul class="nav nav-tabs" role="tablist">
                <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Personal Information</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#tab-2">Digital Signature</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#tab-3">Account Setting</a></li>
              </ul>
              <div class="tab-content">
                <div role="tabpanel" id="tab-1" class="tab-pane active">
                  <div class="panel-body">
                    <form method="post" action="#">
                      <table width="100%">
                        <tbody>
                          <tr>
                            <td width="15%">NIM</td>
                            <td width="2%">:</td>
                            <td style="padding-bottom: 5px">
                              <input type="text" name="nim_aslab" id="nim_aslab" class="form-control" value="<?= $profil_aslab->nim ?>">
                            </td>
                          </tr>
                          <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td style="padding-bottom: 5px">
                              <input type="text" name="nama_aslab" id="nama_aslab" class="form-control" value="<?= $profil_aslab->namaLengkap ?>">
                            </td>
                          </tr>
                          <tr>
                            <td>Phone Number</td>
                            <td>:</td>
                            <td style="padding-bottom: 5px">
                              <input type="text" name="no_telp" id="no_telp" class="form-control" value="<?= $profil_aslab->noTelp ?>">
                            </td>
                          </tr>
                          <tr>
                            <td>Bank</td>
                            <td>:</td>
                            <td style="padding-bottom: 5px">
                              <select class="form-control bank" name="bank">
                                <option></option>
                                <?php
                                foreach ($bank as $b) {
                                  if ($profil_aslab->bank == $b->id_bank) {
                                    echo '<option value="' . $b->id_bank . '" selected>' . $b->nama_bank . '</option>';
                                  } else {
                                    echo '<option value="' . $b->id_bank . '">' . $b->nama_bank . '</option>';
                                  }
                                }
                                ?>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Bank Account Number</td>
                            <td>:</td>
                            <td style="padding-bottom: 5px">
                              <input type="text" name="norek" id="norek" class="form-control" value="<?= $profil_aslab->norek ?>" placeholder="Example: 1234567890" onkeypress="return norek(event)">
                            </td>
                          </tr>
                          <tr>
                            <td>Bank Account Name</td>
                            <td>:</td>
                            <td style="padding-bottom: 5px">
                              <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" value="<?= $profil_aslab->nama_rekening ?>">
                            </td>
                          </tr>
                          <tr>
                            <td colspan="7">
                              <p style="margin-top: 20px">
                                <button type="submit" class="btn btn-primary btn-sm col-md-1">Save</button>
                              </p>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </form>
                  </div>
                </div>
                <div role="tabpanel" id="tab-2" class="tab-pane">
                  <div class="panel-body">
                    <table width="100%">
                      <tr>
                        <td width="15%">Digital Signature</td>
                        <td width="2%">:</td>
                        <td style="padding-bottom: 5px">
                          <div class="form-group row form-inline" style="margin-top: 20px">
                            <div class="radio">
                              <input type="radio" name="ttd" id="upload" class="form-control" onclick="opsi_ttd()">
                              <label for="upload">Upload image</label>
                            </div>
                            <div class="radio">
                              <input type="radio" name="ttd" id="draw" class="form-control" onclick="opsi_ttd()">
                              <label for="draw">Put signature here</label>
                            </div>
                          </div>
                          <div class="row" id="tampil_field_upload" style="display: none">
                            <form action="<?= base_url('Asprak/UploadSign') ?>" method="post" enctype="multipart/form-data">
                              <input type="text" name="nim_asprak" id="nim_asprak" value="" hidden>
                              <div class="col-md-6 col-sm-6">
                                <h2 class="tag-ingo">Upload your signature below,</h2>
                                <div class="custom-file">
                                  <input id="logo" type="file" name="file_ttd" class="custom-file-input" accept="image/*">
                                  <label for="logo" class="custom-file-label">Choose file...</label>
                                </div>
                              </div>
                              <div class="col-md-6 col-sm-6" style="margin-top: 5px;">
                                <button type="submit" class="btn btn-primary btn-sm">Save Sign</button>
                              </div>
                            </form>
                          </div>
                          <div class="row" id="tampil_field_draw" style="display: none">
                            <div class="col-md-6 col-sm-6">
                              <div id="signArea">
                                <h2 class="tag-ingo">Put signature below,</h2>
                                <div class="sig sigWrapper" style="height:auto;">
                                  <div class="typed"></div>
                                  <canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
                                </div>
                              </div>
                              <div style="margin-top: 5px">
                                <button type="button" class="btn btn-primary btn-sm" id="btnSaveSign">Save Sign</button>
                                <button type="button" class="btn btn-warning btn-sm btnClearSign" id="btnClearSign">Clear Sign</button>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Your Signature</td>
                        <td>:</td>
                        <td style="padding-bottom: 5px"></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div role="tabpanel" id="tab-3" class="tab-pane">
                  <div class="panel-body">
                    <form method="post" action="#">
                      <table width="100%">
                        <tr>
                          <td width="15%">Username</td>
                          <td>:</td>
                          <td style="padding-bottom: 5px">
                            <input type="text" name="username" id="username" class="form-control" value="<?= $akun->username ?>" readonly>
                          </td>
                        </tr>
                        <tr>
                          <td>Old Password</td>
                          <td>:</td>
                          <td style="padding-bottom: 5px">
                            <input type="password" name="password_lama" id="password_lama" class="form-control">
                          </td>
                        </tr>
                        <tr>
                          <td>New Password</td>
                          <td>:</td>
                          <td style="padding-bottom: 5px">
                            <input type="password" name="password_baru" id="password_baru" class="form-control">
                          </td>
                        </tr>
                        <tr>
                          <td>Repeat Password</td>
                          <td>:</td>
                          <td style="padding-bottom: 5px">
                            <input type="password" name="konfirm_password" id="konfirm_password" class="form-control">
                          </td>
                        </tr>
                        <tr>
                          <td colspan="7">
                            <p style="margin-top: 20px">
                              <button type="submit" class="btn btn-primary btn-sm col-md-1">Save</button>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>