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

	function atlet()
	{
		$data['title'] = "Data Atlet";	
		$data['atlet'] = $this->am->getData('atlet')->result() ;
		
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('kepelatihan/atlet',$data);
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		$this->load->view('admin/part/footer');
	}

	function getCetak($id)
	{
		$data = [];

		$atlet = $this->db->get_where('atlet', array('atlet_id'=>$id),1)->result();
		
		for($i = 0; $i<count($atlet); $i++){
			$data[$i]['atlet_id'] = $atlet[$i]->atlet_id;
			$data[$i]['atlet_nama'] = $atlet[$i]->atlet_nama;
			$data[$i]['atlet_jkel'] = $atlet[$i]->atlet_jkel;
			$data[$i]['atlet_unit'] = $atlet[$i]->atlet_unit;
			$data[$i]['atlet_kategori_umur'] = $atlet[$i]->atlet_kategori_umur;
			$nilai = $this->am->getQuery("SELECT * FROM `nilai` 
				JOIN kriteria ON nilai.kriteria_id = kriteria.kriteria_id
				JOIN fuzzy_segitiga ON nilai.fuzzy_segitiga_id = fuzzy_segitiga.fuzzy_segitiga_id
				WHERE atlet_id =  '$id'")->result();
			for($j = 0 ; $j < count($nilai) ; $j++){
				$data[$i]['nilai'][$j]['kriteria_nama'] = $nilai[$j]->kriteria_nama;
				$data[$i]['nilai'][$j]['nilai_kriteria'] = $nilai[$j]->uraian_fuzzyfikasi;

			}
		}
		// print_r(json_encode($data));
		return $data;
	}

	function cetak($id, $kesimpulan)
	{
		$data['detail_atlet'] = $this->getCetak($id);
		$data['kesimpulan'] = $kesimpulan;
		// print_r(json_encode($data));
		$this->load->view('kepelatihan/cetak', $data);
	}

	function getPrioritas()
	{
		$atlet = $this->am->getQuery("SELECT DISTINCT atlet.atlet_id, atlet_nama FROM `integral`
			JOIN atlet ON integral.atlet_id = atlet.atlet_id")->result();
		$data = [];
		for($i = 0 ; $i < count($atlet) ; $i++){
			
			$data[$i]['atlet_id'] = $atlet[$i]->atlet_id;
			$data[$i]['atlet_nama'] = $atlet[$i]->atlet_nama;
			$integral = $this->am->getQuery("SELECT a_1, alternatif.alternatif_id , alternatif.alternatif_nama  FROM `integral` 
				JOIN alternatif ON integral.alternatif_id = alternatif.alternatif_id
				WHERE atlet_id = ".$atlet[$i]->atlet_id."
                ORDER BY a_1 DESC limit 2 ")->result();
			for($j = 0; $j < count($integral); $j++){
				$data[$i]['prioritas'][$j]['max_1'] = $integral[$j]->a_1;
				$data[$i]['prioritas'][$j]['alternatif_id'] = $integral[$j]->alternatif_id;
				$data[$i]['prioritas'][$j]['alternatif_nama'] = $integral[$j]->alternatif_nama;
			}			

		}
		
		print_r(json_encode($data));
	}

	function keoptimisan()
	{
		$data['title'] = "Data Laporan Atlet";
		$data['keoptimisan'] = $this->am->getQuery("SELECT * FROM `kategori_pertandingan_atlet`
			JOIN atlet ON kategori_pertandingan_atlet.atlet_id = atlet.atlet_id")->result();
		if(isset($_GET['cari'])){
			$atlet_jkel = $this->input->get('atlet_jkel');
			$atlet_kesimpulan = $this->input->get('atlet_kesimpulan');
			$atlet_kategori_umur = $this->input->get('atlet_kategori_umur');
			$data['keoptimisan'] = $this->am->getQuery("SELECT DISTINCT(atlet.atlet_id), atlet.atlet_nama, atlet.atlet_jkel, kategori_pertandingan_atlet, atlet.atlet_kategori_umur FROM `kategori_pertandingan_atlet`
			JOIN atlet ON kategori_pertandingan_atlet.atlet_id = atlet.atlet_id
            JOIN integral ON kategori_pertandingan_atlet.atlet_id = integral.atlet_id
            WHERE atlet.atlet_jkel = '$atlet_jkel' AND kategori_pertandingan_atlet LIKE '%$atlet_kesimpulan%' AND atlet.atlet_kategori_umur = '$atlet_kategori_umur'
            ORDER BY integral.a_1 DESC")->result();
		}
		$this->load->view('admin/part/head');
		$this->load->view('admin/part/navbar');
		$this->load->view('admin/part/js');
		$this->load->view('admin/part/sidebar',$data);
		$this->load->view('kepelatihan/laporan_keoptimisan',$data);
		$this->load->view('admin/part/footer');
	}
}