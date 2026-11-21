<?php
session_start();
session_destroy();   // forget the logged in student
header("Location: index.php");
exit;
