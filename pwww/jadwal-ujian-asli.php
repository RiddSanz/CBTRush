<?php 
include "lib/configuration.php";
require_once("pwww/tgl.php");
$tglnow = date("Y-m-d", $newTime);
$tomorrow = date('Y-m-d',strtotime($tglnow . "+1 days"));
?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if(isset($_SESSION['fdata']) && !empty($_SESSION['fdata'])) {
		$crdata = $_SESSION['fdata'];
		$crdata2 = $_SESSION['fdata2'];
	}
	else
	{
		$crdata = $tglnow ;
		$crdata2 = $tomorrow;
	}
	?>
	<script type="text/javascript">
	$(document).ready(function() {
		$("#findData").click(function(){
			var fdata = $('#fdata').val();
			var fdata2 = $('#fdata2').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-fdata.php',
				data:'ajax=1&fdata='+fdata+'&fdata2='+fdata2,
				success:function(data) {
					if(data){	
						window.location="?pg=jadwalu";
					}else{ 
						alert(data);
					}
				}
			});
		});
	});
	</script>
	<div class="nm-list-section"><a href='#' onclick="window.location='?pg=cpanel'">PANEL</a> | JADWAL UJIAN</div>
	<div class="cpanel">
		<div class="spasi"></div>
		<h3>JADWAL UJIAN </h3>
		<div class="c-Menu">
			<div class='findp'>
				<input type='date' value='<?=$crdata;?>' id='fdata' class='style-1' placeholder='Filter data'> 
				<span style="float:left;padding-left:5px;padding-right:5px;"> - </span>
				<input type='date' value='<?=$crdata2;?>' id='fdata2' class='style-1' placeholder='Filter data'>
				<input type='button' value='Cari' id='findData'>
			</div>
			<div class="rTable"> 
				<div class="rTableRow fontKecil"> 
					<div class="rTableHead w10px"><center><strong>NO</strong></center></div> 
					<div class="rTableHead w100px"><span style="font-weight: bold;">Jenis Test</span></div> 
					<div class="rTableHead"><span style="font-weight: bold;">Pelajaran</span></div>
					<div class="rTableHead w50px"><span style="font-weight: bold;">Hari</span></div>
					<div class="rTableHead w150px"><span style="font-weight: bold;">Tanggal</span></div>
					<div class="rTableHead w150px"><span style="font-weight: bold;">Pukul</span></div>
					<div class="rTableHead w10px" title="Waktu Ujian(Menit)">
						<center><img src="images/Timetable.png" height="15" class="imglink" align="absmiddle"/></center>
					</div>
					<div class="rTableHead w10px" title="Peserta Ujian(Orang)">
						<center><img src="images/users.png" height="15" class="imglink" align="absmiddle"/></center>
					</div>
					<div class="rTableHead w10px" title="Jumlah Pertanyaan(Soal)">
						<center><img src="images/question_mark-icon.png" height="15" class="imglink" align="absmiddle"/></center>
					</div>
				</div>	
				<?php 
	/*if ($_SESSION['tingkat_user']=='0') {
		$sql = "select * from t_mapel where jid='0' order by nama_mapel asc";
	}
	elseif ($_SESSION['tingkat_user']=='1') {
		$sql = "select * from t_mapel where oleh='".$_SESSION['userid']."' and jid='0' order by nama_mapel asc";
	}*/
	$sql = "select nama_mapel,ket_mapel,kode_test,nama_test,keterangan,tgl_awal_test as tgla,
	tgl_akhir_test as tglb,waktu_test,jumlah_soal,jumlah_peserta,kelas from t_mapel a,
	t_test b where a.mid=b.idmapel and tgl_awal_test between '$crdata' and '$crdata2' order by tgl_awal_test,nama_mapel asc";
	$_SESSION['mapelnya']='';
	$rs = mysqli_query($db,$sql);
	$xdata=1;
	require_once("pwww/konversi-tgl.php");
	while ( $br = mysqli_fetch_array($rs,MYSQLI_ASSOC)) 
	{
		?>	
		<div class="rTableRow font12" title="<?=$br['nama_test'];?>"> 
			<div class="rTableCell"><center><?=$xdata;?></center></div> 
			<div class="rTableCell"><?=strtoupper($br['nama_test']." ".$br['keterangan']);?></div> 			
			<div class="rTableCell"><?=strtoupper($br['ket_mapel']." ".$br['kelas']);?></div> 
			<div class="rTableCell"><?php echo konversi_tanggal("D",$br['tgla']);?></div>
			<div class="rTableCell"><?php echo konversi_tanggal("j M Y",$br['tgla']);?></div>
			<div class="rTableCell"><?php echo konversi_tanggal("H:i:s",$br['tgla']);?> - <?php echo konversi_tanggal("H:i:s",$br['tglb']);?></div>
			<div class="rTableCell"><center><?=$br['waktu_test'];?></center></div>
			<div class="rTableCell"><center><center><?=$br['jumlah_peserta'];?></center></center></div> 
			<div class="rTableCell"><center><?=$br['jumlah_soal'];?></center></div>  			 
		</div>
		<?php 
		$xdata=$xdata+1;
	}
	?>
</div>
</div>
<div class='btnbackBtm2' onclick="window.location='?pg=cpanel'">
	<img src="images/bt_left.png" width="30px" align='absmiddle' class="imglink"> BACK
</div>
</div>
<div class="cpanel">
	<div class="spasi"></div>
</div>
<?php 
}
mysqli_close($db);
?>