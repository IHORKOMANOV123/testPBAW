<?php
namespace app\controllers;

// Autoloader handles Models

class CalcCtrl {

	private $messages;
	private $form;
	private $result;

	public function __construct(){
		$this->messages = new \app\models\Messages();
		$this->form = new \app\models\CalcForm();
		$this->result = new \app\models\CalcResult();
	}

	public function getParams(){
		$this->form->x = isset($_REQUEST ['x']) ? $_REQUEST ['x'] : null;
		$this->form->y = isset($_REQUEST ['y']) ? $_REQUEST ['y'] : null;
		$this->form->op = isset($_REQUEST ['op']) ? $_REQUEST ['op'] : null;
	}

	public function validate() {
		if (! (isset($this->form->x) && isset($this->form->y) && isset($this->form->op))) {
			return false; // Initial view, no validation needed
		}

		if ($this->form->x == "") { $this->messages->addError('Nie podano liczby 1'); }
		if ($this->form->y == "") { $this->messages->addError('Nie podano liczby 2'); }
        if ($this->form->op == "") { $this->messages->addError('Nie wybrano operacji'); }

		if (!$this->messages->isError()) {
			if (! is_numeric($this->form->x)) { $this->messages->addError('Pierwsza wartość nie jest liczbą'); }
			if (! is_numeric($this->form->y)) { $this->messages->addError('Druga wartość nie jest liczbą'); }

            $valid_ops = ['plus', 'minus', 'times', 'div'];
            if (!in_array($this->form->op, $valid_ops)) {
                 $this->messages->addError('Nieprawidłowa operacja');
            }

            if ($this->form->op == 'div' && $this->form->y == 0) {
                $this->messages->addError('Nie można dzielić przez zero');
            }
		}
		return !$this->messages->isError();
	}

	public function process(){
		$this->getParams();

		if ($this->validate()) {
			$this->form->x = floatval($this->form->x);
			$this->form->y = floatval($this->form->y);
			$this->messages->addInfo('Parametry poprawne.');

			switch ($this->form->op) {
				case 'plus':  $this->result->result = $this->form->x + $this->form->y; $this->result->op_name = '+'; break;
				case 'minus': $this->result->result = $this->form->x - $this->form->y; $this->result->op_name = '-'; break;
				case 'times': $this->result->result = $this->form->x * $this->form->y; $this->result->op_name = '*'; break;
				case 'div':   $this->result->result = $this->form->x / $this->form->y; $this->result->op_name = '/'; break;
			}
			$this->messages->addInfo('Wykonano obliczenia.');
		}
		$this->generateView();
	}

	public function generateView(){
		global $conf;
		$smarty = new \Smarty();

        // Configure Smarty directories
        $smarty->template_dir = $conf->smarty_template_dir;
        $smarty->compile_dir  = $conf->smarty_compile_dir;
        $smarty->cache_dir    = $conf->smarty_cache_dir;

        // Assign variables
		$smarty->assign('conf',$conf);
		$smarty->assign('page_title','Kalkulator Zwykły');
		$smarty->assign('page_description','Proste operacje arytmetyczne.');
		$smarty->assign('page_header','Kalkulator');
		$smarty->assign('messages',$this->messages);
		$smarty->assign('form',$this->form);
		$smarty->assign('result',$this->result);

        // Display the template using filename relative to template_dir
		$smarty->display('calc.tpl'); // <-- CORRECTED: Relative path
	}
}
