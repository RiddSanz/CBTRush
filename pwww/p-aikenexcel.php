<?php
include "../lib/configuration.php";
include "tgl.php";
session_start();
require_once 'excel_reader2.php';
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1251');

$idmapel = $_SESSION['idmapel'];
$oleh = $_SESSION['userid'];
$dataU='';
if(isset($_POST['nameupload'])) 
{
	
	if (is_uploaded_file($_FILES['file']['tmp_name'])) 
	{
		
		$file = fopen($_FILES['file']['tmp_name'], "r");
		if ($file) 
		{

			$data->read($_FILES['file']['tmp_name']);
			echo "<div class='prevheader'>Data soal yang di upload</div><br>";
			$count = 0; 
			echo "<ol type='1'>";
			for ($x=2; $x <=count($data->sheets[0]["cells"]); $x++) {
				for ($i=0; $i < 8; $i++) { 
					if(isset($data->sheets[0]["cells"][$x][$i+1]))
					{
						$emapData[$i] = str_replace(",", "&#44;", $data->sheets[0]["cells"][$x][$i+1]);
						$emapData[$i] = str_replace("'", "&#39;", $emapData[$i]);
					}
					else
					{
						$emapData[$i]="";
					}
				}
				/*
			    $emapData[0] = $data->sheets[0]["cells"][$x][1];
			    $emapData[1] = $data->sheets[0]["cells"][$x][2];
			    $emapData[2] = $data->sheets[0]["cells"][$x][3];
			    $emapData[3] = $data->sheets[0]["cells"][$x][4];
			    $emapData[4] = $data->sheets[0]["cells"][$x][5];
			    $emapData[5] = $data->sheets[0]["cells"][$x][6];
			    $emapData[6] = $data->sheets[0]["cells"][$x][7];
			    $emapData[7] = $data->sheets[0]["cells"][$x][8];
			    */
			    $s = "insert into t_soal values ('','$emapData[0]','$emapData[1]','$emapData[2]',
					'$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]','$idmapel','$tgl'
					,'$oleh','0','1','1')";
				echo "<li>";
				$dataU = "soal : $emapData[0]";	
				/*$dataU = $s;*/			      	
				echo "<font color=green>".$dataU." OK!</font><br>";
				mysqli_query($db,$s);
				echo "</li>";			    
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