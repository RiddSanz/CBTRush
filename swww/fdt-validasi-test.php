<?php
if (isset($_SESSION['token']) || $_SESSION['enable_token']=='0') {
	if (isset($_SESSION['token']) || $_SESSION['enable_token'] =='0') {
		//echo "token disable 0";
		$doc = "swww/df-siswa.php";
	}	
}
else
{
	//echo "token enable = 1";
	$doc = "swww/validasi-siswa.php";
}

?>
	<script src="js/jquery.min.js"></script>
	<script>	
	$(document).ready(function(){
		$("#preview").fadeIn("slow");
		$("#preview").html('');
		$("#preview").html('<img src="images/spinner.gif" alt="Uploading...." width="10px"/>');
		$("#ReloadThis").load("<?php echo $doc;?>");
	 	setInterval(function() {
            $("#ReloadThis").load("<?php echo $doc;?>");
            $("#preview").html('<img src="images/success.png" alt="Uploading...." width="15px"/>');
            $("#preview").fadeOut(5000);			
        }, 30000);
	});
	</script>
<body>
<div id="ReloadThis"></div><div id='preview' class='ctime'></div>
</body>
