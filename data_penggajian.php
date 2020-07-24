<?php include "header.php"; ?>
<div class="container">


<?php
$view = isset($_GET['view']) ? $_GET['view'] : null;

switch($view){
		default:
			
		?>

		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Gaji Pegawai</h3>
				</div>
				<div class="panel-body">
					<form class="form-inline" method="get" action="">
					<div class="form-group">
						<label>Bulan</label>
						<select name="bulan" class="form-control">
							<option value="">- Pilih -</option>
							<option value="01">Januari</option>
							<option value="02">Februari</option>
							<option value="03">Maret</option>
							<option value="04">April</option>
							<option value="05">Mei</option>
							<option value="06">Juni</option>
							<option value="07">Juli</option>
							<option value="08">Agustus</option>
							<option value="09">September</option>
							<option value="10">Oktober</option>
							<option value="11">November</option>
							<option value="12">Desember</option>
					</select>
				</div>
					<div class="form-group">
						<label>Tahun</label>
						<select name="tahun" class="form-control">
						<option value="">- Pilih -</option>
						<?php
						$y = date('Y');
						for($i=2020;$i<$y+2;$i++){
							echo "<option value='$i'>$i</option>";
						}
						?>
					</select>
				</div>
				<button type="submit" class="btn btn-primary">Tampilkan Data</button>
				</form>
				<br>
				<?php
				if((isset($_GET['bulan']) && $_GET['bulan']!='') && (isset($_GET['tahun']) && $_GET['tahun']!='')){
						$bulan = $_GET['bulan'];
						$tahun = $_GET['tahun'];
						$bulantahun = $bulan.$tahun;
				}else{
						$bulan = date('m');
						$tahun = date('Y');
						$bulantahun = $bulan.$tahun;
				}
				?>
				<div class="alert alert-info">
					<strong>Bulan : <?php echo $bulan; ?>, Tahun : <?php echo $tahun; ?></strong>
				</div>
				<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No.</th>
							<th>NIP</th>
							<th>Nama Pegawai</th>
							<th>Jabatan</th>
							<th>Gol</th>
							<th>Status</th>
							<th>Jumlah Anak</th>
							<th>Gaji Pokok</th>
							<th>Tj. Jabatan</th>
							<th>Tj. S/I</th>
							<th>Tj. Anak</th>
							<th>Uang Makan</th>
							<th>Uang Transport</th>
							<th>Uang Lembur</th>
							<th>Pendapatan</th>
							<th>Potongan</th>
							<th>Total Gaji</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql = mysqli_query($konek, "SELECT pegawai.nip,pegawai.nama_pegawai,jabatan.nama_jabatan,golongan.nama_golongan,pegawai.status,pegawai.jumlah_anak,jabatan.gapok,jabatan.tunjangan_jabatan,
							IF(pegawai.status='Menikah',tunjangan_suami_istri,0) AS tjsi, 
							IF(pegawai.status='Menikah',tunjangan_anak,0) AS tjanak, 
							uang_makan AS uangmakan, uang_transport AS uangtansport,
							master_gaji.lembur*uang_lembur AS uanglembur,
							(gapok+tunjangan_jabatan+(SELECT tjsi)+(SELECT tjanak)+(SELECT uangmakan)+(SELECT uangtransport)+(SELECT uanglembur)) AS pendapatan, potongan, 
							(SELECT pendapatan) - potongan AS totalgaji
							FROM pegawai
							INNER JOIN master_gaji ON master_gaji.nip=pegawai.nip 
							INNER JOIN golongan ON golongan.kode_golongan=pegawai.kode_golongan
							INNER JOIN jabtan ON jabatan.kode_jabatan=pegawai.kode_jabatan
							WHERE master_gaji.bulan='$bulantahun'
							ORDER BY pegawai.nip ASC");

						$no=1;

						while($d=mysqli_fetch_array($sql)){
							echo "<tr>
							<td width='40px' align='center'>$no</td>
							<td>$d[nip]</td>
							<td>$d[nama_pegawai]</td>
							<td>$d[nama_jabatan]</td>
							<td>$d[nama_golongan]</td>
							<td>$d[status]</td>
							<td>$d[jumlah_anak]</td>
							<td>".buatRp($d[gapok])."</td>
							<td>$d[tunjangan_jabatan]</td>
							<td>$d[tjsi]</td>
							<td>$d[tjanak]</td>
							<td>$d[uang_makan]</td>
							<td>$d[uang_transport]</td>
							<td>$d[uang_lembur]</td>
							<td>$d[pendapatan]</td>
							<td>$d[potongan]</td>
							<td>$d[totalgaji]</td>
							</tr>";
							$no++;
						}
						?>
					</tbody>
				</table>
				</div>

				</div>
				<div class="panel-footer">
					<?php
					if(mysqli_num_rows($sql) > 0){
						echo "
							<center>
								<a class='btn btn-success' href='cetak_daftar_gaji_pegawai.php?bulan=$bulan&tahun=$tahun' target='_blank'><span class='glypicon glypicon-print'></span> Cetak Daftar Pegawai</a>
							</center>
						";
					}
					?>
				</div>
			</div>
		</div>	

		<?php

		break;
}
?>

</div>
<?php include "footer.php"; ?>
