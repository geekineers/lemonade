<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Base.php');

use Sentry as Sentry;

class Welcome extends Base_Controller {

	protected $userRepository;

	public function __construct()
	{
		parent::__construct();
		$this->userRepository = new UserRepository();
	}

	public function index()
	{
		$sentry = Sentry::createSentry();

		// $group = $sentry->createGroup(array(
	 //        'name'        => 'Moderator',
	 //        'permissions' => array(
	 //            'admin' => 1,
	 //            'users' => 1,
	 //        ),
	 //    ));

	 	$adminGroup = $sentry->findGroupById(2);

		$user = $sentry->findUserByLogin(['random@email.com']);
		$user->addGroup($adminGroup);
		// dd($user->email);
		// var_dump($user->getMergedPermissions());
		// dd($user->getPermissions());
		dd($user->hasAnyAccess(['users', ['users.qwe']]));
		// dd($user);

		try {
			// register

			// $sentry->register([
			// 	'email' => 'random@email.com',
			// 	'password' => 'secret'
			// ]);

			// $this->userRepository->create([
			// 	'email' => 'random@email.com',
			// 	'password' => 'secret'
			// ]);

			// $users = $this->userRepository->all()->toArray();
			// var_dump($users);

		} catch(\Exception $e) {

		}

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

