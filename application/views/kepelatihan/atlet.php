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
                    
                    
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Atlet</th>
                                    <th>Unit</th>
                                    <!-- <th>Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $no=1;
                              foreach ($atlet as $a) {
                              ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$a->atlet_nama?></td>
                                    <td><?=$a->atlet_unit?></td>
                                    <!-- <td>
                                      <button class=" btn btn-success" data-toggle="modal" data-target="#editModal" onclick="setId('<?= $a->atlet_id ?>', '<?=$a->atlet_nama?>', '<?=$a->atlet_unit ?>')">Edit</button>
                                      <a href="<?=base_url('admin/delete_atlet')?>/<?= $a->atlet_id ?>"><button class="btn btn-danger" onclick="return confirm('Yakin Mau Hapus??')">Hapus</button></a>
                                    </td> -->
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
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('admin/atlet')?>">
                    
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Atlet</label>
                        <div class="col-sm-9">
                          <input type="text" name="nama_atlet" class="form-control" required="" placeholder="Nama Atlet">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Unit Atlet</label>
                        <div class="col-sm-9">
                          <input type="text" name="unit_atlet" class="form-control" required="" placeholder="Unit Atlet">
                          <div class="invalid-feedback">
                           Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <input class="btn btn-primary" type="submit" name="submit" value="Tambah Akun">
                      
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

  <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Modal Edit <?=$title?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('admin/atlet')?>">
                    
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Atlet</label>
                        <div class="col-sm-9">
                          <input type="" id="atlet_id" name="atlet_id" hidden="">
                          <input type="text" name="nama_atlet" id="nama_atlet_edit" class="form-control" required="" placeholder="Nama Atlet">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Unit Atlet</label>
                        <div class="col-sm-9">
                          <input type="text" name="unit_atlet" id="unit_atlet_edit" class="form-control" required="" placeholder="Nama Lengkap">
                          <div class="invalid-feedback">
                           Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <input class="btn btn-primary" type="submit" name="submit" value="Edit Akun">
                      
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

 <script type="text/javascript">
    function setId(atlet_id, nama, unit) {
      $('#atlet_id').val(atlet_id);
      $('#nama_atlet_edit').val(nama);
      $('#unit_atlet_edit').val(unit);
    }
  </script>
</body>
</html>
