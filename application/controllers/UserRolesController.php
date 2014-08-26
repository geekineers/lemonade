<?php
require_once ('BaseController.php');

class UserRolesController extends BaseController
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
        $data['groups'] = $this->sentry->findAllGroups();
        $data['user']   = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']  = "User Roles";
        $this->render('user_roles/index.twig.html', $data);

    }

    public function add()
    {
        $this->config->load('user_permissions');

        $data['permissions'] = $this->config->item('permissions');
        $data['user']        = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']       = "User Roles";

        $this->render('/user_roles/add.twig.html', $data);

    }

    public function save()
    {
        $input['name'] = $this->input->post('name');
        $permissions   = $this->input->post('permissions');

        foreach ($permissions as $key => $value) {
            $input['permissions'][$key] = ($value == 'on')?1:0;
        }
        // dd($input);
        $this->sentry->createGroup($input);
        redirect('settings/roles', 'location');
    }

    public function edit()
    {
        $this->config->load('user_permissions');
        $id                      = $this->input->get('token');
        $group                   = $this->sentry->findGroupById($id);
        $data['group']           = $group;
        $data['userpermissions'] = $group->getPermissions();
        $data['all_permissions'] = $this->config->item('permissions');
        $data['user']            = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']           = "User Roles";

        $this->render('/user_roles/edit.twig.html', $data);
    }

    public function update()
    {
        $id = $this->input->post('id');
        // Find the group using the group id
        $group = $this->sentry->findGroupById($id);

        // Update the group details
        $group->name        = $this->input->post('name');

        $permissions   = $this->input->post('permissions');
        $permissions_array = [];
        foreach ($permissions as $key => $value) {
            $permissions_array[$key] = ($value == 'on')?1:0;
        }

        $group->permissions = $permissions_array;

        // Update the group
        if ($group->save()) {
            // Group information was updated
            redirect('settings/roles', 'location');
        } else {
            // Group information was not updated
        }
    }
    public function delete()
    {$id = $this->input->get('token');
        $group                       = $this->sentry->findGroupById($id);
        $group->delete();

        redirect('settings/roles', 'location');
    }
}
