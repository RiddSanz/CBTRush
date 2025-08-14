<?php
include "pwww/list-iconmenu.php";
if($_SESSION['tingkat_user']=='2')
{
	$home = "Dashboard";
}
else
{
	$home = "Dashboard";
}
?>
<div class='biologin'>
	<div class="btnbio">
		<img src="<?=$menupengguna;?>" height="30px" class="lingkaran" align="left">
		<span class="textbio"><?php echo "".$_SESSION['user_nama'];?><br><?php echo " ".$_SESSION['kelompok_user'];?>
		</span>
		<div class="dropdown-content">
			<a href="index.php">
		     	<img src="<?=$menucp;?>" height="25px" width="25px" align="absmiddle" class="imglink2"> <?=$home;?>
		     </a>
		    <?php
			if (isset($_SESSION['trueValKey']) && $_SESSION['tingkat_user']!='2') {
			?>
		     <a href="#" onclick="window.location='?pg=status'">
		     	<img src="<?=$menustatususer;?>" height="25px" width="25px" align="absmiddle" class="imglink2"> Status Pengguna
		     </a>
		     <a href="#" onclick="window.location='?pg=kartuP'">
		     	<img src="<?=$menukartu;?>" height="25px" width="25px" align="absmiddle" class="imglink2"> Kartu Peserta
		     </a>
		     <?php
				if ($_SESSION['tingkat_user']=='0') {
					/*require_once "pwww/cek-koneksi.php";*/
				?>
		     <a href="#" onclick="window.location='?pg=rtoken'">
		     	<img src="<?=$menutoken;?>" height="25px" width="25px" align="absmiddle" class="imglink2"> Rilis Token
		     </a>
		     <a href="#" onclick="window.location='?pg=ms'">
		     	<img src="<?=$menusistem;?>" height="25px" width="25px" align="absmiddle" class="imglink2"> Menu Sistem
		     </a>
		     <a href="#" onclick="window.location='?pg=updater'">
		     	<img src="<?=$menuupdate;?>" height="25px" width="25px" align="absmiddle" class="imglink2"> Update Software
		     </a>
		     <?php
				}
			}

			if($_SESSION['tingkat_user']=='2')
			{
			?>
				<a href="#" onclick="window.location='?pg=nilaiku'">
				 <img src="<?=$menunilaiku;?>" height="25px" width="25px" align="absmiddle" class="imglink2"> Hasil Ujian
				</a>
				<?php
			}
				?>
		     <a href="#" onclick="window.location='?pg=chpass'">
		     	<img src="<?=$menupass;?>" height="25px" width="25px" align="absmiddle" class="imglink2"> Ganti password
		     </a>
		</div>
	</div>
	<div class="btnbio" onclick="window.location='pwww/logout.php'"><span class="textbio">Keluar</span></div>
</div>
