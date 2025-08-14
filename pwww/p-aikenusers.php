<?php

include "../lib/configuration.php";
include "tgl.php";
session_start();
$oleh = $_SESSION['userid'];
$dataU='';
if(isset($_POST['nameupload']))
{

	if (is_uploaded_file($_FILES['file']['tmp_name']))
	{

		$file = fopen($_FILES['file']['tmp_name'], "r");
		if ($file)
		{
			echo "<div class='prevheader'>Data user yang di upload</div><br>";
			$count = 0;
			echo "<ol type='1'>";
			while (($emap = fgetcsv($file, 10000, ",")) !== FALSE)
			{
				$count++;
			    if($count>1){
			    	for ($i=0; $i < 9; $i++) {
			    		if(isset($emap[$i]))
						{
							$emapData[$i] = $emap[$i];
						}
						else
						{
							$emapData[$i]="";
						}
			    	}

			    	$sql = "select * from t_peserta where pengguna='$emapData[0]' limit 0,1";
					$rs=mysqli_query($db,$sql);
					$ada = mysqli_num_rows($rs);
					if (!empty($emapData[0]) && !empty($emapData[1]) && !empty($emapData[2]) && !empty($emapData[3]) && !empty($emapData[4])) 
					{
						if (strtolower(trim($emapData[5]))=='guru') {
							$tk = '1';
							$group = 'operator';
						}
						else
						{
							$tk = '2';
							$group = $emapData[3];
						}
						$s = "insert into t_peserta values ('','$emapData[0]','$emapData[1]',
							'$emapData[2]','$group','$tk','$emapData[4]','$oleh','$tgl','$emapData[6]','$emapData[8]','$emapData[7]')";
						//$dataU = "Import Username : $emapData[0], Password: $emapData[1], Nama : $emapData[2], Kelompok: $emapData[3], Kode Sekolah: $emapData[4]";
				      	$dataU = "Import Username : $emapData[0]Nama : $emapData[2]";

				      	echo "<li>";
						if($ada==0)
						{
							echo "<font color=green>".$dataU." Sukses!</font><br>";
							mysqli_query($db,$s);
						}
						else
						{
							echo "<font color=red>".$dataU." Gagal!</font><br>";
						}
						echo "</li>";
					}
					else
					{
						echo "<li>FORMAT DATA ANDA SALAH! <br>
						1) buka file di notepad kemudian pastikan bahwa antara kolom dibatasi dengan koma(,).<br>
						2) Kolom yang wajib diisi adalah username , password , nama_peserta , group dan npsn sekolah.
						</li>";
					}

			    }

			}
			echo "</ol>";
			echo "<div class='spasi'></div>";
			echo "<div class='spasi'></div>";
		}
		else
		{
				die ("Cannot read the file");
		}
	}
	else
	{
		die ("File not uploaded");
	}

}
?>
