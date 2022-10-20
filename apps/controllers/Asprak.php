<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asprak extends CI_Controller
{

  var $data;

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'asprak') {
      redirect();
    }
    $this->data = array(
      'profil'  => $this->a->profilAsprak(userdata('nim'))->row(),
      'absen'   => $this->db->select('count(id_presensi_asprak) jumlah')->from('presensi_asprak')->where('nim_asprak', userdata('nim'))->where('approve_absen', '0')->get()->row()->jumlah
    );
  }

  public function Dashboard()
  {
    $data             = $this->data;
    $data['title']      = 'Dashboard | SIM Laboratorium';
    $data['pengumuman'] = $this->a->daftarPengumuman()->result();
    view('asprak/header', $data);
    view('asprak/dashboard', $data);
    view('asprak/footer');
  }

  public function Schedule()
  {
    $data           = $this->data;
    $data['title']  = 'Schedule | SIM Laboratorium';
    view('asprak/header', $data);
    view('asprak/schedule', $data);
    view('asprak/footer');
  }

  public function ajaxJadwal()
  {
    $hasil  = array();
    $jadwal = $this->a->jadwalMKAsprak(userdata('nim'))->result();
    foreach ($jadwal as $j) {
      $tmp['title']           = $j->title;
      $tmp['start']           = $j->start;
      $tmp['end']             = $j->end;
      $tmp['dow']             = $j->hari_ke;
      $tmp['backgroundColor'] = '#ff6b6b';
      $tmp['borderColor']     = '#ff6b6b';
      array_push($hasil, $tmp);
    }
    $data = $this->a->jadwalAsprak(userdata('nim'))->result();
    foreach ($data as $d) {
      $tmp['title']           = $d->title;
      $tmp['start']           = $d->start;
      $tmp['end']             = $d->end;
      $tmp['dow']             = $d->hari_ke;
      $tmp['backgroundColor'] = '#1ab394';
      $tmp['borderColor']     = '#1ab394';
      array_push($hasil, $tmp);
    }
    echo json_encode($hasil);
  }

  public function PracticumAssistant()
  {
    $data           = $this->data;
    $data['title']  = 'Practicum Assistant | SIM Laboratorium';
    view('asprak/header', $data);
    view('asprak/practicum_assistant', $data);
    view('asprak/footer');
  }

  public function Presence()
  {
    set_rules('ta', 'Year', 'required|trim');
    if (validation_run() == false) {
      $data           = $this->data;
      $data['title']  = 'Presence | SIM Laboratorium';
      $data['data']   = $this->a->daftarPresensiAsprak(userdata('nim'))->result();
      view('asprak/header', $data);
      view('asprak/presence', $data);
      view('asprak/footer');
    } else {
      $ta = input('ta');
      $tahun_ajaran = $this->db->where('id_ta', $ta)->get('tahun_ajaran')->row();
      if ($tahun_ajaran == true) {
        $semester   = substr($tahun_ajaran->ta, -1);
        $tahun      = substr($tahun_ajaran->ta, 0, 4);
        if ($semester == '1') {
          $between  = '"' . $tahun . '-07-01" and "' . $tahun . '-12-31"';
        } elseif ($semester == '2') {
          $between  = '"' . ($tahun + 1) . '-01-01" and "' . ($tahun + 1) . '-06-30"';
        }
        $data           = $this->data;
        $data['title']  = 'Presence | SIM Laboratorium';
        $data['data']   = $this->a->daftarPresensiAsprakPeriode(userdata('nim'), $between)->result();
        view('asprak/header', $data);
        view('asprak/presence', $data);
        view('asprak/footer');
      }
    }
  }

  public function AddPresence()
  {
    // $target = '2020-05-20';
    // if (date('Y-m-d') <= $target) {
    $tanggal = '2020-05-22';
    $jam_awal = '14:00';
    $jam_selesai = '17:00';
    if (date('Y-m-d') == $tanggal && (date('H:i') >= $jam_awal && date('H:i') <= $jam_selesai)) {
      set_rules('jadwal_asprak', 'Schedule', 'required|trim');
      set_rules('tgl_asprak', 'Date', 'required|trim');
      set_rules('jam_masuk', 'Start', 'required|trim');
      set_rules('jam_selesai', 'End', 'required|trim');
      set_rules('modul_praktikum', 'Practicum Modul', 'required|trim');
      if (validation_run() == false) {
        $data           = $this->data;
        $data['title']  = 'Add Presence | SIM Laboratorium';
        $data['jadwal'] = $this->a->jadwalPresensiAsprak(userdata('nim'))->result();
        view('asprak/header', $data);
        view('asprak/add_presence', $data);
        view('asprak/footer');
      } else {
        $honor_asprak     = $this->db->get('tarif')->row()->tarif_honor;
        $jadwal_asprak    = input('jadwal_asprak');
        $tgl_asprak       = input('tgl_asprak');
        $jam_masuk        = input('jam_masuk');
        $jam_selesai      = input('jam_selesai');
        $modul_praktikum  = input('modul_praktikum');
        // $link_youtube     = input('link_youtube');
        $tmp              = explode('/', $tgl_asprak);
        $urut_tanggal     = array($tmp[2], $tmp[0], $tmp[1]);
        $tanggal          = implode('-', $urut_tanggal);
        $tmp              = explode(':', $jam_masuk);
        $jam_masuk_       = ($tmp[0] * 3600) + ($tmp[1] * 60);
        $tmp              = explode(':', $jam_selesai);
        $jam_selesai_     = ($tmp[0] * 3600) + ($tmp[1] * 60);
        $selisih          = $jam_selesai_ - $jam_masuk_;
        $hitung_durasi    = $selisih / 3600;
        $hitung_durasi    = explode('.', $hitung_durasi);
        $selisih_jam      = $hitung_durasi[0];
        $selisih_menit    = ($selisih % 3600) / 60;
        $honor            = $honor_asprak * $selisih_jam;
        $durasi           = $selisih_jam;
        if ($selisih_menit >= 20 && $selisih_menit <= 30) {
          $honor          = $honor + ($honor_asprak / 2);
          $durasi         = $selisih_jam + 0.5;
        } elseif ($selisih_menit >= 40 && $selisih_menit <= 59) {
          $honor          = $honor + $honor_asprak;
          $durasi         = $selisih_jam + 1;
        } elseif ($selisih_menit >= 1 && $selisih_menit < 20) {
          $honor          = $honor;
          $durasi         = $selisih_jam;
        } elseif ($selisih_menit > 30 && $selisih_menit < 40) {
          $honor          = $honor + ($honor_asprak / 2);
          $durasi         = $selisih_jam + 0.5;
        }
        $cek_presensi     = $this->db->where('date_format(asprak_masuk, "%Y-%m-%d") = "' . $tanggal . '"')->where('id_jadwal_asprak', $jadwal_asprak)->where('nim_asprak', userdata('nim'))->get('presensi_asprak')->row();
        if ($cek_presensi) {
          set_flashdata('msg', '<div class="alert alert-danger">You already presence on that day</div>');
          redirect('Asprak/Presence');
        } else {
          $nama_hari        = date('l', strtotime($tanggal));
          $id_jadwal_lab    = $this->db->get_where('jadwal_asprak', array('id_jadwal_asprak' => $jadwal_asprak))->row()->id_jadwal_lab;
          $cek_jadwal_hari  = $this->db->select('hari_ke')->from('jadwal_lab')->where('id_jadwal_lab', $id_jadwal_lab)->get()->row()->hari_ke;
          $cek_jam_masuk    = $this->db->select('date_format(jam_masuk, "%H:%i") masuk')->from('jadwal_lab')->where('id_jadwal_lab', $id_jadwal_lab)->get()->row()->masuk;
          $cek_jam_selesai  = $this->db->select('date_format(jam_selesai, "%H:%i") selesai')->from('jadwal_lab')->where('id_jadwal_lab', $id_jadwal_lab)->get()->row()->selesai;
          if ($nama_hari != hariInggris($cek_jadwal_hari) || $jam_masuk < $cek_jam_masuk || $jam_selesai > $cek_jam_selesai) {
            echo 'Your presence is not according to the day of practicum or start time before the schedule or end time exceeded the schedule';
            set_flashdata('msg', '<div class="alert alert-danger">Your presence is not according to the day of practicum or start time before the schedule or end time exceeded the schedule</div>');
            redirect('Asprak/AddPresence');
          }
          $input                = array(
            'asprak_masuk'      => $tanggal . ' ' . $jam_masuk,
            'asprak_selesai'    => $tanggal . ' ' . $jam_selesai,
            'durasi'            => $durasi,
            'honor'             => $honor,
            'modul'             => $modul_praktikum,
            // 'video'             => $link_youtube,
            'approve_absen'     => '1',
            'id_jadwal_asprak'  => $jadwal_asprak,
            'nim_asprak'        => userdata('nim'),
            'id_jadwal_lab'     => $id_jadwal_lab
          );
          $screenshot               = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['screenshot_praktikum']['name']);
          $config['upload_path']    = 'assets/screenshot/';
          $config['allowed_types']  = 'jpeg|jpg|png|gif';
          $config['max_size']       = 1024 * 100;
          $config['file_name']      = $screenshot;
          $this->load->library('upload', $config);
          if ($this->upload->do_upload('screenshot_praktikum')) {
            $input['screenshot']     = $config['upload_path'] . '' . $screenshot;
          }
          if (!empty($_FILES['video_praktikum'])) {
            $target_folder  = 'assets/video/';
            $nama_file      = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['video_praktikum']['name']);
            $upload_file    = $target_folder . $nama_file;
            $input['video'] = $upload_file;
            move_uploaded_file($_FILES['video_praktikum']['tmp_name'], $upload_file);
          }
          $this->m->insertData('presensi_asprak', $input);
          set_flashdata('msg', '<div class="alert alert-success msg">Your presence successfully saved</div>');
          redirect('Asprak/Presence');
        }
      }
    } else {
      redirect('Asprak/Presence');
    }
  }

  public function EditPresence()
  {
    $id = uri('3');
    $nim_asprak = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->nimAsprak;
    $cek_data = $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"')->where('nim_asprak', $nim_asprak)->get('presensi_asprak')->row();
    if ($cek_data) {
      set_rules('jadwal_asprak', 'Schedule', 'required|trim');
      set_rules('tgl_asprak', 'Date', 'required|trim');
      set_rules('jam_masuk', 'Start', 'required|trim');
      set_rules('jam_selesai', 'End', 'required|trim');
      set_rules('modul_praktikum', 'Practicum Modul', 'required|trim');
      if (validation_run() == false) {
        $data           = $this->data;
        $data['title']  = 'Edit Presence | SIM Laboratorium';
        $data['jadwal'] = $this->a->jadwalPresensiAsprak(userdata('nim'))->result();
        $data['data']   = $this->a->dataPresensiAsprak($nim_asprak, $id)->row();
        view('asprak/header', $data);
        view('asprak/edit_presence', $data);
        view('asprak/footer');
      } else {
        $honor_asprak     = $this->db->get('tarif')->row()->tarif_honor;
        $jadwal_asprak    = input('jadwal_asprak');
        $tgl_asprak       = input('tgl_asprak');
        $jam_masuk        = input('jam_masuk');
        $jam_selesai      = input('jam_selesai');
        $modul_praktikum  = input('modul_praktikum');
        // $link_youtube     = input('link_youtube');
        $tmp              = explode('/', $tgl_asprak);
        $urut_tanggal     = array($tmp[2], $tmp[0], $tmp[1]);
        $tanggal          = implode('-', $urut_tanggal);
        $tmp              = explode(':', $jam_masuk);
        $jam_masuk_       = ($tmp[0] * 3600) + ($tmp[1] * 60);
        $tmp              = explode(':', $jam_selesai);
        $jam_selesai_     = ($tmp[0] * 3600) + ($tmp[1] * 60);
        $selisih          = $jam_selesai_ - $jam_masuk_;
        $hitung_durasi    = $selisih / 3600;
        $hitung_durasi    = explode('.', $hitung_durasi);
        $selisih_jam      = $hitung_durasi[0];
        $selisih_menit    = ($selisih % 3600) / 60;
        $honor            = $honor_asprak * $selisih_jam;
        $durasi           = $selisih_jam;
        if ($selisih_menit >= 20 && $selisih_menit <= 30) {
          $honor          = $honor + ($honor_asprak / 2);
          $durasi         = $selisih_jam + 0.5;
        } elseif ($selisih_menit >= 40 && $selisih_menit <= 59) {
          $honor          = $honor + $honor_asprak;
          $durasi         = $selisih_jam + 1;
        } elseif ($selisih_menit >= 1 && $selisih_menit < 20) {
          $honor          = $honor;
          $durasi         = $selisih_jam;
        } elseif ($selisih_menit > 30 && $selisih_menit < 40) {
          $honor          = $honor + ($honor_asprak / 2);
          $durasi         = $selisih_jam + 0.5;
        }
        $nama_hari        = date('l', strtotime($tanggal));
        $id_jadwal_lab    = $this->db->get_where('jadwal_asprak', array('id_jadwal_asprak' => $jadwal_asprak))->row()->id_jadwal_lab;
        $cek_jadwal_hari  = $this->db->select('hari_ke')->from('jadwal_lab')->where('id_jadwal_lab', $id_jadwal_lab)->get()->row()->hari_ke;
        $cek_jam_masuk    = $this->db->select('date_format(jam_masuk, "%H:%i") masuk')->from('jadwal_lab')->where('id_jadwal_lab', $id_jadwal_lab)->get()->row()->masuk;
        $cek_jam_selesai  = $this->db->select('date_format(jam_selesai, "%H:%i") selesai')->from('jadwal_lab')->where('id_jadwal_lab', $id_jadwal_lab)->get()->row()->selesai;
        if ($nama_hari != hariInggris($cek_jadwal_hari) || $jam_masuk < $cek_jam_masuk || $jam_selesai > $cek_jam_selesai) {
          echo 'Your presence is not according to the day of practicum or start time before the schedule or end time exceeded the schedule';
          set_flashdata('msg', '<div class="alert alert-danger">Your presence is not according to the day of practicum or start time before the schedule or end time exceeded the schedule</div>');
          redirect('Asprak/EditPresence/' . $id);
        }
        $input                = array(
          'asprak_masuk'      => $tanggal . ' ' . $jam_masuk,
          'asprak_selesai'    => $tanggal . ' ' . $jam_selesai,
          'durasi'            => $durasi,
          'honor'             => $honor,
          'modul'             => $modul_praktikum,
          // 'video'             => $link_youtube,
          'approve_absen'     => '1',
          'id_jadwal_asprak'  => $jadwal_asprak,
          'nim_asprak'        => userdata('nim'),
          'id_jadwal_lab'     => $id_jadwal_lab
        );
        $screenshot               = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['screenshot_praktikum']['name']);
        $config['upload_path']    = 'assets/screenshot/';
        $config['allowed_types']  = 'jpeg|jpg|png|gif|tiff';
        $config['max_size']       = 1024 * 100;
        $config['file_name']      = $screenshot;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('screenshot_praktikum')) {
          $input['screenshot']     = $config['upload_path'] . '' . $screenshot;
        }
        if (!empty($_FILES['video_praktikum'])) {
          $link_video     = $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"')->get('presensi_asprak')->row();
          unlink($link_video->video);
          $target_folder  = 'assets/video/';
          $nama_file      = rand(10, 99) . '-' . str_replace(' ', '_', $_FILES['video_praktikum']['name']);
          $upload_file    = $target_folder . $nama_file;
          $input['video'] = $upload_file;
          move_uploaded_file($_FILES['video_praktikum']['tmp_name'], $upload_file);
        }
        print_r($input);
        $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"')->update('presensi_asprak', $input);
        set_flashdata('msg', '<div class="alert alert-success msg">Your presence successfully updated</div>');
        redirect('Asprak/Presence');
      }
    } else {
      redirect('Asprak/Presence');
    }
  }

  public function BAP()
  {
    set_rules('matapraktikum', 'Courses', 'required|trim');
    set_rules('bulan', 'Month', 'required|trim');
    if (validation_run() == false) {
      $data           = $this->data;
      $data['title']  = 'BAP | SIM Laboratorium';
      $data['mk']     = $this->a->daftarMKAsprak(userdata('nim'))->result();
      view('asprak/header', $data);
      view('asprak/bap', $data);
      view('asprak/footer');
    } else {
      $bulan_indo     = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
      $matapraktikum  = input('matapraktikum');
      $bulan          = input('bulan');
      $periode        = $this->a->daftarPeriode()->result();
      $tmp            = explode('|', $bulan);
      $rentang_periode  = $tmp[0];
      $nim_asprak         = $this->db->where('idUser', userdata('id'))->get('users')->row();
      $cek_data_matkul    = $this->db->select('daftar_mk.id_daftar_mk, matakuliah.id_mk, matakuliah.kode_mk, matakuliah.nama_mk, prodi.strata, prodi.kode_prodi, prodi.nama_prodi')->from('daftar_mk')->join('prodi', 'daftar_mk.kode_prodi = prodi.kode_prodi')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('daftar_mk.id_daftar_mk', $matapraktikum)->get()->row();
      $data['nama_bulan'] = $bulan_indo[$tmp[1]];
      foreach ($periode as $p) {
        if ($p->bulan == $tmp[2]) {
          $id_mk          = $cek_data_matkul->id_mk;
          $kode_mk        = $cek_data_matkul->kode_mk;
          $cek_data_user  = $this->db->select('asprak.nim_asprak, asprak.nama_asprak')->from('users')->join('asprak', 'users.nimAsprak = asprak.nim_asprak')->where('users.idUser', userdata('id'))->get()->row();
          $nim_asprak     = $cek_data_user->nim_asprak;
          $durasi         = $this->db->select('sum(presensi_asprak.durasi) durasi, count(presensi_asprak.asprak_masuk) hari')->from('presensi_asprak')->join('jadwal_asprak', 'presensi_asprak.id_jadwal_asprak = jadwal_asprak.id_jadwal_asprak')->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $rentang_periode)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk')->get()->row();
          $ambil_bap      = $this->db->select('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") jam_masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") jam_selesai, presensi_asprak.durasi, presensi_asprak.modul, presensi_asprak.screenshot')->from('presensi_asprak')->join('jadwal_asprak', 'presensi_asprak.id_jadwal_asprak = jadwal_asprak.id_jadwal_asprak')->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $rentang_periode)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk', 'asc')->get()->result();
          $ttd                      = $this->db->get_where('asprak', array('nim_asprak' => $nim_asprak))->row()->ttd_asprak;
          $koordinator_mk           = $this->db->select('dosen.nama_dosen, dosen.ttd_dosen, daftar_mk.koordinator_mk')->from('daftar_mk')->join('dosen', 'daftar_mk.koordinator_mk = dosen.id_dosen')->where('daftar_mk.kode_mk', $kode_mk)->get()->row();
          $data['user']             = $cek_data_user;
          $data['bulan']            = $bulan_indo[$tmp[1]];
          $data['mk_prodi']         = $cek_data_matkul;
          $data['durasi']           = $durasi;
          $data['bap']              = $ambil_bap;
          $data['ttd_asprak']       = $ttd;
          $data['tanggal_sekarang'] = tanggal_indonesia(date('Y-m-d'));
          $data['koordinator']      = $koordinator_mk;
          // view('asprak/print_bap', $data);
          $honor_asprak = $this->db->where('status', '1')->get('tarif')->row();
          $where  = array(
            'id_daftar_mk'    => $cek_data_matkul->id_daftar_mk,
            'id_periode'      => $p->id_periode,
            'nim_asprak'      => $nim_asprak,
            'id_dosen'        => $koordinator_mk->koordinator_mk,
          );
          $cek_submit = $this->db->get_where('honor', $where)->row();
          if ($cek_submit == true) {
            set_flashdata('msg', '<div class="alert alert-danger msg">Your BAP already submited</div>');
            redirect('Asprak/BAP');
          } else {
            $input  = array(
              'hari'            => $durasi->hari,
              'jam'             => $durasi->durasi,
              'nominal'         => $durasi->durasi * $honor_asprak->tarif_honor,
              'tanggal_submit'  => date('Y-m-d'),
              'status'          => 0,
              'id_daftar_mk'    => $cek_data_matkul->id_daftar_mk,
              'id_periode'      => $p->id_periode,
              'nim_asprak'      => $nim_asprak,
              'id_dosen'        => $koordinator_mk->koordinator_mk,
              'approve_dosen'   => 0
            );
            $this->db->insert('honor', $input);
            set_flashdata('msg', '<div class="alert alert-success msg">Your BAP successfully submited</div>');
            redirect('Asprak/BAP');
          }
        }
      }
    }
  }

  public function ajaxBAP()
  {
    $data                       = $this->data;
    $nim_asprak                 = userdata('nim');
    $bulan_indo                 = $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $id_daftar_mk               = input('idMK');
    $ambil                      = input('bulan');
    $tmp                        = explode("|", $ambil);
    if ($ambil == true) {
      if ($tmp[1] == '5') {
        $bulan                  = '"2020-01-01" and "2020-07-01"';
        $namaBulan              = $bulan_indo[$tmp[1]];
      }
    }
    // $bulan                      = $tmp[0];
    // $namaBulan                  = $bulan_indo[$tmp[1]];
    $ambil_mk                   = $this->db->select('matakuliah.id_mk, matakuliah.kode_mk, matakuliah.nama_mk, prodi.strata, prodi.kode_prodi, prodi.nama_prodi')->from('daftar_mk')->join('prodi', 'daftar_mk.kode_prodi = prodi.kode_prodi')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('daftar_mk.id_daftar_mk', $id_daftar_mk)->get()->row();
    $id_mk                      = $ambil_mk->id_mk;
    $durasi                     = $this->db->select('sum(presensi_asprak.durasi) durasi')->from('presensi_asprak')->join('jadwal_asprak', 'presensi_asprak.id_jadwal_asprak = jadwal_asprak.id_jadwal_asprak')->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $bulan)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk')->get()->row();
    $kode_mk                    = $ambil_mk->kode_mk;
    $koordinator_mk             = $this->db->select('dosen.nama_dosen, dosen.ttd_dosen')->from('daftar_mk')->join('dosen', 'daftar_mk.koordinator_mk = dosen.id_dosen')->where('daftar_mk.kode_mk', $kode_mk)->get()->row();
    $output                     = '<table width="100%">
                                    <tr>
                                      <td style="font-family: Arial; font-size: 14px;" width="40%" valign="top" colspan="2"><b>BERITA ACARA PEKERJAAN DAN KEHADIRAN<br>ASISTEN PRAKTIKUM</b></td>
                                      <td width="30%" rowspan="8" valign="top">
                                        <div align="right">
                                          <img src="' . base_url() . 'assets/img/logo_tass.png" height="70px" width="250px">
                                          <p style="font-family: Arial; font-size: 12px;"><b>Unit Laboratorium/Bengkel/Studio<br>Fakultas Ilmu Terapan</b></p>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td width="10%"><b><br>NAMA</b></td>
                                      <td><br><b>: ' . $data['profil']->nama_asprak . '</b></td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>NIM</b></td>
                                      <td><b>: ' . userdata('nim') . '</b></td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>BULAN</b></td>
                                      <td><b>: ' . $namaBulan . '</b></td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>PRODI</b></td>
                                      <td><b>: ' . $ambil_mk->strata . ' ' . $ambil_mk->nama_prodi . '</b></td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>MK / KODE MK</b></td>
                                      <td><b>: ' . $ambil_mk->nama_mk . ' / ' . $ambil_mk->kode_mk . '</b></td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>TAHUN</b></td>
                                      <td><b>: ' . date("Y") . '</b></td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>TOTAL JAM</b></td>
                                      <td><b>: ' . $durasi->durasi . '</b></td>
                                    </tr>
                                  </table>
                                  <br>
                                  <table border="1" width="100%" style="border-collapse: collapse; border: 1px solid black;">
                                    <tr style="text-align: center; background: #333333; font-weight: bold; color: white;">
                                      <td width="15%">Tanggal</td>
                                      <td width="10%">Jam Masuk</td>
                                      <td width="10%">Jam Keluar</td>
                                      <td width="10%">Jumlah Jam</td>
                                      <td colspan="2">Modul Praktikum</td>
                                      <td width="10%">Paraf Asprak</td>
                                    </tr>';
    if ($bulan != '') {
      $ambil_bap  = $this->db->select('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") jam_masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") jam_selesai, presensi_asprak.durasi, presensi_asprak.modul, presensi_asprak.screenshot')->from('presensi_asprak')->join('jadwal_asprak', 'presensi_asprak.id_jadwal_asprak = jadwal_asprak.id_jadwal_asprak')->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $bulan)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk', 'asc')->get()->result();
    }
    $ttd          = $this->db->get_where('asprak', array('nim_asprak' => $nim_asprak))->row()->ttd_asprak;
    foreach ($ambil_bap as $a) {
      $tanggal_indonesia  = tanggal_indonesia($a->tanggal);
      $gambar_praktikum   = '<img src="' . base_url($a->screenshot) . '" style="max-height: 100px">';
      $ttd_asprak         = '<img src="' . base_url($ttd) . '" style="max-height: 50px">';
      $output             .= '<tr>
                                <td style="text-align: center">' . $tanggal_indonesia . '</td>
                                <td style="text-align: center">' . $a->jam_masuk . '</td>
                                <td style="text-align: center">' . $a->jam_selesai . '</td>
                                <td style="text-align: center">' . $a->durasi . '</td>
                                <td>' . $a->modul . '</td>
                                <td width="23%" style="text-align: center">' . $gambar_praktikum . '</td>
                                <td style="text-align: center">' . $ttd_asprak . '</td>
                              </tr>';
    }
    $output                     .= '</table>';
    echo $output;
  }

  public function PracticumReport()
  {
    set_rules('daftar_mk', 'Courses', 'required|trim');
    if (validation_run() == false) {
      $data           = $this->data;
      $data['title']  = 'Practicum Report | SIM Laboratorium';
      $data['data']   = $this->a->daftarLaporan(userdata('nim'))->result();
      view('asprak/header', $data);
      view('asprak/practicum_report', $data);
      view('asprak/footer');
    } else {
      $id_daftar_mk = input('daftar_mk');
      $data = $this->db->select('tahun_ajaran.ta, daftar_mk.kode_mk, matakuliah.nama_mk')->from('daftar_mk')->join('tahun_ajaran', 'daftar_mk.id_ta = tahun_ajaran.id_ta')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('daftar_mk.id_daftar_mk', $id_daftar_mk)->get()->row();
      print_r($data);
      $nama_file  = $data->ta . '_' . $data->kode_mk . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $data->nama_mk) . '.pdf';
      $input  = array(
        'tanggal_upload'  => date('Y-m-d H:i:s'),
        'status_laporan'  => '0',
        'id_daftar_mk'    => $id_daftar_mk,
        'nim_asprak'      => userdata('nim')
      );
      $config['upload_path']    = 'assets/laporan/asprak/';
      $config['allowed_types']  = 'pdf';
      $config['max_size']       = 1024 * 100;
      $config['overwrite']      = true;
      $config['file_name']      = $nama_file;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('file_laporan')) {
        $input['nama_file'] = $config['upload_path'] . '' . $nama_file;
      } else {
        print_r($this->upload->display_errors());
      }
      $this->db->insert('laporan_praktikum', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Your practicum report successfully submited</div>');
      redirect('Asprak/PracticumReport');
    }
  }

  public function RevisionReport()
  {
    set_rules('id_laporan', 'ID Laporan', 'required|trim');
    if (validation_run() == false) {
      redirect('Asprak/PracticumReport');
    } else {
      $id_laporan   = input('id_laporan');
      $id_daftar_mk = input('id_daftar_mk');
      $cek_data     = $this->db->where('id_laporan_praktikum', $id_laporan)->where('id_daftar_mk', $id_daftar_mk)->get('laporan_praktikum')->row();
      unlink($cek_data->nama_file);
      $data = $this->db->select('tahun_ajaran.ta, daftar_mk.kode_mk, matakuliah.nama_mk')->from('daftar_mk')->join('tahun_ajaran', 'daftar_mk.id_ta = tahun_ajaran.id_ta')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('daftar_mk.id_daftar_mk', $id_daftar_mk)->get()->row();
      print_r($data);
      echo '<br>';
      $nama_file  = $data->ta . '_' . $data->kode_mk . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $data->nama_mk) . '.pdf';
      $input  = array(
        'tanggal_upload'  => date('Y-m-d H:i:s'),
        'status_laporan'  => '0',
        'id_daftar_mk'    => $id_daftar_mk,
        'nim_asprak'      => userdata('nim')
      );
      $config['upload_path']    = 'assets/laporan/asprak/';
      $config['allowed_types']  = 'pdf';
      $config['max_size']       = 1024 * 100;
      $config['overwrite']      = true;
      $config['file_name']      = $nama_file;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload('file_laporan')) {
        $input['nama_file'] = $config['upload_path'] . '' . $nama_file;
      } else {
        print_r($this->upload->display_errors());
      }
      $this->db->where('id_laporan_praktikum', $id_laporan)->update('laporan_praktikum', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Your practicum report successfully updated</div>');
      redirect('Asprak/PracticumReport');
    }
  }

  public function Salary()
  {
    $data           = $this->data;
    $data['title']  = 'Salary | SIM Laboratorium';
    $data['data']   = $this->a->daftarHonorAsprak(userdata('nim'))->result();
    $data['honor']  = $this->a->daftarHonorAsprakDiambil(userdata('nim'))->result();
    view('asprak/header', $data);
    view('asprak/salary', $data);
    view('asprak/footer');
  }

  public function TakeSalary()
  {
    set_rules('pilihan', 'Option', 'required|trim');
    if (validation_run() == false) {
      redirect('Asprak/Salary');
    } else {
      $id_honor = input('id_honor');
      $pilihan  = input('pilihan');
      $tmp      = explode('|', $id_honor);
      for ($i = 1; $i < count($tmp); $i++) {
        $input  = array('opsi_pengambilan' => $pilihan, 'status' => '1');
        $this->db->where('id_honor', $tmp[$i])->update('honor', $input);
      }
      set_flashdata('msg', '<div class="alert alert-success msg">Your BAP successfully submited</div>');
      redirect('Asprak/Salary');
    }
  }

  public function Certificate()
  {
    $data           = $this->data;
    $data['title']  = 'Certificate | SIM Laboratorium';
    view('asprak/header', $data);
    view('asprak/certificate', $data);
    view('asprak/footer');
  }

  public function DownloadCertificate()
  {
    set_rules('nim_asprak', 'NIM Asprak', 'required|trim');
    set_rules('id_daftar_mk', 'ID Daftar MK', 'required|trim');
    if (validation_run() == true) {
      $nim_asprak = input('nim_asprak');
      $id_daftar_mk = input('id_daftar_mk');
      $no_sertifikat = $this->db->where('nim_asprak', $nim_asprak)->where('id_daftar_mk', $id_daftar_mk)->get('sertifikat')->row();
      $daftar_mk = $this->db->where('id_daftar_mk', $id_daftar_mk)->get('daftar_mk')->row();
      $nama_mk  = $this->db->where('kode_mk', $daftar_mk->kode_mk)->get('matakuliah')->row();
      $tahun_ajaran = $this->db->where('id_ta', $daftar_mk->id_ta)->get('tahun_ajaran')->row();
      $nama_asprak = $this->db->where('nim_asprak', $nim_asprak)->get('asprak')->row();
      $status_keanggotaan = $this->db->where('nim_asprak', $nim_asprak)->where('id_daftar_mk', $id_daftar_mk)->get('daftarasprak')->row();
      $data['no_sertifikat']  = $no_sertifikat;
      $data['nama_asprak']    = $nama_asprak->nama_asprak;
      $data['ta']             = $tahun_ajaran->ta;
      $data['nama_mk']        = $nama_mk->nama_mk;
      $data['keanggotaan']    = $status_keanggotaan->posisi;
      view('asprak/download_sertifikat', $data);
    } else {
      redirect('Asprak/Certificate');
    }
  }

  public function Setting()
  {
    $data           = $this->data;
    $data['title']  = 'Setting | SIM Laboratorium';
    $data['akun']   = $this->a->akunAsprak(userdata('nim'))->row();
    $data['bank']   = $this->a->daftarBank()->result();
    view('asprak/header', $data);
    view('asprak/setting', $data);
    view('asprak/footer');
  }

  public function cobaSubmitAjax()
  {
    $nim_asprak     = input('nim_asprak');
    $nama_asprak    = input('nama_asprak');
    $kontak_asprak  = input('kontak_asprak');
    $norek_asprak   = input('norek_asprak');
    $nama_rekening  = input('nama_rekening');
    $linkaja_asprak = input('linkaja_asprak');
    $nama_linkaja   = input('nama_linkaja');
    $input          = array(
      'nama_asprak'     => $nama_asprak,
      'kontak_asprak'   => $kontak_asprak,
      'norek_asprak'    => $norek_asprak,
      'nama_rekening'   => $nama_rekening,
      'linkaja_asprak'  => $linkaja_asprak,
      'nama_linkaja'    => $nama_linkaja
    );
    $this->a->updateData('asprak', $input, 'nim_asprak', $nim_asprak);
    $username_asprak  = input('username_asprak');
    $password_lama    = input('password_lama');
    $password_baru    = input('password_baru');
    $konfirm_password = input('konfirm_password');
    if ($password_lama == null) {
      echo 'true';
    } else {
      $cek_password = $this->a->cekPassword($username_asprak)->row()->password;
      if ($cek_password == sha1($password_lama)) {
        if ($password_baru == $konfirm_password) {
          $input  = array('password' => sha1($password_baru));
          $this->a->updateData('users', $input, 'username', $username_asprak);
          echo 'true';
        } else {
          echo 'false1';
        }
      } else {
        echo 'false2';
      }
    }
  }

  public function SaveSignature()
  {
    $result = array();
    $image_data = base64_decode($_POST['img_data']);
    $convert    = substr(sha1(date('Y-m-d H:i:s')), 5, 9);
    $file_name  = $_POST['nim_asprak'] . '_' . $convert;
    $cek_ttd    = substr(sha1($_POST['img_data']), 5, 20);
    if ($cek_ttd != '746d1ff79db1b124917d') {
      $cek_data   = $this->db->get_where('asprak', array('nim_asprak' => $_POST['nim_asprak']))->row();
      if ($cek_data->ttd_asprak) {
        unlink($cek_data->ttd_asprak);
      }
      $save_file  = 'assets/signature/asprak/' . $file_name . '.png';
      $input      = array('ttd_asprak' => $save_file);
      $this->db->where('nim_asprak', $_POST['nim_asprak'])->update('asprak', $input);
      file_put_contents($save_file, $image_data);
      $result['status'] = 1;
      $result['file_name'] = $save_file;
      echo json_encode($result);
    }
  }

  public function DeleteSignature()
  {
    $result = array();
    $nim_asprak = $_POST['nim_asprak'];
    $cek_data   = $this->db->get_where('asprak', array('nim_asprak' => $nim_asprak))->row();
    if ($cek_data->ttd_asprak) {
      unlink($cek_data->ttd_asprak);
    }
    $input      = array('ttd_asprak' => null);
    $this->db->where('nim_asprak', $_POST['nim_asprak'])->update('asprak', $input);
    $result['status'] = 1;
    echo json_encode($result);
  }

  public function HistoryLogin()
  {
    $data           = $this->data;
    $data['title']  = 'History Login | SIM Laboratorium';
    $username = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->username;
    $data['data']   = $this->db->order_by('tanggal_login', 'desc')->get_where('history_login', array('username' => $username))->result();
    view('asprak/header', $data);
    view('asprak/history_login', $data);
    view('asprak/footer');
  }
}
