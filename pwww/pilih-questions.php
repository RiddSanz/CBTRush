<?php
include "lib/configuration.php";
if (!isset($_SESSION['nomor'])) {
	$_SESSION['nomor']=0;
}
if(isset($_SESSION['jmlhal']))
{
	$jumlah_per_page=$_SESSION['jmlhal'];
}
else
{
	$jumlah_per_page=20;
}
$totc = 0;
$okc = 0;
$totdata = 0;
if (isset($_GET["hal"])) { $hal  = $_GET["hal"]; } else { $hal=1; }; 
$start_from = ($hal-1) * $jumlah_per_page; 

$idmapel = $_SESSION['idmapel'];

if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
	$crdata = $_SESSION['fdata'];
	$sql = "select * from t_soal a LEFT JOIN t_kd ON id_submapel=kdid WHERE a.id_mapel='$idmapel' 
	and nama_kd like '%$crdata%' ORDER BY a.qid ASC LIMIT $start_from, $jumlah_per_page ";
}
else
{
	$crdata ="";
	$sql = "select * from t_soal a LEFT JOIN t_kd ON id_submapel=kdid WHERE a.id_mapel='$idmapel' 
	ORDER BY a.qid ASC LIMIT $start_from, $jumlah_per_page ";
}

$rs = mysqli_query($db,$sql);

$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
$ket_mapel = $bm['ket_mapel'];
$kelas = $bm['kelas'];

$id=mysqli_real_escape_string($db,$_SESSION['idtest']);
$sqltest = "select * from t_test where id='$id' limit 1";

