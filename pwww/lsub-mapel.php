<?php 
include "lib/configuration.php";
include "pwww/date-expired.php";

if($date1 >= $date2)
{
	$valid = true;
}
else
{
	$valid = false;
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
<style>
table {
	width: 100%;
}
table, th, td {
    border: 0px solid black;
}
tr:hover {
	background: #CDEDF6;
	cursor: pointer;
}
</style>

<ul class="topnav" id="myTopnav">
	<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
	<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
</ul>
<div class="cpanel">
	<div class="spasi"></div>
	
	<?php 
	if ($_SESSION['tingkat_user']=='0') {
		$sql = "select a.*,b.nama_pengguna as guru from t_mapel a ,t_peserta b where jid='0' and a.oleh=b.pengguna order by a.kelas,a.ket_mapel asc";
	}
	elseif ($_SESSION['tingkat_user']=='1') {
		$sql = "select * from t_mapel where oleh='".$_SESSION['userid']."' and jid='0' order by kelas,ket_mapel asc";
	}
	$_SESSION['mapelnya']='';
	$_SESSION['ketmapelnya']='';
	$rs = mysqli_query($db,$sql);
	$xdata=1;
	$warna = "#f5f5f0";
	echo "
	<table>
	<tr style='background:#ebebe0;color:#000;'>
    	<th width='20px'>No</th>
    	<th>Pelajaran</th>
    	<th width='25%'>Guru</th>
    	<th width='10%'>Tingkat</th>
    	<th width='50px'>Pertanyaan</th>
  	</tr>";	
	while ( $br = mysqli_fetch_array($rs,MYSQLI_ASSOC)) {
		$idm = $br['mid'];	
		//$scek = "select * from t_test where idmapel='$idm' limit 1";
		$scek = "select * from t_soal where id_mapel='$idm'";
		$rcek = mysqli_query($db,$scek);	
		$tot = mysqli_num_rows($rcek);
		$warna = ($warna == '#fff' ? "#f5f5f0" : "#fff");
		
		if($valid==true)
		{
	?>
	<tr bgcolor="<? echo($warna);?>"  onclick="window.location='?pg=lsub2mapel&s=<?=$br['mid'];?>'">
		<?PHP 
		}
		else
		{
			?>
	<tr bgcolor="<? echo($warna);?>">	
			<?php
		}
		?>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;"><?=$xdata;?></td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;"><?=strtoupper($br['ket_mapel']);?></td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;"><?=$br['guru'];?></td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;"><?=$br['kelas'];?></td>
    	<td style="padding:10px;border-bottom:1px #C0CADC dotted;">
    		<?php 
			if ($tot>0) {
				echo $tot;
			}
			else
			{
				echo '0';
			}
			echo " soal";		
			?>
    	</td>
  	</tr>
  	<?php
  	/*
  	?>	
	<div class="lmapelSetUjian" onclick="window.location='?pg=lsub2mapel&s=<?=$br['mid'];?>'">
		<span class="fontsubmenu"><?=$br['ket_mapel'];?></span>
		<div class="picR">
		<?php 
		if ($tot>0) {
			echo $tot;
		}
		else
		{
			echo '0';
		}
		echo " soal";		
		?>
		</div>
	</div>
	<?php */?>
	<?php 
	$xdata=$xdata+1;
	}
	echo "</table>";
	?>

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