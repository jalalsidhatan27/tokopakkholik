<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
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
        $data['title'] = "Supplier";
        $data['supplier'] = $this->main->get('supplier');

        template_view('supplier/index', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('namaSupplier', 'Nama Supplier', 'required|trim');
    }

    public function add()
    {
        $data['title'] = "Supplier";

        $this->_validasi();
        if ($this->form_validation->run() == false) {
            template_view('supplier/add', $data);
        } else {
            $input = $this->input->post(null, true);

            $save = $this->main->insert('supplier', $input);
            if ($save) {
                msgBox('save');
                redirect('supplier');
            } else {
                msgBox('save', false);
                redirect('supplier/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $where = ['idSupplier' => $id];

        $data['title'] = 'Supplier';
        $data['supplier'] = $this->main->get_where('supplier', $where);

        $this->_validasi();
        if ($this->form_validation->run() == false) {
            template_view('supplier/edit', $data);
        } else {
            $input = $this->input->post(null, true);

            $edit = $this->main->update('supplier', $input, $where);
            if ($edit) {
                msgBox('edit');
                redirect('supplier');
            } else {
                msgBox('edit', false);
                redirect('supplier/edit/' . $id);
            }
        }
    }

    public function hapus($getId)
    {
        $id = encode_php_tags($getId);
        $where = ['idSupplier' => $id];

        $del = $this->main->delete('supplier', $where);
        if ($del) {
            msgBox('delete');
            redirect('supplier');
        } else {
            msgBox('delete', false);
            redirect('supplier/add');
        }


        redirect('supplier');
    }
}