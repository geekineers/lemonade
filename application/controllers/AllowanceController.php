
<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class AllowanceController extends BaseController
{

    protected $branchRepository;
    protected $allowanceRepository;
    protected $employeeRepository;
    protected $employeeDeductionRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository            = new BranchRepository();
        $this->employeeRepository          = new EmployeeRepository();
        $this->allowanceRepository         = new AllowanceRepository();
        $this->employeeAllowanceRepository = new EmployeeAllowanceRepository();
        $this->load->library('session');

    }

    public function index()
    {
        $data['company']       = $this->company;
        $data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
        $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $data['title']      = "Benefits";
        $data['allowances'] = $this->allowanceRepository->all();
        $this->render('allowance/index.twig.html', $data);

    }

    public function save()
    {
        $allowance_name     = $this->input->post('allowance_name');
        $post               = $this->input->post();
        $post['created_by'] = $this->employeeRepository->getLoginUser($this->sentry->getUser())->id;
        // dd($post);
        $save = $this->allowanceRepository->create($post);
        // dd($save);
        $this->session->set_flashdata('message', $allowance_name . ' has been added.');

        redirect('/settings/allowances', 'location');

    }

    public function addEmployeeAllowance()
    {
        $employee_id  = $this->input->post('employee_id');
        $allowance_id = $this->input->post('allowance_id');
        $amount       = $this->input->post('amount');
        $recurring    = $this->input->post('recurring');
        $valid_from   = $this->input->post('valid_from');
        $valid_to     = $this->input->post('valid_to');

        $post = array(
            'employee_id'  => (int) $employee_id,
            'allowance_id' => (int) $allowance_id,
            'recurring'    => $recurring,
            'amount'       => floatval($amount),
            'valid_from'   => $valid_from,
            'valid_to'     => $valid_to
        );

        if ( strtolower($post['recurring']) == 'yes' ) {
            $post['valid_to'] = date('Y-m-d', strtotime('01-01-2032'));
        }

        // dd($post);

        // dd($post);

        $this->employeeAllowanceRepository->create($post);

        redirect('/employees/' . $employee_id . '/profile', 'location');

    }



    public function delete()
    {
        $id = $this->input->get('id');

        $branch_name = $this->allowanceRepository->find($id)->allowance_name;

        $this->allowanceRepository->find($id)->delete();
        $this->session->set_flashdata('message', $branch_name . ' has been deleted.');
        redirect('/settings/allowances', 'location');

    }

    public function update()
    {
        $input = $this->input->post();

        $this->allowanceRepository->update($input, $input['id']);

        redirect('/settings/allowances', 'location');

    }

   public function trash()
    {
        $data['company'] = $this->company;
        $data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
        $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']    = "Deleted Allowances";
        $data['allowances'] = $this->allowanceRepository->onlyTrashed()->get();

        $this->render('allowance/trash.twig.html', $data);
    }

    public function restore($id)
    {
        if(is_null($id)){
            $this->session->set_flashdata('message', 'Error!');
            redirect('settings/allowances/trash','location');
        }

        $this->allowanceRepository->where('id', '=', $id)
                               ->onlyTrashed()
                               ->first()
                               ->restore();

        $this->session->set_flashdata('message', 'Succesfully Restored!');
            redirect('settings/allowances/trash','location');
    }
}
