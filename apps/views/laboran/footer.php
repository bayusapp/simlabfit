<div class="footer">
  <div>
    <strong>Copyright</strong> SIM Laboratorium Team &copy; 2017
  </div>
</div>
</div>
</div>
<!-- Mainly scripts -->
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/fullcalendar/moment.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/jquery-3.1.1.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/popper.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/bootstrap.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/inspinia.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/pace/pace.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/toastr/toastr.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/sweetalert/sweetalert.min.js"></script>
<!-- Addon scripts -->
<script>
  window.setTimeout(function() {
    $(".msg").fadeTo(500, 0).slideUp(500, function() {
      $(this).remove();
    });
  }, 3500);
</script>
<?php
if ($laporan_asprak > 0) {
?>
  <script>
    $(function() {
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": false,
        "preventDuplicates": false,
        "positionClass": "toast-bottom-right",
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "0",
        "extendedTimeOut": "0",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.options.onclick = function() {
        window.location.href = '<?= base_url('Practicum/Report') ?>'
      }
      toastr.warning("You have <?= $laporan_asprak ?> practicum report to check. Please go to Practicum &rarr; Practicum Report");
    });
  </script>
<?php
}
if ($honor_asprak > 0) {
?>
  <script>
    $(function() {
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": false,
        "preventDuplicates": false,
        "positionClass": "toast-bottom-right",
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "0",
        "extendedTimeOut": "0",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.options.onclick = function() {
        window.location.href = '<?= base_url('Finance/Honor#pengambilan') ?>'
      }
      toastr.info("You have <?= $honor_asprak ?> practicum assistant salary withdrawals to check. Please go to Finance &rarr; Honor");
    });
  </script>
<?php
}
if ($honor_aslab > 0) {
?>
  <script>
    $(function() {
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": false,
        "preventDuplicates": false,
        "positionClass": "toast-bottom-right",
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "0",
        "extendedTimeOut": "0",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.info("You have <?= $honor_aslab ?> laboratory assistant salary withdrawals to check. Please go to Finance &rarr; Honor");
    });
  </script>
<?php
}
if (uri('1') == 'Dashboard') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/chartJs/Chart.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/iCheck/icheck.min.js"></script>
  <script>
    function hapus_pengumuman(id) {
      $.ajax({
        url: '<?= base_url('Dashboard/ajaxPengumuman') ?>',
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
              text: 'Your announcement has been deleted',
              timer: 1500,
              type: 'success',
              showConfirmButton: false
            }, function() {
              window.location.href = '<?= base_url('Dashboard/DeleteAnnouncement/') ?>' + id;
            });
          });
        }
      });
    }

    var tanggal_sekarang = new Date();
    tanggal_sekarang.setDate(tanggal_sekarang.getDate());
    $(document).ready(function() {
      $('#date_picker .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        startDate: tanggal_sekarang
      });

      $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
      });
    });

    <?php
    if (isset($komplain)) {
    ?>
      $(function() {
        var line_data = {
          labels: ['', <?php
                        foreach ($komplain as $k) {
                          echo "'" . $k->bulan . "', ";
                        }
                        ?>],
          datasets: [{
            label: 'Complaint(s)',
            backgroundColor: 'rgba(26,179,148,0.5)',
            borderColor: "rgba(26,179,148,0.7)",
            pointBackgroundColor: "rgba(26,179,148,1)",
            pointBorderColor: "#fff",
            data: [0, <?php
                      foreach ($komplain as $k) {
                        echo $k->jumlah . ',';
                      }
                      ?>]
          }]
        };

        var line_option = {
          responsive: true,
          legend: {
            display: false
          }
        };

        var ctx = document.getElementById("grafik_komplain").getContext("2d");
        new Chart(ctx, {
          type: 'line',
          data: line_data,
          options: line_option
        });
      });
    <?php
    }
    ?>
  </script>
