<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
?>
<script src="js/jquery-1.6.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/anytime.css" />
<script src="js/anytime.js"></script>
<script>
$(document).ready(function(){

	if ($('#fedit').val()=='') {
		$('#btnsave').hide();
	}else
	{
		$('#btnsave').show();
	}
	$('input[name=soal_opsi]').change(function() {
		var tmp_sulit = $('#soal_sulit').val();
		var tmp_sedang = $('#soal_sedang').val();
		var soal_opsi = $('#soal_opsi').val();
		var nil_mudah = parseInt(soal_opsi) - (parseInt(tmp_sulit)+parseInt(tmp_sedang));
		$('#tmp_mudah').val(nil_mudah);
	});
	$('input[name=soal_sulit]').change(function() {
		var tmp_sulit = $('#soal_sulit').val();
		var tmp_sedang = $('#soal_sedang').val();
		var soal_opsi = $('#soal_opsi').val();
		var nil_mudah = parseInt(soal_opsi) - (parseInt(tmp_sulit)+parseInt(tmp_sedang));
		$('#tmp_mudah').val(nil_mudah);
	});
	$('input[name=soal_sedang]').change(function() {
		var tmp_sulit = $('#soal_sulit').val();
		var tmp_sedang = $('#soal_sedang').val();
		var soal_opsi = $('#soal_opsi').val();
		var nil_mudah = parseInt(soal_opsi) - (parseInt(tmp_sulit)+parseInt(tmp_sedang));
		$('#tmp_mudah').val(nil_mudah);
	});

	$('#waktutest').change(function()
	{

		var waktutest = $('#waktutest').val();
		$("#preview").html('');
		$("#preview").html('<img src="images/spinner.gif" alt="Uploading...." width="25px"/>');
		$.post( "pwww/p-checkAddtest.php",{ kd:""+kd })
		.done(function(data) {

		  if (data==0) {
		  	$("#preview").html('<img src="images/success.png" alt="Uploading...." width="16px"/>');
		  	$('#btnsave').show();
		  }else
		  {
		  	$("#preview").html('<img src="images/fail.png" alt="Uploading...." width="16px"/>');
		  	$('#btnsave').hide();
		  }

		})
		.fail(function() {
		    alert( "Error" );
		})
		.always(function() {

		});
	});

	$("#btnsave").click(function()
	{
		//alert("test");
		var id=$("#id").val();
		var kd=$("#kd").val();
		var namatest=$("#namatest").val();
		var waktutest=$("#waktutest").val();
		var tombolselesai=$("#tombolselesai").val();
		var soal_opsi=$("#soal_opsi").val();
		var soal_esay=$("#soal_esay").val();
		var soal_sulit = $("#soal_sulit").val();
		var soal_sedang = $("#soal_sedang").val();
		var acak_soal = $("input:radio[name=acak_soal]:checked").val();
		var acak_jawaban = $("input:radio[name=acak_jawaban]:checked").val();
		var hasil_jawab = $("input:radio[name=hasil_jawab]:checked").val();
		var jns_test = $("input:radio[name=jns_test]:checked").val();
		var bobot = $("input:radio[name=bobot]:checked").val();

		var tglmulai=$("#tglmulai").val();
		var tglakhir=$("#tglakhir").val();
		var fedit=$("#fedit").val();
		var jumlahsoal = parseInt(soal_opsi) + parseInt(soal_esay);
		var soal_mudah = parseInt(jumlahsoal) - (parseInt(soal_sulit) + parseInt(soal_sedang) + parseInt(soal_esay));
		var cekSoal = parseInt(soal_sulit) + parseInt(soal_sedang);

		if (parseInt(cekSoal) <= parseInt(soal_opsi)) {
			var dataString = 'kd='+kd+'&fedit='+fedit+'&idmapel='+id+'&namatest='+namatest+'&waktutest='+waktutest+'&jumlahsoal='+jumlahsoal+'&tombolselesai='+tombolselesai+'&tglmulai='+tglmulai+'&tglakhir='+tglakhir+'&soal_opsi='+soal_opsi+'&soal_esay='+soal_esay+'&soal_sulit='+soal_sulit+'&soal_sedang='+soal_sedang+'&soal_mudah='+soal_mudah+'&acak_soal='+acak_soal+'&acak_jawaban='+acak_jawaban+'&jns_test='+jns_test+'&hasil_jawab='+hasil_jawab+'&bobot='+bobot;
			//alert(dataString);
			if($.trim(kd).length>0 && $.trim(namatest).length>0 && $.trim(waktutest).length>0 && $.trim(soal_opsi).length>0 && $.trim(tglmulai).length>0 && $.trim(tglakhir).length>0)
			{
				$.ajax({
					type: "POST",
					url: "pwww/p-addtest.php",
					data: dataString,
					cache: false,
					beforeSend: function(){ $("#btnsave").val('Waiting to save...');},
					success: function(data){
						if(data=="1")
						{
							/*$("body").load("index.php?pg=ltest").hide().fadeIn(1500).delay(6000);
							*/
							window.location.href='index.php?pg=ltest';
						}
						else if(data=="2")
						{
							$("#btnsave").val('Simpan Test');
							$("#error").html("<span style='color:#cc0000'>Proses penyimpanan gagal!!!.</span> ");
							$("#error").hide().fadeIn(1500).delay(6000);

						}
						else if(data=="3")
						{
							$("#btnsave").val('Simpan Test');
							$("#error").html("<span style='color:#cc0000'>Tersimpan! , Pembobotan tidak dapat dirubah dikarenakan sudah terdapat peserta yang ujian!.</span> ");
							$("#error").hide().fadeIn(1500).delay(6000);

						}
						//alert(data);

					}
				});

			}
		}
		else
		{
			alert('Soal sulit dan sedang melebihi jumlah soal opsi!');
		}
		return false;
	});

});
</script>
<?php
include "lib/configuration.php";
$idmapel = $_SESSION['idmapel'];
$sm = "select * from t_mapel where mid='$idmapel' limit 1";
$rm = mysqli_query($db,$sm);
$bm = mysqli_fetch_array($rm,MYSQLI_ASSOC);
$nm_mapel = $bm['nama_mapel'];
$ket_mapel = $bm['ket_mapel'];
$kelas = $bm['kelas'];

