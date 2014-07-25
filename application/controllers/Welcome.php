<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Base.php');

class Welcome extends Base_Controller {

	protected $userRepository;

	public function __construct()
	{
		parent::__construct();
		$this->userRepository = new UserRepository();
	}

	public function index()
	{
		try {
			$users = $this->userRepository->all()->toArray();
			// var_dump($users);
		} catch(\Exception $e) {

		}

		ci_dd(ci_app_path('storage'));

		$site = ['title' => 'My Site Title'];
		$navigation = [
			['href' => '#', 'caption' => 'Home'],
			['href' => '/about-us', 'caption' => 'About Us']
		];

		//http://twig.sensiolabs.org/doc/templates.html
		$this->render('index.twig.html', compact('site', 'navigation'));
	}

	public function hey($a = 'all')
	{
		echo $a;
	}

	public function error404()
	{
		echo '404';
	}
}

