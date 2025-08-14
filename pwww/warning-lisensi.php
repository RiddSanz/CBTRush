<script type="text/javascript">
  $(document).ready(function(){
    $('a.close').click(function(eve){

      eve.preventDefault();
      $(this).parents('div.popup').fadeOut('slow');
    });
  });
</script>
<?php
if (!isset($_SESSION['tingkat_user'])) {
  include "pwww/date-expired.php";

  $valid=false;
  //echo ($date2-$date1);
  if($date1 >= $date2)
  {
       $valid = true;
  $_SESSION['valid']=true;
  }
  else
  {
       $valid = false;
  $_SESSION['valid']=false;
  }

  if ($valid==true) {
    if ($counterlisensi === false) {      
  ?>
  <div class="popup">
    <div id="modal">
        <a class="close" href="#">&nbsp;x&nbsp;</a>
        <div class="wmodal">
          <div><img src="images/cbtrush.jpg" class='img-modal' width='80px'></div>
          <h5>MASA TRIAL ANDA AKAN BERAKHIR<br></h5>
          <h3>SILAHKAN MELAKUKAN<br>UPGRADE SOFTWARE DAN LISENSI</h3><br>
          <h4>BATAS AKHIR 1 JANUARI 2017</h4><br>
      </div>
    </div>
  </div>
  <?php
    }
  }
  if($valid==false)
  {
  ?>
  <div class="popup">
        <div id="modal">
            <a class="close" href="#">&nbsp;x&nbsp;</a>
            <div class="wmodal">
                <div><img src="images/cbtrush.jpg" class='img-modal' width='80px'></div>
                <h5>MASA TRIAL ANDA TELAH BERAKHIR<br></h5>
                <h3>SILAHKAN MELAKUKAN<br>UPGRADE SOFTWARE DAN LISENSI</h3><br>
                <h4>TERIMA KASIH</h4><br>
            </div>
        </div>
    </div>

  <?php
  }

}
?>
