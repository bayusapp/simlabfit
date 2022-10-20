      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
          <h2 style="text-align: center">Schedule<br>School of Applied Science School's Laboratory</h2>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <div class="col-md-4 offset-md-4" style="margin-bottom: 5px">
                <select class="form-control laboratorium" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                  <option></option>
                  <option value="<?= base_url('Schedule') ?>">All Laboratory</option>
                  <?php
                  foreach ($data as $d) {
                    echo '<option value="' . base_url('Schedule/index/' . substr(sha1($d->idLab), 6, 4)) . '">' . $d->namaLab . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="ibox">
              <div class="ibox-content">
                <div id="calendar"></div>
              </div>
            </div>
          </div>
        </div>
      </div>