<?php
use User as User;

class UserRepository extends BaseRepository{

	public function __construct()
	{
		$this->class = new User;
	}

}
