<?php 

class MY_Session extends CI_Session
{

    public function __construct() {
        parent::__construct();
    }

    function sess_destroy() {

        //update the Online filed as required

        if($this->CI->session->userdata('is_login'))
        {
            $this->CI->db->update('user', [
                'is_online' => 0
            ], [
                'username' => $this->CI->session->userdata('username')
            ]);
        }
        

        //call the parent 
        parent::sess_destroy();
    }

}