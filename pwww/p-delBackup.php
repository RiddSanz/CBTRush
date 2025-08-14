<?php
session_start();
/* export to excel*/
if(isset($_POST['ajax']) && isset($_POST['mp']))
{
    $file_name = $_POST['mp'];
    if(file_exists('../soal/'.$file_name.'.txt')){
        unlink('../soal/'.$file_name.'.txt');
        echo "1";
    }else
    {
        echo "2";           
    }
}
else
{
    echo "3";
}
?>