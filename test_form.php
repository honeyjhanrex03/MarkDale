<?php
session_start();
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['name'] = 'Test';
$_POST['email'] = 'test@example.com';
$_POST['subject'] = 'Test Subject';
$_POST['message'] = 'This is a test message.';
require 'contact.php';
var_dump($_SESSION);
