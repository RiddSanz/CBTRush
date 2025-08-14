<?php
include "lib/configuration.php";
if(isset($_SESSION['jmlhal']))
{
	$jumlah_per_page=$_SESSION['jmlhal'];
}
else
{
	$jumlah_per_page=20;
}

if (isset($_GET["hal"])) { $hal  = $_GET["hal"]; } else { $hal=1; }; 
$start_from = ($hal-1) * $jumlah_per_page; 
if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
	$crdata = $_SESSION['fdata'];
	$sql = "select pengguna,nama_pengguna,kelompok,t_ip,t_host,t_mac,t_jam_log,browser_type,os_type,system_type from t_activity a,t_peserta b where a.t_who=b.pid and kelompok like '%$crdata%' union select pengguna,nama_pengguna,kelompok,t_ip,t_host,t_mac,t_jam_log,browser_type,os_type,system_type from t_activity a,t_peserta b where a.t_who=b.pid and pengguna like '%$crdata%' union select pengguna,nama_pengguna,kelompok,t_ip,t_host,t_mac,t_jam_log,browser_type,os_type,system_type from t_activity a,t_peserta b where a.t_who=b.pid and nama_pengguna like '%$crdata%' union select pengguna,nama_pengguna,kelompok,t_ip,t_host,t_mac,t_jam_log,browser_type,os_type,system_type from t_activity a,t_peserta b where a.t_who=b.pid and t_jam_log like '%$crdata%' order by t_jam_log desc LIMIT $start_from, $jumlah_per_page ";
}
else{
	$crdata = '';
	$sql = "select pengguna,nama_pengguna,kelompok,t_ip,t_host,t_mac,t_jam_log,browser_type,os_type,system_type from t_activity a,t_peserta b where a.t_who=b.pid order by t_jam_log desc LIMIT $start_from, $jumlah_per_page ";
}
/*$sql = "select * from t_activity where oleh='".$_SESSION['userid']."' order by t_jam_log desc
	LIMIT $start_from, $jumlah_per_page ";
	*/

$rs = mysqli_query($db,$sql);


?>
<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
?>

<script>
$(document).ready(function() {
	$('a.delete').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent();
		$.ajax({
			type: 'get',
			url: 'pwww/p-usersdelete.php',
			data: 'ajax=1&id=' + parent.attr('id').replace('record-',''),
			beforeSend: function() {
				parent.animate({'backgroundColor':'#fb6c6c'},300);
			},
			success: function(data) {
				
				if (data=='1') {
					$("body").load("index.php?pg=sysmon").hide().fadeIn(1500).delay(6000);
				}else {
					alert(data);
				}				
			}
		});
	});
	$("#setpage").click(function(){
			
			var jmlhal = $('#jmlhal').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-hal.php',
				data:'ajax=1&jmlhal='+jmlhal,
				success:function(data) {
					if(data){	
						$("body").load("index.php?pg=sysmon").hide().fadeIn(1500).delay(6000);
					}else{ 
						 
						alert(data);
					}
				}
			});
		});
	$("#findData").click(function(){
			
			var fdata = $('#fdata').val();
			$.ajax({
				type:'GET',
				url:'pwww/p-set-fdata.php',
				data:'ajax=1&fdata='+fdata,
				success:function(data) {
					if(data){
						$("body").load("index.php?pg=sysmon").hide().fadeIn(1500).delay(6000);						
					}else{ 
						
						alert(data);
					}
				}
			});
		});
	$("#clearData").click(function(){
			
			$.ajax({
				type:'GET',
				url:'pwww/p-set-cfdata.php',
				data:'ajax=1',
				success:function(data) {
					if(data){
						window.location="?pg=sysmon";
					}else{ 
						
						alert(data);
					}
				}
			});
		});
});
</script>
<div class="cpanel">
	<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=ms'"><?=$site1;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
	</ul>
	<div class='spasi'></div>
	<div class='findp'>
		<input type='text' value='<?=$crdata;?>' id='fdata' class='style-1 wd50' placeholder='Filter data'>
		<input type='button' value='Pencarian data' id='findData'>
		<input type='button' value='Clear' id='clearData'>
	</div>	
	<table width="100%">
		<tr style='background:#ebebe0;color:#000;'>
			<th width="5%">
				<center>NO</center>
			</th>
			<th width="10%">
				UID
			</th>
			<th width="30%">
				NAMA PENGGUNA
			</th>
			<th width="10%">
				KELOMPOK
			</th>
			<th width="15%">
				BROWSER
			</th>
			<th width="15%">
				TANGGAL
			</th>
		</tr>
		<?php 
		$x=$start_from+1;$warna = "#f5f5f0";
		while($br = mysqli_fetch_array($rs,MYSQLI_ASSOC))
		{$warna = ($warna == '#fff' ? "#f5f5f0" : "#fff");
		?>
		<tr bgcolor="<? echo($warna);?>" >
			<td class="isi">
				<center><?=$x;?></center>
			</td>
			<td>
				<?=$br['pengguna'];?>
			</td>
			<td>
				<?=strtoupper($br['nama_pengguna']);?>
			</td>
			<td>
				<?=strtoupper($br['kelompok']);?>
			</td>
			<td>
				<?=$br['browser_type'];?>
			</td>
			<td>
				<?=$br['t_jam_log'];?>
			</td>
		</tr>
		<?php 
		$x++;
		}
		?>
	</table>
