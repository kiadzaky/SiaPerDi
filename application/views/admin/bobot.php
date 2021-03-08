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
          <?= $this->session->userdata('message1'); ?>
          <?= $this->session->userdata('message2'); ?>
          <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="col-md-9"><h4>TABEL <?= strtoupper($title) ?></h4></div>
                    
                    <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">TAMBAH <?= strtoupper($title) ?></button>  -->
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Uraian Fuzzyfikasi</th>
                                    <th>Uraian Kecocokan</th>
                                    <th>Nilai 1</th>
                                    <th>Nilai 2</th>
                                    <th>Nilai 3</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $no=1;
                              foreach ($bobot as $bo) {
                              ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$bo->uraian_fuzzyfikasi?></td>
                                    <td><?=$bo->uraian_kecocokan?></td>
                                    <td><?=$bo->n1?></td>
                                    <td><?=$bo->n2?></td>
                                    <td><?=$bo->n3?></td>
                                    <td>
                                      <button class=" btn btn-success" data-toggle="modal" data-target="#editModal<?=$bo->fuzzy_segitiga_id?>">Edit</button>
                                      <a href="<?=base_url('admin/delete_bobot')?>/<?=$bo->fuzzy_segitiga_id?>"><button class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Untuk Hapus Data?')">Hapus</button></a>

                                    </td>
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

  <?php foreach ($bobot as $bo) {
  ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editModal<?=$bo->fuzzy_segitiga_id?>">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Modal Edit <?=$title?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('admin/bobot')?>">
                    
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Uraian Fuzzyfikasi</label>
                        <div class="col-sm-9">
                          <input type="" name="fuzzy_segitiga_id" value="<?=$bo->fuzzy_segitiga_id?>" hidden >
                          <input type="text" name="uraian_fuzzyfikasi" class="form-control" required="" value="<?=$bo->uraian_fuzzyfikasi?>" placeholder="Nama Uraian Fuzzyfikasi">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Uraian Kecocokan</label>
                        <div class="col-sm-9">
                          <input type="text" name="uraian_kecocokan" class="form-control" required="" value="<?=$bo->uraian_kecocokan?>" placeholder="Nama Uraian Kecocokan">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nilai 1</label>
                        <div class="col-sm-9">
                          <input type="text" name="n1" class="form-control" id="nilai" onkeyup="angkaSaja(this)" required="" value="<?=$bo->n1?>" placeholder="Nama Nilai 1">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nilai 2</label>
                        <div class="col-sm-9">
                          <input type="text" name="n2" class="form-control" id="nilai" onkeyup="angkaSaja(this)" required="" value="<?=$bo->n2?>" placeholder="Nama Nilai 2">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nilai 3</label>
                        <div class="col-sm-9">
                          <input type="text" name="n3" onkeyup="angkaSaja(this)" id="nilai" class="form-control" required="" value="<?=$bo->n3?>" placeholder="Nama Nilai 3">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <input class="btn btn-primary" type="submit" name="submit" value="Edit Bobot">
                      
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
  <?php
  } ?>
 <script type="text/javascript">
   function angkaSaja(nilai) {
     var validasi = /^[a-zA-Z ]+$/;   
     console.log(nilai);  
     if(!/^[0-9.]+$/.test(nilai.value)){
      nilai.value = nilai.value.substring(0, nilai.value.length-1);
      // $('#nilai').attr('title', 'Angka dan Titik Saja');
      alert('Angka dan Titik Saja Yang Diperbolehkan');
     }
   }
 </script>
</body>
</html>
