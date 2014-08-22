<?php
use Form_Application as Form_Application;

class FormApplicationRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Form_Application();

	}
	
}