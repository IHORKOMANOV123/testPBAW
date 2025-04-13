<?php
session_start();

require_once 'config.php';
require_once __DIR__ . '/controllers/LoginCtrl.class.php';

$ctrl = new LoginCtrl();
$ctrl->getParams();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ctrl->process(); // редирект в calc.php
}

$ctrl->display();
