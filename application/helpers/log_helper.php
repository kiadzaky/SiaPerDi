<?php 
function helper_log($akun_nik, $str){
    $CI =& get_instance();
 
    // paramter
    $param['akun_nik']      	= $akun_nik;
    $param['log_aktivitas']      = $str;
 
    //load model log
    $CI->load->model('Admin_model', 'am');
    //save to database
 	$CI->am->insertData('log', $param);
}

?>