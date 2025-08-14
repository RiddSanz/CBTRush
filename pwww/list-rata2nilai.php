<?php
include "lib/configuration.php";
$idmapel = $_SESSION['idmapel'];
$sm = "select * from t_mapel where mid='$idmapel' limit 1";

$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
$ket_mapel = $bm['ket_mapel'];
$kelas = $bm['kelas'];
$sql = "call GetNilaiMapelAll($idmapel)";
$rs = mysqli_query($db,$sql);

/*
if (!$rm) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
}
*/
?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	?>
	<style type="text/css">
	#dwFile {
		clear: both;
		float: right;
		margin-bottom: 5px;
	}
	</style>		
	<link rel="stylesheet" type="text/css" href="css/popup-window.css" />
	<div class="cpanel">
		<div class="nm-list-section">
		<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
		<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
		<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a> | 
		Rata-rata Nilai
		</div>
		<div id="dwFile" class="btnupload" onclick="window.location='pwww/p-downloadNilaiRate.php'">Download Excel</div>
		<div class='spasi'></div>		
		<table width="100%" id="t01">
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
			</tr>
			<?php
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
					?>
					<tr>
						<td class="isi">
							<center><?=$x;?></center>
						</td>
						<td>
							<?=$br['pengguna'];?>
						</td>
						<td>
							<?=$br['nama_pengguna'];?>							
						</td>
						<td>
							<?=$br['kelompok'];?>
						</td>
						<td>
							<?=sprintf("%.2f",$br['rata2']);?>
						</td>						
					</tr>
					<?php 
					$x++;
				}
			}
			?>
		</table>
	</div>
<?php	
}
mysqli_close($db);
?>


