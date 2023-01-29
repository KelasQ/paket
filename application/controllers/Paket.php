<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket extends CI_Controller {

    function __construct(){
		parent::__construct();
	
		if($this->session->userdata('role') == "1" || $this->session->userdata('role') == "2"){
        }
        else {
            $this->session->sess_destroy();
            redirect(base_url(''));
        }
        
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
	}

	public function index()
	{
	    
		$data['title'] = 'Data Paket';
		$data['parent_active'] = 'paket';

		//$this->db->where('stock', 'IN STOCK');
		$this->db->select()->from('paket');
		$this->db->where('stock', 'IN STOCK');
		
		$data['data'] = [];
		if( isset($_GET['start']) && isset($_GET['end'] ) ) 
		{
		    
		    if( empty( $_GET['start'] ) && empty($_GET['end']) ) {
		        
    		    
    		    $this->db->where('gambar', '');
    		    $this->db->where('YEAR(tanggal)', date('Y'));
    		    $data['data'] = $this->db->get()->result();
		    
		        
		    } 
		    
		    if( $this->input->get('start') && $this->input->get('end')) {
    		    $this->db->where("tanggal BETWEEN '" . $this->input->get('start') . ' 00:00:00' . "' AND '" . $this->input->get('end') . ' 23:59:59' . "'");
    		    $data['data'] = $this->db->get()->result();
    		}
		    
		    
		} 
		    
		if( !$this->session->userdata( 'role') != 1) 
		{
		    $this->db
		    ->group_start()
		    ->where( 'paket.username', $this->session->userdata( 'username') )->or_where( 'paket.username', '')
		    ->group_end();
		}
		
		

		$this->load->view('templates/header',$data);
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('paket', $data);
		$this->load->view('templates/footer');
		
	}
	
	
	public function tambah()
	{
		$data['title'] = 'Data Paket';
		$data['parent_active'] = 'scan';

		$this->load->view('templates/header',$data);
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('paket_tambah');
		$this->load->view('templates/footer');		
		
	}

	public function edit( $id ) 
	{

		$data['title'] 			= 'Data Paket';
		$data['parent_active'] 	= 'scan';

		$data['row'] =  $this->db->select()->from( 'paket' )->where( 'id', $id)->get()->row();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('paket_tambah');
		$this->load->view('templates/footer');	

	}
	
	public function filter()
	{
		$data['title'] = 'Data Paket';
		$data['parent_active'] = 'paket';

		$this->db->where('role !=', 3);
		$data['username'] = $this->M_crud->get_user();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('filter');
		$this->load->view('templates/footer');		
	}
	
	public function filterby()
	{
		$data['title'] = 'Data Paket';
		$data['parent_active'] = 'paket';
		$user = $this->input->post('username');
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$cek = 0;
		if($start != '') {
    		$cek = 1;
		}
		if($end != '') {
    		$cek++;
		}
		if($user != 'all'){
    		$this->db->where('username',$user);
		}
		if($cek == 2){
		    $this->db->where('tanggal >=', $start.' 00:00:00');
            $this->db->where('tanggal <=', $end.' 23:59:59');
		}
		$data['data'] = $this->M_crud->get_paket();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('paket');
		$this->load->view('templates/footer');
	}


	public function invoice()
	{

		$this->load->model('GlobalModel');

		$this->GlobalModel->table( 'paket' );

		$data['title'] = 'Data Paket';
		$data['parent_active'] = 'check_invoice';
    
    
		$this->db->where("tanggal BETWEEN '" . $this->input->get('start') . ' 00:00:00' . "' AND '" . $this->input->get('end') . ' 23:59:59' . "'");
		$data['data'] = $this->GlobalModel->findAll();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('kasir/laporan-invoice');
		$this->load->view('templates/footer');
	}


	private function uploadBerkasScan( $name )
	{


		$config = [
			'upload_path' 	=> './uploads/',
			'allowed_types' => 'gif|jpg|png|jpeg',
			'max_width'		=> '8000',
			'max_height'	=> '8000',
			'max_size'		=> '10000'
		];


		$this->load->library( 'upload', $config );
		//$this->load->initialize( $config );

		if( $this->upload->do_upload( $name ) )
		{


			return $this->upload->data( 'file_name' );

		}


		return '';

	}

	public function update( $id )
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['gambar'] = $this->input->post( 'old_gambar' );

		if( !empty( $_FILES['gambar']['tmp_name']) ) $data['gambar'] = $this->uploadBerkasScan( 'gambar' );

		

		//var_dump( $data ); 

		//die();

		$this->db->where( 'id', (int)$id );
		$this->db->update( 'paket', $data);
		
		$data = $data + [ 
		    'id' => $id,
		    'redirect' => base_url('/paket?start=' . $this->input->post('start') . '&end=' . $this->input->post('end'))
		];

        echo json_encode( $data );
	}

    public function save()
    {

    	//var_dump( $_POST + $_FILES );
    	//die();

        $username = $this->input->post('username', true);
        $noInvoice = $this->input->post('noInvoice', true);
        // $nama = $this->input->post('nama', true);
        // $alamat = $this->input->post('alamat', true);
        // $username = $_POST['username'];
        $image = $this->uploadBerkasScan('gambar');
        // $image = str_replace('data:image/jpeg;base64,','', $image);
        // $image = base64_decode($image);
        // $filename = 'image_'.time().'.png';
        // file_put_contents(FCPATH.'/uploads/'.$filename,$image);
        $data = array(
            'username'  	=> $username,
            'tanggal'   	=> date('Y-m-d H:i:s'),
            'gambar'    	=> $image,
            'no_invoice' 	=> $noInvoice
        );


        ///$this->GlobalModel->table( 'paket' )->insert( $data );
        $res = $this->M_crud->savedata($data);
        echo json_encode($res);
    }

    public function hapus($id)
    {
        $this->M_crud->del('paket', 'id', $id);
	}
	
	public function checked( $id, $status ) {

		$data = [];

		if($status == 'No') $data['is_checked'] = 'Yes';
		else $data['is_checked'] = 'No';
	
		$this->db->update('paket', $data, [ 'id' => $id ]);
		$this->session->set_flashdata('message', 'Status telah di perbaharui');
		
		redirect(base_url('/paket/invoice'));

	}
}
