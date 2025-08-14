<?php
include "lib/configuration.php";
$idmapel = $_SESSION['idmapel'];
$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
$ket_mapel = $bm['ket_mapel'];
$kelas = $bm['kelas'];
if (isset($_GET['s'])) {
	$s_ada = $_GET['s'];
	$qid=mysqli_real_escape_string($db,$_GET['s']);
	$sq = "select * from t_soal where qid='$qid' LIMIT 1";
	$rq = mysqli_query($db,$sq);
	$bq = mysqli_fetch_array($rq,MYSQLI_ASSOC);
	$idunit = $bq['id_submapel'];
	$isisoal = $bq['isi_soal'];
	$op1 = $bq['pilihan1'];
	$op2 = $bq['pilihan2'];
	$op3 = $bq['pilihan3'];
	$op4 = $bq['pilihan4'];
	$op5 = $bq['pilihan5'];
	$correct = $bq['benar'];
	##$point_soal = $bq['point_soal'];
	$point_soal = '1';
	$tingkat_kesulitan = $bq['tingkat_kesulitan'];
	if ($point_soal=='') {
		$point_soal = '1';
	}
	if ($tingkat_kesulitan) {
		$tingkat_kesulitan = '1';
	}
	if (isset($_GET['op'])) {
		$opsi_esay = $_GET['op'];
	}
	else
	{
		$opsi_esay = $bq['opsi_esay'];
	}

}
else
{
	$s_ada = '0';
	$qid = '';
	$idunit = '';
	$isisoal='';
	$op1 = '';
	$op2 = '';
	$op3 = '';
	$op4 = '';
	$op5 = '';
	$correct = '';
	$point_soal = '1';
	$tingkat_kesulitan = '1';
	if (isset($_GET['op'])) {
		$opsi_esay = $_GET['op'];
	}
	else
	{
		$opsi_esay = '0';
	}

}
//echo $s_ada;
$list_kesulitan = array('1' => 'Mudah','2' => 'Sedang','3' => 'Sulit');

if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	$dataimg="";
	$slist = "select * from t_image where id_mapel='$idmapel' order by nama_image asc";
	$rlist = mysqli_query($db,$slist);
	$jdata = mysqli_num_rows($rlist);
	$x = 0;
	while($blist = mysqli_fetch_array($rlist,MYSQLI_ASSOC)){
		$imgdata[$x] = $blist['nama_image'];
		$x++;
	}
	if ($jdata==0) {
		$dataimg="";
	}
	else
	{
		for ($i=0; $i < $jdata; $i++) {
			$dt = "mapel/".$nm_mapel."/".$imgdata[$i];
			$dataimg .= "['".$imgdata[$i]."', '".$dt."']";
			if ($i!=($jdata-1)) {
				$dataimg .= ",";
			}
		}

	}
?>
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "css/word.css",
		extended_valid_elements: "audio[id|class|src|type|controls]",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "pwww/list_img.php",
		media_external_list_url : "pwww/list_video.php",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}

	});
</script>

