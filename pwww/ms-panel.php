<?php
$_SESSION['fdata']='';
$_SESSION['fdata2']='';
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if((isset($_SESSION['sid_user']) && $_SESSION['sid_user']!="") || $_SESSION['tingkat_user']!='2')
	{
?>
	<script>
		$(document).ready(function(){
			
			$("#btnRestart").click(function()
			{
				$.ajax({
						type:'GET',
						url:'pwww/p-restart.php',
						data:'action=restart',
						success:function(data) {
							if(data==1){
								//$("#warning").html('system restart dijalankan, tunggu hingga komputer selesai restart!');
								$("#warning").html('system restart dijalankan! tunggu <span id="count">120</span> detik');
								//window.setTimeout( show_popup, 90000 );
								var counter=120;
								window.setInterval(
									function() {
									    counter--;
									    if (counter >= 0) {
									      span = document.getElementById("count");
									      span.innerHTML = counter;
									    }
									    // Display 'counter' wherever you want to display it.
									    if (counter === 0) {
									        //alert('this is where it happens');
									        clearInterval(counter);
									        show_popup();
									    }

									  }, 1000);
							}else{
								$("#warning").html(data);
							}							
						}
					});				
			});		
			$("#btnMatikan").click(function()
			{
				$.ajax({
						type:'GET',
						url:'pwww/p-shutdown.php',
						data:'action=shutdown',
						success:function(data) {
							if(data==1){
								//$("#warning").html('system shutdown dijalankan, tunggu hingga komputer dimatikan!');
								$("#warning").html('system shutdown dijalankan! tunggu <span id="count">120</span> detik');
								//window.setTimeout( show_popup, 90000 );
								var counter=120;
								window.setInterval(
									function() {
									    counter--;
									    if (counter >= 0) {
									      span = document.getElementById("count");
									      span.innerHTML = counter;
									    }
									    // Display 'counter' wherever you want to display it.
									    if (counter === 0) {
									        //alert('this is where it happens');
									        clearInterval(counter);
									        show_popup();
									    }

									  }, 1000);
							}else{
								$("#warning").html("<span style='color:#cc0000'>matikan gagal!.</span> ");
							}							
						}
					});				
			});
			$("#btnMonitor").click(function()
			{
				window.location = "?pg=sysmon";				
			});

			function show_popup(){
      			window.location='?pg=ms';
   			};
		});
	</script>
	<ul class="topnav" id="myTopnav">
		<li><a href='#' onclick="window.location='?pg=ms'"><?=$site1;?></a></li>
		<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
	</ul>
	<?php 
		if (isset($_SESSION['trueValKey']) && $_SESSION['tingkat_user']=='0') {			
		?>
	<div class="cpanel">
		<h3>KONFIGURASI JARINGAN & DATABASE</h3>		
		<div class="cpanelMenu" onclick="window.location='?pg=setip'">
			<img src="images/setip2.png" height="100" width="100" class="imglink"/> 
			<center>IP ADDRESS</center>
		</div>
		<div class="cpanelMenu" onclick="window.location='?pg=dbR'">
			<img src="images/dbservernew.png" height="100" width="100" class="imglink"/> 
			<center>RESET DATABASE</center>
		</div>	
		<div class="cpanelMenu" onclick="window.location='?pg=setTM'">
			<img src="images/clock_yellow.png" height="100" width="100" class="imglink"/> 
			<center>SET TIME</center>
		</div>				
	</div>
	<div class="cpanel">
		<div class="spasi"></div>
	</div>
	<div class="cpanel">
		<h3>SYSTEM PANEL</h3>
		<div class="cpanelMenu" id="btnRestart">
			<img src="images/reboot.png" height="100" width="100" class="imglink"/> 
			<center>RESTART SYSTEM</center>
		</div>
		<div class="cpanelMenu" id="btnMatikan">
			<img src="images/2c_shutdown.png" height="100" width="100" class="imglink"/> 
			<center>MATIKAN SYSTEM</center>
		</div>
		<div class="cpanelMenu" id="btnMonitor">
			<img src="images/activity_monitor.png" height="100" width="100" class="imglink"/> 
			<center>SYSTEM MONITOR</center>
		</div>		
	</div>	
	<?php 
		}
		require_once "pwww/p_enc.php";if(enc($_SESSION['trueValKey'])!=($_SESSION['sid_user'].$_SESSION['namaSEKOLAH'])) {include "pwww/logout.php";}
	?>	
	<div class="cpanel">
		<div class="spasi"></div>		
		<div class="spasi"></div>
		<div id="warning"></div>
		<div class="spasi"></div>
	</div>	
<?php 
	}
	else
	{
		echo "<div class='nm-list-section'>SYSTEM PANEL CBT</div>";
		echo "<div class=cpanel><h3>MAAF ANDA TIDAK TERDAFTAR SEBAGAI ADMIN</h3>";
	}
}
?>