if (isset($_GET['s'])) {

	$sql = "select * from t_test where id='".$_GET['s']."' limit 0,1";

	$rs = mysqli_query($db,$sql);
	$br = mysqli_fetch_array($rs,MYSQLI_ASSOC);

	$idtest = $br['id'];
	$kdtest = $br['kode_test'];
	$nmtest = $br['keterangan'];
	$wktest = $br['waktu_test'];
	$jumlahsoal = $br['jumlah_soal'];
	$tombolwaktu = $br['tingkat_test'];
	$tglmulai = $br['tgl_awal_test'];
	$tglakhir = $br['tgl_akhir_test'];
	$soal_esay = $br['soal_esay'];
	$soal_opsi = $br['soal_opsi'];
	$acak_soal = $br['acak_soal'];
	$acak_jawaban = $br['acak_jawaban'];
	$hasil_jawab = $br['publish_test_to_other'];
	$soal_sulit = $br['soal_sulit'];
	$soal_sedang = $br['soal_sedang'];
	$soal_mudah = $br['soal_mudah'];
	$jns_test = $br['nama_test'];
	$bobot = $br['pembobotan'];
}
else{
	$idtest = '';
	$kdtest = $idmapel.$thn.$bln.$hr.$jm.$min.$sec;
	$nmtest = '';
	$wktest = '0';
	$jumlahsoal = '0';
	$tombolwaktu = '15';
	$tglmulai = '';
	$tglakhir = '';
	$soal_esay = '0';
	$soal_opsi = '0';
	$acak_soal = '0';
	$acak_jawaban = '0';
	$hasil_jawab = '0';
	$soal_sulit = '0';
	$soal_sedang = '0';
	$soal_mudah = '0';
	$jns_test = '';
	$bobot = '0';
}
$ju = array('0' =>'usek' ,
			'1'=>'pas',
			'2'=>'pts',
			'3'=>'ph',
			'4'=>'remidi',
			'5'=>'other'
			 );
