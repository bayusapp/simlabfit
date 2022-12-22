var base_url = 'http://localhost/simlabfit/'

window.setTimeout(function () {
  $(".msg").fadeTo(500, 0).slideUp(500, function () {
    $(this).remove();
  });
}, 3500);

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust()
    .responsive.recalc();
});

function hapus_bapp(id) {
  $.ajax({
    url: base_url + 'Asprak/AjaxBAPP',
    method: 'post',
    data: {
      id: id
    },
    success: function (response) {
      swal({
        title: 'Are you sure?',
        text: 'Do you want to delete your BAPP',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        closeOnConfirm: false
      }, function () {
        swal({
          title: 'Deleted!',
          text: 'Your BAPP has been deleted',
          timer: 1500,
          type: 'success',
          showConfirmButton: false
        }, function () {
          $.ajax({
            url: base_url + 'Asprak/DeleteBAPP',
            method: 'post',
            data: {
              id: id
            },
          });
          window.location.href = base_url + 'Asprak/BAPP';
        });
      });
    }
  });
}

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

$(document).ready(function () {
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
    eventSources: [base_url + 'Asprak/ajaxJadwal'],
    eventRender: function (event, element) {
      $(element).tooltip({
        title: event.title
      });
    },
    axisFormat: 'H:mm',
    timeFormat: {
      agenda: 'H:mm'
    }
  });

  $('#calendar').fullCalendar('changeView', 'agendaWeek');
});

$(document).ready(function () {
  $('.dataTables').DataTable({
    pageLength: 10,
    responsive: true,
    dom: '<"html5buttons"B>lTfgitp',
    buttons: []
  });

  $('#date_picker .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true
  });

  $('.clockpicker').clockpicker({
    autoclose: true
  });

  $(".jadwal").select2({
    placeholder: "Select Schedule"
  });
});

$(document).ready(function () {
  $('#date_picker .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true
  });

  $(".matapraktikum").select2({
    placeholder: "Select Cource"
  });

  $("#awal").change(function () {
    var idMK = document.getElementById('matapraktikum').value;
    var awal = $(this).val();
    var akhir = document.getElementById('akhir').value;
    if (idMK) {
      $.ajax({
        url: base_url + "Asprak/ajaxBAP",
        method: "POST",
        data: {
          awal: awal,
          akhir: akhir,
          idMK: idMK
        },
        success: function (data) {
          $('#tampil').html(data);
        }
      });
    }
  });

  $("#akhir").change(function () {
    var idMK = document.getElementById('matapraktikum').value;
    var awal = document.getElementById('awal').value;
    var akhir = $(this).val();
    if (idMK) {
      $.ajax({
        url: base_url + "Asprak/ajaxBAP",
        method: "POST",
        data: {
          awal: awal,
          akhir: akhir,
          idMK: idMK
        },
        success: function (data) {
          $('#tampil').html(data);
        }
      });
    }
  });

  $("#matapraktikum").change(function () {
    var idMK = $(this).val();
    var awal = document.getElementById('awal').value;
    var akhir = document.getElementById('akhir').value;
    $.ajax({
      url: base_url + "Asprak/ajaxBAP",
      method: "POST",
      data: {
        awal: awal,
        akhir: akhir,
        idMK: idMK
      },
      success: function (data) {
        $('#tampil').html(data);
      }
    });
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

  $(".dosen").select2({
    placeholder: "Select Lecturer",
  });
});

$('#jam_datang, #jam_pulang, #jam_masuk, #jam_selesai').on('input', function (e) {
  $(this).val(function (i, v) {
    return v.replace(/[^\d:]/gi, '');
  });
});