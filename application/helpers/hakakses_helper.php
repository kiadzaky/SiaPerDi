<?php 

function hakakses()
{
	$ci = get_instance();
	// cek apakah dia udh login
	if(!$ci->session->userdata('nik')) {
		redirect('auth');
	}
	 else {
		// dapatkan siapa sih yang sedang akses melalui session
		$jabatan_id = $ci->session->userdata('jabatan_id');
		// kita berada di menu/akses mana ?
		$menu =  ucfirst($ci->uri->segment(1)) ;
		// echo "menu".$menu;
		$userAccess = $ci->db->get_where('jabatan', ['jabatan_id' => $jabatan_id, 'jabatan_nama' => $menu ]);
		// print_r ($userAccess);
		if($jabatan_id != 0){
			if($userAccess->num_rows() < 1){
			redirect('auth/block');
			}
		}
		
	}
}


function check_access($role_id, $menu_id)
{
	$ci = get_instance();
	$ci->db->where('role_id', $role_id);
	$ci->db->where('menu_id', $menu_id);
	$result = $ci->db->get('user_access_menu');

	if($result->num_rows() > 0) {
		return "checked='checked'";
	}
}