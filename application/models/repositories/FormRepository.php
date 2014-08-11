<?php
use Form as Form;

class FormRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Form();
	}

}
