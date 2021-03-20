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
                    
                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">TAMBAH <?= strtoupper($title) ?></button> 
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Atlet</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Unit</th>
                                    <th>Kategori Umur</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $no=1;
                              foreach ($atlet as $a) {
                              ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=ucwords($a->atlet_nama)?></td>
                                    <td><?=strtoupper($a->atlet_jkel)?></td>
                                    <td><?=strtoupper($a->atlet_unit)?></td>
                                    <td><?=strtoupper($a->atlet_kategori_umur)?></td>
                                    <td>
                                      <button class=" btn btn-success" data-toggle="modal" data-target="#editModal" onclick="setId('<?= $a->atlet_id ?>', '<?=$a->atlet_nama?>', '<?=$a->atlet_jkel?>', '<?=$a->atlet_unit ?>', '<?=$a->atlet_kategori_umur?>')">Edit</button>
                                      <a href="<?=base_url('admin/delete_atlet')?>/<?= $a->atlet_id ?>"><button class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Untuk Hapus Data?')">Hapus</button></a>
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
                        <label class="col-sm-3 col-form-label">Jenis Kelamin Atlet</label>
                        <div class="col-sm-9">
                          <select name="jkel_atlet" class="form-control">
                            <option value="putra">Putra </option>
                            <option value="putri">Putri</option>

                          </select>
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
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kategori Umur Atlet</label>
                        <div class="col-sm-9">
                          <select name="kategori_umur_atlet" class="form-control">
                            <option value="pra remaja">Pra Remaja</option>
                            <option value="remaja">Remaja </option>
                            <option value="dewasa">Dewasa</option>

                          </select>
                          <div class="invalid-feedback">
                           Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <input class="btn btn-primary" type="submit" name="submit" value="Tambah Atlet">
                      
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
                        <label class="col-sm-3 col-form-label">Jenis Kelamin Atlet</label>
                        <div class="col-sm-9">
                          <select name="jkel_atlet" id="jkel_atlet_edit" class="form-control">
                            <option value="putra">Putra </option>
                            <option value="putri">Putri</option>

                          </select>
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
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kategori Umur Atlet</label>
                        <div class="col-sm-9">
                          <select name="kategori_umur_atlet" id="kategori_umur_atlet_edit" class="form-control">
                            <option value="pra remaja">Pra Remaja</option>
                            <option value="remaja">Remaja </option>
                            <option value="dewasa">Dewasa</option>

                          </select>
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
<!-- Ini merupakan script yang terpenting -->
<!-- <script type="text/javascript">
    $(document).ready(function() {

      $('.editModal').click(function(){
          
          var atlet_id = $(this).attr('atlet_id'); //get the attribute value
          
          $.ajax({
              url : "<?php echo base_url(); ?>admin/getDetailAtlet/",
              data:{atlet_id : atlet_id},
              method:'GET',
              dataType:'json',
              success:function(data) {
                $('#atlet_id').val(data.atlet_id); //hold the response in id and show on popup
                $('#atlet_nama').val(data.atlet_nama);
                $('#atlet_unit').val(data.atlet_unit);
                $('#kriteria_nama').text(data.kriteria_nama);
                // $('#editModal').modal({backdrop: 'static', keyboard: true, show: true});
                $('#editModal').modal('show')
            }
          });
      });
    });
</script> -->
 <script type="text/javascript">
    function setId(atlet_id, nama, jkel, unit, kategori_umur) {
      $('#atlet_id').val(atlet_id);
      $('#jkel_atlet_edit').val(jkel);
      $('#nama_atlet_edit').val(nama);
      $('#unit_atlet_edit').val(unit);
      $('#kategori_umur_atlet_edit').val(kategori_umur);
    }
  </script>
</body>
</html>
