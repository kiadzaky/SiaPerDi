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
                                  <th>Alternatif</th>
                                  <th>Aksi</th>
                                  <th>Kriteria</th>
                                  <th>Rating Kecocokan</th>
                                </tr>
                            </thead>
                            <tbody>

                              <?php 
                              $no=1;
                              foreach ($rating_kecocokan as $rk) {
                              ?>

                                  <?php 
                                   $jum = count($rk['fuzzy_segitiga']);
                                   $jum = $jum + 2;
                                      echo "<tr>";
                                      echo '<td rowspan ='. $jum .' > '.$no.' </td>';
                                      echo '<td rowspan ='. $jum .' > '.$rk['alternatif_nama'].' </td>';
                                      echo "</tr>";
                                  ?>
                                      <td rowspan="<?=$jum?>">
                                        <button class=" btn btn-success" data-toggle="modal" data-target="#editModal<?=$rk['alternatif_id']?>">Edit</button>
                                        <a href="<?=base_url('admin/delete_rating_kecocokan')?>/<?= $rk['alternatif_id'] ?>"><button class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Untuk Hapus Data?')">Hapus</button></a>
                                      </td>
                                      <?php  
                                      
                                      foreach ($rk['fuzzy_segitiga'] as $rkk) {
                                        echo "<tr>";                                     
                                        echo '<td> '.$rkk['kriteria_nama'].' </td>';
                                        echo '<td> '.$rkk['uraian_kecocokan'].' </td>';
                                        echo "</tr>";

                                      }
                                      
                                       
                             $no++;
                                    ?>   
                              <?php     } ?>
                                
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
  <?php if (count($alternatif) <= 0) {
  ?>
  <style type="text/css">
    .modal_info {
      top: 25%;
    }
  </style>
    <div class="modal fade modal_info" tabindex="-1" role="dialog" id="tambahModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">MOHON TAMBAH ALTERNATIF DI SUB MENU ALTERNATIF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h6><a href="<?=base_url('admin/alternatif')?>">Menuju Menu Alternatif</a></h6>
              </div>
              
            </div>
          </div>
  </div>
  <?php
  }else{
  ?>
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
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('admin/rating_kecocokan')?>">
                    
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Alternatif</label>
                        <div class="col-sm-9">
                          <select name="alternatif_nama" class="form-control" required="">
                          <?php foreach ($alternatif as $a):?>
                          <option value="<?= $a->alternatif_id ?>"><?=$a->alternatif_nama?></option>
                          <?php endforeach; ?>
                          </select>
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <?php foreach ($kriteria as $k):?>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><?=$k->kriteria_nama?></label>
                        <div class="col-sm-9">
                          <select class="form-control" name="fuzzy_segitiga-<?php echo strtolower($k->kriteria_id)  ?>" >
                        <?php foreach ($fuzzy_segitiga as $fs) :?>
                         
                           <option value="<?=$fs->fuzzy_segitiga_id ?>"><?=$fs->uraian_kecocokan ?></option>
                         
                        <?php endforeach; ?>
                          </select>
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <?php endforeach; ?>
                    </div>
                    <div class="card-footer text-right">
                      <input class="btn btn-primary" type="submit" name="submit" value="Tambah Rating Kecocokan">
                      
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
  

  <?php foreach ($rating_kecocokan as $rk) {
  ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editModal<?=$rk['alternatif_id']?>">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Modal Edit <?=$title?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('admin/rating_kecocokan')?>">
                    
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Alternatif</label>
                        <div class="col-sm-9">
                          <input type="" name="alternatif_id" value="<?=$rk['alternatif_id']?>" hidden>
                          <input type="text" name="alternatif_nama" class="form-control" required="" value="<?=$rk['alternatif_nama']?>" placeholder="Alternatif">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <?php foreach ($rk['fuzzy_segitiga'] as $k):?>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><?=$k['kriteria_nama']?></label>
                        <div class="col-sm-9">
                          <select class="form-control" name="fuzzy_segitiga-<?php echo strtolower($k['kriteria_id'])  ?>" >
                          <?php foreach ($fuzzy_segitiga as $fs) :?>
                           
                             <option <?php if($fs->fuzzy_segitiga_id == $k['fuzzy_segitiga_id']){ echo "selected";}?> value="<?=$fs->fuzzy_segitiga_id ?>"><?=$fs->uraian_kecocokan ?></option>
                           
                          <?php endforeach; ?>
                          </select>
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <?php endforeach; ?>
                    </div>
                    <div class="card-footer text-right">
                      <input class="btn btn-primary" type="submit" name="submit" value="Edit Rating Kecocokan">
                      
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
