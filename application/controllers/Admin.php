<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Admin_model','am');
		$this->load->library('session');
		hakakses();
	}

	function getChart()
	{
		$kriteria = $this->am->getQuery("SELECT * FROM `kriteria`")->result();
		$data = [];
		$atlet_jkel = $this->am->getQuery("SELECT atlet_jkel, COUNT(atlet_jkel) as jml_jkel  FROM `atlet` GROUP BY atlet_jkel ORDER BY atlet_jkel ASC")->result();
		for ($i=0; $i <count($kriteria) ; $i++) { 		
						$data['atlet'] = $atlet_jkel;
		}
		
		// print_r(json_encode($data));
		return $data;
	}

	function index()
	{
		$data['title'] = "Dashoard";		
		$data['jml_atlet'] = count($this->am->getData('atlet')->result()) ;
		$data['jml_alternatif'] = count($this->am->getData('alternatif')->result()) ;
		$data['jml_kriteria'] = count($this->am->getData('kriteria')->result()) ;
		$data['jml_atlet_nilai'] = count($this->am->getQuery("SELECT DISTINCT(atlet.atlet_nama) FROM `nilai`
			INNER JOIN atlet ON nilai.atlet_id = atlet.atlet_id")->result()) ;
		$data['log'] = $this->am->getQuery("SELECT log_id, log_aktivitas, akun.akun_nama FROM `log` 
			JOIN akun ON log.akun_nik = akun.akun_nik ORDER BY `log`.`log_id` DESC")->result();
		$data['chart'] = $this->getChart();
		$data['kriteria_nama'] = $this->am->getQuery("SELECT * FROM `kriteria` ORDER BY `kriteria`.`kriteria_id` ASC")->result();
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/index',$data);
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		$this->load->view('admin/part/footer');
	}

	function akun()
	{
		$data['title'] = "Akun Pengguna";	

		$data['akun'] = $this->am->getQuery("SELECT * FROM `akun` 
			JOIN jabatan ON akun.jabatan_id = jabatan.jabatan_id 
			WHERE akun_nik NOT IN ('".$this->session->userdata('nik')."')")->result();
		$data['jabatan'] = $this->am->getData('jabatan')->result();



		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('admin/akun',$data);
		$this->load->view('admin/part/footer');

		if(isset($_POST['submit'])){
			$nik = $this->input->post('nik');
			$nik_edit = $this->input->post('nik_edit');
			$nama_lengkap = $this->input->post('nama_lengkap');
			$username = $this->input->post('username');
			$password1 = $this->input->post('password1');
			$password2= $this->input->post('password2');
			$jabatan = $this->input->post('jabatan');

			if($nik_edit == null){ //tambah
				if($password1 == $password2){ //validasi password 1 dan 2
				$get_akun = $this->db->get_where('akun',['akun_username'=>$username])->row_array();
				$akun_username = $get_akun['akun_username']; //username from db
					if($akun_username != $username ){ // username validation
						$data = [
						'akun_nik' => $nik,
						'akun_nama' => ucwords($nama_lengkap),
						'akun_username' => strtolower($username),
						'akun_password' => password_hash($password2, PASSWORD_DEFAULT),
						'jabatan_id' => $jabatan,
						];
						$this->am->insertData('akun',$data);
						$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Ditambahkan</div>');
						helper_log($this->session->userdata('nik'), 'Tambah Akun '.$nama_lengkap);
						redirect('admin/akun');
					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username Telah Terdaftar</div>');
						redirect('admin/akun');
					}
				
				} //validasi password
				else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Tidak Sama</div>');
					redirect('admin/akun');

				}
			}else{ //edit
				$data = [
						'akun_nik' => $nik_edit,
						'akun_nama' => $nama_lengkap,
						'akun_username' => $username,
						'jabatan_id' => $jabatan,
						];
				$this->db->where('akun_nik', $nik_edit);
				$this->db->update('akun', $data);	
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Edit</div>');
				helper_log($this->session->userdata('nik'), 'Edit Akun '.$nama_lengkap);
					redirect('admin/akun');	
			}
			
		} // submit
	}

	function delete_akun($id)
	{
		$this->am->Delete("akun",["akun_nik"=>$id]);
		helper_log($this->session->userdata('nik'), 'Delete Akun NIK : '.$id);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
		redirect('admin/akun');
	}

	function atlet()
	{		
		$data['title'] = "Data Atlet";	
		$data['kriteria'] = $this->am->getData('kriteria')->result();
		
		$data['jabatan'] = $this->am->getData('jabatan')->result();
		$data['atlet'] = $this->am->getData('atlet', 'atlet_nama ASC')->result();


		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('admin/atlet',$data);
		$this->load->view('admin/part/footer');

		if (isset($_POST['submit'])) {

			$nama_atlet = $this->input->post('nama_atlet');
			$jkel_atlet = $this->input->post('jkel_atlet');
			$unit_atlet = $this->input->post('unit_atlet');
			$kategori_umur_atlet = $this->input->post('kategori_umur_atlet');
			$atlet_id = $this->input->post('atlet_id');

			if($atlet_id == null){ // tambah
				$data =[
					'atlet_nama' => $nama_atlet,
					'atlet_jkel' => $jkel_atlet,
					'atlet_unit' => $unit_atlet,
					'atlet_kategori_umur'=> $kategori_umur_atlet,

				];
				$this->am->insertData('atlet',$data);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Ditambahkan</div>');
				helper_log($this->session->userdata('nik'), 'Tambah Atlet '.$nama_atlet);
				redirect('admin/atlet');
			} else{ //edit
				
				$data =[
					'atlet_id' => $atlet_id,
					'atlet_nama' => $nama_atlet,
					'atlet_jkel' => $jkel_atlet,
					'atlet_unit' => $unit_atlet,
					'atlet_kategori_umur'=> $kategori_umur_atlet,

				];
				$this->db->where('atlet_id', $atlet_id);
				$this->db->update('atlet', $data);	
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Edit</div>');
				helper_log($this->session->userdata('nik'), 'Edit Atlet '.$nama_atlet);
				redirect('admin/atlet');	
			}
		}//submit
	}

	function delete_atlet($id)
	{
		$this->am->Delete("nilai",["atlet_id"=>$id]);
		$this->am->Delete("y_q_z",["atlet_id"=>$id]);
		$this->am->Delete("integral",["atlet_id"=>$id]);
		$this->am->Delete("kategori_pertandingan_atlet",["atlet_id"=>$id]);
		$this->am->Delete("atlet",["atlet_id"=>$id]);

		helper_log($this->session->userdata('nik'), 'Delete Atlet '.$id);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
		redirect('admin/atlet');
	}


	

	function jabatan()
	{
		$data['title'] = "Data Jabatan";	
		$data['jabatan'] = $this->am->getData('jabatan')->result();
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('admin/jabatan',$data);
		$this->load->view('admin/part/footer');
		

		if(isset($_POST['submit'])){
			$jabatan_id = $this->input->post('jabatan_id');
			$jabatan_nama = $this->input->post('jabatan_nama');
			$get_jabatan = $this->db->get_where('jabatan',array('jabatan_id'=>$jabatan_id))->row_array();
			var_dump($get_jabatan);
			if($jabatan_id != $get_jabatan['jabatan_id']){
				$data = [
					'jabatan_id' => $jabatan_id,
					'jabatan_nama'=> $jabatan_nama,

				];
				$this->db->insert('jabatan', $data);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Tambah Jabatan</div>');
				helper_log($this->session->userdata('nik'), 'Tambah Jabatan '.$jabatan_nama);
				redirect('admin/jabatan');
			}else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal Tambah Karena ID atau Username Sama</div>');
				redirect('admin/jabatan');
			}
			
		}
	}

	function delete_jabatan($id)
	{
		$this->am->Delete("jabatan",["jabatan_id"=>$id]);
		helper_log($this->session->userdata('nik'), 'Delete Jabatan '.$id);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
		redirect('admin/jabatan');
	}

	function bobot()
	{
		$data['title'] = "Data Bobot";	
		$data['bobot'] = $this->am->getData('fuzzy_segitiga')->result();
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('admin/bobot',$data);
		$this->load->view('admin/part/footer');

		if($this->input->post('fuzzy_segitiga_id') <> null || $this->input->post('fuzzy_segitiga_id') <> ''){ // edit bobot
			$uraian_fuzzyfikasi = $this->input->post('uraian_fuzzyfikasi');
			$uraian_kecocokan = $this->input->post('uraian_kecocokan');
			$n1 = $this->input->post('n1');
			$n2 = $this->input->post('n2');
			$n3 = $this->input->post('n3');

			$data = [
				'uraian_fuzzyfikasi' => $uraian_fuzzyfikasi,
				'uraian_kecocokan' => $uraian_kecocokan,
				'n1' => $n1,
				'n2' => $n2,
				'n3' => $n3,
			];
			$this->db->where('fuzzy_segitiga_id', $this->input->post('fuzzy_segitiga_id'));
			$this->db->update('fuzzy_segitiga', $data);
			redirect('admin/bobot','refresh');
		}
	}

	function kriteria()
	{
		$data['title'] = "Data Kriteria";	
		$data['kriteria'] = $this->am->getData('kriteria')->result();
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('admin/kriteria',$data);
		$this->load->view('admin/part/footer');

		if (isset($_POST['submit'])) {
			$kriteria_id = $this->input->post('kriteria_id');
			$kriteria_nama = $this->input->post('kriteria_nama');

			if($kriteria_id == null){ //tambah data
				$data = [
					'kriteria_nama' => $kriteria_nama,
				];

				$this->db->insert('kriteria', $data);
				helper_log($this->session->userdata('nik'), 'Tambah Kriteria '.$kriteria_nama);
				$get_id_kriteria = $this->am->getQuery("SELECT kriteria_id FROM `kriteria` WHERE kriteria_nama = '$kriteria_nama'")->row_array(); //ambil id kriteria yang baru
				$alternatif = $this->am->getQuery("SELECT alternatif_id FROM `alternatif`")->result();
				$fuzzy_segitiga_id = $this->am->getQuery("SELECT fuzzy_segitiga_id FROM `fuzzy_segitiga`")->row_array();
				foreach ($alternatif as $a) {
					$data = [
						'alternatif_id' => $a->alternatif_id,
						'kriteria_id' => $get_id_kriteria['kriteria_id'],
						'fuzzy_segitiga_id' => $fuzzy_segitiga_id['fuzzy_segitiga_id'],
					];
					$this->db->insert('rating_kecocokan', $data );
					helper_log($this->session->userdata('nik'), 'Tambah Rating Kecocokan '.$a->alternatif_id);
				}

				$atlet = $this->am->getQuery("SELECT DISTINCT(atlet_id) FROM `nilai`")->result();
				foreach ($atlet as $atlet) {
					$data = [
						'akun_nik' => $this->session->userdata('nik'),
						'kriteria_id' => $get_id_kriteria['kriteria_id'],
						'atlet_id' => $atlet->atlet_id,
						'fuzzy_segitiga_id'=> $fuzzy_segitiga_id['fuzzy_segitiga_id'],

					];
					$this->db->insert('nilai', $data);
					helper_log($this->session->userdata('nik'), 'Tambah Nilai Per Atlet '.$atlet->atlet_id);
				}
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Ditambah</div>');
			}else{ //edit
				$data = [
					'kriteria_nama'=> $kriteria_nama,
				];

				$this->db->where('kriteria_id', $kriteria_id);
				$this->db->update('kriteria', $data);	
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Edit Data</div>');
			}
			redirect('admin/kriteria');
			helper_log($this->session->userdata('nik'), 'Edit Kriteria '.$kriteria_id);
		}
	}

	function delete_kriteria($id)
	{
		$this->am->Delete("nilai",["kriteria_id"=>$id]);
		$this->am->Delete("rating_kecocokan",["kriteria_id"=>$id]);
		$this->am->Delete("kriteria",["kriteria_id"=>$id]);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
		$this->session->set_flashdata('message1', '<div class="alert alert-success" role="alert">Nilai yang memiliki kriteria tersebut Sukses Dihapus</div>');
		$this->session->set_flashdata('message2', '<div class="alert alert-success" role="alert">Rating Kecocokan yang memiliki kriteria tersebut Sukses Dihapus</div>');
		helper_log($this->session->userdata('nik'), 'Hapus Nilai dari Kriteria '.$kriteria_id);
		helper_log($this->session->userdata('nik'), 'Hapus Rating Kecocokan dari Kriteria '.$kriteria_id);
		helper_log($this->session->userdata('nik'), 'Hapus Kriteria '.$kriteria_id);
		redirect('admin/kriteria');
	}

	function alternatif()
	{
		$data['title'] = "Data Alternatif";	
		$data['alternatif'] = $this->am->getData('alternatif')->result();
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('admin/alternatif',$data);
		$this->load->view('admin/part/footer');

		if (isset($_POST['submit'])) {
			$alternatif_id = $this->input->post('alternatif_id');
			$alternatif_nama = $this->input->post('alternatif_nama');

			if($alternatif_id == null){ //tambah
				$data = [
					'alternatif_nama' => $alternatif_nama,
				];

				$this->db->insert('alternatif', $data);
				helper_log($this->session->userdata('nik'), 'Tambah Alternatif '.$alternatif_nama);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Ditambah</div>');
			}else{ //edit
				$data = [
					'alternatif_nama'=> $alternatif_nama,
				];

				$this->db->where('alternatif_id', $alternatif_id);
				$this->db->update('alternatif', $data);	
				helper_log($this->session->userdata('nik'), 'Edit Alternatif '.$alternatif_nama);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Edit Data</div>');
			}
			redirect('admin/alternatif');
		}// submit

	}
	function delete_alternatif($id)
	{
		$this->am->Delete("rating_kecocokan",["alternatif_id"=>$id]);
		$this->am->Delete("alternatif",["alternatif_id"=>$id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
		$this->session->set_flashdata('message1', '<div class="alert alert-success" role="alert">Rating Kecocokan yang memiliki alternatif tersebut Sukses Dihapus</div>');
		helper_log($this->session->userdata('nik'), 'Delete Alternatif '.$id);
		helper_log($this->session->userdata('nik'), 'Delete Rating Kecocokan dari Alternatif '.$id);
		redirect('admin/alternatif');
	}

	function getRatingKecocokan()
	{
		$data =[];
		$alternatif = $this->am->getQuery("SELECT DISTINCT (alternatif.alternatif_nama), rating_kecocokan.alternatif_id FROM `rating_kecocokan`
		JOIN alternatif ON rating_kecocokan.alternatif_id = alternatif.alternatif_id ")->result();

		for ($i=0; $i < count($alternatif) ; $i++) { 
			$fuzzy_segitiga = $this->am->getQuery("SELECT fuzzy_segitiga.fuzzy_segitiga_id, fuzzy_segitiga.uraian_kecocokan, kriteria.kriteria_id, kriteria.kriteria_nama, alternatif.alternatif_nama  FROM `rating_kecocokan`
				JOIN kriteria ON rating_kecocokan.kriteria_id = kriteria.kriteria_id
				JOIN alternatif ON rating_kecocokan.alternatif_id = alternatif.alternatif_id
				JOIN fuzzy_segitiga ON rating_kecocokan.fuzzy_segitiga_id = fuzzy_segitiga.fuzzy_segitiga_id
				WHERE alternatif.alternatif_id =".$alternatif[$i]->alternatif_id." ORDER BY kriteria.kriteria_id asc")->result();

			$data[$i]['alternatif_id'] = $alternatif[$i]->alternatif_id; 
			$data[$i]['alternatif_nama'] = $alternatif[$i]->alternatif_nama;  
			for ($j=0; $j < count($fuzzy_segitiga) ; $j++) { 
				$data[$i]['fuzzy_segitiga'][$j]['fuzzy_segitiga_id'] = $fuzzy_segitiga[$j]->fuzzy_segitiga_id;
				$data[$i]['fuzzy_segitiga'][$j]['uraian_kecocokan'] = $fuzzy_segitiga[$j]->uraian_kecocokan;
				$data[$i]['fuzzy_segitiga'][$j]['kriteria_id'] = $fuzzy_segitiga[$j]->kriteria_id;
				$data[$i]['fuzzy_segitiga'][$j]['kriteria_nama'] = $fuzzy_segitiga[$j]->kriteria_nama;
			}
		}
		return $data;
		// print_r(json_encode($data));
	}

	function rating_kecocokan()
	{
		$data['title'] = "Data Rating Kecocokan";	
		$data['kriteria'] = $this->am->getQuery('SELECT * FROM `kriteria` ORDER BY `kriteria`.`kriteria_id` ASC')->result();
		$kriteria = $data['kriteria'];
		$data['rating_kecocokan'] = $this->getRatingKecocokan();
		$data['alternatif'] = $this->am->getQuery("SELECT * FROM `rating_kecocokan`
		RIGHT JOIN alternatif ON rating_kecocokan.alternatif_id = alternatif.alternatif_id
		WHERE rating_kecocokan_id is null
		")->result();
		$data['fuzzy_segitiga'] = $this->am->getQuery("SELECT * FROM `fuzzy_segitiga` ORDER BY n1")->result();
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('admin/rating_kecocokan',$data);
		$this->load->view('admin/part/footer');

		if (isset($_POST['submit'])) {
			foreach ($kriteria as $k) {
				$alternatif_id = $this->input->post('alternatif_id');
				$kriteria_id = $k->kriteria_id;
				$fuzzy_segitiga_id = $_POST['fuzzy_segitiga-'.strtolower($k->kriteria_id)];
				
				if($alternatif_id == null){ // tambah

					$data = [
						'alternatif_id' => $this->input->post('alternatif_nama'),
						'kriteria_id' => $kriteria_id,
						'fuzzy_segitiga_id'=> $fuzzy_segitiga_id,

					];
					$this->db->insert('rating_kecocokan', $data);
					helper_log($this->session->userdata('nik'), 'Tambah Rating Kecocokan '.$this->input->post('alternatif_nama'));
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Ditambah</div>');

				}else{ // edit
					$data = [
						'fuzzy_segitiga_id' => $fuzzy_segitiga_id,

					];
					$this->db->where('alternatif_id', $alternatif_id);
					$this->db->where('kriteria_id', $kriteria_id);
					$this->db->update('rating_kecocokan', $data);	
					helper_log($this->session->userdata('nik'), 'Edit Rating Kecocokan '.$alternatif_id);
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Edit Data</div>');
				}
			}
			redirect('admin/rating_kecocokan');
		}// submit
	}

	function delete_rating_kecocokan($id)
	{
		$this->am->Delete("rating_kecocokan",["alternatif_id"=>$id]);
		helper_log($this->session->userdata('nik'), 'Delete Rating Kecocokan '.$id);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
		redirect('admin/rating_kecocokan');
	}
	
}

