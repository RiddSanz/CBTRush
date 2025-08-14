<?php
include "lib/configuration.php";
$id=mysqli_real_escape_string($db,$_GET['s']);
$sql = "select * from t_mapel where mid='$id' limit 1";
$rs = mysqli_query($db,$sql);
$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);
$_SESSION['idmapel']=$br['mid'];
$idmapel = $id;
$nmp = $br['nama_mapel'];
$ket_mapel = $br['ket_mapel'];
$kelas = $br['kelas'];
$filename = trim(substr($ket_mapel, 0,50 )).trim($kelas);
?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if((isset($_SESSION['sid_user']) && $_SESSION['sid_user']!="") || $_SESSION['tingkat_user']=='0')
	{
?>
<style type="text/css">
.meter-wrap{
    position: relative;
}

.meter-wrap, .meter-value, .meter-text {
    /* The width and height of your image */
    width: 300px; height: 30px;
}

.meter-wrap, .meter-value {
    background: #00D4B8 url(images/bg_meter.png) top left no-repeat;
    background-size: 0px 30px;
}

.meter-text {
    position: absolute;
    top:0; left:0;

    padding-top: 5px;

    color: #fff;
    text-align: center;
    width: 100%;
}
.meter-wrap:hover {
	background-color: #0077E3;
}
.pdMeter {
	padding-left: 15px;
}
#akhir {
	padding-left: 15px;
}
#akhir a {
	color: #fff;
	margin-top: 15px;
	padding: 5px;
	background: #0077E3;
}
#akhir a:hover {
	background: #00D4B8;
}
</style>
<script src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type='text/javascript'>
$(document).ready(function(){
    var ex1running = false;
    var ex2running = false;

    $('#meter-ex1').click(function(){
      if(!ex1running){
        ex1running = true;
        var $this = $(this);
        var count = 0;
        var inter = null;
        var dataString = "ajax=1";
        $.ajax({
				type: "POST",
				url: "mapel/p-backupS.php",
				data: dataString,
				cache: false,
				success: function(data){
					if(data=="1")
					{

					}
					//alert(data);
				}
			});
        function run(){
			count++;
			$this.find('.meter-value').css('width', count+"%");
			$this.find('.meter-text').text(count+"%");
			if(count == 100){
				clearInterval(inter);
				ex1running = false;
				$("#akhir").html("<br>Pembuatan file backup sukses!<br><br><a href='<?php echo $filename;?>.zip' id='btndownload'>Download Backup Soal disini!</a> ");
			}
		}
		inter = setInterval(run, 50);
      }

    });

    $('#meter-ex2').click(function(){
      if(!ex2running){
        ex2running = true;
        var $this = $(this);
        var gb = 'A4F3';
        var r = 0;
        var inter = null;
        function run(){
            r++;
            var rhex = r.toString(16);
            if(rhex.length == 1) rhex = "0"+rhex;
            var color = "#"+rhex+gb;
            $this.find('.meter-value').css('background-color', color);
            $this.find('.meter-text').text(color);
            if(r == 255){
                clearInterval(inter);
                ex2running = false;
                $this.find('.meter-text').text('click me!');
            }
        }
        inter = setInterval(run, 10);
      }
    });
    $("#akhir").click(function(){

    	var dtmp = '<?php echo $nmp;?>';
    	var dataString = "ajax=1&mp="+dtmp;
        $.ajax({
				type: "POST",
				url: "pwww/p-delBackup.php",
				data: dataString,
				cache: false,
				success: function(data){
					if(data=="1")
					{
						/*window.location.reload();*/
					}
				}
			});
    });
    $('#uploadfile').live('change', function()
	{
		var filename = $("#uploadfile").val();
        var extension = filename.replace(/^.*\./, '');

        if (extension == filename) {
            extension = '';
        } else {
            extension = extension.toLowerCase();
        }

				switch (extension) {
            case 'dat':
                $("#preview").html('');
								$("#nameupload").val(this.value);
								$("#preview").html('<img src="images/spinner.gif" alt="Uploading...." width="25px"/>');
								$("#uploadform").ajaxForm(
								{
									success: function (data) {
										var dataLenght = data.split(",");
										for(var i=0;i<=dataLenght[0];i++){
											updateProgress(i,dataLenght[1]);
										}
										//alert(dataLenght[0]);
										//alert(data);
										console.log(data);
										//$("#preview").html(data);
									}
								}).submit();
								break;
						case 'file':
								$("#preview").html('');
								$("#nameupload").val(this.value);
								$("#preview").html('<img src="images/spinner.gif" alt="Uploading...." width="25px"/>');
								$("#uploadform").ajaxForm(
								{
									success: function (data) {
										var dataLenght = data.split(",");
										for(var i=0;i<=dataLenght[0];i++){
											updateProgress(i,dataLenght[1]);
										}
										console.log(data);
										//alert(dataLenght[0]);
										//alert(data);
										//$("#preview").html(data);
									}
								}).submit();
								break;
						case 'bak':
										$("#preview").html('');
										$("#nameupload").val(this.value);
										$("#preview").html('<img src="images/spinner.gif" alt="Uploading...." width="25px"/>');
										$("#uploadform").ajaxForm(
										{
											success: function (data) {
												var dataLenght = data.split(",");
												for(var i=0;i<=dataLenght[0];i++){
													updateProgress(i,dataLenght[1]);
												}
												console.log(data);
												//alert(dataLenght[0]);
												//alert(data);
												//$("#preview").html(data);
											}
										}).submit();
						break;
						default:
							console.log("ok");
        }

	});

	$('.tabs .tab-links a').click(function(e)  {
        var currentAttrValue = $(this).attr('href');
 		//alert(currentAttrValue);
        // Show/Hide Tabs
        $('.tabs ' + currentAttrValue).show().siblings().hide();

        // Change/remove current tab to active
        $(this).parent('li').addClass('active').siblings().removeClass('active');

        if (currentAttrValue=="#tab2") {
        	$("#tab1").hide();
        	$("#tab2").show();
        }
        else
        {
        	$("#tab2").hide();
        	$("#tab1").show();
        }

        e.preventDefault();
    });
});
</script>
<script>
function updateProgress(a,b){
	var nil = parseFloat(Math.round(a * 100) / b).toFixed(2);
	document.getElementById("preview").innerHTML = nil + "% completed";
}
</script>
<?PHP /*
	<div class="nm-list-section">
		<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
		<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
		<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$id;?>'"><?=$ket_mapel;?> <?=$kelas;?></a>
		| Backup dan Restore
	</div>*/?>
	<ul class="topnav" id="myTopnav">
			<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
			<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
			<li id='ratakanan'><a href='#' class='activek'><?=$site3;?></a></li>
		</ul>
	<div class="tabs">
	    <ul class="tab-links">
	        <li class="active"><a href="#tab1">Backup Soal</a></li>
	        <li><a href="#tab2">Restore Soal</a></li>
	    </ul>
	</div>
	<div id="tab1" class="tab active">
		<div class="spasi"></div>
		<div class="tab-content">
	    	<div class="pdMeter">
				<div class="meter-wrap">
			    	<div class='meter-wrap' id='meter-ex1' style='cursor: pointer'>
			    		<div class='meter-value' style='background-color: #4DA4F3; width: 0%;'>
			        		<div class='meter-text'>
			            		Klik untuk membuat file backup!
			        		</div>
			    		</div>
		    		</div>
		    	</div>
		    </div>

	    <?php
	    	if(file_exists("soal/".$nmp.".txt"))
	    	{
	    		echo "<div id='akhir'><br>Pembuatan file backup sukses!<br><br><a href='soal/$nmp.zip' id='btndownload'>Download disini!</a> </div>";
	    	}
	    	else{
	    		echo "<div id='akhir'></div>";
	    	}
	    ?>
			<div class="cpanel">
				<div class="spasi"></div>
			</div>
		</div>
    </div>
    <div id="tab2" class="tab">
    	<div class="spasi"></div>
		<div class="tab-content">
			<h3>Pilih File DAT hasil backup</h3>
			<?php
			$urlrestore = "mapel/p-restoresoal.php";
			if(file_exists($urlrestore))
			{
				$linkfile = "mapel/p-restoresoal.php";
			}
			else{
				$linkfile = "pwww/p-restoresoal.php";
				//echo $linkfile;
			}
			?>
			<form class='spUpload' id="uploadform" action="<?=$linkfile;?>" method="post" enctype="multipart/form-data">
				<input id="nameupload" name="nameupload" placeholder="Pilih DAT File" class="input5" readonly='yes'/>
				<div class="fileUpload btnFile">
					<span>Import</span>
					<input type="file" name="file" id="uploadfile"  class="upload" />
				</div>

			</form>
			<div class="cpanel">
				<div class="spasi"></div>
			</div>
			<div class='spUpload' id='preview'>
		</div>
    </div>


<?php
	}
	else
	{
		echo "<div class='nm-list-section'>MENU TEST ".$br['nama_mapel']."</div>";
		echo "<div class=cpanel><h3>MAAF ANDA TIDAK TERDAFTAR DI SALAH SATU SEKOLAH , HUBUNGI ADMIN</h3>";
	}require_once "pwww/p_enc.php";if(enc($_SESSION['trueValKey'])!=($_SESSION['sid_user'].$_SESSION['namaSEKOLAH'])) {include "pwww/logout.php";}
}
mysqli_close($db);
?>
