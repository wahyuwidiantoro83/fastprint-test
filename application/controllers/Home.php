<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
        $this->load->model('produk');

		$this->load->model('status');

        $data['result'] = $this->produk->getAllData();

		$data['status'] = $this->status->getAllStatus();

		$this->load->view('index', $data);
	}

	public function tambahView(){
		$this->load->model('status');
		$this->load->model('kategori');
		$this->load->library('session');

		$data['status'] = $this->status->getAllStatus();
		$data['kategori'] = $this->kategori->getAllKategori();
		$data['validation_errors'] = $this->session->flashdata('validation_add_errors')?$this->session->flashdata('validation_add_errors'):null;

		$this->load->view('tambah_produk',$data);
	}

	public function aksiTambah(){
		if ($this->input->post()) {
			$nama_produk = $this->input->post('nama_produk');
			$harga = $this->input->post('harga');
			$kategori_id = $this->input->post('kategori');
			$status_id = $this->input->post('status');

			//Validation
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nama_produk', 'nama_produk', 'required');
			$this->form_validation->set_rules('harga', 'harga', 'required|numeric');
			$this->form_validation->set_rules('kategori', 'kategori', 'required');
			$this->form_validation->set_rules('status', 'status', 'required');

			if ($this->form_validation->run() == FALSE)
                {
					$this->load->library('session');
					$this->session->set_flashdata('validation_add_errors', validation_errors());
					redirect(base_url().'produk/tambah');
                }
                else
                {
			
					$this->load->model('produk');
			
					$result = $this->produk->insertProduk($nama_produk, $harga, $kategori_id, $status_id);
			
					if ($result) {
						redirect(base_url());
					} else {
						echo "Gagal menambahkan produk.";
					}
                }

			
		} else {
			echo "Tidak ada data yang dikirim.";
		}

	}

	public function ubahView($id){
		$this->load->model('status');
		$this->load->model('produk');
		$this->load->model('kategori');
		$this->load->library('session');

		$data['status'] = $this->status->getAllStatus();
		$data['kategori'] = $this->kategori->getAllKategori();
		$data['data_produk'] = $this->produk->getProdukById($id);
		$data['validation_errors'] = $this->session->flashdata('validation_update_errors')?$this->session->flashdata('validation_update_errors'):null;

		$this->load->view('ubah_produk',$data);
	}

	public function aksiUbah(){
		if ($this->input->post()) {
			$data['nama_produk'] = $this->input->post('nama_produk');
			$data['harga'] = $this->input->post('harga');
			$data['kategori_id'] = $this->input->post('kategori');
			$data['status_id'] = $this->input->post('status');
			$id = $this->input->post('id_produk');

			//Validation
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_produk', 'id_produk', 'required');
			$this->form_validation->set_rules('nama_produk', 'nama_produk', 'required');
			$this->form_validation->set_rules('harga', 'harga', 'required|numeric');
			$this->form_validation->set_rules('kategori', 'kategori', 'required');
			$this->form_validation->set_rules('status', 'status', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->library('session');
				$this->session->set_flashdata('validation_update_errors', validation_errors());
				redirect(base_url().'produk/ubah/'.$id);
			}
			else
			{
		
				$this->load->model('produk');
		
				$result = $this->produk->updateProduk($data,$id);
		
				if ($result) {
					redirect(base_url());
				} else {
					echo "Gagal ubah produk.";
				}
			}

			
	

		} else {
			echo "Tidak ada data yang dikirim.";
		}

	}

	public function deleteProduk($id){
		$this->load->model('produk');

		$result = $this->produk->deleteProduk($id);

		if ($result) {
			echo json_encode(['message' => 'Item deleted successfully']);
		}
	}

	public function getProdukFilter(){
		$result;
		$filter = $_GET['status'];

		$this->load->model('produk');

		if ($filter) {
			$result = $this->produk->getAllData($filter);
		} else {
			$result = $this->produk->getAllData();
		}

		echo json_encode($result);
	}

	public function getDataFromAPI()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://recruitment.fastprint.co.id/tes/api_tes_programmer',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'username=tesprogrammer111223C00&password=f016e5eef673d97be29dc9941381bbdb',
			CURLOPT_HTTPHEADER => array(
			  'Content-Type: application/x-www-form-urlencoded',
			  'Cookie: ci_session=u26t3loop91b6o1bpf4vgnvbbncihi06'
			),
			CURLOPT_HEADER => true,
		  ));
		  
		  $response = curl_exec($curl);
		  
		  $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		  $header = substr($response, 0, $headerSize);
		  
		  preg_match('/X-Credentials-Username: (.+)/', $header, $usernameMatch);
		  preg_match('/tesprogrammer\d+C\d+/', trim($usernameMatch[1]), $matches);
		  $passwordDate = preg_replace('/\D/', '', $matches[0]);
		  
		  curl_close($curl);

		  $username = $matches[0];
		  $password = md5("bisacoding-" . substr($passwordDate, 0, 2) . "-" . substr($passwordDate, 2, 2) . "-" . substr($passwordDate, 4,2));
		  
		  $result = json_decode($this->getData($username,$password));

		  $kategoriList = array_values(array_unique(array_column($result->data, 'kategori')));

		  $statusList = array_values(array_unique(array_column($result->data, 'status')));

		  $this->load->model('kategori');

		  for ($i=0; $i < count($kategoriList) ; $i++) { 
			$this->kategori->insertKategori($kategoriList[$i]);
		  }

		  $currKategori = $this->kategori->getAllKategori();

		  $this->load->model('status');

		  for ($i=0; $i < count($statusList) ; $i++) { 
			$this->status->insertStatus($statusList[$i]);
		  }

		  $currStatus = $this->status->getAllStatus();

		  $this->load->model('produk');

		  for ($i=0; $i < count($result->data); $i++) { 

			$nama = $result->data[$i]->nama_produk;
			$harga = $result->data[$i]->harga;
			$kategori;
			$status;

			for ($j=0; $j < count($currKategori); $j++) { 
				if ($currKategori[$j]['nama_kategori'] === $result->data[$i]->kategori) {
					$kategori = $currKategori[$j]['id_kategori'];
				}
			}

			for ($k=0; $k < count($currStatus); $k++) { 
				if ($currStatus[$k]['nama_status'] === $result->data[$i]->status) {
					$status = $currStatus[$k]['id_status'];
				}
			}
			$this->produk->insertProduk($nama,$harga,$kategori,$status);
		  }

		  echo "<h1>Succes get data from API</h1><a href='http://localhost/fastprint/'>Back to Home</a>";

	}

	function getData($username,$password) {
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://recruitment.fastprint.co.id/tes/api_tes_programmer',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => "username=$username&password=$password",
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded',
			'Cookie: ci_session=u26t3loop91b6o1bpf4vgnvbbncihi06'
		),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		return $response;
	}
}
