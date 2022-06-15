<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PembelianModel extends CI_Model
{

    public function getKeranjangB($where)
    {
        $this->db->select('kb.noItem, b.kdBarang, b.namaBarang, b.hargaBeli, kb.qty');
        $this->db->join('barang b', 'kb.kdBarang=b.kdBarang');
        return $this->db->get_where('keranjangb kb', $where)->result();
    }

    public function getBarang()
    {
        $this->db->join('kategori k', 'k.idKategori=b.idKategori');
        return $this->db->get('barang b')->result();
    }

    public function cekItem($where)
    {
        return $this->db->get_where('keranjangb', $where)->num_rows();
    }

    public function updateQtyKeranjangB($qty = 0, $where)
    {
        $getQty = $this->db->get_where('keranjangb', $where)->row()->qty;
        $result = (int) $getQty + (int) $qty;

        return $this->db->update('keranjangb', ['qty' => $result], $where);
    }

    public function getTotalKeranjangB($where)
    {
        $this->db->join('barang b', 'b.kdBarang=kb.kdBarang');
        $keranjangb = $this->db->get_where('keranjangb kb', $where)->result();

        $subtotal = [];
        foreach ($keranjangb as $kb) {
            $subtotal[] = $kb->qty * $kb->hargaBeli;
        }

        return array_sum($subtotal);
    }

    public function getPembelian($id = null)
    {
        if ($id == null) {
            return $this->db->get('pembelian')->result();
        } else {
            $this->db->join('user u', 'u.idUser=p.idUser');
            return $this->db->get_where('pembelian p', ['idPembelian' => $id])->row();
        }
    }

    public function getDetailPembelian($id)
    {

        $this->db->select("b.namaBarang, td.qty, td.subtotal, (td.subtotal/td.qty) as hargaBeli");
        $this->db->join('barang b', 'b.kdBarang=td.kdBarang');
        $this->db->where('idPembelian', $id);
        return $this->db->get('pembelian_detail td')->result();
    }

    public function getLaporanPembelian($tgl1, $tgl2)
    {
        $this->db->join('user u', 'u.idUser=p.idUser');
        if ($tgl1 != null && $tgl2 != null) {
            $this->db->where('tanggal' . ' >=', $tgl1);
            $this->db->where('tanggal' . ' <=', $tgl2);
        }
        return $this->db->get('pembelian p')->result();
    }

    public function getTotalPembelian($bln = null, $custom = [])
    {
        if ($bln != null) {
            $this->db->like('tanggal', $bln, 'after');
        }
        if ($custom != null) {
            $this->db->where('tanggal' . ' >=', $custom[0]);
            $this->db->where('tanggal' . ' <=', $custom[1]);
        }
        $this->db->select_sum('totalHargaBeli', 'totalPembelian');
        return $this->db->get('pembelian')->row()->totalPembelian;
    }

    public function chartPembelian($date = null)
    {
        if ($date != null) {
            $this->db->like('tanggal', $date, 'after');
        }
        $this->db->select_sum('totalHargaBeli', 'totalPembelian');
        return $this->db->get('pembelian')->row()->totalPembelian;
    }


    function cek_ju($where)
    {
        $this->db->select('*');
        $this->db->from('jurnal_umum');
        $this->db->where('tanggal', $where);
        $this->db->where('nama_perkiraan', 'Pembelian');
        $this->db->where('keterangan', 'Tunai');
        $query = $this->db->get();
        return $query;
    }
}