<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Export_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function importData($data)
    {

        $res = $this->db->insert_batch('barang', $data);
        if ($res) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function exportList() {
        $this->db->select(array('id', 'id_sku', 'supplier', 'nama_barang', 'harga_beli', 'image', 'date', 'status'));
        $this->db->from('barang');
        $query = $this->db->get();
        return $query->result();
    }
}
