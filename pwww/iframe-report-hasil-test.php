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
	order by kelompok,pengguna asc LIMIT $start_from, $jumlah_per_page ";
}
else{
	$crdata ='';
	$sql = "select * from hsl_score_akhir where idmapel='$idmapel' order by kelompok,pengguna asc 
			LIMIT $start_from, $jumlah_per_page ";
}
/*$sql = "select * from t_peserta where oleh='".$_SESSION['userid']."' order by pengguna asc
	LIMIT $start_from, $jumlah_per_page ";
	*/

$rs = mysqli_query($db,$sql);

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
			
			var jmlhal = $('#jmlhal').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-hal.php',
				data:'ajax=1&jmlhal='+jmlhal,
				success:function(data) {
					if(data){	
						location.reload();
					}else{ 
						alert(data);
					}
				}
			});
		});
	$("#findData").click(function(){
			var fdata = $('#fdata').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-fdata.php',
				data:'ajax=1&fdata='+fdata,
				success:function(data) {
					if(data){
						location.reload();
					}else{ 
						alert(data);
					}
				}
			});
		});
	$("#clearData").click(function(){
			$.ajax({
				type:'GET',
				url:'pwww/p-set-cfdata.php',
				data:'ajax=1',
				success:function(data) {
					if(data){
						location.reload();
					}else{ 
						alert(data);
					}
				}
			});
		});
});
</script>
<script src="js/iframe.print.js"></script>
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
		<button onclick="iPrint(theiframe);"  style='float:right;'>
		<img src="images/printer.png" width="20px" align='absmiddle' class="imglink">
		</button>
	</div>
	<div class='lineP'></div>	
	<iframe name="theiframe" src="pwww/report-hasil-test.php?mulai=<?=$start_from;?>" height='500px' width='100%' frameborder="0"></iframe>
</div>
<?php
if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
	$crdata = $_SESSION['fdata'];
	$sql = "select * from hsl_score_akhir a where a.kelompok like '%$crdata%' and a.idmapel='$idmapel'
	union select * from hsl_score_akhir b where b.nama_pengguna like '%$crdata%' and b.idmapel='$idmapel'
	union select * from hsl_score_akhir c where c.kode_test like '%$crdata%' and c.idmapel='$idmapel'
	order by kelompok,pengguna asc ";
}
else{
	$sql = "select * from hsl_score_akhir where idmapel='$idmapel' order by kelompok,pengguna asc  
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
	$rs = mysqli_query($db,$sql);
	$total_records = mysqli_num_rows($rs);
	$total_pages = ceil($total_records / $jumlah_per_page);
	echo "<div class='setpage'><input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Data' id='setpage'>
	</div>";
	echo "<a href='?pg=laporant&hal=1' class='lpg'>".'|<'."</a> "; 

	if ($hal<10) {
		$aj = 1;
		if ($total_pages<=10) {
			$aki = $total_pages;
		}
		else
		{
			$aki = 10;
		}
		
	}
	else
	{
				
		if ($total_pages<($hal+9)) {
			$aj = $hal - 5;
			$aki = $hal + ($total_pages-$hal);
			/*echo $total_pages;
			echo ($hal+10);*/
		}
		else
		{
			$aj = $hal-5;
			$aki = $hal + 5;
			/*echo $aj;
			echo $aki;*/
		}
		

	}
	
	for ($i=$aj; $i<=$aki; $i++) { 
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
	if ($total_pages<($hal+10)) {
		echo "";
	}
	else
	{
		echo "......";
		echo "<a href='?pg=laporant&hal=".$total_pages."' class='$rgb'>".$total_pages."</a> ";
	} 
	echo "<a href='?pg=laporant&hal=$total_pages' class='lpg'>".'>|'."</a> ";
	echo "<div class='spasi'></div><div class='spasi'></div>";
}
?>