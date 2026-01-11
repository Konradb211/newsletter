<?php
session_start();

unset($_SESSION['logged_in']);

header('Location: admin.php');
exit();
