<?php

// use Respect\Validation\Validator as Validator;

trait ValidableTrait 
{
	public function getRule($rule)
	{
		switch ($rule) {
			case 'required':
				return Validator::string()->notEmpty();
				break;
			case 'numeric|required':
				return Validator::numeric()->notEmpty();
				break;
			case 'date|required':
				return Validator::date()->notEmpty();
				break;
			default:
				return Validator::string()->notEmpty();
				
				break;
		}
	}

	public function validate($data)
	{
		// $validator = Validator::arr();
		$required = $this->required;
		
		// foreach ($rules as $key => $value) {
		// 	$rule = $this->getRule($value);
		// 	$validator->key($key, $value);
		// }


		// return $validator->validate($data);
		// 
	   foreach ($required_field as $key => $value) {
            if($value == "" || $value==NULL){ 
               return ['status' => false, 'message' => $key . ' is required'];
            }
        }

	}

}