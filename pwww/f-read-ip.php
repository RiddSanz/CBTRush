<?php
if(!isset($_SESSION['user_nama']) && !isset($_SESSION['userid']))
{
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
else
{
	if($_SESSION['tingkat_user']=='0')
	{
		$file = fopen("ipconf.sh", "r") or exit("Unable to open file!");
		$ip = "";
		$netmask = "";
		$gw = "";
		$x = 1;
		while(!feof($file))
		{
			$br = fgets($file). "<br/>";
			if(!empty($br)){
				$lines = explode(" ", $br);
				$count = count($lines);
				/*print_r($lines);*/
				/*echo "$x";*/
				if($count>1){
					/*echo"Potong baris $count <br>";*/    		
					/*for ($i = 0; $i < $count; $i++) {
		       			echo $lines[$i]." ";				
		       		}*/
		       		/*echo("Line = ".$lines[2]);*/
		       		if ($x==2) {
		       			$ip = $lines[2];
		       			$netmask = $lines[4];
		       		}
		       		elseif ($x==3) {
		       			$gw = str_replace("<br/>", "", $lines[4]);
		       		}
		       		
		       		
		       	}
		       }
		       $x++;
		   }
		   fclose($file);
		   
		   ?>
		   <?php 
		   if (isset($_SESSION['trueValKey']) && $_SESSION['tingkat_user']=='0') 
		   {
		   	?>
		   	<script>
		   	$(document).ready(function(){
		   		$("#btnsave").click(function()
		   		{
		   			var ip=$("#ip").val();
		   			var netmask=$("#netmask").val();
		   			var gw=$("#gw").val();
		   			if ($.trim(ip).length>0 && $.trim(netmask).length>0) {
		   				$.ajax({
		   					type:'POST',
		   					url:'pwww/p-write-ip.php',
		   					data:'ajax=1&ip='+ip+'&netmask='+netmask+'&gw='+gw,
		   					success:function(data) {
		   						if(data==1){
		   							$("#error").html('setting ip berhasil!');
		   						}else{
		   							$("#error").html("<span style='color:#cc0000'>setting ip gagal!.</span> ");
		   						}							
		   					}
		   				});
		   			}
		   			
		   		});

		   	});
		   	</script>
		   	<ul class="topnav" id="myTopnav">
				<li><a href='#' onclick="window.location='?pg=ms'"><?=$site1;?></a></li>
				<li id='ratakanan'><a href='#' class='activek'><?=$site2;?></a></li>
			</ul>
		   	<div class="cpanel">
		   		<fieldset>
		   			<legend>Eth0</legend>		
		   			<form style="padding-left:20px;">
		   				<label>IP Address</label><br>
		   				<input name="ip" id="ip" value="<?=$ip;?>" type="text" class="input2 wd25">
		   				<label>Netmask</label><br>
		   				<input name="netmask" id="netmask" value="<?=$netmask;?>" type="text" class="input2 wd25">
		   				<label>Gateway</label><br>
		   				<input name="gw" id="gw" value="<?=$gw;?>" type="text" class="input2 wd25"> 
		   				<span style="float:left;color:red;font-style:italic;font-size:10px;">
		   					* isikan jika belum memliki gateway pada server anda (baik eth0 atau eth1).
		   				</span><br>
		   				<input type="button" value="Simpan konfigurasi" id="btnsave">
		   				<input type="button" value="Batal" class="tombol" onclick="window.location='?pg=ms'">
		   			</form>	
		   		</fieldset>	
		   		<br>
		   		<fieldset>
		   			<legend>Eth1 (Otomatis)</legend>		
		   			<?php 
		   			$url = "eth1.conf";
		   			$file = fopen("$url", "r");

		   			$data = "";
		   			while (!feof($file)) {
		   				$data .= fgets($file);
		   			}
		   			fclose($file);

		   			$interfaces = array();
		   			foreach (preg_split("/\n\n/", $data) as $int) {

		   				preg_match("/^([A-z]*\d)\s+Link\s+encap:([A-z]*)\s+HWaddr\s+([A-z0-9:]*).*" .
		   					"inet addr:([0-9.]+).*Bcast:([0-9.]+).*Mask:([0-9.]+).*" .
		   					"MTU:([0-9.]+).*Metric:([0-9.]+).*" .
		   					"RX packets:([0-9.]+).*errors:([0-9.]+).*dropped:([0-9.]+).*overruns:([0-9.]+).*frame:([0-9.]+).*" .
		   					"TX packets:([0-9.]+).*errors:([0-9.]+).*dropped:([0-9.]+).*overruns:([0-9.]+).*carrier:([0-9.]+).*" .
		   					"RX bytes:([0-9.]+).*\((.*)\).*TX bytes:([0-9.]+).*\((.*)\)" .
		   					"/ims", $int, $regex);

		   				if (!empty($regex)) {

		   					$interface = array();
		   					$interface['name'] = $regex[1];
		   					$interface['type'] = $regex[2];
		   					$interface['mac'] = $regex[3];
		   					$interface['ip'] = $regex[4];
		   					$interface['broadcast'] = $regex[5];
		   					$interface['netmask'] = $regex[6];
		   					$interface['mtu'] = $regex[7];
		   					$interface['metric'] = $regex[8];

		   					$interface['rx']['packets'] = (int) $regex[9];
		   					$interface['rx']['errors'] = (int) $regex[10];
		   					$interface['rx']['dropped'] = (int) $regex[11];
		   					$interface['rx']['overruns'] = (int) $regex[12];
		   					$interface['rx']['frame'] = (int) $regex[13];
		   					$interface['rx']['bytes'] = (int) $regex[19];
		   					$interface['rx']['hbytes'] = (int) $regex[20];

		   					$interface['tx']['packets'] = (int) $regex[14];
		   					$interface['tx']['errors'] = (int) $regex[15];
		   					$interface['tx']['dropped'] = (int) $regex[16];
		   					$interface['tx']['overruns'] = (int) $regex[17];
		   					$interface['tx']['carrier'] = (int) $regex[18];
		   					$interface['tx']['bytes'] = (int) $regex[21];
		   					$interface['tx']['hbytes'] = (int) $regex[22];

		   					$interfaces[] = $interface;
		   				}
		   			}
		   			/*print_r($interfaces);*/
		   			echo "Mac Address =>".$interface['mac']."<br>";
		   			echo "IP Address ==>".$interface['ip']."<br>";
		   			echo "Netmask ===>".$interface['netmask']."<br>";
		   			/*echo "Broadcast &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:".$interface['broadcast']."<br>";*/
		   			
		   			?>
		   		</fieldset>		
		   	</div>
		   	<div id="error"></div>
		   	<div class="spasi"></div>			
		   	<?php 
		   }
		   ?>		
		   <?php 
		}
		else
		{
			echo "<div class='nm-list-section'>SYSTEM PANEL CBT</div>";
			echo "<div class=cpanel><h3>MAAF ANDA TIDAK TERDAFTAR SEBAGAI ADMIN</h3>";
			echo "<div class='spasi'></div>";
		}
	}
	?>