<?php
}
if (uri('1') == 'StockLists') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script>
    function hanya_angka(event) {
      var angka = (event.which) ? event.which : event.keyCode
      if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
        return false;
      return true;
    }

    function hapus_inventaris(id) {
      $.ajax({
        url: '<?= base_url('StockLists/ajaxNamaStockList') ?>',
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
              text: 'Your stock list has been deleted',
              timer: 1500,
              type: 'success',
              showConfirmButton: false
            }, function() {
              window.location.href = '<?= base_url('StockLists/DeleteStockList/') ?>' + id;
            });
          });
        }
      });
    }

    $(document).ready(function() {
      $('.stock_lists').DataTable({
        pageLength: 10,
        responsive: true,
        <?php
        if (isset($id_lab)) {
          echo "'ajax': '" . base_url('StockLists/ajaxStockLists/' . $id_lab) . "'";
        } else {
          echo "'ajax': '" . base_url('StockLists/ajaxStockLists') . "'";
        }
        ?>,
        'columns': [{
          'data': 'no'
        }, {
          'data': 'barcode'
        }, {
          'data': 'tools'
        }, {
          'data': 'lab'
        }, {
          'data': 'qty'
        }, {
          'data': 'condition'
        }, {
          'data': 'spesification'
        }, {
          'data': 'action'
        }],
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $(".laboratorium").select2({
        placeholder: "Select Laboratory",
      });
    });
  </script>
<?php
}
if (uri('1') == 'Laboratory') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/iCheck/icheck.min.js"></script>
  <script>
    function hapus_lab(id) {
      $.ajax({
        url: '<?= base_url('Laboratory/ajaxNamaLab') ?>',
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
              text: response + ' Laboratory been deleted',
              timer: 1500,
              type: 'success',
              showConfirmButton: false
            }, function() {
              window.location.href = '<?= base_url('Laboratory/DeleteLaboratory/') ?>' + id;
            });
          });
        }
      });
    }

    $(document).ready(function() {
      $('.daftar_lab').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
      });
    });
  </script>
<?php
}
if (uri('1') == 'Practicum') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
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

    function generate_sertifikat(id) {
      $.ajax({
        url: '<?= base_url('Practicum/ajaxCertificate') ?>',
        method: 'post',
        data: {
          id: id
        },
        success: function(response) {
          swal({
            title: 'Are you sure?',
            text: 'Do you want to generate certificate "' + response + '"',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            closeOnConfirm: false
          }, function() {
            window.location.href = '<?= base_url('Practicum/GenerateCertificate/') ?>' + id;
          });
        }
      });
    }

    $(document).ready(function() {
      $('.courses').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.asprak').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.report').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.bap').DataTable({
        pageLength: 10,
        responsive: true,
        'ajax': '<?= base_url('Practicum/ajaxBAP') ?>',
        'columns': [{
          'data': 'no'
        }, {
          'data': 'nim_asprak'
        }, {
          'data': 'nama_asprak'
        }, {
          'data': 'matakuliah'
        }, {
          'data': 'approve'
        }, {
          'data': 'periode'
        }, {
          'data': 'tahun'
        }, {
          'data': 'action'
        }],
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $(".tahun_ajaran").select2({
        placeholder: "Select Year",
      });

      $(".daftar_mk").select2({
        placeholder: "Select Courses",
      });

      $(".periode").select2({
        placeholder: "Select Periode",
      });

      $(".ta").select2({
        placeholder: "Select Year",
      });

      $(".prodi").select2({
        placeholder: "Select Majors",
      });

      $(".matkul").select2({
        placeholder: "Select Courses",
      });
    });
  </script>
<?php
}
if (uri('1') == 'LaboratoryAssistant') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".laboratorium").select2({
        placeholder: "Select Laboratory",
      });

      $(".periode").select2({
        placeholder: "Select Periode of Journal",
      });

      $('.kegiatan_aslab').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.kegiatan_aslab_full').DataTable({
        pageLength: 10,
        responsive: true,
        'ajax': '<?= base_url('LaboratoryAssistant/ajaxKegiatanAslab') ?>',
        'columns': [{
            'data': 'no'
          },
          {
            'data': 'tanggal'
          },
          {
            'data': 'nama'
          },
          {
            'data': 'aktivitas'
          }
        ],
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });
    });
  </script>
<?php
}
if (uri('1') == 'Schedule') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/fullcalendar/fullcalendar.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".laboratorium").select2({
        placeholder: "Select Laboratory",
      });

      var date = new Date();
      var d = date.getDate();
      var m = date.getMonth();
      var y = date.getFullYear();

      $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        droppable: false,
        eventSources: [
          <?php
          if ($id_lab) {
            echo "'" . base_url('Schedule/ajaxJadwal/' . $id_lab) . "'";
          } else {
            echo "'" . base_url('Schedule/ajaxJadwal') . "'";
          }
          ?>
        ]
      });

      $('#calendar').fullCalendar('changeView', 'agendaDay');
    });
  </script>
<?php
}
if (uri('1') == 'Borrowing') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/iCheck/icheck.min.js"></script>
  <script>
    function hanya_angka(event) {
      var angka = (event.which) ? event.which : event.keyCode
      if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
        return false;
      return true;
    }

    $(document).ready(function() {
      $('.peminjaman').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $(".laboratorium").select2({
        placeholder: "Select Laboratory",
      });

      $(".alat").select2({
        placeholder: "Select Equipment",
      });

      $('#tanggal_pinjam .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
      });

      $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
      });
    });
  </script>
<?php
}
if (uri('1') == 'Complaint') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/iCheck/icheck.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.peminjaman').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('#tanggal_komplain .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
      });

      $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
      });

      $(".laboratorium").select2({
        placeholder: "Select Laboratory",
      });
    });
  </script>
