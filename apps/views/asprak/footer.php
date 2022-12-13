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
<script>
  window.setTimeout(function() {
    $(".msg").fadeTo(500, 0).slideUp(500, function() {
      $(this).remove();
    });
  }, 3500);
</script>
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
    $(document).ready(function() {
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
        contentHeight: 400,
        eventSources: ['<?= base_url('Asprak/ajaxJadwal') ?>'],
        // dengan bootstrap
        eventRender: function(event, element) {
          $(element).tooltip({
            title: event.title
          });
        },
        // tanpa bootstrap
        // eventRender: function(event, element) {
        //   element[0].title = event.title;
        // },
        axisFormat: 'H:mm',
        timeFormat: {
          agenda: 'H:mm'
        }
      });

      $('#calendar').fullCalendar('changeView', 'agendaWeek');
    });
  </script>
<?php
}
if (uri('2') == 'PracticumAssistant') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script>
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
      $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .responsive.recalc();
    });

    $(document).ready(function() {
      $('.dataTables').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });
    });
  </script>
<?php
}
if (uri('2') == 'Presence') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/sweetalert/sweetalert.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script>
    window.setTimeout(function() {
      $(".msg").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 3500);

    function hapus_presensi(id) {
      $.ajax({
        url: '<?= base_url('Asprak/AjaxPresence') ?>',
        method: 'post',
        data: {
          id: id
        },
        success: function(response) {
          swal({
            title: 'Are you sure?',
            text: 'Do you want to delete your presence',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            closeOnConfirm: false
          }, function() {
            swal({
              title: 'Deleted!',
              text: 'Your presence has been deleted',
              timer: 1500,
              type: 'success',
              showConfirmButton: false
            }, function() {
              window.location.href = '<?= base_url('Asprak/DeletePresence/') ?>' + id;
            });
          });
        }
      });
    };

    $(document).ready(function() {
      $('.dataTables').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });

      $(".ta").select2({
        placeholder: "Select Year"
      });
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
      $(".jadwal").select2({
        placeholder: "Select Schedule"
      });

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
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
  <script>
    window.setTimeout(function() {
      $(".msg").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 3500);

    $(document).ready(function() {
      $(".matapraktikum").select2({
        placeholder: "Select Cource"
      });

      $(".periode_bap").select2({
        placeholder: "Select Month"
      });

      $("#matapraktikum").change(function() {
        <?php
        if (date('m') == 12 && date('d') >= 6) {
          $bulan = "'" . date('Y') . "-12-06' and '" . date('Y', strtotime('+1 years')) . "-01-05'|1|Januari";
        } elseif (date('m') == 1 && date('d') <= 5) {
          $bulan = "'" . date('Y', strtotime('-1 years')) . "-12-06' and '" . date('Y') . "-01-05'|1|Januari";
        }
        ?>
        var idMK = $(this).val();
        var bulan = document.getElementById('month').value;
        if (bulan != '') {
          bulan = bulan;
        } else {
          bulan = "<?= $bulan ?>";
        }
        document.getElementById('course').value = idMK;
        $.ajax({
          url: "<?= base_url() ?>Asprak/ajaxBAP",
          method: "POST",
          data: {
            bulan: bulan,
            idMK: idMK
          },
          success: function(data) {
            $('#tampil').html(data);
          }
        });
      });

      $("#bulan").change(function() {
        var bulan = $(this).val();
        var idMK = document.getElementById('matapraktikum').value;
        document.getElementById('month').value = bulan;
        if (idMK != '') {
          document.getElementById('month').value = bulan;
          $.ajax({
            url: "<?= base_url() ?>Asprak/ajaxBAP",
            method: "POST",
            data: {
              bulan: bulan,
              idMK: idMK
            },
            success: function(data) {
              $('#tampil').html(data);
            }
          });
          // var date = new Date();
          // var month = date.getMonth();
          // var split = bulan.split("|");
          // var noBulan = split[1] - 1;

          // var tanggal = date.getDate();
          // var nextMonth = (date.getMonth() + 1);
          // if ((tanggal >= 1 && tanggal <= 20) && month == noBulan) {
          //   document.getElementById('print').disabled = false;
          // } else if ((tanggal > 20 && tanggal <= 31) && nextMonth == noBulan) {
          //   document.getElementById('print').disabled = false;
          // } else if ((tanggal >= 1 && tanggal <= 20) && month != noBulan) {
          //   document.getElementById('print').disabled = true;
          // } else if ((tanggal > 20 && tanggal <= 31) && nextMonth != noBulan) {
          //   document.getElementById('print').disabled = true;
          // }
        }
      });
    });
  </script>
<?php
}
if (uri('2') == 'BAPP') {
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

      $(".ta").select2({
        placeholder: "Select Year"
      });
    });
  </script>
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
    function nimKM(event) {
      var angka = (event.which) ? event.which : event.keyCode
      if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
        return false;
      return true;
    }

    function komplainScript() {
      if (document.getElementById('tidak_ada').checked) {
        document.getElementById('catatan_komplain').disabled = true;
      } else {
        document.getElementById('catatan_komplain').disabled = false;
      }
    }

    function opsi_kehadiran() {
      if (document.getElementById('dosen_tidak_hadir').checked) {
        document.getElementById('jam_datang').disabled = true;
        document.getElementById('jam_pulang').disabled = true;
      } else {
        document.getElementById('jam_datang').disabled = false;
        document.getElementById('jam_pulang').disabled = false;
      }
    }

    // var tanggal_sekarang = new Date();
    // tanggal_sekarang.setDate(tanggal_sekarang.getDate());

    $(document).ready(function() {
      $("#form").validate({});

      $('#date_picker .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        // autoclose: true,
        // startDate: tanggal_sekarang
        autoclose: true
      });

      $('.clockpicker').clockpicker();

      $(".prodi").select2({
        placeholder: "Select Major",
      });

      $(".mk").select2({
        placeholder: "Select Courses",
      });

      $(".lab").select2({
        placeholder: "Select Laboratory",
      });

      $(".asprak").select2({
        placeholder: "Select Practicum Assistant",
      });

      $(".dosen").select2({
        placeholder: "Select Lecturer",
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
if (uri('2') == 'Salary') {
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
if (uri('2') == 'PracticumReport') {
?>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/datatables.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/inspinia/') ?>js/plugins/select2/select2.full.min.js"></script>
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

      $(".matkul").select2({
        placeholder: "Select Courses",
      });

      $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });
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
  <script>
    $(document).ready(function() {
      $('.dataTables').DataTable({
        pageLength: 10,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: []
      });
    });
  </script>
<?php
}
?>
</body>

</html>