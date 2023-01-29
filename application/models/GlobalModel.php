<?php

class GlobalModel extends CI_Model
{
    private $table          = '';
    private $primaryKey     = '';
    private $select         = '*';

    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
        return $this;
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function add($data)
    {

        return $this->db->insert($this->table, $data);
    }

    public function update($data = [], $where = [])
    {

        return $this->db->update($this->table, $data, $where);
    }

    public function delete($id)
    {

        return $this->db->delete($this->table, [$this->primaryKey => $id]);
    }

    public function find($id)
    {

        return $this->db->select()->from($this->table)->where($this->primaryKey, $id)->get()->row();
    }

    public function findAll()
    {
        return $this->db->select($this->select)->from($this->table)->get()->result();
    }


    public function filterBy($filters)
    {

        foreach ($filters as $key => $value) {

            $this->db->where($key, $value);
        }

        return $this;
    }

    public function joins($joins)
    {
        foreach ($joins as $key => $value) {

            $this->db->join($value['table'],  $value['on'], $value['position']);
        }

        return $this;
    }


    public function groupBy($groups)
    {

        $this->db->group_by($groups);

        return $this;
    }

    public function select($select = '*')
    {

        $this->select = $select;

        return $this;
    }
}
