<?php
$doc = "swww/iframe-nomor.php";
?>

	<script>	
	$(document).ready(function(){
		$("#lihat").fadeIn("slow");
		$("#lihat").html('');
		$("#lihat").html('<img src="images/spinner.gif" alt="Uploading...." width="10px"/>');
		$("#akses").load("<?php echo $doc;?>");
	 	setInterval(function() {
            $("#akses").load("<?php echo $doc;?>");
            $("#lihat").html('<img src="images/success.png" alt="Uploading...." width="15px"/>');
            $("#lihat").fadeOut(2000);			
        }, 60000);
	});
	</script>
<body>
<div id="akses"></div><div id='lihat' class='ctime'></div>
</body>
