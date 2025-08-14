<?php
function Sort_Directory_Files_By_Last_Modified($dir, $sort_type = 'descending', $date_format = "F d Y H:i:s.")
{
	$files = scandir($dir);

	$array = array();

	foreach($files as $file)
	{
		if($file != '.' && $file != '..')
		{
			date_default_timezone_set('Asia/Jakarta');
			$now = time();
			$last_modified = filemtime($dir.$file);

			$time_passed_array = array();

			$diff = $now - $last_modified;

			$days = floor($diff / (3600 * 24));

			if($days)
			{
				$time_passed_array['days'] = $days;
			}

			$diff = $diff - ($days * 3600 * 24);

			$hours = floor($diff / 3600);

			if($hours)
			{
				$time_passed_array['hours'] = $hours;
			}

			$diff = $diff - (3600 * $hours);

			$minutes = floor($diff / 60);

			if($minutes)
			{
				$time_passed_array['minutes'] = $minutes;
			}

			$seconds = $diff - ($minutes * 60);

			$time_passed_array['seconds'] = $seconds;

			$array[] = array('file'         => $file,
				'timestamp'    => $last_modified,
				'date'         => date ($date_format, $last_modified),
				'time_passed'  => $time_passed_array);
		}
	}

	usort($array, create_function('$a, $b', 'return strcmp($a["timestamp"], $b["timestamp"]);'));

	if($sort_type == 'descending')
	{
		krsort($array);
	}

	return array($array, $sort_type);
}
?>
<?php
		$dir = "soal/";
		$array = Sort_Directory_Files_By_Last_Modified($dir);
				// Info Array
		$info = $array[0];

				// Sort Type
		$sort_type = $array[1];
		$i=1;
		foreach($info as $key => $detail)
		{
			if ($detail['file'] != "index.html") {
				unlink('soal/'.$detail['file']);
			}			
			$i++; 
		}

		if (file_exists("update/cbtfile.zip")) {
			unlink("update/cbtfile.zip");
		}
?>