<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class AuthController extends BaseController {

	protected $userRepository,
			  $timeSheetRepository;


	public function __construct()
	{
		parent::__construct();
		$this->userRepository = new UserRepository();
		$this->timeSheetRepository = new TimesheetRepository();
		$this->load->library('session'); 
	}


	public function index()
	{
		$data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
		
		$this->mustBeLoggedOut();
		$this->render('login.twig.html', $data);
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
		
			redirect('/auth/time-in');

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

