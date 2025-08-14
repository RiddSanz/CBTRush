<div class="nm-list">FASILITAS USER</div>
<div class="box">
	<div class="lpanel" onclick="window.location='?pg=cpanel'">
		<img src="images/cpanel.gif" height="25px" align="absmiddle" class="imglink"> Control Panel
	</div>
	<?php
	if (isset($_SESSION['trueValKey'])) {
	?>
	<div class="lpanel" onclick="window.location='?pg=status'">
		<img src="images/status.png" height="25px" align="absmiddle" class="imglink"> Status Pengguna
	</div>
	<div class="lpanel" onclick="window.location='?pg=jadwalu'">
		<img src="images/schedule_icon.png" height="25px" align="absmiddle" class="imglink"> Jadwal Ujian
	</div>
	<div class="lpanel" onclick="window.location='?pg=kartuP'">
		<img src="images/id_card.png" height="25px" align="absmiddle" class="imglink"> Kartu Peserta
	</div>
	<?php
	if ($_SESSION['tingkat_user']=='0') {
		/*require_once "pwww/cek-koneksi.php";*/
	?>
	<div class="lpanel" onclick="window.location='?pg=rtoken'">
		<img src="images/token4.png" height="25px" align="absmiddle" class="imglink"> Rilis Token
	</div>
	<div class="lpanel" onclick="window.location='?pg=ms'">
		<img src="images/system-icon.png" height="25px" align="absmiddle" class="imglink"> Menu System
	</div>
	<?php
	
	?>
	<div class="lpanel" onclick="window.location='?pg=updater'">
		<img src="images/system_software_update.png" height="25px" align="absmiddle" class="imglink"/> Update Software
	</div>
	<?php

	?>
	<?php
	}
	}
	?>
</div>
