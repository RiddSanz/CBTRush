<?php
include "lib/configuration.php";
if(isset($_SESSION['jmlhal']))
{
	$jumlah_per_page=$_SESSION['jmlhal'];
}
else
{
	$jumlah_per_page=20;
}
$idmapel = $_SESSION['idmapel'];
if (isset($_GET["hal"])) { $hal  = $_GET["hal"]; } else { $hal=1; }; 
$start_from = ($hal-1) * $jumlah_per_page; 
if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
	$crdata = $_SESSION['fdata'];
	$sql = "select * from hsl_score_akhir a where a.kelompok like '%$crdata%' and a.idmapel='$idmapel'
	union select * from hsl_score_akhir b where b.nama_pengguna like '%$crdata%' and b.idmapel='$idmapel'
	union select * from hsl_score_akhir c where c.kode_test like '%$crdata%' and c.idmapel='$idmapel'
	ORDER BY pengguna ASC LIMIT $start_from, $jumlah_per_page ";
}
else{
	$crdata = '';
	$sql = "select * from hsl_score_akhir where idmapel='$idmapel' ORDER BY pengguna ASC 
			LIMIT $start_from, $jumlah_per_page ";
}
/*$sql = "select * from t_peserta where oleh='".$_SESSION['userid']."' order by pengguna asc
	LIMIT $start_from, $jumlah_per_page ";
	*/
//echo $sql;
$rs = mysqli_query($db,$sql);
//$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
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
	$("#setpage").click(function(){
			//alert('Testing');
			var jmlhal = $('#jmlhal').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-hal.php',
				data:'ajax=1&jmlhal='+jmlhal,
				success:function(data) {
					if(data){	// DO SOMETHING
						//$("body").load("index.php?pg=users").hide().fadeIn(1500).delay(6000);
						location.reload();
					}else{ 
						//DO SOMETHING 
						alert(data);
					}
				}
			});
		});
	$("#findData").click(function(){
			//alert('Testing');
			var fdata = $('#fdata').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-fdata.php',
				data:'ajax=1&fdata='+fdata,
				success:function(data) {
					if(data){	// DO SOMETHING
						//$("body").load("index.php?pg=users").hide().fadeIn(1500).delay(6000);
						location.reload();
					}else{ 
						//DO SOMETHING 
						alert(data);
					}
				}
			});
		});
	$("#clearData").click(function(){
			//alert('Testing');
			//var fdata = $('#fdata').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-cfdata.php',
				data:'ajax=1',
				success:function(data) {
					if(data){	// DO SOMETHING
						//$("body").load("index.php?pg=status").hide().fadeIn(1500).delay(6000);
						location.reload();
					}else{ 
						//DO SOMETHING 
						alert(data);
					}
				}
			});
		});
});
</script>
<div class="cpanel">
	<div class="nm-list-section">
			<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a> | 
			<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a> | 
			<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$nm_mapel;?></a> | 
			Hasil Test
		</div>
	<div class='spasi'></div>
	<div class='findp'>
		<input type='text' value='<?=$crdata;?>' id='fdata' class='input2 wd50' placeholder='Filter data'>
		<input type='button' value='Pencarian data' id='findData'>
		<input type='button' value='Clear' id='clearData'>
		<img style='float:right;' src="images/printer.png" width="20px" align='absmiddle' class="imglink">
	</div>	
	<table width="100%" id="t01">
		<tr>
			<th width="5%">
				<center>NO</center>
			</th>
			<th width="10%">
				UID
			</th>
			<th width="48%">
				NAMA PENGGUNA
			</th>
			<th width="20%">
				KODE TEST
			</th>
			<th width="12%">
				KELAS
			</th>
			<th width="5%">
				NILAI
			</th>
		</tr>
		<?php 
		$x=$start_from+1;
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
				<?=strtoupper($br['nama_pengguna']);?>
			</td>
			<td>
				<?=strtoupper($br['kode_test']);?>
			</td>
			<td>
				<?=strtoupper($br['kelompok']);?>
			</td>
			<td>
				<?=strtoupper(ceil(($br['score']/$br['jumlah_soal'])*100));?>
			</td>
		</tr>
		<?php 
		$x++;
		}
		?>
	</table>
</div>
<?php
	//$sql = "select * from t_peserta where oleh='".$_SESSION['userid']."' ORDER BY pengguna ASC";
if(isset($_SESSION['fdata'])) {
	$crdata = $_SESSION['fdata'];
	$sql = "select * from hsl_score_akhir a where a.kelompok like '%$crdata%' and a.idmapel='$idmapel'
	union select * from hsl_score_akhir b where b.nama_pengguna like '%$crdata%' and b.idmapel='$idmapel'
	union select * from hsl_score_akhir c where c.kode_test like '%$crdata%' and c.idmapel='$idmapel'
	ORDER BY pengguna ASC";
}
else{
	$sql = "select * from hsl_score_akhir where idmapel='$idmapel' ORDER BY pengguna ASC 
			";
}
	/*	if(isset($_SESSION['fdata'])) {
		$crdata = $_SESSION['fdata'];
		$sql = "select * from t_peserta a where a.oleh='".$_SESSION['userid']."' and a.kelompok like '%$crdata%' 
		union select * from t_peserta b where b.oleh='".$_SESSION['userid']."' and b.nama_pengguna like '%$crdata%' 
		ORDER BY pengguna ASC";
	}
	else{
		$sql = "select * from t_peserta where oleh='".$_SESSION['userid']."' ORDER BY pengguna ASC ";
	}
*/
	$rs = mysqli_query($db,$sql); //run the query
	$total_records = mysqli_num_rows($rs);  //count number of records
	$total_pages = ceil($total_records / $jumlah_per_page);

	echo "<div class='setpage'>Tampilkan <input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Set Halaman' id='setpage'>
	</div>";
	//echo $total_records;
	echo "<a href='?pg=laporant&hal=1' class='lpg'>".'|<'."</a> "; // Goto 1st page  

	for ($i=1; $i<=$total_pages; $i++) { 
		if($hal==$i)
		{
			$rgb = 'lpgw';
		}
		else
		{
			$rgb = 'lpg';
		}
		echo "<a href='?pg=laporant&hal=".$i."' class='$rgb'>".$i."</a> "; 
	}; 
	echo "<a href='?pg=laporant&hal=$total_pages' class='lpg'>".'>|'."</a> "; // Goto last page	
	echo "<div class='spasi'></div><div class='spasi'></div>";
}
?>