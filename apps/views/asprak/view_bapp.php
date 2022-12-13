<html>

<head>
  <title>Surat Perjanjian Asprak</title>
  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
    body {
      font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;
      -webkit-print-color-adjust: exact !important;
    }

    @page {
      size: A4
    }

    .surat {
      margin: 2.54mm 2.54mm 2.54mm 3mm;
    }

    .header {
      font-family: "Times New Roman", Times, serif;
    }

    .tabel1 {
      font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;
      font-size: 14px;
    }

    .tabel2 {
      font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;
      font-size: 14px;
    }
  </style>
</head>

<body class="A4" onmousedown="return false" onselectstart="return false">
  <section class="sheet padding-15mm">
    <div class="surat">
      <table width="100%" style="text-align: right;" class="header">
        <tr>
          <td rowspan="3" style="text-align: left; vertical-align: middle">
            <img src="<?= base_url('assets/img/') ?>Logo_Telkom_University_potrait.png" style="max-height: 77px;">
          </td>
          <td style="font-weight: bold; font-size: 18px">LABORATORIUM</td>
        </tr>
        <tr>
          <td style="font-weight: bold; font-size: 26px; font-style: italic;">Fakultas Ilmu Terapan</td>
        </tr>
        <tr style="font-weight: bold; font-size: 21px; font-style: italic;">
          <td>Universitas Telkom Bandung</td>
        </tr>
      </table>
      <hr style="height: 5px; background: black">
      <table width="100%" class="tabel1">
        <tr>
          <td colspan="6" style="font-weight: bold; font-size: 21px;">BERITA ACARA PELAKSANAAN PRAKTIKUM (diisi oleh ketua kelas)</td>
        </tr>
        <tr style="vertical-align: top;">
          <td style="font-weight: bold;" width="15%">MODUL</td>
          <td width="1%">:</td>
          <td width="30%"><?= $data->modul ?></td>
          <td style="font-weight: bold;" width="7%">PRODI</td>
          <td width="1%">:</td>
          <td width="30%"><?= $data->strata . ' ' . $data->nama_prodi ?></td>
        </tr>
        <tr style="vertical-align: top;">
          <td style="font-weight: bold;">KD MK/NAMA MK</td>
          <td>:</td>
          <td><?= $data->kode_mk . ' / ' . $data->nama_mk ?></td>
          <td style="font-weight: bold;">RUANG</td>
          <td>:</td>
          <td><?= $data->kodeRuang ?></td>
        </tr>
        <tr style="vertical-align: top;">
          <td style="font-weight: bold;">KELAS</td>
          <td>:</td>
          <td><?= $data->kelas ?></td>
          <td style="font-weight: bold;">DOSEN</td>
          <td>:</td>
          <td><?= $data->kode_dosen ?></td>
        </tr>
        <tr style="vertical-align: top;">
          <td style="font-weight: bold;">TANGGAL</td>
          <td>:</td>
          <td><?= tanggal_indonesia($data->tanggal_bapp) ?></td>
          <td rowspan="3"></td>
        </tr>
      </table>
      <br>
      <table width="90%" class="tabel2" style="margin: 0px 30px">
        <tr>
          <td width="40%">Ketua Kelas (Nama dan NIM)</td>
          <td width="1%">:</td>
          <td><?= $data->nama_km . ' (' . $data->nim_km . ')' ?></td>
        </tr>
        <tr>
          <td>Jumlah Mahasiswa Seharusnya</td>
          <td>:</td>
          <td><?= $data->jumlah_mahasiswa ?> orang</td>
        </tr>
        <tr>
          <td>Jumlah Mahasiswa yang tidak hadir</td>
          <td>:</td>
          <td><?= $data->mahasiswa_absen ?> orang</td>
        </tr>
        <tr style="vertical-align: top;">
          <td>(tuliskan NIM)</td>
          <td></td>
          <td>
            <?php
            $tmp = explode(',', $data->daftar_absen_mhs);
            for ($i = 0; $i < count($tmp); $i++) {
              echo $tmp[$i];
              if (($i + 1) == count($tmp)) {
                echo '';
              } else {
                echo ', ';
              }
            }
            ?>
            <!-- <?= $data->daftar_absen_mhs ?> -->
          </td>
        </tr>
      </table>
      <br>
      <span style="font-weight: bold;">Berita Acara:</span>
      <table width="90%" class="tabel2" border="1" style="margin: 0px 30px; border-collapse: collapse;
      border: 1px solid black;">
        <tr>
          <td width="50%">
            <?php
            if ($data->kehadiran_dosen == 0) {
              $tidak = '&emsp;&emsp;&check;';
              $hadir = '&emsp;&emsp;&emsp;';
            } elseif ($data->kehadiran_dosen == 1) {
              $tidak = '&emsp;&emsp;&emsp;';
              $hadir = '&emsp;&emsp;&check;';
            }
            ?>
            <?= $hadir ?>Dosen Hadir<?= $tidak ?>Dosen Tidak Hadir
          </td>
          <td width="50%" rowspan="3" style="vertical-align: top;">
            Catatan Selama Praktikum:
            <br><br>
            <?= $data->catatan_praktikum ?>
          </td>
        </tr>
        <tr>
          <?php
          if ($data->dosen_datang == null) {
            $datang = '&emsp;&emsp;-&emsp;&emsp;';
          } else {
            $datang = '&emsp;' . $data->dosen_datang . '&emsp;';
          }
          if ($data->dosen_pulang == null) {
            $pulang = '&emsp;&emsp;-&emsp;&emsp;';
          } else {
            $pulang = '&emsp;' . $data->dosen_pulang . '&emsp;';
          }
          ?>
          <td style="padding-left: 3px;">Dosen Hadir Pukul:<?= $datang ?>s/d<?= $pulang ?></td>
        </tr>
        <tr>
          <td style="text-align: center;">
            Tanda tangan Ketua Kelas :<br>
            <center>
              <img src="<?= base_url($data->ttd_km) ?>" style="max-height: 50px;">
            </center>
            <?= $data->nama_km ?>
          </td>
        </tr>
      </table>
      <br>
      <table width="94%" class="tabel2" border="1" style="margin: 0px 15px; border-collapse: collapse; border: 1px solid black;">
        <tr style="background-color: #D8D8D8; text-align: center">
          <td width="7%">NO</td>
          <td>NAMA ASISTEN</td>
          <td>TANDA TANGAN</td>
        </tr>
        <?php
        $no = 1;
        $daftar_asprak = $this->a->daftarAsprakBAPP(uri('3'))->result();
        foreach ($daftar_asprak as $a) {
        ?>
          <tr>
            <td style="text-align: center;"><?= $no++ ?></td>
            <td><?= $a->nama_asprak ?></td>
            <td style="text-align: center;">
              <?php
              if ($a->ttd_asprak == null) {
                $img = '-';
              } else {
                $img = '<img src="' . base_url($a->ttd_asprak) . '" style="max-height: 20px">';
              }
              echo $img;
              ?>
            </td>
          </tr>
        <?php
        }
        ?>
      </table>
      <br>
      <table width="100%" style="text-align: center;">
        <tr>
          <td width="33%" style="font-weight: bold;">Mengetahui</td>
          <td width="34%">&nbsp;</td>
          <td width="33%" style="font-weight: bold;">Hormat Kami,</td>
        </tr>
        <tr>
          <td>
            <span style="font-weight: bold;">Dosen Kelas Praktikum</span><br><br><br><br><br>
            (&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)
          </td>
          <td>&nbsp;</td>
          <td>
            <?php
            $koor = $this->a->ambilKoorBAPP($data->kode_mk)->row();
            if ($koor) {
              if ($koor->ttd_asprak == null) {
                $ttd_koor = '<br><br><br><br><br>';
              } else {
                $ttd_koor = '<img src="' . base_url($koor->ttd_asprak) . '" style="max-height: 80px">';
              }
              $koor = $koor->nama_asprak;
            } else {
              $ttd_koor = '<br><br><br><br><br>';
              $koor     = '(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)';
            }
            ?>
            <span style="font-weight: bold;">Koordinator Asprak</span>
            <?= $ttd_koor ?><br>
            <?= $koor ?>
          </td>
        </tr>
      </table>
    </div>
  </section>
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script>
    $(document).bind("contextmenu", function(e) {
      return false;
    });
  </script>
</body>

</html>