$rstest = mysqli_query($db,$sqltest);
$brtest = mysqli_fetch_array($rstest,MYSQLI_ASSOC);
$kodetest = $brtest['kode_test'];
$nmtest = strtoupper($brtest['nama_test']." ".$brtest['keterangan']);
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
		
		$(".pilih_soal").click(function(){
		   var pil_id = $(this).attr('id');
		   $("#preview"+pil_id).fadeIn("slow");
		   $("#preview"+pil_id).html('');
			$("#preview"+pil_id).html('<img src="images/spinner.gif" alt="Uploading...." width="10px"/>');
			$.post( "pwww/p-pilih-soal.php",{ pil_id:""+pil_id, kondisi:"satu" })
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
		$('#selecctall').click(function(){
			if(this.checked){ 
				$('.pilih_soal').each(function(){
					this.checked = true;	
					var pil_id = $(this).attr('id');
					$("#preview"+pil_id).fadeIn("slow");
					$("#preview"+pil_id).html('');
					$("#preview"+pil_id).html('<img src="images/spinner.gif" alt="Uploading...." width="10px"/>');
					$.post( "pwww/p-pilih-soal.php",{ pil_id:""+pil_id, kondisi:"cek" })
					.done(function(data){
						if (data==1){
							$("#preview"+pil_id).html('<img src="images/success.png" alt="Uploading...." width="15px"/>');
							
						}else
						{
							$("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="15px"/>');
							
						}
					})
					.fail(function(){
					    $("#preview"+pil_id).html('<img src="images/fail.png" alt="Uploading...." width="10px"/>');
					})
					.always(function(){
					    $("#preview"+pil_id).fadeOut(3000);
					});
				});
			}else{
				$('.pilih_soal').each(function(){
					this.checked = false; 
					var pil_id = $(this).attr('id');
					$("#preview"+pil_id).fadeIn("slow");
					$("#preview"+pil_id).html('');
					$("#preview"+pil_id).html('<img src="images/spinner.gif" alt="Uploading...." width="10px"/>');
					$.post( "pwww/p-pilih-soal.php",{ pil_id:""+pil_id ,kondisi:"uncek"})
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
		        if(data) {   
		        	$("body").load("index.php?pg=menutestq").hide().fadeIn(1500).delay(6000);
		        } else { 
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
	<link rel="stylesheet" type="text/css" href="css/popup-window.css" />
	<div class="cpanel">
		<?PHP/*
		<div class="nm-list-section">
			<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
			<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
			<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a>
			<a href='#' onclick="window.location='?pg=ltest'">Test</a>
			<a href='#' onclick="window.location='?pg=menutest&idtest=<?=$id;?>'">Atur Soal dan Peserta <?=$nmtest;?></a> |
			Pilih Soal
		</div>*/?>
		<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
			<li><a href='#' onclick="window.location='?pg=ltest'"><?=$site3;?></a></li>
			<li><a href='#' onclick="window.location='?pg=menutest&idtest=<?=$id;?>'"><?=$site4;?><?=strtoupper($nmtest);?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site5;?></a></li>
		</ul>
		<div class='spasi'></div>
		<div class='btnback2 letakKanan' onclick="window.location='?pg=menutest&idtest=<?=$id;?>'">
			<img src="images/back.png" width="10px" align='absmiddle' class="imglink"> Kembali
		</div>	
		<div class='findp'>
			<input type='text' value='<?=$crdata;?>' id='fdata' class='style-1 wd50' placeholder='Filter data'>
			<input type='button' value='Pencarian data' id='findData'>
			<input type='button' value='Clear' id='clearData'>
		</div>
		<table width="100%" id="t01">
			<tr>
				<th width="5%">
					<center>NO</center>
				</th>				
				<th width="55%">
					PERTANYAAN
				</th>
				<th>
					UNIT
				</th>
				<th width="40px" >
					&nbsp;
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
					$totdata++;
					$idsoal = $br['qid'];					
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
						<td>
							<?php
							if($br['nama_kd']==''){
								echo "--";
							}
							else{
								echo $br['nama_kd'];
							}
							?>
						</td>
						<td>
							<div onclick="popup_window_show('#prev<?=$idsoal;?>', { pos : 'window-center',       width : '500px' });" class="btnstatus">
								<img src="images/preview_file.png" height="15px" class="imglink" align="absmiddle">
							</div>
							<div   class="popup_window_css" id="prev<?=$idsoal;?>">
								<table class="popup_window_css">
									<tr    class="popup_window_css">
										<td    class="popup_window_css">
											<div   class="popup_window_css_head"><img src="images/close.gif" alt="" width="9" height="9" />Preview pertanyaan</div>
											<div   class="popup_window_css_body">
												<div style="border: 1px solid #808080; padding: 6px; background: #FFFFFF;">
													<?=$br['isi_soal'];?>													
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
							$sc = "select * from t_test_pertanyaan where id_soal='$idsoal' and id_test='$id' limit 0,1";
							$rc = mysqli_query($db,$sc);
							$tc = mysqli_num_rows($rc);
							if ($tc==1) {
								$totc++;
							}

							?>
							<input class='pilih_soal' type="checkbox" name="soal[]" id="<?=$idsoal;?>" value="<?=$idsoal;?>" <?php if($tc==1) echo "checked";?>>
							<label for="<?=$idsoal;?>">&nbsp;</label><div class="checkUser" id='preview<?=$idsoal;?>'></div>
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
				<th colspan='2' >
					Pilih semua
				</th>				
				<th width="70px">
					<?php
						if ($totc==$totdata) {
							$okc = 1;
						}
						else
						{
							$okc = 0;
						}
					?>
					<input class='pilihsemua' type="checkbox" id="selecctall" value='all' <?php if($okc==1) echo 'checked';?>/><label for="all">&nbsp;</label>
				</th>
			</tr>
		</table>
		<br>
		<div class='btnback2 letakKanan' onclick="window.location='?pg=menutest&idtest=<?=$id;?>'">
			<img src="images/back.png" width="10px" align='absmiddle' class="imglink"> Kembali
		</div>		

	</div>

<?php	
	if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
		$sql = "select * from t_soal a LEFT JOIN t_kd ON id_submapel=kdid WHERE a.id_mapel='$idmapel' 
		and nama_kd like '%$crdata%' ORDER BY a.qid ASC";
	}
	else
	{
		$sql = "select * from t_soal a LEFT JOIN t_kd ON id_submapel=kdid WHERE a.id_mapel='$idmapel' 
		ORDER BY a.qid ASC";
	}
	$rs = mysqli_query($db,$sql); 
	$total_records = mysqli_num_rows($rs);  
	$total_pages = ceil($total_records / $jumlah_per_page);

	echo "<div class='setpage'><input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Data' id='setpage'>
	</div>";
	
	echo "<a href='?pg=menutestq&hal=1' class='lpg'>".'|<'."</a> ";  

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
		echo "<a href='?pg=menutestq&hal=".$i."' class='$rgb'>".$i."</a> "; 
	}; 
	if ($total_pages<($hal+10)) {
		echo "";
	}
	else
	{
		echo "......";
		echo "<a href='?pg=menutestq&hal=".$total_pages."' class='$rgb'>".$total_pages."</a> ";
	}
	echo "<a href='?pg=menutestq&hal=$total_pages' class='lpg'>".'>|'."</a> "; 
	echo "<div class='spasi'></div><div class='spasi'></div>";
}
mysqli_close($db);
?>

