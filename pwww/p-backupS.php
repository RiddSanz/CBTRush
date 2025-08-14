<?php
include("../lib/configuration.php");
session_start();
/* export to excel*/
$idm = $_SESSION['idmapel'];
$sm = "select * from t_mapel where mid='$idm' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
$ket_mapel = $bm['ket_mapel'];
$kelas = $bm['kelas'];

$select = "select isi_soal as soal,pilihan1 as pilihan_a,pilihan2 as pilihan_b,pilihan3 as pilihan_c,pilihan4 as pilihan_d,pilihan5 as pilihan_e,benar,opsi_esay,point_soal,tingkat_kesulitan  from t_soal where id_mapel='$idm' order by qid asc";
$export = mysqli_query($db,$select);
$jmlData = mysqli_num_rows($export);

/*$file_name = $nm_mapel."-".date('dmy-His');*/
$file_name = trim(substr($ket_mapel, 0,15 ))."".trim($kelas);
function trim_all( $str , $what = NULL , $with = ' ' )
{
    if( $what === NULL )
    {
        $what   = "\\x00-\\x20";
    }

    return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
}

/* creates a compressed zip file */
function create_zip($files = array(),$destination = '',$overwrite = false) {
    if(file_exists($destination) && !$overwrite) { return false; }
    $valid_files = array();

    if(is_array($files)) {

        foreach($files as $file) {

            if(file_exists($file)) {
                $valid_files[] = $file;
            }
        }
    }

    if(count($valid_files)) {

        $zip = new ZipArchive();
        if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
            return false;
        }

        foreach($valid_files as $file) {
            $zip->addFile($file,$file);
        }

        $zip->close();

        return file_exists($destination);
    }
    else
    {
        return false;
    }
}

    $tujuan = "";
    $nomor = 0;

        while ($dr = mysqli_fetch_array($export,MYSQLI_ASSOC)) {
            $soal = str_replace(",", "&#44;", $dr['soal']);
            $a = str_replace(",", "&#44;", $dr['pilihan_a']);
            $b = str_replace(",", "&#44;", $dr['pilihan_b']);
            $c = str_replace(",", "&#44;", $dr['pilihan_c']);
            $d = str_replace(",", "&#44;", $dr['pilihan_d']);
            $e = str_replace(",", "&#44;", $dr['pilihan_e']);

            /*$soal = str_replace('"', "&quot;", $soal);
            $a = str_replace('"', "&quot;", $a);
            $b = str_replace('"', "&quot;", $b);
            $c = str_replace('"', "&quot;", $c);
            $d = str_replace('"', "&quot;", $d);
            $e = str_replace('"', "&quot;", $e);
            */

            $soal = str_replace("'", "&rsquo;", $soal);
            $a = str_replace("'", "&rsquo;", $a);
            $b = str_replace("'", "&rsquo;", $b);
            $c = str_replace("'", "&rsquo;", $c);
            $d = str_replace("'", "&rsquo;", $d);
            $e = str_replace("'", "&rsquo;", $e);

            $soal = str_replace("`", "&rsquo;", $soal);
            $a = str_replace("`", "&rsquo;", $a);
            $b = str_replace("`", "&rsquo;", $b);
            $c = str_replace("`", "&rsquo;", $c);
            $d = str_replace("`", "&rsquo;", $d);
            $e = str_replace("`", "&rsquo;", $e);

/*
            $soal = str_replace(".", "&middot;", $dr['soal']);
            $a = str_replace(".", "&middot;", $dr['pilihan_a']);
            $b = str_replace(".", "&middot;", $dr['pilihan_b']);
            $c = str_replace(".", "&middot;", $dr['pilihan_c']);
            $d = str_replace(".", "&middot;", $dr['pilihan_d']);
            $e = str_replace(".", "&middot;", $dr['pilihan_e']);

            $soal = str_replace("$nm_mapel", "#########", $dr['soal']);
            $a = str_replace("$nm_mapel", "#########", $dr['pilihan_a']);
            $b = str_replace("$nm_mapel", "#########", $dr['pilihan_b']);
            $c = str_replace("$nm_mapel", "#########", $dr['pilihan_c']);
            $d = str_replace("$nm_mapel", "#########", $dr['pilihan_d']);
            $e = str_replace("$nm_mapel", "#########", $dr['pilihan_e']);
*/
            /*
            $soal = str_replace("<p></p>", "<br>", $dr['soal']);
            $a = str_replace("<p></p>", "<br>", $dr['pilihan_a']);
            $b = str_replace("<p></p>", "<br>", $dr['pilihan_b']);
            $c = str_replace("<p></p>", "<br>", $dr['pilihan_c']);
            $d = str_replace("<p></p>", "<br>", $dr['pilihan_d']);
            $e = str_replace("<p></p>", "<br>", $dr['pilihan_e']);

            $soal = str_replace("&nbsp;", " ", $dr['soal']);
            $a = str_replace("<&nbsp;", " ", $dr['pilihan_a']);
            $b = str_replace("&nbsp;", " ", $dr['pilihan_b']);
            $c = str_replace("&nbsp;", " ", $dr['pilihan_c']);
            $d = str_replace("&nbsp;", " ", $dr['pilihan_d']);
            $e = str_replace("&nbsp;", " ", $dr['pilihan_e']);
            */
            /*$soal = str_replace(";", "&#59;", $dr['soal']);
            $a = str_replace(";", "&#59;", $dr['pilihan_a']);
            $b = str_replace(";", "&#59;", $dr['pilihan_b']);
            $c = str_replace(";", "&#59;", $dr['pilihan_c']);
            $d = str_replace(";", "&#59;", $dr['pilihan_d']);
            $e = str_replace(";", "&#59;", $dr['pilihan_e']);*/

            $dsoal[$nomor]['q'] = trim(strip_tags($soal, '<br><p><em><video><audio><img><span><sup><sub><ol><li><ul><strong>'));
            $dsoal[$nomor]['a'] = trim(strip_tags($a, '<br><em><video><audio><img><span><sup><sub><ol><li><ul><strong>'));
            $dsoal[$nomor]['b'] = trim(strip_tags($b, '<br><em><video><audio><img><span><sup><sub><ol><li><ul><strong>'));
            $dsoal[$nomor]['c'] = trim(strip_tags($c, '<br><em><video><audio><img><span><sup><sub><ol><li><ul><strong>'));
            $dsoal[$nomor]['d'] = trim(strip_tags($d, '<br><em><video><audio><img><span><sup><sub><ol><li><ul><strong>'));
            $dsoal[$nomor]['e'] = trim(strip_tags($e, '<br><em><video><audio><img><span><sup><sub><ol><li><ul><strong>'));
            $dsoal[$nomor]['ans'] = trim($dr['benar']);
            $dsoal[$nomor]['opsi_esay'] = trim($dr['opsi_esay']);
            $dsoal[$nomor]['point_soal'] = trim($dr['point_soal']);
            $dsoal[$nomor]['tingkat_kesulitan'] = trim($dr['tingkat_kesulitan']);

            /* koding backup lawas
            $tujuan.= trim(strip_tags($soal, '<br><p><em><video><audio><img><span><sup><sub><ol><li><ul><strong>'));
            $tujuan.= "\r\n";
            $tujuan.= "a. ".trim(strip_tags($a, '<br><em><video><audio><img><sup><sub><ol><li><ul><strong>'));
            $tujuan.= "\r\n";
            $tujuan.= "b. ".trim(strip_tags($b, '<br><em><video><audio><img><sup><sub><ol><li><ul><strong>'));
            $tujuan.= "\r\n";
            if (!empty($c) || $c!="") {
                $tujuan.= "c. ".trim(strip_tags($c, '<br><em><video><audio><img><sup><sub><ol><li><ul><strong>'));
                $tujuan.= "\r\n";
            }
            if (!empty($d) || $d!="") {
                $tujuan.= "d. ".trim(strip_tags($d, '<br><em><video><audio><img><sup><sub><ol><li><ul><strong>'));
                $tujuan.= "\r\n";
            }
            if (!empty($e) || $e!="") {
                $tujuan.= "e. ".trim(strip_tags($e, '<br><em><video><audio><img><sup><sub><ol><li><ul><strong>'));
                $tujuan.= "\r\n";
            }
            $tujuan.= "answer: ".$dr['benar'];
            $tujuan.= "\r\n";
            $tujuan.= "\r\n";

            sampai sini */

            /*
            $tujuan.= strip_tags($soal, '<img> ');
            $tujuan.= $separate."".strip_tags($a, '<img> ');
            $tujuan.= $separate."".strip_tags($b, '<img> ');
            $tujuan.= $separate."".strip_tags($c, '<img> ');
            $tujuan.= $separate."".strip_tags($d, '<img> ');
            $tujuan.= $separate."".strip_tags($e, '<img> ');
            $tujuan.= $separate."".$dr['benar'];
            $tujuan.= $separate."";
            $tujuan.= "\r\n";
            */
            /* untuk mendapatkan source image
            preg_match('%<img.*?src=["\'](.*?)["\'].*?/>%i', $soal , $rsl);
            //$foo = $result[1];
            if (isset($rsl[1])) {
                # code...
                print_r($rsl);
            }
            */
            $nomor++;
        }

        //$hasil = serialize($dsoal);
        $hasil = base64_encode(serialize($dsoal));
        //echo $hasil;

        $ourFileName = "../mapel/".trim($nm_mapel)."/".$file_name.".dat";
        $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
        # Now UTF-8 - Add byte order mark
        fwrite($ourFileHandle, pack("CCC",0xef,0xbb,0xbf));
        $ck = fwrite($ourFileHandle, $hasil);
        fclose($ourFileHandle);
        if ($ck) {
            echo "sukses";
        }
        else{
            echo "$ck";
        }
        // scan direktori gambar dan audio video
        $nm_mapel = trim($_SESSION['mapelnya']);
        $dataimg="";

        // image extensions
        $extensions = array('dat','mp3', 'ogg', 'wav', 'mp4', 'webm','jpg', 'png', 'gif', 'bmp','jpeg','JPG','PNG','GIF','BMP','JPEG');
        $result = array();
        $directory = new DirectoryIterator('../mapel/'.trim($nm_mapel).'/');
        foreach ($directory as $fileinfo) {
            if ($fileinfo->isFile()) {
                $extension = strtolower(pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION));
                if (in_array($extension, $extensions)) {
                    $result[] = $fileinfo->getFilename();
                }
            }
        }

        if (count($result)==0) {
            $dataimg="";
        }
        else
        {
            for ($i=0; $i < count($result); $i++) {
                /*$dt = "../mapel/".trim($nm_mapel)."/".$result[$i];*/
                $dt = "../mapel/".trim($nm_mapel)."/".$result[$i];
                $dataimg .= "$dt";
                if ($i!=(count($result)-1)) {
                    $dataimg .= ",";
                }
            }

        }
        
        $files_to_zip2 = explode(',', $dataimg);        

        $result2 = create_zip($files_to_zip2,'../'.$file_name.'.zip');

        if ($result2) {
            echo "";
        }
        else
        {
            echo "$result2";
        }
        
mysqli_close($db);
?>
