<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function check_user_online()
    {

        $users = $this->db->select('id, last_aktive')->from('user')->where('is_online', 1)->get()->result();
        $ids = [];
        foreach ($users as $user) {
            $last_active = strtotime($user->last_aktive);
            $current_date = strtotime(date('Y-m-d H:i:s'));

            $total = ($current_date - $last_active);
            if ($total >= 300) {
                $this->db->where('id', $user->id)->update('user', [
                    'is_online' => 0
                ]);
                $ids[] = $user->id;
            }
        }
    }

    public function checkPaketStatus()
    {

        // kalau sudah jam 12 malam
        // update status barang


    }
}
