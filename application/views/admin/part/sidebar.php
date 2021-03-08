<div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#"><?=$title?></a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">

            <a href="<?=base_url()?>"><?php
            $arr = explode(' ', $title);
            $singkatan = "";
            foreach ($arr as $kata) {
              $singkatan .= substr($kata, 0,1); 
            }
            echo $singkatan;
            ?></a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
                <?php if ($this->session->userdata('jabatan_id') == 0) {
                  $jabatan = 'admin';
                } elseif ($this->session->userdata('jabatan_id') == 2) {
                  $jabatan = 'kepelatihan';
                }
                else{
                  $jabatan = 'pelatih';
                }

                ?>
                <li><a class="nav-link" href="<?=base_url().$jabatan?>"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
              
              <?php if ($this->session->userdata('jabatan_id') == 0) {
              ?>
              <li class="menu-header">Halaman Admin</li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Pengguna</span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?=base_url()?>admin/akun">Akun</a></li>
                  
                  <li><a href="<?=base_url()?>admin/jabatan">Jabatan</a></li>
                </ul>
              </li>
              <li class="">
                <a class="nav-link" href="<?=base_url()?>admin/atlet"><i class="fas fa-running"></i> <span>Atlet</span></a>
                
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Halaman</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?=base_url()?>admin/bobot">Bobot</a></li>
                  <li><a class="nav-link" href="<?=base_url()?>admin/kriteria">Kriteria</a></li>
                  <li><a class="nav-link" href="<?=base_url()?>admin/alternatif">Alternatif</a></li>
                  <li><a class="nav-link" href="<?=base_url()?>admin/rating_kecocokan">Rating Kecocokan</a></li>
                  
                </ul>
              </li>
              <?php
              } ?>
              <?php if ($this->session->userdata('jabatan_id') == 0 || $this->session->userdata('jabatan_id')==1 ) {
              ?>

              <li class="menu-header">Halaman Pelatih</li> 
              <?php
                if ($this->session->userdata('jabatan_id')==1) {
                ?>
                <li><a class="nav-link" href="<?=base_url().$jabatan.'/atlet'?>"><i class="fas fa-running"></i> <span>Atlet</span></a></li>
                <?php
                }

              ?>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-pencil-ruler"></i> <span>Perhitungan</span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?=base_url()?>pelatih/nilai_atlet">Nilai Atlet</a></li>
                  <li><a class="nav-link" href="<?=base_url()?>pelatih/perangkingan">Perangkingan Atlet</a></li>
                  <li><a class="nav-link" href="<?=base_url()?>pelatih/keoptimisan">Derajat Keoptimisan</a></li>
                </ul>
              </li>
              <?php
              }  ?>
              
              <?php if ($this->session->userdata('jabatan_id')== 0 || $this->session->userdata('jabatan_id')== 2) {
              ?>
              <li class="menu-header">Halaman Kepelatihan</li> 
              <?php
                if ($this->session->userdata('jabatan_id')== 2) {
                ?>
                <li><a class="nav-link" href="<?=base_url().$jabatan.'/atlet'?>"><i class="fas fa-running"></i> <span>Atlet</span></a></li>
                <?php
                }
              ?>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-list"></i> <span>Laporan</span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?=base_url()?>kepelatihan/keoptimisan">Laporan Atlet</a></li>
                </ul>
              </li>
              <?php
              } ?>

            </ul>
        </aside>
      </div>