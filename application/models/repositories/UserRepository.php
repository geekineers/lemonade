<?php
use User as User;

class UserRepository {

	protected $model = '';

	public function __construct()
	{
		$this->model = new User;
	}

	public function getAll()
	{
		return $this->model->all();
	}

}
