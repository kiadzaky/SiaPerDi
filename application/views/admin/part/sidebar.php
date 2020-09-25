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
                }else{
                  $jabatan = 'pelatih';
                }

                ?>
                <li><a class="nav-link" href="<?=base_url().$jabatan?>"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
              
              <?php if ($this->session->userdata('jabatan_id') == 0) {
              ?>
              <li class="menu-header">Halaman Admin</li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Seseorang</span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?=base_url()?>admin/akun">Akun</a></li>
                  <li><a href="<?=base_url()?>admin/atlet">Atlet</a></li>
                  
                  <li><a href="<?=base_url()?>admin/jabatan">Jabatan</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Halaman</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?=base_url()?>admin/kriteria">Kriteria</a></li>
                  <li><a class="nav-link" href="<?=base_url()?>admin/alternatif">Alternatif</a></li>
                  <li><a class="nav-link" href="<?=base_url()?>admin/rating_kecocokan">Rating Kecocokan</a></li>
                  
                </ul>
              </li>
              <?php
              } ?>
              
              <li class="menu-header">Halaman Pelatih</li> 
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-pencil-ruler"></i> <span>Perhitungan</span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?=base_url()?>pelatih/nilai_atlet">Nilai Atlet</a></li>
                  <li><a class="nav-link" href="<?=base_url()?>pelatih/perangkingan">Perangkingan Atlet</a></li>
                  <li><a class="nav-link" href="<?=base_url()?>pelatih/keoptimisan">Derajat Keoptimisan</a></li>
                </ul>
              </li>
            </ul>
        </aside>
      </div>