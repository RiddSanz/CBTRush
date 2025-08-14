<?php
include "../lib/configuration.php";
session_start();
$oleh = $_SESSION['userid'];

$timestamp = time();
$tgl = date("Y-m-d H:i:s",$timestamp);
$idmapel = $_SESSION['idmapel'];
$pilih = array(0=>'a',1=>'b',2=>'c',3=>'d',4=>'e');

if(isset($_POST['bSave']) && isset($_SESSION['datasoal'])) {
	
	$ldata = count($_SESSION['datasoal']);
			
		for($i=0;$i<$ldata;$i++)
		{
			$msg = $_SESSION['datasoal'][$i]['question'];
			for ($j=0; $j < count($_SESSION['datasoal'][$i]['options']); $j++) 
			{ 
				if ($_SESSION['datasoal'][$i]['options'][$j]['right_answer']==true) 
				{
					
					$benar=mysqli_real_escape_string($db,$pilih[$j]);
				} 
				$pilihan[$j] = $_SESSION['datasoal'][$i]['options'][$j]['text'];

			}
						
			$smid=mysqli_real_escape_string($db,$_POST['smid']);
			for ($k=0; $k < 5; $k++) { 
				if (isset($pilihan[$k])) {
					$a[$k]=mysqli_real_escape_string($db,$pilihan[$k]);
				}
				else
				{
					$a[$k] = "";
				}
			}
			
			$sql = "insert into t_soal values('','$msg','$a[0]','$a[1]','$a[2]','$a[3]','$a[4]',
				'$benar','$smid','$idmapel','$tgl','$oleh','0','1','1')";				
			$result=mysqli_query($db,$sql);

			if($result)
			{
				echo "<div class='prevheader'>Soal ".($i+1).". berhasil di masukkan ke database!</div><br>";
			}
			else
			{
				echo "<div class='prevheader'>".($i+1).". perintah [ $sql ] tidak berhasil dijalankan!</div><br>";
			}
		}
}
else{
	echo "<div class='prevheader'>Mohon cek terlebih dahulu format notepad anda, pastikan tidak ada yang error.</div><br>";
}
?>