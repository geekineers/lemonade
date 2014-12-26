<?php
require_once ('BaseController.php');

class JobController extends BaseController
{

    protected $jobPositionRepository;
    protected $employeeRepository;
    protected $branchRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->jobPositionRepository = new JobPositionRepository();
        $this->employeeRepository    = new EmployeeRepository();
        $this->branchRepository    = new BranchRepository();
        $this->load->library('session');

    }
    public function index()
    {
        $data['company'] = $this->company;
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']   = "Job Positions";
        $data['branches']   = $this->branchRepository->all();
        $data['groups']  = $this->jobPositionRepository->all();

        // dd($data);
        $this->render('job_position/index.twig.html', $data);

    }

    public function add()
    {

        // $data['permissions'] = $this->config->item('permissions');
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['company'] = $this->company;
        $data['title']   = "Job Position";

        $this->render('/job_position/add.twig.html', $data);

    }

    public function save()
    {
        $input['job_position']    = (string) $this->input->post('job_position');
        $input['job_description'] = (string) $this->input->post('job_description');

        // dd($input);
        $job = $this->jobPositionRepository->createNotExist($input);
        if ($job) 
        {
            $this->session->set_flashdata('message', $input['job_position'] . ' has been added.');
            redirect('/settings/job');
        } 
        else 
        {
            $this->session->set_flashdata('message', $input['job_position'] . ' is already in here.');

            redirect('/settings/job/add');
        }
    }

    public function delete()
    {
        $id = $this->input->get('token');
        $this->jobPositionRepository->delete($id);
        $this->session->set_flashdata('alert_message', 'Successfully Deleted!');
        redirect('/settings/job');
    }

    public function update()
    {
        $id    = $this->input->post('id');
        $input = $this->input->post();
        $this->jobPositionRepository->update($input, $id);
        redirect('/settings/job');
    }
    public function trash()
    {
        $data['company'] = $this->company;
        $data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
        $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']    = "Deleted Job Positions";
        $data['groups'] = $this->jobPositionRepository->onlyTrashed()->get();
        $this->render('job_position/trash.twig.html', $data);
    }

    public function restore($id)
    {
        if(is_null($id)){
            $this->session->set_flashdata('message', 'Error!');
            redirect('settings/job/trash','location');
        }

        $this->jobPositionRepository->where('id', '=', $id)
                               ->onlyTrashed()
                               ->first()
                               ->restore();

        $this->session->set_flashdata('message', 'Succesfully Restored!');
            redirect('settings/job/trash','location');
    }

    public function search()
    {
        $branch = $this->input->get('branch');
        
        if($branch != null){
        $data = $this->jobPositionRepository->where('branch_id', $branch)->get()->toArray();
        }
        else{
        $data = $this->jobPositionRepository->all();

        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
  
    }
}
