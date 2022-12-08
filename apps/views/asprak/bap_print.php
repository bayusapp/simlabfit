<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>" />
  <title>BAP <?= $profil->nim_asprak . ' ' . $profil->nama_asprak . ' ' . $nama_bulan . ' ' . date('Y') ?></title>
  <style type="text/css">
    body {
      font-family: Arial;
      -webkit-print-color-adjust: exact !important;
    }

    .header {
      font-weight: bold;
      font-size: 12pt;
    }

    .isi {
      font-size: 10pt;
    }

    .table-isi {
      border-collapse: collapse;
      border: 1px solid black;
      font-size: 10pt;
    }

    .thead-isi {
      font-weight: bold;
      background-color: #333333;
      color: #FFFFFF;
      text-align: center;
      /* font-size: 10pt; */
    }
  </style>
  <style type="text/css" media="print">
    @page {
      size: auto;
      /* auto is the initial value */
      margin: 4mm;
      /* this affects the margin in the printer settings */
    }
  </style>
</head>

<body onload="window.print()">
  <table width="100%">
    <tr>
      <td width="70%" valign="top" colspan="2">
        <div class="header">
          BERITA ACARA PEKERJAAN DAN KEHADIRAN<br>ASISTEN PRAKTIKUM
        </div>
      </td>
      <td style="text-align: center" width="30%" rowspan="3" valign="middle">
        <div align="center">
          <img src="https://simlabfit.com/assets/img/logo_tass.png" height="52px" style="padding-right: 30px;">
        </div>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;" width="14%">NAMA</td>
      <td>: <?= strtoupper($profil->nama_asprak) ?></td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">NIM</td>
      <td>: <?= $profil->nim_asprak ?></td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">BULAN</td>
      <td>: <?= strtoupper($nama_bulan) ?></td>
      <td style="text-align: right; font-weight: bold;">Laboratorium</td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">PRODI</td>
      <td>: <?= strtoupper($ambil_mk->strata . ' ' . $ambil_mk->nama_prodi) ?></td>
      <td style="text-align: right; font-weight: bold;">Fakultas Ilmu Terapan</td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">MK / KODE MK</td>
      <td>: <?= strtoupper($ambil_mk->nama_mk . ' / ' . $ambil_mk->kode_mk) ?></td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">TAHUN</td>
      <td>: <?= date('Y') ?></td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">TOTAL JAM</td>
      <td>: <?= $durasi->durasi ?></td>
    </tr>
  </table>
  <br>
  <table border="1" width="100%" class="table-isi">
    <thead>
      <tr>
        <td class="thead-isi" width="13%">Tanggal</td>
        <td class="thead-isi" width="13%">Kelas</td>
        <td class="thead-isi" width="7%">Jam Masuk</td>
        <td class="thead-isi" width="7%">Jam Keluar</td>
        <td class="thead-isi" width="7%">Jumlah Jam</td>
        <td class="thead-isi" width="27%">Modul Praktikum</td>
        <td class="thead-isi" width="13%">Paraf<br>Asprak</td>
        <td class="thead-isi" width="13%">Tanda Tangan<br>Dosen</td>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($ambil_bap as $a) {
        $tanggal_indonesia  = tanggal_indonesia_pendek($a->tanggal);
        $ttd_asprak         = '<img src="' . base_url($ttd) . '" style="max-height: 25px">';
      ?>
        <tr>
          <td style="text-align: center"><?= $tanggal_indonesia ?></td>
          <td style="text-align: center"><?= $a->kelas ?></td>
          <td style="text-align: center"><?= $a->jam_masuk ?></td>
          <td style="text-align: center"><?= $a->jam_selesai ?></td>
          <td style="text-align: center"><?= $a->durasi ?></td>
          <td style="padding-left: 3px; padding-right: 3px"><?= $a->modul ?></td>
          <td style="text-align: center"><?= $ttd_asprak ?></td>
          <td></td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
  <br>
  <table width="100%" style="text-align: right" class="isi">
    <tr>
      <td>Bandung, <?= tanggal_indonesia(date('Y-m-d')) ?></td>
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
  </table>
</body>

</html>