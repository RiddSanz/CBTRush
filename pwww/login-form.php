<script src="js/jquery-google.min.js"></script>
<script>
window.onload = function(){
	$("#login").click(function()
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
						$("body").load("index.php").hide().fadeIn(1500).delay(6000);
						location.reload();
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
<script type="text/javascript">
function fullScreen(theURL) {
	window.open(theURL,'','resizable=yes, status=no, toolbar=no, scrollbars= yes, location=no, menubar=no, height='+screen.height+', width='+screen.width ,'fullscreen=yes');
}
function openFullscreen(page) {
var yes = 1;
var no = 0;
var menubar = no; // The File, Edit, View Menus
var scrollbars = no; // Horizontal and vertical scrollbars
var locationbar = no; // The location box with the site URL
var directories = no; // the "What's New", "What Cool" links
var resizable = no; // Can the window be resized?
var statusbar = no; // Status bar (with "Document: Done")
var toolbar = no; // Back, Forward, Home, Stop toolbar
if (navigator.appName == "Microsoft Internet Explorer"){ // better be ie6 at least
windowprops = "width=" + (screen.width-10) + ",height=" + (screen.height-30) + ",top=0,left=0";
}
else { // i.e. if Firefox
windowprops = "width=" + (screen.width-5) + ",height=" + (screen.height-30) + ",top=0,left=0";
}
windowprops += (menubar ? ",menubars" : "") +
(scrollbars ? ",scrollbars" : "") +
(locationbar ? ",location" : "") +
(directories ? ",directories" : "") +
(resizable ? ",resizable" : "") +
(statusbar ? ",status" : "") +
(toolbar ? ",toolbar" : "");
window.open(page, 'fullPopup', windowprops);
window.opener = top; // this will close opener in ie only (not Firefox)
window.close();
}
//
</script>
<div id="box" class="clogin">
	<form method="POST">
		<input type="text" name="username" id="username" placeholder="Username" class="loginInput">
		<input type="password" name="password" id="password" placeholder="Password" class="s-login">
		<div class="eyeshow showHide">&nbsp;</div>		
		<input name="user_code" id="user_code" type="text" size="7" maxlength="7" class="input3"  placeholder="kode captcha">
		<img src="pwww/captcha.php" alt="Visual Captcha" align="absmiddle" class="imgcpt"><br>
		<input type="submit" value="Login CBT" id="login">
	</form>				
	<div id="error"></div>
</div>