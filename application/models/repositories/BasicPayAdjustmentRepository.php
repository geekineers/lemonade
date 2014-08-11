<?php
use BasicPayAdjustment as BasicPayAdjustment;

class BasicPayAdjustmentRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new BasicPayAdjustment();

	}

}