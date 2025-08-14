<script type="text/javascript">
function showValue(testval)
{
	/*alert(testval);
	here in parent page you call any other function as per your need.*/
	$.ajax({
		type:'GET',
		url:'swww/p-setnomor.php',
		data:'ajax=1&nomorid='+testval,
		success:function(data) {
			if(data) {
				location.reload();
			} else {
				alert(data);
			}
		}
	});
}
</script>
<div id="pnote" style="color:#808080; background:#ffffff;">
	<ul class="topnav" id="myTopnav" style="margin-bottom:10px;margin-top:-10px;">
		<li style="text-align: right;float:right;"><a href='#' class="activek">Navigasi Soal</a></li>
	</ul>
	<iframe id='ifsoal' class="kotaksoal" src="swww/nomor-siswa.php" width="98%"></iframe>
</div>
<div class='spasi'></div>
