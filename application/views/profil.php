<body>
  <div id="app">
    <div class="main-wrapper">
     
      <!-- Main Content -->
      <div class="main-content" style="min-height: 557px;">
        <section class="section">
          <div class="section-header">
            <h1><?=$title?></h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <?= $this->session->userdata('message')?> 
                  <div class="card-header">
                    <h4><?=$title?></h4>
                  </div>
                  <div class="card-body">
                    <form method="post">
                    <div class="row">
                      <?php foreach ($akun as $ak) {
                      ?>

                        <div class="col-4">
                          <div class="form-group">
                            <label>NIK</label>
                            <input type="text" name="akun_nik" class="form-control" value="<?=$ak->akun_nik?>" readonly required>
                          </div>
                          <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="akun_nama" class="form-control" value="<?=$ak->akun_nama?>" required>
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="akun_username" class="form-control" value="<?=$ak->akun_username?>" required>
                          </div>
                          <div class="form-group">
                            <label>Status</label>
                            <input type="text" class="form-control" value="<?=$ak->jabatan_nama?>" readonly required>
                          </div>
                        </div>
                      
                      <?php
                      } ?>
                    </div>
                    <input class="btn btn-primary" type="submit" name="submit" value="SUBMIT">
                    
                    
                    </form>
                    
                    <br>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#editModal<?=$ak->akun_nik?>">Ganti Password</button>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </section>
      </div>
      
    </div>
    <?php foreach ($akun as $ak) {
    ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal<?=$ak->akun_nik?>">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Modal Edit <?=$title?></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="needs-validation" novalidate="" method="post" action="<?=base_url('profil/ganti_password')?>">
                      
                      <div class="card-body">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Password Baru</label>
                          <div class="col-sm-9">
                            <input type="" name="akun_nik" value="<?=$ak->akun_nik?>" hidden="">
                            <input type="password" name="akun_password" id="akun_password" class="form-control" required="" value="" placeholder="Password Baru" onkeyup="validasiPassword(this.value)">
                            <div class="invalid-feedback">
                              Tolong Diisi dengan Benar
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Ketik Ulang Password Baru</label>
                          <div class="col-sm-9">
                            <input type="password" name="akun_password1" id="akun_password1" onkeyup="cekPassword(this.value)" class="form-control" required="" value="" placeholder="Ketik Ulang Password Baru">
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
                        <input class="btn btn-danger" type="submit" disabled="" name="submit" id="submit" value="Edit Password">
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
    <?php
    } ?>
    </div>
</body>