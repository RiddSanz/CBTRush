<?php
include "lib/configuration.php";
require_once("pwww/konversi-tgl.php");
$jumlah_per_page=20;
if (isset($_GET["hal"])) { $hal  = $_GET["hal"]; } else { $hal=1; }; 
$start_from = ($hal-1) * $jumlah_per_page; 

$idmapel = $_SESSION['idmapel'];

$sql = "select * from t_test where idmapel='$idmapel' order by tgl_awal_test asc LIMIT $start_from, $jumlah_per_page";

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
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
	<script src="js/bootstrap-dialog.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script>	
	$(document).ready(function(){		
	 $(".delete_class").click(function(){	 	
	   var del_id = $(this).attr('id');
	   BootstrapDialog.show({
	   		title: 'Konfirmasi',
            message: 'Anda Yakin ingin menghapus test ini?',
            buttons: [{
                label: 'Ya',
                cssClass: 'btn-primary',
                data: {
                    js: 'btn-confirm',
                    'user-id': '3'
                },
                action: function(){
                    $.ajax({
				      type:'GET',
				      url:'pwww/p-testdelete.php',
				      data:'ajax=1&id='+del_id,
				      success:function(data) {
				        if(data) {   
				        	location.reload();
				        } else { 				         
				        	alert(data);
				    	}
				      }
				   });
                }
            },{
                label: 'Batal',
                action: function(dialogItself){
                    dialogItself.close();
                }
            }]
        });	   
	   
	 });
	 $(".btnfinall").click(function()
		{
			var nomorid = $(this).attr('id').replace('btnSetFin-','');
			$.ajax({
				type:'GET',
				url:'pwww/p-finishmapel.php',
				data:'ajax=1&nomorid='+nomorid,
				success:function(data) {
					if(data==1){
						//location.reload();
						alert("Test diset selesai semua!");
						window.location='?pg=ltest';
					}
					else
					{
						alert(data);
					}					
				}
			});
		});
	 $(".btnUnFinish").click(function()
		{
			var nomorid = $(this).attr('id').replace('btnSetUnFin-','');
			$.ajax({
				type:'GET',
				url:'pwww/p-unfinishmapel.php',
				data:'ajax=1&nomorid='+nomorid,
				success:function(data) {
					if(data==1){
						//location.reload();
						alert("Test diset belum selesai semua!");
						window.location='?pg=ltest';
					}
					else
					{
						alert(data);
					}					
				}
			});
		});
	 $(".btnRtime").click(function()
		{
			var nomorid = $(this).attr('id').replace('btnResetTime-','');
			$.ajax({
				type:'GET',
				url:'pwww/p-reset-time-all.php',
				data:'ajax=1&nomorid='+nomorid,
				success:function(data) {
					if(data==1){
						//location.reload();
						alert("Waktu ujian telah direset semua!");
						window.location='?pg=ltest';
					}
					else
					{
						alert(data);
					}					
				}
			});
		});
	});
	</script>
	<div class="cpanel">
		<?PHP /*
		<div class="nm-list-section">
			<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
			<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a> 
			<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a> | 
			Buat Test
		</div>*/?>
		<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
		</ul>
		<div class='spasi'></div>
		<div class='btnback' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'">
			<img src="images/back.png" width="20px" align='absmiddle' class="imglink"> Kembali
		</div>
		<div class="btnadd" onclick="window.location='?pg=f-addtest'">
			<img src="images/add.png" width="20px" align='absmiddle' class="imglink"> Buat Test Baru
		</div>
		<table width="100%">
			<tr style='background:#ebebe0;color:#000;'>
				<th width="20px">
					<center>N0</center>
				</th>						
				<th>
					<center>Nama Ujian</center>
				</th>	
				<th width="30px">
					<center>Pilihan</center>
				</th>
				<th width="30px">
					<center>Uraian</center>
				</th>			
				<th width="200px">
					<center>Jadwal</center>
				</th>
				<th width="30px">
					<center>Siswa</center>
				</th>
				<th width="30px">
					<center>Pertanyaan<br>SK/ST</center>
				</th>
				<th width="30px">
					<center>Waktu<br>(menit)</center>
				</th>				
				<th width="300px">
					<center>-</center>
				</th>
			</tr>
			<?php
			$jdata = mysqli_num_rows($rs);
			if ($jdata==0) {
				echo '<tr>
				<td class="isi"  colspan="9">
				<center>DATA TEST MASIH KOSONG</center>
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
					<tr bgcolor="<? echo($warna);?>" >
						<td class="isi">
							<center><?=$x;?></center>
						</td>						
						<td>
							<?php 
							$id = $br['id'];												
							?>
							<?=strtoupper($br['nama_test']);?> <?=$br['keterangan'];?>	

							<?php
							?>						
						</td>	
						<td><?=$br['soal_opsi'];?></td>	
						<td><?=$br['soal_esay'];?></td>				
						<td><center>
							<?php echo konversi_tanggal("D",$br['tgl_awal_test']);?> 
							<?php echo konversi_tanggal("j M Y",$br['tgl_awal_test']);?><br>
							<?php echo konversi_tanggal("H:i:s",$br['tgl_awal_test']);?>
							-
							<?php //echo konversi_tanggal("D",$br['tgl_akhir_test']);?>
							<?php //echo konversi_tanggal("j M Y",$br['tgl_akhir_test']);?>
							<?php echo konversi_tanggal("H:i:s",$br['tgl_akhir_test']);?>
							<?php //echo $br['tgl_awal_test'];?> 
							<?php //echo $br['tgl_akhir_test'];?>
							</center>
						</td>
						<td>
							<center><?=$br['jumlah_peserta'];?></center>
						</td>
						<td>
							<center><?=$br['jumlah_soal'];?>/<?=$br['total_soal_dicek'];?></center>
						</td>
						<td>
							<center><?=$br['waktu_test'];?></center>
						</td>
						<td>
							&nbsp;
							<div class='linktest warnaBgBiru' title="Klik untuk memilih pertanyaan , peserta ujian dan lihat hasil!"  onclick="window.location='?pg=menutest&idtest=<?=$br['id'];?>'">				
							KELOLA
							</div>
							<div class='linktest warnaBgHijau' title="Klik untuk mengubah test"  onclick="window.location='?pg=f-addtest&s=<?=$id;?>'">				
							UBAH
							</div>
							<div class='delete_class linktest warnaBgMerah' id="<?=$id;?>" title="Klik untuk menghapus test">				
							HAPUS
							</div>
						</td>
					</tr>
					<?php 
					$x++;
				}
			}
			?>
		</table>
		<div style="font-size:12px;">
			Keterangan :<br>
			<ol>
  				<li>SK = Jumlah soal yang dikeluarkan</li>
  				<li>ST = Jumlah soal yang dipilih dari bank soal</li>
  				<li>Kelola Test digunakan untuk :
  					<ul>
  						<li>Memilih soal yang akan di keluarkan.</li>
  						<li>Memilih peserta test.</li>
  						<li>Mengubah status test menjadi selesai untuk semua peserta.</li>
  						<li>Mengubah status test menjadi belum selesai untuk semua peserta.</li>
  						<li>Mereset ulang waktu test untuk semua peserta.</li>
  					</ul>
  				</li>
  				<li>Ubah Test digunakan untuk :
  					<ul>
  						<li>Mengubah jenis test (PAS,PTS,PH dan lainnya).</li>
  						<li>Durasi test / Waktu pengerjaan oleh peserta test.</li>
  						<li>Waktu dibuka dan ditutupnya test.</li>
  						<li>Jumlah soal yang dikeluarkan ke peserta test.</li>
  						<li>Jumlah tingkat kesukaran soal.</li>
  						<li>Pengacakan soal dan jawaban soal.</li>
  					</ul>	
  				</li>
			</ol>			
			
		</div>
	</div>
<?php
	
	$sql = "select * from t_test where idmapel='$idmapel' order by tgl_awal_test asc";

	$rs = mysqli_query($db,$sql); 
	$total_records = mysqli_num_rows($rs);  
	$total_pages = ceil($total_records / $jumlah_per_page); 
	
	echo "<a href='?pg=ltest&hal=1' class='lpg'>".'|<'."</a> ";  

	for ($i=1; $i<=$total_pages; $i++) { 
		if($hal==$i)
		{
			$rgb = 'lpgw';
		}
		else
		{
			$rgb = 'lpg';
		}
		echo "<a href='?pg=ltest&hal=".$i."' class='$rgb'>".$i."</a> "; 
	}; 
	echo "<a href='?pg=ltest&hal=$total_pages' class='lpg'>".'>|'."</a> "; 

}
require_once "pwww/p_enc.php";if(enc($_SESSION['trueValKey'])!=($_SESSION['sid_user'].$_SESSION['namaSEKOLAH'])) {include "pwww/logout.php";}
?>