<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Timeline extends CI_Controller
{
    private $table = 'timeline';

    function __construct()
    {
        parent::__construct();
        if (!in_array($this->session->userdata('role'), ['1', '2', '3', '4'])) {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    public function index()
    {
        $data = [
            'title'         =>  'Data Timeline Barang',
            'parent_active' =>  'timeline',
            'dataTimeline'  =>  $this->M_crud->getDataTimeline(),
            // 'invoices'  =>  $this->M_crud->getNomorInvoice()
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('timeline', $data);
        $this->load->view('templates/footer');
    }

    public function invoices()
    {
        $s = $this->input->get('s');
        $results = $this->db->select('no_invoice')->from('paket')
            ->like('no_invoice', $s)->limit(10);
        echo json_encode($results->get()->result());
        die();
    }


    public function add()
    {
        $data = [
            'title'         =>  'Tambah Data Timeline Barang',
            'parent_active' =>  'timeline',
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('add_timeline', $data);
        $this->load->view('templates/footer');
    }

    public function insert()
    {
        $this->form_validation->set_rules('no_invoice', 'Nomor Invoice', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() != false) {
            $data   = array(
                'id_user'    =>  $this->input->post('id_user'),
                'no_invoice' =>  $this->input->post('no_invoice'),
                'keterangan' =>  $this->input->post('keterangan'),
                'tgl_input'  =>  $this->input->post('tgl_input')
            );
        }

        $simpan = $this->M_crud->insertDataTimeline('timeline', $data);
        if ($simpan) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Timeline Berhasil Disimpan.</div>');
            redirect('timeline');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf, Ada Masalah Saat Menyimpan Data Timeline!</div>');
            redirect('timeline');
        }
    }

    public function edit($id)
    {
        $data = [
            'title'         =>  'Edit Data Timeline Barang',
            'parent_active' =>  'timeline',
            'dataTimeline'  =>  $this->M_crud->getDataTimelineById($id),
            'invoices'      =>  $this->M_crud->getNomorInvoiceById($id)
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('edit_timeline', $data);
        $this->load->view('templates/footer');
    }

    public function update($id)
    {
        $this->form_validation->set_rules('no_invoice', 'Nomor Invoice', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() != false) {
            $data   = array(
                'id_timeline' =>  $id,
                'id_user'     =>  $this->input->post('id_user'),
                'no_invoice'  =>  $this->input->post('no_invoice'),
                'keterangan'  =>  $this->input->post('keterangan'),
                'tgl_input'   =>  $this->input->post('tgl_input')
            );
        }

        $update = $this->M_crud->updateDataTimeline('timeline', $data, $id);
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Timeline Berhasil Diupdate.</div>');
            redirect('timeline');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf, Ada Masalah Saat Update Data Timeline!</div>');
            redirect('timeline');
        }
    }

    public function hapus($id)
    {
        if ($this->M_crud->deleteDataTimeline($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Timeline Berhasil Disimpan.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf, Ada Masalah Saat Menyimpan Data Timeline!</div>');
        }
        redirect('timeline');
    }

    public function history($no_invoice)
    {
        $data = $this->M_crud->getHistoryTimeline($no_invoice);
        echo json_encode($data);
        die();
    }
}
