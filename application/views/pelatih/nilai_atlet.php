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
                  <form action="<?=base_url('pelatih/nilai_atlet')?>" method = "GET">
                    <div class="row">
                      <div class="col-4"> 
                        <input type="" name="atlet_nama_cari" class="form-control" placeholder="Cari Nama Atlet">
                      </div>
                        <button class="btn btn-primary" name="cari">FILTER</button></br> 
                    </div>
                  </form>
                    <div class="row">
                      <br>
                    </div>
                    <div class="table-responsive">
                      <table id="tabel-data" class="" width="100%" cellspacing="0" border="1">
                        
                        </style>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Atlet</th>
                                    <th>Aksi</th>
                                    <th>Kriteria</th>
                                    <th>Nilai</th>
                                    <th>Fuzzyfikasi</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                              <?php 
                              $no=1;
                              foreach ($nilai_atlet as $na) {
                              ?>

                                  <?php 
                                   $jum = count($na['kriteria']);
                                   $jum = $jum + 2;
                                      echo "<tr>";
                                      echo '<td rowspan ='. $jum .' > '.$no.' </td>';
                                      echo '<td rowspan ='. $jum .' > '.$na['atlet_nama'].' </td>';
                                      echo "</tr>";
                                  ?>
                                      <td rowspan="<?=$jum?>">
                                        <button class=" btn btn-success" data-toggle="modal" data-target="#editModal<?=$na['atlet_id']?>" onclick="setId('<?= $na['atlet_id'] ?>', '<?= $na['atlet_nama']?>')">Edit</button>
                                        <a href="<?=base_url('pelatih/delete_nilai')?>/<?= $na['atlet_id'] ?>"><button class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Untuk Hapus Data?')">Hapus</button></a>
                                      </td>
                                      <?php  
                                      
                                      foreach ($na['kriteria'] as $nak) {
                                        echo "<tr>";                                     
                                        echo '<td> '.$nak['kriteria_nama'].' </td>';
                                        echo '<td> '.$nak['nilai_kriteria'].' </td>';
                                        echo '<td> '.$nak['uraian_fuzzyfikasi'].' </td>';
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
  <?php if (count($atlet) <= 0)  {
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
            <h5 class="modal-title">Mohon Tambah Data Atlet</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?php if ($this->session->userdata('jabatan_id') > 0 ) {
            ?>
            <h6>Silahkan Hubungi Admin untuk menambah data atlet</h6>
            <?php
            }else{ 
            ?>
            <h6><a href="<?=base_url('admin/atlet')?>">Menuju Link Ini</a></h6>
            <?php
            }
            ?>
            
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
            <form class="needs-validation" novalidate="" method="post" action="<?=base_url('pelatih/nilai_atlet')?>">

              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Atlet</label>
                  <div class="col-sm-9">
                    <select name="atlet_nama" id = "atlet_nama" class="form-control" required="">
                      <?php
                      foreach ($atlet as $a) {
                        ?>
                        <option value="<?=$a->atlet_id?>"><?=$a->atlet_nama?> - Unit <?=$a->atlet_unit?></option>
                        <?php
                      }
                      ?>

                    </select>
                    <div class="invalid-feedback">
                      Tolong Diisi dengan Benar
                    </div>
                  </div>
                </div>
                <center><h6 class="center">Nilai Range 0-100</h6></center>
                <div class="form-group row">
                  <?php
                  foreach ($kriteria as $k) {
                    ?>
                    <label>Nilai <?= $k->kriteria_nama?></label>
                    <input type="number" min="0" max="100" class="form-control" name="kriteria-<?=$k->kriteria_id?>" value ="" placeholder="Nilai <?= $k->kriteria_nama?>" required ></br>
                    <?php
                  }
                  ?>
                  <div class="col-sm-9">

                    <div class="invalid-feedback">
                     Tolong Diisi dengan Benar
                   </div>
                 </div>
               </div>
             </div>
             <div class="card-footer text-right">
              <input class="btn btn-primary" type="submit" name="submit" value="Tambah Nilai Atlet">

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
  }
  ?>
  
<?php $no=0; foreach ($nilai_atlet as $na): $no++
                    // print_r($na['kriteria']);
                    ?>
  <div class="modal fade" tabindex="-1" role="dialog" id="editModal<?=$na['atlet_id']?>">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Modal Edit <?=$title?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('pelatih/nilai_atlet')?>">
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Atlet</label>
                        <div class="col-sm-9">
                          <input type="" name="atlet_id" id = "atlet_id" value="<?=$na['atlet_id']?>" hidden>
                          <input type="" name="atlet_nama" id="atlet_nama_edit" class="form form-control" readonly="" value="<?=$na['atlet_nama']?>">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <center><h6 class="center">Nilai Range 0-100</h6></center>
                      <div class="form-group row">
                        <?php
                        foreach ($na['kriteria'] as $na) {
                        ?>
                          <label>Nilai <?=$na['kriteria_nama']?></label>
                          <input type="" class="form-control" name="kriteria-<?=$na['kriteria_id']?>" id = "kriteria-<?=$na['kriteria_id']?>" value ="<?=$na['nilai_kriteria']?>" placeholder="Nilai <?=$na['kriteria_nama']?>"  ></br>
                        <?php
                        }
                        ?>
                        <div class="col-sm-9">
                          
                          <div class="invalid-feedback">
                           Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <input class="btn btn-primary" type="submit" name="submit" value="Edit Nilai Atlet">
                      
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
<?php endforeach; ?>
<!-- Ini merupakan script yang terpenting -->
<script type="text/javascript">
    $(document).ready(function() {

      $('.editModal').click(function(){
          
          var atlet_id = $(this).attr('atlet_id'); //get the attribute value
          
          $.ajax({
              url : "<?php echo base_url(); ?>admin/getNilaiById/",
              data:{atlet_id : atlet_id},
              method:'GET',
              dataType:'json',
              success: function(data) {
                console.log(data); 
            }
          });
      });
    });
</script>
<script type="text/javascript">
    function setId(atlet_id, nama, unit) {
      $('#atlet_id').val(atlet_id);
      $('#atlet_nama_edit').val(nama);
    }
  </script>
 
</body>
</html>
