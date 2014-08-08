<?php
use Document as Document;

class DocumentRepository extends BaseRepository{

	public function __construct()
	{
		$this->class = new Document;
	}



}