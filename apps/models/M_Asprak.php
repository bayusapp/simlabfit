<?php

class M_Asprak extends CI_Model
{

  function updateData($tabel, $data, $where, $nilai)
  {
    $this->db->where($where, $nilai);
    $this->db->update($tabel, $data);
  }

  function profilAsprak($nim)
  {
    return $this->db->get_where('asprak', array('nim_asprak' => $nim));
  }

  function daftarPengumuman()
  {
    $this->db->select('*');
    $this->db->from('pengumuman');
    $this->db->where('tipePengumuman', 'Practicum Assistant');
    $this->db->order_by('tglPengumuman', 'desc');
    $this->db->limit('7');
    return $this->db->get();
  }

  function daftarPengumumanDosen()
  {
    $this->db->select('*');
    $this->db->from('pengumuman');
    $this->db->where('tipePengumuman', 'Lecture');
    $this->db->order_by('tglPengumuman', 'desc');
    $this->db->limit('7');
    return $this->db->get();
  }

  function akunAsprak($nim)
  {
    return $this->db->get_where('users', array('nimAsprak' => $nim));
  }

  function jadwalMKAsprak($nim)
  {
    $this->db->select('jadwal_lab.id_jadwal_lab, concat(matakuliah.kode_mk, "\n", matakuliah.nama_mk, "\n", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen) title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke');
    $this->db->from('jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->join('daftar_mk', 'matakuliah.kode_mk = daftar_mk.kode_mk');
    $this->db->join('daftarasprak', 'daftar_mk.id_daftar_mk = daftarasprak.id_daftar_mk');
    $this->db->where('daftarasprak.nim_asprak', $nim);
    $this->db->where('jadwal_lab.id_jadwal_lab not in (select jadwal_lab.id_jadwal_lab from jadwal_asprak join jadwal_lab on jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab where jadwal_asprak.nim_asprak = ' . $nim . ')');
    return $this->db->get();
  }

  function jadwalAsprak($nim)
  {
    // $this->db->select('jadwal_asprak.nim_asprak, concat(matakuliah.kode_mk, "\n", matakuliah.nama_mk, "\n", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen, "\n", laboratorium.namaLab, " Laboratory (", laboratorium.kodeRuang, ")") title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke');
    // $this->db->from('jadwal_asprak');
    // $this->db->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    // $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    // $this->db->join('laboratorium', 'jadwal_lab.id_lab = laboratorium.idLab');
    // $this->db->where('jadwal_asprak.nim_asprak', $nim);
    $this->db->select('jadwal_asprak.nim_asprak, jadwal_lab.id_jadwal_lab, concat(matakuliah.kode_mk, "\n", matakuliah.nama_mk, "\n", jadwal_lab.kelas, " / ", jadwal_lab.kode_dosen) title, jadwal_lab.jam_masuk start, jadwal_lab.jam_selesai end, jadwal_lab.hari_ke');
    $this->db->from('jadwal_asprak');
    $this->db->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->where('jadwal_asprak.nim_asprak', $nim);
    return $this->db->get();
  }

  function jadwalPresensiAsprak($nim)
  {
    $this->db->select('jadwal_asprak.id_jadwal_asprak, jadwal_lab.id_jadwal_lab, matakuliah.kode_mk, matakuliah.nama_mk, jadwal_lab.hari_ke, date_format(jadwal_lab.jam_masuk, "%H:%i") masuk, date_format(jadwal_lab.jam_selesai, "%H:%i") selesai');
    $this->db->from('jadwal_asprak');
    $this->db->join('jadwal_lab', 'jadwal_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->where('jadwal_asprak.nim_asprak', $nim);
    $this->db->order_by('jadwal_lab.hari_ke', 'asc');
    return $this->db->get();
  }

  function daftarPresensiAsprak($nim)
  {
    $this->db->select('presensi_asprak.id_presensi_asprak, date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") selesai, presensi_asprak.modul, jadwal_lab.kelas, jadwal_lab.kode_dosen, matakuliah.nama_mk');
    $this->db->from('presensi_asprak');
    $this->db->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->where('nim_asprak', $nim);
    $this->db->order_by('asprak_masuk', 'desc');
    return $this->db->get();
    // $this->db->select('presensi_asprak.id_presensi_asprak, date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") selesai, presensi_asprak.modul, presensi_asprak.approve_absen, jadwal_lab.kelas, jadwal_lab.kode_dosen, matakuliah.nama_mk');
    // $this->db->from('presensi_asprak');
    // $this->db->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    // $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    // $this->db->where('nim_asprak', $nim);
    // $this->db->order_by('approve_absen', 'asc');
    // $this->db->order_by('asprak_masuk', 'desc');
    // return $this->db->get();
  }

  function daftarPresensiAsprakPeriode($nim, $between)
  {
    $this->db->select('presensi_asprak.id_presensi_asprak, date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") selesai, presensi_asprak.modul, jadwal_lab.kelas, jadwal_lab.kode_dosen, matakuliah.nama_mk');
    $this->db->from('presensi_asprak');
    $this->db->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    $this->db->where('nim_asprak', $nim);
    $this->db->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $between);
    $this->db->order_by('asprak_masuk', 'desc');
    return $this->db->get();
    // $this->db->select('presensi_asprak.id_presensi_asprak, date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") tanggal, date_format(presensi_asprak.asprak_masuk, "%H:%i") masuk, date_format(presensi_asprak.asprak_selesai, "%H:%i") selesai, presensi_asprak.modul, presensi_asprak.approve_absen, jadwal_lab.kelas, jadwal_lab.kode_dosen, matakuliah.nama_mk');
    // $this->db->from('presensi_asprak');
    // $this->db->join('jadwal_lab', 'presensi_asprak.id_jadwal_lab = jadwal_lab.id_jadwal_lab');
    // $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    // $this->db->where('nim_asprak', $nim);
    // $this->db->where('date_format(presensi_asprak.asprak_masuk, "%Y-%m-%d") between ' . $between);
    // $this->db->order_by('approve_absen', 'asc');
    // $this->db->order_by('asprak_masuk', 'desc');
    // return $this->db->get();
  }

  function dataPresensiAsprak($nim, $id)
  {
    $this->db->select('id_jadwal_asprak, date_format(asprak_masuk, "%m/%d/%Y") tanggal, date_format(asprak_masuk, "%H:%i") masuk, date_format(asprak_selesai, "%H:%i") selesai, modul');
    $this->db->from('presensi_asprak');
    $this->db->where('substring(sha1(id_presensi_asprak), 8, 7) = "' . $id . '"');
    $this->db->where('nim_asprak', $nim);
    return $this->db->get();
  }

  function daftarMKAsprak($nim)
  {
    $this->db->select('daftarasprak.id_daftar_mk, prodi.strata, prodi.kode_prodi, matakuliah.id_mk, matakuliah.kode_mk, matakuliah.nama_mk');
    $this->db->from('daftarasprak');
    $this->db->join('daftar_mk', 'daftarasprak.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('prodi', 'daftar_mk.kode_prodi = prodi.kode_prodi');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->join('tahun_ajaran', 'daftar_mk.id_ta = tahun_ajaran.id_ta');
    $this->db->where('daftarasprak.nim_asprak', $nim);
    $this->db->where('tahun_ajaran.status', '1');
    $this->db->order_by('matakuliah.kode_mk', 'asc');
    return $this->db->get();
  }

  function daftarPeriode()
  {
    return $this->db->get('periode');
    // return $this->db->get_where('periode', array('asprak' => '1'));
  }

  function daftarHonorAsprak($nim)
  {
    $this->db->select('honor.id_honor, matakuliah.kode_mk, matakuliah.nama_mk, tahun_ajaran.ta, periode.bulan, date_format(honor.tanggal_submit, "%Y") tahun, honor.nominal, honor.status');
    $this->db->from('honor');
    $this->db->join('daftar_mk', 'honor.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->join('periode', 'honor.id_periode = periode.id_periode');
    $this->db->join('tahun_ajaran', 'daftar_mk.id_ta = tahun_ajaran.id_ta');
    $this->db->where('honor.nim_asprak', $nim);
    $this->db->where('honor.status', '0');
    $this->db->where('honor.approve_dosen', '1');
    $this->db->where('honor.no_pk is not null');
    $this->db->order_by('honor.id_honor', 'desc');
    return $this->db->get();
  }

  function daftarHonorAsprakDiambil($nim)
  {
    $this->db->select('honor.id_honor, matakuliah.kode_mk, matakuliah.nama_mk, tahun_ajaran.ta, periode.bulan, date_format(honor.tanggal_submit, "%Y") tahun, honor.nominal, honor.status, honor.opsi_pengambilan, honor.bukti_transfer');
    $this->db->from('honor');
    $this->db->join('daftar_mk', 'honor.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->join('periode', 'honor.id_periode = periode.id_periode');
    $this->db->join('tahun_ajaran', 'daftar_mk.id_ta = tahun_ajaran.id_ta');
    $this->db->where('honor.nim_asprak', $nim);
    $this->db->where('honor.status != 0');
    $this->db->where('honor.approve_dosen', '1');
    $this->db->order_by('honor.id_honor', 'desc');
    return $this->db->get();
  }

  function daftarLaporan($nim)
  {
    $this->db->select('laporan_praktikum.id_laporan_praktikum, laporan_praktikum.id_daftar_mk, date_format(laporan_praktikum.tanggal_upload, "%Y-%m-%d") tanggal, date_format(laporan_praktikum.tanggal_upload, "%H:%i:%s") jam, laporan_praktikum.catatan_revisi, laporan_praktikum.status_laporan, laporan_praktikum.nama_file, matakuliah.kode_mk, matakuliah.nama_mk');
    $this->db->from('laporan_praktikum');
    $this->db->join('daftar_mk', 'laporan_praktikum.id_daftar_mk = daftar_mk.id_daftar_mk');
    $this->db->join('matakuliah', 'daftar_mk.kode_mk = matakuliah.kode_mk');
    $this->db->where('laporan_praktikum.nim_asprak', $nim);
    return $this->db->get();
  }

  function daftarBank()
  {
    return $this->db->get('bank');
  }

  function cekPassword($username)
  {
    return $this->db->get_where('users', array('username' => $username));
  }

  function cekJadwalAsprakDashboard($nim, $hari, $jam_sekarang)
  {
    $this->db->select('b.id_jadwal_asprak, a.nama_asprak, d.nama_mk, c.kelas, dayname(c.jam_masuk) hari, date_format(c.jam_masuk, "%H:%i") masuk, date_format(c.jam_selesai, "%H:%i") keluar, e.namaLab, c.id_jadwal_lab');
    $this->db->from('asprak a');
    $this->db->join('jadwal_asprak b', 'a.nim_asprak = b.nim_asprak');
    $this->db->join('jadwal_lab c', 'b.id_jadwal_lab = c.id_jadwal_lab');
    $this->db->join('matakuliah d', 'c.id_mk = d.id_mk');
    $this->db->join('laboratorium e', 'c.id_lab = e.idLab');
    $this->db->where('a.nim_asprak', $nim);
    $this->db->where('dayname(c.jam_masuk)', $hari);
    $this->db->where('date_format(c.jam_masuk, "%H:%i") <= "' . $jam_sekarang . '"');
    $this->db->where('date_format(c.jam_selesai, "%H:%i") >= "' . $jam_sekarang . '"');
    return $this->db->get();
  }

  function cekTapAsprak($id_jadwal_asprak, $tanggal)
  {
    $this->db->select('id_presensi_asprak, id_jadwal_asprak, asprak_masuk, ((date_format(asprak_masuk, "%H") * 3600) + (date_format(asprak_masuk, "%i") * 60)) durasi, if (asprak_selesai, asprak_selesai, "null") keluar');
    $this->db->from('presensi_asprak');
    $this->db->where('id_jadwal_asprak', $id_jadwal_asprak);
    $this->db->where('date_format(asprak_masuk, "%Y-%m-%d") = "' . $tanggal . '"');
    return $this->db->get();
  }

  function cekTahunAjaranAsprak($nim)
  {
    $this->db->select('DISTINCT(a.id_ta), b.ta');
    $this->db->from('daftarasprak a');
    $this->db->join('tahun_ajaran b', 'a.id_ta = b.id_ta');
    $this->db->where('a.nim_asprak', $nim);
    $this->db->order_by('a.id_ta', 'desc');
    return $this->db->get();
  }

  function daftarAsprakMKPeriode($nim, $ta)
  {
    $this->db->select('a.kode_mk, a.nama_mk, b.id_daftar_mk, c.id_ta');
    $this->db->from('matakuliah a');
    $this->db->join('daftar_mk b', 'a.kode_mk = b.kode_mk');
    $this->db->join('daftarasprak c', 'b.id_daftar_mk = c.id_daftar_mk');
    $this->db->where('c.nim_asprak', $nim);
    $this->db->where('c.id_ta', $ta);
    $this->db->order_by('a.nama_mk', 'asc');
    return $this->db->get();
  }

  function daftarAsprakMK($id_ta, $id_mk)
  {
    $this->db->select('b.nim_asprak, b.nama_asprak, b.kontak_asprak, a.posisi');
    $this->db->from('daftarasprak a');
    $this->db->join('asprak b', 'a.nim_asprak = b.nim_asprak');
    $this->db->where('a.id_ta', $id_ta);
    $this->db->where('a.id_daftar_mk', $id_mk);
    $this->db->order_by('b.nama_asprak', 'asc');
    return $this->db->get();
  }

  function daftarProdi()
  {
    return $this->db->get('prodi');
  }

  function daftarMK()
  {
    return $this->db->get('matakuliah');
  }

  function daftarLaboratorium()
  {
    return $this->db->order_by('kodeRuang', 'asc')->get('laboratorium');
  }

  function daftarSeluruhAsprak()
  {
    return $this->db->order_by('nama_asprak', 'asc')->get('asprak');
  }

  function daftarDosen()
  {
    return $this->db->order_by('kode_dosen', 'asc')->get('dosen');
  }

  function hitungGajiPeriode($nim, $p1, $p2)
  {
    $this->db->select('sum(honor) gaji');
    $this->db->from('presensi_asprak');
    $this->db->where('nim_asprak', $nim);
    $this->db->where('asprak_masuk between "' . $p1 . '" and "' . $p2 . '"');
    return $this->db->get();
  }

  function daftarBAPP($nim)
  {
    $this->db->select('bapp.id_bapp, bapp.tanggal_bapp, bapp.kelas, matakuliah.nama_mk, dosen.kode_dosen, bapp.modul');
    $this->db->from('bapp');
    $this->db->join('bapp_asprak', 'bapp.id_bapp = bapp_asprak.id_bapp');
    $this->db->join('matakuliah', 'bapp.id_mk = matakuliah.id_mk');
    $this->db->join('dosen', 'bapp.id_dosen = dosen.id_dosen');
    $this->db->where('bapp_asprak.nim_asprak', $nim);
    $this->db->order_by('bapp.tanggal_bapp', 'desc');
    return $this->db->get();
  }

  function detailBAPP($id)
  {
    $this->db->select('bapp.id_bapp, bapp.tanggal_bapp, bapp.kelas, bapp.nama_km, bapp.nim_km, bapp.ttd_km, bapp.jumlah_mahasiswa, bapp.mahasiswa_absen, bapp.daftar_absen_mhs, bapp.kehadiran_dosen, bapp.dosen_datang, bapp.dosen_pulang, bapp.id_mk, bapp.catatan_praktikum, bapp.id_prodi, matakuliah.kode_mk, matakuliah.nama_mk, dosen.kode_dosen, bapp.modul, prodi.strata, prodi.nama_prodi, laboratorium.kodeRuang');
    $this->db->from('bapp');
    $this->db->join('bapp_asprak', 'bapp.id_bapp = bapp_asprak.id_bapp');
    $this->db->join('matakuliah', 'bapp.id_mk = matakuliah.id_mk');
    $this->db->join('dosen', 'bapp.id_dosen = dosen.id_dosen');
    $this->db->join('prodi', 'bapp.id_prodi = prodi.id_prodi');
    $this->db->join('laboratorium', 'bapp.id_lab = laboratorium.idLab');
    $this->db->where('substring(sha1(bapp.id_bapp), 8, 5) = "' . $id . '"');
    $this->db->order_by('bapp.id_bapp', 'desc');
    return $this->db->get();
  }

  function daftarAsprakBAPP($id_bapp)
  {
    $this->db->select('asprak.nama_asprak, asprak.ttd_asprak');
    $this->db->from('bapp_asprak');
    $this->db->join('asprak', 'bapp_asprak.nim_asprak = asprak.nim_asprak');
    $this->db->where('substring(sha1(bapp_asprak.id_bapp), 8, 5) = "' . $id_bapp . '"');
    return $this->db->get();
  }

  function ambilKoorBAPP($kode_mk)
  {
    $this->db->select('asprak.nama_asprak, asprak.ttd_asprak');
    $this->db->from('daftar_mk');
    $this->db->join('daftarasprak', 'daftar_mk.id_daftar_mk = daftarasprak.id_daftar_mk');
    $this->db->join('asprak', 'daftarasprak.nim_asprak = asprak.nim_asprak');
    $this->db->where('daftar_mk.kode_mk', $kode_mk);
    $this->db->where('daftarasprak.posisi = "1"');
    return $this->db->get();
  }

  function jadwalKuliah()
  {
    $this->db->select('jadwal_lab.id_jadwal_lab, substring(jadwal_lab.jam_masuk, 12, 5) masuk, substring(jadwal_lab.jam_selesai, 12, 5) selesai, jadwal_lab.kelas, jadwal_lab.kode_dosen, jadwal_lab.hari_ke, laboratorium.kodeRuang, matakuliah.kode_mk, matakuliah.nama_mk');
    $this->db->from('jadwal_lab');
    $this->db->join('laboratorium', 'jadwal_lab.id_lab = laboratorium.idLab');
    $this->db->join('matakuliah', 'jadwal_lab.id_mk = matakuliah.id_mk');
    return $this->db->get();
  }
}
