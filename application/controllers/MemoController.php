<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class MemoController extends BaseController 
{

	protected $employeeRepository,
			  $memoRepository;
	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->employeeRepository = new EmployeeRepository();
		$this->memoRepository = new MemoRepository();
	}

	public function add()
	{
		$data['from'] = $this->employeeRepository->getLoginUser($this->sentry->getUser())->id;
		$data['to'] = $this->input->post('to');
		$data['message'] = $this->input->post('message');

		$this->memoRepository->create($data);
		return 'true';

	}

	public function delete()
	{
		$id = $this->input->post('id');

        $this->memoRepository->where('id','=',$id)->delete();
        $this->sendJSON(['status'=>'ok']);
    
	}
	



}