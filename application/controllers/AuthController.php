<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class AuthController extends BaseController
{

    protected $userRepository,
    $timeSheetRepository,
    $companyRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository      = new UserRepository();
        $this->timeSheetRepository = new TimesheetRepository();
        $this->companyRepository   = new CompanyRepository();
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
            $login = $this->sentry->login($user, true);

        }

         catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $message = 'User not found.';
            $this->session->set_flashdata('message', $message);

            redirect('/auth', 'location');
        }
         catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            echo 'User not activated.';
            redirect('/auth');
            $message = 'User not activated.';
            $this->session->set_flashdata('message', $message);

            redirect('/auth', 'location');

        }

        // Following is only needed if throttle is enabled
         catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {

            echo "User is suspended for [$time] minutes.";
            $this->session->set_flashdata('message', $message);

            redirect('/auth', 'location');

        }
         catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {

            $message = 'User not activated.';
            $this->session->set_flashdata('message', $message);

            redirect('/auth', 'location');

        }
         catch (Exception $e) {

            $message = 'Login Failed.';
            $this->session->set_flashdata('message', $message);

            redirect('/auth', 'location');

        }

        redirect('/dashboard');

    }

    public function forgotPassword()
    {

        $data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');

        $this->render('forgot.twig.html', $data);
    }

    public function forgot()
    {
        $email = $this->input->post('email');

        try
        {
            // Find the user using the user email address
            $user = $this->sentry->findUserByLogin('john.doe@example.com');

            // Get the password reset code
            $resetCode = $user->getResetPasswordCode();

            // Now you can send this code to your user via email for example.
            $this->load->library('email');

            $this->email->from('dontreply@lemonade.com', 'Lemonade Password Support');
            $this->email->to($email); 
      
            $this->email->subject('Lemonade Password Recovery');
            $this->email->message('To succesfully reset your password. Kindly click the <a href="' . 'http://'.$_SERVER['SERVER_NAME'].'/reset-password/' . $resetCode  .'/' . $user->id . '">link</a>');  

        }
         catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $message = 'User was not found.';
            $this->session->set_flashdata('message', $message);

            redirect('/forgot-password', 'location');

        }
    }

    public function resetPassword($code)
    {

        $data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');

        $this->render('reset_password.twig.html', $data);

    }

    public function postResetPassword($code, $user_id)
    {

        $new_password     = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        if ($new_password == $confirm_password) {
            $message = 'Password not matched.';
            $this->session->set_flashdata('message', $message);

            redirect('/reset-password', 'location');
        }

        try
        {
            // Find the user using the user id
            $user = $this->sentry->findUserById($user_id);

            // Check if the reset password code is valid
            if ($user->checkResetPasswordCode($code)) {
                // Attempt to reset the user password
                if ($user->attemptResetPassword($code, $new_password)) {
                    // Password reset passed
                    $data = [];
                    $this->render('congratulations_reset_password.twig.html', $data);
                } else {
                    // Password reset failed
                    $message = 'Oopps! Error Occured.';
                    $this->session->set_flashdata('message', $message);

                    redirect('/reset-password', 'location');
                }
            } else {
                // The provided password reset code is Invalid
            }
        }
         catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $message = 'User was not found.';
            $this->session->set_flashdata('message', $message);

            redirect('/forgot-password', 'location');
        }

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
        $username     = $this->input->post('username');
        $password     = $this->input->post('password');

        $company = $this->companyRepository->create(['company_name' => $company_name]);

        $user = $this->sentry->createUser([
                'first_name' => 'Admininistrator',
                'last_name'  => $company_name,
                'email'      => $username,
                'password'   => $password,
                'activated'  => true,
                'company_id' => $company->id

            ]);

        $all_permissions = $this->config->item('permissions');
        $permissions     = array();

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
        $login = $this->sentry->login($user, true);

        $this->session->set_flashdata('new_user', "true");
        redirect('settings/company');
    }

    /* ADMIN Creator */
    public function createAdmin()
    {
        return $this->sentry->createUser([
                'first_name' => 'Admininstrator',
                'last_name'  => 'Lemon',
                'email'      => 'admin@lemon.com',
                'password'   => 'lemondash',
                'activated'  => true

            ]);

    }
}
