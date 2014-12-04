<?php
use Deduction as Deduction;

class DeductionRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Deduction();

	}

}