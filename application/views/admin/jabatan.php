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
                    <div class="col-md-9"><h4>TABEL <?= strtoupper($title) ?></h4></div>
                    
                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">TAMBAH <?= strtoupper($title) ?></button> 
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id Jabatan</th>
                                    <th>Nama Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $no=1;
                              foreach ($jabatan as $j) {
                              ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$j->jabatan_id?></td>
                                    <td><?=$j->jabatan_nama?></td>
                                    <td>
                                      <a href="<?= base_url('admin/delete_jabatan/')?><?=$j->jabatan_id?>"><button class="btn btn-danger">Hapus</button></a>

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

  <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Modal Tambah <?=$title?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('admin/jabatan')?>">
                    
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Id Jabatan</label>
                        <div class="col-sm-9">
                          <input type="number" name="jabatan_id" class="form-control" required="" placeholder="Jabatan ID">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Jabatan</label>
                        <div class="col-sm-9">
                          <input type="text" name="jabatan_nama" class="form-control" required="" placeholder="Nama Jabatan">
                          <div class="invalid-feedback">
                           Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      
                    </div>
                    <div class="card-footer text-right">
                      <input class="btn btn-primary" type="submit" name="submit" value="Tambah Jabatan">
                      
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
</html>