<?php
}
if (uri('1') == 'Option') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".periode").select2({
        placeholder: "Select Periode",
      });

      $(".tarif").select2({
        placeholder: "Select Honor",
      });
    });
  </script>
<?php
}
if (uri('1') == 'HistoryLogin') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.history_login').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });
    });
  </script>
<?php
}
if (uri('1') == 'Finance') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/chartJs/Chart.min.js"></script>
  <script>
    $(function() {
      var hash = window.location.hash;
      hash && $('ul.nav a[href="' + hash + '"]').tab('show');

      $('.nav-tabs a').click(function(e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
      });
    });

    $(function() {
      var line_data = {
        <?php
        $tahun_ajaran = $this->db->query('select distinct tahun_ajaran.ta, tahun_ajaran.id_ta from pk join tahun_ajaran on pk.id_ta = tahun_ajaran.id_ta')->result();
        ?>
        labels: ['',
          <?php
          foreach ($tahun_ajaran as $t) {
            echo "'" . $t->ta . "',";
          }
          ?>
        ],
        datasets: [
          <?php
          $prodi = $this->db->get('prodi')->result();
          foreach ($prodi as $p) {
            $pk = $this->db->select('sum(total) total')->from('pk')->where('kode_prodi', $p->kode_prodi)->group_by('id_ta')->group_by('kode_prodi')->get()->result();
          ?> {
              label: '<?= $p->kode_prodi ?>',
              backgroundColor: '<?= $p->color ?>',
              borderColor: '<?= $p->color ?>',
              data: [0,
                <?php
                foreach ($pk as $p) {
                  echo $p->total . ',';
                }
                ?>
              ],
              fill: false
            },
          <?php
          }
          ?>
        ]
      };

      var line_options = {
        responsive: true
      };

      var ctx = document.getElementById("lineChart").getContext("2d");
      new Chart(ctx, {
        type: 'line',
        data: line_data,
        options: line_options
      });
    })

    $(document).ready(function() {
      $('.submission').DataTable({
        pageLength: 8,
        responsive: true,
        'ajax': '<?= base_url('Finance/ajaxSubmission') ?>',
        'columns': [{
          'data': 'no_pk'
        }, {
          'data': 'informasi'
        }, {
          'data': 'total',
          'className': 'dt-right'
        }, {
          'data': 'tgl_pengajuan'
        }, {
          'data': 'tgl_cair'
        }, {
          'data': 'status'
        }, {
          'data': 'action'
        }],
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [],
        aaSorting: [
          [0, 'desc']
        ]
      });

      $('.asprak').DataTable({
        pageLength: 10,
        responsive: true,
        'ajax': '<?= base_url('Finance/ajaxSalaryAsprak') ?>',
        'columns': [{
          'data': 'no'
        }, {
          'data': 'kode_mk'
        }, {
          'data': 'nama_mk'
        }, {
          'data': 'nim'
        }, {
          'data': 'nama'
        }, {
          'data': 'periode'
        }, {
          'data': 'jumlah',
          'className': 'dt-right'
        }, {
          'data': 'opsi'
        }, {
          'data': 'status'
        }, {
          'data': 'action'
        }],
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [],
        aaSorting: [
          [8, 'asc']
        ]
        // 'ajax': '<?= base_url('Finance/ajaxSalaryAsprak') ?>',
        // 'columns': [{
        //   'data': 'no'
        // }, {
        //   'data': 'kode_mk'
        // }, {
        //   'data': 'nama_mk',
        // }, {
        //   'data': 'nim'
        // }, {
        //   'data': 'nama'
        // }, {
        //   'data': 'periode'
        // }, {
        //   'data': 'jumlah'
        // }, {
        //   'data': 'opsi'
        // }, {
        //   'data': 'status'
        // }, {
        //   'data': 'action'
        // }],
        // dom: '<"html5buttons"B>lTfgitp',
        // buttons: []
      });

      $('.aslab').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $(".type_submission").select2({
        placeholder: "Select Type",
      });

      $(".prodi").select2({
        placeholder: "Select Major",
      });

      $(".ta").select2({
        placeholder: "Select Year",
      });

      $(".periode").select2({
        placeholder: "Select Period",
      });

      $(".pembuat").select2({
        placeholder: "Select Person",
      });

      $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });
    });

    function approve_honor(id) {
      $.ajax({
        url: '<?= base_url('Finance/ApproveHonor/') ?>' + id,
        method: 'post',
        data: {
          id: id
        },
        success: function(response) {
          if (response == 'true') {
            document.getElementById('btn_approve_honor' + id).innerHTML = '';
            document.getElementById('btn_approve_honor' + id).innerHTML = '<button class="btn btn-success btn-sm" disabled><i class="fa fa-check"></i></button>';
          }
        }
      });
    }
  </script>
<?php
}
?>
</body>

</html>