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
								<table border="1">
									<thead  width="30%">
										<?php foreach ($da['nilai'] as $n) {
										?>
										<th width="30%"><?=$n['kriteria_nama']?></th>
										<?php
										} ?>
									</thead>
									<tbody>
										<tr>
											<?php foreach ($da['nilai'] as $n) {
											?>
											<td  width="30%" style="text-align: center"><?= $n['nilai_kriteria'] ?></td>
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
</body>
</html>