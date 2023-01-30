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
        $tglUpdateData = date('Y-m-d 23:59:59');
        $tglBesok = date('Y-m-d 00:00:01', strtotime('+1 days'));

        if (date('Y-m-d H:i:s') === $tglUpdateData) {
            $pakets = $this->db->query("SELECT * FROM paket WHERE tanggal < '{$tglBesok}' AND is_publish = 'Draft'");

            if ($pakets->num_rows() > 0) {
                $this->db->where('tanggal' < $tglBesok)->update('paket', [
                    'is_publish' => 'Publish',
                    'stock'      => 'IN STOCK'
                ]);
            }
        }
    }
}
