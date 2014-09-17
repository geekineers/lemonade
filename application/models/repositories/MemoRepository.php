<?php
use Memo as Memo;

class MemoRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Memo();
	}

}