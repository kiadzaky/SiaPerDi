<body>
  <div id="app">
    <div class="main-wrapper">
      
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?=$title?></h1>
          </div>
          <?= $this->session->userdata('message'); ?>
          <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="col-md-9">
                      <h4>TABEL <?= strtoupper($title) ?></h4>
                      <button class="btn btn-primary"  onclick="dropdown_klik()">Get Prioritas Atlet</button>
                      <br>
                      <form method="GET">
                      <div class="row" id="dropdown-getprioritas" >
                        
                        <div class="col-md-12 d-flex flex">
                          <div class="col-sm-3">                        
                          <label>Jenis Kelamin</label>
                          <select class="form-control" name="atlet_jkel">
                              <option value="putra">Putra</option>
                              <option value="putri">Putri</option>
                          </select>
                          </div>  
                          <div class="col-sm-3">
                            <label>Kesimpulan</label>
                              <select class="form-control" name="atlet_kesimpulan">
                                <option value="tanding">Tanding</option>
                                <option value="serang hindar">Serang Hindar</option>
                                <option value="seni">Seni</option>
                              </select>
                          </div>
                          <div class="col-sm-3">
                            <label>Kategori Umur</label>
                            <select class="form-control" name="atlet_kategori_umur">
                              <option value="pra remaja">Pra Remaja</option>
                              <option value="remaja">Remaja </option>
                              <option value="dewasa">Dewasa</option>
                            </select>
                          </div>
                          <div class=" justify-content-start pl-4 pt-2 col-sm-3" style="margin-top: 30px; margin-bottom: auto;">
                            <button style="size: 10px" name="cari" class="d-flex btn-success btn justify-content-start">Get Data</button>
                          </div>
                        </div>
                        
                      </div>
                      </form>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Nama Atlet</th>
                                  <th>Jenis Kelamin</th>
                                  <th>Kesimpulan</th>
                                  <th>Kategori Umur</th>
                                  <th>Cetak</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $no=1;
                              foreach ($keoptimisan as $ko) {
                                                              
                              ?>
                                <tr>
                                    <td ><?=$no++?></td>
                                    <td ><?=ucwords($ko->atlet_nama)?></td>
                                    <td><?=strtoupper($ko->atlet_jkel)?></td>
                                    <td ><?=$ko->kategori_pertandingan_atlet?></td>
                                    <td><?=strtoupper($ko->atlet_kategori_umur)?></td>
                                    <td><a href="<?=base_url('kepelatihan/cetak/')?><?=$ko->atlet_id?>/<?=$ko->kategori_pertandingan_atlet?>"><i class="fas fa-print"></i></a></td>
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
        </section>
      </div>
      
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="tambahModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Modal Tambah <?=$title?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('pelatih/keoptimisan')?>">
                    
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Atlet</label>
                        <div class="col-sm-9">
                          <select name="atlet_nama" class="form-control">
                          <?php foreach ($atlet as $a):?>
                          <option value="<?= $a->atlet_id ?>"><?=$a->atlet_nama?></option>
                          <?php endforeach; ?>
                          </select>
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <input class="btn btn-primary" type="submit" name="submit" value="Hitung Atlet">
                      
                    </div>
                  </form>
              </div>
              <!-- <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div> -->
            </div>
          </div>
  </div>

</body>
<script type="text/javascript">
  var dropdown = document.getElementById('dropdown-getprioritas');
  dropdown.style.display = 'none';
  function dropdown_klik(argument) {
    if(dropdown.style.display === "block"){
      dropdown.style.display = "none";
    }else{
      dropdown.style.display = "block";
    }
  }
</script>
</html>
