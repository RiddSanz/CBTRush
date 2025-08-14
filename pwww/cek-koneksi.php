<?php
	$versi_baru = '';
	$rev_baru = '';
	$size_file = '';
	$versi_cur = '';
	$rev_cur = '';
	include "addr-server.php";

	$destination_folder = '../soal/';

	$url = $addr.'update/version.txt';
	//echo $url;
	$newfname = $destination_folder . basename($url);

    $response = get_headers($url);
    /*print_r($response);*/
	if($response[0] === 'HTTP/1.1 200 OK')
	{
    	$file = fopen ($url, "rb");
		if ($file)
		{
		    while ($baris = fgets($file, 4096))
		    {
		    	if (empty($baris) or trim($baris)=="") {
		    		continue;
		    	}
		    	/*/echo strip_tags($baris)."<br/>";*/
		    	$temp[] = trim($baris);
		    }

			/*print_r($temp);*/
			$versi_baru = $temp[0];
			$rev_baru = $temp[1];
			$size_file = $temp[2];
			$data_update = $temp[3];
			if ($file) {
				fclose($file);
			}
		}
		else {
			echo "Versi software tidak dapat di baca!";
		}
	}
	else{
		/*echo "Koneksi gagal!";*/
		echo '';
	}

	/* reading current version*/
	$url2 = "version/version.txt";
	$file2 = fopen ($url2, "rb");
	if ($file2)
	{
	    while ($baris2 = fgets($file2, 4096))
	    {
	    	if (empty($baris2) or trim($baris2)=="") {
	    		continue;
	    	}
	    	/*/echo strip_tags($baris)."<br/>";*/
	    	$temp2[] = trim($baris2);
	    }

		/*print_r($temp2);*/
		$versi_cur = $temp2[0];
		$rev_cur = $temp2[1];
		if ($file2) {
			fclose($file2);
		}
	}
	else {
		echo "Versi software saat ini tidak dapat di baca!<br>";
	}
?>
