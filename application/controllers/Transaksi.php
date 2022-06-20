<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_role(['administrator', 'kepala toko']);

        $this->load->model('MainModel', 'main');
        $this->load->model('TransaksiModel', 'transaksi');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
    }

    public function index()
    {
        $data['title'] = "Transaksi";
        $data['transaksi'] = $this->transaksi->getTransaksi();


        template_view('transaksi/index', $data);
    }

    public function detail($id)
    {
        $data['title'] = "Transaksi";
        $data['idTransaksi'] = $id;
        $data['transaksi'] = $this->transaksi->getTransaksi($id);
        $data['detail'] = $this->transaksi->getDetailTransaksi($id);
        // $data['untung'] = $this->transaksi->getUntung($id);

        template_view('transaksi/detail', $data);
    }

    public function hapus($id)
    {
        $where = ['idTransaksi' => $id];
        $del = $this->main->delete('transaksi', $where);
        if ($del) {
            msgBox('delete');
        } else {
            msgBox('delete', false);
        }
        redirect('transaksi');
    }

    public function add()
    {
        $data['title'] = "Transaksi";
        //$data['pelanggan'] = $this->main->get('pelanggan');
        $idUser = userdata()->idUser;
        $idTransaksi = generate_id("T", "transaksi", "idTransaksi", date('ymd'), 3);

        $data['keranjang'] = $this->transaksi->getKeranjang(['idUser' => $idUser]);
        $data['total_harga'] = $this->transaksi->getTotalKeranjang(['idUser' => $idUser]);
        $data['untung'] = $this->transaksi->getUntung(['idUser' => $idUser]);

        $this->form_validation->set_rules('namaPelanggan', 'Nama Pelanggan', 'required');
        $this->form_validation->set_rules('alamatPelanggan', 'Alamat Pelanggan', 'required');
        $this->form_validation->set_rules('noTelp', 'No Telp', 'required');
        $this->form_validation->set_rules('uangBayar', 'Uang Bayar', 'required|numeric');

        if ($this->form_validation->run() == false) {
            template_view('transaksi/keranjang', $data);
        } else {
            // Data Tabel Transaksi
            // $input = $this->input->post('namaPelanggan');
            // $input = $this->input->post('alamatPelanggan');
            // $input = $this->input->post('noTelp');
            $input = $this->input->post(null, true);
            $input['tanggal'] = date('Y-m-d');
            $input['idUser'] = $idUser;
            $input['idTransaksi'] = $idTransaksi;
            $input['kembalian'] = $input['uangBayar'] - $data['total_harga'];


            // Data Detail Transaksi
            $data_detail = [];
            $i = 0;

            foreach ($data['keranjang'] as $k) {
                $data_detail[$i]['idTransaksi'] = $idTransaksi;
                $data_detail[$i]['kdBarang']    = $k->kdBarang;
                $data_detail[$i]['qty']         = $k->qty;
                $data_detail[$i]['subtotal']    = $k->harga * $k->qty;
                $data_detail[$i]['untung']    = ($k->harga - $k->hargaBeli) * $k->qty;
                $i++;
            }

            if ($input['uangBayar'] >= $data['total_harga']) {
                // Simpan transaksi
                $this->main->insert('transaksi', $input);
                // Simpan detail transaksi
                $this->main->insert_batch('transaksi_detail', $data_detail);
                // bersihkan keranjang
                $this->main->delete('keranjang', ['idUser' => $idUser]);
                $this->save_ju();

                msgBox('save');
                redirect('transaksi/detail/' . $idTransaksi);
            } else {
                setMsg('danger', 'Uang bayar tidak cukup.');
                redirect('transaksi/add');
            }
        }
    }

    public function add_item()
    {
        $data['title'] = "Transaksi";
        $idUser = userdata()->idUser;

        $data['barang'] = $this->transaksi->getBarang();

        $this->form_validation->set_rules('kdBarang', 'Kode Barang', 'required|trim');
        $this->form_validation->set_rules('qty', 'Jumlah Beli', 'required|numeric');

        if ($this->form_validation->run() == false) {
            template_view('transaksi/add_item', $data);
        } else {
            $input = $this->input->post(null, true);
            $input['noItem'] = time();
            $input['idUser'] = $idUser;

            // Cek stok
            $stok = $this->main->get_where('barang', ['kdBarang' => $input['kdBarang']])->stok;
            if ($stok >= $input['qty']) {
                $cekItem = $this->transaksi->cekItem(['idUser' => $idUser, 'kdBarang' => $input['kdBarang']]);

                if ($cekItem > 0) {
                    $this->transaksi->updateQtyKeranjang($input['qty'], ['idUser' => $idUser, 'kdBarang' => $input['kdBarang']]);
                    // redirect('transaksi/add');
                } else {
                    $this->main->insert('keranjang', $input);
                    redirect('transaksi/add');
                }
            } else {
                setMsg('danger', "Maaf stok yang tersedia hanya {$stok}");
                template_view('transaksi/add_item', $data);
            }
        }
    }

    public function delete_item($noItem)
    {
        $input = $this->db->get_where('keranjang', ['noItem' => encode_php_tags($noItem)])->result_array();
        // $kdbrg = $this->db->get_where('keranjang')
        $data = [
            'noItem' => $input[0]['noItem'],
            'kdBarang' => $input[0]['kdBarang'],
            'idUser' => $input[0]['idUser'],
            'qty' => $input[0]['qty'],
        ];
        // echo '<pre>';
        // print_r($data);
        // die;
        // echo '</pre>';
        $true = $this->db->insert('keranjang_reset', $data);
        if ($true) {
            $this->db->where('noItem', $input[0]['noItem']);
            $true1 =  $this->db->delete('keranjang');
            if ($true1) {
                $this->db->where('noItem', $input[0]['noItem']);
                $this->db->delete('keranjang_reset');
            } else {
                redirect('transaksi/add');
            }
            redirect('transaksi/add');
        } else {
            redirect('transaksi/add');
        }

        // $id = encode_php_tags($noItem);
        // $this->main->delete('keranjang', ['noItem' => $id]);
    }

    public function cetak_detail($getId)
    {
        $this->load->library('Dompdf_gen');

        $id = encode_php_tags($getId);
        $where = ['idKategori' => $id];

        $data['transaksi'] = $this->transaksi->getTransaksi($id);
        $data['detail'] = $this->transaksi->getDetailTransaksi($id);

        $this->load->view('transaksi/cetak_detail', $data);

        $paper_size = 'A4'; // ukuran kertas
        $orientation = 'landscape'; //tipe format kertas potrait atau landscape
        $html = $this->output->get_output();

        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();

        ob_end_clean();
        $this->dompdf->stream("detail_transaksi_" . time() . ".pdf", array('Attachment' => 0));
    }

    // public function cetak_transaksi($tgl1, $tgl2)
    // {
    //     $this->load->library('Dompdf_gen');

    //     $data['tanggal'] = indo_date($tgl1) . " s/d " . indo_date($tgl2);
    //     $data['transaksi'] = $this->transaksi->getLaporanTransaksi($tgl1, $tgl2);
    //     $data['jumlah'] = count((array) $data['transaksi']);
    //     $data['total'] = $this->transaksi->getTotalTransaksi(null, [$tgl1, $tgl2]);
    //     $this->load->view('laporan/laporan_transaksi', $data);

    //     $paper_size = 'A4'; // ukuran kertas
    //     $orientation = 'landscape'; //tipe format kertas potrait atau landscape
    //     $html = $this->output->get_output();

    //     $this->dompdf->set_paper($paper_size, $orientation);
    //     //Convert to PDF
    //     $this->dompdf->load_html($html);
    //     $this->dompdf->render();

    //     ob_end_clean();
    //     $this->dompdf->stream("laporan_transaksi_" . time() . ".pdf", array('Attachment' => 0));
    // }

    public function del_pers_akhir()
    {
        $this->transaksi->del_pers_akhir();
    }

    public function save_ju()
    {
        //hapus PERSEDIAAN AKHIR jika sudah terinput
        $this->del_pers_akhir();

        $where    = date('Y-m-d');
        $cek     = $this->transaksi->cek_ju($where, 'jurnal_umum')->num_rows();
        if ($cek == 0) {
            $ju     = array(
                'tanggal'         =>    date('Y-m-d'),
                'nama_perkiraan' =>     'Kas',
                'debet'         =>    str_replace('.', '', $this->input->post('totalHarga', TRUE)),
                'kredit'        =>    0,
                'keterangan'     =>     'Penjualan'
            );
            $this->db->insert('jurnal_umum', $ju);

            $ju = array(
                'tanggal'         =>    date('Y-m-d'),
                'nama_perkiraan' =>     'Penjualan',
                'kredit'         =>    str_replace('.', '', $this->input->post('totalHarga', TRUE)),
                'debet'            =>    0,
            );
            $this->db->insert('jurnal_umum', $ju);
        } else {
            //UPDATE FOR KAS DEBET
            $where = array(
                'keterangan'     => 'Penjualan',
                'nama_perkiraan' => 'Kas'
            );
            $this->db->set('debet', 'debet+' . str_replace('.', '', $this->input->post('totalHarga', TRUE)), FALSE);
            $this->db->where($where);
            $this->db->update('jurnal_umum');

            //UPDATE FOR PENJUALAN KREDIT
            $this->db->set('kredit', 'kredit+' . str_replace('.', '', $this->input->post('totalHarga', TRUE)), FALSE);
            $this->db->where('nama_perkiraan', 'Penjualan');
            $this->db->update('jurnal_umum');
        }
    }
}
