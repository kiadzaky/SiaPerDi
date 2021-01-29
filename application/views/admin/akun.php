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
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $no=1;
                              foreach ($akun as $a) {
                              ?>
                                <tr>
                                    <td><?=$no++?></td>
                                    <td><?=$a->akun_nama?></td>
                                    <td><?=$a->akun_username?></td>
                                    <td><?=$a->jabatan_nama?></td>
                                    <td>
                                      <button class=" btn btn-success" data-toggle="modal" data-target="#editModal" onclick="setId('<?= $a->akun_nik ?>', '<?=$a->akun_nama?>', '<?=$a->akun_username ?>', '<?=$a->jabatan_id ?>')">Edit</button>
                                      <a href="<?=base_url('admin/delete_akun')?>/<?= $a->akun_nik ?>"><button class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Untuk Hapus Data?')">Hapus</button></a>
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
          <form class="needs-validation" novalidate="" method="post" action="<?=base_url('admin/akun')?>">
            <div class="card-body">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">NIK</label>
                <div class="col-sm-9">
                  <input type="number" name="nik" id = "nik" class="form-control" required="" placeholder="NIK">
                  <div class="invalid-feedback">
                    Tolong Diisi dengan Benar
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-9">
                  <input type="text" name="nama_lengkap" class="form-control" required="" placeholder="Nama Lengkap">
                  <div class="invalid-feedback">
                   Tolong Diisi dengan Benar
                 </div>
               </div>
             </div>
             <div class="form-group row">
              <label class="col-sm-3 col-form-label">Username</label>
              <div class="col-sm-9">
                <input type="text" name="username" class="form-control" required="" placeholder="Username">
                <div class="valid-feedback">
                  Tolong Diisi dengan Benar
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Jabatan</label>
              <div class="col-sm-9">
                <select name="jabatan" class="form-control">
                  <?php foreach ($jabatan as $j) {
                    ?>
                    <option value="<?=$j->jabatan_id?>"><?=$j->jabatan_nama?></option>
                    <?php
                  } ?>
                </select>
                <div class="invalid-feedback">
                  Tolong Diisi dengan Benar
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Password</label>
              <div class="col-sm-9">
                <input type="password" name="password1" id="akun_password" onkeyup="validasiPassword(this.value)" class="form-control" required="" placeholder="Password">
                <div class="invalid-feedback">
                  Tolong Diisi dengan Benar
                </div>
              </div>
            </div>
            <div class="form-group mb-0 row">
              <label class="col-sm-3 col-form-label">Ketik Ulang Password</label>
              <div class="col-sm-9">
                <input type="password" name="password2" class="form-control" required="" id="akun_password1" onkeyup="cekPassword(this.value)" placeholder="Password">
                <div class="invalid-feedback">
                  Tolong Diisi dengan Benar
                </div>
                <p id="pesan" style="color: red"></p>
              </div>
            </div>
            <p class="invalid" id="karakter">Lebih dari 8 Karakter</p>
            <p class="invalid" id="hurufBesar">Minimal 1 huruf besar</p>
            <p class="invalid" id="angka">Minimal satu angka</p>
            <style type="text/css">
              .valid{
                color: green;
                font-weight: bold;
              }
              .invalid {
                font-weight: bold;
                color: red;
              }
            </style>
          </div>
          <div class="card-footer text-right">
            <input class="btn btn-primary" type="submit" name="submit" id="submit" disabled="" value="Tambah Akun">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

  function validasiPassword(akun_password) {
    var lowerCase = /[a-z]/g;
    var capitalCase = /[A-Z]/g;
    var numberCase = /[0-9]/g;

    if(akun_password.match(lowerCase)){
      if(akun_password.length >= 8){
        $('#karakter').removeClass('invalid');
        $('#karakter').addClass('valid');

          }else{ // panjang 8 karakter
            $('#karakter').removeClass('valid');
            $('#karakter').addClass('invalid');
          }
          
        }else{ // karakter kecil
          $('#karakter').removeClass('valid');
          $('#karakter').addClass('invalid');
        }
        if (akun_password.match(numberCase)) {
          $('#angka').removeClass('invalid');
          $('#angka').addClass('valid');
        }else{ //number case
          $('#angka').removeClass('valid');
          $('#angka').addClass('invalid');
        }
        if (akun_password.match(capitalCase)) {
          $('#hurufBesar').removeClass('invalid');
          $('#hurufBesar').addClass('valid');
        }else{ //capital case
          $('#hurufBesar').removeClass('valid');
          $('#hurufBesar').addClass('invalid');
        }      
      }

      function cekPassword(akun_password1) {
        var akun_password = document.getElementById('akun_password').value;
        if (akun_password1 == akun_password) {
          $('#submit').removeAttr('disabled');
          $('#pesan').text('');
        }else{
          $('#submit').attr('disabled', 'true');
          $('#pesan').text('*Dimohon Password Harus Sama');
        }
      }
    </script>
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
                <form class="needs-validation" novalidate="" method="post" action="<?=base_url('admin/akun')?>">
                    
                    <div class="card-body">
                      <div class="form-group row">
                        <!-- <label class="col-sm-3 col-form-label">NIK</label> -->
                        <div class="col-sm-9">
                          <input type="text" name="nik_edit" id = "nik_edit" class="form-control" required="" placeholder="NIK" hidden="">
                          <div class="invalid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                          <input type="text" name="nama_lengkap" id="nama_lengkap_edit" class="form-control" required="" placeholder="Nama Lengkap">
                          <div class="invalid-feedback">
                           Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                          <input type="text" name="username" id="username_edit" class="form-control" required="" placeholder="Username">
                          <div class="valid-feedback">
                            Tolong Diisi dengan Benar
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jabatan</label>
                        <div class="col-sm-9">
                          <select name="jabatan" id="jabatan_edit" class="form-control">
                            <?php foreach ($jabatan as $j) {
                              ?>
                              <option value="<?=$j->jabatan_id?>"><?=$j->jabatan_nama?></option>
                              <?php
                            } ?>
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
            </div>
          </div>
  </div>
  <script type="text/javascript">
    function setId(nik, nama, username, jabatan) {
      $('#nik_edit').val(nik);
      $('#nama_lengkap_edit').val(nama);
      $('#username_edit').val(username);
      $('#jabatan_edit').val(jabatan);
    }
  </script>
</body>
</html>
