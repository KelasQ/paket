<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Smalot\PdfParser\Parser;

use App\Services\Extractor;

class Invoice extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
		if (!$this->session->userdata('role') == "4") {
			$this->session->sess_destroy();
			redirect(base_url(''));
		}

		if ($this->session->userdata('role') != 1) {
			$jam_mulai = $this->db->select()->from('meta')->where('meta_key', 'jam_mulai')->get()->row()->meta_value;
			$jam_selesai = $this->db->select()->from('meta')->where('meta_key', 'jam_selesai')->get()->row()->meta_value;

			if ($jam_selesai <= date('H:i:s')) {
				$this->session->sess_destroy();
				$this->session->set_flashdata('message', 'Jam masuk telah lewat');
				//redirect('https://csorder.web.id/');
			}

			if (date('H:i:s') <= $jam_mulai) {
				$this->session->sess_destroy();
				$this->session->set_flashdata('message', 'Jam masuk telah lewat');
			}
		}
		$this->load->model('GlobalModel');
		$this->GlobalModel->table('paket');
		$this->GlobalModel->setPrimaryKey('id');
	}

	public function index()
	{
		$data['title'] = 'Data Invoice';
		$data['parent_active'] = 'invoice';
		$data['data'] = [];

		if ($this->input->get('start') && $this->input->get('end')) {
			$this->db->where("tanggal BETWEEN '" . $this->input->get('start') . ' 00:00:00' . "' AND '" . $this->input->get('end') . ' 23:59:59' . "'");
			$data['data'] = $this->GlobalModel->findAll();
		}

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/lists', $data);
		$this->load->view('templates/footer');
	}

	public function lists()
	{
		$data['title'] = 'Data Invoice';
		$data['parent_active'] = 'invoice';

		$this->db->where("tanggal BETWEEN '" . $this->input->get('start') . ' 00:00:00' . "' AND '" . $this->input->get('end') . ' 23:59:59' . "'");

		$data['data'] = $this->GlobalModel->findAll();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/lists', $data);
		$this->load->view('templates/footer');
	}

	public function tambah()
	{
		$data['title'] = 'Data Kasir';
		$data['parent_active'] = 'kasir';

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar');
		$this->load->view('templates/sidebar');
		$this->load->view('admin/tambah');
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
		$this->load->view('admin/edit');
		$this->load->view('templates/footer');
	}

	public function update($id)
	{
		if (!$id) die();

		$no_invoice = $this->input->post('no_invoice');

		$data = [
			'invoice'		 => $this->input->post('old_invoice'),
			'no_invoice' 	=> $this->input->post('no_invoice'),
			'stock'			=> $this->input->post('stock')
		];

		if (!empty($_FILES['invoice']['tmp_name'])) $data['invoice'] = $this->uploadInvoice();

		$cari = $this->db->from('paket')->where('id', $id)->get()->row();

		if ($cari) {
			$paramIfExists = [
				'invoice' => $cari->invoice,
				'no_invoice' => $cari->no_invoice
			];

			$checkIfExists = $this->db->from('paket')->where($paramIfExists)->get();
			if ($checkIfExists->num_rows() > 1) {
				$failedResponse = [
					'status' => 'failed',
					'data' => $data,
					'error' => 'Inovice dan No Invoice sudah ada'
				];
				echo json_encode($failedResponse);
				die();
			}

			$this->GlobalModel->update($data, ['id' => $id]);

			echo json_encode($data + [
				'status' => 'success',
				'redirect'	=>	base_url('invoice?start=' . $this->input->post('start') . '&end=' . $this->input->post('end'))
			]);
			die();
		}

		echo json_encode([
			'status' => 'failed',
			'data' => $data,
			'error' => 'Data tidak ada'
		]);
		die();
	}

	public function add()
	{
		$no_invoice = $this->input->post('no_invoice');
		$invoice    = $this->input->post('old_invoice');
		$data = [
			'invoice' 		=> $this->input->post('old_invoice'),
			'no_invoice' 	=> $this->input->post('no_invoice'),
			'tanggal'   	=> date('Y-m-d H:i:s'),
			'stock'			=> $this->input->post('stock')
		];

		if (!empty($_FILES['invoice']['tmp_name'])) $data['invoice'] = $this->uploadInvoice();

		$is_exist = $this->db
			->from('paket')
			->where('no_invoice', $no_invoice)
			->or_where('invoice', $data['invoice'])
			->get();

		if ($is_exist->num_rows() > 0) {
			echo json_encode($data + [
				'code'      => 400,
				'message'   => 'Invoice dan No invoice sudah ada',
			]);
			die();
		}

		$this->GlobalModel->add($data);
		echo json_encode($data + [
			'redirect'	=>	base_url('invoice?start=' . $this->input->post('start') . '&end=' . $this->input->post('end')),
			'code'      => 200,
			'message'   => 'Berhasil menyimpan'
		]);
		die();
	}

	public function tmpUpload()
	{
		$image = $this->uploadFile('file');
		echo $image;
		die();
	}

	private function uploadFile($name)
	{
		$config['upload_path']          = './tmpUpload/';
		$config['allowed_types']        = 'gif|jpg|png|pdf|jpeg';
		$config['overwrite']			= true;
		$config['max_size']             = 15000; // 1MB
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;
		$this->load->library('upload', $config);
		if ($this->upload->do_upload($name)) {
			return $this->upload->data("file_name");
		}
		return '';
	}

	public function uploadInvoice()
	{
		$config['upload_path']          = './uploads/kasir/';
		$config['allowed_types']        = 'gif|jpg|png|pdf|jpeg';
		$config['overwrite']			= true;
		$config['max_size']             = 8024; // 1MB
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;
		$this->load->library('upload', $config);

		if ($this->upload->do_upload('invoice')) {
			return $this->upload->data("file_name");
		}
		return '';
	}



	public function uploads()
	{
		$this->upload->initialize([
			'upload_path'   =>  'uploads/',
			'allowed_types' =>  '*',
			'encrypt_name'  =>  TRUE,
			'file_size' => 30000
		]);

		$extractor = new Extractor;
		$extractor->upload($this->upload, [
			'user_id'      =>  $this->session->userdata('id'),
			'username'      =>  $this->session->userdata('username'),
			'tanggal'       =>  date('Y-m-d H:i:s'),
			'gambar'		=>	'',
			'keterangan'	=>	'',
			'stock'			=>	'IN STOCK'
		]);
	}

	public function extractPdf($invoice_store)
	{
		if ($invoice_store == "tokopedia") {
			return $this->tokopediaExtractPdf();
		} elseif ($invoice_store == "shoppe") {
			return $this->shopeeExtractPdf();
		} elseif ($invoice_store == "lazada") {
			return $this->lazadaExtractPdf();
		} elseif ($invoice_store == "tiktok") {
			return $this->tiktokExtractPdf();
		} elseif ($invoice_store == "cs_order") {
			return $this->CSOrderExtractPdf();
		}
	}

	public function tokopediaExtractPdf()
	{
		$parser = new Parser();

		$files = $_FILES['invoice_file'] ?? [];

		for ($i = 0; $i < count($files('name')); $i++) {
			$pdf = $parser->parseFile($files('tmp_name')[$i]);
			$pdfText = $pdf->getText();
			$pdfText = nl2br($pdfText);
			$pdfText = str_replace(" ", "", $pdfText);
			$pdfTextArr = explode("\n", $pdfText);
			return $pdfTextArr[2];
		}
	}

	public function shopeeExtractPdf()
	{
		$parser = new Parser();

		$files = $_FILES['invoice_file'] ?? [];

		for ($i = 0; $i < count($files('name')); $i++) {
			$pdf = $parser->parseFile($files('tmp_name')[$i]);
			$pdfText = $pdf->getText();
			$pdfText = nl2br($pdfText);
			$pdfText = str_replace(" ", "", $pdfText);
			$pdfTextArr = explode("\n", $pdfText);
			return $pdfTextArr[8];
		}
	}

	public function lazadaExtractPdf()
	{
		$parser = new Parser();

		$files = $_FILES['invoice_file'] ?? [];

		for ($i = 0; $i < count($files('name')); $i++) {
			$pdf = $parser->parseFile($files('tmp_name')[$i]);
			$pdfText = $pdf->getText();
			$pdfText = nl2br($pdfText);
			$pdfText = str_replace(" ", "", $pdfText);
			$pdfTextArr = explode("\n", $pdfText);
			$pdfTextArr = explode(":", $pdfTextArr[3]);
			return $pdfTextArr[2];
		}
	}

	public function CSOrderExtractPdf()
	{
		$parser = new Parser();

		$files = $_FILES['invoice_file'] ?? [];

		for ($i = 0; $i < count($files('name')); $i++) {
			$pdf = $parser->parseFile($files('tmp_name')[$i]);
			$pdfText = $pdf->getText();
			$pdfText = nl2br($pdfText);
			$pdfText = str_replace(" ", "", $pdfText);
			$pdfTextArr = explode("\n", $pdfText);
			return $pdfTextArr[7];
		}
	}

	public function tiktokExtractPdf()
	{
	}
}
