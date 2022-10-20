<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HistoryLogin extends CI_Controller
{

  var $data;

  public function __construct()
  {
    parent::__construct();
    if (userdata('login') != 'laboran' && userdata('login') != 'aslab' && userdata('login') != 'dosen') {
      redirect();
    }
    if (userdata('login') == 'laboran') {
      $id_laboran = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->id_laboran;
      $this->data = array(
        'profil'              => $this->m->profilLaboran($id_laboran)->row(),
        'jumlah_komplain'     => $this->m->hitungKomplain()->row()->komplain,
        'jumlah_pinjam_lab'   => $this->m->hitungPeminjamanLab()->row()->pinjamlab,
        'jumlah_pinjam_alat'  => $this->m->hitungPeminjamanAlat()->row()->pinjamalat,
        'laporan_asprak'      => $this->db->select('count(id_laporan_praktikum) jumlah')->from('laporan_praktikum')->where('status_laporan', '0')->get()->row()->jumlah,
        'honor_asprak'        => $this->db->select('count(id_honor) jumlah')->from('honor')->where('status', '1')->get()->row()->jumlah,
        'honor_aslab'         => $this->db->select('count(id_honor_aslab) jumlah')->from('honor_aslab')->where('status_honor', '2')->get()->row()->jumlah
      );
    } elseif (userdata('login') == 'aslab') {
      $this->data = array(
        'jumlah_komplain'     => $this->m->hitungKomplain()->row()->komplain,
        'jumlah_pinjam_lab'   => $this->m->hitungPeminjamanLab()->row()->pinjamlab,
        'jumlah_pinjam_alat'  => $this->m->hitungPeminjamanAlat()->row()->pinjamalat,
        'cek_aslab'           => $this->m->profilAslab(userdata('id_aslab'))->row()
      );
    } elseif (userdata('login') == 'dosen') {
      $id_dosen = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->id_dosen;
      $this->data = array(
        'profil'              => $this->m->profilDosen($id_dosen)->row()
      );
    }
  }

  public function index()
  {
    $data           = $this->data;
    $data['title']  = 'History Login | SIM Laboratorium';
    $username = $this->db->get_where('users', array('idUser' => userdata('id')))->row()->username;
    $data['data']   = $this->db->order_by('tanggal_login', 'desc')->get_where('history_login', array('username' => $username))->result();
    if (userdata('login') == 'laboran') {
      view('laboran/header', $data);
      view('laboran/history_login', $data);
      view('laboran/footer');
    } elseif (userdata('login') == 'aslab') {
      view('aslab/header', $data);
      view('aslab/history_login', $data);
      view('aslab/footer');
    } elseif (userdata('login') == 'dosen') {
      view('dosen/header', $data);
      view('dosen/history_login', $data);
      view('dosen/footer');
    }
  }
}
