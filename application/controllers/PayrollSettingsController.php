<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class PayrollSettingsController extends BaseController 
{

	protected $employeeRepository;
	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();
	}

	public function index()
	{
		$data['user'] = $this->sentry->getUser();
		$data['title'] = 'Payroll Settings';
		$data['wtax'] = getWTax();
		
		// $this->output
	 //    ->set_content_type('application/json')
	 //    ->set_output(json_encode($data['wtax']));
			// dd(iterator_to_array($data['wtax']));
		$this->render('payroll_settings/index.twig.html',$data);
	}
}
