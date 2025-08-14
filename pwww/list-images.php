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

	$_SESSION['nama_mapel'] = $nm_mapel;
?>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(document).ajaxStart(function(){
        $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
    });

	$("a").click(function(){
		event.preventDefault();
		var del_id = $(this).attr('id').replace('img','');
		//alert(del_id);
		var res = confirm('Anda yakin ingin menghapus gambar "'+ del_id +'" ?');
	    if(!res){ 
	       return false; 
	    }else{ 
	       $.ajax({
		      type:'GET',
		      url:'pwww/p-delimage.php',
		      data:'ajax=1&id='+del_id,
		      success:function(data) {
		        if(data==1) {   // DO SOMETHING
		        	/*$("body").load("index.php?pg=img-up").hide().fadeIn(1500).delay(6000);
		        	//window.location.href="index.php?pg=img-up";
		        	//location.reload();*/

		        	$('body').fadeOut(400, function(){					 	
					 		document.location.href = "index.php?pg=img-up";		 	
			        });

		        } else {
		        	alert(data);
		    	}
		      }
		   });
	    }
			
	});

	$('.lightbox_trigger').click(function(e) {
		e.preventDefault();
		// Code that makes the lightbox appear
		//var image_href = $(this).attr("href");
		var image_href = $(this).attr('id').replace('imgP','');
		if ($('#lightbox').length > 0) { // #lightbox exists
			
			//insert img tag with clicked link's href as src value
			$('#content').html('<img src="' + image_href + '" />');
		   	
			//show lightbox window - you can use a transition here if you want, i.e. .show('fast')
			$('div.popup_bg').show();
		}
		else { //#lightbox does not exist 
	
			//create HTML markup for lightbox window
			var lightbox = 
			'<div class="popup_bg"><div class="bgpop">&nbsp;</div><div id="lightbox">' +
				'<div class="popup_close">Close</div>' +
				'<div id="content">' + //insert clicked link's href into img src
					'<img src="' + image_href +'" />' +
				'</div>' +	
			'</div></div>';
				
			//insert lightbox HTML into page
			$('body').append(lightbox);
			$('div.popup_close').off('click');
			$('div.popup_close').on('click',function(eve){
		      eve.preventDefault();
		      $(this).parents('div.popup_bg').hide();
		    });
		}
	});
	
});
</script>
<style type="text/css">
.popup_bg{
	height: 100%;
	width: 100%;
	overflow:auto;
}
#lightbox {
 /* keeps the lightbox window in the current viewport */
    position:absolute;
    display:hidden;
    top:50%;
    left:50%;
    width:auto;
    height:auto;
    margin-top:-263px;
    margin-left:-200px;
    background-color:#fff;
    z-index:2;
    padding:5px;
}
.bgpop
{
	position : fixed;
	top:0; 
    left:0; 
	width:100%; 
    height:100%;
	background-color:#737373; 
	opacity: 0.7;
}
#lightbox img {
    box-shadow:0 0 25px #111;
    -webkit-box-shadow:0 0 25px #111;
    -moz-box-shadow:0 0 25px #111;
    max-width:940px;
}
.lightbox_trigger{
	cursor:pointer;
}
.lightbox_trigger:hover{
	border: 2px blue solid;
}
.popup_close {
    display: block;
    float:right;
    cursor: pointer;
    z-index:3
}
</style>
<?PHP /*
<div class="nm-list-section">
	<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
	<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
	<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a> | 
	Gambar
</div>*/?>
<ul class="topnav" id="myTopnav">
	<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
	<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
</ul>
<div class="cpanel">
	<div class='spasi'></div>
	<div class="btnadd" onclick="window.location='?pg=f-addpic'">
		<img src="images/add.png" width="20px" align='absmiddle' class="imglink"> Tambah Gambar
	</div>
	<div class="btnback3 letakKanan u12" onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'">
		<img src="images/kembali.png" height="20px" align='absmiddle' class="imglink"> Kembali
	</div>
	<div class='spasi'></div>
	<div class='spasi'></div>
	<div class='spasi'></div>
	<div class="c-Menu">	
	<?php 
	/*
	$sql = "select * from t_image where id_mapel='$idmapel' order by nama_image asc ,tgl asc";
	$rs = mysqli_query($db,$sql);
	//$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
	while ( $br = mysqli_fetch_array($rs,MYSQLI_ASSOC)) {	

		//$ind = "pic".$idmapel."-";
		//$nm = explode($ind,$br['nama_image']);
		//if (strlen($nm[1])<20) {
		//	$nmcut = $nm[1];
		//}
		//else
		//{
		//	$nmcut = substr($nm[1], 0, 20)."...";	
		//}
		if (strlen($br['nama_image'])<20) {
			$nmcut = $br['nama_image'];
		}
		else
		{
			$nmcut = substr($br['nama_image'], 0, 20)."...";	
		}
		$ukuran = round(($br['besar']/1024),2);
		
	?>	
	<div class="img-frame" title="<?=$br['nama_image'];?>">
		<img src="mapel/<?=$nm_mapel;?>/<?=$br['nama_image'];?>" align="middle" class="imglink"/>		
		<span class="fontKecil"><?=$nmcut;?></span><br><span class="fontMenu"><?=$ukuran;?> KB</span>
		<span style="cursor:pointer;margin-top:-5px;width:10px;float:right;widht:20px;height:20px;background-color:red;">
			<a class='del_img' href='#' id="img<?=$br['id'];?>">x</a>
		</span>		
	</div>	
	<?php 
	}*/
	?>
	<?php 
	require_once "pwww/cek-ukuran.php";
	$dataimg="";

	/*image extensions*/
	$extensions = array('png', 'gif', 'jpg');
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
	/*print_r($result);*/

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
			?>
			<div class="img-frame" title="<?=$result[$i];?>">
				<span>
					<a class='del_img' href='#' id="img<?=$result[$i];?>">x</a>
				</span>	
				<img src="<?=$dt;?>" align="middle" class="lightbox_trigger" data-toggle="modal" data-id="<?=$result[$i];?>" id="imgP<?=$dt;?>"/>
				<div class="spasi"></div>		
				<div class="font10 fontMargin0"><?=$result[$i];?></div>
				<div class="font8 fontMargin0"><?=filesize_formatted($dt);?></div>					
			</div>				
			<?php
		}
	  	
	}
	?>
	</div>
	<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;">
		<img src='images/loading_large.gif' width="64" height="64" /><br>Loading..
	</div>
</div>
<div class="cpanel">
	<div class="spasi"></div>
</div>

<?php 
}mysqli_close($db);
?>