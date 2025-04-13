<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once 'config.php';
require_once __DIR__ . '/controllers/CalcCtrl.class.php';

$ctrl = new CalcCtrl();
$ctrl->getParams();
$ctrl->process();
$ctrl->display();
?>
