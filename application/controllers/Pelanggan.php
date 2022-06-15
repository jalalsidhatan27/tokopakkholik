<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_role(['administrator', 'kepala toko']);
        $this->load->model('MainModel', 'main');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
    }

    public function index()
    {
        $data['title'] = "Pelanggan";
        $data['pelanggan'] = $this->main->get('pelanggan');

        template_view('pelanggan/index', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('namaPelanggan', 'Nama Pelanggan', 'required|trim');
    }

    public function add()
    {
        $data['title'] = "Pelanggan";

        $this->_validasi();
        if ($this->form_validation->run() == false) {
            template_view('pelanggan/add', $data);
        } else {
            $input = $this->input->post(null, true);

            $save = $this->main->insert('pelanggan', $input);
            if ($save) {
                msgBox('save');
                redirect('pelanggan');
            } else {
                msgBox('save', false);
                redirect('pelanggan/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $where = ['idPelanggan' => $id];

        $data['title'] = 'Pelanggan';
        $data['pelanggan'] = $this->main->get_where('pelanggan', $where);

        $this->_validasi();
        if ($this->form_validation->run() == false) {
            template_view('pelanggan/edit', $data);
        } else {
            $input = $this->input->post(null, true);

            $edit = $this->main->update('pelanggan', $input, $where);
            if ($edit) {
                msgBox('edit');
                redirect('pelanggan');
            } else {
                msgBox('edit', false);
                redirect('pelanggan/edit/' . $id);
            }
        }
    }

    public function hapus($getId)
    {
        $id = encode_php_tags($getId);
        $where = ['idPelanggan' => $id];

        $del = $this->main->delete('pelanggan', $where);
        if ($del) {
            msgBox('delete');
            redirect('pelanggan');
        } else {
            msgBox('delete', false);
            redirect('pelanggan/add');
        }


        redirect('pelanggan');
    }
}