<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('role') == "3") {

            $this->session->sess_destroy();
            redirect(base_url(''));
        }
        /**
        if($this->session->userdata('role') != 1)
		{
		    $jam_mulai = $this->db->select()->from('meta')->where('meta_key', 'jam_mulai')->get()->row()->meta_value;
		    $jam_selesai = $this->db->select()->from('meta')->where('meta_key', 'jam_selesai')->get()->row()->meta_value;
		    
		  //  var_dump( $jam_mulai . ' - ' .  date('H:i:s') );
		  //  var_dump( $jam_selesai . ' - ' .  date('H:i:s') );
		    
		    if($jam_selesai <= date('H:i:s'))  
		    {
		        
		        
			    $this->session->sess_destroy();
		        $this->session->set_flashdata('message', 'Jam masuk telah lewat');
			    redirect('https://csorder.web.id/');
		    }
		    
		    if(date('H:i:s') <= $jam_mulai ) 
		    {
		        
			    $this->session->sess_destroy();
		        $this->session->set_flashdata('message', 'Jam masuk telah lewat');
			    redirect('https://csorder.web.id/');
		    }
		    
		}
		
         **/

        $this->load->model('GlobalModel');
        $this->GlobalModel->table('paket');
        $this->GlobalModel->setPrimaryKey('id');
    }

    public function index()
    {
        $data['title'] = 'Data Kasir';
        $data['parent_active'] = 'kasir';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('kasir/form');
        $this->load->view('templates/footer');
    }

    public function lists()
    {
        $data['title'] = 'Data Kasir';
        $data['parent_active'] = 'kasir';


        $this->db->where("tanggal BETWEEN '" . $this->input->get('start') . ' 00:00:00' . "' AND '" . $this->input->get('end') . ' 23:59:59' . "' AND gambar != ''");
        $data['data'] = $this->GlobalModel->findAll();



        //var_dump($data);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('kasir/lists');
        $this->load->view('templates/footer');
    }


    public function edit($id)
    {
        $data['title'] = 'Data Kasir';
        $data['parent_active'] = 'kasir';
        $data['data'] = $this->GlobalModel->find($id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar');
        $this->load->view('templates/sidebar');
        $this->load->view('kasir/edit');
        $this->load->view('templates/footer');
    }

    public function update($id)
    {

        $no_invoice = $this->input->post('no_invoice');

        $data = [
            'keterangan' => $this->input->post('keterangan')
        ];


        //if(!empty($_FILES['invoice']['name'])) $data['invoice'] = $this->uploadInvoice();

        $is_exist = $this->db->from('paket')->where('id', $id)->get();

        if ($is_exist->num_rows() > 0) {

            $this->GlobalModel->update($data, ['id' => $id]);
        }

        echo json_encode($data + [
            'redirect'    =>    base_url('kasir/lists?start=' . $this->input->post('start') . '&end=' . $this->input->post('end'))
        ]);

        die();
    }

    public function updatePublish($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules([
            [
                'field' => 'no_invoice',
                'rules' => 'required',
                'label' => 'No Invoice'
            ]
        ]);

        if (!$this->form_validation->run()) {
            $this->output->set_status_header(400, 'Bad Requeset')
                ->set_output(json_encode([
                    'errors' => $this->form_validation->error_array()
                ]))
                ->set_content_type('application/json', 'utf-8')
                ->_display();
            exit;
        }

        $publish = $this->input->post('publish');
        $this->GlobalModel->update([
            'is_publish' => $publish
        ], [
            'id' => $id
        ]);

        // Insert Data Timeline
        $dataTimeline = [
            'id_user'       =>  $this->session->userdata('id'),
            'no_invoice'    =>  $this->input->post('no_invoice'),
            'keterangan'    =>  'Invoice telah discan oleh ' . $this->session->userdata('username'),
            'tgl_input'     =>  date('Y-m-d H:i:s')
        ];

        $mCrud = new \App\Models\Timeline;
        $mCrud->create($dataTimeline);
    }


    public function uploadInvoice()
    {

        $config['upload_path']          = './uploads/kasir/';
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $config['overwrite']            = true;
        $config['max_size']             = 8024; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('invoice')) {
            return $this->upload->data("file_name");
        }

        return '';
    }
}
