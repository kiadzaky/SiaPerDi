 <!-- General JS Scripts -->
  <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
  <script src="<?= base_url() ?>/assets/js/jquery-3.3.1.min.js"></script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->
  <script src="<?= base_url() ?>/assets/js/popper.min.js"></script>
  <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
  <script src="<?= base_url() ?>/assets/js/bootstrap.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script> -->
  <script src="<?= base_url() ?>/assets/js/jquery.nicescroll.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> -->
  <script src="<?= base_url() ?>/assets/js/moment.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <!-- <script src="<?= base_url() ?>/node_modules/simpleweather/jquery.simpleWeather.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/chart.js/dist/Chart.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/jqvmap/dist/jquery.vmap.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="<?= base_url() ?>/node_modules/summernote/dist/summernote-bs4.js"></script>
  <script src="<?= base_url() ?>/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
 -->
  <!-- Template JS File -->
  <script src="<?= base_url() ?>/assets/js/scripts.js"></script>
  <script src="<?= base_url() ?>/assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script src="<?= base_url() ?>/assets/js/page/index-0.js"></script>
  <script src="<?= base_url() ?>/assets/js/page/modules-datatables.js"></script>

   <script>
  $(document).ready(function(){
    $('#tabel-data').DataTable({ dom: 'Bfrtip', buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ] });
});
  </script>
  <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>/assets/js/jquery.dataTables.js"></script>
<script src="<?=base_url('upup/')?>/upup.min.js"></script>
<script>
    UpUp.start({
      'content-url': '<?=base_url('auth')?>',
      'service-worker-url': '<?=base_url('upup/')?>upup.sw.min.js',
      // 'assets': ['css/bootstrap.min.css', 'css/offline.css']
    });
</script>
<script>
   if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('<?=base_url('upup/')?>upup.sw.min.js')
        .then(function(reg){
         
       }).catch(function(err) {
          
      });
   }
  </script>
  <script type="text/javascript" src="<?=base_url('upup/')?>/addtohomescreen.js"></script>
  <script type="text/javascript" src="<?=base_url('upup/')?>/addtohomescreen.min.js"></script>
  <script type="text/javascript">
    if(
    (("standalone" in window.navigator) && !window.navigator.standalone) // ios
    || //or
      (!window.matchMedia('(display-mode: standalone)').matches)// android
    ){
      addToHomescreen();
    }

  </script>