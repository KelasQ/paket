<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role') == "1") {
        } else {
            $this->session->sess_destroy();
            redirect(base_url(''));
        }
    }

    public function index()
    {
        $data['title'] = 'Data User';
        $data['parent_active'] = 'user';
        $data['data'] = $this->M_crud->get_user();
        $this->db->group_by('role');
        $data['role'] = $this->M_crud->get_user();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('user');
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Data User';
        $data['parent_active'] = 'user';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('user_tambah');
        $this->load->view('templates/footer');
    }

    public function tambahbaru()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() != false) {
            $data   = array(
                'username'      =>  $this->input->post('username'),
                'password'       =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role'          =>  $this->input->post('role'),
                'picture'       =>  'default.jpg',
                'last_aktive'    =>  '0000-00-00 00:00:00'
            );

            $this->M_crud->add('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan !</div>');
            redirect('user');
        } else {
            $data['title'] = 'Data User';
            $data['parent_active'] = 'user';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('user_tambah');
            $this->load->view('templates/footer');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Data User';
        $data['parent_active'] = 'user';
        $data['data'] = $this->M_crud->get_user_id($id)->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('user_edit');
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'required|matches[password]');
        $id = $this->input->post('id');

        if ($this->form_validation->run() != false) {
            $data   = array(
                'password'       =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role'          =>  $this->input->post('role'),
            );

            $this->M_crud->update('user', 'id', $id, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diedit !</div>');
            redirect('user');
        } else {
            $data['title'] = 'Data User';
            $data['parent_active'] = 'user';
            $data['data'] = $this->M_crud->get_user_id($id)->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('user_edit');
            $this->load->view('templates/footer');
        }
    }

    public function hapus($id)
    {
        $this->M_crud->del('user', 'id', $id);
    }



    public function byrole()
    {
        $role = $this->input->post('role');
        if ($role == 'All') {
            redirect('user');
        } else {
            $data['title'] = 'Data User';
            $data['parent_active'] = 'user';
            $this->db->where('role', $role);

            $data['data'] = $this->M_crud->get_user();
            $this->db->group_by('role');

            $data['role'] = $this->M_crud->get_user();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar');
            $this->load->view('templates/sidebar');
            $this->load->view('user');
            $this->load->view('templates/footer');
        }
    }
}
