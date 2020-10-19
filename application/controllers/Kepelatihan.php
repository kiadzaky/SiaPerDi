<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepelatihan extends CI_Controller {
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

	function getKeoptimisan()
	{
		$data =[];
		
        $kesimpulan = "";
		$atlet = $this->am->getQuery("SELECT DISTINCT atlet.atlet_id, atlet.atlet_nama, atlet.atlet_unit, atlet.atlet_kategori_umur FROM `integral`
			JOIN atlet ON integral.atlet_id = atlet.atlet_id")->result();
		for ($i=0; $i < count($atlet) ; $i++) { 
			$data[$i]['atlet_id'] = $atlet[$i]->atlet_id; 
			$data[$i]['atlet_nama'] = $atlet[$i]->atlet_nama;
			$data[$i]['atlet_kategori_umur'] = $atlet[$i]->atlet_kategori_umur;
			$integral = $this->am->getQuery("SELECT * FROM `integral`
				JOIN alternatif ON integral.alternatif_id = alternatif.alternatif_id
				WHERE atlet_id = ".$atlet[$i]->atlet_id."
				ORDER BY integral.alternatif_id ASC")->result();
			$temp = 0;
        	$temp_alternatif = " ";
			for ($j=0; $j < count($integral) ; $j++) { 
				
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
			  $data[$i]['temp'] = $temp;  
			  $data[$i]['temp_alternatif'] = $temp_alternatif;  
			  $data[$i]['kesimpulan'] = $kesimpulan;  
		}
		return $data;
		// print_r(json_encode($data));
	}

	function keoptimisan()
	{
		$data['title'] = "Data Laporan Atlet";
		$data['keoptimisan'] = $this->getKeoptimisan();
		if(isset($_GET['cari'])){
			$atlet_nama_cari = $_GET['atlet_nama_cari'];
			$data['keoptimisan'] = $this->getKeoptimisanByNama($atlet_nama_cari);
		}
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		$this->load->view('kepelatihan/keoptimisan',$data);
		$this->load->view('admin/part/footer');
	}
}