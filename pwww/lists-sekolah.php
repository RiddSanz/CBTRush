<?php
include "lib/configuration.php";
$sql = "select * from t_sekolah order by nama_sekolah asc";

$rs = mysqli_query($db,$sql);
$totSek = mysqli_num_rows($rs);
if (isset($_SESSION['kelompok_user'])) {
	$kelompok = $_SESSION['kelompok_user'];
}
else
{
	$kelompok = '';
}

?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	?>
	<script>
	$(document).ready(function() {
		$('a.delete').click(function(e) {
			e.preventDefault();
			var parent = $(this).parent();
			$.ajax({
				type: 'get',
				url: 'pwww/p-sekolahdelete.php',
				data: 'ajax=1&id=' + parent.attr('id').replace('record-',''),
				beforeSend: function() {
					parent.animate({'backgroundColor':'#fb6c6c'},300);
				},
				success: function(data) {
					if (data=='1') {
						$("body").load("index.php?pg=lsekolah").hide().fadeIn(1500).delay(6000);
					}else {
						alert(data);
					}				
				}
			});
		});
	});
	</script>
	<div class="cpanel">		
			<ul class="topnav" id="myTopnav">
				<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
				<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
			</ul>
		
		<div class='spasi'></div>
		<div class='btnback3 letakKanan u12' onclick="window.location='?pg=cpanel'">
			<img src="images/back.png" width="10px" align='absmiddle' class="imglink"> Kembali
		</div>	
		<?php 
		/*
			if ($totSek<1 || $kelompok=='su') 
			{
		?>
		<div class="btnadd" onclick="window.location='?pg=f-addsekolah'">
			<img src="images/add.png" width="10px" align='absmiddle' class="imglink"> Tambah
		</div>
		<?php 
			}*/
			if (!isset($_SESSION['trueValKey'])) {
		?>
		<div class="btnadd u12" onclick="window.location='?pg=fvalKey'">
			<img src="images/validasikey.png" width="10px" align='absmiddle' class="imglink"> validasi key
		</div>
		<?php 
			}
			
		?>
		<table width="100%" id="t01">
			<tr>
				<th width="5%">
					<center>NO</center>
				</th>
				<th width="10%">
					SID
				</th>
				<th>
					NAMA SEKOLAH
				</th>
				<th width="18%">
					OLEH
				</th>
				<th width="17%">
					TANGGAL VALIDASI
				</th>
				<?php 
				if (!isset($_SESSION['trueValKey'])) {
				?>
				<th width="15%">
					PENGATURAN
				</th>
				<?php
				}
				?>
			</tr>
			<?php
			$jdata = mysqli_num_rows($rs);
			if ($jdata==0) {
				echo '<tr>
				<td class="isi"  colspan="6">
				<center>DATA SEKOLAH MASIH KOSONG</center>
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
							<?=$br['sid'];?>
						</td>
						<td>
							<?=strtoupper($br['nama_sekolah']);?>
						</td>
						<td>
							<?=strtoupper($br['oleh']);?>
						</td>
						<td>
							<?php 
							echo $br['tgl_buat'];
							?>
						</td>
						<?php 
						if (!isset($_SESSION['trueValKey'])) {
						?>
						<td>
							<?php 
							$id = $br['sid'];					
							?>
							<div id="record-<?=$id;?>" class="btnstatus">
								<a href="?delete=<?=$id;?>" class="delete">
									<img src="images/bt_remove.png" height="15px" class="imglink" align="absmiddle"> hapus
								</a>
							</div>
							<div onclick="window.location='?pg=f-addsekolah&s=<?=$id;?>'" class="btnstatus">
								<img src="images/write.png" height="15px" class="imglink" align="absmiddle"> ubah
							</div>	
						</td>
						<?php 
						}
						?>
					</tr>
					<?php 
					$x++;
				}
			}
			?>
		</table>
	</div>
	<?php 
	if (!isset($_SESSION['trueValKey'])) {
	?>
	<div>
		Keterangan : <i>Masukkan validasi Key untuk mendapatkan akses penuh ke software!</i>
	</div>
	<?php
	}
	else{
		echo "Keterangan: <i>Sudah tervalidasi.</i>";
	}
}
?>