<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelatih extends CI_Controller {
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
		$jml_atlet = count($this->am->getData('atlet')->result()) ;
		$data['jml_atlet'] = $jml_atlet;	
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/index',$data);
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		$this->load->view('admin/part/footer');
	}	

	function atlet()
	{
		$data['title'] = "Data Atlet";	
		$data['atlet'] = $this->am->getData('atlet')->result() ;
		
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('pelatih/atlet',$data);
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		$this->load->view('admin/part/footer');
	}

	function getNilai()
	{
		$atlet = $this->am->getQuery("SELECT DISTINCT(nilai.atlet_id), atlet.atlet_nama FROM `nilai` JOIN atlet ON nilai.atlet_id = atlet.atlet_id")->result();
		$data = [];
		for ($i=0; $i < count($atlet) ; $i++) { 
			$nilai = $this->am->getQuery("SELECT kriteria.kriteria_id, kriteria.kriteria_nama, fuzzy_segitiga.uraian_fuzzyfikasi, fuzzy_segitiga.fuzzy_segitiga_id FROM `nilai`
				JOIN kriteria ON nilai.kriteria_id = kriteria.kriteria_id
				JOIN fuzzy_segitiga ON nilai.fuzzy_segitiga_id = fuzzy_segitiga.fuzzy_segitiga_id
				WHERE nilai.atlet_id = ".$atlet[$i]->atlet_id." ORDER BY kriteria.kriteria_id ASC")->result();
			$data[$i]['atlet_id'] = $atlet[$i]->atlet_id;	
			$data[$i]['atlet_nama'] = $atlet[$i]->atlet_nama;
				for ($j=0; $j < count($nilai); $j++) { 
					$data[$i]['kriteria'][$j]['kriteria_id'] = $nilai[$j]->kriteria_id;
					$data[$i]['kriteria'][$j]['kriteria_nama'] = $nilai[$j]->kriteria_nama;
					$data[$i]['kriteria'][$j]['fuzzy_segitiga_id'] = $nilai[$j]->fuzzy_segitiga_id;
					$data[$i]['kriteria'][$j]['uraian_fuzzyfikasi'] = $nilai[$j]->uraian_fuzzyfikasi;
				}


		}
		return $data;
		// print_r(json_encode($data));
	}

	function getNilaiByNama($atlet_nama_cari)
	{
		$data =[];
		$atlet = $this->am->getQuery("SELECT DISTINCT atlet.atlet_id, atlet.atlet_nama, atlet.atlet_unit FROM `nilai` 
			JOIN atlet ON nilai.atlet_id = atlet.atlet_id WHERE atlet.atlet_nama LIKE '%$atlet_nama_cari%' ")->result();

		for ($i=0; $i < count($atlet) ; $i++) { 
			$kriteria = $this->am->getQuery("SELECT kriteria.kriteria_id, kriteria.kriteria_nama, fuzzy_segitiga.uraian_fuzzyfikasi, fuzzy_segitiga.fuzzy_segitiga_id FROM `nilai`
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
				$data[$i]['kriteria'][$j]['fuzzy_segitiga_id'] = $nilai[$j]->fuzzy_segitiga_id;
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
		$data['bobot'] = $this->am->getData('fuzzy_segitiga')->result();
		
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('pelatih/nilai_atlet',$data);
		$this->load->view('admin/part/footer');

		if (isset($_POST['submit'])) {
			
			foreach ($kriteria_all as $key) {
				$atlet_id = $_POST['atlet_id'];
				$fuzzy_segitiga_id = $_POST['fuzzy_segitiga_id_'.$key->kriteria_id];
				if($atlet_id == null){ //TAMBAH DATA
					$data = [
					'akun_nik' => $this->session->userdata('nik'),
					'atlet_id' => $this->input->post('atlet_nama'),
					'kriteria_id' => $key->kriteria_id,
					'fuzzy_segitiga_id' => $fuzzy_segitiga_id,
					];
					$this->db->insert('nilai', $data);
					helper_log($this->session->userdata('nik'), 'Tambah Nilai Atlet '.$this->input->post('atlet_nama'));
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Ditambah</div>');
				}else{ //EDIT DATA
					$data = [
					'akun_nik' => $this->session->userdata('nik'),
					'kriteria_id' => $key->kriteria_id,
					'fuzzy_segitiga_id' => $fuzzy_segitiga_id,
					];
					$this->db->where('atlet_id', $atlet_id);
					$this->db->where('kriteria_id', $key->kriteria_id);
					$this->db->update('nilai', $data);	
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Edit Data</div>');
					// edit nilai keoptimisan dan nilai perangkingan
					$this->hitungPerangkingan($atlet_id, $atlet_id);
					$this->hitungKeoptimisan($atlet_id, $atlet_id);
					helper_log($this->session->userdata('nik'), 'Edit Nilai Atlet '.$this->input->post('atlet_nama'));
				}
				
			}
			redirect('pelatih/nilai_atlet');
		}//submit


	}

	function delete_nilai($id)
	{
		$this->am->Delete("nilai",["atlet_id"=>$id]);
		$this->am->Delete("kategori_pertandingan_atlet",["atlet_id"=>$id]);
		$this->am->Delete("y_q_z",["atlet_id"=>$id]);
		$this->am->Delete("integral",["atlet_id"=>$id]);
		helper_log($this->session->userdata('nik'), 'Delete Nilai Atlet '.$id);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses Dihapus</div>');
		redirect('pelatih/nilai_atlet');
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
		
		$this->load->view('pelatih/perangkingan',$data);
		$this->load->view('admin/part/footer');


		$kriteria = $this->am->getData('kriteria')->result();
		$jml_kriteria = count($kriteria);
		$alternatif = $this->am->getData('alternatif')->result();
		$jml_alternatif = count($alternatif);
		$temp = 0;
		if(isset($_POST['submit'])){
			$atlet_id = $this->input->post('atlet_id');
			$atlet_nama = $this->input->post('atlet_nama');
			$this->hitungPerangkingan($atlet_nama, $atlet_id);
			helper_log($this->session->userdata('nik'), 'Tambah Perangkingan Atlet '.$this->input->post('atlet_nama'));
			redirect('pelatih/perangkingan');
			
			
		}//submit
	}
	function hitungPerangkingan($atlet_nama, $atlet_id)
	{
		$kriteria = $this->am->getData('kriteria')->result();
		$jml_kriteria = count($kriteria);
		// echo $jml_kriteria;
		$alternatif = $this->am->getData('alternatif')->result();
		$jml_alternatif = count($alternatif);
		$temp = 0;
				$nilai_atlet = $this->am->getQuery("SELECT * FROM `nilai`
					JOIN fuzzy_segitiga ON nilai.fuzzy_segitiga_id = fuzzy_segitiga.fuzzy_segitiga_id
					WHERE atlet_id = $atlet_nama ORDER BY kriteria_id ASC")->result();
						if ($nilai_atlet == null) {
							$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Mohon Isi Nilai Atlet</div>');
						}else{
							$alternatif_in_rk = $this->am->getQuery("SELECT rating_kecocokan.alternatif_id FROM `rating_kecocokan` 
								RIGHT JOIN alternatif ON rating_kecocokan.alternatif_id = alternatif.alternatif_id WHERE rating_kecocokan.alternatif_id is null")->result();
							if(count($alternatif_in_rk) == 0){ //deteksi alternatif sudah masuk rating kecocokan
									foreach ($alternatif as $key) { //perulangan sesuai jml alternatif
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

										if($atlet_id == null){ //simpan

											$data = [
												'nilai_y' => $nilai_y,
												'nilai_q' => $nilai_q,
												'nilai_z' => $nilai_z,
												'alternatif_id' => $key->alternatif_id,
												'atlet_id' => $atlet_nama,

											];

											$this->am->insertData('y_q_z',$data);
											$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Ditambahkan</div>');
										}else{ //hitung ulang
											$data = [
												'nilai_y' => $nilai_y,
												'nilai_q' => $nilai_q,
												'nilai_z' => $nilai_z,

											];
											$this->db->where('alternatif_id', $key->alternatif_id);
											$this->db->where('atlet_id', $atlet_id);
											$this->db->update('y_q_z', $data);	
											$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Hitung Ulang dan Edit Data</div>');
										}
									
									}
							}else{
								$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Mohon Isi Nilai Rating Kecocokan di Fitur Rating Kecocokan</div>');
								redirect('pelatih/perangkingan','refresh');
							}
							
							
						}
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
				ORDER BY integral.a_1 DESC")->result();
			for ($j=0; $j < count($integral) ; $j++) { 
					
					$data[$i]['integral'][$j]['alternatif_id'] = $integral[$j]->alternatif_id;
					$data[$i]['integral'][$j]['alternatif_nama'] = $integral[$j]->alternatif_nama;
				  	$data[$i]['integral'][$j]['a_0'] = $integral[$j]->a_0;
				  	$data[$i]['integral'][$j]['a_0_5'] = $integral[$j]->a_0_5;
				  	$data[$i]['integral'][$j]['a_1'] = $integral[$j]->a_1;
			}
		}
		return $data;
		// print_r(json_encode($data));
	}

	

	function getKeoptimisanByNama($atlet_nama_cari)
	{
		$data =[];
		
        $kesimpulan = "";
		$atlet = $this->am->getQuery("SELECT DISTINCT atlet.atlet_id, atlet.atlet_nama, atlet.atlet_unit FROM `integral`
			JOIN atlet ON integral.atlet_id = atlet.atlet_id WHERE atlet.atlet_nama LIKE '%$atlet_nama_cari%' ")->result();
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
	                    $kesimpulan = $temp_alternatif;
	            }	               
			  }
			  $data[$i]['temp'] = $temp;  
			  $data[$i]['temp_alternatif'] = $temp_alternatif;  
			  $data[$i]['kesimpulan'] = $kesimpulan;  
		}
		return $data;
		// print_r(json_encode($data));
	}
	function hitungKeoptimisan($atlet_nama, $atlet_id)
	{
			$y_q_z = $this->am->getQuery("SELECT * FROM `y_q_z`
				WHERE atlet_id = ".$atlet_nama)->result();
			foreach ($y_q_z as $key) {
				$a_0 = (1/2)*((0)*($key->nilai_z)+($key->nilai_q)+(1-0)*($key->nilai_y));
				$a_0_5 = (1/2)*((0.5)*($key->nilai_z)+($key->nilai_q)+(1-0.5)*($key->nilai_y));
				$a_1 = (1/2)*((1)*($key->nilai_z)+($key->nilai_q)+(1-1)*($key->nilai_y));

				if ($atlet_id == null) { // tambah
					$data = [
					'a_0' => $a_0,
					'a_0_5' => $a_0_5,
					'a_1' => $a_1,
					'alternatif_id' => $key->alternatif_id,
					'atlet_id' => $atlet_nama,
					];
					$this->am->insertData('integral',$data);
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Ditambahkan</div>');
				}else{ // hitung ulang
					$data = [
					'a_0' => $a_0,
					'a_0_5' => $a_0_5,
					'a_1' => $a_1,
					'alternatif_id' => $key->alternatif_id,
					'atlet_id' => $atlet_nama,
					];
						$this->db->where('alternatif_id', $key->alternatif_id);
						$this->db->where('atlet_id', $atlet_nama);
						$this->db->update('integral', $data);	
						$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil Hitung Ulang dan Edit Data</div>');
				}
				
			}
	}
	function hitungKategoriPertandingan($atlet_id)
	{
		$integral = $this->am->getQuery("SELECT * FROM `integral`
				JOIN alternatif ON integral.alternatif_id = alternatif.alternatif_id
				WHERE atlet_id = '$atlet_id'
				ORDER BY integral.alternatif_id ASC")->result();
			$temp = 0;
        	$temp_alternatif = " ";
			for ($j=0; $j < count($integral) ; $j++) { 
					
					// $data[$i]['integral'][$j]['alternatif_id'] = $integral[$j]->alternatif_id;
					// $data[$i]['integral'][$j]['alternatif_nama'] = $integral[$j]->alternatif_nama;
				 //  	$data[$i]['integral'][$j]['a_0'] = $integral[$j]->a_0;
				 //  	$data[$i]['integral'][$j]['a_0_5'] = $integral[$j]->a_0_5;
				 //  	$data[$i]['integral'][$j]['a_1'] = $integral[$j]->a_1;
				  	if($integral[$j]->a_1 > $temp){
		                 	$temp = $integral[$j]->a_1;
		                 	$temp_alternatif = $integral[$j]->alternatif_nama;
		                 	$kesimpulan = $temp_alternatif;


		            }elseif($integral[$j]->a_1 == $temp){
		                    $kesimpulan = $integral[$j]->alternatif_nama." Dan ". $temp_alternatif;
		            }else{
		                    $kesimpulan = $temp_alternatif;
		            }	               
			}
			$data =[
				'atlet_id'=>$atlet_id,
				'kategori_pertandingan_atlet'=>$kesimpulan,
			];
			$this->db->insert('kategori_pertandingan_atlet', $data);
	}
	function keoptimisan()
	{
		$data['title'] = "Data Derajat Keoptimisan Atlet";
		$data['keoptimisan'] = $this->getKeoptimisan();
		if(isset($_GET['cari'])){
			$atlet_nama_cari = $_GET['atlet_nama_cari'];
			$data['keoptimisan'] = $this->getKeoptimisanByNama($atlet_nama_cari);
		}
		$data['atlet'] = $this->am->getQuery("SELECT DISTINCT atlet.atlet_nama, atlet.atlet_id FROM `integral`
			RIGHT JOIN atlet on integral.atlet_id = atlet.atlet_id
			RIGHT JOIN y_q_z ON y_q_z.atlet_id = atlet.atlet_id
			WHERE integral.integral_id is null")->result();
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		
		$this->load->view('pelatih/keoptimisan',$data);
		$this->load->view('admin/part/footer');

		if(isset($_POST['submit'])){
			$atlet_nama = $this->input->post('atlet_nama');
			$atlet_id = $this->input->post('atlet_id');
			
			$this->hitungKeoptimisan($atlet_nama, $atlet_id);	
			$this->hitungKategoriPertandingan($atlet_nama);
			helper_log($this->session->userdata('nik'), 'Tambah Keoptimisan Atlet '.$this->input->post('atlet_nama'));
			redirect('pelatih/keoptimisan');
			

		} // submit
	}
	
}
