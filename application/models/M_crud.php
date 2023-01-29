<?php

class M_crud extends CI_Model
{
	function cek_beli($id)
	{
		$this->db->select_sum('status_detail', 'checker');
		$this->db->where('id_antrian', $id);
		$query = $this->db->get('antrian_detail');
		$result = $query->result();

		return $result[0]->checker;
	}

	function cek_beli2($id)
	{
		$query = $this->db->query('SELECT * FROM antrian_detail where id_antrian = ' . $id);

		return $query->num_rows();
	}

	public function savedata($data)
	{
		$this->db->insert('paket', $data);
		return $this->db->insert_id();
	}

	function get_paket()
	{
		$this->db->order_by('id', 'desc');
		$this->db->select()->from('paket');
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			return $hasil->result();
		} else {
			return array();
		}
	}

	function get_user()
	{
		$this->db->order_by('id', 'desc');
		$hasil = $this->db->get('user');
		if ($hasil->num_rows() > 0) {
			return $hasil->result();
		} else {
			return array();
		}
	}

	function get_barang_where($sup)
	{
		$this->db->order_by('id', 'desc');
		$this->db->where('supplier', $sup);
		$this->db->join('supplier', 'supplier.id_supplier = barang.supplier');
		$hasil = $this->db->get('barang');
		if ($hasil->num_rows() > 0) {
			return $hasil->result();
		} else {
			return array();
		}
	}

	function get_supplier()
	{
		$this->db->order_by('id_supplier', 'desc');
		$hasil = $this->db->get('supplier');
		if ($hasil->num_rows() > 0) {
			return $hasil->result();
		} else {
			return array();
		}
	}

	function get_invoices()
	{
		$this->db->join('supplier', 'supplier.id_supplier = invoices.supplier');
		$this->db->order_by('id', 'desc');
		$hasil = $this->db->get('invoices');
		if ($hasil->num_rows() > 0) {
			return $hasil->result();
		} else {
			return array();
		}
	}

	function get_antrian()
	{
		$this->db->join('supplier', 'supplier.id_supplier = antrian.supplier');
		$this->db->order_by('id', 'desc');
		$hasil = $this->db->get('antrian');
		if ($hasil->num_rows() > 0) {
			return $hasil->result();
		} else {
			return array();
		}
	}

	function get_keranjang()
	{
		$this->db->order_by('id_keranjang', 'desc');
		$hasil = $this->db->get('keranjang');
		if ($hasil->num_rows() > 0) {
			return $hasil->result();
		} else {
			return array();
		}
	}

	function get_barang_id($id)
	{
		return $this->db->get_where('barang', array('id' => $id));
	}

	function get_user_id($id)
	{
		return $this->db->get_where('user', array('id' => $id));
	}

	function get_supplier_id($id)
	{
		return $this->db->get_where('supplier', array('id_supplier' => $id));
	}

	function get_invoices_id($id)
	{
		return $this->db->get_where('invoice_detail', array('id_invoice' => $id));
	}

	function get_antrian_id($id)
	{
		return $this->db->get_where('antrian', array('id' => $id));
	}

	function get_antrian_detail_id($id)
	{
		return $this->db->get_where('antrian_detail', array('id_antrian' => $id));
	}

	function get_data_antrian($id)
	{
		$this->db->join('supplier', 'supplier.id_supplier = antrian_detail.id_supplier');
		$this->db->join('barang', 'barang.id_sku = antrian_detail.id_sku');
		$this->db->group_by('antrian_detail.id_sku');
		$this->db->distinct();
		return $this->db->get_where('antrian_detail', array('id_antrian' => $id));
	}

	function get_id($table, $where, $id)
	{
		return $this->db->get_where($table, array($where => $id));
	}

	function add($table, $data)
	{
		$this->db->insert($table, $data);
	}

	function del($table, $where, $id)
	{
		$this->db->where($where, $id)
			->delete($table);
	}

	function find($table, $where, $id)
	{
		$hasil = $this->db->where($where, $id)
			->limit(1)
			->get($table);
		if ($hasil->num_rows() > 0) {
			return $hasil->row();
		} else {
			return array();
		}
	}

	function update($table, $where, $id, $data)
	{
		$this->db->where($where, $id);
		$this->db->update($table, $data);
	}

	function cek_supplier($supp)
	{
		$where = array(
			'supplier'			=> $supp,
			'status_antrian'	=> 1
		);

		$this->db->where($where);
		$hasil = $this->db->get('antrian');

		return $hasil;
	}

	function cek_barang($id, $sku)
	{
		$where = array(
			'id_antrian'	=> $id,
			'id_sku'		=> $sku
		);

		$this->db->where($where);
		$hasil = $this->db->get('antrian_detail');

		return $hasil;
	}

	public function process($pembeli, $total_barang, $total_harga, $date)
	{
		foreach ($this->cart->contents() as $items) {
			$supplier = $items['gbid'];
		}

		$cek = $this->cek_supplier($supplier)->num_rows();
		$old_data = $this->cek_supplier($supplier)->row_array();

		// var_dump($cek);$var_dump($old_data);die;

		if ($cek == 0) {
			$invoice = array(
				'pembeli'   => $pembeli,
				'supplier'	=> $supplier,
				'total_barang' => $total_barang,
				'total_harga' => $total_harga,
				'date' 		=> $date,
				'status_antrian'	=> 1
			);
			$this->db->insert('antrian', $invoice);
			$invoice_id = $this->db->insert_id();

			foreach ($this->cart->contents() as $items) {
				$data = array(
					'id_antrian'	=>	$invoice_id,
					'id_sku'		=>	$items['sku'],
					'id_supplier'	=>	$items['gbid'],
					'qty'			=>	$items['qty'],
					'price'			=>	$items['price'],
					'status_detail'	=>  '0'
				);
				$this->db->insert('antrian_detail', $data);
			}
		} else {
			$total_barang = $total_barang + $old_data['total_barang'];
			$total_harga = $total_harga + $old_data['total_harga'];

			$invoice = array(
				'total_barang'	=> $total_barang,
				'total_harga'	=> $total_harga,
				'date'			=> $date
			);

			$this->db->where('id', $old_data['id']);
			$this->db->update('antrian', $invoice);

			foreach ($this->cart->contents() as $items) {
				$cekbarang = $this->cek_barang($old_data['id'], $items['sku'])->num_rows();
				$old_barang = $this->cek_barang($old_data['id'], $items['sku'])->row_array();
				if ($cekbarang == 0) {
					$data = array(
						'id_antrian'	=>	$old_data['id'],
						'id_sku'		=>	$items['sku'],
						'id_supplier'	=>	$items['gbid'],
						'qty'			=>	$items['qty'],
						'price'			=>	$items['price'],
						'status_detail'	=>  '0'
					);
					$this->db->insert('antrian_detail', $data);
				} else {
					$data = array(
						'id_antrian'	=>	$old_data['id'],
						'id_sku'		=>	$items['sku'],
						'id_supplier'	=>	$items['gbid'],
						'qty'			=>	$items['qty'] + $old_barang['qty'],
						'price'			=>	$items['price'],
						'status_detail'	=>  '0'
					);

					$where = array(
						'id_antrian'	=> $old_data['id'],
						'id_sku'		=> $items['sku']
					);

					$this->db->where($where);
					$this->db->update('antrian_detail', $data);
				}
			}
		}

		return TRUE;
	}

	public function process_simpan($id, $total_barang, $total_harga)
	{
		foreach ($this->cart->contents() as $items) {
			$supplier = $items['gbid'];
		}

		$invoice = array(
			'supplier'	=> $supplier,
			'total_barang' => $total_barang,
			'total_harga' => $total_harga,
			'status_antrian'	=> 1
		);
		$this->db->where('id', $id);
		$this->db->update('antrian', $invoice);

		$this->db->where('id_antrian', $id)
			->delete('antrian_detail');

		foreach ($this->cart->contents() as $items) {
			$data = array(
				'id_antrian'	=>	$id,
				'id_sku'		=>	$items['sku'],
				'id_supplier'	=>	$items['gbid'],
				'qty'			=>	$items['qty'],
				'price'			=>	$items['price'],
				'status_detail' =>  $items['stat']
			);
			$this->db->insert('antrian_detail', $data);
		}

		return TRUE;
	}


	public function process_co($id, $total_barang, $total_harga, $tanggal)
	{
		foreach ($this->cart->contents() as $items) {
			$supplier = $items['gbid'];
		}

		$invoice = array(
			'supplier'	=> $supplier,
			'total_barang' => $total_barang,
			'total_harga' => $total_harga,
			'date'	=> $tanggal,
			'status_antrian'	=> 2
		);
		$this->db->where('id', $id);
		$this->db->update('antrian', $invoice);

		$this->db->where('id_antrian', $id)
			->delete('antrian_detail');

		foreach ($this->cart->contents() as $items) {
			$data = array(
				'id_antrian'	=>	$id,
				'id_sku'		=>	$items['sku'],
				'id_supplier'	=>	$items['gbid'],
				'qty'			=>	$items['qty'],
				'price'			=>	$items['price'],
				'status_detail' =>  $items['stat']
			);
			$this->db->insert('antrian_detail', $data);
		}

		return TRUE;
	}


	public function getDataTimeline()
	{
		$hasil = $this->db->query("SELECT * FROM `timeline` INNER JOIN `user` ON `timeline`.`id_user` = `user`.`id`");
		if ($hasil->num_rows() > 0) {
			return $hasil->result_array();
		} else {
			return array();
		}
	}

	public function getNomorInvoice()
	{
		$hasil = $this->db->query("SELECT no_invoice FROM paket WHERE no_invoice <> ''");
		if ($hasil->num_rows() > 0) {
			return $hasil->result_array();
		} else {
			return array();
		}
	}

	public function getNomorInvoiceById($id)
	{
		$hasil = $this->db->query("SELECT `no_invoice` FROM `paket` WHERE `no_invoice` <> (SELECT `no_invoice` FROM `timeline` WHERE `id_timeline` = '{$id}') AND `no_invoice` <> '';");
		if ($hasil->num_rows() > 0) {
			return $hasil->result_array();
		} else {
			return array();
		}
	}

	function getDataTimelineById($id)
	{
		$hasil = $this->db->query("SELECT * FROM `timeline` INNER JOIN `user` ON `timeline`.`id_user` = `user`.`id` WHERE `timeline`.`id_timeline` = '{$id}'");
		return $hasil->row_array();
	}

	function insertDataTimeline($table, $data)
	{
		$this->db->insert($table, $data);
	}

	function updateDataTimeline($table, $data, $id)
	{
		$this->db->update($table, $data, ['id_timeline' => $id]);
	}

	public function deleteDataTimeline($id)
	{
		$this->db->delete('timeline', ['id_timeline' => $id]);
	}

	public function getHistoryTimeline($no_invoice)
	{
		$hasil = $this->db->query("SELECT * FROM `timeline` INNER JOIN `user` ON `timeline`.`id_user` = `user`.`id` WHERE `timeline`.`no_invoice` = '{$no_invoice}'");
		if ($hasil->num_rows() > 0) {
			return $hasil->result_array();
		} else {
			return array();
		}
	}
}
