<?php
include "lib/configuration.php";
include "tgl.php";
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
if(isset($_SESSION['fdata']) && !empty($_SESSION['fdata'])) {
	$crdata = $_SESSION['fdata'];
	$sql = "select a.pid,a.pengguna,a.nama_pengguna,a.kelompok,b.* from t_peserta a, v_test_siswa b 
	WHERE a.pid=b.id_peserta and a.nama_pengguna like '%$crdata%' and b.tgl_awal_test < '$tgl' and b.tgl_akhir_test > '$tgl' union
	select c.pid,c.pengguna,c.nama_pengguna,c.kelompok,d.* from t_peserta c, v_test_siswa d 
	WHERE c.pid=d.id_peserta and c.kelompok like '%$crdata%' and d.tgl_awal_test < '$tgl' and d.tgl_akhir_test > '$tgl'
	 order by pengguna asc LIMIT $start_from, $jumlah_per_page";

}
else{
	$crdata = '';
	$_SESSION['fdata'] = '';
	$sql = "select a.pid,a.pengguna,a.nama_pengguna,a.kelompok,b.* from t_peserta a, v_test_siswa b 
	WHERE a.pid=b.id_peserta and b.tgl_awal_test < '$tgl' and b.tgl_akhir_test > '$tgl' order by pengguna asc LIMIT $start_from, $jumlah_per_page";
}

$rs = mysqli_query($db,$sql);

?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']) && $_SESSION['tingkat_user']=='2')
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
?>

