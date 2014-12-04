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
		return $this->orderBy('id', 'desc')->get();
	}

	public function getLatest()
	{
		return $this->orderBy('id', 'desc')->take(5)->get();
	}

	public function getAnnouncementById($id)
	{
		return $this->where('id','=',$id)->first();
	}
	
}