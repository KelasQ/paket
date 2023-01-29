<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!in_array($this->session->userdata('role'), ['1', '2', '3', '4'])) {
			$this->session->sess_destroy();
			redirect(base_url());
		}
		/**if($this->session->userdata('role') != 1){    $jam_mulai = $this->db->select()->from('meta')->where('meta_key', 'jam_mulai')->get()->row()->meta_value;    $jam_selesai = $this->db->select()->from('meta')->where('meta_key', 'jam_selesai')->get()->row()->meta_value;      //  var_dump( $jam_mulai . ' - ' .  date('H:i:s') );  //  var_dump( $jam_selesai . ' - ' .  date('H:i:s') );        if($jam_selesai <= date('H:i:s'))      {                	    $this->session->sess_destroy();        $this->session->set_flashdata('message', 'Jam masuk telah lewat');	    //redirect('https://csorder.web.id/');    }        if(date('H:i:s') <= $jam_mulai )     {        	    $this->session->sess_destroy();        $this->session->set_flashdata('message', 'Jam masuk telah lewat');	    redirect('https://csorder.web.id/');    }    } **/
	}

	public function index()
	{
		$this->load->model('GlobalModel');
		$this->GlobalModel->table('paket');

		$data['title'] = 'Dashboard';
		$data['parent_active'] = 'dashboard';
		$data['paket'] = ['all' => $this->GlobalModel->filterBy(['tanggal >=' => date('Y-m-d') . ' 00:00:00',		'tanggal <=' => date('Y-m-d') . ' 23:59:59',		'role' => 2])->joins([['table'     => 'user',				'on'        => 'user.username = paket.username',				'position'  => '']])->findAll(),	'per_user' => $this->GlobalModel->select('paket.username, count(paket.username) as discan')->filterBy(['tanggal >=' => date('Y-m-d') . ' 00:00:00',			'tanggal <=' => date('Y-m-d') . ' 23:59:59',			'role' => '2'])->joins([['table'     => 'user',				'on'        => 'user.username = paket.username',				'position'  => '']])->groupBy('paket.username')->findAll()];

		$this->db->where("tanggal BETWEEN '" . date('Y-m-d') . ' 00:00:00' . "' AND '" . date('Y-m-d') . ' 23:59:59' . "' AND is_publish = 'Publish'"); //$this->db->where('is_publish', 'Publish');$data['paket']['checked'] = $this->GlobalModel->findAll();

		//echo $this->db->last_query();

		$this->db->where("tanggal BETWEEN '" . date('Y-m-d') . ' 00:00:00' . "' AND '" . date('Y-m-d') . ' 23:59:59' . "' AND is_publish = 'Draft'");
		$data['paket']['not_checked'] = $this->GlobalModel->findAll();

		$data['jam']['mulai'] = $this->db->from('meta')->where('meta_key', 'jam_mulai')->get()->row()->meta_value;
		$data['jam']['selesai'] = $this->db->from('meta')->where('meta_key', 'jam_selesai')->get()->row()->meta_value;
		//echo $this->db->last_query();
		$data['users'] = ['online' => $this->db->from('user')->where(['is_online' => 1])->get()->result()];

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('dashboard');
		$this->load->view('templates/footer');
	}

	public function onlineUser()
	{
		$jam_mulai = $this->db->select()->from('meta')->where('meta_key', 'jam_mulai')->get()->row()->meta_value;
		$jam_selesai = $this->db->select()->from('meta')->where('meta_key', 'jam_selesai')->get()->row()->meta_value;

		if ($jam_selesai <= date('H:i:s')) {
			$this->db->where('role >', '1');
			$this->db->update('user', ['is_online' => 0]);
		}

		if (date('H:i:s') <= $jam_mulai) {
			$this->db->where('role >', '1');
			$this->db->update('user', ['is_online' => 0]);
		}

		$this->load->model('GlobalModel');
		$users = $this->GlobalModel->table('user')->filterBy(['is_online' => 1])->findAll();

		foreach ($users as $user) :
			echo "<tr>		<td>{$user->username}</td>	</tr>";
		endforeach;
	}

	public function updateJamKerja()
	{
		$check_jam_mulai = $this->db->select()->from('meta')->where('meta_key', 'jam_mulai')->get();
		$check_jam_selesai = $this->db->select()->from('meta')->where('meta_key', 'jam_selesai')->get();
		if ((int)$this->input->post('jam_mulai') < 10) $_POST['jam_mulai'] = "0" . (int)$this->input->post('jam_mulai');
		if ((int)$this->input->post('menit_mulai') < 10) $_POST['menit_mulai'] = "0" . $this->input->post('menit_mulai');
		if ((int)$this->input->post('jam_selesai') < 10) $_POST['jam_selesai'] = "0" . (int)$this->input->post('jam_selesai');
		if ((int)$this->input->post('menit_selesai') < 10) $_POST['menit_selesai'] = "0" . $this->input->post('menit_selesai');
		$jam_mulai = $this->input->post('jam_mulai') . ':' . $this->input->post('menit_mulai') . ':00';
		$jam_selesai = $this->input->post('jam_selesai') . ':' . $this->input->post('menit_selesai') . ':00';
		if ($check_jam_mulai->num_rows() > 0) {
			$this->db->update('meta', ['meta_value' => $jam_mulai], ['meta_key' => 'jam_mulai']);
		} else {
			$this->db->insert('meta', [
				'meta_name' => 'jam_mulai',
				'meta_value' => $jam_mulai
			]);
		}
		if ($check_jam_selesai->num_rows() > 0) {
			$this->db->update('meta', ['meta_value' => $jam_selesai], ['meta_key' => 'jam_selesai']);
		} else {
			$this->db->insert('meta', [
				'meta_name' => 'jam_selesai',
				'meta_value' => $jam_selesai
			]);
		}
	}

	public function viewer()
	{
		$this->load->view('viewer');
	}
	public function tempUpload()
	{
	}

	public function uploadFile($name)
	{
		$config['upload_path']          = './tempUpload/';
		$config['allowed_types']        = 'gif|jpg|png|pdf|jpeg';
		$config['overwrite']			= true;
		$config['max_size']             = 8024; // 1MB// $config['max_width']            = 1024;// $config['max_height']           = 768;

		$this->load->library('upload', $config);

		if ($this->upload->do_upload($name)) {
			return $this->upload->data("file_name");
		}

		return '';
	}

	public function getUserOnline()
	{
		$data = $this->db->get_where('user', ['is_online' => 1])->result();
		echo json_encode($data);
	}

	public function getUserOffline()
	{
		$data = $this->db->get_where('user', ['is_online' => 0])->result();
		echo json_encode($data);
	}

	// public function cek_user_status()
	// {
	// 	$menitSekarang = date('i');
	// 	$user = $this->session->userdata('username');

	// 	$sql = $this->db->query("SELECT MINUTE(last_aktive) FROM user WHERE username = '{$user}'")->result();
	// 	$menitLastAktifUser = date('i', $sql['last_aktive']) + 1;

	// 	if ($menitSekarang > $menitLastAktifUser) {
	// 		$this->db->update('user', ['is_online' => 0], ['username' => $user]);
	// 		$this->session->unset_userdata('username');
	// 		$this->session->unset_userdata('role');
	// 		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logout</div>');
	// 		redirect(base_url());
	// 	}
	// }
}
