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
?>
<style>
.opsiku {
	float: left;
	border: 1px solid grey;
	height: 25px;
	width: 25px;
	border-radius: 50%;
	text-align: center;
	vertical-align: middle;
	line-height: 25px;
	color: #000;
}
.pilihanopsi{
	width: 80%;
}
.pilsoal{
	margin-top: 10px;
}
#topsi
{
	clear: both;
	border-style: none;
	width: 100%;
}
table#topsi td{
	padding: 5px;
	margin:0;
}
.tdopsi {
	width: 40px;
}
.mnfont {
	border: 1px solid grey;
	width: 25px;
	cursor: pointer;
	transition: all 0.5s ease;
}
.mnfont:hover {
	background: #ffbe00;
}
.bgputih {
	background-color: #ffffff;
}
.bghijau {
	background-color: #83FE86;
}
.bghitam {
	background-color: #000;
	color: #fff;
}
</style>
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
		
		$("#setpage").click(function(){
			var jmlhal = $('#jmlhal').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-hal.php',
				data:'ajax=1&jmlhal='+jmlhal,
				success:function(data) {
					if(data) {
						window.location.href = "index.php?pg=previewsoal";
					}else { 
						alert(data);
					}
				}
			});
		});		
	});
	</script>
	<link rel="stylesheet" type="text/css" href="css/popup-window.css" />
	<div class="cpanel">
		<?PHP /*
		<div class="nm-list-section">
		<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
		<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
		<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a>
		<a href='#' onclick="window.location='?pg=q'">Pertanyaan</a> | Preview 
		</div>*/?>
		<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
			<li><a href='#' onclick="window.location='?pg=q'"><?=$site3;?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site4;?></a></li>
		</ul>
		<div class='spasi'></div>
		<div class='btnback letakKanan' onclick="window.location='?pg=q'">
			<img src="images/back.png" width="10px" align='absmiddle' class="imglink"> Kembali
		</div>		
		<div class='previewsoal'>
			<?php
			$benar = array("a"=>1,"b"=>2,"c"=>3,"d"=>4,"e"=>5);
			$abc = array('0' => 'A','1' => 'B','2' => 'C','3' => 'D','4' => 'E' );
			$x=$start_from+1;
			echo '<ul style="list-style: none;">';
			$jdata = mysqli_num_rows($rs);
			if ($jdata==0) {
				echo '<li>DATA MASIH KOSONG!</li>';				
			} 
			else
			{				
				while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
				{
					echo "<div class='prevnomor'>Nomor : ".$x." <div class='btnadd' onclick='window.location=\"?pg=f-addsoal&s=".$br['qid']."\"'>Ubah data</div></div>";
					?>
					<table id='topsi'>
						<tr>
							<td colspan='2'>
								<?=$br['isi_soal'];?>
							</td>
						</tr>
						<?php 
						$j=0;
						for($i=1; $i < 6; $i++)
						{
							if ($br['pilihan'.$i]!='' || !empty($br['pilihan'.$i])) {
								if ($benar[$br['benar']]==$i) {
									$opsiwarna = "bghitam";
								}
								else{
									$opsiwarna = "bgputih";
								}

						?>
						<tr>				
						<div class="pilujian" id="pilujian">
							<td class="tdopsi">
								<div class='opsiku <?=$opsiwarna;?>'><?=$abc[$j];?></div>
							</td>
							<td>
								<div class='pilihanopsi'>				  			
							   		<label for="radio<?=$i;?>">
							    		<?=nl2br(trim(str_replace(array("<p>","</p>"),array("","\n"),$br['pilihan'.$i])));?>
							    		<?php /*<img src="images/<?=$kar[$j];?>.png" width="20px" align="absmiddle" class='imglink'> */?>
							    	</label>
								</div>	
							</td>
						</div>
						</tr>
						<?php 
							}
							else{
								continue;
							}
							$j++;
						}
						?>
					</table>

					<?php
					/*
					echo "<div class='prevnomor'>Nomor : ".$x." <div class='btnadd' onclick='window.location=\"?pg=f-addsoal&s=".$br['qid']."\"'>Ubah data</div></div>";
					echo '<li>'.$br['isi_soal'].'</li>';
					echo '<ol type="A">';
					for ($i=1; $i < 6; $i++) { 
						if ($br['pilihan'.$i]!='' || !empty($br['pilihan'.$i])) {
							if ($benar[$br['benar']]==$i) {
								echo '<li><font color="BLUE">'.$br['pilihan'.$i].'</font></li>';
							}
							else{
								echo '<li>'.$br['pilihan'.$i].'</li>';
							}
						}
						else
						{
							continue;
						}						
					}						
					echo '</ol>';
					echo "<br>"; */
					$x++;
				}
			}
			echo '</ul>';
			?>
		</div>
	</div>
<?php
	
	$sql = "select * FROM t_soal a LEFT JOIN t_kd ON id_submapel = kdid where a.id_mapel =  '$idmapel' ORDER BY a.qid ASC ";
	$rs = mysqli_query($db,$sql); 
	$total_records = mysqli_num_rows($rs);  
	$total_pages = ceil($total_records / $jumlah_per_page);

	echo "<div class='setpage'><input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Data' id='setpage'>
	</div>";
	
	echo "<a href='?pg=previewsoal&hal=1' class='lpg'>".'|<'."</a> ";  

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
		echo "<a href='?pg=previewsoal&hal=".$i."' class='$rgb'>".$i."</a> "; 
	}; 
	if ($total_pages<($hal+10)) {
		echo "";
	}
	else
	{
		echo "......";
		echo "<a href='?pg=previewsoal&hal=".$total_pages."' class='$rgb'>".$total_pages."</a> ";
	} 
	echo "<a href='?pg=previewsoal&hal=$total_pages' class='lpg'>".'>|'."</a> "; 	
	echo "<div class='spasi'></div><div class='spasi'></div>";
}
mysqli_close($db);
?>