<script>
$(document).ready(function(){
	window.onbeforeunload = null;
	$('#lspic').hide();
	tinymce.triggerSave();

	$("#btlispic").click(function(){

    	$("#lspic").toggle();
	});

	$(".delete_class").click(function(){
	   var sr = $(this).attr('id');
	   tinymce.execCommand('mceInsertContent',false,'<img src="'+sr+'"/>');
	 });

	$("#lst_av").click(function()
		{	$("#contactdiv").css("display", "block");
	});

	$("#close_av").click(function() {
		$("#contactdiv").css("display", "none");
	});

	$(".btnsave").click(function()
	{
		window.onbeforeunload = null;
		var mid=$("#mid").val();
		var content = tinyMCE.get('content').getContent({format : 'html'});
		var smid=$("#smid").val();
		var tingkat_kesulitan = $("#tingkat_kesulitan").val();
		var point_soal = $("#point_soal").val();
		var opsi_esay = $("input:radio[name=opsi_esay]:checked").val();

		var a=tinyMCE.get('a').getContent({format : 'html'});
		if (opsi_esay=='0') {
			var b=tinyMCE.get('b').getContent({format : 'html'});
			var c=tinyMCE.get('c').getContent({format : 'html'});
			var d=tinyMCE.get('d').getContent({format : 'html'});
			var e=tinyMCE.get('e').getContent({format : 'html'});
		}
		else
		{
			var b="";
			var c="";
			var d="";
			var e="";
		}

		var benar=$("input:radio[name=benar]:checked").val();
		var fedit=$("#fedit").val();
		var dataString = 'mid='+mid+'&content='+encodeURIComponent(content)+'&fedit='+fedit+'&smid='+smid+'&a='+encodeURIComponent(a)+'&b='+encodeURIComponent(b)+'&c='+encodeURIComponent(c)+'&d='+encodeURIComponent(d)+'&e='+encodeURIComponent(e)+'&benar='+benar+'&tingkat_kesulitan='+tingkat_kesulitan+'&point_soal='+point_soal+'&opsi_esay='+opsi_esay;
		if($.trim(content).length>0 && $.trim(a).length>0)
		{
			//alert(fedit);
			$.ajax({
				type: "POST",
				url: "pwww/p-addsoal.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#btnsave").val('Waiting to save...');},
				success: function(data){
					if(data=="1")
					{
						tinyMCE.activeEditor.setContent('');
						window.location.href = "index.php?pg=q";

					}
					else if(data=="2")
					{
						$("#btnsave").val('Simpan Pertanyaan');
						$("#error").html("<span style='color:#cc0000'>Proses penyimpanan gagal!!!.</span> ");
						$("#error").hide().fadeIn(1500).delay(6000);

					}
					else {
						$("#error").html("<span style='color:#cc0000'>Proses penyimpanan gagal!!!.</span> ");

					}
					/*alert(data);*/

				}
			});

		}
		return false;
	});
});

