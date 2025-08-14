<?php
session_start();
ini_set("display_errors", "off");
include "pwww/validasi-sekolah.php";
include "pwww/get-browser.php";
include "pwww/version.php";
if (!isset($_SESSION['ipku'])) {
	include "pwww/check-ip.php";
	$_SESSION['ipku'] = $lip;
	$_SESSION['host'] = $lhip;
	$_SESSION['mac'] = $lmac;
}
$ua=getBrowser();

if (!isset($_SESSION['browser']) || $_SESSION['browser']=='' || $_SESSION['os']=='' || $_SESSION['system']=='') {
	$_SESSION['browser'] = $ua['name'];
	$_SESSION['os'] = $ua['platform'];
	$_SESSION['system'] = $ua['userAgent'];

}
?>

<link rel="stylesheet" href="css-login.css">
<link rel="icon" type="image/png" href="logo/cbtIcon.png" />
<title>CBT - <?=$sekNm;?></title>
<script src="js/jquery-google.min.js"></script>
<script>
window.onload = function(){
	$("#loginnya").click(function()
	{
		var username=$("#username").val();
		var password=$("#password").val();
		var kode=$("#user_code").val();
		var dataString = 'username='+username+'&password='+password+'&user_code='+kode;
		if($.trim(username).length>0 && $.trim(password).length>0)
		{
			$.ajax({
				type: "POST",
				url: "pwww/p-ajax-ijin-masuk.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#login").val('Connecting...');},
				success: function(data){
					if(data=="1")
					{

						//window.fullScreen('index.php');
						//window.openFullscreen('index.php');
						//open(location, '_self').close();
						$("body").load("login.php").hide().fadeIn(1500).delay(6000);
						//location.reload();
						window.location.href = "index.php";
					}
					else if(data=="2")
					{

						$("#login").val('Login');
						$("#error").html("<span style='color:#cc0000'>Error: Invalid username and password.</span> ");
						$("#error").hide().fadeIn(1500).delay(6000);

					}
					else if(data=="3")
					{

						$("#login").val('Login');
						$("#error").html("<span style='color:#cc0000'>Error: Key belum diisi.</span> ");
						$("#error").hide().fadeIn(1500).delay(6000);

					}
					else if(data=="4")
					{

						$("#login").val('Login');
						$("#error").html("<span style='color:#cc0000'>Error: Key tidak sama.</span> ");
						$("#error").hide().fadeIn(1500).delay(6000);

					}
					else if(data=="5")
					{

						$("#login").val('Login');
						$("#error").html("<span style='color:#cc0000'>Anda tidak memiliki test.</span> ");
						$("#error").hide().fadeIn(1500).delay(6000);

					}
					else if(data=="6")
					{

						$("#login").val('Login');
						$("#error").html("<span style='color:#cc0000'>Kondisi masih login, hubungi admin!.</span> ");
						$("#error").hide().fadeIn(1500).delay(6000);

					}
					else if(data=="7")
					{
						$("#login").val('Login');
						$("#error").html("<span style='color:#cc0000'>Anda tidak memiliki hak akses, hubungi admin!.</span> ");
						$("#error").hide().fadeIn(1500).delay(6000);

					}
					else if(data=="8")
					{
						$("#login").val('Login');
						$("#error").html("<span style='color:#cc0000'>Data anda telah terkunci, hubungi admin!.</span> ");
						$("#error").hide().fadeIn(1500).delay(6000);

					}
					//alert(data);
				}
			});

		}
		return false;
	});

	$(".showHide").click(function() {
	    if ($("#password").attr("type") == "password") {
	      $("#password").attr("type", "text");

	    } else {
	      $("#password").attr("type", "password");
	    }
	  });
}
</script>
<style>
.eyeshow {
	float: left;
	vertical-align: middle;
	padding: 0;
	margin-left: -28px;
	padding-top: 4px;
	background-image: url(images/visible.png);
	background-size: 20px 20px;
	background-repeat: no-repeat;
	width: 22px;
	height: 20px;
	opacity: 0.4;
}
.eyeshow:hover {
	cursor: pointer;
	opacity: 0.8;
}
</style>
<?php
$qdes = "select * from t_ujian Limit 1";
$rsdes = mysqli_query($db,$qdes);
$brdes = mysqli_fetch_array($rsdes,MYSQLI_ASSOC);
$des = $brdes['desain'];

if($des=='2')
{

?>
<div class="login-wrap">
		<div class="login">
			<div class="avatar">
			</div>
      <span class="user"><?=$sekNm;?></span>
			<form id="login" class="login-form"  method="POST">
        <input type="text" name="username" id="username" placeholder="Username" class="pass"/>
				<input type="password" name="password" id="password" placeholder="Password" class="pass"/>
				<div class="eyeshow showHide" style="float:right;margin-top:-50px;padding:3px;">&nbsp;</div>
        <input type="text" name="user_code" id="user_code" class="cap"  placeholder="kode captcha">
        <img src="pwww/captcha.php" alt="Visual Captcha" align="absmiddle" class="cap2"><br/>
    		<input type="submit" value="Login CBT" id="loginnya" class="tombol">
			</form>
			<div id="error"></div>
		</div>
	</div>
<?php
include "pwww/warning-lisensi.php";
}
else{
echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}

?>
