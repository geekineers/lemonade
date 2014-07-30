<?php
require_once('BaseController.php');

class UserRolesController extends BaseController {

	public function index() 
	{
		$data['groups'] = $this->sentry->findAllGroups();

		$this->render('user_roles/index.twig.html', $data);

	}

	public function add()
	{
		$this->config->load('user_permissions');

		$data['permissions'] = $this->config->item('permissions');
		$data['user'] = $this->sentry->getUser();
		$data['title'] = "User Roles";

		$this->render('/user_roles/add.twig.html', $data);

	}

	public function save()
	{
		$input['name'] = $this->input->post('name');
		$permissions = $this->input->post('permissions');
		
		foreach ($permissions as $key => $value) {
				$input['permissions'][$key] = ($value == 'on') ? 1 : 0;
			}	

		$this->sentry->createGroup($input);
	}
}