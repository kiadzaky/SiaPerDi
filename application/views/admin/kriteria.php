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
                    
                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">TAMBAH <?= strtoupper($title) ?></button> 
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kriteria</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $no=1;
                              foreach ($kriteria as $k) {
                              ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$k->kriteria_nama?></td>
                                    <td>
                                      <button class=" btn btn-success" data-toggle="modal" data-target="#editModal<?=$k->kriteria_id?>">Edit</button>
                                      <a href="<?=base_url('admin/delete_kriteria')?>/<?=$k->kriteria_id?>"><button class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Untuk Hapus Data?')">Hapus</button></a>

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
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('admin/kriteria')?>">
                    
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Kriteria</label>
                        <div class="col-sm-9">
                          <input type="text" name="kriteria_nama" class="form-control" required="" placeholder="Nama Kriteria">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <input class="btn btn-primary" type="submit" name="submit" value="Tambah Kriteria">
                      
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

  <?php foreach ($kriteria as $k) {
  ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editModal<?=$k->kriteria_id?>">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Modal Edit <?=$title?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('admin/kriteria')?>">
                    
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Kriteria</label>
                        <div class="col-sm-9">
                          <input type="" name="kriteria_id" value="<?=$k->kriteria_id?>" hidden="">
                          <input type="text" name="kriteria_nama" class="form-control" required="" value="<?=$k->kriteria_nama?>" placeholder="NIK">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <input class="btn btn-primary" type="submit" name="submit" value="Edit Kriteria">
                      
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
 
</body>
</html>
