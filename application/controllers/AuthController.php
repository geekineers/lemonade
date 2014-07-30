<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class AuthController extends BaseController {

	protected $userRepository;


	public function __construct()
	{
		parent::__construct();
		$this->userRepository = new UserRepository();

	}


	public function index()
	{
		$this->mustBeLoggedOut();
		$this->render('login.twig.html');
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
		    $this->sentry->login($user, false);



		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    echo 'Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    echo 'User not found.';
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
		    echo 'User not activated.';
		}

		// Following is only needed if throttle is enabled
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
		    $time = $throttle->getSuspensionTime();

		    echo "User is suspended for [$time] minutes.";
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
		    echo 'User is banned.';
		}

		redirect('/dashboard');

	}

	public function logout()
	{
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

