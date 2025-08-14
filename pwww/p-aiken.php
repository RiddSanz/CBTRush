<?php

session_start();
	if(isset($_POST['nameupload'])) {
		if (is_uploaded_file($_FILES['file']['tmp_name'])) {
			/*read file*/
			$questions = array();
			$temp = array();
			$handle = fopen($_FILES['file']['tmp_name'], "r");
			if ($handle) {
				while ($baris = fgets($handle, 4096)) {
					if (empty($baris) or trim($baris)=="") {
						continue;
					}
					/*/echo strip_tags($baris)."<br/>";*/
					$temp[] = trim($baris);
					if (preg_match("/ANSWER:/", strtoupper($baris))) {
						array_push($questions, $temp);
						$temp = array();
					}
				}
			} else {
				die ("Cannot read the file");
			}
		} else {
			die ("File not uploaded");
		}
		/* how many data in array*/
		$ldata = 0;
		$newquestions = array();
		foreach($questions as $question) {
			$tmp = array();
	 		/*/get the first data */
			$question_text = array_shift($question);
			/*/get the last data */
			$answer = array_pop($question);
			$answer = strtoupper(substr($answer,-1));
			/*echo $answer;*/
			$options = array();
			for($i=0; $i<count($question); $i++) {
				$options[$i]['text'] = trim(substr($question[$i],3));
				//$options[$i]['text'] = trim(strip_tags($question[$i],'<em><p><video><audio><img><span><sup><sub><ol><li><ul><strong>'));
				$options[$i]['right_answer'] = false;
				if ($i== ord($answer)-65) {
					$options[$i]['right_answer'] = true;
				}
			}
	 
			$tmp['question'] = trim(strip_tags($question_text,'<br><em><p><video><audio><img><span><sup><sub><ol><li><ul><strong>'));
			$tmp['options'] = $options;

			array_push($newquestions, $tmp);
			$_SESSION['datasoal'] = $newquestions;
			$ldata++;
		}
		echo "<div class='prevheader'>Hasil preview data : ".$ldata." data</div><br>";
		echo "<span class='warning'>Data soal belum tersimpan dalam database, Mohon klik tombol 'simpan soal'!.</span><br>";
		/*/echo "<pre>"; print_r ($newquestions); echo"</pre>";
		//echo "<pre>"; print_r($_SESSION['datasoal']); echo"</pre>";
		//echo $newquestions[0][question];
		//echo count($newquestions[5][options]);

		// print data array and push over variable	*/		
		echo '<ol type="1">';
		for($i=0;$i<$ldata;$i++)
		{
			echo '<li>'.$newquestions[$i]["question"].'</li>';
			echo '<ol type="A">';
			for ($j=0; $j < count($newquestions[$i]["options"]); $j++) 
			{ 
				if ($newquestions[$i]['options'][$j]['right_answer']==true) 
				{
					echo '<li><font color="BLUE">'.$newquestions[$i]["options"][$j]["text"].'</font></li>';
				} 
				else
				{
					echo '<li>'.$newquestions[$i]["options"][$j]["text"].'</li>';
				}
				
			}
			echo '</ol>';
			echo "<br>"; 				
		}
		echo '</ol>';
	
	}
?>