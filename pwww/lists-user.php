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
$idsek = $_SESSION['sid_user'];

if (isset($_GET["hal"])) { $hal  = $_GET["hal"]; } else { $hal=1; };
$start_from = ($hal-1) * $jumlah_per_page;

if ($_SESSION['userid']=='cbtreset') {
	$plus = "union select * from t_peserta e where e.pengguna='admin'";
}
else
{
	$plus="";
}

if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
	$crdata = $_SESSION['fdata'];

	if ($_SESSION['tingkat_user']=='0') {
		$sql = "select * from t_peserta a where a.kelompok like '%$crdata%' and a.pengguna not in('admin')
		union select * from t_peserta b where b.nama_pengguna like '%$crdata%' and b.kelompok not in('admin')
		union select * from t_peserta c where c.agama like '%$crdata%' and c.kelompok not in('admin')
		union select * from t_peserta d where d.ruang like '%$crdata%' and d.kelompok not in('admin')";
		$sql.=$plus;
		$sql.="ORDER BY pengguna ASC LIMIT $start_from, $jumlah_per_page ";
	}
	else
	{
		$sql = "select * from t_peserta a where a.tingkat='2' and a.kelompok like '%$crdata%'
		union select * from t_peserta b where b.tingkat='2' and b.nama_pengguna like '%$crdata%'
		union select * from t_peserta c where c.tingkat='2' and c.agama like '%$crdata%'
		union select * from t_peserta d where d.tingkat='2' and d.ruang like '%$crdata%'
		ORDER BY pengguna ASC LIMIT $start_from, $jumlah_per_page ";
	}

}
else{
	$crdata = '';
	if ($_SESSION['tingkat_user']=='0') {
		$sql = "select * from t_peserta where kelompok NOT IN('admin')";
		$sql .= $plus;
		$sql.="ORDER BY pengguna ASC LIMIT $start_from, $jumlah_per_page ";
	}
	else
	{
		$sql = "select * from t_peserta where tingkat='2' ORDER BY pengguna ASC
			LIMIT $start_from, $jumlah_per_page ";
	}

}
/*$sql = "select * from t_peserta where oleh='".$_SESSION['userid']."' order by pengguna asc
	LIMIT $start_from, $jumlah_per_page ";
	*/

