<?php
function acronym($longname)
{
    $letters=array();
    $words=explode(' ', $longname);
    $totalKar = count($words);
    $i = 0;
    foreach($words as $word)
    {
      if($i==($totalKar-1)){
        $word = (substr($word, 0, 3));
        array_push($letters, $word);
      }
      else if($i==0 || $i==1){
        $word = (substr($word, 0, 1));
        array_push($letters, $word);
      }

      $i++;
    }
    $shortname = strtoupper(implode($letters));
    return $shortname;
}
?>
