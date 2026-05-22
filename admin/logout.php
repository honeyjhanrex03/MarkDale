<?php
session_start();
unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_username']);
$_SESSION['logout_success'] = true;
header('Location: login.php');
exit;
?>
