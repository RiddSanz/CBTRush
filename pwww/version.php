<?php
	if (!isset($_SESSION['versicbt'])) {
		$myfile = fopen("version/version.txt", "r") or die("Unable to open file!");
		while(!feof($myfile)) {
		  $version_data[] = fgets($myfile);
		}
		fclose($myfile);

		$_SESSION['versicbt'] = $version_data[0]." Rev.".$version_data[1];

	}
?>