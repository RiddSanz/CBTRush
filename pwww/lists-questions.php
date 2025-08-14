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
$sql = "select * from t_soal a LEFT JOIN t_kd ON id_submapel=kdid WHERE a.id_mapel='$idmapel' ORDER BY a.qid ASC 
		LIMIT $start_from, $jumlah_per_page ";

$rs = mysqli_query($db,$sql);

$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
$ket_mapel = $bm['ket_mapel'];
$kelas = $bm['kelas'];
$sqkd = "select kdid,nama_kd from t_kd where id_mapel='$idmapel'";
$rskd = mysqli_query($db,$sqkd);
$list_tipe = array('0' => 'opsi','1' => 'esay' );
$list_kesulitan = array('1' => 'Mudah','2' => 'Sedang','3' => 'Sulit' );
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
	/*
	window.onload = function() {
		
		$('.delete').click(function(e) {
			alert('testing');
			e.preventDefault();
			var parent = $(this).parent();
			$.ajax({
				type: 'get',
				url: 'pwww/p-soaldelete.php',
				data: 'ajax=1&id=' + parent.attr('id').replace('record-',''),
				beforeSend: function() {
					parent.animate({'backgroundColor':'#fb6c6c'},300);
				},
				success: function(data) {
					//parent.slideUp(300,function() {
					//	parent.remove();
					//});
					if (data=='1') {
						$("body").load("index.php?pg=q").hide().fadeIn(1500).delay(6000);
					}else {
						alert(data);
					}				
				}
			});
		});
		
	}
	*/
	$(document).ready(function(){
		$(".delete_class").click(function(){
			var del_id = $(this).attr('id');
			$.ajax({
				type:'GET',
				url:'pwww/p-soaldelete.php',
				data:'ajax=1&id='+del_id,
				success:function(data) {
					if(data) {  
						window.location.href = "index.php?pg=q";
					}else { 
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
					if(data) {
						window.location.href = "index.php?pg=q";
					}else { 
						alert(data);
					}
				}
			});
		});
		$("#btnsetKD").click(function(){
			var idkd = $('#idlistkd').val();
			var tmpqid = $('#tmpqid').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-kd.php',
				data:'ajax=1&idkd='+idkd+'&tmpqid='+tmpqid,
				success:function(data) {
					if(data) {
						window.location.href = "index.php?pg=q";
					}else { 
						alert(data);
					}
				}
			});
		});
		$(".btnDel").click(function(){
			var idm = <?=$idmapel;?>;
			if(confirm("Anda yakin ingin menghapus semua pertanyaan?"))
			{
				$.ajax({
					type:'GET',
					url:'pwww/p-delsoalall.php',
					data:'ajax=1&id='+idm,
					success:function(data) {
						if(data) {
							window.location.href = "index.php?pg=q";
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
		});
	});
	</script>
	<link rel="stylesheet" type="text/css" href="css/popup-window.css" />
	<div class="cpanel">
		<?PHP /*
		<div class="nm-list-section">
		<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
		<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
		<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a> | 
		Pertanyaan
		</div>*/?>
		<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
		</ul>
		<div class='spasi'></div>
		<div class='btnback' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'">
			<img src="images/back.png" width="10px" align='absmiddle' class="imglink"> Kembali
		</div>
		<div class="btnDel letakKanan u12">
			<img src="images/fail.png" width="15px" align='absmiddle' class="imglink"> Hapus Semua
		</div>
		<div class="btnadd" onclick="window.location='?pg=f-addsoal'">
			<img src="images/add.png" width="15px" align='absmiddle' class="imglink"> Tambah Pertanyaan
		</div>
		<div class="btnpreview" onclick="window.location='?pg=previewsoal'">
			<img src="images/previewb.png" width="15px" align='absmiddle' class="imglink"> Preview Pertanyaan
		</div>
		<table width="100%" id="t01">
			<tr>
				<th width="5%">
					<center>NO</center>
				</th>				
				<th>
					<center>PERTANYAAN</center>
				</th>
				<th width="50px">
					<center>TINGKAT</center>
				</th>
				<th width="50px">
					<center>POINT</center>
				</th>
				<th width="50px">
					<center>TIPE</center>
				</th>
				<th width="100px">
					<center>UNIT</center>
				</th>				
				<th width="110px">
					<center>PENGATURAN</center>
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
				$tmpQuestion = "";
				$x=$start_from+1;
				while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
				{
					?>
					<tr>
						<td class="isi">
							<center><?=$x;?></center>
						</td>
						<td>
							<?php 
							if (strlen(strip_tags($br['isi_soal']))<50) {
								$soal = substr(strip_tags($br['isi_soal']), 0,50);
								echo $soal;
							}
							else
							{
								$soal = substr(strip_tags($br['isi_soal']), 0,50);
								echo $soal.'...';
							}
								
							?>
						</td>
						<td title="<?=$br['tingkat_kesulitan'];?>"><center>
							<?php
							echo $list_kesulitan[$br['tingkat_kesulitan']];								
							?></center>
						</td>
						<td title="<?=$br['point_soal'];?>"><center>
							<?php
							echo $br['point_soal'];								
							?></center>
						</td>
						<td title="<?=$br['opsi_esay'];?>"><center>
							<?php
							echo $list_tipe[$br['opsi_esay']];								
							?></center>
						</td>
						<td title="<?=$br['nama_kd'];?>"><center>
							<?php
							if($br['nama_kd']=='')
							{
								echo "belum diset";
							}								
							else{
								echo $br['nama_kd'];
							}								
							?></center>
						</td>
						<td>
							<?php 
							$id = $br['qid'];	
							$tmpQuestion = $id. "," .$tmpQuestion;				
							?>							
							<div class="delete_class btnstatus" id="<?=$id;?>">
								<img src="images/cancel.png" height="15px" class="imglink" align="absmiddle">
							</div>
							<div onclick="window.location='?pg=f-addsoal&s=<?=$id;?>'" class="btnstatus">
								<img src="images/write2.png" height="15px" class="imglink" align="absmiddle">
							</div>
							<div onclick="popup_window_show('#prev<?=$id;?>', { pos : 'window-center',       width : '500px' });" class="btnstatus">
								<img src="images/visits.png" height="15px" class="imglink" align="absmiddle">
							</div>
							<?php
							
							?>
							<div   class="popup_window_css" id="prev<?=$id;?>">
								<table class="popup_window_css">
									<tr    class="popup_window_css">
										<td    class="popup_window_css">
											<div   class="popup_window_css_head"><img src="images/close.gif" alt="" width="9" height="9" />Preview pertanyaan</div>
											<div   class="popup_window_css_body">
												<div style="border: 1px solid #808080; padding: 6px; background: #FFFFFF;">
													<?=$br['isi_soal'];?>
													<?php 
													if($br['opsi_esay']=='0')
													{
													?>													
													<ol type="A">
													<?php 
													for($i=1; $i <= 5; $i++) 
													{ 
														if($br['pilihan'.$i]!='')
														{
														?>
															<li><?=$br['pilihan'.$i];?></li>
														<?php
														}
													}
													?>
													</ol>
													<?php
													}
													?>																										
												</div>
											</div>
											<div   class="popup_window_css_foot"><a href="http://www.php-development.ru/javascripts/popup-window.php" title="Powered by PHPDevel Popup Window | PHPDevel web scripts collection"><img src="images/about.gif" alt="" width="6" height="6" /></a>
											</div>
										</td>
									</tr>
								</table>
							</div>				
						</td>
					</tr>
					<?php 
					$x++;
				}
			}
			?>
		</table><br>
		<input list="listkd" name="listkd" id="idlistkd">
  			<datalist id="listkd">
  				<?php
  				while ($bmkd = mysqli_fetch_array($rskd,MYSQLI_ASSOC)) {
  					?>
  					<option value="<?=$bmkd['kdid'];?>"><?=$bmkd['nama_kd'];?>
  					<?php
  				}
  				?>
  						    
		  </datalist>
  		<input type="button" id="btnsetKD" value="set unit KD">
  		<input type="hidden" id="tmpqid" value="<?=substr($tmpQuestion, 0, -1);?>">
	</div>
<?php
	
	$sql = "select * FROM t_soal a LEFT JOIN t_kd ON id_submapel = kdid where a.id_mapel =  '$idmapel' ORDER BY a.qid ASC ";
	$rs = mysqli_query($db,$sql); 
	$total_records = mysqli_num_rows($rs);  
	$total_pages = ceil($total_records / $jumlah_per_page);

	echo "<div class='setpage'><input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Data' id='setpage'>
	</div>";
	
	echo "<a href='?pg=q&hal=1' class='lpg'>".'|<'."</a> ";  

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
		echo "<a href='?pg=q&hal=".$i."' class='$rgb'>".$i."</a> "; 
	}; 
	if ($total_pages<($hal+10)) {
		echo "";
	}
	else
	{
		echo "......";
		echo "<a href='?pg=q&hal=".$total_pages."' class='$rgb'>".$total_pages."</a> ";
	} 
	echo "<a href='?pg=q&hal=$total_pages' class='lpg'>".'>|'."</a> "; 	
	echo "<div class='spasi'></div><div class='spasi'></div>";
}
mysqli_close($db);
?>