?>
<style>
.sub_bab{
	padding: 2px;
	padding-bottom: 5px;
	padding-top: 5px;
	background-color: #f5f5ef;
	width: 100%;
	font-weight: 800;
}
.sub_bab > span{
	font-weight: 200;
}
input[type="radio"]+label {
  font-weight: 200;
}
</style>
<?PHP/*
<div class="nm-list-section">
	<a href='#' onclick="window.location='?pg=cpanel'">PANEL</a>
	<a href='#' onclick="window.location='?pg=lsubmapel'">SETTING TEST CBT</a>
	<a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=$ket_mapel;?> <?=$kelas;?></a>
	<a href='#' onclick="window.location='?pg=ltest'">Buat Test</a> |
	Tambah Test
</div>*/?>
<ul class="topnav" id="myTopnav">
	<li><a href='#' onclick="window.location='?pg=cpanel'"><?=$site1;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsubmapel'"><?=$site2;?></a></li>
	<li><a href='#' onclick="window.location='?pg=lsub2mapel&s=<?=$idmapel;?>'"><?=strtoupper($kelas." ".$ket_mapel);?></a></li>
	<li><a href='#' onclick="window.location='?pg=ltest'"><?=$site3;?></a></li>
	<li id='ratakanan'><a href='#' class='activek'><?=$site4;?></a></li>
