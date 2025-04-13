<?php
require_once dirname(__FILE__).'/app/core/init.php'; // Use init.php

// Action and Role definitions remain the same...
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'default_action';
$action_roles = [ /* ... */ ];
$required_role = isset($action_roles[$action]) ? $action_roles[$action] : ['admin'];

// Role check remains the same...
if (!checkRole($required_role)) {
    // Instantiate LoginCtrl using FQCN if access denied
    // remove include_once $conf->root_path.'/controllers/LoginCtrl.class.php';
    $ctrl = new \app\controllers\LoginCtrl(); // Use FQCN
    $ctrl->generateView();
    exit();
}

// --- Role check passed, proceed with routing ---

// Remove include_once lines from switch cases and use FQCN
switch ($action) {
	case 'login':
		// include_once $conf->root_path.'/controllers/LoginCtrl.class.php'; // REMOVE
		$ctrl = new \app\controllers\LoginCtrl(); // Use FQCN
		$ctrl->generateView();
	break;
    case 'doLogin':
		// include_once $conf->root_path.'/controllers/LoginCtrl.class.php'; // REMOVE
		$ctrl = new \app\controllers\LoginCtrl(); // Use FQCN
		$ctrl->doLogin();
	break;
	case 'calcShow':
		// include_once $conf->root_path.'/controllers/CalcCtrl.class.php'; // REMOVE
		$ctrl = new \app\controllers\CalcCtrl(); // Use FQCN
		$ctrl->generateView();
	break;
	case 'calcCompute':
		// include_once $conf->root_path.'/controllers/CalcCtrl.class.php'; // REMOVE
		$ctrl = new \app\controllers\CalcCtrl(); // Use FQCN
		$ctrl->process();
	break;
	case 'creditShow':
		// include_once $conf->root_path.'/controllers/CreditCtrl.class.php'; // REMOVE
		$ctrl = new \app\controllers\CreditCtrl(); // Use FQCN
		$ctrl->generateView();
	break;
	case 'creditCompute':
		// include_once $conf->root_path.'/controllers/CreditCtrl.class.php'; // REMOVE
		$ctrl = new \app\controllers\CreditCtrl(); // Use FQCN
		$ctrl->process();
	break;
	case 'logout':
		// include_once $conf->root_path.'/controllers/LoginCtrl.class.php'; // REMOVE
		$ctrl = new \app\controllers\LoginCtrl(); // Use FQCN
		$ctrl->doLogout();
	break;
	case 'default_action':
	default:
        // Default redirection logic remains the same...
		if (checkRole(['user', 'admin'])){
            header("Location: ".$conf->action_url."creditShow");
            exit();
		} else {
            header("Location: ".$conf->action_url."login");
            exit();
		}
	break;
}
