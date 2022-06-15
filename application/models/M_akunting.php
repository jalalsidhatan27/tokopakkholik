<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_akunting extends CI_Model
{
	function tampil_ref()
	{
		$this->db->select('*');
		$this->db->from('reference');
		$this->db->where('posisi', 'Rugi-Laba');
		$this->db->or_where('posisi', 'Aktiva Lancar');
		$this->db->or_where('posisi', 'Aktiva Tetap');
		$this->db->or_where('posisi', 'Pasiva');
		$this->db->or_where('posisi', 'Modal');
		$this->db->or_where('posisi', '');
		$this->db->order_by('no_ref', 'ASC');
		return $this->db->get();
	}

	function tampil_ju()
	{
		$this->db->select('*');
		$this->db->from('jurnal_umum');
		$this->db->where('date_format(tanggal,"%m")', date('m'));
		$this->db->where('date_format(tanggal,"%Y")', date('Y'));
		$this->db->order_by('no', 'ASC');
		return $this->db->get();
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

	function get_total_d()
	{
		$this->db->select_sum('debet');
		$this->db->from('jurnal_umum');
		$this->db->where('date_format(tanggal,"%m")', date('m'));
		return $this->db->get();
	}

	function get_total_k()
	{
		$this->db->select_sum('kredit');
		$this->db->from('jurnal_umum');
		$this->db->where('date_format(tanggal,"%m")', date('m'));
		return $this->db->get();
	}

	function get_data_id1($id_1)
	{
		$this->db->select('debet,kredit');
		$this->db->from('jurnal_umum');
		$this->db->where('no', $id_1);
		return $this->db->get();
	}

	function get_data_id2($id_2)
	{
		$this->db->select('debet,kredit');
		$this->db->from('jurnal_umum');
		$this->db->where('no', $id_2);
		return $this->db->get();
	}


	function get_bukubesar($akun)
	{
		$this->db->select('*');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', $akun);
		$this->db->where('date_format(tanggal,"%m")', date('m'));
		$this->db->where('date_format(tanggal,"%Y")', date('Y'));
		return $this->db->get();
	}

	function get_ref_bukbes()
	{
		$this->db->select('distinct(nama_perkiraan)');
		$this->db->from('jurnal_umum');
		$this->db->where('date_format(tanggal,"%m")', date('m'));
		$this->db->where('date_format(tanggal,"%Y")', date('Y'));
		return $this->db->get();
	}

	function t_neraca_coba()
	{ //t=tabel
		$this->db->select('nama_perkiraan,sum(debet-kredit) as saldo');
		$this->db->from('jurnal_umum');
		$this->db->group_by('nama_perkiraan');
		return $this->db->get();
	}


	function get_total_jual_fil($bln, $thn)
	{
		$this->db->select("sum(case when nama_perkiraan='Penjualan' THEN kredit ELSE 0 END) as total");
		$this->db->from('jurnal_umum');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		$query = $this->db->get();
		return $query;
	}

	function get_all_labarugi_fil($bln, $thn)
	{
		$this->db->select('jurnal_umum.nama_perkiraan,sum(debet-kredit) as akun');
		$this->db->from('jurnal_umum');
		$this->db->join('reference', 'jurnal_umum.nama_perkiraan = reference.nama_perkiraan');
		$this->db->where('posisi', 'Rugi-Laba');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		$this->db->group_by('jurnal_umum.nama_perkiraan');
		return $this->db->get();
	}

	function g_persediaan($bln, $thn)
	{ //get
		$this->db->select('debet,kredit');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', 'Persediaan Barang');
		$this->db->or_where('nama_perkiraan', 'Beban Persediaan');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		$query = $this->db->get();
		return $query;
	}

	function c_pers_awal($bln, $thn)
	{
		$this->db->select('debet');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', 'Persediaan Barang');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		return $this->db->get();
	}

	function get_persediaan($bln, $thn)
	{
		$this->db->select('debet');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', 'Persediaan Barang');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		return $this->db->get();
	}


	function g_pers_akhir($bln, $thn)
	{
		$this->db->select('sum(debet - kredit) as saldo');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', 'Persediaan Barang');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);

		return $this->db->get();
	}


	function c_pers_akhir($bln, $thn)
	{ //colom?
		$this->db->select('nama_perkiraan');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', 'Beban Persediaan');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);

		return $this->db->get();
	}


	function t_beli($bln, $thn)
	{
		$this->db->select("sum(case when nama_perkiraan='Pembelian' THEN debet ELSE 0 END) as t_beli");
		$this->db->from('jurnal_umum');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		return $this->db->get();
	}


	function g_akt_lancar($bln, $thn)
	{
		$this->db->select('jurnal_umum.nama_perkiraan,sum(debet-kredit) as saldo');
		$this->db->from('jurnal_umum');
		$this->db->join('reference', 'jurnal_umum.nama_perkiraan = reference.nama_perkiraan');
		$this->db->where('reference.posisi', 'Aktiva Lancar');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		$this->db->group_by('reference.nama_perkiraan');
		return $this->db->get();
	}


	function g_akt_tetap($bln, $thn)
	{
		$this->db->select('jurnal_umum.nama_perkiraan,sum(debet-kredit) as saldo');
		$this->db->from('jurnal_umum');
		$this->db->join('reference', 'jurnal_umum.nama_perkiraan = reference.nama_perkiraan');
		$this->db->where('reference.posisi', 'Aktiva Tetap');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		$this->db->group_by('reference.nama_perkiraan');
		return $this->db->get();
	}


	function g_akm_inv($bln, $thn)
	{
		$this->db->select('COALESCE(SUM(kredit), 0) as kredit');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', 'Akum.Peny.Inventaris');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		return $this->db->get();
	}


	function g_akm_kend($bln, $thn)
	{
		$this->db->select('COALESCE(SUM(kredit), 0) as kredit');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', 'Akum.Peny.Kendaraan');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		return $this->db->get();
	}


	function g_modal($bln, $thn)
	{
		$this->db->select('kredit');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', 'Modal Owner');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		return $this->db->get();
	}

	function g_pasiva($bln, $thn)
	{
		$this->db->select('jurnal_umum.nama_perkiraan,sum(kredit-debet) as saldo');
		$this->db->from('jurnal_umum');
		$this->db->join('reference', 'jurnal_umum.nama_perkiraan = reference.nama_perkiraan');
		$this->db->where('reference.posisi', 'Pasiva');
		$this->db->where('date_format(tanggal,"%m")', $bln);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		$this->db->group_by('reference.nama_perkiraan');
		return $this->db->get();
	}


	function total_beli($bln, $thn)
	{
		$this->db->select('debet');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', 'Pembelian');
		$this->db->where('date_format(tanggal,"%m")', date('m'));
		$this->db->where('date_format(tanggal,"%Y")', date('Y'));
		return $this->db->get();
	}

	function total_jual($bln, $thn)
	{
		$this->db->select('kredit');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', 'Penjualan');
		$this->db->where('date_format(tanggal,"%m")', date('m'));
		$this->db->where('date_format(tanggal,"%Y")', date('Y'));
		return $this->db->get();
	}

	function g_prive($bln, $thn)
	{
		$this->db->select('sum(debet-kredit) as saldo');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', 'Prive Owner');
		$this->db->where('date_format(tanggal,"%m")', date('m'));
		$this->db->where('date_format(tanggal,"%Y")', date('Y'));
		return $this->db->get();
	}

	function g_neraca_prev($bln, $thn)
	{
		$this->db->select('*');
		$this->db->from('jurnal_umum');
		$this->db->where('nama_perkiraan', 'Modal Owner');
		$this->db->where('MONTH(tanggal)', $bln . '-1', FALSE);
		$this->db->where('date_format(tanggal,"%Y")', $thn);
		return $this->db->get();
	}
}