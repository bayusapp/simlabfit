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


<script src="<?= base_url('assets/inspinia/') ?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/iCheck/icheck.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/toastr/toastr.min.js"></script>
<?php
if ($cek_aslab->bank == null || $cek_aslab->norek == null || $cek_aslab->nama_rekening == null) {
  $tmp = array();
  if ($cek_aslab->bank == null) {
    array_push($tmp, 'bank');
  }
  if ($cek_aslab->norek == null) {
    array_push($tmp, 'bank account number');
  }
  if ($cek_aslab->nama_rekening == null) {
    array_push($tmp, 'bank account name');
  }
  $show = '';
  for ($i = 0; $i < count($tmp); $i++) {
    if (count($tmp) == 1) {
      $show .= $tmp[$i];
    } else {
      if ($i == count($tmp) - 1) {
        $show .= 'and ' . $tmp[$i];
      } else {
        $show .= $tmp[$i] . ', ';
      }
    }
  }
?>
  <script>
    $(function() {
      toastr.options = {
        "closeButton": false,
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
        window.location.href = '<?= base_url('Setting') ?>'
      }
      toastr.warning("Please complete your <?= $show ?> in Setting Menu");
    });
  </script>
<?php
}
if (uri('1') == 'Dashboard') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/chartJs/Chart.min.js"></script>
  <script>
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
  }
    ?>
  </script>
  <script>
    window.setTimeout(function() {
      $(".msg").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 3500);

    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 5000);

    function hanya_angka(event) {
      var angka = (event.which) ? event.which : event.keyCode
      if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
        return false;
      return true;
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

      <?php
      if (uri('1') == 'StockLists') {
      ?>
        $('.stock_lists').DataTable({
          pageLength: 10,
          responsive: true,
          <?php
          if (isset($id_lab)) {
            echo "'ajax': '" . base_url('StockLists/ajaxStockLists/' . $id_lab) . "',";
          } else {
            echo "'ajax': '" . base_url('StockLists/ajaxStockLists') . "',";
          }
          ?> 'columns': [{
            "data": "no"
          }, {
            "data": "barcode"
          }, {
            "data": "tools"
          }, {
            "data": "lab"
          }, {
            "data": "qty"
          }, {
            "data": "condition"
          }, {
            "data": "spesification"
          }, {
            "data": "action"
          }],
          dom: '<"html5buttons"B>lTfgitp',
          buttons: []
        });
      <?php
      }
      ?>

      <?php
      if (uri('2') == 'JournalAssistant') {
      ?>
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
      <?php
      }
      ?>

      $(".laboratorium").select2({
        placeholder: "Select a Laboratory",
      });

      $(".periode_aslab").select2({
        placeholder: "Select Periode",
      });

      $(".periode").select2({
        placeholder: "Select a Periode of Journal",
      });

      $(".bank").select2({
        placeholder: "Select Bank Name",
      });

      $('.dataTables').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.daftar_lab').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.kegiatan_aslab').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.peminjaman').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.history_login').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });

      <?php
      if (uri('1') == 'Schedule') {
      ?>
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
      <?php
      }
      ?>
    });
  </script>
  <?php
  if (uri('1') == 'Finance') {
  ?>
    <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
    <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
    <script>
      window.setTimeout(function() {
        $(".msg").fadeTo(500, 0).slideUp(500, function() {
          $(this).remove();
        });
      }, 3500);

      $(document).ready(function() {
        $('.dataTables').DataTable({
          pageLength: 10,
          responsive: true,
          dom: '<"html5buttons"B>lTfgitp',
          buttons: []
        });

        $('.honor').click(function(event) {
          var total = 0;
          var id_honor = '';
          var tmp = '';
          $('.honor:checked').each(function() {
            tmp = $(this).val().split('|');
            id_honor = id_honor + '|' + tmp[1];
            total += parseInt($(this).val());
          });
          document.getElementById('id_honor').value = id_honor;

          if (total === 0) {
            $('#total_honor').text('Rp 0');
            document.getElementById('cek_alert').disabled = true;
          } else {
            $('#total_honor').text('Rp ' + total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
            $('#modal_total_honor').text('Rp ' + total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
            document.getElementById('cek_alert').disabled = false;
          }
        });
      });

      function ya_tidak_honor() {
        if (document.getElementById('tidak_cek').checked) {
          document.getElementById('tampil_surat_kuasa').style.display = 'block';
        } else {
          document.getElementById('tampil_surat_kuasa').style.display = 'none';
        }
      }
    </script>
  <?php
  }
  if (uri('1') == 'Setting') {
  ?>
    <script src="<?= base_url('assets/inspinia/') ?>js/html2canvas.js"></script>
    <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/numeric-1.2.6.min.js"></script>
    <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/bezier.js"></script>
    <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/jquery.signaturepad.js"></script>
    <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/json2.min.js"></script>
    <script src="<?= base_url('assets/inspinia/') ?>js/plugins/jasny/jasny-bootstrap.min.js"></script>
    <script>
      function norek(event) {
        var angka = (event.which) ? event.which : event.keyCode
        if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
          return false;
        return true;
      }

      function opsi_ttd() {
        if (document.getElementById('draw').checked) {
          document.getElementById('tampil_field_draw').style.display = 'block';
          document.getElementById('tampil_field_upload').style.display = 'none';
        } else {
          document.getElementById('tampil_field_draw').style.display = 'none';
          document.getElementById('tampil_field_upload').style.display = 'block';
        }
      }

      $(document).ready(function() {
        $('.custom-file-input').on('change', function() {
          let fileName = $(this).val().split('\\').pop();
          $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        $(".nama_bank").select2({
          placeholder: "Select a Bank Name",
        });

        $('#signArea').signaturePad({
          drawOnly: true,
          drawBezierCurves: true,
          lineTop: 90
        });

        $("#btnClearSign").click(function(e) {
          $('#signArea').signaturePad().clearCanvas();
        });
      });

      $("#btnSaveSign").click(function(e) {
        html2canvas([document.getElementById('sign-pad')], {
          onrendered: function(canvas) {
            var canvas_img_data = canvas.toDataURL('image/png');
            var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
            var nim_asprak = document.getElementById('nim_asprak').value;
            $.ajax({
              url: '<?= base_url('Asprak/SaveSignature') ?>',
              data: {
                img_data: img_data,
                nim_asprak: nim_asprak
              },
              type: 'post',
              dataType: 'json',
              success: function(response) {
                window.location.href = "<?= base_url('Asprak/SaveSign') ?>";
              }
            });
          }
        });
      });
    </script>
  <?php
  }
  ?>
  </body>

  </html>