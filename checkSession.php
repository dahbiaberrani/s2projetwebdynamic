<?php
session_start();

 echo  $_SESSION["user"];
 echo "<br>";
 echo session_id();
?>