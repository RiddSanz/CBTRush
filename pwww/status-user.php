<?php
include "lib/configuration.php";
include "tgl.php";
if(!isset($_SESSION['fdata2']) || $_SESSION['fdata2']=='')
{
	$today = date("Y-m-d", $newTime);
}
else {
	$today = $_SESSION['fdata2'];
}

$iduser = $_SESSION['userid'];
$tuser = $_SESSION['tingkat_user'];
if(isset($_SESSION['jmlhal']))
{
	$jumlah_per_page=$_SESSION['jmlhal'];
}
else
{
	$jumlah_per_page=20;
}
$tambahan = '';
$tambahan2 = '';
$sistemMasuk = 0;
if ($tuser == '1') {
	$tambahan = "and b.oleh='$iduser'";
	$tambahan2 = "and d.oleh='$iduser'";
}
//echo $tuser;
$total_pages = 1;
if (isset($_GET["hal"])) { $hal  = $_GET["hal"]; } else { $hal=1; };
$start_from = ($hal-1) * $jumlah_per_page;
if(isset($_SESSION['fdata']) && !empty($_SESSION['fdata'])) {
	$crdata = $_SESSION['fdata'];

	/*$sql = "select a.pid,a.pengguna,a.nama_pengguna,a.kelompok,b.* from t_peserta a, v_test_siswa b
	WHERE a.pid=b.id_peserta and a.nama_pengguna like '%$crdata%' and b.tgl_awal_test like '$tgl' and b.tgl_akhir_test > '$tgl' union
	select c.pid,c.pengguna,c.nama_pengguna,c.kelompok,d.* from t_peserta c, v_test_siswa d
	WHERE c.pid=d.id_peserta and c.kelompok like '%$crdata%' and d.tgl_awal_test < '$tgl' and d.tgl_akhir_test > '$tgl'
	 order by pengguna asc LIMIT $start_from, $jumlah_per_page";*/
	$sql = "select a.pid,a.pengguna,a.nama_pengguna,a.kelompok,b.* from t_peserta a, v_test_siswa b
	WHERE a.pid=b.id_peserta and a.nama_pengguna like '%$crdata%' and b.tgl_awal_test like '$today%' $tambahan union
	select c.pid,c.pengguna,c.nama_pengguna,c.kelompok,d.* from t_peserta c, v_test_siswa d
	WHERE c.pid=d.id_peserta and c.kelompok like '%$crdata%' and d.tgl_awal_test like '$today%' $tambahan2
	order by pengguna asc LIMIT $start_from, $jumlah_per_page";

	$sql2 = "select a.pid,a.pengguna,a.nama_pengguna,a.kelompok,b.* from t_peserta a, v_test_siswa b
	WHERE a.pid=b.id_peserta and a.nama_pengguna like '%$crdata%' and b.tgl_awal_test like '$today%' $tambahan union
	select c.pid,c.pengguna,c.nama_pengguna,c.kelompok,d.* from t_peserta c, v_test_siswa d
	WHERE c.pid=d.id_peserta and c.kelompok like '%$crdata%' and d.tgl_awal_test like '$today%' $tambahan2
	order by pengguna asc";

	$rs2 = mysqli_query($db,$sql2);
	$total_records = mysqli_num_rows($rs2);
	$total_pages = ceil($total_records / $jumlah_per_page);
}
else{
	$crdata = '';
	$_SESSION['fdata'] = '';
	$sql = "select a.pid,a.pengguna,a.nama_pengguna,a.kelompok,b.* from t_peserta a, v_test_siswa b
	WHERE a.pid=b.id_peserta and b.tgl_awal_test like '$today%' $tambahan order by pengguna asc LIMIT $start_from, $jumlah_per_page";

	$sql2 = "select a.pid,a.pengguna,a.nama_pengguna,a.kelompok,b.* from t_peserta a, v_test_siswa b
	WHERE a.pid=b.id_peserta and b.tgl_awal_test like '$today%' $tambahan order by pengguna asc";

	$rs2 = mysqli_query($db,$sql2);
	$total_records = mysqli_num_rows($rs2);
	$total_pages = ceil($total_records / $jumlah_per_page);
}
//echo $sql;
$rs = mysqli_query($db,$sql);
$datamapel = array();

