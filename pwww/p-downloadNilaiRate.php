<?php
include "../lib/configuration.php";
session_start();
$idmapel = $_SESSION['idmapel'];
$sm = "select * from t_mapel where mid='$idmapel' limit 1";

$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];

header("Content-type: application/vnd-ms-excel"); 
header("Content-Disposition: attachment; filename=rata2-$nm_mapel.xls");

$sql = "call GetNilaiMapelAll($idmapel)";
$rs = mysqli_query($db,$sql);

/*
if (!$rm) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
}
*/
echo '	
<table width="100%" border="1">
		<tr>
			<td class="isi"  colspan="5">
			<center>';echo $nm_mapel; echo '</center>
			</td>
		<tr>
			<th width="5%">
				<center>NO</center>
			</th>
			<th width="10%">
				NIS
			</th>				
			<th>
				NAMA SISWA
			</th>
			<th width="15%">
				KELAS
			</th>				
			<th width="15%">
				RATA-RATA
			</th>
		</tr>';

		$jdata = mysqli_num_rows($rs);
		if ($jdata==0) {
			echo '<tr>
			<td class="isi"  colspan="5">
			<center>DATA PERTANYAAN MASIH KOSONG</center>
			</td>';
		} 
		else
		{
			$x=1;
			while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
			{
				echo '
				<tr>
					<td class="isi">
						<center>';echo $x; echo '</center>
					</td>
					<td>
						';echo $br["pengguna"];
						echo '
					</td>
					<td>';echo $br['nama_pengguna'];
					echo '							
					</td>
					<td>';echo $br['kelompok'];
					echo '
					</td>
					<td>';echo sprintf("%.2f",$br['rata2']);
					echo '
					</td>						
				</tr>';				
				$x++;
			}
		}
		echo '
	</table>
	';
mysqli_close($db);

?>