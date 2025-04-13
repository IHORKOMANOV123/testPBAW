<?php
namespace app\controllers;

// Autoloader handles Messages model

class LoginCtrl {

    private $messages;

    public function __construct(){
        $this->messages = new \app\models\Messages(); // Use FQCN
    }

    // Method to check if user is logged in
    public function checkLogin() {
        return isset($_SESSION['user_role']);
    }

    public function doLogin(){
        global $conf;

        $login = isset($_REQUEST['login']) ? trim($_REQUEST['login']) : '';
        $pass = isset($_REQUEST['pass']) ? trim($_REQUEST['pass']) : '';

        if ($login == "") { $this->messages->addError('Nie podano loginu'); }
        if ($pass == "") { $this->messages->addError('Nie podano hasła'); }

        if (!$this->messages->isError()) {
            // --- Replace with database check ---
            if ($login == "admin" && $pass == "admin") {
                session_regenerate_id();
                $_SESSION['user_login'] = 'admin';
                $_SESSION['user_role'] = 'admin';
                header("Location: ".$conf->action_url."creditShow"); // Redirect to credit calc on success
                exit();
            } else if ($login == "user" && $pass == "user") {
                session_regenerate_id();
                $_SESSION['user_login'] = 'user';
                $_SESSION['user_role'] = 'user';
                header("Location: ".$conf->action_url."creditShow"); // Redirect to credit calc on success
                exit();
            } else {
                $this->messages->addError('Niepoprawny login lub hasło');
            }
            // --- End credential check ---
        }

        // If login failed, show the login view again with errors
        $this->generateView();
    }

    public function doLogout(){
        global $conf;

        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();

        header("Location: ".$conf->action_url."login"); // Redirect to login page
        exit();
    }

    /**
     * Generates the login form view.
     */
    public function generateView(){
        global $conf;

        $smarty = new \Smarty(); // Smarty class is available

        // Configure Smarty directories (important!)
        $smarty->template_dir = $conf->smarty_template_dir;
        $smarty->compile_dir  = $conf->smarty_compile_dir;
        $smarty->cache_dir    = $conf->smarty_cache_dir;

        // Assign variables
        $smarty->assign('conf',$conf);
        $smarty->assign('page_title','Logowanie');
        $smarty->assign('page_header','Logowanie do systemu');
        $smarty->assign('messages',$this->messages);

        // Display the template using filename relative to template_dir
        $smarty->display('login.tpl'); // <-- CORRECTED: Relative path
    }
}
