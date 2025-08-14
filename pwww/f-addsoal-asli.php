<?php 
include "lib/configuration.php";
$idmapel = $_SESSION['idmapel'];
$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];

if (isset($_GET['s'])) {
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
}
else
{
	$qid = '';
	$idunit = '';
	$isisoal='';
	$op1 = '';
	$op2 = '';
	$op3 = '';
	$op4 = '';
	$op5 = '';
	$correct = '';
}

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
			$dataimg .= "{title: '".$imgdata[$i]."', value: '".$dt."'}";
			if ($i!=($jdata-1)) {
				$dataimg .= ",";
			}
		}
  	
	}
?>
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
selector: "textarea",
plugins: [
"eqneditor advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
"searchreplace wordcount visualblocks visualchars code fullscreen image insertdatetime media nonbreaking",
"table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
],

toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor code | image insertdatetime preview media | forecolor backcolor",
toolbar3: "table | hr removeformat | eqneditor subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

menubar: false,
toolbar_items_size: 'small',
style_formats: [
{title: 'Bold text', inline: 'b'},
{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
{title: 'Example 1', inline: 'span', classes: 'example1'},
{title: 'Example 2', inline: 'span', classes: 'example2'},
{title: 'Table styles'},
{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
],
templates: [
{title: 'Test template 1', content: 'Test 1'},
{title: 'Test template 2', content: 'Test 2'}
],
image_list: [
    <?php echo $dataimg;?>
],
 media_scripts: [
   {filter: 'http://media1.tinymce.com'},
   {filter: 'http://media2.tinymce.com', width: 100, height: 200}
 ],
external_media_list_url : "pwww/myexternallist.js"
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

	$("#btnsave").click(function()
	{
		window.onbeforeunload = null;
		var mid=$("#mid").val();		
		var content = tinyMCE.get('content').getContent({format : 'html'});
		var smid=$("#smid").val();
		var a=tinyMCE.get('a').getContent({format : 'html'});
		var b=tinyMCE.get('b').getContent({format : 'html'});
		var c=tinyMCE.get('c').getContent({format : 'html'});
		var d=tinyMCE.get('d').getContent({format : 'html'});
		var e=tinyMCE.get('e').getContent({format : 'html'});
		var benar=$("input:radio[name=benar]:checked").val();
		var fedit=$("#fedit").val();				
		var dataString = 'mid='+mid+'&content='+encodeURIComponent(content)+'&fedit='+fedit+'&smid='+smid+'&a='+encodeURIComponent(a)+'&b='+encodeURIComponent(b)+'&c='+encodeURIComponent(c)+'&d='+encodeURIComponent(d)+'&e='+encodeURIComponent(e)+'&benar='+benar;
		if($.trim(content).length>0 && $.trim(a).length>0 && $.trim(b).length>0)
		{
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
					
				}
			});

		}
		return false;
	});

});
</script>
<div class="cpanel">
	<div class="nm-list-section">
		<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a> | 
		<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a> | 
		<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$nm_mapel;?></a> | 
		<a href='#' onclick="window.location='?pg=q'">Pertanyaan</a> |
		Tambah pertanyaan
	</div>
	<div class='spasi'></div>
	<form method="post">
		<input type="hidden" name="mid" id="mid" value="<?=$idmapel;?>">
		<input type="hidden" name="fedit" id="fedit" value="<?=$qid;?>">
		<h2>UNIT / KD</h2>
		<select name="smid" id="smid" class="input2">
			<option value="">----Pilih Unit-----</option>
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
		</select><br>		
		<h2>Pertanyaan</h2>
		<textarea name="content" style="width:100%" id="content" rows='15'>
			<?=$isisoal;?>
		</textarea>
		<br>
		<div class="example">
		<h2>Pilihan Jawaban A <input type="radio" name="benar" value="a" <?php if($correct=='a') echo "checked";?>><label for="a">&nbsp;</label></h2>
		<textarea name="a" id="a" cols='40' rows='5'><?=$op1;?></textarea>
		<br>
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
		</div>
		<input type="submit" value="Simpan Pertanyaan" name="save" id="btnsave"> 
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
}
?>