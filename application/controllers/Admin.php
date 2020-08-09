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

	

	function index()
	{
		$data['title'] = "Dashboard";		
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

		$data['akun'] = $this->am->getQuery('SELECT * FROM `akun` JOIN jabatan ON akun.jabatan_id = jabatan.jabatan_id')->result();
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
						'akun_nama' => $nama_lengkap,
						'akun_username' => $username,
						'akun_password' => password_hash($password2, PASSWORD_DEFAULT),
						'jabatan_id' => $jabatan,
						];
						$this->am->insertData('akun',$data);
						$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Ditambahkan</div>');
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
					redirect('admin/akun');	
			}
			
		} // submit
	}

	function delete_akun($id)
	{
		$this->am->Delete("akun",["akun_nik"=>$id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
		redirect('admin/akun');
	}

	function atlet()
	{		
		$data['title'] = "Data Atlet";	
		$data['kriteria'] = $this->am->getData('kriteria')->result();
		
		$data['jabatan'] = $this->am->getData('jabatan')->result();
		$data['atlet'] = $this->am->getData('atlet')->result();


		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('admin/atlet',$data);
		$this->load->view('admin/part/footer');

		if (isset($_POST['submit'])) {

			$nama_atlet = $this->input->post('nama_atlet');
			$unit_atlet = $this->input->post('unit_atlet');
			$atlet_id = $this->input->post('atlet_id');

			if($atlet_id == null){ // tambah
				$data =[
					'atlet_nama' => $nama_atlet,
					'atlet_unit' => $unit_atlet,

				];
				$this->am->insertData('atlet',$data);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Ditambahkan</div>');
				redirect('admin/atlet');
			} else{ //edit
				
				$data =[
					'atlet_id' => $atlet_id,
					'atlet_nama' => $nama_atlet,
					'atlet_unit' => $unit_atlet,

				];
				$this->db->where('atlet_id', $atlet_id);
				$this->db->update('atlet', $data);	
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Edit</div>');
				redirect('admin/atlet');	
			}
		}//submit
	}

	function delete_atlet($id)
	{
		$this->am->Delete("atlet",["atlet_id"=>$id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
		redirect('admin/atlet');
	}


	function getNilai()
	{
		$atlet = $this->am->getQuery("SELECT DISTINCT(nilai.atlet_id), atlet.atlet_nama FROM `nilai` JOIN atlet ON nilai.atlet_id = atlet.atlet_id")->result();
		$data = [];
		for ($i=0; $i < count($atlet) ; $i++) { 
			$nilai = $this->am->getQuery("SELECT kriteria.kriteria_id, nilai.nilai_kriteria, kriteria.kriteria_nama, fuzzy_segitiga.uraian_fuzzyfikasi FROM `nilai`
				JOIN kriteria ON nilai.kriteria_id = kriteria.kriteria_id
				JOIN fuzzy_segitiga ON nilai.fuzzy_segitiga_id = fuzzy_segitiga.fuzzy_segitiga_id
				WHERE nilai.atlet_id = ".$atlet[$i]->atlet_id." ORDER BY kriteria.kriteria_id ASC")->result();
			$data[$i]['atlet_id'] = $atlet[$i]->atlet_id;	
			$data[$i]['atlet_nama'] = $atlet[$i]->atlet_nama;
				for ($j=0; $j < count($nilai); $j++) { 
					$data[$i]['kriteria'][$j]['kriteria_id'] = $nilai[$j]->kriteria_id;
					$data[$i]['kriteria'][$j]['kriteria_nama'] = $nilai[$j]->kriteria_nama;
					$data[$i]['kriteria'][$j]['nilai_kriteria'] = $nilai[$j]->nilai_kriteria;
					$data[$i]['kriteria'][$j]['uraian_fuzzyfikasi'] = $nilai[$j]->uraian_fuzzyfikasi;
				}


		}
		return $data;
		// print_r(json_encode($data));
	}

	function getNilaiById()
	{
		$id = $_GET['atlet_id'];
		$data =[];
		$atlet = $this->am->getQuery("SELECT DISTINCT atlet.atlet_id, atlet.atlet_nama, atlet.atlet_unit FROM `nilai` 
			JOIN atlet ON nilai.atlet_id = atlet.atlet_id WHERE atlet.atlet_id = $id ")->result();

		for ($i=0; $i < count($atlet) ; $i++) { 
			$kriteria = $this->am->getQuery("SELECT kriteria.kriteria_id, nilai.nilai_kriteria, kriteria.kriteria_nama, fuzzy_segitiga.uraian_fuzzyfikasi FROM `nilai`
				JOIN kriteria ON nilai.kriteria_id = kriteria.kriteria_id
				JOIN fuzzy_segitiga ON nilai.fuzzy_segitiga_id = fuzzy_segitiga.fuzzy_segitiga_id
				WHERE nilai.atlet_id = $id ORDER BY kriteria.kriteria_id ASC")->result();

			$data[$i]['atlet_id'] = $atlet[$i]->atlet_id; 
			$data[$i]['atlet_nama'] = $atlet[$i]->atlet_nama;  
			$data[$i]['atlet_unit'] = $atlet[$i]->atlet_unit;  
			for ($j=0; $j < count($kriteria) ; $j++) { 
				$data[$i]['kriteria'][$j]['kriteria_id'] = $kriteria[$j]->kriteria_id;
				$data[$i]['kriteria'][$j]['kriteria_nama'] = $kriteria[$j]->kriteria_nama;
				$data[$i]['kriteria'][$j]['nilai_kriteria'] = $kriteria[$j]->nilai_kriteria;
				$data[$i]['kriteria'][$j]['uraian_fuzzyfikasi'] = $kriteria[$j]->uraian_fuzzyfikasi;
			}
		}

		echo json_encode($data); 
	}

	function getNilaiByNama($atlet_nama_cari)
	{
		$data =[];
		$atlet = $this->am->getQuery("SELECT DISTINCT atlet.atlet_id, atlet.atlet_nama, atlet.atlet_unit FROM `nilai` 
			JOIN atlet ON nilai.atlet_id = atlet.atlet_id WHERE atlet.atlet_nama LIKE '%$atlet_nama_cari%' ")->result();

		for ($i=0; $i < count($atlet) ; $i++) { 
			$kriteria = $this->am->getQuery("SELECT kriteria.kriteria_id, nilai.nilai_kriteria, kriteria.kriteria_nama, fuzzy_segitiga.uraian_fuzzyfikasi FROM `nilai`
				JOIN atlet ON nilai.atlet_id = atlet.atlet_id
				JOIN kriteria ON nilai.kriteria_id = kriteria.kriteria_id
				JOIN fuzzy_segitiga ON nilai.fuzzy_segitiga_id = fuzzy_segitiga.fuzzy_segitiga_id
				WHERE atlet.atlet_nama LIKE '%$atlet_nama_cari%'  ORDER BY kriteria.kriteria_id ASC")->result();

			$data[$i]['atlet_id'] = $atlet[$i]->atlet_id; 
			$data[$i]['atlet_nama'] = $atlet[$i]->atlet_nama;  
			$data[$i]['atlet_unit'] = $atlet[$i]->atlet_unit;  
			for ($j=0; $j < count($kriteria) ; $j++) { 
				$data[$i]['kriteria'][$j]['kriteria_id'] = $kriteria[$j]->kriteria_id;
				$data[$i]['kriteria'][$j]['kriteria_nama'] = $kriteria[$j]->kriteria_nama;
				$data[$i]['kriteria'][$j]['nilai_kriteria'] = $kriteria[$j]->nilai_kriteria;
				$data[$i]['kriteria'][$j]['uraian_fuzzyfikasi'] = $kriteria[$j]->uraian_fuzzyfikasi;
			}
		}
		return $data;
		// echo json_encode($data); 
	}

	function nilai_atlet()
	{
		
		$data['title'] = "Data Nilai Atlet";	
		$data['nilai_atlet'] = $this->getNilai();
		if(isset($_GET['cari'])){
			$atlet_nama_cari = $_GET['atlet_nama_cari'];
			$data['nilai_atlet'] = $this->getNilaiByNama($atlet_nama_cari);
		} // cari atlet by nama
		$data['atlet'] = $this->am->getQuery("SELECT DISTINCT( atlet.atlet_nama), atlet.atlet_id, atlet.atlet_unit FROM `nilai` 
			RIGHT JOIN atlet ON nilai.atlet_id = atlet.atlet_id
			WHERE nilai_id is null")->result();
		$kriteria_all = $this->am->getData('kriteria')->result();
		$data['kriteria'] = $kriteria_all;
		

		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('admin/nilai_atlet',$data);
		$this->load->view('admin/part/footer');

		if (isset($_POST['submit'])) {
			
			foreach ($kriteria_all as $key) {
				$nilai_kriteria = $_POST['kriteria-'.$key->kriteria_id];
				$atlet_id = $_POST['atlet_id'];

				if($nilai_kriteria <=100 && $nilai_kriteria >= 75){ //sangat baik sangat cocok
 					$fuzzy_segitiga_id = 4;
				}elseif ($nilai_kriteria < 75 && $nilai_kriteria >= 50 ) { //baik cocok
					$fuzzy_segitiga_id = 3;
				}elseif ($nilai_kriteria < 50 && $nilai_kriteria >=25) { // cukup baik ckup cocok
					$fuzzy_segitiga_id = 2;
				}elseif ($nilai_kriteria < 25) { // tidak baik tidak cocok
					$fuzzy_segitiga_id = 1;
				}
				if($atlet_id == null){ //TAMBAH DATA
					$data = [
					'akun_nik' => $this->session->userdata('nik'),
					'atlet_id' => $this->input->post('atlet_nama'),
					'kriteria_id' => $key->kriteria_id,
					'nilai_kriteria' => $nilai_kriteria,
					'fuzzy_segitiga_id' => $fuzzy_segitiga_id,
					];
					$this->db->insert('nilai', $data);

					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Ditambah</div>');
				}else{ //EDIT DATA
					$data = [
					'akun_nik' => $this->session->userdata('nik'),
					'kriteria_id' => $key->kriteria_id,
					'nilai_kriteria' => $nilai_kriteria,
					'fuzzy_segitiga_id' => $fuzzy_segitiga_id,
					];
					$this->db->where('atlet_id', $atlet_id);
					$this->db->where('kriteria_id', $key->kriteria_id);
					$this->db->update('nilai', $data);	
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Edit Data</div>');
				}
				
			}
			// $this->db->insert_batch('nilai', $data);
			redirect('admin/nilai_atlet');
		}//submit


	}

	function delete_nilai($id)
	{
		$this->am->Delete("nilai",["atlet_id"=>$id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
		redirect('admin/nilai_atlet');
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
		}
	}

	function delete_kriteria($id)
	{
		$this->am->Delete("kriteria",["kriteria_id"=>$id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
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

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Ditambah</div>');
			}else{ //edit
				$data = [
					'alternatif_nama'=> $alternatif_nama,
				];

				$this->db->where('alternatif_id', $alternatif_id);
				$this->db->update('alternatif', $data);	
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Edit Data</div>');
			}
			redirect('admin/alternatif');
		}// submit

	}
	function delete_alternatif($id)
	{
		$this->am->Delete("alternatif",["alternatif_id"=>$id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
		redirect('admin/alternatif');
	}

	function getRatingKecocokan()
	{
		$data =[];
		$alternatif = $this->am->getQuery("SELECT DISTINCT (alternatif.alternatif_nama), rating_kecocokan.alternatif_id FROM `rating_kecocokan`
		JOIN alternatif ON rating_kecocokan.alternatif_id = alternatif.alternatif_id ")->result();

		for ($i=0; $i < count($alternatif) ; $i++) { 
			$fuzzy_segitiga = $this->am->getQuery("SELECT fuzzy_segitiga.fuzzy_segitiga_id, fuzzy_segitiga.uraian_kecocokan, kriteria.kriteria_nama, alternatif.alternatif_nama  FROM `rating_kecocokan`
				JOIN kriteria ON rating_kecocokan.kriteria_id = kriteria.kriteria_id
				JOIN alternatif ON rating_kecocokan.alternatif_id = alternatif.alternatif_id
				JOIN fuzzy_segitiga ON rating_kecocokan.fuzzy_segitiga_id = fuzzy_segitiga.fuzzy_segitiga_id
				WHERE alternatif.alternatif_id =".$alternatif[$i]->alternatif_id." ORDER BY kriteria.kriteria_id asc")->result();

			$data[$i]['alternatif_id'] = $alternatif[$i]->alternatif_id; 
			$data[$i]['alternatif_nama'] = $alternatif[$i]->alternatif_nama;  
			for ($j=0; $j < count($fuzzy_segitiga) ; $j++) { 
				$data[$i]['fuzzy_segitiga'][$j]['fuzzy_segitiga_id'] = $fuzzy_segitiga[$j]->fuzzy_segitiga_id;
				$data[$i]['fuzzy_segitiga'][$j]['uraian_kecocokan'] = $fuzzy_segitiga[$j]->uraian_kecocokan;
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
				$fuzzy_segitiga_id = $_POST['fuzzy_segitiga-'.strtolower($k->kriteria_nama)];
				
				if($alternatif_id == null){ // tambah

					$data = [
						'alternatif_id' => $this->input->post('alternatif_nama'),
						'kriteria_id' => $kriteria_id,
						'fuzzy_segitiga_id'=> $fuzzy_segitiga_id,

					];
					$this->db->insert('rating_kecocokan', $data);
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Ditambah</div>');

				}else{ // edit
					$data = [
						'fuzzy_segitiga_id' => $fuzzy_segitiga_id,

					];
					$this->db->where('alternatif_id', $alternatif_id);
					$this->db->where('kriteria_id', $kriteria_id);
					$this->db->update('rating_kecocokan', $data);	
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Edit Data</div>');
				}
			}
			redirect('admin/rating_kecocokan');
		}// submit
	}

	function delete_rating_kecocokan($id)
	{
		$this->am->Delete("rating_kecocokan",["alternatif_id"=>$id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
		redirect('admin/rating_kecocokan');
	}

	function getPerangkingan()
	{
		$data =[];
		
		$atlet = $this->am->getQuery("SELECT DISTINCT(atlet.atlet_nama), atlet.atlet_id FROM `y_q_z`
			JOIN alternatif ON y_q_z.alternatif_id = alternatif.alternatif_id
			JOIN atlet ON y_q_z.atlet_id = atlet.atlet_id")->result();
		for ($i=0; $i < count($atlet) ; $i++) { 
			$data[$i]['atlet_id'] = $atlet[$i]->atlet_id; 
			$data[$i]['atlet_nama'] = $atlet[$i]->atlet_nama;
			$y_q_z = $this->am->getQuery("SELECT * FROM `y_q_z` 
				JOIN alternatif ON y_q_z.alternatif_id = alternatif.alternatif_id
				WHERE atlet_id = ".$atlet[$i]->atlet_id ."
                ORDER BY atlet_id, alternatif.alternatif_id ASC")->result();
			for ($j=0; $j < count($y_q_z) ; $j++) { 
				$data[$i]['y_q_z'][$j]['alternatif_nama'] = $y_q_z[$j]->alternatif_nama;
			  	$data[$i]['y_q_z'][$j]['nilai_y'] = $y_q_z[$j]->nilai_y;
			  	$data[$i]['y_q_z'][$j]['nilai_q'] = $y_q_z[$j]->nilai_q;
			  	$data[$i]['y_q_z'][$j]['nilai_z'] = $y_q_z[$j]->nilai_z;
			  }  
		}
		return $data;
		// print_r(json_encode($data));
	}

	function perangkingan()
	{
		$data['title'] = "Data Rangking Atlet Terhadap Alternatif";	
		$data['perangkingan'] = $this->getPerangkingan();
		$data['atlet'] = $this->am->getQuery("SELECT * FROM `y_q_z`
			RIGHT JOIN atlet ON y_q_z.atlet_id = atlet.atlet_id
			WHERE y_q_z_id is null")->result();
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('admin/perangkingan',$data);
		$this->load->view('admin/part/footer');


		$kriteria = $this->am->getData('kriteria')->result();
		$jml_kriteria = count($kriteria);
		$alternatif = $this->am->getData('alternatif')->result();
		$jml_alternatif = count($alternatif);
		$temp = 0;
		if(isset($_POST['submit'])){
			$atlet_id = $this->input->post('atlet_id');
			$atlet_nama = $this->input->post('atlet_nama');
			if ($atlet_id == null) { //simpan
						$nilai_atlet = $this->am->getQuery("SELECT * FROM `nilai`
						JOIN fuzzy_segitiga ON nilai.fuzzy_segitiga_id = fuzzy_segitiga.fuzzy_segitiga_id
						WHERE atlet_id = $atlet_nama ORDER BY kriteria_id ASC")->result();
						if ($nilai_atlet == null) {
							$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Mohon Isi Nilai Atlet</div>');
						}else{
							foreach ($alternatif as $key) {
								$rating_kecocokan = $this->am->getQuery("SELECT * FROM `rating_kecocokan`
								JOIN fuzzy_segitiga ON rating_kecocokan.fuzzy_segitiga_id = fuzzy_segitiga.fuzzy_segitiga_id
				                WHERE alternatif_id = ".$key->alternatif_id."
				                ORDER BY alternatif_id, kriteria_id asc
				                ")->result();

								for ($i=0; $i < $jml_kriteria ; $i++) {  //nilai Y
									$nilai_perkalian = ($nilai_atlet[$i]->n1 * $rating_kecocokan[$i]->n1) + $temp;
									$temp = $nilai_perkalian;
								}
								$nilai_y = (1/$jml_kriteria)* $nilai_perkalian ;
								$temp = 0; $nilai_perkalian = 0;
								for ($i=0; $i < $jml_kriteria ; $i++) {  //nilai Q
									$nilai_perkalian = ($nilai_atlet[$i]->n2 * $rating_kecocokan[$i]->n2) + $temp;
									$temp = $nilai_perkalian;
								}
								$nilai_q = (1/$jml_kriteria)* $nilai_perkalian ;
								$temp = 0; $nilai_perkalian = 0;
								for ($i=0; $i < $jml_kriteria ; $i++) {  //nilai Z
									$nilai_perkalian = ($nilai_atlet[$i]->n3 * $rating_kecocokan[$i]->n3) + $temp;
									$temp = $nilai_perkalian;
								}
								$nilai_z = (1/$jml_kriteria)* $nilai_perkalian ;
								$temp = 0; $nilai_perkalian = 0;

								$data = [
									'nilai_y' => $nilai_y,
									'nilai_q' => $nilai_q,
									'nilai_z' => $nilai_z,
									'alternatif_id' => $key->alternatif_id,
									'atlet_id' => $atlet_nama,

								];

								$this->am->insertData('y_q_z',$data);
								
							}
							$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Ditambahkan</div>');
						}
							
					
			}else{ //hitung ulang
				$nilai_atlet = $this->am->getQuery("SELECT * FROM `nilai`
						JOIN fuzzy_segitiga ON nilai.fuzzy_segitiga_id = fuzzy_segitiga.fuzzy_segitiga_id
						WHERE atlet_id = $atlet_id ORDER BY kriteria_id ASC")->result();
				if($nilai_atlet == null){
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Mohon Isi Nilai Atlet</div>');
				}else{
					foreach ($alternatif as $key) {
						$rating_kecocokan = $this->am->getQuery("SELECT * FROM `rating_kecocokan`
						JOIN fuzzy_segitiga ON rating_kecocokan.fuzzy_segitiga_id = fuzzy_segitiga.fuzzy_segitiga_id
		                WHERE alternatif_id = ".$key->alternatif_id."
		                ORDER BY alternatif_id, kriteria_id asc
		                ")->result();

						for ($i=0; $i < $jml_kriteria ; $i++) {  //nilai Y
							$nilai_perkalian = ($nilai_atlet[$i]->n1 * $rating_kecocokan[$i]->n1) + $temp;
							$temp = $nilai_perkalian;
						}
						$nilai_y = (1/$jml_kriteria)* $nilai_perkalian ;
						$temp = 0; $nilai_perkalian = 0;
						for ($i=0; $i < $jml_kriteria ; $i++) {  //nilai Q
							$nilai_perkalian = ($nilai_atlet[$i]->n2 * $rating_kecocokan[$i]->n2) + $temp;
							$temp = $nilai_perkalian;
						}
						$nilai_q = (1/$jml_kriteria)* $nilai_perkalian ;
						$temp = 0; $nilai_perkalian = 0;
						for ($i=0; $i < $jml_kriteria ; $i++) {  //nilai Z
							$nilai_perkalian = ($nilai_atlet[$i]->n3 * $rating_kecocokan[$i]->n3) + $temp;
							$temp = $nilai_perkalian;
						}
						$nilai_z = (1/$jml_kriteria)* $nilai_perkalian ;
						$temp = 0; $nilai_perkalian = 0;

						$data = [
							'nilai_y' => $nilai_y,
							'nilai_q' => $nilai_q,
							'nilai_z' => $nilai_z,

						];
						$this->db->where('alternatif_id', $key->alternatif_id);
						$this->db->where('atlet_id', $atlet_id);
						$this->db->update('y_q_z', $data);	
						
						
					}
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Edit Data</div>');
				}
					
			}
			
				redirect('admin/perangkingan');
			
		}//submit
		

	}

	function getKeoptimisan()
	{
		$data =[];
		
        $kesimpulan = "";
		$atlet = $this->am->getQuery("SELECT DISTINCT atlet.atlet_id, atlet.atlet_nama, atlet.atlet_unit FROM `integral`
			JOIN atlet ON integral.atlet_id = atlet.atlet_id")->result();
		for ($i=0; $i < count($atlet) ; $i++) { 
			$data[$i]['atlet_id'] = $atlet[$i]->atlet_id; 
			$data[$i]['atlet_nama'] = $atlet[$i]->atlet_nama;
			$integral = $this->am->getQuery("SELECT * FROM `integral`
				JOIN alternatif ON integral.alternatif_id = alternatif.alternatif_id
				WHERE atlet_id = ".$atlet[$i]->atlet_id."
				ORDER BY integral.alternatif_id ASC")->result();
			$temp = 0;
        	$temp_alternatif = " ";
			for ($j=0; $j < count($integral) ; $j++) { 
				
				$data[$i]['integral'][$j]['alternatif_id'] = $integral[$j]->alternatif_id;
				$data[$i]['integral'][$j]['alternatif_nama'] = $integral[$j]->alternatif_nama;
			  	$data[$i]['integral'][$j]['a_0'] = $integral[$j]->a_0;
			  	$data[$i]['integral'][$j]['a_0_5'] = $integral[$j]->a_0_5;
			  	$data[$i]['integral'][$j]['a_1'] = $integral[$j]->a_1;
			  	if($integral[$j]->a_1 > $temp){
	                 	$temp = $integral[$j]->a_1;
	                 	$temp_alternatif = $integral[$j]->alternatif_nama;


	            }elseif($integral[$j]->a_1 == $temp){
	                    $kesimpulan = $integral[$j]->alternatif_nama." Dan ". $temp_alternatif;
	            }else{
	                    $kesimpulan = $integral[$j]->alternatif_nama;
	            }
	               
			  }
			  $data[$i]['temp'] = $temp;  
			  $data[$i]['temp_alternatif'] = $temp_alternatif;  
			  $data[$i]['kesimpulan'] = $kesimpulan;  
		}
		return $data;
		// print_r(json_encode($data));
	}

	function keoptimisan()
	{
		$data['title'] = "Data Derajat Keoptimisan Atlet";
		$data['keoptimisan'] = $this->getKeoptimisan();
		$data['atlet'] = $this->am->getQuery("SELECT DISTINCT atlet.atlet_nama, atlet.atlet_id FROM `integral`
			RIGHT JOIN atlet on integral.atlet_id = atlet.atlet_id
			RIGHT JOIN y_q_z ON y_q_z.atlet_id = atlet.atlet_id
			WHERE integral.integral_id is null")->result();
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('admin/keoptimisan',$data);
		$this->load->view('admin/part/footer');

		if(isset($_POST['submit'])){
			$atlet_nama = $this->input->post('atlet_nama');
			$y_q_z = $this->am->getQuery("SELECT * FROM `y_q_z`
				WHERE atlet_id = ".$atlet_nama)->result();
			foreach ($y_q_z as $key) {
				$a_0 = (1/2)*((0)*($key->nilai_z)+($key->nilai_q)+(1-0)*($key->nilai_y));
				$a_0_5 = (1/2)*((0.5)*($key->nilai_z)+($key->nilai_q)+(1-0.5)*($key->nilai_y));
				$a_1 = (1/2)*((1)*($key->nilai_z)+($key->nilai_q)+(1-1)*($key->nilai_y));

				$data = [
					'a_0' => $a_0,
					'a_0_5' => $a_0_5,
					'a_1' => $a_1,
					'alternatif_id' => $key->alternatif_id,
					'atlet_id' => $atlet_nama,
				];
				$this->am->insertData('integral',$data);
			}
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Ditambahkan</div>');
			redirect('admin/keoptimisan');

		} // submit
	}
}

