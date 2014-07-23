<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Base.php');

class Welcome extends Base_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		try {
			$users = User::all();
		} catch(\Exception $e) {

		}

		$site = ['title' => 'My Site Title'];
		$navigation = [
			['href' => '#', 'caption' => 'Home'],
			['href' => '/about-us', 'caption' => 'About Us']
		];

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

/* End of file welcome.php */
/* Location: ./application/controllers/Welcome.php */
