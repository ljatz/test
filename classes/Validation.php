<?php

class Validation
{
	private $_passed = false;
	private $_errors = array();
	private $_db = null;
	
	public function __construct()
	{
		$this->_db = DB::getInstance();
	}
	
	public function check($items = array())
	{
		foreach($items as $field => $rules){
			foreach($rules as $rule => $rule_value){
				
				$value = trim(Input::get($field));
				
				if($rule === 'required' && empty($value)) {
					$this->addError($field, "This field must be filled!");
				} else if(!empty($value)) {
					switch($rule) {
						case 'min':
							if(strlen($value) < $rule_value)
								$this->addError($field, "Field {$field} must have at least {$rule_value} characters.");
						break;
						case 'max':
							if(strlen($value) > $rule_value)
								$this->addError($field, "Field {$field} can have the most {$rule_value} characters.");
						break;
						case 'matches':
							if($value != Input::get($rule_value))
								$this->addError($field, "Field {$field} must match with password field.");
						break;
						case 'unique':
							$check = $this->_db->get('id',$rule_value,array($field,'=',$value));
							if($check->count())
								$this->addError($field, "{$field} already exists.");
						break;
						case 'number':
							if(!preg_match('/\d/', $value)) {
									$this->addError($field, "Field {$field} accept only numbers!");
								}
						break;
						case 'lost':
							$lost = $this->_db->lost($value, 'users')->count();
							if($lost != $rule_value)
								$this->addError($field, "Try again!");
						break;
						case 'price':
							if(preg_match('/,/', $value)) {
								$this->addError($field, 'If number is not round use dot instead comma!');
							}
						break;
					}
				}
			}	
		}
		
		if(empty($this->_errors)) {
			$this->_passed = true;
		}
		
		return $this;
		
	}
	
	public function addError($field, $error)
	{
		$this->_errors[$field] = $error;
	}
	
	public function passed()
	{
		return $this->_passed;
	}
	
	public function errors()
	{
		return $this->_errors;
	}
	
	public function hasError($field)
	{
		if(isset($this->_errors[$field]))
			return $this->_errors[$field];
		return false;
	}
}

?>