<?php
session_start();
if(isset($_SESSION['login'])){
	include "koneksi.php";
	include "fungsi.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Cetak Daftar Gaji Pegawai</title>
		<style type="text/css">
			body{
				font-family: Arial;
			}
			@media print{
				.no-print{
					display: none;
				}
			}
			table{
				border-collapse: collapse;
			}

		</style>
	</head>
	<body>
<h3 align="center">PT. Kujang Tatar Persada<br>DAFTAR GAJI PEGAWAI</h3>
<hr>
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

<table>
	<tr>
		<td>Bulan</td>
		<td>:</td>
		<td><?php echo $bulan; ?></td>
	</tr>
	<tr>
		<td>Bulan</td>
		<td>:</td>
		<td><?php echo $tahun; ?></td>
	</tr>
</table>
<table border="1" cellpadding="4" cellspacing="0" width="100%">
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
	$sql = mysqli_query($konek, "SELECT pegawai.nip,pegawai.nama_pegawai,
		jabatan.nama_jabatan,golongan.nama_golongan,pegawai.status,pegawai.jumlah_anak,
		jabatan.gapok,jabatan.tunjangan_jabatan,
		IF(pegawai.status='Menikah',tunjangan_suami_istri,0) AS tjsi, 
		IF(pegawai.status='Menikah',tunjangan_anak,0) AS tjanak, 
		uang_makan AS uangmakan, uang_transport AS uangtansport,
		master_gaji.lembur*uang_lembur AS uanglembur,
		(gapok+tunjangan_jabatan+(SELECT tjsi)+(SELECT tjanak)+(SELECT uangmakan)+(SELECT uangtransport)+
			(SELECT uanglembur)) AS pendapatan, potongan, 
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
						<td>".buatRp($d['gapok'])."</td>
						<td>".buatRp($d['tunjangan_jabatan'])."</td>
						<td>".buatRp($d['tjsi'])."</td>
						<td>".buatRp($d['tjanak'])."</td>
						<td>".buatRp($d['uang_makan'])."</td>
						<td>".buatRp($d['uang_transport'])."</td>
						<td>".buatRp($d['uang_lembur'])."</td>
						<td>".buatRp($d['pendapatan'])."</td>
						<td>".buatRp($d['potongan'])."</td>
						<td>".buatRp($d['totalgaji'])."</td>
						</tr>";
				$no++;
			}
			?>
			</tbody>
		</table>

	<table width="100%">
		<tr>
			<td></td>
			<td width="200px">
				<p>Kujang Tatar Persada, <?php echo date("d/m/Y"); ?><br>
				Administrasi Keuangan,</p>
				<br>
				<br>
				<br>
				<p>_______________________________________</p>
			</td>
		</tr>
		
	</table>

	<a href="#" class="no-print" onclick="window.print();">Cetak/Print</a>
	</body>
</html>
<?php
}else{
	header('location:login.php');
}
?>