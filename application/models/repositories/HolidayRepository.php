<?php
use Holiday as Holiday;
use \Curl\Curl;

class HolidayRepository extends BaseRepository {

	protected $sentry;

	public function __construct($sentry=null)
	{
		$this->class = new Holiday();
		$this->sentry = $sentry;

	}


	public function generateHoliday($year)
	{
   	$curl = new Curl();
   	$holidays = $curl->get('http://juanholiday.sourcescript.ph/api/' . $year);
	// dd($holidays);
	HolidayYear::create([
			'year' => $year,
			'created_by' => $this->sentry->getUser()->id
		]);

	foreach ($holidays as $holiday) {
		
		$this->create([
				'year' => $year,
				'holiday_year_id' => $year,
				'holiday_name' => $holiday->title,
				'holiday_type' => $holiday->type,
				'holiday_from' => $holiday->from,
				'holiday_to'   => $holiday->to
			]);

	}

	return true;

	}

	public function getAllHoliday($year){
		return $this->where('year', $year)->orderBy('holiday_from', 'asc')->get();
	}

	public function updateDays($holidays)
	{
		foreach ($holidays as $holiday) {
			$this->where('id', '=', $holiday['id'])->update($holiday);
		}
	}

	public function isHoliday($date)
	{


		// dd($start, $end);
		return $this->where('holiday_from', '=', $date)->count();
	}

	public function getAllEvents()
	{
		$output = [];
		$item = [];

		$holidays = $this->all();

		foreach ($holidays as $holiday) {
			$item['name'] = $holiday->holiday_name;
			$item['day'] = $holiday->getDay(true);
			$item['month'] = $holiday->getNumericMonth();
			$item['year'] = $holiday->getyear();
			$item['type'] = $holiday->holiday_type;
			array_push($output, $item);
		}

		return $output;

	}

}
