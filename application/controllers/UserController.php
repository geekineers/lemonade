<?php

class UserController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLogedIn();

    }

    public function index()
    {
		$data['company'] = $this->company;
        $data['groups']  = Group::where('company_id', '=', COMPANY_ID)->get();
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']   = "User Roles";
        $this->render('user_roles/index.twig.html', $data);

    }

}
