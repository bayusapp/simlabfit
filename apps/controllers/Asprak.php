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
      // 'absen'   => $this->db->select('count(id_presensi_asprak) jumlah')->from('presensi_asprak')->where('nim_asprak', userdata('nim'))->where('approve_absen', '0')->get()->row()->jumlah
      'absen'   => $this->db->select('count(id_presensi_asprak) jumlah')->from('presensi_asprak')->where('nim_asprak', userdata('nim'))->where('modul is null')->get()->row()->jumlah
    );
  }

  public function Dashboard()
  {
    $data             = $this->data;
    $data['title']      = 'Dashboard | SIM Laboratorium';
    $data['pengumuman'] = $this->a->daftarPengumuman()->result();
    //variable untuk presensi
    $nim                = userdata('nim');
    $hari_sekarang      = date('l');
    $tanggal_sekarang   = date('Y-m-d');
    $jam_sekarang       = date('H:i');

    if (date('m') == 12 && date('d') <= 5) {
      $p1 = date('Y') . '-' . date('m', strtotime('-1 months')) . '-06';
      $p2 = date('Y-m') . '-05';
    } elseif (date('m') == 12 && date('d') >= 6) {
      $p1 = date('Y-m') . '-06';
      $p2 = date('Y', strtotime('+1 years')) . '-01-05';
    } elseif (date('m') == 1 && date('d') <= 5) {
      $p1 = date('Y', strtotime('-1 years')) . '-12-06';
      $p2 = date('Y-m') . '-05';
    } elseif (date('m') == 1 && date('d') >= 6) {
      $p1 = date('Y-m') . '-06';
      $p2 = date('Y') . '-' . date('m', strtotime('+1 months')) . '-05';
    } else {
      $p1 = date('Y') . '-' . date('m', strtotime('-1 months')) . '-06';
      $p2 = date('Y-m') . '-05';
    }
    $data['rekap_honor']  = $this->a->hitungGajiPeriode(userdata('nim'), $p1, $p2)->row();
    $cek_jadwal         = $this->a->cekJadwalAsprakDashboard($nim, $hari_sekarang, $jam_sekarang)->row();
    if ($cek_jadwal == true) { //kondisi jika ada jadwal
      $data['jadwal_asprak']  = 'true'; //kirim value untuk button absen
      $data['cek_jadwal']     = $cek_jadwal;
      $data['cek_tap']        = $this->a->cekTapAsprak($cek_jadwal->id_jadwal_asprak, $tanggal_sekarang)->row();
      if ($data['cek_tap']) {
        $tap_keluar         = $this->a->cekTapAsprak($cek_jadwal->id_jadwal_asprak, $tanggal_sekarang)->row()->keluar;
        if ($tap_keluar == 'null') {
          $data['tap_keluar'] = 'belumKeluar';
        } else {
          $data['tap_keluar'] = 'sudahKeluar';
        }
        $data['tap_masuk']  = 'sudahMasuk';
      } else {
        $data['tap_masuk']  = 'belumMasuk';
      }
    } else { //kondisi jika tidak ada jadwal
      $data['jadwal_asprak']  = 'false'; //kirim value untuk button absen
    }
    view('asprak/header', $data);
    view('asprak/dashboard', $data);
    view('asprak/footer');
  }

  public function SubmitTapMasuk($id, $lab)
  {
    $org = check_org_ip();
    if ($org == 'TELKOM UNIVERSITY') {
      $nim            = userdata('nim');
      $sekarang       = date('Y-m-d H:i:s');
      $ambil_tanggal  = date('Y-m-d');
      $hari_sekarang  = date('l');
      $jam_sekarang   = date('H:i');
      $cek_jadwal     = $this->a->cekJadwalAsprakDashboard($nim, $hari_sekarang, $jam_sekarang)->row();
      if ($cek_jadwal) {
        $cek_absen_masuk  = $this->db->query('select * from presensi_asprak where date_format(asprak_masuk, "%Y-%m-%d") = "' . $ambil_tanggal . '" and nim_asprak = "' . $nim . '" and id_jadwal_asprak = "' . $id . '"')->row();
        if ($cek_absen_masuk) {
          redirect('Asprak/Dashboard');
        } else {
          $input      = array(
            'id_jadwal_asprak'  => $id,
            'asprak_masuk'      => $sekarang,
            'nim_asprak'        => $nim,
            'id_jadwal_lab'     => $lab
          );
          $this->db->insert('presensi_asprak', $input);
          set_flashdata('msg', '<div class="alert alert-success msg">Your presence successfully recorded</div>');
          redirect('Asprak/Dashboard');
        }
      }
    } else {
      set_flashdata('msg', '<div class="alert alert-danger msg">If you try to redirect to presence and not connected to TUNE Network, sorry your presence is not recorded</div>');
      redirect('Asprak/Dashboard');
    }
  }

  public function SubmitTapKeluar($id, $lab)
  {
    $org = check_org_ip();
    if ($org == 'TELKOM UNIVERSITY') {
      $nim = userdata('nim');
      $sekarang = date('Y-m-d H:i:s');
      $ambil_tanggal = date('Y-m-d');
      $hari_sekarang = date('l');
      $jam_sekarang = date('H:i');

      $cek_jadwal = $this->a->cekJadwalAsprakDashboard($nim, $hari_sekarang, $jam_sekarang)->row();
      if ($cek_jadwal) {
        $cek_absen_keluar  = $this->db->query('select * from presensi_asprak where date_format(asprak_masuk, "%Y-%m-%d") = "' . $ambil_tanggal . '" and nim_asprak = "' . $nim . '" and id_jadwal_asprak = "' . $id . '" and asprak_masuk is not null')->row();
        if ($cek_absen_keluar->asprak_selesai) {
          redirect('Asprak/Dashboard');
        } else {
          $honor_per_jam = $this->db->select('honorAsprak')->from('optionsim')->get()->row()->honorAsprak;
          $id_presensi_asprak = $cek_absen_keluar->id_presensi_asprak;
          $ambil_jam_masuk  = $this->db->query('select ((date_format(asprak_masuk, "%H") * 3600) + (date_format(asprak_masuk, "%i") * 60)) jam_masuk from presensi_asprak where id_presensi_asprak = "' . $id_presensi_asprak . '"')->row()->jam_masuk;
          $jam_keluar = (date('H') * 3600) + (date('i') * 60);
          $selisih_waktu  = ($jam_keluar - $ambil_jam_masuk);
          $durasi_asprak = 0;
          $hitung_durasi  = $selisih_waktu / 3600;
          $hitung_durasi  = explode('.', $hitung_durasi);
          $ambil_selisih_jam  = $hitung_durasi[0];
          $ambil_selisih_menit  = ($selisih_waktu % 3600) / 60;
          $honor_diterima = $honor_per_jam * $ambil_selisih_jam;
          if ($ambil_selisih_menit >= 20 && $ambil_selisih_menit <= 30) {
            $honor_diterima = $honor_diterima + ($honor_per_jam / 2);
            $durasi_asprak  = $ambil_selisih_jam + 0.5;
          } elseif ($ambil_selisih_menit >= 40 && $ambil_selisih_menit <= 59) {
            $honor_diterima = $honor_diterima + $honor_per_jam;
            $durasi_asprak  = $ambil_selisih_jam + 1;
          } elseif ($ambil_selisih_menit >= 1 && $ambil_selisih_menit < 20) {
            $honor_diterima = $honor_diterima;
            $durasi_asprak  = $ambil_selisih_jam;
          } elseif ($ambil_selisih_menit > 30 && $ambil_selisih_menit < 40) {
            $honor_diterima = $honor_diterima + ($honor_per_jam / 2);
            $durasi_asprak  = $ambil_selisih_jam + 0.5;
          }
          $input  = array(
            'asprak_selesai'  => $sekarang,
            'honor'           => $honor_diterima,
            'durasi'          => $durasi_asprak
          );
          $this->a->updateData('presensi_asprak', $input, 'id_presensi_asprak', $id_presensi_asprak);
          redirect('Asprak/Dashboard');
        }
      }
    } else {
      set_flashdata('msg', '<div class="alert alert-danger msg">If you try to redirect to presence and not connected to TUNE Network, sorry your presence is not recorded</div>');
      redirect('Asprak/Dashboard');
    }
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
      $tmp['backgroundColor'] = '#1ab394';
      $tmp['borderColor']     = '#1ab394';
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
      $data['jadwal'] = $this->a->jadwalKuliah()->result();
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
    $org = check_org_ip();
    if ($org == 'TELKOM UNIVERSITY') {
      set_rules('jadwal_asprak', 'Schedule', 'required|trim');
      set_rules('tgl_asprak', 'Date', 'required|trim');
      set_rules('jam_masuk', 'Start', 'required|trim');
      set_rules('jam_selesai', 'End', 'required|trim');
      set_rules('modul_praktikum', 'Practicum Modul', 'required|trim');
      if (validation_run() == false) {
        // $data           = $this->data;
        // $data['title']  = 'Add Presence | SIM Laboratorium';
        // // $data['jadwal'] = $this->a->jadwalPresensiAsprak(userdata('nim'))->result();
        // $data['jadwal'] = $this->a->jadwalKuliah()->result();
        // view('asprak/header', $data);
        // view('asprak/add_presence', $data);
        // view('asprak/footer');
        redirect('Asprak/Presence');
      } else {
        $honor_asprak     = $this->db->get('tarif')->row()->tarif_honor;
        $id_jadwal_lab    = input('jadwal_asprak');
        $tgl_asprak       = input('tgl_asprak');
        $jam_masuk        = input('jam_masuk');
        $jam_selesai      = input('jam_selesai');
        $modul_praktikum  = input('modul_praktikum');
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
        // $cek_presensi     = $this->db->where('date_format(asprak_masuk, "%Y-%m-%d") = "' . $tanggal . '"')->where('id_jadwal_asprak', $jadwal_asprak)->where('nim_asprak', userdata('nim'))->get('presensi_asprak')->row();
        // if ($cek_presensi) {
        //   set_flashdata('msg', '<div class="alert alert-danger">You already presence on that day</div>');
        //   redirect('Asprak/Presence');
        // } else {
        $input                = array(
          'asprak_masuk'      => $tanggal . ' ' . $jam_masuk,
          'asprak_selesai'    => $tanggal . ' ' . $jam_selesai,
          'durasi'            => $durasi,
          'honor'             => $honor,
          'modul'             => $modul_praktikum,
          'nim_asprak'        => userdata('nim'),
          'id_jadwal_lab'     => $id_jadwal_lab
        );
        $this->m->insertData('presensi_asprak', $input);
        set_flashdata('msg', '<div class="alert alert-success msg">Your presence successfully saved</div>');
        redirect('Asprak/Presence');
        //}
      }
    } else {
      redirect('Asprak/Dashboard');
    }
  }

  public function EditPresence($id)
  {
    set_rules('modul', 'Modul', 'required|trim');
    if (validation_run() == false) {
      redirect('Asprak/Presence');
    } else {
      $this->db->query('update presensi_asprak set modul = "' . input('modul') . '" where substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"');
      set_flashdata('msg', '<div class="alert alert-success msg">Your presence successfully updated</div>');
      redirect('Asprak/Presence');
    }
  }

  public function AjaxPresence()
  {
    $hasil  = '';
    $id     = input('id');
    $cek    = $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"')->get('presensi_asprak')->row();
    if ($cek == true) {
      $hasil .= $cek->asprak_masuk;
    } else {
      $hasil .= 'kosong';
      redirect('Asprak/Presence');
    }
    echo $hasil;
  }

  public function DeletePresence()
  {
    if (userdata('login') == 'asprak') {
      set_rules('id', 'ID', 'required|trim');
      if (validation_run() == false) {
        redirect('Asprak/Presence');
      } else {
        $id = input('id');
        $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"')->delete('presensi_asprak');
        // redirect('Asprak/Presence');
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
          $ambil_bap      = $this->db->select('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") jam_masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") jam_selesai, presensi_asprak.durasi, presensi_asprak.modul')->from('presensi_asprak')->join('jadwal_asprak', 'presensi_asprak.id_jadwal_asprak = jadwal_asprak.id_jadwal_asprak')->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $rentang_periode)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk', 'asc')->get()->result();
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
    $awal   = input('awal');
    $akhir  = input('akhir');
    if ($awal == null || $akhir == null) {
      $ambil  = "'" . date('Y') . "-12-06' and '" . date('Y', strtotime('+1 years')) . "-01-05'";
      $angka_bulan = 1;
    } else {
      $ambil  = "'" . convert_tanggal($awal) . "' and '" . convert_tanggal($akhir) . "'";
      $tmp    = explode('-', convert_tanggal($akhir));
      $angka_bulan  = $tmp[1];
      if ($angka_bulan < 10) {
        $pisah = explode('0', $angka_bulan);
        $angka_bulan = $pisah[1];
      }
    }
    // // '2022-12-06' and '2023-01-05'|1|Januari
    $bulan                      = $ambil;
    $namaBulan                  = $bulan_indo[$angka_bulan];
    $ambil_mk                   = $this->db->select('matakuliah.id_mk, matakuliah.kode_mk, matakuliah.nama_mk, prodi.strata, prodi.kode_prodi, prodi.nama_prodi')->from('daftar_mk')->join('prodi', 'daftar_mk.kode_prodi = prodi.kode_prodi')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('daftar_mk.id_daftar_mk', $id_daftar_mk)->get()->row();
    $id_mk                      = $ambil_mk->id_mk;
    $durasi                     = $this->db->select('sum(presensi_asprak.durasi) durasi')->from('presensi_asprak')->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $bulan)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk')->get()->row();
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
                                      <td width="7%"><b><br>NAMA</b></td>
                                      <td><br>: ' . $data['profil']->nama_asprak . '</td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>NIM</b></td>
                                      <td>: ' . userdata('nim') . '</td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>BULAN</b></td>
                                      <td>: ' . $namaBulan . '</td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>PRODI</b></td>
                                      <td>: ' . $ambil_mk->strata . ' ' . $ambil_mk->nama_prodi . '</td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>MK / KODE MK</b></td>
                                      <td>: ' . $ambil_mk->nama_mk . ' / ' . $ambil_mk->kode_mk . '</td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>TAHUN</b></td>
                                      <td>: ' . date("Y") . '</td>
                                    </tr>
                                    <tr style="font-family: Arial; font-size: 12px;">
                                      <td><b>TOTAL JAM</b></td>
                                      <td>: ' . $durasi->durasi . '</td>
                                    </tr>
                                  </table>
                                  <br>
                                  <table border="1" width="100%" style="border-collapse: collapse; border: 1px solid black;">
                                    <tr style="text-align: center; background: #333333; font-weight: bold; color: white;">
                                      <td width="15%">Tanggal</td>
                                      <td width="10%">Kelas</td>
                                      <td width="7%">Jam Masuk</td>
                                      <td width="7%">Jam Keluar</td>
                                      <td width="7%">Jumlah Jam</td>
                                      <td>Modul Praktikum</td>
                                      <td width="10%">Paraf Asprak</td>
                                      <td width="10%">Tanda Tangan Dosen</td>
                                    </tr>';
    if ($bulan != '') {
      $ambil_bap  = $this->db->select('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") jam_masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") jam_selesai, presensi_asprak.durasi, presensi_asprak.modul, jadwal_lab.kelas')->from('presensi_asprak')->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $bulan)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk', 'asc')->get()->result();
    }
    $ttd          = $this->db->get_where('asprak', array('nim_asprak' => $nim_asprak))->row()->ttd_asprak;
    foreach ($ambil_bap as $a) {
      $tanggal_indonesia  = tanggal_indonesia($a->tanggal);
      $ttd_asprak         = '<img src="' . base_url($ttd) . '" style="max-height: 40px">';
      $output             .= '<tr>
                                <td style="text-align: center">' . $tanggal_indonesia . '</td>
                                <td style="text-align: center">' . $a->kelas . '</td>
                                <td style="text-align: center">' . $a->jam_masuk . '</td>
                                <td style="text-align: center">' . $a->jam_selesai . '</td>
                                <td style="text-align: center">' . $a->durasi . '</td>
                                <td>' . $a->modul . '</td>
                                <td style="text-align: center">' . $ttd_asprak . '</td>
                                <td></td>
                              </tr>';
    }
    $output                     .= '</table>';
    $output                     .= '<br>';
    $output                     .= '<table width="100%">
    <tbody style="text-align: right">
    <tr>
    <td>Bandung, ' . tanggal_indonesia(date('Y-m-d')) . '</td>
    </tr>
    <tr>
    <td>Koordinator Dosen Mata Kuliah</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td>_________________________________</td>
    </tr>
    </tbody>
    </table>';
    echo $output;
  }

  public function PrintBAP()
  {
    $data                       = $this->data;
    $nim_asprak                 = userdata('nim');
    $bulan_indo                 = $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $id_daftar_mk               = input('matapraktikum');
    $ambil                      = input('bulan');
    $tmp                        = explode("|", $ambil);
    $bulan                      = $tmp[0];
    $data['nama_bulan']         = $bulan_indo[$tmp[1]];
    $ambil_mk                   = $this->db->select('matakuliah.id_mk, matakuliah.kode_mk, matakuliah.nama_mk, prodi.strata, prodi.kode_prodi, prodi.nama_prodi')->from('daftar_mk')->join('prodi', 'daftar_mk.kode_prodi = prodi.kode_prodi')->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk')->where('daftar_mk.id_daftar_mk', $id_daftar_mk)->get()->row();
    $data['ambil_mk']           = $ambil_mk;
    $id_mk                      = $ambil_mk->id_mk;
    $data['durasi']             = $this->db->select('sum(presensi_asprak.durasi) durasi')->from('presensi_asprak')->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $bulan)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk')->get()->row();
    if ($bulan != '') {
      $data['ambil_bap']  = $this->db->select('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") jam_masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") jam_selesai, presensi_asprak.durasi, presensi_asprak.modul, jadwal_lab.kelas')->from('presensi_asprak')->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab')->where('jadwal_lab.id_mk', $id_mk)->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $bulan)->where('presensi_asprak.nim_asprak', $nim_asprak)->order_by('presensi_asprak.asprak_masuk', 'asc')->get()->result();
    }
    $data['ttd']          = $this->db->get_where('asprak', array('nim_asprak' => $nim_asprak))->row()->ttd_asprak;
    view('asprak/bap_print', $data);
  }

  public function BAPP()
  {
    $data           = $this->data;
    $data['title']  = 'BAPP | SIM Laboratorium';
    $data['bapp']   = $this->a->daftarBAPP(userdata('nim'))->result();
    view('asprak/header', $data);
    view('asprak/bapp', $data);
    view('asprak/footer');
  }

  public function AddBAPP()
  {
    set_rules('modul', 'Modul', 'required|trim');
    // set_rules('prodi', 'Prodi', 'required|trim');
    // set_rules('mk', 'MK', 'required|trim');
    // set_rules('lab', 'Lab', 'required|trim');
    // set_rules('kelas', 'Kelas', 'required|trim');
    // set_rules('dosen', 'Dosen', 'required|trim');
    // set_rules('tanggal', 'Tanggal', 'required|trim');
    // set_rules('jumlah_mhs', 'Jumlah Mahasiswa', 'required|trim');
    // set_rules('absen_mhs', 'Jumlah Mahasiswa Absen', 'required|trim');
    // set_rules('nim_absen', 'NIM Mahasiswa Absen', 'required|trim');
    // set_rules('dosen_hadir', 'Kehadiran Dosen', 'required|trim');
    // set_rules('jam_datang', 'Jam Datang', 'required|trim');
    // set_rules('jam_pulang', 'Jam Pulang', 'required|trim');
    // set_rules('nim_km', 'NIM KM', 'required|trim');
    // set_rules('nama_km', 'Nama KM', 'required|trim');
    if (validation_run() == false) {
      $data           = $this->data;
      $data['title']  = 'Add BAPP | SIM Laboratorium';
      $data['prodi']  = $this->a->daftarProdi()->result();
      $data['dosen']  = $this->a->daftarDosen()->result();
      $data['mk']     = $this->a->daftarMK()->result();
      $data['lab']    = $this->a->daftarLaboratorium()->result();
      $data['asprak'] = $this->a->daftarSeluruhAsprak()->result();
      view('asprak/header', $data);
      view('asprak/add_bapp', $data);
      view('asprak/footer');
    } else {
      $modul              = input('modul');
      $prodi              = input('prodi');
      $mk                 = input('mk');
      $lab                = input('lab');
      $kelas              = input('kelas');
      $dosen              = input('dosen');
      $tanggal            = input('tanggal');
      $pisah_tanggal      = explode('/', $tanggal);
      $urut_tanggal       = array($pisah_tanggal[2], $pisah_tanggal[0], $pisah_tanggal[1]);
      $tanggal            = implode('-', $urut_tanggal);
      $jumlah_mhs         = input('jumlah_mhs');
      $absen_mhs          = input('absen_mhs');
      $nim_absen          = input('nim_absen');
      $dosen_hadir        = input('dosen_hadir');
      $jam_datang         = input('jam_datang');
      $jam_pulang         = input('jam_pulang');
      $nim_km             = input('nim_km');
      $nama_km            = input('nama_km');
      $ttd_km             = input('tmp_sign');
      $catatan_praktikum  = nl2br(htmlspecialchars_decode(input('catatan_praktikum'), ENT_HTML5));
      $keluhan            = input('keluhan');
      $komplain           = nl2br(htmlspecialchars_decode(input('komplain'), ENT_HTML5));
      $image_data         = base64_decode($ttd_km);
      $convert            = substr(sha1(date('Y-m-d H:i:s')), 5, 9);
      $file_name          = $nim_km . '_' . $convert;
      $save_file          = 'assets/signature/km/' . $file_name . '.png';
      if ($image_data) {
        file_put_contents($save_file, $image_data);
      } else {
        $save_file = null;
      }
      if ($dosen_hadir == 0) {
        $jam_datang = null;
        $jam_pulang = null;
      }
      $input              = array(
        'tanggal_bapp'      => $tanggal,
        'modul'             => $modul,
        'id_prodi'          => $prodi,
        'id_mk'             => $mk,
        'kelas'             => $kelas,
        'id_dosen'          => $dosen,
        'id_lab'            => $lab,
        'jumlah_mahasiswa'  => $jumlah_mhs,
        'daftar_absen_mhs'  => $nim_absen,
        'mahasiswa_absen'   => $absen_mhs,
        'kehadiran_dosen'   => $dosen_hadir,
        'dosen_datang'      => $jam_datang,
        'dosen_pulang'      => $jam_pulang,
        'nim_km'            => $nim_km,
        'nama_km'           => $nama_km,
        'ttd_km'            => $save_file,
        'catatan_praktikum' => $catatan_praktikum
      );
      $this->db->insert('bapp', $input);
      $ambil_id_bapp = $this->db->get_where('bapp', $input)->row();
      foreach (input('asprak') as $a) {
        $input = array(
          'nim_asprak'  => $a,
          'id_bapp'     => $ambil_id_bapp->id_bapp
        );
        $this->db->insert('bapp_asprak', $input);
      }
      if ($keluhan == '1') {
        $kirim_komplain = array(
          'tglKomplain'     => $tanggal,
          'namaInforman'    => $nama_km,
          'jenisInforman'   => 'Student',
          'catatanKomplain' => $komplain,
          'statusKomplain'  => '0',
          'idLab'           => $lab
        );
        $this->db->insert('komplain', $kirim_komplain);
      }
      set_flashdata('msg', '<div class="alert alert-success msg">Your BAPP successfully saved</div>');
      redirect('Asprak/BAPP');
    }
  }

  public function EditBAPP($id)
  {
    set_rules('modul', 'Modul', 'required|trim');
    // set_rules('prodi', 'Prodi', 'required|trim');
    // set_rules('mk', 'MK', 'required|trim');
    // set_rules('lab', 'Lab', 'required|trim');
    // set_rules('kelas', 'Kelas', 'required|trim');
    // set_rules('dosen', 'Dosen', 'required|trim');
    // set_rules('tanggal', 'Tanggal', 'required|trim');
    // set_rules('jumlah_mhs', 'Jumlah Mahasiswa', 'required|trim');
    // set_rules('absen_mhs', 'Jumlah Mahasiswa Absen', 'required|trim');
    // set_rules('nim_absen', 'NIM Mahasiswa Absen', 'required|trim');
    // set_rules('dosen_hadir', 'Kehadiran Dosen', 'required|trim');
    // set_rules('jam_datang', 'Jam Datang', 'required|trim');
    // set_rules('jam_pulang', 'Jam Pulang', 'required|trim');
    // set_rules('nim_km', 'NIM KM', 'required|trim');
    // set_rules('nama_km', 'Nama KM', 'required|trim');
    if (validation_run() == false) {
      $data           = $this->data;
      $data['title']  = 'Edit BAPP | SIM Laboratorium';
      $data['prodi']  = $this->a->daftarProdi()->result();
      $data['dosen']  = $this->a->daftarDosen()->result();
      $data['mk']     = $this->a->daftarMK()->result();
      $data['lab']    = $this->a->daftarLaboratorium()->result();
      $data['asprak'] = $this->a->daftarSeluruhAsprak()->result();
      $data['data']   = $this->a->detailBAPP($id)->row();
      view('asprak/header', $data);
      view('asprak/edit_bapp', $data);
      view('asprak/footer');
    } else {
      $modul              = input('modul');
      $prodi              = input('prodi');
      $mk                 = input('mk');
      $lab                = input('lab');
      $kelas              = input('kelas');
      $dosen              = input('dosen');
      $tanggal            = input('tanggal');
      $pisah_tanggal      = explode('/', $tanggal);
      $urut_tanggal       = array($pisah_tanggal[2], $pisah_tanggal[0], $pisah_tanggal[1]);
      $tanggal            = implode('-', $urut_tanggal);
      $jumlah_mhs         = input('jumlah_mhs');
      $absen_mhs          = input('absen_mhs');
      $nim_absen          = input('nim_absen');
      $dosen_hadir        = input('dosen_hadir');
      $jam_datang         = input('jam_datang');
      $jam_pulang         = input('jam_pulang');
      $nim_km             = input('nim_km');
      $nama_km            = input('nama_km');
      $ttd_km             = input('tmp_sign');
      $catatan_praktikum  = nl2br(htmlspecialchars_decode(input('catatan_praktikum'), ENT_HTML5));
      $komplain           = nl2br(htmlspecialchars_decode(input('komplain'), ENT_HTML5));
      $image_data         = base64_decode($ttd_km);
      $convert            = substr(sha1(date('Y-m-d H:i:s')), 5, 9);
      $file_name          = $nim_km . '_' . $convert;
      $save_file          = 'assets/signature/km/' . $file_name . '.png';
      file_put_contents($save_file, $image_data);
      $input              = array(
        'tanggal_bapp'      => $tanggal,
        'modul'             => $modul,
        'id_prodi'          => $prodi,
        'id_mk'             => $mk,
        'kelas'             => $kelas,
        'id_dosen'          => $dosen,
        'id_lab'            => $lab,
        'jumlah_mahasiswa'  => $jumlah_mhs,
        'daftar_absen_mhs'  => $nim_absen,
        'mahasiswa_absen'   => $absen_mhs,
        'kehadiran_dosen'   => $dosen_hadir,
        'dosen_datang'      => $jam_datang,
        'dosen_pulang'      => $jam_pulang,
        'nim_km'            => $nim_km,
        'nama_km'           => $nama_km,
        'ttd_km'            => $save_file,
        'catatan_praktikum' => $catatan_praktikum
      );
      $this->db->insert('bapp', $input);
      $ambil_id_bapp = $this->db->get_where('bapp', $input)->row();
      print_r($ambil_id_bapp);
      foreach (input('asprak') as $a) {
        echo $a . ' ';
        $input = array(
          'nim_asprak'  => $a,
          'id_bapp'     => $ambil_id_bapp->id_bapp
        );
        $this->db->insert('bapp_asprak', $input);
      }
      $kirim_komplain = array(
        'tglKomplain'     => $tanggal,
        'namaInforman'    => $nama_km,
        'jenisInforman'   => 'Student',
        'catatanKomplain' => $komplain,
        'statusKomplain'  => '0',
        'idLab'           => $lab
      );
      $this->db->insert('komplain', $kirim_komplain);
      set_flashdata('msg', '<div class="alert alert-success msg">Your BAPP successfully saved</div>');
      redirect('Asprak/BAPP');
    }
  }

  public function ViewBAPP()
  {
    $id = uri('3');
    if ($id == true) {
      if ($this->a->detailBAPP($id)->row()) {
        $data['title']  = 'View BAPP | SIM Laboratorium';
        $data['data'] = $this->a->detailBAPP($id)->row();
        view('asprak/view_bapp', $data);
      } else {
        redirect('Asprak/BAPP');
      }
    } else {
      redirect('Asprak/BAPP');
    }
  }

  public function AjaxBAPP()
  {
    $hasil  = '';
    $id     = input('id');
    $cek    = $this->db->where('substring(sha1(id_bapp), 8, 5) = "' . $id . '"')->get('bapp')->row();
    if ($cek == true) {
      $hasil .= $cek->id_bapp;
    } else {
      $hasil .= 'kosong';
    }
    echo $hasil;
  }

  public function DeleteBAPP()
  {
    set_rules('id', 'id', 'required|trim');
    if (validation_run() == false) {
      redirect('Asprak/BAPP');
    } else {
      $id = input('id');
      $cek_bapp = $this->db->where('substring(sha1(id_bapp), 8, 5) = "' . $id . '"')->get('bapp')->row();
      if ($cek_bapp) {
        $this->db->where('substring(sha1(id_bapp), 8, 5) = "' . $id . '"')->delete('bapp');
        $this->db->where('id_bapp', $cek_bapp->id_bapp)->delete('bapp_asprak');
        redirect('Asprak/BAPP');
      } else {
        redirect('Asprak/BAPP');
      }
    }
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

  public function PersonalInfo()
  {
    set_rules('nim', 'NIM', 'required|trim');
    if (validation_run() == true) {
      $nim            = input('nim');
      $nama_asprak    = input('nama_asprak');
      $kontak_asprak  = input('kontak_asprak');
      $email_asprak   = input('email_asprak');
      $nama_bank      = input('nama_bank');
      $norek_asprak   = input('norek_asprak');
      $nama_rekening  = input('nama_rekening');
      $input          = array(
        'nama_asprak'   => $nama_asprak,
        'kontak_asprak' => $kontak_asprak,
        'email_asprak'  => $email_asprak,
        'id_bank'       => $nama_bank,
        'norek_asprak'  => $norek_asprak,
        'nama_rekening' => $nama_rekening
      );
      $this->a->updateData('asprak', $input, 'nim_asprak', $nim);
      set_flashdata('msg', '<div class="alert alert-success msg">Your personal information successfully updated</div>');
      redirect('Asprak/Setting');
    } else {
      redirect('Asprak/Setting');
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

  public function SaveSign()
  {
    set_flashdata('msg', '<div class="alert alert-success msg">Your signature successfully saved</div>');
    redirect('Asprak/Setting');
  }

  public function UploadSign()
  {
    $convert    = substr(sha1(date('Y-m-d H:i:s')), 5, 9);
    $extension  = explode('.', $_FILES['file_ttd']['name']);
    $nama_file  = $_POST['nim_asprak'] . '_' . $convert . '.' . $extension[1];
    $config['upload_path']    = 'assets/signature/asprak/';
    $config['allowed_types']  = 'gif|jpg|jpeg|png';
    $config['max_size']       = 1024 * 10;
    $config['file_name']      = $nama_file;
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('file_ttd')) {
      $cek_data   = $this->db->get_where('asprak', array('nim_asprak' => $_POST['nim_asprak']))->row();
      if ($cek_data->ttd_asprak) {
        unlink($cek_data->ttd_asprak);
      }
      $ttd_asprak = $config['upload_path'] . '' . $nama_file;
      $input      = array('ttd_asprak' => $ttd_asprak);
      $this->db->where('nim_asprak', $_POST['nim_asprak'])->update('asprak', $input);
      set_flashdata('msg', '<div class="alert alert-success msg">Your signature successfully saved</div>');
      redirect('Asprak/Setting');
    }
  }

  public function AccountSetting()
  {
    set_rules('username_asprak', 'Username', 'required|trim');
    set_rules('password_lama', 'Old Password', 'required|trim');
    set_rules('password_baru', 'New Password', 'required|trim');
    set_rules('konfirm_password', 'Repeat Password', 'required|trim');
    if (validation_run() == false) {
      redirect(base_url('Asprak/Setting'));
    } else {
      $username_asprak  = input('username_asprak');
      $password_lama    = sha1(input('password_lama'));
      $password_baru    = sha1(input('password_baru'));
      $konfirm_password = sha1(input('konfirm_password'));
      $data = $this->db->get_where('users', array('username' => $username_asprak))->row();
      if ($data->password != $password_lama) {
        set_flashdata('msg', '<div class="alert alert-danger msg">Old password not match. Please try again</div>');
        redirect('Asprak/Setting');
      } else {
        if ($password_baru != $konfirm_password) {
          set_flashdata('msg', '<div class="alert alert-danger msg">New password and confirm password not match. Please try again</div>');
          redirect('Asprak/Setting');
        } else {
          $input = array(
            'password'  => $password_baru
          );
          $this->a->updateData('users', $input, 'username', $username_asprak);
          set_flashdata('msg', '<div class="alert alert-success msg">Password successfully updated</div>');
          redirect('Asprak/Setting');
        }
      }
    }
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

  public function AgreementLetter()
  {
    //
  }
}
