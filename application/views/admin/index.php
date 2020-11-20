<body>
  <div id="app">
    <div class="main-wrapper">
      <?php if ($this->session->userdata('jabatan_id') == 0) {
                  $jabatan = 'admin';
                } elseif ($this->session->userdata('jabatan_id') == 2) {
                  $jabatan = 'kepelatihan';
                }
                else{
                  $jabatan = 'pelatih';
                }
      ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?=$title?></h1>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <a href="<?= base_url('').$jabatan.'/atlet'?>">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4 style="color: black">Total Atlet</h4>
                    </div>
                    <div class="card-body">
                      <?= $jml_atlet ?>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <?php if ($this->session->userdata('jabatan_id') == 0) {
            ?>
             <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <a href="<?= base_url('admin/alternatif')?>">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-danger">
                    <i class="far fa-list-alt"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4 style="color: black">Jumlah Alternatif</h4>
                    </div>
                    <div class="card-body">
                      <?= $jml_alternatif ?>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <a href="<?= base_url('admin/kriteria')?>">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-warning">
                    <i class="far fa-list-alt"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4 style="color: black">Jumlah Kriteria</h4>
                    </div>
                    <div class="card-body">
                      <?= $jml_kriteria ?>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <a href="<?= base_url('pelatih/nilai_atlet')?>">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-success">
                    <i class="fas fa-check-square"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4 style="color: black">Atlet Yang Dinilai</h4>
                    </div>
                    <div class="card-body">
                      <?= $jml_atlet_nilai ?>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <a href="<?= base_url('pelatih/keoptimisan')?>">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-success">
                    <i class="fas fa-check-square"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4 style="color: black">Atlet Yang Terpilih</h4>
                    </div>
                    <div class="card-body">
                      <?= $jml_atlet_nilai ?>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <?php
            } ?>
           
          </div>
          <?php if ($this->session->userdata('jabatan_id')==0) {
          ?>

          <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="col-md-9"><h4>TABEL Log Aktivitas User</h4></div>
                    
                   
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Waktu</th>
                                    <th>Aktivitas</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $no=1;
                              foreach ($log as $l) {
                              ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=ucwords($l->log_id)?></td>
                                    <td><?=strtoupper($l->log_aktivitas)?></td>
                                    <td><?=strtoupper($l->akun_nama)?></td>
                                    
                                </tr>
                              <?php
                              
                              } $no++;?>
                            </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>           

          </div>
          <?php
          } ?>
        </section>
      </div>
      
    </div>
  </div> 
</body>
</html>