</div>
<?php
if(isset($_SESSION['fdata']) && $_SESSION['fdata']!='') {
	$crdata = $_SESSION['fdata'];
	$sql = "select pengguna,nama_pengguna,kelompok,t_ip,t_host,t_mac,t_jam_log,browser_type,os_type,system_type from t_activity a,t_peserta b where a.t_who=b.pid and kelompok like '%$crdata%' union select pengguna,nama_pengguna,kelompok,t_ip,t_host,t_mac,t_jam_log,browser_type,os_type,system_type from t_activity a,t_peserta b where a.t_who=b.pid and pengguna like '%$crdata%' union select pengguna,nama_pengguna,kelompok,t_ip,t_host,t_mac,t_jam_log,browser_type,os_type,system_type from t_activity a,t_peserta b where a.t_who=b.pid and nama_pengguna like '%$crdata%' union select pengguna,nama_pengguna,kelompok,t_ip,t_host,t_mac,t_jam_log,browser_type,os_type,system_type from t_activity a,t_peserta b where a.t_who=b.pid and t_jam_log like '%$crdata%' order by t_jam_log desc";
}
else{
	$crdata = '';
	$sql = "select pengguna,nama_pengguna,kelompok,t_ip,t_host,t_mac,t_jam_log,browser_type,os_type,system_type from t_activity a,t_peserta b where a.t_who=b.pid order by t_jam_log desc";
}
/*	if(isset($_SESSION['fdata'])) {
		$crdata = $_SESSION['fdata'];
		$sql = "select * from t_activity a where a.oleh='".$_SESSION['userid']."' and a.kelompok like '%$crdata%' 
		union select * from t_activity b where b.oleh='".$_SESSION['userid']."' and b.nama_pengguna like '%$crdata%' 
		order by t_jam_log desc";
	}
	else{
		$sql = "select * from t_activity where oleh='".$_SESSION['userid']."' order by t_jam_log desc ";
	}
*/
	$rs = mysqli_query($db,$sql); 
	$total_records = mysqli_num_rows($rs);  
	$total_pages = ceil($total_records / $jumlah_per_page);

	echo "<div class='setpage'>Tampilkan <input type='text' value='$jumlah_per_page' id='jmlhal' class='input2 wd1' maxlength='3'>
	<input type=button value='Set Halaman' id='setpage'>
	</div>";
	
	echo "<a href='?pg=sysmon&hal=1' class='lpg'>".'|<'."</a> "; 

	if ($hal<10) {
		$aj = 1;
		if ($total_pages<=10) {
			$aki = $total_pages;
		}
		else
		{
			$aki = 10;
		}
		
	}
	else
	{
				
		if ($total_pages<($hal+9)) {
			$aj = $hal - 5;
			$aki = $hal + ($total_pages-$hal);
			/*echo $total_pages;
			echo ($hal+10);*/
		}
		else
		{
			$aj = $hal-5;
			$aki = $hal + 5;
			/*echo $aj;
			echo $aki;*/
		}
		

	}
	
	for ($i=$aj; $i<=$aki; $i++) { 
		if($hal==$i)
		{
			$rgb = 'lpgw';
		}
		else
		{
			$rgb = 'lpg';
		}
		echo "<a href='?pg=sysmon&hal=".$i."' class='$rgb'>".$i."</a> "; 
	}; 
	if ($total_pages<($hal+10)) {
		echo "";
	}
	else
	{
		echo "......";
		echo "<a href='?pg=sysmon&hal=".$total_pages."' class='$rgb'>".$total_pages."</a> ";
	}
	
	echo "<a href='?pg=sysmon&hal=$total_pages' class='lpg'>".'>|'."</a> "; 	
	echo "<div class='spasi'></div><div class='spasi'></div>";
}
mysqli_close($db);
?>