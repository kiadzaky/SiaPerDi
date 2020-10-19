<body>
  <div id="app">
    <div class="main-wrapper">
      
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?=$title?></h1>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <a href="<?= base_url('admin/atlet')?>">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4 style="color: black">Total Atlet</h4>
                    </div>
                    <div class="card-body">
                      <?= $jml_atlet ?>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <?php if ($this->session->userdata('jabatan_id') == 0) {
            ?>
             <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <a href="<?= base_url('admin/alternatif')?>">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-danger">
                    <i class="far fa-list-alt"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4 style="color: black">Jumlah Alternatif</h4>
                    </div>
                    <div class="card-body">
                      <?= $jml_alternatif ?>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <a href="<?= base_url('admin/kriteria')?>">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-warning">
                    <i class="far fa-list-alt"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4 style="color: black">Jumlah Kriteria</h4>
                    </div>
                    <div class="card-body">
                      <?= $jml_kriteria ?>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <a href="<?= base_url('pelatih/nilai_atlet')?>">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-success">
                    <i class="fas fa-check-square"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4 style="color: black">Atlet Yang Dinilai</h4>
                    </div>
                    <div class="card-body">
                      <?= $jml_atlet_nilai ?>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <a href="<?= base_url('pelatih/keoptimisan')?>">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-success">
                    <i class="fas fa-check-square"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4 style="color: black">Atlet Yang Terpilih</h4>
                    </div>
                    <div class="card-body">
                      <?= $jml_atlet_nilai ?>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <?php
            } ?>
           
          </div>
        </section>
      </div>
      
    </div>
  </div>

  <!-- <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate="">
                    <div class="card-header">
                      <h4>JavaScript Validation (Horizontal Form)</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Your Name</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" required="">
                          <div class="invalid-feedback">
                            What's your name?
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" required="">
                          <div class="invalid-feedback">
                            Oh no! Email is invalid.
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Subject</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control">
                          <div class="valid-feedback">
                            Good job!
                          </div>
                        </div>
                      </div>
                      <div class="form-group mb-0 row">
                        <label class="col-sm-3 col-form-label">Message</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" required=""></textarea>
                          <div class="invalid-feedback">
                            What do you wanna say?
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary">Submit</button>
                    </div>
                  </form>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
  </div> -->

 
</body>
</html>