$sqlmapel = "select mid,ket_mapel,kelas as tingkat from t_mapel";
$rmapel = mysqli_query($db,$sqlmapel);
while ($bmapel = mysqli_fetch_array($rmapel,MYSQLI_ASSOC)) {
	$datamapel[$bmapel['mid']]['mapel'] = $bmapel['ket_mapel'];
	$datamapel[$bmapel['mid']]['tingkat'] = $bmapel['tingkat'];
}


?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']) && $_SESSION['tingkat_user']=='2')
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
?>
<link rel="stylesheet" href="jquery-ui.css">
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/jquery-ui.js"></script>

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

  $( "#fdata2" ).datepicker({ dateFormat: 'yy-mm-dd'});

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
		var r = confirm("Anda yakin untuk mereset waktu ujian ?");
		if (r == true) {
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
		}
	});
	$(".resetMasuk").click(function(){
		var parent = $(this).parent();
		var loid = $(this).attr('id').replace('masuk-','');
		var r = confirm("Anda yakin untuk mengijinkan ganti peralatan ?");
		if (r == true) {
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
					//alert(data);
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
						location.reload();
					}else{
						alert(data);
					}
				}
			});
		});
	$("#findData").click(function(){
			var fdata = $('#fdata').val();
			var fdata2 = $('#fdata2').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-fdata.php',
				data:'ajax=1&fdata='+fdata+'&fdata2='+fdata2,
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
	$("#btcekall").click(function(){
		$('input:checkbox').not(this).prop('checked', this.checked);	
	});
	$("#btudah").click(function(){
			var checkValues = $('input[type=checkbox]:checked').map(function()
            {
                return $(this).val();
            }).get();
			var hal = <?php echo $hal;?>;
			//alert(checkValues);
			if (checkValues=='') {
				alert('Maaf silahkan pilih peserta terlebih dahulu!');
			}else{
				if(confirm("Anda yakin ingin menset selesai ?"))
				{
					$.ajax({
						type:'GET',
						url:'pwww/p-finishall.php',
						data:'ajax=1&qid='+checkValues+'&hal='+hal,
						success:function(data) {
							if(data) {
								window.location.href = "index.php?pg=status&hal="+data;
								//alert(data);
							}else { 
								alert(data);
							}
						}
					});
				}
				else
				{
					return false;
				}
			}
	            		
		});
	$("#btbelom").click(function(){
			var checkValues = $('input[type=checkbox]:checked').map(function()
            {
                return $(this).val();
            }).get();
			var hal = <?php echo $hal;?>;
			//alert(checkValues);
			if (checkValues=='') {
				alert('Maaf silahkan pilih peserta terlebih dahulu!');
			}else{
				if(confirm("Anda yakin ingin menset belum selesai ?"))
				{
					$.ajax({
						type:'GET',
						url:'pwww/p-unfinishall.php',
						data:'ajax=1&qid='+checkValues+'&hal='+hal,
						success:function(data) {
							if(data) {
								window.location.href = "index.php?pg=status&hal="+data;
							}else { 
								alert(data);
							}
						}
					});
				}
				else
				{
					return false;
				}
			}
	            		
		});
	$("#bt60").click(function(){
			var checkValues = $('input[type=checkbox]:checked').map(function()
            {
                return $(this).val();
            }).get();
			var hal = <?php echo $hal;?>;
			//alert(checkValues);
			if (checkValues=='') {
				alert('Maaf silahkan pilih peserta terlebih dahulu!');
			}else{
				if(confirm("Anda yakin ingin mereset waktu ujian ?"))
				{
					$.ajax({
						type:'GET',
						url:'pwww/p-resettimeall.php',
						data:'ajax=1&qid='+checkValues+'&hal='+hal+'&wtime=',
						success:function(data) {
							if(data) {
								window.location.href = "index.php?pg=status&hal="+data;
								//alert(data);
							}else { 
								alert(data);
							}
							
						}
					});
				}
				else
				{
					return false;
				}
			}
            		
		});
	$("#bt30").click(function(){
			var checkValues = $('input[type=checkbox]:checked').map(function()
            {
                return $(this).val();
            }).get();
			var hal = <?php echo $hal;?>;
			//alert(checkValues);
			if (checkValues=='') {
				alert('Maaf silahkan pilih peserta terlebih dahulu!');
			}else{
				if(confirm("Anda yakin ingin memberikan waktu 30 menit ?"))
				{
					$.ajax({
						type:'GET',
						url:'pwww/p-resettimeall.php',
						data:'ajax=1&qid='+checkValues+'&hal='+hal+'&wtime=30',
						success:function(data) {
							if(data) {
								window.location.href = "index.php?pg=status&hal="+data;
								//alert(data);
							}else { 
								alert(data);
							}
							
						}
					});
				}
				else
				{
					return false;
				}
			}
            		
		});
	$("#bt20").click(function(){
			var checkValues = $('input[type=checkbox]:checked').map(function()
            {
                return $(this).val();
            }).get();
			var hal = <?php echo $hal;?>;
			//alert(checkValues);
			if (checkValues=='') {
				alert('Maaf silahkan pilih peserta terlebih dahulu!');
			}else{
				if(confirm("Anda yakin ingin memberikan waktu 20 menit ?"))
				{
					$.ajax({
						type:'GET',
						url:'pwww/p-resettimeall.php',
						data:'ajax=1&qid='+checkValues+'&hal='+hal+'&wtime=20',
						success:function(data) {
							if(data) {
								window.location.href = "index.php?pg=status&hal="+data;
								//alert(data);
							}else { 
								alert(data);
							}
							
						}
					});
				}
				else
				{
					return false;
				}
			}
	            		
		});
	$("#bt10").click(function(){
			var checkValues = $('input[type=checkbox]:checked').map(function()
            {
                return $(this).val();
            }).get();
			var hal = <?php echo $hal;?>;
			//alert(checkValues);

			if (checkValues=='') {
				alert('Maaf silahkan pilih peserta terlebih dahulu!');
			}else{
				if(confirm("Anda yakin ingin memberikan waktu 10 menit ?"))
				{
					$.ajax({
						type:'GET',
						url:'pwww/p-resettimeall.php',
						data:'ajax=1&qid='+checkValues+'&hal='+hal+'&wtime=10',
						success:function(data) {
							if(data) {
								window.location.href = "index.php?pg=status&hal="+data;
								//alert(data);
							}else { 
								alert(data);
							}
							
						}
					});
				}
				else
				{
					return false;
				}
			}
	            		
		});
	$("#gantialat").click(function(){
			var checkValues = $('input[type=checkbox]:checked').map(function()
            {
                return $(this).val();
            }).get();
			var hal = <?php echo $hal;?>;
			//alert(checkValues);
			if (checkValues=='') {
				alert('Maaf silahkan pilih peserta terlebih dahulu!');
			}else{
				if(confirm("Anda yakin ingin ganti perlatan ujian ?"))
				{
					$.ajax({
						type:'GET',
						url:'pwww/p-gantipcall.php',
						data:'ajax=1&qid='+checkValues+'&hal='+hal,
						success:function(data) {
							if(data) {
								window.location.href = "index.php?pg=status&hal="+data;
								//alert(data);
							}else { 
								alert(data);
							}
							
						}
					});
				}
				else
				{
					return false;
				}
			}
	            		
		});
});
</script>
<div class="cpanel">
	<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
	</ul>
	<div class='spasi'></div>
	<div class='findp'>
		<input type='text' value='<?=$crdata;?>' id='fdata' class='style-2 wd20' placeholder='Filter data'>
		<input type='text' value='<?=$today;?>' id='fdata2' class='style-2 wd10'>
		<input type='button' value='Pencarian data' id='findData'>
		<input type='button' value='Clear' id='clearData'>
		<div class="letakKanan u14 margin5">
			<div id="btudah" class="statusP" title="Set telah dikerjakan">
				<img src="<?=$menufinish;?>" height="15px" class="imglink2" align="absmiddle">
			</div>
			<div id="btbelom" class="statusP" title="Set belum dikerjakan">
				<img src="<?=$menuunfinish;?>" height="15px" class="imglink2" align="absmiddle">
			</div>
			<div id="bt60" class="statusP" title="Reset waktu">
				<img src="<?=$menujam;?>" height="15px" class="imglink2" align="absmiddle">
			</div>
			<div id="bt30" class="statusP" title="Reset waktu 30 Menit">
				<b>30</b>
			</div>
			<div id="bt20" class="statusP" title="Reset waktu 20 Menit">
				<b>20</b>
			</div>
			<div id="bt10" class="statusP" title="Reset waktu 10 Menit">
				<b>10</b>
			</div>
			<div id="gantialat" class="statusP" title="Ijinkan pindah komputer">
				<img src="<?=$menudevice;?>" height="15px" class="imglink2" align="absmiddle">
			</div>
		</div>
	</div>

	<table width="100%">
		<tr style='background:#ebebe0;color:#000;'>
			<th width="20px">
				<center><input type="checkbox" name="btcekall" id="btcekall" value="0"></center>
			</th>
			<th style="padding:5px;">
				<center>No</center>
			</th>
			<th style="padding:5px;">
				Peserta Ujian
			</th>
			<th width="15%">
				<center>Kelompok</center>
			</th>
			<th width="10%">
				<center>Mapel</center>
			</th>
			<th width="10%">
				<center>Tingkat</center>
			</th>
			<th width="10%">
				<center>Ujian</center>
			</th>
			<th width="10%">
				<center>Login<br>Terakhir</center>
			</th>
			<th width="5%">
				<center>Sisa Waktu<br>(M)</center>
			</th>
		</tr>
		<?php
		$x=$start_from+1;
		while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
		{
			$id = $br['pid'];
			$idt = $br['id_test'];
			$kirim = $id.":".$idt;
			$warna = ($warna == '#fff' ? "#f5f5f0" : "#fff");
		?>
		<tr bgcolor="<? echo($warna);?>" title="<?=strtoupper($br['nama_test']);?>">
			<td>
				<center><input type="checkbox" name="r<?=$x;?>" value="<?=$kirim;?>"></center>
			</td>
			<td class="isi">
				<center><?=$x;?></center>
			</td>
			<td style="padding:5px;">
				<?=strtoupper($br['pengguna']);?> <?=strtoupper($br['nama_pengguna']);?><br>
				<?php
					$id = $br['pid'];
					$idt = $br['id_test'];

					$cek_log = "select * from t_activity where t_who='".$id."' and t_jam_log like '$today%' limit 1";
					$rsLog = mysqli_query($db,$cek_log);
					$jdata = mysqli_num_rows($rsLog);
					//echo $cek_log;
						if ($br['last_login']!='0000-00-00 00:00:00') {
							$ol = "online_status.png";
							$tol = "Ujian sedang dikerjakan!";
						}
						else
						{
							$ol = "status_offline.png";
							$tol = "Ujian belum dikerjakan!";
						}
						if ($br['kunci_login']=='1') {
							$kunci_user = "lock_green.png";
							$tkunci_user = "Login user terkunci! klik untuk ubah";
						}
						else
						{
							$kunci_user = "nolock.png";
							$tkunci_user = "Login user tidak terkunci! klik untuk ubah";
						}
						if ($br['diselesaikan']=='1') {
							$selesai ="finish.svg";
							$tselesai = "Ujian selesai dikerjakan! klik untuk ubah";
						}
						else
						{
							$selesai = "na.jpg";
							$tselesai = "Ujian belum selesai dikerjakan! klik untuk ubah";
						}

						/*
						if($br['system_type']!='')
						{
							$alat = "lock-login.png";
							$talat = "pc/smartphone telah tercatat! klik untuk ubah";
						}
						else
						{
							$alat = "computer.png";
							$talat = "pc/smartphone belum tercatat!";
						}
						*/
						if($jdata!=0)
						{
							$alat = "lock-login.png";
							$talat = "pc/smartphone telah tercatat! klik untuk ubah";
						}
						else
						{
							$alat = "computer.png";
							$talat = "pc/smartphone belum tercatat!";
						}
						
						?>
						<div id="ol-<?=$id;?>:<?=$idt;?>" class="olStatus statusP" title="<?=$tol;?>">
								<img src="images/<?=$ol;?>" height="15px" class="imglink" align="absmiddle">
						</div>
						<div id="udah-<?=$id;?>:<?=$idt;?>" class="udahStatus statusP" title="<?=$tselesai;?>">
							<img src="images/<?=$selesai;?>" height="15px" class="imglink" align="absmiddle">
						</div>
						<div id="terkunci-<?=$id;?>:<?=$idt;?>" class="lockStatus statusP" title="<?=$tkunci_user;?>">
							<img src="images/<?=$kunci_user;?>" height="15px" class="imglink" align="absmiddle">
						</div>
						<div id="time-<?=$id;?>:<?=$idt;?>" class="resetTime statusP" title="Reset waktu">
							<img src="images/waktu.svg" height="15px" class="imglink" align="absmiddle">
						</div>
						<div id="masuk-<?=$id;?>:<?=$idt;?>" class="resetMasuk statusP" title="<?=$talat;?>">
							<img src="images/<?=$alat;?>" height="15px" class="imglink" align="absmiddle">
						</div>
						<?php
				?>
			</td>
			<td>
				<center><?=strtoupper($br['kelompok']);?></center>
			</td>
			<td>
				<center><?=strtoupper($datamapel[$br['idmapel']]['mapel']);?></center>
			</td>
			<td>
				<center><?=strtoupper($datamapel[$br['idmapel']]['tingkat']);?></center>
			</td>
			<td>
				<center><?=strtoupper($br['nama_test']);?></center>
			</td>
			<td>
				<center><span style="font-size:10px;"><?=strtoupper($br['last_login']);?></span></center>
			</td>
			<td>
				<center>
					<?php
					if ($br['remaining_time']=='') {
						echo '<img src="images/editor_none_icon.png" height="20px" class="imglink" align="absmiddle">';
					}
					else
					{
						if (($br['remaining_time']/60) < 0) {
							echo '0';
						}
						else
						{
							echo floor($br['remaining_time']/60);
						}
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
	/*
	if(isset($_SESSION['fdata']) && !empty($_SESSION['fdata'])) {
		$sql = "select a.pid,a.pengguna,a.nama_pengguna,a.kelompok,b.* from t_peserta a, v_test_siswa b
		WHERE a.pid=b.id_peserta and a.nama_pengguna like '%$crdata%' and b.tgl_awal_test < '$tgl' and b.tgl_akhir_test > '$tgl' $tambahan union
		select c.pid,c.pengguna,c.nama_pengguna,c.kelompok,d.* from t_peserta c, v_test_siswa d
		WHERE c.pid=d.id_peserta and c.kelompok like '%$crdata%' and d.tgl_awal_test < '$tgl' and d.tgl_akhir_test > '$tgl' $tambahan2
		order by pengguna asc";
	}
	else{
		$sql = "select a.pid,a.pengguna,a.nama_pengguna,a.kelompok,b.* from t_peserta a, v_test_siswa b
		WHERE a.pid=b.id_peserta and b.tgl_awal_test < '$tgl' and b.tgl_akhir_test > '$tgl' $tambahan order by pengguna asc";
	}
	$rs = mysqli_query($db,$sql);
	$total_records = mysqli_num_rows($rs);
	$total_pages = ceil($total_records / $jumlah_per_page);
	*/
	echo "<div class='setpage'><input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Data' id='setpage'>
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
