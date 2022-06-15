<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransaksiModel extends CI_Model
{

    public function getKeranjang($where)
    {
        $this->db->select('k.noItem, b.kdBarang, b.namaBarang, b.harga, k.qty, b.hargaBeli');
        $this->db->join('barang b', 'k.kdBarang=b.kdBarang');
        return $this->db->get_where('keranjang k', $where)->result();
    }

    public function getBarang()
    {
        $this->db->join('kategori k', 'k.idKategori=b.idKategori');
        return $this->db->get('barang b')->result();
    }

    public function cekItem($where)
    {
        return $this->db->get_where('keranjang', $where)->num_rows();
    }

    public function updateQtyKeranjang($qty = 0, $where)
    {
        $getQty = $this->db->get_where('keranjang', $where)->row()->qty;
        $result = (int) $getQty + (int) $qty;

        return $this->db->update('keranjang', ['qty' => $result], $where);
    }

    public function getTotalKeranjang($where)
    {
        $this->db->join('barang b', 'b.kdBarang=k.kdBarang');
        $keranjang = $this->db->get_where('keranjang k', $where)->result();

        $subtotal = [];
        foreach ($keranjang as $k) {
            $subtotal[] = $k->qty * $k->harga;
        }

        return array_sum($subtotal);
    }
    public function getUntung($where)
    {
        $this->db->join('barang b', 'b.kdBarang=k.kdBarang');
        $keranjang = $this->db->get_where('keranjang k', $where)->result();

        $subtotaluntung = [];
        foreach ($keranjang as $k) {
            $subtotaluntung[] = ($k->harga - $k->hargaBeli) * $k->qty;
        }

        return array_sum($subtotaluntung);
    }

    public function getTransaksi($id = null)
    {
        if ($id == null) {
            return $this->db->get('transaksi')->result();
        } else {
            $this->db->join('user u', 'u.idUser=t.idUser');
            return $this->db->get_where('transaksi t', ['idTransaksi' => $id])->row();
        }
    }

    // public function getTotalHarga($id)
    // {
    //     $this->db->select("sum(harga*qty) as total");
    //     $this->db->join('barang b', 'b.kdBarang=td.kdBarang');
    //     $this->db->where('idTransaksi', $id);
    //     return $this->db->get('transaksi_detail td')->row()->total;
    // }

    public function getDetailTransaksi($id)
    {
        // $this->db->select("namaBarang, harga, qty, (harga*qty) as subtotal");
        // $this->db->join('barang b', 'b.kdBarang=td.kdBarang');
        // $this->db->where('idTransaksi', $id);
        // return $this->db->get('transaksi_detail td')->result();

        $this->db->select("b.namaBarang, td.qty, td.untung,td.subtotal, (td.subtotal/td.qty) as harga");
        $this->db->join('barang b', 'b.kdBarang=td.kdBarang');
        $this->db->where('idTransaksi', $id);
        return $this->db->get('transaksi_detail td')->result();
    }

    public function getLaporanTransaksi($tgl1, $tgl2)
    {
        $this->db->join('user u', 'u.idUser=t.idUser');
        if ($tgl1 != null && $tgl2 != null) {
            $this->db->where('tanggal' . ' >=', $tgl1);
            $this->db->where('tanggal' . ' <=', $tgl2);
        }
        return $this->db->get('transaksi t')->result();
    }

    public function getTotalTransaksi($bln = null, $custom = [])
    {
        if ($bln != null) {
            $this->db->like('tanggal', $bln, 'after');
        }
        if ($custom != null) {
            $this->db->where('tanggal' . ' >=', $custom[0]);
            $this->db->where('tanggal' . ' <=', $custom[1]);
        }
        $this->db->select_sum('totalHarga', 'totalTransaksi');
        return $this->db->get('transaksi')->row()->totalTransaksi;
    }

    public function getTotalUntung($bln = null, $custom = [])
    {
        if ($bln != null) {
            $this->db->like('tanggal', $bln, 'after');
        }
        if ($custom != null) {
            $this->db->where('tanggal' . ' >=', $custom[0]);
            $this->db->where('tanggal' . ' <=', $custom[1]);
        }
        $this->db->select_sum('untung', 'totalUntung');
        return $this->db->get('transaksi')->row()->totalUntung;
    }

    public function chartTransaksi($date = null)
    {
        if ($date != null) {
            $this->db->like('tanggal', $date, 'after');
        }
        $this->db->select_sum('totalHarga', 'totalTransaksi');
        return $this->db->get('transaksi')->row()->totalTransaksi;
    }
    public function chartUntung($date = null)
    {
        if ($date != null) {
            $this->db->like('tanggal', $date, 'after');
        }
        $this->db->select_sum('untung', 'totalUntung');
        return $this->db->get('transaksi')->row()->totalUntung;
    }




    function del_pers_akhir()
    {
        $this->db
            ->where('date_format(tanggal,"%m")', date('m'))
            ->where('date_format(tanggal,"%Y")', date('Y'))
            ->where('nama_perkiraan', 'Persediaan Barang')
            ->where('keterangan', 'Akhir');
        $this->db->delete('jurnal_umum');

        $this->db
            ->where('date_format(tanggal,"%m")', date('m'))
            ->where('date_format(tanggal,"%Y")', date('Y'))
            ->where('nama_perkiraan', 'Beban Persediaan');
        $this->db->delete('jurnal_umum');
    }

    function cek_ju($where)
    {
        $this->db->select('*');
        $this->db->from('jurnal_umum');
        $this->db->where('tanggal', $where);
        $this->db->where('nama_perkiraan', 'Penjualan');
        $query = $this->db->get();
        return $query;
    }
}