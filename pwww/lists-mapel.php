<?php
include "lib/configuration.php";
if ($_SESSION['tingkat_user']=='0') {
	$sql = "select * from t_mapel order by kelas,ket_mapel asc";
}
elseif ($_SESSION['tingkat_user']=='1') {
	$sql = "select * from t_mapel where oleh='".$_SESSION['userid']."' order by kelas,ket_mapel asc";
}


$rs = mysqli_query($db,$sql);

$_SESSION['idmapel']="";
?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	?>
	<script src="js/jquery.min.js"></script>
	<script>
	$(document).ready(function() {
		$('.bdel').click(function(e) {
			e.preventDefault();
			var mp = $(this).attr('id');
			var id = mp.split(":");
			if (!confirm("Anda Yakin ingin menghapus mapel "+mp+" (Semua bank soal didalam mapel ini akan terhapus!)?")) return false;
			else
			{
				$.ajax({
					type: 'post',
					url: 'pwww/p-mapeldelete.php',
					data: 'ajax=1&id='+id[0],
					success: function(data) {
						if (data=='1') {
							$("body").load("index.php?pg=lmapel").hide().fadeIn(1500).delay(6000);
						}else {
							alert(data);
						}
					}
				});
			}
		});
		$('.bhide').click(function() {
			var nomorid = $(this).attr('id').replace('sh-','');
			$.ajax({
					type: 'get',
					url: 'pwww/p-mapelshow.php',
					data: 'ajax=1&id=' + nomorid,
					success: function(data) {
						if (data=='1') {
							window.location="?pg=lmapel";
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
		<div class='btnback' onclick="window.location='?pg=cpanel'">
			<img src="images/back.png" width="20px" align='absmiddle' class="imglink"> Kembali
		</div>
		<div class="btnadd" onclick="window.location='?pg=f-addmapel'">
			<img src="images/add.png" width="20px" align='absmiddle' class="imglink"> Tambah MAPEL
		</div>
		<table width="100%">
			<tr style='background:#ebebe0;color:#000;'>
				<th width="5%">
					<center>NO</center>
				</th>
				<th>
					<center>MATAPELAJARAN</center>
				</th>
				<th width="50px">
					<center>TINGKAT</center>
				</th>
				<th width="180px">
					<center>PENGAMPU</center>
				</th>
				<th width="180px">
					<center>PENGATURAN</center>
				</th>
			</tr>
			<?php
			$jdata = mysqli_num_rows($rs);
			if ($jdata==0) {
				echo '<tr>
				<td class="isi"  colspan="6">
				<center>DATA MAPEL MASIH KOSONG</center>
				</td>';
			}
			else
			{
				$x=1;$warna = "#f5f5f0";
				while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
				{$warna = ($warna == '#fff' ? "#f5f5f0" : "#fff");
					?>
					<tr bgcolor="<? echo($warna);?>">
						<td class="isi">
							<center><?=$x;?></center>
						</td>
						<td>
							<?php
								if($br['pic']!='')
								{
									$picIcon = "mapelpic/".$br['pic'];
								}
								else {
									$picIcon = "images/pic.png";

								}
							?>
							<img src="<?=$picIcon;?>" height="30px" width="30px" class="imgIcon" align="absmiddle">
							<?=strtoupper($br['ket_mapel']);?>
						</td>
						<td><center>
							<?php
							echo strtoupper($br['kelas']);
							?></center>
						</td>
						<td>
							<?php
							$sqlp = "select nama_pengguna from t_peserta where pengguna='".$br['oleh']."' limit 1";
							$rsp = mysqli_query($db,$sqlp);
							$brp = mysqli_fetch_array($rsp,MYSQLI_ASSOC);
							echo strtoupper($brp['nama_pengguna']);
							?>
						</td>
						<td><center>
							<?php
							$id = $br['mid'];
							$ol = $br['jid'];
							if ($ol=='0') {
								$pol = "ul.png";
							}
							else
							{
								$pol = "validasikey.png";
							}

							if ($_SESSION['tingkat_user']=='0')
							{

							?>
								<div id="<?=$id;?>:<?=$br['nama_mapel'];?>" class="bdel btnstatus" onclick="?pg=mapel">
									<img src="images/bt_remove.png" height="20px" class="imglink" align="absmiddle">
								</div>

							<?php
							}
							?>
							<div onclick="window.location='?pg=f-addmapel&s=<?=$id;?>'" class="btnstatus">
								<img src="images/textedit.png" height="20px" class="imglink" align="absmiddle">
							</div>
							<div onclick="window.location='?pg=f-picmapel&s=<?=$id;?>'" class="btnstatus">
								<img src="images/pic2.png" height="20px" class="imglink" align="absmiddle">
							</div>
							<div id="sh-<?=$id;?>" class="bhide btnstatus" onclick="?pg=lmapel">
								<img src="images/<?=$pol;?>" height="20px" class="imglink" align="absmiddle">
							</div></center>
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
?>
