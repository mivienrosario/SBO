<?php
  session_start();
  require 'inc/db.inc.php';

    if (isset($_SESSION['logged_in']) != TRUE) {
      header("Location: login.php?error=invader");
      exit();
    }
?>

<!-- Top container -->
<div class="w3-bar w3-top w3-blue w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right">CIT - SBO</span>
</div> <!-- Top container -->
