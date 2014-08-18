<?php
use Company as Company;

class CompanyRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Company();

	}

}