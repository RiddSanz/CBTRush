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


if (isset($_GET["hal"])) { $hal  = $_GET["hal"]; } else { $hal=1; }; 
$start_from = ($hal-1) * $jumlah_per_page; 
if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
	$crdata = $_SESSION['fdata'];
	$sql = "select * from t_peserta a where a.tingkat='2' and a.pengguna like '%$crdata%' union 
	select * from t_peserta b where b.tingkat='2' and b.nama_pengguna like '%$crdata%' union 
	select * from t_peserta c where c.tingkat='2' and c.kelompok like '%$crdata%' order by pengguna ASC
	LIMIT $start_from, $jumlah_per_page ";
}
else{
	$crdata = 'SEMUA';
	$sql = "select * from t_peserta where tingkat='2' order by pengguna ASC LIMIT $start_from, $jumlah_per_page ";
}
/*$sql = "select * from t_peserta where oleh='".$_SESSION['userid']."' order by pengguna asc
	LIMIT $start_from, $jumlah_per_page ";
	*/

$rs = mysqli_query($db,$sql);


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
	<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
	</ul>
	<div class='spasi'></div>
	<div class='findp'>
		<input type='text' value='<?=$crdata;?>' id='fdata' class='style-1 wd50' placeholder='Filter data'>
		<input type='button' value='Pencarian data' id='findData'>
		<input type='button' value='Clear' id='clearData'>
		<div id="dwFile" class="btnDownload letakKanan u12" onclick="iPrint(theiframe);">
			<img src="images/printer.png" height="20px" align='absmiddle' class="imglink"> Cetak Kartu
		</div>
	</div>
	<div class='spasi'></div>
	<div class='lineP'></div>	
	<iframe name="theiframe" src="pwww/kartu-peserta.php?mulai=<?=$start_from;?>" height='500px' width='100%' frameborder="0"></iframe>
</div>
<?php
if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
	$crdata = $_SESSION['fdata'];
	$sql = "select * from t_peserta a where a.tingkat='2' and a.pengguna like '%$crdata%' union 
	select * from t_peserta b where b.tingkat='2' and b.nama_pengguna like '%$crdata%' union 
	select * from t_peserta c where c.tingkat='2' and c.kelompok like '%$crdata%' order by pengguna ASC
	";
}
else{
	$crdata = 'SEMUA';
	$sql = "select * from t_peserta where tingkat='2' order by pengguna ASC";
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
	echo "<div class='setpage'>Tampilkan <input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Set Halaman' id='setpage'>
	</div>";
	echo "<a href='?pg=kartuP&hal=1' class='lpg'>".'|<'."</a> "; 

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
		echo "<a href='?pg=kartuP&hal=".$i."' class='$rgb'>".$i."</a> "; 
	}; 
	if ($total_pages<($hal+10)) {
		echo "";
	}
	else
	{
		echo "......";
		echo "<a href='?pg=kartuP&hal=".$total_pages."' class='$rgb'>".$total_pages."</a> ";
	} 
	echo "<a href='?pg=kartuP&hal=$total_pages' class='lpg'>".'>|'."</a> ";
	echo "<div class='spasi'></div><div class='spasi'></div>";
}
?>