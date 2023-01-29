<?php

namespace App\Models;

use CI_Model;

class Paket extends CI_Model
{

    protected $table = "paket";

    public function create($data = [])
    {
        return $this->db->insert($this->table, $data);
    }
}
