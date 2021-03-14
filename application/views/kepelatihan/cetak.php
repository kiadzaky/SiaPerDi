<?php foreach ($detail_atlet as $da) 
				
		 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		td {
			font-size: 25px;
		}
	</style>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js" integrity="sha512-hZf9Qhp3rlDJBvAKvmiG+goaaKRZA6LKUO35oK6EsM0/kjPK32Yw7URqrq3Q+Nvbbt8Usss+IekL7CRn83dYmw==" crossorigin="anonymous"></script>
</head>
<body>
	<center>
		<table border="0" width="910"> 
			<tr>
				<td width="20%"><img src="<?=base_url('assets/img')?>/pd.jpg"></td>
				<td>
					<div style="text-align: center; font-size: 33px">
						<strong>Keluarga Silat Nasional Indonesia</strong><br>
						<strong>Perisai Diri</strong> <br>
						Kabupaten Jember
					</div>
				</td>
				<td width="20%"><img height="137" width="137" align="right" src="<?=base_url('assets/img')?>/pd_jember.jpg" ></td>
			</tr>

				<table border="0">
					<h2>Detail Atlet <?= $da['atlet_nama']?></h2>
					<tr>
					<td>Atlet Id</td>
					<td>: <?=$da['atlet_id']?></td>
					</tr>
					<tr>
						<td>Atlet Nama</td>
						<td>: <?=$da['atlet_nama']?></td>
					</tr>
					<tr>
						<td>Atlet Unit</td>
						<td>: <?=strtoupper($da['atlet_unit'])?></td>
					</tr>
					<tr>
						<td>Atlet Kategori Umur</td>
						<td>: <?=strtoupper($da['atlet_kategori_umur']) ?></td>
					</tr>
					<tr>
						<td colspan="2" width="100">
							<center>
								<br>
								NILAI
								<br>
								<br>
								<table border="1" cellpadding="4">
									<thead  width="30%">
										<?php 
										$kriteria = "";
										foreach ($da['nilai'] as $n) {
											$kriteria_nama = $n['kriteria_nama'];
											$kriteria .= "'$kriteria_nama'". ", ";
										?>
										<th width="30%"><?=$n['kriteria_nama']?></th>
										<?php
										} ?>
									</thead>
									<tbody>
										<tr>
											<?php 
											$nilai = "";
											foreach ($da['nilai'] as $n) {
												$nilai_atlet = $n['nilai_kriteria'];
												$nilai .= "'$nilai_atlet'". ", ";
											?>
											<td width="40%" style="text-align: center"><?= $n['nilai_kriteria'] ?></td>
											<?php
											} ?>
										</tr>
									</tbody>
								</table>
							</center>	
						</td>
					</tr>
					<tr>
						<td>&nbsp</td>
					</tr>
					<TR>
						<td>Kategori Pertandingan</td>
						<td>: <?php
						//Seni%20Dan%20Serang%20Hindar
							$kesimpulan = str_replace('%20', ' ', $kesimpulan);
							echo "<strong>$kesimpulan</strong>";
						?></td>
					</TR>
				</table>
		</table>
		<button style="size: 100" onclick="cetak()" id="cetak">CETAK</button>
		<br>
		&nbsp
		
	</center>
<script type="text/javascript">
	function cetak() {
		var x = document.getElementById('cetak');
		x.style.display = 'none';
		if (window.print()) {
			x.style.display = 'none';
		}
		x.style.display = 'block';
		
	}
</script>
 <script>
    var ctx = document.getElementById("myChart1").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'radar',
      data: {
        labels: [<?=$kriteria?>],
        datasets: [{
          label: 'Rata Rata',
          data: [<?=$nilai?>],
          backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 2,
        }]
      },
      options: {
        scales: {
          
        }
      }
    });
  </script>
</body>
</html>