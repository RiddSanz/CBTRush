<script src="../js/jquery-1.6.4.min.js"></script>
<script>
$(document).ready(function(){	
	$("#btupdate").click(function()
	{
		$.ajax({
			type:'GET',
			url:'p-sysupdate.php',
			data:'action=update',
			success:function(data) {
				if(data==1){
					var counter=90;
					$("#warning").html('<br>system update dijalankan! tunggu <span id="count">'+ counter +'</span> detik');
					window.setInterval(
						function() {
							counter--;
							if (counter >= 0) {
								span = document.getElementById("count");
								span.innerHTML = counter;
							}
							if (counter === 0) {
								clearInterval(counter);
								show_popup();
							}

						}, 1000);
				}else{
					$("#warning").html(data);
				}							
			}
		});				
	});
	
	function show_popup(){
		window.parent.location.reload();
	};		
});
</script>
<script>
function updateProgress(a,b){
	var nil = parseFloat(Math.round(a * 100) / b).toFixed(2);
	document.getElementById("nilaiprogres").innerHTML = nil + "%";
}
</script>
<link rel="stylesheet" type="text/css" href="../css/iframe.css">
<?php
if(isset($_GET['sf'])) {
	$sf = $_GET['sf'];
    echo "<div id='nilaiprogres' class='progres'></div>";
    onFunc($sf);

	//echo "panggil fungsi";
}

function onFunc($sf)
{
	require_once "cek-ukuran.php";
	include "addr-server.php";
	set_time_limit(0);
	
	$path = '../update/cbtfile.zip';
	$url = $addr.'update/cbtupdate.zip';
	
	if(UR_exists($url))
   	{
   		$newfname = $path;
		$file = fopen ($url, "rb");
		$x=1;
		$filesize = '';
		if($file) {
			$newf = fopen ($newfname, "wb");
			if($newf)
			{
				while(!feof($file)) {
					$wr = fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );/*data 1 MB*/
					/*echo "Data $x , check $wr.<br>";*/
					$filesize = $filesize + $wr;
					//echo $filesize;
					//echo " ";
					//echo '<meter id="pmeter" class="ph_meter" value="'.$filesize.'" min="0" max="'.$size_file.'">2 out of 10</meter>';
					echo '<script>updateProgress("' . $filesize .'","'.$sf.'");</script>';
					flush();
					$x++;
				}			
			}		
			echo '<div class="progres"><img src="../images/success.png" height="10px" class="imglink"/></div>';	
			echo "<br><span class='updateheader'>Total data yang diupdate : ".filesize_formatted($path)." </span></br></br>";
			echo("<input type='button' value='Proses update' id='btupdate'>");
			echo ('<div id="warning"></div>');
		}
		else
		{
			echo "<br><font style='color:red;'>data update tidak ditemukan!</font><br>";
		}
		echo '<script>updateProgress("' . $sf .'","'.$sf.'");</script>';
		if($file) {
			fclose($file);
		}
		if($newf) {
			fclose($newf);
		}
   	}
	else
	{
		echo "File update tidak tersedia!";
	}
   		
		
}
function UR_exists($url){
   $headers=get_headers($url);
   return stripos($headers[0],"200 OK")?true:false;
}
?>