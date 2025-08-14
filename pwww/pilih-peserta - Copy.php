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

$idmapel = $_SESSION['idmapel'];

if(isset($_SESSION['fdata'])) {
	$crdata = $_SESSION['fdata'];
	$sql = "select * from t_peserta a where a.tingkat='2' and a.kelompok like '%$crdata%' 
	union select * from t_peserta b where b.tingkat='2' and b.nama_pengguna like '%$crdata%' 
	ORDER BY pengguna ASC LIMIT $start_from, $jumlah_per_page ";
}
else{
	$crdata = '';
	$sql = "select * from t_peserta where tingkat='2' ORDER BY pengguna ASC 
			LIMIT $start_from, $jumlah_per_page ";
}

$rs = mysqli_query($db,$sql);

$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];

$id=mysqli_real_escape_string($db,$_SESSION['idtest']);
$sqltest = "select * from t_test where id='$id' limit 1";

$rstest = mysqli_query($db,$sqltest);
$brtest = mysqli_fetch_array($rstest,MYSQLI_ASSOC);
$kodetest = $brtest['kode_test'];
$tid = $id;

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
	$(document).ready(function(){
		
		$(".pilih_peserta").click(function(){		   
		   var pil_id = $(this).attr('id');		   
		   $("#preview"+pil_id).fadeIn("slow");
		   $("#preview"+pil_id).html('');
			$("#preview"+pil_id).html('<img src="images/spinner.gif" alt="Uploading...." width="10px"/>');
			$.post( "pwww/p-pilih-siswa.php",{ pil_id:""+pil_id, kondisi:"satu" })
			.done(function(data) {			 
			  if (data==1) {
			  	$("#preview"+pil_id).html('<img src="images/success.png" alt="Uploading...." width="15px"/>');			  	
			  }else
			  {
			  	$("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="15px"/>');			  	
			  }
			})
			.fail(function() {
			   $("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="10px"/>');
			})
			.always(function() {
				$("#preview"+pil_id).fadeOut(3000);
			});
		 });

		$("#pilihAll").click(function(){
			if(this.checked){
				$('.pilih_peserta').each(function() { 
				this.checked = true;  
				var pil_id = $(this).attr('id');
				   $("#preview"+pil_id).fadeIn("slow");
				   $("#preview"+pil_id).html('');
					$("#preview"+pil_id).html('<img src="images/spinner.gif" alt="Uploading...." width="10px"/>');
					$.post( "pwww/p-pilih-siswa.php",{ pil_id:""+pil_id, kondisi:"cek" })
					.done(function(data) {					  
					  if (data==1) {
					  	$("#preview"+pil_id).html('<img src="images/success.png" alt="Uploading...." width="15px"/>');					  	
					  }else
					  {
						$("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="15px"/>');					  	
					  }
					})
					.fail(function() {
						$("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="10px"/>');
					})
					.always(function() {
						$("#preview"+pil_id).fadeOut(3000);
					});
				});
			}else{
				$('.pilih_peserta').each(function() { 
					this.checked = false; 
					var pil_id = $(this).attr('id');
				   $("#preview"+pil_id).fadeIn("slow");
				   $("#preview"+pil_id).html('');
					$("#preview"+pil_id).html('<img src="images/spinner.gif" alt="Uploading...." width="10px"/>');
					$.post( "pwww/p-pilih-siswa.php",{ pil_id:""+pil_id ,kondisi:"uncek"})
					.done(function(data) {
					  if (data==1) {
					  	$("#preview"+pil_id).html('<img src="images/success.png" alt="Uploading...." width="15px"/>');
					  	
					  }else
					  {
					  	$("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="15px"/>');
					  	
					  }
					})
					.fail(function() {
						$("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="10px"/>');
					})
					.always(function() {
						$("#preview"+pil_id).fadeOut(3000);
					});
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
						$("body").load("index.php?pg=menutestp").hide().fadeIn(1500).delay(6000);
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
						$("body").load("index.php?pg=menutestp").hide().fadeIn(1500).delay(6000);
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
	<link rel="stylesheet" type="text/css" href="css/popup-window.css" />
	<div class="cpanel">
		<div class="nm-list-section">
			<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a> | 
			<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a> | 
			<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$nm_mapel;?></a> | 
			<a href='#' onclick="window.location='?pg=ltest'">Test</a> |
			<a href='#' onclick="window.location='?pg=menutest&idtest=<?=$id;?>'">Atur Soal dan Peserta <?=$kodetest;?></a> |
			Pilih Peserta
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
					<center>NO</center>
				</th>				
				<th width="65%">
					NAMA SISWA
				</th>
				<th>
					KELAS
				</th>				
				<th width="70px">
					PILIH
				</th>
			</tr>
			<?php
			$jdata = mysqli_num_rows($rs);
			if ($jdata==0) {
				echo '<tr>
				<td class="isi"  colspan="6">
				<center>DATA PERTANYAAN MASIH KOSONG</center>
				</td>';
			} 
			else
			{
				$x=$start_from+1;
				while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
				{
					$pid = $br['pid'];					
				?>
					<tr>
						<td class="isi">
							<center><?=$x;?></center>
						</td>
						<td>
							<?php 
							if (strlen(strip_tags($br['nama_pengguna']))<50) {
								$siswa = substr(strip_tags($br['nama_pengguna']), 0,50);
								echo $siswa;
							}
							else
							{
								$siswa = substr(strip_tags($br['nama_pengguna']), 0,50);
								echo $siswa.'...';
							}
								
							?>
						</td>
						<td><?=$br['kelompok'];?>
							<div onclick="popup_window_show('#prev<?=$pid;?>', { pos : 'window-center',   width : '500px' });" class="btnstatus">
								<img src="images/preview_file.png" height="15px" class="imglink" align="absmiddle">
							</div>
							<div   class="popup_window_css" id="prev<?=$pid;?>">
								<table class="popup_window_css">
									<trclass="popup_window_css">
										<tdclass="popup_window_css">
											<div   class="popup_window_css_head"><img src="images/close.gif" alt="" width="9" height="9" />Preview pertanyaan</div>
											<div   class="popup_window_css_body">
												<div style="border: 1px solid #808080; padding: 6px; background: #FFFFFF;">
													<?=$br['nama_pengguna'];?> <br>													
													<?=$br['kelompok'];?>																										
												</div>
											</div>
											<div class="popup_window_css_foot">&nbsp;</div>
										</td>
									</tr>
								</table>
							</div>
						</td>
						<td>
							<?php 
							$sc = "select * from t_test_peserta where id_peserta='$pid' and id_test='$tid' limit 0,1";
							
							$rc = mysqli_query($db,$sc);
							$tc = mysqli_num_rows($rc);
							?>
							<input class='pilih_peserta' type="checkbox" name="lsiswa[]" id="<?=$pid;?>" value="<?=$pid;?>" <?php if($tc==1){echo "checked";}?>>
							<label for="<?=$pid;?>">&nbsp;</label><div class="checkUser" id='preview<?=$pid;?>'></div>
						</td>
					</tr>
					<?php 
					$x++;
				}
			}
			?>
			<tr>
				<th width="5%">
					&nbsp;
				</th>				
				<th width="55%">
					&nbsp;
				</th>				
				<th>
					Pilih semua
				</th>				
				<th>
					<input class='pilihsemua' type="checkbox" id="pilihAll" value='all'/><label for="all">&nbsp;</label>
				</th>
			</tr>
		</table>
	</div>
<?php
	
	if (isset($_SESSION['fdata'])) {
		$sql = "select * from t_peserta a where a.tingkat='2' and a.kelompok like '%$crdata%' 
		union select * from t_peserta b where b.tingkat='2' and b.nama_pengguna like '%$crdata%' 
		ORDER BY pengguna ASC";
	}
	else{
		$sql = "select * from t_peserta where tingkat='2' ORDER BY pengguna ASC";
	}
	$rs = mysqli_query($db,$sql); 
	$total_records = mysqli_num_rows($rs);  
	$total_pages = ceil($total_records / $jumlah_per_page);

	echo "<div class='setpage'>Tampilkan <input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Set Halaman' id='setpage'>
	</div>";
	
	echo "<a href='?pg=menutestp&hal=1' class='lpg'>".'|<'."</a> "; 

	for ($i=1; $i<=$total_pages; $i++) { 
		if($hal==$i)
		{
			$rgb = 'lpgw';
		}
		else
		{
			$rgb = 'lpg';
		}
		echo "<a href='?pg=menutestp&hal=".$i."' class='$rgb'>".$i."</a> "; 
	}; 
	echo "<a href='?pg=menutestp&hal=$total_pages' class='lpg'>".'>|'."</a> "; 	
	echo "<div class='spasi'></div><div class='spasi'></div>";
}
?>

