<?php
/* This  software  is  licensed   under  an */
/* Open Source Initiative  approved license */
/*                                          */
/* You can  use parts  or whole  content of */
/* this script  by free, either  for perso- */
/* nal or  bussiness purpose. You  can also */
/* modify  this script and write  your name */
/* bellow  this comment. But  this comment  */
/* should be  writen in origin  without any */
/* changes.                                 */
/*                                          */
function de212($in){
	$out='';
	$out1='';$out2='';$out3='';
	if (empty($in) || $in=='') {
		$out = 'prefix499ca49c6a924:prefix499ca49c6a948:prefix499ca49c6a948';
	}
	
	function getval($text,$start){
		$start++;
		if($text[$start]!=']')
		{
			$val=$text[$start].getval($text,$start);
			return $val;
		}
	}
	$key = array('1' => 'G','3' => 'A','5' => 'S');
	$in = str_replace($key, array_keys($key), $in);
	for($i=0;$i<strlen($in);$i++)
	{
		if($in[$i]=='[')
		{
			$temp=getval($in,$i);
			$out = $out.chr(base_convert(base_convert($temp,7,5),3,10));
		}
	}
	
	list($out1,$out2,$out3) = explode(":", $out);
	$out = 'prefix499ca49c6a924:prefix499ca49c6a948:prefix499ca49c6a948';
	/*
	//list($usec, $sec) = explode(' ',microtime());
	//echo sprintf("%s%08x%05x",'prefix',$sec,(($usec * 1000000) % 0x100000)),'<br>',uniqid('prefix',false);
	*/
	$out='';
	$out.=$out1.$out3;
	return $out;
}
?>