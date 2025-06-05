<?php
session_start();
session_unset();
session_destroy();
header("Location: portfolio.html");  // Change this to your main HTML page filename
exit();
?>
