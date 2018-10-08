<?php
if (!isset($_SESSION)) {
    session_start();
  }
include_once("config.php");
include_once("functions.php");
func::deleteCookie();
print_r(error_get_last());
echo'<script language="javascript">window.location="login.php"</script>';
?>