</ul>
<div class='spasi'></div>
<div class='f-input'>
<form method="POST" enctype="multipart/form-data">
	<input type="hidden" name="fedit" value="<?=$idtest;?>" id="fedit">
	<input type="hidden" name="id" value="<?=$idmapel;?>" id="id">
	<input type="hidden" name="kd" value="<?=$kdtest;?>" id="kd">
	<table>
		<tr>
			<td colspan='2'>
				<div class="sub_bab">Jenis Test</div><br>
				<input type="radio" name="jns_test" value="<?=$ju[0];?>" <?php if($jns_test==$ju[0]) echo "checked";?>><label for="usek"><?=strtoupper($ju[0]);?></label>
				<input type="radio" name="jns_test" value="<?=$ju[1];?>" <?php if($jns_test==$ju[1]) echo "checked";?>><label for="pas"><?=strtoupper($ju[1]);?></label>
				<input type="radio" name="jns_test" value="<?=$ju[2];?>" <?php if($jns_test==$ju[2]) echo "checked";?>><label for="pts"><?=strtoupper($ju[2]);?></label>
				<input type="radio" name="jns_test" value="<?=$ju[3];?>" <?php if($jns_test==$ju[3]) echo "checked";?>><label for="ph"><?=strtoupper($ju[3]);?></label>
				<input type="radio" name="jns_test" value="<?=$ju[4];?>" <?php if($jns_test==$ju[4]) echo "checked";?>><label for="remidi"><?=strtoupper($ju[4]);?></label>
				<input type="radio" name="jns_test" value="<?=$ju[5];?>" <?php if($jns_test==$ju[5]) echo "checked";?>><label for="other">Lainnya</label>
				<br><br>
				<div class="sub_bab">Keterangan tambahan</div><br>
				<input type="text" name="namatest" value="<?=$nmtest;?>" id="namatest" placeholder="Silahkan tuliskan kode mapel , KD , Ganjil , Genap , 1 atau 2." class="style-2 wdp75">
			</td>
		</tr>
		<tr>
			<td>
				<div class="sub_bab">Waktu Pengerjaan</div><br>
				<input type="text" name="waktutest" value="<?=$wktest;?>" id="waktutest" placeholder="Misal: 60" class="style-2 wd1"> menit
				<br>
			</td>
			<td>
				<div class="sub_bab">Waktu Test</div><br>
				<input type="text" name="tglmulai" value="<?=$tglmulai;?>" id="tglmulai" class="style-2 w150px" readonly="yes" placeholder="Tanggal test dibuka">
				<?php /*?><img src="images/calendar.png" width="20px" class="caltest" id="kliktgl"> */?>
				<script>
			    $('#tglmulai').click(
			      function(e) {
			        $('#tglmulai').AnyTime_noPicker().AnyTime_picker().focus();
			        e.preventDefault();
			      } );
			  	</script>
			  	s/d
			  	<input type="text" name="tglakhir" value="<?=$tglakhir;?>" id="tglakhir" class="style-2 w150px" readonly="yes" placeholder="Tanggal test ditutup">
				<script>
			    $('#tglakhir').click(
			      function(e) {
			        $('#tglakhir').AnyTime_noPicker().AnyTime_picker().focus();
			        e.preventDefault();
			      } );
			  	</script>
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<div class="sub_bab">Jumlah Soal yang dikeluarkan</div><br>
				<div>
					<input type="text" name="soal_opsi" value="<?=$soal_opsi;?>" id="soal_opsi" placeholder="Misal: 50" class="style-2 wd1"><span class="wdauto2">pilihan</span><?php echo ''.str_repeat('&nbsp;', 15);?>
					<input type="text" name="soal_esay" value="<?=$soal_esay;?>" id="soal_esay" placeholder="Misal: 50" class="style-2 wd1"><span class="wdauto2">uraian</span>
				</div>
				<div class="sub_bab">Jumlah tingkat kesukaran soal pilihan.</div><br>
				<div>
					<?php
					$tmp_mudah = $soal_opsi - ($soal_sulit+$soal_sedang);
					?>
				<input type="text" name="soal_sulit" value="<?=$soal_sulit;?>" id="soal_sulit" placeholder="Misal: 50" class="style-2 wd1"> Sulit <?php echo ''.str_repeat('&nbsp;', 15);?>
				<input type="text" name="soal_sedang" value="<?=$soal_sedang;?>" id="soal_sedang" placeholder="Misal: 50" class="style-2 wd1"> Sedang <?php echo ''.str_repeat('&nbsp;', 15);?>
				<input type="text" name="tmp_mudah" value="<?=$tmp_mudah;?>" id="tmp_mudah" placeholder="Misal: 50" class="style-2 wd1" readonly="yes"> Mudah<br><br>
				</div>
				<div class="sub_bab">Acak Soal</div>
				<input type="radio" name="acak_soal" value="1" <?php if($acak_soal=='1') echo "checked";?>><label for="1">Ya</label>
				<input type="radio" name="acak_soal" value="0" <?php if($acak_soal=='0') echo "checked";?>><label for="0">Tidak</label>
				<br><br>
				<div class="sub_bab">Acak Jawaban</div>
				<input type="radio" name="acak_jawaban" value="1" <?php if($acak_jawaban=='1') echo "checked";?>><label for="1">Ya (Aktif)</label>
				<input type="radio" name="acak_jawaban" value="2" <?php if($acak_jawaban=='2') echo "checked";?>><label for="2">Ya (Pasive)</label>
				<input type="radio" name="acak_jawaban" value="0" <?php if($acak_jawaban=='0') echo "checked";?>><label for="0">Tidak</label>
				<br><br>
				<div class="sub_bab">Tampilkan Hasil Ujian Ke Peserta?</div>
				<input type="radio" name="hasil_jawab" value="1" <?php if($hasil_jawab=='1') echo "checked";?>><label for="1">Ya</label>
				<input type="radio" name="hasil_jawab" value="0" <?php if($hasil_jawab=='0') echo "checked";?>><label for="0">Tidak</label>
				<br><br>
				<div class="sub_bab">Pembobotan Nilai ? <span>(Jika "ya" maka nilai benar = 2 , nilai salah = -1 dan tidak menjawab = 0)</span></div>
				<input type="radio" name="bobot" value="1" <?php if($bobot=='1') echo "checked";?>><label for="1">Ya</label>
				<input type="radio" name="bobot" value="0" <?php if($bobot=='0') echo "checked";?>><label for="0">Tidak</label>
				<br><br>
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<div class="sub_bab">Tombol Selesai</div><br>
				<input type="text" name="tombolselesai" value="<?=$tombolwaktu;?>" id="tombolselesai" placeholder="Misal: 15" class="style-2 wd1"> menit sebelum waktu habis
				<br>
			</td>
		</tr>
	</table>

  	<div class='spasi'></div>
	<input type="submit" value="Simpan Test" name="save" id="btnsave">
	<input type="button" value="Kembali" class="tombol" onclick="window.location='?pg=ltest'">
</form>
</div>
<div id="error"></div>
<div class='spasi'></div>
<?php
}
?>