function cekOpsi(s){
	var ele = document.getElementsByName('opsi_esay');
	var i = ele.length;
	for (var j = 0; j < i; j++) {
	    if (ele[j].checked) {
	        /*alert('radio '+j+' checked');*/
	        if (s!='' || s!='0') {
	        	window.location.href = "index.php?pg=f-addsoal&s="+s+"&op="+j;
	        }
	        else{
	        	window.location.href = "index.php?pg=f-addsoal&op="+j;
	        }

	    }
	}
}
</script>
<div class="cpanel">
	<?PHP /*
	<div class="nm-list-section">
		<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
		<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
		<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a>
		<a href='#' onclick="window.location='?pg=q'">Pertanyaan</a> |
		Tambah pertanyaan
	</div>*/?>
	<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
		<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
		<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
		<li><a href='#' onclick="window.location='?pg=q'"><?=$site3;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site4;?></a></li>
	</ul>
	<div class='spasi'></div>
	<div class='btnback2 letakKanan' onclick="window.location='?pg=q'">
		<img src="images/back.png" width="10px" align='absmiddle' class="imglink"> Kembali
	</div>
	<div class='spasi'></div>
	<form method="post">
		<input type="submit" value="Simpan Pertanyaan" name="save" class="btnsave">
		<input type="hidden" name="mid" id="mid" value="<?=$idmapel;?>">
		<input type="hidden" name="fedit" id="fedit" value="<?=$qid;?>">
		<input type="hidden" name="point_soal" id="point_soal" value="<?=$point_soal;?>" class="input2 wd1" readonly>
		<table class="form-soal">
			<tr>
				<td width="70px">
					Unit KD
				</td>
				<td width="180px">
					<select name="smid" id="smid" class="input2">
						<option value="">----Pilih Unit KD-----</option>
						<?php
							$sunit = "select * from t_kd where id_mapel='$idmapel'";
							$runit = mysqli_query($db,$sunit);
							while($bunit = mysqli_fetch_array($runit,MYSQLI_ASSOC))
							{
							?>
								<option value="<?=$bunit['kdid'];?>" <?php if($bunit['kdid']==$idunit) echo 'selected';?>><?=$bunit['nama_kd'];?></option>
							<?php
							}
						?>
					</select>
				</td>
				<td width="50px">
					Tingkat
				</td>
				<td width="90px">
					<select name="tingkat_kesulitan" id="tingkat_kesulitan" class="input2">
						<?php
							for ($i=1; $i <= count($list_kesulitan); $i++) {
								?>
								<option value="<?=$i;?>" <?php if($list_kesulitan[$i]==$tingkat_kesulitan) echo 'selected';?>><?=$list_kesulitan[$i];?></option>
							<?php
							}
						?>
					</select>
				</td>
				<td>
					<input type="radio" onclick="cekOpsi(<?php echo $s_ada;?>)" name="opsi_esay" value="0" <?php if($opsi_esay=='0') echo "checked";?>><label for="0">Soal Pilihan</label>
					<input type="radio" onclick="cekOpsi(<?php echo $s_ada;?>)" name="opsi_esay" value="1" <?php if($opsi_esay=='1') echo "checked";?>><label for="1">Soal Uraian</label>
				</td>
			</tr>
		</table>
		<h1>Pertanyaan</h1>
		<textarea name="content" style="width:100%" id="content" rows='15'>
			<?=$isisoal;?>
		</textarea>
		<br>
		<div class="example">
		<h2>Pilihan Jawaban A <input type="radio" name="benar" value="a" <?php if($correct=='a') echo "checked";?>><label for="a">&nbsp;</label></h2>
		<textarea name="a" id="a" cols='40' rows='5'><?=$op1;?></textarea>
		<br>
		<?php
		if ($opsi_esay=='0') {
		?>
		<h2>Pilihan Jawaban B <input type="radio" name="benar" value="b" <?php if($correct=='b') echo "checked";?>><label for="b">&nbsp;</label></h2>
		<textarea name="b" id="b" cols='40' rows='5'><?=$op2;?></textarea>
		<br>
		<h2>Pilihan Jawaban C <input type="radio" name="benar" value="c" <?php if($correct=='c') echo "checked";?>><label for="c">&nbsp;</label></h2>
		<textarea name="c" id="c" cols='40' rows='5'><?=$op3;?></textarea>
		<br>
		<h2>Pilihan Jawaban D <input type="radio" name="benar" value="d" <?php if($correct=='d') echo "checked";?>><label for="d">&nbsp;</label></h2>
		<textarea name="d" id="d" cols='40' rows='5'><?=$op4;?></textarea>
		<br>
		<h2>Pilihan Jawaban E <input type="radio" name="benar" value="e" <?php if($correct=='e') echo "checked";?>><label for="e">&nbsp;</label></h2>
		<textarea name="e" id="e" cols='40' rows='5'><?=$op5;?></textarea>
		<br>
		<?php
		}
		?>
		</div>
		<input type="submit" value="Simpan Pertanyaan" name="save" class="btnsave">
		<input type="button" value="Batal" class="tombol" onclick="window.location='?pg=q'">
	</form>
</div>
<div id="contactdiv">
	<div class="fhead">
		Daftar Audio Video Soal
		<div class="tutupWindow">
			<img src="images/cancel.png" height="25px" align="absmiddle" class="imgUser2" id="close_av">
		</div>
	</div>
	<div class="scrollContanctdiv">

	</div>
</div>
<?php
require_once "pwww/p_enc.php";if(enc($_SESSION['trueValKey'])!=($_SESSION['sid_user'].$_SESSION['namaSEKOLAH'])) {include "pwww/logout.php";}
}
mysqli_close($db);
?>
