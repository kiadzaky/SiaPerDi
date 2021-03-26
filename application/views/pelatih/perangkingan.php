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
                                  <th>Alternatif</th>
                                  <th>Nilai Y</th>
                                  <th>Nilai Q</th>
                                  <th>Nilai Z</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $no=1;
                              foreach ($perangkingan as $pr) {
                               $jml= count($pr['y_q_z']);
                               $jml+=1;
                              ?>
                                <tr>
                                    <td rowspan="<?= $jml ?>"><?=$no++?></td>
                                    <td rowspan="<?= $jml ?>"><?=$pr['atlet_nama']?></td>
                                    <!-- <td rowspan="<?= $jml ?>"><form method="post" action="<?= base_url('pelatih/perangkingan') ?>"> <input type="" name="atlet_nama" value="<?=$pr['atlet_id']?>" hidden=""> <input type="" name="atlet_id" value="<?=$pr['atlet_id']?>" hidden=""> <input type="submit" class="btn btn-success" name="submit" value="Hitung Ulang">  </form>  </td> -->
                                </tr>    
                                    <?php
                                    foreach ($pr['y_q_z'] as $yqz) {
                                      echo "<tr>";
                                      echo "<td>".$yqz['alternatif_nama']."</td>";
                                      echo "<td>".$yqz['nilai_y']."</td>";
                                      echo "<td>".$yqz['nilai_q']."</td>";
                                      echo "<td>".$yqz['nilai_z']."</td>";
                                      echo "</tr>";
                                    }
                                    ?>                                
                              <?php
                              
                              } $no++;?>
                            </tbody>
                      </table>
                      <div class="text-right">
                      <?php
                          $jml_data = $jml_atlet_ranking->jml;
                          $jml_data = ceil($jml_data/3);
                          for($i = 1 ; $i<=$jml_data; $i++){
                          ?>
                          <a href="<?=base_url('pelatih/perangkingan/').$i?>"><button class="btn btn-primary"><?=$i?></button></a>
                          <?php
                          }
                        ?>
                      </div>
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
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('pelatih/perangkingan')?>">
                    
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

<!--   <?php foreach ($rating_kecocokan as $rk) {
  ?> -->
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
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('pelatih/rating_kecocokan')?>">
                    
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
                          <select class="form-control" name="fuzzy_segitiga-<?php echo strtolower($k['kriteria_nama'])  ?>" >
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
 <!--  <?php
  } ?> -->
 
</body>
</html>
