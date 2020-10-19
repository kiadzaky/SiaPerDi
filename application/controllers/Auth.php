<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->library('form_validation');
		$this->load->library('session');
	}

	function index()
	{
		if($this->session->userdata('nik')){
			redirect('admin');
		}else{
			$this->load->view('auth/login');
			if(isset($_POST['submit'])){
				$username = $this->input->post('username');
				$password = $this->input->post('password');

				$get_akun = $this->db->get_where('akun',['akun_username'=>$username])->row_array();
				$password_verify = password_verify($password, $get_akun['akun_password']);
				if($password_verify){
					$data = [
						'nama' => $get_akun['akun_nama'],
						'nik' => $get_akun['akun_nik'],
						'jabatan_id' => $get_akun['jabatan_id'],
					];
					$this->session->set_userdata($data);
					if($get_akun['jabatan_id'] == 1){ //pelatih
						redirect('pelatih/index');
					}elseif ($get_akun['jabatan_id'] == 2) { //bagian kepelatihan
						redirect('kepelatihan/index');
					}
					else{ // admin
						redirect('admin/index');
					}
					
					
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Salah Username atau Password</div>');
					redirect('auth');
				}
			}
		}
		
	}

	public function logout()
	{
		$this->session->unset_userdata('nik');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('id_jabatan');
		session_destroy();
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil logout.</div>');
			redirect('auth');
	}

	function block()
	{
		$get_data = $this->db->get_where('jabatan',['jabatan_id'=>$this->session->userdata('jabatan_id')])->row_array();
		echo "Akses Ditolak!!";
		echo "<a href = ".base_url('').$get_data['jabatan_nama']." >Kembali</a>";
	}

}