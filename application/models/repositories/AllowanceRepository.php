<?php
use Allowance as Allowance;

class AllowanceRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Allowance();

	}

}