$rs = mysqli_query($db,$sql);
$list_agama  = array('-','islam','katholik',
	'kristen','hindu','budha','khonghucu'
	,'lainnya' );

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
	$('.delete').click(function(e) {
		e.preventDefault();
			var mp = $(this).attr('id');
			var id = mp.split(":");
			if (!confirm("Anda Yakin ingin menghapus "+id[1]+" (data yang dihapus tidak dapat dikembalikan!)")) return false;
			else
			{
				$.ajax({
					type: 'get',
					url: 'pwww/p-usersdelete.php',
					data: 'ajax=1&id=' +id[0],
					success: function(data) {
						if (data=='1') {
							$("body").load("index.php?pg=users").hide().fadeIn(1500).delay(6000);
						}else {
							alert(data);
						}
					}
				});
			}
	});
	$("#setpage").click(function(){

			var jmlhal = $('#jmlhal').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-hal.php',
				data:'ajax=1&jmlhal='+jmlhal,
				success:function(data) {
					if(data){
						$("body").load("index.php?pg=users").hide().fadeIn(1500).delay(6000);
					}else{

						alert(data);
					}
				}
			});
		});
		$(".btrefresh").click(function(){
				$.ajax({
					type:'GET',
					url:'pwww/p-clear-dbpengguna.php',
					data:'ajax=1',
					success:function(data) {
						if(data=='1'){
							$("body").load("index.php?pg=users").hide().fadeIn(1500).delay(6000);
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
						$("body").load("index.php?pg=users").hide().fadeIn(1500).delay(6000);
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
						window.location="?pg=users";
					}else{

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

	<?php
	if ($_SESSION['tingkat_user']=='0')
	{
	?>
	<div class="btnadd" onclick="window.location='?pg=f-addusers'">
		<img src="images/add.png" width="10px" align='absmiddle' class="imglink"> Tambah User
	</div>
	<div class="btnadd" onclick="window.location='?pg=importusers'">
		<img src="images/user_up.png" width="20px" align='absmiddle' class="imglink"> Import User
	</div>
	<div class="btrefresh btnadd">
		<img src="<?=$menubtnrefresh;?>" width="10px" align='absmiddle' class="imglink"> Refresh Pengguna
	</div>
	<?php
	}
	?>

	<div class='findp'>
		<input type='text' value='<?=$crdata;?>' id='fdata' class='style-1' placeholder='Filter data'>
		<input type='button' value='Pencarian data' id='findData'>
		<input type='button' value='Clear' id='clearData'>
	</div>
	<table width="100%" id="t01">
		<tr>
			<th width="10px">
				<center>NO</center>
			</th>
			<th width="50px">
				<center>UID</center>
			</th>
			<th>
				<center>NAMA PENGGUNA</center>
			</th>
			<th width="50px">
				<center>AGAMA</center>
			</th>
			<th width="100px">
				<center>GROUP</center>
			</th>
			<th width="40px">
				<center>RUANG</center>
			</th>
			<th width="40px">
				<center>SESI</center>
			</th>
			<th width="150px">
				<center>PENGATURAN</center>
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
				<center><?=strtoupper($br['agama']);?></center>
			</td>
			<td>
				<center><?=strtoupper($br['kelompok']);?></center>
			</td>
			<td>
				<center><?php /*
					if ($br['tingkat']=='0') {
						echo "ADMIN";
					}
					elseif ($br['tingkat']=='1') {
						echo "OPERATOR";
					}
					elseif ($br['tingkat']=='2') {
						echo "SISWA";
					}*/
					echo strtoupper($br['ruang']);
				?></center>
			</td>
			<td>
				<center>
					<?php
						echo strtoupper($br['sesi']);
					?>
				</center>
			</td>
			<td><center>
				<?php
				if ($_SESSION['tingkat_user']=='0') {
					$id = $br['pid'];

					//if($br['tingkat']!='0')
					//{
					?>
						<div id="<?=$id;?>:<?=$br['nama_pengguna'];?>" class="delete btnstatus">
							<img src="images/bt_remove.png" height="15px" class="imglink" align="absmiddle"> hapus
						</div>
						<div onclick="window.location='?pg=f-addusers&s=<?=$id;?>'" class="btnstatus">
							<img src="images/write.png" height="15px" class="imglink" align="absmiddle"> ubah
						</div>
						<?php
					//}
				}
				else
				{
					echo "-";
				}
				?>
				</center>
			</td>
		</tr>
		<?php
		$x++;
		}
		?>
	</table>
</div>
<?php
if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
	$crdata = $_SESSION['fdata'];
	if ($_SESSION['tingkat_user']=='0') {
		$sql = "select * from t_peserta a where a.kelompok like '%$crdata%' and a.pengguna not in('anrit02')
		union select * from t_peserta b where b.nama_pengguna like '%$crdata%' and b.kelompok not in('su')
		union select * from t_peserta c where c.agama like '%$crdata%' and c.kelompok not in('su')
		union select * from t_peserta d where d.ruang like '%$crdata%' and d.kelompok not in('su')
		ORDER BY pengguna ASC";
	}
	else
	{
		$sql = "select * from t_peserta a where a.tingkat='2' and a.kelompok like '%$crdata%'
		union select * from t_peserta b where b.tingkat='2' and b.nama_pengguna like '%$crdata%'
		union select * from t_peserta c where c.tingkat='2' and c.agama like '%$crdata%'
		union select * from t_peserta d where d.tingkat='2' and d.ruang like '%$crdata%'
		ORDER BY pengguna ASC";
	}

}
else{
	$crdata = '';
	if ($_SESSION['tingkat_user']=='0') {
		$sql = "select * from t_peserta where kelompok NOT IN('su') ORDER BY pengguna ASC
			";
	}
	else
	{
		$sql = "select * from t_peserta where tingkat='2' ORDER BY pengguna ASC
			";
	}

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

	echo "<a href='?pg=users&hal=1' class='lpg'>".'|<'."</a> ";

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
		echo "<a href='?pg=users&hal=".$i."' class='$rgb'>".$i."</a> ";
	};
	if ($total_pages<($hal+10)) {
		echo "";
	}
	else
	{
		echo "......";
		echo "<a href='?pg=users&hal=".$total_pages."' class='$rgb'>".$total_pages."</a> ";
	}

	echo "<a href='?pg=users&hal=$total_pages' class='lpg'>".'>|'."</a> ";
	echo "<div class='spasi'></div><div class='spasi'></div>";
}
mysqli_close($db);
?>
