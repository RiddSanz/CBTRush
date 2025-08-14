<?php
include "lib/configuration.php";

$jumlah_per_page=20;
if (isset($_GET["hal"])) { $hal  = $_GET["hal"]; } else { $hal=1; };
$start_from = ($hal-1) * $jumlah_per_page;

$idmapel = $_SESSION['idmapel'];

$sql = "select * from t_kd a, t_mapel b where a.id_mapel=b.mid and a.id_mapel='$idmapel' order by a.nama_kd asc LIMIT $start_from, $jumlah_per_page";

$rs = mysqli_query($db,$sql);

$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
$ket_mapel = $bm['ket_mapel'];
$kelas = $bm['kelas'];
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
	/*
	$(document).ready(function() {
		$('a.delete').click(function(e) {
			alert('testing');
			e.preventDefault();
			var parent = $(this).parent();
			$.ajax({
				type: 'get',
				url: 'pwww/p-kddelete.php',
				data: 'ajax=1&id=' + parent.attr('id').replace('record-',''),
				beforeSend: function() {
					parent.animate({'backgroundColor':'#fb6c6c'},300);
				},
				success: function(data) {
					if (data=='1') {
						$("body").load("index.php?pg=q").hide().fadeIn(1500).delay(6000);
					}else {
						alert(data);
					}
				}
			});
		});

	});*/
	$(document).ready(function(){
		$(".delete_class").click(function(){
			var del_id = $(this).attr('id');
			$.ajax({
				type:'GET',
				url:'pwww/p-kddelete.php',
				data:'ajax=1&id='+del_id,
				success:function(data) {
					if(data) {
						window.location.href = "index.php?pg=kd";
					} else {
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
			<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
		</ul>
		<div class='spasi'></div>
		<div class="btnadd lebartombol100" onclick="window.location='?pg=f-addkd'">
			Tambah KD
		</div>
		<div class='btnback letakKanan lebartombol100' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'">
			Kembali
		</div>

		<table width="100%">
			<tr style='background:#ebebe0;color:#000;'>
				<th width="5%">
					<center>NO</center>
				</th>
				<th width="20%">
					KODE KD
				</th>
				<th>
					KOMPETENSI DASAR
				</th>				
				<th width="150px">
					<center>&nbsp;</center>
				</th>
			</tr>
			<?php
			$jdata = mysqli_num_rows($rs);
			if ($jdata==0) {
				echo '<tr>
				<td class="isi"  colspan="5">
				<center>DATA UNIT KD MASIH KOSONG</center>
				</td>';
			}
			else
			{
				$x=$start_from+1;
				$warna = "#f5f5f0";
				while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
				{
					$warna = ($warna == '#fff' ? "#f5f5f0" : "#fff");
					?>
					<tr bgcolor="<? echo($warna);?>">
						<td class="isi">
							<center><?=$x;?></center>
						</td>
						<td class="isi">
							<?=$br['nama_kd'];?>
						</td>
						<td>
							<?=$br['kd_sub'];?>
						</td>						
						<td><center>
							<?php
							$id = $br['kdid'];

							?>
							<div class="delete_class btnstatus" id="<?=$id;?>">
								<img src="images/cancel.png" height="15px" class="imglink" align="absmiddle">
							</div>
							<div onclick="window.location='?pg=f-addkd&s=<?=$id;?>'" class="btnstatus">
								<img src="images/write2.png" height="15px" class="imglink" align="absmiddle">
							</div>
							
							<!--
							<div id="<?=$id;?>" class="delete_class btnstatus merah lebartombol50">
								Hapus
							</div>
							<div onclick="window.location='?pg=f-addkd&s=<?=$id;?>'" class="btnstatus orange lebartombol50">
								Edit
							</div>
							<div onclick="window.location='window.location='?pg=f-addkd&s=<?=$id;?>''" class="btnstatus">
								<img src="images/preview_file.png" height="15px" class="imglink" align="absmiddle">
							</div>
							-->
							<?php
							?>	</center>
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

	$sql = "select * from t_kd a, t_mapel b where a.id_mapel=b.mid and a.id_mapel='$idmapel' order by a.nama_kd";
	$rs = mysqli_query($db,$sql);
	$total_records = mysqli_num_rows($rs);
	$total_pages = ceil($total_records / $jumlah_per_page);

	echo "<a href='?pg=kd&hal=1' class='lpg'>".'|<'."</a> ";

	for ($i=1; $i<=$total_pages; $i++) {
		if($hal==$i)
		{
			$rgb = 'lpgw';
		}
		else
		{
			$rgb = 'lpg';
		}
		echo "<a href='?pg=kd&hal=".$i."' class='$rgb'>".$i."</a> ";
	};
	echo "<a href='?pg=kd&hal=$total_pages' class='lpg'>".'>|'."</a> ";

}
?>
