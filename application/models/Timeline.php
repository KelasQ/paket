<?php

namespace App\Models;

use CI_Model;

class Timeline extends CI_Model
{

    protected $table = "timeline";

    public function create($data = [])
    {
        return $this->db->insert($this->table, $data);
    }
}
