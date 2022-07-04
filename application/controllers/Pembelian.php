<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_role(['kepala toko']);

        $this->load->model('MainModel', 'main');
        $this->load->model('PembelianModel', 'pembelian');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
    }

    public function index()
    {
        $data['title'] = "Pembelian";
        $data['pembelian'] = $this->pembelian->getPembelian();

        template_view('pembelian/index', $data);
    }

    public function detail($id)
    {
        $data['title'] = "Pembelian";
        $data['idPembelian'] = $id;
        $data['pembelian'] = $this->pembelian->getPembelian($id);
        $data['detail'] = $this->pembelian->getDetailPembelian($id);

        template_view('pembelian/detail', $data);
    }

    public function hapus($id)
    {
        $where = ['idPembelian' => $id];
        $del = $this->main->delete('pembelian', $where);
        if ($del) {
            msgBox('delete');
        } else {
            msgBox('delete', false);
        }
        redirect('pembelian');
    }

    public function add()
    {
        $data['title'] = "Pembelian";
        //$data['pelanggan'] = $this->main->get('pelanggan');
        $idUser = userdata()->idUser;
        $idPembelian = generate_id("P", "pembelian", "idPembelian", date('ymd'), 3);

        $data['keranjangb'] = $this->pembelian->getKeranjangB(['idUser' => $idUser]);
        $data['total_harga_beli'] = $this->pembelian->getTotalKeranjangB(['idUser' => $idUser]);

        // $this->form_validation->set_rules('namaPelanggan', 'Nama Pelanggan', 'required');
        // $this->form_validation->set_rules('alamatPelanggan', 'Alamat Pelanggan', 'required');
        // $this->form_validation->set_rules('noTelp', 'No Telp', 'required');
        // $this->form_validation->set_rules('uangBayar', 'Uang Bayar', 'required|numeric');
        $this->form_validation->set_rules('konfirmasi', 'Konfirmasi', 'required');

        if ($this->form_validation->run() == false) {
            template_view('pembelian/keranjang', $data);
        } else {
            // Data Tabel Pembelian
            // $input = $this->input->post('namaPelanggan');
            // $input = $this->input->post('alamatPelanggan');
            // $input = $this->input->post('noTelp');
            $input = $this->input->post(null, true);
            $input['tanggal'] = date('Y-m-d');
            $input['idUser'] = $idUser;
            $input['idPembelian'] = $idPembelian;
            // $input['kembalian'] = $input['uangBayar'] - $data['total_harga_beli'];

            // Data Detail Pembelian
            $data_detail = [];
            $i = 0;
            foreach ($data['keranjangb'] as $kb) {
                $data_detail[$i]['idPembelian'] = $idPembelian;
                $data_detail[$i]['kdBarang']    = $kb->kdBarang;
                $data_detail[$i]['qty']         = $kb->qty;
                $data_detail[$i]['subtotal']    = $kb->hargaBeli * $kb->qty;
                // save to jurnal umum
                $this->save_ju_tunai($kb->hargaBeli * $kb->qty);
                $i++;
            }

            // if ($input['uangBayar'] >= $data['total_harga_beli']) {
            // Simpan transaksi
            $this->main->insert('pembelian', $input);
            // Simpan detail transaksi
            $this->main->insert_batch('pembelian_detail', $data_detail);
            // bersihkan keranjang b
            $this->main->delete('keranjangb', ['idUser' => $idUser]);


            msgBox('save');
            redirect('pembelian/detail/' . $idPembelian);
            // } else {
            //     setMsg('danger', 'Uang bayar tidak cukup.');
            //     redirect('pembelian/add');
            // }
        }
    }

    public function add_item()
    {
        $data['title'] = "Pembelian";
        $idUser = userdata()->idUser;

        $data['barang'] = $this->pembelian->getBarang();

        $this->form_validation->set_rules('kdBarang', 'Kode Barang', 'required|trim');
        $this->form_validation->set_rules('qty', 'Jumlah Beli', 'required|numeric');

        if ($this->form_validation->run() == false) {
            template_view('pembelian/add_item', $data);
        } else {
            $input = $this->input->post(null, true);
            $input['noItem'] = time();
            $input['idUser'] = $idUser;

            // Cek stok
            $stok = $this->main->get_where('barang', ['kdBarang' => $input['kdBarang']])->stok;
            if ($input['qty'] > 0) {
                $cekItem = $this->pembelian->cekItem(['idUser' => $idUser, 'kdBarang' => $input['kdBarang']]);

                if ($cekItem > 0) {
                    // $this->pembelian->updateQtyKeranjangB($input['qty'], ['idUser' => $idUser, 'kdBarang' => $input['kdBarang']]);
                    $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
                    Data ini sudah dikeranjang, mohon lakukan update jika ada perubahan, atau hapus !
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                    redirect('pembelian/add');
                } else {
                    $this->main->insert('keranjangb', $input);
                    redirect('pembelian/add');
                }
            } else {
                setMsg('danger', "Inputan stok tidak boleh kosong");
                template_view('pembelian/add_item', $data);
            }
        }
    }

    public function delete_item($noItem)
    {
        $input = $this->db->get_where('keranjangb', ['noItem' => encode_php_tags($noItem)])->result_array();
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
        $true = $this->db->insert('keranjangb_reset', $data);
        if ($true) {
            $this->db->where('noItem', $input[0]['noItem']);
            $true1 =  $this->db->delete('keranjangb');
            if ($true1) {
                $this->db->where('noItem', $input[0]['noItem']);
                $this->db->delete('keranjangb_reset');
            } else {
                redirect('pembelian/add');
            }
            redirect('pembelian/add');
        } else {
            redirect('pembelian/add');
        }

        // $id = encode_php_tags($noItem);
        // $this->main->delete('keranjangb', ['noItem' => $id]);
    }

    public function cetak_detail($getId)
    {
        $this->load->library('Dompdf_gen');

        $id = encode_php_tags($getId);
        $where = ['idKategori' => $id];

        $data['pembelian'] = $this->pembelian->getPembelian($id);
        $data['detail'] = $this->pembelian->getDetailPembelian($id);

        $this->load->view('pembelian/cetak_detail', $data);

        $paper_size = 'A4'; // ukuran kertas
        $orientation = 'landscape'; //tipe format kertas potrait atau landscape
        $html = $this->output->get_output();

        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();

        ob_end_clean();
        $this->dompdf->stream("detail_pembelian_" . time() . ".pdf", array('Attachment' => 0));
    }


    public function save_ju_tunai($get_total = 0)
    {
        // $where    = date('Y-m-d');
        $where    = date('Y-m-d');
        // $cek     = $this->pembelian->cek_ju($where, 'jurnal_umum')->num_rows();
        // if ($cek == 0) {
        $ju     = array(
            'tanggal'         =>    date('Y-m-d'),
            'nama_perkiraan' =>     'Pembelian',
            'debet'         =>    $get_total,
            'kredit'        =>    0,
            'keterangan'    => 'Tunai'
        );
        $this->db->insert('jurnal_umum', $ju);

        $ju = array(
            'tanggal'         =>    date('Y-m-d'),
            'nama_perkiraan' =>     'Kas',
            'kredit'         =>    $get_total,
            'debet'            =>    0,
            'keterangan'     =>     'Pembelian'
        );
        $this->db->insert('jurnal_umum', $ju);
        // }
        // else {
        //     //UPDATE FOR KAS KREDIT
        //     $where = array(
        //         'keterangan'     => 'Pembelian',
        //         'nama_perkiraan' => 'Kas'
        //     );
        //     $this->db->set('kredit', 'kredit+' . $this->get_total(), FALSE);
        //     $this->db->where($where);
        //     $this->db->update('jurnal_umum');

        //     //UPDATE FOR PEMBELIAN DEBET
        //     $this->db->set('debet', 'debet+' . $this->get_total(), FALSE);
        //     $this->db->where('nama_perkiraan', 'Pembelian');
        //     $this->db->where('keterangan', 'Tunai');
        //     $this->db->update('jurnal_umum');
        // }
    }

    public function get_total()
    {
        $this->db->select('totalHargaBeli');
        $this->db->from('pembelian');
        $query = $this->db->get();
        return $query->row()->totalHargaBeli;
    }








    public function update_jumbel()
    {
        $noItem = $this->input->post('noItem');
        $kdBarang = $this->input->post('kdBarang');
        $jum1 = $this->input->post('jum1');
        $jum2 = $this->input->post('jum2');

        $this->form_validation->set_rules('jum2', 'Jumlah Beli', 'required|numeric');

        $data['title'] = "Pembelian";
        $idUser = userdata()->idUser;
        $data['keranjangb'] = $this->pembelian->getKeranjangB(['idUser' => $idUser]);
        $data['total_harga_beli'] = $this->pembelian->getTotalKeranjangB(['idUser' => $idUser]);


        if ($this->form_validation->run() == false) {
            template_view('pembelian/keranjang', $data);
        } else {
            if ($jum1 > $jum2) {
                $res = $jum1 - $jum2;
                // echo '<pre>';
                // print_r($res . ' ini ke 1');
                // die;
                // echo '<pre>';
                $data_k = [
                    'qty' => $jum2,
                ];
                $data_res = [
                    'noItem' => $noItem,
                    'kdBarang' => $kdBarang,
                    'idUser' => $idUser,
                    'qty' => $res,
                ];
                $this->db->where('noItem', $noItem);
                $true = $this->db->update('keranjangb', $data_k);
                if ($true) {
                    $true1 = $this->db->insert('beli_update_plus', $data_res);
                    if ($true1) {
                        $this->db->where('noItem', $noItem);
                        $true2 = $this->db->delete('beli_update_plus');
                        if ($true2) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                            Jumlah Beli sukses diperbarui
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>');
                            redirect('pembelian/add');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                            Gagal delete di update plus
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>');
                            redirect('pembelian/add');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Gagal masuk di Update Plus
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>');
                        redirect('pembelian/add');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Gagal terupdate dikeranjang
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                    redirect('pembelian/add');
                }
            } elseif ($jum1 < $jum2) {
                $res = ($jum1 - $jum2) * -1;
                // echo '<pre>';
                // print_r($res . ' ini ke 2');
                // die;
                // echo '<pre>';
                $data_k = [
                    'qty' => $jum2,
                ];
                $data_res = [
                    'noItem' => $noItem,
                    'kdBarang' => $kdBarang,
                    'idUser' => $idUser,
                    'qty' => $res,
                ];
                $this->db->where('noItem', $noItem);
                $true = $this->db->update('keranjangb', $data_k);
                if ($true) {
                    $true1 = $this->db->insert('beli_update_minus', $data_res);
                    if ($true1) {
                        $this->db->where('noItem', $noItem);
                        $true2 = $this->db->delete('beli_update_minus');
                        if ($true2) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                            Jumlah Beli sukses diperbarui
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>');
                            redirect('pembelian/add');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                            Gagal delete di update plus
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>');
                            redirect('pembelian/add');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        Gagal masuk di Update Plus
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>');
                        redirect('pembelian/add');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Gagal terupdate dikeranjang
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                    redirect('pembelian/add');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
                Tidak ada perubahan Jumlah Beli
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
                redirect('pembelian/add');
            }
        }
    }
}
