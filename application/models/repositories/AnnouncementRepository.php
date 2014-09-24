<?php
use Announcement as Announcement;

class AnnouncementRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Announcement();

	}
	public function postAnnouncement($data)
	{
		$this->create($data);
		return true;
	}

	public function getAllAnnouncement()
	{
		return $this->all();
	}

	public function getAnnouncementById($id)
	{
		return $this->where('id','=',$id)->first();
	}
	
}