<script>
$(document).ready(function() {
	/*$(".olStatus").click(function(){
		var parent = $(this).parent();
		var olid = $(this).attr('id').replace('ol-','');
		$.ajax({
			type:'GET',
			url:'pwww/p-reset-oluser.php',
			data:'ajax=1&id='+olid,
			success:function(data) {
				if(data==1) {   
					location.reload();
				} else { 
					alert(data);
				}
			}
		});
	});*/
	$(".lockStatus").click(function(){
		var parent = $(this).parent();
		var loid = $(this).attr('id').replace('terkunci-','');
		$.ajax({
			type:'GET',
			url:'pwww/p-lock-oluser.php',
			data:'ajax=1&id='+loid,
			success:function(data) {
				if(data==1) {   
					location.reload();
				} else { 
					alert(data);
				}
			}
		});
	});
	$(".udahStatus").click(function(){
		var parent = $(this).parent();
		var loid = $(this).attr('id').replace('udah-','');
		$.ajax({
			type:'GET',
			url:'pwww/p-selesai-oluser.php',
			data:'ajax=1&id='+loid,
			success:function(data) {
				if(data==1) {   
					location.reload();
				} else { 
					alert(data);
				}
			}
		});
	});
	$(".resetTime").click(function(){
		var parent = $(this).parent();
		var loid = $(this).attr('id').replace('time-','');
		$.ajax({
			type:'GET',
			url:'pwww/p-reset-time.php',
			data:'ajax=1&id='+loid,
			success:function(data) {
				if(data==1) {   
					location.reload();
				} else { 
					alert(data);
				}
			}
		});
	});
	$(".resetTime").click(function(){
		var parent = $(this).parent();
		var loid = $(this).attr('id').replace('masuk-','');
		$.ajax({
			type:'GET',
			url:'pwww/p-reset-masuk.php',
			data:'ajax=1&id='+loid,
			success:function(data) {
				if(data==1) {   
					location.reload();
				} else { 
					alert(data);
				}
			}
		});
	});
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
						window.location="?pg=status";
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
						window.location="?pg=status";
					}else{ 
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
		STATUS PESERTA UJIAN
	</div>
	<div class='spasi'></div>
	<div class='findp'>
		<input type='text' value='<?=$crdata;?>' id='fdata' class='input2 wd50' placeholder='Filter data'>
		<input type='button' value='Pencarian data' id='findData'>
		<input type='button' value='Clear' id='clearData'>
	</div>	
	<table width="100%" id="t01">
		<tr>
			<th width="5%">
				<center>No</center>
			</th>			
			<th>
				Nama Siswa
			</th>
			<th width="10%">
				<center>Kelas</center>
			</th>
			<th width="5%">
				<center>Waktu (Menit)</center>
			</th>
			<th width="15%">
				<center>login akhir</center>
			</th>
			<th width="15%">
				<center>kode tes</center>
			</th>
			<th width="20%">
				<div class="statusP">						
					<img src="images/online_status.png" height="20px" class="imglink" align="absmiddle"> 
				</div>
				<div class="statusP">
					<img src="images/flag_finish.png" height="20px" class="imglink" align="absmiddle">
				</div>
				<div class="statusP">
					<img src="images/lock_icon.png" height="20px" class="imglink" align="absmiddle">
				</div>
				<div class="statusP">
					<img src="images/time-machine.png" height="20px" class="imglink" align="absmiddle">
				</div>
				<div class="statusP">
					<img src="images/lock-login.png" height="20px" class="imglink" align="absmiddle">
				</div>
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
				<?=strtoupper($br['nama_pengguna']);?>
			</td>
			<td>
				<center><?=strtoupper($br['kelompok']);?></center>
			</td>
			<td><center>				
				<?php
					if ($br['remaining_time']=='') {
						echo '<img src="images/editor_none_icon.png" height="20px" class="imglink" align="absmiddle">';
					}
					else
					{
						echo floor($br['remaining_time']/60);
					}
				?></center>
			</td>
			<td>
				<center><?=strtoupper($br['last_login']);?></center>
			</td>
			<td>
				<center><?=strtoupper($br['kode_test']);?></center>
			</td>
			<td>
				<?php 
					$id = $br['pid'];
					$idt = $br['id_test'];
						if ($br['last_login']!='0000-00-00 00:00:00') {
							$ol = "online_status.png";
						}
						else
						{
							$ol = "status_offline.png";
						}
						if ($br['kunci_login']=='1') {
							$kunci_user = "lock_green.png";
						}
						else
						{
							$kunci_user = "nolock.png";
						}
						if ($br['diselesaikan']=='1') {
							$selesai = "flag_finish.png";
						}
						else
						{
							$selesai = "na.jpg";
						}
						
						?>
						<div id="ol-<?=$id;?>:<?=$idt;?>" class="olStatus statusP">						
								<img src="images/<?=$ol;?>" height="20px" class="imglink" align="absmiddle">
						</div>
						<div id="udah-<?=$id;?>:<?=$idt;?>" class="udahStatus statusP">
							<img src="images/<?=$selesai;?>" height="20px" class="imglink" align="absmiddle">
						</div>
						<div id="terkunci-<?=$id;?>:<?=$idt;?>" class="lockStatus statusP">
							<img src="images/<?=$kunci_user;?>" height="20px" class="imglink" align="absmiddle">
						</div>
						<div id="time-<?=$id;?>:<?=$idt;?>" class="resetTime statusP">
							<img src="images/time-machine.png" height="20px" class="imglink" align="absmiddle">
						</div>
						<div id="masuk-<?=$id;?>:<?=$idt;?>" class="resetTime statusP">
							<img src="images/lock-login.png" height="20px" class="imglink" align="absmiddle">
						</div>
						<?php
				?>
				
			</td>
		</tr>
		<?php 
		$x++;
		}
		?>
	</table>
</div>
<?php
	if(isset($_SESSION['fdata']) && !empty($_SESSION['fdata'])) {
		$sql = "select a.pid,a.pengguna,a.nama_pengguna,a.kelompok,b.* from t_peserta a, v_test_siswa b 
		WHERE a.pid=b.id_peserta and a.nama_pengguna like '%$crdata%' and b.tgl_awal_test < '$tgl' and b.tgl_akhir_test > '$tgl' union
		select c.pid,c.pengguna,c.nama_pengguna,c.kelompok,d.* from t_peserta c, v_test_siswa d 
		WHERE c.pid=d.id_peserta and c.kelompok like '%$crdata%' and d.tgl_awal_test < '$tgl' and d.tgl_akhir_test > '$tgl'
		order by pengguna asc";
	}
	else{
		$sql = "select a.pid,a.pengguna,a.nama_pengguna,a.kelompok,b.* from t_peserta a, v_test_siswa b 
		WHERE a.pid=b.id_peserta and b.tgl_awal_test < '$tgl' and b.tgl_akhir_test > '$tgl' order by pengguna asc";
	}
	$rs = mysqli_query($db,$sql); 
	$total_records = mysqli_num_rows($rs);  
	$total_pages = ceil($total_records / $jumlah_per_page);

	echo "<div class='setpage'>Tampilkan <input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Set Halaman' id='setpage'>
	</div>";
	
	echo "<a href='?pg=status&hal=1' class='lpg'>".'|<'."</a> ";  

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
		echo "<a href='?pg=status&hal=".$i."' class='$rgb'>".$i."</a> "; 
	}; 
	if ($total_pages<($hal+10)) {
		echo "";
	}
	else
	{
		echo "......";
		echo "<a href='?pg=status&hal=".$total_pages."' class='$rgb'>".$total_pages."</a> ";
	}
	echo "<a href='?pg=status&hal=$total_pages' class='lpg'>".'>|'."</a> "; 	
	echo "<div class='spasi'></div><div class='spasi'></div>";
}require_once "pwww/p_enc.php";if(enc($_SESSION['trueValKey'])!=($_SESSION['sid_user'].$_SESSION['namaSEKOLAH'])) {include "pwww/logout.php";}
mysqli_close($db);
?>