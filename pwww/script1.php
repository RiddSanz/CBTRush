<?php
$j=0;
$tmp=0;
$nilai=70;
$awal=680;
$arr = array(0,70,70,
70,75,
75,85,
70,85,
70,70,
75,85,
70,85,
70,85,
75,70,
75,85,
75,70,
70,75,
70,85,
70,70,
75,70,
70,70,
85,70
);
echo "VERSION BUILD=8961227 RECORDER=FX<br>";
echo "TAB T=1<br>";
//echo "URL GOTO=http://raporku.net/2015_genap/guru/#<br>";
for($i=$nilai;$i<((38*2)+$nilai);$i++) {	
	$value = rand(80,85);
	if (isset($arr[$j])) {
		$tmp = $arr[$j];
	}
	else
	{
		$tmp=0;
	}
	
	echo "TAG POS=$awal TYPE=BUTTON ATTR=ID:input_<br>";
	echo "TAG POS=$i TYPE=SELECT ATTR=TXT:010099989796959493929190898887868584838281807978777675747372* CONTENT=%".$tmp."<br>";
	//echo "TAG POS=$i TYPE=SELECT ATTR=TXT:010099989796959493929190898887868584838281807978777675747372* CONTENT=%0<br>";
	//echo "TAG POS=$i TYPE=SELECT ATTR=TXT:010099989796959493929190898887868584838281807978777675747372* CONTENT=%$value<br>";
	$awal+=9;
	$j++;
}

?>