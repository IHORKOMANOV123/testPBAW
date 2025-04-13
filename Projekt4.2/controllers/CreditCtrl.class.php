<?php
namespace app\controllers;

// Autoloader handles Models

class CreditCtrl {

	private $messages;
	private $form;
	private $result;

	public function __construct(){
		$this->messages = new \app\models\Messages();
		$this->form = new \app\models\CreditForm();
		$this->result = new \app\models\CreditResult();
	}

	public function getParams(){
		$this->form->amount = isset($_REQUEST ['amount']) ? $_REQUEST ['amount'] : null;
		$this->form->years = isset($_REQUEST ['years']) ? $_REQUEST ['years'] : null;
		$this->form->interestRate = isset($_REQUEST ['interestRate']) ? $_REQUEST ['interestRate'] : null;
	}

	public function validate() {
		if (! (isset($this->form->amount) && isset($this->form->years) && isset($this->form->interestRate))) {
			return false; // Initial view, no validation needed
		}

		if ($this->form->amount == "") { $this->messages->addError('Nie podano kwoty kredytu'); }
		if ($this->form->years == "") { $this->messages->addError('Nie podano liczby lat'); }
        if ($this->form->interestRate == "") { $this->messages->addError('Nie podano oprocentowania'); }

		if (! $this->messages->isError()) {
			if (! is_numeric($this->form->amount) || $this->form->amount <= 0) {
				$this->messages->addError('Kwota kredytu musi być liczbą dodatnią');
			}
			if (! is_numeric($this->form->years) || $this->form->years <= 0 || !ctype_digit($this->form->years)) {
				$this->messages->addError('Liczba lat musi być liczbą całkowitą dodatnią');
			}
            if (! is_numeric($this->form->interestRate) || $this->form->interestRate < 0) {
				$this->messages->addError('Oprocentowanie musi być liczbą nieujemną');
			}
		}
		return ! $this->messages->isError();
	}

	public function process(){
		$this->getParams();

		if ($this->validate()) {
			$this->form->amount = floatval($this->form->amount);
			$this->form->years = intval($this->form->years);
			$this->form->interestRate = floatval($this->form->interestRate);

			$monthlyInterestRate = ($this->form->interestRate / 100) / 12;
			$numberOfMonths = $this->form->years * 12;

            if ($monthlyInterestRate == 0) {
                if ($numberOfMonths > 0) {
                    $this->result->monthlyPayment = $this->form->amount / $numberOfMonths;
                } else {
                    $this->result->monthlyPayment = 0; // Or handle as error
                }
            } else {
			    $this->result->monthlyPayment = $this->form->amount * $monthlyInterestRate * pow(1 + $monthlyInterestRate, $numberOfMonths) / (pow(1 + $monthlyInterestRate, $numberOfMonths) - 1);
            }

            $this->result->totalAmount = $this->result->monthlyPayment * $numberOfMonths;
            $this->result->monthlyPayment = round($this->result->monthlyPayment, 2);
            $this->result->totalAmount = round($this->result->totalAmount, 2);

			$this->messages->addInfo('Obliczenia wykonane poprawnie.');
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
		$smarty->assign('page_title','Kalkulator Kredytowy');
		$smarty->assign('page_description','Obliczanie miesięcznej raty kredytu');
		$smarty->assign('page_header','Kalkulator Kredytowy');
		$smarty->assign('messages',$this->messages);
		$smarty->assign('form',$this->form);
		$smarty->assign('result',$this->result);

		// Display the template using filename relative to template_dir
		$smarty->display('credit_calc.tpl'); // <-- CORRECTED: Relative path
	}
}
