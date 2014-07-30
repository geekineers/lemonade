<?php
use Branch as Branch;

class BranchRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Branch();

	}

}