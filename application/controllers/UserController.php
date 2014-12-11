<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class UserController extends BaseController
{
    protected $employeeRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->employeeRepository = new EmployeeRepository();
    }

    public function index()
    {
		$data['company'] = $this->company;
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']   = "User";
        $data['users'] = User::where('company_id', '=', COMPANY_ID)->get();
        // dd($data['users']);
         $data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
        foreach ($data['users'] as $key => $value) {
            // dd($value->id);
            $user     = get_instance()->sentry->findUserById($value->id);
            $data['users'][$key]['role'] = $user->getGroups()[0]->name;
        }

        $this->render('user/index.twig.html', $data);

    }

    public function delete()
    {
        $token = $this->input->get('token');

        try
        {
            // Find the user using the user id

            $user = $this->sentry->findUserById($token);
            // Delete the user
            $user->delete();
           $this->session->set_flashdata('message', 'Succesfully deleted!');
       
            redirect('settings/users');
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            echo 'User was not found.';
        }
    }

}
