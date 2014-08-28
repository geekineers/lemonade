<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class AuthController extends BaseController {

	protected $userRepository,
			  $timeSheetRepository,
			  $companyRepository;


	public function __construct()
	{
		parent::__construct();
		$this->userRepository = new UserRepository();
		$this->timeSheetRepository = new TimesheetRepository();
		$this->companyRepository = new CompanyRepository();
		$this->load->library('session'); 
	}


	public function index()
	{
		$data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
		
		$this->mustBeLoggedOut();
		$this->render('login.twig.html', $data);
	}

	public function register()
	{
		$this->render('register.twig.html');
	}

	public function login()
	{


		try
		{
		 	$credentials = array(
       			 'email'    => $this->input->post('email'),
       		 	 'password' => $this->input->post('password'),
    			);

    		// Authenticate the user
    		$user = $this->sentry->authenticate($credentials, false);
    	  // Log the user in
		   $login =  $this->sentry->login($user, true);
		  



		}
	
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			$message = 'User not found.';
    		$this->session->set_flashdata('message', $message);

		    redirect('/auth', 'location');
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
		    echo 'User not activated.';
		    redirect('/auth');
		    	$message = 'User not activated.';
    		$this->session->set_flashdata('message', $message);

		    redirect('/auth', 'location');

		}

		// Following is only needed if throttle is enabled
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
		   

		   echo "User is suspended for [$time] minutes.";
    		$this->session->set_flashdata('message', $message);

		    redirect('/auth', 'location');
		    
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
		 

		   	$message = 'User not activated.';
    		$this->session->set_flashdata('message', $message);

		    redirect('/auth', 'location');
		    
		}
				catch (Exception $e)
		{
		 

		   	$message = 'Login Failed.';
    		$this->session->set_flashdata('message', $message);

		    redirect('/auth', 'location');
		    
		}
		
			redirect('/dashboard');

	}

	public function timeIn()
	{
		// Time in User
		   $sentry_user = $this->sentry->getUser();
		  // dd($cookie);
		   $this->timeSheetRepository->timeIn($sentry_user);

		   	redirect('/dashboard');

	}

	public function logout()
	{
		$this->timeSheetRepository->timeOut();
		$this->sentry->logout();
		redirect('/auth');
	}


	public function saveRegister()
	{
		$this->config->load('user_permissions');

		$company_name = $this->input->post('company_name');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$company = $this->companyRepository->create(['company_name' => $company_name]);
	
		$user = $this->sentry->createUser([
				'first_name' => 'Admininistrator',
				'last_name'	 =>  $company_name,
				'email'		 =>  $username,
				'password'   =>  $password,
				'activated'  => true,
				'company_id' => $company->id
				
			]);

		$all_permissions = $this->config->item('permissions');
		$permissions = array();

		foreach ($all_permissions as $permission) {
			$permissions[$permission] = 1;
		}

	   $group = $this->sentry->createGroup(array(
				        'name'        => 'Super Admin - ' . $company_name,
				        'permissions' => $permissions,
			        'company_id'  => $company->id
				   		 ));

      	$user->addGroup($group);
		 // Log the user in
		 $login =  $this->sentry->login($user, true);
		 
			$this->session->set_flashdata('new_user', "true");
			redirect('settings/company');
	}



	/* ADMIN Creator */
	public function createAdmin()
	{
		return $this->sentry->createUser([
				'first_name' => 'Admininstrator',
				'last_name'	 =>  'Lemon',
				'email'		 =>  'admin@lemon.com',
				'password'   =>  'lemondash',
				'activated'  => true
				
			]);


	}
}

