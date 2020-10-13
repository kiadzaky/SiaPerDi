<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Admin_model','am');
		$this->load->library('session');
		
	}

	function index()
	{
		$data['title'] = "Profil Anda";		
		$data['akun'] = $this->am->getQuery("SELECT * FROM `akun` 
			JOIN jabatan ON akun.jabatan_id = jabatan.jabatan_id
			WHERE akun_nik = ".$this->session->userdata('nik'))->result();
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('profil',$data);
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		$this->load->view('admin/part/footer');
		if (isset($_POST['submit'])) {
			$akun_username = $this->input->post('akun_username');
			$akun_nama = $this->input->post('akun_nama');
			$data = [
						'akun_username' => $akun_username,
						'akun_nama' => $akun_nama,
						
					];
				$this->db->where('akun_nik', $this->input->post('akun_nik'));
				$this->db->update('akun', $data);	
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Ganti Profil</div>');
					redirect('profil');	
		}
		
	}
	function ganti_password()
	{
		if ($this->input->post('akun_nik') == $this->session->userdata('nik')) {
			$akun_password = $this->input->post('akun_password');
			$akun_password1 = $this->input->post('akun_password1');
			if($akun_password1 == $akun_password){
				$data = [
							'akun_password' => password_hash($akun_password1, PASSWORD_DEFAULT) ,
							];
				$this->db->where('akun_nik', $this->input->post('akun_nik'));
				$this->db->update('akun', $data);	
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Ganti Password</div>');
					redirect('profil');	
			}else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Tidak Sama</div>');
					redirect('profil');	
			}
		}
		
	}

}