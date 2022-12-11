<html>

<head>
  <style type="text/css">
    body {
      font-family: Arial;
      -webkit-print-color-adjust: exact !important;
    }

    .header {
      font-weight: bold;
      font-size: 11pt;
    }

    .isi {
      font-size: 9pt;
      vertical-align: top;
    }

    .table-isi {
      border-collapse: collapse;
      border: 1px solid black;
      font-size: 9pt;
    }

    .thead-isi {
      font-weight: bold;
      background-color: #333333;
      color: white;
      text-align: center;
      /* font-size: 10pt; */
    }
  </style>
</head>

<body>
  <table width="100%">
    <tr>
      <td width="70%" valign="top" colspan="3">
        <div class="header">
          BERITA ACARA PEKERJAAN DAN KEHADIRAN<br>ASISTEN LABORATORIUM
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;" width="12%">NAMA</td>
      <td width="1%">:</td>
      <td><?= strtoupper($profil_aslab->namaLengkap) ?></td>
      <td style="text-align: right" width="30%" rowspan="3" valign="top">
        <div align="right">
          <img src="https://simlabfit.com/assets/img/logo_tass.png" height="52px">
        </div>
      </td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">NIM</td>
      <td>:</td>
      <td><?= $profil_aslab->nim ?></td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">NAMA LAB</td>
      <?php
      $laboratorium = '';
      $no = 1;
      $jumlah = count($pj);
      foreach ($pj as $p) {
        if (($no + 1) == $jumlah) {
          $laboratorium .= $p->namaLab . ' & ';
        } else {
          $laboratorium .= $p->namaLab;
        }
        $no++;
        // if ($p->idAslab == uri('3')) {
        //   $laboratorium .= '- ' . $p->namaLab . '<br>';
        // }
      }
      ?>
      <td>:</td>
      <td><?= strtoupper($laboratorium) ?> LABORATORY</td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">PRODI</td>
      <td>:</td>
      <td><?= strtoupper($prodi->nama_prodi) ?></td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">BULAN</td>
      <td>:</td>
      <td><?= strtoupper($bulan) ?></td>
      <td style="text-align: right; font-weight: bold;">
        Laboratorium
      </td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">TAHUN</td>
      <td>:</td>
      <td><?= date('Y') ?></td>
      <td style="text-align: right; font-weight: bold;">Fakultas Ilmu Terapan</td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">TOTAL JAM</td>
      <td>:</td>
      <?php
      $total = 0;
      foreach ($kegiatan as $k) {
        $masuk = explode(':', $k->jamMasuk);
        $jam_masuk = $masuk[0] * 3600;
        $menit_masuk = $masuk[1] * 60;
        if ($k->jamKeluar == '0') {
          $kluar = '00:00';
        } else {
          $kluar = $k->jamKeluar;
        }
        $keluar = explode(':', $kluar);
        $jam_keluar = $keluar[0] * 3600;
        $menit_keluar = $keluar[1] * 60;
        $durasi = (($jam_keluar + $menit_keluar) - ($jam_masuk + $menit_masuk)) / 3600;
        if ($durasi < 0) {
          $durasi = 0;
        } else {
          $durasi = round($durasi);
        }
        $total = $total + $durasi;
      }
      ?>
      <td><?= $total ?></td>
    </tr>
    <tr class="isi">
      <td style="font-weight: bold;">LABORAN</td>
      <td>:</td>
      <td><?= strtoupper($profil_aslab->nama_laboran) ?></td>
    </tr>
  </table>
  <br>
  <table border="1" width="100%" class="table-isi">
    <thead>
      <tr>
        <td class="thead-isi" width="14%">Tanggal</td>
        <td class="thead-isi" width="7%">Jam Masuk</td>
        <td class="thead-isi" width="7%">Jam Keluar</td>
        <td class="thead-isi" width="8%">Jumlah Jam</td>
        <td class="thead-isi">Deskripsi Pekerjaan</td>
        <td class="thead-isi" width="8%">Paraf Asisten</td>
        <td class="thead-isi" width="8%">Paraf Laboran</td>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($kegiatan as $k) {
        $masuk = explode(':', $k->jamMasuk);
        $jam_masuk = $masuk[0] * 3600;
        $menit_masuk = $masuk[1] * 60;
        if ($k->jamKeluar == '0') {
          $kluar = '00:00';
        } else {
          $kluar = $k->jamKeluar;
        }
        $keluar = explode(':', $kluar);
        $jam_keluar = $keluar[0] * 3600;
        $menit_keluar = $keluar[1] * 60;
        $durasi = (($jam_keluar + $menit_keluar) - ($jam_masuk + $menit_masuk)) / 3600;
        if ($durasi < 0) {
          $durasi = '-';
        } else {
          $durasi = round($durasi);
        }
      ?>
        <tr>
          <td style="text-align: center;"><?= tanggal_indonesia_pendek($k->aslabMasuk) ?></td>
          <td style="text-align: center;"><?= $k->jamMasuk ?></td>
          <td style="text-align: center;"><?= $k->jamKeluar ?></td>
          <td style="text-align: center;"><?= $durasi ?></td>
          <td style="padding: 4px;"><?= $k->jurnal ?></td>
          <td></td>
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
      <td>Ka.Ur. Laboratorium/Bengkel/Studio</td>
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
      <td>Devie Ryana Suchendra</td>
    </tr>
  </table>
</body>

</html>