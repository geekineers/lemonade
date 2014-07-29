<?php
use User as User;

class UserRepository extends BaseRepository{

	public function __construct()
	{
		$this->class = new User;
		
	}

	public function createUser(array $input){
		try{
			$input['password'] = md5($input['password']);
			$this->create($input);
		}
		catch (Exception $e) {
    		var_dump($e);
    		exit();
    	}
	}


}
