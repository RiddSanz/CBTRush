<?php 
include "lib/configuration.php";
//session_start();
?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	$idmapel = $_SESSION['idmapel'];
	$smapel = "select * from t_mapel where mid='$idmapel' limit 1";
	$rmapel = mysqli_query($db,$smapel);
	$bmapel = mysqli_fetch_array($rmapel,MYSQLI_ASSOC);
	$nm_mapel = $bmapel['nama_mapel'];
	$ket_mapel = $bmapel['ket_mapel'];
	$kelas = $bmapel['kelas'];
	
?>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//alert('Testing');
	$("a").click(function(){
		event.preventDefault();
		//alert('Testing');
		var folder = '<?php echo $nm_mapel;?>';
		var del_id = $(this).attr('id').replace('video','');
		//alert(folder);
		var res = confirm('Anda yakin ingin menghapus file "'+ del_id +'" ?');
	    if(!res){ 
	       return false; 
	    }else{ 
			$.ajax({
		      type:'GET',
		      url:'pwww/p-delav.php',
		      data:'ajax=1&id='+del_id+"&folder="+folder,
		      success:function(data) {
		        if(data==1) {   // DO SOMETHING
		        	//$("body").load("index.php?pg=q").hide().fadeIn(1500).delay(6000);
		        	window.location.href="index.php?pg=av-up";
		        } else { 
		            alert(data);
		    	}
		      }
		   });
		}
	});
});
</script>
<?PHP /*
<div class="nm-list-section">
	<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
	<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
	<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a> | 
	Audio Video
</div>*/?>
<ul class="topnav" id="myTopnav">
	<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
	<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
</ul>
<div class="cpanel">
	<div class='spasi'></div>
	<div class="btnadd lebartombol100" onclick="window.location='?pg=f-addav'">
		Tambah File
	</div>
	<div class="btnback letakKanan lebartombol100" onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'">
		Kembali
	</div>
	<div class="c-Menu2">	
		<h2>FILE AUDIO</h2>
	<?php 
	// scaning audio
	require_once "pwww/cek-ukuran.php";
	$dataimg="";

	// image extensions
	$extensions = array('mp3', 'ogg', 'wav');
	$result = array();
	$directory = new DirectoryIterator('mapel/'.$nm_mapel.'/');
	foreach ($directory as $fileinfo) {
	    if ($fileinfo->isFile()) {
	        $extension = strtolower(pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION));
	        if (in_array($extension, $extensions)) {
	            $result[] = $fileinfo->getFilename();
	        }
	    }
	}
		
	if (count($result)==0) {
		$dataimg="";
	}
	else
	{
		for ($i=0; $i < count($result); $i++) {
			$dt = "mapel/".$nm_mapel."/".$result[$i];
			$jmldot = substr_count($dt, '.');
			$pecah = explode(".", $dt);

			if($jmldot==1)
			{
				$ekstensi = $pecah[1];
			}
			else
			{
				$ekstensi = $pecah[$jmldot];
			}
			//echo 'adalah '.$ekstensi;
			echo '<div class="av-frame" title="'.$result[$i].'">';
			echo '<span><a class="del_av" href="#" id="video'.$result[$i].'">x</a></span>';
			echo '<audio controls style="width: 200px;">';
			echo '<source src="'.$dt.'" type="audio/'.$ekstensi.'">';
			echo 'Your browser does not support the audio element.';
			echo '</audio>';	
			echo '<div class="spasi"></div><div class="font10 fontMargin0">'.$result[$i].'</div>
				<div class="font8 fontMargin0">'.filesize_formatted($dt).'</div>';
			echo '</div>';
		}
	  	
	}
	?>
	</div>
	<div class='spasiBawah'></div>
	<div class="c-Menu2">
		<h2>FILE VIDEO</h2>
	<?php	
	//scaning video
	$dataimg="";
	// image extensions
	$extensions = array('mp4', 'webm');
	$result = array();
	$directory = new DirectoryIterator('mapel/'.$nm_mapel.'/');
	foreach ($directory as $fileinfo) {
	    if ($fileinfo->isFile()) {
	        $extension = strtolower(pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION));
	        if (in_array($extension, $extensions)) {
	            $result[] = $fileinfo->getFilename();
	        }
	    }
	}
		
	if (count($result)==0) {
		$dataimg="";
	}
	else
	{
		for ($i=0; $i < count($result); $i++) {
			$dt = "mapel/".$nm_mapel."/".$result[$i];
			//$dataimg .= '["'.$result[$i].'", "'.$dt.'"]';
			//if ($i!=(count($result)-1)) {
			//	$dataimg .= ",";
			//}			

			$jmldot = substr_count($dt, '.');
			$pecah = explode(".", $dt);

			if($jmldot==1)
			{
				$ekstensi = $pecah[1];
			}
			else
			{
				$ekstensi = $pecah[$jmldot];
			}
			//echo 'adalah '.$ekstensi;
			echo '<div class="av-frame" title="'.$result[$i].'">';
			echo '<video width="200" height="150" controls>';
			echo '<source src="'.$dt.'" type="video/'.$ekstensi.'">';
			echo '</video>';
			echo '<span style="cursor:pointer;margin-top:-5px;width:10px;float:right;widht:20px;height:20px;background-color:red;">
			<a class="del_img" href="#" id="video'.$result[$i].'">x</a></span>';
			echo '</div>';
		}
	  	
	}	
	?>			
	</div>
</div>
<div class="cpanel">
	<div class="spasi"></div>
</div>
	

<?php 
}mysqli_close($db);
?>