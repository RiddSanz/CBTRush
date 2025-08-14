<?php
$file = fopen("ipconf.sh", "r") or exit("Unable to open file!");

while(!feof($file))
  {
  	$br = fgets($file). "<br/>";
	if(!empty($br)){
  		$lines = explode(" ", $br);
    	$count = count($lines);
		if($count>1){
			/*//echo"Potong baris $count <br>";*/    		
			for ($i = 0; $i < $count; $i++) {
       			echo $lines[$i]." ";				
    		}
			//echo("Line = ".$lines[0]);			
		}
	}
  }
fclose($file);
?>