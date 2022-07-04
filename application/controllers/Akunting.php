<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Akunting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_role(['kepala toko']);

        $this->load->model('m_akunting');
        $this->load->model('MainModel', 'main');

        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
    }

    // List all your items
    public function reference()
    {

        $data['title'] = "Reference";
        $data['reference'] = $this->m_akunting->tampil_ref()->result();

        template_view('akunting/reference', $data);
    }

    public function jurnal_umum()
    {
        $data = array(
            'title' => 'Jurnal Umum',
            'ju' => $this->m_akunting->tampil_ju()->result(),
            'reference' => $this->m_akunting->tampil_ref()->result(),
            'total_debet' => $this->m_akunting->get_total_d()->row(),
            'total_kredit' => $this->m_akunting->get_total_k()->row(),

        );
        template_view('akunting/jurnal_umum', $data);
    }

    function hapus_ju($id)
    {
        $this->db->where('no', $id);
        $this->db->delete('jurnal_umum');
        redirect('akunting/jurnal_umum');
    }

    public function get_akun()
    {
        $get = $this->input->post('akun', TRUE);
        $this->db->select('*');
        $this->db->from('reference');
        $this->db->where('id', $get);
        $query = $this->db->get();
        return $query;
    }


    public function update_ju()
    {
        $this->db->set($this->input->post('column', TRUE), str_replace(".", "", $this->input->post('editval', TRUE)));
        $this->db->where('no', $this->input->post('id', TRUE));
        $this->db->update('jurnal_umum');
    }

    public function tambah_ju()
    {
        $trans     = $this->m_akunting->get_akun()->row()->no_ref;
        if ($trans == 102) { // PIUTANG PEGAWAI 

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Piutang Pegawai',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Kas',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 105) { //SEWA Dibayar Di muka
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Sewa dibayar di muka',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Kas',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 106) { //Perlengkapan Toko
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Perlengkapan Toko',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Kas',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );

            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 106) { //Peralatan Toko
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Peralatan Toko',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Kas',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 201) { //HUTANG DAGANG
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Persediaan Barang',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Hutang Dagang',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 202) { //HUTANG BANK 
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Kas',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Hutang Bank',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 302) { // PRIVE OWNER
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Prive Owner',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Kas',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 501) { //BIAYA PEMBELIAN
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Biaya Pembelian',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Kas',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 503) { //GAJI PEGAWAI
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Biaya Gaji',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Kas',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 504) { //REKENING AIR 
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Biaya Rek Air',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Kas',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 507) { // REKENING LISTRIK 
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Biaya Listrik & Telepon',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Kas',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 508) { // Biaya lain-lain
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Biaya lain-lain',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Kas',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 505) { // Biaya Penyusutan Peralatan Toko
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Biaya Peny.Inventaris',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Akum.Peny.Inventaris',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($trans == 506) { // Biaya Penyusutan Kendaraan
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Biaya Peny.Kendaraan',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Akum.Peny.Kendaraan',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        } elseif ($this->input->post('akun', TRUE) == 'b_hutang_dagang') {
            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Hutang Dagang',
                'debet'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'         =>    date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan' =>     'Kas',
                'kredit'         =>    str_replace('.', '', $this->input->post('biaya', TRUE)),
                'debet'            =>    0,
                'keterangan'     =>     $this->input->post('keterangan', TRUE)
            );
            $this->db->insert('jurnal_umum', $data);
        }
        redirect('akunting/jurnal_umum');
    }

    public function buku_besar()
    {
        $data = array(
            'title' => 'Buku Besar',
            'ju'    => $this->m_akunting->tampil_ju()->result(),
            'ref'   => $this->m_akunting->get_ref_bukbes()->result(),
        );
        template_view('akunting/buku_besar', $data);
    }

    public function get_bukubesar()
    {
        $akun = $this->input->post('akun', TRUE);
        $data = array(
            'title' => 'Buku Besar',
            'ju'    => $this->m_akunting->get_bukubesar($akun, 'jurnal_umum')->result(),
            'ref'   => $this->m_akunting->get_ref_bukbes()->result(),
            'set_saldo' => $this->get_top_bukbes(),
        );
        template_view('akunting/buku_besar', $data);
    }

    public function get_top_bukbes()
    {
        $this->db->select('debet,kredit');
        $this->db->from('jurnal_umum');
        $this->db->where('nama_perkiraan', $this->input->post('akun', TRUE));
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function lap_laba_rugi()
    {

        // $data = array('content' => "Maaf Tidak bisa masuk ke akses ini");
        // $this->load->view('notification/cant_access', $data);

        $now  = date('m');
        $data = array(
            'bulan'         => $now,
            'title'        => "Laporan Laba Rugi",
        );
        template_view('akunting/filter_lap_laba_rugi', $data);
    }

    public function filter_lap_laba_rugi()
    {
        $bln = $this->input->post('bulan', TRUE);
        $thn = $this->input->post('tahun', TRUE);

        $g_persediaan     = $this->m_akunting->g_persediaan($bln, $thn)->num_rows();
        $pers_awal        = $this->m_akunting->c_pers_awal($bln, $thn, 'jurnal_umum')->num_rows();
        if ($g_persediaan == $pers_awal or $pers_awal == 0) { //mencari apakah sudah melakukan stok persediaan akhir
            $data = array(
                // 'content' => 'Isi Persediaan Awal / Akhir terlebih dahulu',
                'url'      => 'akunting/lap_laba_rugi'
            );
            setMsg('danger', "Isi Persediaan Awal / Akhir terlebih dahulu");
        } else {
            $data = array(
                't_jual'         => $this->m_akunting->get_total_jual_fil($bln, $thn, 'jurnal_umum')->row_array(),
                'pers_awal'        => $this->m_akunting->c_pers_awal($bln, $thn, 'jurnal_umum')->row(),
                't_beli'        => $this->m_akunting->t_beli($bln, $thn, 'jurnal_umum')->row(),
                'pers_akhir'    => $this->m_akunting->g_pers_akhir($bln, $thn)->row_array(),
                'get_labarugi'    => $this->m_akunting->get_all_labarugi_fil($bln, $thn, 'jurnal_umum')->result(),
                'title'        => "Laporan Laba rugi",
            );

            print_r($data);
            die;
            template_view('akunting/lap_laba_rugi', $data);
        }
    }
    public function get_nama_bln($bln)
    {
        $monthNum = $bln;
        $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        return $monthName;
    }

    public function pers_akhir()
    {
        $bln     = date('m', strtotime($this->input->post('tanggal', TRUE)));
        $thn    = date('Y', strtotime($this->input->post('tanggal', TRUE)));
        $tgl     = date('Y-m-d', strtotime($this->input->post('tanggal', TRUE)));

        $c_pers_akhir     = $this->m_akunting->c_pers_akhir($bln, $thn, 'jurnal_umum')->num_rows();
        $pers_awal         = $this->m_akunting->get_persediaan($tgl, date('Y'))->row_array();

        if ($c_pers_akhir == 0) {

            $data = array(
                'tanggal'             => date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan'    => 'Beban Persediaan',
                'debet'                => $pers_awal['debet'] - $this->get_pers_akhir($bln, $thn),
                'kredit'            => 0
            );
            $this->db->insert('jurnal_umum', $data);

            $data = array(
                'tanggal'             => date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
                'nama_perkiraan'    => 'Persediaan Barang',
                'debet'                => 0,
                'kredit'            => $pers_awal['debet'] - $this->get_pers_akhir($bln, $thn),
                'keterangan'        => 'Akhir'
            );
            $this->db->insert('jurnal_umum', $data);

            msgBox('save');
            echo '<meta http-equiv="refresh" content="2;URL=lap_laba_rugi">';
        } else {
            $d = $pers_awal['debet'] - $this->get_pers_akhir($bln, $thn);

            $this->db->set('debet', $d, FALSE);
            $this->db->where('nama_perkiraan', 'Beban Persediaan');
            $this->db->update('jurnal_umum');

            $this->db->set('kredit', $d, FALSE);
            $this->db->where('nama_perkiraan', 'Persediaan Barang');
            $this->db->where('keterangan', 'Akhir');
            $this->db->update('jurnal_umum');

            msgBox('save');
            echo '<meta http-equiv="refresh" content="2;URL=lap_laba_rugi">';
            // $data = array(
            // 	'content' 	=> 'Persediaan Akhir sudah diinput',
            // 	'url'		=> 'akunting/lap_rugi_laba' 
            // 	);
            // $this->load->view('notification/error',$data);
        }
    }

    public function get_pers_akhir($bln, $thn)
    {
        $pers_awal        = $this->m_akunting->c_pers_awal($bln, $thn, 'jurnal_umum')->row_array();
        $t_beli            = $this->m_akunting->t_beli($bln, $thn, 'jurnal_umum')->row_array();
        $t_jual         = $this->m_akunting->get_total_jual_fil($bln, $thn)->row_array();

        $pers_akhir     = $t_jual['total'] - ($pers_awal['debet'] + $t_beli['t_beli']);

        return $pers_akhir;
    }

    public function neraca()
    {
        $data = array(
            'title'        => "NERACA",
        );
        template_view('akunting/neraca', $data);
    }

    public function save_modal()
    {
        $data = array(
            'tanggal'         => date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
            'nama_perkiraan' => 'Kas',
            'debet'             => $this->input->post('kas', TRUE),
            'kredit'         => 0
        );
        $this->db->insert('jurnal_umum', $data);

        $data = array(
            'tanggal'         => date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
            'nama_perkiraan' => 'Inventaris',
            'debet'             => $this->input->post('inventaris', TRUE),
            'kredit'         => 0
        );
        $this->db->insert('jurnal_umum', $data);

        $data = array(
            'tanggal'         => date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
            'nama_perkiraan' => 'Persediaan Barang',
            'debet'             => $this->input->post('persediaan', TRUE),
            'kredit'         => 0
        );
        $this->db->insert('jurnal_umum', $data);

        $data = array(
            'tanggal'         => date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
            'nama_perkiraan' => 'Perlengkapan',
            'debet'             => $this->input->post('perlengkapan', TRUE),
            'kredit'         => 0
        );
        $this->db->insert('jurnal_umum', $data);

        $data = array(
            'tanggal'         => date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
            'nama_perkiraan' => 'Kendaraan',
            'debet'             => $this->input->post('kendaraan', TRUE),
            'kredit'         => 0
        );
        $this->db->insert('jurnal_umum', $data);

        $data = array(
            'tanggal'         => date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
            'nama_perkiraan' => 'Modal Owner',
            'debet'             => 0,
            'kredit'         => str_replace('.', '', $this->input->post('total', TRUE))
        );
        $this->db->insert('jurnal_umum', $data);

        // $this->load->view('notification/success');
        // echo "<meta http-equiv='refresh' content='2;URL=neraca'>";
    }

    public function filter_neraca()
    {
        $bln = $this->input->post('bulan', TRUE);
        $thn = $this->input->post('tahun', TRUE);

        $g_neraca_prev = $this->m_akunting->g_neraca_prev($bln, $thn)->num_rows();
        $g_neraca_now  = $this->m_akunting->g_akt_lancar($bln, $thn, 'jurnal_umum')->num_rows();

        if ($g_neraca_now == 0 and $g_neraca_prev == 0) {
            $data = array(
                // 'content'    => 'Input Persediaan Akhir terlebih dahulu',
                'url'        => 'akunting/neraca'
            );
            setMsg('danger', "Input Persediaan Akhir terlebih dahulu");
        }

        if ($g_neraca_now > 0) {
            $this->tampil_neraca($bln, $thn);
        } elseif ($g_neraca_prev > 0) {

            $bln = $this->input->post('bulan', TRUE) - 1;
            $thn = $this->input->post('tahun', TRUE);

            $this->save_n_saldo($bln, $thn);
        }
    }

    public function tampil_neraca($bln, $thn)
    {
        $data = array(
            'title' => 'Neracaaaa',
            // 'sidebar'        => "Akunting",
            // 'sidebar2'        => "Reference",
            // 'menu'            => "active open",
            'per'                => $this->get_nama_bln($bln) . ' ' . $thn,
            'akt_lancar'    => $this->m_akunting->g_akt_lancar($bln, $thn, 'jurnal_umum')->result(),
            'akt_tetap'     => $this->m_akunting->g_akt_tetap($bln, $thn, 'jurnal_umum')->result(),
            'akm_inv'        => $this->m_akunting->g_akm_inv($bln, $thn, 'jurnal_umum')->row(),
            'akm_kend'        => $this->m_akunting->g_akm_kend($bln, $thn, 'jurnal_umum')->row(),
            'pasiva'            => $this->m_akunting->g_pasiva($bln, $thn, 'jurnal_umum')->result(),
            'g_modal'        => $this->m_akunting->g_modal($bln, $thn, 'jurnal_umum')->row_array(),
            'laba_bersih'     => $this->c_laba_bersih($bln, $thn),
            'prive'            => $this->m_akunting->g_prive($bln, $thn, 'jurnal_umum')->row_array()
        );
        template_view('akunting/filter_neraca', $data);
    }

    public function c_laba_bersih($bln, $thn)
    {
        $t_jual             = $this->m_akunting->get_total_jual_fil($bln, $thn, 'jurnal_umum')->row_array();
        $pers_awal        = $this->m_akunting->c_pers_awal($bln, $thn, 'persediaan')->row_array();
        $t_beli            = $this->m_akunting->t_beli($bln, $thn, 'jurnal_umum')->row_array();
        $pers_akhir        = $this->m_akunting->g_pers_akhir($bln, $thn)->row_array();
        $get_labarugi    = $this->m_akunting->get_all_labarugi_fil($bln, $thn, 'jurnal_umum')->result();

        $t_beban = 0;

        foreach ($get_labarugi as $g) {
            $t_beban += $g->akun;
        }

        $laba_bersih = $t_jual['total'] - ($pers_awal['debet'] + $t_beli['t_beli'] - $pers_akhir['saldo'] + $t_beban);
        return $laba_bersih;
    }

    public function save_n_saldo($bln, $thn)
    {
        $akt_lancar     = $this->m_akunting->g_akt_lancar($bln, $thn, 'jurnal_umum')->result();
        $akt_tetap         = $this->m_akunting->g_akt_tetap($bln, $thn, 'jurnal_umum')->result();
        $akm_inv         = $this->m_akunting->g_akm_inv($bln, $thn, 'jurnal_umum');
        $akm_kend        = $this->m_akunting->g_akm_kend($bln, $thn, 'jurnal_umum');
        $pasiva            = $this->m_akunting->g_pasiva($bln, $thn, 'jurnal_umum');
        $g_modal        = $this->m_akunting->g_modal($bln, $thn, 'jurnal_umum')->row_array();
        $laba_bersih     = $this->c_laba_bersih($bln, $thn);
        $prive            = $this->m_akunting->g_prive($bln, $thn, 'jurnal_umum')->row_array();

        $t_bulan = $bln + 1;
        foreach ($akt_lancar as $ak) { //input auto aktiva lancar
            $data[] = array(
                'tanggal'         => $thn . '-' . $t_bulan . '-01',
                'nama_perkiraan' => $ak->nama_perkiraan,
                'debet'            => $ak->saldo,
                'kredit'        => 0
            );
        }
        $this->db->insert_batch('jurnal_umum', $data);

        foreach ($akt_tetap as $at) { //input auto aktiva tetap
            $s_at[] = array(
                'tanggal'         => $thn . '-' . $t_bulan . '-01',
                'nama_perkiraan' => $at->nama_perkiraan,
                'debet'            => $at->saldo,
                'kredit'        => 0
            );
        }
        $this->db->insert_batch('jurnal_umum', $s_at);

        if ($akm_inv->num_rows() > 0) {
            $ai = $akm_inv->row_array();
            $s_av = array( //input auto akumulasi inventory
                'tanggal'         => $thn . '-' . $t_bulan . '-01',
                'nama_perkiraan' => 'Akum.Peny.Inventaris',
                'debet'            => 0,
                'kredit'        => $ai['kredit']
            );
            $this->db->insert('jurnal_umum', $s_av);
        }

        if ($akm_kend->num_rows() > 0) {
            $ak = $akm_kend->row_array();
            $s_akm = array( //input auto akumulasi kendaraan
                'tanggal'         => $thn . '-' . $t_bulan . '-01',
                'nama_perkiraan' => 'Akum.Peny.Kendaraan',
                'debet'            => 0,
                'kredit'        => $ak['kredit']
            );
            $this->db->insert('jurnal_umum', $s_akm);
        }

        if ($pasiva->num_rows() > 0) {
            foreach ($pasiva->result() as $p) { //pasiva
                $s_pa[] = array(
                    'tanggal'         => $thn . '-' . $t_bulan . '-01',
                    'nama_perkiraan' => $p->nama_perkiraan,
                    'debet'            => 0,
                    'kredit'        => $p->saldo
                );
            }
            $this->db->insert_batch('jurnal_umum', $s_pa);
        }

        $s_modal = array( //input auto modal
            'tanggal'         => $thn . '-' . $t_bulan . '-01',
            'nama_perkiraan' => 'Modal Owner',
            'debet'            => 0,
            'kredit'        => $g_modal['kredit'] + $laba_bersih - $prive['saldo']
        );
        $this->db->insert('jurnal_umum', $s_modal);
        $this->tampil_neraca($t_bulan, $thn);
    }


    // public function laba_rugi_print()
    // {
    //     $this->load->library('Dompdf_gen');

    //     // $id = encode_php_tags($getId);
    //     // $where = ['idKategori' => $id];

    //     // $data['pembelian'] = $this->pembelian->getPembelian($id);
    //     // $data['detail'] = $this->pembelian->getDetailPembelian($id);

    //     $this->load->view('akunting/prinnt_laba_rugi', $data);

    //     $paper_size = 'A4'; // ukuran kertas
    //     $orientation = 'landscape'; //tipe format kertas potrait atau landscape
    //     $html = $this->output->get_output();

    //     $this->dompdf->set_paper($paper_size, $orientation);
    //     //Convert to PDF
    //     $this->dompdf->load_html($html);
    //     $this->dompdf->render();

    //     ob_end_clean();
    //     $this->dompdf->stream("detail_pembelian_" . time() . ".pdf", array('Attachment' => 0));
    // }
}

/* End of file Controllername.php */