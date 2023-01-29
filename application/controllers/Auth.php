<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        $this->load->view('login');
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $dateTimeNow = date('Y-m-d H:i:s');
        $user = $this->db->get_where('user', ['username' => $username])->row_array();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = array(
                    'id'        => $user['id'],
                    'username'  => $user['username'],
                    'picture'   => $user['picture'],
                    'role'      => $user['role'],
                    'is_login'  => 1,
                );
                $this->session->set_userdata($data);
                $this->db->update('user', ['is_online' => 1], ['id' => $user['id']]);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong Password!</div>');
                redirect(base_url());
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username is not registered</div>');
            redirect(base_url());
        }
    }

    public function logout()
    {
        $this->db->update('user', ['is_online' => 0], ['username' => $this->session->userdata('username')]);
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logout</div>');
        redirect(base_url());
    }

    public function last_aktive()
    {
        $dateTimeNow = date('Y-m-d H:i:s');
        $this->db->update('user', ['last_aktive' => $dateTimeNow], ['username' => $this->session->userdata('username')]);
    }
}
