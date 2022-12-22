<div class="footer">
  <div>
    <strong>Copyright</strong> SIM Laboratorium Team &copy; 2017
  </div>
</div>
</div>
</div>
<!-- Mainly scripts -->
<script src="<?= base_url('assets/inspinia/') ?>js/jquery-3.1.1.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/popper.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/bootstrap.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/inspinia.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/pace/pace.min.js"></script>
<script src="<?= base_url('assets/inspinia/') ?>js/plugins/toastr/toastr.min.js"></script>
<?php
if ($profil->kontak_asprak == null || $profil->email_asprak == null || $profil->ttd_asprak == null || $profil->id_bank == null || $profil->norek_asprak == null || $profil->nama_rekening == null) {
  $tmp = array();
  if ($profil->kontak_asprak == null) {
    array_push($tmp, 'phone number');
  }
  if ($profil->email_asprak == null) {
    array_push($tmp, 'email');
  }
  if ($profil->id_bank == null) {
    array_push($tmp, 'bank');
  }
  if ($profil->norek_asprak == null) {
    array_push($tmp, 'bank account number');
  }
  if ($profil->nama_rekening == null) {
    array_push($tmp, 'bank account name');
  }
  if ($profil->ttd_asprak == null) {
    array_push($tmp, 'digital signature');
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
        window.location.href = '<?= base_url('Asprak/Setting') ?>'
      }
      toastr.warning("Please complete your <?= $show ?> in Setting Menu");
    });
  </script>
<?php
}
if ($absen > 0) {
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
        window.location.href = '<?= base_url('Asprak/Presence') ?>'
      }
      toastr.warning("You have <?= $absen ?> presence must be corrected. Please go to presence and click te yellow button to edit");
    });
  </script>
<?php
}
if (uri('2') == 'Schedule') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/fullcalendar/moment.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/fullcalendar/fullcalendar.min.js"></script>
  <script>
  </script>
<?php
}
if (uri('2') == 'PracticumAssistant') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<?php
}
if (uri('2') == 'Presence') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/sweetalert/sweetalert.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/clockpicker/clockpicker.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <script>
    $(document).ready(function() {
      // $(".jadwal").select2({
      //   placeholder: "Select Schedule"
      // });
    });
  </script>
<?php
}
if (uri('2') == 'AddPresence' || uri('2') == 'EditPresence') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/clockpicker/clockpicker.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <script>
    var tanggal_sekarang = new Date();
    // tanggal_sekarang.setDate(tanggal_sekarang.getDate());
    tanggal_sekarang.setFullYear(2020, 2, 16);
    $(document).ready(function() {


      $('.clockpicker').clockpicker();

      $('#tanggal .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        startDate: tanggal_sekarang
      });

      $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });
    });
  </script>
<?php
}
if (uri('2') == 'BAP') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
<?php
}
if (uri('2') == 'BAPP') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/sweetalert/sweetalert.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<?php
}
if (uri('2') == 'AddBAPP' || uri('2') == 'EditBAPP') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/iCheck/icheck.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/validate/jquery.validate.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/clockpicker/clockpicker.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/html2canvas.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/numeric-1.2.6.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/bezier.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/jquery.signaturepad.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/json2.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/jasny/jasny-bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      // $("#form").validate({});






      $(".asprak").select2({
        placeholder: "Select Practicum Assistant",
      });



      $('#signArea').signaturePad({
        drawOnly: true,
        drawBezierCurves: true,
        lineTop: 90
      });

      $("#btnClearSign").click(function(e) {
        $('#signArea').signaturePad().clearCanvas();
      });

      $('#sign-pad').click(function(e) {
        html2canvas([document.getElementById('sign-pad')], {
          onrendered: function(canvas) {
            var canvas_img_data = canvas.toDataURL('image/png');
            var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
            document.getElementById('tmp_sign').value = img_data;
          }
        });
      })
    });
  </script>
<?php
}
if (uri('2') == 'Setting') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/sweetalert/sweetalert.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/html2canvas.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/numeric-1.2.6.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/bezier.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/jquery.signaturepad.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/digital-signature/json2.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/jasny/jasny-bootstrap.min.js"></script>
  <script>
    window.setTimeout(function() {
      $(".msg").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 3500);

    function opsi_ttd() {
      if (document.getElementById('draw').checked) {
        document.getElementById('tampil_field_draw').style.display = 'block';
        document.getElementById('tampil_field_upload').style.display = 'none';
      } else {
        document.getElementById('tampil_field_draw').style.display = 'none';
        document.getElementById('tampil_field_upload').style.display = 'block';
      }
    }

    function norek(event) {
      var angka = (event.which) ? event.which : event.keyCode
      if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
        return false;
      return true;
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
if (uri('2') == 'HistoryLogin') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<?php
}
?>
<script src="<?= base_url('assets/inspinia/') ?>js/main-asprak.js"></script>
</body>

</html>